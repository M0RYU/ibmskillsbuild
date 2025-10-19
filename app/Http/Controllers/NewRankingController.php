<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alternative;
use App\Models\Assessment;
use App\Models\Criteria;
use App\Models\Ranking;
use App\Models\RankingAlternative;
use App\Models\RankingCriteria;
use App\Services\MooraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewRankingController extends Controller
{
    /**
     * Display a listing of all rankings.
     */
    public function index(Request $request)
    {
        $query = Ranking::query()->with('alternatives')
                        ->where('is_temporary', false); // Only show completed rankings
        
        // Search by title or description
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('created_by', 'like', "%{$search}%");
            });
        }
        
        // Filter by date range if provided
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Sort rankings
        $sortField = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        // Validate sort field to prevent SQL injection
        $allowedSortFields = ['title', 'created_at', 'created_by'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'created_at';
        }
        
        $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');
        
        $rankings = $query->paginate(10);
        
        return view('rankings.index', compact('rankings'));
    }
      /**
     * Show the form for creating a new ranking (clear session).
     */
    public function createNew(Request $request)
    {
        // Clear all ranking session data for fresh start
        $request->session()->forget('ranking_data');
        $request->session()->forget('ranking_alternatives_data');
        
        return redirect()->route('rankings.create');
    }
    
    /**
     * Show the form for creating a new ranking.
     */
    public function create(Request $request)
    {
        // If coming back from later steps, keep the session data
        // Otherwise clear session data when starting fresh
        if (!$request->session()->has('ranking_data')) {
            $request->session()->forget('ranking_data');
            $request->session()->forget('ranking_alternatives_data');
        }
        
        $criterias = Criteria::all();
        $rankingData = $request->session()->get('ranking_data', []);
        
        return view('rankings.create', compact('criterias', 'rankingData'));
    }
    
    /**
     * Cancel ranking creation and clear session data.
     */
    public function cancelRanking(Request $request)
    {
        // Clear all ranking-related session data
        $request->session()->forget('ranking_data');
        $request->session()->forget('ranking_alternatives_data');
        
        return redirect()->route('rankings.index')
                        ->with('info', 'Ranking creation cancelled.');
    }

    /**
     * Store basic ranking information and redirect to criteria selection.
     */
    public function storeBasic(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Store data in session for later use
        $request->session()->put('ranking_data', [
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('rankings.select-criteria');
    }    /**
     * Show the criteria selection step for creating a new ranking.
     */    public function selectCriteria(Request $request)
    {
        // Check if we have ranking data in session
        if (!$request->session()->has('ranking_data')) {
            return redirect()->route('rankings.create')->with('error', 'Please start by creating a ranking.');
        }

        $rankingData = $request->session()->get('ranking_data');
        $criterias = Criteria::active()->get(); // Only get active criteria
        
        return view('rankings.select-criteria', compact('criterias', 'rankingData'));
    }

    /**
     * Store criteria selection and redirect to weight assignment.
     */
    public function storeCriteriaSelection(Request $request)
    {
        $request->validate([
            'selected_criteria' => 'required|array|min:2',
            'selected_criteria.*' => 'exists:criterias,id',
        ]);

        // Get existing ranking data from session
        $rankingData = $request->session()->get('ranking_data', []);
        
        // Add selected criteria to session data
        $rankingData['selected_criteria'] = $request->selected_criteria;
        $request->session()->put('ranking_data', $rankingData);

        return redirect()->route('rankings.assign-weights');
    }
    
    /**
     * Go back to criteria selection from weight assignment.
     */
    public function backToCriteriaSelection(Request $request)
    {
        // Save current weights to session if provided
        if ($request->has('criteria_weights')) {
            $rankingData = $request->session()->get('ranking_data', []);
            $rankingData['criteria_weights'] = $request->criteria_weights;
            $request->session()->put('ranking_data', $rankingData);
        }
        
        // Keep the session data intact for back navigation
        return redirect()->route('rankings.select-criteria');
    }    /**
     * Show the weight assignment step for selected criteria.
     */
    public function assignWeights(Request $request)
    {
        // Check if we have ranking data with selected criteria in session
        if (!$request->session()->has('ranking_data') || !isset($request->session()->get('ranking_data')['selected_criteria'])) {
            return redirect()->route('rankings.create')->with('error', 'Please complete the previous steps first.');
        }

        $rankingData = $request->session()->get('ranking_data');
        $selectedCriteriaIds = $rankingData['selected_criteria'];
        $selectedCriterias = Criteria::with('options')->whereIn('id', $selectedCriteriaIds)->get();
        
        // Get old weights if available (for back navigation)
        $oldWeights = $rankingData['criteria_weights'] ?? [];

        return view('rankings.assign-weights', [
            'title' => $rankingData['title'],
            'description' => $rankingData['description'] ?? '',
            'selectedCriterias' => $selectedCriterias,
            'oldWeights' => $oldWeights,
        ]);
    }

    /**
     * Store the final ranking with criteria weights and redirect to alternatives.
     */
    public function storeWeights(Request $request)    {
        $request->validate([
            'criteria_weights' => 'required|array',
            'criteria_weights.*' => 'required|numeric|min:0|max:100',
        ]);

        // Get ranking data from session
        $rankingData = $request->session()->get('ranking_data');
        if (!$rankingData) {
            return redirect()->route('rankings.create')->with('error', 'Session expired. Please start over.');
        }

        // Validate that total weights don't exceed 100%
        $totalWeight = array_sum($request->criteria_weights);
        if ($totalWeight > 100) {
            return back()->withErrors(['total_weight' => 'Total weight cannot exceed 100%'])->withInput();
        }

        if ($totalWeight == 0) {
            return back()->withErrors(['total_weight' => 'At least one criteria must have a weight greater than 0'])->withInput();
        }

        // Store weights in session instead of saving to database yet
        $rankingData['criteria_weights'] = $request->criteria_weights;
        $request->session()->put('ranking_data', $rankingData);

        DB::beginTransaction();
        try {
            // Create the ranking record using session data
            $ranking = Ranking::create([
                'title' => $rankingData['title'],
                'description' => $rankingData['description'] ?? null,
                'created_by' => $request->session()->get('user_name', 'Guest'),
                'is_temporary' => true, // Mark as temporary
            ]);

            // Store selected criteria with their weights
            foreach ($request->criteria_weights as $criteriaId => $weight) {
                if ($weight > 0) { // Only store criteria with positive weights
                    RankingCriteria::create([
                        'ranking_id' => $ranking->id,
                        'criteria_id' => $criteriaId,
                        'weight' => $weight,
                    ]);
                }
            }

            DB::commit();

            // Store ranking ID in session for later reference
            $rankingData['ranking_id'] = $ranking->id;
            $request->session()->put('ranking_data', $rankingData);

            return redirect()->route('rankings.alternatives.create', $ranking->id)
                             ->with('success', 'Ranking created with selected criteria. Now add alternatives.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create ranking: ' . $e->getMessage())->withInput();
        }
    }
    
    /**
     * Go back to weight assignment from alternatives.
     */
    public function backToWeightAssignment(Request $request, $rankingId)
    {
        // Delete the temporary ranking if going back
        $ranking = Ranking::find($rankingId);
        if ($ranking && $ranking->is_temporary) {
            // Delete ranking criteria
            RankingCriteria::where('ranking_id', $ranking->id)->delete();
            // Delete alternatives and assessments if any
            foreach ($ranking->alternatives as $alternative) {
                Assessment::where('alternative_id', $alternative->id)->delete();
                $alternative->delete();
            }
            $ranking->delete();
        }
        
        return redirect()->route('rankings.assign-weights');
    }
    
    /**
     * Display the specified ranking.
     */
    public function show(string $id)
    {
        $ranking = Ranking::with('alternatives')->findOrFail($id);
        
        // Check if we have alternatives and results
        if ($ranking->alternatives->count() > 0 && $ranking->result_data) {
            $alternativeRankings = collect($ranking->result_data)->sortBy('rank');
            return view('rankings.show', compact('ranking', 'alternativeRankings'));
        }
        
        // If ranking is not complete, redirect to add alternatives
        if ($ranking->alternatives->count() == 0) {
            return redirect()->route('rankings.alternatives.create', $ranking->id)
                            ->with('info', 'Please add alternatives to this ranking.');
        }
        
        // If alternatives exist but no results, calculate results
        return redirect()->route('rankings.calculate', $ranking->id)
                        ->with('info', 'Calculating ranking results...');
    }
      /**
     * Show the form for creating a new alternative for this ranking.
     */    public function createAlternative(string $rankingId)
    {
        $ranking = Ranking::with('rankingCriteria.criteria')->findOrFail($rankingId);
        
        // Get the ranking criteria (with their weights)
        $rankingCriteria = $ranking->rankingCriteria;
        
        if ($rankingCriteria->isEmpty()) {
            return redirect()->route('rankings.index')
                            ->with('error', 'This ranking has no criteria assigned. Please recreate the ranking.');
        }
        
        return view('rankings.create-alternative', compact('ranking', 'rankingCriteria'));
    }
      /**
     * Store a newly created alternative for this ranking.
     */
    public function storeAlternative(Request $request, string $rankingId)
    {
        $ranking = Ranking::with('rankingCriteria.criteria')->findOrFail($rankingId);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Create alternative
            $alternative = Alternative::create([
                'name' => $request->name,
                'description' => $request->description,
                'ranking_id' => $ranking->id,
            ]);

            // Get only the criteria selected for this ranking
            $selectedCriterias = $ranking->rankingCriteria->map(function ($rc) {
                return $rc->criteria;
            });
            
            // Store assessments for each selected criteria
            foreach ($selectedCriterias as $criteria) {
                if ($criteria->input_type === 'number') {
                    $request->validate([
                        'criteria_' . $criteria->id => 'required|numeric',
                    ]);
                    
                    Assessment::create([
                        'alternative_id' => $alternative->id,
                        'criteria_id' => $criteria->id,
                        'value' => $request->input('criteria_' . $criteria->id),
                    ]);
                } else { // options
                    $request->validate([
                        'criteria_' . $criteria->id => 'required|exists:criteria_options,id',
                    ]);
                    
                    Assessment::create([
                        'alternative_id' => $alternative->id,
                        'criteria_id' => $criteria->id,
                        'criteria_option_id' => $request->input('criteria_' . $criteria->id),
                    ]);
                }
            }
            
            // Store alternative data in session for potential back navigation
            $alternativesData = $request->session()->get('ranking_alternatives_data', []);
            $alternativesData[] = [
                'id' => $alternative->id,
                'name' => $request->name,
                'description' => $request->description,
            ];
            $request->session()->put('ranking_alternatives_data', $alternativesData);
            
            DB::commit();
            
            if ($request->has('add_another') && $request->add_another) {
                return redirect()->route('rankings.alternatives.create', $ranking->id)
                                ->with('success', 'Alternative added successfully. Add another one.');
            }
            
            return redirect()->route('rankings.alternatives.list', $ranking->id)
                            ->with('success', 'Alternative added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to save alternative: ' . $e->getMessage())->withInput();
        }
    }
    
    /**
     * List all alternatives for a ranking.
     */
    public function listAlternatives(string $rankingId)
    {
        $ranking = Ranking::with('alternatives')->findOrFail($rankingId);
        $alternatives = $ranking->alternatives;
        
        return view('rankings.alternatives-list', compact('ranking', 'alternatives'));
    }
    
    /**
     * Calculate ranking using MOORA method.
     */
    public function calculate(string $rankingId)
    {
        $ranking = Ranking::with('alternatives')->findOrFail($rankingId);
        
        if ($ranking->alternatives->count() < 2) {
            return redirect()->route('rankings.alternatives.create', $ranking->id)
                            ->with('error', 'You need at least 2 alternatives to calculate a ranking.');
        }
        
        $mooraService = new MooraService();
        
        // Get the alternative IDs for this ranking
        $alternativeIds = $ranking->alternatives->pluck('id')->toArray();
        
        // Calculate ranking for the alternatives, specifying the ranking ID
        $rankingResults = $mooraService->calculateRanking($alternativeIds, $ranking->id);
        
        if (empty($rankingResults)) {
            return back()->with('error', 'Unable to generate ranking. Please ensure all criteria and alternatives are properly set up.');
        }
        
        // Update the ranking with results and mark as complete
        $ranking->update([
            'result_data' => $rankingResults,
            'is_temporary' => false, // Mark as complete
        ]);
        
        // Clear existing ranking alternatives
        RankingAlternative::where('ranking_id', $ranking->id)->delete();
        
        // Store ranking alternatives for reference
        foreach ($rankingResults as $result) {
            RankingAlternative::create([
                'ranking_id' => $ranking->id,
                'alternative_id' => $result['id'],
                'rank' => $result['rank'],
                'optimization_value' => $result['optimization_value']
            ]);
        }
        
        // Clear session data as ranking is now complete
        session()->forget('ranking_data');
        session()->forget('ranking_alternatives_data');
          
        return redirect()->route('rankings.show', $ranking->id)
                         ->with('success', 'Ranking calculated successfully.');
    }
    
    /**
     * Cancel ranking creation from alternatives page.
     */
    public function cancelRankingFromAlternatives(Request $request, $rankingId)
    {
        DB::beginTransaction();
        try {
            $ranking = Ranking::find($rankingId);
            
            if ($ranking) {
                // Delete alternatives and their assessments
                foreach ($ranking->alternatives as $alternative) {
                    Assessment::where('alternative_id', $alternative->id)->delete();
                    $alternative->delete();
                }
                
                // Delete ranking criteria
                RankingCriteria::where('ranking_id', $ranking->id)->delete();
                
                // Delete the ranking itself
                $ranking->delete();
            }
            
            DB::commit();
            
            // Clear session data
            $request->session()->forget('ranking_data');
            $request->session()->forget('ranking_alternatives_data');
            
            return redirect()->route('rankings.index')
                            ->with('info', 'Ranking creation cancelled. All data has been removed.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to cancel ranking: ' . $e->getMessage());
        }
    }

    /**
     * Delete incomplete rankings (rankings without alternatives or results).
     */
    public function cleanupIncompleteRankings()
    {
        try {
            $deletedCount = 0;
            
            // Find rankings without alternatives
            $rankingsWithoutAlternatives = Ranking::whereDoesntHave('alternatives')->get();
            
            foreach ($rankingsWithoutAlternatives as $ranking) {
                // Delete related ranking criteria
                RankingCriteria::where('ranking_id', $ranking->id)->delete();
                $ranking->delete();
                $deletedCount++;
            }
            
            // Find rankings with alternatives but without results after 1 hour of creation
            $incompleteRankings = Ranking::whereNull('result_data')
                                        ->where('created_at', '<', now()->subHour())
                                        ->has('alternatives')
                                        ->get();
            
            foreach ($incompleteRankings as $ranking) {
                // Delete alternatives and their assessments
                foreach ($ranking->alternatives as $alternative) {
                    Assessment::where('alternative_id', $alternative->id)->delete();
                    $alternative->delete();
                }
                
                // Delete ranking criteria and ranking
                RankingCriteria::where('ranking_id', $ranking->id)->delete();
                $ranking->delete();
                $deletedCount++;
            }
            
            if ($deletedCount > 0) {
                return back()->with('success', "Cleaned up {$deletedCount} incomplete ranking(s).");
            } else {
                return back()->with('info', 'No incomplete rankings found to clean up.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to cleanup rankings: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alternative;
use App\Models\Assessment;
use App\Models\Criteria;
use App\Models\CriteriaOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlternativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alternatives = Alternative::all();
        
        return view('admin.alternatives.index', compact('alternatives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $criterias = Criteria::with('options')->get();
        
        return view('admin.alternatives.create', compact('criterias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        // Begin transaction to ensure atomicity
        DB::beginTransaction();
        
        try {
            $alternative = Alternative::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            
            $criterias = Criteria::all();
            
            foreach ($criterias as $criteria) {
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
            
            DB::commit();
            
            return redirect()->route('admin.alternatives.index')
                             ->with('success', 'Alternative created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withErrors(['error' => 'Failed to create alternative: ' . $e->getMessage()])
                         ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $alternative = Alternative::with('assessments')->findOrFail($id);
        $criterias = Criteria::with('options')->get();
        
        // Organize assessments by criteria for easier form handling
        $assessments = [];
        foreach ($alternative->assessments as $assessment) {
            $assessments[$assessment->criteria_id] = $assessment;
        }
        
        return view('admin.alternatives.edit', compact('alternative', 'criterias', 'assessments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $alternative = Alternative::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        // Begin transaction to ensure atomicity
        DB::beginTransaction();
        
        try {
            $alternative->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            
            $criterias = Criteria::all();
            
            foreach ($criterias as $criteria) {
                $assessment = Assessment::where('alternative_id', $alternative->id)
                                       ->where('criteria_id', $criteria->id)
                                       ->first();
                
                if ($criteria->input_type === 'number') {
                    $request->validate([
                        'criteria_' . $criteria->id => 'required|numeric',
                    ]);
                    
                    if ($assessment) {
                        $assessment->update([
                            'value' => $request->input('criteria_' . $criteria->id),
                            'criteria_option_id' => null,
                        ]);
                    } else {
                        Assessment::create([
                            'alternative_id' => $alternative->id,
                            'criteria_id' => $criteria->id,
                            'value' => $request->input('criteria_' . $criteria->id),
                        ]);
                    }
                } else { // options
                    $request->validate([
                        'criteria_' . $criteria->id => 'required|exists:criteria_options,id',
                    ]);
                    
                    if ($assessment) {
                        $assessment->update([
                            'value' => null,
                            'criteria_option_id' => $request->input('criteria_' . $criteria->id),
                        ]);
                    } else {
                        Assessment::create([
                            'alternative_id' => $alternative->id,
                            'criteria_id' => $criteria->id,
                            'criteria_option_id' => $request->input('criteria_' . $criteria->id),
                        ]);
                    }
                }
            }
            
            DB::commit();
            
            return redirect()->route('admin.alternatives.index')
                             ->with('success', 'Alternative updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withErrors(['error' => 'Failed to update alternative: ' . $e->getMessage()])
                         ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alternative = Alternative::findOrFail($id);
        
        // Begin transaction to ensure atomicity
        DB::beginTransaction();
        
        try {
            // Delete related assessments first
            Assessment::where('alternative_id', $alternative->id)->delete();
            
            // Then delete the alternative
            $alternative->delete();
            
            DB::commit();
            
            return redirect()->route('admin.alternatives.index')
                             ->with('success', 'Alternative deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.alternatives.index')
                             ->with('error', 'Failed to delete alternative: ' . $e->getMessage());
        }
    }
}

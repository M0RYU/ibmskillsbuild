<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alternative;
use App\Models\Assessment;
use App\Models\Criteria;
use App\Models\CriteriaOption;
use App\Models\Ranking;
use App\Services\MooraService;
use Illuminate\Http\Request;

class ClientController extends Controller
{    /**
     * Display the client dashboard.
     */
    public function index(Request $request)
    {
        // Get recent rankings
        $rankings = Ranking::with('alternatives')
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
        
        // Count total alternatives across all rankings for informational purposes
        $alternativesCount = Alternative::count();
        
        return view('client.index', compact('rankings', 'alternativesCount'));
    }
    
    /**
     * Display welcome page.
     */
    public function welcome()
    {
        // Get recent rankings
        $rankings = Ranking::with('alternatives')
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
        
        return view('welcome', compact('rankings'));
    }

    /**
     * Show the form for creating a new alternative.
     */
    public function createAlternative(Request $request)
    {
        // Redirect to the new ranking flow since alternatives now require a ranking
        if ($request->has('redirect_to_rankings')) {
            return redirect()->route('rankings.create')
                             ->with('info', 'To create alternatives, first create a ranking to organize them.');
        }
        
        return redirect()->route('rankings.create');
    }

    /**
     * Store a newly created alternative.
     */
    public function storeAlternative(Request $request)
    {
        // This method is deprecated in favor of the NewRankingController
        return redirect()->route('rankings.create')
                         ->with('info', 'Please use the new ranking flow to create alternatives.');
    }/**
     * Show ranking of alternatives using MOORA method.
     */
    public function showRanking()
    {
        // Redirect to the rankings index page since we now handle rankings differently
        return redirect()->route('rankings.index');
    }
    
    /**
     * Show the form for creating a new ranking.
     */
    public function createRanking(Request $request)
    {
        // Redirect to the new ranking flow
        return redirect()->route('rankings.create');
    }

    /**
     * Store a newly created ranking.
     */
    public function storeRanking(Request $request)
    {
        // Redirect to the new ranking flow
        return redirect()->route('rankings.create');
    }

    /**
     * Display a specific ranking.
     */
    public function showSpecificRanking($id)
    {
        // Redirect to the new ranking show page
        return redirect()->route('rankings.show', $id);
    }
}

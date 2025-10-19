<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Services\MooraService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $criterias = Criteria::all();
        $totalWeight = $criterias->sum('weight');
        
        return view('admin.index', compact('criterias', 'totalWeight'));
    }

    /**
     * Show the ranking page from admin.
     */
    public function showRanking()
    {
        $mooraService = new MooraService();
        $rankings = $mooraService->calculateRanking();
        
        return view('admin.ranking', compact('rankings'));
    }
}

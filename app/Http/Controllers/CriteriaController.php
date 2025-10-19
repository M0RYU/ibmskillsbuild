<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\CriteriaOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */    public function index()
    {
        $criterias = Criteria::with('options')->get();
        
        return view('admin.criterias.index', compact('criterias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.criterias.create');
    }

    /**
     * Store a newly created resource in storage.
     */    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cost,benefit',
            'input_type' => 'required|in:number,options',
        ]);
          $criteria = Criteria::create([
            'name' => $request->name,
            'type' => $request->type,
            'input_type' => $request->input_type,
            'is_active' => $request->has('is_active') ? true : false,
        ]);
        
        // Handle options if input_type is options
        if ($request->input_type === 'options' && $request->has('options')) {
            foreach ($request->options as $key => $option) {
                if (!empty($option['text']) && isset($option['value'])) {
                    CriteriaOption::create([
                        'criteria_id' => $criteria->id,
                        'option_text' => $option['text'],
                        'option_value' => $option['value'],
                    ]);
                }
            }
        }
        
        return redirect()->route('admin.criterias.index')
                         ->with('success', 'Criteria created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $criteria = Criteria::with('options')->findOrFail($id);
        
        return view('admin.criterias.edit', compact('criteria'));
    }

    /**
     * Update the specified resource in storage.
     */    public function update(Request $request, string $id)
    {
        $criteria = Criteria::findOrFail($id);
          $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cost,benefit',
            'input_type' => 'required|in:number,options',
        ]);
          $criteria->update([
            'name' => $request->name,
            'type' => $request->type,
            'input_type' => $request->input_type,
            'is_active' => $request->has('is_active') ? true : false,
        ]);
        
        // Handle options if input_type is options
        if ($request->input_type === 'options') {
            // Delete existing options
            CriteriaOption::where('criteria_id', $criteria->id)->delete();
            
            // Add new options
            if ($request->has('options')) {
                foreach ($request->options as $key => $option) {
                    if (!empty($option['text']) && isset($option['value'])) {
                        CriteriaOption::create([
                            'criteria_id' => $criteria->id,
                            'option_text' => $option['text'],
                            'option_value' => $option['value'],
                        ]);
                    }
                }
            }
        }
        
        return redirect()->route('admin.criterias.index')
                         ->with('success', 'Criteria updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $criteria = Criteria::findOrFail($id);
        
        // Begin transaction to ensure atomicity
        DB::beginTransaction();
        
        try {
            // Delete all options first
            CriteriaOption::where('criteria_id', $criteria->id)->delete();
            
            // Then delete the criteria
            $criteria->delete();
            
            DB::commit();
            
            return redirect()->route('admin.criterias.index')
                             ->with('success', 'Criteria deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.criterias.index')
                             ->with('error', 'Failed to delete criteria: ' . $e->getMessage());
        }
    }
    
    /**
     * Toggle the active status of a criteria.
     */
    public function toggleActive(string $id)
    {
        $criteria = Criteria::findOrFail($id);
        $criteria->update(['is_active' => !$criteria->is_active]);
        
        $status = $criteria->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.criterias.index')
                         ->with('success', "Criteria has been {$status} successfully.");
    }
}

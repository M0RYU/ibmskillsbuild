<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $fillable = [
        'title',
        'description',
        'created_by',
        'result_data',
        'is_temporary'
    ];

    protected $casts = [
        'result_data' => 'array',
        'is_temporary' => 'boolean'
    ];    /**
     * Get the alternatives associated with this ranking.
     */
    public function rankingAlternatives()
    {
        return $this->hasMany(RankingAlternative::class);
    }

    /**
     * Get all alternatives directly associated with this ranking.
     */
    public function alternatives()
    {
        return $this->hasMany(Alternative::class);
    }
    
    /**
     * Get the criteria assigned to this ranking with their weights.
     */
    public function rankingCriteria()
    {
        return $this->hasMany(RankingCriteria::class);
    }
    
    /**
     * Get the criteria directly through the pivot table.
     */
    public function criteria()
    {
        return $this->belongsToMany(Criteria::class, 'ranking_criteria')
                    ->withPivot('weight')
                    ->withTimestamps();
    }
}

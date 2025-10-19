<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RankingCriteria extends Model
{
    protected $table = 'ranking_criteria';
    
    protected $fillable = [
        'ranking_id',
        'criteria_id',
        'weight'
    ];

    /**
     * Get the ranking that owns this criteria assignment.
     */
    public function ranking(): BelongsTo
    {
        return $this->belongsTo(Ranking::class);
    }

    /**
     * Get the criteria that this assignment refers to.
     */
    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criteria extends Model
{    protected $fillable = [
        'name',
        'type',
        'input_type',
        'is_active',
    ];

    /**
     * Scope to get only active criteria
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the options for this criteria.
     */
    public function options(): HasMany
    {
        return $this->hasMany(CriteriaOption::class);
    }

    /**
     * Get the assessments for this criteria.
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }
    
    /**
     * Get the ranking criteria assignments for this criteria.
     */
    public function rankingCriteria(): HasMany
    {
        return $this->hasMany(RankingCriteria::class);
    }
}

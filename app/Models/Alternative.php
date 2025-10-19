<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alternative extends Model
{
    protected $fillable = [
        'name',
        'description',
        'ranking_id',
    ];

    /**
     * Get the assessments for this alternative.
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }
    
    /**
     * Get the ranking this alternative belongs to.
     */
    public function ranking(): BelongsTo
    {
        return $this->belongsTo(Ranking::class);
    }
}

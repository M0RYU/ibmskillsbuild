<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CriteriaOption extends Model
{
    protected $fillable = [
        'criteria_id',
        'option_text',
        'option_value',
    ];

    /**
     * Get the criteria that owns the option.
     */
    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class);
    }

    /**
     * Get the assessments for this option.
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }
}

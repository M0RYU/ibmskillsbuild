<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assessment extends Model
{
    protected $fillable = [
        'alternative_id',
        'criteria_id',
        'value',
        'criteria_option_id',
    ];

    /**
     * Get the alternative that owns the assessment.
     */
    public function alternative(): BelongsTo
    {
        return $this->belongsTo(Alternative::class);
    }

    /**
     * Get the criteria that owns the assessment.
     */
    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class);
    }

    /**
     * Get the criteria option that owns the assessment.
     */
    public function criteriaOption(): BelongsTo
    {
        return $this->belongsTo(CriteriaOption::class);
    }

    /**
     * Get the actual value of this assessment.
     * If it's a number criteria, return the value.
     * If it's an option criteria, return the option value.
     */
    public function getActualValue()
    {
        if ($this->criteria_option_id) {
            return $this->criteriaOption->option_value;
        }
        
        return $this->value;
    }
}

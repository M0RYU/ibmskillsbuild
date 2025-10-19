<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RankingAlternative extends Model
{
    protected $fillable = [
        'ranking_id',
        'alternative_id',
        'rank',
        'optimization_value'
    ];

    /**
     * Get the ranking that owns this ranking alternative.
     */
    public function ranking()
    {
        return $this->belongsTo(Ranking::class);
    }

    /**
     * Get the alternative associated with this ranking alternative.
     */
    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }
}

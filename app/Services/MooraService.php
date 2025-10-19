<?php

namespace App\Services;

use App\Models\Alternative;
use App\Models\Assessment;
use App\Models\Criteria;
use App\Models\Ranking;
use App\Models\RankingAlternative;
use App\Models\RankingCriteria;

class MooraService
{    /**
     * Calculate the ranking using the MOORA method.
     *
     * @param array $alternativeIds Optional array of alternative IDs to include in calculation
     * @param int|null $rankingId Required ranking ID to get criteria weights from
     * @return array
     */
    public function calculateRanking(array $alternativeIds = null, ?int $rankingId = null): array
    {
        if (!$rankingId) {
            throw new \InvalidArgumentException('Ranking ID is required to get criteria weights.');
        }

        $ranking = Ranking::with('rankingCriteria.criteria')->findOrFail($rankingId);
        
        $alternativesQuery = Alternative::query();
        
        // Filter alternatives if IDs are provided
        if ($alternativeIds) {
            $alternativesQuery->whereIn('id', $alternativeIds);
        }
        
        // Filter by ranking_id if provided
        $alternativesQuery->where('ranking_id', $rankingId);
        
        $alternatives = $alternativesQuery->get();
        
        // Get selected criteria with their weights for this ranking
        $rankingCriterias = $ranking->rankingCriteria;
        
        if ($alternatives->isEmpty() || $rankingCriterias->isEmpty()) {
            return [];
        }
        
        // Step 1: Create the decision matrix (only for selected criteria)
        $matrix = [];
        foreach ($alternatives as $alternative) {
            $row = [];
            foreach ($rankingCriterias as $rankingCriteria) {
                $criteria = $rankingCriteria->criteria;
                $assessment = Assessment::where('alternative_id', $alternative->id)
                    ->where('criteria_id', $criteria->id)
                    ->first();
                
                if ($assessment) {
                    $row[] = $assessment->getActualValue();
                } else {
                    $row[] = 0; // Default value if no assessment exists
                }
            }
            $matrix[] = $row;
        }
        
        // Step 2: Normalize the decision matrix
        $normalizedMatrix = $this->normalizeMatrix($matrix);
        
        // Step 3: Calculate weighted normalized values using ranking-specific weights
        $weightedMatrix = $this->calculateWeightedMatrixForRanking($normalizedMatrix, $rankingCriterias);
        
        // Step 4: Calculate optimization values
        $optimizationValues = $this->calculateOptimizationValuesForRanking($weightedMatrix, $rankingCriterias);
        
        // Step 5: Rank the alternatives
        $rankings = $this->rankAlternatives($alternatives, $optimizationValues);
        
        return $rankings;
    }
    
    /**
     * Normalize the decision matrix.
     *
     * @param array $matrix
     * @return array
     */
    private function normalizeMatrix(array $matrix): array
    {
        $rows = count($matrix);
        $cols = count($matrix[0]);
        $normalizedMatrix = [];
        
        // Calculate the square root of sum of squares for each column
        $denominators = [];
        for ($j = 0; $j < $cols; $j++) {
            $sumOfSquares = 0;
            for ($i = 0; $i < $rows; $i++) {
                $sumOfSquares += pow($matrix[$i][$j], 2);
            }
            $denominators[$j] = sqrt($sumOfSquares);
        }
        
        // Normalize each element
        for ($i = 0; $i < $rows; $i++) {
            $normalizedRow = [];
            for ($j = 0; $j < $cols; $j++) {
                // Avoid division by zero
                if ($denominators[$j] == 0) {
                    $normalizedRow[] = 0;
                } else {
                    $normalizedRow[] = $matrix[$i][$j] / $denominators[$j];
                }
            }
            $normalizedMatrix[] = $normalizedRow;
        }
        
        return $normalizedMatrix;
    }
    
    /**
     * Calculate the weighted normalized matrix.
     *
     * @param array $normalizedMatrix
     * @param \Illuminate\Database\Eloquent\Collection $criterias
     * @return array
     */
    private function calculateWeightedMatrix(array $normalizedMatrix, $criterias): array
    {
        $rows = count($normalizedMatrix);
        $cols = count($normalizedMatrix[0]);
        $weightedMatrix = [];
        
        for ($i = 0; $i < $rows; $i++) {
            $weightedRow = [];
            for ($j = 0; $j < $cols; $j++) {
                // Convert percentage weight to decimal
                $weight = $criterias[$j]->weight / 100;
                $weightedRow[] = $normalizedMatrix[$i][$j] * $weight;
            }
            $weightedMatrix[] = $weightedRow;
        }
          return $weightedMatrix;
    }

    /**
     * Calculate the weighted normalized matrix using ranking-specific weights.
     *
     * @param array $normalizedMatrix
     * @param \Illuminate\Database\Eloquent\Collection $rankingCriterias
     * @return array
     */
    private function calculateWeightedMatrixForRanking(array $normalizedMatrix, $rankingCriterias): array
    {
        $rows = count($normalizedMatrix);
        $cols = count($normalizedMatrix[0]);
        $weightedMatrix = [];
        
        for ($i = 0; $i < $rows; $i++) {
            $weightedRow = [];
            for ($j = 0; $j < $cols; $j++) {
                // Convert percentage weight to decimal
                $weight = $rankingCriterias[$j]->weight / 100;
                $weightedRow[] = $normalizedMatrix[$i][$j] * $weight;
            }
            $weightedMatrix[] = $weightedRow;
        }
        
        return $weightedMatrix;
    }
    
    /**
     * Calculate optimization values based on benefit and cost criteria.
     *
     * @param array $weightedMatrix
     * @param \Illuminate\Database\Eloquent\Collection $criterias
     * @return array
     */
    private function calculateOptimizationValues(array $weightedMatrix, $criterias): array
    {
        $rows = count($weightedMatrix);
        $cols = count($weightedMatrix[0]);
        $optimizationValues = [];
        
        for ($i = 0; $i < $rows; $i++) {
            $benefitSum = 0;
            $costSum = 0;
            
            for ($j = 0; $j < $cols; $j++) {
                if ($criterias[$j]->type === 'benefit') {
                    $benefitSum += $weightedMatrix[$i][$j];
                } else { // cost
                    $costSum += $weightedMatrix[$i][$j];
                }
            }
            
            // MOORA formula: Benefit - Cost
            $optimizationValues[] = $benefitSum - $costSum;
        }
          return $optimizationValues;
    }

    /**
     * Calculate optimization values based on benefit and cost criteria for ranking-specific criteria.
     *
     * @param array $weightedMatrix
     * @param \Illuminate\Database\Eloquent\Collection $rankingCriterias
     * @return array
     */
    private function calculateOptimizationValuesForRanking(array $weightedMatrix, $rankingCriterias): array
    {
        $rows = count($weightedMatrix);
        $cols = count($weightedMatrix[0]);
        $optimizationValues = [];
        
        for ($i = 0; $i < $rows; $i++) {
            $benefitSum = 0;
            $costSum = 0;
            
            for ($j = 0; $j < $cols; $j++) {
                if ($rankingCriterias[$j]->criteria->type === 'benefit') {
                    $benefitSum += $weightedMatrix[$i][$j];
                } else { // cost
                    $costSum += $weightedMatrix[$i][$j];
                }
            }
            
            // MOORA formula: Benefit - Cost
            $optimizationValues[] = $benefitSum - $costSum;
        }
        
        return $optimizationValues;
    }
    
    /**
     * Rank alternatives based on optimization values.
     *
     * @param \Illuminate\Database\Eloquent\Collection $alternatives
     * @param array $optimizationValues
     * @return array
     */
    private function rankAlternatives($alternatives, array $optimizationValues): array
    {
        $rankings = [];
        
        // Combine alternatives with their optimization values
        foreach ($alternatives as $index => $alternative) {
            $rankings[] = [
                'id' => $alternative->id,
                'name' => $alternative->name,
                'description' => $alternative->description,
                'optimization_value' => $optimizationValues[$index] ?? 0,
            ];
        }
        
        // Sort by optimization value in descending order (higher is better)
        usort($rankings, function ($a, $b) {
            return $b['optimization_value'] <=> $a['optimization_value'];
        });
        
        // Add rank
        foreach ($rankings as $key => $ranking) {
            $rankings[$key]['rank'] = $key + 1;
        }
        
        return $rankings;
    }
    
    /**
     * Save a ranking result with a title and description.
     *
     * @param array $rankings The ranking results
     * @param string $title The title for this ranking
     * @param string|null $description Optional description
     * @param string|null $createdBy Optional identifier for who created the ranking
     * @return Ranking
     */
    public function saveRanking(array $rankings, string $title, ?string $description = null, ?string $createdBy = null): Ranking
    {
        // Create the ranking record
        $ranking = Ranking::create([
            'title' => $title,
            'description' => $description,
            'created_by' => $createdBy,
            'result_data' => $rankings
        ]);
        
        // Clear any existing ranking alternatives
        RankingAlternative::where('ranking_id', $ranking->id)->delete();
        
        // Save each alternative's rank and optimization value
        foreach ($rankings as $rankData) {
            RankingAlternative::create([
                'ranking_id' => $ranking->id,
                'alternative_id' => $rankData['id'],
                'rank' => $rankData['rank'],
                'optimization_value' => $rankData['optimization_value']
            ]);
        }
        
        return $ranking;
    }
}

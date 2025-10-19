<?php

namespace App\Console\Commands;

use App\Models\Alternative;
use App\Models\Assessment;
use App\Models\Ranking;
use App\Models\RankingCriteria;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupTemporaryRankings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rankings:cleanup-temporary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up temporary rankings that are older than 2 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting cleanup of temporary rankings...');
        
        // Find temporary rankings older than 2 hours
        $temporaryRankings = Ranking::where('is_temporary', true)
                                    ->where('created_at', '<', now()->subHours(2))
                                    ->get();
        
        $deletedCount = 0;
        
        DB::beginTransaction();
        try {
            foreach ($temporaryRankings as $ranking) {
                // Delete alternatives and their assessments
                foreach ($ranking->alternatives as $alternative) {
                    Assessment::where('alternative_id', $alternative->id)->delete();
                    $alternative->delete();
                }
                
                // Delete ranking criteria
                RankingCriteria::where('ranking_id', $ranking->id)->delete();
                
                // Delete the ranking itself
                $ranking->delete();
                $deletedCount++;
                
                $this->info("Deleted temporary ranking: {$ranking->title}");
            }
            
            DB::commit();
            $this->info("Successfully cleaned up {$deletedCount} temporary ranking(s).");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Failed to cleanup temporary rankings: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}

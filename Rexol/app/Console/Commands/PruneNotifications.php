<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PruneNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune notifications older than 20 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = 20;
        $count = DB::table('notifications')
            ->where('created_at', '<', now()->subDays($days))
            ->delete();

        $this->info("Pruned {$count} notifications older than {$days} days.");
    }
}

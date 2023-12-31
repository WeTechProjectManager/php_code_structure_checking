<?php

namespace App\Console\Commands;

use App\Models\Story;
use Illuminate\Console\Command;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $twentyFourHoursAgo = now()->subHours(24);

        Story::where('created_at', '<=', $twentyFourHoursAgo)
            ->update(['status' => 'inactive']);
    }
}

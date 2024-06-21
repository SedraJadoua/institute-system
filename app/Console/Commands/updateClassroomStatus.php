<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class updateClassroomStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'classroom:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update classroom status based on the current time and schedule';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $currentDay = $now->format('l');
        $currentTime = $now->format('H:i:s');
        $this->info($currentDay ." " . $currentTime);
        Log::info($currentDay ." " . $currentTime);
    }
}

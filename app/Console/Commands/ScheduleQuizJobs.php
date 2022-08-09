<?php

namespace App\Console\Commands;

use App\Http\Controllers\UserController;
use Illuminate\Console\Command;

class ScheduleQuizJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:RunQuizJob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It is for sending email for subscribed quiz users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $usrCon = new UserController();
        return $usrCon->subscribeJobs();
    }
}

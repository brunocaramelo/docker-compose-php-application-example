<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SchedulerInutil extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedulerInutil:run';

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
     * @return mixed
     */
    public function handle()
    {
     \Log::info('sou o schedulerInutil e nao estou fazendo nada');
    }
}

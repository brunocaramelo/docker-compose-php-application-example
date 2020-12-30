<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CuspidorDeLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cuspirlog:run
    {--parametrozao=maoe : parametro aqui}
    ';

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
       \Log::info('sou o Cuspidor de Log e esse o meu parametrozao: '.$this->option('parametrozao'));
    }
}

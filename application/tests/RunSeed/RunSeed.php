<?php

namespace Tests\RunSeed;

use Illuminate\Support\Facades\Artisan as Artisan;
use Illuminate\Support\Facades\Cache as Cache;


trait RunSeed
{
    public function runSeed()
    {
        Cache::flush();
        Artisan::call('db:seed', ['--class' => 'Seeds\ImporFakeJsonSeeder' ]);
    }
}
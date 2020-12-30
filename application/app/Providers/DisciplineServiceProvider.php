<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Disciplines\Services\DisciplineService;

class DisciplineServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(DisciplineService::class, function () {
            return new DisciplineService();
        });
    }
}

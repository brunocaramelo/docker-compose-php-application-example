<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Domain\Authors\Services\AuthorService;

class AuthorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AuthorService::class, function () {
            return new AuthorService();
        });
    }
}

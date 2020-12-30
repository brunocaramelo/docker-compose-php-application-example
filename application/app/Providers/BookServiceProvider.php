<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Books\Services\BookService;

class BookServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(BookService::class, function () {
            return new BookService();
        });
    }
}

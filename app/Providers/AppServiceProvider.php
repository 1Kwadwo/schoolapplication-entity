<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);
        
        // Register global middleware to block external requests only in local development
        if (config('app.env') === 'local') {
            $this->app['router']->pushMiddlewareToGroup('web', \App\Http\Middleware\BlockExternalRequests::class);
        }
    }
}

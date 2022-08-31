<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::macro('jetstreamMiddleware', function () {
            $authMiddleware = config('jetstream.guard')
                ? 'auth:'.config('jetstream.guard')
                : 'auth';

            $authSessionMiddleware = config('jetstream.auth_session', false)
                ? config('jetstream.auth_session')
                : null;

            return Route::middleware(array_values(array_filter([$authMiddleware, $authSessionMiddleware, 'verified'])));
        });
    }
}

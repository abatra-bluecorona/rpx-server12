<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CheckDownloadToken; // Adjust the namespace according to your class


class CustomServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('check.download.token', function ($app) {
            return new CheckDownloadToken(); // Replace with your class
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

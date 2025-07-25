<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

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
        // Set locale PHP
        setlocale(LC_TIME, 'id_ID.UTF-8');

        // Set locale Carbon
        Carbon::setLocale('id');
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;

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
        Schema::defaultStringLength(191);
        

        Gate::define('CEO', function ($user) {
            if (auth()->user()->nivel == 'CEO') {
                return true;
            }
            return false;
        });
        Gate::define('MAS', function ($user) {
            if (
                auth()->user()->nivel == 'CEO'
                ||auth()->user()->nivel == 'MAS'
            ) {
                return true;
            }
            return false;
        });
        Gate::define('ADM', function ($user) {
            if (
                auth()->user()->nivel == 'CEO'
                ||auth()->user()->nivel == 'MAS'
                ||auth()->user()->nivel == 'ADM'
            ) {
                return true;
            }
            return false;
        });

        Gate::define('COB', function ($user) {
            if (
                auth()->user()->nivel == 'CEO'
                ||auth()->user()->nivel == 'MAS'
                ||auth()->user()->nivel == 'ADM'
                ||auth()->user()->nivel == 'COB'
            ) {
                return true;
            }
            return false;
        });

        Gate::define('CLI', function ($user) {
            if (
                auth()->user()->nivel == 'CEO'
                ||auth()->user()->nivel == 'MAS'
                ||auth()->user()->nivel == 'ADM'
                ||auth()->user()->nivel == 'COB'
                ||auth()->user()->nivel == 'CLI'
            ) {
                return true;
            }
            return false;
        });

        Gate::define('APENASCLI', function ($user) {
            if (
                auth()->user()->nivel == 'CLI'
            ) {
                return true;
            }
            return false;
        });

    }
}

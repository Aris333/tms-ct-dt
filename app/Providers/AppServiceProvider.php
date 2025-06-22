<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

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

        Model::preventLazyLoading(App::isLocal());
        Model::preventAccessingMissingAttributes(App::isLocal());
        Model::preventSilentlyDiscardingAttributes(App::isLocal());

        // Log slow queries in development
        if (app()->isLocal()) {
            DB::listen(function ($query) {
                if ($query->time > 100) {
                    logger()->warning('Slow Query: ' . $query->sql, [
                        'time' => $query->time,
                        'bindings' => $query->bindings,
                    ]);
                }
            });
        }
    }
}

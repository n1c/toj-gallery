<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.debug_sql')) {
            \Event::listen('illuminate.query', function ($sql, $bindings, $time) {
                $sql = str_replace([ '%', '?' ], [ '%%', '%s' ], $sql);
                $sql = vsprintf($sql, $bindings);
                $now = (new \DateTime)->format('Y-m-d H:i:s');
                \Log::debug(sprintf('%s [%ums]', $sql, $time));
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

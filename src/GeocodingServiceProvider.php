<?php

namespace Geocoding;

use Illuminate\Support\ServiceProvider;

class GeocodongServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config.php' => config_path('geocoding.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('geocoding', function () {
            return new Geocoder();
        });
    }
}
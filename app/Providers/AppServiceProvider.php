<?php

namespace App\Providers;

use App\API\Serializers\CustomArraySerializer;
use Dingo\Api\Transformer\Adapter\Fractal;
use Dingo\Api\Transformer\Factory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use VIITech\Helpers\GlobalHelpers;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (GlobalHelpers::isDevelopmentEnv()) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // set default schema string length
        Schema::defaultStringLength(191);

        // Customize Dingo API Serializer
        $this->app[Factory::class]->setAdapter(function ($app) {
            $fractal = new Manager;
            $fractal->setSerializer(new CustomArraySerializer());
            return new Fractal($fractal);
        });

        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
}

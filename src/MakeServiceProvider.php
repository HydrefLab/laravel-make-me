<?php

namespace HydrefLab\Laravel\Make;

use HydrefLab\Laravel\Make\Console\MakeCommand;
use Illuminate\Support\ServiceProvider;

class MakeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            MakeCommand::class,
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
<?php

namespace NickSynev\MakeObserverCommand;

use Illuminate\Support\ServiceProvider;

class MakeObserverCommandServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    protected $commands = [
        'NickSynev\MakeObserverCommand\MakeObserver',
    ];

    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}

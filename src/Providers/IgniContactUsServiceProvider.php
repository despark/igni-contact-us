<?php

namespace Despark\Cms\ContactUs\Providers;

use Illuminate\Support\ServiceProvider;

class IgniContactUsServiceProvider extends ServiceProvider
{
    /**
     * Artisan commands.
     *
     * @var array
     */
    protected $commands = [
        \Despark\Cms\ContactUs\Console\Commands\InstallCommand::class,
    ];

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/' => config_path(),
        ], 'config');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Register the application commands
        $this->commands($this->commands);
    }
}

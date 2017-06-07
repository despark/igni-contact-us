<?php

namespace Despark\Cms\ContactUs\Providers;

use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Support\ServiceProvider;

class IgniContactUsServiceProvider extends ServiceProvider
{
    use DetectsApplicationNamespace;

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
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}

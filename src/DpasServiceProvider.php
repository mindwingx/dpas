<?php

namespace Mindwingx\Dpas;

use Illuminate\Support\ServiceProvider;

class DpasServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected array $commands = [];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', 'mindwingx');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'mindwingx');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->getCommands());
        //$this->commands($this->getCommands());
        $this->mergeConfigFrom(__DIR__ . '/../config/dpas.php', 'dpas');

        // Register the service the package provides.
        $this->app->singleton('dpas', function ($app) {
            return new Dpas;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['dpas'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/dpas.php' => base_path('config/dpas.php'),
        ], 'dpas.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/mindwingx'),
        ], 'dpas.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/mindwingx'),
        ], 'dpas.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/mindwingx'),
        ], 'dpas.views');*/

        // Registering package commands.
        // $this->commands([]);
    }

    /**
     * @return array
     */
    protected function getCommands(): array
    {
        $commandFiles = glob(base_path('vendor/mindwingx/dpas/src/Commands/*.php'));

        foreach ($commandFiles as $item) {
            $regex = preg_replace('/\/(.*)vendor\/|[*.]php|\/.[src]+/', '', $item);
            $step = str_replace(['mindwingx', 'dpas', '/'], ['Mindwingx', 'Dpas', '\\'], $regex);
            $this->commands[] = $step;
        }

        return $this->commands;
    }
}

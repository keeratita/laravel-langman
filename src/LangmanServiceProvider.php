<?php

namespace Keeratita\Langman;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

class LangmanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/langman.php' => config_path('langman.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/langman.php', 'langman');

        $this->app->bind(Manager::class, function () {
            return new Manager(
                new Filesystem,
                $this->app['config']['langman.path'],
                array_merge($this->app['config']['view.paths'], [$this->app['path']])
            );
        });

        $this->commands([
            \Keeratita\Langman\Commands\MissingCommand::class,
            \Keeratita\Langman\Commands\RemoveCommand::class,
            \Keeratita\Langman\Commands\TransCommand::class,
            \Keeratita\Langman\Commands\ShowCommand::class,
            \Keeratita\Langman\Commands\FindCommand::class,
            \Keeratita\Langman\Commands\SyncCommand::class,
            \Keeratita\Langman\Commands\RenameCommand::class,
        ]);
    }
}
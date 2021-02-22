<?php

namespace mahdiraad\LumenSail;

use Illuminate\Support\Composer;
use Illuminate\Support\ServiceProvider;

class LumenSailServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'SailInstall' => 'command.sail.install',
    ];

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerCommands($this->commands);
    }

    /**
     * Register the given commands.
     *
     * @param array $commands
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            $method = "register{$command}Command";

            call_user_func_array([$this, $method], []);
        }

        $this->commands(array_values($commands));
    }

    /**
     * Register the command.
     */
    protected function registerSailInstallCommand()
    {
        $this->app->singleton('command.sail.install', function ($app) {
            return new Console\Commands\SailInstallCommand();
        });
    }

    /**
     * Register the command.
     */
    protected function registerSailPublishCommand()
    {
        $this->app->singleton('command.sail.publish', function ($app) {
            return new Console\Commands\SailPublishCommand();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_values($this->commands);
    }
}
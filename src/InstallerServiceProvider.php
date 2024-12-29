<?php

namespace Larawise\Installer;

use Illuminate\Support\Facades\File;
use Larawise\Installer\Events\InstallationCompleted;
use Illuminate\Support\ServiceProvider;

/**
 * Srylius - The ultimate symphony for technology architecture!
 *
 * @package     Larawise
 * @subpackage  Installer
 * @version     v1.0.0
 * @author      Selçuk Çukur <hk@selcukcukur.com.tr>
 * @license     MIT License (https://github.com/larawise/installer/blob/main/license.md)
 * @copyright   Srylius Teknoloji Limited Şirketi
 *
 * @see https://larawise.com/ Larawise : Docs
 */
class InstallerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        // Record the macros required for the installation wizard.
        $this->registerMacros();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Register event listener for installation completed events.
        $this->app['events']->listen(InstallationCompleted::class, function () {
            // Create a file containing the date and time of the installation.
            $this->app['files']->put(storage_path('framework/install.lock'), Carbon::now()->toDateTimeString());
        });
    }

    /**
     * Register macros for the application.
     *
     * @return void
     */
    protected function registerMacros()
    {
        // Record a macro that checks the application database connection status.
        Application::macro('isConnected', function () {
            // Check the completion status of the application installation and database connection.
            return Schema::hasTable($this->app['config']->get('larawise::installer.table', 'settings'));
        });

        // Record a macro that checks the application installation status.
        Application::macro('isInstalled', function () {
            // Check the application installation wizard status.
            if (! $this->app['config']->get('larawise::installer.status', false)) {
                return true;
            }

            // Check if the application is installed.
            if ($this->app['files']->exists($this->app->storagePath('framework/install.lock'))) {
                return true;
            }

            // Check the completion status of the application installation and database connection.
            return ! $this->app['files']->exists($this->app->storagePath('framework/installing.lock')) && $this->app->isConnected();
        });
    }
}

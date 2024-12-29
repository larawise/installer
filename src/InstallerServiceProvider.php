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
}

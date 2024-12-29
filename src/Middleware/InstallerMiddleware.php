<?php

namespace Srylius\Installer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
class InstallerMiddleware
{
    /**
     * The URLs that must be accessible during installation
     *
     * @var string[]
     */
    protected $except = [];

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if a route should be excluded from the check.
        if ($this->inAccessible($request)) {
            // Continue to next middleware.
            return $next($request);
        }

        // Check the application installation status and whether the current request is an installation request.
        if (! app()->isInstalled() && Route::current()->getPrefix() !== 'install') {
            // If the required conditions are not met, redirect to the installation wizard.
            return redirect()->route('installer.welcome');
        }

        // Continue to next middleware.
        return $next($request);
    }

    /**
     * Determine if the request has a URI that should be accessible in installation.
     *
     * @param Request $request
     *
     * @return bool
     */
    protected function inAccessible(Request $request): bool
    {
        // Check all url paths that should be excluded.
        foreach (array_merge($this->except, config('larawise::installer.except')) as $except) {
            // Make sure the request is not the root route.
            if ($except !== '/') {
                // Check if there is a trailing slash at the end of the path that should be excluded and trim it.
                $except = trim($except, '/');
            }

            // Check if the route to be excluded matches the request route.
            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }
}

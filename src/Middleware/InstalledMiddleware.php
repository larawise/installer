<?php

namespace Larawise\Installer\Middleware;

use Closure;
use Illuminate\Http\Request;

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
class InstalledMiddleware
{
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
        // Check if the application installation is completed.
        if (app()->isInstalled()) {
            // If the application installation is completed and the installation routes are visited, redirect to the home page.
            return redirect()->route(config('larawise::installer.redirect', 'web.home'));
        }

        // Continue to next middleware.
        return $next($request);
    }
}

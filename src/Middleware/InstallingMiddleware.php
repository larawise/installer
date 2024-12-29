<?php

namespace Srylius\Installer\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
class InstallingMiddleware
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
        try {
            // Get the contents of the lock file created after installation.
            $content = File::get(storage_path('framework/installing.lock'));

            // Parse the time in the setup file.
            $starting = Carbon::parse(strip_tags($content));

            // Check if the content is not available or is more than 30 minutes.
            if (! $content || Carbon::now()->diffInMinutes($starting) > 30) {
                // If conditions are met, redirect the user to the home page.
                return redirect()->route(config('larawise::installer.redirect', 'web.home'));
            }
        } catch (Exception $exception) {
            // If conditions are met, redirect the user to the home page.
            return redirect()->route(config('larawise::installer.redirect', 'web.home'));
        }

        // Continue to next middleware.
        return $next($request);
    }
}

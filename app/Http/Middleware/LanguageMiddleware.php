<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->session()->get('locale');

        if ($locale && in_array($locale, config('app.locales'))) {
            app()->setLocale($locale);
        }

        if (!$locale) {
            app()->setLocale(config('app.locale'));
        }

        return $next($request);
    }
}

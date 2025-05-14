<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale', config('app.locale'));
        if ($request->has('locale')) {
            $locale = $request->locale;
            session(['locale' => $locale]);
        }
        if (in_array($locale, ['ar', 'en'])) {
            app()->setLocale($locale);
        }
        return $next($request);
    }
}

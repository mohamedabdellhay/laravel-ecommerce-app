<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (!Auth::check() || !Auth::user()->is_admin) {
        //     // Check if we're on admin subdomain
        //     if (str_contains($request->getHost(), 'admin.')) {
        //         return redirect()->route('admin.login')
        //             ->withErrors(['email' => 'You do not have permission to access the admin area.']);
        //     }

        //     return redirect()->route('login');
        // }
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized.');
        }


        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login'); // Changed to admin-specific view
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Check if the user is an admin
        $user = Auth::user();

        // Check if we're on the admin domain
        if (str_contains($request->getHost(), 'admin.')) {
            // Only admins should be able to access admin routes
            if ($user && $user->is_admin) {
                return redirect()->intended(route('admin.dashboard'));
            } else {
                // Non-admin users should be logged out and redirected to admin login
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('admin.login')
                    ->withErrors(['email' => 'You do not have permission to access the admin area.']);
            }
        }

        // For non-admin domain, redirect to home
        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirect to admin login if logout was from admin panel
        if (str_contains($request->getHost(), 'admin.')) {
            return redirect()->route('admin.login');
        }

        return redirect('/');
    }
}

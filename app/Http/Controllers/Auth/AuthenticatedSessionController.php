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
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user
        $request->authenticate();

        // Get the authenticated user
        $user = $request->user();

        // Check if the user is active
        if ($user->status === 0) {
            // If user is inactive, log them out and return an error message
            auth()->logout(); // Log the user out
            return redirect()->route('login')->with('status', 'Your account has been deactivated. Please contact the administrator.')->with('status_type', 'danger');
        }

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        // Add success message for successful login
        return redirect()->route($user->role === 'admin' ? 'admin.dashboard' : 'dashboard')
            ->with('status', "You're logged in!")->with('status_type', 'success');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

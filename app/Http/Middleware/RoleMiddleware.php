<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Proceed if the role matches
            if ($role && $user->role === $role) {
                return $next($request);
            }

            // Default redirection based on role
            return redirect($user->role === 'admin' ? '/admin/dashboard' : '/dashboard');
        }

        // Redirect to login if not authenticated
        return redirect('/login');
    }
}

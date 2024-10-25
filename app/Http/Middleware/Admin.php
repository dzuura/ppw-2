<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the 'admin' role
        if (Auth::check() && Auth::user()->level === 'admin') {
            return $next($request); // Allow access if user is admin
        }

        // Redirect based on user level
        if (Auth::check() && Auth::user()->level === 'user') {
            return redirect('/dashboard'); // Redirect user to user dashboard
        }

        // If role is 'guest' or anything else
        return redirect('/'); // Redirect guest or unauthorized roles to home
    }
}

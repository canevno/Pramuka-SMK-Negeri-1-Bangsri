<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // If user is not logged in or not admin, redirect back to home.
        if (! $user || ! ($user->is_admin ?? false)) {
            return redirect()->route('home')->with('error', 'Akses terbatas: hanya untuk admin.');
        }

        return $next($request);
    }
}

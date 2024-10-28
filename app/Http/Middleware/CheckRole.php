<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        // Convert role parameter to uppercase for case-insensitive comparison
        $userRole = strtolower(Auth::user()->Role);
        $requiredRole = strtolower($role);

        if ($userRole === $requiredRole) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}

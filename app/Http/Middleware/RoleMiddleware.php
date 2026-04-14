<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // If not logged in
        if (!$user) {
            return redirect()->route('login');
        }

        // If no role defined in DB, block access
        if (!$user->role) {
            abort(403, 'No role assigned.');
        }

        // Allow multiple roles: admin,manager,user etc.
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
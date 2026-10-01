<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (Auth::guest()) {
            return redirect()->route('login');
        }

        $userRole = strtolower(Auth::user()->role->role_name);

        $allowedRoles = array_map('strtolower', $roles);

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Unauthorized action.');
        }
        
        return $next($request);
    }
}
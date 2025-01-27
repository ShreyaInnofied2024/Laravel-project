<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $roles)
    {
        $rolesArray = explode(',', $roles);

        if (Auth::check() && in_array(Auth::user()->role, $rolesArray)) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Unauthorized access');
    }
}

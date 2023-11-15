<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRoleAny
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  int  $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        
        // Check if the user has at least one of the allowed roles (1 or 2)
        if (!in_array($request->user()->role_id, $roles)) {
            $url = $request->url();
            return redirect('dashboard')->with('error', "Access denied to {$url}");
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOrMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated as either admin or member
        if (Auth::guard('admin')->check() || Auth::guard('member')->check()) {
            return $next($request);
        }

        // Redirect or handle unauthorized access
        return redirect()->route('login'); 
    }
}

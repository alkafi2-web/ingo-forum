<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class MemberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the current user is authenticated as a member
        if (Auth::guard('member')->check()) {
            return $next($request);
        }

        // If not authenticated as member, redirect or handle accordingly
        return redirect()->route('frontend.login')->with('failed', 'Login is required for comment'); // Example: Redirect to member login route
    }
}

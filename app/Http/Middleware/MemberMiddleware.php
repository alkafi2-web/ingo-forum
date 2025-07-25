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
            $user = Auth::guard('member')->user();

            // Check if the user's status is 1
            if ($user->status == 1) {
                return $next($request);
            }

            // If the user's status is not 1, handle accordingly
            return redirect()->route('frontend.login')->with('failed', 'Access restricted to active members');
        }

        // If not authenticated as member, redirect or handle accordingly
        return redirect()->route('frontend.login')->with('failed', 'Login is required for comment'); // Example: Redirect to member login route
    }
}

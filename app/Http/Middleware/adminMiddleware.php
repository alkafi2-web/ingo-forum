<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class adminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check the user in the custom table
        $admin_user = User::where('id', $user->id)->first();

        if (!$admin_user) {
            // If the user is not found in the custom table, logout and redirect to login
            Auth::logout();
            return redirect()->route('login')->withErrors(['message' => 'User not authorized.']);
        }

        // If the user is found, proceed with the request
        return $next($request);
    }
}

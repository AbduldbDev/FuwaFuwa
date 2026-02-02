<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$types)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'You must be logged in to access this page.');
        }

        $user = Auth::user();

        if (!in_array($user->user_type, $types)) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        return $next($request);
    }
}

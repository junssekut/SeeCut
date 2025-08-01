<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is not logged in at all, redirect to login
        if (!Auth::check()) {
            return redirect()->guest(route('login'));
        }
        
        // If user is logged in and is a regular user (not vendor or admin), allow access
        $userRole = Auth::user()->profile?->role ?? 'customer';
        if ($userRole === 'customer') {
            return $next($request);
        }
        
        // If user is logged in but is vendor or admin, show access denied
        return response()->view('errors.customer-access-denied', [
            'previousUrl' => url()->previous(),
            'userRole' => $userRole
        ], 403);
    }
}

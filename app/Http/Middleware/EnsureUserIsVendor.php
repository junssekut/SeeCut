<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsVendor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is not logged in at all, redirect to vendor login
        if (!Auth::check()) {
            return redirect()->guest(route('vendor.login'));
        }
        
        // If user is logged in and is a vendor, allow access
        if (Auth::user()->profile?->role === 'vendor') {
            return $next($request);
        }
        
        // If user is logged in but NOT a vendor, show access denied page
        return response()->view('errors.vendor-access-denied', [
            'previousUrl' => url()->previous()
        ], 403);
    }
}

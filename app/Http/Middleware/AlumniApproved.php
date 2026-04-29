<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AlumniApproved
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // If user is alumni and not yet approved → force logout and redirect to login
            if ($user->role === 'alumni' && !$user->is_approved) {
                Auth::logout();

                return redirect()->route('login')
                    ->withErrors(['email' => 'Your account is pending admin approval.']);
            }
        }

        return $next($request);
    }
}
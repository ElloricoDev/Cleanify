<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ThrottleReports
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'reports:' . $request->user()?->id ?? $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 10)) { // 10 reports per hour
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'message' => 'Too many report submissions. Please try again in ' . ceil($seconds / 60) . ' minutes.',
            ], 429);
        }

        RateLimiter::hit($key, 3600); // 1 hour

        return $next($request);
    }
}

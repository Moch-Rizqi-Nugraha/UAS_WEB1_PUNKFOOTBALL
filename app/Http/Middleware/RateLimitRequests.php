<?php

namespace App\Http\Middleware;

use Illuminate\Cache\RateLimiter;
use Closure;
use Illuminate\Http\Request;

class RateLimitRequests
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next, $maxAttempts = 60, $decayMinutes = 1)
    {
        // Use IP address as throttle key
        $key = $this->resolveRequestSignature($request);

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            $retryAfter = $this->limiter->availableIn($key);
            
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again in ' . $retryAfter . ' seconds.',
            ], 429)
                ->header('X-RateLimit-Limit', $maxAttempts)
                ->header('X-RateLimit-Remaining', 0)
                ->header('Retry-After', $retryAfter);
        }

        $this->limiter->hit($key, $decayMinutes * 60);

        $response = $next($request);

        return $this->addHeaders(
            $response,
            $maxAttempts,
            $this->limiter->attempts($key),
            $this->limiter->availableIn($key),
            $key
        );
    }

    protected function resolveRequestSignature($request)
    {
        if (auth()->user()) {
            return auth()->id();
        }

        return $request->ip();
    }

    protected function addHeaders($response, $limit, $remaining, $availableIn, $key)
    {
        $resetTime = now()->addSeconds($availableIn)->timestamp;

        $response->headers->add([
            'X-RateLimit-Limit' => $limit,
            'X-RateLimit-Remaining' => max(0, $remaining - 1),
            'X-RateLimit-Reset' => $resetTime,
        ]);

        return $response;
    }
}

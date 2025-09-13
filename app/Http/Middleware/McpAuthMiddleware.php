<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class McpAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        $validToken = config('mcp.api_token');

        // Allow requests without auth in development
        if (app()->environment('local') && ! $token) {
            return $next($request);
        }

        // Require auth in production
        if (! $token || $token !== $validToken) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Valid bearer token required for MCP access',
            ], 401);
        }

        return $next($request);
    }
}

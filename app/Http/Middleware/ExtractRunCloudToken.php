<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExtractRunCloudToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Extract RunCloud API token from multiple possible header sources
        $runcloudToken = $request->header('X-RunCloud-Token')
            ?? $request->header('RunCloud-API-Token')
            ?? $request->header('X-RunCloud-API-Token');

        if ($runcloudToken) {
            // Store token in request for tools to access
            $request->merge(['_runcloud_api_token' => $runcloudToken]);

            // Also set in app container for global access
            app()->instance('runcloud.api.token', $runcloudToken);
        }

        return $next($request);
    }
}

<?php

namespace App\Modules;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class APIRequest
{
    protected string $baseUrl;

    protected string $token;

    public function __construct(?string $baseUrl = null, ?string $token = null)
    {
        $this->baseUrl = $baseUrl ?? config('services.runcloud.api_endpoint_url');
        $this->token = $token ?? config('services.runcloud.api_token');
    }

    /**
     * Send an API request.
     *
     * @param  string  $method  HTTP method (GET, POST, etc)
     * @param  string  $endpoint  Endpoint path (e.g. '/ping')
     * @param  array|null  $data  Optional data for POST/PUT/PATCH
     * @return array [success => bool, message => string, response => mixed]
     */
    public function request(string $method, string $endpoint, ?array $data = null): array
    {
        $url = rtrim($this->baseUrl, '/').'/'.ltrim($endpoint, '/');

        // Check cache for GET requests only
        if (strtoupper($method) === 'GET') {
            $cacheKey = 'api:'.md5($url.$this->token);
            $cached = Cache::get($cacheKey);
            if ($cached) {
                return $cached;
            }
        }

        try {
            $http = Http::withHeaders([
                'Authorization' => 'Bearer '.$this->token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]);

            $response = match (strtoupper($method)) {
                'GET' => $http->timeout(30)->get($url),
                'POST' => $http->timeout(30)->post($url, $data ?? []),
                'PUT' => $http->timeout(30)->put($url, $data ?? []),
            };

            $result = [
                'success' => $response->successful(),
                'message' => $response->successful() ? 'Request successful.' : $response->body(),
                'response' => $response->successful() ? $response->json() : null,
            ];

            // Cache GET requests for 1 minute
            if (strtoupper($method) === 'GET' && isset($cacheKey)) {
                Cache::put($cacheKey, $result, 60);
            }

            return $result;

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'response' => null,
            ];
        }
    }
}

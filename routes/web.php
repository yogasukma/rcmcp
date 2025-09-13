<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// MCP OAuth Discovery Endpoints
Route::get('/.well-known/oauth-authorization-server', function () {
    $baseUrl = url('/');

    return response()->json([
        'issuer' => $baseUrl,
        'authorization_endpoint' => $baseUrl.'/oauth/authorize',
        'token_endpoint' => $baseUrl.'/oauth/token',
        'userinfo_endpoint' => $baseUrl.'/oauth/userinfo',
        'jwks_uri' => $baseUrl.'/.well-known/jwks.json',
        'response_types_supported' => ['code'],
        'grant_types_supported' => ['authorization_code', 'refresh_token'],
        'token_endpoint_auth_methods_supported' => ['client_secret_basic', 'client_secret_post'],
        'scopes_supported' => ['openid', 'profile', 'mcp:access'],
        'subject_types_supported' => ['public'],
    ]);
})->name('oauth.discovery');

Route::get('/.well-known/oauth-protected-resource', function () {
    return response()->json([
        'resource' => url('/'),
        'authorization_servers' => [url('/')],
        'scopes_required' => ['mcp:access'],
        'bearer_token_methods_supported' => ['header'],
    ]);
})->name('oauth.resource');

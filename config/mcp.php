<?php

return [
    /*
    |--------------------------------------------------------------------------
    | MCP API Token
    |--------------------------------------------------------------------------
    |
    | This token is used to authenticate MCP requests. Generate a secure
    | random token for production use.
    |
    */
    'api_token' => env('MCP_API_TOKEN', 'dev-token-change-me'),

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configure rate limiting for MCP endpoints to prevent abuse.
    |
    */
    'rate_limit' => [
        'requests' => env('MCP_RATE_LIMIT_REQUESTS', 60),
        'minutes' => env('MCP_RATE_LIMIT_MINUTES', 1),
    ],

    /*
    |--------------------------------------------------------------------------
    | CORS Configuration
    |--------------------------------------------------------------------------
    |
    | Configure CORS settings for MCP endpoints. In production, you may
    | want to restrict allowed origins.
    |
    */
    'cors' => [
        'allowed_origins' => env('MCP_CORS_ORIGINS', '*'),
        'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
        'allowed_headers' => ['Content-Type', 'Authorization', 'X-Requested-With'],
    ],
];

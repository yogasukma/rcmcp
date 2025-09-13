<?php

use Laravel\Mcp\Server\Facades\Mcp;

Mcp::web('/rcmcp', \App\Mcp\Servers\RCMCPServer::class)
    ->middleware(['throttle:60,1', 'mcp.auth', 'extract.runcloud.token']); // Available at /mcp/rcmcp
// Mcp::local('RCMCP', \App\Mcp\Servers\RCMCPServer::class); // Start with ./artisan mcp:start RCMCP

<?php

use Laravel\Mcp\Server\Facades\Mcp;

// Mcp::web('demo', \App\Mcp\Servers\PublicServer::class); // Available at /mcp/demo
Mcp::local('RCMCP', \App\Mcp\Servers\RCMCPServer::class); // Start with ./artisan mcp:start RCMCP

<?php

namespace App\Mcp\Servers;

use Laravel\Mcp\Server;

class RCMCPServer extends Server
{
    public string $serverName = 'RCMCP Server';

    public string $serverVersion = '0.0.1';

    public string $instructions = 'This MCP server provides unified access to RunCloud server management via API.';

    public array $tools = [
        \App\Mcp\Tools\Server\ListServers::class,
        \App\Mcp\Tools\Server\FindServer::class,
        \App\Mcp\Tools\Server\ListSystemUsers::class,
        \App\Mcp\Tools\WebApplication\ListWebApplications::class,
        \App\Mcp\Tools\WebApplication\FindWebApplication::class,
        \App\Mcp\Tools\WebApplication\CreateWebApplication::class,
        \App\Mcp\Tools\Database\ListDatabases::class,
        \App\Mcp\Tools\Backup\ListBackups::class,
        \App\Mcp\Tools\Backup\FindBackup::class,
        \App\Mcp\Tools\Backup\CreateBackup::class,
    ];

    public array $resources = [
        // ExampleResource::class,
    ];

    public array $prompts = [
        // ExamplePrompt::class,
    ];
}

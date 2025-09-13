<?php

namespace App\Mcp\Tools\Server;

use App\Modules\Formatter\ServerFormatter;
use App\Modules\Server;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\ToolResult;

class ListServers extends Tool
{
    public string $name = 'list_servers';

    public function description(): string
    {
        return 'List all RunCloud servers with their details, status, and metadata';
    }

    public function handle(array $arguments): ToolResult
    {
        // Get RunCloud API token from middleware-extracted container
        $apiToken = app()->bound('runcloud.api.token') ? app('runcloud.api.token') : null;

        if (! $apiToken) {
            return ToolResult::error('RunCloud API token is required. Please provide your RunCloud API token in the X-RunCloud-Token header.');
        }

        $server = new Server($apiToken);
        $result = $server->listServers();

        if (! $result['success']) {
            return ToolResult::error($result['message']);
        }

        $output = ServerFormatter::formatServersList($result);

        return ToolResult::text($output);
    }
}

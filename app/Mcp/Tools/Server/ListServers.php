<?php

namespace App\Mcp\Tools\Server;

use App\Modules\Server;
use App\Modules\Formatter\ServerFormatter;
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
        $server = new Server();
        $result = $server->listServers();
        
        if (!$result['success']) {
            return ToolResult::error($result['message']);
        }

        $output = ServerFormatter::formatServersList($result);
        return ToolResult::text($output);
    }
}

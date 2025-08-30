<?php

namespace App\Mcp\Tools\Server;

use App\Modules\Server;
use App\Modules\Formatter\ServerFormatter;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\ToolInputSchema;
use Laravel\Mcp\Server\Tools\ToolResult;

class FindServer extends Tool
{
    public string $name = 'find_server';

    public function description(): string
    {
        return 'Find detailed server information including info, stats, and hardware details by server ID';
    }

    public function schema(ToolInputSchema $schema): ToolInputSchema
    {
        return $schema->string('id')
            ->description('Server ID to find')
            ->required();
    }

    public function handle(array $arguments): ToolResult
    {
        $id = $arguments['id'];
        $server = new Server();
        $result = $server->findServer($id);
        
        if (!$result['info']['success']) {
            return ToolResult::error($result['info']['message']);
        }

        $output = ServerFormatter::formatServerDetails($result);
        return ToolResult::text($output);
    }
}

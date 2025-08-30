<?php

namespace App\Mcp\Tools\Server;

use App\Modules\Server;
use App\Modules\Formatter\ServerFormatter;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\ToolInputSchema;
use Laravel\Mcp\Server\Tools\ToolResult;

class ListSystemUsers extends Tool
{
    public string $name = 'list_system_users';

    public function description(): string
    {
        return 'List all system users for a specific server by server ID';
    }

    public function schema(ToolInputSchema $schema): ToolInputSchema
    {
        return $schema->string('id')
            ->description('Server ID to list system users for')
            ->required();
    }

    public function handle(array $arguments): ToolResult
    {
        $id = $arguments['id'];
        $server = new Server();
        $result = $server->listSystemUsers($id);
        
        if (!$result['success']) {
            return ToolResult::error($result['message']);
        }

        $output = ServerFormatter::formatSystemUsers($result, $id);
        return ToolResult::text($output);
    }
}

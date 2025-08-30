<?php

namespace App\Mcp\Tools\Database;

use App\Modules\Database;
use App\Modules\Formatter\DatabaseFormatter;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\ToolInputSchema;
use Laravel\Mcp\Server\Tools\ToolResult;

class ListDatabases extends Tool
{
    public string $name = 'list_databases';

    public function description(): string
    {
        return 'List all databases for a specific server with their details, collations, and metadata';
    }

    public function schema(ToolInputSchema $schema): ToolInputSchema
    {
        return $schema->string('server_id')
            ->description('Server ID to list databases for')
            ->required();
    }

    public function handle(array $arguments): ToolResult
    {
        $serverId = $arguments['server_id'];
        $database = new Database();
        $result = $database->listDatabases($serverId);
        
        if (!$result['success']) {
            return ToolResult::error($result['message']);
        }

        $output = DatabaseFormatter::formatDatabasesList($result);
        return ToolResult::text($output);
    }
}

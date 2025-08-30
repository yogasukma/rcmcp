<?php

namespace App\Mcp\Tools\Backup;

use App\Modules\Backup;
use App\Modules\Formatter\BackupFormatter;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\ToolInputSchema;
use Laravel\Mcp\Server\Tools\ToolResult;

class ListBackups extends Tool
{
    public string $name = 'list_backups';

    public function description(): string
    {
        return 'List all backups with their details, storage, status, and metadata. Supports optional filtering parameters';
    }

    public function schema(ToolInputSchema $schema): ToolInputSchema
    {
        return $schema->string('storage')
            ->description('Filter by storage type (optional)')
            ->string('search')
            ->description('Search term to filter backups (optional)')
            ->string('server_id')
            ->description('Filter by server ID (optional)')
            ->string('status')
            ->description('Filter by status (optional)')
            ->string('sort_column')
            ->description('Column to sort by (optional)')
            ->string('sort_direction')
            ->description('Sort direction: asc or desc (optional)');
    }

    public function handle(array $arguments): ToolResult
    {
        // Filter out empty parameters
        $params = array_filter($arguments, fn($v) => !empty($v));
        
        $backup = new Backup();
        $result = $backup->listBackups($params);
        
        if (!$result['success']) {
            return ToolResult::error($result['message']);
        }

        $output = BackupFormatter::formatBackupsList($result);
        return ToolResult::text($output);
    }
}

<?php

namespace App\Mcp\Tools\Backup;

use App\Modules\Backup;
use App\Modules\Formatter\BackupFormatter;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\ToolInputSchema;
use Laravel\Mcp\Server\Tools\ToolResult;

class FindBackup extends Tool
{
    public string $name = 'find_backup';

    public function description(): string
    {
        return 'Find detailed backup information including storage, type, frequency, retention, and backup items by backup ID';
    }

    public function schema(ToolInputSchema $schema): ToolInputSchema
    {
        return $schema->string('id')
            ->description('Backup ID to find')
            ->required();
    }

    public function handle(array $arguments): ToolResult
    {
        $id = $arguments['id'];
        $backup = new Backup();
        $result = $backup->findBackup($id);
        
        if (!$result['success']) {
            return ToolResult::error($result['message']);
        }

        $output = BackupFormatter::formatBackupDetails($result);
        return ToolResult::text($output);
    }
}

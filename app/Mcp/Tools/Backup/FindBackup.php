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
        // Get RunCloud API token from middleware-extracted container
        $apiToken = app()->bound('runcloud.api.token') ? app('runcloud.api.token') : null;

        if (! $apiToken) {
            return ToolResult::error('RunCloud API token is required. Please provide your RunCloud API token in the X-RunCloud-Token header.');
        }

        $id = $arguments['id'];
        $backup = new Backup($apiToken);
        $result = $backup->findBackup($id);

        if (! $result['success']) {
            return ToolResult::error($result['message']);
        }

        $output = BackupFormatter::formatBackupDetails($result);

        return ToolResult::text($output);
    }
}

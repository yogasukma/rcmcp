<?php

namespace App\Mcp\Tools\Backup;

use App\Modules\Backup;
use App\Modules\Formatter\BackupFormatter;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\ToolInputSchema;
use Laravel\Mcp\Server\Tools\ToolResult;

class CreateBackup extends Tool
{
    public string $name = 'create_backup';

    public function description(): string
    {
        return 'Create a new backup with specified configuration. Must include either webApplicationId or databaseId (or both)';
    }

    public function schema(ToolInputSchema $schema): ToolInputSchema
    {
        return $schema->string('name')
            ->description('Name for the backup')
            ->string('web_application_id')
            ->description('Web application ID to backup (required if no database_id)')
            ->string('database_id')
            ->description('Database ID to backup (required if no web_application_id)')
            ->string('backup_type')
            ->description('Type of backup: full or incremental (default: full)')
            ->string('storage')
            ->description('Storage location: runcloud, s3, etc (default: runcloud)')
            ->string('format')
            ->description('Backup format: tar or zip (default: tar)')
            ->string('frequency')
            ->description('Backup frequency: 1 day, 1 week, etc (default: 1 week)')
            ->string('retention')
            ->description('Retention period: 1 week, 1 month, etc (default: 1 month)')
            ->boolean('exclude_development_files')
            ->description('Exclude development files (default: false)')
            ->boolean('exclude_wordpress_cache_files')
            ->description('Exclude WordPress cache files (default: false)')
            ->boolean('success_notification')
            ->description('Send success notifications (default: false)')
            ->boolean('fail_notification')
            ->description('Send failure notifications (default: false)');
    }

    public function handle(array $arguments): ToolResult
    {
        // Get RunCloud API token from middleware-extracted container
        $apiToken = app()->bound('runcloud.api.token') ? app('runcloud.api.token') : null;

        if (! $apiToken) {
            return ToolResult::error('RunCloud API token is required. Please provide your RunCloud API token in the X-RunCloud-Token header.');
        }

        // Map snake_case parameters to camelCase for the API
        $data = [];

        if (! empty($arguments['name'])) {
            $data['name'] = $arguments['name'];
        }
        if (! empty($arguments['web_application_id'])) {
            $data['webApplicationId'] = $arguments['web_application_id'];
        }
        if (! empty($arguments['database_id'])) {
            $data['databaseId'] = $arguments['database_id'];
        }
        if (! empty($arguments['backup_type'])) {
            $data['backupType'] = $arguments['backup_type'];
        }
        if (! empty($arguments['storage'])) {
            $data['storage'] = $arguments['storage'];
        }
        if (! empty($arguments['format'])) {
            $data['format'] = $arguments['format'];
        }
        if (! empty($arguments['frequency'])) {
            $data['frequency'] = $arguments['frequency'];
        }
        if (! empty($arguments['retention'])) {
            $data['retention'] = $arguments['retention'];
        }
        if (isset($arguments['exclude_development_files'])) {
            $data['excludeDevelopmentFiles'] = $arguments['exclude_development_files'];
        }
        if (isset($arguments['exclude_wordpress_cache_files'])) {
            $data['excludeWordpressCacheFiles'] = $arguments['exclude_wordpress_cache_files'];
        }
        if (isset($arguments['success_notification'])) {
            $data['successNotification'] = $arguments['success_notification'];
        }
        if (isset($arguments['fail_notification'])) {
            $data['failNotification'] = $arguments['fail_notification'];
        }

        $backup = new Backup($apiToken);
        $result = $backup->createBackup($data);

        if (! $result['success']) {
            return ToolResult::error($result['message']);
        }

        $output = BackupFormatter::formatCreateResult($result);

        return ToolResult::text($output);
    }
}

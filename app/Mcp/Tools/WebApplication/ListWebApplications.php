<?php

namespace App\Mcp\Tools\WebApplication;

use App\Modules\Formatter\WebApplicationFormatter;
use App\Modules\WebApplication;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\ToolInputSchema;
use Laravel\Mcp\Server\Tools\ToolResult;

class ListWebApplications extends Tool
{
    public string $name = 'list_web_applications';

    public function description(): string
    {
        return 'List all web applications for a specific server with their details, PHP versions, and database information';
    }

    public function schema(ToolInputSchema $schema): ToolInputSchema
    {
        return $schema->string('server_id')
            ->description('Server ID to list web applications for')
            ->required();
    }

    public function handle(array $arguments): ToolResult
    {
        // Get RunCloud API token from middleware-extracted container
        $apiToken = app()->bound('runcloud.api.token') ? app('runcloud.api.token') : null;

        if (! $apiToken) {
            return ToolResult::error('RunCloud API token is required. Please provide your RunCloud API token in the X-RunCloud-Token header.');
        }

        $serverId = $arguments['server_id'];
        $webApp = new WebApplication($apiToken);
        $result = $webApp->listWebApplications($serverId);

        if (! $result['success']) {
            return ToolResult::error($result['message']);
        }

        $output = WebApplicationFormatter::formatWebApplicationsList($result);

        return ToolResult::text($output);
    }
}

<?php

namespace App\Mcp\Tools\WebApplication;

use App\Modules\Formatter\WebApplicationFormatter;
use App\Modules\WebApplication;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\ToolInputSchema;
use Laravel\Mcp\Server\Tools\ToolResult;

class CreateWebApplication extends Tool
{
    public string $name = 'create_web_application';

    public function description(): string
    {
        return 'Create a new web application on a server with specified name and domain';
    }

    public function schema(ToolInputSchema $schema): ToolInputSchema
    {
        return $schema->string('server_id')
            ->description('Server ID where the web application will be created')
            ->required()
            ->string('name')
            ->description('Name for the web application')
            ->required()
            ->string('domain_name')
            ->description('Domain name for the web application')
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
        $data = [
            'name' => $arguments['name'],
            'domainName' => $arguments['domain_name'],
        ];

        $webApp = new WebApplication($apiToken);
        $result = $webApp->createWebApplication($serverId, $data);

        if (! $result['success']) {
            return ToolResult::error($result['message']);
        }

        $output = WebApplicationFormatter::formatCreateResult($result);

        return ToolResult::text($output);
    }
}

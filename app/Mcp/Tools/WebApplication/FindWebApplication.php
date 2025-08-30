<?php

namespace App\Mcp\Tools\WebApplication;

use App\Modules\WebApplication;
use App\Modules\Formatter\WebApplicationFormatter;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\ToolInputSchema;
use Laravel\Mcp\Server\Tools\ToolResult;

class FindWebApplication extends Tool
{
    public string $name = 'find_web_application';

    public function description(): string
    {
        return 'Find detailed web application information including paths, PHP version, stack configuration, and database details';
    }

    public function schema(ToolInputSchema $schema): ToolInputSchema
    {
        return $schema->string('server_id')
            ->description('Server ID where the web application is hosted')
            ->required()
            ->string('web_app_id')
            ->description('Web application ID to find')
            ->required();
    }

    public function handle(array $arguments): ToolResult
    {
        $serverId = $arguments['server_id'];
        $webAppId = $arguments['web_app_id'];
        
        $webApp = new WebApplication();
        $result = $webApp->findWebApplication($serverId, $webAppId);
        
        if (!$result['success']) {
            return ToolResult::error($result['message']);
        }

        $output = WebApplicationFormatter::formatWebApplicationDetails($result);
        return ToolResult::text($output);
    }
}

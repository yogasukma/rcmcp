<?php

namespace App\Mcp\Tools\WebApplication;

use App\Modules\WebApplication;
use App\Modules\Formatter\WebApplicationFormatter;
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
        $serverId = $arguments['server_id'];
        $data = [
            'name' => $arguments['name'],
            'domainName' => $arguments['domain_name'],
        ];
        
        $webApp = new WebApplication();
        $result = $webApp->createWebApplication($serverId, $data);
        
        if (!$result['success']) {
            return ToolResult::error($result['message']);
        }

        $output = WebApplicationFormatter::formatCreateResult($result);
        return ToolResult::text($output);
    }
}

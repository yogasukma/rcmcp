<?php

namespace App\Mcp\Tools\Server;

use App\Modules\Formatter\ServerFormatter;
use App\Modules\Server;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\ToolInputSchema;
use Laravel\Mcp\Server\Tools\ToolResult;

class FindServer extends Tool
{
    public string $name = 'find_server';

    public function description(): string
    {
        return 'Find detailed server information including info, stats, and hardware details by server ID';
    }

    public function schema(ToolInputSchema $schema): ToolInputSchema
    {
        return $schema->string('id')
            ->description('Server ID to find')
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
        $server = new Server($apiToken);
        $result = $server->findServer($id);

        if (! $result['info']['success']) {
            return ToolResult::error($result['info']['message']);
        }

        $output = ServerFormatter::formatServerDetails($result);

        return ToolResult::text($output);
    }
}

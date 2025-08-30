<?php

namespace App\Console\Commands\WebApplication;

use App\Modules\WebApplication;
use Illuminate\Console\Command;

class CreateWebApplication extends Command
{
    protected $signature = 'api:create-webapp {serverId} {name} {domainName}';

    protected $description = 'Create a new web application for a server';

    public function handle()
    {
        $serverId = $this->argument('serverId');
        $name = $this->argument('name');
        $domainName = $this->argument('domainName');
        $data = [
            'name' => $name,
            'domainName' => $domainName,
        ];

        $result = (new WebApplication())->createWebApplication($serverId, $data);

        $this->info(json_encode($result, JSON_PRETTY_PRINT));
    }
}

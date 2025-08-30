<?php

namespace App\Console\Commands\WebApplication;

use App\Modules\WebApplication;
use Illuminate\Console\Command;

class ListWebApplications extends Command
{
    protected $signature = 'api:list-webapps {serverId}';

    protected $description = 'List all web applications for a server';

    public function handle()
    {
        $serverId = $this->argument('serverId');

        $result = (new WebApplication())->listWebApplications($serverId);

        $this->info(json_encode($result, JSON_PRETTY_PRINT));
    }
}

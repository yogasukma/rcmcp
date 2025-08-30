<?php

namespace App\Console\Commands\WebApplication;

use App\Modules\WebApplication;
use Illuminate\Console\Command;

class FindWebApplication extends Command
{
    protected $signature = 'api:find-webapp {serverId} {id}';

    protected $description = 'Find a web application by server ID and webapp ID';

    public function handle()
    {
        $serverId = $this->argument('serverId');
        $id = $this->argument('id');

        $result = (new WebApplication())->findWebApplication($serverId, $id);

        $this->info(json_encode($result, JSON_PRETTY_PRINT));
    }
}

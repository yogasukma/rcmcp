<?php

namespace App\Console\Commands\Database;

use App\Modules\Database;
use Illuminate\Console\Command;

class ListDatabases extends Command
{
    protected $signature = 'api:list-databases {serverId}';

    protected $description = 'List all databases for a server';

    public function handle()
    {
        $serverId = $this->argument('serverId');

        $result = (new Database())->listDatabases($serverId);
        
        $this->info(json_encode($result, JSON_PRETTY_PRINT));
    }
}

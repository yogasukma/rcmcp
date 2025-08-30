<?php

namespace App\Console\Commands\Server;

use App\Modules\Server;
use Illuminate\Console\Command;

class ListServers extends Command
{
    protected $signature = 'api:list-servers';

    protected $description = 'List all servers';

    public function handle()
    {
        $result = (new Server())->listServers();

        $this->info(json_encode($result, JSON_PRETTY_PRINT));
    }
}

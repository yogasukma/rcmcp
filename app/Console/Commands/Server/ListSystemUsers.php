<?php

namespace App\Console\Commands\Server;

use App\Modules\Server;
use Illuminate\Console\Command;

class ListSystemUsers extends Command
{
    protected $signature = 'api:list-system-users {id}';

    protected $description = 'List system users for a server by ID';

    public function handle()
    {
        $id = $this->argument('id');

        $result = (new Server())->listSystemUsers($id);

        $this->info(json_encode($result, JSON_PRETTY_PRINT));
    }
}

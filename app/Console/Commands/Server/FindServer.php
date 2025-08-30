<?php

namespace App\Console\Commands\Server;

use App\Modules\Server;
use Illuminate\Console\Command;

class FindServer extends Command
{
    protected $signature = 'api:find-server {id}';

    protected $description = 'Find server info, stats, and hardware by ID';

    public function handle()
    {
        $id = $this->argument('id');

        $result = (new Server())->findServer($id);

        $this->info(json_encode($result, JSON_PRETTY_PRINT));
    }
}

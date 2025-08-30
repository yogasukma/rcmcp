<?php

namespace App\Console\Commands\Backup;

use App\Modules\Backup;
use Illuminate\Console\Command;

class FindBackup extends Command
{
    protected $signature = 'api:find-backup {id}';

    protected $description = 'Find a backup by ID';

    public function handle()
    {
        $id = $this->argument('id');

        $result = (new Backup())->findBackup($id);

        $this->info(json_encode($result, JSON_PRETTY_PRINT));
    }
}

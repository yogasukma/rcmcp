<?php

namespace App\Console\Commands\Backup;

use App\Modules\Backup;
use Illuminate\Console\Command;

class ListBackups extends Command
{
    protected $signature = 'api:list-backups';

    protected $description = 'List all backups';

    public function handle()
    {
        $result = (new Backup())->listBackups();
        
        $this->info(json_encode($result, JSON_PRETTY_PRINT));
    }
}

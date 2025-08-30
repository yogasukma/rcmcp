<?php

namespace App\Console\Commands\Backup;

use App\Modules\Backup;
use Illuminate\Console\Command;

class CreateBackup extends Command
{
    protected $signature = 'api:create-backup {name?} {webApplicationId?} {databaseId?}';

    protected $description = 'Create a new backup';

    public function handle()
    {
        $data = [
            'webApplicationId' => $this->argument('webApplicationId'),
            'databaseId' => $this->argument('databaseId'),
            'name' => $this->argument('name'),
        ];

        // Remove null values
        $data = array_filter($data, fn($v) => $v !== null);

        $result = (new Backup())->createBackup($data);

        $this->info(json_encode($result, JSON_PRETTY_PRINT));
    }
}

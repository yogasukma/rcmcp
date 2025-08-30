<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ApiCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check API Connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $api = new \App\Modules\APIRequest();
        $result = $api->request('GET', '/ping');

        if ($result['success']) {
            $this->info('API connection successful.');
        } else {
            $this->error('API connection failed: ' . $result['message']);
        }
        return $result['success'] ? 0 : 1;
    }
}

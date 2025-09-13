<?php

namespace App\Modules;

class Database
{
    protected APIRequest $api;

    public function __construct(?string $apiToken = null)
    {
        $this->api = new APIRequest(null, $apiToken);
    }

    public function listDatabases($serverId)
    {
        $result = $this->api->request('GET', '/servers/'.$serverId.'/databases');

        return $result;
    }
}

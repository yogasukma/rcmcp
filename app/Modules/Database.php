<?php

namespace App\Modules;

class Database
{
    protected APIRequest $api;

    public function __construct()
    {
        $this->api = new APIRequest;
    }

    public function listDatabases($serverId)
    {
        $result = $this->api->request('GET', '/servers/'.$serverId.'/databases');

        return $result;
    }
}

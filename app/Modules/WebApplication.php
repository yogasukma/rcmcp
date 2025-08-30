<?php

namespace App\Modules;

class WebApplication
{
    protected APIRequest $api;

    public function __construct()
    {
        $this->api = new APIRequest;
    }

    public function listWebApplications($serverId)
    {
        $result = $this->api->request('GET', '/servers/'.$serverId.'/webapps');

        return $result;
    }

    public function findWebApplication($serverId, $id)
    {
        $result = $this->api->request('GET', '/servers/'.$serverId.'/webapps/'.$id);

        return $result;
    }

    public function createWebApplication($serverId, $data)
    {
        $validation = Validator::validateWebAppData($data);
        if ($validation !== true) {
            return $validation;
        }

        $result = $this->api->request('POST', '/servers/'.$serverId.'/webapps/custom', $data);

        return $result;
    }
}

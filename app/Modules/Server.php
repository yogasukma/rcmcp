<?php

namespace App\Modules;

class Server
{
    protected APIRequest $api;

    public function __construct()
    {
        $this->api = new APIRequest;
    }

    public function listServers()
    {
        $result = $this->api->request('GET', '/servers');

        return $result;
    }

    public function findServer($id)
    {
        $info = $this->api->request('GET', '/servers/'.$id);

        if ($info['success']) {
            $stats = $this->api->request('GET', '/servers/'.$id.'/stats');
            $hardware = $this->api->request('GET', '/servers/'.$id.'/hardwareinfo');
        }

        return [
            'info' => $info,
            'stats' => $stats ?? null,
            'hardware' => $hardware ?? null,
        ];
    }

    public function listSystemUsers($id)
    {
        $result = $this->api->request('GET', '/servers/'.$id.'/users');

        return $result;
    }
}

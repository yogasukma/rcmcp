<?php

namespace App\Modules;

class Server
{
    protected APIRequest $api;

    public function __construct(?string $apiToken = null)
    {
        $this->api = new APIRequest(null, $apiToken);
    }

    /**
     * List all servers.
     *
     * @return array An array of servers.
     */
    public function listServers(): array
    {
        $result = $this->api->request('GET', '/servers');

        return $result;
    }

    /**
     * Find a server by its ID.
     *
     * @param  string  $id  The server ID.
     * @return array An array containing server info, stats, and hardware info.
     */
    public function findServer($id): array
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

    /**
     * List all system users for a server.
     *
     * @param  string  $id  The server ID.
     * @return array An array of system users.
     */
    public function listSystemUsers($id)
    {
        $result = $this->api->request('GET', '/servers/'.$id.'/users');

        return $result;
    }
}

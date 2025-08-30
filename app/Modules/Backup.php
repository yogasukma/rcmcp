<?php

namespace App\Modules;

class Backup
{
    protected APIRequest $api;

    public function __construct()
    {
        $this->api = new APIRequest;
    }

    public function listBackups(array $params = [])
    {
        // curl --location --request GET 'https://manage.runcloud.io/api/v3/backups?storage&search&server_id&status&sort_column&sort_direction'
        $query = http_build_query($params);
        $endpoint = '/backups'.($query ? ('?'.$query) : '');

        $result = $this->api->request('GET', $endpoint);

        return $result;
    }

    public function findBackup($id)
    {
        $result = $this->api->request('GET', '/backups/'.$id);

        return $result;
    }

    public function createBackup(array $data)
    {
        // curl --location --request POST 'https://manage.runcloud.io/api/v3/backups' \
        // --header 'Content-Type: application/json' \
        // --data-raw '{
        //     "name": "Test external Backup Via API2",
        //     "webApplicationId": 187,
        //     "databaseId": 123,
        //     "backupType": "full",
        //     "storage": "runcloud",
        //     "format": "tar",
        //     "frequency": "1 week",
        //     "retention": "1 month",
        //     "excludeDevelopmentFiles": true,
        //     "excludeWordpressCacheFiles": true,
        //     "successNotification": true,
        //     "failNotification": true,
        //     "excludeFile": [
        //         "wp-config.php",
        //         "index.php"
        //     ],
        //     "excludeTable": [
        //         "wp-posts"
        //     ]
        // }'

        // Validation: must have webApplicationId or databaseId
        $validation = Validator::validateBackupData($data);
        if ($validation !== true) {
            return $validation;
        }

        // Set defaults for optional fields
        $defaults = [
            'name' => 'Backup',
            'backupType' => 'full',
            'storage' => 'runcloud',
            'format' => 'tar',
            'frequency' => '1 week',
            'retention' => '1 month',
            'excludeDevelopmentFiles' => false,
            'excludeWordpressCacheFiles' => false,
            'successNotification' => false,
            'failNotification' => false,
            'excludeFile' => [],
            'excludeTable' => [],
        ];

        $payload = array_merge($defaults, $data);

        $result = $this->api->request('POST', '/backups', $payload);

        return $result;
    }
}

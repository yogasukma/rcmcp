<?php

namespace App\Modules;

class Validator
{
    public static function validateWebAppData($data)
    {
        foreach (['name', 'domainName'] as $field) {
            if (empty($data[$field])) {
                return [
                    'success' => false,
                    'message' => ucfirst($field).' is required.',
                    'response' => null,
                ];
            }
        }

        return true;
    }

    public static function validateBackupData($data)
    {
        if (empty($data['webApplicationId']) && empty($data['databaseId'])) {
            return [
                'success' => false,
                'message' => 'Either webApplicationId or databaseId is required.',
                'response' => null,
            ];
        }

        return true;
    }
}

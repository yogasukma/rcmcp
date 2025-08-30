<?php

namespace App\Modules\Formatter;

class BackupFormatter
{
    public static function formatBackupsList($response)
    {
        if (!$response['success']) {
            return "Error: {$response['message']}";
        }

        $backups = $response['response']['data'];
        $meta = $response['response']['meta'] ?? null;

        if (empty($backups)) {
            return "No backups found.";
        }

        $output = "Backups:\n\n";

        foreach ($backups as $backup) {
            $output .= "• ID: {$backup['id']}\n";
            $output .= "• Label: {$backup['label']}\n";
            $output .= "• Type: {$backup['type']}\n";
            $output .= "• Storage: {$backup['storage']}\n";
            $output .= "• Format: {$backup['format']}\n";
            $output .= "• Frequency: {$backup['frequency']}\n";
            $output .= "• Retention: {$backup['retention']}\n";
            $output .= "• Size: {$backup['size']}\n";
            $output .= "• Status: {$backup['status']}\n";
            
            if (isset($backup['items'])) {
                $output .= "• Items:\n";
                if (isset($backup['items']['webApplicationId'])) {
                    $output .= "  • Web Application ID: {$backup['items']['webApplicationId']}\n";
                }
                if (isset($backup['items']['databaseId'])) {
                    $output .= "  • Database ID: {$backup['items']['databaseId']}\n";
                }
            }
            
            $output .= "\n";
        }

        // Add pagination info if available
        if ($meta && isset($meta['pagination'])) {
            $pagination = $meta['pagination'];
            $output .= "Pagination:\n";
            $output .= "• Total: {$pagination['total']}\n";
            $output .= "• Current Page: {$pagination['current_page']}\n";
            $output .= "• Per Page: {$pagination['per_page']}\n";
            $output .= "• Total Pages: {$pagination['total_pages']}\n";
        }

        return $output;
    }

    public static function formatBackupDetails($response)
    {
        if (!$response['success']) {
            return "Error: {$response['message']}";
        }

        $backup = $response['response'];

        $output = "Backup Details:\n\n";
        $output .= "• ID: {$backup['id']}\n";
        $output .= "• Label: {$backup['label']}\n";
        $output .= "• Type: {$backup['type']}\n";
        $output .= "• Storage: {$backup['storage']}\n";
        $output .= "• Format: {$backup['format']}\n";
        $output .= "• Frequency: {$backup['frequency']}\n";
        $output .= "• Retention: {$backup['retention']}\n";
        $output .= "• Size: {$backup['size']}\n";
        $output .= "• Status: {$backup['status']}\n";

        if (isset($backup['items'])) {
            $output .= "\nBackup Items:\n";
            if (isset($backup['items']['webApplicationId'])) {
                $output .= "• Web Application ID: {$backup['items']['webApplicationId']}\n";
            }
            if (isset($backup['items']['databaseId'])) {
                $output .= "• Database ID: {$backup['items']['databaseId']}\n";
            }
        }

        return $output;
    }

    public static function formatCreateResult($response)
    {
        if (!$response['success']) {
            return "Error creating backup: {$response['message']}";
        }

        return "Backup created successfully!\n\n" . self::formatBackupDetails($response);
    }
}

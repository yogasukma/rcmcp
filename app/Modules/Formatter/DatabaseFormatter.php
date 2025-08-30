<?php

namespace App\Modules\Formatter;

class DatabaseFormatter
{
    public static function formatDatabasesList($response)
    {
        if (!$response['success']) {
            return "Error: {$response['message']}";
        }

        $databases = $response['response']['data'];
        $meta = $response['response']['meta'];

        if (empty($databases)) {
            return "No databases found.";
        }

        $output = "Databases:\n\n";

        foreach ($databases as $database) {
            $output .= "• ID: {$database['id']}\n";
            $output .= "• Name: {$database['name']}\n";
            $output .= "• Collation: " . ($database['collation'] ?: 'Default') . "\n";
            $output .= "• Created: {$database['created_at']}\n";
            $output .= "\n";
        }

        // Add pagination info
        $pagination = $meta['pagination'];
        $output .= "Pagination:\n";
        $output .= "• Total: {$pagination['total']}\n";
        $output .= "• Current Page: {$pagination['current_page']}\n";
        $output .= "• Per Page: {$pagination['per_page']}\n";
        $output .= "• Total Pages: {$pagination['total_pages']}\n";

        return $output;
    }
}

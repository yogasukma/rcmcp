<?php

namespace App\Modules\Formatter;

class WebApplicationFormatter
{
    public static function formatWebApplicationsList($response)
    {
        if (!$response['success']) {
            return "Error: {$response['message']}";
        }

        $webApps = $response['response']['data'];
        $meta = $response['response']['meta'];

        if (empty($webApps)) {
            return "No web applications found.";
        }

        $output = "Web Applications:\n\n";

        foreach ($webApps as $app) {
            $output .= "• ID: {$app['id']}\n";
            $output .= "• Name: {$app['name']}\n";
            $output .= "• Type: {$app['type']}\n";
            $output .= "• PHP Version: {$app['phpVersion']}\n";
            $output .= "• Stack: {$app['stack']}\n";
            $output .= "• Stack Mode: {$app['stackMode']}\n";
            $output .= "• Root Path: {$app['rootPath']}\n";
            $output .= "• Public Path: {$app['publicPath']}\n";
            $output .= "• Default App: " . ($app['defaultApp'] ? 'Yes' : 'No') . "\n";
            $output .= "• Alias: " . ($app['alias'] ?: 'None') . "\n";
            $output .= "• Created: {$app['created_at']}\n";
            
            if (isset($app['database'])) {
                $output .= "• Database:\n";
                $output .= "  • ID: {$app['database']['id']}\n";
                $output .= "  • Name: {$app['database']['name']}\n";
                $output .= "  • Collation: " . ($app['database']['collation'] ?: 'Default') . "\n";
                $output .= "  • Created: {$app['database']['created_at']}\n";
            }
            
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

    public static function formatWebApplicationDetails($response)
    {
        if (!$response['success']) {
            return "Error: {$response['message']}";
        }

        $app = $response['response'];

        $output = "Web Application Details:\n\n";
        $output .= "• ID: {$app['id']}\n";
        $output .= "• Server User ID: {$app['server_user_id']}\n";
        $output .= "• Name: {$app['name']}\n";
        $output .= "• Type: {$app['type']}\n";
        $output .= "• PHP Version: {$app['phpVersion']}\n";
        $output .= "• Stack: {$app['stack']}\n";
        $output .= "• Stack Mode: {$app['stackMode']}\n";
        $output .= "• Root Path: {$app['rootPath']}\n";
        $output .= "• Public Path: {$app['publicPath']}\n";
        $output .= "• Default App: " . ($app['defaultApp'] ? 'Yes' : 'No') . "\n";
        $output .= "• Alias: " . ($app['alias'] ?: 'None') . "\n";
        $output .= "• Pull Key 1: {$app['pullKey1']}\n";
        $output .= "• Pull Key 2: {$app['pullKey2']}\n";
        $output .= "• Created: {$app['created_at']}\n";

        if (isset($app['database'])) {
            $output .= "\nDatabase Information:\n";
            $output .= "• ID: {$app['database']['id']}\n";
            $output .= "• Name: {$app['database']['name']}\n";
            $output .= "• Collation: " . ($app['database']['collation'] ?: 'Default') . "\n";
            $output .= "• Created: {$app['database']['created_at']}\n";
        }

        return $output;
    }

    public static function formatCreateResult($response)
    {
        if (!$response['success']) {
            return "Error creating web application: {$response['message']}";
        }

        return "Web application created successfully!\n\n" . self::formatWebApplicationDetails($response);
    }
}

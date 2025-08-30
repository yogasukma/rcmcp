<?php

namespace App\Modules\Formatter;

class ServerFormatter
{
    public static function formatServersList(array $result): string
    {
        if (!$result['success']) {
            return "Error: {$result['message']}";
        }

        $servers = $result['response']['data'];
        $total = $result['response']['meta']['pagination']['total'];
        
        $output = "**RunCloud Servers ({$total} total):**\n\n";
        
        foreach ($servers as $srv) {
            $status = $srv['connected'] ? '🟢 Connected' : '🔴 Disconnected';
            $online = $srv['online'] ? 'Online' : 'Offline';
            
            $output .= "• **{$srv['name']}** (ID: {$srv['id']})\n";
            $output .= "  - Status: {$status}\n";
            $output .= "  - Online: {$online}\n";
            $output .= "  - IP: {$srv['ipAddress']}\n";
            $output .= "  - Provider: {$srv['provider']}\n";
            $output .= "  - OS: {$srv['os']} {$srv['osVersion']}\n";
            $output .= "  - Stack: {$srv['stack']}\n";
            $output .= "  - Country: {$srv['country_iso_code']}\n";
            $output .= "  - PHP: {$srv['phpCLIVersion']}\n";
            $output .= "  - Created: {$srv['created_at']}\n";
            
            if (!empty($srv['tags'])) {
                $tags = implode(', ', $srv['tags']);
                $output .= "  - Tags: {$tags}\n";
            }
            
            $output .= "\n";
        }
        
        return $output;
    }

    public static function formatServerDetails(array $result): string
    {
        if (!$result['info']['success']) {
            return "Error: {$result['info']['message']}";
        }

        $info = $result['info']['response'];
        $stats = $result['stats']['response'] ?? null;
        $hardware = $result['hardware']['response'] ?? null;
        
        $status = $info['connected'] ? '🟢 Connected' : '🔴 Disconnected';
        $online = $info['online'] ? 'Online' : 'Offline';
        
        $output = "**Server Details: {$info['name']}** (ID: {$info['id']})\n\n";
        
        $output .= "**📊 Server Info:**\n";
        $output .= "• Status: {$status}\n";
        $output .= "• Online: {$online}\n";
        $output .= "• IP Address: {$info['ipAddress']}\n";
        $output .= "• Provider: {$info['provider']}\n";
        $output .= "• Stack: {$info['stack']}\n";
        $output .= "• Database: {$info['database']}\n";
        $output .= "• OS: {$info['os']} {$info['osVersion']}\n";
        $output .= "• Country: {$info['country_iso_code']}\n";
        $output .= "• PHP CLI: {$info['phpCLIVersion']}\n";
        $output .= "• Agent Version: {$info['agentVersion']}\n";
        $output .= "• Created: {$info['created_at']}\n";
        
        if (!empty($info['tags'])) {
            $tags = implode(', ', $info['tags']);
            $output .= "• Tags: {$tags}\n";
        }
        
        if ($stats) {
            $output .= "\n**📈 Statistics:**\n";
            $output .= "• Web Applications: {$stats['stats']['webApplication']}\n";
            $output .= "• Databases: {$stats['stats']['database']}\n";
            $output .= "• Cron Jobs: {$stats['stats']['cronJob']}\n";
            $output .= "• Supervisors: {$stats['stats']['supervisor']}\n";
            $output .= "• Country: {$stats['country']}\n";
        }
        
        if ($hardware) {
            $output .= "\n**🖥️ Hardware Info:**\n";
            $output .= "• Kernel: {$hardware['kernelVersion']}\n";
            $output .= "• Processor: {$hardware['processorName']}\n";
            $output .= "• CPU Cores: {$hardware['totalCPUCore']}\n";
            $output .= "• Memory: " . round($hardware['totalMemory'], 2) . "GB total, " . round($hardware['freeMemory'], 2) . "GB free\n";
            $output .= "• Disk: " . round($hardware['diskTotal'], 2) . "GB total, " . round($hardware['diskFree'], 2) . "GB free\n";
            $output .= "• Load Average: {$hardware['loadAvg']}\n";
            $output .= "• Uptime: {$hardware['uptime']}\n";
        }
        
        return $output;
    }

    public static function formatSystemUsers(array $result, string $serverId): string
    {
        if (!$result['success']) {
            return "Error: {$result['message']}";
        }

        $users = $result['response']['data'];
        $total = $result['response']['meta']['pagination']['total'];
        
        $output = "**System Users for Server ID {$serverId}** ({$total} total):\n\n";
        
        foreach ($users as $user) {
            $deleteable = $user['deleteable'] ? '❌ Deleteable' : '🔒 Protected';
            
            $output .= "• **{$user['username']}** (ID: {$user['id']})\n";
            $output .= "  - Status: {$deleteable}\n";
            $output .= "  - Created: {$user['created_at']}\n";
            
            if ($user['deploymentKey']) {
                $output .= "  - Has deployment key\n";
            }
            
            $output .= "\n";
        }
        
        return $output;
    }
}

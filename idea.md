# RCMCP Server - Prompt Ideas and Use Cases

## Server Management Prompts

1. **Server Overview**: "List all my RunCloud servers and show me their current status, including which ones are online, offline, or need security updates."

2. **Server Health Check**: "Find detailed information about server ID 5979 including system stats, hardware specs, and current resource usage."

3. **Multi-Cloud Inventory**: "Show me all servers grouped by provider (DigitalOcean, Vultr, AWS, etc.) and their geographical distribution."

4. **Server Security Audit**: "List all servers that have security updates available and show their agent versions."

5. **Resource Monitoring**: "Find server 1806 details and analyze its CPU, memory, and disk usage patterns."

6. **System Users Management**: "List all system users on server 37549 and show their access levels and permissions."

## Web Application Management Prompts

7. **WordPress Inventory**: "List all web applications on server 15609 and identify which ones are WordPress sites."

8. **PHP Version Audit**: "Show me all web applications and their PHP versions across all servers to identify outdated installations."

9. **Application Creation**: "Create a new web application called 'my-new-site' with domain 'example.com' on server 37549."

10. **WordPress Setup**: "Create a new WordPress web application called 'blog-site' with domain 'myblog.example.com' on server 5979."

11. **Stack Analysis**: "List all web applications and group them by stack type (nginx, apache, hybrid) and stack mode (production, staging)."

12. **Database-Linked Apps**: "Find all web applications that have associated databases and show their database connection details."

13. **Path Structure Review**: "Show me the root paths and public paths for all web applications on a specific server."

## Database Management Prompts

14. **Database Inventory**: "List all databases on server 5979 and show their creation dates and collation settings."

15. **Database Size Analysis**: "Show me all databases across servers and identify which ones might need optimization."

16. **Orphaned Database Check**: "Find databases that don't have associated web applications."

## Backup Management Prompts

17. **Backup Status Report**: "List all backups and show me which ones are active, failed, or archived, grouped by status."

18. **Backup Storage Analysis**: "Show me all backups and their storage locations (RunCloud, pCloud, S3) with size information."

19. **Failed Backup Investigation**: "Find all failed backups and show their configuration details to identify common issues."

20. **Backup Schedule Review**: "List all backups and show their frequency and retention settings to optimize backup strategies."

21. **Comprehensive Backup Creation**: "Create a full backup for web application 15292 and database 8243 with weekly frequency, monthly retention, stored on RunCloud, excluding development files and WordPress cache."

22. **Backup Filtering**: "Show me all backups for a specific server that are stored on external services like pCloud."

23. **Simple Web App Backup**: "Create a basic backup named 'daily-backup' for web application 15609 with default settings."

24. **Database-Only Backup**: "Create a backup named 'db-backup' for database 8515 with daily frequency and one week retention."

25. **Production Backup Setup**: "Create a production backup for web application 15292 named 'prod-backup' with weekly frequency, one month retention, excluding development files and WordPress cache, with success notifications enabled."

26. **Emergency Backup Creation**: "Create an immediate full backup named 'emergency-backup' for both web application 15609 and its associated database 8515."

27. **Custom Storage Backup**: "Create a backup named 'external-backup' for web application 15292 stored on pCloud with monthly frequency."

28. **Incremental Backup Setup**: "Create an incremental backup named 'incremental-daily' for web application 15609 with daily frequency and two weeks retention."

## Advanced Analysis Prompts

29. **Infrastructure Overview**: "Give me a complete overview of my infrastructure: total servers, their providers, web applications count, databases count, and backup status."

30. **Security Compliance Check**: "Analyze all servers for security updates, agent versions, and connection status to ensure compliance."

31. **Resource Optimization**: "Find servers with high resource usage and their associated web applications to identify optimization opportunities."

32. **Disaster Recovery Planning**: "Show me all servers, their backups, and identify which applications don't have proper backup coverage."

## Backup Strategy and Implementation Prompts

33. **Backup Strategy Implementation**: "Implement a comprehensive backup strategy: create daily incremental backups for all development apps and weekly full backups for production apps."

34. **Disaster Recovery Backup**: "Create disaster recovery backups for all critical applications with external storage (pCloud) and immediate execution."

35. **Compliance Backup Setup**: "Set up compliance backups with one year retention for web application 15609 and database 8515, stored externally with failure notifications."

36. **Automated Backup Chain**: "Create a backup chain: daily incremental backup named 'daily-inc', weekly full backup named 'weekly-full', and monthly archive backup named 'monthly-archive' for web application 15292."

## Maintenance and Monitoring Prompts

37. **Update Management**: "List all servers that need software or security updates and prioritize them by criticality."

38. **Geographic Distribution**: "Show me server distribution by country and identify potential latency issues for global applications."

39. **Version Standardization**: "Analyze PHP versions across all web applications and create an upgrade plan to standardize versions."

40. **Backup Health Monitoring**: "Create a backup health report showing success rates, storage usage, and potential issues."

41. **Application Lifecycle Management**: "Track web application creation dates and identify old applications that might need updates or decommissioning."

## Troubleshooting Prompts

42. **Connection Issues**: "Find all servers that are not connected or offline and show their last known status."

43. **Backup Failures**: "Investigate why backup 3942 failed and show its configuration details."

44. **Performance Analysis**: "Show server statistics for high-usage periods and correlate with web application performance."

45. **Configuration Drift**: "Compare server configurations across similar environments to identify inconsistencies."

## Reporting Prompts

46. **Monthly Infrastructure Report**: "Generate a comprehensive monthly report showing server health, backup status, application counts, and any issues."

47. **Cost Optimization Report**: "Analyze server distribution by provider and suggest potential cost optimizations."

48. **Capacity Planning**: "Review current server resources and application growth trends to plan for scaling."

49. **Compliance Dashboard**: "Create a security and compliance dashboard showing update status, backup coverage, and system health."

## Integration and Automation Ideas

50. **Automated Health Checks**: "Set up monitoring for servers that haven't been updated in 30+ days."

51. **Backup Validation**: "Verify all critical applications have proper backup configurations with appropriate frequency and retention."

## Usage Tips

- Use specific server IDs when you know them for faster queries
- Combine multiple tools to get comprehensive views (e.g., server details + web apps + databases)
- Filter results by provider, status, or other criteria for focused analysis
- Use the data for capacity planning, security auditing, and cost optimization
- Regular monitoring helps identify issues before they become critical

## Available Tool Parameters

### Server Tools:
- `list_servers`: No parameters needed
- `find_server`: Requires `id` (server ID)
- `list_system_users`: Requires `server_id`

### Web Application Tools:
- `list_web_applications`: Requires `server_id`
- `find_web_application`: Requires `server_id` and `web_app_id`
- `create_web_application`: Requires `server_id`, `name`, `domain_name`

### Database Tools:
- `list_databases`: Requires `server_id`

### Backup Tools:
- `list_backups`: Optional filters: `storage`, `search`, `server_id`, `status`, `sort_column`, `sort_direction`
- `find_backup`: Requires `id` (backup ID)
- `create_backup`: Requires `name`, `web_application_id` or `database_id`, plus optional configuration parameters

# RCMCP - RunCloud MCP Server

An implementation of the **RunCloud MCP (Model Context Protocol) Server** that enables AI assistants to manage RunCloud infrastructure through natural language interactions. This server exposes RunCloud's server management, web application deployment, database administration, and backup management capabilities through the MCP protocol.

## What This Project Does

RCMCP provides AI assistants with comprehensive RunCloud management tools, allowing you to:

### 🖥️ **Server Management**
- List all servers with status, provider, and resource information
- Get detailed server information including system stats and hardware specs
- Manage system users and permissions
- Monitor server health and resource usage

### 🌐 **Web Application Management** 
- List web applications across servers
- View detailed application configurations (domains, SSL, PHP versions)
- Create new web applications with custom configurations
- Monitor application status and stack information

### 🗄️ **Database Management**
- List databases across your infrastructure
- View database details including collation and creation dates
- Monitor database usage and configurations

### 💾 **Backup Management**
- List all backups with detailed status information
- Create new backups for web applications and databases
- Configure backup settings (frequency, retention, storage, notifications)
- Monitor backup status and manage backup policies

All interactions return AI-friendly formatted responses with clear bullet points, status indicators, and organized information that's easy for AI agents to understand and act upon.

## Available MCP Tools

The server includes **12 comprehensive tools** organized by functionality:

**Server Tools:**
- `list_servers` - List all RunCloud servers
- `find_server` - Get detailed server information  
- `list_system_users` - List system users for a server

**Web Application Tools:**
- `list_web_applications` - List web applications on a server
- `find_web_application` - Get detailed web application info
- `create_web_application` - Create new web applications

**Database Tools:**
- `list_databases` - List databases on a server

**Backup Tools:**
- `list_backups` - List all backups with filtering options
- `find_backup` - Get detailed backup information
- `create_backup` - Create new backups with custom configurations

## Getting Started

### Prerequisites
- PHP 8.4.11+
- Composer
- RunCloud account with API access

### Installation & Setup

1. **Clone and install dependencies:**
   ```bash
   git clone <repository-url>
   cd rcmcp
   composer install
   ```

2. **Setup environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configure RunCloud API credentials:**
   
   Add your RunCloud API credentials to `.env`:
   ```env
   API_ENDPOINT_URL="https://manage.runcloud.io/api/v3"
   API_TOKEN="your_runcloud_api_token_here"
   ```

   To get your API token:
   - Log in to your RunCloud dashboard
   - Go to Account Settings → API Keys
   - Create a new API key with appropriate permissions

4. **Test API connection:**
   ```bash
   php artisan api:check
   ```
   
   You should see: `✅ API connection successful.`

### Setup with AI Agents

#### **Google Gemini CLI**

1. **Install Gemini CLI:**
   ```bash
   npm install -g @google/gemini-cli
   ```

2. **Create MCP configuration:**
   
   Create the settings directory if it doesn't exist:
   ```bash
   mkdir -p ~/.gemini
   ```
   
   Then add the following configuration to `~/.gemini/settings.json`:
   ```json
   {
      "mcpServers": {
        "rcmcp": {
          "command": "php",
          "args": [
            "artisan",
            "mcp:start",
            "RCMCP"
          ],
          "cwd": "/full/path/to/rcmcp"
        }
      }
   }
   ```

3. **Check MCP in Gemini:**
   ```bash
   gemini 
   ```
   then run /mcp

### Verification

After setup, test the integration:

1. **Ask your AI assistant:** "List all my RunCloud servers"
2. **Try creating a backup:** "Create a backup for web application ID 123 with daily frequency"
3. **Check server details:** "Show me detailed information for server ID 456"

You should see formatted responses with server information, status indicators, and organized data.

## Example Usage

Once connected, you can ask your AI assistant questions like:

1. get me list of server name, ip, and cloud provider and connection status from RunCloud. 
2. get me list of server that disk storage is less than 5GB
3. create webapplication with name test-gemini in server "yoga staging vultr"
4. give me list of failed backup
5. create backup for web application that didn't have backup from server "yoga staging vultr"


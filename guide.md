# RCMCP Integration Guide

**RunCloud MCP Server** - Manage your RunCloud infrastructure through AI agents and applications.

## 🎯 **What is RCMCP?**

RCMCP is a Model Context Protocol (MCP) server that provides AI agents with direct access to RunCloud's server management capabilities. It enables natural language interactions with your RunCloud infrastructure through any MCP-compatible AI system.

## 🚀 **Quick Start**

### **For AI Agent Users**
If you use AI agents like Claude Desktop, add this MCP server to access your RunCloud infrastructure.

### **For Developers**
If you're building AI applications, integrate with our HTTP API to give your users RunCloud management capabilities.

---

## 📋 **Prerequisites**

- **RunCloud Account** with API access enabled
- **RunCloud API Token** from your account settings
- **AI Agent** or custom application that supports MCP protocol

### Getting Your RunCloud API Token

1. Log in to your [RunCloud Dashboard](https://manage.runcloud.io)
2. Go to **Account Settings** → **API Keys**
3. Create a new API key with appropriate permissions
4. Copy the token (starts with `rc_`)

---

## 🤖 **For AI Agent Users**

### **Claude Desktop Integration**

Add this to your Claude Desktop configuration:

**File:** `~/.config/claude-desktop/claude_desktop_config.json` (macOS/Linux) or `%APPDATA%/claude-desktop/claude_desktop_config.json` (Windows)

```json
{
  "mcpServers": {
    "rcmcp": {
      "command": "npx",
      "args": ["@modelcontextprotocol/http-client", "https://your-mcp-domain.com/mcp/rcmcp"],
      "env": {
        "MCP_API_TOKEN": "your_mcp_server_token_here"
      }
    }
  }
}
```

### **Google Gemini CLI Integration**

**File:** `~/.gemini/settings.json`

```json
{
  "mcpServers": {
    "rcmcp": {
      "command": "curl",
      "args": [
        "-X", "POST",
        "-H", "Authorization: Bearer YOUR_MCP_TOKEN",
        "-H", "X-RunCloud-Token: YOUR_RUNCLOUD_API_TOKEN",
        "-H", "Content-Type: application/json",
        "https://your-mcp-domain.com/mcp/rcmcp"
      ]
    }
  }
}
```

### **Using with Your AI Agent**

Once configured, you can ask your AI agent natural language questions:

```
"List all my RunCloud servers"

"Create a new web application called 'my-app' on server 'production-server-1'"

"Show me all failed backups"

"Get detailed information for server ID 12345"
```

**Important:** Your RunCloud API token is automatically included in the HTTP header, so you don't need to mention it in your prompts!

---

## 💻 **For Developers (API Integration)**

### **Base URL**
```
https://your-mcp-domain.com/mcp/rcmcp
```

### **Authentication**
```
Authorization: Bearer YOUR_MCP_SERVER_TOKEN
X-RunCloud-Token: USER_RUNCLOUD_API_TOKEN
Content-Type: application/json
```

### **Request Format**
```json
{
  "jsonrpc": "2.0",
  "id": 1,
  "method": "tools/call",
  "params": {
    "name": "TOOL_NAME",
    "arguments": {
      "param1": "value1",
      "param2": "value2"
    }
  }
}
```

### **Response Format**
```json
{
  "jsonrpc": "2.0",
  "id": 1,
  "result": {
    "content": [
      {
        "type": "text",
        "text": "Tool execution result here"
      }
    ]
  }
}
```

### **Error Handling**
```json
{
  "jsonrpc": "2.0",
  "id": 1,
  "error": {
    "code": -32000,
    "message": "RunCloud API token is required. Please provide your RunCloud API token in the X-RunCloud-Token header."
  }
}
```

---

## 🛠️ **Available Tools**

### **Server Management**

#### `list_servers`
List all RunCloud servers with details and status.

```json
{
  "name": "list_servers",
  "arguments": {}
}
```

**Headers required:**
```
X-RunCloud-Token: rc_your_token_here
```

#### `find_server`
Get detailed server information including stats and hardware details.

```json
{
  "name": "find_server",
  "arguments": {
    "runcloud_api_token": "rc_your_token_here",
    "id": "12345"
  }
}
```

#### `list_system_users`
List all system users for a specific server.

```json
{
  "name": "list_system_users",
  "arguments": {
    "runcloud_api_token": "rc_your_token_here",
    "id": "12345"
  }
}
```

### **Web Application Management**

#### `list_web_applications`
List all web applications on a server.

```json
{
  "name": "list_web_applications",
  "arguments": {
    "runcloud_api_token": "rc_your_token_here",
    "server_id": "12345"
  }
}
```

#### `find_web_application`
Get detailed web application information.

```json
{
  "name": "find_web_application",
  "arguments": {
    "runcloud_api_token": "rc_your_token_here",
    "server_id": "12345",
    "web_app_id": "67890"
  }
}
```

#### `create_web_application`
Create a new web application on a server.

```json
{
  "name": "create_web_application",
  "arguments": {
    "runcloud_api_token": "rc_your_token_here",
    "server_id": "12345",
    "name": "my-new-app",
    "domain_name": "example.com"
  }
}
```

### **Database Management**

#### `list_databases`
List all databases on a server.

```json
{
  "name": "list_databases",
  "arguments": {
    "runcloud_api_token": "rc_your_token_here",
    "server_id": "12345"
  }
}
```

### **Backup Management**

#### `list_backups`
List all backups with optional filtering.

```json
{
  "name": "list_backups",
  "arguments": {
    "runcloud_api_token": "rc_your_token_here",
    "storage": "runcloud",
    "status": "completed",
    "server_id": "12345"
  }
}
```

#### `find_backup`
Get detailed backup information.

```json
{
  "name": "find_backup",
  "arguments": {
    "runcloud_api_token": "rc_your_token_here",
    "id": "backup123"
  }
}
```

#### `create_backup`
Create a new backup with custom configuration.

```json
{
  "name": "create_backup",
  "arguments": {
    "runcloud_api_token": "rc_your_token_here",
    "name": "daily-backup",
    "web_application_id": "67890",
    "backup_type": "full",
    "storage": "runcloud",
    "frequency": "1 day",
    "retention": "1 month",
    "success_notification": true,
    "fail_notification": true
  }
}
```

---

## 🔧 **Implementation Examples**

### **Python Example**
```python
import requests
import json

class RunCloudMCP:
    def __init__(self, mcp_base_url, mcp_token, runcloud_token):
        self.base_url = mcp_base_url
        self.headers = {
            'Authorization': f'Bearer {mcp_token}',
            'X-RunCloud-Token': runcloud_token,
            'Content-Type': 'application/json'
        }

    def call_tool(self, tool_name, arguments):
        payload = {
            "jsonrpc": "2.0",
            "id": 1,
            "method": "tools/call",
            "params": {
                "name": tool_name,
                "arguments": arguments
            }
        }

        response = requests.post(self.base_url,
                               headers=self.headers,
                               json=payload)
        return response.json()

    def list_servers(self):
        return self.call_tool("list_servers", {})

    def create_webapp(self, server_id, name, domain):
        return self.call_tool("create_web_application", {
            "server_id": server_id,
            "name": name,
            "domain_name": domain
        })

# Usage
mcp = RunCloudMCP("https://your-domain.com/mcp/rcmcp", "your_mcp_token", "rc_your_runcloud_token")
servers = mcp.list_servers()
print(servers)
```

### **Node.js Example**
```javascript
class RunCloudMCP {
    constructor(baseUrl, mcpToken, runcloudToken) {
        this.baseUrl = baseUrl;
        this.headers = {
            'Authorization': `Bearer ${mcpToken}`,
            'X-RunCloud-Token': runcloudToken,
            'Content-Type': 'application/json'
        };
    }

    async callTool(toolName, arguments) {
        const payload = {
            jsonrpc: "2.0",
            id: 1,
            method: "tools/call",
            params: {
                name: toolName,
                arguments: arguments
            }
        };

        const response = await fetch(this.baseUrl, {
            method: 'POST',
            headers: this.headers,
            body: JSON.stringify(payload)
        });

        return await response.json();
    }

    async listServers() {
        return await this.callTool("list_servers", {});
    }

    async createWebapp(serverId, name, domain) {
        return await this.callTool("create_web_application", {
            server_id: serverId,
            name: name,
            domain_name: domain
        });
    }
}

// Usage
const mcp = new RunCloudMCP("https://your-domain.com/mcp/rcmcp", "your_mcp_token", "rc_your_runcloud_token");
const servers = await mcp.listServers();
console.log(servers);
```

---

## 🔒 **Security & Authentication**

### **Two Types of Tokens Required:**

1. **MCP Server Token** (`MCP_API_TOKEN`)
   - Used to authenticate with the RCMCP server
   - Set in environment variables or AI agent config
   - Shared among users of the same MCP instance

2. **RunCloud API Token** (`runcloud_api_token`)
   - Your personal RunCloud API token
   - Must be provided with EVERY tool call
   - Unique to each RunCloud account

### **Security Best Practices:**

- ✅ Never hardcode API tokens in your code
- ✅ Use environment variables for tokens
- ✅ Validate API responses for errors
- ✅ Implement proper error handling
- ✅ Use HTTPS for all requests
- ✅ Rotate tokens regularly

---

## 📊 **Usage Examples**

### **Common AI Agent Prompts**

```
"Show me all my RunCloud servers using token rc_abc123"

"Create a new web app called 'blog' with domain 'myblog.com' on my staging server using token rc_abc123"

"List all failed backups from the last week using my RunCloud token rc_abc123"

"Show me server stats for server ID 12345 using token rc_abc123"

"Create a daily backup for web application 'my-shop' with email notifications using token rc_abc123"
```

### **Developer Integration Patterns**

```python
# Pattern 1: Token per user
def handle_user_request(user_runcloud_token, action, params):
    mcp = RunCloudMCP(MCP_URL, MCP_TOKEN)
    return mcp.call_tool(action, params, user_runcloud_token)

# Pattern 2: Session-based requests
class UserSession:
    def __init__(self, runcloud_token):
        self.runcloud_token = runcloud_token
        self.mcp = RunCloudMCP(MCP_URL, MCP_TOKEN)

    def execute(self, tool_name, **kwargs):
        return self.mcp.call_tool(tool_name, kwargs, self.runcloud_token)
```

---

## 🐛 **Troubleshooting**

### **Common Issues**

**"RunCloud API token is required"**
- Ensure you're passing `runcloud_api_token` in every request
- Check that your token starts with `rc_`

**"Invalid Token" from RunCloud API**
- Verify your RunCloud API token is valid
- Check token permissions in RunCloud dashboard

**"Unauthorized" (401 error)**
- Check your MCP server authentication token
- Verify the `Authorization: Bearer` header is correct

**Connection timeouts**
- RunCloud API calls may take time for large operations
- Implement appropriate timeout handling in your code

### **Debug Mode**

Enable debug logging in your API calls to troubleshoot issues:

```python
import logging
logging.basicConfig(level=logging.DEBUG)

# Your MCP calls will now show detailed request/response info
```

---

## 📚 **Additional Resources**

- **RunCloud API Documentation:** https://runcloud.io/docs/api
- **Model Context Protocol Spec:** https://modelcontextprotocol.io/
- **RCMCP GitHub Repository:** [Your repo URL]
- **Demo Video:** [Your demo video URL]

---

## 🆘 **Support**

Need help? Here's how to get support:

1. **Check this guide first** - Most questions are answered here
2. **Test with curl** - Verify basic connectivity before complex integrations
3. **Check RunCloud API limits** - Ensure you're within rate limits
4. **Create an issue** - [Your GitHub issues URL]

---

## ⚡ **Rate Limits & Best Practices**

- **RunCloud API:** Respect RunCloud's rate limits (check their documentation)
- **Caching:** Cache server/app lists to reduce API calls
- **Error Handling:** Always handle API errors gracefully
- **Retry Logic:** Implement exponential backoff for failed requests
- **Bulk Operations:** Use batch requests where possible

---

**Happy automating!** 🚀
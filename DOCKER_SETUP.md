# Docker WordPress Development Environment

## Quick Start

### 1. Start the containers
```bash
docker-compose up -d
```

### 2. Access WordPress
- **WordPress Site**: http://localhost:8080
- **WordPress Admin**: http://localhost:8080/wp-admin
- **phpMyAdmin**: http://localhost:8081

### 3. Initial WordPress Setup
1. Go to http://localhost:8080
2. Complete the WordPress installation:
   - Site Title: Your choice
   - Username: admin
   - Password: Choose a strong password
   - Email: Your email

### 4. Activate the Theme
1. Go to http://localhost:8080/wp-admin
2. Navigate to **Appearance → Themes**
3. Activate **TahsinRahit Theme**

### 5. Configure Notion Integration
1. Go to **Travel History → Sync from Notion**
2. Enter your Notion API Key and Database ID
3. Click **Save Settings**
4. Click **Sync from Notion Now**

## Commands

### Start containers
```bash
docker-compose up -d
```

### Stop containers
```bash
docker-compose down
```

### View logs
```bash
docker-compose logs -f wordpress
```

### Restart WordPress
```bash
docker-compose restart wordpress
```

### Stop and remove everything (including data)
```bash
docker-compose down -v
```

### Access WordPress container shell
```bash
docker exec -it tahsinrahit_wp bash
```

### Check PHP syntax
```bash
docker exec tahsinrahit_wp php -l /var/www/html/wp-content/themes/tahsinrahit-theme/inc/notion-travel-sync.php
```

## Database Access

### phpMyAdmin
- URL: http://localhost:8081
- Server: db
- Username: root
- Password: rootpassword

### MySQL CLI
```bash
docker exec -it tahsinrahit_db mysql -u wordpress -pwordpress wordpress
```

## Troubleshooting

### Check WordPress errors
```bash
docker-compose logs wordpress
```

### Check PHP errors in the theme
```bash
docker exec tahsinrahit_wp tail -f /var/www/html/wp-content/debug.log
```

### Reset everything
```bash
docker-compose down -v
docker-compose up -d
```

## File Structure

The current directory is mounted as the theme:
```
/Users/rahit/MyLab/web → /var/www/html/wp-content/themes/tahsinrahit-theme
```

Any changes you make to files will be immediately reflected in the container.

## Ports

- **8080**: WordPress site
- **8081**: phpMyAdmin
- **3306**: MySQL (internal only)

## Environment Variables

You can add Notion credentials to the WordPress container by editing `docker-compose.yml`:

```yaml
wordpress:
  environment:
    NOTION_API_KEY: "your_api_key_here"
    NOTION_DATABASE_ID: "your_database_id_here"
```

Or configure them via the admin panel after setup.

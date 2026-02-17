# Notion Travel Integration - Setup Guide

## ✅ What's Been Installed

Your WordPress site now has a complete Notion integration for your travel timeline! Here's what was added:

1. **Notion API Integration** (`/inc/notion-travel-sync.php`)
   - Fetches data from your Notion database
   - Caches data for 1 hour to avoid API limits
   - Automatic hourly sync
   - Admin interface for manual sync

2. **Updated Date Fields** (`/inc/cpt-travel.php`)
   - Entry Date & Exit Date fields
   - Smart date formatting (e.g., "Jun — Aug 2024")

3. **Updated Travel Page** (`/page-travel.php`)
   - Priority 1: Notion database
   - Priority 2: WordPress Custom Post Type
   - Priority 3: Hardcoded fallback data

## 🚀 Setup Instructions (5 minutes)

### Step 1: Create Notion Integration

1. Go to https://www.notion.so/my-integrations
2. Click **"+ New integration"**
3. Give it a name: "WordPress Travel Sync"
4. Select your workspace
5. Click **"Submit"**
6. Copy the **"Internal Integration Token"** (starts with `secret_`)

### Step 2: Share Your Database

1. Open your Notion travel database
2. Click the **"⋯"** menu (top right)
3. Click **"Add connections"**
4. Search for "WordPress Travel Sync" (or whatever you named it)
5. Click to connect

### Step 3: Get Your Database ID

Your database ID is in the URL when viewing your database:

```
https://www.notion.so/[workspace]/[DATABASE_ID]?v=[view_id]
                                 ^^^^^^^^^^^^^^^^
                                 This is your Database ID
```

Example:
```
https://www.notion.so/myworkspace/a1b2c3d4e5f6g7h8i9j0?v=12345
                                  ^^^^^^^^^^^^^^^^^^^^
                                  Copy this part
```

### Step 4: Add Credentials to WordPress

1. Open your `wp-config.php` file (in your WordPress root directory)
2. Add these two lines **before** the line that says `/* That's all, stop editing! */`:

```php
define('NOTION_API_KEY', 'secret_YOUR_KEY_HERE');
define('NOTION_DATABASE_ID', 'YOUR_DATABASE_ID_HERE');
```

Replace:
- `secret_YOUR_KEY_HERE` with your actual integration token from Step 1
- `YOUR_DATABASE_ID_HERE` with your database ID from Step 3

### Step 5: Test the Integration

1. Log into WordPress Admin
2. Go to **Travel History → Sync from Notion**
3. You should see:
   - ✓ Notion API Key: Configured
   - ✓ Database ID: Configured
4. Click **"🔄 Sync from Notion Now"**
5. You should see a success message with the number of places synced
6. Preview your data in the table below

### Step 6: View Your Travel Page

Visit your travel page to see your Notion data displayed beautifully!

## 📊 Your Notion Database Structure

Based on your screenshot, your database has:

| Property | Type | Maps to |
|----------|------|---------|
| **Flag** | Text | Emoji flag |
| **Country** | Text | Country name |
| **City** | Title | City name |
| **Purpose** | Select | Type (Travel/Work/Conference/etc) |
| **From Date** | Date | Entry date |
| **To Date** | Date | Exit date |

This matches perfectly with the integration! ✅

## 🔄 How It Works

### Data Priority:
1. **Notion** (if configured) → Checks every hour
2. **WordPress CPT** (if Notion fails) → Manual entry
3. **Hardcoded data** (if both fail) → Fallback

### Automatic Sync:
- Runs every hour automatically
- Caches data to avoid API limits
- Manual sync available anytime

### Date Formatting:
Your dates will automatically format as:
- Same month: "Jun 2024"
- Same year: "Jun — Aug 2024"
- Different years: "Dec 2023 — Feb 2024"
- Ongoing: "Sep 2019 — Present"

## 🎯 Usage

### Adding a New Place in Notion:

1. Open your Notion database
2. Click **"+ New"**
3. Fill in:
   - **City** (Title field)
   - **Flag** (emoji, e.g., 🇯🇵)
   - **Country** (e.g., Japan)
   - **Purpose** (select from dropdown)
   - **From Date** (entry date)
   - **To Date** (exit date, or leave empty for "Present")
4. Save

Within 1 hour (or after manual sync), it will appear on your website!

## 🛠️ Admin Features

### Manual Sync:
- Go to **Travel History → Sync from Notion**
- Click **"🔄 Sync from Notion Now"**

### Force Refresh:
Add `?force_refresh=1` to your travel page URL to bypass cache

### View Cache Status:
Check **Travel History → Sync from Notion** to see:
- Configuration status
- Number of cached places
- Auto-sync status
- Preview of synced data

## 🔍 Troubleshooting

### "Notion API credentials not configured"
- Make sure you added the defines to `wp-config.php`
- Check for typos in the API key and Database ID

### "Notion API returned status: 401"
- Your API key is incorrect
- Regenerate the integration token in Notion

### "Notion API returned status: 404"
- Your Database ID is incorrect
- Make sure you shared the database with your integration

### No data showing
1. Check **Travel History → Sync from Notion**
2. Look for error messages
3. Verify your Notion database has data
4. Try manual sync

### Data not updating
- Cache refreshes every hour
- Use manual sync for immediate updates
- Check that your Notion database is shared with the integration

## 📝 Notes

- **API Rate Limits**: Notion allows 3 requests per second. The integration caches data to stay well within limits.
- **Security**: Your API key is stored in `wp-config.php`, which is not publicly accessible.
- **Fallback**: If Notion is down or misconfigured, your site will still work using WordPress data or hardcoded fallback.

## 🎉 You're All Set!

Once configured, you can manage your entire travel history from Notion, and it will automatically sync to your website every hour!

**Questions?** Check the admin page at **Travel History → Sync from Notion** for status and diagnostics.

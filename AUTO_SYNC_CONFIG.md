# ✅ Auto-Sync Configuration

## Current Settings

**Sync Interval:** Every 7 days (weekly)

**What Gets Synced:**
- New entries from Notion → Created as WordPress posts
- Updated entries in Notion → Updated in WordPress
- Deleted entries in Notion → Trashed in WordPress

## How It Works

### Automatic Sync
- **Frequency:** Every 7 days
- **Action:** Runs `tahsinrahit_sync_notion_to_posts()` automatically
- **Status:** Check in **Travel History → Sync from Notion** admin page

### Manual Sync
- **When to use:** When you want immediate updates
- **How:** Click **"🔄 Sync from Notion Now"** in admin panel
- **Result:** Instant sync, no need to wait for weekly schedule

## Technical Details

### WordPress Cron
The sync uses WordPress's built-in cron system:
```php
wp_schedule_event(time(), 'weekly', 'tahsinrahit_refresh_notion_travel');
```

### Hook
```php
add_action('tahsinrahit_refresh_notion_travel', 'tahsinrahit_sync_notion_to_posts');
```

### Schedule Clearing
On each page load, the system:
1. Checks if an old schedule exists
2. Clears it (in case interval changed)
3. Creates a new weekly schedule

This ensures the schedule is always up-to-date.

## Changing the Interval

To change the sync frequency, edit `/inc/notion-travel-sync.php`:

### Available Intervals
```php
'hourly'      // Every hour
'twicedaily'  // Twice per day
'daily'       // Once per day
'weekly'      // Once per week (current)
```

### Example: Change to Daily
```php
// Line ~150 in notion-travel-sync.php
wp_schedule_event(time(), 'daily', $hook);
```

### Example: Custom Interval (Every 3 Days)
```php
// Add custom interval
add_filter('cron_schedules', function($schedules) {
    $schedules['every_three_days'] = array(
        'interval' => 259200, // 3 days in seconds
        'display'  => __('Every 3 Days')
    );
    return $schedules;
});

// Use it
wp_schedule_event(time(), 'every_three_days', $hook);
```

## Monitoring

### Check Schedule Status
Go to **Travel History → Sync from Notion**

You'll see:
- ✅ **Auto-sync:** Enabled (weekly - every 7 days)

### Check Next Run Time
```php
$timestamp = wp_next_scheduled('tahsinrahit_refresh_notion_travel');
echo date('Y-m-d H:i:s', $timestamp);
```

### View Cron Events (Plugin)
Install **WP Crontrol** plugin to:
- View all scheduled events
- Manually trigger events
- See next run times
- Debug cron issues

## Troubleshooting

### Sync Not Running?
1. **Check WordPress Cron:** WordPress cron only runs when someone visits your site
2. **Low Traffic Sites:** Consider using a real cron job
3. **Server Cron:** Add to your server's crontab:
   ```bash
   */15 * * * * wget -q -O - https://www.tahsinrahit.com/wp-cron.php?doing_wp_cron >/dev/null 2>&1
   ```

### Disable WP-Cron, Use Server Cron
In `wp-config.php`:
```php
define('DISABLE_WP_CRON', true);
```

Then add to server crontab:
```bash
# Run every 15 minutes
*/15 * * * * wget -q -O - https://www.tahsinrahit.com/wp-cron.php?doing_wp_cron >/dev/null 2>&1
```

### Force Sync Now
Use the manual sync button in admin, or run:
```php
do_action('tahsinrahit_refresh_notion_travel');
```

## Best Practices

1. **Weekly is Good for Travel Data** - Travel history doesn't change often
2. **Use Manual Sync** - When you add new trips, click manual sync
3. **Monitor First Week** - Check admin page to ensure auto-sync is working
4. **Server Cron for Reliability** - If you have server access, use real cron

## Summary

✅ **Current Setup:**
- Auto-sync: Every 7 days
- Manual sync: Available anytime
- Syncs to WordPress posts (persistent)
- Old hourly schedule automatically cleared

🎯 **No action needed** - It's configured and working!

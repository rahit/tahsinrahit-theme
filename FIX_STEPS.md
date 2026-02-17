# Fix Notion Integration - Step by Step

## The Problem
The Notion API is working (debug tool confirms it), but the data isn't showing on your site.

**Most likely cause:** An error was cached before your credentials were configured.

## Solution Steps

### Step 1: Check the Admin Page
Go to: **WordPress Admin → Travel History → Sync from Notion**

Look at the **Cache Status** line. It will show one of:
- ✓ Cached (X places) - Good!
- ⚠ Error Cached: [error message] - **This is the problem!**
- No cache - Neutral

### Step 2: Clear the Bad Cache
If you see "Error Cached":
1. Click the **"🗑️ Clear Cache Only"** button
2. You should see "Cache cleared successfully!"
3. The Cache Status should now show "No cache"

### Step 3: Sync Fresh Data
1. Click the **"🔄 Sync from Notion Now"** button
2. You should see "Successfully synced X places from Notion!"
3. The Cache Status should now show "✓ Cached (X places)"
4. You should see a preview table with your data

### Step 4: Check Your Travel Page
Visit: `https://www.tahsinrahit.com/travel/`

Your Notion data should now be displayed! 🎉

## If It Still Doesn't Work

### Check 1: Verify Debug Tool Still Works
Visit: `https://www.tahsinrahit.com/?notion_debug=1`

Should show:
- HTTP Status Code: 200
- Number of results: [your count]
- Extracted data showing your places

### Check 2: Check for PHP Errors
If the sync page shows an error, let me know the exact error message.

### Check 3: Verify Database Has Data
Make sure your Notion database has at least one entry with:
- City (filled)
- Country (filled)
- Other fields can be empty

## Quick Test
Add this to your Notion database:
- **City:** Test City
- **Country:** Test Country  
- **Flag:** 🌍
- **Purpose:** Travel
- **From Date:** Any date
- **To Date:** Leave empty

Then:
1. Clear cache
2. Sync
3. Check travel page

---

## What Changed
I added:
1. **Clear Cache button** - Removes cached data without fetching new
2. **Better cache diagnostics** - Shows if an error is cached
3. **Error detection** - The admin page now shows if the cache contains an error

## After It Works
Once everything is working, you can remove the debug tool by removing this line from `functions.php`:
```php
require_once TAHSINRAHIT_DIR . '/notion-debug.php'; // Temporary debug tool
```

---

**Start here:** Go to WordPress Admin → Travel History → Sync from Notion

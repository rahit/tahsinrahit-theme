# Debugging Notion Integration - Quick Guide

## The Problem
Configuration shows as correct, but 0 places are being fetched from Notion.

## Debug Steps

### Step 1: Run the Debug Tool

Visit this URL in your browser (while logged in as admin):
```
https://yoursite.com/?notion_debug=1
```

This will show you:
1. ✅ Configuration status
2. 🔍 Actual API response from Notion
3. 📊 What data is being returned
4. ❌ Any errors

### Step 2: Check Common Issues

Based on what the debug tool shows, here are common problems:

#### Issue 1: Empty Database
**Symptom:** Debug shows "Database is empty" or 0 results
**Solution:** Add at least one entry to your Notion database

#### Issue 2: Database Not Shared
**Symptom:** HTTP Status 404 or "object not found"
**Solution:** 
1. Open your Notion database
2. Click "..." menu → "Add connections"
3. Select your integration
4. Try debug again

#### Issue 3: Wrong Database ID
**Symptom:** HTTP Status 404
**Solution:**
1. Open your database in Notion
2. Copy the URL
3. Extract the ID (32 characters, no dashes)
   ```
   https://notion.so/workspace/XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX?v=...
                              ^^^^^^^^ This part (32 chars)
   ```

#### Issue 4: Invalid API Key
**Symptom:** HTTP Status 401 (Unauthorized)
**Solution:**
1. Go to https://www.notion.so/my-integrations
2. Find your integration
3. Click "Show" next to Internal Integration Token
4. Copy the full token (starts with `secret_`)
5. Update in wp-config.php

#### Issue 5: Property Names Don't Match
**Symptom:** Debug shows results but extracted data is empty
**Solution:** The debug tool will show you the actual property names in your database. Compare them with what the code expects:

Expected properties:
- `City` (Title field)
- `Country` (Text field)
- `Flag` (Text field)
- `Purpose` (Select field)
- `From Date` (Date field)
- `To Date` (Date field)

If your property names are different, we need to update the code.

### Step 3: Check Your Database Structure

Make sure your Notion database has these exact property names (case-sensitive):

| Property Name | Type | Example |
|---------------|------|---------|
| City | Title | Tokyo |
| Country | Text | Japan |
| Flag | Text | 🇯🇵 |
| Purpose | Select | Travel |
| From Date | Date | 2024-06-15 |
| To Date | Date | 2024-06-20 |

### Step 4: Test with Sample Data

Add one test entry to your Notion database:
- **City:** Test City
- **Country:** Test Country
- **Flag:** 🌍
- **Purpose:** Travel
- **From Date:** Today's date
- **To Date:** Leave empty

Then run the debug tool again.

## What to Look For in Debug Output

### ✅ Good Output:
```
HTTP Status Code: 200
✓ API call successful!
Number of results: 5

First Result Properties:
Available properties:
  - City (type: title)
  - Country (type: rich_text)
  - Flag (type: rich_text)
  - Purpose (type: select)
  - From Date (type: date)
  - To Date (type: date)

Extracted Data from First Result:
City: Tokyo
Country: Japan
Flag: 🇯🇵
Purpose: Travel
From Date: 2024-06-15
To Date: 2024-06-20
```

### ❌ Bad Output Examples:

**Empty Database:**
```
Number of results: 0
⚠ Database is empty!
```
→ Add entries to your Notion database

**Not Shared:**
```
HTTP Status Code: 404
✗ API call failed
Response body: {"object":"error","status":404}
```
→ Share database with integration

**Wrong API Key:**
```
HTTP Status Code: 401
✗ API call failed
```
→ Check your API key in wp-config.php

**Property Name Mismatch:**
```
City: NOT FOUND or EMPTY
Country: NOT FOUND or EMPTY
```
→ Property names don't match (see Step 5 below)

## Step 5: If Property Names Are Different

If the debug shows your properties have different names, let me know what they are and I'll update the code to match.

For example, if your database uses:
- "Location" instead of "City"
- "Nation" instead of "Country"
- etc.

Just tell me the actual names and I'll fix the mapping.

## After Debugging

Once the debug tool shows data correctly:
1. Go back to WP Admin → Travel History → Sync from Notion
2. Click "Sync from Notion Now"
3. You should see the data!

## Remove Debug Tool Later

Once everything works, remove this line from functions.php:
```php
require_once TAHSINRAHIT_DIR . '/notion-debug.php'; // Temporary debug tool
```

---

## Quick Checklist

- [ ] Database has at least one entry
- [ ] Database is shared with integration
- [ ] API key is correct (starts with `secret_`)
- [ ] Database ID is correct (32 characters)
- [ ] Property names match exactly
- [ ] Debug tool shows HTTP 200
- [ ] Debug tool shows extracted data

**Run the debug tool now:** `yoursite.com/?notion_debug=1`

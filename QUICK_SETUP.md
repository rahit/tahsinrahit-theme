# Quick Setup - Notion Travel Integration

## 1️⃣ Create Integration (2 min)
→ https://www.notion.so/my-integrations
- Click "+ New integration"
- Name: "WordPress Travel Sync"
- Copy the token (starts with `secret_`)

## 2️⃣ Share Database (30 sec)
- Open your travel database in Notion
- Click "⋯" → "Add connections"
- Select "WordPress Travel Sync"

## 3️⃣ Get Database ID (30 sec)
From your database URL:
```
https://www.notion.so/workspace/a1b2c3d4e5f6?v=...
                                ^^^^^^^^^^^^
                                Copy this
```

## 4️⃣ Add to wp-config.php (1 min)
Add before `/* That's all, stop editing! */`:

```php
define('NOTION_API_KEY', 'secret_YOUR_TOKEN_HERE');
define('NOTION_DATABASE_ID', 'YOUR_DATABASE_ID_HERE');
```

## 5️⃣ Test (1 min)
WordPress Admin → **Travel History → Sync from Notion**
Click "🔄 Sync from Notion Now"

## ✅ Done!
Your Notion database now syncs automatically every hour!

---

## Your Notion Database Fields:
- **City** (Title) → City name
- **Flag** (Text) → 🇯🇵 emoji
- **Country** (Text) → Country name  
- **Purpose** (Select) → Travel/Work/Conference/etc
- **From Date** (Date) → Entry date
- **To Date** (Date) → Exit date (empty = "Present")

## Manual Sync:
WP Admin → Travel History → Sync from Notion → Click sync button

## Troubleshooting:
See `NOTION_SETUP_GUIDE.md` for detailed help

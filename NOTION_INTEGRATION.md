# Notion Integration for Travel Timeline

## Overview
Yes, it's **absolutely possible and feasible** to pull data from a Notion database and display it on your travel timeline. Here are the two main approaches:

## Approach 1: Notion API Integration (Recommended)

### How it works:
- Use Notion's official API to fetch data from your Notion database
- Create a WordPress plugin or add code to your theme's `functions.php`
- Cache the data to avoid hitting API rate limits
- Automatically sync on a schedule (e.g., hourly or daily)

### Pros:
- Real-time or near-real-time updates
- Single source of truth (Notion)
- Easy to update from mobile/anywhere
- Can leverage Notion's powerful database features

### Cons:
- Requires API setup and authentication
- Need to handle caching and rate limits
- Slightly more complex initial setup

### Implementation Steps:

1. **Create a Notion Integration:**
   - Go to https://www.notion.so/my-integrations
   - Create a new integration
   - Get your API key

2. **Share your database with the integration:**
   - Open your Notion travel database
   - Click "Share" → Add your integration

3. **Add this code to your theme:**

```php
// In functions.php or a custom plugin

// Store Notion credentials
define('NOTION_API_KEY', 'your_secret_key_here');
define('NOTION_DATABASE_ID', 'your_database_id_here');

// Function to fetch from Notion
function fetch_travel_places_from_notion() {
    $transient_key = 'notion_travel_places';
    
    // Check cache first (1 hour)
    $cached = get_transient($transient_key);
    if ($cached !== false) {
        return $cached;
    }
    
    // Fetch from Notion API
    $response = wp_remote_post(
        'https://api.notion.com/v1/databases/' . NOTION_DATABASE_ID . '/query',
        array(
            'headers' => array(
                'Authorization' => 'Bearer ' . NOTION_API_KEY,
                'Notion-Version' => '2022-06-28',
                'Content-Type' => 'application/json',
            ),
            'body' => json_encode(array(
                'sorts' => array(
                    array(
                        'property' => 'Entry Date',
                        'direction' => 'ascending'
                    )
                )
            ))
        )
    );
    
    if (is_wp_error($response)) {
        return array();
    }
    
    $body = json_decode(wp_remote_retrieve_body($response), true);
    $places = array();
    
    foreach ($body['results'] as $page) {
        $props = $page['properties'];
        
        $places[] = array(
            'emoji'   => $props['Emoji']['rich_text'][0]['plain_text'] ?? '',
            'city'    => $props['City']['title'][0]['plain_text'] ?? '',
            'country' => $props['Country']['rich_text'][0]['plain_text'] ?? '',
            'entry_date' => $props['Entry Date']['date']['start'] ?? '',
            'exit_date' => $props['Exit Date']['date']['start'] ?? '',
            'type'    => $props['Type']['select']['name'] ?? '',
        );
    }
    
    // Cache for 1 hour
    set_transient($transient_key, $places, HOUR_IN_SECONDS);
    
    return $places;
}

// Add WP-CLI command to manually refresh
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('notion refresh-travel', function() {
        delete_transient('notion_travel_places');
        $places = fetch_travel_places_from_notion();
        WP_CLI::success('Refreshed ' . count($places) . ' travel places from Notion');
    });
}

// Optional: Auto-refresh hourly
add_action('init', function() {
    if (!wp_next_scheduled('refresh_notion_travel')) {
        wp_schedule_event(time(), 'hourly', 'refresh_notion_travel');
    }
});

add_action('refresh_notion_travel', function() {
    delete_transient('notion_travel_places');
    fetch_travel_places_from_notion();
});
```

4. **Update page-travel.php to use Notion data:**

```php
// Replace the WP_Query section with:
$places_from_notion = fetch_travel_places_from_notion();

if (!empty($places_from_notion)) {
    $places = array();
    foreach ($places_from_notion as $place) {
        $places[] = array(
            'emoji'   => $place['emoji'],
            'city'    => $place['city'],
            'country' => $place['country'],
            'year'    => tahsinrahit_format_travel_dates($place['entry_date'], $place['exit_date']),
            'type'    => $place['type'],
        );
    }
}
// Otherwise fall back to WordPress CPT or hardcoded data
```

### Notion Database Structure:
Create a database in Notion with these properties:
- **City** (Title)
- **Country** (Text)
- **Emoji** (Text)
- **Entry Date** (Date)
- **Exit Date** (Date)
- **Type** (Select: Travel, Conference, Work, Home, Origin, Transit)

---

## Approach 2: Notion Export + Manual Sync

### How it works:
- Export your Notion database as CSV
- Upload to WordPress and import into the Custom Post Type
- Use a plugin like WP All Import

### Pros:
- No API complexity
- Works offline
- Simple setup

### Cons:
- Manual process
- Not real-time
- More steps to update

---

## Recommendation

**Use Approach 1 (Notion API)** if you:
- Update your travel data frequently
- Want to manage everything from Notion
- Are comfortable with a bit of code setup

**Use the current WordPress CPT** if you:
- Prefer managing data directly in WordPress
- Don't update travel data very often
- Want the simplest solution

---

## Hybrid Approach (Best of Both Worlds)

You could also:
1. Keep the WordPress Custom Post Type
2. Add a "Sync from Notion" button in the admin
3. Manually trigger sync when you update Notion
4. This gives you flexibility and control

Would you like me to implement the Notion API integration for you?

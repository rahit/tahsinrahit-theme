<?php
/**
 * Notion Cache Test & Clear
 * 
 * Upload to WordPress root and visit: yoursite.com/test-notion.php
 */

define('WP_USE_THEMES', false);
require('./wp-load.php');

if (!current_user_can('manage_options')) {
    die('You must be logged in as admin.');
}

echo '<html><head><title>Notion Cache Test</title></head><body style="font-family: monospace; padding: 20px;">';
echo '<h1>Notion Cache Test & Debug</h1>';

// Check current cache
echo '<h2>1. Current Cache Status</h2>';
$cached = get_transient('notion_travel_places_cache');
echo '<pre>';
if ($cached === false) {
    echo 'Cache: EMPTY (no cache exists)' . "\n";
} else {
    echo 'Cache: EXISTS' . "\n";
    echo 'Type: ' . gettype($cached) . "\n";
    if (is_array($cached)) {
        echo 'Count: ' . count($cached) . ' places' . "\n";
        echo 'Data: ' . print_r($cached, true) . "\n";
    } elseif (is_wp_error($cached)) {
        echo 'ERROR CACHED: ' . $cached->get_error_message() . "\n";
    }
}
echo '</pre>';

// Clear cache
echo '<h2>2. Clearing Cache</h2>';
delete_transient('notion_travel_places_cache');
echo '<p style="color: green;">✓ Cache cleared!</p>';

// Fetch fresh data
echo '<h2>3. Fetching Fresh Data from Notion</h2>';
$fresh_data = tahsinrahit_fetch_from_notion();
echo '<pre>';
if (is_wp_error($fresh_data)) {
    echo '<strong style="color: red;">ERROR:</strong> ' . $fresh_data->get_error_message() . "\n";
} else {
    echo '<strong style="color: green;">SUCCESS!</strong>' . "\n";
    echo 'Type: ' . gettype($fresh_data) . "\n";
    echo 'Count: ' . count($fresh_data) . ' places' . "\n";
    echo "\n" . 'Data:' . "\n";
    echo print_r($fresh_data, true);
}
echo '</pre>';

// Check cache again
echo '<h2>4. Cache After Fetch</h2>';
$cached_after = get_transient('notion_travel_places_cache');
echo '<pre>';
if ($cached_after === false) {
    echo 'Cache: EMPTY' . "\n";
} else {
    echo 'Cache: EXISTS' . "\n";
    echo 'Count: ' . count($cached_after) . ' places' . "\n";
}
echo '</pre>';

echo '<hr>';
echo '<p><a href="' . admin_url('edit.php?post_type=travel_place&page=notion-travel-sync') . '">Go to Notion Sync Page</a></p>';
echo '<p><a href="' . home_url('/travel/') . '">View Travel Page</a></p>';
echo '</body></html>';

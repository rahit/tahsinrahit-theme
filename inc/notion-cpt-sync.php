<?php
/**
 * Notion to WordPress CPT Sync
 * Syncs Notion database entries as WordPress posts
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Sync travel places from Notion to WordPress posts
 */
function tahsinrahit_sync_notion_to_posts()
{
    // Check if credentials are configured - check options first, then constants
    $api_key = get_option('notion_api_key', '');
    $database_id = get_option('notion_database_id', '');

    // Fallback to constants if options are empty
    if (empty($api_key) && defined('NOTION_API_KEY')) {
        $api_key = NOTION_API_KEY;
    }
    if (empty($database_id) && defined('NOTION_DATABASE_ID')) {
        $database_id = NOTION_DATABASE_ID;
    }

    if (empty($api_key) || empty($database_id)) {
        return new WP_Error('notion_config', 'Notion API credentials not configured');
    }

    // Fetch from Notion API
    $response = wp_remote_post(
        'https://api.notion.com/v1/databases/' . $database_id . '/query',
        array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Notion-Version' => '2022-06-28',
                'Content-Type' => 'application/json',
            ),
            'body' => json_encode(array(
                'sorts' => array(
                    array(
                        'property' => 'From Date',
                        'direction' => 'descending'
                    )
                )
            )),
            'timeout' => 15
        )
    );

    if (is_wp_error($response)) {
        $error_msg = 'Notion API Error: ' . $response->get_error_message();
        error_log($error_msg);
        return new WP_Error('notion_api', $error_msg);
    }

    $status_code = wp_remote_retrieve_response_code($response);
    $raw_body = wp_remote_retrieve_body($response);

    if ($status_code !== 200) {
        $error_msg = 'Notion API returned status ' . $status_code . ': ' . $raw_body;
        error_log($error_msg);
        return new WP_Error('notion_api', $error_msg);
    }

    $body = json_decode($raw_body, true);

    if (!isset($body['results'])) {
        error_log('Notion API: Invalid response structure');
        return new WP_Error('notion_response', 'Invalid Notion API response');
    }

    $synced_count = 0;
    $updated_count = 0;
    $notion_ids = array();

    foreach ($body['results'] as $page) {
        $props = $page['properties'];
        $notion_id = $page['id'];
        $notion_ids[] = $notion_id;

        // Extract data - CORRECTED based on actual API structure
        // City is rich_text type
        $city = '';
        if (isset($props['City']['rich_text']) && !empty($props['City']['rich_text'])) {
            $city = $props['City']['rich_text'][0]['plain_text'] ?? '';
        }

        // Country is title type
        $country = '';
        if (isset($props['Country']['title']) && !empty($props['Country']['title'])) {
            $country = $props['Country']['title'][0]['plain_text'] ?? '';
        }

        $flag = '';
        if (isset($props['Flag']['rich_text']) && !empty($props['Flag']['rich_text'])) {
            $flag = $props['Flag']['rich_text'][0]['plain_text'] ?? '';
        }

        $purpose = '';
        if (isset($props['Purpose']['select']['name'])) {
            $purpose = $props['Purpose']['select']['name'];
        }

        $from_date = '';
        if (isset($props['From Date']['date']['start'])) {
            $from_date = $props['From Date']['date']['start'];
        }

        $to_date = '';
        if (isset($props['To Date']['date']['start'])) {
            $to_date = $props['To Date']['date']['start'];
        }

        // Photos (URL field - supports comma separated values)
        $photos = array();
        $photos_str = '';

        // Check for 'url' type (standard URL field)
        if (isset($props['Photos']['url']) && !empty($props['Photos']['url'])) {
            $photos_str = $props['Photos']['url'];
        }
        // Fallback: Check for 'rich_text' type (Text field) just in case
        elseif (isset($props['Photos']['rich_text']) && !empty($props['Photos']['rich_text'])) {
            $photos_str = $props['Photos']['rich_text'][0]['plain_text'] ?? '';
        }

        if (!empty($photos_str)) {
            // Split by comma, trim whitespace
            $urls = explode(',', $photos_str);
            foreach ($urls as $url) {
                $url = trim($url);
                if (!empty($url)) {
                    $photos[] = $url;
                }
            }
        }

        // Skip if missing required fields
        if (empty($city) || empty($country)) {
            continue;
        }

        // Check if post already exists with this Notion ID
        $existing = get_posts(array(
            'post_type' => 'travel_place',
            'meta_key' => '_notion_id',
            'meta_value' => $notion_id,
            'posts_per_page' => 1,
            'post_status' => 'any'
        ));

        if (!empty($existing)) {
            // Update existing post
            $post_id = $existing[0]->ID;
            wp_update_post(array(
                'ID' => $post_id,
                'post_title' => $city,
                'post_status' => 'publish'
            ));
            $updated_count++;
        } else {
            // Create new post
            $post_id = wp_insert_post(array(
                'post_type' => 'travel_place',
                'post_title' => $city,
                'post_status' => 'publish',
                'post_author' => 1
            ));
            $synced_count++;
        }

        if ($post_id && !is_wp_error($post_id)) {
            // Clear object cache for this post to ensure fresh data
            wp_cache_delete($post_id, 'post_meta');

            // Update meta fields
            update_post_meta($post_id, '_notion_id', $notion_id);
            update_post_meta($post_id, '_travel_country', $country);
            update_post_meta($post_id, '_travel_emoji', $flag);
            update_post_meta($post_id, '_travel_type', $purpose);
            update_post_meta($post_id, '_travel_entry_date', $from_date);
            update_post_meta($post_id, '_travel_exit_date', $to_date);

            // Force update photos by deleting old value first
            delete_post_meta($post_id, '_travel_photos');
            update_post_meta($post_id, '_travel_photos', $photos); // Save photos array

            update_post_meta($post_id, '_synced_from_notion', current_time('mysql'));
        }
    }

    // Optional: Delete posts that no longer exist in Notion
    $all_notion_posts = get_posts(array(
        'post_type' => 'travel_place',
        'meta_key' => '_notion_id',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'post_status' => 'any'
    ));

    $deleted_count = 0;
    foreach ($all_notion_posts as $post_id) {
        $notion_id = get_post_meta($post_id, '_notion_id', true);
        if (!in_array($notion_id, $notion_ids)) {
            // This post no longer exists in Notion, trash it
            wp_trash_post($post_id);
            $deleted_count++;
        }
    }

    return array(
        'synced' => $synced_count,
        'updated' => $updated_count,
        'deleted' => $deleted_count,
        'total' => $synced_count + $updated_count
    );
}

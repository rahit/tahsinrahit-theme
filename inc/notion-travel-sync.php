<?php
/**
 * Notion Travel Database Integration
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit;
}

// Configuration - Add these to wp-config.php or define here
// define('NOTION_API_KEY', 'secret_xxxxxxxxxxxxx');
// define('NOTION_DATABASE_ID', 'xxxxxxxxxxxxx');

/**
 * Fetch travel places from Notion database
 */
function tahsinrahit_fetch_from_notion()
{
    // Check if credentials are configured
    if (!defined('NOTION_API_KEY') || !defined('NOTION_DATABASE_ID')) {
        return new WP_Error('notion_config', 'Notion API credentials not configured');
    }

    $transient_key = 'notion_travel_places_cache';

    // Check cache first (1 hour)
    $cached = get_transient($transient_key);
    if ($cached !== false && !isset($_GET['force_refresh'])) {
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
                        'property' => 'From Date',
                        'direction' => 'descending'
                    )
                )
            )),
            'timeout' => 15
        )
    );

    if (is_wp_error($response)) {
        error_log('Notion API Error: ' . $response->get_error_message());
        return $response;
    }

    $status_code = wp_remote_retrieve_response_code($response);
    if ($status_code !== 200) {
        error_log('Notion API returned status: ' . $status_code);
        return new WP_Error('notion_api', 'Notion API returned status: ' . $status_code);
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);

    if (!isset($body['results'])) {
        error_log('Notion API: Invalid response structure');
        return new WP_Error('notion_response', 'Invalid Notion API response');
    }

    $places = array();

    foreach ($body['results'] as $page) {
        $props = $page['properties'];

        // Extract data based on your Notion structure
        $city = '';
        if (isset($props['City']['title']) && !empty($props['City']['title'])) {
            $city = $props['City']['title'][0]['plain_text'] ?? '';
        }

        $country = '';
        if (isset($props['Country']['rich_text']) && !empty($props['Country']['rich_text'])) {
            $country = $props['Country']['rich_text'][0]['plain_text'] ?? '';
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

        // Only add if we have at least city and country
        if (!empty($city) && !empty($country)) {
            $places[] = array(
                'emoji' => $flag,
                'city' => $city,
                'country' => $country,
                'entry_date' => $from_date,
                'exit_date' => $to_date,
                'type' => $purpose,
            );
        }
    }

    // Cache for 1 hour
    set_transient($transient_key, $places, HOUR_IN_SECONDS);

    return $places;
}

/**
 * Clear Notion cache
 */
function tahsinrahit_clear_notion_cache()
{
    delete_transient('notion_travel_places_cache');
}

/**
 * Schedule automatic refresh
 */
function tahsinrahit_schedule_notion_sync()
{
    if (!wp_next_scheduled('tahsinrahit_refresh_notion_travel')) {
        wp_schedule_event(time(), 'hourly', 'tahsinrahit_refresh_notion_travel');
    }
}
add_action('init', 'tahsinrahit_schedule_notion_sync');

/**
 * Hourly refresh hook
 */
add_action('tahsinrahit_refresh_notion_travel', 'tahsinrahit_clear_notion_cache');

/**
 * Add admin menu for manual sync
 */
function tahsinrahit_notion_admin_menu()
{
    add_submenu_page(
        'edit.php?post_type=travel_place',
        'Sync from Notion',
        'Sync from Notion',
        'manage_options',
        'notion-travel-sync',
        'tahsinrahit_notion_sync_page'
    );
}
add_action('admin_menu', 'tahsinrahit_notion_admin_menu');

/**
 * Admin page for manual sync
 */
function tahsinrahit_notion_sync_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $message = '';
    $error = '';

    // Handle manual sync
    if (isset($_POST['sync_notion']) && check_admin_referer('notion_sync_action', 'notion_sync_nonce')) {
        tahsinrahit_clear_notion_cache();
        $result = tahsinrahit_fetch_from_notion();

        if (is_wp_error($result)) {
            $error = $result->get_error_message();
        } else {
            $message = 'Successfully synced ' . count($result) . ' places from Notion!';
        }
    }

    // Get current status
    $cached_data = get_transient('notion_travel_places_cache');
    $is_configured = defined('NOTION_API_KEY') && defined('NOTION_DATABASE_ID');

    ?>
    <div class="wrap">
        <h1>Notion Travel Sync</h1>

        <?php if ($message): ?>
            <div class="notice notice-success is-dismissible">
                <p>
                    <?php echo esc_html($message); ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="notice notice-error is-dismissible">
                <p>
                    <?php echo esc_html($error); ?>
                </p>
            </div>
        <?php endif; ?>

        <div class="card" style="max-width: 800px;">
            <h2>Configuration Status</h2>
            <table class="form-table">
                <tr>
                    <th>Notion API Key:</th>
                    <td>
                        <?php if (defined('NOTION_API_KEY')): ?>
                            <span style="color: green;">✓ Configured</span>
                        <?php else: ?>
                            <span style="color: red;">✗ Not configured</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Database ID:</th>
                    <td>
                        <?php if (defined('NOTION_DATABASE_ID')): ?>
                            <span style="color: green;">✓ Configured</span>
                        <?php else: ?>
                            <span style="color: red;">✗ Not configured</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Cache Status:</th>
                    <td>
                        <?php if ($cached_data !== false): ?>
                            <span style="color: green;">✓ Cached (
                                <?php echo count($cached_data); ?> places)
                            </span>
                        <?php else: ?>
                            <span style="color: orange;">No cache</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Auto-sync:</th>
                    <td>
                        <?php if (wp_next_scheduled('tahsinrahit_refresh_notion_travel')): ?>
                            <span style="color: green;">✓ Enabled (hourly)</span>
                        <?php else: ?>
                            <span style="color: orange;">Not scheduled</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>

        <?php if (!$is_configured): ?>
            <div class="card" style="max-width: 800px; margin-top: 20px;">
                <h2>Setup Instructions</h2>
                <ol>
                    <li>Go to <a href="https://www.notion.so/my-integrations" target="_blank">Notion Integrations</a></li>
                    <li>Create a new integration and copy the "Internal Integration Token"</li>
                    <li>Share your travel database with this integration</li>
                    <li>Copy your database ID from the database URL</li>
                    <li>Add these lines to your <code>wp-config.php</code>:</li>
                </ol>
                <pre style="background: #f5f5f5; padding: 15px; border-radius: 5px;">
        define('NOTION_API_KEY', 'secret_your_key_here');
        define('NOTION_DATABASE_ID', 'your_database_id_here');
                        </pre>
            </div>
        <?php else: ?>
            <div class="card" style="max-width: 800px; margin-top: 20px;">
                <h2>Manual Sync</h2>
                <p>Click the button below to manually sync your travel data from Notion.</p>
                <form method="post">
                    <?php wp_nonce_field('notion_sync_action', 'notion_sync_nonce'); ?>
                    <p>
                        <button type="submit" name="sync_notion" class="button button-primary button-large">
                            🔄 Sync from Notion Now
                        </button>
                    </p>
                </form>
                <p class="description">
                    Note: Data is automatically synced every hour. Manual sync is only needed if you want immediate updates.
                </p>
            </div>

            <?php if ($cached_data !== false && !empty($cached_data)): ?>
                <div class="card" style="max-width: 800px; margin-top: 20px;">
                    <h2>Preview (
                        <?php echo count($cached_data); ?> places)
                    </h2>
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th>Flag</th>
                                <th>City</th>
                                <th>Country</th>
                                <th>Dates</th>
                                <th>Purpose</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($cached_data, 0, 10) as $place): ?>
                                <tr>
                                    <td>
                                        <?php echo esc_html($place['emoji']); ?>
                                    </td>
                                    <td>
                                        <?php echo esc_html($place['city']); ?>
                                    </td>
                                    <td>
                                        <?php echo esc_html($place['country']); ?>
                                    </td>
                                    <td>
                                        <?php echo esc_html(tahsinrahit_format_travel_dates($place['entry_date'], $place['exit_date'])); ?>
                                    </td>
                                    <td>
                                        <?php echo esc_html($place['type']); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if (count($cached_data) > 10): ?>
                        <p class="description">Showing first 10 of
                            <?php echo count($cached_data); ?> places.
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Add admin notice if Notion is not configured
 */
function tahsinrahit_notion_admin_notice()
{
    $screen = get_current_screen();
    if ($screen->id !== 'edit-travel_place') {
        return;
    }

    if (!defined('NOTION_API_KEY') || !defined('NOTION_DATABASE_ID')) {
        ?>
        <div class="notice notice-warning">
            <p>
                <strong>Notion Integration Available!</strong>
                <a href="<?php echo admin_url('edit.php?post_type=travel_place&page=notion-travel-sync'); ?>">
                    Click here to set up Notion sync
                </a> and manage your travel history directly from Notion.
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'tahsinrahit_notion_admin_notice');

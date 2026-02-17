<?php
/**
 * Notion API Debug Tool
 * 
 * Add this to your theme's functions.php temporarily to debug the Notion API
 * Access it at: yoursite.com/?notion_debug=1
 */

add_action('init', function () {
    if (isset($_GET['notion_debug']) && current_user_can('manage_options')) {

        echo '<html><head><title>Notion API Debug</title></head><body style="font-family: monospace; padding: 20px;">';
        echo '<h1>Notion API Debug Tool</h1>';

        // Check configuration
        echo '<h2>1. Configuration Check</h2>';
        echo '<pre>';
        echo 'NOTION_API_KEY defined: ' . (defined('NOTION_API_KEY') ? 'YES' : 'NO') . "\n";
        echo 'NOTION_DATABASE_ID defined: ' . (defined('NOTION_DATABASE_ID') ? 'YES' : 'NO') . "\n";

        if (defined('NOTION_API_KEY')) {
            echo 'API Key starts with: ' . substr(NOTION_API_KEY, 0, 10) . '...' . "\n";
            echo 'API Key length: ' . strlen(NOTION_API_KEY) . ' characters' . "\n";
        }

        if (defined('NOTION_DATABASE_ID')) {
            echo 'Database ID: ' . NOTION_DATABASE_ID . "\n";
            echo 'Database ID length: ' . strlen(NOTION_DATABASE_ID) . ' characters' . "\n";
        }
        echo '</pre>';

        if (!defined('NOTION_API_KEY') || !defined('NOTION_DATABASE_ID')) {
            echo '<p style="color: red;">Configuration missing! Add to wp-config.php</p>';
            echo '</body></html>';
            exit;
        }

        // Test API call
        echo '<h2>2. Testing API Call</h2>';

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

        echo '<pre>';

        if (is_wp_error($response)) {
            echo '<strong style="color: red;">WP_Error occurred:</strong>' . "\n";
            echo 'Error message: ' . $response->get_error_message() . "\n";
        } else {
            $status_code = wp_remote_retrieve_response_code($response);
            echo 'HTTP Status Code: ' . $status_code . "\n\n";

            $raw_body = wp_remote_retrieve_body($response);
            $body = json_decode($raw_body, true);

            if ($status_code === 200) {
                echo '<strong style="color: green;">✓ API call successful!</strong>' . "\n\n";

                if (isset($body['results'])) {
                    echo 'Number of results: ' . count($body['results']) . "\n\n";

                    if (count($body['results']) > 0) {
                        echo '<h3>First Result Properties:</h3>' . "\n";
                        $first = $body['results'][0];

                        if (isset($first['properties'])) {
                            echo 'Available properties:' . "\n";
                            foreach ($first['properties'] as $prop_name => $prop_data) {
                                echo '  - ' . $prop_name . ' (type: ' . $prop_data['type'] . ')' . "\n";
                            }

                            echo "\n" . '<h3>Extracted Data from First Result:</h3>' . "\n";
                            $props = $first['properties'];

                            // City
                            if (isset($props['City']['title']) && !empty($props['City']['title'])) {
                                echo 'City: ' . $props['City']['title'][0]['plain_text'] . "\n";
                            } else {
                                echo 'City: NOT FOUND or EMPTY' . "\n";
                            }

                            // Country
                            if (isset($props['Country']['rich_text']) && !empty($props['Country']['rich_text'])) {
                                echo 'Country: ' . $props['Country']['rich_text'][0]['plain_text'] . "\n";
                            } else {
                                echo 'Country: NOT FOUND or EMPTY' . "\n";
                            }

                            // Flag
                            if (isset($props['Flag']['rich_text']) && !empty($props['Flag']['rich_text'])) {
                                echo 'Flag: ' . $props['Flag']['rich_text'][0]['plain_text'] . "\n";
                            } else {
                                echo 'Flag: NOT FOUND or EMPTY' . "\n";
                            }

                            // Purpose
                            if (isset($props['Purpose']['select']['name'])) {
                                echo 'Purpose: ' . $props['Purpose']['select']['name'] . "\n";
                            } else {
                                echo 'Purpose: NOT FOUND or EMPTY' . "\n";
                            }

                            // From Date
                            if (isset($props['From Date']['date']['start'])) {
                                echo 'From Date: ' . $props['From Date']['date']['start'] . "\n";
                            } else {
                                echo 'From Date: NOT FOUND or EMPTY' . "\n";
                            }

                            // To Date
                            if (isset($props['To Date']['date']['start'])) {
                                echo 'To Date: ' . $props['To Date']['date']['start'] . "\n";
                            } else {
                                echo 'To Date: NOT FOUND or EMPTY' . "\n";
                            }
                        }
                    } else {
                        echo '<strong style="color: orange;">⚠ Database is empty!</strong>' . "\n";
                        echo 'Add some entries to your Notion database.' . "\n";
                    }
                } else {
                    echo '<strong style="color: red;">✗ No "results" in response</strong>' . "\n";
                }
            } else {
                echo '<strong style="color: red;">✗ API call failed</strong>' . "\n\n";
                echo 'Response body:' . "\n";
                echo $raw_body . "\n";
            }

            echo "\n" . '<h3>Full Response (JSON):</h3>' . "\n";
            echo json_encode($body, JSON_PRETTY_PRINT);
        }

        echo '</pre>';
        echo '</body></html>';
        exit;
    }
});

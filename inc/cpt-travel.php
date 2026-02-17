<?php
/**
 * Custom Post Type: Travel Place
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit;
}

// Register Custom Post Type
function tahsinrahit_register_travel_cpt()
{

    $labels = array(
        'name' => _x('Travel Places', 'Post Type General Name', 'tahsinrahit'),
        'singular_name' => _x('Travel Place', 'Post Type Singular Name', 'tahsinrahit'),
        'menu_name' => __('Travel History', 'tahsinrahit'),
        'name_admin_bar' => __('Travel Place', 'tahsinrahit'),
        'archives' => __('Item Archives', 'tahsinrahit'),
        'attributes' => __('Item Attributes', 'tahsinrahit'),
        'parent_item_colon' => __('Parent Item:', 'tahsinrahit'),
        'all_items' => __('All Places', 'tahsinrahit'),
        'add_new_item' => __('Add New Place', 'tahsinrahit'),
        'add_new' => __('Add New', 'tahsinrahit'),
        'new_item' => __('New Place', 'tahsinrahit'),
        'edit_item' => __('Edit Place', 'tahsinrahit'),
        'update_item' => __('Update Place', 'tahsinrahit'),
        'view_item' => __('View Place', 'tahsinrahit'),
        'view_items' => __('View Items', 'tahsinrahit'),
        'search_items' => __('Search Place', 'tahsinrahit'),
        'not_found' => __('No places found', 'tahsinrahit'),
        'not_found_in_trash' => __('No places found in Trash', 'tahsinrahit'),
        'featured_image' => __('Featured Image', 'tahsinrahit'),
        'set_featured_image' => __('Set featured image', 'tahsinrahit'),
        'remove_featured_image' => __('Remove featured image', 'tahsinrahit'),
        'use_featured_image' => __('Use as featured image', 'tahsinrahit'),
        'insert_into_item' => __('Insert into item', 'tahsinrahit'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'tahsinrahit'),
        'items_list' => __('Items list', 'tahsinrahit'),
        'items_list_navigation' => __('Items list navigation', 'tahsinrahit'),
        'filter_items_list' => __('Filter items list', 'tahsinrahit'),
    );
    $args = array(
        'label' => __('Travel Place', 'tahsinrahit'),
        'description' => __('Places I have visited or lived.', 'tahsinrahit'),
        'labels' => $labels,
        'supports' => array('title', 'page-attributes'), // Title will be the City name
        'taxonomies' => array(),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-airplane',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );
    register_post_type('travel_place', $args);

}
add_action('init', 'tahsinrahit_register_travel_cpt', 0);

// Add Meta Box
function tahsinrahit_travel_add_meta_box()
{
    add_meta_box(
        'travel_place_details',
        'Place Details',
        'tahsinrahit_travel_meta_box_callback',
        'travel_place',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'tahsinrahit_travel_add_meta_box');

// Meta Box Callback
function tahsinrahit_travel_meta_box_callback($post)
{
    wp_nonce_field('tahsinrahit_travel_save_meta_box_data', 'tahsinrahit_travel_meta_box_nonce');

    $country = get_post_meta($post->ID, '_travel_country', true);
    $entry_date = get_post_meta($post->ID, '_travel_entry_date', true);
    $exit_date = get_post_meta($post->ID, '_travel_exit_date', true);
    $type = get_post_meta($post->ID, '_travel_type', true);
    $emoji = get_post_meta($post->ID, '_travel_emoji', true);

    ?>
    <p>
        <label for="travel_emoji"><strong>Emoji Flag:</strong></label><br>
        <input type="text" id="travel_emoji" name="travel_emoji" value="<?php echo esc_attr($emoji); ?>" class="widefat"
            placeholder="e.g. 🇨🇦">
    </p>
    <p>
        <label for="travel_country"><strong>Country:</strong></label><br>
        <input type="text" id="travel_country" name="travel_country" value="<?php echo esc_attr($country); ?>"
            class="widefat" placeholder="e.g. Canada">
    </p>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
        <p>
            <label for="travel_entry_date"><strong>Entry Date:</strong></label><br>
            <input type="date" id="travel_entry_date" name="travel_entry_date" value="<?php echo esc_attr($entry_date); ?>"
                class="widefat">
        </p>
        <p>
            <label for="travel_exit_date"><strong>Exit Date:</strong></label><br>
            <input type="date" id="travel_exit_date" name="travel_exit_date" value="<?php echo esc_attr($exit_date); ?>"
                class="widefat">
            <small style="color: #666;">Leave empty for "Present"</small>
        </p>
    </div>
    <p>
        <label for="travel_type"><strong>Type:</strong></label><br>
        <select id="travel_type" name="travel_type" class="widefat">
            <option value="Travel" <?php selected($type, 'Travel'); ?>>Travel</option>
            <option value="Conference" <?php selected($type, 'Conference'); ?>>Conference</option>
            <option value="Work" <?php selected($type, 'Work'); ?>>Work</option>
            <option value="Home" <?php selected($type, 'Home'); ?>>Home</option>
            <option value="Origin" <?php selected($type, 'Origin'); ?>>Origin</option>
            <option value="Transit" <?php selected($type, 'Transit'); ?>>Transit</option>
        </select>
    </p>
    <?php
}

// Save Meta Box Data
function tahsinrahit_travel_save_meta_box_data($post_id)
{
    if (!isset($_POST['tahsinrahit_travel_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['tahsinrahit_travel_meta_box_nonce'], 'tahsinrahit_travel_save_meta_box_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['travel_country'])) {
        update_post_meta($post_id, '_travel_country', sanitize_text_field($_POST['travel_country']));
    }
    if (isset($_POST['travel_entry_date'])) {
        update_post_meta($post_id, '_travel_entry_date', sanitize_text_field($_POST['travel_entry_date']));
    }
    if (isset($_POST['travel_exit_date'])) {
        update_post_meta($post_id, '_travel_exit_date', sanitize_text_field($_POST['travel_exit_date']));
    }
    if (isset($_POST['travel_type'])) {
        update_post_meta($post_id, '_travel_type', sanitize_text_field($_POST['travel_type']));
    }
    if (isset($_POST['travel_emoji'])) {
        update_post_meta($post_id, '_travel_emoji', sanitize_text_field($_POST['travel_emoji']));
    }
}
add_action('save_post', 'tahsinrahit_travel_save_meta_box_data');

// Helper function to format date range
function tahsinrahit_format_travel_dates($entry_date, $exit_date = '')
{
    if (empty($entry_date)) {
        return '';
    }

    $entry = new DateTime($entry_date);

    // If no exit date, it's ongoing
    if (empty($exit_date)) {
        return $entry->format('M Y') . ' — Present';
    }

    $exit = new DateTime($exit_date);

    // Same month and year - show as single month
    if ($entry->format('Y-m') === $exit->format('Y-m')) {
        return $entry->format('M Y');
    }

    // Same year - show abbreviated
    if ($entry->format('Y') === $exit->format('Y')) {
        return $entry->format('M') . ' — ' . $exit->format('M Y');
    }

    // Different years - show full range
    return $entry->format('M Y') . ' — ' . $exit->format('M Y');
}

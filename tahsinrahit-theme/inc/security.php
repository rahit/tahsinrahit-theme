<?php
/**
 * Security Hardening
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access.
}

/**
 * Remove WordPress version from head and RSS feeds.
 */
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

/**
 * Hide version from scripts and styles.
 */
function tahsinrahit_remove_version_strings($src)
{
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'tahsinrahit_remove_version_strings', 9999);
add_filter('script_loader_src', 'tahsinrahit_remove_version_strings', 9999);

/**
 * Disable XML-RPC.
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Disable file editor in admin.
 */
if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}

/**
 * Send security headers.
 */
function tahsinrahit_security_headers()
{
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
    }
}
add_action('send_headers', 'tahsinrahit_security_headers');

/**
 * Disable REST API user enumeration for non-authenticated users.
 */
function tahsinrahit_restrict_rest_api_users($response, $handler, $request)
{
    $route = $request->get_route();
    if (strpos($route, '/wp/v2/users') !== false && !current_user_can('list_users')) {
        return new WP_Error(
            'rest_forbidden',
            esc_html__('You do not have permission to access this resource.', 'tahsinrahit'),
            array('status' => 403)
        );
    }
    return $response;
}
add_filter('rest_request_before_callbacks', 'tahsinrahit_restrict_rest_api_users', 10, 3);

/**
 * Disable author archives to prevent user enumeration via /?author=1.
 */
function tahsinrahit_disable_author_archives()
{
    if (is_author()) {
        wp_safe_redirect(home_url(), 301);
        exit;
    }
}
add_action('template_redirect', 'tahsinrahit_disable_author_archives');

/**
 * Remove unnecessary meta tags from head.
 */
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');

/**
 * Sanitize uploaded filenames to remove special characters.
 */
function tahsinrahit_sanitize_file_name($filename)
{
    $info = pathinfo($filename);
    $ext = empty($info['extension']) ? '' : '.' . $info['extension'];
    $name = basename($filename, $ext);
    $name = sanitize_title($name);
    return $name . $ext;
}
add_filter('sanitize_file_name', 'tahsinrahit_sanitize_file_name', 10);

/**
 * Limit login attempts description — works as a hint to use a plugin.
 * For production, recommend installing Limit Login Attempts or similar.
 */

/**
 * Remove "Powered by WordPress" from login page.
 */
function tahsinrahit_login_headerurl()
{
    return home_url();
}
add_filter('login_headerurl', 'tahsinrahit_login_headerurl');

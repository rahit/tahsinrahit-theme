<?php
/**
 * Theme Functions
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit;
}

/* ---------------------------------------------------------------
 * Constants
 * --------------------------------------------------------------- */
define('TAHSINRAHIT_VERSION', '1.0.0');
define('TAHSINRAHIT_DIR', get_template_directory());
define('TAHSINRAHIT_URI', get_template_directory_uri());

/* ---------------------------------------------------------------
 * Includes
 * --------------------------------------------------------------- */
require_once TAHSINRAHIT_DIR . '/inc/security.php';
require_once TAHSINRAHIT_DIR . '/inc/customizer.php';
require_once TAHSINRAHIT_DIR . '/inc/template-tags.php';
require_once TAHSINRAHIT_DIR . '/inc/cpt-travel.php';
require_once TAHSINRAHIT_DIR . '/inc/notion-travel-sync.php';
require_once TAHSINRAHIT_DIR . '/inc/notion-cpt-sync.php'; // New: Sync to WordPress posts
require_once TAHSINRAHIT_DIR . '/notion-debug.php'; // Temporary debug tool

/* ---------------------------------------------------------------
 * Theme Setup
 * --------------------------------------------------------------- */
function tahsinrahit_setup()
{
    // Make theme available for translation.
    load_theme_textdomain('tahsinrahit', TAHSINRAHIT_DIR . '/languages');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable featured images.
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(800, 450, true);
    add_image_size('tahsinrahit-card', 400, 250, true);

    // Custom logo.
    add_theme_support('custom-logo', array(
        'height' => 60,
        'width' => 200,
        'flex-height' => true,
        'flex-width' => true,
    ));

    // HTML5 support.
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
        'navigation-widgets',
    ));

    // Register navigation menus.
    register_nav_menus(array(
        'primary' => __('Primary Navigation', 'tahsinrahit'),
        'footer' => __('Footer Navigation', 'tahsinrahit'),
    ));

    // Content width.
    if (!isset($content_width)) {
        $content_width = 1280;
    }
}
add_action('after_setup_theme', 'tahsinrahit_setup');

/* ---------------------------------------------------------------
 * Enqueue Scripts & Styles
 * --------------------------------------------------------------- */
function tahsinrahit_enqueue_assets()
{
    // Google Fonts.
    wp_enqueue_style(
        'tahsinrahit-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap',
        array(),
        null
    );

    // Google Material Symbols (for icons on homepage).
    wp_enqueue_style(
        'tahsinrahit-material-symbols',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200',
        array(),
        null
    );

    // Main stylesheet (style.css — design system + base).
    wp_enqueue_style(
        'tahsinrahit-style',
        get_stylesheet_uri(),
        array('tahsinrahit-google-fonts'),
        TAHSINRAHIT_VERSION
    );

    // Component styles.
    wp_enqueue_style(
        'tahsinrahit-theme-css',
        TAHSINRAHIT_URI . '/assets/css/theme.css',
        array('tahsinrahit-style'),
        TAHSINRAHIT_VERSION
    );

    // Theme toggle (load early, in head, to prevent flash).
    wp_enqueue_script(
        'tahsinrahit-theme-toggle',
        TAHSINRAHIT_URI . '/assets/js/theme-toggle.js',
        array(),
        TAHSINRAHIT_VERSION,
        array('strategy' => 'defer', 'in_footer' => false)
    );

    // Navigation.
    wp_enqueue_script(
        'tahsinrahit-navigation',
        TAHSINRAHIT_URI . '/assets/js/navigation.js',
        array(),
        TAHSINRAHIT_VERSION,
        true
    );

    // Network background.
    wp_enqueue_script(
        'tahsinrahit-network-bg',
        TAHSINRAHIT_URI . '/assets/js/network-bg.js',
        array(),
        TAHSINRAHIT_VERSION,
        true
    );

    // Comment reply script.
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'tahsinrahit_enqueue_assets');

/* ---------------------------------------------------------------
 * Custom Nav Walker
 * --------------------------------------------------------------- */
class Tahsinrahit_Nav_Walker extends Walker_Nav_Menu
{

    /**
     * Start element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';

        if (in_array('current-menu-item', $classes, true)) {
            $classes[] = 'nav-item--active';
        }

        $class_names = implode(' ', array_filter($classes));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names . '>';

        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';

        // Check if this is the Contact link to give it a special class.
        $is_contact = (strtolower(trim($item->title)) === 'contact');

        $atts['class'] = $is_contact ? 'nav-link nav-link--cta' : 'nav-link';

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);

        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . $title . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

/* ---------------------------------------------------------------
 * Fallback Menu
 * --------------------------------------------------------------- */
function tahsinrahit_fallback_menu()
{
    $pages = array(
        array('title' => 'Home', 'url' => home_url('/')),
        array('title' => 'About', 'url' => home_url('/about/')),
        array('title' => 'Blog', 'url' => home_url('/blog/')),
        array('title' => 'Travel', 'url' => home_url('/travel/')),
        array('title' => 'Contact', 'url' => home_url('/#contact')),
    );

    echo '<ul class="nav-menu">';
    foreach ($pages as $page) {
        $is_contact = ('Contact' === $page['title']);
        $class = $is_contact ? 'nav-link nav-link--cta' : 'nav-link';
        printf(
            '<li class="nav-item"><a href="%s" class="%s">%s</a></li>',
            esc_url($page['url']),
            esc_attr($class),
            esc_html($page['title'])
        );
    }
    echo '</ul>';
}

/* ---------------------------------------------------------------
 * Excerpt Length & More
 * --------------------------------------------------------------- */
function tahsinrahit_excerpt_length($length)
{
    return 25;
}
add_filter('excerpt_length', 'tahsinrahit_excerpt_length');

function tahsinrahit_excerpt_more($more)
{
    return '&hellip;';
}
add_filter('excerpt_more', 'tahsinrahit_excerpt_more');

/* ---------------------------------------------------------------
 * Body Classes
 * --------------------------------------------------------------- */
function tahsinrahit_body_classes($classes)
{
    if (is_front_page()) {
        $classes[] = 'page-home';
    }
    if (is_singular()) {
        $classes[] = 'page-singular';
    }
    return $classes;
}
add_filter('body_class', 'tahsinrahit_body_classes');

/* ---------------------------------------------------------------
 * Widget Areas
 * --------------------------------------------------------------- */
function tahsinrahit_widgets_init()
{
    register_sidebar(array(
        'name' => __('Blog Sidebar', 'tahsinrahit'),
        'id' => 'sidebar-blog',
        'description' => __('Widgets shown on the blog pages.', 'tahsinrahit'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'tahsinrahit_widgets_init');

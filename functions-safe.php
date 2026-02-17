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
   Constants
--------------------------------------------------------------- */
define('TAHSINRAHIT_VERSION', '1.0.0');
define('TAHSINRAHIT_DIR', get_template_directory());
define('TAHSINRAHIT_URI', get_template_directory_uri());

/* ---------------------------------------------------------------
   Includes
--------------------------------------------------------------- */
require_once TAHSINRAHIT_DIR . '/inc/setup.php';
require_once TAHSINRAHIT_DIR . '/inc/enqueue.php';
require_once TAHSINRAHIT_DIR . '/inc/template-tags.php';
require_once TAHSINRAHIT_DIR . '/inc/cpt-travel.php';

// Temporarily commented out to debug
// require_once TAHSINRAHIT_DIR . '/inc/notion-travel-sync.php';
// require_once TAHSINRAHIT_DIR . '/inc/notion-cpt-sync.php';
// require_once TAHSINRAHIT_DIR . '/notion-debug.php';

/* ---------------------------------------------------------------
   Theme Setup
--------------------------------------------------------------- */
add_action('after_setup_theme', 'tahsinrahit_setup');

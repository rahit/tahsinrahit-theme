<?php
/**
 * Header Template
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <!-- Scroll Progress Bar -->
    <div class="scroll-progress" id="scroll-progress" aria-hidden="true"></div>

    <!-- Background Animation Container -->
    <div class="bg-animation no-print" aria-hidden="true">
        <canvas id="network-canvas"></canvas>
        <!-- Aurora Blobs -->
        <div class="aurora-blob aurora-blob--cyan"></div>
        <div class="aurora-blob aurora-blob--blue"></div>
        <div class="aurora-blob aurora-blob--purple"></div>
    </div>

    <!-- Navigation -->
    <nav class="site-nav no-print" id="site-nav" role="navigation"
        aria-label="<?php esc_attr_e('Primary Navigation', 'tahsinrahit'); ?>">
        <div class="container nav-container">
            <!-- Brand -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-brand" rel="home">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <span class="nav-brand__icon material-symbols-outlined" aria-hidden="true">radio_button_unchecked</span>
                    <span class="nav-brand__text">
                        Tahsin <span class="nav-brand__accent">Rahit</span>
                    </span>
                <?php endif; ?>
            </a>

            <!-- Desktop Nav -->
            <div class="nav-desktop">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'nav-menu',
                    'fallback_cb' => 'tahsinrahit_fallback_menu',
                    'walker' => new Tahsinrahit_Nav_Walker(),
                    'depth' => 1,
                ));
                ?>
                <!-- Theme Toggle -->
                <button class="theme-toggle" id="theme-toggle-desktop"
                    aria-label="<?php esc_attr_e('Toggle dark/light mode', 'tahsinrahit'); ?>">
                    <span class="material-symbols-outlined theme-toggle__icon" id="theme-icon">light_mode</span>
                </button>
            </div>

            <!-- Mobile Controls -->
            <div class="nav-mobile-controls">
                <button class="theme-toggle" id="theme-toggle-mobile"
                    aria-label="<?php esc_attr_e('Toggle dark/light mode', 'tahsinrahit'); ?>">
                    <span class="material-symbols-outlined theme-toggle__icon" id="theme-icon-mobile">light_mode</span>
                </button>
                <button class="mobile-menu-toggle" id="mobile-menu-toggle"
                    aria-label="<?php esc_attr_e('Toggle mobile menu', 'tahsinrahit'); ?>" aria-expanded="false"
                    aria-controls="mobile-menu">
                    <span class="material-symbols-outlined" aria-hidden="true">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobile-menu" aria-hidden="true">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'mobile-menu__list',
                'fallback_cb' => 'tahsinrahit_fallback_menu',
                'depth' => 1,
            ));
            ?>
        </div>
    </nav>

    <main id="main-content" class="site-main">
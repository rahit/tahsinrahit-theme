<?php
/**
 * Theme Customizer
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Customizer settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function tahsinrahit_customize_register($wp_customize)
{

    /* ---------------------------------------------------------------
     * Section: Social Links
     * --------------------------------------------------------------- */
    $wp_customize->add_section('tahsinrahit_social', array(
        'title' => __('Social Links', 'tahsinrahit'),
        'priority' => 30,
    ));

    $social_links = array(
        'github' => __('GitHub URL', 'tahsinrahit'),
        'linkedin' => __('LinkedIn URL', 'tahsinrahit'),
        'google_scholar' => __('Google Scholar URL', 'tahsinrahit'),
        'orcid' => __('ORCID URL', 'tahsinrahit'),
        'email' => __('Email Address', 'tahsinrahit'),
    );

    $priority = 10;
    foreach ($social_links as $key => $label) {
        $setting_id = 'tahsinrahit_social_' . $key;

        $wp_customize->add_setting($setting_id, array(
            'default' => '',
            'sanitize_callback' => ('email' === $key) ? 'sanitize_email' : 'esc_url_raw',
        ));

        $wp_customize->add_control($setting_id, array(
            'label' => $label,
            'section' => 'tahsinrahit_social',
            'type' => ('email' === $key) ? 'email' : 'url',
            'priority' => $priority,
        ));

        $priority += 10;
    }

    /* ---------------------------------------------------------------
     * Section: Profile Info
     * --------------------------------------------------------------- */
    $wp_customize->add_section('tahsinrahit_profile', array(
        'title' => __('Profile Info', 'tahsinrahit'),
        'priority' => 25,
    ));

    $wp_customize->add_setting('tahsinrahit_profile_name', array(
        'default' => 'K.M. Tahsin Hassan Rahit',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('tahsinrahit_profile_name', array(
        'label' => __('Full Name', 'tahsinrahit'),
        'section' => 'tahsinrahit_profile',
        'type' => 'text',
    ));

    $wp_customize->add_setting('tahsinrahit_profile_title', array(
        'default' => 'Ph.D.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('tahsinrahit_profile_title', array(
        'label' => __('Title / Suffix', 'tahsinrahit'),
        'section' => 'tahsinrahit_profile',
        'type' => 'text',
    ));

    $wp_customize->add_setting('tahsinrahit_profile_tagline', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('tahsinrahit_profile_tagline', array(
        'label' => __('Hero Tagline', 'tahsinrahit'),
        'section' => 'tahsinrahit_profile',
        'type' => 'textarea',
    ));

    /* ---------------------------------------------------------------
     * Section: Footer
     * --------------------------------------------------------------- */
    $wp_customize->add_setting('tahsinrahit_footer_text', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('tahsinrahit_footer_text', array(
        'label' => __('Footer Text', 'tahsinrahit'),
        'section' => 'title_tagline',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'tahsinrahit_customize_register');

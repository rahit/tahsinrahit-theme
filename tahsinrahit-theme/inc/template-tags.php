<?php
/**
 * Template Tags — Helper functions for templates
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get a social link from the Customizer and return an escaped URL.
 *
 * @param string $key Social link key (github, linkedin, google_scholar, orcid, email).
 * @return string Escaped URL or mailto link. Empty string if not set.
 */
function tahsinrahit_get_social_url($key)
{
    $value = get_theme_mod('tahsinrahit_social_' . $key, '');
    if ('email' === $key && !empty($value)) {
        return 'mailto:' . sanitize_email($value);
    }
    return esc_url($value);
}

/**
 * Get the profile name from the Customizer.
 *
 * @return string Escaped name.
 */
function tahsinrahit_get_profile_name()
{
    return esc_html(get_theme_mod('tahsinrahit_profile_name', 'K.M. Tahsin Hassan Rahit'));
}

/**
 * Get the profile title suffix.
 *
 * @return string Escaped title.
 */
function tahsinrahit_get_profile_title()
{
    return esc_html(get_theme_mod('tahsinrahit_profile_title', 'Ph.D.'));
}

/**
 * Estimated reading time for a post.
 *
 * @param int $post_id Post ID. Defaults to current post.
 * @return int Minutes.
 */
function tahsinrahit_reading_time($post_id = 0)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(wp_strip_all_tags($content));
    $minutes = max(1, (int) ceil($word_count / 200));
    return $minutes;
}

/**
 * Print post tags as styled chips.
 *
 * @param int $post_id Post ID. Defaults to current post.
 */
function tahsinrahit_post_tags($post_id = 0)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $tags = get_the_tags($post_id);
    if ($tags) {
        echo '<div class="post-tags">';
        foreach ($tags as $tag) {
            printf(
                '<a href="%s" class="tag-chip">%s</a>',
                esc_url(get_tag_link($tag->term_id)),
                esc_html($tag->name)
            );
        }
        echo '</div>';
    }
}

/**
 * Social icon SVG helper.
 *
 * @param string $icon Icon name (github, linkedin, mail, scholar, orcid).
 * @return string SVG markup.
 */
function tahsinrahit_social_icon($icon)
{
    $icons = array(
        'github' => '<svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20" aria-hidden="true"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.6.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0 1 12 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>',
        'linkedin' => '<svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
        'mail' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>',
        'scholar' => '<svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20" aria-hidden="true"><path d="M5.242 13.769L0 9.5 12 0l12 9.5-5.242 4.269C17.548 11.249 14.978 9.5 12 9.5c-2.977 0-5.548 1.748-6.758 4.269zM12 10a7 7 0 1 0 0 14 7 7 0 0 0 0-14z"/></svg>',
        'orcid' => '<svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20" aria-hidden="true"><path d="M12 0C5.372 0 0 5.372 0 12s5.372 12 12 12 12-5.372 12-12S18.628 0 12 0zM7.369 4.378c.541 0 .942.428.942.946s-.401.946-.942.946c-.541 0-.942-.428-.942-.946s.401-.946.942-.946zm1.096 3.123v10.22H6.273V7.501h2.192zm5.062 0c2.28 0 3.732 1.498 3.732 5.11 0 3.611-1.452 5.11-3.732 5.11h-2.148V7.501h2.148zm-1.096 1.834h-.942v6.551h.942c1.644 0 2.587-.905 2.587-3.275 0-2.371-.943-3.276-2.587-3.276z"/></svg>',
    );

    return isset($icons[$icon]) ? $icons[$icon] : '';
}

/**
 * Print a section heading with animated underline.
 *
 * @param string $title Section title text.
 * @param string $id    Section HTML id.
 */
function tahsinrahit_section_heading($title, $id = '')
{
    $id_attr = $id ? ' id="' . esc_attr($id) . '"' : '';
    printf(
        '<h2 class="section-heading reveal"%s>%s</h2>',
        $id_attr,
        esc_html($title)
    );
}

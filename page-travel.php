<?php
/**
 * Template Name: Travel
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit;
}

$places = array(
    array('emoji' => '🇨🇦', 'city' => 'Calgary', 'country' => 'Canada', 'year' => '2019 — Present', 'type' => 'Home'),
    array('emoji' => '🏴󠁧󠁢󠁳󠁣󠁴󠁿', 'city' => 'Glasgow', 'country' => 'Scotland', 'year' => '2023', 'type' => 'Conference'),
    array('emoji' => '🇺🇸', 'city' => 'Los Angeles', 'country' => 'USA', 'year' => '2022', 'type' => 'Conference'),
    array('emoji' => '🇸🇬', 'city' => 'Singapore', 'country' => 'Singapore', 'year' => '2018', 'type' => 'Conference'),
    array('emoji' => '🇹🇭', 'city' => 'Bangkok', 'country' => 'Thailand', 'year' => '2016 — 2017', 'type' => 'Work'),
    array('emoji' => '🇧🇩', 'city' => 'Dhaka', 'country' => 'Bangladesh', 'year' => 'Hometown', 'type' => 'Origin'),
    array('emoji' => '🇮🇳', 'city' => 'Kolkata', 'country' => 'India', 'year' => '2016', 'type' => 'Travel'),
    array('emoji' => '🇲🇾', 'city' => 'Kuala Lumpur', 'country' => 'Malaysia', 'year' => '2017', 'type' => 'Travel'),
    array('emoji' => '🇦🇪', 'city' => 'Dubai', 'country' => 'UAE', 'year' => '2019', 'type' => 'Transit'),
    array('emoji' => '🇺🇸', 'city' => 'Houston', 'country' => 'USA', 'year' => '2019', 'type' => 'Conference'),
);

// Fetch from Custom Post Type
$travel_query = new WP_Query(array(
    'post_type' => 'travel_place',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
));

if ($travel_query->have_posts()) {
    $places = array(); // Override defaults if we have dynamic content
    while ($travel_query->have_posts()) {
        $travel_query->the_post();
        $places[] = array(
            'emoji' => get_post_meta(get_the_ID(), '_travel_emoji', true),
            'city' => get_the_title(),
            'country' => get_post_meta(get_the_ID(), '_travel_country', true),
            'year' => get_post_meta(get_the_ID(), '_travel_year', true),
            'type' => get_post_meta(get_the_ID(), '_travel_type', true),
        );
    }
    wp_reset_postdata();
}

get_header();
?>

<div class="page-header">
    <div class="container">
        <h1 class="page-header__title fade-in-up">
            <?php the_title(); ?>
        </h1>
        <p class="page-header__desc fade-in-up" style="animation-delay:0.1s;">
            <?php echo esc_html__('Places I have lived, worked, and explored around the world.', 'tahsinrahit'); ?>
        </p>
    </div>
</div>

<section class="section" style="padding-top:0;">
    <div class="container">
        <div class="travel-timeline">
            <?php foreach ($places as $place): ?>
                <div class="travel-item reveal">
                    <div class="travel-item__dot"></div>
                    <div class="glass-panel travel-card">
                        <div class="travel-card__emoji" aria-hidden="true">
                            <?php echo esc_html($place['emoji']); ?>
                        </div>
                        <div class="travel-card__year">
                            <?php echo esc_html($place['year']); ?>
                        </div>
                        <div class="travel-card__city">
                            <?php echo esc_html($place['city']); ?>
                        </div>
                        <div class="travel-card__country">
                            <?php echo esc_html($place['country']); ?>
                        </div>
                        <span class="travel-card__type">
                            <?php echo esc_html($place['type']); ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
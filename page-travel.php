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
    array('emoji' => '🇨🇦', 'city' => 'Calgary', 'country' => 'Canada', 'year' => '2019 — Present', 'type' => 'Home', 'photos' => array('https://images.unsplash.com/photo-1597200459346-6ad86f2b48a3?w=400&q=80', 'https://images.unsplash.com/photo-1629167123964-b5a93910c662?w=400&q=80')),
    array('emoji' => '🏴󠁧󠁢󠁳󠁣󠁴󠁿', 'city' => 'Glasgow', 'country' => 'Scotland', 'year' => '2023', 'type' => 'Conference', 'photos' => array('https://images.unsplash.com/photo-1579707252277-3e12c0199343?w=400&q=80')),
    array('emoji' => '🇺🇸', 'city' => 'Los Angeles', 'country' => 'USA', 'year' => '2022', 'type' => 'Conference', 'photos' => array()),
    array('emoji' => '🇸🇬', 'city' => 'Singapore', 'country' => 'Singapore', 'year' => '2018', 'type' => 'Conference', 'photos' => array('https://images.unsplash.com/photo-1525625293386-3f8f99389e14?w=400&q=80', 'https://images.unsplash.com/photo-1565967511849-76a60a516170?w=400&q=80')),
    array('emoji' => '🇹🇭', 'city' => 'Bangkok', 'country' => 'Thailand', 'year' => '2016 — 2017', 'type' => 'Work', 'photos' => array('https://images.unsplash.com/photo-1582260656608-25175965dd36?w=400&q=80')),
    array('emoji' => '🇧🇩', 'city' => 'Dhaka', 'country' => 'Bangladesh', 'year' => 'Hometown', 'type' => 'Origin', 'photos' => array()),
    array('emoji' => '🇮🇳', 'city' => 'Kolkata', 'country' => 'India', 'year' => '2016', 'type' => 'Travel', 'photos' => array()),
    array('emoji' => '🇲🇾', 'city' => 'Kuala Lumpur', 'country' => 'Malaysia', 'year' => '2017', 'type' => 'Travel', 'photos' => array('https://images.unsplash.com/photo-1574087834778-9e19dce9b2b5?w=400&q=80')),
    array('emoji' => '🇦🇪', 'city' => 'Dubai', 'country' => 'UAE', 'year' => '2019', 'type' => 'Transit', 'photos' => array()),
    array('emoji' => '🇺🇸', 'city' => 'Houston', 'country' => 'USA', 'year' => '2019', 'type' => 'Conference', 'photos' => array()),
);

// Fetch from WordPress Custom Post Type (synced from Notion)
$travel_query = new WP_Query(array(
    'post_type' => 'travel_place',
    'posts_per_page' => -1,
    'orderby' => 'meta_value',
    'meta_key' => '_travel_entry_date',
    'order' => 'DESC',
));

if ($travel_query->have_posts()) {
    $places = array(); // Override defaults if we have dynamic content
    while ($travel_query->have_posts()) {
        $travel_query->the_post();
        $entry_date = get_post_meta(get_the_ID(), '_travel_entry_date', true);
        $exit_date = get_post_meta(get_the_ID(), '_travel_exit_date', true);
        $places[] = array(
            'emoji' => get_post_meta(get_the_ID(), '_travel_emoji', true),
            'city' => get_the_title(),
            'country' => get_post_meta(get_the_ID(), '_travel_country', true),
            'year' => tahsinrahit_format_travel_dates($entry_date, $exit_date),
            'type' => get_post_meta(get_the_ID(), '_travel_type', true),
            'photos' => get_post_meta(get_the_ID(), '_travel_photos', true) ?: array(),
        );
    }
    wp_reset_postdata();
}
// Otherwise use hardcoded fallback data (already defined above)

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

                    <?php if (!empty($place['photos'])): ?>
                        <div class="travel-gallery">
                            <?php foreach (array_slice($place['photos'], 0, 3) as $index => $photo_url): ?>
                                <div class="travel-gallery__item" style="--i: <?php echo $index; ?>">
                                    <img src="<?php echo esc_url($photo_url); ?>"
                                        alt="Travel photo from <?php echo esc_attr($place['city']); ?>" loading="lazy">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

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
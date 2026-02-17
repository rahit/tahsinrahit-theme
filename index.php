<?php
/**
 * Index template — Fallback for all content types
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit;
}

// For blog posts listing, use archive template.
if (is_home() || is_archive() || is_search()) {
    get_template_part('archive');
    return;
}

get_header();
?>

<div class="page-header">
    <div class="container">
        <h1 class="page-header__title fade-in-up">
            <?php echo esc_html__('Content', 'tahsinrahit'); ?>
        </h1>
    </div>
</div>

<section class="section" style="padding-top:0;">
    <div class="container">
        <?php
        if (have_posts()):
            while (have_posts()):
                the_post();
                ?>
                <article class="single-post-content">
                    <h2>
                        <?php the_title(); ?>
                    </h2>
                    <?php the_content(); ?>
                </article>
                <?php
            endwhile;
        endif;
        ?>
    </div>
</section>

<?php get_footer(); ?>
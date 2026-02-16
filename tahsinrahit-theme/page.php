<?php
/**
 * Default page template
 *
 * Used for generic WordPress pages that don't match a more specific template.
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="page-header">
    <div class="container">
        <h1 class="page-header__title fade-in-up">
            <?php the_title(); ?>
        </h1>
    </div>
</div>

<section class="section" style="padding-top:0;">
    <div class="container">
        <div class="single-post-content">
            <?php
            if (have_posts()):
                while (have_posts()):
                    the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
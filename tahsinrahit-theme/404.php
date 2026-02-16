<?php
/**
 * 404 Error Page
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="error-page">
    <div class="error-page__code">404</div>
    <h1 class="error-page__title">
        <?php echo esc_html__('Page Not Found', 'tahsinrahit'); ?>
    </h1>
    <p class="error-page__desc">
        <?php echo esc_html__("The page you're looking for doesn't exist or has been moved.", 'tahsinrahit'); ?>
    </p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">
        <span class="material-symbols-outlined" aria-hidden="true">home</span>
        <?php echo esc_html__('Back to Home', 'tahsinrahit'); ?>
    </a>
</div>

<?php get_footer(); ?>
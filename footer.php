<?php
/**
 * Footer Template
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
</main><!-- #main-content -->

<!-- Footer -->
<footer class="site-footer no-print" role="contentinfo">
    <div class="container">
        <div class="footer-inner">
            <!-- Brand & Tagline -->
            <div class="footer-brand">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-brand__link">
                    <span class="footer-brand__name">Tahsin <span class="footer-brand__accent">Rahit</span></span>
                </a>
                <p class="footer-brand__tagline">
                    <?php echo esc_html__('Researcher · Educator · Developer', 'tahsinrahit'); ?>
                </p>
            </div>

            <!-- Social Links -->
            <div class="footer-social">
                <?php
                $social_links = array(
                    'github' => 'github',
                    'linkedin' => 'linkedin',
                    'email' => 'mail',
                    'google_scholar' => 'scholar',
                    'orcid' => 'orcid',
                );
                foreach ($social_links as $key => $icon):
                    $url = tahsinrahit_get_social_url($key);
                    if ($url):
                        $target = ('email' === $key) ? '' : ' target="_blank" rel="noopener noreferrer"';
                        ?>
                        <a href="<?php echo esc_url($url); ?>" class="footer-social__link"
                            aria-label="<?php echo esc_attr(ucfirst(str_replace('_', ' ', $key))); ?>" <?php echo $target; ?>>
                            <?php echo tahsinrahit_social_icon($icon); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG is hardcoded. ?>
                        </a>
                        <?php
                    endif;
                endforeach;
                ?>
            </div>

            <!-- Copyright -->
            <div class="footer-copyright">
                <?php
                $footer_text = get_theme_mod('tahsinrahit_footer_text', '');
                if ($footer_text) {
                    echo wp_kses_post($footer_text);
                } else {
                    printf(
                        /* translators: %1$s: copyright year, %2$s: site name */
                        esc_html__('© %1$s %2$s. All rights reserved.', 'tahsinrahit'),
                        esc_html(gmdate('Y')),
                        esc_html(get_bloginfo('name'))
                    );
                }
                ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>
<?php
/**
 * Single Post template
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

if (have_posts()):
    while (have_posts()):
        the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="single-post-header">
                <div class="container">
                    <a href="<?php echo esc_url(get_post_type_archive_link('post') ? get_post_type_archive_link('post') : home_url('/blog/')); ?>"
                        class="single-post-header__back">
                        <span class="material-symbols-outlined" aria-hidden="true">arrow_back</span>
                        <?php echo esc_html__('Back to Blog', 'tahsinrahit'); ?>
                    </a>

                    <?php tahsinrahit_post_tags(); ?>

                    <h1 class="single-post-header__title fade-in-up">
                        <?php the_title(); ?>
                    </h1>

                    <div class="single-post-header__meta fade-in-up" style="animation-delay:0.1s;">
                        <div class="single-post-header__author">
                            <?php echo get_avatar(get_the_author_meta('ID'), 32, '', '', array('class' => 'single-post-header__avatar')); ?>
                            <span>
                                <?php the_author(); ?>
                            </span>
                        </div>
                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo esc_html(get_the_date()); ?>
                        </time>
                        <span>
                            <?php
                            /* translators: %d: minutes */
                            printf(esc_html__('%d min read', 'tahsinrahit'), tahsinrahit_reading_time());
                            ?>
                        </span>
                    </div>
                </div>
            </header>

            <div class="container">
                <div class="single-post-content">
                    <?php the_content(); ?>

                    <!-- Share Buttons -->
                    <div class="share-buttons">
                        <span style="color:var(--color-text-muted);font-size:var(--text-sm);">
                            <?php echo esc_html__('Share:', 'tahsinrahit'); ?>
                        </span>
                        <?php
                        $share_url = rawurlencode(get_permalink());
                        $share_title = rawurlencode(get_the_title());
                        ?>
                        <a href="<?php echo esc_url('https://twitter.com/intent/tweet?url=' . $share_url . '&text=' . $share_title); ?>"
                            target="_blank" rel="noopener noreferrer" class="share-btn"
                            aria-label="<?php esc_attr_e('Share on Twitter', 'tahsinrahit'); ?>">
                            𝕏
                            <?php echo esc_html__('Twitter', 'tahsinrahit'); ?>
                        </a>
                        <a href="<?php echo esc_url('https://www.linkedin.com/shareArticle?mini=true&url=' . $share_url . '&title=' . $share_title); ?>"
                            target="_blank" rel="noopener noreferrer" class="share-btn"
                            aria-label="<?php esc_attr_e('Share on LinkedIn', 'tahsinrahit'); ?>">
                            <?php echo tahsinrahit_social_icon('linkedin'); // phpcs:ignore ?>
                            <?php echo esc_html__('LinkedIn', 'tahsinrahit'); ?>
                        </a>
                    </div>

                    <!-- Post Navigation -->
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    if ($prev_post || $next_post):
                        ?>
                        <nav class="post-navigation" aria-label="<?php esc_attr_e('Post navigation', 'tahsinrahit'); ?>">
                            <?php if ($prev_post): ?>
                                <a href="<?php echo esc_url(get_permalink($prev_post)); ?>"
                                    class="post-nav-link post-nav-link--prev">
                                    <span class="post-nav-link__label">&larr;
                                        <?php echo esc_html__('Previous', 'tahsinrahit'); ?>
                                    </span>
                                    <span class="post-nav-link__title">
                                        <?php echo esc_html($prev_post->post_title); ?>
                                    </span>
                                </a>
                            <?php else: ?>
                                <div></div>
                            <?php endif; ?>

                            <?php if ($next_post): ?>
                                <a href="<?php echo esc_url(get_permalink($next_post)); ?>"
                                    class="post-nav-link post-nav-link--next">
                                    <span class="post-nav-link__label">
                                        <?php echo esc_html__('Next', 'tahsinrahit'); ?> &rarr;
                                    </span>
                                    <span class="post-nav-link__title">
                                        <?php echo esc_html($next_post->post_title); ?>
                                    </span>
                                </a>
                            <?php else: ?>
                                <div></div>
                            <?php endif; ?>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </article>

        <?php
    endwhile;
endif;

get_footer();
?>
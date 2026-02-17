<?php
/**
 * Archive template — Blog listing
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
            <?php
            if (is_category()) {
                single_cat_title();
            } elseif (is_tag()) {
                single_tag_title();
            } elseif (is_search()) {
                /* translators: %s: search query */
                printf(esc_html__('Search: %s', 'tahsinrahit'), get_search_query());
            } else {
                echo esc_html__('Blog', 'tahsinrahit');
            }
            ?>
        </h1>
        <p class="page-header__desc fade-in-up" style="animation-delay:0.1s;">
            <?php
            if (is_category()) {
                echo esc_html(category_description());
            } else {
                echo esc_html__('Thoughts, tutorials, and research notes.', 'tahsinrahit');
            }
            ?>
        </p>
    </div>
</div>

<!-- Category Filters -->
<?php
$categories = get_categories(array('hide_empty' => true));
if ($categories):
    ?>
    <div class="container" style="padding-bottom:var(--space-8);">
        <div class="exp-filters" style="justify-content:center;">
            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts')) ? get_permalink(get_option('page_for_posts')) : home_url('/blog/')); ?>"
                class="exp-filter-btn <?php echo !is_category() ? 'active' : ''; ?>">
                <?php echo esc_html__('All', 'tahsinrahit'); ?>
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
                    class="exp-filter-btn <?php echo (is_category($cat->term_id)) ? 'active' : ''; ?>">
                    <?php echo esc_html($cat->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<section class="section" style="padding-top:0;">
    <div class="container">
        <?php if (have_posts()): ?>
            <div class="blog-grid">
                <?php while (have_posts()):
                    the_post(); ?>
                    <article class="glass-panel blog-card reveal" id="post-<?php the_ID(); ?>">
                        <?php if (has_post_thumbnail()): ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('tahsinrahit-card', array(
                                    'class' => 'blog-card__image',
                                    'loading' => 'lazy',
                                )); ?>
                            </a>
                        <?php else: ?>
                            <a href="<?php the_permalink(); ?>">
                                <div class="blog-card__image" style="display:flex;align-items:center;justify-content:center;">
                                    <span class="material-symbols-outlined" style="font-size:3rem;color:var(--color-text-muted);"
                                        aria-hidden="true">article</span>
                                </div>
                            </a>
                        <?php endif; ?>

                        <div class="blog-card__body">
                            <div class="blog-card__date">
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                    <?php echo esc_html(get_the_date()); ?>
                                </time>
                            </div>
                            <h2 class="blog-card__title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <p class="blog-card__excerpt">
                                <?php echo esc_html(get_the_excerpt()); ?>
                            </p>
                            <div class="blog-card__footer">
                                <?php tahsinrahit_post_tags(); ?>
                                <span class="blog-card__readtime">
                                    <?php
                                    /* translators: %d: minutes */
                                    printf(esc_html__('%d min read', 'tahsinrahit'), tahsinrahit_reading_time());
                                    ?>
                                </span>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => '&larr;',
                    'next_text' => '&rarr;',
                ));
                ?>
            </div>

        <?php else: ?>
            <div style="text-align:center;padding:var(--space-16) 0;">
                <span class="material-symbols-outlined" style="font-size:4rem;color:var(--color-text-muted);"
                    aria-hidden="true">search_off</span>
                <h2 style="margin-top:var(--space-4);">
                    <?php echo esc_html__('No posts found', 'tahsinrahit'); ?>
                </h2>
                <p style="color:var(--color-text-muted);">
                    <?php echo esc_html__('Check back soon for new content.', 'tahsinrahit'); ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
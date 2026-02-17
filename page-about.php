<?php
/**
 * Template Name: About
 *
 * @package TahsinRahit
 */

if (!defined('ABSPATH')) {
    exit;
}

$timeline = array(
    array(
        'title' => 'Postdoctoral Associate',
        'subtitle' => 'Bose Lab, Dept of Oncology, University of Calgary',
        'period' => 'Oct 2024 — Present',
    ),
    array(
        'title' => 'Ph.D. in Biochemistry & Molecular Biology',
        'subtitle' => 'University of Calgary',
        'period' => '2019 — 2024',
    ),
    array(
        'title' => 'Sessional Instructor',
        'subtitle' => 'University of Calgary',
        'period' => '2024 — 2025',
    ),
    array(
        'title' => 'M.Sc. in Computer Science',
        'subtitle' => 'AIUB, Bangladesh',
        'period' => '2015 — 2017',
    ),
    array(
        'title' => 'Scientific Officer',
        'subtitle' => 'Bangladesh Atomic Energy Commission',
        'period' => '2018 — 2019',
    ),
    array(
        'title' => 'B.Sc. in Computer Science & Engineering',
        'subtitle' => 'AIUB, Bangladesh',
        'period' => '2012 — 2015',
    ),
);

get_header();
?>

<div class="page-header">
    <div class="container">
        <h1 class="page-header__title fade-in-up">
            <?php the_title(); ?>
        </h1>
        <p class="page-header__desc fade-in-up" style="animation-delay:0.1s;">
            <?php echo esc_html__('Researcher, Educator, Developer — bridging AI and genomics.', 'tahsinrahit'); ?>
        </p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="about-content reveal">
            <?php
            if (have_posts()):
                while (have_posts()):
                    the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>

        <div class="about-timeline">
            <?php tahsinrahit_section_heading(__('Education & Experience', 'tahsinrahit')); ?>

            <?php foreach ($timeline as $item): ?>
                <div class="about-timeline__item reveal">
                    <div class="about-timeline__dot"></div>
                    <div>
                        <div class="about-timeline__title">
                            <?php echo esc_html($item['title']); ?>
                        </div>
                        <div class="about-timeline__subtitle">
                            <?php echo esc_html($item['subtitle']); ?>
                        </div>
                        <div class="about-timeline__period">
                            <?php echo esc_html($item['period']); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
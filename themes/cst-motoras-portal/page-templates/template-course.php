<?php
/**
 * Template Name: Curso
 * Template Post Type: page
 *
 * Full-width course landing page: hero → impact → feature cards → FAQ → registration CTA.
 * Structure mirrors cursomotoras.willai.info.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="cst-main">

    <?php
    // 1. Hero section with CTA linking to registration.
    cst_hero( [
        'title'    => get_the_title(),
        'subtitle' => __( 'Módulo en Conducción Segura para Motociclistas y Four Tracks — Requisito Obligatorio de Ley 107', 'cst-motoras' ),
        'cta_text' => __( 'Ver Módulo', 'cst-motoras' ),
        'cta_url'  => '#registro',
        'class'    => 'cst-hero--course',
        'image_url' => get_stylesheet_directory_uri() . '/assets/images/hero-bg.jpg',
    ] );
    ?>

    <?php // 2. Impact section (secondary hero with stat + callouts). ?>
    <?php get_template_part( 'template-parts/section', 'course-impact' ); ?>

    <?php // 3. Feature cards (Digital, Interactive, Certificate). ?>
    <?php get_template_part( 'template-parts/section', 'course-cards' ); ?>

    <?php // 4. FAQ accordion. ?>
    <?php get_template_part( 'template-parts/section', 'course-faq' ); ?>

    <?php // 5. Footer CTA with registration form + contact + disclaimer. ?>
    <?php get_template_part( 'template-parts/section', 'course-footer-cta' ); ?>

</main>

<?php
get_footer();

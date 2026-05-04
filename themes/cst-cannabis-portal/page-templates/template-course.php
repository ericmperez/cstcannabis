<?php
/**
 * Template Name: Curso
 * Template Post Type: page
 *
 * Full-width course landing page: hero → impact → feature cards → FAQ → registration CTA.
 * Structure mirrors cursomotoras.willai.info adapted for cannabis medicinal.
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
        // The page name "Curso" already appears in the breadcrumb / nav highlight,
        // so we promote the descriptive tagline to the H1 and leave the subtitle empty.
        'title'     => __( 'Recurso Educativo Gratuito de la Comisión para la Seguridad en el Tránsito', 'cst-cannabis' ),
        'subtitle'  => '',
        'cta_text'  => __( 'Ver Curso', 'cst-cannabis' ),
        'cta_url'   => home_url( '/courses/curso-cannabis/' ),
        'class'     => 'cst-hero--course',
        'image_url' => get_stylesheet_directory_uri() . '/assets/images/hero-bg.jpg',
    ] );
    ?>

    <?php // 2. Impact section (secondary hero with stat + callouts). ?>
    <?php get_template_part( 'template-parts/section', 'course-impact' ); ?>

    <?php // 3. Feature cards (Digital, Interactive, Certificate). ?>
    <?php get_template_part( 'template-parts/section', 'course-cards' ); ?>

    <?php // 4. FAQ accordion. ?>
    <?php get_template_part( 'template-parts/section', 'course-faq' ); ?>

    <?php // 5. Footer CTA with registration form + contact. ?>
    <?php get_template_part( 'template-parts/section', 'course-footer-cta' ); ?>

    <?php // 6. Centered legal disclaimer above the site footer. ?>
    <?php get_template_part( 'template-parts/section', 'course-disclaimer' ); ?>

</main>

<?php
get_footer();

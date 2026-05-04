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
    // 1. Hero — CTA points logged-in users to the course, everyone else into
    //    the Tutor LMS student-registration flow.
    $course_url   = home_url( '/courses/curso-cannabis/' );
    $tutor_opts   = get_option( 'tutor_option', [] );
    $register_id  = (int) ( $tutor_opts['student_register_page'] ?? 0 );
    $register_url = $register_id ? get_permalink( $register_id ) : home_url( '/student-registration/' );

    cst_hero( [
        'title'     => __( 'Curso de Cannabis y Seguridad Vial', 'cst-cannabis' ),
        'subtitle'  => __( 'Recurso educativo gratuito de la Comisión para la Seguridad en el Tránsito.', 'cst-cannabis' ),
        'cta_text'  => is_user_logged_in()
            ? __( 'Ir al curso', 'cst-cannabis' )
            : __( 'Regístrate', 'cst-cannabis' ),
        'cta_url'   => is_user_logged_in() ? $course_url : $register_url,
        'class'     => 'cst-hero--course',
        // No background image — hero falls back to the CST primary green.
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

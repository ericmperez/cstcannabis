<?php
/**
 * Template Name: Página de inicio
 * Template Post Type: page
 *
 * Front page: hero → trust strip → course modules → course features →
 * statistics → enrollment CTA → posts → events → page content.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="cst-main">

    <?php
    // 1. Hero — single short slogan, rendered in small-caps via theme CSS
    //    (.cst-hero--home .cst-hero__title). No subtitle.
    cst_hero( [
        'eyebrow'          => __( 'Cannabis Medicinal y Seguridad Vial', 'cst-cannabis' ),
        'title'            => __( 'Educación, prevención y datos para proteger vidas', 'cst-cannabis' ),
        'subtitle'         => '',
        'cta_text'         => __( 'Ver Curso', 'cst-cannabis' ),
        'cta_url'          => cst_course_url(),
        'class'            => 'cst-hero--home',
        'image_url'        => get_stylesheet_directory_uri() . '/assets/images/hero-bg.jpg',
        'video_url'        => get_stylesheet_directory_uri() . '/assets/images/hero-bg.mp4',
        'scroll_indicator' => true,
    ] );
    ?>

    <?php // 2. Course pillars (Consumo / Seguridad vial / Protección familiar). ?>
    <?php get_template_part( 'template-parts/section', 'course-pillars' ); ?>

    <?php // 3. Trust strip. ?>
    <?php get_template_part( 'template-parts/section', 'trust-strip' ); ?>

    <?php // 3. Course modules ("Lo que aprenderás"). ?>
    <?php get_template_part( 'template-parts/section', 'objectives' ); ?>

    <?php // 4. Course features. ?>
    <?php get_template_part( 'template-parts/section', 'course-features' ); ?>

    <?php // 5. Statistics (dark background). ?>
    <?php get_template_part( 'template-parts/section', 'stats-highlight' ); ?>

    <?php // 6. Enrollment CTA. ?>
    <?php get_template_part( 'template-parts/section', 'enrollment-cta' ); ?>

    <?php // 7. Latest blog posts. ?>
    <?php get_template_part( 'template-parts/section', 'latest-posts' ); ?>

    <?php // 8. Upcoming events (The Events Calendar). ?>
    <?php get_template_part( 'template-parts/section', 'upcoming-events' ); ?>

    <?php
    // 9. Page content (if any).
    while ( have_posts() ) :
        the_post();
        $content = get_the_content();
        if ( trim( $content ) ) :
    ?>
        <section class="cst-section">
            <div class="cst-container cst-content-area">
                <?php the_content(); ?>
            </div>
        </section>
    <?php
        endif;
    endwhile;
    ?>

</main>

<?php
get_footer();

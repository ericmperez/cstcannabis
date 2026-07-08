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
    // 1. Hero — institutional authority treatment (left-aligned sentence-case
    //    title, navy scrim, no marketing decor). Copy/photo are real; badges
    //    reuse facts already published in trust strip / enrollment CTA.
    cst_hero( [
        'eyebrow'   => __( 'Cannabis Medicinal y Seguridad Vial', 'cst-cannabis' ),
        'title'     => __( 'Educación, prevención y datos para proteger vidas', 'cst-cannabis' ),
        'subtitle'  => __( 'Recurso educativo gratuito de la Comisión para la Seguridad en el Tránsito.', 'cst-cannabis' ),
        'cta_text'  => __( 'Ver Curso', 'cst-cannabis' ),
        'cta_url'   => cst_course_url(),
        'cta2_text' => __( 'Ver recursos', 'cst-cannabis' ),
        'cta2_url'  => home_url( '/recursos/' ),
        'class'     => 'cst-hero--home',
        'image_url' => get_stylesheet_directory_uri() . '/assets/images/hero-home.jpg',
        'trust_badges' => [
            [
                'icon'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/></svg>',
                'label' => __( 'Certificado digital', 'cst-cannabis' ),
            ],
            [
                'icon'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14z"/></svg>',
                'label' => __( '100% en línea', 'cst-cannabis' ),
            ],
            [
                'icon'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>',
                'label' => __( 'Gratuito', 'cst-cannabis' ),
            ],
        ],
    ] );
    ?>

    <?php // 1b. Critical safety strip — red = critical (CST palette recommendation). ?>
    <aside class="cst-critical-strip" aria-label="<?php esc_attr_e( 'Mensaje de seguridad', 'cst-cannabis' ); ?>">
        <div class="cst-container cst-critical-strip__inner">
            <svg class="cst-critical-strip__icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/>
            </svg>
            <p class="cst-critical-strip__msg">
                <strong><?php esc_html_e( 'Si consumiste, no manejes.', 'cst-cannabis' ); ?></strong>
                <span><?php esc_html_e( 'El cannabis reduce tus reflejos y tu tiempo de reacción.', 'cst-cannabis' ); ?></span>
            </p>
        </div>
    </aside>

    <?php // 2. Course pillars (Consumo / Seguridad vial / Protección familiar). ?>
    <?php get_template_part( 'template-parts/section', 'course-pillars' ); ?>

    <?php // 3. Trust strip. ?>
    <?php get_template_part( 'template-parts/section', 'trust-strip' ); ?>

    <?php // 3. Course modules ("Lo que aprenderás"). ?>
    <?php get_template_part( 'template-parts/section', 'objectives' ); ?>

    <?php // 4. Course features. ?>
    <?php get_template_part( 'template-parts/section', 'course-features' ); ?>

    <?php // 6. Enrollment CTA. ?>
    <?php get_template_part( 'template-parts/section', 'enrollment-cta' ); ?>

    <?php // 7. Latest blog posts — blog disabled by request (see below). ?>
    <?php // get_template_part( 'template-parts/section', 'latest-posts' ); ?>

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

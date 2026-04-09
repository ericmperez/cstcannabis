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
    // 1. Hero section (with trust badges + scroll indicator).
    $hero_title    = get_theme_mod( 'cst_hero_title', '' ) ?: get_bloginfo( 'name' );
    $hero_subtitle = get_theme_mod( 'cst_hero_subtitle', '' ) ?: get_bloginfo( 'description' );
    cst_hero( [
        'title'            => $hero_title,
        'subtitle'         => $hero_subtitle,
        'cta_text'         => __( 'Ver Módulo', 'cst-motoras' ),
        'cta_url'          => 'https://cursomotoras.willai.info/courses/modulo-conduccion-segura-para-motociclistas/',
        'cta2_text'        => __( 'Ver temario', 'cst-motoras' ),
        'cta2_url'         => 'https://cursomotoras.willai.info/courses/modulo-conduccion-segura-para-motociclistas/#temario',
        'class'            => 'cst-hero--home',
        'image_url'        => get_stylesheet_directory_uri() . '/assets/images/hero-bg.jpg',
        'scroll_indicator' => true,
        'trust_badges'     => [
            [ 'icon' => '💰', 'label' => __( 'Gratuito', 'cst-motoras' ) ],
            [ 'icon' => '📜', 'label' => __( 'Certificado Verificable', 'cst-motoras' ) ],
            [ 'icon' => '💻', 'label' => __( '100% Digital', 'cst-motoras' ) ],
            [ 'icon' => '⚖️', 'label' => __( 'Requisito de Ley', 'cst-motoras' ) ],
        ],
    ] );
    ?>

    <?php // 2. Trust strip. ?>
    <?php get_template_part( 'template-parts/section', 'trust-strip' ); ?>

    <?php // 3. Course modules ("Lo que aprenderás"). ?>
    <?php get_template_part( 'template-parts/section', 'objectives' ); ?>

    <?php // 4. Course features. ?>
    <?php get_template_part( 'template-parts/section', 'course-features' ); ?>

    <?php // 5. Statistics (dark background). ?>
    <?php get_template_part( 'template-parts/section', 'stats-highlight' ); ?>

    <?php // 6. FAQ section. ?>
    <?php get_template_part( 'template-parts/section', 'faq' ); ?>

    <?php // 7. Enrollment CTA. ?>
    <?php get_template_part( 'template-parts/section', 'enrollment-cta' ); ?>

    <?php // 8. Latest blog posts. ?>
    <?php get_template_part( 'template-parts/section', 'latest-posts' ); ?>

    <?php // 9. Upcoming events (The Events Calendar). ?>
    <?php get_template_part( 'template-parts/section', 'upcoming-events' ); ?>

    <?php
    // 10. Page content (if any).
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

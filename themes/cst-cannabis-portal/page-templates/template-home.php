<?php
/**
 * Template Name: Página de inicio
 * Template Post Type: page
 *
 * Front page: hero, objectives, latest posts, upcoming events, stats, resources CTA.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="cst-main">

    <?php
    // Hero section.
    $hero_title    = get_theme_mod( 'cst_hero_title', '' ) ?: get_bloginfo( 'name' );
    $hero_subtitle = get_theme_mod( 'cst_hero_subtitle', '' ) ?: get_bloginfo( 'description' );
    cst_hero( [
        'title'      => $hero_title,
        'subtitle'   => $hero_subtitle,
        'cta_text'   => __( 'Inscríbete al curso gratuito', 'cst-cannabis' ),
        'cta_url'    => home_url( '/curso/' ),
        'cta2_text'  => __( 'Conoce más', 'cst-cannabis' ),
        'cta2_url'   => '#objetivos',
        'class'      => 'cst-hero--home',
        'image_url'  => get_stylesheet_directory_uri() . '/assets/images/hero-bg.jpg',
    ] );
    ?>

    <?php // Objectives grid. ?>
    <?php get_template_part( 'template-parts/section', 'objectives' ); ?>

    <?php // Latest blog posts. ?>
    <?php get_template_part( 'template-parts/section', 'latest-posts' ); ?>

    <?php // Upcoming events (The Events Calendar). ?>
    <?php get_template_part( 'template-parts/section', 'upcoming-events' ); ?>

    <?php // Statistics highlights. ?>
    <?php get_template_part( 'template-parts/section', 'stats-highlight' ); ?>

    <?php // Resources CTA. ?>
    <section class="cst-section cst-section--cta" aria-label="<?php esc_attr_e( 'Recursos educativos', 'cst-cannabis' ); ?>">
        <div class="cst-container cst-text-center">
            <?php cst_section_heading(
                __( 'Recursos educativos', 'cst-cannabis' ),
                __( 'Descarga guías, infografías y materiales sobre el uso responsable del cannabis medicinal.', 'cst-cannabis' )
            ); ?>
            <?php cst_cta_button(
                __( 'Ver todos los recursos', 'cst-cannabis' ),
                home_url( '/recursos/' ),
                'primary'
            ); ?>
        </div>
    </section>

    <?php
    // Page content (if any).
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

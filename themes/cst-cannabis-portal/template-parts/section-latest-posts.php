<?php
/**
 * Template Part: Latest blog posts (home page).
 *
 * Shows 3 most recent blog posts as cards.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$latest = new WP_Query( [
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
] );

if ( ! $latest->have_posts() ) {
    return;
}
?>

<section class="cst-section cst-section--latest-posts"
         aria-label="<?php esc_attr_e( 'Últimas publicaciones', 'cst-cannabis' ); ?>">
    <div class="cst-container">
        <?php cst_section_heading(
            __( 'Últimas publicaciones', 'cst-cannabis' ),
            __( 'Artículos recientes sobre cannabis medicinal y seguridad vial.', 'cst-cannabis' )
        ); ?>

        <div class="cst-card-grid cst-card-grid--3">
            <?php
            while ( $latest->have_posts() ) :
                $latest->the_post();
                get_template_part( 'template-parts/card', 'blog' );
            endwhile;
            wp_reset_postdata();
            ?>
        </div>

        <div class="cst-section__footer cst-text-center">
            <?php cst_cta_button(
                __( 'Ver todas las publicaciones', 'cst-cannabis' ),
                get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ),
                'outline'
            ); ?>
        </div>
    </div>
</section>

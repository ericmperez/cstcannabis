<?php
/**
 * Blog archive template (Posts page).
 *
 * Displays posts in a 3-column card grid using the card-blog template part.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="cst-main cst-main--blog">

    <?php
    cst_hero( [
        'eyebrow'  => __( 'Portal CST', 'cst-cannabis' ),
        'title'    => __( 'Blog', 'cst-cannabis' ),
        'subtitle' => __( 'Artículos sobre cannabis medicinal y seguridad vial.', 'cst-cannabis' ),
        'class'    => 'cst-hero--page cst-hero--slim cst-hero--blog',
    ] );
    ?>

    <section class="cst-section cst-section--blog-archive" aria-label="<?php esc_attr_e( 'Listado de artículos', 'cst-cannabis' ); ?>">
        <div class="cst-container">

            <?php if ( have_posts() ) : ?>

                <div class="cst-card-grid cst-card-grid--3">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/card', 'blog' );
                    endwhile;
                    ?>
                </div>

                <nav class="cst-pagination" aria-label="<?php esc_attr_e( 'Paginación del blog', 'cst-cannabis' ); ?>">
                    <?php
                    the_posts_pagination( [
                        'mid_size'  => 2,
                        'prev_text' => '&larr; ' . __( 'Anteriores', 'cst-cannabis' ),
                        'next_text' => __( 'Siguientes', 'cst-cannabis' ) . ' &rarr;',
                        'class'     => 'cst-pagination__nav',
                    ] );
                    ?>
                </nav>

            <?php else : ?>

                <p class="cst-empty-state">
                    <?php esc_html_e( 'No hay publicaciones disponibles en este momento.', 'cst-cannabis' ); ?>
                </p>

            <?php endif; ?>

        </div>
    </section>

</main>

<?php
get_footer();

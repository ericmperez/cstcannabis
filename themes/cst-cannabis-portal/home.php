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

<main id="main-content" class="cst-main">

    <?php
    cst_hero( [
        'title'    => __( 'Blog', 'cst-cannabis' ),
        'subtitle' => __( 'Artículos recientes sobre cannabis medicinal y seguridad vial.', 'cst-cannabis' ),
        'class'    => 'cst-hero--page cst-hero--slim',
    ] );
    ?>

    <section class="cst-section">
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

                <?php
                the_posts_pagination( [
                    'mid_size'  => 2,
                    'prev_text' => '&larr; ' . __( 'Anteriores', 'cst-cannabis' ),
                    'next_text' => __( 'Siguientes', 'cst-cannabis' ) . ' &rarr;',
                ] );
                ?>

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

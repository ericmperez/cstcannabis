<?php
/**
 * Template Name: Estadísticas
 * Template Post Type: page
 *
 * Public metrics dashboard. Renders the [cst_statistics] shortcode.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="cst-main">

    <?php
    cst_hero( [
        'title'    => get_the_title(),
        'subtitle' => __( 'Datos y métricas sobre la seguridad vial y el uso del cannabis medicinal en Puerto Rico.', 'cst-cannabis' ),
        'class'    => 'cst-hero--page',
    ] );
    ?>

    <section class="cst-section cst-section--statistics">
        <div class="cst-container">

            <?php
            // The cst_statistics shortcode is provided by cst-core plugin.
            echo do_shortcode( '[cst_statistics]' );
            ?>

            <?php
            // Additional page content.
            while ( have_posts() ) :
                the_post();
                $content = get_the_content();
                if ( trim( $content ) ) :
            ?>
                <div class="cst-content-area">
                    <?php the_content(); ?>
                </div>
            <?php
                endif;
            endwhile;
            ?>

        </div>
    </section>

</main>

<?php
get_footer();

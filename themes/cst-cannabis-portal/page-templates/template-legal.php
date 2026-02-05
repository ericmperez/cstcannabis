<?php
/**
 * Template Name: Página legal
 * Template Post Type: page
 *
 * Legal pages with auto-generated table of contents from headings.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="cst-main">

    <?php
    cst_hero( [
        'title' => get_the_title(),
        'class' => 'cst-hero--page cst-hero--legal',
    ] );
    ?>

    <section class="cst-section cst-section--legal">
        <div class="cst-container">
            <div class="cst-legal-layout">

                <!-- Auto-generated TOC (populated by JS) -->
                <aside class="cst-legal-toc" aria-label="<?php esc_attr_e( 'Tabla de contenido', 'cst-cannabis' ); ?>">
                    <h2 class="cst-legal-toc__title"><?php esc_html_e( 'Contenido', 'cst-cannabis' ); ?></h2>
                    <nav id="cst-toc-nav">
                        <ol class="cst-legal-toc__list" id="cst-toc-list">
                            <!-- Populated by main.js -->
                        </ol>
                    </nav>
                </aside>

                <!-- Content -->
                <article class="cst-legal-content cst-content-area" id="cst-legal-article">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        the_content();
                    endwhile;
                    ?>

                    <div class="cst-legal-meta">
                        <p class="cst-legal-meta__updated">
                            <?php
                            printf(
                                /* translators: %s: last modified date */
                                esc_html__( 'Última actualización: %s', 'cst-cannabis' ),
                                esc_html( get_the_modified_date() )
                            );
                            ?>
                        </p>
                    </div>
                </article>

            </div>
        </div>
    </section>

</main>

<?php
get_footer();

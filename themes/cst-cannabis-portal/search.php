<?php
/**
 * Search results — CST-branded.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$query  = get_search_query();
$count  = (int) $GLOBALS['wp_query']->found_posts;
?>

<main id="main-content" class="cst-main">
    <?php
    cst_hero( [
        'title'    => sprintf(
            /* translators: %s: search term */
            __( 'Resultados para: %s', 'cst-cannabis' ),
            esc_html( $query )
        ),
        'subtitle' => sprintf(
            /* translators: %d: number of results */
            _n( '%d resultado encontrado.', '%d resultados encontrados.', $count, 'cst-cannabis' ),
            $count
        ),
        'class'    => 'cst-hero--page cst-hero--search',
    ] );
    ?>

    <section class="cst-section">
        <div class="cst-container">
            <div class="cst-search-page__form">
                <?php get_search_form(); ?>
            </div>

            <?php if ( have_posts() ) : ?>
                <ul class="cst-search-results">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <li class="cst-search-result">
                            <h2 class="cst-search-result__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <p class="cst-search-result__meta">
                                <span class="cst-search-result__type"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
                                <span class="cst-search-result__date"><?php echo esc_html( get_the_date() ); ?></span>
                            </p>
                            <div class="cst-search-result__excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <a class="cst-search-result__read-more" href="<?php the_permalink(); ?>">
                                <?php esc_html_e( 'Leer más', 'cst-cannabis' ); ?> &rarr;
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>

                <nav class="cst-pagination" aria-label="<?php esc_attr_e( 'Paginación de resultados', 'cst-cannabis' ); ?>">
                    <?php
                    the_posts_pagination( [
                        'prev_text' => '&larr; ' . __( 'Anteriores', 'cst-cannabis' ),
                        'next_text' => __( 'Siguientes', 'cst-cannabis' ) . ' &rarr;',
                    ] );
                    ?>
                </nav>
            <?php else : ?>
                <div class="cst-search-empty">
                    <h2><?php esc_html_e( 'No encontramos nada.', 'cst-cannabis' ); ?></h2>
                    <p>
                        <?php esc_html_e( 'Pruebe con otras palabras clave o explore las secciones del portal:', 'cst-cannabis' ); ?>
                    </p>
                    <ul class="cst-404__links">
                        <li><a class="cst-btn cst-btn--primary" href="<?php echo esc_url( cst_course_url() ); ?>"><?php esc_html_e( 'Ver Curso', 'cst-cannabis' ); ?></a></li>
                        <li><a class="cst-btn cst-btn--outline" href="<?php echo esc_url( home_url( '/recursos/' ) ); ?>"><?php esc_html_e( 'Recursos', 'cst-cannabis' ); ?></a></li>
                        <li><a class="cst-btn cst-btn--outline" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>"><?php esc_html_e( 'Contacto', 'cst-cannabis' ); ?></a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_footer();

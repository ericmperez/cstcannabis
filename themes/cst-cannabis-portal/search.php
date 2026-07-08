<?php
/**
 * Search results — CST-branded.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$query = get_search_query();
$count = (int) $GLOBALS['wp_query']->found_posts;
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
                <div class="cst-card-grid cst-card-grid--search">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        $type_object = get_post_type_object( get_post_type() );
                        $type_label  = $type_object ? $type_object->labels->singular_name : '';
                        ?>
                        <article class="cst-card cst-card--search" aria-label="<?php the_title_attribute(); ?>">
                            <div class="cst-card__body">
                                <?php if ( $type_label ) : ?>
                                    <div class="cst-card__tags">
                                        <span class="cst-tag"><?php echo esc_html( $type_label ); ?></span>
                                    </div>
                                <?php endif; ?>

                                <h2 class="cst-card__title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>

                                <div class="cst-card__meta">
                                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                        <?php echo esc_html( get_the_date() ); ?>
                                    </time>
                                </div>

                                <p class="cst-card__excerpt">
                                    <?php echo esc_html( wp_trim_words( get_the_excerpt(), 24, '…' ) ); ?>
                                </p>

                                <a href="<?php the_permalink(); ?>" class="cst-card__link">
                                    <?php esc_html_e( 'Leer más', 'cst-cannabis' ); ?>
                                    <span class="sr-only">: <?php the_title(); ?></span>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                        <path d="M8.354 1.646a.5.5 0 010 .708L3.207 7.5H14.5a.5.5 0 010 1H3.207l5.147 5.146a.5.5 0 01-.708.708l-6-6a.5.5 0 010-.708l6-6a.5.5 0 01.708 0z" transform="scale(-1,1) translate(-16,0)"/>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="cst-pagination">
                    <?php
                    the_posts_pagination( [
                        'prev_text'          => '&larr; ' . __( 'Anteriores', 'cst-cannabis' ),
                        'next_text'          => __( 'Siguientes', 'cst-cannabis' ) . ' &rarr;',
                        'screen_reader_text' => __( 'Paginación de resultados', 'cst-cannabis' ),
                        'aria_label'         => __( 'Paginación de resultados', 'cst-cannabis' ),
                    ] );
                    ?>
                </div>
            <?php else : ?>
                <div class="cst-search-empty">
                    <svg class="cst-search-empty__icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="M21 21l-4.35-4.35"/>
                    </svg>
                    <h2><?php esc_html_e( 'No encontramos nada.', 'cst-cannabis' ); ?></h2>
                    <p>
                        <?php esc_html_e( 'Pruebe con otras palabras clave o explore las secciones del portal:', 'cst-cannabis' ); ?>
                    </p>
                    <ul class="cst-search-empty__actions">
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

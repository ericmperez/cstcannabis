<?php
/**
 * Archive template for cst_resource CPT.
 *
 * Uses the same hero header as page templates, then lists resources
 * with filter tabs and card grid (mirroring template-resources.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="cst-main">

    <?php
    cst_hero( [
        'title'    => __( 'Recursos', 'cst-motoras' ),
        'subtitle' => __( 'Guías, infografías, videos y documentos sobre la conducción segura de motocicletas y four tracks.', 'cst-motoras' ),
        'class'    => 'cst-hero--page',
    ] );
    ?>

    <section class="cst-section cst-section--resources">
        <div class="cst-container">

            <?php
            // Taxonomy filter tabs.
            $resource_types = get_terms( [
                'taxonomy'   => 'cst_resource_type',
                'hide_empty' => true,
            ] );
            ?>

            <?php if ( ! is_wp_error( $resource_types ) && ! empty( $resource_types ) ) : ?>
                <nav class="cst-filter-tabs" aria-label="<?php esc_attr_e( 'Filtrar por tipo de recurso', 'cst-motoras' ); ?>">
                    <ul class="cst-filter-tabs__list" role="tablist">
                        <li role="presentation">
                            <button role="tab" class="cst-filter-tabs__btn is-active"
                                    data-filter="all" aria-selected="true">
                                <?php esc_html_e( 'Todos', 'cst-motoras' ); ?>
                            </button>
                        </li>
                        <?php foreach ( $resource_types as $type ) : ?>
                            <li role="presentation">
                                <button role="tab" class="cst-filter-tabs__btn"
                                        data-filter="<?php echo esc_attr( $type->slug ); ?>"
                                        aria-selected="false">
                                    <?php echo esc_html( $type->name ); ?>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            <?php endif; ?>

            <?php if ( have_posts() ) : ?>
                <div class="cst-card-grid cst-card-grid--resources" role="tabpanel" aria-live="polite">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/card', 'resource' );
                    endwhile;
                    ?>
                </div>

                <?php the_posts_navigation( [
                    'prev_text' => __( '&larr; Recursos anteriores', 'cst-motoras' ),
                    'next_text' => __( 'Más recursos &rarr;', 'cst-motoras' ),
                ] ); ?>

            <?php else : ?>
                <p class="cst-empty-state">
                    <?php esc_html_e( 'Próximamente se publicarán recursos educativos.', 'cst-motoras' ); ?>
                </p>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php
get_footer();

<?php
/**
 * Template Name: Recursos educativos
 * Template Post Type: page
 *
 * Resources listing with taxonomy filter tabs, card grid.
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
        'subtitle' => __( 'Guías, infografías, videos y documentos sobre el uso responsable del cannabis medicinal.', 'cst-cannabis' ),
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
                <nav class="cst-filter-tabs" aria-label="<?php esc_attr_e( 'Filtrar por tipo de recurso', 'cst-cannabis' ); ?>">
                    <ul class="cst-filter-tabs__list" role="tablist">
                        <li role="presentation">
                            <button role="tab" class="cst-filter-tabs__btn is-active"
                                    data-filter="all" aria-selected="true">
                                <?php esc_html_e( 'Todos', 'cst-cannabis' ); ?>
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

            <?php
            // Resource cards.
            $resources = new WP_Query( [
                'post_type'      => 'cst_resource',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ] );
            ?>

            <?php if ( $resources->have_posts() ) : ?>
                <div class="cst-card-grid cst-card-grid--resources" role="tabpanel" aria-live="polite">
                    <?php
                    while ( $resources->have_posts() ) :
                        $resources->the_post();
                        get_template_part( 'template-parts/card', 'resource' );
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            <?php else : ?>
                <p class="cst-empty-state">
                    <?php esc_html_e( 'Próximamente se publicarán recursos educativos.', 'cst-cannabis' ); ?>
                </p>
            <?php endif; ?>

            <?php
            // Page content (Download Manager shortcodes, etc.).
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

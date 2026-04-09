<?php
/**
 * Template Part: Key statistics cards (home page).
 *
 * Shows up to 4 statistics from the cst_statistic CPT.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$stats = new WP_Query( [
    'post_type'      => 'cst_statistic',
    'posts_per_page' => 4,
    'meta_key'       => '_cst_stat_order',
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC',
] );

if ( ! $stats->have_posts() ) {
    return;
}
?>

<?php $stats_class = is_front_page() ? 'cst-section cst-section--stats cst-section--stats-dark' : 'cst-section cst-section--stats'; ?>
<section class="<?php echo esc_attr( $stats_class ); ?>"
         aria-label="<?php esc_attr_e( 'Estadísticas destacadas', 'cst-motoras' ); ?>">
    <div class="cst-container">
        <?php cst_section_heading(
            __( 'Cifras clave', 'cst-motoras' ),
            __( 'Datos actualizados sobre la seguridad vial para motociclistas y conductores de four tracks en Puerto Rico.', 'cst-motoras' )
        ); ?>

        <div class="cst-stats-grid">
            <?php while ( $stats->have_posts() ) : $stats->the_post();
                $value  = get_post_meta( get_the_ID(), '_cst_stat_value', true );
                $unit   = get_post_meta( get_the_ID(), '_cst_stat_unit', true );
                $icon   = get_post_meta( get_the_ID(), '_cst_stat_icon', true );
                $source = get_post_meta( get_the_ID(), '_cst_stat_source', true );
            ?>
                <div class="cst-stat-card" data-target="<?php echo esc_attr( $value ); ?>">
                    <?php if ( $icon ) : ?>
                        <span class="cst-stat-card__icon dashicons <?php echo esc_attr( $icon ); ?>" aria-hidden="true"></span>
                    <?php endif; ?>
                    <span class="cst-stat-card__value" aria-live="polite">
                        <span class="cst-stat-counter" data-value="<?php echo esc_attr( $value ); ?>">0</span><?php if ( $unit ) : ?><span class="cst-stat-card__unit"><?php echo esc_html( $unit ); ?></span><?php endif; ?>
                    </span>
                    <span class="cst-stat-card__label"><?php the_title(); ?></span>
                    <?php if ( $source ) : ?>
                        <span class="cst-stat-card__source"><?php echo esc_html( $source ); ?></span>
                    <?php endif; ?>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <div class="cst-section__footer cst-text-center">
            <?php cst_cta_button(
                __( 'Ver todas las estadísticas', 'cst-motoras' ),
                home_url( '/estadisticas/' ),
                'outline'
            ); ?>
        </div>
    </div>
</section>

<?php
/**
 * Template Part: Upcoming events from The Events Calendar (home page).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Requires The Events Calendar plugin.
if ( ! function_exists( 'tribe_get_events' ) ) {
    return;
}

$events = tribe_get_events( [
    'posts_per_page' => 3,
    'start_date'     => 'now',
    'order'          => 'ASC',
] );

if ( empty( $events ) ) {
    return;
}
?>

<section class="cst-section cst-section--events"
         aria-label="<?php esc_attr_e( 'Próximos eventos', 'cst-cannabis' ); ?>">
    <div class="cst-container">
        <?php cst_section_heading(
            __( 'Próximos eventos', 'cst-cannabis' ),
            __( 'Talleres, seminarios y actividades educativas.', 'cst-cannabis' )
        ); ?>

        <div class="cst-card-grid cst-card-grid--3">
            <?php
            global $post;
            foreach ( $events as $post ) :
                setup_postdata( $post );
                get_template_part( 'template-parts/card', 'event' );
            endforeach;
            wp_reset_postdata();
            ?>
        </div>

        <div class="cst-section__footer cst-text-center">
            <?php cst_cta_button(
                __( 'Ver todos los eventos', 'cst-cannabis' ),
                function_exists( 'tribe_get_events_link' ) ? tribe_get_events_link() : home_url( '/eventos/' ),
                'outline'
            ); ?>
        </div>
    </div>
</section>

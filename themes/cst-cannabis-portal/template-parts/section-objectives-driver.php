<?php
/**
 * Template Part: Driver Education Objectives grid (home page).
 *
 * 3-column grid showing the portal's driver education objectives.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$objectives = [
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/></svg>',
        'title' => __( 'Conducción segura', 'cst-cannabis' ),
        'desc'  => __( 'Conozca cómo el cannabis afecta sus habilidades de conducción: tiempo de reacción, coordinación y toma de decisiones.', 'cst-cannabis' ),
    ],
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M4 10.5c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5 1.5-.67 1.5-1.5-.67-1.5-1.5-1.5zm0-6c-.83 0-1.5.67-1.5 1.5S3.17 7.5 4 7.5 5.5 6.83 5.5 6 4.83 4.5 4 4.5zm0 12c-.83 0-1.5.68-1.5 1.5s.68 1.5 1.5 1.5 1.5-.68 1.5-1.5-.67-1.5-1.5-1.5zM7 19h14v-2H7v2zm0-6h14v-2H7v2zm0-8v2h14V5H7z"/></svg>',
        'title' => __( 'Marco legal', 'cst-cannabis' ),
        'desc'  => __( 'Entienda las leyes de Puerto Rico sobre cannabis y conducción, las penalidades y sus derechos como conductor.', 'cst-cannabis' ),
    ],
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L18 9l-8 8z"/></svg>',
        'title' => __( 'Decisiones responsables', 'cst-cannabis' ),
        'desc'  => __( 'Aprenda estrategias prácticas: planificación de transporte, tiempos de espera y alternativas seguras para llegar a su destino.', 'cst-cannabis' ),
    ],
];
?>

<section class="cst-section cst-section--objectives" id="objetivos"
         aria-label="<?php esc_attr_e( 'Objetivos del curso', 'cst-cannabis' ); ?>">
    <div class="cst-container">
        <?php cst_section_heading(
            __( '¿Qué aprenderá en este curso?', 'cst-cannabis' ),
            __( 'Un programa integral para conductores sobre cannabis y seguridad vial.', 'cst-cannabis' )
        ); ?>

        <div class="cst-objectives-grid">
            <?php foreach ( $objectives as $obj ) : ?>
                <div class="cst-objective-card">
                    <div class="cst-objective-card__icon" aria-hidden="true">
                        <?php echo $obj['icon']; ?>
                    </div>
                    <h3 class="cst-objective-card__title"><?php echo esc_html( $obj['title'] ); ?></h3>
                    <p class="cst-objective-card__desc"><?php echo esc_html( $obj['desc'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

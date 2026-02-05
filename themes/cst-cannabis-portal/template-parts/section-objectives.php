<?php
/**
 * Template Part: Objectives grid (home page).
 *
 * 3-column grid showing the portal's main objectives.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$objectives = [
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>',
        'title' => __( 'Educar', 'cst-cannabis' ),
        'desc'  => __( 'Proveer información basada en evidencia sobre el uso responsable del cannabis medicinal y su impacto en la seguridad vial.', 'cst-cannabis' ),
    ],
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>',
        'title' => __( 'Concientizar', 'cst-cannabis' ),
        'desc'  => __( 'Crear conciencia sobre los efectos del cannabis en la conducción y promover alternativas seguras de transporte.', 'cst-cannabis' ),
    ],
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>',
        'title' => __( 'Investigar', 'cst-cannabis' ),
        'desc'  => __( 'Recopilar y publicar datos estadísticos actualizados que apoyen políticas públicas informadas.', 'cst-cannabis' ),
    ],
];
?>

<section class="cst-section cst-section--objectives" id="objetivos"
         aria-label="<?php esc_attr_e( 'Objetivos del portal', 'cst-cannabis' ); ?>">
    <div class="cst-container">
        <?php cst_section_heading(
            __( 'Nuestros objetivos', 'cst-cannabis' ),
            __( 'Trabajamos para una Puerto Rico más segura e informada.', 'cst-cannabis' )
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

<?php
/**
 * Template Part: Course Features.
 *
 * Checklist of course details: duration, format, certificate, language, cost.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$features = [
    [
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>',
        'label' => __( 'Duración', 'cst-cannabis' ),
        'value' => __( 'Aproximadamente 2 horas', 'cst-cannabis' ),
    ],
    [
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M21 3H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h5v2h8v-2h5c1.1 0 1.99-.9 1.99-2L23 5c0-1.1-.9-2-2-2zm0 14H3V5h18v12z"/></svg>',
        'label' => __( 'Formato', 'cst-cannabis' ),
        'value' => __( '100% en línea, a tu ritmo', 'cst-cannabis' ),
    ],
    [
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>',
        'label' => __( 'Certificado', 'cst-cannabis' ),
        'value' => __( 'Certificado digital al completar', 'cst-cannabis' ),
    ],
    [
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM18 14H6v-2h12v2z"/></svg>',
        'label' => __( 'Idioma', 'cst-cannabis' ),
        'value' => __( 'Español', 'cst-cannabis' ),
    ],
    [
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.94s4.18 1.36 4.18 3.85c0 1.89-1.44 2.98-3.12 3.19z"/></svg>',
        'label' => __( 'Costo', 'cst-cannabis' ),
        'value' => __( 'Completamente gratuito', 'cst-cannabis' ),
    ],
    [
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>',
        'label' => __( 'Requisitos', 'cst-cannabis' ),
        'value' => __( 'Ninguno — abierto a todo público', 'cst-cannabis' ),
    ],
];
?>

<section class="cst-section cst-section--course-features"
         aria-label="<?php esc_attr_e( 'Características del curso', 'cst-cannabis' ); ?>">
    <div class="cst-container">
        <?php cst_section_heading(
            __( 'Características del curso', 'cst-cannabis' ),
            __( 'Todo lo que necesitas saber antes de comenzar.', 'cst-cannabis' )
        ); ?>

        <div class="cst-course-features__grid">
            <?php foreach ( $features as $feature ) : ?>
                <div class="cst-course-feature">
                    <div class="cst-course-feature__icon" aria-hidden="true">
                        <?php echo $feature['icon']; ?>
                    </div>
                    <h3 class="cst-course-feature__label"><?php echo esc_html( $feature['label'] ); ?></h3>
                    <p class="cst-course-feature__value"><?php echo esc_html( $feature['value'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

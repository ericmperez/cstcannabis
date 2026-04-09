<?php
/**
 * Template Part: Course modules / learning objectives (home page).
 *
 * 3-column grid showing what the student will learn.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$objectives = [
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>',
        'title' => __( 'Módulo 1: Fundamentos, Ley 22 y Tipos de Motocicletas', 'cst-motoras' ),
        'desc'  => __( 'Responsabilidades del conductor, reglas de seguridad, requisitos legales bajo la Ley 22, clasificaciones de motocicletas e inspecciones mecánicas previas al viaje.', 'cst-motoras' ),
    ],
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>',
        'title' => __( 'Módulo 2: Viste para el Impacto — Casco y Equipo Completo', 'cst-motoras' ),
        'desc'  => __( 'Absorción de impactos, certificaciones de seguridad (DOT, ECE, Snell), tipos de casco, protección corporal completa y visibilidad.', 'cst-motoras' ),
    ],
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/></svg>',
        'title' => __( 'Módulo 3: Control Básico y Conducción Defensiva', 'cst-motoras' ),
        'desc'  => __( 'Control técnico y coordinación, técnicas de conducción defensiva, manejo de curvas, frenado controlado y condiciones especiales (lluvia, noche, viento).', 'cst-motoras' ),
    ],
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>',
        'title' => __( 'Módulo 4: Factores Humanos y Respuesta ante Choques', 'cst-motoras' ),
        'desc'  => __( 'Reconocimiento de impedimentos, tiempo de reacción, protocolos de emergencia, primeros auxilios y responsabilidad del motociclista.', 'cst-motoras' ),
    ],
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>',
        'title' => __( 'Módulo 5: Examen Final', 'cst-motoras' ),
        'desc'  => __( 'Evaluación comprensiva de todos los módulos. Aprueba con 70% o más para obtener tu certificado digital verificable con código QR.', 'cst-motoras' ),
    ],
];
?>

<section class="cst-section cst-section--objectives" id="objetivos"
         aria-label="<?php esc_attr_e( 'Lo que aprenderás', 'cst-motoras' ); ?>">
    <div class="cst-container">
        <?php cst_section_heading(
            __( 'Lo que aprenderás', 'cst-motoras' ),
            __( 'Cinco módulos educativos basados en estándares locales y federales para la conducción segura de motocicletas y four tracks.', 'cst-motoras' )
        ); ?>

        <div class="cst-objectives-grid">
            <?php foreach ( $objectives as $index => $obj ) : ?>
                <div class="cst-objective-card" data-step="<?php echo esc_attr( $index + 1 ); ?>">
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

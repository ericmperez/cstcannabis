<?php
/**
 * Template Part: Course Impact Section.
 *
 * Dark navy section with stat callout and 3 feature highlights.
 * Mirrors the "Reduciendo Riesgos" section from cursomotoras.willai.info.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$callouts = [
    [
        'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>',
        'title' => __( 'Basado en evidencia', 'cst-cannabis' ),
        'desc'  => __( 'Contenido desarrollado con base en estudios científicos y estándares locales y federales.', 'cst-cannabis' ),
    ],
    [
        'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>',
        'title' => __( 'Alianzas confiables', 'cst-cannabis' ),
        'desc'  => __( 'Colaboración entre agencias gubernamentales para promover una cultura de uso responsable.', 'cst-cannabis' ),
    ],
    [
        'icon'  => '<svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>',
        'title' => __( 'Educación preventiva', 'cst-cannabis' ),
        'desc'  => __( 'Formación obligatoria para garantizar la seguridad vial de pacientes y conductores.', 'cst-cannabis' ),
    ],
];
?>

<section class="cst-section cst-section--course-impact" role="region"
         aria-label="<?php esc_attr_e( 'Impacto del curso', 'cst-cannabis' ); ?>">
    <div class="cst-container">

        <div class="cst-course-impact__grid">
            <div class="cst-course-impact__text">
                <h2 class="cst-course-impact__title">
                    <?php esc_html_e( 'Educando para un Uso Responsable del Cannabis Medicinal en Puerto Rico', 'cst-cannabis' ); ?>
                </h2>
                <p class="cst-course-impact__desc">
                    <?php esc_html_e( 'El cannabis medicinal es legal en Puerto Rico, pero su uso conlleva responsabilidades. Este curso te prepara para entender el marco legal, los efectos en la conducción y las mejores prácticas de seguridad vial.', 'cst-cannabis' ); ?>
                </p>
            </div>
            <div class="cst-course-impact__stat-box">
                <span class="cst-course-impact__stat-number" aria-hidden="true">40%</span>
                <p class="cst-course-impact__stat-label">
                    <?php esc_html_e( 'de los pacientes de cannabis medicinal desconocen los efectos en la capacidad de conducción', 'cst-cannabis' ); ?>
                </p>
            </div>
        </div>

        <div class="cst-course-impact__callouts">
            <?php foreach ( $callouts as $callout ) : ?>
                <div class="cst-course-impact__callout">
                    <div class="cst-course-impact__callout-icon" aria-hidden="true">
                        <?php echo cst_kses_svg( $callout['icon'] ); ?>
                    </div>
                    <h3 class="cst-course-impact__callout-title"><?php echo esc_html( $callout['title'] ); ?></h3>
                    <p class="cst-course-impact__callout-desc"><?php echo esc_html( $callout['desc'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

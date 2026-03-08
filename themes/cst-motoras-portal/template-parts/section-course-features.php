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
        'label' => __( 'Duración', 'cst-motoras' ),
        'value' => __( 'Aproximadamente 2 horas', 'cst-motoras' ),
    ],
    [
        'label' => __( 'Formato', 'cst-motoras' ),
        'value' => __( '100% en línea, a tu ritmo', 'cst-motoras' ),
    ],
    [
        'label' => __( 'Certificado', 'cst-motoras' ),
        'value' => __( 'Certificado digital al completar', 'cst-motoras' ),
    ],
    [
        'label' => __( 'Idioma', 'cst-motoras' ),
        'value' => __( 'Español', 'cst-motoras' ),
    ],
    [
        'label' => __( 'Costo', 'cst-motoras' ),
        'value' => __( 'Completamente gratuito', 'cst-motoras' ),
    ],
    [
        'label' => __( 'Requisitos', 'cst-motoras' ),
        'value' => __( 'Ninguno — abierto a todo público', 'cst-motoras' ),
    ],
];
?>

<section class="cst-section cst-section--course-features"
         aria-label="<?php esc_attr_e( 'Características del curso', 'cst-motoras' ); ?>">
    <div class="cst-container">
        <div class="cst-course-features">
            <div class="cst-course-features__content">
                <?php cst_section_heading(
                    __( 'Características del curso', 'cst-motoras' ),
                    __( 'Todo lo que necesitas saber antes de comenzar.', 'cst-motoras' )
                ); ?>

                <ul class="cst-course-features__list" role="list">
                    <?php foreach ( $features as $feature ) : ?>
                        <li class="cst-course-feature">
                            <span class="cst-course-feature__check" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                            </span>
                            <span class="cst-course-feature__text">
                                <strong class="cst-course-feature__label"><?php echo esc_html( $feature['label'] ); ?>:</strong>
                                <?php echo esc_html( $feature['value'] ); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="cst-course-features__aside" aria-hidden="true">
                <div class="cst-course-features__card">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="currentColor" opacity="0.15"><path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/></svg>
                    <span class="cst-course-features__card-label"><?php esc_html_e( 'Curso certificado por la CST', 'cst-motoras' ); ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

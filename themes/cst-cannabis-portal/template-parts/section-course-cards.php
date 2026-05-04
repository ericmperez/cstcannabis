<?php
/**
 * Template Part: Course Feature Cards.
 *
 * 3-column card grid: Digital, Interactive, Certificate.
 * Mirrors the "Tu Camino Seguro" section from cursomotoras.willai.info.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cards = [
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M21 3H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h5v2h8v-2h5c1.1 0 1.99-.9 1.99-2L23 5c0-1.1-.9-2-2-2zm0 14H3V5h18v12z"/></svg>',
        'title' => __( '100% Digital y Accesible', 'cst-cannabis' ),
        'items' => [
            __( 'Accede desde computadora, tableta o celular', 'cst-cannabis' ),
            __( 'Compatible con iOS y Android', 'cst-cannabis' ),
            __( 'Estudia las 24 horas, a tu propio ritmo', 'cst-cannabis' ),
        ],
    ],
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9H9V9h10v2zm-4 4H9v-2h6v2zm4-8H9V5h10v2z"/></svg>',
        'title' => __( 'Contenido Interactivo', 'cst-cannabis' ),
        'items' => [
            __( '11 módulos educativos completos', 'cst-cannabis' ),
            __( 'Videos, animaciones y evaluaciones', 'cst-cannabis' ),
            __( 'Basado en estándares locales y federales', 'cst-cannabis' ),
        ],
    ],
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>',
        'title' => __( 'Certificado Verificable', 'cst-cannabis' ),
        'items' => [
            __( 'Certificado digital con código QR único', 'cst-cannabis' ),
            __( 'Validación instantánea en línea', 'cst-cannabis' ),
            __( 'Emitido por la Comisión para la Seguridad en el Tránsito de Puerto Rico', 'cst-cannabis' ),
        ],
    ],
];
?>

<section class="cst-section cst-section--course-cards" id="temario" role="region"
         aria-label="<?php esc_attr_e( 'Características del curso', 'cst-cannabis' ); ?>">
    <div class="cst-container">
        <?php cst_section_heading(
            __( 'Tu Camino hacia la Educación Responsable', 'cst-cannabis' ),
            __( 'Todo lo que necesitas para completar el curso y obtener tu certificado.', 'cst-cannabis' )
        ); ?>

        <div class="cst-course-cards__grid">
            <?php foreach ( $cards as $card ) : ?>
                <div class="cst-course-card">
                    <div class="cst-course-card__icon" aria-hidden="true">
                        <?php echo cst_kses_svg( $card['icon'] ); ?>
                    </div>
                    <h3 class="cst-course-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
                    <ul class="cst-course-card__list">
                        <?php foreach ( $card['items'] as $item ) : ?>
                            <li><?php echo esc_html( $item ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

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
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14z"/></svg>',
        'title' => __( '100% Digital y Accesible', 'cst-motoras' ),
        'items' => [
            __( 'Accede desde computadora, tableta o celular', 'cst-motoras' ),
            __( 'Compatible con iOS y Android', 'cst-motoras' ),
            __( 'Estudia las 24 horas, a tu propio ritmo', 'cst-motoras' ),
        ],
    ],
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9H9V9h10v2zm-4 4H9v-2h6v2zm4-8H9V5h10v2z"/></svg>',
        'title' => __( 'Contenido Interactivo', 'cst-motoras' ),
        'items' => [
            __( '5 módulos educativos completos', 'cst-motoras' ),
            __( 'Videos, animaciones y evaluaciones', 'cst-motoras' ),
            __( 'Basado en estándares locales y federales', 'cst-motoras' ),
        ],
    ],
    [
        'icon'  => '<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>',
        'title' => __( 'Certificado Verificable', 'cst-motoras' ),
        'items' => [
            __( 'Certificado digital con código QR único', 'cst-motoras' ),
            __( 'Validación instantánea en línea', 'cst-motoras' ),
            __( 'Emitido por la CST de Puerto Rico', 'cst-motoras' ),
        ],
    ],
];
?>

<section class="cst-section cst-section--course-cards" id="temario" role="region"
         aria-label="<?php esc_attr_e( 'Características del curso', 'cst-motoras' ); ?>">
    <div class="cst-container">
        <?php cst_section_heading(
            __( 'Tu Camino hacia la Conducción Segura', 'cst-motoras' ),
            __( 'Todo lo que necesitas para completar el módulo y obtener tu certificado.', 'cst-motoras' )
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

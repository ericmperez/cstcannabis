<?php
/**
 * Template Part: FAQ Section.
 *
 * Accessible accordion with frequently asked questions about
 * the motorcycle/four tracks endorsement module.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$faqs = [
    [
        'question' => __( '¿Es obligatorio completar el módulo?', 'cst-motoras' ),
        'answer'   => __( 'Sí. El módulo es un requisito obligatorio para obtener el endoso de motocicletas y four tracks según la Ley 107 de Puerto Rico.', 'cst-motoras' ),
    ],
    [
        'question' => __( '¿Qué necesito para inscribirme?', 'cst-motoras' ),
        'answer'   => __( 'Necesitas una licencia de conducir válida de Puerto Rico. El registro es completamente gratuito.', 'cst-motoras' ),
    ],
    [
        'question' => __( '¿Puedo completarlo desde mi celular?', 'cst-motoras' ),
        'answer'   => __( 'Sí. El módulo es 100% compatible con dispositivos móviles, tabletas y computadoras. Puedes acceder desde cualquier dispositivo con conexión a internet.', 'cst-motoras' ),
    ],
    [
        'question' => __( '¿Qué pasa si no apruebo el examen?', 'cst-motoras' ),
        'answer'   => __( 'Tienes hasta 3 intentos para aprobar el examen final. Debes esperar 24 horas entre cada intento. La puntuación mínima para aprobar es 70%.', 'cst-motoras' ),
    ],
    [
        'question' => __( '¿Cuánto tiempo es válido el certificado?', 'cst-motoras' ),
        'answer'   => __( 'El certificado digital es válido por 90 días a partir de la fecha de emisión. Debes completar tu trámite de endoso en CESCO dentro de ese período.', 'cst-motoras' ),
    ],
];
?>

<section class="cst-section cst-section--faq" id="preguntas-frecuentes"
         aria-label="<?php esc_attr_e( 'Preguntas frecuentes', 'cst-motoras' ); ?>">
    <div class="cst-container">
        <?php cst_section_heading(
            __( 'Preguntas Frecuentes sobre el Endoso', 'cst-motoras' ),
            __( 'Respuestas a las dudas más comunes sobre el módulo de conducción segura.', 'cst-motoras' )
        ); ?>

        <div class="cst-faq-list" role="list">
            <?php foreach ( $faqs as $index => $faq ) :
                $id = 'cst-faq-' . ( $index + 1 );
            ?>
                <div class="cst-faq-item" role="listitem">
                    <button class="cst-faq-item__toggle"
                            aria-expanded="false"
                            aria-controls="<?php echo esc_attr( $id ); ?>"
                            type="button">
                        <span class="cst-faq-item__question"><?php echo esc_html( $faq['question'] ); ?></span>
                        <span class="cst-faq-item__icon" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 10 13 14 9"/>
                            </svg>
                        </span>
                    </button>
                    <div class="cst-faq-item__answer" id="<?php echo esc_attr( $id ); ?>"
                         role="region" aria-labelledby="<?php echo esc_attr( $id . '-btn' ); ?>"
                         hidden>
                        <p><?php echo esc_html( $faq['answer'] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

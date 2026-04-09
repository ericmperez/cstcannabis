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
        'question' => __( '¿Es este módulo obligatorio para obtener el endoso?', 'cst-motoras' ),
        'answer'   => __( 'Sí. Según la Ley 107, completar este módulo es un requisito indispensable antes de poder solicitar el examen práctico y obtener el endoso de motocicletas y four tracks en Puerto Rico.', 'cst-motoras' ),
    ],
    [
        'question' => __( '¿Qué necesito para registrarme en el módulo?', 'cst-motoras' ),
        'answer'   => __( 'Necesitas tener una licencia de conducir vigente de Puerto Rico. El sistema validará tu número de licencia contra los archivos para permitirte el acceso. El registro es completamente gratuito.', 'cst-motoras' ),
    ],
    [
        'question' => __( '¿Puedo tomar el módulo desde mi celular?', 'cst-motoras' ),
        'answer'   => __( 'Sí. La plataforma es 100% compatible con computadoras, tabletas y dispositivos móviles (iOS y Android), permitiéndote estudiar a tu propio ritmo desde cualquier lugar.', 'cst-motoras' ),
    ],
    [
        'question' => __( '¿Qué sucede si repruebo el examen final?', 'cst-motoras' ),
        'answer'   => __( 'Tienes hasta 3 intentos para aprobar el examen final. Si no apruebas en un intento, deberás esperar 24 horas antes de volver a intentarlo. Se requiere un 70% para aprobar.', 'cst-motoras' ),
    ],
    [
        'question' => __( '¿El certificado tiene fecha de vencimiento?', 'cst-motoras' ),
        'answer'   => __( 'Sí. Una vez emitido, el certificado digital tiene una validez de 90 días. Debes completar tu trámite de endoso en CESCO dentro de ese período.', 'cst-motoras' ),
    ],
];
?>

<section class="cst-section cst-section--faq" id="preguntas-frecuentes"
         aria-label="<?php esc_attr_e( 'Preguntas frecuentes', 'cst-motoras' ); ?>">
    <div class="cst-container">
        <?php cst_section_heading(
            __( 'Preguntas Frecuentes sobre el Endoso', 'cst-motoras' ),
            __( 'Encuentra respuestas rápidas sobre el proceso de registro, requisitos técnicos y validación de tu endoso. Si tienes otra duda, contáctanos.', 'cst-motoras' )
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

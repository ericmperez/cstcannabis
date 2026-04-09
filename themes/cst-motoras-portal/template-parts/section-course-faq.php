<?php
/**
 * Template Part: Course FAQ Section.
 *
 * Accordion of frequently asked questions using native <details>/<summary>.
 * Mirrors the FAQ section from cursomotoras.willai.info.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$faqs = [
    [
        'q' => __( '¿Es este módulo obligatorio para obtener el endoso?', 'cst-motoras' ),
        'a' => __( 'Sí. Según la Ley 107, completar este módulo es un requisito indispensable antes de poder solicitar el examen práctico y obtener el endoso de motocicletas y four tracks en Puerto Rico.', 'cst-motoras' ),
    ],
    [
        'q' => __( '¿Qué necesito para registrarme en el módulo?', 'cst-motoras' ),
        'a' => __( 'Necesitas tener una licencia de conducir vigente de Puerto Rico. El sistema validará tu número de licencia contra los archivos para permitirte el acceso. El registro es completamente gratuito.', 'cst-motoras' ),
    ],
    [
        'q' => __( '¿Puedo tomar el módulo desde mi celular?', 'cst-motoras' ),
        'a' => __( 'Sí. La plataforma es 100% compatible con computadoras, tabletas y dispositivos móviles (iOS y Android), permitiéndote estudiar a tu propio ritmo desde cualquier lugar.', 'cst-motoras' ),
    ],
    [
        'q' => __( '¿Qué sucede si repruebo el examen final?', 'cst-motoras' ),
        'a' => __( 'Tienes hasta 3 intentos para aprobar el examen final. Si no apruebas en un intento, deberás esperar 24 horas antes de volver a intentarlo. Se requiere un 70% para aprobar.', 'cst-motoras' ),
    ],
    [
        'q' => __( '¿El certificado tiene fecha de vencimiento?', 'cst-motoras' ),
        'a' => __( 'Sí. Una vez emitido, el certificado digital tiene una validez de 90 días. Debes completar tu trámite de endoso en CESCO dentro de ese período.', 'cst-motoras' ),
    ],
];
?>

<section class="cst-section cst-section--course-faq" role="region"
         aria-label="<?php esc_attr_e( 'Preguntas frecuentes', 'cst-motoras' ); ?>">
    <div class="cst-container">
        <?php cst_section_heading(
            __( 'Preguntas Frecuentes', 'cst-motoras' ),
            __( 'Respuestas a las dudas más comunes sobre el módulo y la certificación.', 'cst-motoras' )
        ); ?>

        <div class="cst-faq">
            <?php foreach ( $faqs as $faq ) : ?>
                <details class="cst-faq__item">
                    <summary class="cst-faq__question">
                        <?php echo esc_html( $faq['q'] ); ?>
                    </summary>
                    <div class="cst-faq__answer">
                        <p><?php echo esc_html( $faq['a'] ); ?></p>
                    </div>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>

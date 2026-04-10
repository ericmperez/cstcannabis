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
        'q' => __( '¿Es este curso obligatorio para pacientes de cannabis medicinal?', 'cst-cannabis' ),
        'a' => __( 'Este curso es un recurso educativo gratuito ofrecido por la Comisión para la Seguridad en el Tránsito. Está diseñado para educar a pacientes, profesionales y al público general sobre el uso responsable del cannabis medicinal y la seguridad vial.', 'cst-cannabis' ),
    ],
    [
        'q' => __( '¿Qué necesito para registrarme en el curso?', 'cst-cannabis' ),
        'a' => __( 'Solo necesitas una dirección de correo electrónico válida y completar el formulario de registro. El curso es completamente gratuito y abierto a todo público.', 'cst-cannabis' ),
    ],
    [
        'q' => __( '¿Puedo tomar el curso desde mi celular?', 'cst-cannabis' ),
        'a' => __( 'Sí. La plataforma es completamente compatible con dispositivos móviles, tabletas y computadoras. Puedes acceder al contenido desde cualquier navegador moderno.', 'cst-cannabis' ),
    ],
    [
        'q' => __( '¿Qué sucede si no apruebo el examen final?', 'cst-cannabis' ),
        'a' => __( 'Tienes hasta 3 intentos para aprobar el examen final. Debes esperar 24 horas entre cada intento. Se requiere un 70% para aprobar y obtener el certificado.', 'cst-cannabis' ),
    ],
    [
        'q' => __( '¿El certificado tiene fecha de vencimiento?', 'cst-cannabis' ),
        'a' => __( 'Sí. El certificado digital es válido por 90 días a partir de la fecha de emisión. Puedes verificar su autenticidad mediante el código QR incluido.', 'cst-cannabis' ),
    ],
];
?>

<section class="cst-section cst-section--course-faq" role="region"
         aria-label="<?php esc_attr_e( 'Preguntas frecuentes', 'cst-cannabis' ); ?>">
    <div class="cst-container">
        <?php cst_section_heading(
            __( 'Preguntas Frecuentes', 'cst-cannabis' ),
            __( 'Respuestas a las dudas más comunes sobre el curso y la certificación.', 'cst-cannabis' )
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

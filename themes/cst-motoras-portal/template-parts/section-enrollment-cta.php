<?php
/**
 * Template Part: Enrollment CTA.
 *
 * Strong call-to-action section driving course enrollment.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<section class="cst-enrollment-cta" role="region"
         aria-label="<?php esc_attr_e( 'Inscripción al curso', 'cst-motoras' ); ?>">
    <!-- Decorative dot pattern -->
    <div class="cst-enrollment-cta__pattern" aria-hidden="true"></div>

    <div class="cst-container">
        <div class="cst-enrollment-cta__content">
            <h2 class="cst-enrollment-cta__title"><?php esc_html_e( 'Reduciendo Riesgos y Salvando Vidas en las Carreteras de Puerto Rico', 'cst-motoras' ); ?></h2>
            <p class="cst-enrollment-cta__subtitle"><?php esc_html_e( 'Completa los 5 módulos educativos, valida tu endoso, aprueba el examen y obtén tu certificado digital.', 'cst-motoras' ); ?></p>
            <div class="cst-enrollment-cta__actions">
                <a href="https://cursomotoras.willai.info/courses/modulo-conduccion-segura-para-motociclistas/" class="cst-btn cst-btn--primary cst-btn--lg" target="_blank" rel="noopener noreferrer">
                    <?php esc_html_e( 'Ver Módulo', 'cst-motoras' ); ?>
                </a>
                <a href="https://cursomotoras.willai.info/courses/modulo-conduccion-segura-para-motociclistas/#temario" class="cst-btn cst-btn--outline-hero" target="_blank" rel="noopener noreferrer">
                    <?php esc_html_e( 'Ver temario', 'cst-motoras' ); ?>
                </a>
            </div>
        </div>
    </div>
</section>

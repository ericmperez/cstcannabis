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
         aria-label="<?php esc_attr_e( 'Inscripción al curso', 'cst-cannabis' ); ?>">
    <!-- Decorative dot pattern -->
    <div class="cst-enrollment-cta__pattern" aria-hidden="true"></div>

    <div class="cst-container">
        <div class="cst-enrollment-cta__inner">
            <div class="cst-enrollment-cta__content">
                <h2 class="cst-enrollment-cta__title"><?php esc_html_e( 'Comienza tu educación hoy', 'cst-cannabis' ); ?></h2>
                <p class="cst-enrollment-cta__subtitle"><?php esc_html_e( 'Inscríbete en el curso gratuito de la Comisión para la Seguridad en el Tránsito y obtén tu certificado digital.', 'cst-cannabis' ); ?></p>
            </div>
            <div class="cst-enrollment-cta__actions">
                <a href="<?php echo esc_url( cst_course_url() ); ?>" class="cst-btn cst-btn--primary cst-btn--lg">
                    <?php esc_html_e( 'Inscríbete ahora', 'cst-cannabis' ); ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14"/><path d="M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="<?php echo esc_url( cst_course_url( '#temario' ) ); ?>" class="cst-btn cst-btn--outline-hero">
                    <?php esc_html_e( 'Ver temario', 'cst-cannabis' ); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php
/**
 * Template Part: Course Footer CTA.
 *
 * Registration form, contact info, and legal disclaimer.
 * Mirrors the footer section from cursomotoras.willai.info.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$phone = get_theme_mod( 'cst_phone', '787-721-4142' );
$email = get_theme_mod( 'cst_email', 'comunicaciones@cst.pr.gov' );
?>

<section class="cst-section cst-section--course-footer-cta" id="registro" role="region"
         aria-label="<?php esc_attr_e( 'Registro al curso', 'cst-cannabis' ); ?>">
    <div class="cst-container">

        <div class="cst-course-footer-cta__header">
            <h2 class="cst-course-footer-cta__title">
                <?php esc_html_e( 'Curso de Cannabis Medicinal y Seguridad Vial', 'cst-cannabis' ); ?>
            </h2>
            <p class="cst-course-footer-cta__subtitle">
                <?php esc_html_e( 'Recurso educativo gratuito de la CST', 'cst-cannabis' ); ?>
            </p>
        </div>

        <div class="cst-course-footer-cta__grid">

            <!-- Registration Form — data-redirect-url sends user to Tutor LMS course after CF7 submit -->
            <div class="cst-course-footer-cta__form cst-contact-form" tabindex="-1"
                 data-redirect-url="<?php echo esc_url( home_url( '/courses/cannabis-medicinal-seguridad-vial/' ) ); ?>">
                <h3><?php esc_html_e( 'Regístrate ahora', 'cst-cannabis' ); ?></h3>
                <?php
                while ( have_posts() ) :
                    the_post();
                    the_content();
                endwhile;
                ?>
            </div>

            <!-- Certificate Mockup & Contact -->
            <div class="cst-course-footer-cta__info">

                <div class="cst-certificate-mockup" aria-label="<?php esc_attr_e( 'Ejemplo de certificado digital', 'cst-cannabis' ); ?>">
                    <div class="cst-certificate-mockup__card">
                        <div class="cst-certificate-mockup__border">
                            <div class="cst-certificate-mockup__seal">
                                <img src="<?php echo esc_url( CST_CANNABIS_URI . '/assets/images/cst-logo.svg' ); ?>"
                                     alt="" width="60" height="20" aria-hidden="true" />
                            </div>
                            <p class="cst-certificate-mockup__label"><?php esc_html_e( 'Certificado de Aprobación', 'cst-cannabis' ); ?></p>
                            <p class="cst-certificate-mockup__course"><?php esc_html_e( 'Cannabis Medicinal y Seguridad Vial', 'cst-cannabis' ); ?></p>
                            <p class="cst-certificate-mockup__name"><?php esc_html_e( 'Juan del Pueblo', 'cst-cannabis' ); ?></p>
                            <div class="cst-certificate-mockup__details">
                                <span><?php esc_html_e( 'Fecha: DD/MM/AAAA', 'cst-cannabis' ); ?></span>
                                <span><?php esc_html_e( 'Válido: 90 días', 'cst-cannabis' ); ?></span>
                            </div>
                            <div class="cst-certificate-mockup__qr" aria-hidden="true">
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                                    <rect width="48" height="48" rx="4" fill="#f0f0f0"/>
                                    <rect x="8" y="8" width="12" height="12" rx="1" fill="#333"/>
                                    <rect x="28" y="8" width="12" height="12" rx="1" fill="#333"/>
                                    <rect x="8" y="28" width="12" height="12" rx="1" fill="#333"/>
                                    <rect x="10" y="10" width="8" height="8" rx="1" fill="#f0f0f0"/>
                                    <rect x="30" y="10" width="8" height="8" rx="1" fill="#f0f0f0"/>
                                    <rect x="10" y="30" width="8" height="8" rx="1" fill="#f0f0f0"/>
                                    <rect x="12" y="12" width="4" height="4" fill="#333"/>
                                    <rect x="32" y="12" width="4" height="4" fill="#333"/>
                                    <rect x="12" y="32" width="4" height="4" fill="#333"/>
                                    <rect x="24" y="24" width="4" height="4" fill="#333"/>
                                    <rect x="28" y="28" width="4" height="4" fill="#333"/>
                                    <rect x="32" y="32" width="4" height="4" fill="#333"/>
                                    <rect x="36" y="28" width="4" height="4" fill="#333"/>
                                    <rect x="28" y="36" width="4" height="4" fill="#333"/>
                                </svg>
                                <span class="cst-certificate-mockup__qr-label"><?php esc_html_e( 'Código QR verificable', 'cst-cannabis' ); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cst-course-footer-cta__contact">
                    <?php if ( $email ) : ?>
                        <div class="cst-course-footer-cta__contact-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                            <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if ( $phone ) : ?>
                        <div class="cst-course-footer-cta__contact-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                            <a href="tel:<?php echo esc_attr( str_replace( [ ' ', '-' ], '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="cst-course-footer-cta__disclaimer">
                    <p>
                        <?php esc_html_e( 'Este curso es un recurso educativo independiente ofrecido por la Comisión para la Seguridad en el Tránsito (CST). El contenido es de carácter informativo y no constituye asesoría legal ni médica. Consulte a un profesional para orientación específica.', 'cst-cannabis' ); ?>
                    </p>
                </div>

                <a href="#registro" class="cst-btn cst-btn--primary cst-btn--lg">
                    <?php esc_html_e( 'Ver Curso', 'cst-cannabis' ); ?>
                </a>
            </div>

        </div>

    </div>
</section>

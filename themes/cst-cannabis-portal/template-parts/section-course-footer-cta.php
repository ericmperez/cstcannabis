<?php
/**
 * Template Part: Course Footer CTA.
 *
 * Registration form, certificate preview, contact info, and legal disclaimer.
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
                <?php esc_html_e( 'Recurso educativo gratuito de la Comisión para la Seguridad en el Tránsito', 'cst-cannabis' ); ?>
            </p>
        </div>

        <div class="cst-course-footer-cta__grid">

            <!-- Registration Form -->
            <div class="cst-course-footer-cta__form cst-contact-form" tabindex="-1"
                 data-redirect-url="<?php echo esc_url( home_url( '/courses/curso-cannabis/' ) ); ?>">
                <h3><?php esc_html_e( 'Regístrate ahora', 'cst-cannabis' ); ?></h3>
                <?php
                while ( have_posts() ) :
                    the_post();
                    the_content();
                endwhile;
                ?>
                <p class="cst-form-privacy">
                    <?php
                    printf(
                        wp_kses(
                            /* translators: %s: privacy policy URL */
                            __( 'Al registrarse, usted acepta nuestra <a href="%s">Política de Privacidad</a> conforme a la Ley 39-2012. Sus datos serán utilizados exclusivamente para el proceso de registro y emisión de certificado.', 'cst-cannabis' ),
                            [ 'a' => [ 'href' => [] ] ]
                        ),
                        esc_url( get_privacy_policy_url() )
                    );
                    ?>
                </p>
            </div>

            <!-- Right Column: Certificate + Info -->
            <div class="cst-course-footer-cta__info">

                <!-- Certificate Mockup -->
                <div class="cst-certificate-mockup" aria-label="<?php esc_attr_e( 'Ejemplo de certificado digital', 'cst-cannabis' ); ?>">
                    <div class="cst-certificate-mockup__badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        <?php esc_html_e( 'Certificado verificable', 'cst-cannabis' ); ?>
                    </div>
                    <div class="cst-certificate-mockup__card">
                        <div class="cst-certificate-mockup__border">
                            <div class="cst-certificate-mockup__ribbon"></div>
                            <div class="cst-certificate-mockup__seal">
                                <img src="<?php echo esc_url( CST_CANNABIS_URI . '/assets/images/cst-logo.svg' ); ?>"
                                     alt="" width="80" height="26" aria-hidden="true" />
                            </div>
                            <p class="cst-certificate-mockup__label"><?php esc_html_e( 'Certificado de Aprobación', 'cst-cannabis' ); ?></p>
                            <div class="cst-certificate-mockup__divider"></div>
                            <p class="cst-certificate-mockup__course"><?php esc_html_e( 'Cannabis Medicinal y Seguridad Vial', 'cst-cannabis' ); ?></p>
                            <p class="cst-certificate-mockup__awarded"><?php esc_html_e( 'Otorgado a', 'cst-cannabis' ); ?></p>
                            <p class="cst-certificate-mockup__name"><?php esc_html_e( 'Juan del Pueblo', 'cst-cannabis' ); ?></p>
                            <div class="cst-certificate-mockup__footer">
                                <div class="cst-certificate-mockup__meta">
                                    <span><?php esc_html_e( 'Fecha: DD/MM/AAAA', 'cst-cannabis' ); ?></span>
                                    <span><?php esc_html_e( 'Válido: 90 días', 'cst-cannabis' ); ?></span>
                                </div>
                                <div class="cst-certificate-mockup__qr" aria-hidden="true">
                                    <svg width="40" height="40" viewBox="0 0 48 48" fill="none">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Info Cards -->
                <div class="cst-course-footer-cta__quick-info">
                    <div class="cst-quick-info-card">
                        <div class="cst-quick-info-card__icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                        </div>
                        <div>
                            <strong><?php esc_html_e( '100% En Línea', 'cst-cannabis' ); ?></strong>
                            <span><?php esc_html_e( 'A tu ritmo, 24/7', 'cst-cannabis' ); ?></span>
                        </div>
                    </div>
                    <div class="cst-quick-info-card">
                        <div class="cst-quick-info-card__icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
                        </div>
                        <div>
                            <strong><?php esc_html_e( 'Gratuito', 'cst-cannabis' ); ?></strong>
                            <span><?php esc_html_e( 'Sin costo alguno', 'cst-cannabis' ); ?></span>
                        </div>
                    </div>
                    <div class="cst-quick-info-card">
                        <div class="cst-quick-info-card__icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                        </div>
                        <div>
                            <strong><?php esc_html_e( '11 Módulos', 'cst-cannabis' ); ?></strong>
                            <span><?php esc_html_e( 'Contenido completo', 'cst-cannabis' ); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="cst-course-footer-cta__contact">
                    <h4 class="cst-course-footer-cta__contact-title"><?php esc_html_e( '¿Necesitas ayuda?', 'cst-cannabis' ); ?></h4>
                    <?php if ( $email ) : ?>
                        <div class="cst-course-footer-cta__contact-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                            <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if ( $phone ) : ?>
                        <div class="cst-course-footer-cta__contact-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                            <a href="tel:<?php echo esc_attr( str_replace( [ ' ', '-' ], '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

        </div>

    </div>
</section>

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

            <!-- Contact & Disclaimer -->
            <div class="cst-course-footer-cta__info">
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

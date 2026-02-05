<?php
/**
 * Template Part: Cannabis Course Section (home page).
 *
 * Featured course registration CTA with course details.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$course_url = 'https://bearsmoke.store/curso-cannabis/courses/curso-cannabis/';
?>

<section class="cst-course-section" id="curso"
         aria-label="<?php esc_attr_e( 'Curso de Cannabis', 'cst-cannabis' ); ?>">
    <div class="cst-container">
        <div class="cst-course-card">
            <div class="cst-course-card__content">
                <div class="cst-course-card__badge">
                    <span class="cst-course-card__badge-dot" aria-hidden="true"></span>
                    <?php esc_html_e( 'Registro gratuito', 'cst-cannabis' ); ?>
                </div>

                <h2 class="cst-course-card__title">
                    <?php esc_html_e( 'Curso de Cannabis Medicinal', 'cst-cannabis' ); ?>
                </h2>

                <p class="cst-course-card__desc">
                    <?php esc_html_e( 'Aprende todo sobre el cannabis medicinal, su uso responsable y su impacto en la seguridad vial. Curso en línea completamente gratuito, a tu ritmo.', 'cst-cannabis' ); ?>
                </p>

                <ul class="cst-course-card__features">
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                        <?php esc_html_e( 'Contenido basado en evidencia científica', 'cst-cannabis' ); ?>
                    </li>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                        <?php esc_html_e( '100% en línea — aprende a tu ritmo', 'cst-cannabis' ); ?>
                    </li>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                        <?php esc_html_e( 'Registro gratuito — sin costo alguno', 'cst-cannabis' ); ?>
                    </li>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                        <?php esc_html_e( 'Seguridad vial y cannabis medicinal', 'cst-cannabis' ); ?>
                    </li>
                </ul>

                <div class="cst-course-card__actions">
                    <a href="<?php echo esc_url( $course_url ); ?>" class="cst-btn cst-btn--course"
                       target="_blank" rel="noopener noreferrer">
                        <?php esc_html_e( 'Registrarse gratis', 'cst-cannabis' ); ?>
                        <span class="cst-btn__icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </span>
                    </a>
                </div>
            </div>

            <div class="cst-course-card__visual">
                <div class="cst-course-card__illustration">
                    <div class="cst-course-card__icon-large" aria-hidden="true">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/>
                        </svg>
                    </div>

                    <div class="cst-course-card__stats">
                        <div class="cst-course-card__stat">
                            <span class="cst-course-card__stat-value"><?php esc_html_e( 'Gratis', 'cst-cannabis' ); ?></span>
                            <span class="cst-course-card__stat-label"><?php esc_html_e( 'Sin costo', 'cst-cannabis' ); ?></span>
                        </div>
                        <div class="cst-course-card__stat">
                            <span class="cst-course-card__stat-value"><?php esc_html_e( '100%', 'cst-cannabis' ); ?></span>
                            <span class="cst-course-card__stat-label"><?php esc_html_e( 'En línea', 'cst-cannabis' ); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

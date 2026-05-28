<?php
/**
 * Template Part: Línea PAS safety notice.
 *
 * Crisis-support callout pointing to ASSMCA's Línea PAS (24/7, free,
 * confidential). Shown on the course landing page because the curriculum
 * covers mental-health screening (SBIRT / DSM-5) and substance use.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$pas_number = '1-800-981-0023';
?>

<aside class="cst-course-safety" role="note"
       aria-label="<?php esc_attr_e( 'Recurso de apoyo en crisis', 'cst-cannabis' ); ?>">
    <div class="cst-container">
        <div class="cst-course-safety__card">
            <span class="cst-course-safety__icon" aria-hidden="true">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.02-.24 11.36 11.36 0 003.57.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.45.57 3.57a1 1 0 01-.25 1.02l-2.2 2.2z"/></svg>
            </span>
            <div class="cst-course-safety__body">
                <p class="cst-course-safety__title">
                    <?php esc_html_e( '¿Necesitas apoyo? No estás solo.', 'cst-cannabis' ); ?>
                </p>
                <p class="cst-course-safety__text">
                    <?php
                    printf(
                        /* translators: %s: Línea PAS phone number link */
                        esc_html__( 'Si tú o alguien que conoces atraviesa una crisis emocional o de salud mental, comunícate con la Línea PAS de ASSMCA: %s. Disponible 24/7, gratuita y confidencial.', 'cst-cannabis' ),
                        '<a class="cst-course-safety__phone" href="tel:18009810023">' . esc_html( $pas_number ) . '</a>'
                    );
                    ?>
                </p>
            </div>
        </div>
    </div>
</aside>

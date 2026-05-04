<?php
/**
 * Template Part: Course Disclaimer.
 *
 * Centered, full-width legal/educational disclaimer rendered immediately
 * before the site footer.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<aside class="cst-course-disclaimer" role="note"
       aria-label="<?php esc_attr_e( 'Aviso legal sobre el curso', 'cst-cannabis' ); ?>">
    <div class="cst-container">
        <div class="cst-course-disclaimer__card">
            <p class="cst-course-disclaimer__text">
                <?php esc_html_e( 'Este curso es un recurso educativo independiente ofrecido por la Comisión para la Seguridad en el Tránsito (CST). El contenido es de carácter informativo y no constituye asesoría legal ni médica. Consulte a un profesional para orientación específica.', 'cst-cannabis' ); ?>
            </p>
        </div>
    </div>
</aside>

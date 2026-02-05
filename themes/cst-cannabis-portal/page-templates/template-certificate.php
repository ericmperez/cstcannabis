<?php
/**
 * Template Name: Curso - Certificado
 * Template Post Type: page
 *
 * Certificate of completion page. Validates course progress via localStorage
 * and renders a printable certificate.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$modules     = class_exists( 'CST_Course' ) ? CST_Course::get_ordered_modules() : [];
$module_ids  = array_map( function( $m ) { return $m->ID; }, $modules );
$module_json = wp_json_encode( $module_ids );
?>

<main id="main-content" class="cst-main">

    <?php
    cst_hero( [
        'title'    => __( 'Certificado de Finalización', 'cst-cannabis' ),
        'subtitle' => __( 'Complete todos los módulos y quizzes para obtener su certificado oficial.', 'cst-cannabis' ),
        'class'    => 'cst-hero--page cst-hero--certificate',
    ] );
    ?>

    <section class="cst-section cst-section--certificate" aria-label="<?php esc_attr_e( 'Certificado del curso', 'cst-cannabis' ); ?>">
        <div class="cst-container">

            <!-- Not Completed State -->
            <div class="cst-certificate-gate" id="cst-cert-gate">
                <div class="cst-certificate-gate__icon" aria-hidden="true">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                </div>
                <h2 class="cst-certificate-gate__title"><?php esc_html_e( 'Aún no ha completado el curso', 'cst-cannabis' ); ?></h2>
                <p class="cst-certificate-gate__text">
                    <?php esc_html_e( 'Debe completar todos los módulos y aprobar todas las evaluaciones para desbloquear su certificado.', 'cst-cannabis' ); ?>
                </p>
                <div class="cst-certificate-gate__progress">
                    <p id="cst-cert-progress-text"></p>
                    <div class="cst-course-progress__bar">
                        <div class="cst-course-progress__fill" id="cst-cert-progress-fill" style="width:0%"></div>
                    </div>
                </div>
                <a href="<?php echo esc_url( home_url( '/curso/' ) ); ?>" class="cst-btn cst-btn--primary">
                    <?php esc_html_e( 'Continuar el curso', 'cst-cannabis' ); ?>
                </a>
            </div>

            <!-- Certificate (hidden until validated by JS) -->
            <div class="cst-certificate" id="cst-certificate" hidden>
                <div class="cst-certificate__document" id="cst-certificate-doc">
                    <div class="cst-certificate__border">
                        <div class="cst-certificate__inner">

                            <div class="cst-certificate__header">
                                <div class="cst-certificate__seal" aria-hidden="true">CST</div>
                                <p class="cst-certificate__agency"><?php esc_html_e( 'Comisión para la Seguridad en el Tránsito', 'cst-cannabis' ); ?></p>
                                <p class="cst-certificate__gov"><?php esc_html_e( 'Gobierno de Puerto Rico', 'cst-cannabis' ); ?></p>
                            </div>

                            <div class="cst-certificate__body">
                                <h1 class="cst-certificate__title"><?php esc_html_e( 'Certificado de Finalización', 'cst-cannabis' ); ?></h1>
                                <p class="cst-certificate__subtitle"><?php esc_html_e( 'Se certifica que', 'cst-cannabis' ); ?></p>
                                <div class="cst-certificate__name-wrapper">
                                    <p class="cst-certificate__name" id="cst-cert-name"></p>
                                    <div class="cst-certificate__name-line"></div>
                                </div>
                                <p class="cst-certificate__course-text">
                                    <?php esc_html_e( 'Ha completado satisfactoriamente el', 'cst-cannabis' ); ?>
                                </p>
                                <p class="cst-certificate__course-name">
                                    <?php esc_html_e( 'Curso de Educación Vial y Cannabis', 'cst-cannabis' ); ?>
                                </p>
                                <p class="cst-certificate__details">
                                    <?php printf(
                                        esc_html__( 'Consistente en %d módulos educativos sobre los efectos del cannabis en la conducción, el marco legal en Puerto Rico y las prácticas seguras de transporte.', 'cst-cannabis' ),
                                        count( $modules )
                                    ); ?>
                                </p>
                            </div>

                            <div class="cst-certificate__footer">
                                <div class="cst-certificate__date">
                                    <p class="cst-certificate__date-value" id="cst-cert-date"></p>
                                    <p class="cst-certificate__date-label"><?php esc_html_e( 'Fecha de finalización', 'cst-cannabis' ); ?></p>
                                </div>
                                <div class="cst-certificate__id">
                                    <p class="cst-certificate__id-value" id="cst-cert-id"></p>
                                    <p class="cst-certificate__id-label"><?php esc_html_e( 'Número de certificado', 'cst-cannabis' ); ?></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Certificate Actions -->
                <div class="cst-certificate__actions">
                    <button type="button" class="cst-btn cst-btn--primary" id="cst-cert-print" onclick="window.print()">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/></svg>
                        <?php esc_html_e( 'Imprimir certificado', 'cst-cannabis' ); ?>
                    </button>
                </div>
            </div>

            <!-- Name Entry Dialog (shown before certificate) -->
            <div class="cst-certificate-form" id="cst-cert-form" hidden>
                <h2><?php esc_html_e( 'Ingrese su nombre completo', 'cst-cannabis' ); ?></h2>
                <p><?php esc_html_e( 'Este nombre aparecerá en su certificado oficial.', 'cst-cannabis' ); ?></p>
                <div class="cst-certificate-form__field">
                    <label for="cst-cert-name-input"><?php esc_html_e( 'Nombre completo', 'cst-cannabis' ); ?></label>
                    <input type="text" id="cst-cert-name-input" class="cst-input" required
                           placeholder="<?php esc_attr_e( 'Ej: Juan A. Pérez García', 'cst-cannabis' ); ?>">
                </div>
                <button type="button" class="cst-btn cst-btn--primary" id="cst-cert-generate">
                    <?php esc_html_e( 'Generar certificado', 'cst-cannabis' ); ?>
                </button>
            </div>

        </div>
    </section>

</main>

<script>
    window.cstCourseModules = <?php echo $module_json; ?>;
</script>

<?php
get_footer();

<?php
/**
 * Template Name: Curso
 * Template Post Type: page
 *
 * Course registration page: info grid + CF7 form.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="cst-main">

    <?php
    cst_hero( [
        'title'    => get_the_title(),
        'subtitle' => __( 'Módulo en Conducción Segura para Motociclistas y Four Tracks — Requisito Obligatorio de Ley 107.', 'cst-motoras' ),
        'class'    => 'cst-hero--page',
    ] );
    ?>

    <section class="cst-section cst-section--course" id="temario">
        <div class="cst-container">

            <div class="cst-course-grid">

                <!-- Course Info -->
                <div class="cst-course-info">
                    <p>
                        <?php esc_html_e( 'Este módulo educativo gratuito aborda los requisitos de la Ley 107 para la seguridad en motocicletas y four tracks en Puerto Rico. Enfatiza la conducción defensiva, el equipo de protección adecuado y el cumplimiento legal bajo la Ley 22. Completa los 5 módulos, aprueba el examen y obtén tu certificado digital verificable.', 'cst-motoras' ); ?>
                    </p>

                    <h2><?php esc_html_e( 'Contenido del Módulo', 'cst-motoras' ); ?></h2>
                    <ul class="cst-course-list">
                        <li><?php esc_html_e( 'Módulo 1: Fundamentos, Ley 22 y Tipos de Motocicletas — responsabilidades, reglas de seguridad, clasificaciones e inspecciones mecánicas', 'cst-motoras' ); ?></li>
                        <li><?php esc_html_e( 'Módulo 2: Viste para el Impacto — casco, certificaciones (DOT, ECE, Snell), protección corporal y visibilidad', 'cst-motoras' ); ?></li>
                        <li><?php esc_html_e( 'Módulo 3: Control Básico y Conducción Defensiva — técnicas de manejo, curvas, frenado y condiciones especiales', 'cst-motoras' ); ?></li>
                        <li><?php esc_html_e( 'Módulo 4: Factores Humanos y Respuesta ante Choques — impedimentos, emergencias, primeros auxilios y responsabilidad', 'cst-motoras' ); ?></li>
                        <li><?php esc_html_e( 'Módulo 5: Examen Final — evaluación comprensiva con 70% para aprobar', 'cst-motoras' ); ?></li>
                    </ul>

                    <div class="cst-course-features">
                        <div class="cst-course-feature">
                            <div class="cst-course-feature__icon" aria-hidden="true">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14z"/>
                                </svg>
                            </div>
                            <div class="cst-course-feature__body">
                                <h3><?php esc_html_e( '100% Digital', 'cst-motoras' ); ?></h3>
                                <p><?php esc_html_e( 'Compatible con computadora, tableta y celular. Accede 24/7 a tu propio ritmo.', 'cst-motoras' ); ?></p>
                            </div>
                        </div>

                        <div class="cst-course-feature">
                            <div class="cst-course-feature__icon" aria-hidden="true">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 3H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h5v2h8v-2h5c1.1 0 1.99-.9 1.99-2L23 5c0-1.1-.9-2-2-2zm0 14H3V5h18v12z"/>
                                </svg>
                            </div>
                            <div class="cst-course-feature__body">
                                <h3><?php esc_html_e( 'Contenido Interactivo', 'cst-motoras' ); ?></h3>
                                <p><?php esc_html_e( '5 módulos educativos con videos y animaciones basados en estándares locales y federales.', 'cst-motoras' ); ?></p>
                            </div>
                        </div>

                        <div class="cst-course-feature">
                            <div class="cst-course-feature__icon" aria-hidden="true">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                                </svg>
                            </div>
                            <div class="cst-course-feature__body">
                                <h3><?php esc_html_e( 'Certificado Verificable', 'cst-motoras' ); ?></h3>
                                <p><?php esc_html_e( 'Certificado digital con código QR único para validación instantánea en trámites de licencia.', 'cst-motoras' ); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Form -->
                <div class="cst-course-form cst-contact-form">
                    <h2><?php esc_html_e( 'Regístrate ahora', 'cst-motoras' ); ?></h2>
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>

            </div>

        </div>
    </section>

</main>

<?php
get_footer();

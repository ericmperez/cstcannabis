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
        'subtitle' => __( 'Curso gratuito sobre cannabis medicinal y seguridad vial en Puerto Rico.', 'cst-cannabis' ),
        'class'    => 'cst-hero--page',
    ] );
    ?>

    <section class="cst-section cst-section--course">
        <div class="cst-container">

            <div class="cst-course-grid">

                <!-- Course Info -->
                <div class="cst-course-info">
                    <p>
                        <?php esc_html_e( 'Este curso gratuito está diseñado para educar a profesionales, pacientes y al público general sobre el marco legal del cannabis medicinal en Puerto Rico y su impacto en la seguridad vial. Aprenderás sobre la legislación vigente, los efectos del cannabis en la conducción, y las mejores prácticas para un uso responsable.', 'cst-cannabis' ); ?>
                    </p>

                    <h2><?php esc_html_e( 'Lo que aprenderás', 'cst-cannabis' ); ?></h2>
                    <ul class="cst-course-list">
                        <li><?php esc_html_e( 'Marco legal del cannabis medicinal en Puerto Rico', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Efectos del cannabis en la capacidad de conducción', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Protocolos de seguridad vial y fiscalización', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Derechos y responsabilidades de los pacientes', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Estrategias de prevención y educación comunitaria', 'cst-cannabis' ); ?></li>
                    </ul>

                    <div class="cst-course-features">
                        <div class="cst-course-feature">
                            <div class="cst-course-feature__icon" aria-hidden="true">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                </svg>
                            </div>
                            <div class="cst-course-feature__body">
                                <h3><?php esc_html_e( 'Duración', 'cst-cannabis' ); ?></h3>
                                <p><?php esc_html_e( '4 horas (a tu propio ritmo)', 'cst-cannabis' ); ?></p>
                            </div>
                        </div>

                        <div class="cst-course-feature">
                            <div class="cst-course-feature__icon" aria-hidden="true">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 3H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h5v2h8v-2h5c1.1 0 1.99-.9 1.99-2L23 5c0-1.1-.9-2-2-2zm0 14H3V5h18v12z"/>
                                </svg>
                            </div>
                            <div class="cst-course-feature__body">
                                <h3><?php esc_html_e( 'Formato', 'cst-cannabis' ); ?></h3>
                                <p><?php esc_html_e( '100% en línea, accesible desde cualquier dispositivo', 'cst-cannabis' ); ?></p>
                            </div>
                        </div>

                        <div class="cst-course-feature">
                            <div class="cst-course-feature__icon" aria-hidden="true">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                                </svg>
                            </div>
                            <div class="cst-course-feature__body">
                                <h3><?php esc_html_e( 'Certificado', 'cst-cannabis' ); ?></h3>
                                <p><?php esc_html_e( 'Certificado digital de completación emitido por la CST', 'cst-cannabis' ); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Form -->
                <div class="cst-course-form cst-contact-form">
                    <h2><?php esc_html_e( 'Regístrate ahora', 'cst-cannabis' ); ?></h2>
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

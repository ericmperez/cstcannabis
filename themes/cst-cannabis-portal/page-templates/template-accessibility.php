<?php
/**
 * Template Name: Declaración de accesibilidad
 * Template Post Type: page
 *
 * Pre-populated accessibility statement page compliant with Ley 229-2003.
 * Content is hardcoded to ensure compliance even without editor input.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="cst-main">

    <?php
    cst_hero( [
        'title' => get_the_title(),
        'class' => 'cst-hero--page cst-hero--legal',
    ] );
    ?>

    <section class="cst-section cst-section--legal">
        <div class="cst-container">
            <div class="cst-legal-layout">

                <!-- Auto-generated TOC (populated by JS) -->
                <aside class="cst-legal-toc" aria-label="<?php esc_attr_e( 'Tabla de contenido', 'cst-cannabis' ); ?>">
                    <h2 class="cst-legal-toc__title"><?php esc_html_e( 'Contenido', 'cst-cannabis' ); ?></h2>
                    <nav id="cst-toc-nav">
                        <ol class="cst-legal-toc__list" id="cst-toc-list">
                            <!-- Populated by main.js -->
                        </ol>
                    </nav>
                </aside>

                <article class="cst-legal-content cst-content-area" id="cst-legal-article">

                    <h2><?php esc_html_e( 'Compromiso con la accesibilidad', 'cst-cannabis' ); ?></h2>
                    <p>
                        <?php esc_html_e( 'La Comisión para la Seguridad en el Tránsito de Puerto Rico (CST) se compromete a garantizar que su portal web sea accesible para todas las personas, incluyendo personas con discapacidades, conforme a la Ley 229 de 2003 del Gobierno de Puerto Rico.', 'cst-cannabis' ); ?>
                    </p>

                    <h2><?php esc_html_e( 'Nivel de conformidad', 'cst-cannabis' ); ?></h2>
                    <p>
                        <?php esc_html_e( 'Este portal ha sido diseñado y desarrollado para cumplir con las Pautas de Accesibilidad para el Contenido Web (WCAG) 2.1 nivel AA, conforme a los estándares establecidos por:', 'cst-cannabis' ); ?>
                    </p>
                    <ul>
                        <li><?php esc_html_e( 'Ley 229 de 2003 — Accesibilidad de sitios web del Gobierno de Puerto Rico', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Sección 508 de la Ley de Rehabilitación (federal)', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Título II de la Ley ADA (Americans with Disabilities Act)', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'WCAG 2.1 Nivel AA — Pautas de Accesibilidad para el Contenido Web', 'cst-cannabis' ); ?></li>
                    </ul>

                    <h2><?php esc_html_e( 'Medidas implementadas', 'cst-cannabis' ); ?></h2>
                    <p><?php esc_html_e( 'Para garantizar la accesibilidad, este portal incluye las siguientes medidas:', 'cst-cannabis' ); ?></p>
                    <ul>
                        <li><?php esc_html_e( 'Navegación completa por teclado en todos los componentes interactivos', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Indicadores de enfoque visibles (3px sólido, 2px de desplazamiento)', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Áreas táctiles de mínimo 44x44 píxeles', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Contraste de color mínimo de 4.5:1 para texto normal y 3:1 para texto grande', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Compatibilidad con lectores de pantalla mediante ARIA landmarks, roles y regiones activas', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Soporte para modo de alto contraste y colores forzados (Windows)', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Respeto a la preferencia de movimiento reducido del usuario', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Enlace para saltar al contenido principal', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Jerarquía de encabezados lógica y estructurada', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Textos alternativos en todas las imágenes', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Etiquetas asociadas a todos los campos de formulario', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Idioma de la página declarado correctamente (lang="es")', 'cst-cannabis' ); ?></li>
                    </ul>

                    <h2><?php esc_html_e( 'Tecnologías de asistencia compatibles', 'cst-cannabis' ); ?></h2>
                    <p><?php esc_html_e( 'Este portal está diseñado para ser compatible con las siguientes tecnologías de asistencia:', 'cst-cannabis' ); ?></p>
                    <ul>
                        <li><?php esc_html_e( 'NVDA y JAWS (lectores de pantalla para Windows)', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'VoiceOver (macOS e iOS)', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'TalkBack (Android)', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Navegación por teclado en todos los navegadores modernos', 'cst-cannabis' ); ?></li>
                    </ul>

                    <h2><?php esc_html_e( 'Limitaciones conocidas', 'cst-cannabis' ); ?></h2>
                    <p>
                        <?php esc_html_e( 'Aunque hacemos nuestro mejor esfuerzo para asegurar la accesibilidad, algunas áreas podrían presentar limitaciones:', 'cst-cannabis' ); ?>
                    </p>
                    <ul>
                        <li><?php esc_html_e( 'Contenido de terceros (formularios de Contact Form 7, Tutor LMS) puede tener limitaciones fuera de nuestro control directo.', 'cst-cannabis' ); ?></li>
                        <li><?php esc_html_e( 'Documentos PDF enlazados podrían no cumplir completamente con WCAG 2.1 AA.', 'cst-cannabis' ); ?></li>
                    </ul>

                    <h2><?php esc_html_e( 'Reportar un problema de accesibilidad', 'cst-cannabis' ); ?></h2>
                    <p>
                        <?php esc_html_e( 'Si encuentra alguna barrera de accesibilidad en este portal, le invitamos a comunicarse con nosotros:', 'cst-cannabis' ); ?>
                    </p>
                    <ul>
                        <?php $a11y_email = get_theme_mod( 'cst_email', 'comunicaciones@cst.pr.gov' ); ?>
                        <li>
                            <?php esc_html_e( 'Correo electrónico:', 'cst-cannabis' ); ?>
                            <a href="mailto:<?php echo esc_attr( $a11y_email ); ?>"><?php echo esc_html( $a11y_email ); ?></a>
                        </li>
                        <?php $a11y_phone = get_theme_mod( 'cst_phone', '787-721-4142' ); ?>
                        <li>
                            <?php esc_html_e( 'Teléfono:', 'cst-cannabis' ); ?>
                            <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $a11y_phone ) ); ?>"><?php echo esc_html( $a11y_phone ); ?></a>
                        </li>
                    </ul>
                    <p>
                        <?php
                        echo wp_kses(
                            sprintf(
                                /* translators: %s: URL to accesibilidad.pr.gov */
                                __( 'También puede reportar problemas de accesibilidad en sitios web del Gobierno de Puerto Rico a través del portal <a href="%s" target="_blank" rel="noopener noreferrer">accesibilidad.pr.gov</a>.', 'cst-cannabis' ),
                                'https://accesibilidad.pr.gov'
                            ),
                            [ 'a' => [ 'href' => [], 'target' => [], 'rel' => [] ] ]
                        );
                        ?>
                    </p>

                    <h2><?php esc_html_e( 'Base legal', 'cst-cannabis' ); ?></h2>
                    <p>
                        <?php
                        echo wp_kses(
                            __( 'Esta declaración se emite en cumplimiento de la <a href="https://accesibilidad.pr.gov" target="_blank" rel="noopener noreferrer">Ley 229 de 2003</a> del Gobierno de Puerto Rico, que requiere que todos los sitios web gubernamentales sean accesibles para personas con discapacidades.', 'cst-cannabis' ),
                            [ 'a' => [ 'href' => [], 'target' => [], 'rel' => [] ] ]
                        );
                        ?>
                    </p>

                    <?php
                    // Allow editor to add additional content.
                    while ( have_posts() ) :
                        the_post();
                        $content = get_the_content();
                        if ( trim( $content ) ) :
                            ?>
                            <hr>
                            <?php the_content(); ?>
                        <?php endif;
                    endwhile;
                    ?>

                    <div class="cst-legal-meta">
                        <p class="cst-legal-meta__updated">
                            <?php
                            printf(
                                /* translators: %s: last modified date */
                                esc_html__( 'Última actualización: %s', 'cst-cannabis' ),
                                esc_html( get_the_modified_date() )
                            );
                            ?>
                        </p>
                    </div>
                </article>

            </div>
        </div>
    </section>

</main>

<?php
get_footer();

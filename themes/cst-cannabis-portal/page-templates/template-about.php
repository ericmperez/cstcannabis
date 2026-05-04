<?php
/**
 * Template Name: Sobre nosotros
 * Template Post Type: page
 *
 * Government-style about page: mission, purpose, pillars, contact CTA.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="main-content" class="cst-main">

    <?php
    cst_hero( [
        'title'    => __( 'Sobre nosotros', 'cst-cannabis' ),
        'subtitle' => __( 'Conoce nuestra misión, propósito y compromiso con la seguridad vial en Puerto Rico.', 'cst-cannabis' ),
        'class'    => 'cst-hero--page',
    ] );
    ?>

    <!-- Mission -->
    <section class="cst-section cst-section--about-mission">
        <div class="cst-container">
            <div class="cst-about-block">
                <?php cst_section_heading(
                    __( 'Nuestra misión', 'cst-cannabis' ),
                    '',
                    'h2'
                ); ?>
                <p class="cst-about-block__text">
                    <?php echo esc_html__(
                        'La Comisión para la Seguridad en el Tránsito de Puerto Rico (CST) es la agencia gubernamental encargada de promover la seguridad vial en todo el territorio. A través de este portal educativo, nos dedicamos a informar sobre el uso responsable del cannabis medicinal y su relación con la seguridad en las carreteras.',
                        'cst-cannabis'
                    ); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Purpose -->
    <section class="cst-section cst-section--about-purpose">
        <div class="cst-container">
            <div class="cst-about-block">
                <?php cst_section_heading(
                    __( '¿Por qué este portal?', 'cst-cannabis' ),
                    '',
                    'h2'
                ); ?>
                <p class="cst-about-block__text">
                    <?php echo esc_html__(
                        'Con la aprobación de la Ley 42-2017 que reguló el uso del cannabis medicinal en Puerto Rico, surgió la necesidad de educar a la población sobre los efectos de esta sustancia en la capacidad de conducir. Este portal es nuestra respuesta a esa necesidad.',
                        'cst-cannabis'
                    ); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Pillars -->
    <section class="cst-section cst-section--about-pillars">
        <div class="cst-container">
            <?php cst_section_heading(
                __( 'Nuestros pilares', 'cst-cannabis' ),
                __( 'Los principios que guían nuestro trabajo', 'cst-cannabis' ),
                'h2'
            ); ?>

            <div class="cst-pillars-grid" role="list">

                <div class="cst-pillar-card" role="listitem">
                    <div class="cst-pillar-card__icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                        </svg>
                    </div>
                    <h3 class="cst-pillar-card__title"><?php esc_html_e( 'Educación basada en evidencia', 'cst-cannabis' ); ?></h3>
                    <p class="cst-pillar-card__desc">
                        <?php esc_html_e( 'Toda nuestra información proviene de fuentes científicas verificadas y datos del Departamento de Salud.', 'cst-cannabis' ); ?>
                    </p>
                </div>

                <div class="cst-pillar-card" role="listitem">
                    <div class="cst-pillar-card__icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <h3 class="cst-pillar-card__title"><?php esc_html_e( 'Prevención proactiva', 'cst-cannabis' ); ?></h3>
                    <p class="cst-pillar-card__desc">
                        <?php esc_html_e( 'Trabajamos para prevenir accidentes antes de que ocurran mediante campañas de concientización.', 'cst-cannabis' ); ?>
                    </p>
                </div>

                <div class="cst-pillar-card" role="listitem">
                    <div class="cst-pillar-card__icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <h3 class="cst-pillar-card__title"><?php esc_html_e( 'Colaboración interagencial', 'cst-cannabis' ); ?></h3>
                    <p class="cst-pillar-card__desc">
                        <?php esc_html_e( 'Coordinamos con el Departamento de Salud, la Policía de Puerto Rico y organizaciones comunitarias.', 'cst-cannabis' ); ?>
                    </p>
                </div>

                <div class="cst-pillar-card" role="listitem">
                    <div class="cst-pillar-card__icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                    </div>
                    <h3 class="cst-pillar-card__title"><?php esc_html_e( 'Accesibilidad universal', 'cst-cannabis' ); ?></h3>
                    <p class="cst-pillar-card__desc">
                        <?php esc_html_e( 'Nuestro contenido está disponible en español e inglés, y cumple con los estándares WCAG 2.1 AA.', 'cst-cannabis' ); ?>
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="cst-section cst-section--about-cta">
        <div class="cst-container">
            <div class="cst-about-cta-box">
                <?php cst_section_heading(
                    __( 'Contacto', 'cst-cannabis' ),
                    '',
                    'h2'
                ); ?>
                <p class="cst-about-cta-box__text">
                    <?php esc_html_e( 'Para más información sobre nuestros programas y servicios, contáctenos.', 'cst-cannabis' ); ?>
                </p>
                <?php
                $contact_url = get_permalink( get_page_by_path( 'contacto' ) );
                if ( ! $contact_url ) {
                    $contact_url = home_url( '/contacto/' );
                }
                cst_cta_button(
                    __( 'Página de contacto', 'cst-cannabis' ),
                    $contact_url,
                    'primary'
                );
                ?>
            </div>
        </div>
    </section>

    <?php
    // Render any additional page content from the editor.
    while ( have_posts() ) :
        the_post();
        $content = get_the_content();
        if ( trim( $content ) ) :
    ?>
        <section class="cst-section">
            <div class="cst-container cst-content-area">
                <?php the_content(); ?>
            </div>
        </section>
    <?php
        endif;
    endwhile;
    ?>

</main>

<?php
get_footer();

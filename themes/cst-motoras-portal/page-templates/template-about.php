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
        'title'    => get_the_title(),
        'subtitle' => __( 'Promoviendo la conducción segura de motocicletas y four tracks en Puerto Rico', 'cst-motoras' ),
        'class'    => 'cst-hero--page',
    ] );
    ?>

    <!-- Mission -->
    <section class="cst-section cst-section--about-mission">
        <div class="cst-container">
            <div class="cst-about-block">
                <?php cst_section_heading(
                    __( 'Nuestra misión', 'cst-motoras' ),
                    '',
                    'h2'
                ); ?>
                <p class="cst-about-block__text">
                    <?php echo esc_html__(
                        'La Comisión para la Seguridad en el Tránsito de Puerto Rico (CST) es la agencia gubernamental encargada de promover la seguridad vial en todo el territorio. A través de este portal educativo, nos dedicamos a proveer el módulo obligatorio de conducción segura para motociclistas y conductores de four tracks según los requisitos de la Ley 107.',
                        'cst-motoras'
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
                    __( '¿Por qué este portal?', 'cst-motoras' ),
                    '',
                    'h2'
                ); ?>
                <p class="cst-about-block__text">
                    <?php echo esc_html__(
                        'El 36% de los motociclistas en accidentes fatales no tenían licencia válida. Con la aprobación de la Ley 107 que establece requisitos de educación para el endoso de motocicletas y four tracks, este portal ofrece el módulo obligatorio de conducción segura basado en estándares locales y federales para reducir riesgos y salvar vidas en nuestras carreteras.',
                        'cst-motoras'
                    ); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Pillars -->
    <section class="cst-section cst-section--about-pillars">
        <div class="cst-container">
            <?php cst_section_heading(
                __( 'Nuestros pilares', 'cst-motoras' ),
                __( 'Los principios que guían nuestro trabajo', 'cst-motoras' ),
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
                    <h3 class="cst-pillar-card__title"><?php esc_html_e( 'Expertos en la materia', 'cst-motoras' ); ?></h3>
                    <p class="cst-pillar-card__desc">
                        <?php esc_html_e( 'Currículo oficial basado en estándares locales y federales de conducción de motocicletas y four tracks.', 'cst-motoras' ); ?>
                    </p>
                </div>

                <div class="cst-pillar-card" role="listitem">
                    <div class="cst-pillar-card__icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <h3 class="cst-pillar-card__title"><?php esc_html_e( 'Prevención proactiva', 'cst-motoras' ); ?></h3>
                    <p class="cst-pillar-card__desc">
                        <?php esc_html_e( 'Trabajamos para reducir accidentes mediante educación en conducción defensiva, equipo de protección y respuesta ante emergencias.', 'cst-motoras' ); ?>
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
                    <h3 class="cst-pillar-card__title"><?php esc_html_e( 'Alianzas confiables', 'cst-motoras' ); ?></h3>
                    <p class="cst-pillar-card__desc">
                        <?php esc_html_e( 'Fomentamos una cultura de respeto hacia peatones, ciclistas y la convivencia segura con vehículos pesados.', 'cst-motoras' ); ?>
                    </p>
                </div>

                <div class="cst-pillar-card" role="listitem">
                    <div class="cst-pillar-card__icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                    </div>
                    <h3 class="cst-pillar-card__title"><?php esc_html_e( 'Requisito de Ley', 'cst-motoras' ); ?></h3>
                    <p class="cst-pillar-card__desc">
                        <?php esc_html_e( 'Esta certificación es un requisito obligatorio e indispensable para la obtención del endoso de motocicletas y four tracks en Puerto Rico, en cumplimiento con la legislación local y federal.', 'cst-motoras' ); ?>
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
                    __( 'Contacto', 'cst-motoras' ),
                    '',
                    'h2'
                ); ?>
                <p class="cst-about-cta-box__text">
                    <?php esc_html_e( 'Para más información sobre el módulo de conducción segura para motociclistas y four tracks, contáctenos.', 'cst-motoras' ); ?>
                </p>
                <?php
                $contact_url = get_permalink( get_page_by_path( 'contacto' ) );
                if ( ! $contact_url ) {
                    $contact_url = home_url( '/contacto/' );
                }
                cst_cta_button(
                    __( 'Página de contacto', 'cst-motoras' ),
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

<?php
/**
 * Template Part: Institutional Footer (GUIDI compliant).
 *
 * Layout: Branding (wide) | Contenido | Síguenos + Contactos.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$socials = [
    'cst_facebook'  => [ 'Facebook', 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z' ],
    'cst_twitter'   => [ 'Twitter / X', 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z' ],
    'cst_instagram' => [ 'Instagram', 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z' ],
    'cst_youtube'   => [ 'YouTube', 'M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z' ],
];
$phone   = get_theme_mod( 'cst_phone' );
$email   = get_theme_mod( 'cst_email' );
$address = get_theme_mod( 'cst_address' );
?>
<footer class="cst-institutional-footer" role="contentinfo">
    <div class="cst-container">

        <!-- Main footer grid -->
        <div class="cst-institutional-footer__grid">

            <!-- Column 1: Branding + OIG -->
            <div class="cst-institutional-footer__col cst-institutional-footer__col--brand">
                <div class="cst-institutional-footer__branding">
                    <?php
                    $custom_logo_id = get_theme_mod( 'custom_logo' );
                    if ( $custom_logo_id ) :
                        echo wp_get_attachment_image( $custom_logo_id, 'thumbnail', false, [
                            'class' => 'cst-institutional-footer__seal',
                            'alt'   => esc_attr__( 'Sello CST', 'cst-cannabis' ),
                        ] );
                    endif;
                    ?>
                    <p class="cst-institutional-footer__agency">
                        <?php esc_html_e( 'Comisión para la Seguridad en el Tránsito de Puerto Rico', 'cst-cannabis' ); ?>
                    </p>
                </div>

                <div class="cst-institutional-footer__oig">
                    <div class="cst-institutional-footer__oig-header">
                        <a href="https://www.oig.pr.gov/" target="_blank" rel="noopener noreferrer"
                           aria-label="<?php esc_attr_e( 'Oficina del Inspector General', 'cst-cannabis' ); ?>">
                            <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/oig-logo.svg' ); ?>"
                                 alt="<?php esc_attr_e( 'Oficina del Inspector General', 'cst-cannabis' ); ?>"
                                 class="cst-institutional-footer__oig-seal"
                                 width="40" height="40" loading="lazy">
                        </a>
                        <p class="cst-institutional-footer__oig-heading">
                            <?php esc_html_e( 'Oficina del Inspector General', 'cst-cannabis' ); ?>
                        </p>
                    </div>
                    <ul class="cst-institutional-footer__oig-contact">
                        <li>
                            <a href="https://www.oig.pr.gov/informa" target="_blank" rel="noopener noreferrer">
                                <?php esc_html_e( 'Reportar fraude, despilfarro o abuso', 'cst-cannabis' ); ?>
                            </a>
                        </li>
                        <li>
                            <a href="mailto:informa@oig.pr.gov">informa@oig.pr.gov</a>
                        </li>
                        <li>
                            <a href="tel:+17876797979">787-679-7979</a>
                            <span class="cst-institutional-footer__oig-note">
                                (<?php esc_html_e( 'línea confidencial', 'cst-cannabis' ); ?>)
                            </span>
                        </li>
                    </ul>
                    <p class="cst-institutional-footer__oig-whistleblower">
                        <?php esc_html_e( 'Los denunciantes están protegidos por la Ley 30-2005 contra represalias.', 'cst-cannabis' ); ?>
                    </p>
                </div>
                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                <?php endif; ?>
            </div>

            <!-- Column 2: Contenido -->
            <div class="cst-institutional-footer__col">
                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                <?php else : ?>
                    <h4 class="cst-footer-widget__title"><?php esc_html_e( 'Contenido', 'cst-cannabis' ); ?></h4>
                    <?php
                    wp_nav_menu( [
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'cst-footer-menu',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ] );
                    ?>
                <?php endif; ?>
            </div>

            <!-- Column 3: Contactos -->
            <div class="cst-institutional-footer__col">
                <h4 class="cst-footer-widget__title"><?php esc_html_e( 'Contactos', 'cst-cannabis' ); ?></h4>
                <ul class="cst-footer-contact">
                    <?php if ( $email ) : ?>
                        <li>
                            <svg class="cst-footer-contact__icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ( $phone ) : ?>
                        <li>
                            <svg class="cst-footer-contact__icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                            <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ( $address ) : ?>
                        <li>
                            <svg class="cst-footer-contact__icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            <span><?php echo esc_html( $address ); ?></span>
                        </li>
                    <?php endif; ?>
                </ul>

                <h4 class="cst-footer-widget__title cst-footer-widget__title--social"><?php esc_html_e( 'Síguenos', 'cst-cannabis' ); ?></h4>
                <ul class="cst-social-links">
                    <?php foreach ( $socials as $mod_key => $data ) :
                        $url = get_theme_mod( $mod_key );
                        if ( $url ) :
                    ?>
                        <li>
                            <a href="<?php echo esc_url( $url ); ?>" target="_blank"
                               rel="noopener noreferrer"
                               aria-label="<?php echo esc_attr( $data[0] ); ?>">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="<?php echo esc_attr( $data[1] ); ?>"/>
                                </svg>
                            </a>
                        </li>
                    <?php endif; endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Bottom bar: compliance + legal + copyright -->
        <div class="cst-institutional-footer__bottom">
            <div class="cst-institutional-footer__compliance">
                <p>
                    <?php esc_html_e( 'La Comisión para la Seguridad en el Tránsito es un patrono con igualdad de oportunidades en el empleo. No se discrimina por razón de raza, color, género, nacimiento, origen o condición social, ni por ideas políticas o religiosas, edad, orientación sexual o identidad de género.', 'cst-cannabis' ); ?>
                </p>
            </div>

            <div class="cst-institutional-footer__statements">
                <p>
                    <?php
                    echo wp_kses(
                        sprintf(
                            __( 'Accesibilidad — Conforme a la <a href="%s" target="_blank" rel="noopener noreferrer">Ley 229 de 2003</a> (WCAG 2.1 AA).', 'cst-cannabis' ),
                            'https://accesibilidad.pr.gov'
                        ),
                        [ 'a' => [ 'href' => [], 'target' => [], 'rel' => [] ] ]
                    );
                    ?>
                    &nbsp;&middot;&nbsp;
                    <?php
                    echo wp_kses(
                        sprintf(
                            __( 'Transparencia — <a href="%s" target="_blank" rel="noopener noreferrer">Ley 141-2019</a>.', 'cst-cannabis' ),
                            'https://consultasenlinea.ogp.pr.gov'
                        ),
                        [ 'a' => [ 'href' => [], 'target' => [], 'rel' => [] ] ]
                    );
                    ?>
                </p>
            </div>

            <?php
            wp_nav_menu( [
                'theme_location'       => 'legal',
                'container'            => 'nav',
                'container_class'      => 'cst-legal-nav',
                'container_aria_label' => esc_attr__( 'Enlaces legales', 'cst-cannabis' ),
                'menu_class'           => 'cst-legal-menu',
                'depth'                => 1,
                'fallback_cb'          => false,
            ] );

            $privacy_page_id = (int) get_option( 'wp_page_for_privacy_policy' );
            if ( $privacy_page_id && 'publish' === get_post_status( $privacy_page_id ) ) :
            ?>
                <div class="cst-legal-nav cst-legal-nav--fallback">
                    <ul class="cst-legal-menu">
                        <li>
                            <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>">
                                <?php esc_html_e( 'Política de privacidad', 'cst-cannabis' ); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="cst-institutional-footer__copyright">
                <p>
                    &copy; <?php echo esc_html( date( 'Y' ) ); ?>
                    <?php esc_html_e( 'Comisión para la Seguridad en el Tránsito de Puerto Rico. Todos los derechos reservados.', 'cst-cannabis' ); ?>
                </p>
            </div>
        </div>

    </div>

    <!-- Back to top -->
    <button class="cst-back-to-top" aria-label="<?php esc_attr_e( 'Volver al inicio', 'cst-cannabis' ); ?>" type="button">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
            <path d="M10 4L3 11l1.4 1.4L9 7.8V16h2V7.8l4.6 4.6L17 11l-7-7z" fill="currentColor"/>
        </svg>
    </button>
</footer>

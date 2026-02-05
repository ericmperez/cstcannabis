<?php
/**
 * Template Part: Institutional Footer (GUIDI compliant).
 *
 * 4-column layout, government seal, legal links, copyright.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<footer class="cst-institutional-footer" role="contentinfo">
    <div class="cst-container">

        <!-- Footer Columns -->
        <div class="cst-institutional-footer__grid">
            <!-- Column 1: About -->
            <div class="cst-institutional-footer__col">
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
                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                <?php endif; ?>
            </div>

            <!-- Column 2 -->
            <div class="cst-institutional-footer__col">
                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                <?php else : ?>
                    <h4 class="cst-footer-widget__title"><?php esc_html_e( 'Enlaces rápidos', 'cst-cannabis' ); ?></h4>
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

            <!-- Column 3 -->
            <div class="cst-institutional-footer__col">
                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                    <?php dynamic_sidebar( 'footer-3' ); ?>
                <?php else : ?>
                    <h4 class="cst-footer-widget__title"><?php esc_html_e( 'Contacto', 'cst-cannabis' ); ?></h4>
                    <ul class="cst-footer-contact">
                        <?php
                        $phone   = get_theme_mod( 'cst_phone' );
                        $email   = get_theme_mod( 'cst_email' );
                        $address = get_theme_mod( 'cst_address' );
                        ?>
                        <?php if ( $phone ) : ?>
                            <li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
                        <?php endif; ?>
                        <?php if ( $email ) : ?>
                            <li><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
                        <?php endif; ?>
                        <?php if ( $address ) : ?>
                            <li><?php echo esc_html( $address ); ?></li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Column 4: Social -->
            <div class="cst-institutional-footer__col">
                <h4 class="cst-footer-widget__title"><?php esc_html_e( 'Redes sociales', 'cst-cannabis' ); ?></h4>
                <ul class="cst-social-links">
                    <?php
                    $socials = [
                        'cst_facebook'  => [ 'Facebook', 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z' ],
                        'cst_twitter'   => [ 'Twitter', 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z' ],
                        'cst_instagram' => [ 'Instagram', 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z' ],
                        'cst_youtube'   => [ 'YouTube', 'M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z' ],
                    ];

                    foreach ( $socials as $mod_key => $data ) :
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
                    <?php
                        endif;
                    endforeach;
                    ?>
                </ul>
            </div>
        </div>

        <!-- Legal Links -->
        <div class="cst-institutional-footer__legal">
            <?php
            wp_nav_menu( [
                'theme_location' => 'legal',
                'container'      => 'nav',
                'container_class' => 'cst-legal-nav',
                'container_aria_label' => esc_attr__( 'Enlaces legales', 'cst-cannabis' ),
                'menu_class'     => 'cst-legal-menu',
                'depth'          => 1,
                'fallback_cb'    => false,
            ] );
            ?>
        </div>

        <!-- Copyright -->
        <div class="cst-institutional-footer__copyright">
            <p>
                &copy; <?php echo esc_html( date( 'Y' ) ); ?>
                <?php esc_html_e( 'Comisión para la Seguridad en el Tránsito de Puerto Rico. Todos los derechos reservados.', 'cst-cannabis' ); ?>
            </p>
        </div>

    </div>
</footer>

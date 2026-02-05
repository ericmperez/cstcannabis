<?php
/**
 * Template Part: Institutional Header (GUIDI compliant).
 *
 * CST seal, portal name, language switcher.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="cst-institutional-header" role="banner">
    <div class="cst-container">
        <div class="cst-institutional-header__inner">
            <!-- CST Seal -->
            <div class="cst-institutional-header__branding">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="cst-institutional-header__logo-link"
                   aria-label="<?php esc_attr_e( 'Ir a la página principal', 'cst-cannabis' ); ?>">
                    <?php
                    $custom_logo_id = get_theme_mod( 'custom_logo' );
                    if ( $custom_logo_id ) :
                        echo wp_get_attachment_image( $custom_logo_id, 'medium', false, [
                            'class' => 'cst-institutional-header__seal',
                            'alt'   => esc_attr__( 'Sello de la Comisión para la Seguridad en el Tránsito', 'cst-cannabis' ),
                        ] );
                    else :
                    ?>
                        <span class="cst-institutional-header__seal-placeholder" aria-hidden="true">CST</span>
                    <?php endif; ?>
                </a>

                <div class="cst-institutional-header__titles">
                    <span class="cst-institutional-header__agency">
                        <?php esc_html_e( 'Comisión para la Seguridad en el Tránsito', 'cst-cannabis' ); ?>
                    </span>
                    <span class="cst-institutional-header__portal-name">
                        <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
                    </span>
                </div>
            </div>

            <!-- Right: Language Switcher -->
            <div class="cst-institutional-header__actions">
                <?php if ( function_exists( 'pll_the_languages' ) ) : ?>
                    <nav class="cst-lang-switcher" aria-label="<?php esc_attr_e( 'Selector de idioma', 'cst-cannabis' ); ?>">
                        <ul class="cst-lang-switcher__list">
                            <?php pll_the_languages( [
                                'display_names_as' => 'slug',
                                'hide_current'     => false,
                            ] ); ?>
                        </ul>
                    </nav>
                <?php else : ?>
                    <span class="cst-lang-switcher__static">
                        <span class="cst-lang-switcher__current" aria-label="<?php esc_attr_e( 'Idioma actual: Español', 'cst-cannabis' ); ?>">ES</span>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

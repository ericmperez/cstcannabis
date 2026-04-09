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
                    <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/cst-logo.svg' ); ?>"
                         class="cst-institutional-header__seal"
                         alt="<?php esc_attr_e( 'Sello de la Comisión para la Seguridad en el Tránsito', 'cst-cannabis' ); ?>"
                         width="861" height="280" />
                </a>

                <div class="cst-institutional-header__titles">
                    <span class="cst-institutional-header__portal-name">
                        <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
                    </span>
                </div>
            </div>

            <!-- Right: Language Switcher -->
            <div class="cst-institutional-header__actions">
                <nav class="cst-lang-switcher" aria-label="<?php esc_attr_e( 'Selector de idioma', 'cst-cannabis' ); ?>">
                    <?php if ( function_exists( 'pll_the_languages' ) ) : ?>
                        <ul class="cst-lang-switcher__list">
                            <?php pll_the_languages( [
                                'display_names_as' => 'slug',
                                'hide_current'     => false,
                            ] ); ?>
                        </ul>
                    <?php else : ?>
                        <ul class="cst-lang-switcher__list">
                            <li class="current-lang"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-current="true" lang="es">ES</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/en/' ) ); ?>" lang="en">EN</a></li>
                        </ul>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </div>
</div>

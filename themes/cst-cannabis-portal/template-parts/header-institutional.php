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

            <!-- Right: Search + Language Switcher -->
            <div class="cst-institutional-header__actions">
                <!-- Search Form -->
                <form class="cst-header-search" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>"
                      aria-label="<?php esc_attr_e( 'Buscar en el portal', 'cst-cannabis' ); ?>">
                    <label for="cst-header-search-input" class="sr-only"><?php esc_html_e( 'Buscar', 'cst-cannabis' ); ?></label>
                    <input type="search" id="cst-header-search-input" class="cst-header-search__input"
                           name="s" placeholder="<?php esc_attr_e( 'Buscar...', 'cst-cannabis' ); ?>"
                           value="<?php echo esc_attr( get_search_query() ); ?>">
                    <button type="submit" class="cst-header-search__btn"
                            aria-label="<?php esc_attr_e( 'Buscar', 'cst-cannabis' ); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </button>
                </form>

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

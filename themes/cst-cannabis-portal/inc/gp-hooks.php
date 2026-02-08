<?php
/**
 * GeneratePress hook callbacks — government banner, institutional header/footer, breadcrumbs.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ==========================================================================
   Nav: aria-current on active menu items (WCAG / Ley 229)
   ========================================================================== */

add_filter( 'nav_menu_link_attributes', 'cst_nav_aria_current', 10, 3 );

function cst_nav_aria_current( array $atts, $item, $args ): array {
    if ( in_array( 'current-menu-item', (array) $item->classes, true ) ) {
        $atts['aria-current'] = 'page';
    } elseif ( in_array( 'current-menu-ancestor', (array) $item->classes, true ) ) {
        $atts['aria-current'] = 'true';
    }
    return $atts;
}

/* ==========================================================================
   Government Banner (top of page)
   ========================================================================== */

add_action( 'generate_before_header', 'cst_government_banner', 5 );

function cst_government_banner(): void {
    ?>
    <div class="cst-gov-banner" role="complementary" aria-label="<?php esc_attr_e( 'Banner del Gobierno de Puerto Rico', 'cst-cannabis' ); ?>">
        <div class="cst-container">
            <div class="cst-gov-banner__inner">
                <p class="cst-gov-banner__text">
                    <img src="<?php echo esc_url( CST_CANNABIS_URI . '/assets/images/pr-flag-icon.svg' ); ?>"
                         alt="" width="20" height="14" class="cst-gov-banner__flag" aria-hidden="true">
                    <?php esc_html_e( 'Un sitio web oficial del Gobierno de Puerto Rico', 'cst-cannabis' ); ?>
                    <button type="button" class="cst-gov-banner__toggle" aria-expanded="false"
                            aria-controls="cst-gov-banner-details">
                        <?php esc_html_e( 'Así es como usted puede verificarlo', 'cst-cannabis' ); ?>
                        <svg aria-hidden="true" width="12" height="12" viewBox="0 0 12 12" fill="currentColor">
                            <path d="M6 8.5L1 3.5h10L6 8.5z"/>
                        </svg>
                    </button>
                </p>
                <div id="cst-gov-banner-details" class="cst-gov-banner__details" hidden>
                    <div class="cst-gov-banner__columns">
                        <div class="cst-gov-banner__col">
                            <strong><?php esc_html_e( 'Los sitios web oficiales del Gobierno de Puerto Rico usan .pr.gov', 'cst-cannabis' ); ?></strong>
                            <p><?php esc_html_e( 'Un sitio web .pr.gov pertenece a una organización oficial del Gobierno de Puerto Rico.', 'cst-cannabis' ); ?></p>
                        </div>
                        <div class="cst-gov-banner__col">
                            <strong><?php esc_html_e( 'Los sitios web seguros de .pr.gov usan HTTPS', 'cst-cannabis' ); ?></strong>
                            <p><?php esc_html_e( 'Un candado o https:// significa que usted se conectó de forma segura a un sitio web .pr.gov.', 'cst-cannabis' ); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/* ==========================================================================
   Institutional Header
   ========================================================================== */

add_action( 'generate_before_header', 'cst_institutional_header', 10 );

function cst_institutional_header(): void {
    get_template_part( 'template-parts/header', 'institutional' );
}

/* ==========================================================================
   Institutional Footer
   ========================================================================== */

add_action( 'generate_after_footer', 'cst_institutional_footer' );

function cst_institutional_footer(): void {
    get_template_part( 'template-parts/footer', 'institutional' );
}

/* ==========================================================================
   Yoast Breadcrumbs
   ========================================================================== */

add_action( 'generate_after_header', 'cst_breadcrumbs' );

function cst_breadcrumbs(): void {
    if ( is_front_page() ) {
        return;
    }

    if ( function_exists( 'yoast_breadcrumb' ) ) {
        echo '<nav class="cst-breadcrumbs" aria-label="' . esc_attr__( 'Ruta de navegación', 'cst-cannabis' ) . '">';
        echo '<div class="cst-container">';
        yoast_breadcrumb( '<p>', '</p>' );
        echo '</div>';
        echo '</nav>';
    }
}

/* ==========================================================================
   Skip-to-content Link
   ========================================================================== */

add_action( 'generate_before_header', 'cst_skip_link', 1 );

function cst_skip_link(): void {
    echo '<a class="cst-skip-link sr-only sr-only-focusable" href="#main-content">';
    esc_html_e( 'Ir al contenido principal', 'cst-cannabis' );
    echo '</a>';
}

<?php
/**
 * CST Cannabis Medicinal Portal — Theme functions.
 *
 * GeneratePress child theme for the CST Cannabis educational portal.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CST_CANNABIS_VERSION', '1.1.0' );
define( 'CST_CANNABIS_DIR', get_stylesheet_directory() );
define( 'CST_CANNABIS_URI', get_stylesheet_directory_uri() );

/* ==========================================================================
   Theme Setup
   ========================================================================== */

add_action( 'after_setup_theme', function () {
    // Translations — initial load (may be overridden by Polylang locale switch).
    load_child_theme_textdomain( 'cst-cannabis', CST_CANNABIS_DIR . '/languages' );

    // Navigation menus.
    register_nav_menus( [
        'primary'     => __( 'Menú principal', 'cst-cannabis' ),
        'footer'      => __( 'Menú del pie de página', 'cst-cannabis' ),
        'legal'       => __( 'Enlaces legales', 'cst-cannabis' ),
        'social'      => __( 'Redes sociales', 'cst-cannabis' ),
    ] );

    // Image sizes for cards.
    add_image_size( 'cst-card', 600, 400, true );
    add_image_size( 'cst-hero', 1920, 800, true );

    // Theme supports.
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
    ] );
    add_theme_support( 'responsive-embeds' );
} );

/* ==========================================================================
   Reload text domain when Polylang switches locale
   ========================================================================== */

add_action( 'wp', function () {
    if ( function_exists( 'pll_current_language' ) ) {
        $lang = pll_current_language( 'locale' );
        if ( $lang && 'es' !== substr( $lang, 0, 2 ) ) {
            unload_textdomain( 'cst-cannabis' );
            load_textdomain( 'cst-cannabis', CST_CANNABIS_DIR . '/languages/cst-cannabis-' . $lang . '.mo' );
        }
    }
}, 1 );

/* ==========================================================================
   Disable Sidebar — full-width content on all pages
   ========================================================================== */

add_filter( 'generate_sidebar_layout', function () {
    return 'no-sidebar';
} );

add_action( 'widgets_init', function () {
    unregister_sidebar( 'sidebar-1' );
}, 20 );

/* ==========================================================================
   Enqueue Styles & Scripts
   ========================================================================== */

add_action( 'wp_enqueue_scripts', function () {
    // Parent theme.
    wp_enqueue_style(
        'generatepress',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme( 'generatepress' )->get( 'Version' )
    );

    // Child theme (design tokens).
    wp_enqueue_style(
        'cst-cannabis-style',
        get_stylesheet_uri(),
        [ 'generatepress' ],
        filemtime( CST_CANNABIS_DIR . '/style.css' )
    );

    // Google Fonts — Open Sans (body) + Montserrat (headings).
    wp_enqueue_style(
        'cst-google-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap',
        [],
        null
    );

    // Dashicons — needed for stat card and KPI icons on the frontend.
    wp_enqueue_style( 'dashicons' );

    // Custom layout & component styles.
    wp_enqueue_style(
        'cst-custom',
        CST_CANNABIS_URI . '/assets/css/custom.css',
        [ 'cst-cannabis-style' ],
        filemtime( CST_CANNABIS_DIR . '/assets/css/custom.css' )
    );

    // Accessibility styles.
    wp_enqueue_style(
        'cst-accessibility',
        CST_CANNABIS_URI . '/assets/css/accessibility.css',
        [ 'cst-custom' ],
        filemtime( CST_CANNABIS_DIR . '/assets/css/accessibility.css' )
    );

    // Main JS.
    wp_enqueue_script(
        'cst-main',
        CST_CANNABIS_URI . '/assets/js/main.js',
        [],
        filemtime( CST_CANNABIS_DIR . '/assets/js/main.js' ),
        true
    );

    // Pass data to JS.
    wp_localize_script( 'cst-main', 'cstPortal', [
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'restUrl'  => rest_url( 'cst/v1/' ),
        'nonce'    => wp_create_nonce( 'wp_rest' ),
        'siteName' => get_bloginfo( 'name' ),
        'wpRestUrl' => rest_url( 'wp/v2/' ),
        'i18n'      => [
            'menuOpen'        => __( 'Abrir menú', 'cst-cannabis' ),
            'menuClose'       => __( 'Cerrar menú', 'cst-cannabis' ),
            'bannerClose'     => __( 'Cerrar banner', 'cst-cannabis' ),
            'filterAll'       => __( 'Todos', 'cst-cannabis' ),
            'searchOpen'      => __( 'Abrir búsqueda', 'cst-cannabis' ),
            'searchClose'     => __( 'Cerrar búsqueda', 'cst-cannabis' ),
            'searchLoading'   => __( 'Buscando...', 'cst-cannabis' ),
            'searchNoResults' => __( 'No se encontraron resultados.', 'cst-cannabis' ),
            'searchViewAll'   => __( 'Ver todos los resultados', 'cst-cannabis' ),
            'typePage'        => __( 'Página', 'cst-cannabis' ),
            'typePost'        => __( 'Artículo', 'cst-cannabis' ),
            'resourceFound'   => __( '%d recurso encontrado', 'cst-cannabis' ),
            'resourcesFound'  => __( '%d recursos encontrados', 'cst-cannabis' ),
        ],
        'locale'    => function_exists( 'pll_current_language' ) ? pll_current_language( 'locale' ) : 'es-PR',
    ] );
}, 20 );

/* ==========================================================================
   Force GP nav to use assigned menu (prevent page-list fallback)
   ========================================================================== */

add_filter( 'wp_nav_menu_args', function ( $args ) {
    if ( isset( $args['theme_location'] ) && 'primary' === $args['theme_location'] ) {
        $args['fallback_cb'] = false;
        // Polylang may fail to resolve the menu when the current post has no
        // language assigned. Fall back to the correct language menu directly.
        if ( ! wp_get_nav_menu_object( wp_get_nav_menu_name( 'primary' ) ) ) {
            $pll_menus = get_option( 'polylang_nav_menus', [] );
            $theme     = get_stylesheet();
            $lang      = function_exists( 'pll_current_language' ) ? pll_current_language() : 'es';
            $lang      = $lang ?: 'es';
            if ( ! empty( $pll_menus[ $theme ]['primary'][ $lang ] ) ) {
                $args['menu'] = (int) $pll_menus[ $theme ]['primary'][ $lang ];
            }
        }
    }
    return $args;
} );

/* ==========================================================================
   Include modules
   ========================================================================== */

$includes = [
    '/inc/gp-hooks.php',
    '/inc/widgets.php',
    '/inc/template-functions.php',
    '/inc/customizer.php',
];

foreach ( $includes as $file ) {
    $path = CST_CANNABIS_DIR . $file;
    if ( file_exists( $path ) ) {
        require_once $path;
    }
}

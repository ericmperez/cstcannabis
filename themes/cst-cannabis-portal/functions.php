<?php
/**
 * CST Cannabis Medicinal Portal — Theme functions.
 *
 * GeneratePress child theme for the CST Cannabis educational portal.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CST_CANNABIS_VERSION', '1.0.0' );
define( 'CST_CANNABIS_DIR', get_stylesheet_directory() );
define( 'CST_CANNABIS_URI', get_stylesheet_directory_uri() );

/* ==========================================================================
   Theme Setup
   ========================================================================== */

add_action( 'after_setup_theme', function () {
    // Translations.
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
        CST_CANNABIS_VERSION
    );

    // Google Fonts — Montserrat + Cormorant Garamond.
    wp_enqueue_style(
        'cst-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap',
        [],
        null
    );

    // Custom layout & component styles.
    wp_enqueue_style(
        'cst-custom',
        CST_CANNABIS_URI . '/assets/css/custom.css',
        [ 'cst-cannabis-style' ],
        CST_CANNABIS_VERSION
    );

    // Accessibility styles.
    wp_enqueue_style(
        'cst-accessibility',
        CST_CANNABIS_URI . '/assets/css/accessibility.css',
        [ 'cst-custom' ],
        CST_CANNABIS_VERSION
    );

    // Main JS.
    wp_enqueue_script(
        'cst-main',
        CST_CANNABIS_URI . '/assets/js/main.js',
        [],
        CST_CANNABIS_VERSION,
        true
    );

    // Pass data to JS.
    wp_localize_script( 'cst-main', 'cstPortal', [
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'restUrl'  => rest_url( 'cst/v1/' ),
        'nonce'    => wp_create_nonce( 'wp_rest' ),
        'siteName' => get_bloginfo( 'name' ),
        'i18n'     => [
            'menuOpen'    => __( 'Abrir menú', 'cst-cannabis' ),
            'menuClose'   => __( 'Cerrar menú', 'cst-cannabis' ),
            'bannerClose' => __( 'Cerrar banner', 'cst-cannabis' ),
            'filterAll'   => __( 'Todos', 'cst-cannabis' ),
        ],
    ] );
}, 20 );

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

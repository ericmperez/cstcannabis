<?php
/**
 * CST Curso de Motoras Portal — Theme functions.
 *
 * GeneratePress child theme for the CST Cannabis educational portal.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CST_MOTORAS_VERSION', '1.1.0' );
define( 'CST_MOTORAS_DIR', get_stylesheet_directory() );
define( 'CST_MOTORAS_URI', get_stylesheet_directory_uri() );

/* ==========================================================================
   Theme Setup
   ========================================================================== */

add_action( 'after_setup_theme', function () {
    // Translations.
    load_child_theme_textdomain( 'cst-motoras', CST_MOTORAS_DIR . '/languages' );

    // Navigation menus.
    register_nav_menus( [
        'primary'     => __( 'Menú principal', 'cst-motoras' ),
        'footer'      => __( 'Menú del pie de página', 'cst-motoras' ),
        'legal'       => __( 'Enlaces legales', 'cst-motoras' ),
        'social'      => __( 'Redes sociales', 'cst-motoras' ),
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
        'cst-motoras-style',
        get_stylesheet_uri(),
        [ 'generatepress' ],
        CST_MOTORAS_VERSION
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
        CST_MOTORAS_URI . '/assets/css/custom.css',
        [ 'cst-motoras-style' ],
        CST_MOTORAS_VERSION
    );

    // Accessibility styles.
    wp_enqueue_style(
        'cst-accessibility',
        CST_MOTORAS_URI . '/assets/css/accessibility.css',
        [ 'cst-custom' ],
        CST_MOTORAS_VERSION
    );

    // Main JS.
    wp_enqueue_script(
        'cst-main',
        CST_MOTORAS_URI . '/assets/js/main.js',
        [],
        CST_MOTORAS_VERSION,
        true
    );

    // Pass data to JS.
    wp_localize_script( 'cst-main', 'cstPortal', [
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'restUrl'  => rest_url( 'cst/v1/' ),
        'nonce'    => wp_create_nonce( 'wp_rest' ),
        'siteName' => get_bloginfo( 'name' ),
        'i18n'     => [
            'menuOpen'    => __( 'Abrir menú', 'cst-motoras' ),
            'menuClose'   => __( 'Cerrar menú', 'cst-motoras' ),
            'bannerClose' => __( 'Cerrar banner', 'cst-motoras' ),
            'filterAll'   => __( 'Todos', 'cst-motoras' ),
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
    $path = CST_MOTORAS_DIR . $file;
    if ( file_exists( $path ) ) {
        require_once $path;
    }
}

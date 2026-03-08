<?php
/**
 * Widget areas — sidebar and footer columns.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'widgets_init', function () {
    // Sidebar for resource pages.
    register_sidebar( [
        'name'          => __( 'Barra lateral de recursos', 'cst-motoras' ),
        'id'            => 'sidebar-resources',
        'description'   => __( 'Aparece en las páginas de recursos educativos.', 'cst-motoras' ),
        'before_widget' => '<div id="%1$s" class="cst-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="cst-widget__title">',
        'after_title'   => '</h3>',
    ] );

    // Footer column 1.
    register_sidebar( [
        'name'          => __( 'Pie de página — Columna 1', 'cst-motoras' ),
        'id'            => 'footer-1',
        'description'   => __( 'Primera columna del pie de página institucional.', 'cst-motoras' ),
        'before_widget' => '<div id="%1$s" class="cst-footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="cst-footer-widget__title">',
        'after_title'   => '</h4>',
    ] );

    // Footer column 2.
    register_sidebar( [
        'name'          => __( 'Pie de página — Columna 2', 'cst-motoras' ),
        'id'            => 'footer-2',
        'description'   => __( 'Segunda columna del pie de página institucional.', 'cst-motoras' ),
        'before_widget' => '<div id="%1$s" class="cst-footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="cst-footer-widget__title">',
        'after_title'   => '</h4>',
    ] );

    // Footer column 3.
    register_sidebar( [
        'name'          => __( 'Pie de página — Columna 3', 'cst-motoras' ),
        'id'            => 'footer-3',
        'description'   => __( 'Tercera columna del pie de página institucional.', 'cst-motoras' ),
        'before_widget' => '<div id="%1$s" class="cst-footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="cst-footer-widget__title">',
        'after_title'   => '</h4>',
    ] );

    // Footer column 4 (Servicios).
    register_sidebar( [
        'name'          => __( 'Pie de página — Columna 4 (Servicios)', 'cst-motoras' ),
        'id'            => 'footer-4',
        'description'   => __( 'Cuarta columna del pie de página institucional — Servicios.', 'cst-motoras' ),
        'before_widget' => '<div id="%1$s" class="cst-footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="cst-footer-widget__title">',
        'after_title'   => '</h4>',
    ] );
} );

<?php
/**
 * Customizer settings — hero image, contact info, social links.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {

    /* ------------------------------------------------------------------ */
    /*  CST Portal Section                                                */
    /* ------------------------------------------------------------------ */
    $wp_customize->add_section( 'cst_portal', [
        'title'    => __( 'Portal CST', 'cst-cannabis' ),
        'priority' => 30,
    ] );

    /* --- Hero Image --- */
    $wp_customize->add_setting( 'cst_hero_image', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cst_hero_image', [
        'label'   => __( 'Imagen del héroe', 'cst-cannabis' ),
        'section' => 'cst_portal',
    ] ) );

    /* --- Hero Title Override --- */
    $wp_customize->add_setting( 'cst_hero_title', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'cst_hero_title', [
        'label'   => __( 'Título del héroe (vacío = nombre del sitio)', 'cst-cannabis' ),
        'section' => 'cst_portal',
        'type'    => 'text',
    ] );

    /* --- Hero Subtitle Override --- */
    $wp_customize->add_setting( 'cst_hero_subtitle', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ] );
    $wp_customize->add_control( 'cst_hero_subtitle', [
        'label'   => __( 'Subtítulo del héroe (vacío = descripción del sitio)', 'cst-cannabis' ),
        'section' => 'cst_portal',
        'type'    => 'text',
    ] );

    /* ------------------------------------------------------------------ */
    /*  Contact Info Section                                              */
    /* ------------------------------------------------------------------ */
    $wp_customize->add_section( 'cst_contact', [
        'title'    => __( 'Información de contacto', 'cst-cannabis' ),
        'priority' => 31,
    ] );

    $contact_fields = [
        'cst_phone'   => __( 'Teléfono', 'cst-cannabis' ),
        'cst_email'   => __( 'Correo electrónico', 'cst-cannabis' ),
        'cst_address' => __( 'Dirección', 'cst-cannabis' ),
    ];

    foreach ( $contact_fields as $id => $label ) {
        $wp_customize->add_setting( $id, [
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ] );
        $wp_customize->add_control( $id, [
            'label'   => $label,
            'section' => 'cst_contact',
            'type'    => 'text',
        ] );
    }

    /* ------------------------------------------------------------------ */
    /*  Social Links Section                                              */
    /* ------------------------------------------------------------------ */
    $wp_customize->add_section( 'cst_social', [
        'title'    => __( 'Redes sociales', 'cst-cannabis' ),
        'priority' => 32,
    ] );

    $social_fields = [
        'cst_facebook'  => 'Facebook URL',
        'cst_twitter'   => 'Twitter / X URL',
        'cst_instagram' => 'Instagram URL',
        'cst_youtube'   => 'YouTube URL',
    ];

    foreach ( $social_fields as $id => $label ) {
        $wp_customize->add_setting( $id, [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ] );
        $wp_customize->add_control( $id, [
            'label'   => $label,
            'section' => 'cst_social',
            'type'    => 'url',
        ] );
    }
} );

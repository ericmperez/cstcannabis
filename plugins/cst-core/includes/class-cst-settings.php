<?php
/**
 * CST_Settings — Admin settings page for CST Core plugin.
 *
 * Settings: WhatsApp number, LLM API key/endpoint, chatbot toggle.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Settings {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'add_menu_page' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
    }

    public function add_menu_page(): void {
        add_options_page(
            __( 'Configuración CST', 'cst-core' ),
            __( 'CST Portal', 'cst-core' ),
            'manage_options',
            'cst-settings',
            [ $this, 'render_page' ]
        );
    }

    public function register_settings(): void {
        // WhatsApp.
        register_setting( 'cst_settings', 'cst_whatsapp_number', [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => '',
        ] );

        register_setting( 'cst_settings', 'cst_whatsapp_message', [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => '',
        ] );

        register_setting( 'cst_settings', 'cst_whatsapp_enabled', [
            'type'              => 'boolean',
            'sanitize_callback' => 'rest_sanitize_boolean',
            'default'           => false,
        ] );

        // Chatbot.
        register_setting( 'cst_settings', 'cst_chatbot_enabled', [
            'type'              => 'boolean',
            'sanitize_callback' => 'rest_sanitize_boolean',
            'default'           => true,
        ] );

        register_setting( 'cst_settings', 'cst_chatbot_api_endpoint', [
            'type'              => 'string',
            'sanitize_callback' => 'esc_url_raw',
            'default'           => '',
        ] );

        register_setting( 'cst_settings', 'cst_chatbot_api_key', [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => '',
        ] );

        register_setting( 'cst_settings', 'cst_chatbot_greeting', [
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default'           => '',
        ] );

        // Sections.
        add_settings_section( 'cst_whatsapp_section', __( 'WhatsApp', 'cst-core' ), null, 'cst-settings' );
        add_settings_section( 'cst_chatbot_section', __( 'Chatbot', 'cst-core' ), null, 'cst-settings' );

        // WhatsApp fields.
        add_settings_field( 'cst_whatsapp_enabled', __( 'Activar botón', 'cst-core' ), [ $this, 'render_checkbox' ], 'cst-settings', 'cst_whatsapp_section', [ 'id' => 'cst_whatsapp_enabled' ] );
        add_settings_field( 'cst_whatsapp_number', __( 'Número (con código país)', 'cst-core' ), [ $this, 'render_text_field' ], 'cst-settings', 'cst_whatsapp_section', [ 'id' => 'cst_whatsapp_number', 'placeholder' => '+17875551234' ] );
        add_settings_field( 'cst_whatsapp_message', __( 'Mensaje predeterminado', 'cst-core' ), [ $this, 'render_text_field' ], 'cst-settings', 'cst_whatsapp_section', [ 'id' => 'cst_whatsapp_message', 'placeholder' => 'Hola, tengo una pregunta sobre…' ] );

        // Chatbot fields.
        add_settings_field( 'cst_chatbot_enabled', __( 'Activar chatbot', 'cst-core' ), [ $this, 'render_checkbox' ], 'cst-settings', 'cst_chatbot_section', [ 'id' => 'cst_chatbot_enabled' ] );
        add_settings_field( 'cst_chatbot_greeting', __( 'Mensaje de bienvenida', 'cst-core' ), [ $this, 'render_text_field' ], 'cst-settings', 'cst_chatbot_section', [ 'id' => 'cst_chatbot_greeting', 'placeholder' => '¡Hola! ¿En qué puedo ayudarle?' ] );
        add_settings_field( 'cst_chatbot_api_endpoint', __( 'URL del API LLM', 'cst-core' ), [ $this, 'render_text_field' ], 'cst-settings', 'cst_chatbot_section', [ 'id' => 'cst_chatbot_api_endpoint', 'placeholder' => 'https://api.example.com/v1/chat' ] );
        add_settings_field( 'cst_chatbot_api_key', __( 'API Key', 'cst-core' ), [ $this, 'render_password_field' ], 'cst-settings', 'cst_chatbot_section', [ 'id' => 'cst_chatbot_api_key' ] );
    }

    public function render_page(): void {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'Configuración del Portal CST', 'cst-core' ); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'cst_settings' );
                do_settings_sections( 'cst-settings' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function render_text_field( array $args ): void {
        $id    = $args['id'];
        $value = get_option( $id, '' );
        $ph    = $args['placeholder'] ?? '';
        printf(
            '<input type="text" id="%s" name="%s" value="%s" class="regular-text" placeholder="%s">',
            esc_attr( $id ),
            esc_attr( $id ),
            esc_attr( $value ),
            esc_attr( $ph )
        );
    }

    public function render_password_field( array $args ): void {
        $id    = $args['id'];
        $value = get_option( $id, '' );
        printf(
            '<input type="password" id="%s" name="%s" value="%s" class="regular-text" autocomplete="off">',
            esc_attr( $id ),
            esc_attr( $id ),
            esc_attr( $value )
        );
    }

    public function render_checkbox( array $args ): void {
        $id      = $args['id'];
        $checked = get_option( $id, false );
        printf(
            '<input type="checkbox" id="%s" name="%s" value="1" %s>',
            esc_attr( $id ),
            esc_attr( $id ),
            checked( $checked, true, false )
        );
    }
}

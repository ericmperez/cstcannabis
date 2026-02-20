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

    /**
     * Get the encryption key — derived from AUTH_KEY for portability.
     */
    private static function get_encryption_key(): string {
        $auth_key = defined( 'AUTH_KEY' ) ? AUTH_KEY : 'cst-default-key-change-me';
        return substr( hash( 'sha256', $auth_key, true ), 0, SODIUM_CRYPTO_SECRETBOX_KEYBYTES );
    }

    /**
     * Encrypt a value before storing in wp_options.
     */
    public static function encrypt( string $value ): string {
        if ( empty( $value ) || ! function_exists( 'sodium_crypto_secretbox' ) ) {
            return $value;
        }

        $nonce      = random_bytes( SODIUM_CRYPTO_SECRETBOX_NONCEBYTES );
        $ciphertext = sodium_crypto_secretbox( $value, $nonce, self::get_encryption_key() );

        return 'enc:' . base64_encode( $nonce . $ciphertext );
    }

    /**
     * Decrypt a value retrieved from wp_options.
     */
    public static function decrypt( string $value ): string {
        if ( empty( $value ) || strpos( $value, 'enc:' ) !== 0 || ! function_exists( 'sodium_crypto_secretbox_open' ) ) {
            return $value; // Not encrypted or sodium unavailable — return as-is.
        }

        $decoded = base64_decode( substr( $value, 4 ) );
        if ( $decoded === false || strlen( $decoded ) < SODIUM_CRYPTO_SECRETBOX_NONCEBYTES ) {
            return '';
        }

        $nonce      = substr( $decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES );
        $ciphertext = substr( $decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES );
        $plaintext  = sodium_crypto_secretbox_open( $ciphertext, $nonce, self::get_encryption_key() );

        return $plaintext !== false ? $plaintext : '';
    }

    /**
     * Get a decrypted API key from options.
     */
    public static function get_api_key( string $option_name = 'cst_chatbot_api_key' ): string {
        return self::decrypt( get_option( $option_name, '' ) );
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
            'sanitize_callback' => [ $this, 'sanitize_and_encrypt_key' ],
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
        $has_key = ! empty( $value );
        printf(
            '<input type="password" id="%s" name="%s" value="" class="regular-text" autocomplete="off" placeholder="%s">',
            esc_attr( $id ),
            esc_attr( $id ),
            $has_key ? esc_attr__( '••••••••  (guardada — dejar vacío para mantener)', 'cst-core' ) : ''
        );
        if ( $has_key ) {
            echo '<p class="description">' . esc_html__( 'La clave API está guardada de forma encriptada. Introduzca un nuevo valor para cambiarla.', 'cst-core' ) . '</p>';
        }
    }

    /**
     * Sanitize and encrypt the API key before saving.
     */
    public function sanitize_and_encrypt_key( string $value ): string {
        $value = sanitize_text_field( $value );

        // If empty, keep the existing encrypted value.
        if ( empty( $value ) ) {
            return get_option( 'cst_chatbot_api_key', '' );
        }

        return self::encrypt( $value );
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

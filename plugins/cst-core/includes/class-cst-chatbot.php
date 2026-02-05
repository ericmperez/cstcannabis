<?php
/**
 * CST_Chatbot — Chat widget + REST endpoint.
 *
 * POST /wp-json/cst/v1/chat — accepts { message: string }
 * - If LLM API is configured, proxies to external API.
 * - If not, uses CST_Chatbot_Context to search FAQs locally.
 * - Rate-limited: 10 requests per minute per IP.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Chatbot {

    private const RATE_LIMIT     = 10;
    private const RATE_WINDOW    = 60; // seconds

    public function __construct() {
        add_action( 'wp_footer', [ $this, 'render_widget' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
        add_action( 'rest_api_init', [ $this, 'register_rest_route' ] );
    }

    /* ------------------------------------------------------------------ */
    /*  REST API                                                          */
    /* ------------------------------------------------------------------ */

    public function register_rest_route(): void {
        register_rest_route( 'cst/v1', '/chat', [
            'methods'             => 'POST',
            'callback'            => [ $this, 'handle_chat' ],
            'permission_callback' => '__return_true',
            'args'                => [
                'message' => [
                    'required'          => true,
                    'type'              => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                    'validate_callback' => function ( $value ) {
                        return is_string( $value ) && mb_strlen( trim( $value ) ) > 0 && mb_strlen( $value ) <= 500;
                    },
                ],
            ],
        ] );
    }

    public function handle_chat( WP_REST_Request $request ): WP_REST_Response {
        // Rate limiting.
        if ( $this->is_rate_limited() ) {
            return new WP_REST_Response( [
                'reply'  => __( 'Ha enviado demasiados mensajes. Por favor espere un momento.', 'cst-core' ),
                'source' => 'rate_limit',
            ], 429 );
        }

        $message = trim( $request->get_param( 'message' ) );

        // Try LLM API first if configured.
        $api_endpoint = get_option( 'cst_chatbot_api_endpoint', '' );
        $api_key      = get_option( 'cst_chatbot_api_key', '' );

        if ( $api_endpoint && $api_key ) {
            $reply = $this->query_llm( $message, $api_endpoint, $api_key );
            if ( $reply ) {
                return new WP_REST_Response( [
                    'reply'  => $reply,
                    'source' => 'llm',
                ], 200 );
            }
        }

        // Fallback: search FAQ knowledge base.
        $faq_answer = CST_Chatbot_Context::find_answer( $message );
        if ( $faq_answer ) {
            return new WP_REST_Response( [
                'reply'  => $faq_answer,
                'source' => 'faq',
            ], 200 );
        }

        // No match found.
        $default_reply = __( 'Gracias por su pregunta. No encontré una respuesta específica, pero puede contactarnos directamente para más información.', 'cst-core' );
        $whatsapp = get_option( 'cst_whatsapp_number', '' );
        if ( $whatsapp ) {
            $clean = preg_replace( '/[^0-9]/', '', $whatsapp );
            $default_reply .= ' ' . sprintf(
                /* translators: %s: WhatsApp link */
                __( 'También puede escribirnos por <a href="https://wa.me/%s" target="_blank" rel="noopener noreferrer">WhatsApp</a>.', 'cst-core' ),
                $clean
            );
        }

        return new WP_REST_Response( [
            'reply'  => $default_reply,
            'source' => 'default',
        ], 200 );
    }

    /* ------------------------------------------------------------------ */
    /*  LLM API Proxy (placeholder)                                       */
    /* ------------------------------------------------------------------ */

    private function query_llm( string $message, string $endpoint, string $api_key ): string {
        $body = wp_json_encode( [
            'message' => $message,
            'context' => 'CST Puerto Rico educational portal about medical cannabis and road safety.',
            'lang'    => 'es',
        ] );

        $response = wp_remote_post( $endpoint, [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $api_key,
            ],
            'body'    => $body,
            'timeout' => 15,
        ] );

        if ( is_wp_error( $response ) ) {
            return '';
        }

        $code = wp_remote_retrieve_response_code( $response );
        if ( $code !== 200 ) {
            return '';
        }

        $data = json_decode( wp_remote_retrieve_body( $response ), true );

        // Expected response format: { "reply": "..." }
        return $data['reply'] ?? '';
    }

    /* ------------------------------------------------------------------ */
    /*  Rate Limiting (transient-based, per IP)                           */
    /* ------------------------------------------------------------------ */

    private function is_rate_limited(): bool {
        $ip  = $this->get_client_ip();
        $key = 'cst_chat_rate_' . md5( $ip );

        $count = (int) get_transient( $key );
        if ( $count >= self::RATE_LIMIT ) {
            return true;
        }

        set_transient( $key, $count + 1, self::RATE_WINDOW );
        return false;
    }

    private function get_client_ip(): string {
        $headers = [ 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'REMOTE_ADDR' ];
        foreach ( $headers as $header ) {
            if ( ! empty( $_SERVER[ $header ] ) ) {
                $ips = explode( ',', sanitize_text_field( wp_unslash( $_SERVER[ $header ] ) ) );
                return trim( $ips[0] );
            }
        }
        return '127.0.0.1';
    }

    /* ------------------------------------------------------------------ */
    /*  Front-end Widget                                                  */
    /* ------------------------------------------------------------------ */

    public function enqueue_assets(): void {
        if ( ! $this->is_enabled() ) {
            return;
        }

        wp_enqueue_style(
            'cst-chatbot',
            CST_CORE_URL . 'assets/css/chatbot.css',
            [],
            CST_CORE_VERSION
        );

        wp_enqueue_script(
            'cst-chatbot',
            CST_CORE_URL . 'assets/js/chatbot.js',
            [],
            CST_CORE_VERSION,
            true
        );

        $greeting = get_option( 'cst_chatbot_greeting', '' );
        if ( ! $greeting ) {
            $greeting = __( '¡Hola! Soy el asistente virtual del portal CST. ¿En qué puedo ayudarle?', 'cst-core' );
        }

        wp_localize_script( 'cst-chatbot', 'cstChatbot', [
            'endpoint' => rest_url( 'cst/v1/chat' ),
            'nonce'    => wp_create_nonce( 'wp_rest' ),
            'greeting' => $greeting,
            'i18n'     => [
                'title'       => __( 'Asistente Virtual', 'cst-core' ),
                'placeholder' => __( 'Escriba su pregunta…', 'cst-core' ),
                'send'        => __( 'Enviar', 'cst-core' ),
                'close'       => __( 'Cerrar chat', 'cst-core' ),
                'open'        => __( 'Abrir chat de ayuda', 'cst-core' ),
                'typing'      => __( 'Escribiendo…', 'cst-core' ),
                'error'       => __( 'Hubo un error al procesar su mensaje. Por favor intente de nuevo.', 'cst-core' ),
            ],
        ] );
    }

    public function render_widget(): void {
        if ( ! $this->is_enabled() ) {
            return;
        }
        ?>
        <div class="cst-chatbot" id="cst-chatbot" aria-label="<?php esc_attr_e( 'Chat de ayuda', 'cst-core' ); ?>">
            <!-- Toggle button -->
            <button type="button" class="cst-chatbot__toggle" id="cst-chatbot-toggle"
                    aria-expanded="false" aria-controls="cst-chatbot-window"
                    aria-label="<?php esc_attr_e( 'Abrir chat de ayuda', 'cst-core' ); ?>">
                <svg class="cst-chatbot__toggle-icon cst-chatbot__toggle-icon--chat" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
                </svg>
                <svg class="cst-chatbot__toggle-icon cst-chatbot__toggle-icon--close" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" style="display:none">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </button>

            <!-- Chat window -->
            <div class="cst-chatbot__window" id="cst-chatbot-window" role="dialog"
                 aria-label="<?php esc_attr_e( 'Ventana de chat', 'cst-core' ); ?>">

                <div class="cst-chatbot__header">
                    <span class="cst-chatbot__title"><?php esc_html_e( 'Asistente Virtual', 'cst-core' ); ?></span>
                    <button type="button" class="cst-chatbot__close" id="cst-chatbot-close"
                            aria-label="<?php esc_attr_e( 'Cerrar chat', 'cst-core' ); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </button>
                </div>

                <div class="cst-chatbot__messages" id="cst-chatbot-messages" role="log" aria-live="polite" aria-atomic="false">
                    <!-- Messages injected by JS -->
                </div>

                <form class="cst-chatbot__form" id="cst-chatbot-form" autocomplete="off">
                    <label for="cst-chatbot-input" class="sr-only">
                        <?php esc_html_e( 'Escriba su pregunta', 'cst-core' ); ?>
                    </label>
                    <input type="text" id="cst-chatbot-input" class="cst-chatbot__input"
                           placeholder="<?php esc_attr_e( 'Escriba su pregunta…', 'cst-core' ); ?>"
                           maxlength="500" required>
                    <button type="submit" class="cst-chatbot__send"
                            aria-label="<?php esc_attr_e( 'Enviar mensaje', 'cst-core' ); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        <?php
    }

    private function is_enabled(): bool {
        return (bool) get_option( 'cst_chatbot_enabled', true );
    }
}

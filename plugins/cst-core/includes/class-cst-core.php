<?php
/**
 * CST_Core — Singleton orchestrator that loads all modules.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Core {

    /** @var self|null */
    private static $instance = null;

    public static function get_instance(): self {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->load_modules();
        add_action( 'init', [ $this, 'load_textdomain' ] );
    }

    public function load_textdomain(): void {
        load_plugin_textdomain( 'cst-core', false, dirname( CST_CORE_BASENAME ) . '/languages' );
    }

    private function load_modules(): void {
        // Sprint 1 — foundation.
        new CST_Post_Types();
        new CST_Security();
        new CST_Accessibility();

        // Sprint 3 — interactive features (loaded if class exists).
        if ( class_exists( 'CST_Settings' ) ) {
            new CST_Settings();
        }
        if ( class_exists( 'CST_WhatsApp' ) ) {
            new CST_WhatsApp();
        }
        if ( class_exists( 'CST_Statistics' ) ) {
            new CST_Statistics();
        }
        if ( class_exists( 'CST_Chatbot' ) ) {
            new CST_Chatbot();
        }
    }
}

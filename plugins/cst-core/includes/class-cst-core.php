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
        // Reload once Polylang has resolved the request language (see below).
        add_action( 'wp', [ $this, 'reload_textdomain_for_language' ], 1 );
    }

    public function load_textdomain(): void {
        load_plugin_textdomain( 'cst-core', false, dirname( CST_CORE_BASENAME ) . '/languages' );
    }

    /**
     * Reload the text domain after Polylang resolves the frontend language.
     *
     * The initial load at 'init' runs before Polylang sets the request locale,
     * so on non-Spanish pages the strings would otherwise fall back to the
     * Spanish source. Mirrors the theme's reload in functions.php.
     */
    public function reload_textdomain_for_language(): void {
        if ( ! function_exists( 'pll_current_language' ) ) {
            return;
        }
        $locale = pll_current_language( 'locale' );
        if ( $locale && 'es' !== substr( (string) $locale, 0, 2 ) ) {
            unload_textdomain( 'cst-core' );
            load_textdomain(
                'cst-core',
                WP_PLUGIN_DIR . '/' . dirname( CST_CORE_BASENAME ) . '/languages/cst-core-' . $locale . '.mo'
            );
        }
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
        if ( class_exists( 'CST_Login_Form' ) ) {
            new CST_Login_Form();
        }
        if ( class_exists( 'CST_Redirects' ) ) {
            new CST_Redirects();
        }
        if ( class_exists( 'CST_Auto_Enrollment' ) ) {
            new CST_Auto_Enrollment();
        }
        if ( class_exists( 'CST_Analytics' ) ) {
            new CST_Analytics();
        }
        if ( is_admin() && class_exists( 'CST_Admin_Cleanup' ) ) {
            new CST_Admin_Cleanup();
        }
        if ( class_exists( 'CST_Seo' ) ) {
            new CST_Seo();
        }
        if ( class_exists( 'CST_Login_Throttle' ) ) {
            new CST_Login_Throttle();
        }
        // Cookie consent is handled by the CookieYes (cookie-law-info) plugin;
        // the built-in CST_Consent banner is intentionally not instantiated to
        // avoid showing two competing consent prompts.
        if ( class_exists( 'CST_Content_Seeder' ) ) {
            new CST_Content_Seeder();
        }
        if ( class_exists( 'CST_Forms_Hardening' ) ) {
            new CST_Forms_Hardening();
        }
    }
}

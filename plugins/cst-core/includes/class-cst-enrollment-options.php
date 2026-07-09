<?php
/**
 * CST_Enrollment_Options — keep public student registration enabled.
 *
 * Tutor LMS registration silently fails ("Acceso denegado") when WordPress
 * `users_can_register` is off. This module forces the option on for the
 * free educational portal and keeps the default role at `subscriber`.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Enrollment_Options {

    public function __construct() {
        add_action( 'init', [ $this, 'ensure_registration_options' ], 5 );
        register_activation_hook( CST_CORE_FILE, [ __CLASS__, 'on_activate' ] );
    }

    /**
     * Re-assert registration options (idempotent).
     */
    public function ensure_registration_options(): void {
        if ( (string) get_option( 'users_can_register' ) !== '1' ) {
            update_option( 'users_can_register', 1 );
        }
        if ( (string) get_option( 'default_role' ) !== 'subscriber' ) {
            update_option( 'default_role', 'subscriber' );
        }
    }

    /**
     * Activation-time bootstrap (also runs ensure on construct for safety).
     */
    public static function on_activate(): void {
        update_option( 'users_can_register', 1 );
        update_option( 'default_role', 'subscriber' );
    }
}

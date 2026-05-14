<?php
/**
 * CST_Login_Throttle — Per-IP brute-force protection for wp-login and
 * Tutor LMS student registration.
 *
 * Counts failed logins / registrations in a sliding 15-minute window
 * via transients. Once the threshold is hit the IP is locked for the
 * lockout window — wp_authenticate returns a generic error, and the
 * Tutor registration form rejects the submission.
 *
 * Limits are intentionally lenient (8 fails / 15 min, 30 min lockout)
 * so a forgetful student doesn't get locked out forever, while a
 * scripted attacker is throttled to a useless rate.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Login_Throttle {

    private const MAX_ATTEMPTS  = 8;
    private const WINDOW        = 15 * MINUTE_IN_SECONDS;
    private const LOCKOUT       = 30 * MINUTE_IN_SECONDS;

    public function __construct() {
        // Block the auth handshake before WP checks credentials.
        add_filter( 'authenticate',          [ $this, 'block_if_locked' ], 5, 3 );
        add_action( 'wp_login_failed',       [ $this, 'register_failure' ] );
        add_action( 'wp_login',              [ $this, 'reset_on_success' ], 10, 2 );

        // Tutor student registration submission.
        add_action( 'tutor_action_register_student', [ $this, 'guard_registration' ], 5 );
    }

    /**
     * Short-circuit authenticate() with a generic error when the IP is
     * currently locked out.
     */
    public function block_if_locked( $user, $username, $password ) {
        // Don't interfere with empty-form initial loads.
        if ( empty( $username ) && empty( $password ) ) {
            return $user;
        }
        if ( $this->is_locked() ) {
            return new WP_Error(
                'cst_login_throttled',
                __( 'Demasiados intentos fallidos. Por favor espere unos minutos antes de volver a intentar.', 'cst-core' )
            );
        }
        return $user;
    }

    public function register_failure( string $username ): void {
        unset( $username );
        $key   = $this->counter_key();
        $count = (int) get_transient( $key );
        $count++;

        if ( $count >= self::MAX_ATTEMPTS ) {
            set_transient( $this->lockout_key(), 1, self::LOCKOUT );
            delete_transient( $key );
            return;
        }
        set_transient( $key, $count, self::WINDOW );
    }

    public function reset_on_success( string $user_login, $user ): void {
        unset( $user_login, $user );
        delete_transient( $this->counter_key() );
        delete_transient( $this->lockout_key() );
    }

    /**
     * Tutor LMS doesn't fire wp_login_failed when their custom form
     * rejects input, so guard the registration submission at its own
     * action hook.
     */
    public function guard_registration(): void {
        if ( $this->is_locked() ) {
            wp_die(
                esc_html__( 'Demasiados intentos. Por favor espere unos minutos antes de volver a intentar.', 'cst-core' ),
                esc_html__( 'Solicitud bloqueada', 'cst-core' ),
                [ 'response' => 429 ]
            );
        }
    }

    private function is_locked(): bool {
        return (bool) get_transient( $this->lockout_key() );
    }

    private function counter_key(): string {
        return 'cst_login_fail_' . md5( $this->client_ip() );
    }

    private function lockout_key(): string {
        return 'cst_login_lock_' . md5( $this->client_ip() );
    }

    /**
     * REMOTE_ADDR only — X-Forwarded-For can be spoofed by anyone unless
     * we know we're behind a trusted proxy, and rate-limit bypass is
     * exactly the attack model here.
     */
    private function client_ip(): string {
        return isset( $_SERVER['REMOTE_ADDR'] )
            ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) )
            : '127.0.0.1';
    }
}

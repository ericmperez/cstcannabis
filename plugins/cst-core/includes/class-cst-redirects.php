<?php
/**
 * CST_Redirects — 301 redirects for legacy URLs.
 *
 * The willai source site and common WordPress install patterns expose
 * registration paths that this portal does not own. We send them to the
 * canonical Tutor LMS student-registration page so users (and search
 * engines that may have indexed willai's URLs) don't hit a 404.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Redirects {

    /** Map of legacy paths → canonical destinations (relative to home). */
    private const MAP = [
        'register'      => '/student-registration/',
        'inscripcion'   => '/student-registration/',
        'inscripción'   => '/student-registration/',
        'registro'      => '/student-registration/',
        'crear-cuenta'  => '/student-registration/',
    ];

    public function __construct() {
        add_action( 'template_redirect', [ $this, 'maybe_redirect' ] );
    }

    public function maybe_redirect(): void {
        if ( is_admin() || ! is_404() ) {
            return;
        }

        $request = trim( wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ) ?? '', '/' );
        if ( '' === $request ) {
            return;
        }

        if ( isset( self::MAP[ $request ] ) ) {
            wp_safe_redirect( home_url( self::MAP[ $request ] ), 301 );
            exit;
        }
    }
}

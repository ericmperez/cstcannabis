<?php
/**
 * CST_Security — Security headers for government portal compliance.
 *
 * Sends HSTS, CSP, X-Frame-Options, Referrer-Policy, Permissions-Policy,
 * X-Content-Type-Options, and X-XSS-Protection headers on front-end responses.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Security {

    /**
     * CSP nonce — generated once per request.
     */
    private static string $csp_nonce = '';

    public function __construct() {
        // Generate nonce early.
        self::$csp_nonce = wp_generate_password( 24, false );

        add_action( 'send_headers', [ $this, 'send_security_headers' ] );
        add_filter( 'wp_headers', [ $this, 'add_wp_headers' ] );

        // Add nonce to inline scripts/styles that WordPress outputs.
        add_filter( 'wp_inline_script_attributes', [ $this, 'add_nonce_to_script' ] );
        add_filter( 'wp_script_attributes', [ $this, 'add_nonce_to_script' ] );
    }

    /**
     * Get the CSP nonce for the current request.
     */
    public static function get_csp_nonce(): string {
        return self::$csp_nonce;
    }

    /**
     * Add nonce attribute to inline script tags.
     */
    public function add_nonce_to_script( array $attributes ): array {
        $attributes['nonce'] = self::$csp_nonce;
        return $attributes;
    }

    /**
     * Send security headers early via send_headers action.
     */
    public function send_security_headers(): void {
        if ( is_admin() ) {
            return;
        }

        $nonce = self::$csp_nonce;

        // HSTS — enforce HTTPS for 1 year, include subdomains.
        header( 'Strict-Transport-Security: max-age=31536000; includeSubDomains; preload' );

        // Content Security Policy — nonce-based for scripts, allow inline styles
        // for WordPress/GeneratePress compatibility.
        $csp_directives = [
            "default-src 'self'",
            "script-src 'self' 'nonce-{$nonce}' https://www.googletagmanager.com https://www.google-analytics.com https://api.whatsapp.com https://cdn.jsdelivr.net",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            "font-src 'self' https://fonts.gstatic.com data:",
            "img-src 'self' data: https: http:",
            "connect-src 'self' https://www.google-analytics.com https://api.whatsapp.com",
            "frame-src 'self' https://www.youtube.com https://www.youtube-nocookie.com",
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "form-action 'self'",
        ];
        header( 'Content-Security-Policy: ' . implode( '; ', $csp_directives ) );

        // Prevent clickjacking.
        header( 'X-Frame-Options: SAMEORIGIN' );

        // Referrer — send origin only for cross-origin requests.
        header( 'Referrer-Policy: strict-origin-when-cross-origin' );

        // Permissions Policy — disable unnecessary browser features.
        $permissions = [
            'camera=()',
            'microphone=()',
            'geolocation=()',
            'payment=()',
            'usb=()',
            'magnetometer=()',
            'gyroscope=()',
            'accelerometer=()',
        ];
        header( 'Permissions-Policy: ' . implode( ', ', $permissions ) );

        // Prevent MIME-type sniffing.
        header( 'X-Content-Type-Options: nosniff' );

        // XSS protection (legacy browsers).
        header( 'X-XSS-Protection: 1; mode=block' );
    }

    /**
     * Also add headers via wp_headers filter as a fallback.
     */
    public function add_wp_headers( array $headers ): array {
        if ( is_admin() ) {
            return $headers;
        }

        $headers['X-Content-Type-Options'] = 'nosniff';
        $headers['X-Frame-Options']        = 'SAMEORIGIN';
        $headers['Referrer-Policy']        = 'strict-origin-when-cross-origin';

        return $headers;
    }
}

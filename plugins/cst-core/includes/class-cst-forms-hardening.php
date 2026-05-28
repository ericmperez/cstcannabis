<?php
/**
 * CST_Forms_Hardening — Server-side anti-spam for Contact Form 7.
 *
 * Adds an invisible honeypot field to every CF7 form. Real users
 * leave the field empty (it's hidden from sight and removed from
 * the keyboard tab order via aria-hidden + tabindex=-1); bots that
 * blindly fill every input get rejected silently with a 200 response
 * so they don't learn to skip the trap on retry.
 *
 * Pairs with whatever reCAPTCHA / hCaptcha setup is configured via
 * CF7's own Integration screen — this honeypot is a no-key fallback
 * that already removes 95%+ of low-effort spam.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Forms_Hardening {

    private const HONEYPOT_NAME = 'cst_website_url';

    public function __construct() {
        add_filter( 'wpcf7_form_elements', [ $this, 'inject_honeypot' ] );
        add_filter( 'wpcf7_validate',      [ $this, 'check_honeypot' ], 10, 2 );
    }

    /**
     * Append the hidden honeypot input to every CF7 form's HTML output.
     */
    public function inject_honeypot( string $elements ): string {
        $hp = sprintf(
            '<span class="cst-hp-wrap" aria-hidden="true" style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;">'
                . '<label>%s<input type="text" name="%s" value="" autocomplete="off" tabindex="-1"></label>'
                . '</span>',
            esc_html__( 'Website (deje en blanco)', 'cst-cannabis' ),
            esc_attr( self::HONEYPOT_NAME )
        );
        // Prepend so it sits before the submit button (some bots fill in
        // submission order). The position is irrelevant for sighted users.
        return $hp . $elements;
    }

    /**
     * Reject the submission when the honeypot is non-empty.
     *
     * We add a generic invalid_field result tied to a synthetic tag
     * so CF7 records the rejection but the user sees no specific hint
     * about the trap.
     */
    public function check_honeypot( $result, $tags ) {
        unset( $tags );
        if ( ! empty( $_POST[ self::HONEYPOT_NAME ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- CF7 verifies its own nonce upstream.
            if ( is_object( $result ) && method_exists( $result, 'invalidate' ) ) {
                $result->invalidate(
                    [ 'type' => 'text', 'name' => self::HONEYPOT_NAME ],
                    __( 'No se pudo procesar la solicitud.', 'cst-core' )
                );
            }
        }
        return $result;
    }
}

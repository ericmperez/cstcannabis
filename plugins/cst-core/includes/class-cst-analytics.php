<?php
/**
 * CST_Analytics — Google Analytics 4 integration.
 *
 * Outputs the gtag.js snippet on the frontend when a measurement ID is configured
 * and the integration is enabled. Skips logged-in administrators so admin browsing
 * does not pollute analytics. Tags the current Polylang language as a custom dimension
 * (`portal_language`) when available.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Analytics {

    public function __construct() {
        add_action( 'wp_head', [ $this, 'output_snippet' ], 1 );
    }

    /**
     * Returns the validated GA4 Measurement ID (G-XXXXXXXXXX) or empty string.
     */
    public static function get_measurement_id(): string {
        $id = (string) get_option( 'cst_ga_measurement_id', '' );
        $id = strtoupper( trim( $id ) );
        if ( '' === $id ) {
            return '';
        }
        // GA4 IDs are "G-" + 10 alphanumeric chars; allow 8–12 for forward compat.
        if ( ! preg_match( '/^G-[A-Z0-9]{6,12}$/', $id ) ) {
            return '';
        }
        return $id;
    }

    public static function is_enabled(): bool {
        return (bool) get_option( 'cst_ga_enabled', false );
    }

    /**
     * Output gtag.js on every public page.
     */
    public function output_snippet(): void {
        if ( ! self::is_enabled() ) {
            return;
        }

        $id = self::get_measurement_id();
        if ( '' === $id ) {
            return;
        }

        // Don't track admins on the frontend.
        if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
            return;
        }

        $lang = '';
        if ( function_exists( 'pll_current_language' ) ) {
            $lang = (string) pll_current_language();
        }

        $config = [ 'send_page_view' => true ];
        if ( '' !== $lang ) {
            $config['portal_language'] = $lang;
        }

        $config_json = wp_json_encode( $config );
        $id_attr     = esc_attr( $id );
        $id_js       = esc_js( $id );
        ?>
<!-- Google tag (gtag.js) — CST Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $id_attr; ?>"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '<?php echo $id_js; ?>', <?php echo $config_json; ?>);
</script>
        <?php
    }
}

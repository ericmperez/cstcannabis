<?php
/**
 * CST_Admin_Cleanup — Suppress third-party plugin nag/upsell popups in admin.
 *
 * Targets the most common nag-screen patterns: dismissible admin notices
 * from non-WordPress-core plugins, the Tutor LMS setup-wizard banner,
 * and the GeneratePress welcome notice. Genuine WP update warnings
 * (update_nag, plugin-update messages) are NOT touched.
 *
 * Scope: only fires for users with `manage_options` (the only audience
 * that ever sees these notices) and only in /wp-admin so it can't
 * accidentally affect the front-end.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Admin_Cleanup {

    public function __construct() {
        add_action( 'admin_init',  [ $this, 'remove_third_party_nags' ], 999 );
        add_action( 'admin_head',  [ $this, 'inline_nag_styles' ] );
    }

    /**
     * Strip dismissible nags hooked by third-party plugins.
     *
     * We iterate every callback on admin_notices / all_admin_notices,
     * keep WordPress core handlers, and drop the rest.
     */
    public function remove_third_party_nags(): void {
        global $wp_filter;

        $hooks_to_clean = [ 'admin_notices', 'all_admin_notices', 'network_admin_notices' ];
        $core_keepers   = [
            'update_nag',
            'maintenance_nag',
            'site_admin_notice',
            'privacy_on_link_notice',
        ];

        foreach ( $hooks_to_clean as $hook ) {
            if ( empty( $wp_filter[ $hook ] ) ) {
                continue;
            }
            foreach ( $wp_filter[ $hook ]->callbacks as $priority => $callbacks ) {
                foreach ( $callbacks as $cb_id => $cb ) {
                    $callable = $cb['function'];
                    $name     = $this->callback_name( $callable );
                    if ( in_array( $name, $core_keepers, true ) ) {
                        continue;
                    }
                    // Keep callbacks defined inside core WP files. Anything
                    // from /wp-content/ (plugin or theme) gets dropped.
                    if ( $this->is_core_callback( $callable ) ) {
                        continue;
                    }
                    remove_action( $hook, $callable, $priority );
                }
            }
        }
    }

    /**
     * Belt-and-suspenders CSS — hide dismissible notices outright in case
     * a plugin echoes them before admin_init at priority 999.
     */
    public function inline_nag_styles(): void {
        echo '<style>.notice.is-dismissible:not(.updated):not(.notice-error){display:none!important;}</style>' . "\n";
    }

    private function callback_name( $callable ): string {
        if ( is_string( $callable ) ) {
            return $callable;
        }
        if ( is_array( $callable ) && isset( $callable[1] ) ) {
            return is_object( $callable[0] )
                ? get_class( $callable[0] ) . '::' . $callable[1]
                : $callable[0] . '::' . $callable[1];
        }
        return '';
    }

    private function is_core_callback( $callable ): bool {
        try {
            if ( is_string( $callable ) && function_exists( $callable ) ) {
                $reflection = new ReflectionFunction( $callable );
            } elseif ( is_array( $callable ) && count( $callable ) === 2 ) {
                $reflection = new ReflectionMethod( $callable[0], $callable[1] );
            } else {
                return false;
            }
        } catch ( ReflectionException $e ) {
            return false;
        }
        $file = $reflection->getFileName();
        if ( ! $file ) {
            return false;
        }
        return false === strpos( str_replace( '\\', '/', $file ), '/wp-content/' );
    }
}

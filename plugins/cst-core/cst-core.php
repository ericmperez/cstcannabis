<?php
/**
 * Plugin Name: CST Core
 * Plugin URI:  https://cst.pr.gov
 * Description: Core functionality for CST educational portals — CPTs, security headers, accessibility, chatbot, WhatsApp, and statistics.
 * Version:     1.0.0
 * Author:      Comisión para la Seguridad en el Tránsito de Puerto Rico
 * Author URI:  https://cst.pr.gov
 * License:     GPL-2.0-or-later
 * Text Domain: cst-core
 * Domain Path: /languages
 * Requires at least: 6.4
 * Requires PHP: 8.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Plugin constants.
define( 'CST_CORE_VERSION', '1.0.0' );
define( 'CST_CORE_FILE', __FILE__ );
define( 'CST_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'CST_CORE_URL', plugin_dir_url( __FILE__ ) );
define( 'CST_CORE_BASENAME', plugin_basename( __FILE__ ) );

// Autoloader — includes/class-cst-*.php files.
spl_autoload_register( function ( $class ) {
    $prefix = 'CST_';
    if ( strpos( $class, $prefix ) !== 0 ) {
        return;
    }
    $file = 'class-' . strtolower( str_replace( '_', '-', $class ) ) . '.php';
    $path = CST_CORE_DIR . 'includes/' . $file;
    if ( file_exists( $path ) ) {
        require_once $path;
    }
} );

// Boot the plugin.
function cst_core_init() {
    CST_Core::get_instance();
}
add_action( 'plugins_loaded', 'cst_core_init' );

// Activation: flush rewrite rules so CPT slugs work.
register_activation_hook( __FILE__, function () {
    cst_core_init();
    flush_rewrite_rules();
} );

// Deactivation: clean up rewrite rules.
register_deactivation_hook( __FILE__, function () {
    flush_rewrite_rules();
} );

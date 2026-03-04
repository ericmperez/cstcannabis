<?php
/**
 * CST Cannabis Portal — Production wp-config.php Template
 *
 * INSTRUCTIONS:
 * 1. Copy this file to wp-config.php on the production server
 * 2. Fill in all values marked with TODO
 * 3. Generate fresh security keys at: https://api.wordpress.org/secret-key/1.1/salt/
 * 4. Set correct file permissions: chmod 440 wp-config.php
 */

// ==========================================================================
// Database Settings — TODO: Fill in production credentials
// ==========================================================================
define( 'DB_NAME',     'TODO_database_name' );
define( 'DB_USER',     'TODO_database_user' );
define( 'DB_PASSWORD', 'TODO_database_password' );
define( 'DB_HOST',     'localhost' );
define( 'DB_CHARSET',  'utf8mb4' );
define( 'DB_COLLATE',  '' );

$table_prefix = 'cst_';  // Non-default prefix for security.

// ==========================================================================
// Security Keys — TODO: Replace with fresh keys from
// https://api.wordpress.org/secret-key/1.1/salt/
// ==========================================================================
define( 'AUTH_KEY',         'TODO_generate_unique_key' );
define( 'SECURE_AUTH_KEY',  'TODO_generate_unique_key' );
define( 'LOGGED_IN_KEY',    'TODO_generate_unique_key' );
define( 'NONCE_KEY',        'TODO_generate_unique_key' );
define( 'AUTH_SALT',        'TODO_generate_unique_key' );
define( 'SECURE_AUTH_SALT', 'TODO_generate_unique_key' );
define( 'LOGGED_IN_SALT',   'TODO_generate_unique_key' );
define( 'NONCE_SALT',       'TODO_generate_unique_key' );

// ==========================================================================
// Site URL — TODO: Set your production domain
// ==========================================================================
define( 'WP_HOME',    'https://cannabis.cst.pr.gov' );
define( 'WP_SITEURL', 'https://cannabis.cst.pr.gov' );

// ==========================================================================
// Production Security Hardening
// ==========================================================================
define( 'WP_DEBUG',         false );
define( 'WP_DEBUG_LOG',     false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'SCRIPT_DEBUG',     false );

define( 'DISALLOW_FILE_EDIT',  true );    // No theme/plugin editing from admin.
define( 'DISALLOW_FILE_MODS',  true );    // No plugin/theme installs from admin.
define( 'FORCE_SSL_ADMIN',     true );    // Force HTTPS for admin and logins.

define( 'AUTOMATIC_UPDATER_DISABLED', true );  // Manual updates only.
define( 'WP_AUTO_UPDATE_CORE',       false );

// ==========================================================================
// Performance
// ==========================================================================
define( 'WP_POST_REVISIONS', 5 );              // Limit post revisions.
define( 'WP_MEMORY_LIMIT',   '256M' );         // PHP memory for WordPress.
define( 'EMPTY_TRASH_DAYS',  14 );              // Auto-delete trash after 14 days.
define( 'WP_CRON_LOCK_TIMEOUT', 120 );

// ==========================================================================
// Default Theme
// ==========================================================================
define( 'WP_DEFAULT_THEME', 'cst-cannabis-portal' );

// ==========================================================================
// WordPress Core — DO NOT EDIT BELOW THIS LINE
// ==========================================================================
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';

<?php
/**
 * Plugin Name: AuthSpace
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AUTHSPACE_ABSPATH', plugin_dir_path( __FILE__ ) );
define( 'AUTHSPACE_URL', plugin_dir_url( __FILE__ ) );
define( 'AUTHSPACE_VERSION', '1.0.0');

require_once plugin_dir_path( __FILE__ ) . '/includes/class-auth-space.php';

AuthSpace::instance();
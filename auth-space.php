<?php
/**
 * Plugin Name:       AuthSpace
 * Plugin URI:        https://github.com/mailmug/auth-space
 * Description:       User registration, login, and authentication toolkit for WordPress.
 * Version:           1.0.0
 * Requires at least: 6.5
 * Requires PHP:      7.4
 * Author:            WPDebugLogo
 * Author URI:        https://wpdebuglog.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       auth-space
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AUTHSPACE_ABSPATH', plugin_dir_path( __FILE__ ) );
define( 'AUTHSPACE_URL', plugin_dir_url( __FILE__ ) );
define( 'AUTHSPACE_VERSION', '1.0.0');

require_once plugin_dir_path( __FILE__ ) . '/includes/class-auth-space.php';

AuthSpace::instance();
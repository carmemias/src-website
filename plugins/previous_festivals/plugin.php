<?php
/**
 * Previous Festival Plugin
 *
 * @package     etzali\PreviousFestivals
 * @author      Code Your Future graduates
 * @copyright   2018 Code Your Future
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Previous Festival Plugin
 * Plugin URI:  https://github.com/CodeYourFuture/src-website/tree/master/plugins
 * Description: Saves previous festival design and content
 * Version:     1.0
 * Author:      Code Your Future graduates
 * Author URI:  https://codeyourfuture.io
 * Text Domain: previous-festivals
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace etzali\PreviousFestivals;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Access denied.' );
}

/**
 * Setup the plugin's constants.
 *
 * @since 1.0.0
 *
 * @return void
 */
function init_constants() {
	$plugin_url = plugin_dir_url( __FILE__ );
	if ( is_ssl() ) {
		$plugin_url = str_replace( 'http://', 'https://', $plugin_url );
	}

	//OPTIMIZE using constants like these is not recommended by WP Theme review team
	define( 'PREVIOUS_FESTIVAL_PLUGIN_URL', $plugin_url );
	define( 'PREVIOUS_FESTIVAL_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
}

/**
 * Initialize the plugin hooks
 *
 * @since 1.0.0
 *
 * @return void
 */
function init_hooks() {
	register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_rewrites' );
	register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
}

/**
 * Flush the rewrites.
 *
 * @since 1.0.0
 *
 * @return void
 */
function flush_rewrites() {
	init_autoloader();

	src\previous_festivals_add_meta_box();

	flush_rewrite_rules();
}

/**
 * Kick off the plugin by initializing the plugin files.
 *
 * @since 1.0.0
 *
 * @return void
 */
function init_autoloader() {
	require_once( 'src/support/autoloader.php' );

	Support\autoload_files( __DIR__ . '/src/' );
}

/**
 * Launch the plugin
 *
 * @since 1.0.0
 *
 * @return void
 */
function launch() {
	init_constants();
	init_hooks();
	init_autoloader();
}

launch();

<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.scottishrefugeecouncil.org.uk/
 * @since             1.0.0
 * @package           Src_Events_Simple
 *
 * @wordpress-plugin
 * Plugin Name:       SRC Events Simple
 * Plugin URI:        http://www.scottishrefugeecouncil.org.uk/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Yohannes Fekadu
 * Author URI:        http://www.scottishrefugeecouncil.org.uk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       src-events-simple
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

require plugin_dir_path( __FILE__ ) . 'includes/custom-post-type.php';
require plugin_dir_path( __FILE__ ) . 'includes/custom-shortcodes.php';
require plugin_dir_path( __FILE__ ) . 'includes/custom-meta-boxes.php';

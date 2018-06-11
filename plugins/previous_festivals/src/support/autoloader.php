<?php
/**
 * File autoloader functionality
 *
 * @package     etzali\PreviousFestivals\Support
 * @since       1.0.0
 * @author      Code Your Future Graduates
 * @link        https://codeyourfuture.io
 * @license     GNU General Public License 2.0+
 */
namespace etzali\PreviousFestivals\Support;

/**
 * Load all of the plugin's files.
 *
 * @since 1.0.0
 *
 * @param string $src_root_dir Root directory for the source files
 *
 * @return void
 */
function autoload_files( $src_root_dir ) {

	$filenames = array(
		'previous_festivals_meta_boxes',	
		'previous_festivals_frontend'
	);

	foreach( $filenames as $filename ) {
		include_once( $src_root_dir . $filename . '.php' );
	}
}

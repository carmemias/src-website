<?php
/**
 * meta boxes for Events Custom Post Type.
 *
 * @package     etzali\PreviousFestivals\src
 * @author      etzali
 * @copyright   2018 Code Your Future
 * @license     GPL-2.0+
 *
 */

namespace etzali\PreviousFestivals\src;

function previous_festivals_enqueue_logo_script() {
    /*
     * I recommend to add additional conditions just to not to load the scripts on each page
     * like:
     * if ( !in_array('post-new.php','post.php') ) return;
     */
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }

     //wp_enqueue_script( 'eventlogoscript' , EVENT_FUNCTIONALITY_URL .'/src/assets/js/upload_event_logo.js', array('jquery'), null, true );
     //wp_enqueue_style( 'eventmetastyles' , EVENT_FUNCTIONALITY_URL .'/src/assets/css/metaboxStyling.css');
}

//add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\previous_festivals_enqueue_logo_script' );

function previous_festivals_add_meta_box(){	
	add_meta_box( 'previous_festivals_meta', 'Previous Festivals', __NAMESPACE__.'\render_previous_festivals_meta', 'page', 'side', 'low', array() );
}
add_action ('add_meta_boxes', __NAMESPACE__ . '\previous_festivals_add_meta_box');

function render_previous_festivals_meta(){
    global $post;

	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="previous_festivals_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	require_once plugin_dir_path(__FILE__).'previous_festivals_meta_view.php';
}
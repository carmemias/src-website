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
        wp_enqueue_style( 'wp-color-picker');
        wp_enqueue_script( 'wp-color-picker');
        wp_enqueue_script( 'previousfestivalsscript' , PREVIOUS_FESTIVAL_PLUGIN_URL .'/src/assets/previousfestivalsscript.js', array('jquery'), null, true );
       // wp_enqueue_style( 'previousfestivalsstyles' , PREVIOUS_FESTIVAL_PLUGIN_URL .'/src/assets/previousfestivalsstyles.css');
}

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\previous_festivals_enqueue_logo_script' );

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

function save_previous_festivals_meta($post_id, $post){
	if ( !isset($_POST['previous_festivals_noncename']) ) { return; }

	// verify this came from the our screen and with proper authorization, because save_post can be triggered at other times
  if( !wp_verify_nonce( $_POST['previous_festivals_noncename'], plugin_basename(__FILE__) ) ){
          						return $post->ID;
                    }
	// is the user allowed to edit the post or page?
	if( !current_user_can( 'edit_post', $post->ID )){return $post->ID;}

	// ok, we're authenticated: we need to find and save the data. We'll put it into an array to make it easier to loop through
	$previous_festival_meta['_previous_festival_is_programme'] = absint($_POST['_previous_festival_is_programme']);
	$previous_festival_meta['_previous_festival_is_current'] = absint($_POST['_previous_festival_is_current']);
	$previous_festival_meta['_previous_festival_start_date'] = $_POST['_previous_festival_start_date'];
	$previous_festival_meta['_previous_festival_end_date'] = $_POST['_previous_festival_end_date'];
  $previous_festival_meta['_previous_festival_social_media_buttons_colour'] = sanitize_hex_color($_POST['_previous_festival_social_media_buttons_colour']);
  $previous_festival_meta['_previous_festival_text_colour'] = sanitize_hex_color($_POST['_previous_festival_text_colour']);
  $previous_festival_meta['_previous_festival_accent_colour'] = sanitize_hex_color($_POST['_previous_festival_accent_colour']);

	// Add values of $events_meta as custom fields
	foreach ($previous_festival_meta as $key => $value) { // Cycle through the $classes_meta array!
		if( $post->post_type == 'revision' ){return;} // Don't store custom data twice

		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)

		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
		     update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
		     add_post_meta($post->ID, $key, $value);
		}

		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}
}

add_action('save_post', __NAMESPACE__.'\save_previous_festivals_meta', 1, 2);

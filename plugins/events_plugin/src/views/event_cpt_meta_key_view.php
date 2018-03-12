<?php
namespace yohannes\EventsFunctionality\src\views;
/**
 * Custom meta boxes for this plugin.
 *
 * @package Events_Simple
 */


/**
 * Add meta box
 *
 * @param post $post The post object
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
 */
function event_add_meta_boxes( $post ){
	add_meta_box( 'event_meta_box', __( 'Events Details', 'Events_Simple' ), 'event_build_meta_box', 'event', 'normal', 'high' );
}
add_action( 'add_meta_boxes_event', 'event_add_meta_boxes' );


/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
 function event_build_meta_box( $post ){
	// make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'event_meta_box_nonce' );
	// retrieve the _event_key_event current value
	$current_key_event = get_post_meta( $post->ID, '_event_key_event', true );
	// retrieve the _event_venue_name current value
	$current_venue_name = get_post_meta( $post->ID, '_event_venue_name', true );
	?>
	<div class='inside'>

		<h3><?php _e( 'Key Event?', 'event_example_plugin' ); ?></h3>
		<p>
			<input type="radio" name="key_event" value="0" <?php checked( $current_key_event, '0' ); ?> /> Yes<br />
			<input type="radio" name="key_event" value="1" <?php checked( $current_key_event, '1' ); ?> /> No
		</p>

		<h3><?php _e( 'Venue Name', 'event_example_plugin' ); ?></h3>
		<p>
			<input type="text" name="venue_name" value="<?php echo $current_venue_name; ?>" /> 
		</p>

	</div>
	<?php
}

/**
 * Store custom field meta box data
 *
 * @param int $post_id The post ID.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/save_post
 */


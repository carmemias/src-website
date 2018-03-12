<?php
/**
 * Custom meta boxes for this plugin.
 *
 * @package Src_Events_Simple
 */


/**
 * Add meta box
 *
 * @param post $post The post object
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
 */
function src_event_add_meta_boxes( $post ){
	add_meta_box( 'src_event_meta_box', __( 'Events Details', 'Src_Events_Simple' ), 'src_event_build_meta_box', 'src_event', 'normal', 'high' );
}
add_action( 'add_meta_boxes_src_event', 'src_event_add_meta_boxes' );


/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
function src_event_build_meta_box( $post ){
	// make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'src_event_meta_box_nonce' );
	// retrieve the _src_event_key_event current value
	$current_key_event = get_post_meta( $post->ID, '_src_event_key_event', true );
	// retrieve the _src_event_venue_name current value
	$current_venue_name = get_post_meta( $post->ID, '_src_event_venue_name', true );
	?>
	<div class='inside'>

		<h3><?php _e( 'Key Event?', 'src_event_example_plugin' ); ?></h3>
		<p>
			<input type="radio" name="key_event" value="0" <?php checked( $current_key_event, '0' ); ?> /> Yes<br />
			<input type="radio" name="key_event" value="1" <?php checked( $current_key_event, '1' ); ?> /> No
		</p>

		<h3><?php _e( 'Venue Name', 'src_event_example_plugin' ); ?></h3>
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
function src_event_save_meta_box_data( $post_id ){
	// verify meta box nonce
	if ( !isset( $_POST['src_event_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['src_event_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	}
	// return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
  // Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}
	// store custom fields values
	// key_event string
	if ( isset( $_REQUEST['key_event'] ) ) {
		update_post_meta( $post_id, '_src_event_key_event', sanitize_text_field( $_POST['key_event'] ) );
	}
	// store custom fields values
	// venue_name string
	if ( isset( $_REQUEST['venue_name'] ) ) {
		update_post_meta( $post_id, '_src_event_venue_name', sanitize_text_field( $_POST['venue_name'] ) );
	}
}
add_action( 'save_post_src_event', 'src_event_save_meta_box_data' );

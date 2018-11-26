<?php
/**
 * Metaboxes for Events Custom Post Type.
 *
 * @package     yohannes\EventsFunctionality\src
 * @author      yohannes
 * @copyright   2018 Code Your Future
 * @license     GPL-2.0+
 */

namespace yohannes\EventsFunctionality\src;

/**
 * Enqueue js scripts related to the event logos.
 */
function event_cpt_enqueue_logo_script() {
	/*
	 * I recommend to add additional conditions to avoid loading the scripts on each page like:
	 * if ( !in_array('post-new.php','post.php') ) return;
	 */
	if ( ! did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}

		wp_enqueue_script( 'eventlogoscript', EVENT_FUNCTIONALITY_URL . '/src/assets/js/upload_event_logo.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_style( 'eventmetastyles', EVENT_FUNCTIONALITY_URL . '/src/assets/css/metaboxStyling.css', array(), '1.0' );
}

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\event_cpt_enqueue_logo_script' );

/**
 * Event_cpt metaboxes
 */
function events_cpt_add_meta_box() {
	add_meta_box( 'event_cpt_location_meta', 'Event Location', __NAMESPACE__ . '\render_event_cpt_location_meta', 'event_cpt', 'normal', 'default' );
	add_meta_box( 'event_cpt_organizer_meta', 'Event Organizer', __NAMESPACE__ . '\render_event_cpt_organizer_meta', 'event_cpt', 'normal', 'default' );
	add_meta_box( 'event_cpt_key_event_meta', 'Key Event', __NAMESPACE__ . '\render_event_cpt_key_event_meta', 'event_cpt', 'side', 'low' );
	add_meta_box( 'event_cpt_dateTime_event_meta', 'Event date and time', __NAMESPACE__ . '\render_event_cpt_dateTime_event_meta', 'event_cpt', 'side', 'default' );
	add_meta_box( 'event_cpt_price_event_meta', 'Event Price', __NAMESPACE__ . '\render_event_cpt_price_event_meta', 'event_cpt', 'side', 'default' );
}
/**
 * Render Event Location metabox
 */
function render_event_cpt_location_meta() {
	global $post;

	// Noncename needed to verify where the data originated.
	echo '<input type="hidden" name="event_cpt_location_noncename" value="' . esc_attr( wp_create_nonce( plugin_basename( __FILE__ ) ) ) . '" />';

	require_once plugin_dir_path( __FILE__ ) . 'views/event_cpt_location_meta_view.php';
}
/**
 * Render Event organiser metabox
 */
function render_event_cpt_organizer_meta() {
	global $post;

	// Noncename needed to verify where the data originated.
	echo '<input type="hidden" name="event_cpt_organizer_noncename" value="' . esc_attr( wp_create_nonce( plugin_basename( __FILE__ ) ) ) . '" />';

	require_once plugin_dir_path( __FILE__ ) . 'views/event_cpt_organizer_meta_view.php';
}

/**
 * Render is key event metabox
 */
function render_event_cpt_key_event_meta() {
	global $post;

	// Noncename needed to verify where the data originated.
	echo '<input type="hidden" name="event_cpt_key_event_noncename" value="' . esc_attr( wp_create_nonce( plugin_basename( __FILE__ ) ) ) . '" />';

	require_once plugin_dir_path( __FILE__ ) . 'views/event_cpt_key_event_meta_view.php';
}

/**
 * Render Event price metabox
 */
function render_event_cpt_price_event_meta() {
	global $post;

	// Noncename needed to verify where the data originated.
	echo '<input type="hidden" name="event_cpt_price_event_noncename" value="' . esc_attr( wp_create_nonce( plugin_basename( __FILE__ ) ) ) . '" />';

	require_once plugin_dir_path( __FILE__ ) . 'views/event_cpt_price_meta_view.php';
}

/**
 * Render Event date, starting time and end time metaboxes.
 */
function render_event_cpt_dateTime_event_meta() {
	global $post;

	// Noncename needed to verify where the data originated.
	echo '<input type="hidden" name="event_cpt_time_event_noncename" value="' . esc_attr( wp_create_nonce( plugin_basename( __FILE__ ) ) ) . '" />';

	require_once plugin_dir_path( __FILE__ ) . 'views/event_cpt_time_meta_view.php';
}

/**
 * Save Event Metabox data to database.
 *
 * @param  integer $post_id Post ID.
 * @param  object  $post    Post object.
 */
function save_event_cpt_meta( $post_id, $post ) {
	if ( ! isset(
		$_POST['event_cpt_location_noncename'],
		$_POST['event_cpt_organizer_noncename'],
		$_POST['event_cpt_key_event_noncename'],
		$_POST['event_cpt_price_event_noncename'],
		$_POST['event_cpt_time_event_noncename']
	) ) {
		return; }
	// verify this came from the our screen and with proper authorization, because save_post can be triggered at other times.
	if ( ! wp_verify_nonce(
		filter_input( INPUT_POST, 'event_cpt_location_noncename', FILTER_SANITIZE_STRING ),
		plugin_basename( __FILE__ )
	) || ! wp_verify_nonce(
		filter_input( INPUT_POST, 'event_cpt_organizer_noncename', FILTER_SANITIZE_STRING ),
		plugin_basename( __FILE__ )
	) || ! wp_verify_nonce(
		filter_input( INPUT_POST, 'event_cpt_key_event_noncename', FILTER_SANITIZE_STRING ),
		plugin_basename( __FILE__ )
	) || ! wp_verify_nonce(
		filter_input( INPUT_POST, 'event_cpt_price_event_noncename', FILTER_SANITIZE_STRING ),
		plugin_basename( __FILE__ )
	) || ! wp_verify_nonce(
		filter_input( INPUT_POST, 'event_cpt_time_event_noncename', FILTER_SANITIZE_STRING ),
		plugin_basename( __FILE__ )
	) ) {
						return $post->ID;}

	// is the user allowed to edit the post or page?
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
						return $post->ID;}

	// ok, we're authenticated: we need to find and save the data. We'll put it into an array to make it easier to loop through.
	$event_meta['_event_cpt_area']             = sanitize_text_field( wp_unslash( $_POST['_event_cpt_area'] ) );
	$event_meta['_event_cpt_venue']            = sanitize_text_field( wp_unslash( $_POST['_event_cpt_venue'] ) );
	$event_meta['_event_cpt_address_line_1']   = sanitize_text_field( wp_unslash( $_POST['_event_cpt_address_line_1'] ) );
	$event_meta['_event_cpt_address_line_2']   = sanitize_text_field( wp_unslash( $_POST['_event_cpt_address_line_2'] ) );
	$event_meta['_event_cpt_address_postcode'] = sanitize_text_field( wp_unslash( $_POST['_event_cpt_address_postcode'] ) );

	$event_meta['_event_cpt_price_event']     = floatval( wp_unslash( $_POST['_event_cpt_price_event'] ) );
	$event_meta['_event_cpt_key_event']       = intval( wp_unslash( $_POST['_event_cpt_key_event'] ) );
	$event_meta['_event_cpt_startTime_event'] = wp_unslash( $_POST['_event_cpt_startTime_event'] );
	$event_meta['_event_cpt_endTime_event']   = wp_unslash( $_POST['_event_cpt_endTime_event'] );
	$event_meta['_event_cpt_date_event']      = wp_unslash( $_POST['_event_cpt_date_event'] );

	$event_meta['_event_cpt_logo1_event'] = wp_unslash( $_POST['_event_cpt_logo1_event'] );
	$event_meta['_event_cpt_logo2_event'] = wp_unslash( $_POST['_event_cpt_logo2_event'] );
	$event_meta['_event_cpt_logo3_event'] = wp_unslash( $_POST['_event_cpt_logo3_event'] );
	$event_meta['_event_cpt_logo4_event'] = wp_unslash( $_POST['_event_cpt_logo4_event'] );

	$event_meta['_event_cpt_main_organizer']      = sanitize_text_field( wp_unslash( $_POST['_event_cpt_main_organizer'] ) );
	$event_meta['_event_cpt_other_organizer_1']   = sanitize_text_field( wp_unslash( $_POST['_event_cpt_other_organizer_1'] ) );
	$event_meta['_event_cpt_other_organizer_2']   = sanitize_text_field( wp_unslash( $_POST['_event_cpt_other_organizer_2'] ) );
	$event_meta['_event_cpt_other_organizer_3']   = sanitize_text_field( wp_unslash( $_POST['_event_cpt_other_organizer_3'] ) );
	$event_meta['_event_cpt_organizer_website']   = sanitize_text_field( wp_unslash( $_POST['_event_cpt_organizer_website'] ) );
	$event_meta['_event_cpt_organizer_facebook']  = esc_url_raw( wp_unslash( $_POST['_event_cpt_organizer_facebook'] ) );
	$event_meta['_event_cpt_organizer_twitter']   = esc_url_raw( wp_unslash( $_POST['_event_cpt_organizer_twitter'] ) );
	$event_meta['_event_cpt_organizer_instagram'] = esc_url_raw( wp_unslash( $_POST['_event_cpt_organizer_instagram'] ) );

	// Add values of $events_meta as custom fields.
	foreach ( $event_meta as $key => $value ) { // Cycle through the $classes_meta array!
		if ( 'revision' === $post->post_type ) {
			return; // Don't store custom data twice.
		}

		$value = implode( ',', (array) $value ); // If $value is an array, make it a CSV (unlikely).

		if ( get_post_meta( $post->ID, $key, false ) ) { // If the custom field already has a value.
			update_post_meta( $post->ID, $key, $value );
		} else { // If the custom field doesn't have a value.
			add_post_meta( $post->ID, $key, $value );
		}

		if ( ! $value ) {
			delete_post_meta( $post->ID, $key ); // Delete if blank.
		}
	}
}

add_action( 'save_post', __NAMESPACE__ . '\save_event_cpt_meta', 1, 2 );

// TODO The code below can be removed as we are not using REST.
/**
 * Add metaboxes to cpt’s REST endpoints
 */
function events_cpt_add_metaboxes_to_rest() {
	register_rest_field(
		'event_cpt',
		'extra_meta',
		array(
			'get_callback' => __NAMESPACE__ . '\get_events_cpt_meta',
			'schema'       => null,
		)
	);
}

/**
 * Get the events metabox data.
 *
 * @param  object $object Event.
 * @return object         Event meta.
 */
function get_events_cpt_meta( $object ) {
	$post_id = $object['id'];
	return get_post_meta( $post_id );
}

add_action( 'rest_api_init', __NAMESPACE__ . '\events_cpt_add_metaboxes_to_rest' );

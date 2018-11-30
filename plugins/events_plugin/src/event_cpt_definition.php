<?php
/**
 * Events Custom Post Type.
 *
 * @package     yohannes\EventsFunctionality\src
 * @author      yohannes
 * @copyright   2018 Code Yor Future
 * @license     GPL-2.0+
 *
 */

namespace yohannes\EventsFunctionality\src;

add_action( 'init', __NAMESPACE__ . '\event_cpt_functionality' );
/**
 * Register CPT `event_event`
 * See http://web-profile.net/wordpress/docs/custom-post-types/
 * See https://codex.wordpress.org/Function_Reference/register_post_type
 */
 function event_cpt_functionality() { //see https://codex.wordpress.org/Function_Reference/post_type_supports
	$features = get_all_post_type_features('post', array( #list of excluded features. See lines 59 and 88
		'trackbacks',
		'custom-fields',
		'revisions',
		'author',
		'post-formats',
		'comments',
		//'excerpt'
	));

	register_post_type( 'event_cpt', array(
		'labels'  => array(
			'name' => _x( 'Events', 'Events CPT general name' , 'events-functionality'),
			'singular_name' => _x( 'Event', 'Events CPT singular name' , 'events-functionality'),
			'all_items' => __('All Events', 'events-functionality'),
 		    'add_new_item' => __('Add New Event', 'events-functionality'),
 		    'edit_item' => __('Edit Event', 'events-functionality'),
 		    'new_item' => __('New Event', 'events-functionality'),
			'view_item' => __('View Event', 'events-functionality'),
			'featured_image' => __('Event image', 'events-functionality'),
			'set_featured_image' => __('Choose Event image', 'events-functionality'),
			'remove_featured_image' => __('Remove Event image', 'events-functionality'),
			'use_featured_image' => __('Use Event image', 'events-functionality'),
 		    'view_items' => __('View Events', 'events-functionality'),
 		    'search_items' => __('Search Event', 'events-functionality'),
 		    'not_found' => __( 'No Events found.', 'events-functionality' ),
			'not_found_in_trash' => __( 'No Events found in Trash.', 'events-functionality' ),
		),
		'show_in_rest'    => true,
		'rest_base'    => 'events',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'public' => true,
		'show_ui' => true,
		'has_archive' => true, #this means it'll have an "index/loop" page
		'rewrite' => array(
			'slug' => _x( 'events', 'CPT permalink slug', 'event_cpt'),
			'with_front' => false,
		),
		'menu_icon'   => 'dashicons-images-alt2',
		'menu_position' => 20,
		'supports' => $features, #see line 21
		'taxonomies' => array('event-type'),
		'register_meta_box_cb' => __NAMESPACE__.'\events_cpt_add_meta_box'
	));

	register_taxonomy('event-type', 'event_cpt', array(
		'hierarchical' => true,
		'show_in_nav_menus' => false,
		'show_in_rest' => true,
		'rest_base' => 'eventtypes',
		'rest_control_class' => 'WP_REST_Terms_Controller',
		'labels' => array(
			'name' => __('Event types'),
			'singular_name' => __('Event type'),
			'all_items' => __('All Event types'),
			'edit_item' => __('Edit Event type'),
			'view_item' => __('View Event type'),
			'update_item' => __('Update Event type'),
			'add_new_item' => __('Add new Event type'),
			'new_item_name' => __('New Event type'),
			'popular_items' => __('Most used Event types'),
			'separate_items_with_commas' => __('Separate Event types with commas'),
			'add_or_remove_items' => __('Add or remove Event types'),
			'choose_from_most_used' => __('Choose from most used Event types'),
		)
	) );
}

/**
* Get all the post type features for the given post type
* @param string $post_type - given post type
* @param array $exclude_features - array of features to exclude
* @return array
**/
function get_all_post_type_features($post_type = 'post', $excluded_features = array()){
	#see https://knowthecode.io/labs/custom-post-type-basics#configure-features
	$raw_features = get_all_post_type_supports($post_type);

	if(!$excluded_features){return array_keys($raw_features);}

	$included_features = array();
	foreach($raw_features as $key => $value){
		if(!in_array($key, $excluded_features)){
			$included_features[]=$key;
		}
	}
	return $included_features;
}

add_filter( 'post_updated_messages',  __NAMESPACE__ . '\event_cpt_updated_messages' );



/**
 * Events update messages.
 *
 * @param array $messages Existing post update messages.
 *
 * @return array Amended post update messages with new CPT update messages.
 */
function event_cpt_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	$messages['event_cpt'] = array(
		0  => '', // Unused. Messages start at index 1.
		1  => __( 'Events updated.', 'events-functionality' ),
		2  => __( 'Custom field updated.', 'events-functionality' ),
		3  => __( 'Custom field deleted.', 'events-functionality' ),
		4  => __( 'Events updated.', 'events-functionality' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Event restored to revision from %s', 'events-functionality' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Event published.', 'events-functionality' ),
		7  => __( 'Event saved.', 'events-functionality' ),
		8  => __( 'Event submitted.', 'events-functionality' ),
		9  => sprintf(
			// translators: Publish box date format, see http://php.net/date
			__( 'Event scheduled for: <strong>%1$s</strong>.', 'events-functionality' ),
			date_i18n( __( 'M j, Y @ G:i', 'events-functionality' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Event draft updated.', 'events-functionality' )
	);

	if ( $post_type_object->publicly_queryable && 'event_cpt' === $post_type ) {
		$permalink = get_permalink( $post->ID );

		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View Event', 'events-functionality' ) );
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;

		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview Event', 'events-functionality' ) );
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;
	}

	return $messages;
}


add_filter( 'bulk_post_updated_messages', __NAMESPACE__ . '\event_cpt_bulk_updated_messages', 10, 2 );
/**
 * Events bulk update messages.
 * See https://themeforest.net/forums/thread/custom-post-type-change-delete-message/114401
 * @param array $bulk_messages Existing post bulk update messages.
 * @param array $bulk_counts
 * @return array Amended post update messages with new CPT update messages.
 */
function event_cpt_bulk_updated_messages( $bulk_messages, $bulk_counts ) {

	$bulk_messages['event_cpt'] = array(
		//translators: event name
		'updated'   => _x( '%s Event updated.', '%s Events updated.', $bulk_counts['updated'] ),
		'locked'    => _x( '%s Event not updated, somebody is editing it.', '%s Events not updated, somebody is editing them.', $bulk_counts['locked'] ),
		'deleted'   => _x( '%s Event permanently deleted.', '%s Events permanently deleted.', $bulk_counts['deleted'] ),
		'trashed'   => _x( '%s Event moved to the Bin.', '%s Events moved to the Bin.', $bulk_counts['trashed'] ),
		'untrashed' => _x( '%s Event restored from the Bin.', '%s Events restored from the Bin.', $bulk_counts['untrashed'] ),
	);

	return $bulk_messages;

}

/***********************************/
/*    DISPLAY IN Events LIST TABLE   */
/***********************************/

// see http://shibashake.com/wordpress-theme/expand-the-wordpress-quick-edit-menu
 add_filter('manage_event_cpt_posts_columns', __NAMESPACE__ .'\event_cpt_add_custom_columns');
/*
* Add a new column for Event order in the Events List table.
*/
function event_cpt_add_custom_columns($columns) {
	//remove Date column from its default position
	$date = $columns['date'];
	unset($columns['date']);

    $columns['event_cpt_area'] = 'Area';
	$columns['event_cpt_type'] = 'Type';

    //Add the Date column again to the end of the table
	$columns['date'] = $date;

    return $columns;
}

add_action( 'manage_posts_custom_column' , __NAMESPACE__ .'\event_cpt_custom_columns', 10, 2 );
/*
* Display the metaboxes value in the Post List table
* See https://github.com/bamadesigner/manage-wordpress-posts-using-bulk-edit-and-quick-edit/blob/master/manage_wordpress_posts_using_bulk_edit_and_quick_edit.php line 169
*/
function event_cpt_custom_columns( $column, $post_id ) {
	switch ( $column ) {
		case 'event_cpt_area':
			echo '<div id="event_cpt_area-' . absint( $post_id ) . '">' . esc_html( get_post_meta( $post_id, '_event_cpt_area', true ) ) . '</div>';
			break;

		case 'event_cpt_type':
			$terms = get_the_terms( $post_id, 'event-type' );
			$terms_list = '';
			if($terms) {
				foreach ( $terms as $term ) {$terms_list = $terms_list.$term->name.'</br>';}
			} else {
				$terms_list = 'not yet set </br>';
			}
			echo '<div id="event_cpt_type-' . absint( $post_id ) . '">' . esc_html( $terms_list ) . '</div>';
			break;
	}
}


 add_filter( 'manage_edit-event_cpt_sortable_columns', __NAMESPACE__ .'\event_cpt_area_sortable_column' );
 add_filter( 'manage_edit-event_cpt_sortable_columns', __NAMESPACE__ .'\event_cpt_type_sortable_column' );

/*
* Make new Event Area column sortable
*/
function event_cpt_area_sortable_column( $columns ) {

	$columns['event_cpt_area'] = 'event_cpt_area';

    return $columns;
}

/*
* Make new Event Type column sortable
*/
function event_cpt_type_sortable_column( $columns ) {

	$columns['event_cpt_type'] = 'event_cpt_type';

    return $columns;
}

 add_action( 'pre_get_posts', __NAMESPACE__ .'\event_cpt_area_orderby_backend' );
 add_action( 'pre_get_posts', __NAMESPACE__ .'\event_cpt_type_orderby_backend' );
/*
* Priority sorting instructions for the backend only (front end is set in home.php)
*/
function event_cpt_area_orderby_backend( $query ) {
    if( ! is_admin() )
        return;

    $orderby = $query->get( 'orderby');

    if( 'event_cpt_area' == $orderby ) {
		$query->set('meta_key','_event_cpt_area');
        $query->set('orderby','meta_value_num');
    }
}

function event_cpt_type_orderby_backend( $query ) {
    if( ! is_admin() )
        return;

    $orderby = $query->get( 'orderby');

    if( 'event_cpt_type_event' == $orderby ) {
		$query->set('meta_key','_event_cpt_type');
        $query->set('orderby','meta_value');
    }
}

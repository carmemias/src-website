<?php
/**
 * Custom post types for this plugin.
 *
 * Register e.g. 'Event'
 *
 * @package Src_Events_Simple
 */

/**
 * Register Custom Post Type - Event
 */
function src_event_post_type() {

	$labels = array(
		'name'                => _x( 'Events', 'Post Type General Name', 'Src_Events_Simple' ),
		'singular_name'       => _x( 'Event', 'Post Type Singular Name', 'Src_Events_Simple' ),
		'menu_name'           => __( 'Events', 'Src_Events_Simple' ),
		'parent_item_colon'   => __( 'Parent Event:', 'Src_Events_Simple' ),
		'all_items'           => __( 'All Events', 'Src_Events_Simple' ),
		'view_item'           => __( 'View Event', 'Src_Events_Simple' ),
		'add_new_item'        => __( 'Add New Event', 'Src_Events_Simple' ),
		'add_new'             => __( 'New Event', 'Src_Events_Simple' ),
		'edit_item'           => __( 'Edit Event', 'Src_Events_Simple' ),
		'update_item'         => __( 'Update Event', 'Src_Events_Simple' ),
		'search_items'        => __( 'Search events', 'Src_Events_Simple' ),
		'not_found'           => __( 'No events found', 'Src_Events_Simple' ),
		'not_found_in_trash'  => __( 'No events found in Trash', 'Src_Events_Simple' ),
	);
	$args = array(
		'label'               => __( 'event', 'Src_Events_Simple' ),
		'description'         => __( 'New Events', 'Src_Events_Simple' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_event'       => 2,
		'menu_position'       => 25,
		'menu_icon'           => 'dashicons-calendar-alt',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'src_event', $args );
}
// Hook into the 'init' action
add_action( 'init', 'src_event_post_type', 0 );
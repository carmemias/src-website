<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Refugee_Scotland_Festival_Theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function src_project_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if (is_page() ) {
		$slug = get_post_field( 'post_name', get_post() );
		$classes[] = 'page-' . $slug;
	}

	if ( is_singular( 'event_cpt' ) ){
		$year = date('Y', strtotime( get_post_meta( get_post()->ID, '_event_cpt_date_event', true) ) );
		$classes[] = 'event-' . $year;
	}

	return $classes;
}
add_filter( 'body_class', 'src_project_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function src_project_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'src_project_pingback_header' );

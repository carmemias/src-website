<?php
/**
 * Shortcode functionality for the Events Custom Post Type.
 *
 * @package     yohannes\EventsFunctionality\src
 * @author      yohannes
 * @copyright   2018 Carme Mias Studio
 * @license     GPL-2.0+
 *
 */

namespace yohannes\EventsFunctionality\src;

//See https://wordpress.stackexchange.com/questions/165754/enqueue-scripts-styles-when-shortcode-is-present
/*
* Enqueue javascript and stylesheet files used by the shortcode view
*/
// function events_cpt_shortcode_enqueue_scripts(){
// 	wp_register_style('events_shortcode_style', Event_FUNCTIONALITY_URL . '/src/assets/css/events_shortcode_style.css');
// 	wp_register_script('events_shortcode_script', Event_FUNCTIONALITY_URL . '/src/assets/js/events_shortcode_script.js');
	
// 	//OPTIMIZE this currently loads the script and style on all pages. It could be improved by loading themonly if a shortcut is present
// 	wp_enqueue_style( 'events_shortcode_style' );
// 	wp_enqueue_script( 'events_shortcode_script' );
// }
// add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\events_cpt_shortcode_enqueue_scripts');	


//[events type="type-slug|type name"] type attrib value not case sensitive
function events_cpt_shortcode_handler( $atts ){
	$results_array = [];
	$event_cpt_types = [];
	$output_string = '';
	
	//the default value for type
	$a = shortcode_atts( array(
	        'type' => ''
	    ), $atts );
	
	//find type/s
	if( ('' != $a['type']) ){
		//finds the type object, returns an array with a single object
		// $event_cpt_types = get_terms( array( 'taxonomy' => 'event-type', 'hide_empty' => false ) );
		
		//the type attribute has been set
		//does this type exist?
		$type_ID = term_exists($a['type'],'event-type');
		if( is_array($type_ID) ){ $type_ID = array_shift($type_ID);}
		
		//if the type doesn't exist, return error message
		if( ( 0==$type_ID ) || ( null==$type_ID ) ) {
			
			//TODO make translatable
			return '<p>The selected event type does not exist.</p>';
			
		} 
		
		// $event_cpt_args = array ('post_type' => 'event_cpt',
 		// 				 	'post_status' => 'publish',
		// 					'event-type' => $a['type'],
		// 					 'order' => 'ASC',
		// 					//  'orderby' => 'meta_value',
		// 					 'posts_per_page' => -1);	
		$event_cpt_args = array (
			 'post_type' => 'event_cpt',
 						 	'post_status' => 'publish',
							 'order' => 'ASC',
							//  'orderby' => 'meta_value',
							 'posts_per_page' => -1,
							 'event-type'         => $type_ID,
						    //  'category_name'    => '',
							//  'orderby'          => 'date',
							//  'include'          => '',
							//  'exclude'          => '',
							//  'meta_key'         => '',
							//  'meta_value'       => '',
							//  'post_mime_type'   => '',
							//  'post_parent'      => '',
							//  'author'	   => '',
							//  'author_name'	   => '',
							//  'suppress_filters' => true 
						);
	} else {
		
		//no arguments have been set by the Editor, so all Events will be listed grouped by type and in the order specified.
		 //$event_cpt_types = get_terms( array( 'taxonomy' => 'event-type', 'hide_empty' => false ) );
		 
		 $event_cpt_args = array (
			 'post_type' => 'event_cpt',
 						 	'post_status' => 'publish',
							 'order' => 'ASC',
							//  'orderby' => 'meta_value',
							 'posts_per_page' => -1,
							//  'category'         => '',
							//  'category_name'    => '',
							//  'orderby'          => 'date',
							//  'include'          => '',
							//  'exclude'          => '',
							//  'meta_key'         => '',
							//  'meta_value'       => '',
							//  'post_mime_type'   => '',
							//  'post_parent'      => '',
							//  'author'	   => '',
							//  'author_name'	   => '',
							//  'suppress_filters' => true 
						);

		
	} 
	
	
	
	$events_cpt = get_posts( $event_cpt_args ); //returns an array
	
	//now we have the data, we can build the view
	
	foreach ( $events_cpt as $single_event ) {
		$event_id = $single_event->ID;
		$event_name = get_the_title($event_id);
		// $event_name = $single_event['type']->name;
		//$event_slug = $single_event['type']->slug;
		//$event_description = apply_filters( 'the_content', get_the_content() );
		
		$output_string .= '<h2 class="type-title">' . $event_name . '</h2>';
		//$output_string .= '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
		//$output_string .= $event_description;
		
	 } //foreach $results_array 
	 
	 return $output_string;
	 
	 wp_reset_postdata();
	 
  }

add_shortcode( 'events', __NAMESPACE__ . '\events_cpt_shortcode_handler');

?>
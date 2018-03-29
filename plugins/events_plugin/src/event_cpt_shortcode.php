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

/*
* Enqueue javascript and stylesheet files used by the shortcode view
*/
 function events_cpt_shortcode_enqueue_scripts(){
 }
// add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\events_cpt_shortcode_enqueue_scripts');


//[events type='type-slug' area='town name' date=''] type attrib value not case sensitive
function events_cpt_shortcode_handler( $atts ){
	$output_string = '';

	//the default values for type, area and date
	$a = shortcode_atts( array(
	        'type' => '',
					'area' => '',
					'date' => ''
	    ), $atts );

	//no arguments have been set by the Editor, so all Events will be listed. Ordered by _event_cpt_date_event (ASC), _event_cpt_startTime_event (ASC) and post_title (ASC)
	$event_cpt_args = array (
		 					 'post_type' => 'event_cpt',
		 					 'post_status' => 'publish',
		 					 'posts_per_page' => -1,
							 'tax_query' => array(),
		 					 'meta_query' => array (
		 						 'relation' => 'AND',
		 						 'event_date' => array(
		 							 'key' => '_event_cpt_date_event',
		 							 'compare' => 'EXISTS'
		 						  ),
		 					 	  'event_area' => array(
							 			'key' => '_event_cpt_area',
										'compare' => 'EXISTS'
							    ),
		 						  'event_start_time' => array(
		 							 'key' => '_event_cpt_startTime_event',
		 							 'compare' => 'EXISTS'
		 						  )
		 					 ),
		 					 'orderby' => array(
		 						 'event_date' => 'ASC',
		 						 'event_start_time' => 'ASC',
		 						 'post_title' =>'ASC'
		 					 )
		 				 );

	//find type (custom taxonomy)
	if( ('' != $a['type']) ){
		$event_type = $a['type'];

		//the type attribute has been set. Does this type exist?
		$type_ID = term_exists($event_type,'event-type');
		if( is_array($type_ID) ){ $type_ID = array_shift($type_ID);}

		//if the type doesn't exist, return error message
		if( ( 0==$type_ID ) || ( null==$type_ID ) ) {

			return __('<p>The selected event type '.$event_type.' does not exist.</p>', 'events-functionality' );

		} else {
			//if it does, add it to query
			$event_cpt_args['tax_query'] = array(
				array(
					'taxonomy' => 'event-type',
					'field' => 'slug',
					'terms' => $event_type
				)
			);
		}

	}//by type

	//find area (venue town/city)
	if( ('' != $a['area']) ){

		//the area attribute has been set. Does this type exist?
		//IMPORTANT! NOTICE THAT THIS WILL NOT BE DONE IN THE SAME WAY AS FOR 'TYPE'.
		//THAT'S BECAUSE 'TYPE' IS A TAXONOMY (=TERM) AND THE AREA IS A METABOX.



		//if it does, add value of 'event_area' to query
		//It will look something like this:
		// $event_cpt_args['meta_query']['event_area']['value'] = (string) whatever event_area has been specified in the shortcode);


		//if it doesn't return message 'There are no events for this location'


	} //by area

	//find date (event date)
	if( ('' != $a['date']) ){

		//the date attribute has been set. Does this type exist?
		//IMPORTANT! NOTICE THAT THIS WILL NOT BE DONE IN THE SAME WAY AS FOR 'TYPE'.
		//THAT'S BECAUSE 'TYPE' IS A TAXONOMY (=TERM) AND THE DATE IS A METABOX.


		//if it does, add value of 'event_date' to query
		//the 'event_date' is already set in the default, so we only need to add the value
		//It will look something like this:
		// $event_cpt_args['meta_query']['event_date']['value'] = (string) whatever event_area has been specified in the shortcode);

		//if it doesn't return message 'There are no events for this date'


	} //by date

	$events_cpt = get_posts( $event_cpt_args ); //returns an array

	//now we have the data, we can build the view

	foreach ( $events_cpt as $single_event ) {
		$event_name = $single_event->post_title;
		$event_date = $single_event->_event_cpt_date_event;
		$event_start_time = $single_event->_event_cpt_startTime_event;
		$event_area = $single_event->_event_cpt_area;
		//$event_description = apply_filters( 'the_content', get_the_content() );

		$output_string .= '<h2 class="type-title">' . $event_name . '</h2>';
		$output_string .= '<p>Date: '.$event_date.' | Start Time: '.$event_start_time.' | Area: '.$event_area.'</p>';
		//$output_string .= $event_description;

	 } //foreach

	 return $output_string;

	 wp_reset_postdata();

  }

add_shortcode( 'events', __NAMESPACE__ . '\events_cpt_shortcode_handler');

?>

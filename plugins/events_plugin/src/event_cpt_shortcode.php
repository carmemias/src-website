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
	 wp_enqueue_script( 'shortcodescript' , EVENT_FUNCTIONALITY_URL .'/src/assets/js/events_shortcode_script.js', array('wp-api'), null, true );

 }
 add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\events_cpt_shortcode_enqueue_scripts');


//[events type='type-slug' area='town name' date=''] type attrib value not case sensitive
function events_cpt_shortcode_handler( $atts ){
	$output_string = '';
	//the default values for type, area, date and year
	$a = shortcode_atts( array(
	        'type' => '',
					'area' => '',
					'date' => '',
					'year' => ''
	    ), $atts );

	//no arguments have been set by the Editor, so all Events will be listed. Ordered by _event_cpt_date_event (ASC), _event_cpt_startTime_event (ASC) and post_title (ASC)
	$event_cpt_args = array (
		'post_type' => 'event_cpt',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'tax_query' => array(),
		'meta_query' => array(
			'relation' => 'AND',
			'event_date' => array(
				'key' => '_event_cpt_date_event',
				'compare' => 'BETWEEN'
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
		$event_area = $a['area'];
		$event_cpt_args['meta_query']['event_area']['value'] = $event_area;
	} //by area
	
	
	//find date (event date)
	if( ('' != $a['date']) ){
		$event_date = $a['date'];
		$event_cpt_args['meta_query']['event_date']['value'] = array($event_date, $event_date);
	} //by date
	
	//find year (event year)
	if( ('' != $a['year']) ){
		$event_year = $a['year'];
		$event_cpt_args['meta_query']['event_date']['value'] = array($event_year.'-01-01', $event_year.'-12-31');
	} //by year
	
	$events_cpt = get_posts( $event_cpt_args ); //returns an array
		if(count($events_cpt)==0){
			return __('<p>There are no events to display.</p>', 'events-functionality' );
		}
	//now we have the data, we can build the view

	foreach ( $events_cpt as $single_event ) {
		$event_name = $single_event->post_title;
		$event_date = $single_event->_event_cpt_date_event;
		$event_start_time = $single_event->_event_cpt_startTime_event;
		$event_area = $single_event->_event_cpt_area;
	    $event_description = apply_filters( 'the_content', get_the_content() );
		//finished time, full address, price, organizer social media and website, featured image 
		
		$output_string .= '<h2 class="type-title">' . $event_name . '</h2>';
		$output_string .= '<div class="event-discription">' . $event_description . '</div>';
		$output_string .= '<p>Date: '.$event_date.' | Start Time: '.$event_start_time.' | Area: '.$event_area.'</p>';
		//$output_string .= $event_description;

	} //foreach
	
	return $output_string;
	
	 wp_reset_postdata();

  }

add_shortcode( 'events', __NAMESPACE__ . '\events_cpt_shortcode_handler');

?>

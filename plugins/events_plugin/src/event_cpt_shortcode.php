<?php
/**
 * Shortcode functionality for the Events Custom Post Type.
 *
 * @package     yohannes\EventsFunctionality\src
 * @author      yohannes
 * @copyright   2018 Code Your Future
 * @license     GPL-2.0+
 *
 */

namespace yohannes\EventsFunctionality\src;

/*
* Enqueue javascript and stylesheet files used by the shortcode view
*/
 function events_cpt_shortcode_enqueue_scripts(){
   global $post;
   if( is_a( $post, 'WP_Post' ) && has_shortcode($post->post_content, 'events')){
    //  wp_enqueue_script( 'shortcodescript' , EVENT_FUNCTIONALITY_URL .'/src/assets/js/events_shortcode_script.js', array('wp-api'), null, true );
   wp_enqueue_style( 'shortcodestyle' , EVENT_FUNCTIONALITY_URL .'src/assets/css/events_shortcode_style.css');
   }
 }
 add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\events_cpt_shortcode_enqueue_scripts');

/*
* Register the query variables for the filter
*/
function events_cpt_shortcode_query_variables($vars){
  $vars[] = 'select-type';
  $vars[] = 'select-area';
  $vars[] = 'select-date';
  return $vars;
}
add_filter( 'query_vars', __NAMESPACE__ . '\events_cpt_shortcode_query_variables');

//[events type='type-slug' area='town name' date='YYYY-MM-DD' year='YYYY'] type attrib value not case sensitive
function events_cpt_shortcode_handler( $atts ){
  /***********************************************/
  /** Read the shortcode to get the initial view */
  /***********************************************/
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

	//find type (from shortcode)
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

	}//by type from shortcode

	//find area (from shortcode)
	if( ('' != $a['area']) ){
		$event_area = $a['area'];
		$event_cpt_args['meta_query']['event_area']['value'] = $event_area;
	} //by area from shortcode

  //find year (event year)
  if( ('' != $a['year']) ){
    $event_year = $a['year'];
    $event_cpt_args['meta_query']['event_date']['value'] = array($event_year.'-01-01', $event_year.'-12-31');
  } //by year

	//find date (event date)
	if( ('' != $a['date']) ){
		$event_date = $a['date'];
		$event_cpt_args['meta_query']['event_date']['value'] = array($event_date, $event_date);
	}//by date

  /****************************************/
  /* first query used to generate filters */
  /****************************************/
  //all types dropdown
  $all_types = get_terms( array('taxonomy' => 'event-type' ) );
  $types_filter_dropdown = render_types_filter($all_types);

  $initial_events_cpt = get_posts( $event_cpt_args ); //returns an array

  //get data needed to build the areas and dates dropdowns
  $filter = get_filter_data($initial_events_cpt);

  //all areas dropdown
  $all_areas = $filter['areas'];
  $areas_filter_dropdown = render_areas_filter($all_areas);

  //all dates dropdown
  $all_dates = $filter['dates'];
  $dates_filter_dropdown = render_dates_filter($all_dates);

  //build filters
  $output_string .= '<form class="filters">';
  $output_string .= $types_filter_dropdown;
  $output_string .= $areas_filter_dropdown;
  $output_string .= $dates_filter_dropdown;
  $output_string .= '<button id="submitFilterButton">Find Event</button>';

  $output_string .= '</form>';

  /************************/
  /* filter functionality */
  /************************/
  //get filter selection
  $filter_selection = get_filter_selection();
  $selected_type = '';
  $selected_area = '';
  $selected_date = '';
  if(!empty($filter_selection)){
    $selected_type = $filter_selection['type'];
    $selected_area = $filter_selection['area'];
    $selected_date = $filter_selection['date'];
  }

  //find type (from filter)
  if( '' != $selected_type ){
    $event_cpt_args['tax_query'] = array(
      array(
        'taxonomy' => 'event-type',
        'field' => 'slug',
        'terms' => $selected_type
      )
    );
  }//by type (from filter)

  //find area (from filter)
  if( '' != $selected_area ){
    $event_cpt_args['meta_query']['event_area']['value'] = $selected_area;
  }//by area (from filter)

  //find date (from filter)
  if( '' != $selected_date ){
    $event_cpt_args['meta_query']['event_date']['value'] = array($selected_date, $selected_date);
  }//by date (from filter)

  if($selected_area || $selected_date || $selected_type){
    $output_string .= '<div class="your-selection">Your selection: </br>';
    if($selected_type){
      $output_string .= $selected_type.'</br>';
    }
    if($selected_area){
      $output_string .= ucfirst($selected_area).'</br>';
    }
    if($selected_date){
      $output_string .= date('l j F', strtotime($selected_date)).'</br>';
    }
    $output_string .= '</div>';
  }

  /*********************************/
  /* the events list gets rendered */
  /*********************************/
  //render the programme page
  $events_cpt = get_posts( $event_cpt_args ); //returns an array

  $result = render_programme_page($events_cpt);


  $output_string .= '<div id="programme">';
  if(0 == count($events_cpt)){
      $output_string .= '<p>There are no events to display.</p>';
  } else {
      $output_string .= $result['view'];
  }
  $output_string .= '</div><!-- programme -->';

  return $output_string;

  }

add_shortcode( 'events', __NAMESPACE__ . '\events_cpt_shortcode_handler');

/*
* Pass the filter query variables to the shortcode
*/
function get_filter_selection(){
  global $query;

  $selection = array();

  // get area meta_query
  if( !empty( get_query_var( 'select-area' ) ) ){
    $selection['area'] = str_replace('-', ' ', get_query_var( 'select-area' ));
  }

  // get date meta_query
  if( !empty( get_query_var( 'select-date' ) ) ){
    $selection['date'] = get_query_var( 'select-date' );
  }

  //get type tax_query
  if( !empty( get_query_var( 'select-type' ) ) ){
    $selection['type'] = get_query_var( 'select-type' );
  }

  return $selection;
}


function get_filter_data($initial_events_cpt){
  $result = array();
  $output_areas = array();
  $output_dates = array();

  foreach ( $initial_events_cpt as $single_event ) {
    setup_postdata($single_event);

    $event_date_raw = $single_event->_event_cpt_date_event;
    $event_date = date('l j F', strtotime($event_date_raw));

    if( !array_key_exists($event_date_raw, $output_dates) ){ $output_dates[$event_date_raw] = $event_date; }

    $event_area = ucfirst(sanitize_text_field($single_event->_event_cpt_area));
    $event_area_key = str_replace(' ', '-', strtolower($event_area));
    if( ( ''!=$event_area ) && ( !array_key_exists($event_area_key, $output_areas) ) ){ $output_areas[$event_area_key] = $event_area;}
  }

  $output = array('areas'=> $output_areas, 'dates' => $output_dates);

  wp_reset_postdata();

  return $output;

}

/*
* renders the event-area filter dropdown
*/
function render_areas_filter($all_areas){
  $output = '';
  $output .= '<select class="filterElement" name="select-area">';
  $output .= '<option value="">All Locations</option>';
  foreach($all_areas as $key => $value){
    $output .= '<option value="'.$key.'">'.$value.'</option>';
  }
  $output .= '</select>';

  return $output;
}

/*
* renders the event-area filter dropdown
*/
function render_dates_filter($all_dates){
  $output = '';
  $output .= '<select class="filterElement" name="select-date">';
  $output .= '<option value="">All Dates</option>';
  foreach($all_dates as $key => $value){
    $output .= '<option value="'.$key.'">'.$value.'</option>';
  }
  $output .= '</select>';

  return $output;
}

/*
* renders the event-type filter dropdown
*/
function render_types_filter($all_types){
  $output = '';
  $output .= '<select class="filterElement" name="select-type">';
  $output .= '<option value="">All Event Types</option>';
  foreach($all_types as $single_type){
    $output .= '<option value="'.$single_type->slug.'">'.$single_type->name.'</option>';
  }
  $output .= '</select>';

  return $output;
}

/*
* Renders the programme section, listing all events
*/
function render_programme_page($events_cpt){
  $output_view = '';

  //now we have the data, we can build the view
  foreach ( $events_cpt as $single_event ) {
    setup_postdata($single_event);
    //get the data
    $event_id = absint($single_event->ID);

    $event_image = get_the_post_thumbnail( $event_id, 'medium' );
    $event_organiser_links = get_event_organiser_links($single_event);

    $event_name = get_the_title($event_id);
    $event_organiser_main = sanitize_text_field($single_event->_event_cpt_main_organizer);

    $event_types_result = get_event_types($event_id);
    $event_types = $event_types_result['names'];
    $event_types_data_attr = $event_types_result['slugs'];

    $event_date = date('l j F', strtotime($single_event->_event_cpt_date_event));
    $event_start_time = $single_event->_event_cpt_startTime_event;
    $event_end_time = $single_event->_event_cpt_endTime_event;

    $event_location = get_event_short_location($single_event);

    $event_price = money_format('%i', floatval($single_event->_event_cpt_price_event));
    $event_post_url = get_permalink($event_id);

    //output the event
    $output_view .= '<section id="event-'.esc_attr($event_id).'" class="event-entry">';
    $output_view .= '<div class="left-column">';
    $output_view .= '<a href="'.esc_url_raw($event_post_url).'" alt="Read more about '.$event_name.'">'.$event_image.'</a>';
    $output_view .= '<div class="links">'.$event_organiser_links.'</div><!-- links -->';
    $output_view .= '</div><!-- left-column -->';

    $output_view .= '<div class="right-column">';
    $output_view .= ' <header class="event-header">';
    $output_view .= '  <h2 class="event-title"><a href="'.esc_url_raw($event_post_url).'" alt="Read more about '.$event_name.'">' . $event_name . '</a></h2>';
    $output_view .= '  <div class="event-by">by '.$event_organiser_main.'</div>';
    $output_view .= ' </header>';

    $output_view .= ' <div class="entry-meta">'.$event_types.'</div>';
    if(!$event_date){$output_view .= '<span style="color: #f00;">No date set yet</span>';}else{$output_view .= ' <p class="date">'.$event_date.' '.$event_start_time.' - '.$event_end_time.'</p>';}
    $output_view .= ' <p class="location">'.$event_location.'</p>';
    $output_view .= ' <p class="price">';
    if('0.00' == $event_price){$output_view .= __('Free', 'events-functionality');}elseif('-1.00' == $event_price){$output_view .= __('Entry by donation', 'events-functionality');}else{$output_view .= '£'.$event_price;};
    $output_view .= '</p>';
    $output_view .= '</div><!-- right-column -->';
    $output_view .= '</section>';
     } //foreach

  $output = array('view'=> $output_view);

  wp_reset_postdata();

  return $output;
}

/*
* Get string listing event types
*/
function get_event_types($id){
 $types = get_the_terms( $id, 'event-type' );
 $type_names_string = ''; //displayed on page
 $type_slugs_string = ''; //added to data-type <section> attribute
 $result = array();

 if ( $types && !is_wp_error( $types ) ) {
    $type_names_array = array();
    $type_slugs_array = array();

    foreach ( $types as $type ) {
      $type_names_array[] = sanitize_text_field($type->name);
      $type_slugs_array[] = sanitize_text_field($type->slug);
    }
    $type_names_string = join( " | ", $type_names_array );
    $result['names'] = $type_names_string;

    $type_slugs_string = join( " ", $type_slugs_array );
    $result['slugs'] = $type_slugs_string;
  }

  return $result;
}

function get_event_organiser_links($event){
  $string ='';

  $event_organiser_website = $event->_event_cpt_organizer_website;
  $event_organiser_facebook = $event->_event_cpt_organizer_facebook;
  $event_organiser_twitter = $event->_event_cpt_organizer_twitter;
  $event_organiser_instagram = $event->_event_cpt_organizer_instagram;

  if( '' != $event_organiser_website ){$string .= '<a href="'.esc_url_raw($event_organiser_website).'" target="_blank" rel="noopener"><span class="screen-reader-text">Website</span><svg class="icon icon-website" aria-hidden="true" role="img"><use href="#icon-website" xlink:href="#icon-website"></use></svg></a>';}
  if( '' != $event_organiser_facebook ){$string .= '<a href="'.esc_url_raw($event_organiser_facebook).'" target="_blank" rel="noopener"><span class="screen-reader-text">Facebook</span><svg class="icon icon-facebook" aria-hidden="true" role="img"><use href="#icon-facebook" xlink:href="#icon-facebook"></use></svg></a>';}
  if( '' != $event_organiser_twitter ){$string .= '<a href="'.esc_url_raw($event_organiser_twitter).'" target="_blank" rel="noopener"><span class="screen-reader-text">Twitter</span><svg class="icon icon-twitter" aria-hidden="true" role="img"><use href="#icon-twitter" xlink:href="#icon-twitter"></use></svg></a>';}
  if( '' != $event_organiser_instagram ){$string .= '<a href="'.esc_url_raw($event_organiser_instagram).'" target="_blank" rel="noopener"><span class="screen-reader-text">Instagram</span><svg class="icon icon-instagram" aria-hidden="true" role="img"><use href="#icon-instagram" xlink:href="#icon-instagram"></use></svg></a>';}

  return $string;
}

function get_event_short_location($event){
    $string ='';
    $event_venue = sanitize_text_field($event->_event_cpt_venue);
    $event_area = sanitize_text_field($event->_event_cpt_area);

    $string .= $event_venue.', '.$event_area;

    return $string;
}
?>

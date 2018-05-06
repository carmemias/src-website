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
   global $post;
   if( is_a( $post, 'WP_Post' ) && has_shortcode($post->post_content, 'events')){
	    wp_enqueue_script( 'shortcodescript' , EVENT_FUNCTIONALITY_URL .'/src/assets/js/events_shortcode_script.js', array('wp-api'), null, true );
	    wp_enqueue_style( 'shortcodestyle' , EVENT_FUNCTIONALITY_URL .'/src/assets/css/events_shortcode_style.css');
   }
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
	if( ('' != $a['date']) || ('undefined' !== $a['date']) ){
		$event_date = $a['date'];
		$event_cpt_args['meta_query']['event_date']['value'] = array($event_date, $event_date);
	}//by date

	//find year (event year)
	if( ('' != $a['year']) ){
		$event_year = $a['year'];
		$event_cpt_args['meta_query']['event_date']['value'] = array($event_year.'-01-01', $event_year.'-12-31');
	} //by year

	$events_cpt = get_posts( $event_cpt_args ); //returns an array
		if(count($events_cpt)==0){
			return __('<p>There are no events to display.</p>', 'events-functionality' );
		}

  $output_string .= '<div id="programme">';
	//now we have the data, we can build the view
    foreach ( $events_cpt as $single_event ) {
    setup_postdata($single_event);
    //get the data
    $event_id = $single_event->ID;

    $event_image = get_the_post_thumbnail( $event_id, 'medium' );
    $event_organiser_links = get_event_organiser_links($single_event);

    $event_name = get_the_title($event_id);
    $event_organiser_main = $single_event->_event_cpt_main_organizer;

    $event_types = get_event_types($event_id);
    $event_types_string = '';

    $event_date = date('l j F', strtotime($single_event->_event_cpt_date_event));
    $event_start_time = $single_event->_event_cpt_startTime_event;
    $event_end_time = $single_event->_event_cpt_endTime_event;

    $event_location = get_event_short_location($single_event);

    $event_price = money_format('%i', floatval($single_event->_event_cpt_price_event));
    $event_post_url = get_permalink($event_id);

    //output the event
    $output_string .= '<section id="event-'.esc_attr($event_id).'" class="event-entry">';
    $output_string .= '<div class="left-column">';
    $output_string .= '<a href="'.esc_url_raw($event_post_url).'" alt="Read more about '.$event_name.'">'.$event_image.'</a>';
    $output_string .= '<div class="links">'.$event_organiser_links.'</div><!-- links -->';
    $output_string .= '</div><!-- left-column -->';

    $output_string .= '<div class="right-column">';
    $output_string .= ' <header class="event-header">';
    $output_string .= '  <h2 class="event-title"><a href="'.esc_url_raw($event_post_url).'" alt="Read more about '.$event_name.'">' . $event_name . '</a></h2>';
    $output_string .= '  <div class="event-by">by '.$event_organiser_main.'</div>';
    $output_string .= ' </header>';

    $output_string .= ' <div class="entry-meta">'.$event_types.'</div>';
    if(!$event_date){$output_string .= '<span style="color: #f00;">No date set yet</span>';}else{$output_string .= ' <p class="date">'.$event_date.' from '.$event_start_time.' to '.$event_end_time.'</p>';}
    $output_string .= ' <p class="location">'.$event_location.'</p>';
    $output_string .= ' <p class="price">';
    if('0.00' == $event_price){$output_string .= 'Free';}elseif('-1.00' == $event_price){$output_string .= 'Entry by Donation';}else{$output_string .= '£'.$event_price;};
    $output_string .= '</p>';
    $output_string .= '</div><!-- right-column -->';
    $output_string .= '</section>';
     } //foreach

  $output_string .= '</div><!-- programme -->';
	return $output_string;

	 wp_reset_postdata();

  }

add_shortcode( 'events', __NAMESPACE__ . '\events_cpt_shortcode_handler');

/*
* remove [...] from the end of the excerpt
*/
function custom_excerpt_more( $more ) {
	return '';
}
add_filter( 'excerpt_more', __NAMESPACE__.'\custom_excerpt_more' );

/*
* Limit the excerpt to 20 words
*/
function custom_excerpt_length( $length ) {
	return 18;
}
add_filter( 'excerpt_length',  __NAMESPACE__.'\custom_excerpt_length', 999 );
/*
* Get string listing event types
*/
function get_event_types($id){
 $types = get_the_terms( $id, 'event-type' );
 $types_string = '';

 if ( $types && !is_wp_error( $types ) ) {
    $types_array = array();
    foreach ( $types as $type ) { $types_array[] = $type->name;}
    $types_string = join( " | ", $types_array );
  }

  return $types_string;
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
    $event_venue = $event->_event_cpt_venue;
    $event_area = $event->_event_cpt_area;

    $string .= $event_venue.', '.$event_area;

    return $string;
}

function get_event_full_location($event){
  $string ='';

  $event_venue = $event->_event_cpt_venue;
  $event_address_line_1 = $event->_event_cpt_address_line_1;
  $event_address_line_2 = $event->_event_cpt_address_line_2;
  $event_postcode = $event->_event_cpt_address_postcode;
  $event_area = $event->_event_cpt_area;

  $string .= ' <p class="location">'.$event_venue;
  if($event_address_line_1){$string .= ', '.$event_address_line_1;}
  if($event_address_line_2){$string .= ', '.$event_address_line_2;}
  $string .= ', '.$event_area.' '.$event_postcode.'</p>';

  return $string;
}
?>

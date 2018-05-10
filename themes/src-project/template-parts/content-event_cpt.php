<?php
/**
 * Template part for displaying event content in single-event_cpt.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Refugee_Scotland_Festival_Theme
 */
global $post;

$event_id = get_the_id();
$custom = get_post_custom($event_id);

if(array_key_exists( '_event_cpt_main_organizer', $custom )){$event_by = sanitize_text_field($custom['_event_cpt_main_organizer'][0]);}
$event_types = get_event_types($event_id);

if(array_key_exists( '_event_cpt_date_event', $custom )){$event_date = date('l j F', strtotime($custom['_event_cpt_date_event'][0]));}
if(array_key_exists( '_event_cpt_startTime_event', $custom )){$event_start_time = $custom['_event_cpt_startTime_event'][0];}
if(array_key_exists( '_event_cpt_endTime_event', $custom )){$event_end_time = $custom['_event_cpt_endTime_event'][0];}
$event_organisers = get_event_organisers($custom);
$event_organiser_links = get_event_organiser_links($custom);
$event_location = get_event_full_location($custom);

$event_price = get_price($custom);
if(array_key_exists( '_event_cpt_key_event', $custom )){$is_key_event = $custom['_event_cpt_key_event'][0];}else{$is_key_event = false;}

if($is_key_event){
  $organiser_logos = get_organiser_logos($custom);
}

/*
* Get event price
*/
function get_price($custom){
  if(array_key_exists( '_event_cpt_price_event', $custom )){
    $price = money_format('%i', floatval($custom['_event_cpt_price_event'][0]));

    if('0.00' == $price){
      $price = 'Free Event';
    } elseif('-1.00' == $price) {
      $price ='Entry by donation';
    } else { $price = '£'.$price;
    };

  } else {
    $price = 'Free event';
  }

  return $price;
}

/*
* Get organiser logos
*/
function get_organiser_logos($custom){
  $logo_ids_array = array();
  $result = '';

  // See if there's a media id already saved as post meta
  if(array_key_exists( '_event_cpt_logo1_event', $custom )){
    $logo1_id = absint($custom['_event_cpt_logo1_event'][0]);
    array_push($logo_ids_array,$logo1_id);
  }
  if(array_key_exists( '_event_cpt_logo2_event', $custom )){
    $logo2_id = absint($custom['_event_cpt_logo2_event'][0]);
    array_push($logo_ids_array,$logo2_id);
  }
  if(array_key_exists( '_event_cpt_logo3_event', $custom )){
    $logo3_id = absint($custom['_event_cpt_logo3_event'][0]);
    array_push($logo_ids_array,$logo3_id);
  }
  if(array_key_exists( '_event_cpt_logo4_event', $custom )){
    $logo4_id = absint($custom['_event_cpt_logo4_event'][0]);
    array_push($logo_ids_array,$logo4_id);
  }
  // Get the image src
  foreach($logo_ids_array as $logo_id){
    if(0 != $logo_id){
      $logo_img = wp_get_attachment_image( $logo_id );
      $result .= $logo_img;
    }
  }

   return $result;
}

/*
* Get string listing event types
*/
function get_event_types($id){
 $types = get_the_terms( $id, 'event-type' );
 $types_string = '';

 if ( $types && !is_wp_error( $types ) ) {
    $types_array = array();
    foreach ( $types as $type ) { $types_array[] = sanitize_text_field($type->name);}
    $types_string = join( " | ", $types_array );
  }

  return $types_string;
}

/*
* Get string listing all event organisers other than Main Organiser.
*/
function get_event_organisers($custom){
  $string ='';

  if(array_key_exists( '_event_cpt_main_organizer', $custom )) {
    $event_organiser_main = $custom['_event_cpt_main_organizer'][0];
    $string .= 'Organised by: '.$event_organiser_main.'.';
  }

  $other_organisers = array();

  if(array_key_exists( '_event_cpt_other_organizer_1', $custom )){
    $event_organiser_other_1 = sanitize_text_field($custom['_event_cpt_other_organizer_1'][0]);
    array_push($other_organisers,$event_organiser_other_1);
  }

  if(array_key_exists( '_event_cpt_other_organizer_2', $custom )){
    $event_organiser_other_2 = sanitize_text_field($custom['_event_cpt_other_organizer_2'][0]);
    array_push($other_organisers,$event_organiser_other_2);
  }

  if(array_key_exists( '_event_cpt_other_organizer_3', $custom )){
    $event_organiser_other_3 = sanitize_text_field($custom['_event_cpt_other_organizer_3'][0]);
    array_push($other_organisers,$event_organiser_other_3);
  }

  if(1 >= count($other_organisers)){
    $string .= ' In partnership with: '. $other_organisers[0];
  }

  if(2 === count($other_organisers)){
      $string .= ' and '.$event_organiser_other_2.'.';
  }

  if(3 === count($other_organisers)){
      $string .= ', '.$event_organiser_other_2.' and '.$event_organiser_other_3.'.';
  }

  return $string;
}

/*
* Get string listing website and social media links, with corresponding SVG icon.
*/
function get_event_organiser_links($custom){
  $string ='';

  if(array_key_exists( '_event_cpt_organizer_website', $custom )){
    $event_organiser_website = $custom['_event_cpt_organizer_website'][0];
    $string .= '<a href="'.esc_url_raw($event_organiser_website).'" target="_blank" rel="noopener"><span class="screen-reader-text">Website</span><svg class="icon icon-website" aria-hidden="true" role="img"><use href="#icon-website" xlink:href="#icon-website"></use></svg></a>';
  }
  if(array_key_exists( '_event_cpt_organizer_facebook', $custom )){
    $event_organiser_facebook = $custom['_event_cpt_organizer_facebook'][0];
    $string .= '<a href="'.esc_url_raw($event_organiser_facebook).'" target="_blank" rel="noopener"><span class="screen-reader-text">Facebook</span><svg class="icon icon-facebook" aria-hidden="true" role="img"><use href="#icon-facebook" xlink:href="#icon-facebook"></use></svg></a>';
  }
  if(array_key_exists( '_event_cpt_organizer_twitter', $custom )){
    $event_organiser_twitter = $custom['_event_cpt_organizer_twitter'][0];
    $string .= '<a href="'.esc_url_raw($event_organiser_twitter).'" target="_blank" rel="noopener"><span class="screen-reader-text">Twitter</span><svg class="icon icon-twitter" aria-hidden="true" role="img"><use href="#icon-twitter" xlink:href="#icon-twitter"></use></svg></a>';
  }
  if(array_key_exists( '_event_cpt_organizer_instagram', $custom )){
    $event_organiser_instagram = $custom['_event_cpt_organizer_instagram'][0];
    $string .= '<a href="'.esc_url_raw($event_organiser_instagram).'" target="_blank" rel="noopener"><span class="screen-reader-text">Instagram</span><svg class="icon icon-instagram" aria-hidden="true" role="img"><use href="#icon-instagram" xlink:href="#icon-instagram"></use></svg></a>';
  }

  return $string;
}

/*
* Get string listing venue, address and area
*/
function get_event_full_location($custom){
  $string ='';

  if(array_key_exists( '_event_cpt_venue', $custom )){
    $event_venue = sanitize_text_field($custom['_event_cpt_venue'][0]);
    $string .= $event_venue.'</br>';
  }
  if(array_key_exists( '_event_cpt_address_line_1', $custom )){
    $event_address_line_1 = sanitize_text_field($custom['_event_cpt_address_line_1'][0]);
    $string .= $event_address_line_1.'</br>';
  }
  if(array_key_exists( '_event_cpt_address_line_2', $custom )){
    $event_address_line_2 = sanitize_text_field($custom['_event_cpt_address_line_2'][0]);
    $string .= $event_address_line_2.'</br>';
  }
  if(array_key_exists( '_event_cpt_area', $custom )){
    $event_area = sanitize_text_field($custom['_event_cpt_area'][0]);
    $string .= $event_area;
  }
  if(array_key_exists( '_event_cpt_address_postcode', $custom )){
    $event_postcode = sanitize_text_field($custom['_event_cpt_address_postcode'][0]);
    $string .= '</br>'.$event_postcode;
  }

  return $string;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <div class="left-column">
	    <header class="entry-header">
		   <?php	the_title( '<h1 class="entry-title">', '</h1>' ); ?>
       <?php if(!empty($event_by)){  echo '<div class="event-by">by ' . $event_by .'</div>';  } ?>
	    </header><!-- .entry-header -->

      <div class="date">
        <?php
        if($event_date){echo $event_date;}
        if($event_start_time){ echo ' '.$event_start_time; }
        if($event_end_time){ echo ' - '. $event_end_time; }
        ?>
      </div>

	    <div class="entry-content">
        <?php
    		the_content( sprintf(
    			wp_kses(
    				/* translators: %s: Name of current post. Only visible to screen readers */
    				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'src-project' ),
    				array(
    					'span' => array(
    						'class' => array(),
    					),
    				)
    			),
    			get_the_title()
    		) );
        ?>
	    </div><!-- .entry-content -->
   </div><!-- left-column -->

   <div class="right-column">
  	  <?php if(has_post_thumbnail()){src_project_post_thumbnail();} else {
        echo '<div class="post-thumbnail"><img src="'.get_stylesheet_directory_uri().'/images/default-event-image.png" alt="no event image available" /></div>';
      } ?>

      <div class="subcolumn-A">
        <div class="event-type"> <?php echo $event_types;?> </div>
        <div class="price"> <?php echo $event_price; ?> </div>
     </div><!--subcolumn-A -->

      <div class="subcolumn-B">
        <div class="links">
          <?php echo $event_organiser_links; ?>
        </div><!-- links -->

        <div class="location"><?php echo $event_location; ?></div>
      </div><!-- subcolumn-B -->
   </div><!-- right-column -->

   <div id="organiser-info">
     <div class="organisers">
       <?php echo $event_organisers; ?>
     </div>

     <div class="organiser-logos">
       <?php if($is_key_event){
         echo $organiser_logos;
       }?>
     </div>

   </div><!-- organiser-logos -->
</article><!-- #post-<?php the_ID(); ?> -->

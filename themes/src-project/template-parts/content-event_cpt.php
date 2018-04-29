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

//TODO use get_post_custom() instead ?
$event_types = get_event_types($event_id);
//$event_date = get_post_meta($event_id, '_event_cpt_date_event', true);
$event_date = date('l, j F', strtotime($custom['_event_cpt_date_event'][0]));
$event_start_time = $custom['_event_cpt_startTime_event'][0];
$event_end_time = $custom['_event_cpt_endTime_event'][0];
$event_organisers = get_event_organisers($custom);
$event_organiser_links = get_event_organiser_links($custom);
$event_location = get_event_full_location($custom);
//$event_price = get_post_meta($event_id, '_event_cpt_price_event', true);

$event_price = money_format('%i', floatval($custom['_event_cpt_price_event'][0]));
$is_key_event = $custom['_event_cpt_key_event'][0];

if($is_key_event){
  $organiser_logos = get_organiser_logos($custom);
}

/*
* Get organiser logos
*/
function get_organiser_logos($custom){
  $logo_ids_array = array();

  // See if there's a media id already saved as post meta
  $logo1_id = absint($custom['_event_cpt_logo1_event'][0]);
  array_push($logo_ids_array,$logo1_id);
  $logo2_id = absint($custom['_event_cpt_logo2_event'][0]);
  array_push($logo_ids_array,$logo2_id);
  $logo3_id = absint($custom['_event_cpt_logo3_event'][0]);
  array_push($logo_ids_array,$logo3_id);
  $logo4_id = absint($custom['_event_cpt_logo4_event'][0]);
  array_push($logo_ids_array,$logo4_id);

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
    foreach ( $types as $type ) { $types_array[] = $type->name;}
    $types_string = join( " | ", $types_array );
  }

  return $types_string;
}

function get_event_organisers($custom){
  $string ='';
  $event_organiser_main = $custom['_event_cpt_main_organizer'][0];

  if(!empty($event_organiser_main)) { $string .= 'Organised by: '.$event_organiser_main.'.'; }

  $event_organiser_other_1 = $custom['_event_cpt_other_organizer_1'][0];
  $event_organiser_other_2 = $custom['_event_cpt_other_organizer_2'][0];
  $event_organiser_other_3 = $custom['_event_cpt_other_organizer_3'][0];

  if( $event_organiser_other_1 || $event_organiser_other_2 || $event_organiser_other_3 ){
    $other_organisers = array();
    if($event_organiser_other_1){array_push($other_organisers,$event_organiser_other_1);}
    if($event_organiser_other_2){array_push($other_organisers,$event_organiser_other_2);}
    if($event_organiser_other_3){array_push($other_organisers,$event_organiser_other_3);}
    $string .= ' In partnership with: '. $other_organisers[0];
    if(2 === count($other_organisers)){
      $string .= ' and '.$event_organiser_other_2.'.';
    }
    if(3 === count($other_organisers)){
      $string .= ', '.$event_organiser_other_2.' and '.$event_organiser_other_3.'.';
    }
  }

  return $string;
}

function get_event_organiser_links($custom){
  $string ='';

  $event_organiser_website = $custom['_event_cpt_organizer_website'][0];
  $event_organiser_facebook = $custom['_event_cpt_organizer_facebook'][0];
  $event_organiser_twitter = $custom['_event_cpt_organizer_twitter'][0];
  $event_organiser_instagram = $custom['_event_cpt_organizer_instagram'][0];

  $string .= '<div class="links">';
  if( '' != $event_organiser_website ){$string .= '<a href="'.esc_url_raw($event_organiser_website).'" target="_blank" rel="noopener"><span class="screen-reader-text">Website</span><svg class="icon icon-website" aria-hidden="true" role="img"><use href="#icon-website" xlink:href="#icon-website"></use></svg></a>';}
  if( '' != $event_organiser_facebook ){$string .= '<a href="'.esc_url_raw($event_organiser_facebook).'" target="_blank" rel="noopener"><span class="screen-reader-text">Facebook</span><svg class="icon icon-facebook" aria-hidden="true" role="img"><use href="#icon-facebook" xlink:href="#icon-facebook"></use></svg></a>';}
  if( '' != $event_organiser_twitter ){$string .= '<a href="'.esc_url_raw($event_organiser_twitter).'" target="_blank" rel="noopener"><span class="screen-reader-text">Twitter</span><svg class="icon icon-twitter" aria-hidden="true" role="img"><use href="#icon-twitter" xlink:href="#icon-twitter"></use></svg></a>';}
  if( '' != $event_organiser_instagram ){$string .= '<a href="'.esc_url_raw($event_organiser_instagram).'" target="_blank" rel="noopener"><span class="screen-reader-text">Instagram</span><svg class="icon icon-instagram" aria-hidden="true" role="img"><use href="#icon-instagram" xlink:href="#icon-instagram"></use></svg></a>';}
  $string .= '</div><!-- links -->';

  return $string;
}

function get_event_full_location($custom){
  $string ='';

  $event_venue = $custom['_event_cpt_venue'][0];
  $event_address_line_1 = $custom['_event_cpt_address_line_1'][0];
  $event_address_line_2 = $custom['_event_cpt_address_line_2'][0];
  $event_postcode = $custom['_event_cpt_address_postcode'][0];
  $event_area = $custom['_event_cpt_area'][0];

  $string .= $event_venue.'</br>';
  if($event_address_line_1){$string .= $event_address_line_1.'</br>';}
  if($event_address_line_2){$string .= $event_address_line_2.'</br>';}
  $string .= $event_area.'</br>'.$event_postcode;

  return $string;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <div class="left-column">
	    <header class="entry-header">
		   <?php	the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	    </header><!-- .entry-header -->

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
        echo '<img src="'.get_stylesheet_directory_uri().'/images/default-event-image.png" alt="no event image available" />';
      } ?>
      <?php echo $event_organiser_links; ?>
      <div class="event-type"> <?php echo $event_types;?> </div>
      <div class="date">
        <?php
        if($event_date){echo $event_date;}
        if($event_start_time){ echo ' from '.$event_start_time.' to '. $event_end_time; }
        ?></div>
      <div class="price"> <?php if('0.00' == $event_price){ echo 'FREE';}elseif('-1.00' == $event_price){ echo 'ENTRY BY DONATION';}else{ echo '£'.$event_price;};
       ?> </div>
      <div class="location"><?php echo $event_location; ?></div>
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

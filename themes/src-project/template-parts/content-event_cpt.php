<?php
/**
 * Template part for displaying event content in single-event_cpt.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Refugee_Scotland_Festival_Theme
 */

$event_id = get_the_id();
//TODO use get_post_custom() instead
$event_date = get_post_meta($event_id, '_event_cpt_date_event', true);
$event_start_time = get_post_meta($event_id, '_event_cpt_startTime_event', true);
$event_end_time = get_post_meta($event_id, '_event_cpt_endTime_event', true);
$event_organisers = get_event_organisers($event_id);
$event_organiser_links = get_event_organiser_links($event_id);
$event_location = get_event_full_location($event_id);
$event_price = get_post_meta($event_id, '_event_cpt_price_event', true);

$event_price = money_format('%i', floatval($event_price));

function get_event_organisers($event_id){
  $string ='';
  $event_organiser_main = get_post_meta($event_id, '_event_cpt_main_organizer', true);
  $event_organiser_other_1 = get_post_meta($event_id, '_event_cpt_other_organizer_1', true);
  $event_organiser_other_2 = get_post_meta($event_id, '_event_cpt_other_organizer_2', true);
  $event_organiser_other_3 = get_post_meta($event_id, '_event_cpt_other_organizer_3', true);

  $string .= '<p class="organisers">Organised by: '.$event_organiser_main.'.';
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
  $string .= '</p><!-- organisers -->';

  return $string;
}

function get_event_organiser_links($event_id){
  $string ='';

  $event_organiser_website = get_post_meta($event_id, '_event_cpt_organizer_website', true);
  $event_organiser_facebook = get_post_meta($event_id, '_event_cpt_organizer_facebook', true);
  $event_organiser_twitter = get_post_meta($event_id, '_event_cpt_organizer_twitter', true);
  $event_organiser_instagram = get_post_meta($event_id, '_event_cpt_organizer_instagram', true);

  $string .= '<div class="links">';
  if( '' != $event_organiser_website ){$string .= '<a href="'.esc_url_raw($event_organiser_website).'" target="_blank" rel="noopener"><span class="screen-reader-text">Website</span><svg class="icon icon-website" aria-hidden="true" role="img"><use href="#icon-website" xlink:href="#icon-website"></use></svg></a>';}
  if( '' != $event_organiser_facebook ){$string .= '<a href="'.esc_url_raw($event_organiser_facebook).'" target="_blank" rel="noopener"><span class="screen-reader-text">Facebook</span><svg class="icon icon-facebook" aria-hidden="true" role="img"><use href="#icon-facebook" xlink:href="#icon-facebook"></use></svg></a>';}
  if( '' != $event_organiser_twitter ){$string .= '<a href="'.esc_url_raw($event_organiser_twitter).'" target="_blank" rel="noopener"><span class="screen-reader-text">Twitter</span><svg class="icon icon-twitter" aria-hidden="true" role="img"><use href="#icon-twitter" xlink:href="#icon-twitter"></use></svg></a>';}
  if( '' != $event_organiser_instagram ){$string .= '<a href="'.esc_url_raw($event_organiser_instagram).'" target="_blank" rel="noopener"><span class="screen-reader-text">Instagram</span><svg class="icon icon-instagram" aria-hidden="true" role="img"><use href="#icon-instagram" xlink:href="#icon-instagram"></use></svg></a>';}
  $string .= '</div><!-- links -->';

  return $string;
}

function get_event_full_location($event_id){
  $string ='';

  $event_venue = get_post_meta($event_id, '_event_cpt_venue', true);
  $event_address_line_1 = get_post_meta($event_id, '_event_cpt_address_line_1', true);
  $event_address_line_2 = get_post_meta($event_id, '_event_cpt_address_line_2', true);
  $event_postcode = get_post_meta($event_id, '_event_cpt_address_postcode', true);
  $event_area = get_post_meta($event_id, '_event_cpt_area', true);

  $string .= ' <p class="location">'.$event_venue;
  if($event_address_line_1){$string .= ', '.$event_address_line_1;}
  if($event_address_line_2){$string .= ', '.$event_address_line_2;}
  $string .= ', '.$event_area.' '.$event_postcode.'</p>';

  return $string;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php

			the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<?php src_project_post_thumbnail(); ?>

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

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'src-project' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->

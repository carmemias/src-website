<?php
/**
 * Custom shortcodes for this plugin.
 *
 * @package Src_Events_Simple
 */

// Add Shortcode for Latest News
function src_svents_simple_latest_news( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'items' => '8',
			'title' => 'Events'
		), $atts )
	);

	// Code
	$output = "";
	$args = array (
		'post_type' => 'src_event',
		'posts_per_page' => $items
	);
	$query_news = new WP_Query( $args );
		$output .= '<section class="src-events src-events-list">';
		$output .= '<h2>'.$title.'</h2>';
		if ( $query_news->have_posts() ) {
			$output .= '<ul>';
			while ( $query_news->have_posts() ) {
				$query_news->the_post();
				$output .= '<li>';
					$output .= '<div class="events-thumbnail">';
					if (has_post_thumbnail()) {
						$output .= get_the_post_thumbnail(get_the_ID(),'thumbnail') ;
					}
					$output .= '</div>';
					$output .= '<div class="events-content">';
						$output .= '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
						$output .= '<p>'.get_the_excerpt().'</p>';
					$output .= '</div>';
				$output .= '</li>';
			}
			$output .= '</ul>';
		} else {
			$output .= "<h4>Sorry, no evetns.</h4>";
		}
	$output .= '</section>';
	wp_reset_postdata();
	return $output;
}
add_shortcode( 'src-svents-list', 'src_svents_simple_latest_news' );
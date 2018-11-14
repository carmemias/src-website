<?php
	

	add_action( 'wp_head', 'src_project_previous_festivals_frontend_css', 100);
	function src_project_previous_festivals_frontend_css(){
		global $post;
	$is_programme = get_post_meta($post->ID, '_previous_festival_is_programme', true);
	$is_current = get_post_meta($post->ID, '_previous_festival_is_current', true);
	if (($is_programme == "yes") && ($is_current == "no")) {
		$social_media_colour = get_post_meta($post->ID, '_previous_festival_social_media_buttons_colour', true);
		$text_colour = get_post_meta($post->ID, '_previous_festival_text_colour', true);
		$accent_colour = get_post_meta($post->ID, '_previous_festival_accent_colour', true);
?>
    <style type="text/css" id="previousFestivalsCss">
		body[class*="page-programme-"] .entry-header {
			display: block;
		}
		.previous-festivals-date {
			margin-top: 0;
		}
		<?php 
		if (!empty($social_media_colour)){
		?>
							/* menu and links text color */
							.main-navigation a, .site-title, .site-footer .es_caption, .single-event_cpt .entry-content {
										color: <?php echo $social_media_colour; ?>;
							}
							.site-header svg.icon {
										fill:<?php echo $social_media_colour; ?>;
							}
							button, .site-footer #es_txt_button, input[type="submit"] {
								border: <?php echo $social_media_colour; ?>;
								background-color: <?php echo $social_media_colour; ?>;
							}
							#programme .links a, .single-event_cpt .links a {
								background-color: <?php echo $social_media_colour; ?>;
							}
		<?php } 
		?>

		<?php 
		if (!empty($text_colour)){
		?>
							/* main text color */
							body, input, select, optgroup, a,
							.site-footer, .site-footer a, .site-footer label, .site-footer .widget-title, p  {
								color: <?php echo $text_colour; ?>;
							}

							.site-footer #es_txt_button { color: #FFF; }

							body:not(.home) .site-main .filterElement {
								background-color: <?php echo $text_colour; ?>;
							}

		<?php } 
		?>
		<?php 
			if (!empty($accent_colour)){
		?>
							/* accent color */
							#hero .site-description, #hero .festival-dates, .single-event_cpt article .right-column .subcolumn-B  {
								color: <?php echo $accent_colour; ?>;
							}
							.social-navigation a {
								background-color: <?php echo $accent_colour; ?>;
							}
							input[type="text"], input[type="email"], input[type="url"], input[type="password"],
							input[type="search"], input[type="number"], input[type="tel"], input[type="range"],
							input[type="date"], input[type="month"], input[type="week"], input[type="time"],
							input[type="datetime"], input[type="datetime-local"], input[type="color"],
							textarea, select, .site-footer .es_textbox_class {
								background-color: <?php echo $accent_colour; ?>;
							}
							.main-navigation .current_page_item > a, body[class*="page-programme-"] .event-header, .single-event_cpt .entry-header, body:not(.home) .site-main #programme {
								border-color:<?php echo $accent_colour; ?>;
							}
		<?php } 
		?>
	</style>

		<?php
						}
	}
	
	
 add_filter( 'the_content', 'getDates', 5, 1); 

function getDates($content) {
	$id = $GLOBALS['post']->ID;
	$is_programme = get_post_meta($id, '_previous_festival_is_programme', true);
	$is_current = get_post_meta($id, '_previous_festival_is_current', true);
	if (($is_programme == "yes") && ($is_current == "no")) {

	$start_date = get_post_meta($id, '_previous_festival_start_date', true);
	$end_date = get_post_meta($id, '_previous_festival_end_date', true);
	
	if(!empty($start_date) && !empty($end_date)){
		$formated_start_date = date('l j F Y', strtotime($start_date));
		$formated_end_date = date('l j F Y', strtotime($end_date));

		$content = sprintf(	
			'<h2 class="previous-festivals-date"> %s to %s</h2> %s', $formated_start_date, $formated_end_date,$content
        );
	}}
	return $content;
	}
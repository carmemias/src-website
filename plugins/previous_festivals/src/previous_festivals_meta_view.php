<?php
namespace etzali\PreviousFestivals\src;

global $post;
$is_programme = get_post_meta($post->ID, '_previous_festival_is_programme', true);
$is_current = get_post_meta($post->ID, '_previous_festival_is_current', true);
$start_date = get_post_meta($post->ID, '_previous_festival_start_date', true);
$end_date = get_post_meta($post->ID, '_previous_festival_end_date', true);
$social_media_colour = get_post_meta($post->ID, '_previous_festival_social_media_buttons_colour', true);
if(empty($social_media_colour)){$social_media_colour = "#a66bed";}
$text_colour = get_post_meta($post->ID, '_previous_festival_text_colour', true);
if(empty($text_colour)){$text_colour = "#2f39ed";}
$accent_colour = get_post_meta($post->ID, '_previous_festival_accent_colour', true);
if(empty($accent_colour)){$accent_colour = "#0ea2c7";}

?>
	<style>
		.hidden{ display: none;}
	</style>

<table cellspacing="15">
	<tr>
		<td>
			<label><?php _e( 'Is this a festival programme page?', 'previous-festivals' ); ?></label><br>
				<input type="radio" name="_previous_festival_is_programme" value="1" <?php checked( $is_programme, '1' ); ?> /> Yes<br />
				<input type="radio" name="_previous_festival_is_programme" value="0" <?php checked( $is_programme, '' ); ?> /> No
		</td>
	</tr>
    <tr>
		<td>
			<div id="isCurrent" class="<?php if($is_programme !== 1){echo 'hidden';} ?>">
				<label><?php _e( 'Is this for the current year?', 'previous-festivals' ); ?></label><br>
					<input type="radio" name="_previous_festival_is_current" value="1" <?php checked( $is_current, '1' ); ?> /> Yes<br />
					<input type="radio" name="_previous_festival_is_current" value="0" <?php checked( $is_current, '' ); ?> /> No
			</div>
		</td>
	</tr>
	<tr>
		<td>			
			<div id="datesAndColours" class="<?php if($is_current == 1){echo 'hidden';} ?>">
				<label><?php _e( 'What are the festival dates?', 'previous-festivals' ); ?></label><br>
					<input type="date" name="_previous_festival_start_date" value="<?php echo $start_date; ?>" /> <br />
					<input type="date" name="_previous_festival_end_date" value="<?php echo $end_date; ?>" /> 
					<br>
					<label><?php _e( 'Festival Colour Scheme', 'previous-festivals' ); ?></label><br />
					<label>Social Media Buttons </label> <input class="color-field" type="text" name="_previous_festival_social_media_buttons_colour" value="<?php esc_attr_e($social_media_colour); ?>" /> <br />
					<label>Text Colour </label><input  class="color-field" type="text" name="_previous_festival_text_colour" value=" <?php esc_attr_e($text_colour); ?>" /> <br />
					<label>Accent Colour </label><input  class="color-field" type="text" name="_previous_festival_accent_colour" value="<?php esc_attr_e( $accent_colour); ?>" /> <br />
			</div>
		</td>
	</tr>
</table>
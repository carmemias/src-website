<?php
namespace etzali\PreviousFestivals\src;

global $post;
$is_programme = get_post_meta($post->ID, '_previous_festival_is_programme', true);
$is_current = get_post_meta($post->ID, '_previous_festival_is_current', true);

?>
	<style>
		._previous_festival_admin_notice select {background-color:#ffb900}
		.hidden{ display: none;}
	</style>

<table cellspacing="15">
	<tr>
		<td>
			<label><?php _e( 'Is this a festival programme page?', 'previous-festivals' ); ?></label><br>
				<input type="radio" name="_previous_festival_is_programme" value="1" <?php checked( $is_programme, '1' ); ?> /> Yes<br />
				<input type="radio" name="_previous_festival_is_programme" value="0" <?php checked( $is_programme, '0' ); ?> /> No
		</td>
	</tr>
    <tr>
		<td>
			<label><?php _e( 'Is this for the current year?', 'previous-festivals' ); ?></label><br>
				<input type="radio" name="_previous_festival_is_current" value="1" <?php checked( $is_current, '1' ); ?> /> Yes<br />
				<input type="radio" name="_previous_festival_is_current" value="0" <?php checked( $is_current, '0' ); ?> /> No
		</td>
	</tr>
</table>
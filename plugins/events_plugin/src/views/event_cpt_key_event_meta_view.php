<?php
namespace yohannes\EventsFunctionality\src\views;

	//$custom = get_post_custom($post->ID);
	// Get the data if its already been entered
	$_event_cpt_key_event = get_post_meta($post->ID, '_event_cpt_key_event', true);

?>
<style>
	._event_cpt_admin_notice select {background-color:#ffb900}
</style>

	<table>

		<tr>
		
			<td>
			<label><?php _e( 'Key Event?', 'event_cpt' ); ?></label><br>
				<input type="radio" name="_event_cpt_key_event" value="0" <?php checked( $_event_cpt_key_event, '0' ); ?> /> Yes<br />
				<input type="radio" name="_event_cpt_key_event" value="1" <?php checked( $_event_cpt_key_event, '1' ); ?> /> No
			</td>
		</tr>
		<tr id="sponsorLogos">
			<td>
				<p>if its yes we will show the image upload link </p>
			</td>
		</tr>
	</table>
	<?php

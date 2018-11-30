<?php
namespace yohannes\EventsFunctionality\src\views;

	// $custom = get_post_custom($post->ID);
	// Get the data if its already been entered
	$_event_cpt_start_time_event = get_post_meta( $post->ID, '_event_cpt_start_time_event', true );
	$_event_cpt_end_time_event   = get_post_meta( $post->ID, '_event_cpt_end_time_event', true );
	$_event_cpt_date_event       = get_post_meta( $post->ID, '_event_cpt_date_event', true );


?>
<style>
	._event_cpt_admin_notice select {background-color:#ffb900}
</style>

<table>

	<tr>
		<td>
		<label><?php esc_html_e( 'Event Date and Time?', 'event_cpt' ); ?></label><br>
		<label>Date (required): </label><input type="date"  name="_event_cpt_date_event" value="<?php echo $_event_cpt_date_event; ?>" /><br>
			<label>Start time (required): </label><input type="time"  name="_event_cpt_start_time_event" value="<?php echo $_event_cpt_start_time_event; ?>" /><br>
			<label>Finish time: </label><input type="time"  name="_event_cpt_end_time_event" value="<?php echo $_event_cpt_end_time_event; ?>" />
		</td>
	</tr>
</table>

<?php
namespace yohannes\EventsFunctionality\src\views;

	//$custom = get_post_custom($post->ID);
	// Get the data if its already been entered
	$_event_cpt_area = get_post_meta($post->ID, '_event_cpt_area', true);

?>
<style>
	._event_cpt_admin_notice select {background-color:#ffb900}
</style>

<table class="form-table"> <!-- TODO make translatable -->
	<tr>
		<td>Type the Event's area name:</td>
	</tr>
	<tr style="border-bottom: 1px solid #eee;">
		<td>
			<label>Event Area:</label>
			 <input type="text" name="_event_cpt_area" placeholder="Area name ..." value="<?php echo $_event_cpt_area; ?>">
		</td><!-- event area -->
	</tr>
</table>

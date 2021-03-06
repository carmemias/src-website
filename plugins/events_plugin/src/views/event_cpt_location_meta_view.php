<?php
namespace yohannes\EventsFunctionality\src\views;

	//$custom = get_post_custom($post->ID);
	// Get the data if its already been entered
	$_event_cpt_venue = get_post_meta($post->ID, '_event_cpt_venue', true);
	$_event_cpt_address_line_1 = get_post_meta($post->ID, '_event_cpt_address_line_1', true);
	$_event_cpt_address_line_2 = get_post_meta($post->ID, '_event_cpt_address_line_2', true);
	$_event_cpt_address_postcode = get_post_meta($post->ID, '_event_cpt_address_postcode', true);
	$_event_cpt_area = get_post_meta($post->ID, '_event_cpt_area', true);

?>
<style>
	._event_cpt_admin_notice select {background-color:#ffb900}
</style>

<table class="form-table"> <!-- TODO make translatable -->
	<tr style="border-bottom: 1px solid #eee;">
		<td>
			<label>Venue Name:</label>
			 <input type="text" name="_event_cpt_venue" placeholder="Venue name ..." value="<?php echo $_event_cpt_venue; ?>">
		</td><!-- venue name -->
	</tr>
	<tr>
		<td>Type the Event's Address:</td>
	</tr>
	 <tr>
		<td>
			<label>Address Line 1: </label>
			 <input type="text" size="50" name="_event_cpt_address_line_1" placeholder="Address line 1..." value="<?php echo $_event_cpt_address_line_1; ?>"><br>
			 <label>Address Line 2: </label>
			 <input type="text" size="50" name="_event_cpt_address_line_2" placeholder="Address line 2..." value="<?php echo $_event_cpt_address_line_2; ?>"><br>
			 <label>Postcode: </label>
			 <input type="text" name="_event_cpt_address_postcode" placeholder="Postcode..." value="<?php echo $_event_cpt_address_postcode; ?>"><br>
			<label>Event Area (required):</label>
			 <input type="text" name="_event_cpt_area" placeholder="City / Town ..." value="<?php echo $_event_cpt_area; ?>">
		</td><!-- venue address -->
	</tr>
</table>

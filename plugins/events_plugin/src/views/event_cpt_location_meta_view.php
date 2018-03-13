<?php
namespace yohannes\EventsFunctionality\src\views;

	//$custom = get_post_custom($post->ID);
	// Get the data if its already been entered
	$_event_cpt_venue = get_post_meta($post->ID, '_event_cpt_venue', true);
	$_event_cpt_address_line_1 = get_post_meta($post->ID, '_event_cpt_address_line_1', true);
	$_event_cpt_address_line_2 = get_post_meta($post->ID, '_event_cpt_address_line_2', true);
	// $_event_cpt_address_town_city = get_post_meta($post->ID, '_event_cpt_address_town_city', true);
	// $_event_cpt_address_county = get_post_meta($post->ID, '_event_cpt_address_county', true);
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
			 <input type="text" size="100" name="_event_cpt_address_line_1" placeholder="Address line 1..." value="<?php echo $_event_cpt_address_line_1; ?>"><br>
			 <label>Address Line 2: </label>
			 <input type="text" size="100" name="_event_cpt_address_line_2" placeholder="Address line 2..." value="<?php echo $_event_cpt_address_line_2; ?>"><br>
			 <!-- <label>Town/city </label>
			 <input type="text" name="_event_cpt_address_town_city" placeholder="Town / City..." value="<?php echo $_event_cpt_address_town_city; ?>"><br>
			 <label>County: </label>
			 <input type="text" name="_event_cpt_address_county" placeholder="County..." value="<?php echo $_event_cpt_address_county ?>"><br> -->
			 <label>Postcode: </label>
			 <input type="text" name="_event_cpt_address_postcode" placeholder="Postcode..." value="<?php echo $_event_cpt_address_postcode; ?>">	 
		</td><!-- venue address -->
	</tr>
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

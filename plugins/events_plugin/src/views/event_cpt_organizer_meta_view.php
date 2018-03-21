<?php
namespace yohannes\EventsFunctionality\src\views;

	//$custom = get_post_custom($post->ID);
	// Get the data if its already been entered
    $_event_cpt_main_organizer = get_post_meta($post->ID, '_event_cpt_main_organizer', true);
    $_event_cpt_other_organizer = get_post_meta($post->ID, '_event_cpt_other_organizer', true);
    $_event_cpt_organizer_website = get_post_meta($post->ID, '_event_cpt_organizer_website', true);
    $_event_cpt_organizer_facebook = get_post_meta($post->ID, '_event_cpt_organizer_facebook', true);
    $_event_cpt_organizer_twitter = get_post_meta($post->ID, '_event_cpt_organizer_twitter', true);
    $_event_cpt_organizer_instagram = get_post_meta($post->ID, '_event_cpt_organizer_instagram', true);

?>
<style>
	._event_cpt_admin_notice select {background-color:#ffb900}
</style>

<table class="form-table"> <!-- TODO make translatable -->

    <tr style="border-bottom: 1px solid #eee;">
		<td>
			<label>Main Organizer Name:</label>
             <input type="text" size="50" name="_event_cpt_main_organizer" placeholder="Organizer Name ..." value="<?php echo $_event_cpt_main_organizer; ?>"><br>
             <label>Organizer Name:</label>
             <input type="text" size="50" name="_event_cpt_other_organizer" placeholder="Organizer Name ..." value="<?php echo $_event_cpt_other_organizer; ?>"><br>
			 <label>Organizer Name:</label>
             <input type="text" size="50" name="_event_cpt_other_organizer" placeholder="Organizer Name ..." value="<?php echo $_event_cpt_other_organizer; ?>"><br>
			 <label>Organizer Name:</label>
             <input type="text" size="50" name="_event_cpt_other_organizer" placeholder="Organizer Name ..." value="<?php echo $_event_cpt_other_organizer; ?>">
		</td><!-- organizer name -->
	</tr>
    <tr>
		<td>
			<label>Organizer's Website </label>
			 <input type="url" size="50" name="_event_cpt_organizer_website" placeholder="website url https:// ....." value="<?php echo $_event_cpt_organizer_website; ?>"><br>
		</td><!-- venue address -->
	</tr>
    <tr>
        <td>
             <label>Social Media </label><br>
			 <label>Facebook</label><input type="url" size="50" name="_event_cpt_organizer_facebook" placeholder="Facebook url..." value="<?php echo $_event_cpt_organizer_facebook; ?>"><br>
			 <label>Twitter</label><input type="url" size="50" name="_event_cpt_organizer_twitter" placeholder="Twitter url..." value="<?php echo $_event_cpt_organizer_twitter; ?>"><br>
             <label>Instagram</label><input type="url" size="50" name="_event_cpt_organizer_instagram" placeholder="Instagram url..." value="<?php echo $_event_cpt_organizer_instagram; ?>"><br>
		</td><!-- venue address -->
	</tr>

</table>
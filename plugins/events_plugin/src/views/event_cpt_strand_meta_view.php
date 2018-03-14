<?php
namespace yohannes\EventsFunctionality\src\views;

	//$custom = get_post_custom($post->ID);
	// Get the data if its already been entered
	$_event_cpt_strand_event = get_post_meta($post->ID, '_event_cpt_strand_event', true);

?>
<style>
	._event_cpt_admin_notice select {background-color:#ffb900}
</style>

<table>

    <tr>
        <td>
        <label><?php _e( 'Strand Event?', 'event_cpt' ); ?></label><br>
            <input type="radio" name="_event_cpt_strand_event" value="0" <?php checked( $_event_cpt_strand_event, '0' ); ?> /> Open Program<br />
            <input type="radio" name="_event_cpt_strand_event" value="1" <?php checked( $_event_cpt_strand_event, '1' ); ?> /> Creative Communities
        </td>
    </tr>
</table>
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
            <input type="radio" name="_event_cpt_strand_event" value="Open Program" <?php checked( $_event_cpt_strand_event, 'Open Program' ); ?> /> Open Program<br />
            <input type="radio" name="_event_cpt_strand_event" value="Creative Communities" <?php checked( $_event_cpt_strand_event, 'Creative Communities' ); ?> /> Creative Communities
        </td>
    </tr>
</table>
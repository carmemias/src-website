<?php
namespace yohannes\EventsFunctionality\src\views;

	//$custom = get_post_custom($post->ID);
	// Get the data if its already been entered
    $_event_cpt_startTime_event = get_post_meta($post->ID, '_event_cpt_startTime_event', true);
    $_event_cpt_endTime_event = get_post_meta($post->ID, '_event_cpt_endTime_event', true);
    

?>
<style>
	._event_cpt_admin_notice select {background-color:#ffb900}
</style>

<table>

    <tr>
        <td>
        <label><?php _e( 'Event time?', 'event_cpt' ); ?></label><br>
           <input type="text"  name="_event_cpt_startTime_event" placeholder="insert start time" value="<?php echo $_event_cpt_startTime_event; ?>" />
           <input type="text"  name="_event_cpt_endTime_event" placeholder="insert end time" value="<?php echo $_event_cpt_endTime_event; ?>" />
        </td>
    </tr>
</table>
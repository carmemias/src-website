<?php
namespace yohannes\EventsFunctionality\src\views;

	//$custom = get_post_custom($post->ID);
	// Get the data if its already been entered
	$_event_cpt_price_event = get_post_meta($post->ID, '_event_cpt_price_event', true);

?>
<style>
	._event_cpt_admin_notice select {background-color:#ffb900}
</style>

<table>

    <tr>
        <td>
        <label><?php _e( 'Event Price?', 'event_cpt' ); ?></label><br>
            <span>£</span><input type="number" style="width: 100px; height: 35px;" min="0.00" step="0.01" max="500" name="_event_cpt_price_event" placeholder="£" value="<?php echo $_event_cpt_price_event; ?>" />
        </td>
    </tr>
</table>
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
        <label><?php _e( 'What is the Event Price?', 'event_cpt' ); ?></label><br>
            <span>£ </span><input type="number" id="inputPrice" style="width: 100px; height: 35px;" min="0.00" step="0.01" max="500" name="_event_cpt_price_event" placeholder="00.00" value="<?php echo $_event_cpt_price_event; ?>" /><br/>
            <input type="radio" name="_event_cpt_price_event" value="0" <?php checked( $_event_cpt_price_event, '0' ); ?> /> Free<br />
			<input type="radio" name="_event_cpt_price_event" value="-1" <?php checked( $_event_cpt_price_event, '0' ); ?> /> Entry by Donation
        </td>
    </tr>
</table>

<?php
namespace yohannes\EventsFunctionality\src\views;

	$current_num_events = wp_count_posts('event_cpt')->publish;
?>

<fieldset class="inline-edit-col-right"> <!-- TODO make translatable -->
    <div class="inline-edit-col">
        <span class="title">Event Order</span>
        <input type="hidden" name="event_cpt_noncename" id="event_cpt_noncename" value="<?php echo wp_create_nonce('event_cpt_order'); ?>" />

		 <select id="_event_cpt_order" name="_event_cpt_order" class=""> <!-- The selected attribute is set with javascript -->
		  <option value="not set">Select order...</option>
		  <option value="hidden">Don't show</option>
		  <option value="10000">Bottom of the list</option>
      	<?php for ( $i=1; $i <= $current_num_events; $i++ ) { ?>
      		<option value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
          <?php } //end for loop ?>
		</select>
    </div>
</fieldset>

<?php
namespace yohannes\EventsFunctionality\src\views;

	//$custom = get_post_custom($post->ID);
	// Get the data if its already been entered
	$_event_cpt_key_event = get_post_meta($post->ID, '_event_cpt_key_event', true);
	//$_event_cpt_logo2_event = get_post_meta($post->ID, '_event_cpt_logo2_event', true);
	//$_event_cpt_logo3_event = get_post_meta($post->ID, '_event_cpt_logo3_event', true);
	//$_event_cpt_logo4_event = get_post_meta($post->ID, '_event_cpt_logo4_event', true);

?>
<style>
	._event_cpt_admin_notice select {background-color:#ffb900}
	.hidden{ display: none;}
</style>

	<table>

		<tr>
		
			<td>
			<label><?php _e( 'Key Event?', 'event_cpt' ); ?></label><br>
				<input type="radio" name="_event_cpt_key_event" value="1" <?php checked( $_event_cpt_key_event, '1' ); ?> /> Yes<br />
				<input type="radio" name="_event_cpt_key_event" value="0" <?php checked( $_event_cpt_key_event, '0' ); ?> /> No
			</td>
		</tr>
		<tr class="logoRow <?php if($_event_cpt_key_event!= '1'){echo "hidden";}?>">
			<td>
				<?php
					global $post;
					
					// Get WordPress' media upload URL
					$upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );
					
					// See if there's a media id already saved as post meta
					$_event_cpt_logo1_event = get_post_meta( $post->ID, '_event_cpt_logo1_event', true );
					
					// Get the image src
					$logo1_img_src = wp_get_attachment_image_src( $_event_cpt_logo1_event, 'thumbnail' );
					
					// For convenience, see if the array is valid
					$you_have_img = is_array( $logo1_img_src );
				?>
				<div class="custom-img-container">
				<?php if ( $you_have_img ) { ?>
					<img src="<?php echo $logo1_img_src[0] ?>" alt="" style="max-width:100%;" />
				<?php } ?>
				</div>

				<div class="logo-buttons">
				<a href="#" class="upload_new_logo button" <?php if ( $you_have_img ) { echo 'style="display:none;"'; } ?>>Upload Logo 1</a>
				<a href="#" class="remove_logo button" style="display:inline-block;<?php if ( !$you_have_img ) { echo 'display: none;'; } ?>">Remove Logo 1</a>
				</div>

				<input type="hidden" name="_event_cpt_logo1_event" id="_logo_id" value="<?php echo $_event_cpt_logo1_event;?>" />
			</td>
		</tr>
	</table>

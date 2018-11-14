<?php
namespace yohannes\EventsFunctionality\src\views;

//$custom = get_post_custom($post->ID);
// Get the data if its already been entered
global $post;
$_event_cpt_key_event = get_post_meta($post->ID, '_event_cpt_key_event', true);
$upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );
// See if there's a media id already saved as post meta
$_event_cpt_logo1_event = get_post_meta( $post->ID, '_event_cpt_logo1_event', true );
$_event_cpt_logo2_event = get_post_meta( $post->ID, '_event_cpt_logo2_event', true );
$_event_cpt_logo3_event = get_post_meta( $post->ID, '_event_cpt_logo3_event', true );
$_event_cpt_logo4_event = get_post_meta( $post->ID, '_event_cpt_logo4_event', true );
// Get the image src
$logo1_img_src = wp_get_attachment_image_src( $_event_cpt_logo1_event, 'thumbnail' );
$logo2_img_src = wp_get_attachment_image_src( $_event_cpt_logo2_event, 'thumbnail' );
$logo3_img_src = wp_get_attachment_image_src( $_event_cpt_logo3_event, 'thumbnail' );
$logo4_img_src = wp_get_attachment_image_src( $_event_cpt_logo4_event, 'thumbnail' );
// For convenience, see if the array is valid
$you_have_img1 = is_array( $logo1_img_src );
$you_have_img2 = is_array( $logo2_img_src );
$you_have_img3 = is_array( $logo3_img_src );
$you_have_img4 = is_array( $logo4_img_src );

?>
	<style>
		._event_cpt_admin_notice select {background-color:#ffb900}
		.hidden{ display: none;}
	</style>

<table cellspacing="15">
	<tr>
		<td>
			<label><?php _e( 'Is this a Key Event?', 'events-functionality' ); ?></label><br>
				<input type="radio" name="_event_cpt_key_event" value="1" <?php checked( $_event_cpt_key_event, '1' ); ?> /> Yes<br />
				<input type="radio" name="_event_cpt_key_event" value="0" <?php checked( $_event_cpt_key_event, '0' ); ?> /> No
		</td>
	</tr>
	  <tr>
		<td>
			<div class="logo1 logoRow <?php if($_event_cpt_key_event!= '1'){echo "hidden";}?>">
				<div class="custom-img-container">
				<?php if ( $you_have_img1 ) { ?>
					<img src="<?php echo $logo1_img_src[0] ?>" alt="" style="max-width:100%;" />
				<?php } ?>
				</div>

				<div class="logo-buttons">
				<a href="#" class="upload_new_logo button" <?php if ( $you_have_img1 ) { echo 'style="display:none;"'; } ?>>Upload Logo 1</a>
				<a href="#" class="remove_logo button" style="display:inline-block;<?php if ( !$you_have_img1 ) { echo 'display: none;'; } ?>">Remove Logo 1</a>
				</div>

				<input type="hidden" name="_event_cpt_logo1_event" id="_logo_id" value="<?php echo $_event_cpt_logo1_event;?>" />
			</div>
		</td>
	  </tr>
	  <tr>
		<td>
			<div class="logo2 logoRow <?php if($_event_cpt_key_event!= '1'){echo "hidden";}?>">

				<div class="custom-img-container">
				<?php if ( $you_have_img2 ) { ?>
					<img src="<?php echo $logo2_img_src[0] ?>" alt="" style="max-width:100%;" />
				<?php } ?>
				</div>

				<div class="logo-buttons">
				<a href="#" class="upload_new_logo button" <?php if ( $you_have_img2 ) { echo 'style="display:none;"'; } ?>>Upload Logo 2</a>
				<a href="#" class="remove_logo button" style="display:inline-block;<?php if ( !$you_have_img2 ) { echo 'display: none;'; } ?>">Remove Logo 2</a>
				</div>

				<input type="hidden" name="_event_cpt_logo2_event" id="_logo_id" value="<?php echo $_event_cpt_logo2_event;?>" />

			</div>
		</td>
	  </tr>
	  <tr>
		<td>
			<div class="logo3 logoRow <?php if($_event_cpt_key_event!= '1'){echo "hidden";}?>">

				<div class="custom-img-container">
				<?php if ( $you_have_img3 ) { ?>
					<img src="<?php echo $logo3_img_src[0] ?>" alt="" style="max-width:100%;" />
				<?php } ?>
				</div>

				<div class="logo-buttons">
				<a href="#" class="upload_new_logo button" <?php if ( $you_have_img3 ) { echo 'style="display:none;"'; } ?>>Upload Logo 3</a>
				<a href="#" class="remove_logo button" style="display:inline-block;<?php if ( !$you_have_img3 ) { echo 'display: none;'; } ?>">Remove Logo 3</a>
				</div>

				<input type="hidden" name="_event_cpt_logo3_event" id="_logo_id" value="<?php echo $_event_cpt_logo3_event;?>" />
			</div>
		</td>
	  </tr>
	  <tr>
		<td>
			<div class="logo4 logoRow <?php if($_event_cpt_key_event!= '1'){echo "hidden";}?>">

				<div class="custom-img-container">
				<?php if ( $you_have_img4 ) { ?>
					<img src="<?php echo $logo4_img_src[0] ?>" alt="" style="max-width:100%;" />
				<?php } ?>
				</div>

				<div class="logo-buttons">
				<a href="#" class="upload_new_logo button" <?php if ( $you_have_img4 ) { echo 'style="display:none;"'; } ?>>Upload Logo 4</a>
				<a href="#" class="remove_logo button" style="display:inline-block;<?php if ( !$you_have_img4 ) { echo 'display: none;'; } ?>">Remove Logo 4</a>
				</div>

				<input type="hidden" name="_event_cpt_logo4_event" id="_logo_id" value="<?php echo $_event_cpt_logo4_event;?>" />
			</div>
		</td>
	</tr>
</table>

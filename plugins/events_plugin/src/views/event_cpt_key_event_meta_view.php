<?php
namespace yohannes\EventsFunctionality\src\views;

	//$custom = get_post_custom($post->ID);
	// Get the data if its already been entered
	$_event_cpt_key_event = get_post_meta($post->ID, '_event_cpt_key_event', true);
	$_event_cpt_logo1_event = get_post_meta($post->ID, '_event_cpt_logo1_event', true);
	//$_event_cpt_logo2_event = get_post_meta($post->ID, '_event_cpt_logo2_event', true);
	//$_event_cpt_logo3_event = get_post_meta($post->ID, '_event_cpt_logo3_event', true);
	//$_event_cpt_logo4_event = get_post_meta($post->ID, '_event_cpt_logo4_event', true);

?>
<style>
	._event_cpt_admin_notice select {background-color:#ffb900}
</style>

	<table>

		<tr>
		
			<td>
			<label><?php _e( 'Key Event?', 'event_cpt' ); ?></label><br>
				<input type="radio" name="_event_cpt_key_event" value="1" <?php checked( $_event_cpt_key_event, '1' ); ?> /> Yes<br />
				<input type="radio" name="_event_cpt_key_event" value="0" <?php checked( $_event_cpt_key_event, '0' ); ?> /> No
			</td>
		</tr>
		<tr>
			<td>

			</td>
		</tr>
	</table>
<?php

global $post;

// Get WordPress' media upload URL
$upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );

// See if there's a media id already saved as post meta
// $logo1_img_src_id = get_post_meta( $post->ID, '_event_cpt_logo1_event', true );

// Get the image src
$logo1_img_src = wp_get_attachment_image_src( $_event_cpt_logo1_event, 'thumbnail' );

// For convenience, see if the array is valid
$you_have_img = is_array( $logo1_img_src );
?>

<!-- Your image container, which can be manipulated with js -->
<div class="custom-img-container">
    <?php if ( $you_have_img ) : ?>
        <img src="<?php echo $logo1_img_src[0] ?>" alt="" style="max-width:100%;" />
    <?php endif; ?>
</div>

<!-- Your add & remove image links -->
<p class="addLogoButtons" style="display: none;">
    <a class="upload-custom-img <?php if ( $you_have_img  ) { echo 'hidden'; } ?>" 
       href="<?php echo $upload_link ?>">
        <?php _e('Upload Logo') ?>
    </a>
    <a class="delete-custom-img <?php if ( ! $you_have_img  ) { echo 'hidden'; } ?>" 
      href="#">
        <?php _e('Remove this image') ?>
    </a>
</p>

<!-- A hidden input to set and post the chosen image id -->
<input class="custom-img-id" name="custom-img-id" type="hidden" value="<?php echo esc_attr( $your_img_id ); ?>" />

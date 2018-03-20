$(document).ready(function(){
    $('[name="_event_cpt_key_event"]').click(function(){
	var value = $(this).val().parseInt(10);
      if (!value){
		$('.logoRow').hide();
	  }else
	  $('.logoRow').show();
    });
});

jQuery(function($) {
  /*
	 * Select/Upload image(s) event
	 */
  $("body").on("click", ".upload_new_logo", function(e) {
    e.preventDefault();

    var button = $(this),
      current_logo = $(this).parent().parent(),
      imgContainer = current_logo.find(".custom-img-container"),
      hiddenLogoIdInput = current_logo.find("#_logo_id"),
      custom_uploader = wp.media({
          title: "Insert image",
          library: {
            type: "image"
          },
          button: {
            text: "Use this image" // button label text
          },
          multiple: false // for multiple image selection set to true
        })
        .on("select", function() {
          // it also has "open" and "close" events

          var attachment = custom_uploader
            .state()
            .get("selection")
            .first()
            .toJSON();
          imgContainer.append(
            '<img src="' +
              attachment.url +
              '" style="max-width:100%;display:block;" />'
          );
          hiddenLogoIdInput.val(attachment.id);

          button.hide();
          button.next().show();
        })
        .open();
  });

  /*
	 * Remove image event
	 */
  $("body").on("click", ".remove_logo", function() {
    var button = $(this),
      current_logo = $(this).parent().parent(),
      imgContainer = current_logo.find(".custom-img-container"),
      hiddenLogoIdInput = current_logo.find("#_logo_id");

    button.hide();
    button.prev().show();
    imgContainer.html("");
    hiddenLogoIdInput.val("");

    return false;
  });
});
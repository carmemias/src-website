console.log("found");
$(document).ready(function(){
    $('[name="_event_cpt_key_event"]').click(function(){
	var value = $(this).val();
      if (value=="0"){
		$('.addLogoButtons').hide();
	  }else
	  $('.addLogoButtons').show();
    });
});
jQuery(document).ready(function($) {
  $(".color-field").each(function() {
    $(this).wpColorPicker();
  });
  $("[name=_previous_festival_is_programme]").click(function() {
    var valueProgramme = $(this).val();
    if (valueProgramme == "yes") {
      $("[name=_previous_festival_is_current]").val([""]);
      $("#isCurrent").removeClass("hidden");
    } else {
      $("#isCurrent").addClass("hidden") &&
        $("#datesAndColours").addClass("hidden");
    }
  });

  $("[name=_previous_festival_is_current]").click(function() {
    var valueCurrent = $(this).val();
    var valueProgramme = $("[name=_previous_festival_is_programme]").val();
    if (valueCurrent != "yes" && valueProgramme == "yes") {
      $("#datesAndColours").removeClass("hidden");
    } else {
      $("#datesAndColours").addClass("hidden");
    }
  });
});

jQuery(document).ready(function($) {
  $(".color-field").each(function() {
    $(this).wpColorPicker();
  });
  $("[name=_previous_festival_is_programme]").click(function() {
    var valueProgramme = $(this).val();
    if (valueProgramme == 1) {
      $("[name=_previous_festival_is_current]").val(["1"]);
      $("#isCurrent").removeClass("hidden");
    } else {
      $("#isCurrent").addClass("hidden") &&
        $("#datesAndColours").addClass("hidden");
    }
  });

  $("[name=_previous_festival_is_current]").click(function() {
    var valueCurrent = $(this).val();
    var valueProgramme = $("[name=_previous_festival_is_programme]").val();
    if (valueCurrent != 1 && valueProgramme == 1) {
      $("#datesAndColours").removeClass("hidden");
    } else {
      $("#datesAndColours").addClass("hidden");
    }
  });
});

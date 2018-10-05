$(function () {
  "use strict";

  // Switch between login & singup
  $(".login-page h1 span").on("click", function () {
    $(this).addClass("selected").siblings("h1 span").removeClass("selected");
    $("." + $(this).data("class")).fadeIn().siblings(".login-page form").hide();
  });

  // Trigger The SelectBoxIt
  $("select").selectBoxIt({
    autoWidth: false
  });

  // Hide Placeholder On Form Focus
  $('[placeholder]').on('focus', function () {

    $(this).attr('data-text', $(this).attr('placeholder'));
    $(this).attr('placeholder', '');

  }).on('blur', function () {

    $(this).attr('placeholder', $(this).attr('data-text'));

  });

  // Add Asterisk On Each Required Field
  $("input").each(function () {
    if ($(this).attr("required") === "required") {
      $(this).after("<span class='asterisk'>*</span>");
    }
  });

  // Confirmation Message On Button Clicked
  $(".confirm").on("click", function () {
    return confirm("Are you sure to so this action ?");
  });

});

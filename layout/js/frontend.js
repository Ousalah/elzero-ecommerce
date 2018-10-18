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

  // Start live preview, item (ad) creation
  $(".live").keyup(function () { $($(this).data("class")).text($(this).val()); });
  $(".live-preview [class^='live-']").on("click", function () {
    $("input[data-class='." + $(this).attr("class").match(/live-[\w-]*\b/) + "']").focus();
  });
  // live preview for image
  $(".live-preview img").on("click", function() { $("input[name='image']").click(); });
  $("input[name='image']").change(function() {
    $(".live-preview img").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
  });

});

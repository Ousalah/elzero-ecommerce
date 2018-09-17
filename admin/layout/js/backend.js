$(function () {
  "use strict";

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

  // Convert Password Field To Text Fieald On Hover
  $('.show-pass').hover(function () {
    $(this).removeClass('fa-eye-slash').addClass('fa-eye');
    $(this).siblings('[name="password"]').attr('type', 'text');

  }, function () {
    $(this).removeClass('fa-eye').addClass('fa-eye-slash');
    $(this).siblings('[name="password"]').attr('type', 'password');
  });

  // Convert Password Field To Text Fieald On Click
  $(".show-pass").on("click" , function () {
    if( $(this).hasClass("fa-eye-slash") ) {
      $(this).removeClass('fa-eye-slash').addClass('fa-eye');
      $(this).siblings('[name="password"]').attr('type', 'text');

    } else if ( $(this).hasClass("fa-eye") ) {
      $(this).removeClass('fa-eye').addClass('fa-eye-slash');
      $(this).siblings('[name="password"]').attr('type', 'password');
    }
  });

  // Confirmation Message On Button Clicked
  $(".confirm").on("click", function () {
    return confirm("Are you sure to so this action ?");
  });

});

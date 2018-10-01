$(function () {
  "use strict";

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

  // Category View Option
  $(".categories .cat h3").on("click", function () { $(this).next(".full-view").fadeToggle(200); });

  $(".options span").on("click", function () {
    $(this).addClass("active").siblings("span").removeClass("active");
    if($(this).data("view") === "full") {
      $(".categories .cat .full-view").fadeIn(200);
    } else {
      $(".categories .cat .full-view").fadeOut(200);
    }
  });

  $(".toggle-latest-info").on("click", function () {
    if ($(this).children("i").hasClass("fa-plus")) {
      $(this).children("i").removeClass("fa-plus").addClass("fa-minus");
      $(this).parent().next(".panel-body").fadeOut(100);
    } else {
      $(this).children("i").removeClass("fa-minus").addClass("fa-plus");
      $(this).parent().next(".panel-body").fadeIn(100);
    }
  });

});

$(document).ready(function() {
  toggleMenu();
  triggerMenu();
  resizeWindow();
});

function resizeWindow() {
  $(window).resize(function() {
    // $('body').removeClass('hide-menu');
  });
}

function triggerMenu() {
  var deviceWidth = $(window).width();
  if (deviceWidth < 768) {
    var bodyClass = $('body').hasClass('hide-menu');
    if (!bodyClass) {
      $('.toggle-menu.mobile a.btn').trigger('click');
    }
  }
}

function toggleMenu() {
  $('.toggle-menu a.btn').on('click', function() {
    $('body').toggleClass('hide-menu');
    var bodyClass = $('body').hasClass('hide-menu');
    var deviceWidth = $(window).width();

    if (deviceWidth > 767) {
      var winWid = deviceWidth - 66;
    } else {
      var winWid = deviceWidth;
    }
  });
}

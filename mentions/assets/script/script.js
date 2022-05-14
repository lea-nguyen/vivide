$(document).ready(function () {
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      $("#scroll").fadeIn();
    } else {
      $("#scroll").fadeOut();
    }
  });
  $("#scroll").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 100);
    return false;
  });

  // MEDIA QUERIES
  if (window.matchMedia("(min-width: 800px)").matches) {
    var headerHeight = $("header").height();
    $("main").css({ marginTop: headerHeight + "px" });
  }

  $("ol li a").click(function () {
    $("html, body").animate(
      {
        scrollTop: $($(this).attr("href")).offset().top - (headerHeight + 40),
      },
      50
    );
    return false;
  });
});

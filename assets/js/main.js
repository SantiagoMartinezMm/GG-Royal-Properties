jQuery(document).ready(function ($) {
  // Toggle mobile menu
  $('#mobile-menu-toggle').on('click', function () {
      $('.main-navigation').toggleClass('menu-open');
  });

  // Close mobile menu when clicking outside
  $(document).on('click', function (e) {
      if (!$(e.target).closest('.main-navigation, #mobile-menu-toggle').length) {
          $('.main-navigation').removeClass('menu-open');
      }
  });

  // Smooth scroll for anchor links
  $('a[href*="#"]').on('click', function (e) {
      if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
          let target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
          if (target.length) {
              e.preventDefault();
              $('html, body').animate({
                  scrollTop: target.offset().top
              }, 800);
          }
      }
  });
});


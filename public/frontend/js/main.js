$(document).ready(function() {
  $('.count-number').each(function() {
    $(this).prop('Counter', 0).animate({
      Counter: $(this).data('count')
    }, {
      duration: 3000,
      easing: 'swing',
      step: function(now) {
        $(this).text(Math.ceil(now));
      }
    });
  });
});

// Owl Carousel 
$('.owl-carousel').owlCarousel({
  loop:true,
  responsiveClass:true,
  nav: false,
  dots: false,
  autoplay: true,
  autoplayTimeout: 4000,
  animateIn: true,
  animateOut: true,
  responsive:{
      0:{
          items:2,
      },
      600:{
          items:3,
      },
      1000:{
          items:5,
          loop:true
      }
  }
})
'use strict';
import $ from 'jquery';
import slick from 'slick-carousel';

export default class Carousel {
  constructor() {
  }

  init() {
      $(".slider").slick({

          // normal options...
          slidesToShow: 1,
          slidesToScroll: 1,
          autoplay: true,
		  speed: 500,
          infinite: true,
          accessibility: true,
		  fade: true,
  		  cssEase: 'linear',
		  arrows: false,
		  lazyLoad: 'progressive',

          // the magic
          responsive: [{

              breakpoint: 1024,
              settings: {
                  slidesToShow: 1,
                  infinite: false
              }

          }, {

              breakpoint: 600,
              settings: {
                  slidesToShow: 1,
                  dots: false
              }

          }, {

              breakpoint: 300,
              settings: "unslick" // destroys slick

          }]
      });
  }
}
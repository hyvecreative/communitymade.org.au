'use strict';
import $ from 'jquery';
import slick from 'slick-carousel';

export default class Carousel {
  constructor() {
  }

  init() {
      $(".logo-slider").slick({

          // normal options...
          slidesToShow: 6,
          slidesToScroll: 1,
          autoplay: true,
          autoplaySpeed: 5000,
          infinite: true,
          accessibility: true,
          speed: 1000,

          // the magic
          responsive: [{

              breakpoint: 992,
              settings: {
                  slidesToShow: 2,
                  infinite: true
              }

          }, {

              breakpoint: 300,
              settings: "unslick" // destroys slick

          }]
      });
  }
}
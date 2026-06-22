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

              breakpoint: 1200,
              settings: {
                  slidesToShow: 1,
                  infinite: false,
                  variableWidth: true,
                    variableHeight: true,
                    adaptiveHeight: true,
                    // Custom settings for this breakpoint
                    onInit: function(slider) {
                        $(slider.$slider).height(800); // Set height to 500px for this breakpoint
                    },
                    onSetPosition: function(slider) {
                        $(slider.$slider).height(800); // Maintain height on resize
                    }
                }

          }, {

              breakpoint: 992,
              settings: {
                  slidesToShow: 1,
                  dots: false,
                  variableWidth: true,
                    variableHeight: true,
                    adaptiveHeight: true,
                    // Custom settings for this breakpoint
                    onInit: function(slider) {
                        $(slider.$slider).height(700); // Set height to 400px for this breakpoint
                    },
                    onSetPosition: function(slider) {
                        $(slider.$slider).height(700); // Maintain height on resize
                    }
              }

          }, {

              breakpoint: 320,
              settings: {
                  slidesToShow: 1,
                  dots: false,
                  variableWidth: true,
                    variableHeight: true,
                    adaptiveHeight: true,
                    // Custom settings for this breakpoint
                    onInit: function(slider) {
                        $(slider.$slider).height(400); // Set height to 400px for this breakpoint
                    },
                    onSetPosition: function(slider) {
                        $(slider.$slider).height(400); // Maintain height on resize
                    }
              }

          }, {

              breakpoint: 301,
              settings: {
                  slidesToShow: 1,
                  dots: false,
                  variableWidth: true,
                    variableHeight: true,
                    adaptiveHeight: true,
                    // Custom settings for this breakpoint
                    onInit: function(slider) {
                        $(slider.$slider).height(280); // Set height to 400px for this breakpoint
                    },
                    onSetPosition: function(slider) {
                        $(slider.$slider).height(280); // Maintain height on resize
                    }
              }

          }, {

              breakpoint: 300,
              settings: "unslick" // destroys slick

          }]
      });
  }
}
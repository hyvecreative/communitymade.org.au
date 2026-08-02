'use strict';
import $ from 'jquery';
import 'slick-carousel';

export default class Carousel {
  init() {
    const $slider = $('.hero-slider');
    if (!$slider.length || $slider.hasClass('slick-initialized')) return;

    $slider.slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      infinite: true,
      accessibility: true,
      speed: 1000,
      cssEase: 'linear',
      arrows: false,
      dots: true,
    });

    // Re-measure as images finish loading (the cold-load mobile fix)
    $slider.find('img').each(function () {
      if (this.complete) return;
      $(this).one('load', () => $slider.slick('setPosition'));
    });

    $(window).one('load', () => $slider.slick('setPosition'));
  }
}
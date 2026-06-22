import $ from 'jquery';
import './style.scss';
import HeaderSearch from './js/components/header-search';
import Carousel from './js/components/carousel';
import matchHeight from 'jquery-match-height';
import Masonry from 'masonry-layout';
import imagesLoaded from 'imagesloaded';

$(() => {

  const headerSearch = new HeaderSearch();
  headerSearch.init();

  const carousel = new Carousel();
  carousel.init();

  // Match height
  $('.sub-navs').matchHeight('true');
  $('.fiveitem').matchHeight('true');
  $('.support-opt-wrap').matchHeight({target: $('.support-opt')});

  const $grid = $('.grid');

  if ($grid.length) {

    const gridMasonry = new Masonry('.grid', {
      // set itemSelector so .grid-sizer is not used in layout
      itemSelector: '.grid-item',
      // use element for option
      percentPosition: true,
      // columnWidth: '.grid-sizer'
    });

    // layout Masonry after each image loads
    imagesLoaded.makeJQueryPlugin( $ );
    $grid.imagesLoaded(function() {
      gridMasonry.layout();
    });
  }

  // Donate
  $('.donate-main label').click(function() {
    $(this).parent('li').parent('ul').children().removeClass('donate-active');
    $(this).parent('li').addClass('donate-active');
  });
});


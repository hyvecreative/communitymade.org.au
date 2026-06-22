import $ from 'jquery';
import './style.scss';
import HeaderSearch from './js/components/header-search';
import Carousel from './js/components/carousel';
import MenuToggle from './js/components/menu-toggle';
import Dropdown from './js/components/dropdown';
import simpleParallax from 'simple-parallax-js';

$(() => {

  const headerSearch = new HeaderSearch();
  headerSearch.init();

  const carousel = new Carousel();
  carousel.init();
	
  console.log(simpleParallax);
	
	var image = document.getElementsByClassName('thumbnail');
	new simpleParallax(image, {
	scale: 1.4,
	delay: .3,
	transition: 'cubic-bezier(0,0,0,1)'
	});

});


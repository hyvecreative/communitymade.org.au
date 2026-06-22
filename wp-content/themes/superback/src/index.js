import './style.scss';
import HeaderSearch from './js/components/header-search';
import Carousel from './js/components/carousel';
import MenuToggle from './js/components/menu-toggle';
import Dropdown from './js/components/dropdown';

$(() => {

  const headerSearch = new HeaderSearch();
  headerSearch.init();

  const carousel = new Carousel();
  carousel.init();

});


import './style.scss';
import HeaderSearch from './js/components/header-search';
import Carousel from './js/components/carousel';
import MenuToggle from './js/components/menu-toggle';
import Dropdown from './js/components/dropdown';

$(() => {
  [
    () => new HeaderSearch().init(),
    () => new Carousel().init(),
    // add MenuToggle, Dropdown etc. here too if they're initialized
  ].forEach((init) => {
    try {
      init();
    } catch (e) {
      console.error('Component init failed:', e);
    }
  });
});


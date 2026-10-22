import $ from 'jquery';

import './style.scss';

import HeaderSearch from './js/components/header-search';
import Carousel from './js/components/carousel';

// These two attach their own handlers on load rather than exporting a class,
// so they are imported for their side effects only.
import './js/components/menu-toggle';
import './js/components/dropdown';

$(() => {
  [() => new HeaderSearch().init(), () => new Carousel().init()].forEach((init) => {
    try {
      init();
    } catch (e) {
      console.error('Component init failed:', e);
    }
  });
});

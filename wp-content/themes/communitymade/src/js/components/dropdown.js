/**
 * Dropdown
 *
 * Mobile-only: first tap on a parent menu item opens its submenu instead of
 * following the link. Desktop (>=1025px) keeps the link behaviour.
 */

import $ from 'jquery';

$(() => {
  $('.menu-item-has-children > a').on('click', function (e) {
    const $this = $(this);

    if ($(window).width() < 1025) {
      if (!$this.closest('li').hasClass('isOpen')) {
        e.preventDefault();

        $this
          .next()
          .slideDown()
          .closest('li')
          .addClass('isOpen')
          .siblings()
          .removeClass('isOpen')
          .find('ul')
          .slideUp();
      }
    }
  });
});

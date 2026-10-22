/**
 * Menu Toggle
 *
 * Hamburger button: toggles the button, the nav panel and a body class
 * (used to lock scrolling while the menu is open).
 */

import $ from 'jquery';

$(() => {
  $('.js-toggle').on('click', function () {
    $(this).toggleClass('is-active');
    $('.header__nav').toggleClass('is-active');
    $('body').toggleClass('is-active');
  });
});

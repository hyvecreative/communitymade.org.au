/**
 * Menu Toggle
**/


$('.js-toggle').on('click', function() {

	$(this).toggleClass('is-active');

	$('.header__nav').toggleClass('is-active');

	$('body').toggleClass('is-active');
})

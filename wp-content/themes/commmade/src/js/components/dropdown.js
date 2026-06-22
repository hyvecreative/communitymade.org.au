/**
 * Dropdown
**/

$('.menu-item-has-children > a').on('click', function(e){
	let $this = $(this);

	if( $(window).width() < 1025 ){
		if( !$this.closest('li').hasClass('isOpen') ){
			e.preventDefault();

			$this.next().slideDown().closest('li').addClass('isOpen').siblings().removeClass('isOpen').find('ul').slideUp();
		}
	}
})

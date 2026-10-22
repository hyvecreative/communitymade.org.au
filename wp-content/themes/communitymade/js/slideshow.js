function slideSwitch(switchSpeed) {
    var $active = $('#slideshow div.active');
    
    if ( $active.length == 0 ) $active = $('#slideshow div:last');

    var $next =  $active.next('div').length ? $active.next('div')
        : $('#slideshow div:first');

    $active.addClass('last-active');
    
    
    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, switchSpeed, function() {
            $active.removeClass('active last-active');
        });
}

$(function() {
    setInterval ( "slideSwitch(1000)", 6000 );    
});
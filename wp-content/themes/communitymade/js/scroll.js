(function($) {
    $(document).ready(function() {
        $('.hm-down-arrow').on('click touchstart', function () {
            $.scrollTo('.intro-text-wrapper', {
                duration: 800,
                axis: 'y',
                easing: 'easeOutQuad'
            });
        });
        
        $('.scroll-down-action').on('click touchstart', function () {
            $.scrollTo('.action-form', {
                duration: 800,
                axis: 'y',
                easing: 'easeOutQuad'
            });
        });
        
        $(window).scroll(function() {
            if ($(window).scrollTop() > 150)
                $('#scroll-to-top').addClass('displayed');
            else
                $('#scroll-to-top').removeClass('displayed');
        });
        
        $('#scroll-to-top').click(function() {
            $('html, body').animate({ scrollTop: '0px' });
            return false;
        });
    });
})(jQuery);



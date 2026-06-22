$(document).ready(function(){
  
jQuery('.scroll-down-arrow').on('click touchstart', function () {
   //optionally remove the 500 (which is time in milliseconds) of the
   //scrolling animation to remove the animation and make it instant
   
   jQuery.scrollTo('div.stats-panel', 800, {axis:'y'});
   
});

    jQuery('.hero-scroll').on('click touchstart', function () {
        //optionally remove the 500 (which is time in milliseconds) of the
        //scrolling animation to remove the animation and make it instant

        jQuery.scrollTo('#content', 800, {axis:'y'});

    });

    jQuery('.petition-action').on('click touchstart', function () {
        //optionally remove the 500 (which is time in milliseconds) of the
        //scrolling animation to remove the animation and make it instant

        jQuery.scrollTo('.action-form', 1200, {axis:'y'});

    });
	
	jQuery('.sub-nav-3').on('click touchstart', function () {
        //optionally remove the 500 (which is time in milliseconds) of the
        //scrolling animation to remove the animation and make it instant

        jQuery.scrollTo('#projects', 1200, {axis:'y'});

    });
	
	jQuery('.sub-nav-4').on('click touchstart', function () {
        //optionally remove the 500 (which is time in milliseconds) of the
        //scrolling animation to remove the animation and make it instant

        jQuery.scrollTo('#research', 1200, {axis:'y'});

    });


jQuery(function($){{$(window).scroll(function(){if($(window).scrollTop()>150)$('#scroll-to-top').addClass('displayed');else $('#scroll-to-top').removeClass('displayed');});$('#scroll-to-top').click(function(){$("html, body").animate({scrollTop:"0px"});return false;});}

});
	

	
	
});


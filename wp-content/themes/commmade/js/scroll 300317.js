
  
jQuery('.blackbox a.btn').on('click touchstart', function () {
   //optionally remove the 500 (which is time in milliseconds) of the
   //scrolling animation to remove the animation and make it instant
   
   jQuery.scrollTo('div.project-icons', 800, {axis:'y'});
   
});

jQuery('.btn.navy').on('click touchstart', function () {
   //optionally remove the 500 (which is time in milliseconds) of the
   //scrolling animation to remove the animation and make it instant
   
   jQuery.scrollTo('.form-box', 800, {axis:'y'});
   
});

jQuery('.txt-wrap .white').on('click touchstart', function () {
   //optionally remove the 500 (which is time in milliseconds) of the
   //scrolling animation to remove the animation and make it instant
   
   jQuery.scrollTo('.form-box', 800, {axis:'y'});
   
});

jQuery('.menu-item-321').on('click touchstart', function () {
   //optionally remove the 500 (which is time in milliseconds) of the
   //scrolling animation to remove the animation and make it instant
   
   jQuery.scrollTo('.form-box', 800, {axis:'y'});
	
	jQuery('.flexmenu.fm-offcanvas.fm-sm').css('left', '-70%');
	jQuery('.fm-inner').css('left', '0');
	
	
});
  

jQuery(function($){{$(window).scroll(function(){if($(window).scrollTop()>150)$('#scroll-to-top').addClass('displayed');else $('#scroll-to-top').removeClass('displayed');});$('#scroll-to-top').click(function(){$("html, body").animate({scrollTop:"0px"});return false;});}

});

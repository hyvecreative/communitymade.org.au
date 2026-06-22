jQuery(document).ready(function($){
    $('.bxslider').bxSlider({
        auto: true,
        controls: false,
        pager: false
    });

    $(".toggle").click(function(){
        $("nav").slideToggle();
    });

    $(".video").click(function(){
        $(".screen-one .button").toggle();
    });

    $('.myVideo').parent().click(function () {
    if($(this).children(".myVideo").get(0).paused){
        $(this).children(".myVideo").get(0).play();
        $(this).children(".play").css("opacity", 0);
        $(".screen-one h2").css("opacity", 0);
    }else{
       $(this).children(".myVideo").get(0).pause();
       $(this).children(".play").css("opacity", 1);
       $(".screen-one h2").css("opacity", 1);
    }
});
    
var video= $('.myVideo')[0]; 
var videoJ= $('.myVideo');        
videoJ.on('ended',function(){
    video.load();     
    $('.play').attr('style', 'opacity: 1 !important');
    $(".screen-one h2").css("opacity", 1);
});


    $.each($(".slide"), function(index, value){
            var num = index + 1;
            $(value).attr("data-anchor","slide"+ num);
        });
});
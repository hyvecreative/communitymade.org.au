
$('.play-pause-button').click(function () {
   if ($(".myVideo").get(0).paused) {
       $(".myVideo").get(0).play();
       $(".play").css("opacity", 0);
       $(".play-pause-button h2").css("opacity", 0);
       $(".play-pause-button h3").css("opacity", 0);
       $(".btn").css("opacity", 0);
   } else {
       $(".myVideo").get(0).pause();
       $(".play").css("opacity", 1);
       $(".play-pause-button h2").css("opacity", 1);
       $(".play-pause-button h3").css("opacity", 1);
       $(".btn").css("opacity", 1);
  }
});


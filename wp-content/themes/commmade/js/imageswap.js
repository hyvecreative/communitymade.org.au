	$(function(){
		
			$("#dir2-button").css({
				opacity: 0.3
			});
			$("#dir3-button").css({
				opacity: 0.3
			});
			$("#dir4-button").css({
				opacity: 0.3
			});
			$("#AA-button").css({
				opacity: 0.3
			});
			$("#BB-button").css({
				opacity: 0.3
			});
			$("#CC-button").css({
				opacity: 0.3
			});
			$("#DD-button").css({
				opacity: 0.3
			});
			$("#EE-button").css({
				opacity: 0.3
			});
			$("#FF-button").css({
				opacity: 0.3
			});
			$("#GG-button").css({
				opacity: 0.3
			});
			$("#HH-button").css({
				opacity: 0.3
			});
			$("#II-button").css({
				opacity: 0.3
			});
			$("#JJ-button").css({
				opacity: 0.3
			});
			$("#KK-button").css({
				opacity: 0.3
			});
			$("#LL-button").css({
				opacity: 0.3
			});
			$("#MM-button").css({
				opacity: 0.3
			});
			$("#NN-button").css({
				opacity: 0.3
			});
			$("#OO-button").css({
				opacity: 0.3
			});
			$("#PP-button").css({
				opacity: 0.3
			});
			$("#QQ-button").css({
				opacity: 0.3
			});
			$("#RR-button").css({
				opacity: 0.3
			});
			$("#SS-button").css({
				opacity: 0.3
			});
			
		
            $("#page-wrap div.button").click(function(){
            	
            	$clicked = $(this);
            	
            	// if the button is not already "transformed" AND is not animated
            	if ($clicked.css("opacity") != "1" && $clicked.is(":not(animated)")) {
            		
            		$clicked.animate({
            			opacity: 1,
            			borderWidth: 5
            		}, 600 );
            		
            		// each button div MUST have a "xx-button" and the target div must have an id "xx" 
            		var idToLoad = $clicked.attr("id").split('-');
            		
            		//we search trough the content for the visible div and we fade it out
            		$("#contentpeople").find("div:visible").fadeOut("fast", function(){
            			//once the fade out is completed, we start to fade in the right div
            			$(this).parent().find("#"+idToLoad[0]).fadeIn();
            		})
            	}
            	
            	//we reset the other buttons to default style
            	$clicked.siblings(".button").animate({
            		opacity: 0.5,
            		borderWidth: 1
            	}, 600 );
            	
            });
		});
jQuery(document).ready(function($){

	var parentwidth = $(".summary").width();
	$("#small-summary").width(parentwidth);

	// Add reveal class to sticky message after 129px
	$(document).on("scroll", function(){

		if($(document).scrollTop() > 350){

			$("#small-summary").addClass("scroll");

		} else {

			$("#small-summary").removeClass("scroll");

		}


	});


	$(window).scroll(function () {

		// distance from top of footer to top of document
		footertotop = ($('#stop-summary').position().top);
		// distance user has scrolled from top, adjusted to take in height of sidebar (570 pixels inc. padding)
		scrolltop = $(document).scrollTop()+50;
		// difference between the two
		difference = scrolltop-footertotop;

		// if user has scrolled further than footer,
		// pull sidebar up using a negative margin

		if (scrolltop > footertotop) {

		$('#small-summary').css('margin-top',  0-difference);
		}

		else  {
		$('#small-summary').css('margin-top', 0);
		}

	});
	
});

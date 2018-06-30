jQuery(document).ready(function($){

	$(".no-animated").zIndex(89);

	var parentwidth = $(".summary").width();
	$("#small-summary").width(parentwidth);

	var headerHeight = $(".site-header").height();
	$("#page-header").height(headerHeight);

	var selectHeight = $("table.variations").height();
	$(".tc-extra-product-options").height(selectHeight);

	// Add reveal class to sticky message after 129px
	$(document).on("scroll", function(){

		if($(document).scrollTop() > 35){

			$("#small-summary").addClass("scroll");

		} else {

			$("#small-summary").removeClass("scroll");

		}

	});

	$( window ).resize(function() {
		var headerHeight = $(".site-header").height();
	    $("#page-header").height(headerHeight);

	    var parentwidth = $(".summary").width();
  	    $("#small-summary").width(parentwidth);

	    var galleryWidth = $(".woocommerce-product-gallery").width();
  	    $(".woocommerce-product-gallery img").width(galleryWidth);
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

		if (scrolltop > footertotop-350) {

		$('#small-summary').css('margin-top',  0-difference-350);
		}

		else  {
		$('#small-summary').css('margin-top', 0);
		}

	});

});

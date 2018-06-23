jQuery(document).ready(function($){

	// if only one product is present, avoid ul products to collapse on product hover

	var productsCount = $('.product-loop-wrap').length;

	if ( productsCount == 1 ) {
		var ulHeight = $("ul.products").height();
		$('ul.products').css("height", ulHeight);
		$( window ).resize(function() {
			var resHeight = $("li.product").height();
			$('ul.products').css("height", resHeight);
		});
	}

});

<?php
/**
 * This template displays the Product Category and Tag taxonomy term archives
 *
 */


/** Remove default Genesis loop */
remove_action( 'genesis_loop', 'genesis_do_loop' );

/** Remove Genesis archive title/description */
remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );

/** Remove WooCommerce breadcrumbs */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/** Uncomment the below line of code to add back WooCommerce breadcrumbs */
//add_action( 'genesis_before_loop', 'woocommerce_breadcrumb', 10, 0 );

/** Remove Woo #container and #content divs */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/* Add divs for hover fx */
add_action('woocommerce_before_shop_loop_item', 'ap_product_wrap', 5);
function ap_product_wrap() {
	echo "<div class='product-loop-wrap'>";
}
add_action('woocommerce_shop_loop_item_title', 'ap_product_loop_details_opening', 5);
function ap_product_loop_details_opening() {
	echo "<div class='product-loop-details'>";
}
add_action('woocommerce_after_shop_loop_item', 'ap_product_loop_details_opening', 90);
function ap_product_loop_details_closing() {
	echo "</div'></div>";
}

add_action( 'genesis_loop', 'genesiswooc_product_taxonomy_loop' );
/**
 * Displays shop items for the queried taxonomy term
 *
 * This function has been refactored in 0.9.4 to provide compatibility with
 * both WooC 1.6.0 and backwards compatibility with older versions.
 * This is needed thanks to substantial changes to WooC template contents
 * introduced in WooC 1.6.0.
 *
 * @uses genesiswooc_content_product() if WooC is version 1.6.0+
 * @uses genesiswooc_product_taxonomy() for earlier WooC versions
 *
 * @since 0.9.0
 * @updated 0.9.4
 */
function genesiswooc_product_taxonomy_loop() {

	global $woocommerce;

	$new = version_compare( $woocommerce->version, '1.6.0', '>=' );

	if ( $new )
		genesiswooc_content_product();

	else
		genesiswooc_product_taxonomy();

}

genesis();

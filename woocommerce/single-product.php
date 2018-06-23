<?php
/**
 * This template displays the single Product
 *
 */

/** Remove default Genesis loop */
remove_action( 'genesis_loop', 'genesis_do_loop' );

/** Remove WooCommerce breadcrumbs */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/** Uncomment the below line of code to add back WooCommerce breadcrumbs */
//add_action( 'genesis_before_loop', 'woocommerce_breadcrumb', 10, 0 );

/** Remove Woo #container and #content divs */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/** Custom FlexSlider Navigation **/
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
// Update WooCommerce Flexslider options

add_filter( 'woocommerce_single_product_carousel_options', 'ap_update_woo_flexslider_options' );

function ap_update_woo_flexslider_options( $options ) {
	/* properties here: https://github.com/woocommerce/FlexSlider/wiki/FlexSlider-Properties */
    $options['directionNav'] = true;
    $options['controlNav'] = false;
    $options['touch'] = true;

    return $options;
}

/** Enqueue JS scripts */
add_action( 'wp_enqueue_scripts', 'ap_sticky_small_summary' );
function ap_sticky_small_summary() {
	wp_enqueue_script( 'sticky-summary', get_bloginfo( 'stylesheet_directory' ) . '/assets/scripts/min/sticky-summary.min.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script( 'div-toggle', get_bloginfo( 'stylesheet_directory' ) . '/assets/scripts/min/div-toggle.min.js', array( 'jquery' ), '1.0.1' );
}

// Product summary tweaks

add_action('woocommerce_single_product_summary', 'ap_small_summary_open_div', 4);
function ap_small_summary_open_div() {
    echo '<div id="small-summary">';
}

remove_action( 'business_page_header', 'business_page_title', 10 );
add_action( 'woocommerce_single_product_summary', 'genesis_do_post_title', 5 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

add_action('woocommerce_single_product_summary', 'ap_small_summary_close_div', 51);
function ap_small_summary_close_div() {
	// echo '<a data-rel="prettyPhoto" href="#single-product-reviews">';
	// woocommerce_template_single_rating();
	// echo '</a>';
    echo '</div>';
}

/**
 * Remove existing tabs from single product pages.
 */
function ap_remove_woocommerce_product_tabs( $tabs ) {
	unset( $tabs['description'] );
	unset( $tabs['reviews'] );
	unset( $tabs['additional_information'] );
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'ap_remove_woocommerce_product_tabs', 98 );
/**
 * Hook in each tabs callback function after single content.
 */
add_action( 'woocommerce_after_single_product_summary', 'ap_custom_woocommerce_product_description_tab' );
/*add_action( 'woocommerce_after_single_product_summary', 'ap_custom_comments_template' );*/
function ap_custom_woocommerce_product_description_tab() {
	echo '<div id="stop-summary" style="width:100%;display:block;float:left;clear:both;"></div>';
	echo '<div class="single-product-additional-info">';
		echo '<div class="option-heading"><h2>'; _e('Product Description', 'business-pro'); echo'</h2><div class="arrow-up">+</div><div class="arrow-down">-</div></div><div class="option-content-first">';
			echo '<div id="single-product-description">';
				woocommerce_product_description_tab();
			echo '</div>';
		echo '</div>';

        global $product;
	    if( $product->has_attributes() || $product->has_dimensions() || $product->has_weight() ) {
    		echo '<div class="option-heading"><h2>'; _e('Additional Info', 'business-pro'); echo'</h2><div class="arrow-up">-</div><div class="arrow-down">+</div></div><div class="option-content">';
    			echo '<div id="single-product-description">';
    				woocommerce_product_additional_information_tab();
    			echo '</div>';
    		echo '</div>';
        }
	echo '</div>';
}

/** Remove quantity inputs in single products */
function ap_remove_all_quantity_fields( $return, $product ) {
    return true;
}
add_filter( 'woocommerce_is_sold_individually', 'ap_remove_all_quantity_fields', 10, 2 );


add_action( 'genesis_loop', 'gencwooc_single_product_loop' );
/**
 * Displays single product loop
 *
 * Uses WooCommerce structure and contains all existing WooCommerce hooks
 *
 * Code based on WooCommerce 1.5.5 woocommerce_single_product_content()
 * @see woocommerce/woocommerce-template.php
 *
 * @since 0.9.0
 */
function gencwooc_single_product_loop() {

	do_action( 'woocommerce_before_main_content' );

	// Let developers override the query used, in case they want to use this function for their own loop/wp_query
	$wc_query = false;

	// Added a hook for developers in case they need to modify the query
	$wc_query = apply_filters( 'gencwooc_custom_query', $wc_query );

	if ( ! $wc_query) {

		global $wp_query;

		$wc_query = $wp_query;
	}

	if ( $wc_query->have_posts() ) while ( $wc_query->have_posts() ) : $wc_query->the_post(); ?>

		<?php do_action('woocommerce_before_single_product'); ?>

		<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php do_action( 'woocommerce_before_single_product_summary' ); ?>

			<div class="summary">

				<?php do_action( 'woocommerce_single_product_summary'); ?>

			</div>

			<?php do_action( 'woocommerce_after_single_product_summary' ); ?>

		</div>

		<?php do_action( 'woocommerce_after_single_product' );

	endwhile;

	do_action( 'woocommerce_after_main_content' );
}

genesis();

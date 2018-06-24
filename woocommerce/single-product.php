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

/** Change Option select placehoòder to group name (i.e. size) */
add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'ap_filter_dropdown_args', 10 );
function ap_filter_dropdown_args( $args ) {
    $variation_tax = get_taxonomy( $args['attribute'] );
    $name = wc_sanitize_taxonomy_name( str_replace( 'pa_', '', $variation_tax->name ) );
    $args['show_option_none'] = apply_filters( 'the_title', ucfirst($name) );
    return $args;
}

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

add_action('woocommerce_single_product_summary', 'ap_summary_shipping_info', 30);
function ap_summary_shipping_info() {
		?>
        <div class="go-to-details">
            <a href="#product-details" class="go-to-details--link" title="View Product Details">Product Details <i class="fa fa-angle-right"></i></a>
        </div>
		<div class="summary-shipping-info">
            <ul>
                <li><?php _e('Free Shipping and Returns', 'business-pro');?></li>
            </ul>
        </div>
		<?php
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
    echo '<div class="single-product-additional-info">';
    echo '<div id="product-details" style="position:absolute;top:-10rem;"></div>';
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
        echo '<div class="option-heading"><h2>'; _e('Shipping', 'business-pro'); echo'</h2><div class="arrow-up">-</div><div class="arrow-down">+</div></div><div class="option-content">';
            echo '<div id="single-product-description">';
                ?>
                <p>We charge 15€ to US, UK, EU and Canada. No extra rates will be added. We offer Express shipping with all orders. From the moment the order leaves our warehouse, we deliver in 3-4 business days.</p>
                <p>All orders are processed Monday through Saturday, excluding Sunday and holidays. US & Canadian customers will not pay any duties.</p>
                <p>From March 10, 2016 a new commercial agreement was made with the EU: orders under 800$ value will be delivered directly to you duty free.</p>
                <p>For the rest of the world we charge 25€, duties and local taxes will be charged by the appropriate authority at the destination country. Please determine these charges locally.</p>
                <?php
            echo '</div>';
        echo '</div>';
        echo '<div id="#spedizioni-resi" class="option-heading"><h2>'; _e('Returns and Exchanges', 'business-pro'); echo'</h2><div class="arrow-up">-</div><div class="arrow-down">+</div></div><div class="option-content">';
            echo '<div id="single-product-description">';
                ?>
                <p>For online purchases, Max Lemari will refund the purchase price of merchandise that is returned in its original condition and accompanied by the original invoice, original Gucci packaging and security return/exchange label intact and attached to the item. Customized products can be returned with a 20€ penalty.</p>
                <p>You must inform Max Lemari of your intention to return the merchandise within 14 days of the date of delivery by (i) directly returning the merchandise to Max Lemari; or (ii) writing your intention to info@maxlemari.com
                We are a startup and work with almost no margins on Kickstarter. If the need for an exchange arises, we will need to charge for the shipping both ways. Choose your size carefully and read our sizing guidelines.</p>
                <?php
            echo '</div>';
        echo '</div>';
        echo '<div class="option-heading"><h2>'; _e('Payment Options', 'business-pro'); echo'</h2><div class="arrow-up">-</div><div class="arrow-down">+</div></div><div class="option-content">';
            echo '<div id="single-product-description">';
                ?>
                <p>Max Lemari accepts the following forms of payment for online purchases: Visa, Mastercard, American Express and PAYPAL.</p>
                <p>For credit card payments, please note that your billing address must match the address on your credit card statement.</p>
                <p>The authorized amount will be released by your credit card’s issuing bank according to its policy.</p>
                <p>The purchase transaction will only be charged to your credit card after we have verified your card details, received credit authorization for an amount equal to the purchase price of the ordered products, confirmed product availability and prepared your order for shipping.</p>
                <?php
            echo '</div>';
        echo '</div>';
    echo '</div>';
    echo '<div id="stop-summary" style="width:100%;float:left;"></div>';
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

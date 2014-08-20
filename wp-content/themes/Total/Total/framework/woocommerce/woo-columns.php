<?php
/**
 * Alter default WooCommerce columns/pagination
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
 */


/**
	Change products per/page for the shop
**/
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '. wpex_option( 'woo_shop_posts_per_page', '12' ) .';' ), 20 );


/**
	Change number or products per row to 3
**/
add_filter('loop_shop_columns', 'wpex_loop_columns');
if (!function_exists('wpex_loop_columns')) {
	function wpex_loop_columns() {
		$columns = wpex_option( 'woocommerce_shop_columns', '3' );
		return $columns;
	}
}


/**
	Change number of related products on product page
**/
if (!function_exists('wpex_woo_related_output')) {
	function wpex_woo_related_output() {
		global $product, $orderby, $related;
		$args = array(
			'posts_per_page'	=> wpex_option( 'woocommerce_related_count', '3' ),
			'columns'			=> wpex_option( 'woocommerce_related_columns', '3' ),
		);
		return $args;
	}
}
add_filter( 'woocommerce_output_related_products_args', 'wpex_woo_related_output' );


/**
	Remove Woo Related if count equals 0
**/
if ( '0' == wpex_option( 'woocommerce_related_count', '3' ) ) {
	function wpex_woocommerce_remove_related_products(){
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
	}
	add_action('woocommerce_after_single_product_summary', 'wpex_woocommerce_remove_related_products');
}


/**
	Single Product Up-Sells
**/
if ( ! function_exists( 'wpex_woocommerce_output_upsells' ) ) {
	function wpex_woocommerce_output_upsells() {
		woocommerce_upsell_display( wpex_option( 'woocommerce_upsells_count', '3' ), wpex_option( 'woocommerce_upsells_columns', '3' ) );
	}
}
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
if ( '0' != wpex_option( 'woocommerce_upsells_count', '3' ) ) {
	add_action( 'woocommerce_after_single_product_summary', 'wpex_woocommerce_output_upsells', 15 );
}


/**
	Cart Up-Sells
**/
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
//add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );
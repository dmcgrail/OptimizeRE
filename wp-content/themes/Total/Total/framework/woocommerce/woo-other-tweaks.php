<?php
/**
 * Other Fun WooCommerce Tweaks
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
 */


// Remove woo page title from shop
if ( !function_exists( 'wpex_remove_woo_shop_title' ) ) {
	function wpex_remove_woo_shop_title() {
		if ( is_shop() && is_singular('product') ) {
			return false;
		}
	}
}
add_filter('woocommerce_show_page_title', 'wpex_remove_woo_shop_title');


// Remove Product Meta
if ( !wpex_option( 'woo_product_meta', '1' ) ) {
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
}


// Change onsale text
if ( !function_exists( 'wpex_custom_sale_flash' ) ) {
	function wpex_custom_sale_flash($text, $post, $_product) {
		return '<span class="onsale">'. __( 'Sale', 'wpex' ) .'</span>';
	}
}
add_filter( 'woocommerce_sale_flash', 'wpex_custom_sale_flash', 10, 3 );


// Display First category
if ( !function_exists( 'wpex_get_woo_product_first_cat' ) ) {
	function wpex_get_woo_product_first_cat() {
		// Display first product category
		$wpex_product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
			if ( $wpex_product_cats && ! is_wp_error ( $wpex_product_cats ) ) {
			$wpex_first_product_cat = array_shift( $wpex_product_cats );
			return $wpex_first_product_cat->name;
		}
	}
}

// Check if product is in stock
if ( !function_exists( 'wpex_woo_product_instock' ) ) {
	function wpex_woo_product_instock( $id = '' ) {
		global $post;
		$post_id = $id ? $id : $post->ID;
		$stock_status = get_post_meta( $post_id, '_stock_status', true );
		if ( 'instock' == $stock_status ) {
			return true;
		} else {
			return false;
		}
	}
}

// Remove term descriptions
if ( !function_exists( 'woocommerce_taxonomy_archive_description' ) ) {
	function woocommerce_taxonomy_archive_description(){
		return false;
	}
}
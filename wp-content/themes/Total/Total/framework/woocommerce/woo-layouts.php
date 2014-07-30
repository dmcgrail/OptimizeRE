<?php
/**
 * USeful functions for latering the WooCommerce layouts
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
 */


// Add classes for the various layouts - with sidebar, without sidebar, full-width
if (!function_exists('wpex_woo_layout_class')) {
	
	function wpex_woo_layout_class() {
		
		$woo_shop_layout = wpex_option( 'woo_shop_layout', 'full-width' );
		$woo_product_layout = wpex_option( 'woo_product_layout', 'full-width' );
		
		$classes=array();
		
		// Main Shop & archives
		if ( is_shop() || is_product_category() || is_product_tag() ) {
			$classes[] = $woo_shop_layout;
		}
		
		// Single Products
		if ( is_singular( 'product' ) ) {
			global $post;
			$meta = get_post_meta( $post->ID, 'wpex_post_layout', true );
			if ( '' != $meta ) {
				$classes[] = $meta;
			} else {
				$classes[] = $woo_product_layout;
			}
		}
		
		// Filter for devs
		$classes = apply_filters( 'wpex_woo_wrap_classes', $classes );
		
		// Ninja work
		$classes = implode( " ", $classes );
		
		// Return classes
		return $classes;
		
	} // End function
	
} // End if



// Function to return sidebar on woo pages when needed
if (!function_exists('wpex_woo_sidebar')) {
	
	function wpex_woo_sidebar() {
		
		// Get current class
		$class = wpex_woo_layout_class();
		
		// Return true or false
		if ( $class == 'right-sidebar' || $class == 'left-sidebar') {
			return true;
		} else {
			return false;
		}
		
	} // End function
	
} // End if
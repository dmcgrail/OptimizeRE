<?php
/**
 * Returns the correct sidebar region
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/


if ( ! function_exists( 'wpex_get_sidebar' ) ) {
	function wpex_get_sidebar( $sidebar='sidebar' ) {

		// Pages
		if ( is_page() && wpex_option( 'pages_custom_sidebar', '1' ) ) {
			if ( !is_page_template('templates/blog.php') ) {
				$sidebar = 'pages_sidebar';
			}
		}

		// Search
		if ( is_search() && wpex_option( 'search_custom_sidebar', '1' ) ) {
			$sidebar = 'search_sidebar';
		}
		
		// Custom Post Types
		$post_types = wpex_active_post_types();
		foreach ( $post_types as $post_type ) {
			if ( is_singular( $post_type ) || is_tax( $post_type .'_category' ) || is_tax( $post_type .'_tag' ) ) {
				if ( wpex_option( $post_type .'_custom_sidebar', '1' ) ) {
					$sidebar = $post_type .'_sidebar';
				}
			}
		}

		// WooCommerce
		if ( class_exists( 'Woocommerce' ) ) {
			if ( wpex_option( 'woo_custom_sidebar', '1' ) && is_woocommerce() ) {
				$sidebar = 'woo_sidebar';
			}
		}
		
		// bbPress
		if ( function_exists('is_bbpress') ) {
			if ( is_bbpress() && wpex_option( 'bbpress_custom_sidebar', '1' ) ) {
				$sidebar = 'bbpress_sidebar';
			}
		}

		// Check meta option
		if ( is_singular() ) {
			global $post;
			$sidebar_meta = get_post_meta( $post->ID, 'sidebar', true );
			if ( '' != $sidebar_meta && is_active_sidebar( $sidebar_meta ) ) {
				$sidebar = $sidebar_meta;
			}
		}
		
		// Return the correct sidebar name & add useful hook
		$sidebar = apply_filters( 'wpex_get_sidebar', $sidebar );
		return $sidebar;
		
	}
}
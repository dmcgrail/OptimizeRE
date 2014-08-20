<?php
/**
 * Adds custom classes to the header container
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.1
*/

if ( ! function_exists( 'wpex_header_classes' ) ) { 
	function wpex_header_classes() {

		// Get header style
		$header_style = wpex_get_header_style();

		// Setup classes array
		$classes = array();

		// Clearfix class
		$classes[] = 'clr';

		// Main header style
		$classes[] = 'header-'. $header_style;

		// Fixed Header
		if ( wpex_option( 'fixed_header', '1' ) && $header_style == 'one' ) {
			if ( !wp_is_mobile() ) {
				$classes[] = 'fixed-scroll';
			}
		}
		
		// Apply filters
		$classes = apply_filters( 'wpex_header_classes', $classes );

		// Echo classes as space seperated classes
		echo implode( ' ', $classes );

	}
}

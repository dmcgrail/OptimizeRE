<?php
/**
 * This file outputs all custom CSS for the theme
 * Google fonts, styling, layouts...etc.
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

if ( !function_exists( 'wpex_output_css' ) ) {
	function wpex_output_css() {
	
		// Set output Var
		$output = '';

		// Custom Layouts
		$output .= wpex_layout_css();

		// Site Background
		$output .= wpex_site_background();

		// Per Page Backgrounds = After main background
		$output .= wpex_page_backgrounds();

		// Typography
		$output .= wpex_typography( 'css' );

		// Styling settings
		$output .= wpex_styling_css();

		// Responsive Widths
		$output .= wpex_responsive_widths();

		// Custom CSS option
		// Call Last to make sure it overrides things
		$output .= wpex_custom_css();

		// Fix for Fonts In the Visual Composer
		$output .='.wpb_row .fa:before { box-sizing: content-box !important; -moz-box-sizing: content-box !important; -webkit-box-sizing: content-box !important; }';

		// Output CSS in WP_Head
		if ( $output ) {
			$output = "<!-- TOTAL CSS -->\n<style type=\"text/css\">\n" . $output . "\n</style>";
			echo $output;
		}

	}
}
add_action( 'wp_head', 'wpex_output_css' );
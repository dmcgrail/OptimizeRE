<?php
/**
 * Gaps Skin Class
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.3
*/

if ( !class_exists( "Total_Gaps_Skin" ) ) {
	class Total_Gaps_Skin {
		
		// Constructor
		function __construct() {
			add_action( 'wp_enqueue_scripts', array( &$this, 'load_styles') );
		}

		// Load Styles
		public function load_styles() {
			if ( wp_script_is( 'wpex-woocommerce', 'enqueued' ) ) {
				wp_enqueue_style( 'gaps-skin', WPEX_SKIN_DIR_URI .'/gaps/gaps-style.css', array( 'wpex-style', 'wpex-woocommerce' ), '1.0', 'all' );
			} else {
				wp_enqueue_style( 'gaps-skin', WPEX_SKIN_DIR_URI .'/gaps/gaps-style.css', array( 'wpex-style' ), '1.0', 'all' );
			}
		}

	}
}
$wpex_skin_class = new Total_Gaps_Skin();

/**
 * Override core functions
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.5
*/

// Remove nav from the header
if ( ! function_exists( 'wpex_hook_header_bottom_default' ) ) {
	function wpex_hook_header_bottom_default() {
		return;
	}
}

// Add menu for header styles 2 or 3 before the main content
if ( ! function_exists( 'wpex_hook_main_before_default' ) ) {
	function wpex_hook_main_before_default() {
		$header_style = wpex_get_header_style();
		if ( $header_style == 'two' || $header_style == 'three' ) {
			// Above menu slider
			if ( 'above_menu' == wpex_post_slider_position() ) {
				wpex_post_slider();
			}
			wpex_header_menu();
		}
	}
}
add_action( 'wpex_hook_main_before', 'wpex_hook_main_before_default' );
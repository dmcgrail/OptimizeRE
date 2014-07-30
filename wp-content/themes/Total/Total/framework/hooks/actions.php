<?php
/**
 * Adds theme functions to hooks
 *
 * The following functions run certain functions in their corresponding hooks.
 * For example the header logo runs in the wpex_hook_header_inner hook.
 * You can copy and paste any of these functions into your child theme to change the
 * order of the displayed elements or remove any - have fun!
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.1
*/

/**
 * Adds actions for theme filters
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 * @return string
*/
add_action( 'wpex_hook_header_before', 'wpex_hook_header_before_default' );
add_action( 'wpex_hook_header_inner', 'wpex_hook_header_inner_default' );
add_action( 'wpex_hook_header_bottom', 'wpex_hook_header_bottom_default' );
add_action( 'wpex_hook_main_top', 'wpex_hook_main_top_default' );
add_action( 'wpex_hook_sidebar_inner', 'wpex_hook_sidebar_inner_default' );
add_action( 'wpex_hook_footer_before', 'wpex_hook_footer_before_default' );
add_action( 'wpex_hook_footer_inner', 'wpex_hook_footer_inner_default' );
add_action( 'wpex_hook_footer_after', 'wpex_hook_footer_after_default' );
add_action( 'wpex_hook_wrap_after', 'wpex_hook_wrap_after_default' );

/**
 * Returns functions for use in the before header hook
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if( ! function_exists( 'wpex_hook_header_before_default' ) ) {
	function wpex_hook_header_before_default() {
		// Toggle Bar
		wpex_toggle_bar_btn();
		// Above top Bar slider
		if ( 'above_topbar' == wpex_post_slider_position() ) {
			wpex_post_slider();
		}
		// Top bar
		wpex_top_bar();
		// Above header slider
		if ( 'above_header' == wpex_post_slider_position() ) {
			wpex_post_slider();
		}
	}
}

/**
 * Returns functions for use in the inner header hook
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if( ! function_exists( 'wpex_hook_header_inner_default' ) ) {
	function wpex_hook_header_inner_default() {
		// Header logo
		wpex_header_logo();
		// Header aside content - used for styles 2/3
		wpex_header_aside();
		// Header menu for header style 1
		$header_style = wpex_get_header_style();
		if ( $header_style == 'one' ) {
			wpex_header_menu();
		}
		//Mobile menu
		wpex_mobile_menu();
	}
}

/**
 * Returns functions for use in the header bottom hook
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if( ! function_exists( 'wpex_hook_header_bottom_default' ) ) {
	function wpex_hook_header_bottom_default() {
		// Header menu for header styles 2 or 3
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

/**
 * Returns functions for use in the main top hook
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if( ! function_exists( 'wpex_hook_main_top_default' ) ) {
	function wpex_hook_main_top_default() {
		// Above title slider
		if ( 'above_title' == wpex_post_slider_position() ) {
			wpex_post_slider();
		}
		// Page title/header
		wpex_display_page_header();
		// Below title/header slider
		if ( 'below_title' == wpex_post_slider_position() ) {
			wpex_post_slider();
		}
	}
}

/**
 * Returns functions for use in the sidebar inner hook
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if( ! function_exists( 'wpex_hook_sidebar_inner_default' ) ) {
	function wpex_hook_sidebar_inner_default() {
		// Display dynamic sidebar
		// See functions/widgets/get-sidebar.php
		dynamic_sidebar( wpex_get_sidebar() );
	}
}

/**
 * Returns functions for use in the before footer hook
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if( ! function_exists( 'wpex_hook_footer_before_default' ) ) {
	function wpex_hook_footer_before_default() {
		wpex_footer_callout();
	}
}

/**
 * Returns functions for use in the footer inner hook
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if( ! function_exists( 'wpex_hook_footer_inner_default' ) ) {
	function wpex_hook_footer_inner_default() {
		wpex_footer_widgets();
	}
}

/**
 * Returns functions for use in the footer afer hook
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if( ! function_exists( 'wpex_hook_footer_after_default' ) ) {
	function wpex_hook_footer_after_default() {
		wpex_footer_bottom();
	}
}

/**
 * Returns functions for use in the wrap after hook
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if( ! function_exists( 'wpex_hook_wrap_after_default' ) ) {
	function wpex_hook_wrap_after_default() {
		wpex_toggle_bar();
	}
}
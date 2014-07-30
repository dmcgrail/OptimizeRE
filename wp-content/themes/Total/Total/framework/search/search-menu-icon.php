<?php
/**
 * Ads a search icon in the header
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.1
*/




if ( !function_exists( 'wpex_add_search_to_menu' ) ) {

	function wpex_add_search_to_menu ( $items, $args ) {

		// Custom menu, bail
		if ( wpex_custom_menu() ) return $items;

		// Menu search disabled
		if ( !wpex_search_in_menu() ) return $items;
		
		// Get Search toggle style
		$toggle_style = wpex_option('main_search_toggle_style','overlay');
		
		// Add class to search icon based on search toggle style
		if ( $toggle_style == 'overlay' ) {
			$class = 'search-overlay-toggle';
		} elseif ( $toggle_style == 'drop_down' ) {
			$class = 'search-dropdown-toggle';
		} elseif ( $toggle_style == 'header_replace' ) {
			$class = 'search-header-replace-toggle';
		}

		// It's all cool so display search icon in the main_menu
		if ( 'main_menu' == $args->theme_location ) {
			$items .= '<li class="search-toggle-li"><a href="#" class="'. $class .' site-search-toggle"><span class="fa fa-search"></span></a></li>';
		}
		
		// Return nav $items
		return $items;

	} // End function

} // End function_exists check

add_filter( 'wp_nav_menu_items', 'wpex_add_search_to_menu', 11, 2 );
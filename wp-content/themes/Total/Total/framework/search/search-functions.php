<?php
/**
 * Core search functions
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/


// Not needed in admin
if ( is_admin() ) {
	return;
}

/**
 * Check if search icon should be in the nav
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 * @return bool
*/
if ( ! function_exists( 'wpex_search_in_menu' ) ) {
	function wpex_search_in_menu() {
		if ( !wpex_option( 'main_search', '1' ) ) {
			return false;
		}
		$header_style = wpex_option( 'header_style', 'one' );
		if ( 'two' == $header_style ) {
			return false;
		} else {
			return true;
		}
	}
}

/**
 * Adds a hidden searchbox in the footer for use with the mobile menu
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.51
*/
if ( ! function_exists( 'wpex_mobile_searchform' ) ) {
	function wpex_mobile_searchform() {
		// Make sure the mobile search is enabled for the sidr nav other wise return
		if ( function_exists( 'wpex_mobile_menu_source' ) ) {
			$sidr_elements = wpex_mobile_menu_source();
			if ( isset( $sidr_elements ) && is_array( $sidr_elements ) ) {
				if ( ! isset( $sidr_elements['search'] ) ) {
					return;
				}
			}
		}
		// Output the search
		$placeholder = apply_filters( 'wpex_mobile_searchform_placeholder', __( 'Search', 'wpex' ) ); ?>
		<div id="mobile-menu-search" class="clr">
			<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" class="mobile-menu-searchform">
				<input type="search" name="s" autocomplete="off" placeholder="<?php echo $placeholder; ?>" />
			</form>
		</div>
	<?php }
}
add_filter( 'wp_footer', 'wpex_mobile_searchform' );
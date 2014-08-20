<?php
/**
 * Scroll to top link
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.1
*/



// Outputs the scroll to top link in the footer
add_action('wp_footer','wpex_scroll_top');
if ( ! function_exists( 'wpex_scroll_top' ) ) {
	function wpex_scroll_top() {
		// If it's disabled lets bail
		if ( wpex_option( 'scroll_top', '1' ) !== '1' ) return;
		// Return the link
		echo '<a href="#" id="site-scroll-top"><span class="fa fa-chevron-up"></span></a>';
	} // End function
} // End if

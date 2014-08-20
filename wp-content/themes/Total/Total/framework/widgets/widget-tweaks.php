<?php
/**
 * Tweaks for WP widgets
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/


// Add a span around the WP categories widget count
add_filter('wp_list_categories', 'wpex_cat_count_span');
if ( ! function_exists( 'wpex_cat_count_span' ) ) {
	function wpex_cat_count_span($links) {
		$links = str_replace('</a> (', '</a> <span class="cat-count-span">(', $links);
		$links = str_replace(')', ')</span>', $links);
		return $links;
	} // End function
} // End if
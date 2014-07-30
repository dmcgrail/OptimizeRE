<?php
/**
 * Exclude blog categories from the main blog page / index
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 */

if ( ! function_exists( 'wpex_blog_exclude_categories' ) ) {
	
	function wpex_blog_exclude_categories() {
		
		// Wait..we don't want to be in these plages? Lets leave now!
		if ( is_admin() ) {
			return;
		} elseif ( is_search() ) {
			return;
		} elseif ( is_archive() ) {
			return;
		}
		
		// Categories to exclude
		$cats_to_exclude = wpex_option( 'blog_cats_exclude' );
		
		// Admin option is blank, so bail.
		if ( $cats_to_exclude == '' ) {
			return;
		}
		
		// Blog template
		if ( is_home() && !is_singular( 'page' ) ) {
			$exclude = $cats_to_exclude;
		} else {
			return;
		}

		// Alter query var
		if ( $cats_to_exclude ) {
			set_query_var( 'category__not_in', $cats_to_exclude );
		}
		
	} // End function
	
} // End if
add_action( 'pre_get_posts', 'wpex_blog_exclude_categories' );
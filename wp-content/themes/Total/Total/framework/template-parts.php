<?php
/**
 * Loads the correct file using the get_template_part function
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.40
*/


if ( ! function_exists( 'wpex_get_template_part' ) ) {
	function wpex_get_template_part( $template_part = '' ) {

		// Get Post Vars
		global $post;
		$post_id = $post->ID;
		$post_type = get_post_type( $post_id );

		// Search result
		if ( is_search() ) {
			$template_part = 'searchresult';

		// Standard Posts
		} elseif ( 'post' == $post_type ) {
			$template_part = get_post_format( $post_id );

		// Portfolio
		} elseif ( 'portfolio' == $post_type ) {
			$template_part = 'portfolio';

		// Staff
		} elseif ( 'staff' == $post_type ) {
			$template_part = 'staff';

		// Testimonials
		} elseif ( 'testimonials' == $post_type ) {
			$template_part = 'testimonials';

		// Other Post Types
		} else {
			$template_part = 'other';
		}

		// Apply filter for child editing
		apply_filters( 'wpex_get_template_part', $template_part );

		// Echo Template Part
		ob_start();
		get_template_part( 'content', $template_part );
		echo ob_get_clean();

	}
}
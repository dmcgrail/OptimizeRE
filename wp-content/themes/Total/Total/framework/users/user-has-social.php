<?php
/**
 * Check if author has any social options added
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 * @return bool
 */

if ( !function_exists( 'wpex_author_has_social' ) ) {
	function wpex_author_has_social() {
		global $post;
		if ( '' != get_the_author_meta( 'wpex_twitter', $post->post_author ) ) {
			return true;
		}
		elseif ( '' != get_the_author_meta( 'wpex_facebook', $post->post_author ) ) {
			return true;
		}
		elseif ( '' != get_the_author_meta( 'wpex_googleplus', $post->post_author ) ) {
			return true;
		}
		elseif ( '' != get_the_author_meta( 'wpex_linkedin', $post->post_author ) ) {
			return true;
		}
		elseif ( '' != get_the_author_meta( 'wpex_pinterest', $post->post_author ) ) {
			return true;
		}
		elseif ( '' != get_the_author_meta( 'wpex_instagram', $post->post_author ) ) {
			return true;
		} else {
			return false;
		}
	}
}
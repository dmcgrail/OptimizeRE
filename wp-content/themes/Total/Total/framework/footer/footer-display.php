<?php
/**
 * Function used to show/hide the main footer depending on current post meta
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/

if ( ! function_exists( 'wpex_display_footer' ) ) {
	function wpex_display_footer() {
		if ( !is_singular() ) return true;
		global $post;
		$post_id = $post->ID;
		$meta = get_post_meta( $post_id, 'wpex_disable_footer', true );
		if ( $meta == 'on' ) {
			return false;
		}
		return true;
	}
}
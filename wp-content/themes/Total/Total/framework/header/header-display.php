<?php
/**
 * Main header functions
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/

// Whether the header should display or not
if ( ! function_exists( 'wpex_display_header' ) ) {
	function wpex_display_header( $return = true ) {
		if ( is_singular() ) {
			global $post;
			$post_id = $post->ID;
			$meta = get_post_meta( get_the_ID(), 'wpex_disable_header', true );
			if ( $meta == 'on' ) {
				$return = false;
			}
		}
		return apply_filters( 'wpex_display_header', $return );
	}
}
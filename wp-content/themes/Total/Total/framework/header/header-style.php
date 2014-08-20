<?php
/**
 * // Return the correct header style
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/

if ( ! function_exists( 'wpex_get_header_style' ) ) {
	function wpex_get_header_style( $style = 'one' ) {
		$style = wpex_option('header_style','one');
		if ( is_singular() ) {
			global $post;
			$post_id = $post->ID;
			$meta = get_post_meta( $post_id, 'wpex_header_style', true );
			if ( $meta ) {
				$style = $meta;
			}
		}
		return $style;
	}
}
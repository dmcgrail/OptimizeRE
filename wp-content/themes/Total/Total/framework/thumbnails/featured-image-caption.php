<?php
/**
 * Displays the featured image caption of a post with $id
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.52
*/

if ( ! function_exists( 'wpex_featured_image_caption' ) ) {
	function wpex_featured_image_caption( $post_ID = '' ) {
		if ( ! $post_ID ) {
			global $post;
			$post_ID = $post->ID;
		}
		$thumbnail_id = get_post_thumbnail_id( $post_ID );
		$caption = get_post_field( 'post_excerpt', $thumbnail_id );
		if ( $caption ) {
			return $caption;
		}
	}
}
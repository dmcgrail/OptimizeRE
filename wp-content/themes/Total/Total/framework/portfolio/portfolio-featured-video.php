<?php
/*
 * Returns the Portfolio Post Video
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
*/


/**
	Get Featured Video URL
**/
if ( ! function_exists( 'wpex_get_portfolio_featured_video_url' ) ) {
	function wpex_get_portfolio_featured_video_url( $post_id = '' ) {
		$post_id = $post_id ? $post_id : get_the_ID();
		$meta = get_post_meta( $post_id, 'wpex_post_video', true );
		if ( $meta ) {
			return $meta;
		} else {
			return false;
		}
	}
}

/**
	Display Featured Video
**/
if ( ! function_exists( 'wpex_portfolio_post_video' ) ) {
	function wpex_portfolio_post_video( $post_id = '' ) {
		$video_url = wpex_get_portfolio_featured_video_url();
		if ( empty($video_url) ) return;
		$embed_code = wp_oembed_get( $video_url );
		if ( $video_url !== '' && !is_wp_error($embed_code) ) {
			echo '<div class="portfolio-featured-video responsive-video-wrap clr">'. $embed_code .'</div>';
		}
	}
}
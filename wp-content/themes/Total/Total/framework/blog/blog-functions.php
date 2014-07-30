<?php
/**
 * Useful functions for the standard posts
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/


/**
 * Returns post video URL
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( ! function_exists( 'wpex_post_video_url' ) ) {
	function wpex_post_video_url() {
		// Oembed
		$video = get_post_meta( get_the_ID(), 'wpex_post_oembed', true );
		if ( $video ) {
			return esc_url( $video );
		}
		// Self Hosted redux
		$video = get_post_meta( get_the_ID(), 'wpex_post_self_hosted_shortcode_redux', true );
		if ( is_array( $video ) && !empty( $video['url'] ) ) {
			return $video['url'];
		}
		// Self Hosted old
		else {
			return get_post_meta( get_the_ID(), 'wpex_post_self_hosted_shortcode', true );
		}
	}
}

/**
 * Returns post audio URL
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( ! function_exists( 'wpex_post_audio_url' ) ) {
	function wpex_post_audio_url() {
		// Oembed
		$audio = get_post_meta( get_the_ID(), 'wpex_post_oembed', true );
		if ( $audio ) {
			return esc_url( $audio );
		}
		// Self Hosted redux
		$audio = get_post_meta( get_the_ID(), 'wpex_post_self_hosted_shortcode_redux', true );
		if ( is_array( $audio ) && !empty( $audio['url'] ) ) {
			return $audio['url'];
		}
		// Self Hosted old
		else {
			return get_post_meta( get_the_ID(), 'wpex_post_self_hosted_shortcode', true );
		}
	}
}
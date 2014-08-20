<?php
/*
 * Creates functions for the front end Image galleries
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
*/




// Retrieve attachment IDs
if ( !function_exists ( 'wpex_get_gallery_ids' ) ) {
	function wpex_get_gallery_ids() {
		global $post;
		$postid = $post->ID;
		if( ! isset( $postid ) ) return;
		$attachment_ids = get_post_meta( $postid, '_easy_image_gallery', true );
		$attachment_ids = explode( ',', $attachment_ids );
		return array_filter( $attachment_ids );
	}
}


// Get attachment data
if ( !function_exists ( 'wpex_get_attachment' ) ) {
	function wpex_get_attachment( $attachment_id ) {
		$attachment = get_post( $attachment_id );
		return array(
			'alt'			=> get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'caption'		=> $attachment->post_excerpt,
			'description'	=> $attachment->post_content,
			'href'			=> get_permalink( $attachment->ID ),
			'src'			=> $attachment->guid,
			'title'			=> $attachment->post_title
		);
	}
}


// Return gallery images count
if ( !function_exists ( 'wpex_gallery_count' ) ) {
	function wpex_gallery_count() {
		$images = get_post_meta( get_the_ID(), '_easy_image_gallery', true );
		$images = explode( ',', $images );
		$number = count( $images );
		return $number;
	}
}


// Check if lightbox is enabled
function wpex_gallery_is_lightbox_enabled() {
	$link_images = get_post_meta( get_the_ID(), '_easy_image_gallery_link_images', true );
	if ( 'on' == $link_images ) return true;
}
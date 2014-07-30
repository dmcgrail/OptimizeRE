<?php
/**
 * Overrides the WooCommerce category thumbnail output
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
 */


function woocommerce_subcategory_thumbnail( $category ) {
	
	// Vars
	$title = get_the_title();
	$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
	$attachment_url = wp_get_attachment_url( $thumbnail_id );
	$width = wpex_option( 'woo_cat_entry_width', '9999' );
	$height = wpex_option( 'woo_cat_entry_height', '9999' );
	$crop =  ( $height == '9999' ) ? false : true;
	
	// Echo Image
	echo '<img src="'. wpex_image_resize( $attachment_url,  $width, $height, $crop ) .'" alt="'. $title .'" />';
	
} // End function
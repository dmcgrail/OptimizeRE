<?php
/**
 * Alter the WooCommerce entry media - featured image, slider, image swap
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
 */


$woo_product_entry_style = wpex_option( 'woo_product_entry_style', 'image-swap' );

/*------------------------------------------------*/
/* - Featured Image
/*------------------------------------------------*/
if ( $woo_product_entry_style == 'featured-image' ) {
	
	function woocommerce_get_product_thumbnail() {
		
		//Globals
		global $product;
		
		// Main vars
		$output = '';
		$enable_woo_entry_sliders = wpex_option( 'enable_woo_entry_sliders', '1' );
		
		// Get first image
		$attachment_id = get_post_thumbnail_id();
		$attachment_url = wp_get_attachment_url( $attachment_id );
		$alt = strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );
		$width = wpex_option( 'woo_entry_width', '9999' );
		$height = wpex_option( 'woo_entry_height', '9999' );
		$crop =  ( $height == '9999' ) ? false : true;
		
		// Return thumbnail
		$output .= '<img src="'. wpex_image_resize( $attachment_url,  $width, $height, $crop ) .'" alt="'. $alt .'" class="woo-entry-image-main" />';
		
		return $output;
		
	} // End function

}




/*------------------------------------------------*/
/* - Slider Style
/*------------------------------------------------*/
if ( $woo_product_entry_style == 'gallery-slider' ) {
	
	function woocommerce_get_product_thumbnail() {
		
		//Globals
		global $product;
		
		// Main vars
		$output = '';
		$enable_woo_entry_sliders = wpex_option( 'enable_woo_entry_sliders', '1' );
		
		// Get first image
		$attachment_id = get_post_thumbnail_id();
		$attachment_url = wp_get_attachment_url( $attachment_id );
		$alt = strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );
		$width = wpex_option( 'woo_entry_width', '9999' );
		$height = wpex_option( 'woo_entry_height', '9999' );
		$crop =  ( $height == '9999' ) ? false : true;
		
		// Get gallery images
		$attachment_ids = $product->get_gallery_attachment_ids();
		$attachment_ids[] = $attachment_id;
		$attachment_ids = array_unique($attachment_ids); // remove duplicate images
		
		if ( $attachment_ids && $enable_woo_entry_sliders == '1' ) {
			
			$output .= '<div class="woo-product-entry-slider">';
				$output .= '<div class="flexslider">';
					$output .= '<ul class="slides">';
						$count=0;
						foreach ( $attachment_ids as $attachment_id ) {
							$count++;
							if ( $count < 5 ) {
								$alt = strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );
								$attachment_url = wp_get_attachment_url( $attachment_id );
								$output .= '<li><img src="'. wpex_image_resize( $attachment_url,  $width, $height, $crop ) .'" alt="'. $alt .'" /></li>';
							}
						}
					$output .= '</ul>';
				$output .= '</div>';
			$output .= '</div>';
			
		} else {
		
			// Return thumbnail
			$output .= '<img src="'. wpex_image_resize( $attachment_url,  $width, $height, $crop ) .'" alt="'. $alt .'" class="woo-entry-image-main" />';
		
		}
		
		return $output;
		
	} // End function

}



/*------------------------------------------------*/
/* - Image Swap
/*------------------------------------------------*/
if ( $woo_product_entry_style == 'image-swap' ) {
	
	function woocommerce_get_product_thumbnail() {
		
		//Globals
		global $product;
		
		// Main vars
		$output = '';
		$enable_woo_entry_sliders = wpex_option( 'enable_woo_entry_sliders', '1' );
		
		// Get first image
		$attachment_id = get_post_thumbnail_id();
		$attachment_url = wp_get_attachment_url( $attachment_id );
		$alt = strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );
		$width = wpex_option( 'woo_entry_width', '9999' );
		$height = wpex_option( 'woo_entry_height', '9999' );
		$crop =  ( $height == '9999' ) ? false : true;
		
		// Get Second Image in Gallery
		$attachment_ids = $product->get_gallery_attachment_ids();
		$attachment_ids[] = $attachment_id; // Add featured image to the array
		$secondary_img_id_url='';
		
		if ( !empty( $attachment_ids ) ) {
			$attachment_ids = array_unique($attachment_ids); // remove duplicate images
			if ( count($attachment_ids) > '1' ) {
				if ( $attachment_ids['0'] !== $attachment_id ) {
					$secondary_img_id = $attachment_ids['0'];
				} elseif ( $attachment_ids['1'] !== $attachment_id ) {
					$secondary_img_id = $attachment_ids['1'];
				}
				$secondary_img_id_url = wp_get_attachment_url( $secondary_img_id );
			}
		}
					
		// Return thumbnail
		if ( '' != $secondary_img_id_url ) {
			$output .= '<div class="woo-entry-image-swap">';
				$output .= '<img src="'. wpex_image_resize( $attachment_url,  $width, $height, $crop ) .'" alt="'. $alt .'" class="woo-entry-image-main" />';
				$output .= '<img src="'. wpex_image_resize( $secondary_img_id_url,  $width, $height, $crop ) .'" alt="'. $alt .'" class="woo-entry-image-secondary" />';
			$output .= '</div>';
		} else {
			$output .= '<img src="'. wpex_image_resize( $attachment_url,  $width, $height, $crop ) .'" alt="'. $alt .'" class="woo-entry-image-main" />';
		}
		
		return $output;
		
	} // End function

}
<?php
/**
 * Change default Woo Image sizes
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
 */



// Change the default WooCommerce image sizes
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'wpex_woocommerce_image_dimensions', 1 );
function wpex_woocommerce_image_dimensions() {
	
	$catalog = array(
		'width' 	=> '9999',
		'height'	=> '9999',
		'crop'		=> 0
	);
	
	$single = array(
		'width' 	=> '9999',
		'height'	=> '9999',
		'crop'		=> 0
	);

	$thumbnail = array(
		'width' 	=> '100',
		'height'	=> '100',
		'crop'		=> 1
	);
	
	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog );
	update_option( 'shop_single_image_size', $single );
	update_option( 'shop_thumbnail_image_size', $thumbnail );
	
}
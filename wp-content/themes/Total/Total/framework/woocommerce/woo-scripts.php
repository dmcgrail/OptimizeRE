<?php
/**
 * Remove WooCommerce Styles & Scripts
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
 */


// Remode default Woo CSS
if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
} else {
	define( 'WOOCOMMERCE_USE_CSS', false );
}


add_action( 'wp_enqueue_scripts', 'wpex_manage_woocommerce_styles', 99 );
function wpex_manage_woocommerce_styles() {
	
	// Remove Woo generator in <head>
	remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
	
	// Remove prettyPhoto CSS
	wp_dequeue_style( 'woocommerce_prettyPhoto_css' );

	// Remove prettyPhoto Init
	wp_dequeue_script( 'prettyPhoto-init' );
	
}
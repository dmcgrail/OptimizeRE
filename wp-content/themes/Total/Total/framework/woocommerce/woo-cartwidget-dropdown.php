<?php
/**
 * Add Menu Cart to menu
 *
 * Code elegantly lifted from: http://wordpress.org/plugins/woocommerce-menu-bar-cart/
 * Edited by WPExplorer
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
*/


$wpex_header_style = wpex_get_header_style();;
if ( $wpex_header_style == 'one' ) {
	add_action( 'wpex_hook_header_inner', 'wpex_cart_widget_dropdown' );
}

if ( $wpex_header_style == 'two' || $wpex_header_style == 'three' ) {
	add_action( 'wpex_hook_main_menu_bottom', 'wpex_cart_widget_dropdown' );
}


if ( ! function_exists('wpex_cart_widget_dropdown') ) {
	
	function wpex_cart_widget_dropdown() {
		
		// WooCommerce is not active, so bail
		if ( ! class_exists('Woocommerce') ) return;
		
		// If disabled bail
		if ( wpex_option('woo_menu_icon','1') !== '1' ) return;
		
		// Do nothing if it isn't the corrent style
		$woo_menu_icon_style = wpex_option('woo_menu_icon_style');
		if ( $woo_menu_icon_style !== 'drop-down' ) return;
				
		// Globals & vars
		global $woocommerce;
		$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
		$cart_contents_count = $woocommerce->cart->cart_contents_count;
		
		// Not needed on checkout
		if ( is_checkout() ) return false;
		
		// Not needed on cart page when items exist
		if ( is_cart() && sizeof( $cart_contents_count ) !== 0 ) return false; ?>
		
		<div id="current-shop-items-dropdown" class="clr">
			<div id="current-shop-items-inner" class="clr">
				<?php
				// Display WooCommerce cart
				if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
					the_widget( 'WC_Widget_Cart', 'title= ' );
				} else {
					the_widget( 'WooCommerce_Widget_Cart', 'title= ' );
				} ?>
			</div><!-- #current-shop-items-inner -->
		</div><!-- #current-shop-items-dropdown -->
		
	<?php
	
	} // End function 
	
} // End if function exists
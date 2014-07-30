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


add_action( 'wp_footer', 'wpex_cart_widget_overlay' );

if ( ! function_exists('wpex_cart_widget_overlay') ) {
	
	function wpex_cart_widget_overlay() {
		
		// WooCommerce is not active, so bail
		if ( ! class_exists('Woocommerce') ) return;
		
		// If disabled bail
		if ( wpex_option('woo_menu_icon','1') !== '1' ) return;
		
		// Do nothing if it isn't the corrent style
		$woo_menu_icon_style = wpex_option('woo_menu_icon_style');
		if ( $woo_menu_icon_style !== 'overlay' ) return;
				
		// Globals & vars
		global $woocommerce;
		$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
		$cart_contents_count = $woocommerce->cart->cart_contents_count;
		
		// Not needed on checkout
		if ( is_checkout() ) return false;
		
		// Not needed on cart page when items exist
		if ( is_cart() && sizeof( $cart_contents_count ) !== 0 ) return false; ?>
		
		<div id="current-shop-items-overlay" class="clr">
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
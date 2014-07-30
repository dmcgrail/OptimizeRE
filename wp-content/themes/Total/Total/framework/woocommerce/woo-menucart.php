<?php
/**
 * Add Menu Cart to menu
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
*/


add_filter( 'wp_nav_menu_items', 'wpex_add_itemcart_to_menu' , 10, 2 );
add_filter( 'add_to_cart_fragments', 'wpex_wcmenucart_add_to_cart_fragment' );
		

// Add Woo Cart icon to main nav
if ( ! function_exists('wpex_add_itemcart_to_menu') ) {
	
	function wpex_add_itemcart_to_menu( $items, $args ) {

		// Custom menu, bail
		if ( wpex_custom_menu() ) return $items;
		
		// Add to main menu only
		if( $args->theme_location == 'main_menu' ) {
			
			// Var
			$js_class = '';
			
			// Style
			$woo_menu_icon_style = wpex_option('woo_menu_icon_style','overlay');
			
			if ( $woo_menu_icon_style == 'overlay' ) {
				$js_class = 'wcmenucart-toggle-overlay';
			}
			
			if ( $woo_menu_icon_style == 'drop-down' ) {
				$js_class = 'wcmenucart-toggle-dropdown';
			}
			
			// Only add toggle class when needed
			if ( is_cart() || is_checkout() ) {
				$classes = '';
			} else {
				$classes = $js_class;
			}
			
			// Do not show toggle class on certain woo styles
			if ( $woo_menu_icon_style == 'store' ) {
				$classes = '';
			}
			
			if ( $woo_menu_icon_style == 'custom-link' ) {
				$classes = '';
			}
			
			// Add cart link to menu items
			$items .= '<li class="'.$classes.' woo-menu-icon">' . wpex_wcmenucart_menu_item() .'</li>';
		}
		
		// Return items
		return $items;
	}
	
}


// Woo Fragments
if ( ! function_exists('wpex_wcmenucart_add_to_cart_fragment') ) {
	function wpex_wcmenucart_add_to_cart_fragment( $fragments ) {
		$fragments['.wcmenucart'] = wpex_wcmenucart_menu_item();
		return $fragments;
	}
}


// Create Woo Cart Link
if ( ! function_exists('wpex_wcmenucart_menu_item') ) {
	
	function wpex_wcmenucart_menu_item() {
		
		// Globals
		global $woocommerce;

		// Vars
		$go_to_cart_class = '';
		
		// Cart Total
		$cart_total = $woocommerce->cart->get_cart_total();
		
		// URL
		$url = get_permalink( woocommerce_get_page_id( 'shop' ) );
		
		// Theme options
		$woo_menu_icon_amount = wpex_option('woo_menu_icon_amount');
		$woo_menu_icon_style = wpex_option('woo_menu_icon_style','overlay');
		$woo_menu_icon_custom_link = wpex_option('woo_menu_icon_custom_link','overlay');
		
		// Icon + Vars
		$menu_item = '';
		$icon_output = '<span class="fa fa-shopping-cart"></span>';

		// Redirect to cart if empty
		
		// URL
		if ( $woo_menu_icon_style == 'custom-link' && $woo_menu_icon_custom_link ) {
			$url = $woo_menu_icon_custom_link;
		}
		
		// Remove total if disabled
		if ( $woo_menu_icon_amount !== '1' ) {
			$cart_total = '';
		}

		ob_start(); ?>

		<a href="<?php echo $url; ?>" class="wcmenucart" title="<?php _e('Your Cart','wpex'); ?>">
			<span class="wcmenucart-count"><?php echo $icon_output .' '. $cart_total; ?></span>
		</a>

	<?php
		return ob_get_clean();
	}

}
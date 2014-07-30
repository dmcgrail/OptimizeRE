<?php
/**
 * Header Menu
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/


// Custom Menus
if ( ! function_exists( 'wpex_custom_menu' ) ) {
	function wpex_custom_menu( $menu = false ) {
		if ( is_singular( 'page' ) ) {
			global $post;
			$post_id = $post->ID;
			if ( get_post_meta( $post_id, 'wpex_custom_menu', true ) && 'default' != get_post_meta( $post_id, 'wpex_custom_menu', true ) ) {
				$menu = get_post_meta( $post_id, 'wpex_custom_menu', true );
			}
		}
		return apply_filters( 'wpex_custom_menu', $menu );
	}
}


// Outputs the main header menu
if ( ! function_exists( 'wpex_header_menu' ) ) {
	function wpex_header_menu() {
		
		// Vars
		$wrap_classes = $classes = '';
		$header_style = wpex_get_header_style();
		$fixed_header = wpex_option( 'fixed_header', '1' );
		$header_height = intval( wpex_option( 'header_height' ) );
		$woo_icon = wpex_option( 'woo_menu_icon', '1' );

		// Main + Header Style Wrap Classes
		$wrap_classes .= 'clr navbar-style-'. $header_style;

		// Fixed Nav Wrap Classes
		if ( $header_style !== 'one' && $fixed_header == '1' ){
			$wrap_classes .= ' fixed-nav';
		}

		// Fixed Height Wrap Classes
		if ( $header_style == 'one' && ' ' != $header_height ) {
			if ( $header_height && '0' != $header_height && 'auto' != $header_height ) {
				$wrap_classes .= ' nav-custom-height';
			}
		}

		// Dropdown top border
		if (  wpex_option( 'menu_dropdown_top_border', '1' ) ) {
			$wrap_classes .= ' nav-dropdown-top-border';
		}

		// Site Nav Classes
		// Header 2 + 3 classes
		if ( $header_style == 'two' || $header_style == 'three' ) {
			$classes .= 'container';
		}

		// Nav Search classes
		if ( '1' == wpex_option( 'main_search', '1' ) ) {
			$classes .= ' site-navigation-with-search';
			if ( class_exists('Woocommerce') && $woo_icon == '1' ) {
				$classes .= ' site-navigation-with-cart-icon';
			} elseif ( class_exists('Woocommerce') && $woo_icon !== '1' ) {
				$classes .= ' site-navigation-without-cart-icon';
			} else {
				$classes .= ' site-navigation-without-cart-icon';
			}
		} ?>
		
		<?php
		// Before main menu hook
		wpex_hook_main_menu_before(); ?>
		
		<div id="site-navigation-wrap" class="<?php echo $wrap_classes; ?>">
			<nav id="site-navigation" class="navigation main-navigation clr <?php echo $classes; ?>" role="navigation">
				<?php
				// Top menu hook
				wpex_hook_main_menu_top();

				// Menu Location
				$menu_location = apply_filters( 'wpex_main_menu_location', 'main_menu' );

				// Custom Menu
				$menu = wpex_custom_menu();

				// Display main menu
				if ( $menu ) {
					wp_nav_menu( array(
						'menu'				=> $menu,
						'theme_location'	=> $menu_location,
						'menu_class'		=> 'dropdown-menu sf-menu',
						'fallback_cb'		=> false,
						'walker'			=> new WPEX_Dropdown_Walker_Nav_Menu()
					) );
				} else {
					wp_nav_menu( array(
						'theme_location'	=> $menu_location,
						'menu_class'		=> 'dropdown-menu sf-menu',
						'walker'			=> new WPEX_Dropdown_Walker_Nav_Menu(),
						'fallback_cb'		=> false,
					) );
				}
				// Botttom main menu hook
				wpex_hook_main_menu_bottom(); ?>
			</nav><!-- #site-navigation -->
		</div><!-- #site-navigation-wrap -->
		
		<?php
		// After main menu hook
		wpex_hook_main_menu_after(); ?>
		
	<?php
	}
}

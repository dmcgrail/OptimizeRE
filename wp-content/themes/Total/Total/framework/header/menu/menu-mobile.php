<?php
/**
 * Outputs the responsive/mobile menu for the header
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/


// Outputs the menu
if ( ! function_exists( 'wpex_mobile_menu' ) ) {
	function wpex_mobile_menu( $style = '' ) {
		
		// If responsive is disabled, bail
		if( wpex_option('responsive','1') !== '1' ) {
			return;
		}
		
		// Vars
		$mobile_menu_open_button_text = '<span class="fa fa-bars"></span>';
		$mobile_menu_open_button_text = apply_filters( 'wpex_mobile_menu_open_button_text', $mobile_menu_open_button_text );

		// Toggle style
		$toggle_menu_style = 'sidr-menu-toggle'; ?>

		<div id="sidr-close"><a href="#sidr-close" class="toggle-sidr-close"></a></div>
		<div id="mobile-menu" class="clr">
			<a href="#sidr" class="<?php echo $toggle_menu_style; ?>"><?php echo $mobile_menu_open_button_text; ?></a>
			<?php
			// Display items from the mobile menu
			$menu_name = 'mobile_menu';
			if ( has_nav_menu( $menu_name ) ) {
				if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
					$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
					if ( !empty($menu) ) {
						$menu_items = wp_get_nav_menu_items($menu->term_id);
						foreach ( $menu_items as $key => $menu_item ) {
							$title = $menu_item->title;
							$url = $menu_item->url;
							$attr_title = $menu_item->attr_title ?>
							<a href="<?php echo $url; ?>" title="<?php echo $attr_title; ?>" class="mobile-menu-extra-icons mobile-menu-<?php echo $title; ?>">
								<span class="fa fa-<?php echo $title; ?>"></span>
							</a>
						<?php }
					}
				}
			} ?>
		</div><!-- #mobile-menu -->
		
	<?php
	}
}
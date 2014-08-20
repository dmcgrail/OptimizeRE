<?php
/**
 * Header search overlay style
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/

// Not needed in admin
if ( is_admin() ) {
	return;
}


/**
 * Adds code for the search overlay to the wp footer hook
 *
 * @since 1.0
 * @return string
 */
if ( ! function_exists( 'wpex_search_overlay' ) ) {
	function wpex_search_overlay() {
		if ( !wpex_search_in_menu() ) {
			return;
		} ?>
		<section id="searchform-overlay" class="header-searchform-wrap clr">
			<div id="searchform-overlay-title"><?php _e('Search','wpex'); ?></div>
			<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" class="header-searchform">
				<input type="search" name="s" autocomplete="off" />
			</form>
		</section>
	<?php }
}
add_action( 'wp_footer', 'wpex_search_overlay' );
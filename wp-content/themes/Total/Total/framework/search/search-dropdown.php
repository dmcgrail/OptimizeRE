<?php
/**
 * Header search dropdown style
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
 * Hook into header for correct style
 *
 * @since 1.0
 * @return action
 */
if ( wpex_search_in_menu() ) {
	if ( 'one' == wpex_option( 'header_style', 'one' ) ) {
		add_action( 'wpex_hook_header_inner', 'wpex_search_dropdown' );
	}
	if ( 'three' == wpex_option( 'header_style' ) || 'two' == wpex_option( 'header_style' ) ) {
		add_action( 'wpex_hook_main_menu_bottom', 'wpex_search_dropdown' );
	}
}

/**
 * Function outputs search dropdown
 *
 * @since 1.0
 * @return string
 */
if ( ! function_exists( 'wpex_search_dropdown' ) ) {
	function wpex_search_dropdown() {
		if ( !wpex_search_in_menu() ) {
			return;
		}
		$placeholder = apply_filters( 'wpex_search_placeholder_text', __( 'search', 'wpex' ) ); ?>
		<div id="searchform-dropdown" class="header-searchform-wrap clr">
			<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" class="header-searchform"><input type="search" name="s" autocomplete="off" placeholder="<?php echo $placeholder; ?>" /></form>
		</div>
	<?php
	}
}
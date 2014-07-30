<?php
/**
 * Header search header replace style
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
 * Add code for header replace to nav
 *
 * @since 1.0
 * @return string
 */
if ( ! function_exists( 'wpex_search_header_replace' ) ) {
	function wpex_search_header_replace() {
		if ( !wpex_search_in_menu() ) {
			return;
		}
		$placeholder = apply_filters( 'wpex_search_placeholder_text', __( 'Type then hit enter to search...', 'wpex' ) ); ?>
			<div id="searchform-header-replace" class="clr header-searchform-wrap">
				<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" class="header-searchform"><input type="search" name="s" autocomplete="off" placeholder="<?php _e( 'Type then hit enter to search...', 'wpex' ); ?>" /></form>
				<span id="searchform-header-replace-close" class="fa fa-times"></span>
			</div>
		<?php
	}
}
add_action( 'wpex_hook_header_inner', 'wpex_search_header_replace' );
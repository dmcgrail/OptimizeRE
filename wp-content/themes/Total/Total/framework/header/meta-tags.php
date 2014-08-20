<?php
/**
 * Header meta tags
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link  http://www.wpexplorer.com
 * @since Total 1.4
*/

/**
 * Outputs the header meta viewport tag
 *
 * @since 1.0
 * @return html
 */
if ( ! function_exists( 'wpex_meta_viewport' ) ) {
	function wpex_meta_viewport() {
		// Responsive
		if( '1' == wpex_option( 'responsive', '1' ) ) {
			$output = '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
		// Non responsive
		} else {
			$output = '<meta name="viewport" content="width='. intval(wpex_option( 'main_container_width', '980' )) .'" />';
			//$output = '<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">';
		}
		// Return meta
		echo apply_filters( 'wpex_meta_viewport', $output );
	}
}

/**
 * Outputs the header meta title tag
 *
 * @since 1.4
 * @return html
 */
if ( ! function_exists( 'wpex_meta_title' ) ) {
	function wpex_meta_title() {
		// Yoast SEO
		if ( function_exists( 'wpseo_auto_load' ) ) { ?>
			<title><?php wp_title(); ?></title>
		<?php } else { ?>
			<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo('name'); ?></title>
		<?php }
	}
}
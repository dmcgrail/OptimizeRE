<?php
/**
 * This function is used to output the site favicons and apple icons
 * Code is echoed into the wp_head hook
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/

add_action( 'wp_head', 'wpex_favicons_apple_icons' );
if ( ! function_exists( 'wpex_favicons_apple_icons' ) ) {
	function wpex_favicons_apple_icons() {
		
		// Vars
		$output = '';
		$favicon = wpex_option('favicon', '', 'url');
		$iphone_icon = wpex_option('iphone_icon', '', 'url');
		$iphone_icon_retina = wpex_option('iphone_icon_retina', '', 'url');
		$ipad_icon = wpex_option('ipad_icon', '', 'url');
		$ipad_icon_retina = wpex_option('ipad_icon_retina', '', 'url');
		
		// Favicon
		if ( $favicon ) {
			$output .= '<!-- Favicon -->';
			$output .= '<link rel="shortcut icon" href="'. $favicon .'">';
		}
		
		// Apple iPhone Icon
		if ( $iphone_icon ) {
			$output .= '<!-- Apple iPhone Icon -->';
			$output .= '<link rel="apple-touch-icon-precomposed" href="'. $iphone_icon .'">';
		}
		
		// Apple iPhone Retina Icon
		if ( $iphone_icon_retina ) {
			$output .= '<!-- Apple iPhone Retina Icon -->';
			$output .= '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="'. $iphone_icon_retina .'">';
		}
		
		// Apple iPad Icon
		if ( $ipad_icon ) {
			$output .= '<!-- Apple iPhone Icon -->';
			$output .= '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="'. $ipad_icon .'">';
		}
		
		// Apple iPad Retina Icon
		if ( $ipad_icon_retina && ! $iphone_icon_retina ) {
			$output .= '<!-- Apple iPhone Icon -->';
			$output .= '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="'. $ipad_icon_retina .'">';
		}
		
		echo $output;
		
	}
}
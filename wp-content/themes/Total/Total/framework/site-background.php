<?php
/**
 * Custom backgrounds for your site
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/


add_action('wp_head', 'wpex_site_background');

if ( !function_exists( 'wpex_site_background' ) ) {
	
	function wpex_site_background() {
		
		// VARS
		$background_color = wpex_option( 'background_color' );
		$background_image_toggle = wpex_option( 'background_image_toggle' );
		$background_image = wpex_option( 'background_image', '', 'url' );
		$background_style = wpex_option( 'background_style' );
		$background_pattern_toggle = wpex_option( 'background_pattern_toggle' );
		$background_pattern = wpex_option( 'background_pattern' );
		
		$css = '';
		
		
		// Color
		if ( $background_color ) {
			$css .= 'body, .boxed-main-layout { background-color: '. $background_color .'; }';
		}
		
		// Image
		if ( $background_image && $background_image_toggle && $background_pattern_toggle !== '1'  ) {
			$css .= 'body { background-image: url('. $background_image .'); }';
			if ( $background_style ) {
				if ( $background_style == 'stretched' ) {
					$css .= 'body { -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:fixed; background-repeat: no-repeat; }';
				}
				if ( $background_style == 'repeat' ) {
					$css .= 'body { background-repeat: repeat; }';
				}
				if ( $background_style == 'fixed' ) {
					$css .= 'body { background-repeat: no-repeat; background-position: center center; background-attachment:fixed; }';
				}
			}
		}
		
		// Pattern
		if ( $background_pattern && $background_pattern_toggle == '1' ) {
			$css .= 'body { background-image: url('. $background_pattern .'); background-repeat: repeat; }';
		}
		
		// Return trimmed CSS
		$css = preg_replace( '/\s+/', ' ', $css );
		// output css on front end
		if ( '' != $css ) {
			$css = '/*Admin Site Background CSS START*/'. $css .'/*Admin Site Background CSS END*/';
			return $css;
		} else {
			return '';
		}
		
	}
}
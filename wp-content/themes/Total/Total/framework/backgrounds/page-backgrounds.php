<?php
/**
 * Function used to display custom backgrounds on a per-page basis
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.1
*/

if ( ! function_exists('wpex_page_backgrounds') ) {
	function wpex_page_backgrounds( $title='' ) {
		
		// Only run on pages
		if ( !is_singular() ) {
			return;
		}
		
		global $post;
		$post_ID = $post->ID;
		$css = '';

		// Background Color
		$bg_color = get_post_meta( $post_ID, 'wpex_page_background_color', true );
		if ( $bg_color && $bg_color !== '#' ) {
			$css .= 'body { background-color: '. $bg_color .' !important; }';
		}

		// Background image
		$bg_img = get_post_meta( $post_ID, 'wpex_page_background_image_redux', true );
		if ( is_array($bg_img) && !empty( $bg_img['url'] ) ) {
			$bg_img = $bg_img['url'];
		} else {
			$bg_img = get_post_meta( $post_ID, 'wpex_page_background_image', true );
		}

		// Background image style
		$bg_img_style = get_post_meta( $post_ID, 'wpex_page_background_image_style', true );
		$bg_img_style = $bg_img_style ? $bg_img_style : 'repeat';
		
		// Background Image
		if ( $bg_img ) {
			if ( 'repeat' == $bg_img_style ) {
				$css .= 'body { background: url('. $bg_img .') repeat !important; }';
			}
			if ( 'fixed' == $bg_img_style ) {
				$css .= 'body { background: url('. $bg_img .') center top fixed no-repeat !important; }';
			}
			if ( 'stretched' == $bg_img_style || 'streched' == $bg_img_style  ) {
				$css .= 'body { background: url('. $bg_img .') no-repeat center center fixed !important; -webkit-background-size: cover !important; -moz-background-size: cover !important; -o-background-size: cover !important; background-size: cover !important; }';
			}
		}
		
		// trim white space for faster page loading
		$css = preg_replace( '/\s+/', ' ', $css );
		
		if ( '' != $css ) {
			$css = '/*Admin Page Background CSS START*/'. $css .'/*Admin Page Background CSS END*/';
			return $css;
		} else {
			return '';
		}
		

	}
}
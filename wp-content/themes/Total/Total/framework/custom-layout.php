<?php
/**
 * Outputs custom CSS for layout widths defined in the theme admin
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

if ( !function_exists( 'wpex_layout_css' ) ) {
	function wpex_layout_css() {
	
		$css ='';
		
		/**
			Main Container
		**/
		
		// Main Container With
		$main_container_width = wpex_option( 'main_container_width' );
		if ( '' != $main_container_width && '980px' != $main_container_width ) {
			if ( 'gaps' == wpex_active_skin() ) {
				$css .= '@media only screen and (min-width: 1281px) {
					.is-sticky .fixed-nav,
					#wrap { width: '. $main_container_width .' !important; }
				}';
			} else {
				$css .= '@media only screen and (min-width: 1281px) {
					.container, .vc_row-fluid.container,
					.boxed-main-layout #wrap { width: '. $main_container_width .'; }
					.boxed-main-layout .is-sticky #site-header,
					.boxed-main-layout .is-sticky .fixed-nav { width: '. $main_container_width .' !important; }
				}';
			}
		}
		
		// Left container width
		$left_container_width = wpex_option( 'left_container_width' );
		if ( '' != $left_container_width && $left_container_width !== '680px' ) {
			$css .= '@media only screen and (min-width: 960px) { .content-area { width: '. $left_container_width .'; } }';
		}

		// Boxed top/bottom margin
		if ( 'boxed' == wpex_option( 'main_layout_style', 'full-width' ) ) {
			if ( '' != wpex_option( 'boxed_top_margin' ) ) {
				$css .= '.boxed-main-layout #wrap { margin-top: '. intval( wpex_option( 'boxed_top_margin' ) ) .'px; }';
			}
			if ( '' != wpex_option( 'boxed_bottom_margin' ) ) {
				$css .= '.boxed-main-layout #wrap { margin-bottom: '. intval( wpex_option( 'boxed_bottom_margin' ) ) .'px; }';
			}
		}

		/**
			Header
		**/

		// Header Top Padding
		$header_top_padding = wpex_option( 'header_top_padding' );
		if ( '' != $header_top_padding && '30' != $header_top_padding ) {
			if ( '0' == $header_top_padding || '0px' == $header_top_padding ) {
				$header_top_padding = $header_top_padding;
			} else {
				$header_top_padding = intval( $header_top_padding ) .'px';
			}
			$css .= '#site-header-inner { padding-top: '. $header_top_padding .'; }';
		}
		
		// Header Bottom Padding
		$header_bottom_padding = wpex_option( 'header_bottom_padding' );
		if ( '' != $header_bottom_padding && '30' != $header_bottom_padding ) {
			if ( '0' == $header_bottom_padding || '0px' == $header_bottom_padding ) {
				$header_bottom_padding = $header_bottom_padding;
			} else {
				$header_bottom_padding = intval( $header_bottom_padding ) .'px';
			}
			$css .= '#site-header-inner { padding-bottom: '. $header_bottom_padding .'; }';
		}

		// Header Height
		if ( 'one' == wpex_option( 'header_style' ) ) {
		$header_height = intval( wpex_option( 'header_height' ) );
			if ( $header_height && '0' != $header_height && 'auto' != $header_height ) {
				if ( $header_top_padding || $header_bottom_padding ) {
					$header_height_plus_padding = $header_height + $header_top_padding + $header_bottom_padding;
				} else {
					$header_height_plus_padding = $header_height + '60';
				}
				$css .= '@media only screen and (min-width: 960px) {
							.header-one #site-header { height: '. $header_height .'px; }
							.header-one #site-navigation-wrap,
							.navbar-style-one .dropdown-menu > li > a,
							.nav-custom-height.navbar-style-one .dropdown-menu .wcmenucart-toggle-dropdown,
							.theme-minimal-graphical .nav-custom-height.navbar-style-one .dropdown-menu .wcmenucart-toggle-dropdown,
							.theme-minimal-graphical .nav-custom-height.navbar-style-one .dropdown-menu .search-toggle-li { height: '. $header_height_plus_padding .'px; }
							.navbar-style-one .dropdown-menu > li > a { line-height: '. $header_height_plus_padding .'px; }
							.header-one #site-logo,
							.header-one #site-logo a { height: '. $header_height .'px; line-height: '. $header_height .'px; }
				}';
			}
		}

		/**
			Logo
		**/
		
		// Logo top margin
		$logo_top_margin = intval( wpex_option( 'logo_top_margin' ) );
		if ( '' != $logo_top_margin && '0' != $logo_top_margin ) {
			if ( $header_height && '0' != $header_height && 'auto' != $header_height && wpex_option( 'custom_logo', false, 'url' ) ) {
				$css .= '#site-logo img { padding-top: '. $logo_top_margin .'px; }';
			} else {
				$css .= '#site-logo { margin-top: '. $logo_top_margin .'px; }';
			}
		}
		
		// Logo bottom margin
		$logo_bottom_margin = intval( wpex_option( 'logo_bottom_margin' ) );
		if ( '' != $logo_bottom_margin && '0' != $logo_bottom_margin) {
			if ( $header_height && '0' != $header_height && 'auto' != $header_height && wpex_option( 'custom_logo', false, 'url' ) ) {
				$css .= '#site-logo img { padding-bottom: '. $logo_bottom_margin .'px; }';
			} else {
				$css .= '#site-logo { margin-bottom: '. $logo_bottom_margin .'px; }';
			}
		}

		/**
			Sidebar
		**/

		// Sidebar width
		$sidebar_width = wpex_option( 'sidebar_width' );
		if ( '' != $sidebar_width && '250px' != $sidebar_width ) {
			$css .= '@media only screen and (min-width: 960px) { #sidebar { width: '. $sidebar_width .'; } }';
		}
		
		// Sidebar padding
		$sidebar_padding_array = wpex_option( 'sidebar_padding' );
		if ( is_array( $sidebar_padding_array ) && !empty( $sidebar_padding_array ) ) {
			foreach ( $sidebar_padding_array as $key=>$value ) {
				$value = intval($value );
				if ( !empty( $value ) ) {
					$css .= '#sidebar{ '. $key .': '. $value .'px; }';
				}
			}
		}

		/**
			Output
		**/
		
		// Output css on front end
		if ( '' != $css ) {
			$css =  preg_replace( '/\s+/', ' ', $css );
			$css = '/*Custom Layout CSS START*/'. $css .'/*Custom Layout CSS END*/';
			return $css;
		} else {
			return '';
		}
		
	}
}
<?php
/**
 * This file is used for all the styling options in the admin
 * All custom color options are output to the <head> tag
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */


if ( !function_exists( 'wpex_typography' ) ) {
	
	function wpex_typography( $return ='' ) {
	
		$load_google_fonts = array();
		$css = $google_scripts = $google_fonts_css = '';
		
		/*------------------------------------------------*/
		/* Body
		/*------------------------------------------------*/
		$body_font = wpex_option( 'body_font' );
		if ( !empty($body_font) ) {
			
			// Vars
			$body_family = isset($body_font['font-family']) ? $body_font['font-family'] : "";
			$body_size = isset($body_font['font-size']) ? $body_font['font-size'] : "";
			$body_weight = isset($body_font['font-weight']) ? $body_font['font-weight'] : "";
			$font_style = isset($body_font['font-style']) ? $body_font['font-style'] : "";
			$body_color = isset($body_font['color']) ? $body_font['color'] : "";
			
			// Font family
			if ( !empty($body_family) && 'inherit' != $body_family ) {
				$css .= 'body, .button, input, textarea { font-family: '. $body_family .'; }';
				$load_google_fonts[] = $body_family;
			}
			
			// Font size
			if ( !empty($body_size) && 'inherit' != $body_size ) {
				$css .= 'body { font-size: '. $body_size .'; }';
			}
			
			// Font weight
			if ( !empty($body_weight) && 'inherit' != $body_weight ) {
				$css .= 'body { font-weight: '. $body_weight .' }';
			}

			// Font Style
			if ( !empty($font_style) && 'inherit' != $font_style ) {
				$css .= 'body { font-style: '. $font_style .' }';
			}
			
			// Font color
			if ( !empty($body_color) && 'inherit' != $body_color ) {
				$css .= 'body { color: '. $body_color .' }';
			}
			
		}
		
		
		/*------------------------------------------------*/
		/* Headings
		/*------------------------------------------------*/
		$headings_font = wpex_option( 'headings_font' );
		if ( !empty($headings_font) ) {
			
			// Vars
			$headings_family = isset($headings_font['font-family']) ? $headings_font['font-family'] : "";
			$headings_weight = isset($headings_font['font-weight']) ? $headings_font['font-weight'] : "";
			$font_style = isset($headings_font['font-style']) ? $headings_font['font-style'] : "";
			
			// Font family
			if ( $headings_family && 'inherit' != $headings_family ) {
				$css .= 'h1,h2,h3,h4,h5,h6,.theme-heading, .widget-title, .vc_text_separator { font-family: '. $headings_family .'; }';
				$load_google_fonts[] = $headings_family;
			}
			
			// Font weight
			if ( $headings_weight ) {
				$css .= 'h1,h2,h3,h4,h5,h6,.theme-heading, .widget-title { font-weight: '. $headings_weight .' }';
			}

			// Font Style
			if ( !empty($font_style) && 'inherit' != $font_style ) {
				$css .= 'h1,h2,h3,h4,h5,h6,.theme-heading, .widget-title { font-style: '. $font_style .' }';
			}
			
		}
		
		
		/*------------------------------------------------*/
		/* Logo
		/*------------------------------------------------*/
		$logo_font = wpex_option( 'logo_font' );
		if ( !empty($logo_font) ) {
			
			// Vars
			$logo_family = isset($logo_font['font-family']) ? $logo_font['font-family'] : "";
			$logo_size = isset($logo_font['font-size']) ? $logo_font['font-size'] : "";
			$logo_weight = isset($logo_font['font-weight']) ? $logo_font['font-weight'] : "";
			$logo_color = isset($logo_font['color']) ? $logo_font['color'] : "";
			$font_style = isset($logo_font['font-style']) ? $logo_font['font-style'] : "";
			
			// Font family
			if ( !empty($logo_family) && 'inherit' != $logo_family ) {
				$css .= '#site-logo a { font-family: '. $logo_family .'; }';
				$load_google_fonts[] = $logo_family;
			}
			
			// Font size
			if ( !empty($logo_size) ) {
				$css .= '#site-logo a { font-size: '. $logo_size .'; }';
			}
			
			// Font weight
			if ( !empty($logo_weight) ) {
				$css .= '#site-logo a { font-weight: '. $logo_weight .' }';
			}
			
			// Font color
			if ( !empty($logo_color) ) {
				$css .= '#site-logo a { color: '. $logo_color .' }';
			}

			// Font Style
			if ( !empty($font_style) && 'inherit' != $font_style ) {
				$css .= '#site-logo a { font-style: '. $font_style .' }';
			}
			
		}
		
		
		/*------------------------------------------------*/
		/* Menu
		/*------------------------------------------------*/
		$menu_font = wpex_option( 'menu_font' );
		if ( !empty($menu_font) ) {
			
			// Vars
			$menu_family = isset($menu_font['font-family']) ? $menu_font['font-family'] : "";
			$menu_size = isset($menu_font['font-size']) ? $menu_font['font-size'] : "";
			$menu_weight = isset($menu_font['font-weight']) ? $menu_font['font-weight'] : "";
			$font_style = isset($menu_font['font-style']) ? $menu_font['font-style'] : "";
			
			// Font family
			if ( !empty($menu_family) && 'inherit' != $menu_family ) {
				$css .= '#site-navigation .sf-menu a { font-family: '. $menu_family .'; }';
				$load_google_fonts[] = $menu_family;
			}
			
			// Font size
			if ( !empty($menu_size) ) {
				$css .= '#site-navigation .sf-menu a { font-size: '. $menu_size .'; }';
			}
			
			// Font weight
			if ( !empty($menu_weight) ) {
				$css .= '#site-navigation .sf-menu a { font-weight: '. $menu_weight .' }';
			}

			// Font Style
			if ( !empty($font_style) && 'inherit' != $font_style ) {
				$css .= '#site-navigation .sf-menu a { font-style: '. $font_style .' }';
			}

		}
		
		
		/*------------------------------------------------*/
		/* Menu Dropdowns
		/*------------------------------------------------*/
		$menu_dropdown_font = wpex_option( 'menu_dropdown_font' );
		if ( !empty($menu_dropdown_font) ) {
			
			// Vars	
			$menu_dropdown_family = isset($menu_dropdown_font['font-family']) ? $menu_dropdown_font['font-family'] : "";
			$menu_dropdown_size = isset($menu_dropdown_font['font-size']) ? $menu_dropdown_font['font-size'] : "";
			$menu_dropdown_weight = isset($menu_dropdown_font['font-weight']) ? $menu_dropdown_font['font-weight'] : "";
			$font_style = isset($menu_dropdown_font['font-style']) ? $menu_dropdown_font['font-style'] : "";
			
			// Font family
			if ( !empty($menu_dropdown_family) && 'inherit' != $menu_dropdown_family ) {
				$css .= '#site-navigation .sf-menu ul a { font-family: '. $menu_dropdown_family .'; }';
				$load_google_fonts[] = $menu_dropdown_family;
			}
			
			// Font size
			if ( !empty($menu_dropdown_size) ) {
				$css .= '#site-navigation .sf-menu ul a { font-size: '. $menu_dropdown_size .'; }';
			}
			
			// Font weight
			if ( !empty($menu_dropdown_weight) ) {
				$css .= '#site-navigation .sf-menu ul a { font-weight: '. $menu_dropdown_weight .' }';
			}

			// Font Style
			if ( !empty($font_style) && 'inherit' != $font_style ) {
				$css .= '#site-navigation .sf-menu ul a { font-style: '. $font_style .' }';
			}

		}
		
		
		/*------------------------------------------------*/
		/* Page Titles
		/*------------------------------------------------*/
		$page_header_font = wpex_option( 'page_header_font' );
		if ( !empty($page_header_font) ) {
			
			// Vars
			$page_header_family = isset($page_header_font['font-family']) ? $page_header_font['font-family'] : "";
			$page_header_size = isset($page_header_font['font-size']) ? $page_header_font['font-size'] : "";
			$page_header_weight = isset($page_header_font['font-weight']) ? $page_header_font['font-weight'] : "";
			$page_header_color = isset($page_header_font['color']) ? $page_header_font['color'] : "";
			$font_style = isset($page_header_font['font-style']) ? $page_header_font['font-style'] : "";
			
			// Font family
			if ( !empty($page_header_family) && 'inherit' != $page_header_family ) {
				$css .= '.page-header-title { font-family: '. $page_header_family .'; }';
				$load_google_fonts[] = $page_header_family;
			}
			
			// Font size
			if ( !empty($page_header_size) ) {
				$css .= '.page-header-title { font-size: '. $page_header_size .'; }';
			}
			
			// Font weight
			if ( !empty($page_header_weight) ) {
				$css .= '.page-header-title { font-weight: '. $page_header_weight .' }';
			}
			
			// Font color
			if ( !empty($page_header_color) ) {
				$css .= '.page-header-title { color: '. $page_header_color .' }';
			}

			// Font Style
			if ( !empty($font_style) && 'inherit' != $font_style ) {
				$css .= '.page-header-title { font-style: '. $font_style .' }';
			}

		}
		
		// Return trimmed CSS
		if ( 'css' == $return && $css ) {
			return preg_replace( '/\s+/', ' ', $css );
		}

		// Return Google Fonts
		if ( 'google_fonts' == $return && $load_google_fonts ) {
			return array_unique($load_google_fonts);
		}
		
	}
	
}


/**
	Standard Fonts Array
**/
if ( !function_exists( 'wpex_standard_fonts' ) ) {
	function wpex_standard_fonts() {
		return array(
			"Arial, Helvetica, sans-serif",
			"'Arial Black', Gadget, sans-serif",
			"'Bookman Old Style', serif",
			"'Comic Sans MS', cursive",
			"Courier, monospace",
			"Garamond, serif",
			"Georgia, serif",
			"Impact, Charcoal, sans-serif",
			"'Lucida Console', Monaco, monospace",
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"'MS Sans Serif', Geneva, sans-serif",
			"'MS Serif', 'New York', sans-serif",
			"'Palatino Linotype', 'Book Antiqua', Palatino, serif",
			"Tahoma, Geneva, sans-serif",
			"Tahoma,Geneva, sans-serif",
			"'Times New Roman', Times, serif",
			"'Trebuchet MS', Helvetica, sans-serif",
			"Verdana, Geneva, sans-serif",
			"Tahoma,Geneva",
			"Garamond, serif",
			"'Bookman Old Style'",
			"Tahoma,Geneva",
			"Verdana",
			"Comic Sans",
			"Courier, monospace",
			"'Arial Black'",
			"Arial",
			"'Comic Sans MS'",
			"Courier",
			"Georgia",
			"Paratina Linotype",
			"Trebuchet MS",
			"Times New Roman",
			"'Times New Roman', Times,serif",
		);
	}
}


/**
	Get Active Google Font Scripts
**/
if ( !function_exists( 'wpex_active_googlefont_scripts' ) ) {
	function wpex_active_googlefont_scripts() {
		$fonts = wpex_typography( 'google_fonts' );
		$std_fonts = wpex_standard_fonts();
		$scripts = array();
		if ( $fonts ) {
			foreach ( $fonts as $font ) {
				//echo $font .'<br />';
				if ( !in_array( $font, $std_fonts ) ) {
					$scripts[] = 'https://fonts.googleapis.com/css?family='.str_replace(' ', '%20', $font ).'';
				}
			}
			return $scripts;
		} else {
			return false;
		}
	}
}


/**
	Load Google Fonts For CSS
**/
if ( !function_exists( 'wpex_load_fonts' ) ) {
	function wpex_load_fonts() {
		$scripts = wpex_active_googlefont_scripts();
		if ( ! $scripts ) return;
		$output = '<!-- TOTAL - Google Fonts -->';
		foreach ( $scripts as $script ) {
			$output .= '<link href="'. $script .':300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic" rel="stylesheet" type="text/css">';
		}
		echo $output;
	}
}
add_action( 'wp_head', 'wpex_load_fonts' );


/**
	Add Google Fonts That Are loaded into The Editor - SWEET!
**/
if ( ! function_exists( 'wpex_mce_google_fonts_array' ) ) {
	function wpex_mce_google_fonts_array( $initArray ) {
		// Get Fonts List
		$fonts = wpex_typography( 'google_fonts' );
		$fonts_array = array();
		if ( is_array($fonts) && !empty($fonts) ) {
			foreach ( $fonts as $font ) {
				$fonts_array[] = $font .'=' . $font;
			}
			$fonts = implode( ';', $fonts_array );
			// Add Fonts To MCE
			if ( $fonts ) {
				$initArray['font_formats'] = $fonts .';Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats';
			}
		}
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_google_fonts_array' );


/**
	Add Google Scripts for use with the editor
**/
if ( ! function_exists( 'wpex_mce_google_fonts_styles' ) ) {
	function wpex_mce_google_fonts_styles() {
		if ( ! wpex_option( 'load_google_fonts_admin', '1' ) ) return;
		$scripts = wpex_active_googlefont_scripts();
		if ( ! $scripts ) return;
		if ( is_array( $scripts ) && !empty($scripts) ) {
			foreach ( $scripts as $script ) {
				add_editor_style( str_replace( ',', '%2C', $script ) );
			}
		}
	}
}
add_action( 'init', 'wpex_mce_google_fonts_styles' );
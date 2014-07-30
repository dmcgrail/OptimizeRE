<?php
/**
 * Add more buttons to the MCE editor
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Only needed in the admin
if( ! is_admin() ) return;

// Enable font size buttons in the editor
if ( !function_exists( 'wpex_mce_buttons' ) ) {
	function wpex_mce_buttons( $buttons ) {
		//$buttons[] = 'fontselect';
		//$buttons[] = 'fontsizeselect';
		if ( wpex_supports( 'mce', 'fontselect' ) ) {
			array_unshift( $buttons, 'fontselect' );
		}
		if ( wpex_supports( 'mce', 'fontsizeselect' ) ) {
			array_unshift( $buttons, 'fontsizeselect' );
		}
		return $buttons;
	}
}
add_filter( 'mce_buttons_2', 'wpex_mce_buttons' );

// Customize mce editor font sizes
if ( !function_exists( 'wpex_customize_text_sizes' ) ) {
	function wpex_customize_text_sizes( $initArray ){
		if ( ! wpex_supports( 'mce', 'fontsizeselect' ) ) return $initArray;
		$wp_version = get_bloginfo( 'version' );
		if ( $wp_version >= 3.9 ) {
			$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
		} elseif ( $wp_version < 3.9 ) {
			$initArray['theme_advanced_font_sizes'] = "9px,10px,12px,13px,14px,16px,18px,21px,24px,28px,32px,36px";
		}
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'wpex_customize_text_sizes' );

// Add "Styles" / "Formats" (3.9+) drop-down
if ( !function_exists( 'wpex_style_select' ) ) {
	function wpex_style_select( $buttons ) {
		if ( ! wpex_supports( 'mce', 'formats' ) ) return $buttons;
		array_push( $buttons, 'styleselect' );
		return $buttons;
	}
}
add_filter( 'mce_buttons', 'wpex_style_select' );

// Add "Styles" drop-down content or classes 
if ( ! function_exists( 'wpex_styles_dropdown' ) ) {
	function wpex_styles_dropdown( $settings ) {

		if ( ! wpex_supports( 'mce', 'formats' ) ) return $settings;

		// Get WP Version
		$wp_version = get_bloginfo( 'version' );

		// WP 3.9+
		if ( $wp_version >= 3.9 ) {

			// Create array of formats
			$new_formats = array(
				// Total Buttons
				array(
					'title'	=> WPEX_THEME_BRANDING .' '. __( 'Styles', 'wpex' ),
					'items'	=> array(
						array(
							'title'		=> __('Theme Button','wpex'),
							'selector'	=> 'a',
							'classes'	=> 'theme-button'
						),
						array(
							'title'		=> __('Highlight','wpex'),
							'inline'	=> 'span',
							'classes'	=> 'text-highlight',
						),
						array(
							'title'		=> __('Thin Font','wpex'),
							'inline'	=> 'span',
							'classes'	=> 'thin-font'
						),
						array(
							'title'		=> __('White Text','wpex'),
							'inline'	=> 'span',
							'classes'	=> 'white-text'
						),
					),
				),
			);

			// Merge Formats
			$settings['style_formats_merge'] = true;

			// Add new formats
			$settings['style_formats'] = json_encode( $new_formats );


		// Pre WP 3.9
		} else {
			if ( !empty( $settings['theme_advanced_styles'] ) ) {
				$settings['theme_advanced_styles'] .= ';';
			} else {
				$settings['theme_advanced_styles'] = '';
			}
			$classes = array(
				__( 'Theme Button','wpex' )		=> 'theme-button',
				__( 'Highlight','wpex' )		=> 'text-highlight',
				__( 'Thin Font','wpex' )		=> 'thin-font',
				__( 'White Text','wpex' )		=> 'white-text',
			);
			$class_settings = '';
			foreach ( $classes as $name => $value ) {
				$class_settings .= "{$name}={$value};";
			}
			$settings['theme_advanced_styles'] .= trim( $class_settings, '; ' );
		}

		// Return New Settings
		return $settings;

	}
}

add_filter('tiny_mce_before_init', 'wpex_styles_dropdown');
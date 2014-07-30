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

if ( ! function_exists( 'wpex_redux_styling_options' ) ) {
	function wpex_redux_styling_options() {
		global $wpex_redux_framework_class;
		if ( ! method_exists( $wpex_redux_framework_class, 'getReduxSections' ) ) return;
		$styling_options = array();
		$sections = $wpex_redux_framework_class->getReduxSections();
		if ( isset ( $sections ) ) {
			foreach ($sections as $section) {
				if( isset( $section['fields'] ) ) {
					foreach( $section['fields'] as $field ) {

						// Colors
						if ( isset( $field['type'] ) && $field['type'] == 'color' ) {
							$target_element = isset($field['target_element']) ? $field['target_element'] : '';
							$target_style = isset($field['target_style']) ? $field['target_style'] : '';
							$default = isset($field['default']) ? $field['default'] : '';
							$styling_options[] = array(
								'title'				=> $field['title'],
								'default'			=> $default,
								'type'				=> $field['type'],
								'id'				=> $field['id'],
								'target_element'	=> $target_element,
								'target_style'		=> $target_style,
							);
						}

						// Color Gradients
						if ( isset( $field['type'] ) && $field['type'] == 'color_gradient' ) {
							$target_element = isset($field['target_element']) ? $field['target_element'] : '';
							$styling_options[] = array(
								'title'				=> $field['title'],
								'default'			=> $field['default'],
								'type'				=> $field['type'],
								'id'				=> $field['id'],
								'target_element'	=> $target_element,
							);
						}

						// Link Color
						if ( isset( $field['type'] ) && $field['type'] == 'link_color' ) {
							$default = isset( $field['default'] ) ? $field['default'] : '';
							$target_element = isset( $field['target_element'] ) ? $field['target_element'] : '';
							$target_element_hover = isset( $field['target_element_hover'] ) ? $field['target_element_hover'] : '';
							$target_element_active = isset( $field['target_element_active'] ) ? $field['target_element_active'] : '';
							$target_style = isset( $field['target_style'] ) ? $field['target_style'] : '';
							$styling_options[] = array(
								'title'						=> $field['title'],
								'default'					=> $default,
								'type'						=> $field['type'],
								'id'						=> $field['id'],
								'target_element'			=> $target_element,
								'target_element_hover'		=> $target_element_hover,
								'target_element_active'		=> $target_element_active,
								'target_style'				=> $target_style,
							);
						}
					}
				}
			}
			return $styling_options;
		}
	}
}

/**
 * Loops through styling options and create custom CSS
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( !function_exists( 'wpex_styling_css' ) ) {
	function wpex_styling_css() {

		if ( !wpex_redux_styling_options() ) return;

		//Vars
		$css ='';
		$header_style = wpex_option( 'header_style' );
		$site_theme = wpex_option('site_theme','default');
		$main_layout_style = wpex_option('main_layout_style');
		
		// Return if custom styling is disabled
		if ( '1' != wpex_option( 'custom_styling', '1' ) ) return;
		
		// Boxed Drop-Shadow
		if ( 'boxed' == $main_layout_style ) {
			$boxed_dropdshadow = wpex_option('boxed_dropdshadow','1');
			if ( '1' != $boxed_dropdshadow ) {
				$css .= '.boxed-main-layout #wrap { box-shadow: none; -moz-box-shadow: none; -webkit-box-shadow: none; }';
			}
		}

		// Color Options
		// Loops through all theme options and outputs the correct CSS
		$styling_options = wpex_redux_styling_options();

		foreach( $styling_options as $option ) {

			$value = wpex_option( $option['id'] );
			$type = isset( $option['type'] ) ? $option['type'] : '';
			$target_style = isset( $option['target_style'] ) ? $option['target_style'] : '';
			$target_element = isset( $option['target_element'] ) ? $option['target_element'] : '';
			
			if ( '' != $value ) {

				//Colors
				if ( 'color' == $type ) {
					if ( $target_element && $target_style ) {
						if ( is_array( $target_style ) ) {
							foreach ( $target_style as $key ) {
								$css .= $target_element .'{
									'. $key .':'. $value .';
								}';
							}
						} else {
							$css .= $target_element .'{
								'. $target_style .':'. $value .';
							}';
						}
					}
				}

				// Gradients
				if ( 'color_gradient' == $type && !empty($value) ) {
					if ( $target_element ) {
						$from = isset( $value['from'] ) ? $value['from'] : '';
						$to = isset( $value['to'] ) ? $value['to'] : '';
						if ( $from && $to ) {
							$css .= $target_element .'{
								background: '. $to .';
								background: -webkit-linear-gradient('. $from .','. $to .');
								background: -moz-linear-gradient('. $from .','. $to .');
								background: -o-linear-gradient('. $from .','. $to .');
								background: linear-gradient('. $from .','. $to .');
							}';
						} elseif( $from ) {
							$css .= $target_element .'{
								background: '. $from .';
							}';
						}
					}
				}

				// Link Color
				if ( 'link_color' == $type ) {
					$style = $target_style;
					$regular = isset( $value['regular'] ) ? $value['regular'] : '';
					$hover = isset( $value['hover'] ) ? $value['hover'] : '';
					$active = isset( $value['active'] ) ? $value['active'] : '';
					if ( $target_element && $regular ) {
						$css .= $target_element .'{'. $style .':'. $regular .';}';
					}
					if ( $option['target_element_hover'] && $hover ) {
						$css .= $option['target_element_hover'] .'{'. $style .':'. $hover .';}';
					}
					if ( $option['target_element_active'] && $active ) {
						$css .= $option['target_element_active'] .'{'. $style .':'. $active .';}';
					}
				}

			}
		}

		// Dropdown bg
		$dropdown_menu_background = wpex_option( 'dropdown_menu_background' );
		if ( $dropdown_menu_background ) {
			$css .= '.navbar-style-one .dropdown-menu ul:after { border-bottom-color: '. $dropdown_menu_background .'; }';
		}
		
		// Scroll top border radius
		$scroll_top_radius = wpex_option( 'scroll_top_border_radius' );
		if ( $scroll_top_radius && '35px'!= $scroll_top_radius ) {
			$scroll_top_radius = intval($scroll_top_radius);
			$scroll_top_radius = $scroll_top_radius.'px';
			$css .= '#site-scroll-top { border-radius:'. $scroll_top_radius .'; }';
		}
		
		// Woo Overlay
		$woo_shop_overlay_top_margin = wpex_option( 'woo_shop_overlay_top_margin' );
		$woo_shop_overlay_top_margin = intval($woo_shop_overlay_top_margin);
		if ( $woo_shop_overlay_top_margin ) {
			$css .= '#current-shop-items { top:'. $woo_shop_overlay_top_margin .'px; }';
		}
		
		// Search Overlay
		$main_search_overlay_top_margin = wpex_option( 'main_search_overlay_top_margin' );
		$main_search_overlay_top_margin = intval($main_search_overlay_top_margin);
		if ( $main_search_overlay_top_margin ) {
			$css .= '#searchform-overlay { top:'. $main_search_overlay_top_margin .'px; }';
		}
		
		// Mobile Menu Icon Font Size
		$mobile_menu_icon_size = wpex_option( 'mobile_menu_icon_size' );
		if ( $mobile_menu_icon_size !== '' ) {
			$css .= '#mobile-menu a { font-size:'. $mobile_menu_icon_size .'; }';
		}

		// Callout button border radius
		$callout_button_border_radius = wpex_option( 'callout_button_border_radius' );
		$callout_button_border_radius = intval($callout_button_border_radius);
		if ( $callout_button_border_radius ) {
			$css .= '.footer-callout-button { border-radius:'. $callout_button_border_radius .'px; }';
		}

		// Header opacity
		$fixed_header_opacity = wpex_option('fixed_header_opacity');
		if ( $fixed_header_opacity ) {
			$css .= '.is-sticky #site-header { opacity:'. $fixed_header_opacity .'; }';
		}

		// Sidebar border
		$sidebar_border = wpex_option('sidebar_border');
		$sidebar_border_top = isset($sidebar_border['border-top']) ? $sidebar_border['border-top'] : '';
		$sidebar_border_right = isset($sidebar_border['border-right']) ? $sidebar_border['border-right'] : '';
		$sidebar_border_bottom = isset($sidebar_border['border-bottom']) ? $sidebar_border['border-bottom'] : '';
		$sidebar_border_left = isset($sidebar_border['border-left']) ? $sidebar_border['border-left'] : '';
		$sidebar_border_color = isset($sidebar_border['border-color']) ? $sidebar_border['border-color'] : 'inherit';
		$sidebar_border_style = isset($sidebar_border['border-style']) ? $sidebar_border['border-style'] : 'inherit';

		if ( 'none' != $sidebar_border_style ) {
			if ( $sidebar_border_top ) {
				$css .= '#sidebar { border-top:'. $sidebar_border_top .' '. $sidebar_border_style .' '. $sidebar_border_color .'; }';
			}

			if ( $sidebar_border_right ) {
				$css .= '#sidebar { border-right:'. $sidebar_border_right .' '. $sidebar_border_style .' '. $sidebar_border_color .'; }';
			}

			if ( $sidebar_border_bottom ) {
				$css .= '#sidebar { border-bottom:'. $sidebar_border_bottom .' '. $sidebar_border_style .' '. $sidebar_border_color .'; }';
			}

			if ( $sidebar_border_left ) {
				$css .= '#sidebar { border-left: '. $sidebar_border_left .' '. $sidebar_border_style .' '. $sidebar_border_color .'; }';
			}
		}

		// Footer border
		$footer_border = wpex_option('footer_border');
		$footer_border_top = isset($footer_border['border-top']) ? $footer_border['border-top'] : '';
		$footer_border_right = isset($footer_border['border-right']) ? $footer_border['border-right'] : '';
		$footer_border_bottom = isset($footer_border['border-bottom']) ? $footer_border['border-bottom'] : '';
		$footer_border_left = isset($footer_border['border-left']) ? $footer_border['border-left'] : '';
		$footer_border_color = isset($footer_border['border-color']) ? $footer_border['border-color'] : 'inherit';
		$footer_border_style = isset($footer_border['border-style']) ? $footer_border['border-style'] : 'inherit';

		if ( 'none' != $footer_border_style ) {
			if ( $footer_border_top ) {
				$css .= '#footer { border-top:'. $footer_border_top .' '. $footer_border_style .' '. $footer_border_color .'; }';
			}

			if ( $footer_border_right ) {
				$css .= '#footer { border-right:'. $footer_border_right .' '. $footer_border_style .' '. $footer_border_color .'; }';
			}

			if ( $footer_border_bottom ) {
				$css .= '#footer { border-bottom:'. $footer_border_bottom .' '. $footer_border_style .' '. $footer_border_color .'; }';
			}

			if ( $footer_border_left ) {
				$css .= '#footer { border-left: '. $footer_border_left .' '. $footer_border_style .' '. $footer_border_color .'; }';
			}
		}

		// Footer bottom border
		$bottom_footer_border = wpex_option('bottom_footer_border');
		$bottom_footer_border_top = isset($bottom_footer_border['border-top']) ? $bottom_footer_border['border-top'] : '';
		$bottom_footer_border_right = isset($bottom_footer_border['border-right']) ? $bottom_footer_border['border-right'] : '';
		$bottom_footer_border_bottom = isset($bottom_footer_border['border-bottom']) ? $bottom_footer_border['border-bottom'] : '';
		$bottom_footer_border_left = isset($bottom_footer_border['border-left']) ? $bottom_footer_border['border-left'] : '';
		$bottom_footer_border_color = isset($bottom_footer_border['border-color']) ? $bottom_footer_border['border-color'] : 'inherit';
		$bottom_footer_border_style = isset($bottom_footer_border['border-style']) ? $bottom_footer_border['border-style'] : 'inherit';

		if ( 'none' != $bottom_footer_border_style ) {
			if ( $bottom_footer_border_top ) {
				$css .= '#footer-bottom { border-top:'. $bottom_footer_border_top .' '. $bottom_footer_border_style .' '. $bottom_footer_border_color .'; }';
			}

			if ( $bottom_footer_border_right ) {
				$css .= '#footer-bottom { border-right:'. $bottom_footer_border_right .' '. $bottom_footer_border_style .' '. $bottom_footer_border_color .'; }';
			}

			if ( $bottom_footer_border_bottom ) {
				$css .= '#footer-bottom { border-bottom:'. $bottom_footer_border_bottom .' '. $bottom_footer_border_style .' '. $bottom_footer_border_color .'; }';
			}

			if ( $bottom_footer_border_left ) {
				$css .= '#footer-bottom { border-left: '. $bottom_footer_border_left .' '. $bottom_footer_border_style .' '. $bottom_footer_border_color .'; }';
			}
		}
		
		// Return Custom CSS
		if ( '' != $css ) {
			$css = '/*Styling CSS START*/'. $css .'/*Styling CSS END*/';
			return $css;
		} else {
			return '';
		}
		
	}
}
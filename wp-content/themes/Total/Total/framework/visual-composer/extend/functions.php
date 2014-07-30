<?php
/**
 * Creates a Font Icon selector for the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.52
*/
if ( !function_exists( 'wpex_font_awesome_vc_field' ) ) {
	function wpex_font_awesome_vc_field( $settings, $value ) {
		$dependency = vc_generate_dependencies_attributes($settings);
		$return = '<div class="my_param_block">'
			. '<style>
				.vcex-font-awesome-icon-select-window span { background:#f9f9f9;display:block;float:left;height:40px;line-height:40px;width:40px;text-align:center;padding:5px;vertical-align:middle;border:1px solid #ddd;margin:2px;cursor:pointer;box-sizing:content-box;float:left;}.vcex-font-awesome-icon-select-window span.active {background: #222;color:#fff;border-color: transparent;}
				.vcex-font-awesome-icon-select-window span:hover { background#fff; color:#000; border-color:#ccc; }
				.vcex-font-awesome-icon-select-window span.active:hover {background: #222;color:#fff; border-color: transparent; }
				</style>
				<div class="vcex-font-awesome-icon-preview" style="display: block;
					margin-right: 10px;
					height: 60px;
					width: 90px;
					text-align: center;
					background: #FAFAFA;
					font-size: 60px;
					padding: 15px 0;
					margin-bottom: 10px;
					border: 1px solid #DDD;
					float: left;
					box-sizing: content-box;"></div>
				<input placeholder="' . __( "Type in an icon name or select one from below", 'wpex' ) . '" name="' . $settings['param_name'] . '"'
			. ' data-param-name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'].' '.$settings['type'].'_field" type="text" value="'. $value .'" ' . $dependency . ' style="width: 100%; vertical-align: top; margin-bottom: 10px" />';
			$return .= '<div class="vcex-font-awesome-icon-select-window" style="display: block; font-size:32px; width: 100%; padding: 8px;
				box-sizing: border-box;
				-moz-box-sizing: border-box;
				background: #e6e6e6;
				height: 250px;
				overflow-y: scroll;
				border: 1px solid #DDD;
				clear: both"><span class="fa fa-times" style="color:red;" data-name="clear"></span>';
				$icons = wpex_get_awesome_icons();
				foreach ( $icons as $icon ) {
					if ( '' != $icon ) {
						if ( $value == $icon ) {
							$active = 'active';
						} else {
							$active = '';
						}
						$return .= '<span class="fa fa-'. $icon .' '. $active .'" data-name="'. $icon .'"></span>';
					}
				}
				$return .= '</div>
			</div><div style="clear:both;"></div>';
			return $return;
	}
}
if ( function_exists( 'wpex_font_awesome_vc_field' ) && function_exists( 'add_shortcode_param' ) ) {
	add_shortcode_param( 'vcex_icon', 'wpex_font_awesome_vc_field', WPEX_VCEX_DIR_URI .'assets/icon-type.js' );
}

/**
 * Outputs custom excerpt for VC extensions
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.4
*/
if ( !function_exists( 'vcex_excerpt' ) ) {
	function vcex_excerpt( $array = array() ) {

		// Set main function vars
		$length = isset( $array['length'] ) ? $array['length'] : '30';
		$readmore = isset( $array['readmore'] ) ? $array['readmore'] : false;
		$read_more_text = isset( $array['read_more_text'] ) ? $array['read_more_text'] : __( 'view post', 'wpex' );
		$post_id = isset( $array['post_id'] ) ? $array['post_id'] : '';
		$trim_custom_excerpts = isset( $array['trim_custom_excerpts'] ) ? $array['trim_custom_excerpts'] : '30';

		global $post;
		$id = $post_id ? $post_id : $post->ID;
		$custom_excerpt = $post->post_excerpt;
		$output = '';
		// Display password protected error
		if ( post_password_required( $id ) ) {
			$password_protected_excerpt = __( 'This is a password protected post.', 'wpex' );
			$password_protected_excerpt = apply_filters( 'wpex_password_protected_excerpt', $password_protected_excerpt );
			echo '<p>'. $password_protected_excerpt .'</p>'; return;
		}
		// Return The Excerpt
		if ( '0' != $length ) {
			// Custom Excerpt
			if ( $custom_excerpt ) {
				if ( '-1' ==  $length || ! $trim_custom_excerpts ) {
					$output = apply_filters( 'the_content', $custom_excerpt );
				} else {
					$custom_excerpt = wp_trim_words( $custom_excerpt, $length );
					$output = apply_filters( 'the_content', $custom_excerpt );
				}
			} else {
				// Get post content
				$post_content = get_the_content( $id );
				// Return the content
				if ( '-1' ==  $length ) {
					return apply_filters( 'the_content', $post_content );
				}
				// Excerpt length
				$meta_excerpt = get_post_meta( $id, 'vcex_excerpt_length', true );
				$length = $meta_excerpt ? $meta_excerpt : $length;
				// Check if text shortcode in post
				if ( strpos( $post_content, '[vc_column_text]') ) {
					$pattern = '{\[vc_column_text\](.*?)\[/vc_column_text\]}is';
					preg_match( $pattern, $post_content, $match );
					if( isset( $match[1] ) ) {
						//$excerpt = str_replace('[vc_column_text]', '', $match[0] );
						//$excerpt = str_replace('[/vc_column_text]', '', $excerpt );
						$excerpt = wp_trim_words( $match[1], $length );
					} else {
						$content = strip_shortcodes( $post_content );
						$excerpt = wp_trim_words( $content, $length );
					}
				} else {
					$content = strip_shortcodes( $post_content );
					$excerpt = wp_trim_words( $content, $length );
				}
				// Output Excerpt
				$output .= '<p>'. $excerpt .'</p>';
			}

			// Readmore link
			if ( $readmore ) {
				$readmore_link = '<a href="'. get_permalink( $id ) .'" title="'.$read_more_text .'" rel="bookmark" class="vcex-readmore theme-button">'. $read_more_text .' <span class="vcex-readmore-rarr">&rarr;</span></a>';
				$output .= apply_filters( 'vcex_readmore_link', $readmore_link );
			}
			
			// Output
			echo $output;
		}
	}
}

/**
 * Get custom excerpt for VC extensions
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.4
*/
if ( !function_exists( 'vcex_get_excerpt' ) ) {
	function vcex_get_excerpt( $array = array() ) {

		// Set main function vars
		$length = isset( $array['length'] ) ? $array['length'] : '30';
		$readmore = isset( $array['readmore'] ) ? $array['readmore'] : false;
		$read_more_text = isset( $array['read_more_text'] ) ? $array['read_more_text'] : __( 'view post', 'wpex' );
		$post_id = isset( $array['post_id'] ) ? $array['post_id'] : '';
		$trim_custom_excerpts = isset( $array['trim_custom_excerpts'] ) ? $array['trim_custom_excerpts'] : '30';

		global $post;
		$id = $post_id ? $post_id : $post->ID;
		$custom_excerpt = $post->post_excerpt;
		$output = '';

		// Display password protected error
		if ( post_password_required( $id ) ) {
			$password_protected_excerpt = __( 'This is a password protected post.', 'wpex' );
			$password_protected_excerpt = apply_filters( 'wpex_password_protected_excerpt', $password_protected_excerpt );
			return '<p>'. $password_protected_excerpt .'</p>';
		}
		// Return Excerpt
		if ( '0' != $length ) {
			// Custom Excerpt
			if ( $custom_excerpt ) {
				if ( '-1' ==  $length || ! $trim_custom_excerpts ) {
					$output = apply_filters( 'the_content', $custom_excerpt );
				} else {
					$custom_excerpt = wp_trim_words( $custom_excerpt, $length );
					$output = apply_filters( 'the_content', $custom_excerpt );
				}
			} else {
				// Get the content
				$post_content = get_the_content( $id );
				// Return the content
				if ( '-1' ==  $length ) {
					return apply_filters( 'the_content', $post_content );
				}
				// Excerpt length
				$meta_excerpt = get_post_meta( $id, 'vcex_excerpt_length', true );
				$length = $meta_excerpt ? $meta_excerpt : $length;
				// Check if text shortcode in post
				if ( strpos( $post_content, '[vc_column_text]') ) {
					$pattern = '{\[vc_column_text\](.*?)\[/vc_column_text\]}is';
					preg_match( $pattern, $post_content, $match );
					if( isset( $match[1] ) ) {
						//$excerpt = str_replace('[vc_column_text]', '', $match[0] );
						//$excerpt = str_replace('[/vc_column_text]', '', $excerpt );
						$excerpt = wp_trim_words( $match[1], $length );
					} else {
						$content = strip_shortcodes( $post_content );
						$excerpt = wp_trim_words( $content, $length );
					}
				} else {
					$content = strip_shortcodes( $post_content );
					$excerpt = wp_trim_words( $content, $length );
				}
				// Output Excerpt
				$output .= '<p>'. $excerpt .'</p>';
			}

			// Readmore link
			if ( $readmore == true ) {
				$readmore_link = '<a href="'. get_permalink( $id ) .'" title="'.$read_more_text .'" rel="bookmark" class="vcex-readmore theme-button">'. $read_more_text .' <span class="vcex-readmore-rarr">&rarr;</span></a>';
				$output .= apply_filters( 'vcex_readmore_link', $readmore_link );
			}
			
			// Output
			return $output;
		}
	}
}

/**
 * Image filter styles VC extensions
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.4
*/
if ( !function_exists( 'vcex_image_filters' ) ) {
	function vcex_image_filters() {
		$filters = array (
			__('None','wpex')		=> 'none',
			__('Grayscale','wpex')	=> 'grayscale',
		);
		return apply_filters( 'vcex_image_filters', $filters );
	}
}

/**
 * Image hover styles VC extensions
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.4
*/
if ( !function_exists( 'vcex_image_hovers' ) ) {
	function vcex_image_hovers() {
		$hovers = array (
			__('None','wpex')			=> '',
			__('Grow','wpex')			=> 'grow',
			__('Shrink','wpex')			=> 'shrink',
			__('Side Pan','wpex')		=> 'side-pan',
			__('Vertical Pan','wpex')	=> 'vertical-pan',
			__('Tilt','wpex')			=> 'tilt',
			__('Normal - Blurr','wpex')	=> 'blurr',
			__('Blurr - Normal','wpex')	=> 'blurr-invert',
			__('Sepia','wpex')			=> 'sepia',
			__('Fade Out','wpex')		=> 'fade-out',
			__('Fade In','wpex')		=> 'fade-in',
		);
		return apply_filters( 'vcex_image_hovers', $hovers );
	}
}

/**
 * Image rendering VC extensions
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.4
*/
if ( !function_exists( 'vcex_image_rendering' ) ) {
	function vcex_image_rendering() {
		$render = array (
			__('Auto','wpex')			=> '',
			__('Crisp Edges','wpex')	=> 'crisp-edges',
		);
		return apply_filters( 'vcex_image_rendering', $render );
	}
}

/**
 * Overlays VC extensions
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.4
*/
if ( !function_exists( 'vcex_overlays_array' ) ) {
	function vcex_overlays_array( $style = 'default' ) {
		if ( !function_exists( 'wpex_overlay_styles_array' ) ) {
			return;
		}
		$overlays = wpex_overlay_styles_array( $style );
		if ( ! is_array( $overlays ) ) {
			return;
		}
		$overlays = array_flip( $overlays );
		return array(
			"type"			=> "dropdown",
			"class"			=> "",
			"heading"		=> __( "Image Overlay Style", 'wpex' ),
			"param_name"	=> "overlay_style",
			"value"			=> $overlays,
			'group'			=> __( 'Image', 'wpex' ),
		);
	}
}
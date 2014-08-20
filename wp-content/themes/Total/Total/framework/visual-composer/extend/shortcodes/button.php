<?php
/**
 * Registers the button shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if( !function_exists('vcex_button_shortcode') ) {
	function vcex_button_shortcode( $atts, $content = null ) {
		
		extract( shortcode_atts( array(
			'layout'					=> '',
			'style'						=> 'flat',
			'color'						=> 'blue',
			'custom_color'				=> '',
			'custom_background'			=> '',
			'custom_hover_background'	=> '',
			'custom_hover_color'		=> '',
			'url'						=> 'http://www.vcexplorer.com',
			'title'						=> __('Visit Site', 'wpex' ),
			'target'					=> 'self',
			'size'						=> 'normal',
			'font_weight'				=> '',
			'text_transform'			=> '',
			'font_size'					=> '',
			'letter_spacing'			=> '',
			'font_padding'				=> '',
			'align'						=> 'alignleft',
			'rel'						=> '',
			'border_radius'				=> '',
			'class'						=> '',
			'icon_left'					=> '',
			'icon_right'				=> '',
			'css_animation'				=> '',
			'icon_left_padding'			=> '',
			'icon_right_padding'		=> '',
		), $atts ) );

		ob_start();
		
		// Rel
		$rel = ( 'none' != $rel ) ? 'rel="'. $rel .'"' : NULL;

		// Classes
		$classes = 'vcex-button';
		if ( $layout ) {
			$classes .= ' '. $layout;
		}
		$classes .= ' '. $style;
		$classes .= ' align-'. $align;
		if ( $size ) {
			$classes .= ' '. $size;
		}
		if ( $text_transform ) {
			$classes .= ' text-transform-'. $text_transform;
		}
		if ( $color ) {
			$classes .= ' '. $color;
		}
		if ( $class ) {
			$classes .= ' '. $class;
		}
		if ( $css_animation ) {
			$classes .= ' wpb_animate_when_almost_visible wpb_'. $css_animation .'';
		}

		// Wrap classes
		$wrap_classes = '';
		if ( 'center' == $align ) {
			$wrap_classes = 'textcenter ';
		}
		if ( 'block' == $layout ){
			$wrap_classes .= 'vcex-button-block-wrap';
		}
		if ( 'expanded' == $layout ){
			$wrap_classes .= 'vcex-button-expanded-wrap';
		}

		// Original styles
		$original_color = '#fff';
		
		// Custom Style
		$inline_style = '';
		if ( $custom_background && in_array( $style, array( 'flat', 'graphical', 'three-d' ) ) ) {
			$inline_style .= 'background:'. $custom_background .';';
		}
		if ( $custom_color ) {
			$inline_style .= 'color:'. $custom_color .';';
			$original_color = $custom_color;
			if ( 'outline' == $style ) {
				$inline_style .= 'border-color:'. $custom_color .';';
			}
		}
		if ( $letter_spacing ) {
			$inline_style .= 'letter-spacing:'. $letter_spacing .';';
		}
		if ( $font_size ) {
			$inline_style .= 'font-size:'. $font_size .';';
		}
		if ( $font_weight ) {
			$inline_style .= 'font-weight:'. $font_weight .';';
		}
		if ( $border_radius ) {
			$inline_style .= 'border-radius:'. $border_radius .';';
		}
		if ( $font_padding ) {
			$inline_style .= 'padding:'. $font_padding .';';
		}
		if ( $inline_style ) {
			$inline_style = 'style="'. $inline_style . '"';
		}

		// Data attributes
		$data_attr = '';
		if ( $custom_hover_background && in_array( $style, array( 'flat', 'graphical', 'three-d' ) ) ) {
			$data_attr .= 'data-hover-background="'. $custom_hover_background .'"';
			if ( $custom_background ) {
				$data_attr .= 'data-original-background="'. $custom_background .'"';
			}
		}
		if ( $custom_hover_color && in_array( $style, array( 'flat', 'graphical', 'three-d' ) ) ) {
			$data_attr .= 'data-hover-color="'. $custom_hover_color .'"';
			$data_attr .= 'data-original-color="'. $original_color .'"';
		}
		if ( $data_attr ) {
			$classes .= ' wpex-data-hover';
		}
		
		// Display Button
		if ( $wrap_classes ) { ?>
			<div class="<?php echo $wrap_classes; ?> clr">
		<?php } ?>
		<a href="<?php echo $url; ?>" class="<?php echo $classes; ?>" target="_<?php echo$target; ?>" title="<?php echo $title; ?>" <?php echo $inline_style; ?> <?php echo $rel; ?> <?php echo $data_attr; ?>>
			<span class="vcex-button-inner">
				<?php
				// Left Icon
				if ( $icon_left && 'none' !== $icon_left ) {
					if ( $icon_left_padding ) {
						$icon_left_padding = 'style="padding-right: '. $icon_left_padding .';"';
					} ?>
					<span class="vcex-button-icon-left fa fa-<?php echo $icon_left; ?>" <?php echo $icon_left_padding; ?>></span>
				<?php }
				// The button text
				echo $content; ?>
				<?php
				// Right Icon
				if ( $icon_right && 'none' != $icon_right ) {
					if ( $icon_right_padding ) {
						$icon_right_padding = 'style="padding-left: '. $icon_right_padding .';"';
					} ?>
					<span class="vcex-button-icon-right fa fa-<?php echo $icon_right; ?>" <?php echo $icon_right_padding; ?>></span>
				<?php } ?>
			</span>
		</a>
		<?php if ( $wrap_classes ) { ?>
			</div>
		<?php }

		return ob_get_clean();

	}
}
add_shortcode( 'vcex_button', 'vcex_button_shortcode' );

/**
 * Adds the button shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_button_shortcode_vc_map' ) ) {
	function vcex_button_shortcode_vc_map() {
		$font_awesome_css = wpex_font_awesome_css_url();
		vc_map( array(
			"name"					=> __( "Total Button", 'wpex' ),
			"description"			=> __( "Eye catching button", 'wpex' ),
			"base"					=> "vcex_button",
			'category'				=> WPEX_THEME_BRANDING,
			"icon"					=> "icon-wpb-vcex-button",
			'admin_enqueue_css'		=> $font_awesome_css,
			'front_enqueue_css'		=> $font_awesome_css,
			"params"				=> array(
				array(
					"type"			=> "textfield",
					"heading"		=> __( "URL", 'wpex' ),
					"param_name"	=> "url",
					"value"			=> "http://www.google.com/",
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Button Text", 'wpex' ),
					"param_name"	=> "content",
					"admin_label"	=> true,
					"value"			=> "Button Text",
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Link Title", 'wpex' ),
					"param_name"	=> "title",
					"value"			=> "Visit Site",
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __("CSS Animation", "wpex"),
					"param_name"	=> "css_animation",
					"value"			=> array(
					__("No", "wpex")						=> '',
						__("Top to bottom", "wpex")			=> "top-to-bottom",
						__("Bottom to top", "wpex")			=> "bottom-to-top",
						__("Left to right", "wpex")			=> "left-to-right",
						__("Right to left", "wpex")			=> "right-to-left",
						__("Appear from center", "wpex")	=> "appear"),
				),

				// Design
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Button Style", 'wpex' ),
					"param_name"	=> "style",
					"value"			=> array(
						__( "Flat", "wpex" )		=> "flat",
						__( "Graphical", "wpex")	=> "graphical",
						__( "Clean", "wpex")		=> "clean",
						__( "3D", "wpex" )			=> "three-d",
						__( "Outline", "wpex" )		=> "outline",
					),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __("Layout", "wpex"),
					"param_name"	=> "layout",
					"value"			=> array(
						__( "Inline", "wpex")						=> '',
						__( "Block", 'wpex' )						=> 'block',
						__( "Expanded (fit container)", "wpex" )	=> "expanded",
					),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Button Align", 'wpex' ),
					"param_name"	=> "align",
					"value"			=> array(
						__( "Left", "wpex")		=> "left",
						__( "Right", "wpex")	=> "right",
						__( "Center", "wpex" )	=> "center",
					),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Button Background", 'wpex' ),
					"param_name"	=> "color",
					"value"			=> array(
						__( "Black", "wpex")	=> "black",
						__( "Blue", "wpex" )	=> "blue",
						__( "Brown", "wpex" )	=> "brown",
						__( "Grey", "wpex" )	=> "grey",
						__( "Green", "wpex" )	=> "green",
						__( "Gold", "wpex" )	=> "gold",
						__( "Orange", "wpex" )	=> "orange",
						__( "Pink", "wpex" )	=> "pink",
						__( "Purple", "wpex" )	=> "purple",
						__( "Red", "wpex" ) 	=> "red",
						__( "Rosy", "wpex" )	=> "rosy",
						__( "Teal", "wpex" )	=> "teal",
						__( "White", "wpex")	=> "white",
					),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "colorpicker",
					"heading"		=> __( "Button Custom Background", 'wpex' ),
					"param_name"	=> "custom_background",
					'group'			=> __( 'Design', 'wpex' ),
					'dependency'	=> Array(
						'element'	=> "style",
						'value'		=> array( 'flat', 'graphical', 'three-d' ),
					),
				),
				array(
					"type"			=> "colorpicker",
					"heading"		=> __( "Button Custom Color", 'wpex' ),
					"param_name"	=> "custom_color",
					'group'			=> __( 'Design', 'wpex' ),
					'dependency'	=> Array(
						'element'	=> "style",
						'value'		=> array( 'flat', 'graphical', 'three-d', 'clean', 'outline' ),
					),
				),
				array(
					"type"			=> "colorpicker",
					"heading"		=> __( "Button Custom Hover Background", 'wpex' ),
					"param_name"	=> "custom_hover_background",
					'group'			=> __( 'Design', 'wpex' ),
					'dependency'	=> Array(
						'element'	=> "style",
						'value'		=> array( 'flat', 'graphical', 'three-d' ),
					),
				),
				array(
					"type"			=> "colorpicker",
					"heading"		=> __( "Button Custom Hover Color", 'wpex' ),
					"param_name"	=> "custom_hover_color",
					'group'			=> __( 'Design', 'wpex' ),
					'dependency'	=> Array(
						'element'	=> "style",
						'value'		=> array( 'flat' ),
					),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Button Size", 'wpex' ),
					"param_name"	=> "size",
					"value"			=> array(
						__( "Small", "wpex")	=> "small",
						__( "Medium", "wpex" )	=> "medium",
						__( "Large", "wpex" )	=> "large",
					),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Custom Font Size", 'wpex' ),
					"param_name"	=> "font_size",
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "Text Transform", 'wpex' ),
					'param_name'	=> "text_transform",
					'group'			=> __( 'Design', 'wpex' ),
					'value'			=> array(
						__( 'Default', 'wpex' )		=> '',
						__( 'None', 'wpex' )		=> 'none',
						__( 'Capitalize', 'wpex' )	=> 'capitalize',
						__( 'Uppercase', 'wpex' )	=> 'uppercase',
						__( 'Lowercase', 'wpex' )	=> 'lowercase',
					),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Padding", 'wpex' ),
					"param_name"	=> "font_padding",
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Font Weight", 'wpex' ),
					"param_name"	=> "font_weight",
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Letter Spacing", 'wpex' ),
					"param_name"	=> "letter_spacing",
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Border Radius", 'wpex' ),
					"param_name"	=> "border_radius",
					'group'			=> __( 'Design', 'wpex' ),
				),

				// Attributes
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Link Target", 'wpex' ),
					"param_name"	=> "target",
					"value"			=> array(
						__( "Self", "wpex")		=> "self",
						__( "Blank", "wpex" )	=> "blank",
					),
					'group'			=> __( 'Attributes', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Link Rel", 'wpex' ),
					"param_name"	=> "rel",
					"value"			=> array(
						__( "None", "wpex")			=> "none",
						__( "Nofollow", "wpex" )	=> "nofollow",
					),
					'group'			=> __( 'Attributes', 'wpex' ),
				),
				array(
					"type"			=> "vcex_icon",
					"heading"		=> __( "Left Icon", 'wpex' ),
					"param_name"	=> "icon_left",
					"value"			=> '',
					'group'			=> __( 'Icons', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Left Icon: Right Padding", 'wpex' ),
					"param_name"	=> "icon_left_padding",
					"value"			=> '',
					'group'			=> __( 'Icons', 'wpex' ),
				),
				array(
					"type"			=> "vcex_icon",
					"heading"		=> __( "Right Icon", 'wpex' ),
					"param_name"	=> "icon_right",
					"value"			=> '',
					'group'			=> __( 'Icons', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Right Icon: Left Padding", 'wpex' ),
					"param_name"	=> "icon_right_padding",
					"value"			=> '',
					'group'			=> __( 'Icons', 'wpex' ),
				),
			)
		) );
	}
}
add_action( 'init', 'vcex_button_shortcode_vc_map' );
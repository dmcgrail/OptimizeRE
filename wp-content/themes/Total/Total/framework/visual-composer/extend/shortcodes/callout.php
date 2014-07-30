<?php
/**
 * Registers the callout shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if( !function_exists('vcex_callout_shortcode') ) {
	function vcex_callout_shortcode( $atts, $content = NULL  ) {
		extract( shortcode_atts( array(
			'caption'				=> '',
			'button_text'			=> '',
			'button_style'			=> 'graphical',
			'button_color'			=> 'blue',
			'button_url'			=> 'http://www.wpexplorer.com',
			'button_rel'			=> 'nofollow',
			'button_target'			=> 'blank',
			'button_border_radius'	=> '',
			'button_title'			=> __('Visit Site', 'wpex' ),
			'button_icon_left'		=> '',
			'button_icon_right'		=> '',
			'css_animation'			=> '',
		), $atts ) );
		
		// Add Classes
		$classes='';
		if ( $css_animation !== '' ) {
			$classes .= 'wpb_animate_when_almost_visible wpb_'. $css_animation .' ';
		}
		if ( $button_url ) {
			$classes .= 'with-button';
		}
		
		//Set Vars
		$button_border_radius = ( $button_border_radius ) ? 'style="border-radius:'. $button_border_radius .'"' : NULL;
		$button_rel = ( $button_rel !== 'none' ) ? 'rel="'.$button_rel.'"' : NULL;
		
		// Display Callout
		$output = '<div class="vcex-callout vcex-clearfix '. $classes .'">';
		$output .= '<div class="vcex-callout-caption">';
			$output .= do_shortcode ( $content );
		$output .= '</div>';
		if ( $button_text !== '' ) {
			$output .= '<div class="vcex-callout-button">';
				$output .= '<a href="' . $button_url . '" class="vcex-button '. $button_style .' ' . $button_color . '" target="_'.$button_target.'" title="'. $button_text .'" '. $button_border_radius .' '. $button_rel .'>';
					$output.= '<span class="vcex-button-inner" '.$button_border_radius.'>';
						if ( $button_icon_left && $button_icon_left !== 'none' ) $output.= '<i class="vcex-button-icon-left fa fa-'. $button_icon_left .'"></i>';
							$output.= $button_text;
						if ( $button_icon_right && $button_icon_right !== 'none' ) $output.= '<i class="vcex-button-icon-right fa fa-'. $button_icon_right .'"></i>';
					$output.= '</span>';
				$output.= '</a>';
			$output .='</div>';
		}
		$output .= '</div>';
		
		return $output;
	}
}
add_shortcode( 'vcex_callout', 'vcex_callout_shortcode' );

/**
 * Registers the callout shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_callout_shortcode_vc_map' ) ) {
	function vcex_callout_shortcode_vc_map() {
		vc_map( array(
			"name"			=> __( "Callout", 'wpex' ),
			"description"	=> __( "Call to action section with or without button.", 'wpex' ),
			"base"			=> "vcex_callout",
			"icon"			=> "icon-wpb-vcex-callout",
			'category'		=> WPEX_THEME_BRANDING,
			"params"		=> array(
				array(
					"type"			=> "dropdown",
					"heading"		=> __("CSS Animation", "wpex"),
					"param_name"	=> "css_animation",
					"value"			=> array(
						__("No", "wpex")					=> '',
						__("Top to bottom", "wpex")			=> "top-to-bottom",
						__("Bottom to top", "wpex")			=> "bottom-to-top",
						__("Left to right", "wpex")			=> "left-to-right",
						__("Right to left", "wpex")			=> "right-to-left",
						__("Appear from center", "wpex")	=> "appear"),
						//"description"	=> __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "wpex"),
				),
				array(
					"type"			=> "textarea_html",
					"holder"		=> "div",
					"class"			=> "vcex-callout",
					"heading"		=> __( "Callout Content", 'wpex' ),
					"param_name"	=> "content",
					"value"			=> __( "Enter your content here.", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Button: URL", 'wpex' ),
					"param_name"	=> "button_url",
					"value"			=> "",
					//"description"	=> __( "Enter a target URL for your button. Don't forget the http:// at the front.", 'wpex' ),
					'group'			=> __( 'Button', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Button: Text", 'wpex' ),
					"param_name"	=> "button_text",
					"value"			=> "",
					//"description"	=> __( "Your button Text.", 'wpex' ),
					'group'			=> __( 'Button', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Button Style", 'wpex' ),
					"param_name"	=> "button_style",
					//"description"	=> __( "Select a button style.", 'wpex' ),
					"value"			=> array(
						__( "Graphical", "wpex")	=> "graphical",
						__( "Flat", "wpex" )		=> "flat",
						__( "3D", "wpex" )			=> "three-d",
						__( "Outline", "wpex" )		=> "outline",
					),
					//"description"	=> __( "Select a style for this button.", 'wpex' ),
					'group'			=> __( 'Button', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Button: Color", 'wpex' ),
					"param_name"	=> "button_color",
					"value"			=> array(
						__( "Black", "wpex")	=> "black",
						__( "Blue", "wpex" )	=> "blue",
						__( "Brown", "wpex" )	=> "brown",
						__( "Grey", "wpex" )	=> "grey",
						__( "Green", "wpex" )	=> "green",
						__( "Gold", "wpex" )	=> "gold",
						__( "Orange", "wpex" )	=> "orange",
						__( "Pink", "wpex" )	=> "pink",
						__( "Red", "wpex" )		=> "red",
						__( "Rosy", "wpex" )	=> "rosy",
						__( "Teal", "wpex" )	=> "teal",
					),
					//"description"	=> __( "Select a color for this button. Note: Custom colors aren't supported for several reasons.", 'wpex' ),
					'group'			=> __( 'Button', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Button: Border Radius", 'wpex' ),
					"param_name"	=> "button_border_radius",
					"value"			=> "3px",
					//"description"	=> __( 'Custom border radius. This gives your button "roundedness".', 'wpex' ),
					'group'			=> __( 'Button', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Button: Link Target", 'wpex' ),
					"param_name"	=> "button_target",
					"value"			=> array(
						__( "Self", "wpex")		=> "self",
						__( "Blank", "wpex" )	=> "blank",
					),
					//"description"	=> __( 'Your link target. Choose self to open the link in the same browser tab and blank to open in a new tab.', 'wpex' ),
					'group'			=> __( 'Button', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Button: Rel", 'wpex' ),
					"param_name"	=> "button_rel",
					"value"			=> array(
						__( "None", "wpex")			=> "none",
						__( "Nofollow", "wpex" )	=> "nofollow",
					),
					//"description"	=> __( 'Select a rel attribute for your link.', 'wpex' ),
					'group'			=> __( 'Button', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Button: Icon Left", 'wpex' ),
					"param_name"	=> "button_icon_left",
					//"description"	=> sprintf( __( 'Icon to the left of your button text. See all the icons at %s', 'wpex' ), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome</a>' ),
					"value"			=> wpex_get_awesome_icons(),
					'group'			=> __( 'Button', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Button: Icon Right", 'wpex' ),
					"param_name"	=> "button_icon_right",
					//"description"	=> sprintf( __( 'Icon to the right of your button text. See all the icons at %s', 'wpex' ), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">FontAwesome</a>' ),
					"value"			=> wpex_get_awesome_icons(),
					'group'			=> __( 'Button', 'wpex' ),
				),
			)
		) );
	}
}
add_action( 'init', 'vcex_callout_shortcode_vc_map' );
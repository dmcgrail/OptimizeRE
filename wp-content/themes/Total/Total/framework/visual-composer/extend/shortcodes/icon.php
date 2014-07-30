<?php
/**
 * Registers the icon shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( !function_exists( 'vcex_icon_shortcode' ) ) {
	function vcex_icon_shortcode( $atts, $content = NULL ) {
		
		extract( shortcode_atts( array(
			'unique_id'			=> '',
			'icon'				=> 'cloud',
			'style'				=> 'circle',
			'float'				=> 'left',
			'size'				=> 'normal',
			'custom_size'		=> '',
			'color'				=> '#000',
			'padding'			=> '',
			'background'		=> '',
			'border_radius'		=> '99px',
			'css_animation'		=> '',
			'link_url'			=> '',
			'link_target'		=> 'self',
			'link_rel'			=> '',
			'link_title'		=> '',
			'el_class'			=> '',
		), $atts ) );

		// Turn output buffer on
		ob_start();

			$add_style='';
			if ( $custom_size ) {
				$add_style .= 'font-size:'. $custom_size .';';
			}
			if ( $color ) {
				$add_style .= 'color:'. $color .';';
			}
			if ( $padding ) {
				$add_style .= 'padding:'. $padding .';';
			}
			if ( $background ) {
				$add_style .= 'background-color:'. $background .';';
				if ( $border_radius ) {
					$add_style .= 'border-radius:'. $border_radius .';';
				}
			}
			if ( $add_style ) {
				$add_style = 'style="'. $add_style .'"';
			}
			
			$unique_id = $unique_id ? ' id="'. $unique_id .'"' : NULL;
			
			$classes ='';
			if ( $el_class ) {
				$classes .= $el_class;
			}
			if ( $custom_size ) {
				$classes .= ' custom-size';
			}
			if ( '' != $css_animation ) {
				$classes .= ' wpb_animate_when_almost_visible wpb_'. $css_animation;
			}
			if ( !$background ) {
				$classes .= ' remove-dimensions';
			} ?>
			
			<?php if ( $icon ) { ?>
				<div class="vcex-icon vcex-icon-<?php echo $style; ?> vcex-icon-<?php echo $size; ?> vcex-icon-float-<?php echo $float; ?> <?php echo $classes; ?>"<?php echo $unique_id; ?>>
					<?php if ( $link_url ) { ?>
						<a href="<?php echo esc_url( $link_url ); ?>" title="<?php echo $link_title; ?>" rel="<?php echo $link_rel; ?>" target="_<?php echo $link_target; ?>">
					<?php } ?>
					<span class="fa fa-<?php echo $icon; ?>" <?php echo $add_style; ?>></span>
					<?php if ( $link_url ) { ?></a><?php } ?>
				</div>
			<?php } ?>
		
		<?php
		// Return outbut buffer
		return ob_get_clean();
	}
}
add_shortcode( 'vcex_icon', 'vcex_icon_shortcode' );

/**
 * Adds the icon shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_icon_shortcode_vc_map' ) ) {
	function vcex_icon_shortcode_vc_map() {
		vc_map( array(
			"name"					=> __( "Font Icon", 'wpex' ),
			"description"			=> __( "Font Awesome icon", 'wpex' ),
			"base"					=> "vcex_icon",
			"icon"					=> "icon-wpb-vcex-icon",
			'category'				=> WPEX_THEME_BRANDING,
			'admin_enqueue_css'		=> wpex_font_awesome_css_url(),
			'front_enqueue_css'		=> wpex_font_awesome_css_url(),
			"params"				=> array(
				array(
					'type'			=> 'textfield',
					'heading'		=> __( 'Extra class name', 'wpex' ),
					'param_name'	=> 'el_class',
					'description'	=> __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wpex' ),
				),
				array(
					"type"			=> "vcex_icon",
					"class"			=> "",
					"heading"		=> __( "Icon", 'wpex' ),
					"param_name"	=> "icon",
					"admin_label"	=> true,
					"value"			=> 'flag',
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __("CSS Animation", "wpex"),
					"param_name"	=> "css_animation",
					"admin_label"	=> true,
					"value"			=> array(
						__("No", "wpex")					=> '',
						__("Top to bottom", "wpex")			=> "top-to-bottom",
						__("Bottom to top", "wpex")			=> "bottom-to-top",
						__("Left to right", "wpex")			=> "left-to-right",
						__("Right to left", "wpex")			=> "right-to-left",
						__("Appear from center", "wpex")	=> "appear"),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Icon Size", 'wpex' ),
					"param_name"	=> "size",
					"value"			=> array(
						__( 'Inherit', 'wpex' )		=> "inherit",
						__( "Extra Large", "wpex" )	=> "xlarge",
						__( "Large", "wpex" )		=> "large",
						__( "Normal", "wpex" )		=> "normal",
						__( "Small", "wpex")		=> "small",
						__( "Tiny", "wpex" )		=> "tiny",
					),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Custom Icon Size", 'wpex' ),
					"param_name"	=> "custom_size",
					"value"			=> "",
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Icon Padding", 'wpex' ),
					"param_name"	=> "padding",
					"value"			=> "",
					"dependency"	=> Array(
						'element'	=> "custom_size",
						'not_empty'	=> true
					),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Position", 'wpex' ),
					"param_name"	=> "float",
					"value"			=> array(
						__( "Center", "wpex" )	=> "center",
						__( "Left", "wpex")		=> "left",
						__( "Right", "wpex" )	=> "right",
					),
				),
				array(
					"type"			=> "colorpicker",
					"heading"		=> __( "Icon Color", 'wpex' ),
					"param_name"	=> "color",
					"value"			=> "#000000",
				),
				array(
					"type"			=> "colorpicker",
					"heading"		=> __( "Background Color", 'wpex' ),
					"param_name"	=> "background",
					"value"			=> "",
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Border Radius", 'wpex' ),
					"param_name"	=> "border_radius",
					"value"			=> "99px",
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Link URL", 'wpex' ),
					"param_name"	=> "link_url",
					"value"			=> "",
					'group'			=> __( 'Link', 'wpex' )
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Link Title", 'wpex' ),
					"param_name"	=> "link_title",
					"value"			=> "",
					'group'			=> __( 'Link', 'wpex' )
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Link Target", 'wpex' ),
					"param_name"	=> "link_target",
					"value"			=> array(
						__( "Self", "wpex")		=> "self",
						__( "Blank", "wpex" )	=> "blank",
					),
					'group'			=> __( 'Link', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Link Rel", 'wpex' ),
					"param_name"	=> "link_rel",
					"value"			=> array(
						__( "None", "wpex")			=> "none",
						__( "Nofollow", "wpex" )	=> "nofollow",
					),
					'group'			=> __( 'Link', 'wpex' ),
				),
			)
		) );
	}
}
add_action( 'init', 'vcex_icon_shortcode_vc_map' );
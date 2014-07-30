<?php
/**
 * Registers the layerslider shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_layerslider_shortcode_vc_map' ) ) {
	function vcex_layerslider_shortcode_vc_map() {
		vc_map( array(
			"name"					=> __( "LayerSlider", 'wpex' ),
			"description"			=> __( "Insert a LayerSlider slider via ID", 'wpex' ),
			"base"					=> "layerslider",
			'category'				=> WPEX_THEME_BRANDING,
			"icon"					=> "icon-wpb-vcex-layerslider",
			"params"				=> array(
				array(
					"type"			=> "textfield",
					"holder"		=> "div",
					"heading"		=> __( "Enter your slider ID", 'wpex' ),
					"param_name"	=> "id",
					"value"			=> "1",
				),
			)
		) );
	}
}
add_action( 'init', 'vcex_layerslider_shortcode_vc_map' );
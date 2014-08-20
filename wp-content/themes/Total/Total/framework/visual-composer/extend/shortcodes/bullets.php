<?php
/**
 * Registers the bullets shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if( !function_exists('vcex_bullets_shortcode') ) {
	function vcex_bullets_shortcode( $atts, $content = NULL ) {
		extract( shortcode_atts( array(
			'style'	=> ''
		),
		$atts ) );
		return '<div class="vcex-bullets vcex-bullets-' . $style . '">' . do_shortcode( $content ) . '</div>';
	}
}
add_shortcode( 'vcex_bullets', 'vcex_bullets_shortcode' );

/**
 * Adds the bullets shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_bullets_shortcode_vc_map' ) ) {
	function vcex_bullets_shortcode_vc_map() {
		vc_map( array(
			"name"					=> __( "Bullets", 'wpex' ),
			"description"			=> __( "Styled bulleted lists", 'wpex' ),
			"base"					=> "vcex_bullets",
			'category'				=> WPEX_THEME_BRANDING,
			"icon"					=> "icon-wpb-vcex-bullets",
			"params"				=> array(
				array(
					"type"			=> "textarea_html",
					"heading"		=> __( "Insert Unordered List", 'wpex' ),
					"param_name"	=> "content",
					"value"			=> "<ul><li>List 1</li><li>List 2</li><li>List 3</li><li>List 4</li></ul>",
					//"description"	=> __( "Insert your unordered list here.", 'wpex' ),
					'group'			=> __( 'Your List', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Style", 'wpex' ),
					"param_name"	=> "style",
					"admin_label"	=> true,
					"value"			=> array(
						__( "Check", "wpex")	=> "check",
						__( "Blue", "wpex" )	=> "blue",
						__( "Gray", "wpex" )	=> "gray",
						__( "Purple", "wpex" )	=> "purple",
						__( "Red", "wpex" )		=> "red",
					),
					//"description"	=> __( "Select your bullet style.", 'wpex' ),
					'group'			=> __( 'Style', 'wpex' ),
				),
			)
		) );
	}
}
add_action( 'init', 'vcex_bullets_shortcode_vc_map' );
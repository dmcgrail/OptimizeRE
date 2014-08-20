<?php
/**
 * Adds the staff social shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_staff_social_vc_map' ) ) {
	function vcex_staff_social_vc_map() {
		vc_map( array(
			"name"			=> __( "Staff Social Links", 'wpex' ),
			"description"	=> __( "Single staff social links.", 'wpex' ),
			"base"			=> "staff_social",
			'category'		=> WPEX_THEME_BRANDING,
			"icon"			=> "icon-wpb-vcex-staff_social",
			"params"		=> array(
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Link Target", 'wpex' ),
					"param_name"	=> "link_target",
					"value"			=> array(
						__( "Self", "wpex")		=> "self",
						__( "Blank", "wpex" )	=> "blank",
					),
					//"description"	=> __( 'Your link target. Choose self to open the link in the same browser tab and blank to open in a new tab.', 'wpex' ),
				),
			)
		) );
	}
}
add_action( 'init', 'vcex_staff_social_vc_map' );
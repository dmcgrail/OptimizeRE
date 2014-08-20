<?php
/**
 * Registers the newsletter shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if( !function_exists('vcex_newsletter_form_shortcode') ) {
	function vcex_newsletter_form_shortcode( $atts ) {

		extract( shortcode_atts( array(
			'provider'				=> 'mailchimp',
			'mailchimp_form_action'	=> '',
			'input_width'			=> '100%',
			'input_height'			=> '50px',
			'input_bg'				=> '',
			'input_color'			=> '',
			'placeholder_text'		=> '',
		),
		$atts ) );
		
		// Vars
		$output='';

		// Style
		$style = '';
		if ( $input_height ) {
			$style .= 'height: '. $input_height .';';
		}
		if ( $input_bg ) {
			$style .= 'background: '. $input_bg .';';
		}
		if ( $input_color ) {
			$style .= 'color: '. $input_color .';';
		}
		if ( $style ) {
			$style = 'style="' . esc_attr($style) . '"';
		}
		
		// Mailchimp
		if ( $provider == 'mailchimp' ) {
			$output .='<div class="vcex-newsletter-form clr">';
				$output .='<!-- Begin MailChimp Signup Form -->
							<div id="mc_embed_signup" class="vcex-newsletter-form-wrap" style="width: '. $input_width .';">
								<form action="'. $mailchimp_form_action .'" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
									<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="'. $placeholder_text .'" '. $style .'>
									<input type="submit" value="" name="subscribe" id="mc-embedded-subscribe" class="vcex-newsletter-form-button">
								</form>
							</div><!--End mc_embed_signup-->';
			$output .='</div><!-- .vcex-newsletter-form -->';
		}

		// Return output
		return $output;
		
	}
}
add_shortcode( 'vcex_newsletter_form', 'vcex_newsletter_form_shortcode' );

/**
 * Adds the newsletter shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_newsletter_form_shortcode_vc_map' ) ) {
	function vcex_newsletter_form_shortcode_vc_map() {
		vc_map( array(
			"name"					=> __( "Mailchimp Form", 'wpex' ),
			"description"			=> __( "Mailchimp subscription form", 'wpex' ),
			"base"					=> "vcex_newsletter_form",
			"category"				=> WPEX_THEME_BRANDING,
			"icon" 					=> "icon-wpb-vcex-newsletter_form",
			"params"				=> array(
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Mailchimp Form Action", 'wpex' ),
					"param_name"	=> "mailchimp_form_action",
					"value"			=> "http://domain.us1.list-manage.com/subscribe/post?u=numbers_go_here",
					"description"	=> __( "Enter the MailChimp form action URL.","wpex") .' <a href="http://docs.shopify.com/support/configuration/store-customization/where-do-i-get-my-mailchimp-form-action?ref=wpexplorer" target="_blank">'. __('Learn More','wpex') .' &rarr;</a>',
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Placeholder Text", 'wpex' ),
					"param_name"	=> "placeholder_text",
					"value"			=> __('Enter your email address','wpex'),
					//"description"	=> __( "Enter your custom placeholder text","wpex"),
					"dependency"	=> Array(
						'element'	=> "mailchimp_form_action",
						'not_empty'	=> true
					),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Input Width", 'wpex' ),
					"param_name"	=> "input_width",
					"value"			=> '100%',
					//"description"	=> __( "Enter a width for your input form. It can be in px or %.","wpex"),
					"dependency"	=> Array(
						'element'	=> "mailchimp_form_action",
						'not_empty'	=> true
					),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Input Height", 'wpex' ),
					"param_name"	=> "input_height",
					"value"			=> '50px',
					//"description"	=> __( "Enter a width for your input form in pixels.","wpex"),
					"dependency"	=> Array(
						'element'	=> "mailchimp_form_action",
						'not_empty'	=> true
					),
				),
				array(
					"type"			=> "colorpicker",
					"class"			=> "",
					"heading"		=> __( "Input Background", 'wpex' ),
					"param_name"	=> "input_bg",
					"value"			=> '',
					//"description"	=> __( "Choose a custom input background color. Useful when your form is inside a dark background to make the input white.","wpex"),
					"dependency"	=> Array(
						'element'	=> "mailchimp_form_action",
						'not_empty'	=> true
					),
				),
				array(
					"type"			=> "colorpicker",
					"class"			=> "",
					"heading"		=> __( "Input Color", 'wpex' ),
					"param_name"	=> "input_color",
					"value"			=> '',
					//"description"	=> __( "Choose a custom input text color. This will not change your placeholder text though. That is controlled by the browser.","wpex"),
					"dependency"	=> Array(
						'element'	=> "mailchimp_form_action",
						'not_empty'	=> true
					),
				),
			)
		) );
	}
}
add_action( 'init', 'vcex_newsletter_form_shortcode_vc_map' );
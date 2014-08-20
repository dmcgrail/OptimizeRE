<?php
/**
 * Redesign the default WP login screen
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */


// Hex to RGBA converter
if ( !function_exists( 'wpex_hex2rgba' ) ) {
	function wpex_hex2rgba($color, $opacity = false) {
		$default = 'rgb(0,0,0)';
		//Return default if no color provided
		if(empty($color)) return $default;
		//Sanitize $color if "#" is provided 
			if ($color[0] == '#' ) {
				$color = substr( $color, 1 );
			}
			//Check if color has 6 or 3 characters and get values
			if (strlen($color) == 6) {
					$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
			} elseif ( strlen( $color ) == 3 ) {
					$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
			} else {
					return $default;
			}
			//Convert hexadec to rgb
			$rgb =  array_map('hexdec', $hex);
			//Check if opacity is set(rgba or rgb)
			if($opacity){
				if(abs($opacity) > 1)
					$opacity = 1.0;
				$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
			} else {
				$output = 'rgb('.implode(",",$rgb).')';
			}
			//Return rgb(a) color string
			return $output;
	}
}


// Custom login design
if ( !function_exists( 'wpex_login_design' ) ) {

	function wpex_login_design() {

		// Custom login is disabled so lets bail
		if ( !wpex_option( 'custom_admin_login', '1' ) ) return;

		$output = '';

		// Logo Vars
		$logo = wpex_option( 'admin_login_logo', false, 'url' );
		$logo = esc_url( $logo );
		$logo_height = wpex_option( 'admin_login_logo_height', '50' );
		$logo_height = intval( $logo_height );

		// Main BG Vars
		$bg_color = wpex_option( 'admin_login_background_color' );
		$bg_img = wpex_option( 'admin_login_background_img', false, 'url' );
		$bg_img = esc_url( $bg_img );
		$bg_style = wpex_option( 'admin_login_background_style', 'stretched' );

		// Form Vars
		$form_bg_color = wpex_option( 'admin_login_form_background_color' );
		$form_bg_opacity = wpex_option( 'admin_login_form_background_opacity', '0.7' );
		$form_bg_color_rgba = wpex_hex2rgba( $form_bg_color, $form_bg_opacity );
		$form_text_color = wpex_option( 'admin_login_form_text_color' );
		$form_top = wpex_option( 'admin_login_form_top', '150' );
		$form_top = intval( $form_top );

		// Output Styles
		$output .= '<style type="text/css">';

			// Logo
			if ( $logo ) {
				$output .='body.login div#login h1 a {';
					$output .='background: url("'. $logo .'") center center no-repeat;';
					$output .='height: '. $logo_height .'px;';
					$output .='width: 100%;';
					$output .='display: block;';
					$output .='margin: 0 auto 30px;';
				$output .='}';
			}

			// Background image
			if ( $bg_img ) {
				if ( 'stretched' == $bg_style ) {
					$output .= 'body.login { background: url('. $bg_img .') no-repeat center center fixed; -webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover; }';
				}
				if ( 'repeat' == $bg_style ) {
					$output .= 'body.login { background: url('. $bg_img .') repeat; }';
				}
				if ( 'fixed' == $bg_style ) {
					$output .= 'body.login { background: url('. $bg_img .') center top fixed no-repeat; }';
				}
			}

			// Background color
			if ( $bg_color ) {
				$output .='body.login { background-color: '. $bg_color .'; }';
			}

			// Form Background Color
			if ( $form_bg_color ) {
				$output .='.login form { background: none; -webkit-box-shadow: none; box-shadow: none; padding: 0 0 20px; } #backtoblog { display: none; } .login #nav { text-align: center; }';
				if ( $form_text_color ) {
					$output .='.login label, .login #nav a, .login #backtoblog a, .login #nav { color: '. $form_text_color .'; }';
					
				}
				$output .='body.login div#login { background: '. $form_bg_color .'; background: '. $form_bg_color_rgba .';height:auto;left:50%;margin: 0 0 0 -200px;padding:40px;position:absolute;top:'. $form_top .'px;width:320px; max-width:90%; border-radius: 5px; }';
			}


		$output .='</style>';

		echo $output;

	} // End function

} // End function_exists check

add_action( 'login_enqueue_scripts', 'wpex_login_design' );


// Custom Login Logo URL
if ( !function_exists( 'wpex_login_logo_url' ) ) {
	function wpex_login_logo_url( $url ) {
		if ( wpex_option( 'admin_login_logo_url' ) ){
			return esc_url( wpex_option( 'admin_login_logo_url' ) );
		} else {
			return $url;
		}
	}
	add_filter( 'login_headerurl', 'wpex_login_logo_url' );
}
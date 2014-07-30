<?php
/**
 * Adds social options for users
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

if ( !function_exists( 'wpex_add_user_fields' ) ) {
	function wpex_add_user_fields( $contactmethods ) {
	// Add Twitter
	if ( !isset( $contactmethods['wpex_twitter'] ) ) {
		$contactmethods['wpex_twitter'] = WPEX_THEME_BRANDING .' - Twitter';
	}
	// Add Facebook
	if ( !isset( $contactmethods['wpex_facebook'] ) ) {
		$contactmethods['wpex_facebook'] = WPEX_THEME_BRANDING .' - Facebook';
	}
	// Add GoglePlus
	if ( !isset( $contactmethods['wpex_googleplus'] ) ) {
		$contactmethods['wpex_googleplus'] = WPEX_THEME_BRANDING .' - Google+';
	}
	// Add LinkedIn
	if ( !isset( $contactmethods['wpex_linkedin'] ) ) {
		$contactmethods['wpex_linkedin'] = WPEX_THEME_BRANDING .' - LinkedIn';
	}
	// Add Pinterest
	if ( !isset( $contactmethods['wpex_pinterest'] ) ) {
		$contactmethods['wpex_pinterest'] = WPEX_THEME_BRANDING .' - Pinterest';
	}
	// Add Pinterest
	if ( !isset( $contactmethods['wpex_instagram'] ) ) {
		$contactmethods['wpex_instagram'] = WPEX_THEME_BRANDING .' - Instagram';
	}
	return $contactmethods;
	}
}
add_filter( 'user_contactmethods', 'wpex_add_user_fields', 10, 1 );
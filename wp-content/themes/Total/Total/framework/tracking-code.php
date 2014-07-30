<?php
/**
 * Outputs your tracking code in the head based on your theme settings
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/

add_action('wp_head', 'wpex_site_tracking_header');
if ( !function_exists('wpex_site_tracking_header') ) {	
	function wpex_site_tracking_header() {
		$tracking = wpex_option( 'tracking' );
		if ( $tracking !== '' ) {
			echo wpex_option('tracking');
		}
	}
}
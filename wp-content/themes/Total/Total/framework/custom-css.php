<?php
/**
 * Adds your admin custom CSS to the wp_head() hook.
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

// We don't need this in the admin
if ( is_admin() ) {
	return;
}

// Start function
if ( !function_exists( 'wpex_custom_css' ) ) {
	function wpex_custom_css() {
		$css = wpex_option( 'custom_css' );
		if ( '' != $css && !empty($css) ) {
			return $css = '/*Admin Custom CSS START*/'. $css .'/*Admin Custom CSS END*/';
		} else {
			return '';
		}
	}
}
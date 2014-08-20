<?php
/**
 * Retuns theme options data
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

if ( ! function_exists( 'wpex_option' ) ) {
	function wpex_option( $id, $fallback = false, $param = false ) {
		if ( isset( $_GET['wpex_'.$id] ) ) {
			if ( '-1' == $_GET['wpex_'.$id] ) {
				return false;
			} else {
				return $_GET['wpex_'.$id];
			}
		} else {
			global $wpex_options;
			if ( $fallback == false ) $fallback = '';
			$output = ( isset($wpex_options[$id]) && $wpex_options[$id] !== '' ) ? $wpex_options[$id] : $fallback;
			if ( !empty($wpex_options[$id]) && $param ) {
				$output = $wpex_options[$id][$param];
			}
		}
		return $output;
	}
}
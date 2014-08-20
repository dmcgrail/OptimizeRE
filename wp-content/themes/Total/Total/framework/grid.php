<?php
/**
 * Returns the correct grid class based on column number
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/

if ( ! function_exists( 'wpex_grid_class' ) ) {
	function wpex_grid_class( $col ) {
		if ( $col == '1' ) {
			return 'span_1_of_1';
		} elseif ( $col == '2' ) {
			return 'span_1_of_2';
		} elseif ( $col == '3' ) {
			return 'span_1_of_3';
		} elseif ( $col == '4' ) {
			return 'span_1_of_4';
		} elseif ( $col == '5' ) {
			return 'span_1_of_5';
		} elseif ( $col == '6' ) {
			return 'span_1_of_6';
		} elseif ( $col == '7' ) {
			return 'span_1_of_7';
		} elseif ( $col == '8' ) {
			return 'span_1_of_8';
		} elseif ( $col == '9' ) {
			return 'span_1_of_9';
		} elseif ( $col == '10' ) {
			return 'span_1_of_10';
		} elseif ( $col == '11' ) {
			return 'span_1_of_11';
		} elseif ( $col == '12' ) {
			return 'span_1_of_12';
		} else {
			return 'span_8';
		}
	}
}
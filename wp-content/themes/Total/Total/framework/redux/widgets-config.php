<?php
/**
 * Configs the Redux widget arguments
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link  http://www.wpexplorer.com
 * @since Total 1.52
*/

if ( !function_exists( 'wpex_config_redux_widgets' ) ) {
	function wpex_config_redux_widgets( $options ) {
		$options = array(
			'before_widget'		=> '<div class="sidebar-box %2$s clr">',
			'after_widget'		=> '</div>',
			'before_title'		=> '<'. wpex_option( 'sidebar_headings', 'div' ) .' class="widget-title">',
			'after_title'		=> '</'. wpex_option( 'sidebar_headings', 'div' ) .'>',
		);
		return $options;
	}
}
add_filter( 'redux_custom_widget_args', 'wpex_config_redux_widgets' );
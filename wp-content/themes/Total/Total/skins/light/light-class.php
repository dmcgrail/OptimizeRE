<?php
/**
 * Light Skin Class
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.51
*/


if ( !class_exists( "Total_Light_Skin" ) ) {

	class Total_Light_Skin {

		// Constructor
		function __construct() {
			add_action( 'wp_enqueue_scripts', array( &$this, 'load_styles') );
		}

		// Load Styles
		public function load_styles() {
			if ( wp_script_is( 'wpex-woocommerce', 'enqueued' ) ) {
				wp_enqueue_style( 'light-skin', WPEX_SKIN_DIR_URI .'/light/light-style.css', array( 'wpex-style', 'wpex-woocommerce' ), '1.0', 'all' );
			} else {
				wp_enqueue_style( 'light-skin', WPEX_SKIN_DIR_URI .'/light/light-style.css', array( 'wpex-style' ), '1.0', 'all' );
			}
		}

	}

}

// Start Class
$wpex_skin_class = new Total_Light_Skin();
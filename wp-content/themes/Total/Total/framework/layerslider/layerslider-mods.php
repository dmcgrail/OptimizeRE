<?php
/**
 * Functions that modify the LayerSlider plugin
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 */

// Only needed in the admin
if( ! is_admin() ) return;


// Register your custom function to override some LayerSlider data
if ( ! function_exists( 'wpex_layerslider_remove_auto_updates' ) ) {
	function wpex_layerslider_remove_auto_updates() {
		$GLOBALS['lsAutoUpdateBox'] = false;
	}
}
add_action('layerslider_ready', 'wpex_layerslider_remove_auto_updates');


/* Import Total Slides
if ( ! function_exists( 'wpex_import_layerslider_demos' ) ) {
	function wpex_import_layerslider_demos() {
		include LS_ROOT_PATH .'/classes/class.ls.importutil.php';
		$sliders = array( 'home-main' );
		foreach ( $sliders as $slider ){
			$import = new LS_ImportUtil( get_template_directory_uri() .'/functions/layerslider/'. $slider .'.json' );
		}
	}
}
add_filter( 'layerslider_installed', 'wpex_import_layerslider_demos' ); */
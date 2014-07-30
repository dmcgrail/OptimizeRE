<?php
/**
 * Loads the required files to extend the Visual Composer plugin by WPBackery
 * Adds new modules such as Portfolio Grid, Image Caroursel, Bullets, Lists, Divider...and more!
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.4
*/

/**
 * Loads CSS for the Visual Composer backend composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.5
*/
if ( !function_exists( 'wpex_load_vcex_scripts' ) ) {
	function wpex_load_vcex_scripts() {
		wp_enqueue_style( 'vcex-admin-css', WPEX_VCEX_DIR_URI .'assets/admin.css' );
	}
}
add_action( 'admin_enqueue_scripts', 'wpex_load_vcex_scripts' );

/**
 * Returns the URL to the front end composer custom CSS file
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.5
 * @return string
*/
if ( ! function_exists( 'wpex_vc_frontend_css' ) ) {
	function wpex_vc_frontend_css() {
		return WPEX_VCEX_DIR_URI .'assets/front-end.css';
	}
}

/**
 * Returns the URL to the front end composer custom JS file
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.5
 * @return string
*/
if ( ! function_exists( 'wpex_vc_frontend_js' ) ) {
	function wpex_vc_frontend_js() {
		return WPEX_VCEX_DIR_URI .'assets/front-end.js';
	}
}

/**
 * Custom functions for use with the front-end Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.5
 * @return string
*/
if ( wpex_is_front_end_composer() ) {
	require_once WPEX_VCEX_DIR . 'front-end.php';
}

/**
 * Custom functions for use with VC extended shortcodes
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.4
 * @return string
*/
require_once WPEX_VCEX_DIR . 'functions.php';

/**
 * Custom functions for use with VC extended shortcodes
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.4
*/
require_once WPEX_VCEX_DIR . 'update-params.php';

/**
 * All custom shortcodes for use with the Visual Composer Extension
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.4
*/
require_once WPEX_VCEX_DIR . 'shortcodes/spacing.php';
require_once WPEX_VCEX_DIR . 'shortcodes/divider.php';
require_once WPEX_VCEX_DIR . 'shortcodes/callout.php';
require_once WPEX_VCEX_DIR . 'shortcodes/list_item.php';
require_once WPEX_VCEX_DIR . 'shortcodes/bullets.php';
require_once WPEX_VCEX_DIR . 'shortcodes/button.php';
require_once WPEX_VCEX_DIR . 'shortcodes/pricing.php';
require_once WPEX_VCEX_DIR . 'shortcodes/skillbar.php';
require_once WPEX_VCEX_DIR . 'shortcodes/icon.php';
require_once WPEX_VCEX_DIR . 'shortcodes/icon_box.php';
require_once WPEX_VCEX_DIR . 'shortcodes/milestone.php';
require_once WPEX_VCEX_DIR . 'shortcodes/teaser.php';
require_once WPEX_VCEX_DIR . 'shortcodes/image_swap.php';
require_once WPEX_VCEX_DIR . 'shortcodes/image_galleryslider.php';
require_once WPEX_VCEX_DIR . 'shortcodes/image_flexslider.php';
require_once WPEX_VCEX_DIR . 'shortcodes/image_carousel.php';
require_once WPEX_VCEX_DIR . 'shortcodes/image_grid.php';
require_once WPEX_VCEX_DIR . 'shortcodes/recent_news.php';
require_once WPEX_VCEX_DIR . 'shortcodes/blog_grid.php';
require_once WPEX_VCEX_DIR . 'shortcodes/blog_carousel.php';
require_once WPEX_VCEX_DIR . 'shortcodes/post_type_grid.php';
require_once WPEX_VCEX_DIR . 'shortcodes/post_type_slider.php';

if ( in_array( 'testimonials', wpex_active_post_types() ) ) {
	require_once WPEX_VCEX_DIR . 'shortcodes/testimonials_grid.php';
	require_once WPEX_VCEX_DIR . 'shortcodes/testimonials_slider.php';
}

if ( in_array( 'portfolio', wpex_active_post_types() ) ) {
	require_once WPEX_VCEX_DIR . 'shortcodes/portfolio_grid.php';
	require_once WPEX_VCEX_DIR . 'shortcodes/portfolio_carousel.php';
}

if ( in_array( 'staff', wpex_active_post_types() ) ) {
	require_once WPEX_VCEX_DIR . 'shortcodes/staff_grid.php';
	require_once WPEX_VCEX_DIR . 'shortcodes/staff_carousel.php';
	require_once WPEX_VCEX_DIR . 'shortcodes/staff_social.php';
}

require_once WPEX_VCEX_DIR . 'shortcodes/login_form.php';
require_once WPEX_VCEX_DIR . 'shortcodes/newsletter_form.php';

// Layerslider module
if ( function_exists( 'lsSliders' ) ) {
	require_once WPEX_VCEX_DIR . 'shortcodes/layerslider.php';
}

// WooCommerce Shortcodes
if ( class_exists('Woocommerce') ) {
	require_once WPEX_VCEX_DIR . 'shortcodes/woocommerce_carousel.php';
}
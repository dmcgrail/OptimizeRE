<?php
/**
 * Setup the theme - yay!
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

if ( ! function_exists( 'wpex_theme_setup' ) ) {
	function wpex_theme_setup() {

		// Register navigation menus
		register_nav_menus (
			array(
				'main_menu'		=> __( 'Main', 'wpex' ),
				'mobile_menu'	=> __( 'Mobile Icons', 'wpex' ),
				'footer_menu'	=> __( 'Footer', 'wpex' ),
			)
		);
			
		// Enable some useful post formats for the blog
		add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio', 'quote' ) );
		
		// Add automatic feed links in the header - for themecheck nagg
		add_theme_support( 'automatic-feed-links' );
		
		// Enable the custom background dashboard
		add_theme_support( 'custom-background' );
		
		// Enable featured image support
		add_theme_support( 'post-thumbnails' );
		
		// And HTML5 support
		add_theme_support( 'html5' );
		
		// Enable excerpts for pages.
		add_post_type_support( 'page', 'excerpt' );
		
		// Add support for WooCommerce - Yay!
		add_theme_support( 'woocommerce' );
		
	}
}

add_action( 'after_setup_theme', 'wpex_theme_setup' );


// Localization support
load_theme_textdomain( 'wpex', get_template_directory() .'/languages' );


// Content Width
if ( ! isset( $content_width ) ) {
	$content_width = 980;
}


/**
	Editor CSS
**/
if ( ! function_exists('wpex_add_editor_style') ) {
	function wpex_add_editor_style() {
		add_editor_style( 'editor-style.css' );
	}
}
add_action( 'init', 'wpex_add_editor_style' );


/**
	Flush rewrite rules for custom post types on theme activation
**/
if ( ! function_exists('wpex_flush_rewrite_rules' ) ) {
	function wpex_flush_rewrite_rules() {
		flush_rewrite_rules();
	}
}
add_action( 'after_switch_theme', 'wpex_flush_rewrite_rules' );

/**
	Remove Theme Check Nags
	Does nothing else.
**/
function wpex_remove_theme_check_nags() {
	add_theme_support( 'custom-header' );
}
<?php
/**
 * This file registers the theme's widget regions
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 */

add_action( 'widgets_init', 'wpex_register_sidebars' );

function wpex_register_sidebars() {

	// Vars
	$sidebar_headings = wpex_option( 'sidebar_headings', 'div' );
	$footer_headings = wpex_option( 'footer_headings', 'div' );

	// Main
	register_sidebar( array (
		'name'				=> __( 'Main Sidebar','wpex'),
		'id'				=> 'sidebar',
		'description'		=> __( 'Widgets in this area are used in the default sidebar. This sidebar will be used for your standard blog posts.','wpex' ),
		'before_widget'		=> '<div class="sidebar-box %2$s clr">',
		'after_widget'		=> '</div>',
		'before_title'		=> '<'. $sidebar_headings .' class="widget-title">',
		'after_title'		=> '</'. $sidebar_headings .'>',
	) );

	// Custom Post Types
	$post_types = wpex_active_post_types();
	foreach ( $post_types as $post_type ) {
		if ( post_type_exists( $post_type ) ) {
			$obj = get_post_type_object( $post_type );
			$post_type_name = $obj->labels->name;
			if ( wpex_option( $post_type .'_custom_sidebar', '1' ) ) {
				register_sidebar( array (
					'name'				=> $post_type_name .' '. __( 'Sidebar','wpex'),
					'id'				=> $post_type .'_sidebar',
					'description'		=> __( 'Widgets in this area are used in the sidebar for this custom post type.','wpex' ),
					'before_widget'		=> '<div class="sidebar-box %2$s clr">',
					'after_widget'		=> '</div>',
					'before_title'		=> '<'. $sidebar_headings .' class="widget-title">',
					'after_title'		=> '</'. $sidebar_headings .'>',
				) );
			}
		}
	}

	// Pages
	if ( wpex_option( 'pages_custom_sidebar', '1' ) ) {
		register_sidebar( array (
			'name'				=> __( 'Pages Sidebar','wpex'),
			'id'				=> 'pages_sidebar',
			'description'		=> __( 'Widgets in this area are used for your pages sidebar.','wpex' ),
			'before_widget'		=> '<div class="sidebar-box %2$s clr">',
			'after_widget'		=> '</div>',
			'before_title'		=> '<'. $sidebar_headings .' class="widget-title">',
			'after_title'		=> '</'. $sidebar_headings .'>',
		) );
	}

	// Search Results
	if ( wpex_option( 'search_custom_sidebar', '1' ) ) {
		register_sidebar( array (
			'name'				=> __( 'Search Results Sidebar','wpex'),
			'id'				=> 'search_sidebar',
			'description'		=> __( 'Widgets in this area are used for your search results sidebar.','wpex' ),
			'before_widget'		=> '<div class="sidebar-box %2$s clr">',
			'after_widget'		=> '</div>',
			'before_title'		=> '<'. $sidebar_headings .' class="widget-title">',
			'after_title'		=> '</'. $sidebar_headings .'>',
		) );
	}

	// WooCommerce
	if ( class_exists('Woocommerce') && wpex_option( 'woo_custom_sidebar', '1' ) ) {
		register_sidebar( array (
			'name'				=> __( 'WooCommerce Sidebar','wpex'),
			'id'				=> 'woo_sidebar',
			'description'		=> __( 'Widgets in this area are used in your WooCommerce sidebar for shop pages and product posts.','wpex' ),
			'before_widget'		=> '<div class="sidebar-box %2$s clr">',
			'after_widget'		=> '</div>',
			'before_title'		=> '<'. $sidebar_headings .' class="widget-title">',
			'after_title'		=> '</'. $sidebar_headings .'>',
		) );
	}

	// bbPress
	if ( class_exists( 'bbPress' ) && wpex_option( 'bbpress_custom_sidebar', '1' ) ) {
		register_sidebar( array (
			'name'				=> __( 'bbPress Sidebar','wpex'),
			'id'				=> 'bbpress_sidebar',
			'description'		=> __( 'Widgets in this area are used in the bbPress sidebar.','wpex' ),
			'before_widget'		=> '<div class="sidebar-box %2$s clr">',
			'after_widget'		=> '</div>',
			'before_title'		=> '<'. $sidebar_headings .' class="widget-title">',
			'after_title'		=> '</'. $sidebar_headings .'>',
		) );
	}

	// Footer
	if( wpex_option( 'widgetized_footer', '1' ) ) {
		
		// Footer 1
		register_sidebar( array (
			'name'				=> __( 'Footer 1','wpex'),
			'id'				=> 'footer_one',
			'description'		=> __( 'Widgets in this area are used in the first footer column','wpex' ),
			'before_widget'		=> '<div class="footer-widget %2$s clr">',
			'after_widget'		=> '</div>',
			'before_title'		=> '<'. $footer_headings .' class="widget-title">',
			'after_title'		=> '</'. $footer_headings .'>',
		) );
		
		// Footer 2
		if ( wpex_option('footer_col','4') > "1" ) {
			register_sidebar( array (
				'name'				=> __( 'Footer 2','wpex'),
				'id'				=> 'footer_two',
				'description'		=> __( 'Widgets in this area are used in the second footer column','wpex' ),
				'before_widget'		=> '<div class="footer-widget %2$s clr">',
				'after_widget'		=> '</div>',
				'before_title'		=> '<'. $footer_headings .' class="widget-title">',
				'after_title'		=> '</'. $footer_headings .'>'
			) );
		}
		
		// Footer 3
		if ( wpex_option('footer_col','4') > "2" ) {
			register_sidebar( array (
				'name'				=> __( 'Footer 3','wpex'),
				'id'				=> 'footer_three',
				'description'		=> __( 'Widgets in this area are used in the third footer column','wpex' ),
				'before_widget'		=> '<div class="footer-widget %2$s clr">',
				'after_widget'		=> '</div>',
				'before_title'		=> '<'. $footer_headings .' class="widget-title">',
				'after_title'		=> '</'. $footer_headings .'>',
			) );
		}
		
		// Footer 4
		if ( wpex_option('footer_col','4') > "3" ) {
			register_sidebar( array (
				'name'				=> __( 'Footer 4','wpex'),
				'id'				=> 'footer_four',
				'description'		=> __( 'Widgets in this area are used in the fourth footer column','wpex' ),
				'before_widget'		=> '<div class="footer-widget %2$s clr">',
				'after_widget'		=> '</div>',
				'before_title'		=> '<'. $footer_headings .' class="widget-title">',
				'after_title'		=> '</'. $footer_headings .'>',
			) );
		}
		
	} // End Footer widgets

} // End wpex_register_sidebars
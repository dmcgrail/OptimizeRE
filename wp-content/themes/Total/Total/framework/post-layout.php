<?php
/**
 * Returns the correct main layout class for the current post/page/archive/etc
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/

if ( ! function_exists( 'wpex_get_post_layout_class' ) ) {
	function wpex_get_post_layout_class() {
		
		// Vars
		global $post;
		$class = 'right-sidebar';
		$post_types = get_post_types( '', 'names' ); 
		$blog_archives_layout = wpex_option( 'blog_archives_layout', 'right-sidebar' );
		if ( $post ) {
			$post_id = $post->ID;
		}
		
		// Loop through post types
		foreach ( $post_types as $post_type ) {
			if ( is_singular( $post_type ) ) {
				if ( $post_type == 'post' ) {
					$post_type = 'blog';
				}
				$admin_id = $post_type .'_single_layout';
				$admin_setting = wpex_option( $admin_id, 'right-sidebar' );
				$meta = get_post_meta( $post_id, 'wpex_post_layout', true );
				if ( '' != $meta ) {
					$class = $meta;
				} elseif( $admin_setting ) {
					$class = $admin_setting;
				}
			}
		}

		// WooCommerce
		if ( class_exists( 'Woocommerce' ) ) {
			if ( wpex_option( 'woo_custom_sidebar', '1' ) && is_woocommerce() ) {
				$class = wpex_woo_layout_class();
			}
			if ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) {
				$class = wpex_woo_layout_class();
			}
		}

		// Cats
		if ( is_category() ) {
			$term = get_query_var('cat');
			$term_data = get_option("category_$term");
			if ( $term_data ) {
				if( $term_data['wpex_term_layout'] !== '' ){
					$class = $term_data['wpex_term_layout'];
				}
			} else {
				$class = $blog_archives_layout;
			}
		}
		
		// Archives
		if ( is_archive() || is_author() || is_page_template('templates/blog.php') ) {
			if ( is_post_type_archive() ) {
				$class = $class;
			} else {
				$class = $blog_archives_layout;
			}
		}
		
		// Portfolio tax
		if ( is_tax( 'portfolio_category' ) || is_tax( 'portfolio_tag' ) ) {
			$class = wpex_option( 'portfolio_archive_layout', 'full-width' );
		}
		
		// Staff tax
		if ( is_tax( 'staff_category' ) || is_tax( 'staff_tag' ) ) {
			$class = wpex_option( 'staff_archive_layout', 'full-width' );
		}
		
		// Testimonials tax
		if ( is_tax( 'testimonials_category' ) || is_tax( 'testimonials_tag' ) ) {
			$class = wpex_option( 'testimonials_archive_layout', 'full-width' );
		}

		// Tribe Events
		if ( function_exists( 'tribe_is_month' ) ) {
			if( tribe_is_month() ) {
				$class = 'full-width';
			} elseif ( function_exists( 'tribe_is_event' ) && function_exists( 'tribe_is_day' ) && tribe_is_event() && !tribe_is_day() && !is_single() ) {
				$class = 'full-width';
			} elseif ( function_exists( 'tribe_is_day' ) && tribe_is_day() ) {
				$class = 'full-width';
			}
			if ( is_singular( 'tribe_events' ) ) {
				$meta = get_post_meta( $post_id, 'wpex_post_layout', true );
				if ( '' != $meta ) {
					$class = $meta;
				} else {
					$class = 'full-width';
				}
			}
		}

		// Return the correct class name
		$class = apply_filters( 'wpex_post_layout_class', $class );
		
		return $class;
		
	}
}
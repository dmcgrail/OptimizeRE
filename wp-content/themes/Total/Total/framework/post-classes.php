<?php
/**
 * Add post type classes to standard entries
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/

if ( ! function_exists( 'wpex_post_entry_classes' ) ) {
	function wpex_post_entry_classes( $classes ) {

		// Return on search and singular
		if ( is_search() || is_singular() ) {
			return $classes;
		}
		
		// Post Data
		global $post;
		$post_id = $post->ID;
		$post_type = get_post_type($post_id);
				
		// Custom class for non standard post types
		if ( $post_type !== 'post' ) {
			$theme_post_types = array( 'post', 'portfolio', 'staff', 'testimonials', 'product' );
			if ( !in_array($post_type, $theme_post_types) ) {
				// Non Theme related post types
				$classes[] = 'custom-post-type-entry';
			} else {
				$classes[] = $post_type .'entry';
			}
			return $classes;
		}
		
		// Main vars
		$blog_style = 'large-image';
		$grid_columns = 'span_1_of_2';
		$admin_blog_style = wpex_option( 'blog_style', 'large-image-entry-style' );
		$admin_grid_columns = wpex_option( 'blog_grid_columns', '2' );
		
		// Main Classes
		$classes[] = 'blog-entry clr';
		
		// No Featured Image Class
		if ( !has_post_thumbnail( $post_id ) && '' == get_post_meta( get_the_ID(), 'wpex_post_self_hosted_shortcode', true ) && '' == get_post_meta( get_the_ID(), 'wpex_post_oembed', true ) ) {
			$classes[] = 'no-featured-image';
		}
		
		// Blog Styles
		if ( is_category() ) {
			$term = get_query_var('cat');
			$term_data = get_option("category_$term");
			$term_style  = '';
			$grid_columns = '';
			
			if ( $term_data ) {
				
				if ( isset($term_data['wpex_term_style']) ) {
					$term_style = $term_data['wpex_term_style'] !== '' ? $term_data['wpex_term_style'] .'' : '';
				}
				
				if ( isset($term_data['wpex_term_grid_cols']) ) {
					$grid_columns = $term_data['wpex_term_grid_cols'] !== '' ? $term_data['wpex_term_grid_cols'] .'' : '';
				}
			
			}
			
			$blog_style = $term_style !== '' ? $term_style .'-entry-style' : $admin_blog_style;
			
			$grid_columns = $grid_columns !== '' ? $grid_columns : $admin_grid_columns;
			
		} else {
			$blog_style = $admin_blog_style;
			$grid_columns = $admin_grid_columns;
		}		

		// Add columns for grid style entries
		if ( $blog_style == 'grid-entry-style' ) {
			$classes[] = 'col';
			$classes[] = wpex_grid_class( $grid_columns );
		}

		// Return classes based on admin setting
		$classes[] = $blog_style;
			
		return $classes;
		
	} // End function
} // End if

add_filter( 'post_class', 'wpex_post_entry_classes' );
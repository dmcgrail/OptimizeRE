<?php
/**
 * Custom pagination functions
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

/**
 * Numbered Pagination
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( !function_exists( 'wpex_pagination' ) ) {
	function wpex_pagination() {
		
		// Arrows with RTL support
		$prev_arrow = is_rtl() ? 'fa fa-angle-right' : 'fa fa-angle-left';
		$next_arrow = is_rtl() ? 'fa fa-angle-left' : 'fa fa-angle-right';
		
		// Get vars
		global $wp_query;
		$total = $wp_query->max_num_pages;
		$big = 999999999;

		// Display pagination
		if( $total > 1 ) {
			if( !$current_page = get_query_var('paged') )
				$current_page = 1;
			if( get_option('permalink_structure') ) {
				$format = 'page/%#%/';
			} else {
				$format = '&paged=%#%';
			}
			echo paginate_links(array(
				'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'		=> $format,
				'current'		=> max( 1, get_query_var('paged') ),
				'total'			=> $total,
				'mid_size'		=> 3,
				'type'			=> 'list',
				'prev_text'		=> '<i class="'. $prev_arrow .'"></i>',
				'next_text'		=> '<i class="'. $next_arrow .'"></i>',
			 ) );
		}

	}
}

/**
 * Next/Prev Pagination
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( !function_exists( 'wpex_pagejump' ) ) {
	function wpex_pagejump( $pages = '', $range = 4 ) {

		$output = '';
		$showitems = ($range * 2)+1; 
		global $paged;
		if(empty($paged)) $paged = 1;
		
		if( $pages == '' ) {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages) {
				$pages = 1;
			}
		}
		
		if( 1 != $pages ) {
		$output .= '<div class="page-jump clr">';
			$output .= '<div class="alignleft newer-posts">';
				$output .= get_previous_posts_link('&larr; '. __( 'Newer Posts', 'wpex' ) );
			$output .= '</div>';
			$output .= '<div class="alignright older-posts">';
				$output .= get_next_posts_link( __( 'Older Posts', 'wpex' ) .' &rarr;');
			$output .= '</div>';
		$output .= '</div>';
		}
		
		echo $output;
	}
}


/**
 * Infinite Scroll Pagination
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( !function_exists( 'wpex_infinite_scroll' ) ) {
	function wpex_infinite_scroll( $type = 'standard' ) {
		
		// Load infinite scroll js for standard blog style
		if ( $type == 'standard' ) {
			wp_enqueue_script( 'wpex-infinitescroll', WPEX_JS_DIR_URI .'infinitescroll-standard.js', array( 'jquery' ), 1.0, true );
		}
		
		
		// Load infinite scroll js for grid
		if ( $type == 'standard-grid' ) {
			wp_enqueue_script( 'wpex-infinitescroll', WPEX_JS_DIR_URI .'infinitescroll-standard-grid.js', array( 'jquery' ), 1.0, true );
		}
		
		// Localize loading text
		$is_params = array( 'msgText' => __( 'Loading...', 'wpex' ) );
		wp_localize_script( 'wpex-infinitescroll', 'wpexInfiniteScroll', $is_params );	
		
		// Output pagination HTML
		$output = '';
		$output .= '<div class="infinite-scroll-nav clr">';
			$output .= '<div class="alignleft newer-posts">';
				$output .= get_previous_posts_link('&larr; '. __( 'Newer Posts', 'wpex' ) );
			$output .= '</div>';
			$output .= '<div class="alignright older-posts">';
				$output .= get_next_posts_link( __( 'Older Posts', 'wpex' ) .' &rarr;');
			$output .= '</div>';
		$output .= '</div>';

		echo $output;

	}
}

/**
 * Blog Pagination
 * Used to load the correct pagination function for blog archives
 * Execute the correct pagination function based on the theme settings
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( !function_exists( 'wpex_blog_pagination' ) ) {
	function wpex_blog_pagination() {
		
		// Admin Options
		$blog_style = wpex_option( 'blog_style', 'large-image' );
		$pagination_style = wpex_option( 'blog_pagination_style', 'standard' );
		
		// Category based settings
		if ( is_category() ) {
			
			// Get taxonomy meta
			$term = get_query_var( 'cat' );
			$term_data = get_option( "category_$term" );
			$term_style = $term_pagination = '';
			
			if ( isset( $term_data['wpex_term_style'] ) ) {
				$term_style = '' != $term_data['wpex_term_style'] ? $term_data['wpex_term_style'] .'' : $term_style;
			}
			
			if ( isset( $term_data['wpex_term_pagination'] ) ) {
				$term_pagination = '' != $term_data['wpex_term_pagination'] ? $term_data['wpex_term_pagination'] .'' : '';
			}
			
			if ( $term_style ) {
				$blog_style = $term_style .'-entry-style';
			}
			
			if ( $term_pagination ) {
				$pagination_style = $term_pagination;
			}
			
		}
		
		// Set default $type for infnite scroll
		$infinite_type = ( $blog_style == 'grid-entry-style' ) ? 'standard-grid' : 'standard';
		
		// Execute the correct pagination function
		if ( 'infinite_scroll' == $pagination_style ) {
			wpex_infinite_scroll( $infinite_type );
		} elseif ( $pagination_style == 'next_prev' ) {
			wpex_pagejump();
		} else {
			wpex_pagination();
		}

	}
}
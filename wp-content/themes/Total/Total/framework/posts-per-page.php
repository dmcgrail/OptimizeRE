<?php
/**
 * This file filters the default WP pagination where needed
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/

$wpex_posts_per_page = get_option( 'posts_per_page' );

add_action( 'init', 'wpex_modify_posts_per_page', 0);

if ( ! function_exists( 'wpex_modify_posts_per_page' ) ) {
	function wpex_modify_posts_per_page() {
		add_filter( 'option_posts_per_page', 'wpex_posts_per_page' );
	}
}

if ( ! function_exists ( 'wpex_posts_per_page' ) ) {
	
	function wpex_posts_per_page( $value ) {
		
		global $wpex_posts_per_page;
		
		// Portfolio Pagination
		if ( is_tax( 'portfolio_category' ) || is_tax( 'portfolio_tag' ) || is_post_type_archive( 'portfolio' ) ) {
			return wpex_option( 'portfolio_archive_posts_per_page', '12' );
		}
		
		// Staff Pagination
		if ( is_tax( 'staff_category' ) || is_tax( 'staff_tag' ) || is_post_type_archive( 'staff' ) ) {
			return wpex_option( 'staff_archive_posts_per_page', '12' );
		}

		// Testimonials Pagination
		if ( is_tax( 'testimonials_category' ) || is_tax( 'testimonials_tag' ) || is_post_type_archive( 'testimonials' ) ) {
			return wpex_option( 'testimonials_archive_posts_per_page', '12' );
		}
		
		// Search pagination
		if ( is_search() ) {
			return wpex_option( 'search_posts_per_page', '10' );
		}
		
		// Category pagination
		// If running 3.8 this won't work unfortunately there is a bug - http://core.trac.wordpress.org/ticket/26627
		global $wp_version;
		if ( $wp_version !== '3.8' ) {
			$terms = get_terms('category');
			if ( !empty($terms)){
				foreach ( $terms as $term ) {
					$term_slug = $term->slug;
					$is_cat = is_category( $term_slug);
					if ( $is_cat ) {
						$term_id = $term->term_id;
						$term_data = get_option("category_$term_id");
						if ( $term_data ) {
							if ( isset($term_data['wpex_term_posts_per_page']) ) {
								$term_posts_per_page = $term_data['wpex_term_posts_per_page'] !== '' ? $term_data['wpex_term_posts_per_page'] .'' : '';
								return $term_posts_per_page !== '' ? $term_posts_per_page : $wpex_posts_per_page;
							} else {
								return $wpex_posts_per_page;
							}
						} else {
							return $wpex_posts_per_page;
						}
					}
				}
			}
		}
		
		// Everything else
		return $wpex_posts_per_page;
	}

}
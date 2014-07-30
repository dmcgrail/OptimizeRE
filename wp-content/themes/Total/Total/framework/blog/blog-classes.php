<?php
/**
 * Add classes to the blog entries wrap
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 */

if ( ! function_exists( 'wpex_blog_wrap_classes' ) ) {
	
	function wpex_blog_wrap_classes( $classes=false ) {
		
		// Return custom class if set
		if ( $classes !== false ) {
			return $class;
		}
		
		
		// Admin defaults
		$style = wpex_option( 'blog_style' );
		$pagination = wpex_option( 'blog_pagination_style' );
		$author_avatars = wpex_option( 'blog_entry_author_avatar' );
		
		// Category options
		if ( is_category() ) {
			
			// Get taxonomy meta
			$term = get_query_var('cat');
			$term_data = get_option("category_$term");
			
			if ( isset($term_data['wpex_term_style']) ) {
				$term_style = $term_data['wpex_term_style'] !== '' ? $term_data['wpex_term_style'] .'' : $wpex_term_style;
			}
			
			if ( isset($term_data['wpex_term_pagination']) ) {
				$term_pagination = $term_data['wpex_term_pagination'] !== '' ? $term_data['wpex_term_pagination'] .'' : '';
			}
			
			if ( $term_style ) {
				$style = $term_style .'-entry-style';
			}
			
			if ( $term_pagination ) {
				$pagination = $term_pagination;
			}
			
		}
		
		
		// Isotope classes
		if ( $style == 'grid-entry-style' ) {
			$classes .= 'wpex-row blog-masonry-grid ';
		}
		
		// Add some margin when author is enabled
		if ( $style == 'grid-entry-style' && $author_avatars == '1' ) {
			$classes .= 'grid-w-avatars';
		}
		
		// Infinite scroll classes
		if ( $pagination == 'infinite_scroll' ) {
			$classes .= 'infinite-scroll-wrap';
		}
		

// Return classes -------------------------------------------------------------------------- >	
	
		echo apply_filters( 'wpex_blog_wrap_classes', $classes );
		
	} // End function
	
} // End if


/**
 * Adds animation classes to blog post entries
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.16
 */
if ( ! function_exists( 'wpex_img_animation_classes' ) ) {
	function wpex_img_animation_classes() {
		global $post;
		$animation = wpex_option( 'blog_entry_image_hover_animation' );
		if ( 'post' != get_post_type( $post->ID ) ) return;
		if ( isset($_GET['img_hover_animation'] ) ) {
			$animation = $_GET['img_hover_animation'];
		}
		if( $animation ) {
			echo 'wpex-img-hover-parent wpex-img-hover-'. $animation;
		}
	}
}
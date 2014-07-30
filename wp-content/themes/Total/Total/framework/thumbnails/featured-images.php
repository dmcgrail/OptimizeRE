<?php
/**
 * Creates a function for your featured image sizes which can be altered via your child theme
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/

if ( ! function_exists( 'wpex_image' ) ) {
	function wpex_image( $return = 'url', $custom_id = '', $custom_query = false ) {

		// Post Vars
		global $post;
		$post_id = $post->ID;
		$post_type = get_post_type( $post_id );
		$attachment_id = $custom_id ? $custom_id : get_post_thumbnail_id( $post_id );
		$attachment_url = wp_get_attachment_url( $attachment_id );
		$post_layout = get_post_meta ( $post_id, 'wpex_post_layout', true );
		$post_media_position = get_post_meta ( $post_id, 'wpex_post_media_position', true );
		
		// Resizing Vars
		$width = 9999;
		$height = 9999;
		$crop = false;
		
		/**
			Pages
		**/
		if ( 'page' == $post_type && is_singular( 'page' ) ) {
			$width = wpex_option( 'page_image_width', '9999' );
			$height = wpex_option( 'page_image_height', '9999' );
		}

		/**
			Standard Post Type
		**/
		if ( 'post' == $post_type ) {

			// Singular
			if ( is_singular( 'post' ) ) {
				
				if ( $custom_query ) {
					
					// Related Post Width
					$width = wpex_option( 'blog_related_image_width', '9999' );
					
					// Related Post Height
					$height = wpex_option( 'blog_related_image_height', '9999' );
						
				} else {
					
					// Single Post Width
					if ( $post_layout == 'full-width' || $post_media_position || wpex_option( 'blog_single_layout' ) == 'full-width' ) {
						$width = wpex_option( 'blog_post_full_image_width', '9999' );
					} else {
						$width = wpex_option( 'blog_post_image_width', '9999' );
					}
					
					// Single Post Height
					if ( wpex_option( 'blog_single_layout' ) == 'full-width' || $post_layout == 'full-width' || $post_media_position ) {
						$height =  wpex_option( 'blog_post_full_image_height', '9999' );
					} else {
						$height = wpex_option( 'blog_post_image_height', '9999' );
					}
				
				}
				
			// Entries
			} else {
				
				// Categories
				if ( is_category() ) {
					
					// Get term data
					$term = get_query_var('cat');
					$term_data = get_option("category_$term");
					
					// Width
					if ( isset($term_data['wpex_term_image_width']) ) {
						if ( $term_data['wpex_term_image_width'] !== '' ) {
							$width = $term_data['wpex_term_image_width'];
						} else {
							$width = wpex_option( 'blog_entry_image_width', '9999' );
						}
					} else {
						$width = wpex_option( 'blog_entry_image_width', '9999' );
					}
					
					// height
					if ( isset($term_data['wpex_term_image_height']) ) {
						if ( $term_data['wpex_term_image_height'] !== '' ) {
							$height = $term_data['wpex_term_image_height'];
						} else {
							$height = wpex_option( 'blog_entry_image_height', '9999' );
						}
					} else {
						$height = wpex_option( 'blog_entry_image_height', '9999' );
					}
					
				// All Else
				} else {
				
					$width = wpex_option( 'blog_entry_image_width', '9999' );
					$height = wpex_option( 'blog_entry_image_height', '9999' );
				
				}
				
			} // End if singular

		} // End if post_type

		/**
			Staff Post Type
		**/
		if ( 'staff' == $post_type ) {
			$width = wpex_option( 'staff_entry_image_width', '9999' );
			$height = wpex_option( 'staff_entry_image_height', '9999' );
		} // End if post_type

		/**
			Portfolio Post Type
		**/
		if ( 'portfolio' == $post_type ) {
			if ( is_singular() && $custom_query ) {
				$width = wpex_option( 'portfolio_post_image_width', '9999' );
				$height = wpex_option( 'portfolio_post_image_height', '9999' );
			} else {
				$width = wpex_option( 'portfolio_entry_image_width', '9999' );
				$height = wpex_option( 'portfolio_entry_image_height', '9999' );
			}
		}

		/**
			Testimonials Post Type
		**/
		if ( 'testimonials' == $post_type ) {
			$width = wpex_option( 'testimonial_entry_image_width', '9999' );
			$height = wpex_option( 'testimonial_entry_image_height', '9999' );
		} // End if post_type

		/**
			Search
		**/
		if ( is_search() ) {
			$width = '100';
			$height = '100';
		}

		/**
			Output
		**/

		// Width
		$width = intval($width);
		$width = $width ? $width : '9999';
		$width = apply_filters( 'wpex_image_width', $width );
		// Height
		$height = intval($height);
		$height = $height ? $height : '9999';
		$height = apply_filters( 'wpex_image_height', $height );
		// Crop
		$crop = ( $height == '9999' ) ? false : true;
		// Run aq function
		$resized_array = wpex_image_resize( $attachment_url, $width, $height, $crop, 'array' );
		// Return data
		if ( 'url' == $return ) {
			return $resized_array['url'];
		} elseif ( 'array' == $return ) {
			return $resized_array;
		}

	}
}
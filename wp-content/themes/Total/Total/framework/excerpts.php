<?php
/**
 * Custom excerpt functions
 * 
 * http://codex.wordpress.org/Function_Reference/wp_trim_words
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/


// Custom Excerpt output function
if ( !function_exists( 'wpex_excerpt' ) ) {
	function wpex_excerpt( $length=30, $readmore=false, $apply_filters=true ) {

		// Vars
		global $post;
		$post_id = $post->ID;
		$excerpt ='';
		$meta_excerpt = get_post_meta( $post_id, 'wpex_excerpt_length', true );
		$length = $meta_excerpt ? $meta_excerpt : $length;
		$post_content = get_the_content( $post_id );
		$supported_html = array(
			'a'			=> array(
				'href'	=> array(),
				'title'	=> array(),
			),
			'br'		=> array(),
			'em'		=> array(),
			'strong'	=> array(),
		);
		$supported_html = apply_filters( 'wpex_supported_excerpt_html', $supported_html );

		//Filter for changing the readmore text via a child theme
		$readmore_text = apply_filters( 'wpex_read_more_text', __('view post', 'wpex' ) );

		// Custom excerpt field
		if ( has_excerpt( $post_id ) ) {
			$excerpt = $post->post_excerpt;
			$excerpt = wp_trim_words( $excerpt, $length );
			$excerpt = apply_filters( 'wpex_custom_excerpt_output', $excerpt );
		// Create excerpts from the trimmed content
		} else {
			// Check if text shortcode in post
			if ( strpos( $post_content, '[vc_column_text]') ) {
				$pattern = '{\[vc_column_text\](.*?)\[/vc_column_text\]}is';
				preg_match( $pattern, $post_content, $match );
				if( isset( $match[1] ) ) {
					//$excerpt = str_replace('[vc_column_text]', '', $match[0] );
					//$excerpt = str_replace('[/vc_column_text]', '', $excerpt );
					$excerpt = wp_trim_words( $match[1], $length );
				} else {
					$content = strip_shortcodes( $post_content );
					$excerpt = wp_trim_words( $content, $length );
				}
			} else {
				$excerpt = strip_shortcodes( $post_content );
				$excerpt = wp_trim_words( $excerpt, $length );
			}
		}

		// Clean up excerpt
		$excerpt = wp_kses( $excerpt, $supported_html );
		if ( $apply_filters ) {
			$excerpt = apply_filters( 'the_content', $excerpt );
		}
		$return = $excerpt;

		// Readmore link
		if ( $readmore == true && '' != $excerpt ) {
			$readmore_link = '<span class="readmore-link-wrap"><a href="'. get_permalink( $post_id ) .'" title="'. $readmore_text .'" rel="bookmark" class="readmore-link theme-button">'. $readmore_text .' <span class="readmore-rarr">&rarr;</span></a><span>';
			$return .= apply_filters( 'wpex_readmore_link', $readmore_link );
		}

		// Return Excerpt
		echo $return;

	}
}


// Custom Excerpt return function
if ( !function_exists( 'wpex_get_excerpt' ) ) {
	function wpex_get_excerpt( $length=30 ) {
		// Vars
		global $post;
		$post_id = $post->ID;
		$excerpt='';
		$meta_excerpt = get_post_meta( $post_id, 'wpex_excerpt_length', true );
		$length = $meta_excerpt ? $meta_excerpt : $length;
		$post_content = get_the_content( $post_id );
		//Filter for changing the readmore text via a child theme
		$readmore_text = apply_filters( 'wpex_read_more_text', __('view post', 'wpex' ) );
		// Custom excerpt field
		if ( has_excerpt( $post_id ) ) {
			$excerpt = apply_filters( 'the_content', $post->post_excerpt );
		// Create excerpts from the trimmed content
		} else {
			// Check if text shortcode in post
			if ( strpos( $post_content, '[vc_column_text]') ) {
				$pattern = '{\[vc_column_text\](.*?)\[/vc_column_text\]}is';
				preg_match( $pattern, $post_content, $match );
				if( isset( $match[1] ) ) {
					//$excerpt = str_replace('[vc_column_text]', '', $match[0] );
					//$excerpt = str_replace('[/vc_column_text]', '', $excerpt );
					$excerpt = wp_trim_words( $match[1], $length );
				} else {
					$content = strip_shortcodes( $post_content );
					$excerpt .= wp_trim_words( $content, $length );
				}
			} else {
				$content = strip_shortcodes( $post_content );
				$excerpt .= wp_trim_words( $content, $length );
			}
		}
		// Echo the excerpt
		return $excerpt;
	}
}

// Custom Excerpt length for posts
if ( !function_exists( 'wpex_excerpt_length' ) ) {
	function wpex_excerpt_length() {
		// Theme panel length setting
		$length = wpex_option( 'blog_excerpt_length', '40');
		// Taxonomy setting
		if ( is_category() ) {
			// Get taxonomy meta
			$term = get_query_var('cat');
			$term_data = get_option("category_$term");
			if ( isset($term_data['wpex_term_excerpt_length']) ) {
				$length = $term_data['wpex_term_excerpt_length'] !== '' ? $term_data['wpex_term_excerpt_length'] .'' : $length;
			}
		}
		// Return length and add filter for quicker child theme editign
		return apply_filters( 'wpex_excerpt_length', $length );
	} // End function
} // End if


// Change default read more style
if ( !function_exists( 'wpex_excerpt_more' ) ) {
	function wpex_excerpt_more($more) {
		global $post;
		return '...';
	}
}
add_filter('excerpt_more', 'wpex_excerpt_more');


// Change default excerpt length
if ( !function_exists( 'wpex_custom_excerpt_length' ) ) {
	function wpex_custom_excerpt_length( $length ) {
		return wpex_option( 'excerpt_length', '65' );
	}
}
add_filter( 'excerpt_length', 'wpex_custom_excerpt_length', 999 );


// Prevent Page Scroll When Clicking the More Link
// Learn more @ http://codex.wordpress.org/Customizing_the_Read_More
if ( !function_exists( 'wpex_remove_more_link_scroll' ) ) {
	function wpex_remove_more_link_scroll( $link ) {
		$link = preg_replace( '|#more-[0-9]+|', '', $link );
		return $link;
	}
}
add_filter( 'the_content_more_link', 'wpex_remove_more_link_scroll' );
<?php
/**
 * Used for the blog posts readmore link
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/


if ( ! function_exists( 'wpex_post_readmore_link' ) ) {
	
	function wpex_post_readmore_link() {
		
		global $post;
		$post_id = $post->ID;
		$permalink = get_permalink($post_id);
		$text = wpex_option( 'blog_entry_readmore_text' );
		$text = $text ? $text : apply_filters( 'wpex_post_readmore_link_text', __( 'Continue Reading', 'wpex' ) );
		$output = '';
		
		// Display read more link if entries are enabled and it's not a password protected post
		if ( wpex_option( 'blog_exceprt', '1' ) == '1' && wpex_option( 'blog_entry_readmore', '1' ) == '1' && !post_password_required() ) {
		
			// The readmore link output
			$output .='<div class="blog-entry-readmore clr">';
				$output .='<a href="'. $permalink .'" class="theme-button" title="'. $text .'">'. $text .'<span class="readmore-rarr">&rarr;</span></a>';
			$output .='</div>';
		
		} else {
			return; // nada
		}
	
		echo $output;
		
	} // End function
	
} // End if
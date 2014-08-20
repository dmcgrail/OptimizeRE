<?php
/**
 * Portfolio category related functions
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/



// Displays Portfolio Categories For current postid	
if ( ! function_exists('wpex_portfolio_cats') ) {
	function wpex_portfolio_cats($postid) {
		$cats = get_the_terms( $postid, 'portfolio_category' );
		$output = '';	
		if( $cats ) {
			$output .= '<div class="portfolio-entry-cats clearfix">';
				foreach( $cats as $cat ) {
					$output .= '<a href="'. get_term_link($cat->slug, 'portfolio_category') .'" title="'. $cat->name .'">'. $cat->name .'<span>,</span></a>';
				}
			$output .='</div><!-- .portfolio-entry-cats -->';
		}
		return $output;	
	}
}



// Displays the first category of a given portfolio
if ( ! function_exists( 'wpex_portfolio_first_cat' ) ) {
	function wpex_portfolio_first_cat($postid=false) {
		global $post;
		$postid = $postid ? $postid : $post->ID;
		$cats = get_the_terms( $postid, 'portfolio_category' );
		$output = '';	
		if( $cats ) {
			$count=0;
			foreach( $cats as $cat ) {
				$count++;
				if ( $count == 1 ) {
					$output .= '<a href="'. get_term_link($cat->slug, 'portfolio_category') .'" title="'. $cat->name .'">'. $cat->name .'</a>';
				}
			}
		}
		return $output;
	}
}



// Output Portfolio terms for use with isotope scripts
if ( ! function_exists( 'wpex_portfolio_entry_terms' ) ) {
	function wpex_portfolio_entry_terms() {
		if ( !post_type_exists( 'portfolio' ) ) return;
		global $post;
		if ( ! $post ) return;
		$output='';
		$terms = get_the_terms( $post, 'portfolio_category' );
		if( $terms ) {
			$output = '';
			foreach ( $terms as $term ) {
				$output .= $term->slug .' ';
			}
		}
		return $output;
	}
}
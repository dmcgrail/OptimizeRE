<?php
/**
 * Used to tweak the custom post types
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 */


// Alter Portfolio $args
if ( ! function_exists( 'wpex_tweak_portfolio_args' ) ) {
	function wpex_tweak_portfolio_args($args) {
		
		// Vars
		$search = wpex_option('portfolio_search','1');
		$menu_icon = wpex_option('portfolio_admin_icon');
		
		// Tweaks
		if ( $search !== '1' ) {
			$args['exclude_from_search'] = true;
		}
		
		if ( $menu_icon !== '' && !is_array($menu_icon) ) {
			$args['menu_icon'] = 'dashicons-'. $menu_icon;
		}
		
		return $args;
		
	} // End function
} // End if
add_action('wpex_portfolio_args','wpex_tweak_portfolio_args');


// Alter Staff $args
if ( ! function_exists( 'wpex_tweak_staff_args' ) ) {
	function wpex_tweak_staff_args($args) {
		
		// Vars
		$search = wpex_option('staff_search','1');
		$menu_icon = wpex_option('staff_admin_icon');
		
		// Tweaks
		if ( $search !== '1' ) {
			$args['exclude_from_search'] = true;
		}
		
		if ( $menu_icon !== '' && !is_array($menu_icon) ) {
			$args['menu_icon'] = 'dashicons-'. $menu_icon;
		}
		
		return $args;
		
	} // End function
} // End if
add_action('wpex_staff_args','wpex_tweak_staff_args');


// Alter Testimonials $args
if ( ! function_exists( 'wpex_tweak_testimonials_args' ) ) {
	function wpex_tweak_testimonials_args($args) {
		
		// Vars
		$search = wpex_option('testimonials_search','1');
		$menu_icon = wpex_option('testimonials_admin_icon');
		
		// Tweaks
		if ( $search !== '1' ) {
			$args['exclude_from_search'] = true;
		}
		
		if ( $menu_icon !== '' && !is_array($menu_icon) ) {
			$args['menu_icon'] = 'dashicons-'. $menu_icon;
		}
		
		return $args;
		
	}
}
add_action('wpex_testimonials_args','wpex_tweak_testimonials_args');


//Remove the slug from portfolio post type
function wpex_remove_cpt_slug( $post_link, $post, $leavename ) {
	$post_types = wpex_active_post_types();
	if ( ! in_array( $post->post_type, $post_types ) || 'publish' != $post->post_status ) {
		return $post_link;
	}
	foreach ( $post_types as $post_type ) {
		$post_link = str_replace( '/'. wpex_option( $post_type .'_slug' ) .'/', '/', $post_link );
	}
	return $post_link;
}
function wpex_parse_request_tricksy( $query ) {
	// Get theme post types
	$post_types = wpex_active_post_types();
	// Only noop the main query
	if ( ! $query->is_main_query() )
		return;
	// Only noop our very specific rewrite rule match
	if ( 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
		return;
	}
	// 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
	if ( ! empty( $query->query['name'] ) ) {
		$array = array( 'post', 'page' );
		$array = array_merge( $array, $post_types );
		$query->set( 'post_type', $array );
	}
}
if ( wpex_option( 'remove_posttype_slugs' ) ) {
	add_filter( 'post_type_link', 'wpex_remove_cpt_slug', 10, 3 );
	add_action( 'pre_get_posts', 'wpex_parse_request_tricksy' );
}
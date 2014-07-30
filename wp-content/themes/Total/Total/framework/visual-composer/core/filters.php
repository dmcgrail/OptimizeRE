<?php
/**
 * Tweak Visual Composer & Visual Composer Extension
 * Via custom filters
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 */


// Run code in admin only
if ( !is_admin() ) return;

// Remove VC Teaser metabox
if ( ! function_exists('wpex_remove_vc_boxes') ) {
	function wpex_remove_vc_boxes(){
		$post_types = get_post_types( '', 'names' ); 
		foreach ( $post_types as $post_type ) {
			remove_meta_box('vc_teaser',  $post_type, 'side');
		}
	} // End function
} // End if
add_action('do_meta_boxes', 'wpex_remove_vc_boxes');
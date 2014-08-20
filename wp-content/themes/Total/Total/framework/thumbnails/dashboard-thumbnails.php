<?php
/**
 * Create Custom Columns for the WP dashboard
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 */

// Only needed in the admin
if( ! is_admin() ) {
	return;
}

// If disabled do nothing
if ( ! wpex_option( 'blog_dash_thumbs', '1' ) ) {
	return;
}

// Add thumbnails to post admin dashboard
add_filter( 'manage_post_posts_columns', 'wpex_posts_columns', 10 );
add_filter( 'manage_portfolio_posts_columns', 'wpex_posts_columns', 10 );
add_filter( 'manage_testimonials_posts_columns', 'wpex_posts_columns', 10 );
add_filter( 'manage_staff_posts_columns', 'wpex_posts_columns', 10 );
add_action( 'manage_posts_custom_column', 'wpex_posts_custom_columns', 10, 2 );

if ( ! function_exists( 'wpex_posts_columns' ) ) {
	function wpex_posts_columns( $defaults ){
		$defaults['wpex_post_thumbs'] = __( 'Featured Image', 'wpex' );
		return $defaults;
	}
}

if ( ! function_exists( 'wpex_posts_custom_columns' ) ) {
	function wpex_posts_custom_columns( $column_name, $id ){
		$post_id = get_the_ID();
		if( $column_name != 'wpex_post_thumbs' ) {
			return;
		}
		$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
		if ( $thumbnail_id ) {
			$width = apply_filters( 'wpex_dashboard_thumbnail_width', '100' );
			$height = apply_filters( 'wpex_dashboard_thumbnail_height', '100' );
			$edit_link = get_edit_post_link($post_id);
			echo '<a href="'. $edit_link .'">'. wp_get_attachment_image( $thumbnail_id, array( $width, $height ), true ) .'</a>';
		} else {
			return;
		}
	}
}
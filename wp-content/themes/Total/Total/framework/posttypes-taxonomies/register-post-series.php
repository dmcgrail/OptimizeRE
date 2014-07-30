<?php
/***
* Special Thanks To Devin Price
* This file is a modified of the original plugin found @https://github.com/devinsays/post_series-post-type - Special Thanks!
***/

if ( ! class_exists( 'WPEX_Post Series_Post_Type' ) ) :
class WPEX_Post_Series_Post_Type {

	function __construct() {

		// Adds the post_series taxonomy to the standard post type
		add_action( 'init', array( &$this, 'post_series_init' ), 0 );
	
	}
	

	function post_series_init() {
	
		/**
		 * Register a taxonomy for Post Series
		 * http://codex.wordpress.org/Function_Reference/register_taxonomy
		 */

		$taxonomy_post_series_category_labels = array(
			'name'							=> __( 'Post Series', 'wpex' ),
			'singular_name'					=> __( 'Post Series', 'wpex' ),
			'search_items'					=> __( 'Search Post Series', 'wpex' ),
			'popular_items'					=> __( 'Popular Post Series', 'wpex' ),
			'all_items'						=> __( 'All Post Series', 'wpex' ),
			'parent_item'					=> __( 'Parent Post Series', 'wpex' ),
			'parent_item_colon'				=> __( 'Parent Post Series:', 'wpex' ),
			'edit_item'						=> __( 'Edit Post Series', 'wpex' ),
			'update_item'					=> __( 'Update Post Series', 'wpex' ),
			'add_new_item'					=> __( 'Add New Post Series', 'wpex' ),
			'new_item_name'					=> __( 'New Post Series Name', 'wpex' ),
			'separate_items_with_commas'	=> __( 'Separate post series with commas', 'wpex' ),
			'add_or_remove_items'			=> __( 'Add or remove post series', 'wpex' ),
			'choose_from_most_used'			=> __( 'Choose from the most used post series', 'wpex' ),
			'menu_name'						=> __( 'Post Series', 'wpex' ),
		);

		$args = array(
			'labels' 				=> $taxonomy_post_series_category_labels,
			'public'				=> true,
			'show_in_nav_menus'		=> true,
			'show_ui'				=> true,
			'show_tagcloud'			=> true,
			'hierarchical'			=> true,
			'rewrite'				=> array( 'slug'	=> 'post_series-category' ),
			'query_var'				=> true
		);

		$wpex_taxonomy_post_series_args = apply_filters('wpex_taxonomy_post_series_args', $args);
		
		register_taxonomy( 'post_series', array( 'post' ), $wpex_taxonomy_post_series_args );

	}

}

new WPEX_Post_Series_Post_Type;

endif;
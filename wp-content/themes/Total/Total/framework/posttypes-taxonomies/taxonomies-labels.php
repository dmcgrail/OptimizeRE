<?php
/**
 * Used for renaming custom taxonomies
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 */

// Cats
if ( ! function_exists( 'wpex_custom_portfolio_category_args' ) ) {
	function wpex_custom_portfolio_category_args( $args ) {
		
		//post name based on theme options
		$post_type_name = __('Portfolio','wpex');
		$post_type_name = wpex_option('portfolio_labels','Portfolio');
		$tax_slug = 'portfolio-category';
		$tax_slug = wpex_option('portfolio_cat_slug','portfolio-category');
		
		$taxonomy_portfolio_category_labels = array(
			'name' => $post_type_name . ' '. __( 'Categories', 'wpex' ),
			'singular_name' => $post_type_name . ' '. __( 'Category', 'wpex' ),
			'search_items' => __( 'Search','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'popular_items' => __( 'Popular','wpex') .' '. $post_type_name .' '. __('Categories', 'wpex' ),
			'all_items' => __( 'All','wpex') .' '. $post_type_name .' '. __('Categories', 'wpex' ),
			'parent_item' => __( 'Parent','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'parent_item_colon' => __( 'Parent','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'edit_item' => __( 'Edit','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'update_item' => __( 'Update','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'add_new_item' =>__( 'Add New','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'new_item_name' => __( 'New','wpex') .' '. $post_type_name .' '. __('Category name', 'wpex' ),
			'separate_items_with_commas'	=> __( 'Seperate','wpex') .' '. $post_type_name .' '. __('categories with commas', 'wpex' ),
			'add_or_remove_items' => __( 'Add or remove','wpex') .' '. $post_type_name .' '. __('categories', 'wpex' ),
			'choose_from_most_used' => __( 'Choose from the most used','wpex') .' '. $post_type_name .' '. __('categories', 'wpex' ),
			'menu_name' => $post_type_name .' '. __('Categories', 'wpex' ),
		);

		$custom_taxonomy_portfolio_category_args = array(
			'labels'	=> $taxonomy_portfolio_category_labels,
			'rewrite'	=> array( 'slug'	=> $tax_slug )
		);
		
		return $custom_taxonomy_portfolio_category_args + $args;
			
	}
	add_filter( 'wpex_taxonomy_portfolio_category_args', 'wpex_custom_portfolio_category_args' );
}


// Tags
if ( ! function_exists( 'wpex_custom_portfolio_tag_args' ) ) {
	function wpex_custom_portfolio_tag_args( $args ) {
		
		//post name based on theme options
		$post_type_name = __('Portfolio','wpex');
		$post_type_name = wpex_option('portfolio_labels','Portfolio');
		$tax_slug = 'portfolio-tag';
		$tax_slug = wpex_option('portfolio_tag_slug','portfolio-tag');
		
		$taxonomy_portfolio_tag_labels = array(
			'name' => $post_type_name . ' '. __( 'Tags', 'wpex' ),
			'singular_name' => $post_type_name . ' '. __( 'Tag', 'wpex' ),
			'search_items' => __( 'Search','wpex') .' '. $post_type_name .' '. __('Tag', 'wpex' ),
			'popular_items' => __( 'Popular','wpex') .' '. $post_type_name .' '. __('Tags', 'wpex' ),
			'all_items' => __( 'All','wpex') .' '. $post_type_name .' '. __('Tags', 'wpex' ),
			'parent_item' => __( 'Parent','wpex') .' '. $post_type_name .' '. __('Tag', 'wpex' ),
			'parent_item_colon' => __( 'Parent','wpex') .' '. $post_type_name .' '. __('Tag', 'wpex' ),
			'edit_item' => __( 'Edit','wpex') .' '. $post_type_name .' '. __('Tag', 'wpex' ),
			'update_item' => __( 'Update','wpex') .' '. $post_type_name .' '. __('Tag', 'wpex' ),
			'add_new_item' =>__( 'Add New','wpex') .' '. $post_type_name .' '. __('Tag', 'wpex' ),
			'new_item_name' => __( 'New','wpex') .' '. $post_type_name .' '. __('Tag name', 'wpex' ),
			'separate_items_with_commas'	=> __( 'Seperate','wpex') .' '. $post_type_name .' '. __('tags with commas', 'wpex' ),
			'add_or_remove_items' => __( 'Add or remove','wpex') .' '. $post_type_name .' '. __('tags', 'wpex' ),
			'choose_from_most_used' => __( 'Choose from the most used','wpex') .' '. $post_type_name .' '. __('tags', 'wpex' ),
			'menu_name' => $post_type_name .' '. __('Tags', 'wpex' ),
		);

		$custom_taxonomy_portfolio_tag_args = array(
			'labels'	=> $taxonomy_portfolio_tag_labels,
			'rewrite'	=> array( 'slug'	=> $tax_slug )
		);
		
		return $custom_taxonomy_portfolio_tag_args + $args;
			
	}
	add_filter( 'wpex_taxonomy_portfolio_tag_args', 'wpex_custom_portfolio_tag_args' );
}

/**
* Staff Cats
* @since 1.0
*/

// Cats
if ( ! function_exists( 'wpex_custom_staff_category_args' ) ) {
	function wpex_custom_staff_category_args( $args ) {
		
		//post name based on theme options
		$post_type_name = ( wpex_option('staff_labels','Staff') ) ? wpex_option('staff_labels','Staff') : 'Staff';
		$tax_slug = ( wpex_option('staff_cat_slug','staff-category') ) ? wpex_option('staff_cat_slug','staff-category') : 'staff-category';
		
		$taxonomy_staff_category_labels = array(
			'name'							=> $post_type_name . ' '. __( 'Categories', 'wpex' ),
			'singular_name'					=> $post_type_name . ' '. __( 'Category', 'wpex' ),
			'search_items'					=> __( 'Search','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'popular_items'					=> __( 'Popular','wpex') .' '. $post_type_name .' '. __('Categories', 'wpex' ),
			'all_items'						=> __( 'All','wpex') .' '. $post_type_name .' '. __('Categories', 'wpex' ),
			'parent_item'					=> __( 'Parent','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'parent_item_colon'				=> __( 'Parent','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'edit_item'						=> __( 'Edit','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'update_item'					=> __( 'Update','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'add_new_item'					=>__( 'Add New','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'new_item_name'					=> __( 'New','wpex') .' '. $post_type_name .' '. __('Category name', 'wpex' ),
			'separate_items_with_commas'	=> __( 'Seperate','wpex') .' '. $post_type_name .' '. __('categories with commas', 'wpex' ),
			'add_or_remove_items'			=> __( 'Add or remove','wpex') .' '. $post_type_name .' '. __('categories', 'wpex' ),
			'choose_from_most_used'			=> __( 'Choose from the most used','wpex') .' '. $post_type_name .' '. __('categories', 'wpex' ),
			'menu_name'						=> $post_type_name .' '. __('Categories', 'wpex' ),
		);

		$custom_taxonomy_staff_category_args = array(
			'labels'	=> $taxonomy_staff_category_labels,
			'rewrite'	=> array( 'slug'	=> $tax_slug )
		);
		
		return $custom_taxonomy_staff_category_args + $args;
			
	}
	add_filter( 'wpex_taxonomy_staff_category_args', 'wpex_custom_staff_category_args' );
}

/**
* Testimonials Cats
*/

// Cats
if ( ! function_exists( 'wpex_custom_testimonials_category_args' ) ) {

	function wpex_custom_testimonials_category_args( $args ) {
		
		//post name based on theme options
		$post_type_name = ( wpex_option('testimonials_labels','Testimonials') ) ? wpex_option('testimonials_labels','Testimonials') : 'Testimonials';
		$tax_slug = ( wpex_option('testimonials_cat_slug','testimonials-category') ) ? wpex_option('testimonials_cat_slug','testimonials-category') : 'testimonials-category';
		
		$taxonomy_testimonials_category_labels = array(
			'name'							=> $post_type_name . ' '. __( 'Categories', 'wpex' ),
			'singular_name'					=> $post_type_name . ' '. __( 'Category', 'wpex' ),
			'search_items'					=> __( 'Search','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'popular_items'					=> __( 'Popular','wpex') .' '. $post_type_name .' '. __('Categories', 'wpex' ),
			'all_items'						=> __( 'All','wpex') .' '. $post_type_name .' '. __('Categories', 'wpex' ),
			'parent_item'					=> __( 'Parent','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'parent_item_colon'				=> __( 'Parent','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'edit_item'						=> __( 'Edit','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'update_item'					=> __( 'Update','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'add_new_item'					=>__( 'Add New','wpex') .' '. $post_type_name .' '. __('Category', 'wpex' ),
			'new_item_name'					=> __( 'New','wpex') .' '. $post_type_name .' '. __('Category name', 'wpex' ),
			'separate_items_with_commas'	=> __( 'Seperate','wpex') .' '. $post_type_name .' '. __('categories with commas', 'wpex' ),
			'add_or_remove_items'			=> __( 'Add or remove','wpex') .' '. $post_type_name .' '. __('categories', 'wpex' ),
			'choose_from_most_used'			=> __( 'Choose from the most used','wpex') .' '. $post_type_name .' '. __('categories', 'wpex' ),
			'menu_name'						=> $post_type_name .' '. __('Categories', 'wpex' ),
		);

		$custom_taxonomy_testimonials_category_args = array(
			'labels'	=> $taxonomy_testimonials_category_labels,
			'rewrite'	=> array( 'slug' => $tax_slug )
		);
		
		return $custom_taxonomy_testimonials_category_args + $args;
			
	}
	add_filter( 'wpex_taxonomy_testimonials_category_args', 'wpex_custom_testimonials_category_args' );
}
?>
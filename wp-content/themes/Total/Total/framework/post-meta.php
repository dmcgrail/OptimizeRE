<?php
/**
 * Outputs the post meta for blog posts & entries
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/


if ( ! function_exists( 'wpex_post_meta' ) ) {
	function wpex_post_meta() {
		
		// Get post data
		global $post;
		$post_id = $post->ID;
		$post_type = get_post_type($post);

		// Check what options are enabled
		$meta_sections = wpex_option( 'posts_meta_options', array( 'date' => '1', 'category' => '1', 'comments' => '1' ) );
		$meta_sections = apply_filters( 'wpex_posts_meta_options', $meta_sections );

		// Get category for posts only
		if ( $post_type == 'post' ) {
			$category = get_the_category();
			$fist_category = $category[0];
			if ( isset($fist_category) ) {
				$category_name = $fist_category->cat_name;
				$category_url = get_category_link( $fist_category->term_id );
			}
		}

		// Get EDD Category - woot!
		if ( $post_type == 'download' && taxonomy_exists('download_category') ) {
			$category = get_the_terms( get_the_ID(), 'download_category', array('number' => '1') );
			if ( isset($category)) {
				$fist_category = reset($category);
				$category_name = $fist_category->name;
				$category_id = $fist_category->term_id;
				$category_url = get_term_link( $category_id, 'download_category' );
			}
		}

		// Add class for meta with title
		$classes = 'meta clr';
		if ( is_singular( 'post' ) && 'custom_text' == wpex_option( 'blog_single_header', 'custom_text' ) ) {
			$classes .= ' meta-with-title';
		} ?>
		
		<ul class="<?php echo $classes; ?>">
			<?php
			// Date
			if( isset( $meta_sections['date'] ) && $meta_sections['date'] ) { ?>
				<li class="meta-date"><span class="fa fa-clock-o"></span><?php echo get_the_date(); ?></li>
			<?php }
			// Author
			if( isset( $meta_sections['author'] ) && $meta_sections['author'] ) { ?>
				<li class="meta-author"><span class="fa fa-user"></span><?php the_author_posts_link(); ?></li>
			<?php }
			// Category
			if( isset( $fist_category )
				&& isset( $meta_sections['category'] )
				&& $meta_sections['category'] ) { ?>
				<li class="meta-category"><span class="fa fa-folder-o"></span><a href="<?php echo $category_url; ?>" title="<?php echo $category_name; ?>"><?php echo $category_name; ?></a></li>
			<?php }
			// Comments
			if( comments_open()
				&& isset( $meta_sections['comments'] )
				&& $meta_sections['comments']
				&& ! post_password_required() ) { ?>
				<li class="meta-comments comment-scroll"><span class="fa fa-comment-o"></span><?php comments_popup_link( __( '0 Comments', 'wpex' ), __( '1 Comment',  'wpex' ), __( '% Comments', 'wpex' ), 'comments-link' ); ?></li>
			<?php }
			// Next/Prev
			if ( is_singular('post')
				&& wpex_option( 'post_next_prev_meta', '1' )
				&& 'post_title' == wpex_option( 'blog_single_header', 'custom_text' ) ) { ?>
				<li id="single-post-next-prev" class="clr">
					<?php next_post_link( '%link','<span class="theme-button"><span class="fa fa-chevron-left"></span></span>', '%title', true ); ?>
					<?php previous_post_link( '%link','<span class="theme-button"><span class="fa fa-chevron-right"></span></span>', '%title', true ); ?>
				</li><!-- #single-post-next-prev -->
			<?php } ?>
		</ul>
		
		<?php
		
	}
}

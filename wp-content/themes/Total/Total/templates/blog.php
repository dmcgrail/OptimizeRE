<?php
/**
 * Template Name: Blog
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
*/

// Get site header
get_header(); ?>

	<div id="content-wrap" class="container clr <?php echo wpex_get_post_layout_class(); ?>">
		<section id="primary" class="content-area clr">
			<div id="content" class="site-content clr" role="main">
				<?php
				// Display blog post content
				while ( have_posts() ) : the_post(); ?>
					<div class="entry-content entry clr">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				<?php endwhile; ?>
				<?php
				global $post, $paged, $more;
				$more = 0;
				if ( get_query_var('paged') ) {
					$paged = get_query_var('paged');
				} else if ( get_query_var('page') ) {
					$paged = get_query_var('page');
				} else {
					$paged = 1;
				}
				// Exclude categories based on theme options
				$wpex_cats_to_exclude = wpex_option( 'blog_cats_exclude' );
				// Query posts
				$wp_query = new WP_Query(
					array(
						'post_type'			=> 'post',
						'paged'				=> $paged,
						'category__not_in'	=> $wpex_cats_to_exclude,
					)
				);
				if( $wp_query->posts ) : ?>
					<div id="blog-entries" class="clr <?php wpex_blog_wrap_classes(); ?>">
						<?php
						// Loop through blog posts
						foreach( $wp_query->posts as $post ) : setup_postdata( $post );
							// Get entry design
							get_template_part('content', get_post_format() );
						endforeach; ?>
					</div><!-- #blog-entries -->
					<?php
					// Display pagination - see function/pagination.php
					wpex_blog_pagination();
				// End if $wp_query->posts
				endif;
				// Reset the custom query data
				wp_reset_postdata(); wp_reset_query(); ?>
			</div><!-- #content -->
		</section><!-- #primary -->
		<?php
		// Get site sidebar
		get_sidebar(); ?>
	</div><!-- #content-wrap -->

<?php
// Get site footer
get_footer(); ?>
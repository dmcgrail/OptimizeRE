<?php
/**
 * The template for displaying Testimonials Tags
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */


// Get site header
get_header(); ?>

	<div id="content-wrap" class="container clr <?php echo wpex_get_post_layout_class(); ?>">
		<?php if ( have_posts( ) ) : ?>
			<section id="primary" class="content-area clr">
				<div id="content" class="site-content clr" role="main">
					<div id="testimonials-entries" class="wpex-row clr">
						<?php
						$wpex_count=0;
						// Loop through the posts
						while ( have_posts() ) : the_post();
							$wpex_count++;
							// Get the correct template file for this post type
							wpex_get_template_part();
							if( $wpex_count == wpex_option( 'testimonials_entry_columns','3' ) ) {
								echo '<div class="clr"></div>';
								$wpex_count=0;
							}
						endwhile; ?>
					</div><!-- #testimonials-entries -->
					<?php
					// Display per-page pagination
					wpex_pagination(); ?>
				</div><!-- #content -->
			</section><!-- #primary -->
		<?php endif; ?>
		<?php
		// Get sidebar if needed
		get_sidebar(); ?>
	</div><!-- #content-wrap -->

<?php
// Get Site footer
get_footer(); ?>
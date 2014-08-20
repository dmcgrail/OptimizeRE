<?php
/**
 * The template for displaying Portfolio Categories
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
					<div id="portfolio-entries" class="wpex-row clr portfolio-<?php echo wpex_option( 'portfolio_archive_grid_style', 'fit-rows' ); ?>">
						<?php
						$wpex_count=0;
						// Loop through the posts
						while ( have_posts() ) : the_post();
							$wpex_count++;
							// Get the correct template file for this post type
							wpex_get_template_part();
							// Clear counter/floats
							if( $wpex_count == wpex_option( 'portfolio_entry_columns','4' ) ) {
								echo '<div class="clr"></div>';
								$wpex_count=0;
							}
						endwhile; ?>
					</div><!-- #portfolio-entries -->
					<div class="clr"></div>
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
// Get site footer
get_footer(); ?>
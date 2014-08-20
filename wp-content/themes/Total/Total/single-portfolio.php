<?php
/**
 * The template used for single portfolio posts.
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @since Total 1.0
 * @link  http://www.wpexplorer.com
 */

// Get site header
get_header(); ?>

	<?php
	// Start the standard WP loop
	while ( have_posts() ) : the_post(); ?>
		<div id="content-wrap" class="container clr <?php echo wpex_get_post_layout_class(); ?>">
			<section id="primary" class="content-area">
				<div id="content" class="site-content clr" role="main">
					<?php
					// Display portfolio single media if enabled in the admin
					// Disabled by default
					wpex_portfolio_single_media(); ?>
					<article class="entry clr">
						<?php the_content(); ?>
					</article><!-- .entry clr -->
					<?php
					// Social Sharing links
					wpex_social_share(); ?>
					<?php
					// Get comments & comment form if enabled for portfoliop posts
					if ( wpex_option( 'portfolio_comments' ) == '1' ) { ?>
					<section id="portfolio-post-comments" class="clr">
						<?php comments_template(); ?>
					</section><!-- #portfolio-post-comments -->
					<?php } ?>
					<?php
					// Related Portfolio Items
					// See /functions/portfolio/portfolio-related.php
					wpex_portfolio_related(); ?>
				</div><!-- #content -->
			</section><!-- #primary -->
			<?php
			// Get main sidebar
			get_sidebar(); ?>
			<?php
			// Display next/prev links if enabled
			if ( wpex_option( 'portfolio_next_prev', '1' ) == '1' ) {
				wpex_next_prev();
			} ?>
		</div><!-- .container -->
	<?php endwhile; ?>

<?php
// Get site footer
get_footer();?>
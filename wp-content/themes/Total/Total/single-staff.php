<?php
/**
 * The template used for single staff posts.
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
		<section id="primary" class="content-area clr">
			<div id="content" class="clr site-content" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>">
						<div class="entry-content entry clr">
							<?php the_content(); ?>
						</div><!-- .entry-content -->
					</article><!-- #post -->
					<?php
					// Social Sharing links
					wpex_social_share(); ?>
					<?php
					// Get comments & comment form if enabled for portfoliop posts
					if ( wpex_option( 'staff_comments' ) && comments_open() ) { ?>
					<section id="staff-post-comments" class="clr">
						<?php comments_template(); ?>
					</section><!-- #staff-post-comments -->
					<?php } ?>
				<?php endwhile; ?>
			</div><!-- #content -->
		</section><!-- #primary -->
		<?php
		// Get site sidebar
		get_sidebar(); ?>
		<!-- clear floats -->
		<div class="clr"></div>
		<?php
		// Related Portfolio Items
		// See /functions/staff/staff-related.php
		wpex_staff_related(); ?>
		<?php
		// Get main sidebar
		get_sidebar(); ?>
		<?php
		// Display next and previous post links if enabled
		// See functions/next-prev.php
		if ( wpex_option( 'staff_next_prev', '1' ) == '1' ) {
			wpex_next_prev();
		} ?>
	</div><!-- .container -->

<?php
// Get site footer
get_footer(); ?>
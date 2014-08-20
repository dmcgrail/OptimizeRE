<?php
/**
 * The template used for single testimonial posts.
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @since Total 1.0
 * @link  http://www.wpexplorer.com
 */

// Get site header
get_header(); ?>

	<div id="content-wrap" class="container clr <?php echo wpex_get_post_layout_class(); ?>">
		<section id="primary" class="content-area clr">
			<div id="content" class="clr site-content" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="clr">
						<div class="entry-content entry clr">
							<?php if ( 'blockquote' == wpex_option( 'testimonial_post_style', 'blockquote' ) ) { ?>
								<blockquote><?php the_content(); ?></blockquote>
							<?php } else { ?>
								<?php the_content(); ?>
							<?php } ?>
						</div><!-- .entry-content -->
					</article><!-- #post -->
				<?php endwhile; ?>
				<?php
				// Get comments & comment form if enabled for portfoliop posts
				if ( wpex_option( 'testimonials_comments' ) && comments_open() ) { ?>
					<section id="testimonials-post-comments" class="clr">
						<?php comments_template(); ?>
					</section><!-- #testimonials-post-comments -->
				<?php } ?>
			</div><!-- #content -->
		</section><!-- #primary -->
		<?php
		// Get main sidebar
		get_sidebar(); ?>
	</div><!-- .container -->

<?php
// Get site footer
get_footer(); ?>
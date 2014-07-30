<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */


// Get site header
get_header(); ?>

	<div class="container clr">
		<section id="primary" class="content-area clr">
			<div id="content" class="site-content" role="main">
			<?php if ( have_posts() ) : ?>
				<div id="search-entries" class="clr">
					<?php
					// Loop through posts
					while ( have_posts() ) : the_post();
					wpex_get_template_part();
				endwhile; ?>
				</div><!-- #search-entries -->
				<?php
				// Display pagination - see function/pagination.php
				wpex_pagination(); ?>
			<?php else : ?>
				<div id="search-no-results" class="clr">
				<?php
				// Display message if there aren't any posts
				_e( 'Sorry, no results were found for this query.', 'wpex' ); ?>
				</div><!-- #search-no-results -->
			<?php endif; ?>
			</div><!-- #content -->
		</section><!-- #primary -->
		<?php
		// Get site sidebar
		get_sidebar(); ?>
	</div><!-- .container -->

<?php
// Get site footer
get_footer(); ?>
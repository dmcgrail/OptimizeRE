<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */


// Get header
get_header(); ?>

	<div id="content-wrap" class="container clr <?php echo wpex_get_post_layout_class(); ?>">
		<section id="primary" class="content-area clr">
			<div id="content" class="site-content" role="main">
				<?php if ( have_posts() ) : ?>
				<div id="blog-entries" class="clr <?php wpex_blog_wrap_classes(); ?>">
					<?php
					// Loop through posts
					$wpex_count=0;
					while ( have_posts() ) : the_post();
						get_template_part('content', get_post_format() );
					endwhile; ?>
				</div><!-- #blog-entries -->
				<?php
				// Display pagination
				// See function/pagination.php
				wpex_blog_pagination(); ?>
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
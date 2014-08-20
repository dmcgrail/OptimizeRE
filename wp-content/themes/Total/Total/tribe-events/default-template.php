<?php
/**
 * Default Page Template for "The Events Calendar Plugin"
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.38
 */

// Get site header
get_header(); ?>

	<div id="content-wrap" class="container clr <?php echo wpex_get_post_layout_class(); ?>">
		<section id="primary" class="content-area clr">
			<div id="content" class="clr site-content" role="main">
				<article class="clr">
					<div id="tribe-events-pg-template">
						<?php tribe_events_before_html(); ?>
						<?php tribe_get_view(); ?>
						<?php tribe_events_after_html(); ?>
					</div> <!-- #tribe-events-pg-template -->
				</article><!-- #post -->
			</div><!-- #content -->
		</section><!-- #primary -->
		<?php
		// Get sidebar if needed
		get_sidebar(); ?>
	</div><!-- #content-wrap -->

<?php
// Get site footer
get_footer(); ?>
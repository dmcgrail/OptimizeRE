<?php
/**
 * Used for your standard post entry content and single post media
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/******************************************************
 * Single Posts
*****************************************************/
if ( is_singular() ) {
	
	// Display featured image if enabled and defined
	if( '1' == wpex_option( 'blog_single_thumbnail', '1' ) && has_post_thumbnail() ) {
		// Get cropped featured image
		$wpex_image = wpex_image( 'array' ); ?>
		<div id="post-media" class="clr">
			<img src="<?php echo $wpex_image['url']; ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" width="<?php echo $wpex_image['width']; ?>" height="<?php echo $wpex_image['height']; ?>" />
					<?php
			// Blog entry caption
			if ( wpex_option( 'blog_thumbnail_caption' ) && wpex_featured_image_caption() ) { ?>
				<div class="post-media-caption clr">
					<?php echo wpex_featured_image_caption(); ?>
				</div>
			<?php } ?>
		</div><!-- #post-media -->
	<?php }

}
/******************************************************
 * Entries
 * See framework/blog/blog-entry.php for functions
*****************************************************/
else { ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
		// Display entry media
		wpex_blog_entry_media(); ?>
		<div class="blog-entry-content clr">
			<header class="clr <?php if ( wpex_post_entry_author_avatar_enabled() ) { echo 'header-with-avatar'; } ?>">
				<?php
				// Display entry title
				wpex_blog_entry_title();
				// Displays the post entry author avatar
				wpex_post_entry_author_avatar();
				// Display post meta - see functions/post-meta.php
				wpex_post_meta(); ?>
			</header>
			<?php
			// Entry Excerpt/Content
			wpex_blog_entry_content();
			// Read more link
			wpex_post_readmore_link();
			// Social sharing links
			wpex_social_share(); ?>
		</div><!-- .blog-entry-content -->
	</article><!-- .blog-entry-entry -->
<?php } ?>
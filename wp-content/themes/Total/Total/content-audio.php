<?php
/**
 * Used for your audio post entry content and single post media
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
 * @since 1.0
*****************************************************/

if ( is_singular() ) { ?>
	
	<div id="post-media" class="clr">
		<?php
		// Audio embed
		if ( get_post_meta( get_the_ID(), 'wpex_post_oembed', true ) !== '' ) { ?>
			<div class="blog-post-audio clr wpex-fitvids"><?php echo wp_oembed_get( wpex_post_audio_url() ); ?></div>
		<?php }
		// Self hosted audio
		elseif ( wpex_post_audio_url() ) { ?>
			<div class="blog-post-audio clr"><?php echo apply_filters( 'the_content', wpex_post_audio_url() ); ?></div>
		<?php }
		// Featured Image
		elseif( wpex_option( 'blog_single_thumbnail', '1' ) && has_post_thumbnail() ) {
			$wpex_image = wpex_image( 'array' ); ?>
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" class="blog-entry-img-link">
				<img src="<?php echo $wpex_image['url']; ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" width="<?php echo $wpex_image['width']; ?>" height="<?php echo $wpex_image['height']; ?>" />
			</a>
		<?php } ?>
	</div><!-- #post-media -->

<?php
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
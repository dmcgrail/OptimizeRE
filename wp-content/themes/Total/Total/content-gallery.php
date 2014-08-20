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
 * @since 1.0
*****************************************************/

if ( is_singular() ) {

	// Get post image attachments
	$attachments = wpex_get_gallery_ids();

	// Display slider if there are images saved in the DB
	if ( !empty($attachments) ) { ?>
		<div id="post-media" class="clr">
			<div class="gallery-format-post-slider-wrap clr">
				<div class="gallery-format-post-slider flexslider-container">
					<div class="flexslider">
						<ul class="slides">
						 <?php
							// Loop through each attachment ID
							foreach ( $attachments as $attachment ) :
								// Get image alt tag
								$attachment_alt = strip_tags( get_post_meta( $attachment, '_wp_attachment_image_alt', true ) ); ?>
								<li class="slide" data-thumb="<?php echo wpex_image_resize( wp_get_attachment_url( $attachment ), 100, 100, true ); ?>">
									<?php
									// Display image with lightbox
									if ( wpex_gallery_is_lightbox_enabled() == 'on' ) { ?>
										<a href="<?php echo wp_get_attachment_url( $attachment ); ?>" title="<?php echo get_post_field('post_excerpt', $attachment ); ?>" class="wpex-lightbox"><img src="<?php echo wpex_image( 'url', $attachment ); ?>" alt="<?php echo $attachment_alt; ?>" /></a>
									<?php } else {
										// Lightbox is disabled, only show image ?>
										<img src="<?php echo wpex_image( 'url', $attachment ); ?>" alt="<?php echo $attachment_alt; ?>" />
									<?php } ?>
								</li>
							<?php endforeach; ?>
						</ul><!-- .slides -->
					</div><!-- .flexslider -->
				</div><!-- .flexslider-container -->
			</div><!-- .gallery-format-post-slider-wrap -->
		</div><!-- #post-media -->
	<?php } ?>

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
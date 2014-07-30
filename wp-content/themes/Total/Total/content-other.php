<?php
/**
 * Used for your "other" post type entries
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
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	// Display the post thumbnail if one is set and the post is not password protected
	if ( has_post_thumbnail() && ! post_password_required() ) {
		// Get cropped featured image
		$wpex_image = wpex_image( 'array' ); ?>
		<div class="custom-posttype-entry-media">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" class="custom-posttype-entry-media-link <?php wpex_img_animation_classes(); ?>">
				<img src="<?php echo $wpex_image['url']; ?>" alt="<?php echo the_title(); ?>" width="<?php echo $wpex_image['width']; ?>" height="<?php echo $wpex_image['height']; ?>" />
			</a>
		</div><!-- .custom-posttype-entry-media -->
	<?php } ?>
	<div class="custom-posttype-entry-content clr">
		<header class="clr <?php if ( wpex_post_entry_author_avatar_enabled() ) { echo 'header-with-avatar'; } ?>">
			<h2 class="custom-posttype-entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
			<?php
			// Display post meta - see functions/post-meta.php
			wpex_post_meta(); ?>
		</header>
		<div class="custom-posttype-entry-excerpt entry">
			<?php wpex_excerpt( '60' ); ?>
		</div><!-- .custom-posttype-entry-excerpt -->
		<?php
		// Read more link - see functions/post-readmore-link.php
		wpex_post_readmore_link();
		// Social sharing links
		wpex_social_share(); ?>
	</div><!-- .custom-posttype-entry-content -->
</article><!-- .custom-posttype-entry-entry -->
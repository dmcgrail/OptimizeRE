<?php
/**
 * The template for displaying Author bios.
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */
?>

<section class="author-bio">
	<div class="author-bio-avatar">
		<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php _e( 'Visit Author Page', 'wpex' ); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'wpex_author_bio_avatar_size', 74 ) ); ?></a>
	</div><!-- .author-bio-avatar -->
	<div class="author-bio-content">
		<div class="author-bio-title"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php _e( 'Visit Author Page', 'wpex' ); ?>"><?php echo get_the_author(); ?></a></div>
		<div class="author-bio-description"><?php the_author_meta( 'description' ); ?></div>
		<?php if ( wpex_author_has_social() ) { ?>
			<div class="author-bio-social clr">
				<?php
				// Display twitter url
				if ( '' != get_the_author_meta( 'wpex_twitter', $post->post_author ) ) { ?>
					<a href="<?php echo get_the_author_meta( 'wpex_twitter', $post->post_author ); ?>" title="Twitter" class="twitter tooltip-up"><span class="fa fa-twitter"></span></a>
				<?php }
				// Display facebook url
				if ( '' != get_the_author_meta( 'wpex_facebook', $post->post_author ) ) { ?>
					<a href="<?php echo get_the_author_meta( 'wpex_facebook', $post->post_author ); ?>" title="Facebook" class="facebook tooltip-up"><span class="fa fa-facebook"></span></a>
				<?php }
				// Display google plus url
				if ( '' != get_the_author_meta( 'wpex_googleplus', $post->post_author ) ) { ?>
					<a href="<?php echo get_the_author_meta( 'wpex_googleplus', $post->post_author ); ?>" title="Google Plus" class="google-plus tooltip-up"><span class="fa fa-google-plus"></span></a>
				<?php }
				// Display Linkedin url
				if ( '' != get_the_author_meta( 'wpex_linkedin', $post->post_author ) ) { ?>
					<a href="<?php echo get_the_author_meta( 'wpex_linkedin', $post->post_author ); ?>" title="LinkedIn" class="linkedin tooltip-up"><span class="fa fa-linkedin"></span></a>
				<?php }
				// Display pinterest plus url
				if ( '' != get_the_author_meta( 'wpex_pinterest', $post->post_author ) ) { ?>
					<a href="<?php echo get_the_author_meta( 'wpex_pinterest', $post->post_author ); ?>" title="Pinterest" class="pinterest tooltip-up"><span class="fa fa-pinterest"></span></a>
				<?php }
				// Display instagram plus url
				if ( '' != get_the_author_meta( 'wpex_instagram', $post->post_author ) ) { ?>
					<a href="<?php echo get_the_author_meta( 'wpex_instagram', $post->post_author ); ?>" title="Instagram" class="instagram tooltip-up"><span class="fa fa-instagram"></span></a>
				<?php } ?>
			</div><!-- .author-bio-social -->
		<?php } ?>
	</div><!-- .author-bio-content -->
</section><!-- .author-bio -->
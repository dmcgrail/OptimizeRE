<?php
/**
 * Core functions for blog entry output
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/



/**
 * Check if author avatar is enabled or not for blog entries
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 * @return bool
*/
if ( ! function_exists( 'wpex_post_entry_author_avatar_enabled' ) ) {
	function wpex_post_entry_author_avatar_enabled() {
		
		// Theme settings
		$author_avatar_toggle = wpex_option( 'blog_entry_author_avatar' );
		$blog_style = wpex_option ( 'blog_style' );
		
		if ( $author_avatar_toggle !== '1' ) {
			return false;
		}
		if ( !is_category() && $blog_style !== 'large-image-entry-style' ) {
			return false;
		}
		
		// Category settings
		if ( is_category() ) {
			$term = get_query_var('cat');
			$term_data = get_option("category_$term");
			if ( isset($term_data['wpex_term_style']) ) {
				if ( $term_data['wpex_term_style'] !== '' ) {
					$blog_style = $term_data['wpex_term_style'];
				}
			}
			if ( $blog_style !== 'large-image-entry-style' ) {
				return false;
			}
		} // End if category check
		
		return true;
	}
}

/**
 * Display author avatar for entries
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( ! function_exists( 'wpex_post_entry_author_avatar' ) ) {
	function wpex_post_entry_author_avatar() {
		if ( !wpex_post_entry_author_avatar_enabled() ) {
			return;
		} ?>
		<div class="blog-entry-author-avatar">
			<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php echo __( 'Visit Author Page', 'wpex' ); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'wpex_author_bio_avatar_size', 74 ) ) ?></a>
		</div>
	<?php }
}

/**
 * Displays the blog entry image
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'wpex_blog_entry_image' ) ) {
	function wpex_blog_entry_image() {
		if ( has_post_thumbnail() && ! post_password_required() ) {
			$image = wpex_image( 'array' ); ?>
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" class="blog-entry-media-link <?php wpex_img_animation_classes(); ?>"><img src="<?php echo $image['url']; ?>" alt="<?php echo the_title(); ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" /></a>
	<?php }
	}
}

/**
 * Displays the blog entry gallery
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'wpex_blog_entry_gallery' ) ) {
	function wpex_blog_entry_gallery() {
		// Get attachments
		$attachments = wpex_get_gallery_ids();
		// Show featured image for password-protected post
		if ( post_password_required() ) {
			return wpex_blog_entry_image();
		// If there aren't attachments return nothing
		} elseif( empty( $attachments ) ) {
			return;
		} ?>
		<div class="gallery-format-post-slider-wrap clr">
			<div class="gallery-format-post-slider flexslider-container">
					<div class="flexslider">
						<ul class="slides <?php if ( wpex_gallery_is_lightbox_enabled() == 'on' ) echo 'wpex-gallery-lightbox'; ?>">
							<?php
							// Loop through each attachment ID
							foreach ( $attachments as $attachment ) :
								// Get image alt tag
								$attachment_alt = strip_tags( get_post_meta( $attachment, '_wp_attachment_image_alt', true ) ); ?>
								<li class="slide" data-thumb="<?php echo wpex_image_resize( wp_get_attachment_url( $attachment ), '100', '100', true ); ?>">
									<?php
									// Display image with lightbox
									if ( wpex_gallery_is_lightbox_enabled() == 'on' ) { ?>
										<a href="<?php echo wp_get_attachment_url( $attachment ); ?>" title="<?php echo $attachment_alt; ?>" data-title="<?php echo $attachment_alt; ?>">
											<img src="<?php echo wpex_image( 'url', $attachment ); ?>" alt="<?php echo $attachment_alt; ?>" />
										</a>
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
	<?php
	}
}

/**
 * Displays the blog entry video
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'wpex_blog_entry_video' ) ) {
	function wpex_blog_entry_video() {
		// Show featured image for password-protected post
		if ( post_password_required() ) {
			return wpex_blog_entry_image();
		}
		// Display oembeded video
		if ( '' != get_post_meta( get_the_ID(), 'wpex_post_oembed', true ) ) { ?>
			<div class="blog-entry-video responsive-video-wrap"><?php echo wp_oembed_get( wpex_post_video_url() ); ?></div>
		<?php }
		elseif ( wpex_post_video_url() ) { ?>
			<div class="blog-entry-video"><?php echo apply_filters( 'the_content', wpex_post_video_url() ); ?></div>
		<?php }
		// Display post thumbnail
		else{
			return wpex_blog_entry_image();
		}
	}
}

/**
 * Displays the blog entry audio
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'wpex_blog_entry_audio' ) ) {
	function wpex_blog_entry_audio() {
		if ( has_post_thumbnail() ) {
			$image = wpex_image( 'array' ); ?>
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" class="blog-entry-img-link">
				<img src="<?php echo $image['url']; ?>" alt="<?php echo the_title(); ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />
				<div class="blog-entry-music-icon-overlay"><span class="fa fa-music"></span></div>
			</a>
	<?php }
	}
}

/**
 * Displays the blog entry media
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'wpex_blog_entry_media' ) ) {
	function wpex_blog_entry_media() { ?>
		<div class="blog-entry-media clr">
			<?php
			// Get post format
			$format = get_post_format();
			// Display Audio
			if ( 'audio' == $format ) {
				wpex_blog_entry_audio();
			}
			// Display Gallery
			elseif ( 'gallery' == $format ) {
				wpex_blog_entry_gallery();
			}
			// Display Video
			elseif( 'video' == $format ) {
				wpex_blog_entry_video();
			}
			// Display Featured Image
			else {
				wpex_blog_entry_image();
			} ?>
		</div><!-- .blog-entry-media -->
	<?php }
}

/**
 * Displays the blog entry title
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'wpex_blog_entry_title' ) ) {
	function wpex_blog_entry_title() { ?>
		<h2 class="blog-entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<?php }
}

/**
 * Displays the blog entry content
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'wpex_blog_entry_content' ) ) {
	function wpex_blog_entry_content() { ?>
		<div class="blog-entry-excerpt entry">
			<?php
			// Display excerpt if auto excerpts are enavled in the admin
			if ( '1' == wpex_option( 'blog_exceprt', '1' ) ) {
				// Get excerpt length & output excerpt
				// See functions/excerpts.php
				$wpex_excerpt_length = wpex_excerpt_length();
				wpex_excerpt( $wpex_excerpt_length );
			} else {
			// Display full content
				the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wpex' ) );
			} ?>
		</div><!-- .blog-entry-excerpt -->
	<?php }
}
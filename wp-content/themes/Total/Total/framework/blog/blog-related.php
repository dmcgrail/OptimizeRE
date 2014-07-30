<?php
/**
 * Used to display related portfolio items
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.1
*/


if ( ! function_exists( 'wpex_blog_related' ) ) {
	function wpex_blog_related() {
		
		// Return if disabled
		if ( !wpex_option( 'blog_related', '1' ) ) {
			return;
		}
		
		// Return if full-screen post
		if ( 'full-screen' == wpex_get_post_layout_class() ) {
			return;
		}
		
		// Return if pass required
		if ( post_password_required() ) {
			return;
		}
		
		// Get Post Data
		global $post;
		$post_id = $post->ID;

		// Return if not standard post type
		if ( 'post' != get_post_type( $post) ) {
			return;
		}

		// Theme Settings
		$disable_related_items = get_post_meta( $post_id, 'wpex_disable_related_items', true );
		$posts_per_page = wpex_option( 'blog_related_count', '3' );
	
		// Create an array of current category ID's
		$cats = wp_get_post_terms( $post_id, 'category' );
		$cats_ids = array();
		foreach( $cats as $wpex_related_cat ) {
			$cats_ids[] = $wpex_related_cat->term_id;
		}

		// Related exclude formats
		$exclude_formats = array( 'post-format-quote', 'post-format-link' );
		$exclude_formats = apply_filters( 'wpex_related_blog_posts_exclude_formats', $exclude_formats );
		
		// Related query arguments
		$wpex_related_query = new wp_query( array(
			'posts_per_page'		=> $posts_per_page,
			'orderby' 				=> 'rand',
			'category__in'			=> $cats_ids,
			'post__not_in'			=> array($post_id),
			'no_found_rows'			=> true,
			'tax_query'				=> array (
				'relation'	=> 'AND',
				array (
					'taxonomy'	=> 'post_format',
					'field'		=> 'slug',
					'terms'		=> $exclude_formats,
					'operator'	=> 'NOT IN',
				),
			),
		) );
		// If the custom query returns post display related posts section
		if( $wpex_related_query->have_posts() ) { ?>
			 <section class="related-posts clr">
				<div class="related-posts-title theme-heading"><span><?php _e( 'Related Posts', 'wpex' ); ?></span></div>
				<?php
				// Set counter var for clearing floats
				$count=0;
				// Loop through related posts
				foreach( $wpex_related_query->posts as $post ) : setup_postdata( $post );
					// Increase counter by 1 for each post
					$count++;
					// Define post ID
					$post_id = $post->ID; ?>
					<article class="clr col span_1_of_3 col-<?php echo $count; ?>">
						<?php
						// Display related post thumbnail
						if ( has_post_thumbnail( $post_id ) ) {
							$image = wpex_image( 'array', '', true ); ?>
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" class="related-post-thumb">
								<img src="<?php echo $image['url']; ?>" alt="<?php echo the_title(); ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />
							</a>
						<?php } else { ?>
							<?php
							// Display post video if video post type
							if ( '' != get_post_meta( $post_id, 'wpex_post_oembed', true ) ) { ?>
								<div class="related-post-video responsive-video-wrap"><?php echo wp_oembed_get( get_post_meta( $post_id, 'wpex_post_oembed', true ) ); ?></div>
							<?php } elseif ( get_post_meta( $post_id, 'wpex_post_self_hosted_shortcode', true ) !== '' ) { ?>
								<div class="related-post-video responsive-video-wrap"><?php echo do_shortcode( get_post_meta( $post_id, 'wpex_post_self_hosted_shortcode', true ) ); ?></div>
							<?php } ?>
						<?php } ?>
						<div class="related-post-content clr">
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" class="related-post-title"><?php the_title(); ?></a>
							<div class="related-post-excerpt clr">
								<?php
								// Display excerpt
								wpex_excerpt( wpex_option( 'blog_related_excerpt_length', '15' ), false, false ); ?>
							</div><!-- related-post-excerpt -->
						</div><!-- .related-post-content -->
					</article>
					<?php
					// Clear counter
					if ( '3' == $count ) {
						$count=0;
					}
					endforeach; ?>
			</section>
		<?php } // End related items
		
		// Reset post data
		wp_reset_postdata();
		
	}
}
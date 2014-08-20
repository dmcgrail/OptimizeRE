<?php
/**
 * Outputs a list of posts that belong to the same "series"
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.4
 */


if ( !function_exists('wpex_post_series') ) {

	function wpex_post_series( $postid=NULL ) {
		
		// Return nothing if the post series taxonomy is disabled
		if ( wpex_option( 'post_series', '1' ) !== '1' ) {
			return;
		}

		// Get the post data
		global $post;

		// Return if not standard post type
		if ( get_post_type( $post) !== 'post' ) {
			return;
		}

		// Return if pass protected
		if ( post_password_required() ) {
			return;
		}
		
		// Get post terms
		$terms = wp_get_post_terms( $postid, 'post_series' );
		
		// If terms
		if ( isset( $terms[0] ) ) {

			// Get all posts in series
			$wpex_query = new wp_query( array(
				'post_type'			=> 'post',
				'posts_per_page'	=> -1,
				'orderby'			=> 'Date',
				'order'				=> 'DESC',
				'no_found_rows'		=> true,
				'tax_query'			=> array( array(
						'taxonomy'	=> 'post_series',
						'field'		=> 'id',
						'terms'		=> $terms[0]->term_id
				) ),
			) );

			// Display series if posts are found
			if( $wpex_query->have_posts() ) { ?>

				<section id="post-series" class="clr">
					<div id="post-series-title"><?php _e( 'Post Series:', 'wpex' ); ?> <?php echo $terms[0]->name; ?></div>
					<ul>
						<?php
						$count=0;
						foreach( $wpex_query->posts as $post ) : setup_postdata( $post );
						$count++;
						$current_post_id = $post->ID;
						if( $current_post_id == $postid ) { ?>
							<li class="post-series-current"><span class="post-series-count"><?php echo $count; ?>.</span><?php the_title(); ?></li>
						<?php } else { ?>
							<li><span class="post-series-count"><?php echo $count; ?>.</span><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li> 
						<?php } endforeach; ?>
					</ul>
				</section>

			<?php }

		wp_reset_postdata();
		
		} else {
			return;
		}
		
	}
}
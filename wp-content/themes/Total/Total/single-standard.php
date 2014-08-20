<?php
/**
 * The Template for displaying standard post type content
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.4
 */
?>

<div id="content-wrap" class="container clr <?php echo wpex_get_post_layout_class(); ?>">

	<?php
	// Above content media
	if ( !post_password_required() && get_post_meta( get_the_ID(), 'wpex_post_media_position', true ) == 'above' ) {
		get_template_part('content', get_post_format() );
	} ?>

	<section id="primary" class="content-area clr">
		<div id="content" class="site-content clr" role="main">
			<article class="single-blog-article clr">

				<?php
				// Quote Posts
				if ( 'quote' == get_post_format() ) {
					get_template_part('content', get_post_format() );
				}
				// Blog Single Post Composer
				else {
					$wpex_blocks = array(
						'enabled'	=> array(
							'featured_media'	=> __( 'Featured Media','wpex' ),
							'title_meta'		=> __( 'Title & Meta','wpex' ),
							'post_series'		=> __( 'Post Series','wpex' ),
							'the_content'		=> __( 'Content','wpex' ),
							'social_share'		=> __( 'Social Share','wpex' ),
							'author_bio'		=> __( 'Author Bio','wpex' ),
							'related_posts'		=> __( 'Related Posts','wpex' ),
							'comments'			=> __( 'Comments','wpex' ),
						),
						'disabled'	=> array(
							'post_tags'	=> __( 'Post Tags','wpex' ),
						),
					);
					$wpex_blocks = wpex_option( 'blog_single_composer', $wpex_blocks );
					$wpex_blocks = $wpex_blocks['enabled'];

					foreach ( $wpex_blocks as $key=>$value ) :

						switch ( $key ) {

							// Post title
							case 'title_meta':

								if ( 'custom_text' == wpex_option( 'blog_single_header', 'custom_text' ) ) { ?>
									<h1 class="single-post-title"><?php the_title(); ?></h1>
								<?php }

								// Display post meta info
								wpex_post_meta();

							break;

							// Featured Media - featured image, video, gallery, etc
							case 'featured_media':

								if ( !post_password_required() && get_post_meta( get_the_ID(), 'wpex_post_media_position', true ) == '' ) {
									get_template_part('content', get_post_format() );
								}

							break;

							// Post Series
							case 'post_series':

								wpex_post_series( get_the_ID() );

							break;

							// Get post content for all formats except quote && link
							case 'the_content':

								if ( get_post_format() !== 'quote' && get_post_format() !== 'link' ) { ?>
									<div class="entry clr">
										<?php the_content(); ?>
									</div>
								<?php }

								// Link pages when using <!--nextpage-->
								wp_link_pages( array(
									'before'		=> '<div class="page-links clr">',
									'after'			=> '</div>',
									'link_before'	=> '<span>',
									'link_after'	=> '</span>'
								) );

							break;

							// Post Tags
							case 'post_tags':
								
								if ( '1' == wpex_option( 'blog_tags','1' ) && ! post_password_required() ) {
									the_tags('<div class="post-tags clr">','','</div>');
								}

							break;

							// Social sharing links
							case 'social_share':

								if ( '1' == wpex_option( 'blog_social_share', '1' ) && ! post_password_required() ) {
									wpex_social_share();
								}

							break;

							// Author bio
							case 'author_bio':

								if ( get_the_author_meta( 'description' ) && 'hide' != get_post_meta( get_the_ID(), 'wpex_post_author', true ) && ! post_password_required() ) {
									get_template_part( 'author-bio' );
								}

							break;

							// Displays related posts
							case 'related_posts':
							
								wpex_blog_related();

							break;

							// Get the post comments & comment_form
							case 'comments':
							
								comments_template();

							break;

						} // End switch

					endforeach;
				} ?>
			</article><!-- .entry -->
		</div><!-- #content -->
	</section><!-- #primary -->
	
	<?php
	// Get site sidebar
	get_sidebar();

	// Display next/prev links if enabled - see functions/commons.php
	if ( wpex_option( 'blog_next_prev', '1' ) ) {
		wpex_next_prev();
	} ?>
</div><!-- .container -->
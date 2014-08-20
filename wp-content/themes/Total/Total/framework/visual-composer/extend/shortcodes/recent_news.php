<?php
/**
 * Registers the recent news shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if( !function_exists( 'vcex_news_shortcode' ) ) {
	function vcex_news_shortcode($atts) {
		
		extract( shortcode_atts( array(
			'unique_id'				=> '',
			'term_slug'				=> 'all',
			'include_categories'	=> '',
			'exclude_categories'	=> '',
			'count'					=> '12',
			'grid_columns'			=> '1',
			'order'					=> 'DESC',
			'orderby'				=> 'date',
			'header'				=> '',
			'heading'				=> 'h3',
			'date'					=> 'true',
			'excerpt_length'		=> '15',
			'read_more'				=> 'false',
			'read_more_text'		=> __( 'read more', 'wpex' ),
			'filter_content'		=> 'false',
			'offset'				=> 0,
			'taxonomy'				=> '',
			'terms'					=>'',
			'css_animation'			=> '',
			'img_width'				=> '9999',
			'img_height'			=> '9999',
			'featured_image'		=> 'false',
			'featured_video'		=> 'true',
			'pagination'			=> 'false',
		), $atts ) );

		// Turn output buffer on
		ob_start();

			// Get global $post
			global $post;

			// Include categories
			$include_categories = ( ! empty( $include_categories ) ) ? $include_categories : $term_slug;
			$include_categories = ( 'all' == $include_categories ) ? '' : $include_categories;
			if ( $include_categories ) {
				$include_categories = explode( ',', $include_categories );
			}

			// Exclude categories
			if ( $exclude_categories ) {
				$exclude_categories = explode( ',', $exclude_categories );
				if( ! empty( $exclude_categories ) && is_array( $exclude_categories ) ) {
				$exclude_categories = array(
						'taxonomy'	=> 'category',
						'field'		=> 'slug',
						'terms'		=> $exclude_categories,
						'operator'	=> 'NOT IN',
					);
				} else {
					$exclude_categories = '';
				}
			}
			
			// Start Tax Query
			if( ! empty( $include_categories ) && is_array( $include_categories ) ) {
				$include_categories = array(
					'taxonomy'	=> 'category',
					'field'		=> 'slug',
					'terms'		=> $include_categories,
					'operator'	=> 'IN',
				);
			} else {
				$include_categories = '';
			}

			// Pagination var
			if( 'true' == $pagination ) {
				global $paged;
				$paged = get_query_var('paged') ? get_query_var('paged') : 1;
				$no_found_rows = false;
			} else {
				$paged = NULL;
				$no_found_rows = true;
			}
			
			// The Query
			$vcex_query = new WP_Query(
				array(
					'post_type'			=> 'post',
					'posts_per_page'	=> $count,
					'offset'			=> $offset,
					'order'				=> $order,
					'orderby'			=> $orderby,
					'filter_content'	=> $filter_content,
					'no_found_rows'		=> $no_found_rows,
					'paged'				=> $paged,
					'tax_query'			=> array(
						'relation'		=> 'AND',
						$include_categories,
						$exclude_categories,
						array(
							'taxonomy'	=> 'post_format',
							'field'		=> 'slug',
							'terms'		=> array( 'post-format-quote','post-format-link' ),
							'operator'	=> 'NOT IN',
						),
					),
				)
			);

			$output = '';

			//Output posts
			if( $vcex_query->posts ) :
		
				$unique_id = $unique_id ? ' id="'. $unique_id .'"' : NULL;
				
				// CSS animations
				$classes = 'vcex-recent-news clr';
				if ( '1' != $grid_columns ) {
					$classes .= ' wpex-row';
				}
				if ( '' != $css_animation ) {
					$classes .= ' wpb_animate_when_almost_visible wpb_'. $css_animation .'';
				} ?>
			
				<div class="<?php echo $classes; ?>" <?php echo $unique_id; ?>>
				
				<?php
				// Header
				if ( '' != $header ) { ?>
					<h2 class="vcex-recent-news-header theme-heading">
						<span><?php echo $header; ?></span>
					</h2>
				<?php } ?>
			
				<?php
				// Loop through posts
				$count = '0';
				foreach ( $vcex_query->posts as $post ) : setup_postdata( $post );
					$count++;
				
					// Post VARS
					$post_id = $post->ID;
					$url = get_permalink($post_id);
					$post_title = get_the_title($post_id);
					$post_excerpt = $post->post_excerpt;
					$post_content = $post->post_content;
					$post_format = get_post_format($post_id);
					if ( 'true' == $featured_video ) {
						$post_video = get_post_meta( $post_id, 'wpex_post_oembed', true );
					}

					// Image
					$featured_img_url = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
					$img_width = $img_width ? intval($img_width) : '9999';
					$img_height = $img_height ? intval($img_height) : '9999';
					$img_crop = $img_height == '9999' ? false : true;
					$cropped_img = wpex_image_resize( $featured_img_url, $img_width, $img_height, $img_crop, 'array' ); ?>

					<?php if ( $grid_columns > '1' ) { ?>
					<div class="col span_1_of_<?php echo $grid_columns; ?> vcex-recent-news-entry-wrap col-<?php echo $count; ?>">
					<?php } ?>
					<article id="post-<?php echo $post_id; ?>" class="vcex-recent-news-entry">
						<?php
						// Date
						if ( $date ) { ?>
							<div class="vcex-recent-news-date">
								<span class="day">
									<?php echo get_the_time('d', $post_id); ?>
								</span>
								<span class="month">
									<?php echo get_the_time('M', $post_id); ?>
								</span>
							</div>
						<?php } ?>
						<div class="vcex-news-entry-details vcex-clearfix">
							<?php
							// Thumbnail
							if ( 'true' == $featured_image ) {
								if ( 'video' == $post_format && 'true' == $featured_video && $post_video ) { ?>
									<div class="vcex-news-entry-video vcex-video-wrap clr">
										<?php echo wp_oembed_get( $post_video ); ?>
									</div>
								<?php } elseif ( has_post_thumbnail( $post_id ) ) { ?>
									<div class="vcex-news-entry-thumbnail clr">
										<a href="<?php echo $url; ?>" title="<?php echo $post_title; ?>">
											<img src="<?php echo $cropped_img['url']; ?>" alt="<?php the_title(); ?>" class="vcex-recent-news-entry-img" height="<?php echo $cropped_img['height']; ?>" width="<?php echo $cropped_img['width']; ?>" />
										</a>
									</div>
								<?php } ?>
							<?php } ?>
							<header class="vcex-recent-news-entry-title">
								<<?php echo $heading; ?> class="vcex-recent-news-entry-title-heading">
									<a href="<?php echo $url; ?>" title="<?php $post_title; ?>"><?php echo $post_title; ?></a>
								</<?php echo $heading; ?>>
							</header><!-- .vcex-recent-news-entry-title -->
							<div class="vcex-recent-news-entry-excerpt vcex-clearfix">
								<?php
								// Excerpts
								$read_more = ( $read_more == 'true' ) ? true : false;
								$excerpt_array = array (
									'length'				=> intval( $excerpt_length ),
									'readmore'				=> $read_more,
									'read_more_text'		=> $read_more_text,
								);
								vcex_excerpt( $excerpt_array ); ?>
							</div><!-- .vcex-recent-news-entry-excerpt -->
						</div><!-- .vcex-recent-news-entry-details -->
					</article><!-- .vcex-recent-news-entry -->
					<?php if ( $grid_columns > '1' ) { ?>
					</div>
					<?php }

					// Reset counter
					if ( $count == $grid_columns ) {
						$count = '';
					}

				// End foreach loop
				endforeach; ?>
				
				</div><!-- .vcex-recent-news -->

				<div class="vcex-recent-news-pagination clr">
					<?php
					// Paginate Posts
					if( 'true' == $pagination ) {
						$total = $vcex_query->max_num_pages;
						$big = 999999999; // need an unlikely integer
						if( $total > 1 )  {
							if( !$current_page = get_query_var('paged') )
								 $current_page = 1;
							if( get_option('permalink_structure') ) {
								 $format = 'page/%#%/';
							} else {
								 $format = '&paged=%#%';
							}
							echo paginate_links(array(
								'base'		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format'	=> $format,
								'current'	=> max( 1, get_query_var('paged') ),
								'total'		=> $total,
								'mid_size'	=> 2,
								'type'		=> 'list',
								'prev_text'	=> '<i class="fa fa-angle-left"></i>',
								'next_text'	=> '<i class="fa fa-angle-right"></i>',
							) );
						}
					} ?>
				</div>
			<?php
			endif; // End has posts check
					
			// Set things back to normal
			wp_reset_postdata();

		// Return data
		return ob_get_clean();
		
	}
}
add_shortcode("vcex_recent_news", "vcex_news_shortcode");

/**
 * Adds the news shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_news_shortcode_vc_map' ) ) {
	function vcex_news_shortcode_vc_map() {
		vc_map( array(
			"name"					=> __( "Recent News", 'wpex' ),
			"description"			=> __( "Recent blog posts.", 'wpex' ),
			"base"					=> "vcex_recent_news",
			"class"					=> "",
			'category'				=> WPEX_THEME_BRANDING,
			'admin_enqueue_js'		=> "",
			'admin_enqueue_css'		=> "",
			"icon"					=> "icon-wpb-vcex-recent_news",
			"params"				=> array(
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Unique Id", 'wpex' ),
					"param_name"	=> "unique_id",
					"value"			=> "",
					//"description"	=> __( "You can enter a unique ID here for styling purposes.", 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __("CSS Animation", "wpex"),
					"param_name"		=> "css_animation",
					"value"			=> array(
						__("No", "wpex")					=> '',
						__("Top to bottom", "wpex")			=> "top-to-bottom",
						__("Bottom to top", "wpex")			=> "bottom-to-top",
						__("Left to right", "wpex")			=> "left-to-right",
						__("Right to left", "wpex")			=> "right-to-left",
						__("Appear from center", "wpex")	=> "appear"
					),
					//"description"	=> __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "wpex"),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Title", 'wpex' ),
					"param_name"	=> "header",
					"value"			=> "",
					"descrtiption"	=> __( "You can display a title above your recent posts.", 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Columns", 'wpex' ),
					'param_name'	=> "grid_columns",
					'value' 		=> array(
						__( 'One','wpex' )		=>'1',
						__( 'Two','wpex' )		=>'2',
						__( 'Three','wpex' )	=>'3',
						__( 'Four','wpex' )		=>'4',
					),
					//'description'	=> __( 'Select how many columns for the grid.', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Include Categories", 'wpex' ),
					"param_name"	=> "include_categories",
					"admin_label"	=> true,
					"value"			=> "",
					"description"	=> __('Enter the slugs of a categories (comma seperated) to pull posts from or enter "all" to pull recent posts from all categories. Example: category-1, category-2.','wpex'),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Exclude Categories", 'wpex' ),
					"param_name"	=> "exclude_categories",
					"admin_label"	=> true,
					"value"			=> "",
					"description"	=> __('Enter the slugs of a categories (comma seperated) to exclude. Example: category-1, category-2.','wpex'),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Post Count", 'wpex' ),
					"param_name"	=> "count",
					"value"			=> "3",
					"descrtiption"	=> __( "How many posts do you wish to show.", 'wpex' ),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Order", 'wpex' ),
					"param_name"	=> "order",
					"value"			=> array(
						__( "DESC", "wpex")	=> "DESC",
						__( "ASC", "wpex" )	=> "ASC",
					),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Order By", 'wpex' ),
					"param_name"	=> "orderby",
					"value"			=> array(
						__( "Date", "wpex")				=> "date",
						__( "Name", "wpex" )			=> "name",
						__( "Modified", "wpex")			=> "modified",
						__( "Author", "wpex" )			=> "author",
						__( "Random", "wpex")			=> "rand",
						__( "Comment Count", "wpex" )	=> "comment_count",
					),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Pagination", 'wpex' ),
					'param_name'	=> "pagination",
					'value'			=> array(
						__( "No", "wpex")	=> "false",
						__( "Yes", "wpex" )	=> "true",
					),
					'description'	=> __("Paginate posts? Important: Pagination will not work on your homepage because of how WordPress works", "wpex" ),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Display Featured Media?", 'wpex' ),
					"param_name"	=> "featured_image",
					"value"			=> array(
						__( "False", "wpex" )	=> "false",
						__( "True", "wpex")		=> "true",
					),
					//"description"	=> __( "Display your featured images and post format videos?", "wpex" ),
					'group'			=> __( 'Media', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Display Featured Videos?", 'wpex' ),
					"param_name"	=> "featured_video",
					"value"			=> array(
						__( "True", "wpex")		=> "true",
						__( "False", "wpex" )	=> "false",
					),
					"description"	=> __( "Display your featured videos on the video post format posts (this will only work if the featured media option is enabled above).", "wpex" ),
					'group'			=> __( 'Media', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Image Crop Width", 'wpex' ),
					"param_name"	=> "img_width",
					"value"			=> "9999",
					//"description"	=> __( "Custom image cropping width. Enter 9999 for no cropping.", 'wpex' ),
					'group'			=> __( 'Media', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Image Crop Height", 'wpex' ),
					"param_name"	=> "img_height",
					"value"			=> "9999",
					"description"	=> __( "Custom image cropping height. Enter 9999 for no cropping (just resizing).", 'wpex' ),
					'group'			=> __( 'Media', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Excerpt Length", 'wpex' ),
					"param_name"	=> "excerpt_length",
					"value"			=> "30",
					'group'			=> __( 'Excerpt', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Read More Link?", 'wpex' ),
					"param_name"	=> "read_more",
					"value"			=> array(
						__( "False", "wpex" )	=> "false",
						__( "True", "wpex")		=> "true",
					),
					//"description"	=> __("Display a read more link after the excerpt?","wpex"),
					'group'			=> __( 'Excerpt', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Read More Text", 'wpex' ),
					"param_name"	=> "read_more_text",
					"value"			=> "",
					//"description"	=> __("Enter your custom text for the readmore button.","wpex"),
					"dependency"	=> Array(
						'element'	=> "read_more",
						'value'		=> "true"
					),
					'group'			=> __( 'Excerpt', 'wpex' ),
				),
			)
		) );
	}
}
add_action( 'init', 'vcex_news_shortcode_vc_map' );
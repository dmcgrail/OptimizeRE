<?php
/**
 * Registers the post type grid shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if( !function_exists( 'vcex_post_type_grid_shortcode' ) ) {
	function vcex_post_type_grid_shortcode($atts) {
		
		extract( shortcode_atts( array(
			'unique_id'			=> '',
			'post_types'		=> '',
			'posts_per_page'	=> '12',
			'grid_style'		=> 'fit_columns',
			'columns'			=> '3',
			'order'				=> 'DESC',
			'orderby'			=> 'date',
			'filter'			=> 'true',
			'center_filter'		=> '',
			'thumbnail_link'	=> 'post',
			'entry_media'		=> "true",
			'img_width'			=> '9999',
			'img_height'		=> '9999',
			'thumb_link'		=> 'post',
			'img_filter'		=> '',
			'title'				=> 'true',
			'date'				=> 'true',
			'excerpt'			=> 'true',
			'excerpt_length'	=> '15',
			'custom_excerpt_trim'	=> 'true',
			'read_more'			=> 'false',
			'read_more_text'	=> __( 'read more', 'wpex' ),
			'pagination'		=> 'false',
			'filter_content'	=> 'false',
			'offset'			=> 0,
			'taxonomy'			=> '',
			'terms'				=> '',
			'all_text'			=> __( 'All', 'wpex' ),
			'featured_video'	=> 'true',
			'url_target'		=> '_self',
			'thumbnail_query'	=> 'no',
			'overlay_style'		=> '',
			'img_hover_style'	=> '',
			'date_color'			=> '',
			'content_heading_margin'=> '',
			'content_background'	=> '',
			'content_margin'		=> '',
			'content_font_size'		=> '',
			'content_padding'		=> '',
			'content_border'		=> '',
			'content_color'			=> '',
			'content_opacity'		=> '',
			'content_heading_color'	=> '',
			'content_heading_size'	=> '',
			'content_alignment'		=> '',
			'readmore_background'	=> '',
			'readmore_color'		=> '',
		), $atts ) );
		
		// Turn output buffer on
		ob_start();

			// Get global $post var
			global $post;
			
			// Pagination var
			if( 'true' == $pagination ) {
				global $paged;
				$paged = get_query_var('paged') ? get_query_var('paged') : 1;
				$no_found_rows = false;
			} else {
				$paged = NULL;
				$no_found_rows = true;
			}

			// Post types
			$post_types = $post_types ? $post_types : 'post';
			$post_types = explode( ',', $post_types );
			$post_types_count = count($post_types);

			// Thumbnail meta query
			if ( 'true' == $thumbnail_query ) {
				$meta_query = array( array ( 'key' => '_thumbnail_id' ) );
			} else {
				$meta_query = NULL;
			}

			// Query args
			$args = array(
				'post_type'			=> $post_types,
				'posts_per_page'	=> $posts_per_page,
				'offset'			=> $offset,
				'order'				=> $order,
				'orderby'			=> $orderby,
				'filter_content'	=> $filter_content,
				'paged'				=> $paged,
				'meta_query'		=> $meta_query,
				'no_found_rows'		=> $no_found_rows
			);

			// Args filter
			$args = apply_filters( 'vcex_post_type_grid_args', $args );

			// Build new query
			$vcex_query = new WP_Query( $args );

			//Output posts
			if( $vcex_query->posts ) :

				// Main Vars
				$unique_id = $unique_id ? $unique_id : 'post-type-'. rand( 1, 100 );
				$img_crop = $img_height == '9999' ? false : true;
				$read_more = $read_more == 'true' ? true : false;

				// Is Isotope var
				if ( ( 'true' == $filter && $post_types_count > '1' ) || 'masonry' == $grid_style ) {
					$is_isotope = true;
				} else {
					$is_isotope = false;
				}

				// No need for masonry if not enough columns and filter is disabled
				if ( 'true' != $filter && 'masonry' == $grid_style ) {
					$post_count = count( $vcex_query->posts );
					if ( $post_count <= $columns ) {
						$is_isotope = false;
					}
				}

				// Main wrap classes
				$wrap_classes = 'wpex-row vcex-post-type-grid vcex-clearfix';
				// Isotope classes
				if ( $is_isotope ) {
					$wrap_classes .= ' vcex-isotope-grid';
				}

				// Output script for inline JS for the Visual composer front-end builder
				if ( function_exists( 'vcex_front_end_grid_js' ) ) {
					if ( $is_isotope ) {
						vcex_front_end_grid_js( 'isotope' );
					} elseif ( 'no_margins' == $grid_style ) {
						vcex_front_end_grid_js( 'masonry' );
					}
				}

				// Content Design
				$content_style = '';
				if ( $content_background ) {
					$content_style .= 'background:'. $content_background .';';
				}
				if ( $content_padding ) {
					$content_style .= 'padding:'. $content_padding .';';
				}
				if ( $content_margin ) {
					$content_style .= 'margin:'. $content_margin .';';
				}
				if ( $content_border ) {
					$content_style .= 'border:'. $content_border .';';
				}
				if ( $content_font_size ) {
					$content_style .= 'font-size:'. $content_font_size .';';
				}
				if ( $content_color ) {
					$content_style .= 'color:'. $content_color .';';
				}
				if ( $content_opacity ) {
					$content_style .= 'opacity:'. $content_opacity .';';
				}
				if ( $content_alignment ) {
					$content_style .= 'text-align:'. $content_alignment .';';
				}
				if ( $content_style ) {
					$content_style = 'style="'. $content_style .'"';
				}

				// Heading Design
				$heading_style = '';
				if ( $content_heading_margin ) {
					$heading_style .='margin:'. $content_heading_margin .';';
				}
				if ( $content_heading_size ) {
					$heading_style .='font-size:'. $content_heading_size .';';
				}
				if ( $content_heading_color ) {
					$heading_style .='color:'. $content_heading_color .';';
				}
				if ( $heading_style ) {
					$heading_style = 'style="'. $heading_style .'"';
				}

				// Readmore design
				if ( 'true' == $read_more ) {
					$readmore_style = '';
					if ( $readmore_background ) {
						$readmore_style .='background:'. $readmore_background .';';
					}
					if ( $readmore_color ) {
						$readmore_style .='color:'. $readmore_color .';';
					}
					if ( $readmore_style ) {
						$readmore_style = 'style="'. $readmore_style .'"';
					}
				}

				// Date design
				$date_style = '';
				if ( 'true' == $date ) {
					if ( $date_color ) {
						$date_style .='color:'. $date_color .';';
					}
					if ( $date_style ) {
						$date_style = 'style="'. $date_style .'"';
					}
				}

				// Display filter links
				if ( 'true' == $filter && $post_types_count > '1' ) {
					$center_filter = 'yes' == $center_filter ? 'center' : ''; ?>
					<ul class="vcex-post-type-filter filter-<?php echo $unique_id; ?> vcex-filter-links <?php echo $center_filter; ?> clr">
						<li class="active"><a href="#" data-filter="*"><span><?php echo $all_text; ?></span></a></li>
						<?php foreach ( $post_types as $post_type ) {
							$obj = get_post_type_object( $post_type ); ?>
							<li><a href="#" data-filter=".post-type-<?php echo $post_type; ?>"><?php echo $obj->labels->name; ?></a></li>
						<?php } ?>
					</ul><!-- .vcex-post-type-filter -->
				<?php } ?>

				<div class="<?php echo $wrap_classes; ?>" id="<?php echo $unique_id; ?>">
					<?php
					// Define counter var to clear floats
					$count='';
					// Loop through posts
					foreach ( $vcex_query->posts as $post ) : setup_postdata( $post );
						// Post ID var
						$post_id = $post->ID;
						// Add to counter var
						$count++;
						// Get post format
						$format = get_post_format( $post_id );
						// Get video
						if ( 'true' == $featured_video ) {
							$video_url = get_post_meta( $post_id, 'wpex_post_oembed', true );
						}
						// General Class
						$entry_classes = 'vcex-post-type-entry col';
						// Counter class
						$entry_classes .= ' col-'. $count;
						// Column class
						$entry_classes .= ' span_1_of_'. $columns;
						// Post type class
						$entry_classes .= ' post-type-'. get_post_type( $post_id );
						// Isotope
						if ( $is_isotope ) {
							$entry_classes .= ' vcex-isotope-entry';
						}
						// No media entry class
						if ( "false" == $entry_media ) {
							$entry_classes .= ' vcex-post-type-no-media-entry';
						}
						if ( $title == 'true' ) {
							$main_element_type = 'article';
						} else {
							$main_element_type = 'div';
						} ?>
						<<?php echo $main_element_type; ?> id="#post-<?php the_ID(); ?>" class="<?php echo $entry_classes; ?>">
							<?php if ( "true" == $entry_media ) { ?>
								<?php
								// Video Embed
								if ( "video" == $format && 'true' == $featured_video && $video_url ) { ?>
									<div class="vcex-post-type-entry-media">
										<div class="vcex-video-wrap">
											<?php echo wp_oembed_get($video_url); ?>
										</div>
									</div><!-- .vcex-post-type-entry-media -->
								<?php }
								// Featured Image
								elseif( has_post_thumbnail() ) {
									// Filter style
									$img_filter_class = $img_filter ? 'vcex-'. $img_filter : '';
									// Image hover styles
									$img_hover_style_class = $img_hover_style ? 'vcex-img-hover-parent vcex-img-hover-'. $img_hover_style : '';
									// Media classes
									$media_classes = $img_filter_class;
									$media_classes .= ' '. $img_hover_style_class;
									$overlay_classnames = wpex_overlay_classname( $overlay_style );
									$media_classes .= ' '. $overlay_classnames; ?>
									<div class="vcex-post-type-entry-media <?php echo $media_classes; ?>">
										<?php if ( $thumb_link == 'post' ||  $thumb_link == 'lightbox' ) { ?>
											<?php
											// Post links
											if ( $thumb_link == 'post' ) { ?>
												<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" target="<?php echo $url_target; ?>">
											<?php } ?>
											<?php
											// Lightbox Links
											if ( $thumb_link == 'lightbox' ) { ?>
												<?php
												// Video Lightbox
												if ( $format == 'video' ) { ?>
													<a href="<?php echo $video_url; ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" class="wpex-lightbox-video">
												<?php }
												// Image lightbox
												else { ?>
													<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" class="wpex-lightbox">
												<?php } ?>
											<?php } ?>
										<?php }
											// Get cropped image array and display image
											$cropped_img = wpex_image_resize( wp_get_attachment_url( get_post_thumbnail_id() ), intval($img_width), intval($img_height), $img_crop, 'array' ); ?>
											<img src="<?php echo $cropped_img['url']; ?>" alt="<?php the_title(); ?>" class="vcex-post-type-entry-img" height="<?php echo $cropped_img['height']; ?>" width="<?php echo $cropped_img['width']; ?>" />
										<?php if ( $thumb_link == 'post' || $thumb_link == 'lightbox' ) { ?>
										<?php } ?>
										<?php
										// Overlay
										if ( 'post' == $thumb_link || 'lightbox' == $thumb_link ) {
											// Inner Overlay
											wpex_overlay( 'inside_link', $overlay_style ); ?>
											</a>
											<?php
											// Outside Overlay
											wpex_overlay( 'outside_link', $overlay_style );
										} ?>
									</div><!-- .post_type-entry-media -->
								<?php } ?>
							<?php } ?>
							<?php if ( 'true' == $title || 'true' == $excerpt || 'true' == $read_more ) { ?>
								<div class="vcex-post-type-entry-details clr" <?php echo $content_style; ?>>
									<?php
									// Post Title
									if ( $title == 'true' ) { ?>
										<h2 class="vcex-post-type-entry-title" <?php echo $heading_style; ?>>
											<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" target="<?php echo $url_target; ?>" <?php echo $heading_style; ?>><?php the_title(); ?></a>
										</h2>
									<?php } ?>
									<?php
									// Post Date
									if ( $date == 'true' ) { ?>
										<div class="vcex-post-type-entry-date" <?php echo $date_style; ?>><?php echo get_the_date(); ?></div>
									<?php } ?>
									<?php
									// Excerpt
									if ('true' ==  $excerpt  || 'true' == $read_more ) {
										if ( 'true' != $excerpt ){
											$excerpt_length = '0';
										} ?>
										<div class="vcex-post-type-entry-excerpt clr">
											<?php
											// Show full content
											if ( '9999' == $excerpt_length ) {
												the_content();
											}
											// Display custom excerpt
											else {
												$trim_custom_excerpts = ( 'true' == $custom_excerpt_trim ) ? true : false;
												$excerpt_array = array (
													'length'				=> intval( $excerpt_length ),
													'trim_custom_excerpts'	=> $trim_custom_excerpts
												);
												vcex_excerpt( $excerpt_array );
											}
											// Read more
											if ( $read_more ) { ?>
												<a href="<?php the_permalink(); ?>" title="<?php echo $read_more_text; ?>" rel="bookmark" class="vcex-readmore theme-button" target="<?php echo $url_target; ?>" <?php echo $readmore_style; ?>>
													<?php echo $read_more_text; ?> <span class="vcex-readmore-rarr">&rarr;</span>
												</a>
											<?php } ?>
										</div>
									<?php } ?>
								</div><!-- .post_type-entry-details -->
							<?php } ?>
						</<?php echo $main_element_type; ?>><!-- .post_type-entry -->
					<?php
					// Reset counter
					if ( $count == $columns ) {
						$count = '0';
					} ?>
					<?php endforeach; ?>
				</div><!-- .vcex-post-type-grid -->
				
				<?php
				// Paginate Posts
				if( $pagination == 'true' ) {
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
							'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format'		=> $format,
							'current'		=> max( 1, get_query_var('paged') ),
							'total'			=> $total,
							'mid_size'		=> 2,
							'type'			=> 'list',
							'prev_text'		=> '&laquo;',
							'next_text'		=> '&raquo;',
						) );
					}
				}
			
			// End has posts check
			endif;

			// Reset the WP query
			wp_reset_postdata();

		// Return outbut buffer
		return ob_get_clean();
		
	}
}
add_shortcode("vcex_post_type_grid", "vcex_post_type_grid_shortcode");

/**
 * Adds the post type grid shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_post_type_grid_shortcode_vcmap' ) ) {
	function vcex_post_type_grid_shortcode_vcmap() {
		vc_map( array(
			"name"					=> __( "Post Types Grid", 'wpex' ),
			"description"			=> __( "Multiple post types posts grid.", 'wpex' ),
			"base"					=> "vcex_post_type_grid",
			"class"					=> "vcex_post_type_grid",
			'category'				=> WPEX_THEME_BRANDING,
			"icon" 					=> "icon-wpb-vcex-post-type-grid",
			"params"				=> array(

				// General
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Unique Id", 'wpex' ),
					"param_name"	=> "unique_id",
					"value"			=> "",
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Grid Style", 'wpex' ),
					"param_name"	=> "grid_style",
					"value"			=> array(
						__( "Fit Columns", "wpex")	=> "fit-columns",
						__( "Masonry", "wpex" )		=> "masonry",
					),
					"description"	=> __( "Important: If the category filter is enabled above the grid will always be masonry style.", 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Columns", 'wpex' ),
					"param_name"	=> "columns",
					"admin_label"	=> true,
					"value" 		=> array(
						__( 'Four','wpex' )		=>'4',
						__( 'Three','wpex' )	=>'3',
						__( 'Two','wpex' )		=>'2',
						__( 'One','wpex' )		=>'1',
					),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Display Featured Videos?", 'wpex' ),
					"param_name"	=> "featured_video",
					"value"			=> array(
						__( "True", "wpex")		=> "true",
						__( "False", "wpex" )	=> "false",
					),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Post Link Target", 'wpex' ),
					"param_name"	=> "url_target",
					 "value"		=> array(
						__("Self", "wpex")	=> "_self",
						__("Blank", "wpex")	=> "_blank",
					),
				),

				// Query
				array(
					'type'			=> 'posttypes',
					'heading'		=> __( 'Post types', 'wpex' ),
					'param_name'	=> 'post_types',
					'group'			=> __( 'Query', 'wpex' ),
				),
				
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Post Type Filter", 'wpex' ),
					"param_name"	=> "filter",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					'group'			=> __( 'Filter', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Center Filter Links", 'wpex' ),
					"param_name"	=> "center_filter",
					"value"			=> array(
						__( 'No', 'wpex' )	=> 'no',
						__( 'Yes', 'wpex' )	=> 'yes',
					),
					'group'			=> __( 'Filter', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( 'Filter "All" Text', 'wpex' ),
					"param_name"	=> "all_text",
					"value"			=> __( 'All', 'wpex' ),
					'group'			=> __( 'Filter', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
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
					"type"			=> "dropdown",
					"heading"		=> __( "Pagination", 'wpex' ),
					"param_name"	=> "pagination",
					"value"			=> array(
						__( "False", "wpex")	=> "false",
						__( "True", "wpex" )	=> "true",
					),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Post With Thumbnails Only", 'wpex' ),
					"param_name"	=> "thumbnail_query",
					"value"			=> array(
						__( "No", "wpex" )	=> "false",
						__( "Yes", "wpex")	=> "true",
					),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Posts Per Page", 'wpex' ),
					"param_name"	=> "posts_per_page",
					"value"			=> "12",
					'group'			=> __( 'Query', 'wpex' ),
				),

				// Image
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Entry Media", 'wpex' ),
					"param_name"	=> "entry_media",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					'group'			=> __( 'Image', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Image Width", 'wpex' ),
					"param_name"	=> "img_width",
					"value"			=> "9999",
					'group'			=> __( 'Image', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Image Height", 'wpex' ),
					"param_name"	=> "img_height",
					"value"			=> "9999",
					"description"	=> __( "Custom image cropping height. Enter 9999 for no cropping.", 'wpex' ),
					'group'			=> __( 'Image', 'wpex' ),
				),
				vcex_overlays_array( 'post_types' ),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "CSS3 Image Hover", 'wpex' ),
					'param_name'	=> "img_hover_style",
					'value'			=> vcex_image_hovers(),
					'description'	=> __("Select your preferred image hover effect. Please note this will only work if the image links to a URL or a large version of itself. Please note these effects may not work in all browsers.", "wpex"),
					'group'			=> __( 'Image', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Image Filter", 'wpex' ),
					"param_name"	=> "img_filter",
					"value"			=> vcex_image_filters(),
					'group'			=> __( 'Image', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Image Links To", 'wpex' ),
					"param_name"	=> "thumb_link",
					"value"			=> array(
						__( "Post", "wpex")			=> "post",
						__( "Lightbox", "wpex" )	=> "lightbox",
						__( "Nowhere", "wpex" )		=> "nowhere",
					),
					'group'			=> __( 'Image', 'wpex' ),
				),

				// Content
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Title", 'wpex' ),
					"param_name"	=> "title",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					'group'			=> __( 'Content', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Title Font size", 'wpex' ),
					'param_name'	=> "content_heading_size",
					'group'			=> __( 'Content', 'wpex' ),
					"dependency"	=> Array(
						'element'	=> "title",
						'value'		=> array( 'true' ),
					),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Title Margin", 'wpex' ),
					'param_name'	=> "content_heading_margin",
					'group'			=> __( 'Content', 'wpex' ),
					"dependency"	=> Array(
						'element'	=> "title",
						'value'		=> array( 'true' ),
					),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Date", 'wpex' ),
					"param_name"	=> "date",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					'group'			=> __( 'Content', 'wpex' ),
				),
				array(
					'type'			=> "colorpicker",
					"heading"		=> __( "Date Color", 'wpex' ),
					'param_name'	=> "date_color",
					'group'			=> __( 'Content', 'wpex' ),
					"dependency"	=> Array(
						'element'	=> "date",
						'value'		=> array( 'true' ),
					),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Excerpt", 'wpex' ),
					"param_name"	=> "excerpt",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					'group'			=> __( 'Content', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Excerpt Length", 'wpex' ),
					"param_name"	=> "excerpt_length",
					"value"			=> "15",
					'group'			=> __( 'Content', 'wpex' ),
					"dependency"	=> Array(
						'element'	=> "excerpt",
						'value'		=> array( 'true' ),
					),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Trim Custom Excerpts", 'wpex' ),
					"param_name"	=> "custom_excerpt_trim",
					"value"			=> array(
						__( 'Yes', 'wpex' )	=> 'true',
						__( 'No', 'wpex' )	=> 'false',
					),
					'group'			=> __( 'Content', 'wpex' ),
					"dependency"	=> Array(
						'element'	=> "excerpt",
						'value'		=> array( 'true' ),
					),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Read More", 'wpex' ),
					"param_name"	=> "read_more",
					"value"			=> array(
						__( "No", "wpex" )	=> "false",
						__( "Yes", "wpex")	=> "true",
					),
					'group'			=> __( 'Content', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Read More Text", 'wpex' ),
					"param_name"	=> "read_more_text",
					"value"			=> __('view post', 'wpex' ),
					'group'			=> __( 'Content', 'wpex' ),
					"dependency"	=> Array(
						'element'	=> "read_more",
						'value'		=> array( 'true' ),
					),
				),

				// Design
				array(
					'type'			=> "colorpicker",
					"heading"		=> __( "Content Background", 'wpex' ),
					'param_name'	=> "content_background",
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> "colorpicker",
					"heading"		=> __( "Heading Text Color", 'wpex' ),
					'param_name'	=> "content_heading_color",
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> "colorpicker",
					"heading"		=> __( "Content Text Color", 'wpex' ),
					'param_name'	=> "content_color",
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( 'Content Alignment', 'wpex' ),
					'param_name'	=> "content_alignment",
					'value'			=> array(
						__( "Left", "wpex" )	=> "left",
						__( "Right", "wpex" )	=> "right",
						__( "Center", "wpex")	=> "center",
					),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Content Font Size", 'wpex' ),
					'param_name'	=> "content_font_size",
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Content Margin", 'wpex' ),
					'param_name'	=> "content_margin",
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Content Padding", 'wpex' ),
					'param_name'	=> "content_padding",
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Content Opacity", 'wpex' ),
					'param_name'	=> "content_opacity",
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Content Border", 'wpex' ),
					'param_name'	=> "content_border",
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> "colorpicker",
					"heading"		=> __( "Content Read More Background", 'wpex' ),
					'param_name'	=> "readmore_background",
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> "colorpicker",
					"heading"		=> __( "Content Read More Color", 'wpex' ),
					'param_name'	=> "readmore_color",
					'group'			=> __( 'Design', 'wpex' ),
				),

			)
		) );
	}
}
add_action( 'init', 'vcex_post_type_grid_shortcode_vcmap' );
<?php
/**
 * Registers the portfolio grid shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if( !function_exists( 'vcex_portfolio_grid_shortcode' ) ) {
	function vcex_portfolio_grid_shortcode($atts) {
		
		// Define shortcode params
		extract( shortcode_atts( array(
			'unique_id'				=> '',
			'term_slug'				=> '',
			'include_categories'	=> '',
			'exclude_categories'	=> '',
			'posts_per_page'		=> '12',
			'grid_style'			=> 'fit_columns',
			'columns'				=> '4',
			'order'					=> 'DESC',
			'orderby'				=> 'date',
			'filter'				=> '',
			'center_filter'			=> 'no',
			'thumbnail_link'		=> 'post',
			'img_crop'				=> 'true',
			'img_width'				=> '9999',
			'img_height'			=> '9999',
			//'img_border_radius'	=> '',
			'thumb_link'			=> 'post',
			'img_filter'			=> '',
			'title'					=> 'true',
			'title_link'			=> 'post',
			'excerpt'				=> 'true',
			'excerpt_length'		=> '30',
			'custom_excerpt_trim'	=> 'true',
			'read_more'				=> 'false',
			'read_more_text'		=> __( 'read more', 'wpex' ),
			'pagination'			=> 'false',
			'filter_content'		=> 'false',
			'offset'				=> 0,
			'taxonomy'				=> '',
			'terms'					=> '',
			'img_hover_style'		=> '',
			'img_overlay_disable'	=> '',
			'img_rendering'			=> '',
			'all_text'				=> __( 'All', 'wpex' ),
			'overlay_style'			=> '',
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

			// Get global $post
			global $post;

			// Not done yet
			$img_border_radius = false;

			// Don't create custom tax if tax doesn't exist
			if ( taxonomy_exists( 'portfolio_category' ) ) {

				// Include categories
				$include_categories = ( '' != $include_categories ) ? $include_categories : $term_slug;
				$include_categories = ( 'all' == $include_categories ) ? '' : $include_categories;
				$filter_cats_include = '';
				if ( $include_categories ) {
					$include_categories = explode( ',', $include_categories );
					$filter_cats_include = array();
					foreach ( $include_categories as $key ) {
						$key = get_term_by( 'slug', $key, 'portfolio_category' );
						$filter_cats_include[] = $key->term_id;
					}
				}

				// Exclude categories
				$filter_cats_exclude = '';
				if ( $exclude_categories ) {
					$exclude_categories = explode( ',', $exclude_categories );
					if( ! empty( $exclude_categories ) && is_array( $exclude_categories ) ) {
					$filter_cats_exclude = array();
					foreach ( $exclude_categories as $key ) {
						$key = get_term_by( 'slug', $key, 'portfolio_category' );
						$filter_cats_exclude[] = $key->term_id;
					}
					$exclude_categories = array(
							'taxonomy'	=> 'portfolio_category',
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
						'taxonomy'	=> 'portfolio_category',
						'field'		=> 'slug',
						'terms'		=> $include_categories,
						'operator'	=> 'IN',
					);
				} else {
					$include_categories = '';
				}

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
					'post_type'			=> 'portfolio',
					'posts_per_page'	=> $posts_per_page,
					'offset'			=> $offset,
					'order'				=> $order,
					'orderby'			=> $orderby,
					'filter_content'	=> $filter_content,
					'paged'				=> $paged,
					'tax_query'			=> array(
						'relation'		=> 'AND',
						$include_categories,
						$exclude_categories,
					),
					'no_found_rows'		=> $no_found_rows
				)
			);

			//Output posts
			if( $vcex_query->posts ) :

				// Set unique ID
				$unique_id = $unique_id ? $unique_id : 'portfolio-'. rand( 1, 100 );

				// Image hard crop
				$img_crop = $img_height == '9999' ? false : true;

				// Overlay Style
				if ( empty( $overlay_style ) ) {
					$overlay_style = 'none';
				} else {
					$overlay_style = $overlay_style;
				}

				// Is Isotope var
				if ( 'true' == $filter || 'masonry' == $grid_style ) {
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

				// Remove all filter/isotope for no margin grids
				if ( 'no_margins' == $grid_style ) {
					$filter = false;
					$is_isotope = false;
				}

				// Main wrap classes
				$wrap_classes = 'wpex-row vcex-portfolio-grid vcex-clearfix';
				// Isotope classes
				if ( $is_isotope ) {
					$wrap_classes .= ' vcex-isotope-grid';
				}
				// No margins grid
				if ( 'no_margins' == $grid_style ) {
					$wrap_classes .= ' vcex-no-margin-grid';
				}
				// Border radius
				if ( $img_border_radius ) {
					$img_border_radius = 'style="border-radius:'. $img_border_radius .';"';
				}

				// Output script for inline JS for the Visual composer front-end builder
				if ( function_exists( 'vcex_front_end_grid_js' ) ) {
					if ( $is_isotope ) {
						vcex_front_end_grid_js( 'isotope' );
					} elseif ( 'no_margins' == $grid_style ) {
						vcex_front_end_grid_js( 'masonry' );
					}
				}

				// Display filter links
				if ( 'true' == $filter && taxonomy_exists( 'portfolio_category' ) ) {
					$terms = get_terms( 'portfolio_category', array(
						'include'	=> $filter_cats_include,
						'exclude'	=> $filter_cats_exclude,
					) );
					$terms = apply_filters( 'vcex_portfolio_grid_get_terms', $terms );
					if( $terms && count($terms) > '1') {
						$center_filter = 'yes' == $center_filter ? 'center' : ''; ?>
						<ul class="vcex-portfolio-filter filter-<?php echo $unique_id; ?> vcex-filter-links <?php echo $center_filter; ?> clr">
							<li class="active"><a href="#" data-filter="*"><span><?php echo $all_text; ?></span></a></li>
							<?php foreach ($terms as $term ) : ?>
								<li><a href="#" data-filter=".cat-<?php echo $term->term_id; ?>"><?php echo $term->name; ?></a></li>
							<?php endforeach; ?>
						</ul><!-- .vcex-portfolio-filter -->
					<?php } ?>
				<?php }

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
					$heading_style .='margin: '. $content_heading_margin .';';
				}
				if ( $content_heading_size ) {
					$heading_style .='font-size: '. $content_heading_size .';';
				}
				if ( $content_heading_color ) {
					$heading_style .='color: '. $content_heading_color .';';
				}
				if ( $heading_style ) {
					$heading_style = 'style="'. $heading_style .'"';
				}

				// Readmore design
				if ( 'true' == $read_more ) {
					$readmore_style = '';
					if ( $readmore_background ) {
						$readmore_style .='background: '. $readmore_background .';';
					}
					if ( $readmore_color ) {
						$readmore_style .='color: '. $readmore_color .';';
					}
					if ( $readmore_style ) {
						$readmore_style = 'style="'. $readmore_style .'"';
					}
				} ?>
		
				<div class="<?php echo $wrap_classes; ?>" id="<?php echo $unique_id; ?>">
					<?php
					// Define counter var to clear floats
					$count='';
					// Start loop
					foreach ( $vcex_query->posts as $post ) : setup_postdata( $post );
						// Define post ID var
						$post_id = $post->ID;
						// Add to the counter var
						$count++;
						// Add classes to the entries
						$entry_classes = 'portfolio-entry col';
						// Image rendering
						if ( $img_rendering ) {
							$entry_classes .= ' vcex-image-rendering-'. $img_rendering;
						}
						// Main column class
						$entry_classes .= ' span_1_of_'. $columns;
						// Counter to clear divs
						$entry_classes .= ' col-'. $count;
						// Isotope
						if ( $is_isotope ) {
							$entry_classes .= ' vcex-isotope-entry';
						}
						// No margins grid
						if ( 'no_margins' == $grid_style ) {
							$entry_classes .= ' vcex-no-margin-entry';
						}
						// Add category slugs to classes
						if ( taxonomy_exists( 'portfolio_category' ) ) {
							$post_terms = get_the_terms( $post, 'portfolio_category' );
							if ( $post_terms ) {
								foreach ( $post_terms as $post_term ) {
									$entry_classes .= ' cat-'. $post_term->term_id;
								}
							}
						}
						// Only use articles if title is enabled
						if ( $title == 'true' ) {
							$main_element_type = 'article';
						} else {
							$main_element_type = 'div';
						} ?>
						<<?php echo $main_element_type; ?> id="#post-<?php the_ID(); ?>" class="<?php echo $entry_classes; ?>">
							<?php
							// Video
							if ( function_exists( 'wpex_get_portfolio_featured_video_url' ) && wpex_get_portfolio_featured_video_url() ) { ?>
								<div class="portfolio-entry-media clr">
									<?php wpex_portfolio_post_video(); ?>
								</div>
							<?php }
							// Featured Image
							elseif ( has_post_thumbnail() ) {
								// Filter style
								$img_filter_class = $img_filter ? 'vcex-'. $img_filter : '';
								// Image hover styles
								$img_hover_style_class = $img_hover_style ? 'vcex-img-hover-parent vcex-img-hover-'. $img_hover_style : '';
								// Media classes
								$media_classes = $img_filter_class;
								$media_classes .= ' '. $img_hover_style_class;
								$overlay_classnames = wpex_overlay_classname( $overlay_style );
								$media_classes .= ' '. $overlay_classnames; ?>
								<div class="portfolio-entry-media <?php echo $media_classes; ?>" <?php echo $img_border_radius; ?>>
									<?php if ( $thumb_link == 'post' ||  $thumb_link == 'lightbox' ) { ?>
										<?php if ( $thumb_link == 'post' ) { ?>
											<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" class="portfolio-entry-media-link">
										<?php } ?>
										<?php if ( $thumb_link == 'lightbox' ) { ?>
											<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" class="portfolio-entry-media-link wpex-lightbox">
										<?php } ?>
									<?php }
										// Get cropped image array
										$cropped_img = wpex_image_resize( wp_get_attachment_url( get_post_thumbnail_id() ), intval($img_width), intval($img_height), $img_crop, 'array' ); ?>
										<img src="<?php echo $cropped_img['url']; ?>" alt="<?php the_title(); ?>" class="portfolio-entry-img" height="<?php echo $cropped_img['height']; ?>" width="<?php echo $cropped_img['width']; ?>" />
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
							</div><!-- .portfolio-entry-media -->
							<?php } ?>
							<?php if ( 'true' == $title || 'true' == $excerpt ) { ?>
								<div class="portfolio-entry-details clr" <?php echo $content_style; ?>>
									<?php if ( 'true' == $title ) { ?>
										<h2 class="portfolio-entry-title" <?php echo $heading_style; ?>>
											<?php if ( 'post' == $title_link ) { ?>
												<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" <?php echo $heading_style; ?>><?php the_title(); ?></a>
											<?php } elseif( 'lightbox' == $title_link ) { ?>
												<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" class="wpex-lightbox" <?php echo $heading_style; ?>><?php the_title(); ?></a>
											<?php } else { ?>
												<?php the_title(); ?>
											<?php } ?>
										</h2>
									<?php } ?>
									<?php if ('true' ==  $excerpt || 'true' == $read_more ) {
										if ( 'true' != $excerpt ){
											$excerpt_length = '0';
										} ?>
										<div class="portfolio-entry-excerpt clr">
											<?php
											// Display full content
											if ( '9999' == $excerpt_length ) {
												the_content();
											}
											// Display Excerpt
											else {
												$trim_custom_excerpts = ( 'true' == $custom_excerpt_trim ) ? true : false;
												$excerpt_array = array (
													'length'				=> intval( $excerpt_length ),
													'trim_custom_excerpts'	=> $trim_custom_excerpts
												);
												vcex_excerpt( $excerpt_array );
											}
											// Read more Button
											if ( 'true' == $read_more ) { ?>
												<a href="<?php echo the_permalink(); ?>" title="<?php echo $read_more_text; ?>" rel="bookmark" class="vcex-readmore theme-button" <?php echo $readmore_style; ?>>
													<?php echo $read_more_text; ?> <span class="vcex-readmore-rarr">&rarr;</span>
												</a>
											<?php } ?>
										</div>
									<?php } ?>
								</div><!-- .portfolio-entry-details -->
							<?php } ?>
						</<?php echo $main_element_type; ?>><!-- .portfolio-entry -->
					<?php
					// Reset counter
					if ( $count == $columns ) {
						$count = '';
					} ?>
					<?php endforeach; ?>
				</div><!-- .vcex-portfolio-grid -->
				
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
				}

			// End has posts check
			endif;

			// Reset the WP query
			wp_reset_postdata();

		// Return outbut buffer
		return ob_get_clean();

	}
}
add_shortcode( 'vcex_portfolio_grid', 'vcex_portfolio_grid_shortcode' );

/**
 * Adds the portfolio grid shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_portfolio_grid_shortcode_vc_map' ) ) {
	function vcex_portfolio_grid_shortcode_vc_map() {
		$vc_img_rendering_url = 'https://developer.mozilla.org/en-US/docs/Web/CSS/image-rendering';
		vc_map( array(
			"name"					=> __( "Portfolio Grid", 'wpex' ),
			'description'			=> __( "Recent portfolio posts grid.", 'wpex' ),
			"base"					=> "vcex_portfolio_grid",
			"class"					=> "vcex_portfolio_grid",
			'category'				=> WPEX_THEME_BRANDING,
			"icon" 					=> "icon-wpb-vcex-portfolio_grid",
			"params"				=> array(

				// General
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Unique Id", 'wpex' ),
					'param_name'	=> "unique_id",
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Columns", 'wpex' ),
					'param_name'	=> "columns",
					'value' 		=> array(
						__( 'Four','wpex' )		=>'4',
						__( 'Three','wpex' )	=>'3',
						__( 'Two','wpex' )		=>'2',
						__( 'One','wpex' )		=>'1',
					),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Grid Style", 'wpex' ),
					'param_name'	=> "grid_style",
					'value'			=> array(
						__( "Fit Columns", "wpex")	=> "fit-columns",
						__( "Masonry", "wpex" )		=> "masonry",
						__( "No Margins", "wpex" )	=> "no_margins",
					),
				),

				// Query
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Include Categories", 'wpex' ),
					'param_name'	=> "include_categories",
					"admin_label"	=> true,
					'description'	=> __('Enter the slugs of a categories (comma seperated) to pull posts from or enter "all" to pull recent posts from all categories. Example: category-1, category-2.','wpex'),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Exclude Categories", 'wpex' ),
					'param_name'	=> "exclude_categories",
					"admin_label"	=> true,
					'description'	=> __('Enter the slugs of a categories (comma seperated) to exclude. Example: category-1, category-2.','wpex'),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Order", 'wpex' ),
					'param_name'	=> "order",
					'value'			=> array(
						__( "DESC", "wpex")	=> "DESC",
						__( "ASC", "wpex" )	=> "ASC",
					),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Order By", 'wpex' ),
					'param_name'	=> "orderby",
					'value'			=> array(
						__( "Date", "wpex")				=> "date",
						__( "Name", "wpex" )			=> "name",
						__( "Modified", "wpex")			=> "modified",
						__( "Author", "wpex" )			=> "author",
						__( "Random", "wpex")			=> "rand",
						__( "Comment Count", "wpex" )	=> "comment_count",
					),
					'group'			=> __( 'Query', 'wpex' ),
				),

				// Filter
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Category Filter", 'wpex' ),
					'param_name'	=> "filter",
					'value'			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					'group'			=> __( 'Filter', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Center Filter Links", 'wpex' ),
					'param_name'	=> "center_filter",
					'value'			=> array(
						__( 'No', 'wpex' )	=> 'no',
						__( 'Yes', 'wpex' )	=> 'yes',
					),
					'group'			=> __( 'Filter', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( 'Custom Category Filter "All" Text', 'wpex' ),
					'param_name'	=> "all_text",
					'value'			=> __( 'All', 'wpex' ),
					'group'			=> __( 'Filter', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Posts Per Page", 'wpex' ),
					'param_name'	=> "posts_per_page",
					'value'			=> "8",
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
					'group'			=> __( 'Query', 'wpex' ),
				),


				// Images
				vcex_overlays_array(),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Image Crop Width", 'wpex' ),
					'param_name'	=> "img_width",
					'value'			=> "9999",
					'group'			=> __( 'Image', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Image Crop Height", 'wpex' ),
					'param_name'	=> "img_height",
					'value'			=> "9999",
					'description'	=> __( "Custom image cropping height. Enter 9999 for no cropping (just resizing).", 'wpex' ),
					'group'			=> __( 'Image', 'wpex' ),
				),
				/*array(
					'type'			=> "textfield",
					"heading"		=> __( "Image Border Radius", 'wpex' ),
					'param_name'	=> "img_border_radius",
					//'description'	=> __( "Enter a border radius for your image. For example (4px). To create perfectly round images use 50%.", 'wpex' ),
					'group'			=> __( 'Image', 'wpex' ),
				),*/
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Image Filter", 'wpex' ),
					'param_name'	=> "img_filter",
					'value'			=> vcex_image_filters(),
					'group'			=> __( 'Image', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Image Rendering", 'wpex' ),
					'param_name'	=> "img_rendering",
					'value'			=> vcex_image_rendering(),
					'description'	=> sprintf( __( 'Image-rendering CSS property provides a hint to the user agent about how to handle its image rendering. For example when scaling down images they tend to look a bit fuzzy in Firefox, setting image-rendering to crisp-edges can help make the images look better. <a href="%s">Learn more</a>.', 'wpex' ), esc_url( $vc_img_rendering_url ) ),
					'group'			=> __( 'Image', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "CSS3 Image Hover", 'wpex' ),
					'param_name'	=> "img_hover_style",
					'value'			=> vcex_image_hovers(),
					'description'	=> __("Select your preferred image hover effect. Please note this will only work if the image links to a URL or a large version of itself. Please note these effects may not work in all browsers.", "wpex"),
					'group'			=> __( 'Image', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Image Links To", 'wpex' ),
					'param_name'	=> "thumb_link",
					'value'			=> array(
						__( "Post", "wpex")			=> "post",
						__( "Lightbox", "wpex" )	=> "lightbox",
						__( "Nowhere", "wpex" )		=> "nowhere",
					),
					'group'			=> __( 'Image', 'wpex' ),
				),

				// Content
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Title", 'wpex' ),
					'param_name'	=> "title",
					'value'			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					'group'			=> __( 'Content', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Title Links To", 'wpex' ),
					'param_name'	=> "title_link",
					'value'			=> array(
						__( "Post", "wpex")		=> "post",
						__( "Lightbox", "wpex")	=> "lightbox",
						__( "Nowhere", "wpex" )	=> "nowhere",
					),
					'group'			=> __( 'Content', 'wpex' ),
					"dependency"	=> Array(
						'element'	=> "title",
						'value'		=> array( 'true' ),
					),
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
					'type'			=> "dropdown",
					"heading"		=> __( "Excerpt", 'wpex' ),
					'param_name'	=> "excerpt",
					'value'			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					'group'			=> __( 'Content', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Excerpt Length", 'wpex' ),
					'param_name'	=> "excerpt_length",
					'value'			=> "30",
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
					'type'			=> "dropdown",
					"heading"		=> __( "Read More", 'wpex' ),
					'param_name'	=> "read_more",
					'value'			=> array(
						__( "No", "wpex" )	=> "false",
						__( "Yes", "wpex")	=> "true",
					),
					'group'			=> __( 'Content', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Read More Text", 'wpex' ),
					'param_name'	=> "read_more_text",
					'value'			=> __('view post', 'wpex' ),
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

			),
		) );
	}
}
add_action( 'init', 'vcex_portfolio_grid_shortcode_vc_map' );
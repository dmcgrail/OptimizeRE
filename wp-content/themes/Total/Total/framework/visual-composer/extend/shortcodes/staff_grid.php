<?php
/**
 * Registers the staff grid shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if( !function_exists( 'vcex_staff_grid_shortcode' ) ) {
	function vcex_staff_grid_shortcode( $atts ) {
		
		extract( shortcode_atts( array(
			'unique_id'				=> '',
			'term_slug'				=> '',
			'include_categories'	=> '',
			'exclude_categories'	=> '',
			'posts_per_page'		=> '',
			'grid_style'			=> 'fit_columns',
			'columns'				=> '',
			'order'					=> 'DESC',
			'orderby'				=> 'date',
			'filter'				=> 'true',
			'center_filter'			=> '',
			'thumbnail_link'		=> 'post',
			'img_crop'				=> 'true',
			'img_width'				=> '9999',
			'img_height'			=> '9999',
			'thumb_link'			=> 'post',
			'img_filter'			=> '',
			'title'					=> 'true',
			'title_link'			=> 'post',
			'excerpt'				=> 'true',
			'excerpt_length'		=> '15',
			'custom_excerpt_trim'	=> 'true',
			'read_more'				=> 'false',
			'read_more_text'		=> __( 'read more', 'wpex' ),
			'pagination'			=> 'false',
			'filter_content'		=> 'false',
			'social_links'			=> 'true',
			'offset'				=> 0,
			'taxonomy'				=> '',
			'terms'					=> '',
			'img_hover_style'		=> '',
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

			// Get global $post var
			global $post;

			// Don't create custom tax if tax doesn't exist
			if ( taxonomy_exists( 'staff_category' ) ) {
				
				// Include categories
				$include_categories = ( '' != $include_categories ) ? $include_categories : $term_slug;
				$include_categories = ( 'all' == $include_categories ) ? '' : $include_categories;
				$filter_cats_include = '';
				if ( $include_categories ) {
					$include_categories = explode( ',', $include_categories );
					$filter_cats_include = array();
					foreach ( $include_categories as $key ) {
						$key = get_term_by( 'slug', $key, 'staff_category' );
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
						$key = get_term_by( 'slug', $key, 'staff_category' );
						$filter_cats_exclude[] = $key->term_id;
					}
					$exclude_categories = array(
							'taxonomy'	=> 'staff_category',
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
						'taxonomy'	=> 'staff_category',
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
					'post_type'			=> 'staff',
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
			
				// Main Vars
				$rand_num = rand(1, 100);
				$unique_id = $unique_id ? $unique_id : 'staff-'. rand( 1, 100 );
				$img_crop = $img_height == '9999' ? false : true;
				$read_more = $read_more == 'true' ? true : false;

				// Is Isotope var
				if ( 'true' == $filter  || 'masonry' == $grid_style ) {
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

				// Output script for inline JS for the Visual composer front-end builder
				if ( function_exists( 'vcex_front_end_grid_js' ) ) {
					if ( $is_isotope ) {
						vcex_front_end_grid_js( 'isotope' );
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

				// Display filter links
				if ( $filter == 'true' && taxonomy_exists( 'staff_category' ) ) {
					$terms = get_terms( 'staff_category', array(
						'include'	=> $filter_cats_include,
						'exclude'	=> $filter_cats_exclude,
					) );
					$terms = apply_filters( 'vcex_staff_grid_get_terms', $terms );
					if( $terms && count($terms) > '1') {
						$center_filter = 'yes' == $center_filter ? 'center' : ''; ?>
						<ul class="vcex-staff-filter filter-<?php echo $unique_id; ?> vcex-filter-links <?php echo $center_filter; ?> clr">
							<li class="active"><a href="#" data-filter="*"><span><?php echo $all_text; ?></span></a></li>
							<?php foreach ($terms as $term ) : ?>
								<li><a href="#" data-filter=".cat-<?php echo $term->term_id; ?>"><?php echo $term->name; ?></a></li>
							<?php endforeach; ?>
						</ul><!-- .vcex-staff-filter -->
					<?php } ?>
				<?php } ?>
		
				<div class="wpex-row vcex-staff-grid vcex-clearfix <?php if ( $is_isotope ) echo 'vcex-isotope-grid'; ?>" id="<?php echo $unique_id; ?>">
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
						$entry_classes = 'staff-entry col';
						// Column class
						$entry_classes .= ' span_1_of_'. $columns;
						// Counter
						$entry_classes .= ' col-'. $count;
						// Isotope
						if ( $is_isotope ) {
							$entry_classes .= ' vcex-isotope-entry';
						}
						// Image rendering
						if ( $img_rendering ) {
							$entry_classes .= ' vcex-image-rendering-'. $img_rendering;
						}
						// Categories
						if ( taxonomy_exists( 'staff_category' ) ) {
							$post_terms = get_the_terms( $post, 'staff_category' );
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
								//Featured Image
								if( has_post_thumbnail() ) {
									// Image rendering
									if ( $img_rendering ) {
										$entry_classes .= ' vcex-image-rendering-'. $img_rendering;
									}
									// Categories
									if ( taxonomy_exists( 'staff_category' ) ) {
										$post_terms = get_the_terms( $post, 'staff_category' );
										if ( $post_terms ) {
											foreach ( $post_terms as $post_term ) {
												$entry_classes .= ' cat-'. $post_term->term_id;
											}
										}
									}
									// Overlays
									if ( function_exists( 'wpex_overlay_classname' ) ) {
										$overlay_classnames = wpex_overlay_classname( $overlay_style );
									} else {
										$overlay_classnames = '';
									}
									// Image Filter class
									$img_filter_class = $img_filter ? 'vcex-'. $img_filter : '';
									// Image hover styles
									$img_hover_style_class = $img_hover_style ? 'vcex-img-hover-parent vcex-img-hover-'. $img_hover_style : ''; ?>
									<div class="staff-entry-media <?php echo $img_filter_class; ?> <?php echo $img_hover_style_class; ?> <?php echo $overlay_classnames; ?>">
										<?php if ( 'post' == $thumb_link || 'lightbox' == $thumb_link ) { ?>
											<?php if ( 'post' == $thumb_link ) { ?>
												<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" class="staff-entry-media-link">
											<?php } ?>
											<?php if ( $thumb_link == 'lightbox' ) { ?>
												<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" class="staff-entry-media-link wpex-lightbox">
											<?php } ?>
										<?php }
											// Get cropped image array and display image
											$cropped_img = wpex_image_resize( wp_get_attachment_url( get_post_thumbnail_id() ), intval($img_width), intval($img_height), $img_crop, 'array' ); ?>
											<img src="<?php echo $cropped_img['url']; ?>" alt="<?php the_title(); ?>" class="staff-entry-img" height="<?php echo $cropped_img['height']; ?>" width="<?php echo $cropped_img['width']; ?>" />
										<?php if ( 'post' == $thumb_link || 'lightbox' == $thumb_link ) { ?>
											<?php
											// Inner Overlay
											if ( function_exists( 'wpex_overlay' ) ) {
												wpex_overlay( 'inside_link', $overlay_style );
											} ?>
											</a>
										<?php } ?>
										<?php
										// Outside Overlay
										if ( function_exists( 'wpex_overlay' ) ) {
											wpex_overlay( 'outside_link', $overlay_style );
										} ?>
									</div><!-- .staff-media -->
								<?php } ?>
								<?php if ( 'true' == $title || 'true' == $excerpt || 'true' == $read_more ) { ?>
									<div class="staff-entry-details clr" <?php echo $content_style; ?>>
										<?php
										// Display the title
										if ( 'true' == $title ) { ?>
											<h2 class="staff-entry-title" <?php echo $heading_style; ?>>
												<?php if ( 'post' == $title_link ) { ?>
													<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" <?php echo $heading_style; ?>><?php the_title(); ?></a>
												<?php } else { ?>
													<?php the_title(); ?>
												<?php } ?>
											</h2>
										<?php } ?>
										<?php if ('true' ==  $excerpt ) { ?>
											<div class="clr"></div>
											<div class="staff-entry-excerpt clr">
												<?php
												// Dusplay full content
												if ( '9999' == $excerpt_length ) {
													the_content();
												}
												// Custom Excerpt
												else {
													$trim_custom_excerpts = ( 'true' == $custom_excerpt_trim ) ? true : false;
													$excerpt_array = array (
														'length'				=> intval( $excerpt_length ),
														'trim_custom_excerpts'	=> $trim_custom_excerpts
													);
													vcex_excerpt( $excerpt_array );
												} ?>
											</div>
										<?php } ?>
										<?php
										// Display social links
										if ( function_exists( 'wpex_get_staff_social' ) && 'true' == $social_links ) {
											echo wpex_get_staff_social();
										}
										// Read more button
										if ( 'true' == $read_more ) { ?>
												<a href="<?php echo get_permalink(); ?>" title="<?php $read_more_text; ?>" rel="bookmark" class="vcex-readmore theme-button" <?php echo $readmore_style; ?>>
													<?php echo $read_more_text; ?> <span class="vcex-readmore-rarr">&rarr;</span>
												</a>
										<?php } ?>
									</div><!-- .staff-entry-details -->
								<?php } ?>
							</<?php echo $main_element_type; ?>><!-- .staff-entry -->
							<?php
							// Reset counter
							if ( $count == $columns ) {
								$count = '';
							} ?>
						<?php endforeach; ?>
					</div><!-- .vcex-staff-grid -->
					
					<?php
					// Paginate Posts
					if( $pagination == 'true' ) {
						$total = $vcex_query->max_num_pages;
						$big = 999999999; // need an unlikely integer
						if( $total > 1 ) {
							if( !$current_page = get_query_var( 'paged' ) )
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
								'prev_text'		=> '<i class="fa fa-angle-left"></i>',
								'next_text'		=> '<i class="fa fa-angle-right"></i>',
							));
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
add_shortcode( "vcex_staff_grid", "vcex_staff_grid_shortcode" );

/**
 * Adds the staff grid shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_staff_grid_shortcode_vc_map' ) ) {
	function vcex_staff_grid_shortcode_vc_map() {
		$vc_img_rendering_url = 'https://developer.mozilla.org/en-US/docs/Web/CSS/image-rendering';
		vc_map( array(
			"name"					=> __( "Staff Grid", 'wpex' ),
			"description"			=> __( "Recent staff posts grid", 'wpex' ),
			"base"					=> "vcex_staff_grid",
			"class"					=> "vcex_staff_grid",
			'category'				=> WPEX_THEME_BRANDING,
			"icon" 					=> "icon-wpb-vcex-staff_grid",
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
					"heading"		=> __( "Columns", 'wpex' ),
					"param_name"	=> "columns",
					"value" 		=> array(
						__( 'Four','wpex' )		=>'4',
						__( 'Three','wpex' )	=>'3',
						__( 'Two','wpex' )		=>'2',
						__( 'One','wpex' )		=>'1',
					),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Grid Style", 'wpex' ),
					"param_name"	=> "grid_style",
					"value"			=> array(
						__( "Fit Columns", "wpex")	=> "fit-columns",
						__( "Masonry", "wpex" )		=> "masonry",
					),
				),

				// Query
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Include Categories", 'wpex' ),
					"param_name"	=> "include_categories",
					"admin_label"	=> true,
					"value"			=> "",
					"description"	=> __('Enter the slugs of a categories (comma seperated) to pull posts from or enter "all" to pull recent posts from all categories. Example: category-1, category-2.','wpex'),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Exclude Categories", 'wpex' ),
					"param_name"	=> "exclude_categories",
					"admin_label"	=> true,
					"value"			=> "",
					"description"	=> __('Enter the slugs of a categories (comma seperated) to exclude. Example: category-1, category-2.','wpex'),
					'group'			=> __( 'Query', 'wpex' ),
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
					"type"			=> "textfield",
					"heading"		=> __( "Posts Per Page", 'wpex' ),
					"param_name"	=> "posts_per_page",
					"value"			=> "12",
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Pagination", 'wpex' ),
					"param_name"	=> "pagination",
					"value"			=> array(
						__( "No", "wpex" )	=> "false",
						__( "Yes", "wpex")	=> "true",
					),
					"description"	=> __("Paginate posts? Important: Pagination will not work on your homepage because of how WordPress works","wpex"),
					'group'			=> __( 'Query', 'wpex' ),
				),
				
				// Filter
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Category Filter", 'wpex' ),
					"param_name"	=> "filter",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					'group'			=> __( 'Filter', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
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
					"class"			=> "",
					"heading"		=> __( 'Custom Category Filter "All" Text', 'wpex' ),
					"param_name"	=> "all_text",
					"value"			=> __( 'All', 'wpex' ),
					'group'			=> __( 'Filter', 'wpex' ),
				),

				// Image
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
				vcex_overlays_array(),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Image Crop Width", 'wpex' ),
					"param_name"	=> "img_width",
					"value"			=> "9999",
					'group'			=> __( 'Image', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Image Crop Height", 'wpex' ),
					"param_name"	=> "img_height",
					"value"			=> "9999",
					"description"	=> __( "Custom image cropping height. Enter 9999 for no cropping.", 'wpex' ),
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
					"heading"		=> __( "CSS3 Image Hover", 'wpex' ),
					"param_name"	=> "img_hover_style",
					"value"			=> vcex_image_hovers(),
					"description"	=> __("Select your preferred image hover effect. Please note this will only work if the image links to a URL or a large version of itself. Please note these effects may not work in all browsers.", "wpex"),
					'group'			=> __( 'Image', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Image Rendering", 'wpex' ),
					"param_name"	=> "img_rendering",
					"value"			=> vcex_image_rendering(),
					"description"	=> sprintf( __( 'Image-rendering CSS property provides a hint to the user agent about how to handle its image rendering. For example when scaling down images they tend to look a bit fuzzy in Firefox, setting image-rendering to crisp-edges can help make the images look better. <a href="%s">Learn more</a>.', 'wpex' ), esc_url( $vc_img_rendering_url ) ),
					'group'			=> __( 'Image', 'wpex' ),
				),

				// Content
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Title", 'wpex' ),
					"param_name"	=> "title",
					"value"			=> array(
						__( "Yes", "wpex" )	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					'group'			=> __( 'Content', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Title Links To", 'wpex' ),
					"param_name"	=> "title_link",
					"value"			=> array(
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
					"value"			=> "30",
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
						__( "No", "wpex" )		=> "false",
						__( "Yes", "wpex")		=> "true",
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
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Social Links", 'wpex' ),
					"param_name"	=> "social_links",
					"value"			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					'group'			=> __( 'Content', 'wpex' ),
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
add_action( 'init', 'vcex_staff_grid_shortcode_vc_map' );
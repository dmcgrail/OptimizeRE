<?php
/**
 * Registers the testimonials grid shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if( !function_exists( 'vcex_testimonials_grid_shortcode' ) ) {
	function vcex_testimonials_grid_shortcode($atts) {
		
		extract( shortcode_atts( array(
			'unique_id'				=> '',
			'term_slug'				=> 'all',
			'include_categories'	=> '',
			'exclude_categories'	=> '',
			'posts_per_page'		=> '12',
			'grid_style'			=> 'fit_columns',
			'columns'				=> '4',
			'order'					=> 'DESC',
			'orderby'				=> 'date',
			'filter'				=> 'true',
			'center_filter'			=> '',
			'title'					=> 'true',
			'excerpt'				=> 'false',
			'excerpt_length'		=> '20',
			'read_more'				=> 'true',
			'read_more_text'		=> __( 'read more', 'wpex' ),
			'pagination'			=> 'false',
			'filter_content'		=> 'false',
			'offset'				=> 0,
			'taxonomy'				=> '',
			'terms'					=> '',
			'all_text'				=> __( 'All', 'wpex' ),
			'img_border_radius'		=> '50%',
			'img_width'				=> '45',
			'img_height'			=> '45',
		), $atts ) );

		// Turn output buffer on
		ob_start();

			// Get global $post var
			global $post;

			// Border Radius
			$img_border_radius = $img_border_radius ? $img_border_radius : '50%';
			$img_border_radius = 'style="border-radius:'. $img_border_radius .';"';
				
			// Include categories
			$include_categories = ( '' != $include_categories ) ? $include_categories : $term_slug;
			$include_categories = ( 'all' == $include_categories ) ? '' : $include_categories;
			$filter_cats_include = '';
			if ( $include_categories ) {
				$include_categories = explode( ',', $include_categories );
				$filter_cats_include = array();
				foreach ( $include_categories as $key ) {
					$key = get_term_by( 'slug', $key, 'testimonials_category' );
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
					$key = get_term_by( 'slug', $key, 'testimonials_category' );
					$filter_cats_exclude[] = $key->term_id;
				}
				$exclude_categories = array(
						'taxonomy'	=> 'testimonials_category',
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
					'taxonomy'	=> 'testimonials_category',
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
					'post_type'			=> 'testimonials',
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
				$unique_id = $unique_id ? $unique_id : 'testimonials-'. rand( 1, 100 );

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

				// Output script for inline JS for the Visual composer front-end builder
				if ( function_exists( 'vcex_front_end_grid_js' ) ) {
					if ( $is_isotope ) {
						vcex_front_end_grid_js( 'isotope' );
					}
				}

				// Display filter links
				if ( $filter == 'true' && taxonomy_exists( 'testimonials_category' ) ) {
					$terms = get_terms( 'testimonials_category', array(
						'include'	=> $filter_cats_include,
						'exclude'	=> $filter_cats_exclude,
					) );
					$terms = apply_filters( 'vcex_testimonials_grid_get_terms', $terms );
					if( $terms && count($terms) > '1') {
						$center_filter = 'yes' == $center_filter ? 'center' : ''; ?>
						<ul class="vcex-testimonials-filter filter-<?php echo $unique_id; ?> vcex-filter-links <?php echo $center_filter; ?> clr">
							<li class="active"><a href="#" data-filter="*"><span><?php echo $all_text; ?></span></a></li>
							<?php foreach ($terms as $term ) : ?>
								<li><a href="#" data-filter=".cat-<?php echo $term->term_id; ?>"><?php echo $term->name; ?></a></li>
							<?php endforeach; ?>
						</ul><!-- .vcex-testimonials-filter -->
					<?php }
				} ?>

				<div class="wpex-row vcex-testimonials-grid vcex-clearfix <?php if ( $is_isotope ) echo 'vcex-isotope-grid'; ?>" id="<?php echo $unique_id; ?>">
					<?php
					$count='';
					foreach ( $vcex_query->posts as $post ) : setup_postdata( $post );
						$count++;
						// Get testimonial data
						$wpex_testimonial_author = get_post_meta( get_the_ID(), 'wpex_testimonial_author', true );
						$wpex_testimonial_company = get_post_meta( get_the_ID(), 'wpex_testimonial_company', true );
						$wpex_testimonial_url = get_post_meta( get_the_ID(), 'wpex_testimonial_url', true );
						// Get featured image and resize it
						$post_thumb_id = get_post_thumbnail_id();
						$attachment_url = wp_get_attachment_url( $post_thumb_id );
						$img_crop = '9999' == $img_height ? false : true;
						$cropped_img = wpex_image_resize( wp_get_attachment_url( get_post_thumbnail_id() ), intval($img_width), intval($img_height), $img_crop, 'array' );
						$img_url = $cropped_img['url'];
						// Add classes to the entries
						$entry_classes = 'testimonial-entry col';
						$entry_classes .= ' span_1_of_'. $columns;
						$entry_classes .= ' col-'. $count;
						// Isotope
						if ( $is_isotope ) {
							$entry_classes .= ' vcex-isotope-entry';
						}
						if ( taxonomy_exists( 'testimonials_category' ) ) {
							$post_terms = get_the_terms( $post, 'testimonials_category' );
							if ( $post_terms ) {
								foreach ( $post_terms as $post_term ) {
									$entry_classes .= ' cat-'. $post_term->term_id;
								}
							}
						} ?>
						<div id="#post-<?php the_ID(); ?>" class="<?php echo $entry_classes; ?>">
							<div class="testimonial-entry-content clr">
								<span class="testimonial-caret"></span>
								<?php
								// Custom Excerpt
								if ( 'true' == $excerpt ) {
									$read_more = $read_more == 'true' ? true : false;
									if ( 'true' == $read_more ) {
										$read_more_link = '...<a href="'. get_permalink() .'" title="'. $read_more_text .'">'. $read_more_text .'<span>&rarr;</span></a>';
									} else {
										$read_more_link = '...';
									}
									echo wp_trim_words( get_the_content(), $excerpt_length, $read_more_link );
								}
								// Full Content
								else {
									the_content();
								} ?>
							</div><!-- .home-testimonial-entry-content-->
							<div class="testimonial-entry-bottom">
								<?php if( has_post_thumbnail() ) { ?>
								<div class="testimonial-entry-thumb">
									<img src="<?php echo $img_url; ?>" alt="<?php echo the_title(); ?>" <?php echo $img_border_radius; ?> />
								</div><!-- /testimonial-thumb -->
								<?php } ?>
								<div class="testimonial-entry-meta">
									<?php if ( $wpex_testimonial_author ) { ?>
										<span class="testimonial-entry-author"><?php echo $wpex_testimonial_author; ?></span>
									<?php } ?>
									<?php if ( $wpex_testimonial_company ) { ?>
										<?php if ( $wpex_testimonial_url ) { ?>
											<a href="<?php echo esc_url( $wpex_testimonial_url ); ?>" class="testimonial-entry-company" title="<?php echo $wpex_testimonial_company; ?>" target="_blank"><?php echo $wpex_testimonial_company; ?></a>
										<?php } else { ?>
											<span class="testimonial-entry-company"><?php echo $wpex_testimonial_company; ?></span>
										<?php } ?>
									<?php } ?>
								</div><!-- .testimonial-entry-meta -->
							</div><!-- .home-testimonial-entry-bottom -->
						</div><!-- .testimonials-entry -->
						<?php
						// Reset counter
						if ( $count == $columns ) {
							$count = '';
						}
					endforeach; ?>
				</div><!-- .vcex-testimonials-grid -->
				
				<?php
				// Paginate Posts
				if( $pagination == 'true' ) {
					$total = $vcex_query->max_num_pages;
					$big = 999999999; // need an unlikely integer
					if( $total > 1 ) {
						if( !$current_page = get_query_var('paged') )
							 $current_page = 1;
						if( get_option('permalink_structure') ) {
							 $format = 'page/%#%/';
						} else {
							 $format = '&paged=%#%';
						}
						echo paginate_links( array(
							'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format'		=> $format,
							'current'		=> max( 1, get_query_var('paged') ),
							'total'			=> $total,
							'mid_size'		=> 2,
							'type'			=> 'list',
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
add_shortcode( 'vcex_testimonials_grid', 'vcex_testimonials_grid_shortcode' );

/**
 * Adds the testimonials grid shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_testimonials_grid_shortcode_vc_map' ) ) {
	function vcex_testimonials_grid_shortcode_vc_map() {
		vc_map( array(
			"name"					=> __( "Testimonials Grid", 'wpex' ),
			'description'			=> __( "Recent testimonials post grid", 'wpex' ),
			'base'					=> "vcex_testimonials_grid",
			'class'					=> "vcex_testimonials_grid",
			'category'				=> WPEX_THEME_BRANDING,
			'icon'					=> "icon-wpb-vcex-testimonials_grid",
			'params'				=> array(
				array(
					'type'			=> "textfield",
					'heading'		=> __( "Unique Id", 'wpex' ),
					'param_name'	=> "unique_id",
					"value"			=> "",
					//'description'	=> __( "You can enter a unique ID here for styling purposes.", 'wpex' ),
				),
				/*Query*/
				array(
					'type'			=> "textfield",
					'heading'		=> __( "Include Categories", 'wpex' ),
					'param_name'	=> "include_categories",
					"admin_label"	=> true,
					"value"			=> "",
					'description'	=> __('Enter the slugs of a categories (comma seperated) to pull posts from or enter "all" to pull recent posts from all categories. Example: category-1, category-2.','wpex'),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					'heading'		=> __( "Exclude Categories", 'wpex' ),
					'param_name'	=> "exclude_categories",
					"admin_label"	=> true,
					"value"			=> "",
					'description'	=> __('Enter the slugs of a categories (comma seperated) to exclude. Example: category-1, category-2.','wpex'),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					'heading'		=> __( "Order", 'wpex' ),
					'param_name'	=> "order",
					//'description'	=> sprintf( __( 'Designates the ascending or descending order. More at %s.', 'wpex' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
					"value"			=> array(
						__( "DESC", "wpex")	=> "DESC",
						__( "ASC", "wpex" )	=> "ASC",
					),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					'heading'		=> __( "Order By", 'wpex' ),
					'param_name'	=> "orderby",
					//'description'	=> sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'wpex' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
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
					'type'			=> "textfield",
					'heading'		=> __( "Posts Per Page", 'wpex' ),
					'param_name'	=> "posts_per_page",
					"value"			=> "-1",
					//'description'	=> __( "How many items do you wish to show?", 'wpex' ),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					'heading'		=> __( "Pagination", 'wpex' ),
					'param_name'	=> "pagination",
					"value"			=> array(
						__( "No", "wpex")	=> "false",
						__( "Yes", "wpex" )	=> "true",
					),
					'description'	=> __("Paginate posts? Important: Pagination will not work on your homepage because of how WordPress works","wpex"),
					'group'			=> __( 'Query', 'wpex' ),
				),
				/*Design*/
				array(
					'type'			=> "dropdown",
					'heading'		=> __( "Columns", 'wpex' ),
					'param_name'	=> "columns",
					'value' 		=> array(
						__( 'Four','wpex' )		=>'4',
						__( 'Three','wpex' )	=>'3',
						__( 'Two','wpex' )		=>'2',
						__( 'One','wpex' )		=>'1',
					),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					'heading'		=> __( "Grid Style", 'wpex' ),
					'param_name'	=> "grid_style",
					"value"			=> array(
						__( "Fit Columns", "wpex")	=> "fit-columns",
						__( "Masonry", "wpex" )		=> "masonry",
					),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					'heading'		=> __( "Excerpt", 'wpex' ),
					'param_name'	=> "excerpt",
					'value'			=> array(
						__( "No", "wpex" )	=> "false",
						__( "Yes", "wpex")	=> "true",
					),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					'heading'		=> __( "Excerpt Length", 'wpex' ),
					'param_name'	=> "excerpt_length",
					'value'			=> "20",
					'group'			=> __( 'Design', 'wpex' ),
					"dependency"	=> Array(
						'element'	=> 'excerpt',
						'value'		=> array( 'true' )
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
					'group'			=> __( 'Design', 'wpex' ),
					"dependency"	=> Array(
						'element'	=> "excerpt",
						'value'		=> array( 'true' ),
					),
				),
				array(
					'type'			=> "dropdown",
					'heading'		=> __( "Read More", 'wpex' ),
					'param_name'	=> "read_more",
					'value'			=> array(
						__( "Yes", "wpex")	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					'group'			=> __( 'Design', 'wpex' ),
					"dependency"	=> Array(
						'element'	=> 'excerpt',
						'value'		=> array( 'true' )
					),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( 'Read More Text', 'wpex' ),
					'param_name'	=> 'read_more_text',
					'value'			=> __( 'read more', 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
					"dependency"	=> Array(
						'element'	=> 'excerpt',
						'value'		=> array( 'true' )
					),
				),
				/*Filter*/
				array(
					'type'			=> "dropdown",
					'heading'		=> __( "Category Filter", 'wpex' ),
					'param_name'	=> "filter",
					"value"			=> array(
						__( "Yes", "wpex" )	=> "true",
						__( "No", "wpex" )	=> "false",
					),
					'group'			=> __( 'Filter', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					'heading'		=> __( "Center Filter Links", 'wpex' ),
					'param_name'	=> "center_filter",
					"value"			=> array(
						__( 'No', 'wpex' )	=> 'no',
						__( 'Yes', 'wpex' )	=> 'yes',
					),
					'group'			=> __( 'Filter', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					'heading'		=> __( 'Custom Category Filter "All" Text', 'wpex' ),
					'param_name'	=> "all_text",
					"value"			=> __( 'All', 'wpex' ),
					'group'			=> __( 'Filter', 'wpex' ),
				),
				/*Image*/
				array(
					'type'			=> "textfield",
					'heading'		=> __( "Image Border Radius", 'wpex' ),
					'param_name'	=> "img_border_radius",
					'value'			=> "50%",
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					'heading'		=> __( "Image Crop Width", 'wpex' ),
					'param_name'	=> "img_width",
					'value'			=> "45",
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					'heading'		=> __( "Image Crop Height", 'wpex' ),
					'param_name'	=> "img_height",
					'value'			=> "45",
					'description'	=> __( "Custom image cropping height. Enter 9999 for no cropping.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
			),
		) );
	}
}
add_action( 'init', 'vcex_testimonials_grid_shortcode_vc_map' );
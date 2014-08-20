<?php
/**
 * Registers the blog carousel shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if( !function_exists( 'vcex_blog_carousel_shortcode' ) ) {

	function vcex_blog_carousel_shortcode($atts) {
		
		extract( shortcode_atts( array(
			'unique_id'				=> '',
			'style'					=> 'default',
			'term_slug'				=> '',
			'include_categories'	=> '',
			'exclude_categories'	=> '',
			'count'					=> '8',
			'item_width'			=> '230',
			'infinite_loop'			=> 'true',
			'min_slides'			=> '1',
			'max_slides'			=> '4',
			'items_scroll'			=> 'page',
			'animation'				=> 'CSS',
			'auto_play'				=> 'false',
			'timeout_duration'		=> '5000',
			'arrows'				=> 'true',
			'order'					=> 'DESC',
			'orderby'				=> 'date',
			'thumbnail_link'		=> 'post',
			'img_width'				=> '9999',
			'img_height'			=> '9999',
			'title'					=> 'true',
			'excerpt'				=> 'true',
			'excerpt_length'		=> '30',
			'filter_content'		=> 'false',
			'offset'				=> 0,
			'taxonomy'				=> '',
			'custom_excerpt_trim'	=> 'true',
			'terms'					=>'',
			'img_hover_style'		=> '',
			'img_overlay_disable'	=> '',
		), $atts ) );

		// Global post
		global $post;

		// Front-end composer check
		if ( function_exists('vc_is_inline') && vc_is_inline() ) {
			$is_vcfe = true;
		} else {
			$is_vcfe = false;
		}
		
		// Output var
		$output = '';
		
		// Include categories
		$include_categories = ( '' != $include_categories ) ? $include_categories : $term_slug;
		$include_categories = ( 'all' == $include_categories ) ? '' : $include_categories;
		$filter_cats_include = '';
		if ( $include_categories ) {
			$include_categories = explode( ',', $include_categories );
			$filter_cats_include = array();
			foreach ( $include_categories as $key ) {
				$key = get_term_by( 'slug', $key, 'category' );
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
				$key = get_term_by( 'slug', $key, 'category' );
				$filter_cats_exclude[] = $key->term_id;
			}
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
		
		// The Query
		$vcex_carousel_query = new WP_Query(
			array(
				'post_type' 		=> 'post',
				'posts_per_page'	=> $count,
				'offset'			=> $offset,
				'order'				=> $order,
				'orderby'			=> $orderby,
				'filter_content'	=> $filter_content,
				'no_found_rows'		=> true,
				'tax_query'			=> array(
					'relation'		=> 'AND',
					$include_categories,
					$exclude_categories,
				),
			)
		);

		//Output posts
		if( $vcex_carousel_query->posts ) :
			
			// Give caroufredsel a unique name
			$rand_num = rand(1, 100);
			$unique_carousel_id = 'caroufredsel-'. $rand_num;

			// Prevent auto play in visual composer
			if ( wpex_is_front_end_composer() ) {
				$auto_play = 'false';
			}
			
			// Output filter JS into the footer like a WP Jedi Master
			$output .='
				<script type="text/javascript">
					jQuery(function($){
						if ( $.fn.imagesLoaded != undefined && $.fn.carouFredSel != undefined ) {
							var $carouselContainer = $("#'. $unique_carousel_id .'");
							$carouselContainer.imagesLoaded(function() {
								$carouselContainer.carouFredSel({
									responsive : true,
									height: "variable",
									width : "100%",
									circular : '. $infinite_loop .',
									infinite : '. $infinite_loop .',
									auto : {
										play: '. $auto_play .',
										timeoutDuration : '. $timeout_duration .',
									},
									swipe : {
										onTouch: true,
										onMouse: true
									},';
									if ( 'page' != $items_scroll ) {
										$output .= 'scroll : {
											items : '. $items_scroll .',
										},';
									}
									if ( 'true' == $arrows ) {
										$output .= 'prev : "#prev-'. $rand_num .'",';
										$output .= 'next : "#next-'. $rand_num .'",';
									}
									$output .='items : {
										width : '. intval($item_width) .',
										height: "variable",
										visible : {
											min : '. intval($min_slides) .',
											max : '. intval($max_slides) .'
										}
									}
								});
							});
						}';
						if ( ! $is_vcfe ) {
							$output .= '$(window).load(function(){
								$(".vcex-caroufredsel-loading").removeClass("vcex-caroufredsel-loading");
							});';
						}
					$output .= '});
				</script>';
		
			//Unique ID
			$unique_id = $unique_id ? ' id="'. $unique_id .'"' : NULL;

			// Main Classes
			$main_classes = 'vcex-caroufredsel-wrap clr vcex-caroufredsel-blog';
			if ( $style ) {
				$main_classes .= ' vcex-caroufredsel-'. $style;
			}
			if ( ! $is_vcfe ) {
				$main_classes .= ' vcex-caroufredsel-loading';
			}
		
			// Main wrapper div	
			$output .= '<div class="'. $main_classes .'"'. $unique_id  .'>';

				$output .= '<div class="vcex-caroufredsel"><ul id="'. $unique_carousel_id .'">';
			
				// Loop through posts
				foreach ( $vcex_carousel_query->posts as $post ) : setup_postdata( $post );
				
					// Post VARS
					$postid = $post->ID;
					$featured_img_url	= wp_get_attachment_url( get_post_thumbnail_id( $postid ) );
					$featured_img = wp_get_attachment_url( get_post_thumbnail_id( $postid ) );
					$url = get_permalink( $postid );
					$post_title = get_the_title( $postid );
					$the_content = $post->post_content;
					
					// Crop featured images if necessary
					$img_width = $img_width ? intval($img_width) : '9999';
					$img_height = $img_height ? intval($img_height) : '9999';
					$thumbnail_hard_crop = $img_height == '9999' ? false : true;
					$featured_img = wpex_image_resize( $featured_img_url, $img_width, $img_height, $thumbnail_hard_crop );
		
					// Carousel item start
					$output .= '<li class="vcex-caroufredsel-slide">';
					
						// Image hover styles
						$img_hover_style_class = $img_hover_style ? 'vcex-img-hover-parent vcex-img-hover-'. $img_hover_style : '';
					
						// Media Wrap
						if( has_post_thumbnail($postid) ) {
							$output .= '<div class="vcex-caroufredsel-entry-media '. $img_hover_style_class .'">';
							
								if ( $thumbnail_link == 'none' ) {
									$output .= '<img src="'. $featured_img .'" alt="'. $post_title .'" />';
								} elseif ( 'lightbox' == $thumbnail_link ) {
									$output .= '<a href="'. $featured_img_url .'" title="'. $post_title .'" class="vcex-caroufredsel-entry-img wpex-lightbox">';
										$output .= '<img src="'. $featured_img .'" alt="'. $post_title .'" />';
										if ( 'yes' != $img_overlay_disable ) {
											$output .= '<span class="blog-entry-overlay"></span>';
										}
									$output .= '</a><!-- .vcex-caroufredsel-entry-img -->';
								} else {
									$output .= '<a href="'. $url .'" title="'. $post_title .'" class="vcex-caroufredsel-entry-img">';
										$output .= '<img src="'. $featured_img .'" alt="'. $post_title .'" />';
										if ( 'yes' != $img_overlay_disable ) {
											$output .= '<span class="blog-entry-overlay"></span>';
										}
									$output .= '</a><!-- .vcex-caroufredsel-entry-img -->';
								}
								
								$output .= '</div>';
						}
						
						if ( 'true' == $title || 'true' == $excerpt ) {
							$output .= '<div class="vcex-caroufredsel-entry-details">';
							if ( 'true' == $title && $post_title ) {
								$centered_title = $excerpt == 'true' ? '' : 'textcenter';
								$output .= '<div class="vcex-caroufredsel-entry-title '. $centered_title .'"><a href="'. $url .'" title="'. $post_title .'">'. $post_title .'</a></div>';
							}
							if ( 'true' == $excerpt && !empty( $the_content ) ) {
								// Custom Excerpt
								$trim_custom_excerpts = ( 'true' == $custom_excerpt_trim ) ? true : false;
								$excerpt_array = array (
									'length'				=> intval( $excerpt_length ),
									'readmore'				=> false,
									'trim_custom_excerpts'	=> $trim_custom_excerpts
								);
								$output .= '<div class="vcex-caroufredsel-entry-excerpt">'. vcex_get_excerpt( $excerpt_array ) .'</div>';
							}
							$output .= '</div>';
						
						}
						
					// Close main wrap
					$output .= '</li>';
				
				// End foreach loop
				endforeach;
				
				// End UL
				$output .= '</ul>';
				
				// Next/Prev arrows	
				if ( $arrows == 'true' ) {
					$output .= '<div id="prev-'. $rand_num .'" class="vcex-caroufredsel-prev"><span class="fa fa-chevron-left"></span></div><div id="next-'. $rand_num .'" class="vcex-caroufredsel-next"><span class="fa fa-chevron-right"></span></div>';
				}
			
			// Close main wrap
			$output .= '</div></div><div class="vcex-clear-floats"></div>';
		
		endif; // End has posts check
		
		
		// Set things back to normal
		$vcex_carousel_query = NULL;
		wp_reset_postdata();

		// Return data
		return $output;
		
	}
}
add_shortcode("vcex_blog_carousel", "vcex_blog_carousel_shortcode");

/**
 * Adds the blog carousel shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_blog_carousel_shortcode_vcmap' ) ) {
	function vcex_blog_carousel_shortcode_vcmap() {
		vc_map( array(
			'name'					=> __( "Blog Carousel", 'wpex' ),
			'description'			=> __( "Recent blog posts carousel.", 'wpex' ),
			"base"					=> "vcex_blog_carousel",
			'class'					=> "vcex_blog_carousel",
			'category'				=> WPEX_THEME_BRANDING,
			'icon'					=> "icon-wpb-vcex-blog_carousel",
			"front_enqueue_css"		=> wpex_vc_frontend_css(),
			"front_enqueue_js"		=> wpex_vc_frontend_js(),
			'params'				=> array(
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Unique Id", 'wpex' ),
					'param_name'	=> "unique_id",
				),
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
					'type'			=> "textfield",
					"heading"		=> __( "Post Count", 'wpex' ),
					'param_name'	=> "count",
					'value'			=> "8",
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
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Slide Width", 'wpex' ),
					'param_name'	=> "item_width",
					'value'			=> "230",
					'description'	=> __('The width of each slide in pixels. This is used to calculate the min and max items for responsiveness. It is basic math, figure out how many items you want to display, subtract the margins (20px between each item) and you will get your item width, increase this value to display larger items on smaller devices.','wpex'),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Min Slides", 'wpex' ),
					'param_name'	=> "min_slides",
					'value'			=> "1",
					'description'	=> __('The minimum number of slides to be shown.','wpex'),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Max Slides", 'wpex' ),
					'param_name'	=> "max_slides",
					'value'			=> "4",
					'description'	=> __('The maximum number of slides to be shown.','wpex'),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Items To Scroll", 'wpex' ),
					'param_name'	=> "items_scroll",
					'value'			=> "page",
					'description'	=> __('The number of items to scroll at a time. Enter "page" to scroll to the first item of the previous/next "page".','wpex'),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Auto Play", 'wpex' ),
					'param_name'	=> "auto_play",
					'value'			=> array(
						__( "Yes", "wpex" )	=> "true",
						__( "No", "wpex")	=> "false",
					),
					'description'	=> __('Determines whether the carousel should scroll automatically or not.','wpex'),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Infinite Loop", 'wpex' ),
					"param_name"	=> "infinite_loop",
					"value"			=> array(
						__( "True", "wpex" )	=> "true",
						__( "False", 'wpex' )	=> "false",
					),
					"description"	=> __('Determines whether the carousel should scroll automatically or not.','wpex'),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __('Timeout Duration (in milliseconds)', 'wpex'),
					'param_name'	=> "timeout_duration",
					'value'			=> "5000",
					"dependency"	=> Array('element'	=> "auto_play", 'value' => "true" ),
					'description'	=> __('The amount of milliseconds the carousel will pause.','wpex'),
				),

				// Design
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Style", 'wpex' ),
					'param_name'	=> "style",
					'value'			=> array(
						__( "Default", "wpex")		=> "default",
						__( "No Margins", "wpex" )	=> "no-margins",
					),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Display Arrows?", 'wpex' ),
					'param_name'	=> "arrows",
					'value'			=> array(
						__( "Yes", "wpex" )	=> "true",
						__( "No", "wpex")	=> "false",
					),
					'group'			=> __( 'Design', 'wpex' ),
				),

				// Images
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Image Links To", 'wpex' ),
					'param_name'	=> "thumbnail_link",
					'value'			=> array(
						__( "Post", "wpex")			=> "post",
						__( "Lightbox", "wpex" )	=> "lightbox",
						__( "None", "wpex" )		=> "none",
					),
					'group'			=> __( 'Image', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Image Overlay?", 'wpex' ),
					'param_name'	=> "img_overlay_disable",
					'value'			=> array(
						__( "Yes", "wpex")		=> "false",
						__( "No", "wpex" )		=> "yes",
					),
					'group'			=> __( 'Image', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "CSS3 Image Hover", 'wpex' ),
					'param_name'	=> "img_hover_style",
					'value'			=> vcex_image_hovers(),
					'group'			=> __( 'Image', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Image Width", 'wpex' ),
					'param_name'	=> "img_width",
					'value'			=> "500",
					'group'			=> __( 'Image', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					"heading"		=> __( "Image Height", 'wpex' ),
					'param_name'	=> "img_height",
					'value'			=> "350",
					'description'	=> __( 'Enter a height in pixels. Set to "9999" to disable vertical cropping and keep image proportions.', 'wpex' ),
					'group'			=> __( 'Image', 'wpex' ),
				),

				// Content
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Display Title", 'wpex' ),
					'param_name'	=> "title",
					'value'			=> array(
						__( "True", "wpex")		=> "true",
						__( "False", "wpex" )	=> "false",
					),
					'group'			=> __( 'Content', 'wpex' ),
				),
				array(
					'type'			=> "dropdown",
					"heading"		=> __( "Display Excerpt", 'wpex' ),
					'param_name'	=> "excerpt",
					'value'			=> array(
						__( "True", "wpex")		=> "true",
						__( "False", "wpex" )	=> "false",
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
			)
		) );
	}
}
add_action( 'init', 'vcex_blog_carousel_shortcode_vcmap' );
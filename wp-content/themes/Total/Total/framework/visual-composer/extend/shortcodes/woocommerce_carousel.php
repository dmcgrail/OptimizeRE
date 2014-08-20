<?php
/**
 * Registers the woocommerce carousel shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if( !function_exists( 'vcex_woocommerce_carousel_shortcode' ) ) {
	function vcex_woocommerce_carousel_shortcode($atts) {
		
		extract( shortcode_atts( array(
			'unique_id'			=> '',
			'style'				=> 'default',
			'term_slug'			=> 'all',
			'count'				=> '8',
			'item_width'		=> '230',
			'min_slides'		=> '1',
			'max_slides'		=> '4',
			'animation'			=> 'CSS',
			'auto_play'			=> 'false',
			'infinite_loop'		=> 'true',
			'timeout_duration'	=> '5000',
			'items_scroll'		=> 'page',
			'arrows'			=> 'true',
			'order'				=> 'DESC',
			'orderby'			=> 'date',
			'thumbnail_link'	=> 'post',
			'img_crop'			=> 'true',
			'img_width'			=> '9999',
			'img_height'		=> '9999',
			'details'			=> 'true',
			'filter_content'	=> 'false',
			'offset'			=> 0,
			'taxonomy'			=> '',
			'terms'				=>'',
		), $atts ) );

		// Global post
		global $post;
		
		// Front-end composer check
		if ( function_exists('vc_is_inline') && vc_is_inline() ) {
			$is_vcfe = true;
		} else {
			$is_vcfe = false;
		}

		// Define Output var
		$output = '';

		// Start Tax Query
		if( $term_slug !== 'all' ) {
			$tax_query = array(
				array (
					'taxonomy'	=> 'product_cat',
					'field'		=> 'slug',
					'terms'		=> $term_slug,
				)
			);
		} else {
			$tax_query = NULL;
		}
		
		// The Query
		$vcex_carousel_query = new WP_Query(
			array(
				'post_type'			=> 'product',
				'posts_per_page'	=> $count,
				'offset'			=> $offset,
				'order'				=> $order,
				'orderby'			=> $orderby,
				'filter_content'	=> $filter_content,
				'no_found_rows'		=> true,
				'tax_query'			=> $tax_query,
				'meta_query'		=> array( array( 'key' => '_thumbnail_id' ) ) // only show items with thumbnails
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
										onMouse: true,
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
			$unique_id = $unique_id ? 'id="'. $unique_id .'"' : NULL;

			// Main Classes
			$main_classes = 'vcex-caroufredsel-wrap clr vcex-caroufredsel-portfolio';
			if ( $style ) {
				$main_classes .= ' vcex-caroufredsel-'. $style;
			}
			if ( ! $is_vcfe ) {
				$main_classes .= ' vcex-caroufredsel-loading';
			}
		
			// Main wrapper div
			$output .= '<div class="'. $main_classes .'" '. $unique_id  .'>';

				$output .= '<div class="vcex-caroufredsel"><ul id="'. $unique_carousel_id .'">';
			
				// Loop through posts
				foreach ( $vcex_carousel_query->posts as $post ) : setup_postdata( $post );
				
					// Post VARS
					$postid = $post->ID;
					$featured_img_url	= wp_get_attachment_url( get_post_thumbnail_id( $postid ) );
					$featured_img = wp_get_attachment_url( get_post_thumbnail_id( $postid ) );
					$url = get_permalink( $postid );
					$post_title = get_the_title( $postid );
					
					$product = get_product( $postid );
					$product_price = $product->get_price_html();
					
					// Crop featured images if necessary
					if( $img_crop == 'true' ) {
						$thumbnail_hard_crop = $img_height == '9999' ? false : true;
						$featured_img = wpex_image_resize( $featured_img_url, $img_width, $img_height, $thumbnail_hard_crop );
					}
		
					// Carousel item start
					$output .= '<li class="vcex-caroufredsel-slide">';
					
						// Media Wrap
						if( has_post_thumbnail($postid) ) {
							$output .= '<div class="vcex-caroufredsel-entry-media">';
							
								if ( $thumbnail_link == 'none' ) {
									$output .= '<img src="'. $featured_img .'" alt="'. $post_title .'" />';
								} elseif ( $thumbnail_link == 'lightbox' ) {
									$output .= '<a href="'. $featured_img_url .'" title="'. $post_title .'" class="vcex-caroufredsel-entry-img wpex-lightbox">';
										$output .= '<img src="'. $featured_img .'" alt="'. $post_title .'" />';
									$output .= '</a><!-- .vcex-caroufredsel-entry-img -->';
								} else {
									$output .= '<a href="'. $url .'" title="'. $post_title .'" class="vcex-caroufredsel-entry-img">';
										$output .= '<img src="'. $featured_img .'" alt="'. $post_title .'" />';
									$output .= '</a><!-- .vcex-caroufredsel-entry-img -->';
								}
							$output .= '</div>';
						}
						
						if ( $details == 'true') {
						
							$output .= '<div class="vcex-caroufredsel-entry-details">';
								
								$output .= '<div class="vcex-caroufredsel-entry-title"><a href="'. $url .'" title="'. $post_title .'">'. $post_title .'</a></div>';
							
								if ( $product_price ) {
									$output .= '<div class="vcex-caroufredsel-entry-price">';
										$output .= $product_price;
									$output .= '</div>';
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
					$output .= '<div id="prev-'. $rand_num .'" class="vcex-caroufredsel-prev theme-button"><span class="fa fa-chevron-left"></span></div><div id="next-'. $rand_num .'" class="vcex-caroufredsel-next theme-button"><span class="fa fa-chevron-right"></span></div>';
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
add_shortcode("vcex_woocommerce_carousel", "vcex_woocommerce_carousel_shortcode");

/**
 * Adds the woocommerce carousel shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_woocommerce_carousel_shortcode_vc_map' ) ) {
	function vcex_woocommerce_carousel_shortcode_vc_map() {
		vc_map( array(
			'name'					=> __( "WooCommerce Carousel", 'wpex' ),
			'description'			=> __( "Recent WooCommerce products carousel", 'wpex' ),
			'base'					=> "vcex_woocommerce_carousel",
			'class'					=> "vcex_woocommerce_carousel",
			'icon' 					=> "icon-wpb-vcex-woocommerce_carousel",
			'category'				=> WPEX_THEME_BRANDING,
			'params'				=> array(
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Unique Id", 'wpex' ),
					"param_name"	=> "unique_id",
					"value"			=> "",
					"description"	=> __( "You can enter a unique ID here for styling purposes.", 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Category", 'wpex' ),
					"param_name"	=> "term_slug",
					"admin_label"	=> true,
					"value"			=> "all",
					"description"	=> __( "Enter a category slug to limit your posts.", 'wpex' ),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Post Count", 'wpex' ),
					"param_name"	=> "count",
					"value"			=> "8",
					//"description"	=> __( "How many items do you wish to show.", 'wpex' ),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Order", 'wpex' ),
					"param_name"	=> "order",
					//"description"	=> sprintf( __( 'Designates the ascending or descending order. More at %s.', 'wpex' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
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
					//"description"	=> sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'wpex' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex</a>' ),
					"value"			=> array(
						__( "Date", "wpex")				=> "date",
						__( "Name", "wpex" )				=> "name",
						__( "Modified", "wpex")			=> "modified",
						__( "Author", "wpex" )			=> "author",
						__( "Random", "wpex")				=> "rand",
						__( "Comment Count", "wpex" )	=> "comment_count",
					),
					'group'			=> __( 'Query', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Slide Width", 'wpex' ),
					"param_name"	=> "item_width",
					"value"			=> "230",
					"description"	=> __('The width of each slide in pixels.','wpex')
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Min Slides", 'wpex' ),
					"param_name"	=> "min_slides",
					"value"			=> "1",
					"description"	=> __('The minimum number of slides to be shown.','wpex'),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Max Slides", 'wpex' ),
					"param_name"	=> "max_slides",
					"value"			=> "4",
					"description"	=> __('The maximum number of slides to be shown.','wpex'),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Items To Scroll", 'wpex' ),
					"param_name"	=> "items_scroll",
					"value"			=> "page",
					"description"	=> __('The number of items to scroll at a time. Enter "page" to scroll to the first item of the previous/next "page".','wpex'),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Auto Play", 'wpex' ),
					"param_name"	=> "auto_play",
					"value"			=> array(
						 __( "True", "wpex" )	=> "true",
						 __( "False", "wpex")	=> "false",
					),
					"description"	=> __('Determines whether the carousel should scroll automatically or not.','wpex'),
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
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __('Timeout Duration (in milliseconds)', 'wpex'),
					"param_name"	=> "timeout_duration",
					"value"			=> "5000",
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Style", 'wpex' ),
					"param_name"	=> "style",
					"value"			=> array(
						__( "Default", "wpex")		=> "default",
						__( "No Margins", "wpex" )	=> "no-margins",
					),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Display Arrows?", 'wpex' ),
					"param_name"	=> "arrows",
					"value"			=> array(
						__( "True", "wpex" )	=> "true",
						__( "False", "wpex")	=> "false",
					),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Image Links To", 'wpex' ),
					"param_name"	=> "thumbnail_link",
					"value"			=> array(
						__( "Post", "wpex")		=> "post",
						__( "Lightbox", "wpex" )	=> "lightbox",
						__( "None", "wpex" )		=> "none",
					),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Image Width", 'wpex' ),
					"param_name"	=> "img_width",
					"value"			=> "500",
					"description"	=> __( "Enter a width in pixels.", 'wpex' ),
					"dependency"	=> Array('element'	=> "img_crop", 'value' => "true" ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Image Height", 'wpex' ),
					"param_name"	=> "img_height",
					"value"			=> "350",
					"description"	=> __( 'Enter a height in pixels. Set to "9999" to disable vertical cropping and keep image proportions.', 'wpex' ),
					"dependency"	=> Array('element'	=> "img_crop", 'value' => "true" ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Display Details", 'wpex' ),
					"param_name"	=> "details",
					"value"			=> array(
						__( "True", "wpex")	=> "true",
						__( "False", "wpex" )	=> "false",
					),
					'group'			=> __( 'Design', 'wpex' ),
				),
			)
		) );
	}
}
add_action( 'init', 'vcex_woocommerce_carousel_shortcode_vc_map' );
<?php
/**
 * Registers the image carousel shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if( !function_exists( 'vcex_image_carousel_shortcode' ) ) {

	function vcex_image_carousel_shortcode($atts) {
		
		// Define shortcode params
		extract( shortcode_atts( array(
			'unique_id'				=> '',
			'style'					=> 'default',
			'image_ids'				=> '',
			'item_width'			=> '400',
			'timeout_duration'		=> '5000',
			'min_slides'			=> '1',
			'max_slides'			=> '4',
			'infinite_loop'			=> 'true',
			'items_scroll'			=> 'page',
			'animation'				=> 'CSS',
			'auto_play'				=> 'false',
			'arrows'				=> 'true',
			'thumbnail_link'		=> 'lightbox',
			'custom_links'			=> '',
			'custom_links_target'	=> '_self',
			'img_width'				=> '9999',
			'img_height'			=> '9999',
			'title'					=> 'true',
			'img_filter'			=> 'true',
			'rounded_image'			=> '',
			'img_hover_style'		=> '',
			'img_rendering'			=> '',
		), $atts ) );
			
		// Front-end composer check
		if ( function_exists('vc_is_inline') && vc_is_inline() ) {
			$is_vcfe = true;
		} else {
			$is_vcfe = false;
		}
		
		// Define Output var
		$output = '';

		// Get Attachments
		$images = explode(",",$image_ids);
		$images = array_combine($images,$images);

		// Dummy Images
		$dummy_images = NULL;
		if ( empty($image_ids) ) {
			$dummy_images = true;
			$images = array(
				WPEX_VCEX_DIR_URI .'assets/images/dummy1.jpg',
				WPEX_VCEX_DIR_URI .'assets/images/dummy2.jpg',
				WPEX_VCEX_DIR_URI .'assets/images/dummy3.jpg',
				WPEX_VCEX_DIR_URI .'assets/images/dummy4.jpg',
				WPEX_VCEX_DIR_URI .'assets/images/dummy5.jpg',
				WPEX_VCEX_DIR_URI .'assets/images/dummy6.jpg'
			);
		}
		
		// Classes
		$img_classes = array();
		if ( $rounded_image == 'yes' ) {
			$img_classes[] = 'vcex-rounded-images';
		}
		if ( $img_filter ) {
			$img_classes[] = 'vcex-'. $img_filter;
		}
		if ( $img_hover_style ) {
			$img_classes[] = ' vcex-img-hover-parent vcex-img-hover-'. $img_hover_style;
		}
		$img_classes = implode(' ', $img_classes);
		
		// Custom Links
		if ( $thumbnail_link == 'custom_link' ) {
			$custom_links = explode( ',', $custom_links);
		}
		
		//Output images
		if( $images ) :
		
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
				$unique_id = $unique_id ? ' id="'. $unique_id .'"' : NULL;

				// Main Classes
				$main_classes = 'vcex-caroufredsel-wrap clr vcex-caroufredsel-portfolio';
				if ( $style ) {
					$main_classes .= ' vcex-caroufredsel-'. $style;
				}
				if ( ! $is_vcfe ) {
					$main_classes .= ' vcex-caroufredsel-loading';
				}

				// Carousel Classes
				$carousel_classes = 'vcex-caroufredsel';
				if ( $img_rendering ) {
					$carousel_classes = ' vcex-image-rendering-'. $img_rendering;
				}
				if ( 'lightbox' == $thumbnail_link ) {
					$carousel_classes .= ' vcex-gallery-lightbox ';
				}
			
				// Main wrapper div
				$output .= '<div class="'. $main_classes.'" '. $unique_id .' >';
					
					$output .= '<div class="'. $carousel_classes .'"><ul id="'. $unique_carousel_id .'">';
				
					// Loop through images
					$count=-1;
					foreach ( $images as $attachment ) :
					$count++;
					
						// Attachment VARS
						$attachment_link = get_post_meta( $attachment, '_wp_attachment_url', true );
						$attachment_img_url = wp_get_attachment_url( $attachment );
						$attachment_alt = strip_tags( get_post_meta($attachment, '_wp_attachment_image_alt', true) );
						$attachment_title = get_the_title($attachment);
						$attachment_caption = esc_attr( get_post_field( 'post_excerpt', $attachment ) );
						
						// Get and crop image if needed
						if ( $dummy_images ) {
							$attachment_img = $attachment;
						} else {
							$attachment_img = wp_get_attachment_url( $attachment );
							$img_width = intval($img_width);
							$img_height = intval($img_height);
							$crop = $img_height == '9999' ? false : true;
							$attachment_img = wpex_image_resize( $attachment_img, $img_width, $img_height, $crop );
						}
						
						// Image output
						$image_output = '<img src="'. $attachment_img .'" alt="'. $attachment_alt .'" />';
			
						// Carousel item start
						$output .= '<li class="vcex-caroufredsel-slide">';
						
							// Media Wrap
							$output .= '<div class="vcex-caroufredsel-entry-media '. $img_classes .'">';
							
								if ( 'lightbox' == $thumbnail_link ) {
									$output .= '<a href="'. $attachment_img_url .'" title="'. $attachment_caption .'" class="vcex-caroufredsel-entry-img">';
										$output .= $image_output;
									$output .= '</a><!-- .vcex-caroufredsel-entry-img -->';
								} elseif ( 'custom_link' == $thumbnail_link ) {
									$custom_link = !empty($custom_links[$count]) ? $custom_links[$count] : '#';
									if ( $custom_link == '#' ) {
										$output .= $image_output;
									} else {
										$output .= '<a href="'. $custom_link .'" title="'. $attachment_alt .'" class="vcex-caroufredsel-entry-img" target="'. $custom_links_target .'">';
											$output .= $image_output;
										$output .= '</a>';
									}
								} else {
									$output .= $image_output;
								}
								
							$output .= '</div>';
								
							if ( $title == 'yes' && $attachment_title ) {
								$output .= '<div class="vcex-caroufredsel-entry-title">'. $attachment_title .'</div>';
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
		
			endif; // End has images check
		
		// Reset query
		wp_reset_postdata();

		// Return data
		return $output;
		
	}
}
add_shortcode("vcex_image_carousel", "vcex_image_carousel_shortcode");

/**
 * Adds the image carousel shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_image_carousel_shortcode_vc_map' ) ) {
	function vcex_image_carousel_shortcode_vc_map() {
	$vc_img_rendering_url = 'https://developer.mozilla.org/en-US/docs/Web/CSS/image-rendering';
		vc_map( array(
			"name"					=> __( "Image Carousel", 'wpex' ),
			"description"			=> __( "Image based jQuery carousel.", 'wpex' ),
			"base"					=> "vcex_image_carousel",
			"class"					=> '',
			'category'				=> WPEX_THEME_BRANDING,
			'admin_enqueue_js'		=> '',
			'admin_enqueue_css'		=> '',
			"icon" 					=> "icon-wpb-vcex-image_carousel",
			"params"				=> array(
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Unique Id", 'wpex' ),
					"param_name"	=> "unique_id",
					"value"			=> '',
					//"description"	=> __( "You can enter a unique ID here for styling purposes.", 'wpex' ),
				),
				array(
					"type"			=> "attach_images",
					"admin_label"	=> true,
					"heading"		=> __( "Attach Images", 'wpex' ),
					"param_name"	=> "image_ids",
					//"description"	=> __( "Select the images to include in your carousel.", 'wpex' ),
					'group'			=> __( 'Gallery', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Style", 'wpex' ),
					"param_name"	=> "style",
					"value"			=> array(
						__( "Default", 'wpex' )		=> "default",
						__( "No Margins", "wpex" )	=> "no-margins",
					),
					//"description"	=> __( "Select your carousel style.", 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Slide Width", 'wpex' ),
					"param_name"	=> "item_width",
					"value"			=> "230px",
					"description"	=> __('The width of each slide in pixels. This is used to calculate the min and max items for responsiveness. It is basic math, figure out how many items you want to display, subtract the margins (20px between each item) and you will get your item width, increase this value to display larger items on smaller devices.','wpex'),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Min Slides", 'wpex' ),
					"param_name"	=> "min_slides",
					"value"			=> "1",
					"description"	=> __('The minimum number of slides to be shown.','wpex'),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Max Slides", 'wpex' ),
					"param_name"	=> "max_slides",
					"value"			=> "4",
					"description"	=> __('The maximum number of slides to be shown.','wpex'),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Items To Scroll", 'wpex' ),
					"param_name"	=> "items_scroll",
					"value"			=> "page",
					"description"	=> __('The number of items to scroll at a time. Enter "page" to scroll to the first item of the previous/next "page".','wpex'),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Auto Play", 'wpex' ),
					"param_name"	=> "auto_play",
					"value"			=> array(
						__( "True", "wpex" )	=> "true",
						__( "False", 'wpex' )	=> "false",
					),
					"description"	=> __('Determines whether the carousel should be infinite.','wpex'),
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
					"heading"		=> __('Timeout Duration (in milliseconds)', 'wpex'),
					"param_name"	=> "timeout_duration",
					"value"			=> "5000",
					"dependency"	=> Array(
						'element'	=> "auto_play",
						'value'		=> "true"
					),
					"description"	=> __('The amount of milliseconds the carousel will pause.','wpex'),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Display Arrows?", 'wpex' ),
					"param_name"	=> "arrows",
					"value"			=> array(
						__( "True", "wpex" )	=> "true",
						__( "False", 'wpex' )	=> "false",
					),
					//"description"	=> __( "Display the next and previous arrows?", 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Image Link", 'wpex' ),
					"param_name"	=> "thumbnail_link",
					"value"			=> array(
						__( "None", "wpex" )			=> "none",
						__( "Lightbox", "wpex" )		=> "lightbox",
						__( "Custom Links", "wpex" )	=> "custom_link",
					),
					//"description"	=> __( "Where should the carousel images link to?", 'wpex' ),
					'group'			=> __( 'Links', 'wpex' ),
				),
				array(
					"type"			=> "exploded_textarea",
					"heading"		=> __("Custom links", 'wpex' ),
					"param_name"	=> "custom_links",
					"description"	=> __('Enter links for each slide here. Divide links with linebreaks (Enter). For images without a link enter a # symbol. And don\'t forget to include the http:// at the front.', 'wpex'),
					"dependency"	=> Array(
						'element'	=> "thumbnail_link",
						'value'		=> array( 'custom_link' )
					),
					'group'			=> __( 'Links', 'wpex' ),
				),
				array(
				"type"				=> "dropdown",
				"heading"			=> __("Custom link target", 'wpex' ),
				"param_name"		=> "custom_links_target",
				"description"		=> __('Select where to open custom links.', 'wpex'),
				"dependency"		=> Array('
					element'	=> "thumbnail_link",
					'value'		=> array( 'custom_link' )
				),
				"value"				=> array(
						__("Same window", 'wpex' ) => "_self",
						__("New window", 'wpex' ) => "_blank"
					),
				'group'			=> __( 'Links', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Image Crop Width", 'wpex' ),
					"param_name"	=> "img_width",
					"value"			=> "500",
					//"description"	=> __( "Enter a width in pixels.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Image Crop Height", 'wpex' ),
					"param_name"	=> "img_height",
					"value"			=> "500",
					"description"	=> __( 'Enter a height in pixels. Set to "9999" to disable vertical cropping and keep image proportions.', 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "checkbox",
					"heading"		=> __( "Rounded Image?", 'wpex' ),
					"param_name"	=> "rounded_image",
					"value"			=> Array(
						__("Yes please.", 'wpex' )	=> 'yes'
					),
					//"description"	=> __( "Check box to display rounded images. For truely rounded images make sure your images are cropped to the same width and height.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Image Rendering", 'wpex' ),
					"param_name"	=> "img_rendering",
					"value"			=> vcex_image_rendering(),
					//"description"	=> sprintf( __( 'Image-rendering CSS property provides a hint to the user agent about how to handle its image rendering. For example when scaling down images they tend to look a bit fuzzy in Firefox, setting image-rendering to crisp-edges can help make the images look better. <a href="%s">Learn more</a>.', 'wpex' ), esc_url( $vc_img_rendering_url ) ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Image Filter", 'wpex' ),
					"param_name"	=> "img_filter",
					"value"			=> vcex_image_filters(),
					//"description"	=> __( "Select an image filter style.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "CSS3 Image Hover", 'wpex' ),
					"param_name"	=> "img_hover_style",
					"value"			=> vcex_image_hovers(),
					//"description"	=> __("Select your preferred image hover effect. Please note this will only work if the image links to a URL or a large version of itself. Please note these effects may not work in all browsers.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "checkbox",
					"heading"		=> __( 'Display Title', 'wpex' ),
					"param_name"	=> "title",
					"value"			=> Array(
						__("Yes please.", 'wpex' )	=> 'yes'
					),
					//"description"	=> __( "Check box to display your image titles.", 'wpex' ),
					'group'			=> __( 'Title', 'wpex' ),
				),
			)
		) );
	}
}
add_action( 'init', 'vcex_image_carousel_shortcode_vc_map' );
<?php
/**
 * Registers the image grid shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if( !function_exists( 'vcex_image_grid_shortcode' ) ) {
	function vcex_image_grid_shortcode( $atts ) {
		
		// Define shortcode params
		extract( shortcode_atts( array(
			'unique_id'				=> '',
			'columns'				=> '4',
			'image_ids'				=> '',
			'img_filter'			=> 'true',
			'grid_style'			=> '',
			'rounded_image'			=> '',
			'thumbnail_link'		=> 'lightbox',
			'custom_links'			=> '',
			'custom_links_target'	=> '_self',
			'img_width'				=> '9999',
			'img_height'			=> '9999',
			'title'					=> 'true',
			'title_type'			=> 'title',
			'img_hover_style'		=> '',
			'img_rendering'			=> '',
		), $atts ) );

		// Start output buffer
		ob_start();
		
			// Define output var
			$output = '';
			
			// Get Attachments
			$images = explode( ",",$image_ids );
			$images = array_combine( $images, $images );

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

			//Output posts
			if( $images ) :

				// Custom Links
				if ( 'custom_link' == $thumbnail_link ) {
					$custom_links = explode( ',', $custom_links );
				}

				// Is Isotope var
				if ( 'masonry' == $grid_style ) {
					$is_isotope = true;
				} else {
					$is_isotope = false;
				}

				// No margins style
				if ( 'no-margins' == $grid_style ) {
					$is_isotope = false;
				}
			
				// Set correct grid class
				$col_class = '';
				if ( $grid_style == 'no-margins' ) {
					if ( $columns == '1' ) $columns = 'full-width';
					if ( $columns == '2' ) $columns = 'one-half';
					if ( $columns == '3' ) $columns = 'one-third';
					if ( $columns == '4' ) $columns = 'one-fourth';
					if ( $columns == '5' ) $columns = 'one-fifth';
					if ( $columns == '6' ) $columns = 'one-sixth';
				} else {
					if ( $columns == '1' ) $columns = 'span_1_of_1';
					if ( $columns == '2' ) $columns = 'span_1_of_2';
					if ( $columns == '3' ) $columns = 'span_1_of_3';
					if ( $columns == '4' ) $columns = 'span_1_of_4';
					if ( $columns == '5' ) $columns = 'span_1_of_5';
					if ( $columns == '6' ) $columns = 'span_1_of_6';
				}
			
				// Unique ID
				$unique_id = ( !empty($unique_id) ) ? $unique_id : 'vcex-image-grid-'. rand(1, 100);

				// Grid wrap classes
				$wrap_classes = 'vcex-image-grid clr';
				$wrap_classes .= ' grid-style-'. $grid_style;
				if ( 'no-margins' != $grid_style ) {
					$wrap_classes .= ' wpex-row';
				}
				// Isotope classes
				if ( $is_isotope ) {
					$wrap_classes .= ' vcex-isotope-grid';
				}
				// No margins grid
				if ( 'no-margins' == $grid_style ) {
					$wrap_classes .= ' vcex-no-margin-grid';
				}
				// Image rendering
				if ( $img_rendering ) {
					$wrap_classes .= ' vcex-image-rendering-'. $img_rendering;
				}
				// Lightbox Class
				if ( $thumbnail_link == 'lightbox' ) {
					$wrap_classes .= ' vcex-gallery-lightbox';
				}

				// Output script for inline JS for the Visual composer front-end builder
				if ( function_exists( 'vcex_front_end_grid_js' ) ) {
					if ( $is_isotope ) {
						vcex_front_end_grid_js( 'isotope' );
					} elseif ( 'no-margins' == $grid_style ) {
						vcex_front_end_grid_js( 'masonry' );
					}
				} ?>

				<div class="<?php echo $wrap_classes; ?>" id="<?php echo $unique_id; ?>">
					
					<?php
					$count=0;
					// Loop through images
					$count2=-1;
					foreach ( $images as $attachment ) :
					$count++;
						$count2++;

						// Figure Classes
						$entry_classes = $columns;
						// Rounded Images
						if ( 'yes' == $rounded_image ) {
							$entry_classes .= ' vcex-rounded-images';
						}
						// Isotope
						if ( $is_isotope ) {
							$entry_classes .= ' vcex-isotope-entry';
						}
						// No margins grid
						if ( 'no-margins' == $grid_style ) {
							$entry_classes .= ' vcex-no-margin-entry';
						}

						// Attachment VARS
						$attachment_link = get_post_meta( $attachment, '_wp_attachment_url', true );
						$attachment_alt = strip_tags( get_post_meta($attachment, '_wp_attachment_image_alt', true) );

						// Get and crop image if needed
						if ( $dummy_images ) {
							$cropped_image_url = $attachment_img_url = $attachment;
							$cropped_image_width = '';
							$cropped_image_height = '';
						} else {
							$attachment_img_url = wp_get_attachment_url( $attachment );
							$img_width = intval($img_width);
							$img_height = intval($img_height);
							$crop = $img_height == '9999' ? false : true;
							$cropped_image = wpex_image_resize( $attachment_img_url, $img_width, $img_height, $crop, 'array' );
							$cropped_image_url = $cropped_image['url'];
							$cropped_image_width = $cropped_image['width'];
							$cropped_image_height = $cropped_image['height'];
						}
						// Filter class
						$img_filter_class = $img_filter ? 'vcex-'. $img_filter : '';

						// Image hover styles
						$img_hover_style_class = $img_hover_style ? 'vcex-img-hover-parent vcex-img-hover-'. $img_hover_style : ''; ?>

						<figure class="vcex-image-grid-entry col <?php echo $entry_classes; ?> col-<?php echo $count; ?>">
							<div class="vcex-image-grid-entry-img <?php echo $img_filter_class; ?> <?php echo $img_hover_style_class; ?>">
								<?php
								// Lightbix
								if ( 'lightbox' == $thumbnail_link ) { ?>
									<a href="<?php echo $attachment_img_url; ?>" title="<?php echo $attachment_alt; ?>" class="vcex-image-grid-entry-img">
										<img src="<?php echo $cropped_image_url; ?>" alt="<?php echo $attachment_alt; ?>" width="<?php echo $cropped_image_width; ?>" height="<?php echo $cropped_image_height; ?>" />
									</a><!-- .vcex-image-grid-entry-img -->
								<?php
								}
								// Custom Links
								elseif ( 'custom_link' == $thumbnail_link ) {
									$custom_link = !empty($custom_links[$count2]) ? $custom_links[$count2] : '#';
									if ( '#' == $custom_link ) { ?>
										<img src="<?php echo $cropped_image_url; ?>" alt="<?php echo $attachment_alt; ?>" width="<?php echo $cropped_image_width; ?>" height="<?php echo $cropped_image_height; ?>" />
									<?php } else { ?>
										<a href="<?php echo esc_url( $custom_link ); ?>" title="<?php echo $attachment_alt; ?>" class="vcex-image-grid-entry-img" target="<?php echo $custom_links_target; ?>">
											<img src="<?php echo $cropped_image_url; ?>" alt="<?php echo $attachment_alt; ?>" width="<?php echo $cropped_image_width; ?>" height="<?php echo $cropped_image_height; ?>" />
										</a>
									<?php }
								}
								// Just the Image
								else { ?>
									<img src="<?php echo $cropped_image_url; ?>" alt="<?php echo $attachment_alt; ?>" width="<?php echo $cropped_image_width; ?>" height="<?php echo $cropped_image_height; ?>" />
								<?php }
								// Display title
								if ( 'yes' == $title ) {
									// Title
									if ( 'title' == $title_type ) {
										$attachment_title = get_the_title( $attachment );
										if ( $attachment_title ) {
											echo '<figcaption class="vcex-image-grid-entry-title">'. $attachment_title .'</figcaption>';
										}
									}
									// Alt
									elseif ( 'alt' == $title_type && $attachment_alt ) {
										echo '<figcaption class="vcex-image-grid-entry-title">'. $attachment_alt .'</figcaption>';
									}
									// caption
									elseif ( 'caption' == $title_type ) {
										$attachment_caption = get_post_field( 'post_excerpt', $attachment );
										if ( $attachment_caption ) {
											echo '<figcaption class="vcex-image-grid-entry-title">'. $attachment_caption .'</figcaption>';
										}
									}
									// Description
									elseif ( 'description' == $title_type ) {
										$attachment_description = get_post_field( 'post_content', $attachment );
										if ( $attachment_description ) {
											echo '<figcaption class="vcex-image-grid-entry-title">'. apply_filters( 'the_content', $attachment_description ) .'</figcaption>';
										}
									}
								} ?>
							</div>
						</figure>
						
						<?php
						// Clear counter
						if ( $count == $columns ) {
							$count = 0;
						}
					
					// End foreach loop
					endforeach; ?>

				</div>
			
			<?php
			// End has posts check
			endif;
		
			// Reset query
			wp_reset_postdata();

		// Return data
		return ob_get_clean();
		
	}
}
add_shortcode( 'vcex_image_grid', 'vcex_image_grid_shortcode' );

/**
 * Adds the image grid shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_image_grid_shortcode_vc_map' ) ) {
	function vcex_image_grid_shortcode_vc_map() {
		$vc_img_rendering_url = 'https://developer.mozilla.org/en-US/docs/Web/CSS/image-rendering';
		vc_map( array(
			"name"					=> __( "Image Grid", 'wpex' ),
			"description"			=> __( "Responsive image gallery", 'wpex' ),
			"base"					=> "vcex_image_grid",
			"class"					=> '',
			'admin_enqueue_js'		=> '',
			'admin_enqueue_css'		=> '',
			"icon" 					=> "icon-wpb-vcex-image_grid",
			'category'				=> WPEX_THEME_BRANDING,
			"params"				=> array(
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Unique Id", 'wpex' ),
					'param_name'	=> "unique_id",
					'value'			=> '',
					//"description"	=> __( "You can enter a unique ID here for styling purposes.", 'wpex' ),
				),
				array(
					'type'			=> "attach_images",
					"admin_label"	=> true,
					'heading'		=> __( "Attach Images", 'wpex' ),
					'param_name'	=> "image_ids",
					//"description"	=> __( "Attach images to your post.", 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "Grid Style", 'wpex' ),
					'param_name'	=> "grid_style",
					'value'			=> array(
						__( 'Fit Rows', 'wpex' )	=> 'default',
						__( 'Masonry', 'wpex' )		=> 'masonry',
						__( 'No Margins', 'wpex' )	=> 'no-margins',
					),
					//"description"	=> __( "Select your grid style.", 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "Columns", 'wpex' ),
					'param_name'	=> "columns",
					'value' 		=> array(
						__('Six','wpex')	=> '6',
						__('Five','wpex')	=> '5',
						__('Four','wpex')	=> '4',
						__('Three','wpex')	=> '3',
						__('Two','wpex')	=> '2',
						__('One','wpex')	=> '1',
					),
					//"description"	=> __( "How many columns for your grid?", 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "Display Title", 'wpex' ),
					'param_name'	=> "title",
					'value'			=> array(
						__( 'No', 'wpex' )	=> '',
						__( 'Yes', 'wpex' )	=> 'yes'
					),
					"description"	=> __( "Note: The title will only display on some grid styles. For example the grid without margins will not display the title.", 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "Title Based On Image", 'wpex' ),
					'param_name'	=> "title_type",
					'value'			=> array(
						__( 'Title', 'wpex' )		=> 'title',
						__( 'Alt', 'wpex' )			=> 'alt',
						__( 'Caption', 'wpex' )		=> 'caption',
						__( 'Description', 'wpex' )	=> 'description',
					),
					"description"	=> __( "Note: The title will only display on some grid styles. For example the grid without margins will not display the title.", 'wpex' ),
					'group'			=> __( 'Design', 'wpex' ),
					"dependency"	=> Array(
						'element'	=> 'title',
						'value'		=> array( 'yes' )
					),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "Image Link", 'wpex' ),
					'param_name'	=> "thumbnail_link",
					'value'			=> array(
						__( "None", "wpex" )			=> "none",
						__( "Lightbox", "wpex" )		=> "lightbox",
						__( "Custom Links", "wpex" )	=> "custom_link",
					),
					//"description"	=> __( "Where should the grid images link to?", 'wpex' ),
					'group'			=> __( 'Links', 'wpex' ),
				),
				array(
					'type'			=> "exploded_textarea",
					'heading'		=> __("Custom links", 'wpex' ),
					'param_name'	=> "custom_links",
					"description"	=> __('Enter links for each slide here. Divide links with linebreaks (Enter). For images without a link enter a # symbol. And don\'t forget to include the http:// at the front.', 'wpex'),
					"dependency"	=> Array(
						'element'	=> "thumbnail_link",
						'value'		=> array( 'custom_link' )
					),
					'group'			=> __( 'Links', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __("Custom link target", 'wpex' ),
					'param_name'	=> "custom_links_target",
					//"description"	=> __('Select where to open  custom links.', 'wpex'),
					"dependency"	=> Array(
						'element'	=> "thumbnail_link",
						'value'		=> array('custom_link')
					),
					'value'			=> array(
						__("Same window", 'wpex' )	=> "_self",
						__("New window", 'wpex' )	=> "_blank"
					),
					'group'			=> __( 'Links', 'wpex' ),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Image Crop Width", 'wpex' ),
					'param_name'	=> "img_width",
					'value'			=> "9999",
					//"description"	=> __( "Enter a width in pixels.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Image Crop Height", 'wpex' ),
					'param_name'	=> "img_height",
					'value'			=> "9999",
					"description"	=> __( 'Enter a height in pixels. Set to "9999" to disable vertical cropping and keep image proportions.', 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "Rounded Image?", 'wpex' ),
					'param_name'	=> "rounded_image",
					'value'			=> array(
						__( 'No', 'wpex' )	=> '',
						__( 'Yes', 'wpex' )	=> 'yes'
					),
					//"description"	=> __( "Check box to display rounded images. For truely rounded images make sure your images are cropped to the same width and height.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "Image Filter", 'wpex' ),
					'param_name'	=> "img_filter",
					'value'			=> vcex_image_filters(),
					//"description"	=> __( "Select an image filter style.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "Image Rendering", 'wpex' ),
					'param_name'	=> "img_rendering",
					'value'			=> vcex_image_rendering(),
					"description"	=> sprintf( __( 'Image-rendering CSS property provides a hint to the user agent about how to handle its image rendering. For example when scaling down images they tend to look a bit fuzzy in Firefox, setting image-rendering to crisp-edges can help make the images look better. <a href="%s">Learn more</a>.', 'wpex' ), esc_url( $vc_img_rendering_url ) ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "CSS3 Image Hover", 'wpex' ),
					'param_name'	=> "img_hover_style",
					'value'			=> vcex_image_hovers(),
					"description"	=> __("Select your preferred image hover effect. Please note this will only work if the image links to a URL or a large version of itself. Please note these effects may not work in all browsers.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
			)
		) );
	}
}
add_action( 'init', 'vcex_image_grid_shortcode_vc_map' );
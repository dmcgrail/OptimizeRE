<?php
/**
 * Registers the icon box shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( !function_exists('vcex_icon_box_shortcode')) {
	function vcex_icon_box_shortcode( $atts, $content = NULL ) {
		
		extract( shortcode_atts( array(
				'unique_id'					=> '',
				'font_size'					=> '',
				'font_color'				=> '',
				'style'						=> 'one',
				'image'						=> '',
				'image_width'				=> '',
				'icon'						=> '',
				'icon_color'				=> '#000000',
				'icon_width'				=> '',
				'icon_height'				=> '',
				'icon_size'					=> '24px',
				'icon_background'			=> '',
				'icon_border_radius'		=> '',
				'heading'					=> __('Sample heading','wpex'),
				'heading_type'				=> 'h2',
				'heading_color'				=> '',
				'heading_size'				=> '',
				'heading_weight'			=> '',
				'heading_letter_spacing'	=> '',
				'heading_transform'			=> '',
				'heading_bottom_margin'		=> '',
				'container_left_padding'	=> '',
				'container_right_padding'	=> '',
				'url'						=> '',
				'url_target'				=> '',
				'url_rel'					=> '',
				'css_animation'				=> '',
				'padding'					=> '',
				'margin_bottom'				=> '',
				'el_class'					=> '',
				'alignment'					=> 'center',
		), $atts ) );

		// Turn output buffer on
		ob_start();
	
		// VARS
		$output = $container_background = '';
		$icon = $icon ? $icon : 'flag';
		$icon_size = $icon_size == '' ? '24px' : $icon_size;

		// Main Classes
		$main_classes = 'vcex-clr vcex-icon-box-'. $style .' ';
		if ( $css_animation ) {
			$css_animation_class = 'wpb_animate_when_almost_visible wpb_'. $css_animation .'';
			$main_classes .= $css_animation_class .' ';
		}
		if ( $url ) {
			$main_classes .= 'vcex-icon-box-with-link ';
		}
		if ( $el_class ) {
			$main_classes .= $el_class .' ';
		}
		if ( $alignment ) {
			$main_classes .= 'align-'. $alignment .' ';
		}
		if ( $icon_background ) {
			$main_classes .= 'with-background';
		}
		
		// Container Style
		$container_style = '';
		if ( $font_size ) {
			$container_style .= 'font-size: '. $font_size .';';
		}
		if ( $font_color ) {
			$container_style .= 'color: '. $font_color .';';
		}
		if ( 'six' == $style && $icon_background ) {
			$container_style .= 'background-color: '. $icon_background .';';
		}
		if ( 'six' == $style && $icon_color ) {
			$container_style .= 'color: '. $icon_color .';';
		}
		if ( 'one' == $style && $container_left_padding ) {
			$container_style .= 'padding-left: '. intval( $container_left_padding ) .'px;';
		}
		if ( 'seven' == $style && $container_right_padding ) {
			$container_style .= 'padding-right: '. intval( $container_right_padding ) .'px;';
		}
		if ( $margin_bottom ) {
			$container_style .= 'margin-bottom: '. intval($margin_bottom) .'px;';
		}
		if ( $padding && in_array( $style, array( 'four', 'five', 'six' ) ) ) {
			$container_style .= 'padding: '. $padding .'';
		}
		if ( '' != $container_style ) {
			$container_style = ' style="' . $container_style . '"';
		}

		// Heading Classes
		$heading_classes ='';
		if ( $heading_weight ) {
			$heading_classes .= 'font-weight-'. $heading_weight . ' ';
		}
		if ( $heading_transform ) {
			$heading_classes .= 'text-transform-'. $heading_transform;
		}
		
		// Heading Style
		$heading_style = '';
		if ( '' != $heading_color ) {
			$heading_style .= 'color: '. $heading_color .';';
		}
		if ( '' != $heading_size ) {
			$heading_size = intval( $heading_size );
			$heading_style .= 'font-size: '. $heading_size .'px;';
		}
		if ( '' != $heading_size ) {
			$heading_style .= 'letter-spacing: '. $heading_letter_spacing .';';
		}
		if ( $heading_bottom_margin ) {
			$heading_style .= 'margin-bottom: '. intval( $heading_bottom_margin ) .'px;';
		}
		if ( '' != $heading_style ) {
			$heading_style = ' style="' . $heading_style . '"';
		}
		
		//Link Style
		$link_style = '';
		if ( 'six' == $style ) {
			$link_style .= 'color:'. $icon_color .'';
		}
		if ( '' != $link_style ) {
			$link_style = ' style="' . esc_attr( $link_style ) . '"';
		}
		
		// Icon Style
		$icon_style = '';
		if ( $icon_color ) {
			$icon_style .= 'color:' . $icon_color . ';';
		}
		if ( $icon_width ) {
			$icon_style .= 'width:'. $icon_width .';';
		}
		if ( $icon_height ) {
			$icon_style .= 'height:'. $icon_height .';line-height:'. $icon_height .';';
		}
		if ( $icon_size ) {
			$icon_style .= 'font-size:' . intval( $icon_size ) . 'px;';
		}
		if ( $icon_border_radius ) {
			$icon_style .= 'border-radius:' . $icon_border_radius . ';';
		}
		if ( $icon_background ) {
			$icon_style .= 'background-color: ' . $icon_background . ';';
		}
		if ( '' != $icon_style ) {
			$icon_style = ' style="' . $icon_style . '"';
		}
		
		// Seperate icons into a couple groups for styling/html purposes
		$standard_boxes = array( 'one', 'two', 'three', 'seven' );
		$clickable_boxes = array( 'four', 'five', 'six' ); ?>

		<article class="<?php echo $main_classes; ?>" <?php echo $container_style; ?>>
			<?php
			// Open link if there is one
			if ( $url ) { ?>
				<a href="<?php echo esc_url( $url ); ?>" title="<?php echo $heading; ?>" class="vcex-icon-box-<?php echo $style; ?>-link" target="<?php echo $url_target; ?>" rel="<?php echo $url_rel; ?>" <?php echo $link_style; ?>>
			<?php }
			// Display image alternative
			if ( $image ){
				$image_url = wp_get_attachment_url( $image );
				if ( $image_width ) {
					$image_width = 'style="width:'. intval( $image_width ) .'px;"';
				} ?>
				<img class="vcex-icon-box-<?php echo $style; ?>-img-alt" src="<?php echo $image_url; ?>" alt="<?php echo $heading; ?>" <?php echo $image_width; ?> />
			<?php
			}
			// Display Icon
			else {
				// Icon Classes
				$icon_classes = 'vcex-icon-box-'. $style .'-icon vcex-icon-box-icon';
				if ( $icon_background ) {
					$icon_classes .= ' vcex-icon-box-icon-with-bg';
				}
				if ( $icon_width || $icon_height ) {
					$icon_classes .= ' no-padding';
				} ?>
				<div class="<?php echo $icon_classes; ?>" <?php echo $icon_style; ?>>
					<span class="fa fa-<?php echo $icon; ?>"></span>
				</div>
			<?php }
				
			if ( $heading ) { ?>
				<<?php echo $heading_type; ?> class="vcex-icon-box-<?php echo $style; ?>-heading <?php echo $heading_classes; ?>" <?php echo $heading_style; ?>>
					<?php echo $heading; ?>
				</<?php echo $heading_type; ?>>
			<?php
			}
			// Close link
			if ( $url && in_array( $style, $standard_boxes ) ) { ?>
				</a>
			<?php }
			// The box content
			if ( $content ) { ?>
				<div class="vcex-icon-box-<?php echo $style; ?>-content clr">
					<?php echo apply_filters( 'the_content', $content ); ?>
				</div>
			<?php }
			// Close link
			if ( $url && in_array( $style, $clickable_boxes ) ) { ?>
				</a>
			<?php } ?>
		</article>
		
		<?php
		// Return outbut buffer
		return ob_get_clean();
	}
}
add_shortcode( 'vcex_icon_box', 'vcex_icon_box_shortcode' );

/**
 * Adds the icon box shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_icon_box_shortcode_vc_map' ) ) {
	function vcex_icon_box_shortcode_vc_map() {

		vc_map( array(
			"name"					=> __( "Icon Box", 'wpex' ),
			"base"					=> "vcex_icon_box",
			'category'				=> WPEX_THEME_BRANDING,
			"icon"					=> "icon-wpb-vcex-icon_box",
			"description"			=> __( 'Content box with icon', 'wpex' ),
			'admin_enqueue_css'		=> wpex_font_awesome_css_url(),
			'front_enqueue_css'		=> wpex_font_awesome_css_url(),
			"params"				=> array(
				array(
					'type'			=> 'textfield',
					'heading'		=> __( 'Extra class name', 'wpex' ),
					'param_name'	=> 'el_class',
					'description'	=> __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'wpex' ),
				),
				array(
					'type'			=> 'textarea_html',
					'holder'		=> 'div',
					'heading'		=> __( 'Content', 'wpex' ),
					'param_name'	=> 'content',
					'value'			=> __( 'Don\'t forget to change this dummy text in your page editor for this lovely icon box.', 'wpex' ),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Content Font Size", 'wpex' ),
					'param_name'	=> "font_size",
				),
				array(
					'type'			=> 'colorpicker',
					'heading'		=> __( "Content Font Color", 'wpex' ),
					'param_name'	=> "font_color",
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __("CSS Animation", "wpex"),
					'param_name'	=> "css_animation",
					'value'			=> array(
						__( "No", "wpex" )					=> '',
						__( "Top to bottom", "wpex" )		=> "top-to-bottom",
						__( "Bottom to top", "wpex" )		=> "bottom-to-top",
						__( "Left to right", "wpex" )		=> "left-to-right",
						__( "Right to left", "wpex" )		=> "right-to-left",
						__( "Appear from center", "wpex" )	=> "appear"
					),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "Icon Box Style", 'wpex' ),
					'param_name'	=> "style",
					'value'			=> array(
						__( "Left Icon", "wpex")									=> "one",
						__( "Right Icon", "wpex")									=> "seven",
						__( "Top Icon", "wpex" )									=> "two",
						__( "Top Icon & Background", "wpex" )						=> "three",
						__( "Outlined & Top Icon", "wpex" )							=> "four",
						__( "Boxed & Top Icon", "wpex" )							=> "five",
						__( "Boxed & Top Icon & Custom Background Color", "wpex" )	=> "six",
					),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( 'Alignment', 'wpex' ),
					'param_name'	=> "alignment",
					'group'			=> __( 'Design', 'wpex' ),
					'dependency'	=> Array(
						'element'	=> "style",
						'value'		=> array( 'two' ),
					),
					'value'			=> array(
						__( "Center", "wpex")	=> "center",
						__( "Left", "wpex" )	=> "left",
						__( "Right", "wpex" )	=> "right",
					),
				),

				// Icon
				array(
					'type'			=> 'vcex_icon',
					'heading'		=> __( "Icon", 'wpex' ),
					'param_name'	=> 'icon',
					'value'			=> wpex_get_awesome_icons(),
					'group'			=> __( 'Icon', 'wpex' ),
				),
				array(
					'type'			=> "attach_image",
					'heading'		=> __( "Icon Image Alternative", "wpex" ),
					'param_name'	=> "image",
					'group'			=> __( 'Icon', 'wpex' ),
				),
				array(
					'type'			=> "textfield",
					'heading'		=> __( "Icon Image Alternative Width", "wpex" ),
					'param_name'	=> "image_width",
					'group'			=> __( 'Icon', 'wpex' ),
					'dependency'	=> Array(
						'element'	=> "image",
						'not_empty'	=> true,
					),
				),
				array(
					'type'			=> 'colorpicker',
					'heading'		=> __( "Icon Color", 'wpex' ),
					'param_name'	=> "icon_color",
					'value'			=> "#000000",
					'group'			=> __( 'Icon', 'wpex' ),
				),
				array(
					'type'			=> 'colorpicker',
					'heading'		=> __( "Icon Background", 'wpex' ),
					'param_name'	=> "icon_background",
					'group'			=> __( 'Icon', 'wpex' ),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Icon Border Radius", 'wpex' ),
					'param_name'	=> "icon_border_radius",
					'group'			=> __( 'Icon', 'wpex' ),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Icon Size In Pixels", 'wpex' ),
					'param_name'	=> "icon_size",
					'value'			=> "24px",
					'group'			=> __( 'Icon', 'wpex' ),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Fixed Icon Width", 'wpex' ),
					'param_name'	=> "icon_width",
					'value'			=> "",
					'group'			=> __( 'Icon', 'wpex' ),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Fixed Icon Height", 'wpex' ),
					'param_name'	=> "icon_height",
					'value'			=> "",
					'group'			=> __( 'Icon', 'wpex' ),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Container Left Padding", 'wpex' ),
					'param_name'	=> "container_left_padding",
					'group'			=> __( 'Design', 'wpex' ),
					'dependency'	=> Array(
						'element'	=> "style",
						'value'		=> array( 'one' )
					),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Container Right Padding", 'wpex' ),
					'param_name'	=> "container_right_padding",
					'group'			=> __( 'Design', 'wpex' ),
					'dependency'	=> Array(
						'element'	=> "style",
						'value'		=> array( 'seven' )
					),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Heading", 'wpex' ),
					'param_name'	=> 'heading',
					'value'			=> "Sample Heading",
					'group'			=> __( 'Heading', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "Heading Type", 'wpex' ),
					'param_name'	=> "heading_type",
					'value'		=> array(
						__("h2", "wpex")	=> "h2",
						__("h3", "wpex")	=> "h3",
						__("h4", "wpex")	=> "h4",
						__("h5", "wpex")	=> "h5",
					),
					'group'			=> __( 'Heading', 'wpex' ),
				),
				array(
					'type'			=> 'colorpicker',
					'heading'		=> __( "Heading Font Color", 'wpex' ),
					'param_name'	=> "heading_color",
					'group'			=> __( 'Heading', 'wpex' ),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Heading Font Size", 'wpex' ),
					'param_name'	=> "heading_size",
					'group'			=> __( 'Heading', 'wpex' ),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Heading Font Weight", 'wpex' ),
					'param_name'	=> "heading_weight",
					'group'			=> __( 'Heading', 'wpex' ),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Heading Letter Spacing", 'wpex' ),
					'param_name'	=> "heading_letter_spacing",
					'group'			=> __( 'Heading', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "Heading Text Transform", 'wpex' ),
					'param_name'	=> "heading_transform",
					'group'			=> __( 'Heading', 'wpex' ),
					'value'			=> array(
						__( 'Default', 'wpex' )		=> '',
						__( 'None', 'wpex' )		=> 'none',
						__( 'Capitalize', 'wpex' )	=> 'capitalize',
						__( 'Uppercase', 'wpex' )	=> 'uppercase',
						__( 'Lowercase', 'wpex' )	=> 'lowercase',
					),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Heading Bottom Margin", 'wpex' ),
					'param_name'	=> "heading_bottom_margin",
					'group'			=> __( 'Heading', 'wpex' ),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "URL", 'wpex' ),
					'param_name'	=> "url",
					'group'			=> __( 'URL', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "URL Target", 'wpex' ),
					'param_name'	=> "url_target",
					 'value'		=> array(
						__("Self", "wpex")	=> "_self",
						__("Blank", "wpex")	=> "_blank",
					),
					'group'			=> __( 'URL', 'wpex' ),
				),
				array(
					'type'			=> 'dropdown',
					'heading'		=> __( "URL Rel", 'wpex' ),
					'param_name'	=> "url_rel",
					'value'			=> array(
						__("None", "wpex")		=> "",
						__("Nofollow", "wpex")	=> "nofollow",
					),
					'group'			=> __( 'URL', 'wpex' ),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Padding", 'wpex' ),
					'param_name'	=> "padding",
					'group'			=> __( 'Design', 'wpex' ),
					'dependency'	=> Array(
						'element'	=> "style",
						'value'		=> array( 'four', 'five', 'six' )
					),
				),
				array(
					'type'			=> 'textfield',
					'heading'		=> __( "Bottom Margin", 'wpex' ),
					'param_name'	=> "margin_bottom",
					'group'			=> __( 'Design', 'wpex' ),
				),
			)
		) );

	}
}
add_action( 'init', 'vcex_icon_box_shortcode_vc_map' );
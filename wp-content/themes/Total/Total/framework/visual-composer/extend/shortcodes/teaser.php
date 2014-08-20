<?php
/**
 * Registers the teaser shortcode
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( !function_exists('vcex_teaser_shortcode')) {
	function vcex_teaser_shortcode( $atts, $content = NULL ) {
		
		extract( shortcode_atts( array(
				'unique_id'			=> '',
				'heading'			=> __('Sample heading','wpex'),
				'heading_type'		=> 'h2',
				'style'				=> 'one',
				'text_align'		=> 'center',
				'image'				=> '',
				'img_width'			=> '9999',
				'img_height'		=> '9999',
				'video'				=> '',
				'url'				=> '',
				'url_target'		=> '',
				'url_rel'			=> '',
				'css_animation'		=> '',
				'img_filter'		=> '',
				'img_hover_style'	=> '',
				'img_rendering'		=> '',
		), $atts ) );
		
		$output = '';
		$css_animation_classes = '';
		if ( $css_animation !== '' ) {
			$css_animation_classes = 'wpb_animate_when_almost_visible wpb_'. $css_animation .'';
		}
		
		// Image Vars
		if ( $image ) {
			$image_img_url = wp_get_attachment_url( $image );
			$image_img = wp_get_attachment_url( $image );
			$image_alt = strip_tags( get_post_meta($image, '_wp_attachment_image_alt', true) );
			$img_crop = $img_height >= '9999' ? false : true;
			$figure_classes = 'vcex-teaser-media';
			if ( $img_filter ) {
				$figure_classes .= ' vcex-'. $img_filter;
			}
			if ( $img_hover_style ) {
				$figure_classes .= ' vcex-img-hover-parent vcex-img-hover-'. $img_hover_style;
			}
			if ( $img_rendering ) {
				$figure_classes .= ' vcex-image-rendering-'. $img_rendering;
			}
		}
		
		$output .= '<article class="vcex-teaser vcex-teaser-'. $style .' vcex-text-align-'. $text_align .' '. $css_animation_classes .'">';
			if ( $video ) {
				$output .= '<div class="vcex-teaser-media vcex-video-wrap">'. wp_oembed_get($video) .'</div>';
			}
			if ( $url ) {
				$output .= '<a href="'. esc_url( $url ) .'" title="'. $heading .'" class="vcex-teaser-link" target="'. $url_target .'" rel="'. $url_rel .'">';
			}
				if ( $image ) {
					$output .= '<figure class="'. $figure_classes .'"><img src="'. wpex_image_resize( $image_img_url, intval($img_width),  intval($img_height), $img_crop ) .'" alt="'. $image_alt .'" /></figure>';
				}
			$output .= '<div class="vcex-teaser-content clr">';
				$output .= '<'. $heading_type .' class="vcex-teaser-heading">';
					$output .= $heading;
				$output .= '</'. $heading_type .'>';
				if ( $url ) {
					$output .= '</a>';
				}
				$output .= '<div class="vcex-teaser-text clr">';
					$output .= apply_filters( 'the_content', $content );
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</article>';
		
		return $output;
	}
}
add_shortcode( 'vcex_teaser', 'vcex_teaser_shortcode' );

/**
 * Adds the teaser shortcode to the Visual Composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.41
*/
if ( ! function_exists( 'vcex_teaser_shortcode_vc_map' ) ) {
	function vcex_teaser_shortcode_vc_map() {
		$vc_img_rendering_url = 'https://developer.mozilla.org/en-US/docs/Web/CSS/image-rendering';
		vc_map( array(
			"name"					=> __( "Teaser Box", 'wpex' ),
			"description"			=> __( "A teaser content box", 'wpex' ),
			"base"					=> "vcex_teaser",
			"class"					=> "",
			'category'				=> WPEX_THEME_BRANDING,
			'admin_enqueue_js'		=> "",
			'admin_enqueue_css'		=> "",
			"icon" 					=> "icon-wpb-vcex-teaser",
			"params"				=> array(
				array(
					"type"			=> "textarea_html",
					"class"			=> "",
					"holder"		=> "div",
					"heading"		=> __( "Content", 'wpex' ),
					"param_name"	=> "content",
					'value'			=> __( 'Don\'t forget to change this dummy text in your page editor for this lovely teaser box.', 'wpex' ),
					'group'			=> __( 'Content', 'wpex' ),
				),
				array(
					"type"			=> "attach_image",
					"heading"		=> __("Image", "wpex"),
					"param_name"	=> "image",
					"value"			=> "",
					//"description"	=> __("Select an image from the media library.", "wpex"),
					'group'			=> __( 'Media', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __("Video link", "wpex"),
					"param_name"	=> "video",
					"description"	=> sprintf(__('Enter a video link for a video based teaser box. More about supported formats at %s.', "wpex"), '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">WordPress codex page</a>'),
					'group'			=> __( 'Media', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __("Style", "wpex"),
					"param_name"	=> "style",
					"value"			=> array(
						__("Plain", "wpex")		=> "one",
						__("Boxed 1", "wpex")	=> "two",
						__("Boxed 2", "wpex")	=> "three",
						__("Outline", "wpex")	=> "four",
					),
					//"description"	=> __("Select a teaser box style.", "wpex"),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __("CSS Animation", "wpex"),
					"param_name"	=> "css_animation",
					"value"			=> array(
						__("No", "wpex")					=> '',
						__("Top to bottom", "wpex")			=> "top-to-bottom",
						__("Bottom to top", "wpex")			=> "bottom-to-top",
						__("Left to right", "wpex")			=> "left-to-right",
						__("Right to left", "wpex")			=> "right-to-left",
						__("Appear from center", "wpex")	=> "appear"),
					//"description"	=> __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "wpex"),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __("Text Align", "wpex"),
					"param_name"	=> "text_align",
					"value"			=> array(
						__("Center", "wpex")	=> "center",
						__("Left", "wpex")		=> "left",
						__("Right", "wpex")		=> "right",
					),
					//"description"	=> __("Select your text alignment.", "wpex"),
					'group'			=> __( 'Design', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "Title", 'wpex' ),
					"param_name"	=> "heading",
					"value"			=> "Sample Heading",
					//"description"	=> __("Teaser box main heading.", "wpex"),
					'group'			=> __( 'Title', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "Title Heading Type", 'wpex' ),
					"param_name"	=> "heading_type",
					 "value"		=> array(
						__("h2", "wpex")	=> "h2",
						__("h3", "wpex")	=> "h3",
						__("h4", "wpex")	=> "h4",
						__("h5", "wpex")	=> "h5",
					),
					//"description"	=> __("Teaser box heading type.", "wpex"),
					'group'			=> __( 'Title', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Image Width", 'wpex' ),
					"param_name"	=> "img_width",
					"value"			=> "9999",
					//"description"	=> __( "Custom image cropping width. Enter 9999 for no cropping.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"heading"		=> __( "Image Height", 'wpex' ),
					"param_name"	=> "img_height",
					"value"			=> "9999",
					"description"	=> __( "Custom image cropping height. Enter 9999 for no cropping.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Image Filter", 'wpex' ),
					"param_name"	=> "img_filter",
					"value"			=> vcex_image_filters(),
					//"description"	=> __( "Select a custom filter style for your images.", 'wpex' ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "CSS3 Image Hover", 'wpex' ),
					"param_name"	=> "img_hover_style",
					"value"			=> vcex_image_hovers(),
					"description"	=> __("Select your preferred image hover effect. Please note this will only work if the image links to a URL or a large version of itself. Please note these effects may not work in all browsers.", "wpex"),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"heading"		=> __( "Image Rendering", 'wpex' ),
					"param_name"	=> "img_rendering",
					"value"			=> vcex_image_rendering(),
					"description"	=> sprintf( __( 'Image-rendering CSS property provides a hint to the user agent about how to handle its image rendering. For example when scaling down images they tend to look a bit fuzzy in Firefox, setting image-rendering to crisp-edges can help make the images look better. <a href="%s">Learn more</a>.', 'wpex' ), esc_url( $vc_img_rendering_url ) ),
					'group'			=> __( 'Image Settings', 'wpex' ),
				),
				array(
					"type"			=> "textfield",
					"class"			=> "",
					"heading"		=> __( "URL", 'wpex' ),
					"param_name"	=> "url",
					"value"			=> "",
					//"description"	=> __("Enter a URL to link this teaser box to.", "wpex"),
					'group'			=> __( 'URL', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "URL Target", 'wpex' ),
					"param_name"	=> "url_target",
					"value"			=> array(
						__("Self", "wpex")		=> "_self",
						__("Blank", "wpex")		=> "_blank",
					),
					"dependency"	=> Array('element' => "url", 'not_empty' => true),
					//"description"	=> __( 'Your link target. Choose self to open the link in the same browser tab and blank to open in a new tab.', 'wpex' ),
					'group'			=> __( 'URL', 'wpex' ),
				),
				array(
					"type"			=> "dropdown",
					"class"			=> "",
					"heading"		=> __( "URL Rel", 'wpex' ),
					"param_name"	=> "url_rel",
					 "value"		=> array(
						__( "None", "wpex" )		=> "",
						__( "Nofollow", "wpex" )	=> "nofollow",
					),
					//"description"	=> __( 'Select a rel attribute for your link.', 'wpex' ),
					'group'			=> __( 'URL', 'wpex' ),
					"dependency"	=> Array(
						'element'	=> "url",
						'not_empty'	=> true
					),
				),
			)
		) );
	}
}
add_action( 'init', 'vcex_teaser_shortcode_vc_map' );
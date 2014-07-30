<?php
/**
 * Add new params to the vc composer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 */


// Leave file if the vc_add_param parameter doesn't exist
if ( !function_exists('vc_add_param') ) {
	return;
}


/**
	Returns arrays for use with the VC params
**/
if ( !function_exists( 'wpex_vc_param_arrays' ) ) {
	function wpex_vc_param_arrays( $array ) {
		// Border Styles
		if ( 'border_styles' == $array ) {
			return array(
				__( 'None', 'wpex' )	=> '',
				__( 'Solid', 'wpex' )	=> 'solid',
				__( 'Dotted', 'wpex' )	=> "dotted",
				__( 'Dashed', 'wpex' )	=> "dashed",
			);
		}
		// Alignmnets
		if ( 'alignments' == $array ) {
			return array(
				__( 'None', 'wpex' )			=> 'none',
				__( 'Align left', 'wpex' )		=> 'left',
				__( 'Align right', 'wpex' )		=> 'right',
				__( 'Align center', 'wpex' )	=> 'center',
			);
		}
		// Visibility
		if ( 'visibility' == $array ) {
			return array(
				__( 'All', 'wpex' )						=> '',
				__( 'Hidden on Phones', 'wpex' )		=> "hidden-phone",
				__( 'Hidden on Tablets', 'wpex' )		=> "hidden-tablet",
				__( 'Hidden on Desktop', 'wpex' )		=> "hidden-desktop",
				__( 'Visible on Desktop Only', 'wpex' )	=> "visible-desktop",
				__( 'Visible on Phones Only', 'wpex' )	=> "visible-phone",
				__( 'Visible on Tablets Only', 'wpex' )	=> "visible-tablet",
			);
		}
		// CSS Animation
		if ( 'css_animation' == $array ) {
			return array(
				__( 'None', 'wpex' )				=> '',
				__( 'Top to bottom', 'wpex' )		=> "top-to-bottom",
				__( 'Bottom to top', 'wpex' )		=> "bottom-to-top",
				__( 'Left to right', 'wpex' )		=> "left-to-right",
				__( 'Right to left', 'wpex' )		=> "right-to-left",
				__( 'Appear from center', 'wpex' )	=> "appear",
			);
		}
	}
}


/**
	Toggle
**/
vc_add_param( "vc_toggle", array(
	'type'			=> 'textfield',
	'heading'		=> __( 'Custom ID', 'wpex' ),
	'param_name'	=> 'id',
	'group'			=> __( 'ID', 'wpe' )
) );


/**
	Single Image
**/
vc_add_param( "vc_single_image", array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Image alignment', 'wpex' ),
	'param_name'	=> 'alignment',
	'value'			=> wpex_vc_param_arrays( 'alignments' ),
	'description'	=> __( 'Select image alignment.', 'wpex' )
) );

if ( function_exists('vcex_image_hovers') ) {
	vc_add_param( "vc_single_image", array(
		'type'			=> 'dropdown',

		'heading'		=> __( 'CSS3 Image Link Hover', 'wpex' ),
		'param_name'	=> "img_hover",
		'value'			=> vcex_image_hovers(),
		'description'	=> __( 'Select your preferred image hover effect. Please note this will only work if the image links to a URL or a large version of itself. Please note these effects may not work in all browsers.', 'wpex' ),
	) );
}

if ( function_exists('vcex_image_filters') ) {
	vc_add_param( "vc_single_image", array(
		'type'			=> 'dropdown',

		'heading'		=> __( 'Image Filter', 'wpex' ),
		'param_name'	=> "img_filter",
		'value'			=> vcex_image_filters(),
		'description'	=> __( 'Select an image filter style.', 'wpex' ),
	) );
}

vc_add_param( "vc_single_image", array(
	'type'			=> "checkbox",
	'heading'		=> __( 'Rounded Image?', 'wpex' ),
	'param_name'	=> "rounded_image",
	'value'			=> Array(
		__( 'Yes please.', 'wpex' )	=> 'yes'
	),
	'description'	=> __( 'For truely rounded images make sure your images are cropped to the same width and height.', 'wpex' ),
) );

vc_add_param( "vc_single_image", array(
	'type'			=> "textfield",
	'heading'		=> __( 'Image Link Caption', 'wpex' ),
	'param_name'	=> "img_caption",
	'value'			=> "",
	'description'	=> __( 'Use this field to add a caption to any single image with a link.', 'wpex' ),
) );

vc_add_param( "vc_single_image", array(
	'type'			=> "textfield",
	'heading'		=> __( 'Video, SWF, Flash, URL Lightbox', 'wpex' ),
	'param_name'	=> "lightbox_video",
	'value'			=> "",
	'description'	=> __( 'Enter the URL to a video, SWF file, flash file or a website URL to open in lightbox.', 'wpex' ),
	'group'			=> __( 'Custom Lightbox', 'wpex' ),
) );

vc_add_param( "vc_single_image", array(
	'type'			=> "attach_image",
	'heading'		=> __( 'Custom Image Lightbox', 'wpex' ),
	'param_name'	=> "lightbox_custom_img",
	'value'			=> "",
	'description'	=> __( 'Select a custom image to open in lightbox format', 'wpex' ),
	'group'			=> __( 'Custom Lightbox', 'wpex' ),
) );

vc_add_param( "vc_single_image", array(
	'type'			=> "attach_images",
	"admin_label"	=> true,
	'heading'		=> __( 'Gallery Lightbox', 'wpex' ),
	'param_name'	=> "lightbox_gallery",
	'value'			=> "",
	'description'	=> __( 'Select images to create a lightbox Gallery.', 'wpex' ),
	'group'			=> __( 'Custom Lightbox', 'wpex' ),
) );


/**
	Seperator w/ text
**/
vc_add_param( "vc_text_separator", array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Element Type', 'wpex' ),
	'param_name'	=> "element_type",
	'value'			=> array(
		__( 'Div', 'wpex' )	=> 'div',
		__( 'H1', 'wpex' )	=> "h1",
		__( 'H2', 'wpex' )	=> "h2",
		__( 'H3', 'wpex' )	=> "h3",
		__( 'H4', 'wpex' )	=> "h4",
		__( 'H5', 'wpex' )	=> "h5",
		__( 'H6', 'wpex' )	=> "h6",
	),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( "vc_text_separator", array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Style', 'wpex' ),
	'param_name'	=> "style",
	'value'			=> array(
		__( 'Bottom Border', 'wpex' )				=> 'one',
		__( 'Bottom Border With Color', 'wpex' )	=> "two",
		__( 'Line Through', 'wpex' )				=> "three",
		__( 'Double Line Through', 'wpex' )			=> "four",
		__( 'Dotted', 'wpex' )						=> "five",
		__( 'Dashed', 'wpex' )						=> "six",
		__( 'Top & Bottom Borders', 'wpex' )		=> "seven",
		__( 'Graphical', 'wpex' )					=> "eight",
		__( 'Outlined', 'wpex' )					=> "nine",
	),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( "vc_text_separator", array(
	'type'			=> "colorpicker",
	'heading'		=> __( 'Border Color', 'wpex' ),
	'param_name'	=> "border_color",
	'value'			=> "",
	'description'	=> __( 'Select a custom color for your colored border under the title.', 'wpex' ),
	'dependency'	=> Array(
		'element'	=> "style",
		'value'		=> array( 'two'),
	),
	'group'			=> __( 'Design', 'wpex' ),
) );


vc_add_param( "vc_text_separator", array(
	'type'			=> "textfield",
	'heading'		=> __( 'Font size (px or em)', 'wpex' ),
	'param_name'	=> "font_size",
	'value'			=> "",
	'description'	=> __( 'Enter a custom font size for your heading.', 'wpex' ),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( "vc_text_separator", array(
	'type'			=> "textfield",
	'heading'		=> __( 'Font Weight', 'wpex' ),
	'param_name'	=> "font_weight",
	'value'			=> "",
	'description'	=> __( 'Enter a custom font weight for your heading (300,400,600,700,900).', 'wpex' ),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( "vc_text_separator", array(
	'type'			=> "textfield",
	'heading'		=> __( 'Bottom Margin', 'wpex' ),
	'param_name'	=> "margin_bottom",
	'value'			=> "",
	'description'	=> __( 'Enter a bottom margin in pixels for your heading.', 'wpex' ),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( "vc_text_separator", array(
	'type'			=> "colorpicker",
	'heading'		=> __( 'Background Color', 'wpex' ),
	'param_name'	=> "span_background",
	'value'			=> "",
	'description'	=> __( 'The background color option is used for the background behind the text.', 'wpex' ),
	'dependency'	=> Array(
		'element'	=> "style",
		'value'		=> array( 'three', 'four', 'five', 'six' ),
		'group'			=> __( 'Design', 'wpex' ),
	)
) );

vc_add_param( "vc_text_separator", array(
	'type'			=> "colorpicker",
	'heading'		=> __( 'Font Color', 'wpex' ),
	'param_name'	=> "span_color",
	'value'			=> "",
	'description'	=> __( 'Select a custom font color for your heading.', 'wpex' ),
	'group'			=> __( 'Design', 'wpex' ),
) );

/**
	Columns
**/
vc_add_param( "vc_column", array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Style', 'wpex' ),
	'param_name'	=> "style",
	'value'			=> array(
		__( 'Default', 'wpex' )		=> 'default',
		__( 'Bordered', 'wpex' )	=> "bordered",
		__( 'Boxed', 'wpex' )		=> "boxed",
		__( 'No Spacing', 'wpex' )	=> "no-spacing",
	),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( "vc_column", array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Visibility', 'wpex' ),
	'param_name'	=> "visibility",
	'value'			=> wpex_vc_param_arrays( 'visibility' ),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( "vc_column", array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Animation', 'wpex' ),
	'param_name'	=> "css_animation",
	'value'			=> wpex_vc_param_arrays( 'css_animation' ),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( "vc_column", array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Typography Style', 'wpex' ),
	'param_name'	=> "typo_style",
	'value'			=> array(
		__( 'Dark Text', 'wpex' )	=> '',
		__( 'White Text', 'wpex' )	=> "light",
	),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( "vc_column", array(
	'type'			=> "checkbox",
	'heading'		=> __( 'Drop Shadow?', 'wpex' ),
	'param_name'	=> "drop_shadow",
	'value'			=> Array(
		__( 'Yes please.', 'wpex' )	=> 'yes'
	),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param("vc_column", array(
	'type'			=> "colorpicker",
	'heading'		=> __( 'Background Color', 'wpex' ),
	'param_name'	=> "bg_color",
	'value'			=> "",
	'group'			=> __( 'Background', 'wpex' ),
) );


vc_add_param("vc_column", array(
	'type'			=> "attach_image",
	'heading'		=> __( 'Background Image', 'wpex' ),
	'param_name'	=> "bg_image",
	'value'			=> "",
	'description'	=> __( 'Select image from media library.', 'wpex' ),
	'group'			=> __( 'Background', 'wpex' ),
) );

vc_add_param("vc_column", array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Background Image Style', 'wpex' ),
	'param_name'	=> "bg_style",
	'value'			=> array(
		__( 'Stretched', 'wpex' )	=> 'stretch',
		__( 'Fixed', 'wpex' )		=> "fixed",
		__( 'Parallax', 'wpex' )	=> "parallax",
		__( 'Repeat', 'wpex' )		=> "repeat",
	),
	'dependency' => Array(
		'element'	=> "background_image",
		'not_empty'	=> true
	),
	'group'			=> __( 'Background', 'wpex' ),
) );

vc_add_param("vc_column", array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Border Style', 'wpex' ),
	'param_name'	=> "border_style",
	'value'			=> wpex_vc_param_arrays( 'border_styles' ),
	'group'			=> __( 'Border', 'wpex' ),
) );

vc_add_param("vc_column", array(
	'type'			=> "colorpicker",
	'heading'		=> __( 'Border Color', 'wpex' ),
	'param_name'	=> "border_color",
	'value' 		=> "",
	'group'			=> __( 'Border', 'wpex' ),
) );

vc_add_param("vc_column", array(
	'type'			=> "textfield",
	'heading'		=> __( 'Border Width', 'wpex' ),
	'param_name'	=> "border_width",
	'value'			=> "",
	'description'	=> __( 'Your border width. Example: 1px 1px 1px 1px.', 'wpex' ),
	'group'			=> __( 'Border', 'wpex' ),
) );

vc_add_param("vc_column", array(
	'type'			=> "textfield",
	'heading'		=> __( 'Margin Top', 'wpex' ),
	'param_name'	=> "margin_top",
	'value'			=> "",
	'group'			=> __( 'Margin', 'wpex' ),
) );

vc_add_param("vc_column", array(
	'type'			=> "textfield",
	'heading'		=> __( 'Margin Bottom', 'wpex' ),
	'param_name'	=> "margin_bottom",
	'value'			=> "",
	'group'			=> __( 'Margin', 'wpex' ),
) );

vc_add_param("vc_column", array(
	'type'			=> "textfield",
	'heading'		=> __( 'Padding Top', 'wpex' ),
	'param_name'	=> "padding_top",
	'value'			=> "",
	'group'			=> __( 'Padding', 'wpex' ),
) );

vc_add_param("vc_column", array(
	'type'			=> "textfield",
	'heading'		=> __( 'Padding Bottom', 'wpex' ),
	'param_name'	=> "padding_bottom",
	'value'			=> "",
	'group'			=> __( 'Padding', 'wpex' ),
) );

vc_add_param("vc_column", array(
	'type'			=> "textfield",
	'heading'		=> __( 'Padding Left', 'wpex' ),
	'param_name'	=> "padding_left",
	'value'			=> "",
	'group'			=> __( 'Padding', 'wpex' ),
) );

vc_add_param("vc_column", array(
	'type'			=> "textfield",
	'heading'		=> __( 'Padding Right', 'wpex' ),
	'param_name'	=> "padding_right",
	'value'			=> "",
	'group'			=> __( 'Padding', 'wpex' ),
) );


/**
	Column Inner
**/
vc_add_param( 'vc_column_inner', array(
	'type'			=> 'dropdown',
	'class'			=> '',
	'heading'		=> __( 'Style', 'wpex' ),
	'param_name'	=> "style",
	'value'			=> array(
		__( 'Default', 'wpex' )		=> 'default',
		__( 'Bordered', 'wpex' )	=> "bordered",
		__( 'Boxed', 'wpex' )		=> "boxed",
	),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( 'vc_column_inner', array(
	'type'			=> 'dropdown',
	'class'			=> '',
	'heading'		=> __( 'Visibility', 'wpex' ),
	'param_name'	=> "visibility",
	'value'			=> wpex_vc_param_arrays( 'visibility' ),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( 'vc_column_inner', array(
	'type'			=> 'dropdown',
	'class'			=> '',
	'heading'		=> __( 'Animation', 'wpex' ),
	'param_name'	=> "css_animation",
	'value'			=> wpex_vc_param_arrays( 'css_animation' ),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( 'vc_column_inner', array(
	'type'			=> 'dropdown',
	'class'			=> '',
	'heading'		=> __( 'Typography Style', 'wpex' ),
	'param_name'	=> "typo_style",
	'value'			=> array(
		__( 'Dark Text', 'wpex' )	=> '',
		__( 'White Text', 'wpex' )	=> "light",
	),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( 'vc_column_inner', array(
	'type'			=> "checkbox",
	'class'			=> '',
	'heading'		=> __( 'Drop Shadow?', 'wpex' ),
	'param_name'	=> "drop_shadow",
	'value'			=> Array(
		__( 'Yes please.', 'wpex' )	=> 'yes'
	),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param('vc_column_inner', array(
	'type'			=> "colorpicker",
	'heading'		=> __( 'Background Color', 'wpex' ),
	'param_name'	=> "bg_color",
	'value'			=> '',
	'group'			=> __( 'Background', 'wpex' ),
) );


vc_add_param('vc_column_inner', array(
	'type'			=> "attach_image",
	'heading'		=> __( 'Background Image', 'wpex' ),
	'param_name'	=> "bg_image",
	'value'			=> '',
	'description'	=> __( 'Select image from media library.', 'wpex' ),
	'group'			=> __( 'Background', 'wpex' ),
) );

vc_add_param('vc_column_inner', array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Background Image Style', 'wpex' ),
	'param_name'	=> "bg_style",
	'value'			=> array(
		__( 'Stretched', 'wpex' )	=> 'stretch',
		__( 'Fixed', 'wpex' )		=> "fixed",
		__( 'Parallax', 'wpex' )	=> "parallax",
		__( 'Repeat', 'wpex' )		=> "repeat",
	),
	'dependency' => Array(
		'element'	=> "background_image",
		'not_empty'	=> true
	),
	'group'			=> __( 'Background', 'wpex' ),
) );

vc_add_param('vc_column_inner', array(
	'type'			=> 'dropdown',
	'class'			=> '',
	'heading'		=> __( 'Border Style', 'wpex' ),
	'param_name'	=> "border_style",
	'value'			=> wpex_vc_param_arrays( 'border_styles' ),
	'group'			=> __( 'Border', 'wpex' ),
) );

vc_add_param('vc_column_inner', array(
	'type'			=> "colorpicker",
	'class'			=> '',
	'heading'		=> __( 'Border Color', 'wpex' ),
	'param_name'	=> "border_color",
	'value' 		=> '',
	'group'			=> __( 'Border', 'wpex' ),
) );

vc_add_param('vc_column_inner', array(
	'type'			=> "textfield",
	'class'			=> '',
	'heading'		=> __( 'Border Width', 'wpex' ),
	'param_name'	=> "border_width",
	'value'			=> '',
	'description'	=> __( 'Your border width. Example: 1px 1px 1px 1px.', 'wpex' ),
	'group'			=> __( 'Border', 'wpex' ),
) );

vc_add_param('vc_column_inner', array(
	'type'			=> "textfield",
	'class'			=> '',
	'heading'		=> __( 'Margin Top', 'wpex' ),
	'param_name'	=> "margin_top",
	'value'			=> '',
	'group'			=> __( 'Margin', 'wpex' ),
) );

vc_add_param('vc_column_inner', array(
	'type'			=> "textfield",
	'class'			=> '',
	'heading'		=> __( 'Margin Bottom', 'wpex' ),
	'param_name'	=> "margin_bottom",
	'value'			=> '',
	'group'			=> __( 'Margin', 'wpex' ),
) );

vc_add_param('vc_column_inner', array(
	'type'			=> "textfield",
	'class'			=> '',
	'heading'		=> __( 'Padding Top', 'wpex' ),
	'param_name'	=> "padding_top",
	'value'			=> '',
	'group'			=> __( 'Padding', 'wpex' ),
) );

vc_add_param('vc_column_inner', array(
	'type'			=> "textfield",
	'class'			=> '',
	'heading'		=> __( 'Padding Bottom', 'wpex' ),
	'param_name'	=> "padding_bottom",
	'value'			=> '',
	'group'			=> __( 'Padding', 'wpex' ),
) );

vc_add_param('vc_column_inner', array(
	'type'			=> "textfield",
	'class'			=> '',
	'heading'		=> __( 'Padding Left', 'wpex' ),
	'param_name'	=> "padding_left",
	'value'			=> '',
	'group'			=> __( 'Padding', 'wpex' ),
) );

vc_add_param('vc_column_inner', array(
	'type'			=> "textfield",
	'class'			=> '',
	'heading'		=> __( 'Padding Right', 'wpex' ),
	'param_name'	=> "padding_right",
	'value'			=> '',
	'group'			=> __( 'Padding', 'wpex' ),
) );


/**
	Tabs
**/
vc_add_param( "vc_tabs", array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Style', 'wpex' ),
	'param_name'	=> "style",
	'value'			=> array(
		__( 'Default', 'wpex' )			=> 'default',
		__( 'Alternative #1', 'wpex' )	=> "alternative-one",
		__( 'Alternative #2', 'wpex' )	=> "alternative-two",
	),	
) );


/*
Work in Progress ;)
Individual Tabs
if ( function_exists('vcex_font_icons_array') ) {
	vc_add_param( "vc_tab", array(
		'type'			=> 'dropdown',

		'heading'		=> __( 'Icon', 'wpex' ),
		'param_name'	=> "icon",
		'value'			=> vcex_font_icons_array()
	) );
} */


/**
	Tour
**/
vc_add_param( "vc_tour", array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Style', 'wpex' ),
	'param_name'	=> "style",
	'value'			=> array(
		__( 'Default', 'wpex' )			=> 'default',
		__( 'Alternative #1', 'wpex' )	=> "alternative-one",
		__( 'Alternative #2', 'wpex' )	=> "alternative-two",
	),
	
) );


/**
	Rows
**/
vc_add_param( 'vc_row', array(
	'type'			=> "textfield",
	'heading'		=> __( 'Row ID', 'wpex' ),
	'param_name'	=> "id",
	'value'			=> '',
) );

vc_add_param( 'vc_row', array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Visibility', 'wpex' ),
	'param_name'	=> "visibility",
	'value'			=> wpex_vc_param_arrays( 'visibility' ),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Animation', 'wpex' ),
	'param_name'	=> "css_animation",
	'value'			=> wpex_vc_param_arrays( 'css_animation' ),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "checkbox",
	'heading'		=> __( 'Center Row Content', 'wpex' ),
	'param_name'	=> "center_row",
	'value'			=> Array(
		__( 'Yes please.', 'wpex' )	=> 'yes'
	),
	'description'	=> __( 'Use this option to center the inner content (Horizontally). Useful when using full-width pages.', 'wpex' ),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "checkbox",
	'heading'		=> __( 'Full-Width Columns On Tablets', 'wpex' ),
	'param_name'	=> "tablet_fullwidth_cols",
	'value'			=> Array(
		__( 'Yes please.', 'wpex' ) => 'yes'
	),
	'description'	=> __( 'Check this box to make all columns inside this row full-width for tablets.', 'wpex' ),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "textfield",
	'heading'		=> __( 'Minimum Height', 'wpex' ),
	'param_name'	=> "min_height",
	'value'			=> "",
	'description'	=> __( 'You can enter a minimum height for this row.', 'wpex' ),
	'group'			=> __( 'Design', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Typography Style', 'wpex' ),
	'param_name'	=> "style",
	'value'			=> array(
		__( 'Dark Text', 'wpex' )	=> '',
		__( 'White Text', 'wpex' )	=> "light",
	),
	'group'			=> __( 'Design', 'wpex' ),
) );


vc_add_param( 'vc_row', array(
	'type'			=> "colorpicker",
	'heading'		=> __( 'Background Color', 'wpex' ),
	'param_name'	=> "bg_color",
	'value'			=> "",
	'group'			=> __( 'Background', 'wpex' ),
) );


vc_add_param( 'vc_row', array(
	'type'			=> "attach_image",
	'heading'		=> __( 'Background Image', 'wpex' ),
	'param_name'	=> "bg_image",
	'value'			=> "",
	'description'	=> __( 'Select image from media library.', 'wpex' ),
	'group'			=> __( 'Background', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Background Image Style', 'wpex' ),
	'param_name'	=> "bg_style",
	'value'			=> array(
		__( 'Stretched', 'wpex' )			=> 'stretch',
		__( 'Fixed', 'wpex' )				=> "fixed",
		__( 'Simple Parallax', 'wpex' )		=> "parallax",
		__( 'Advanced Parallax', 'wpex' )	=> "parallax-advanced",
		__( 'Repeat', 'wpex' )				=> "repeat",
	),
	'dependency'	=> Array(
		'element'	=> "background_image",
		'not_empty'	=> true
	),
	'group'			=> __( 'Background', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Parallax Style', 'wpex' ),
	'param_name'	=> "parallax_style",
	'value'			=> array(
		__( 'Fixed & Repeat', 'wpex' )		=> "fixed-repeat",
		__( 'Fixed & No-Repeat', 'wpex' )	=> "fixed-no-repeat",
	),
	'dependency'	=> Array(
		'element'	=> "bg_style",
		'value'		=> array( 'parallax-advanced' ),
	),
	'group'			=> __( 'Background', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Parallax Direction', 'wpex' ),
	'param_name'	=> "parallax_direction",
	'value'			=> array(
		__( 'Up', 'wpex' )		=> 'up',
		__( 'Down', 'wpex' )	=> "down",
		__( 'Left', 'wpex' )	=> "left",
		__( 'Right', 'wpex' )	=> "right",
	),
	'group'			=> __( 'Background', 'wpex' ),
	'dependency'	=> Array(
		'element'	=> "bg_style",
		'value'		=> array( 'parallax-advanced' ),
	),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "textfield",
	'heading'		=> __( 'Parallax Speed', 'wpex' ),
	'param_name'	=> "parallax_speed",
	'value'			=> "0.5",
	'description'	=> __( 'The movement speed, value should be between 0.1 and 1.0. A lower number means slower scrolling speed. Be mindful of the background size and the dimensions of your background image when setting this value. Faster scrolling means that the image will move faster, make sure that your background image has enough width or height for the offset.', 'wpex' ),
	'group'			=> __( 'Background', 'wpex' ),
	'dependency'	=> Array(
		'element'	=> "bg_style",
		'value'		=> array( 'parallax-advanced' ),
	),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "checkbox",
	'heading'		=> __( 'Enable parallax for mobile devices', 'wpex' ),
	'param_name'	=> "parallax_mobile",
	'value'			=> Array(
		__( 'Check to enable parallax for mobile devices', 'wpex' )	=> 'on',
	),
	'description'	=> __( 'Parallax effects would most probably cause slowdowns when your site is viewed in mobile devices. By default it is disabled.', 'wpex' ),
	'group'			=> __( 'Background', 'wpex' ),
	'dependency'	=> Array(
		'element'	=> "bg_style",
		'value'		=> array( 'parallax-advanced' ),
	),
) );

vc_add_param( 'vc_row', array(
	'type'			=> 'checkbox',
	'heading'		=> __( 'Enable Self Hosted Video Background?', 'wpex' ),
	'param_name'	=> "video_bg",
	'description'	=> __( 'Check this box to enable the options for a self hosted video background.', 'wpex' ),
	'value'			=> Array(
		__( 'Yes, please', 'wpex' )	=> 'yes'
	),
	'group'			=> __( 'Video', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Video Background Overlay', 'wpex' ),
	'param_name'	=> "video_bg_overlay",
	'value'			=> array(
		__( 'None', 'wpex' )			=> 'none',
		__( 'Dark', 'wpex' )			=> "dark",
		__( 'Dotted', 'wpex' )			=> "dotted",
		__( 'Diagonal Lines', 'wpex' )	=> "dashed",
	),
	'dependency'	=> Array(
		'element'	=> "video_bg",
		'value'		=> "yes"
	),
	'group'			=> __( 'Video', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "textfield",
	'heading'		=> __( 'Video URL: MP4 URL', 'wpex' ),
	'param_name'	=> "video_bg_mp4",
	'value'			=> "",
	'description'	=> __( 'Enter the URL to a SELF hosted video .mp4 file to create a video background for this row.', 'wpex' ),
	'dependency'	=> Array(
		'element'	=> "video_bg",
		'value'		=> "yes"
	),
	'group'			=> __( 'Video', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "textfield",
	'heading'		=> __( 'Video URL: WEBM URL', 'wpex' ),
	'param_name'	=> "video_bg_webm",
	'value'			=> "",
	'description'	=> __( 'Enter the URL to a SELF hosted video .webm file to create a video background for this row.', 'wpex' ),
	'dependency'	=> Array(
		'element'	=> "video_bg",
		'value'		=> "yes"
	),
	'group'			=> __( 'Video', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "textfield",
	'heading'		=> __( 'Video URL: OGV URL', 'wpex' ),
	'param_name'	=> "video_bg_ogv",
	'value'			=> "",
	'description'	=> __( 'Enter the URL to a SELF hosted video .webm file to create a video background for this row.', 'wpex' ),
	'dependency'	=> Array(
		'element'	=> "video_bg",
		'value'		=> "yes"
	),
	'group'			=> __( 'Video', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> 'dropdown',
	'heading'		=> __( 'Border Style', 'wpex' ),
	'param_name'	=> "border_style",
	'value'			=> wpex_vc_param_arrays( 'border_styles' ),
	'group'			=> __( 'Border', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "colorpicker",
	'heading'		=> __( 'Border Color', 'wpex' ),
	'param_name'	=> "border_color",
	'value'			=> "",
	'group'			=> __( 'Border', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "textfield",
	'heading'		=> __( 'Border Width', 'wpex' ),
	'param_name'	=> "border_width",
	'value'			=> "",
	'description'	=> __( 'Your border width. Example: 1px 1px 1px 1px.', 'wpex' ),
	'group'			=> __( 'Border', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "textfield",
	'heading'		=> __( 'Margin Top', 'wpex' ),
	'param_name'	=> "margin_top",
	'value'			=> "",
	'group'			=> __( 'Margin', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "textfield",
	'heading'		=> __( 'Margin Bottom', 'wpex' ),
	'param_name'	=> "margin_bottom",
	'value'			=> "",
	'group'			=> __( 'Margin', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "textfield",
	'heading'		=> __( 'Margin Left', 'wpex' ),
	'param_name'	=> "margin_left",
	'value'			=> "",
	'group'			=> __( 'Margin', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "textfield",
	'heading'		=> __( 'Margin Right', 'wpex' ),
	'param_name'	=> "margin_right",
	'value'			=> "",
	'group'			=> __( 'Margin', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "textfield",
	'heading'		=> __( 'Padding Top', 'wpex' ),
	'param_name'	=> "padding_top",
	'value'			=> "",
	'group'			=> __( 'Padding', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "textfield",
	'heading'		=> __( 'Padding Bottom', 'wpex' ),
	'param_name'	=> "padding_bottom",
	'value'			=> "",
	'group'			=> __( 'Padding', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "textfield",
	'heading'		=> __( 'Padding Left', 'wpex' ),
	'param_name'	=> "padding_left",
	'value'			=> "",
	'group'			=> __( 'Padding', 'wpex' ),
) );

vc_add_param( 'vc_row', array(
	'type'			=> "textfield",
	'heading'		=> __( 'Padding Right', 'wpex' ),
	'param_name'	=> "padding_right",
	'value'			=> "",
	'group'			=> __( 'Padding', 'wpex' ),
) );
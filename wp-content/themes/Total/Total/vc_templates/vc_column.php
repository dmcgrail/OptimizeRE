<?php
$output = $el_class = $width = '';
extract(shortcode_atts(array(
	'el_class'			=> '',
	'visibility'		=> '',
	'width'				=> '1/1',
	'css_animation'		=> '',
	'typo_style'		=> 'default',
	'style'				=> '',
	'drop_shadow'		=> '',
	'bg_color'			=> '',
	'bg_image'			=> '',
	'bg_style'			=> '',
	'border_color'		=> '',
	'border_style'		=> '',
	'border_width'		=> '',
	'margin_top'		=> '',
	'margin_bottom'		=> '',
	'padding_top'		=> '',
	'padding_bottom'	=> '',
	'padding_left'		=> '',
	'padding_right'		=> '',
	'border'			=> '',
), $atts));

$el_class = $this->getExtraClass($el_class);
$width = wpb_translateColumnWidthToSpan($width);

$css_animation_class = $css_animation !=='' ? 'wpb_animate_when_almost_visible wpb_'. $css_animation .'' : '';

$el_class .= ' wpb_column column_container '.$css_animation_class;

/**
	Extra Parent Classes
**/
$parent_classes = '';
if ( '' != $style && 'no-spacing' == $style ) {
	$parent_classes .= ' '. $style .'-column';
}

/**
	Inner Classes
**/
$col_inner_classes = '';
if ( $bg_style && $bg_image ) {
	$col_inner_classes .= 'vcex-background-'. $bg_style;
}

if ( '' != $style && 'default' != $style && 'no-spacing' != $style ) {
	$col_inner_classes .= ' '. $style .'-column';
}

if ( $drop_shadow == 'yes' ) {
	$col_inner_classes .= ' column-dropshadow';
}

/**
	Outer Style
**/

$add_style = array();

	if ( $margin_top ) {
		$add_style[] = 'margin-top: ' . intval($margin_top) . 'px;';
	}
	
	if ( $margin_bottom ) {
		$add_style[] = 'margin-bottom: ' . intval($margin_bottom) . 'px;';
	}

	if ( $bg_image ) {
		$img_url = wp_get_attachment_url($bg_image);
		$add_style[] = 'background-image: url('. $img_url .');';
	}
	
	if ( $bg_color ) {
		$add_style[] = 'background-color: '. $bg_color .';';
	} 
	
	if ( $border_color ) {
		$add_style[] = 'border-color: '. $border_color .';';
	}
	
	if ( $border_style && $border_color ) {
		$add_style[] = 'border-style: '. $border_style .';';
	}
	
	if ( $border_width && $border_color ) {
		$add_style[] = 'border-width: '. $border_width .';';
	}

	if ( $padding_top ) {
		$add_style[] = 'padding-top: ' . intval($padding_top) . 'px;';
	}
	
	if ( $padding_bottom ) {
		$add_style[] = 'padding-bottom: ' . intval($padding_bottom) . 'px;';
	}
	
	if ( $padding_left ) {
		$add_style[] = 'padding-left: ' . intval($padding_left) . 'px;';
	}
	
	if ( $padding_right ) {
		$add_style[] = 'padding-right: ' . intval($padding_right) . 'px;';
	}

$add_style = implode('', $add_style);

if ( $add_style ) {
	$add_style = wp_kses( $add_style, array() );
	$add_style = ' style="' . esc_attr($add_style) . '"';
}

/**
	Output
**/

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width.$el_class, $this->settings['base']);
$output .= "\n\t".'<div class="'. $css_class .' '. $parent_classes .' '. $visibility .'">';
	$output .= '<div class="clr vcex-skin-'. $typo_style .' '. $col_inner_classes .'" '. $add_style .'>';
		//$output .= "\n\t\t".'<div class="wpb_wrapper">';
		$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
		//$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
	$output .= '</div>';
$output .= "\n\t".'</div> '.$this->endBlockComment($el_class) . "\n";

echo $output;
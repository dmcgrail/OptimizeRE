<?php
$output = $el_class = $image = $img_size = $img_link = $img_link_target = $img_link_large = $title = $alignment = $css_animation = '';

extract( shortcode_atts( array(
	'title'					=> '',
	'image'					=> $image,
	'link'					=> '',
	'img_size'				=> 'full',
	'img_link_large'		=> false,
	'img_link'				=> '',
	'img_link_target'		=> '_self',
	'alignment'				=> '',
	'el_class'				=> '',
	'css_animation'			=> '',
	'img_hover'				=> '',
	'img_caption'			=> '',
	'rounded_image'			=> '',
	'img_filter'			=> '',
	'style'					=> '',
	'border_color'			=> '',
	'lightbox_video'		=> '',
	'lightbox_custom_img'	=> '',
	'lightbox_gallery'		=> '',
), $atts ) );

if ( $link ) {
	$img_link = $link;
}

$style = ($style!='') ? $style : '';
$border_color = ($border_color!='') ? ' vc_box_border_' . $border_color : '';

$img_id = preg_replace('/[^\d]/', '', $image);
$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => $style.$border_color ) );
if ( $img == NULL ) $img['thumbnail'] = '<img class="'. $style . $border_color .'" src="http://placekitten.com/g/400/300" /> <small>'.__('This is image placeholder, edit your page to replace it.', 'js_composer').'</small>';

$el_class = $this->getExtraClass($el_class);

$link_to = '';
$a_class='';

// Image hover classes
if ( $img_hover ) {
	$a_class .= 'vcex-img-hover-parent vcex-img-hover-'. $img_hover;
}

// Gallery Lightbox
if ( $lightbox_gallery ) {
	$gallery_ids = explode( ",",$lightbox_gallery );
	if ( $gallery_ids && is_array( $gallery_ids ) ) {
		$gallery_images = '';
		$count=0;
		foreach ( $gallery_ids as $id ) {
			$count++;
			if ( $count != count( $gallery_ids ) ) {
				$gallery_images .= wp_get_attachment_url( $id ) . ',';
			} else {
				$gallery_images .= wp_get_attachment_url( $id );
			}
		}
		$data_gallery = 'data-gallery="'. $gallery_images .'"';
	}
	$link_to = '#';
	$a_class .= ' wpex-lightbox-gallery';
} else {
	$data_gallery = '';
}

// Link to custom Video
if ( '' != $lightbox_video ) {
	$link_to = $lightbox_video;
	$a_class .= ' wpex-lightbox-video';
}

// Link to custom image
elseif ( '' != $lightbox_custom_img ) {
	$link_to = wp_get_attachment_image_src( $lightbox_custom_img, 'large');
	$link_to = $link_to[0];
	$a_class .= ' wpex-lightbox';
}

// Link to large image lightbox
elseif ( $img_link_large==true ) {
	$link_to = wp_get_attachment_image_src( $img_id, 'large');
	$link_to = $link_to[0];
	$a_class .= ' wpex-lightbox';
}

// Link to external URL
elseif (!empty($img_link)) {
	$link_to = $img_link;
}

$image_string = '';
if( !empty( $link_to ) ) {
	$link_to = esc_url($link_to);
}
if ( !empty( $link_to ) ) {
	$image_string .= '<a class="'.$a_class.'" href="'.$link_to.'"'.( $img_link_target!='_self' ? ' target="'.$img_link_target.'"' : '').' '. $data_gallery .'>';
}
if ( $img_caption ) {
	$image_string .='<span class="wpb_single_image_caption">'. $img_caption .'</span>';
}
if ( $style == 'vc_box_shadow_3d' ) {
	$image_string .= '<span class="vc_box_shadow_3d_wrap">' . $img['thumbnail'] . '</span>';
} else {
	$image_string .= $img['thumbnail'];
}

if ( !empty($link_to) ) {
	$image_string .='</a>';
}

$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_single_image wpb_content_element'.$el_class, $this->settings['base']);
$css_class .= $this->getCSSAnimation($css_animation);

if ( $alignment ) {
	$css_class .= ' vc_align_'.$alignment;
}

if ( $rounded_image == 'yes' ) {
	$css_class .= ' vcex-rounded-images';
}

if ( $img_filter && $img_filter !== 'none' ) {
	$css_class .= ' vcex-'. $img_filter;
}

$output .= "\n\t".'<div class="'.$css_class.'">';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= "\n\t\t\t".wpb_widget_title( array('title' => $title, 'extraclass' => 'wpb_singleimage_heading' ) );
$output .= "\n\t\t\t".$image_string;
$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> '.$this->endBlockComment('.wpb_single_image');

echo $output;
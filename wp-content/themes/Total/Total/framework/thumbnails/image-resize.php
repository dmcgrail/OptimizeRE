<?php
/**
 * Function used to resize and crop images
 * 
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

function wpex_image_resize( $url, $width, $height = null, $crop = null, $return = 'url' ) {

	// Image cropping is disabled
	if ( wpex_option( 'image_resizing', '1' ) !== '1' ) {
		if ( 'array' == $return ) {
			return array(
				'url'		=> $url,
				'width'		=> '',
				'height'	=> ''
			);
		} else {
			return $url;
		}
	}
	
	//validate inputs
	if(!$url OR !$width ) {
		false;
	}
	
	//set dimensions
	$aq_width = $width;
	$aq_height = $height;
	
	//define upload path & dir
	$upload_info = wp_upload_dir();
	$upload_dir = $upload_info['basedir'];
	$upload_url = $upload_info['baseurl'];
	
	//check if $img_url is local
	if( strpos( $url, $upload_url ) === false ) {
		return false;
	}
	
	//define path of image
	$rel_path = str_replace( $upload_url, '', $url);
	$img_path = $upload_dir . $rel_path;
	
	//check if img path exists, and is an image indeed
	if( !file_exists( $img_path) OR !getimagesize( $img_path ) ) {
		return false;
	}
	
	//get image info
	$info = pathinfo($img_path);
	$ext = $info['extension'];
	list($orig_w,$orig_h) = getimagesize($img_path);
			
	//get image size after cropping
	$dims = image_resize_dimensions($orig_w, $orig_h, $aq_width, $aq_height, $crop);
	$dst_w = $dims[4];
	$dst_h = $dims[5];
	
	//use this to check if cropped image already exists, so we can return that instead
	$suffix = "{$dst_w}x{$dst_h}";
	$dst_rel_path = str_replace( '.'.$ext, '', $rel_path);
	$destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";
	
	if(!$dst_h) {
		//can't resize, so return original url
		$img_url = $url;
		$dst_w = $orig_w;
		$dst_h = $orig_h;
	}
	
	//else check if cache exists
	elseif(file_exists($destfilename) && getimagesize($destfilename)) {
		$img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
	}
	
	//else, we resize the image and return the new resized image url
	else {
		
		$editor = wp_get_image_editor($img_path);
		
		if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $aq_width, $aq_height, $crop ) ) )
			return false;
		
		$editor->set_quality( 100 ); // Added by WPExplorer
		$resized_file = $editor->save();

		if(!is_wp_error($resized_file)) {
			$resized_rel_path = str_replace( $upload_dir, '', $resized_file['path']);
			$img_url = $upload_url . $resized_rel_path;
		} else {
			return false;
		}
		
	}
	
	// RETINA Support - Added by WPExplorer --------------------------------------------------------------->
	if ( wpex_option( 'retina', '1' ) == '1' ) {
		
		$retina_w = $dst_w*2;
		$retina_h = $dst_h*2;
		
		//get image size after cropping
		$dims_x2 = image_resize_dimensions($orig_w, $orig_h, $retina_w, $retina_h, $crop);
		$dst_x2_w = $dims_x2[4];
		$dst_x2_h = $dims_x2[5];
		
		// If possible lets make the @2x image
		if($dst_x2_h) {
		
			//@2x image url
			$destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}@2x.{$ext}";
			
			//check if retina image exists
			if(file_exists($destfilename) && getimagesize($destfilename)) {	
				// already exists, do nothing
			} else {
				// doesnt exist, lets create it
				$editor = wp_get_image_editor($img_path);
				if ( ! is_wp_error( $editor ) ) {
					$editor->resize( $retina_w, $retina_h, $crop );
					$editor->set_quality( 100 );
					$filename = $editor->generate_filename( $dst_w . 'x' . $dst_h . '@2x'  );
					$editor = $editor->save($filename);	
				}
			}
		
		}
	
	}
	
	// Return image --------------------------------------------------------------->
	$img_url = isset($img_url) ? $img_url : $url;
	$dst_w = isset($dst_w) ? $dst_w : '';
	$dst_h = isset($dst_h) ? $dst_h : '';
	if ( 'url' == $return ) {
		return $img_url;
	} elseif ( 'array' == $return ) {
		return array(
			'url'		=> $img_url,
			'width'		=> $dst_w,
			'height'	=> $dst_h
		);
	} else {
		return $img_url;
	}

}
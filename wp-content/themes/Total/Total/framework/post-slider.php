<?php
/**
 * Display page slider based on meta option
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/


/**
 * Outputs page/post slider based on the wpex_post_slider_shortcode custom field
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 * @return html
*/
if ( ! function_exists( 'wpex_post_slider' ) ) {
	function wpex_post_slider() {

		// Not singular, bye!
		if ( ! is_singular() && ! is_post_type_archive( 'product' ) ) {
			return;
		}
		
		// Vars
		global $post;
		$post_ID = $post->ID;
		if ( class_exists( 'Woocommerce' ) && function_exists( 'wc_get_page_id' ) ) {
			$shop_id = wc_get_page_id( 'shop' );
			if ( is_post_type_archive( 'product' ) && isset($shop_id) ) {
				$post_ID = $shop_id;
			}
		}
		$legacy_slider = get_post_meta( $post_ID, 'wpex_post_slider_shortcode', true );
		$slider = get_post_meta( $post_ID, 'wpex_post_slider_shortcode', true );
		$slider = ( ! empty( $legacy_slider ) ) ? $legacy_slider : $slider;
		$slider_alt = get_post_meta( $post_ID, 'wpex_post_slider_mobile_alt', true );
		if ( is_array( $slider_alt ) && !empty( $slider_alt['url'] ) ) {
			$slider_alt = $slider_alt['url'];
		} else {
			$slider_alt = '';
		}
		$main_title = get_post_meta( $post_ID, 'wpex_disable_title', true );
		$margin = get_post_meta( $post_ID, 'wpex_post_slider_bottom_margin', true );
		$margin = intval( $margin );
		
		// Display Slider
		if ( '' != $slider || '' != $slider_alt ) { ?>
			<div class="page-slider clr">
				<?php
				// Mobile slider
				if ( wp_is_mobile() && $slider_alt ) { ?>
					<img src="<?php echo $slider_alt; ?>" class="page-slider-mobile-alt" alt="<?php echo the_title(); ?>" />
				<?php }
				// Desktop slider
				else {
					echo do_shortcode( $slider );
				} ?>
			</div><!-- .page-slider -->
			<?php if ( $margin ) { ?>
				<div style="height:<?php echo $margin; ?>px;"></div>
			<?php } ?>
		<?php }

	}
}

/**
 * Gets slider position based on wpex_post_slider_shortcode_position custom field
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.51
 * @return string
*/
if ( ! function_exists( 'wpex_post_slider_position' ) ) {
	function wpex_post_slider_position( $slider_position = 'below_title' ) {
		if ( ! is_singular() && ! is_post_type_archive( 'product' ) ) {
			return;
		}
		global $post;
		$post_ID = $post->ID;
		$slider_position = get_post_meta( $post_ID, 'wpex_post_slider_shortcode_position', true );
		$slider_position = $slider_position ? $slider_position : 'below_title';
		return $slider_position;
	}
}
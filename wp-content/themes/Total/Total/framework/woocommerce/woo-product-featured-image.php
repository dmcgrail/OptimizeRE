<?php
/**
 * Overrides the WooCommerce featured image
 *
 * @package WordPress
 * @subpackage Total
 * @since 1.0
 */


function woocommerce_show_product_images() {
	global $post, $woocommerce, $product; ?>
	<div class="images">
		<?php
		// Featured Image
		if ( has_post_thumbnail() ) {
			$attachment_id = get_post_thumbnail_id();
			$attachment_url = wp_get_attachment_url( $attachment_id );
			$width = wpex_option( 'woo_post_image_width', '9999' );
			$height = wpex_option( 'woo_post_image_height', '9999' );
			$crop = ( $height == '9999' ) ? false : true;
			$image = '<img src="'. wpex_image_resize( $attachment_url, $width,  $height,  $crop) .'" alt="'. get_the_title() .'" />';
			$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_link = wp_get_attachment_url( get_post_thumbnail_id() );
			$attachment_count = count( $product->get_gallery_attachment_ids() );
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s">%s</a>', $image_link, $image_title, $image ), $post->ID );
		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ), $post->ID );
		} ?>
		<?php do_action( 'woocommerce_product_thumbnails' ); ?>
	</div>
<?php } // End function
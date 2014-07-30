<?php
/**
 * Single Product Image
 *
 * @author		WooThemes
 * @package		WooCommerce/Templates
 * @version		2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

// Get first image
$attachment_id = get_post_thumbnail_id();
$attachment_url = wp_get_attachment_url( $attachment_id );
$alt = strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );
$width = wpex_option( 'woo_post_image_width', '9999' );
$height = wpex_option( 'woo_post_image_height', '9999' );
$crop = ( $height == '9999' ) ? false : true;

// Get gallery images
$attachments = $product->get_gallery_attachment_ids();
array_unshift( $attachments, $attachment_id );
$attachments = array_unique( $attachments ); ?>

<div class="images woo-lightbox-gallery clr">
	<?php
	// Flexslider
	if ( $attachments ) { ?>
		<div class="woocommerce-single-product-slider-wrap clr">
			<div class="woocommerce-single-product-slider flexslider-container">
				<div class="flexslider">
					<ul class="slides wpex-gallery-lightbox">
						<?php
						// Loop through each product image
						foreach ( $attachments as $attachment ) {
							// Get image alt tag
							$attachment_alt = strip_tags( get_post_meta( $attachment, '_wp_attachment_image_alt', true ) ); ?>
							<li class="slide" data-thumb="<?php echo wpex_image_resize( wp_get_attachment_url( $attachment ), '100', '100', true ); ?>">
								<a href="<?php echo wp_get_attachment_url( $attachment ); ?>" title="<?php echo $attachment_alt; ?>" data-title="<?php echo $attachment_alt; ?>">
									<img src="<?php echo wpex_image_resize( wp_get_attachment_url( $attachment ), $width,  $height, $crop ); ?>" alt="<?php echo $attachment_alt; ?>" />
								</a>
							</li>
						<?php } ?>
					</ul><!-- .slides -->
				</div><!-- .flexslider -->
			</div><!-- .woocommerce-single-product-slider -->
		</div><!-- .woocommerce-single-product-slider-wrap -->
	<?php }
	// Single featured image
	else {
		if ( has_post_thumbnail() ) {
			$image = '<img src="'. wpex_image_resize( $attachment_url, $width,  $height, $crop ) .'" alt="'. get_the_title() .'" />';
			$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_link = wp_get_attachment_url( get_post_thumbnail_id() );
			$attachment_count = count( $product->get_gallery_attachment_ids() );
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image woo-lightbox" title="" data-mfp-src="%s">%s</a>', $image_link, $attachment_url, $image ), $post->ID );
		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ), $post->ID );
		} ?>
	<?php } ?>
</div>
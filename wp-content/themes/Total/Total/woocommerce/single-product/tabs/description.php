<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $post;

if ( wpex_option( 'woo_product_tabs_headings' ) ) {
	$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( 'Product Description', 'woocommerce' ) ) ); ?>
	<h2 class="woo-tab-description-heading"><?php echo $heading; ?></h2>
<?php } ?>

<?php the_content(); ?>
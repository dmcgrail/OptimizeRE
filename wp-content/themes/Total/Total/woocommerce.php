<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */


// Returns the correct classes for the main wrap
// See functions/woocommerce/woo-layouts.php
$wpex_woo_layout_class = wpex_woo_layout_class();

// Get site header
get_header(); ?>
	
	<?php
	// Display a slider on your shop page if defined in the admin
	if ( wpex_option( 'woo_shop_slider' ) !== '' && is_shop() ) { ?>
		<div class="page-slider clr">
			<?php echo apply_filters( 'the_content', wpex_option( 'woo_shop_slider' ) ); ?>
		</div><!-- .page-slider -->
	<?php } ?>
	
	<div id="content-wrap" class="container clr <?php echo $wpex_woo_layout_class; ?>">
		<section id="primary" class="content-area clr">
			<div id="content" class="clr site-content" role="main">
				<article class="entry-content entry clr">
					<?php woocommerce_content(); ?>
				</article><!-- #post -->
					<?php
					// Display social sharing links
					// See functions/social/social-share.php
					wpex_social_share(); ?>
			</div><!-- #content -->
		</section><!-- #primary -->
		<?php
		// Display sidebar for WooCommerce archives if enabled
		// See functions/woocommerce/woo-layouts.php
		if ( wpex_woo_sidebar() ) {
			get_sidebar();
		} ?>
		<?php
		// Display next/prev links if enabled
		if ( wpex_option( 'woo_next_prev', '1' ) == '1' ) {
			wpex_next_prev();
		} ?>
	</div><!-- #content-wrap -->

<?php
// Get site footer
get_footer(); ?>
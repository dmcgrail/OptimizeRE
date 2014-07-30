<?php
/**
 * Footer Bottom
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.1
*/


// Footer Copyright
if ( ! function_exists( 'wpex_footer_copyright' ) ) {
	function wpex_footer_copyright() {
		$output;
		$copyright = wpex_option('footer_copyright');
		$copyright_content = wpex_option('footer_copyright_text');
		if ( $copyright !== '1' ) return;
		$output = do_shortcode( $copyright_content );
		$output = apply_filters( 'wpex_copyright_info', $output );
		echo $output;
	} // End function
} // End if


// Outputs the Footer Callout
if ( ! function_exists( 'wpex_footer_bottom' ) ) {
	
	function wpex_footer_bottom() { ?>
			
		<?php
		// Lets bail if this section is disabled
		if ( wpex_option( 'footer_copyright', '1' ) !== '1' ) return; ?>
		
		<div id="footer-bottom" class="clr">
			<div id="footer-bottom-inner" class="container clr">
				<div id="copyright" class="clr" role="contentinfo">
					<?php
					// Display copyright info
					wpex_footer_copyright(); ?>
				</div><!-- #copyright -->
				<div id="footer-bottom-menu" class="clr">
					<?php
					// Display footer menu
					wp_nav_menu( array(
						'theme_location'	=> 'footer_menu',
						'sort_column'		=> 'menu_order',
						'fallback_cb'		=> false,
					) ); ?>
				</div><!-- #footer-bottom-menu -->
			</div><!-- #footer-bottom-inner -->
		</div><!-- #footer-bottom -->
			
	<?php		
	} // End function
	
} // End if

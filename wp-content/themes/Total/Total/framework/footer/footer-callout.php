<?php
/**
 * Footer Callout
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/


// Display the footer callout - returns true or false
if ( ! function_exists( 'wpex_display_callout' ) ) {
	
	function wpex_display_callout() {
		
		// Callout is disabled in the admin so bye bye
		if ( ! wpex_option( 'callout', '1' ) ) return false;
		
		// Display callouts on posts/pages if custom field isn't checked
		if ( is_singular() ) {
			$meta = get_post_meta(get_the_ID(), 'wpex_disable_footer_callout', true );
			if ( $meta == 'on' ) {
				$return = false;
			} else {
				$return = true;
			}
		
		// For all else, display the callout
		} else {
			$return = true;
		}

		return apply_filters( 'wpex_disable_footer_callout', $return );
		
	} // End function
	
} // End if


// Outputs the Footer Callout
if ( ! function_exists( 'wpex_footer_callout' ) ) {
	
	function wpex_footer_callout() {
		
		// Lets bail if the callout is disabled for this page/post --> see previous function
		if ( wpex_display_callout() == false ) return;
		
		// Get theme options
		$visibility = wpex_option( 'top_bar_visibility', 'one' );
		$callout_text = wpex_option( 'callout_text' );
		$callout_link = wpex_option( 'callout_link' );
		$callout_link_txt = wpex_option( 'callout_link_txt' );
		$callout_rel = wpex_option( 'callout_button_rel', 'dofollow' );
		$callout_target = wpex_option( 'callout_button_target', 'blank' );
		$rel = ( $callout_rel == 'nofollow' ) ? 'rel="nofollow"' : ''; ?>
			
		<div id="footer-callout-wrap" class="clr <?php echo $visibility; ?>">
			<div id="footer-callout" class="clr container">
				<div id="footer-callout-left" class="footer-callout-content clr <?php if ( wpex_option( 'callout_link' ) == '' ) echo 'full-width'; ?>">
					<?php
					// Echo the footer callout text
					echo do_shortcode( $callout_text ); ?>
				</div><!-- #footer-callout-left -->
				<?php
				// Display footer callout button if callout link & text options are not blank in the admin
				if ( $callout_link && $callout_link_txt ) { ?>
					<div id="footer-callout-right" class="footer-callout-button clr">
						<a href="<?php echo $callout_link; ?>" class="theme-button footer-callout-button" title="<?php echo $callout_link_txt; ?>" target="_<?php echo $callout_target; ?>" <?php echo $rel; ?>><?php echo $callout_link_txt; ?></a>
					</div><!-- #footer-callout-right -->
				<?php } ?>
			</div><!-- #footer-callout -->
		</div><!-- #footer-callout-wrap -->
			
	<?php		
	} // End function
	
} // End if

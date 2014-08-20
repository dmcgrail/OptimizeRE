<?php
/**
 * Outputs your footer widgets
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/


if ( ! function_exists( 'wpex_footer_widgets' ) ) {
	
	function wpex_footer_widgets() {

		// Get footer widget columns option
		$footer_col = wpex_option('footer_col','4'); ?>
	
		<div id="footer-widgets" class="clr <?php if ( $footer_col == '1' ) echo 'single-col-footer'; ?>">
		
			<!-- FOOTER BOX 1 -->
			<div class="footer-box <?php echo wpex_grid_class($footer_col); ?> col col-1">
				<?php dynamic_sidebar('footer_one'); ?>
			</div><!-- .footer-one-box -->
			
			<?php if ( $footer_col > "1" ) { ?>
				<!-- FOOTER BOX 2 -->
				<div class="footer-box <?php echo wpex_grid_class($footer_col); ?> col col-2">
					<?php dynamic_sidebar('footer_two'); ?>
				</div><!-- .footer-one-box -->
			<?php } ?>
			
			<?php if ( $footer_col > "2" ) { ?>
				<!-- FOOTER BOX 3 -->
				<div class="footer-box <?php echo wpex_grid_class($footer_col); ?> col col-3 ">
					<?php dynamic_sidebar('footer_three'); ?>
				</div><!-- .footer-one-box -->
			<?php } ?>
			
			<?php if ( $footer_col > "3" ) { ?>
				<!-- FOOTER BOX 4 -->
				<div class="footer-box <?php echo wpex_grid_class($footer_col); ?> col col-4">
					<?php dynamic_sidebar('footer_four'); ?>
				</div><!-- .footer-box -->
			<?php } ?>
		
		</div><!-- #footer-widgets -->
			
	<?php		
	} // End function
	
} // End if

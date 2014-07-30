<?php
/**
 * Toggle Bar Output
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/

// Check if the toggle bar is enabled
if ( ! function_exists( 'wpex_toggle_bar_active' ) ) {
	function wpex_toggle_bar_active( $return = true ) {
		if ( !wpex_option( 'toggle_bar' ) ) {
			$return = false;
		} elseif ( !wpex_option( 'toggle_bar_page' ) ) {
			$return = false;
		} elseif ( is_singular() && 'on' == get_post_meta( get_the_ID(), 'wpex_disable_toggle_bar', true ) ) {
			$return = false;
		} else {
			$return = true;
		}
		$return = apply_filters( 'wpex_toggle_bar_active', $return );
		return $return;
	}
}


// The toggle bar main content
if ( ! function_exists( 'wpex_toggle_bar' ) ) {
	function wpex_toggle_bar() {
		// Toggle bar disabled or page not selected, lets bail!
		if ( !wpex_toggle_bar_active() ) {
			return;
		}
		// Get toggle bar page content
		$content = get_post_field( 'post_content', wpex_option( 'toggle_bar_page' ) );
		$animation = wpex_option( 'toggle_bar_animation', 'fade' ); ?>
		<div id="toggle-bar-wrap" class="clr toggle-bar-<?php echo $animation; ?> <?php echo wpex_option( 'toggle_bar_visibility' ); ?>">
			<div id="toggle-bar" class="clr container">
				<div class="entry clr">
					<?php echo apply_filters( 'the_content', $content ); ?>
				</div><!-- .entry -->
			</div><!-- #toggle-bar -->
		</div><!-- #toggle-bar-wrap -->
	<?php
	}
}


// The Toggle Bar Button
if ( ! function_exists( 'wpex_toggle_bar_btn' ) ) {
	function wpex_toggle_bar_btn() {
		if ( !wpex_toggle_bar_active() ) {
			return;
		}
		echo '<a href="#" class="toggle-bar-btn fade-toggle '. wpex_option( 'toggle_bar_visibility' ) .'"><span class="fa fa-plus"></span></a>';
	}
}
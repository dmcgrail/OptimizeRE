<?php
/**
 * Custom Top Bar Functions
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

/**
 * Outputs social options for the top bar
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( ! function_exists( 'wpex_top_bar_social' ) ) {
	function wpex_top_bar_social( $social_class ) {
		$style = wpex_option( 'top_bar_social_style', 'font_icons' );
		$social_options = wpex_option( 'top_bar_social_options' );
		$colored_icons_url = get_template_directory_uri() .'/images/topbar-social';
		$colored_icons_url = apply_filters( 'top_bar_social_img_url', $colored_icons_url );
		if ( isset( $social_options ) && !empty($social_options) ) {
			$link_target = wpex_option( 'top_bar_social_target', 'blank' ); ?>
			<div id="top-bar-social" class="clr <?php echo $social_class; ?> social-style-<?php echo $style; ?>">
				<?php
				// Loop through social options
				foreach ( $social_options as $key => $value ) {
					if ( $value ) { ?>
						<a href="<?php echo esc_url($value); ?>" title="<?php echo $key; ?>" target="_<?php echo $link_target; ?>">
						<?php
						// Font Icon
						if ( $style == 'font_icons' ) { ?>
							<span class="fa fa-<?php echo $key; ?>"></span>
						<?php } ?>
						<?php
						// Img Icons
						if ( $style == 'colored-icons' ) { ?>
							<img src="<?php echo $colored_icons_url; ?>/<?php echo $key; ?>.png" alt="<?php echo $key; ?>" />
						<?php } ?>
						</a>
					<?php }
				} ?>
			</div><!-- #top-bar-social -->
		<?php }
	}
}

/**
 * Outputs the top bar content
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( ! function_exists( 'wpex_topbar_output' ) ) {
	function wpex_topbar_output() {
		// Add classes for various top bar styles
		$style = wpex_option( 'top_bar_style', 'one' );
		if ( 'one' == $style ) {
			$content_class = 'top-bar-left';
			$social_class = 'top-bar-right';
		} elseif( 'two' == $style ) {
			$content_class = 'top-bar-right';
			$social_class = 'top-bar-left';
		} elseif( 'three' == $style ) {
			$content_class = 'top-bar-centered';
			$social_class = 'top-bar-centered';
		} else {
			$content_class=$social_class='';
		}

		// Top bar content
		if ( wpex_option( 'top_bar_content' ) ) { ?>
			<div id="top-bar-content" class="clr <?php echo $content_class; ?>">
				<?php echo do_shortcode( wpex_option( 'top_bar_content' ) ); ?>
			</div><!-- #top-bar-content -->
		<?php }

		// Top bar social
		if ( wpex_option( 'top_bar_social', '1' ) ) {
			wpex_top_bar_social( $social_class );
		} elseif ( wpex_option( 'top_bar_social_alt' ) ) { ?>
			<div id="top-bar-social-alt" class="clr <?php echo $social_class; ?>">
				<?php echo do_shortcode( wpex_option( 'top_bar_social_alt' ) ); ?>
			</div><!-- #top-bar-social-alt -->
		<?php }
	}
}

/**
 * Outputs the topbar with all it's content and main wraps
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( ! function_exists( 'wpex_top_bar' ) ) {
	function wpex_top_bar() {
		// Return if top bar is disabled in admin
		if ( !wpex_option( 'top_bar' ) ) {
			return;
		}
		// Return if top bar disabled on single post
		if ( is_singular() ) {
			global $post;
			if ( $post && 'on' == get_post_meta( $post->ID, 'wpex_disable_top_bar', true ) ) {
				return;
			}
		} ?>
		<div id="top-bar-wrap" class="clr <?php echo wpex_option( 'top_bar_visibility' ); ?>">
			<div id="top-bar" class="clr container">
				<?php wpex_topbar_output(); ?>
			</div><!-- #top-bar -->
		</div><!-- #top-bar-wrap -->
	<?php
	}
}

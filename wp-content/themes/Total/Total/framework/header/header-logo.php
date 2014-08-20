<?php
/**
 * Header Logo
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.1
*/


// Outputs the main header logo
if ( ! function_exists( 'wpex_header_logo' ) ) {
	function wpex_header_logo() {
		// Vars
		$header_style = wpex_get_header_style();
		$site_url = esc_url( home_url( '/' ) );
		$logo_url = apply_filters( 'wpex_logo_url', $site_url );
		$logo = wpex_option( 'custom_logo', false, 'url' );
		$blogname = get_bloginfo( 'name' );
		$logo_title = apply_filters( 'wpex_logo_title', $blogname );
		if ( $logo_url ) { ?>
			<div id="site-logo" class="header-<?php echo $header_style; ?>-logo">
				<?php if ( '' != $logo ) { ?>
					<a href="<?php echo esc_url( $logo_url ); ?>" title="<?php echo $logo_title; ?>" rel="home">
						<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo $logo_title; ?>" />
					</a>
				<?php } else { ?>
					<a href="<?php echo $logo_url; ?>" title="<?php echo $logo_title; ?>" rel="home"><?php echo $logo_title; ?></a>
				<?php } ?>
			</div><!-- #site-logo -->
		<?php
		} // If logo URL check
	}
}
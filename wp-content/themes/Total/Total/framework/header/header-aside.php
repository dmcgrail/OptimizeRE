<?php
/**
 * Header Menu
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.1
*/



// Outputs the main header menu
if ( ! function_exists( 'wpex_header_aside' ) ) {
	
	function wpex_header_aside() {
		
		// Display header aside for header style 2 only
		$header_style = wpex_get_header_style();
		if ( $header_style !== 'two' ) return;
		
		// Vars
		$content = wpex_option( 'header_aside' );
		$search = wpex_option( 'main_search', '1' ); ?>
		
		<aside id="header-aside" class=" header-two-aside clr">
			<?php
			// Header aside content based on theme option
			if ( $content ) { ?>
				<div class="header-aside-content clr"><?php echo do_shortcode($content); ?></div>
			<?php } ?>
			<?php
			// Show header search field if enabled in the theme options panel
			if ( $search == '1' ) { ?>
				<div id="header-two-search" class="clr">
					<form method="get" class="header-two-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
						<input type="search" id="header-two-search-input" name="s" value="<?php _e( 'search', 'wpex' ); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"/>
						<input type="submit" value="" id="header-two-search-submit" />
						<span class="header-search-icon"></span>
					</form>
				</div><!-- header-search -->
			<?php } ?>
		</aside><!-- #header-two-aside -->
		
	<?php
	} // End function
	
} // End if

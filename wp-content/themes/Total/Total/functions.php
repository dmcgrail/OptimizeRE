<?php
/**
 * Total functions and definitions.
 *
 * Sets up the theme and provides some helper functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */


/*-----------------------------------------------------------------------------------*/
/*	- Define Constants
/*-----------------------------------------------------------------------------------*/

// Assets
define( 'WPEX_JS_DIR_URI', get_template_directory_uri() .'/js/' );
define( 'WPEX_CSS_DIR_UIR', get_template_directory_uri() .'/css/' );

// Skins
define( 'WPEX_SKIN_DIR', get_template_directory() .'/skins' );
define( 'WPEX_SKIN_DIR_URI', get_template_directory_uri() .'/skins' );

// Framework functions & classes
define( 'WPEX_FRAMEWORK_DIR', get_template_directory() .'/framework/' );
define( 'WPEX_FRAMEWORK_DIR_URI', get_template_directory_uri() .'/framework/' );

// Visual Composer Extend
define( 'WPEX_VCEX_DIR', get_template_directory() .'/framework/visual-composer/extend/' );
define( 'WPEX_VCEX_DIR_URI', get_template_directory_uri() .'/framework/visual-composer/extend/' );

/*-----------------------------------------------------------------------------------*/
/*	- Globals + Theme Setup + Main Skin
/*-----------------------------------------------------------------------------------*/

// Core Functions, these are functions used througout the theme and need to load first
require_once ( WPEX_FRAMEWORK_DIR .'core-functions.php' );

// Image overlays - Load first because its needed in the admin
require_once( WPEX_FRAMEWORK_DIR .'loops/overlays.php' );

// Theme setup - load_theme_domain, add_theme_support, register_nav_menus
require_once( WPEX_FRAMEWORK_DIR .'theme-setup.php' );

// Recommend some useful plugins for this theme via TGMA script
require_once ( get_template_directory() .'/plugins/class-tgm-plugin-activation.php' );
require_once( get_template_directory() .'/plugins/recommend-plugins.php' );

/*-----------------------------------------------------------------------------------*/
/*	- ReduxFramework Admin Panel
/*-----------------------------------------------------------------------------------*/

if ( function_exists( 'wpex_supports' ) && wpex_supports( 'primary', 'admin' ) ) {

	// Remove Redux tracking
	require_once( WPEX_FRAMEWORK_DIR .'redux/remove-tracking-class.php' );

	// Include the Redux theme options Framework
	if ( !class_exists( 'ReduxFramework' ) ) {
		require_once( WPEX_FRAMEWORK_DIR .'redux/redux-core/framework.php' );
	}

	// Extensions loader
	require_once( WPEX_FRAMEWORK_DIR. 'redux/extensions-loader.php' );

	// Redux metaboxes
	require_once( WPEX_FRAMEWORK_DIR. 'redux/meta-config.php' );

	// Redux widgets
	require_once( WPEX_FRAMEWORK_DIR. 'redux/widgets-config.php' );

	// Register all the maintheme options
	require_once( WPEX_FRAMEWORK_DIR . 'redux/admin-config.php' );

}

// Returns theme options data for use on the front-end
require_once( WPEX_FRAMEWORK_DIR . 'redux/wpex-option.php' );

/*-----------------------------------------------------------------------------------*/
/*	- Branding & Theme Skin
/*-----------------------------------------------------------------------------------*/

// Define branding constant based on theme options
if ( !function_exists( 'wpex_theme_branding') ) {
	function wpex_theme_branding() {
		return wpex_option( 'theme_branding', 'Total' );
	}
}
define( 'WPEX_THEME_BRANDING', wpex_theme_branding() );

// Active Skin
if ( !function_exists( 'wpex_active_skin') ) {
	function wpex_active_skin() {
		$skin = wpex_option( 'site_theme', 'base' );
		$skin = $skin ? $skin : 'base';
		return $skin;
	}
}
define( 'WPEX_ACTIVE_SKIN', wpex_active_skin() );

/*-----------------------------------------------------------------------------------*/
/*	- Load Skin Class First so it can override things
/*-----------------------------------------------------------------------------------*/
if ( 'base' != wpex_active_skin() && '' != wpex_active_skin() ) {
	$wpex_skin_dir = get_template_directory() .'/skins/'. wpex_active_skin() .'/'. wpex_active_skin() .'-class.php';
	if ( file_exists( $wpex_skin_dir ) ) {
		require_once( $wpex_skin_dir );
	}
}

/*-----------------------------------------------------------------------------------*/
/*	- Active Post Types
/*-----------------------------------------------------------------------------------*/

// Return active custom post types
if ( !function_exists( 'wpex_active_post_types' ) ) {
	function wpex_active_post_types() {
		if ( ! function_exists( 'wpex_theme_post_types' ) ) return;
		$theme_post_types = wpex_theme_post_types();
		$active_post_types = array();
		if ( is_array( $theme_post_types ) ) {
			foreach ( $theme_post_types as $post_type ) {
				if ( wpex_option( $post_type .'_enable', '1' ) ) {
					$active_post_types[$post_type ] = $post_type;
				}
			}
		}
		return apply_filters( 'wpex_active_post_types', $active_post_types );
	}
}
// Set global active post types var
$wpex_active_post_types = wpex_active_post_types();

/*-----------------------------------------------------------------------------------*/
/*	- Hooks - VERY IMPORTANT - DONT DELETE EVER!!
/*-----------------------------------------------------------------------------------*/
if ( ! is_admin() ) {
	require_once( WPEX_FRAMEWORK_DIR .'hooks/hooks.php' );
	require_once( WPEX_FRAMEWORK_DIR .'hooks/actions.php' );
}

/*-----------------------------------------------------------------------------------*/
/*	- CSS / JS
/*-----------------------------------------------------------------------------------*/

// Loads all the core css and js for this theme
require_once( WPEX_FRAMEWORK_DIR .'scripts.php' );

/*-----------------------------------------------------------------------------------*/
/*	- Site Styling, Layout, Custom Fonts
/*-----------------------------------------------------------------------------------*/

// Outputs css for theme panel styling options
require_once( WPEX_FRAMEWORK_DIR .'styling.php' );

// Outputs css for theme panel layout options
require_once( WPEX_FRAMEWORK_DIR .'custom-layout.php' );

// Outputs custom css from theme options
require_once( WPEX_FRAMEWORK_DIR .'custom-css.php' );

// Outputs typography css - fonts
require_once( WPEX_FRAMEWORK_DIR .'typography.php' );

// Used to add CSS to the <head> tag for your custom background settings
require_once( WPEX_FRAMEWORK_DIR .'site-background.php' );

// Custom backgrounds on a per-post basis
require_once( WPEX_FRAMEWORK_DIR .'backgrounds/page-backgrounds.php' );

// Outputs all Theme custom CSS in WP_Head
require_once( WPEX_FRAMEWORK_DIR .'output-css.php' );

// Custom Login screen design
require_once( WPEX_FRAMEWORK_DIR .'custom-login-screen.php' );

/*-----------------------------------------------------------------------------------*/
/*	- Other Theme Functions
/*-----------------------------------------------------------------------------------*/

// Resize and crop images
require_once( WPEX_FRAMEWORK_DIR .'thumbnails/image-resize.php' );

// Assets
require_once( WPEX_FRAMEWORK_DIR .'font-awesome.php' );

// Theme Shortcodes
require_once( WPEX_FRAMEWORK_DIR .'shortcodes/shortcodes.php' );

// Theme Shortcodes
require_once( WPEX_FRAMEWORK_DIR .'thumbnails/honor-ssl-for-attachments.php' );

// Admin Functions
if ( is_admin() ) {

	// Faster Menu Dashboard
	require_once( WPEX_FRAMEWORK_DIR .'faster-menu-dashboard.php' );
	
	// TinyMCE buttons & edits
	require_once( WPEX_FRAMEWORK_DIR .'tinymce/mce-buttons.php' );
		
	// Gallery metabox function used to define images for your gallery post format
	require_once( WPEX_FRAMEWORK_DIR .'meta/gallery-metabox/gmb-admin.php' );
	
	// Function used to display featured images in your dashboard columns
	require_once( WPEX_FRAMEWORK_DIR .'thumbnails/dashboard-thumbnails.php' );
	
	// Layerslider mods
	require_once( WPEX_FRAMEWORK_DIR .'layerslider/layerslider-mods.php' );

	// Ads meta options for users
	require_once( WPEX_FRAMEWORK_DIR .'users/user-meta.php' );

// Non Admin functions
} else {

	// Returns the correct grid class based on column numbers
	require_once( WPEX_FRAMEWORK_DIR .'grid.php' );
	
	// Retuns the correct post layout class
	require_once( WPEX_FRAMEWORK_DIR .'post-layout.php' );
	
	// Adds additional classes to your posts
	require_once( WPEX_FRAMEWORK_DIR .'post-classes.php' );

	// Header meta tags
	require_once( WPEX_FRAMEWORK_DIR .'header/meta-tags.php' );
	
	// Show/hide the main header depending on current post meta
	require_once( WPEX_FRAMEWORK_DIR .'header/header-display.php' );

	// Displays the site toggle bar
	require_once( WPEX_FRAMEWORK_DIR .'toggle-bar.php' );
	
	// Displays the site top-bar
	require_once( WPEX_FRAMEWORK_DIR .'header/top-bar.php' );

	// Returns correct header style
	require_once( WPEX_FRAMEWORK_DIR .'header/header-style.php' );
	
	// Adds custom classes to the header container
	require_once( WPEX_FRAMEWORK_DIR .'header/header-classes.php' );
	
	// Outputs the header logo
	require_once( WPEX_FRAMEWORK_DIR .'header/header-logo.php' );
	
	// Outputs the header menu
	require_once( WPEX_FRAMEWORK_DIR .'header/menu/menu-html.php' );
	
	// Outputs the header logo
	require_once( WPEX_FRAMEWORK_DIR .'header/header-aside.php' );
	
	// Outputs js for your retina logo
	require_once( WPEX_FRAMEWORK_DIR .'header/retina-logo.php' );
	
	// Custom menu walker used to add classes & icons to menus
	require_once( WPEX_FRAMEWORK_DIR .'header/menu/menu-walker.php');
	
	// Outputs HTML and loads scripts for the responsive toggle menu
	require_once( WPEX_FRAMEWORK_DIR .'header/menu/menu-mobile.php' );

	// Main search functions
	require_once( WPEX_FRAMEWORK_DIR .'search/search-functions.php' );
	
	// Adds a search icon at the end of the menu
	require_once( WPEX_FRAMEWORK_DIR .'search/search-menu-icon.php' );
	
	// Get the correct header search toggle style
	$wpex_search_style = wpex_option('main_search_toggle_style','overlay');
	if ( $wpex_search_style == 'overlay' ) {
		require_once( WPEX_FRAMEWORK_DIR .'search/search-overlay.php');
	}
	if ( $wpex_search_style == 'drop_down' ) {
		require_once( WPEX_FRAMEWORK_DIR .'search/search-dropdown.php');
	}
	if ( $wpex_search_style == 'header_replace' ) {
		require_once( WPEX_FRAMEWORK_DIR .'search/search-header-replace.php');
	}

	// Useful blog functions
	require_once( WPEX_FRAMEWORK_DIR .'blog/blog-functions.php' );

	// Displays content for the blog entries
	require_once( WPEX_FRAMEWORK_DIR .'blog/blog-entry.php' );
	
	// Adds custom classes to blog wraps based on blog styles
	require_once( WPEX_FRAMEWORK_DIR .'blog/blog-classes.php' );
	
	// Exclude blog categories from the main blog page / index
	require_once( WPEX_FRAMEWORK_DIR .'blog/blog-exclude-categories.php' );

	// Displays related blog posts
	require_once( WPEX_FRAMEWORK_DIR .'blog/blog-related.php' );

	// Some cool function functions to tweak widgets
	require_once( WPEX_FRAMEWORK_DIR .'widgets/widget-tweaks.php' );
	
	// Returns the correct sidebar region depending on the post/page/archive and theme settings
	require_once( WPEX_FRAMEWORK_DIR .'widgets/get-sidebar.php' );
	
	// Returns the correct cropped or non-cropped featured image URLs - Requires that the AquaResizer is called first
	require_once( WPEX_FRAMEWORK_DIR .'thumbnails/featured-images.php');

	// Returns featured image caption
	require_once( WPEX_FRAMEWORK_DIR .'thumbnails/featured-image-caption.php');
	
	// Outputs code in the <head> tag for your favicons
	require_once( WPEX_FRAMEWORK_DIR .'favicon-apple-icons.php' );
	
	// Outputs css for theme panel responsive width options
	require_once( WPEX_FRAMEWORK_DIR .'responsive-widths.php' );
	
	// Outputs your tracking code in the <head> tag
	require_once( WPEX_FRAMEWORK_DIR .'tracking-code.php' );
	
	// Used to tweak the_excerpt() function and also defines the wpex_excerpt() function
	require_once( WPEX_FRAMEWORK_DIR .'excerpts.php' );
	
	// Creates an array of font awesome icons for use in your theme
	require_once( WPEX_FRAMEWORK_DIR .'font-awesome.php');
	
	// Built-in breadcrumbs function
	require_once( WPEX_FRAMEWORK_DIR .'breadcrumbs.php' );
	
	// The main page title class - displays title/breadcrumbs/title backgrounds/subheading - etc.
	require_once( WPEX_FRAMEWORK_DIR .'page-header.php' );
	
	// Pagination functions - default, infinite scroll and next/prev
	require_once( WPEX_FRAMEWORK_DIR .'pagination.php' );
	
	// Next & Previous single post pagination
	require_once( WPEX_FRAMEWORK_DIR .'next-prev.php' );
	
	// Outputs the post meta for blog posts & entries
	require_once( WPEX_FRAMEWORK_DIR .'post-meta.php' );
	
	// Used for the readmore links on standard posts
	require_once( WPEX_FRAMEWORK_DIR .'post-readmore-link.php' );
	
	// Function used to alter the number of posts displayed for your custom post type archives
	require_once( WPEX_FRAMEWORK_DIR .'posts-per-page.php' );
	
	// Comments callback function
	require_once( WPEX_FRAMEWORK_DIR .'comments-callback.php');
	
	// Increase the quality of resized jpgs
	require_once( WPEX_FRAMEWORK_DIR .'thumbnails/better-jpgs.php' );

	// Used to display images defined by the gallery metabox function
	require_once( WPEX_FRAMEWORK_DIR .'meta/gallery-metabox/gmb-display.php' );
	
	// Used to display your post slider as defined in the wpex_post_slider meta value
	require_once( WPEX_FRAMEWORK_DIR .'post-slider.php' );
	
	// Outputs the social sharing icons for posts and pages
	require_once( WPEX_FRAMEWORK_DIR .'social/social-share.php' );
	
	// Alter the default output of the WordPress gallery shortcode
	if ( wpex_option( 'custom_wp_gallery', '1' ) == '1' ) {
		require_once( WPEX_FRAMEWORK_DIR .'wp-gallery.php');
	}

	// Responsive videos support
	require_once( WPEX_FRAMEWORK_DIR .'responsive-videos.php' );

	// Add bbPress post type to search
	require_once( WPEX_FRAMEWORK_DIR .'bbpress/bbpress-search.php' );

	// Check if user has social options
	require_once( WPEX_FRAMEWORK_DIR .'users/user-has-social.php' );
	
} // End else - is_admin()

// Define the widget areas for this theme
require_once( WPEX_FRAMEWORK_DIR .'widgets/widget-areas.php' );

// Register custom widgets for the front-end and widgets screen
require_once( WPEX_FRAMEWORK_DIR .'widgets/custom-widgets.php' );

// Footer functions
if ( !is_admin() ) {
	
	// Show/hide the main footer depending on current post meta
	require_once( WPEX_FRAMEWORK_DIR .'footer/footer-display.php' );
	
	// Show/hide the footer callout depending on current post meta
	require_once( WPEX_FRAMEWORK_DIR .'footer/footer-callout.php' );
	
	// The footer widgets
	require_once( WPEX_FRAMEWORK_DIR .'footer/footer-widgets.php' );
	
	// Displays the copyright info in the footer
	require_once( WPEX_FRAMEWORK_DIR .'footer/footer-bottom.php' );
	
	// Scroll to top link function
	require_once( WPEX_FRAMEWORK_DIR .'footer/scroll-top-link.php');
	
}

// Meta fields for Standard Categories
require_once( WPEX_FRAMEWORK_DIR .'meta/taxonomies/category-meta.php');

// A few small optimizations for speed - clean up the <head>, remove useless jetpack scripts, etc.
require_once( WPEX_FRAMEWORK_DIR .'optimizations.php');

// Get the correct Template parts
require_once( WPEX_FRAMEWORK_DIR .'template-parts.php' );

// Alter the password protection form
require_once( WPEX_FRAMEWORK_DIR .'password-protection-form.php' );


/*-----------------------------------------------------------------------------------*/
/*	- Ads new body classes
/*-----------------------------------------------------------------------------------*/
require_once( WPEX_FRAMEWORK_DIR .'body-classes.php' );


/*-----------------------------------------------------------------------------------*/
/*	- Portfolio Post Type
/*-----------------------------------------------------------------------------------*/

if ( in_array( 'portfolio', $wpex_active_post_types ) ) {
	
	// Register the portfolio post type
	require_once( WPEX_FRAMEWORK_DIR .'posttypes-taxonomies/register-portfolio.php' );

	// Displays portfolio media on single posts
	require_once( WPEX_FRAMEWORK_DIR .'portfolio/portfolio-single-media.php' );

	// Portfolio Post Featured Video
	require_once( WPEX_FRAMEWORK_DIR .'portfolio/portfolio-featured-video.php' );
	
	// Displays an array of portfolio categories
	require_once( WPEX_FRAMEWORK_DIR .'portfolio/portfolio-categories.php' );
	
	// Displays related portfolio items
	require_once( WPEX_FRAMEWORK_DIR .'portfolio/portfolio-related.php' );

	// Portfolio Entry Content
	require_once( WPEX_FRAMEWORK_DIR .'portfolio/portfolio-entry.php' );

}

/*-----------------------------------------------------------------------------------*/
/*	- Post Series custom Taxonomy
/*-----------------------------------------------------------------------------------*/

if ( wpex_option( 'post_series', '1' ) ) {
	
	// Registers the post series custom taxonomy for the standard post type
	require_once( WPEX_FRAMEWORK_DIR .'posttypes-taxonomies/register-post-series.php' );
	
}

require_once( WPEX_FRAMEWORK_DIR .'blog/post-series.php' );

/*-----------------------------------------------------------------------------------*/
/*	- Staff Post Type
/*-----------------------------------------------------------------------------------*/

if ( in_array( 'staff', $wpex_active_post_types ) ) {
	
	// Register the staff custom post type
	require_once( WPEX_FRAMEWORK_DIR .'posttypes-taxonomies/register-staff.php' );
	
}

// Used to display the social options for your staff members
require_once( WPEX_FRAMEWORK_DIR .'staff/staff-social.php' );

if ( ! is_admin() ) {
	
	// Staff entry image overlay
	require_once( WPEX_FRAMEWORK_DIR .'staff/staff-overlay.php' );
	
	// Related staff posts
	require_once( WPEX_FRAMEWORK_DIR .'staff/staff-related.php' );

	// Staff Entry Details
	require_once( WPEX_FRAMEWORK_DIR .'staff/staff-entry.php' );

}

/*-----------------------------------------------------------------------------------*/
/*	- Testimonials Post Type
/*-----------------------------------------------------------------------------------*/

if ( in_array( 'testimonials', $wpex_active_post_types ) ) {
	
	// Register the testimonials custom post type
	require_once( WPEX_FRAMEWORK_DIR .'posttypes-taxonomies/register-testimonials.php' );
	
}

/*-----------------------------------------------------------------------------------*/
/*	- Custom Post Type & Taxonomy Functions
/*-----------------------------------------------------------------------------------*/

if ( ! empty( $wpex_active_post_types ) ) {

	// Function used to alter your post type labels via theme options
	require_once( WPEX_FRAMEWORK_DIR .'posttypes-taxonomies/post-type-labels.php' );

	// Function used to alter your taxonomy labels via theme options
	require_once( WPEX_FRAMEWORK_DIR .'posttypes-taxonomies/taxonomies-labels.php' );

	// Tweak custom post types based on theme options
	require_once( WPEX_FRAMEWORK_DIR .'posttypes-taxonomies/tweak.php' );

}

/*-----------------------------------------------------------------------------------*/
/*	- WooCommerce
/*-----------------------------------------------------------------------------------*/

// WooCommerce specific functions
if ( class_exists( 'Woocommerce' ) ) {
	
	if ( ! is_admin() ) {
	
		// Adds classes for the WooCommerce main layouts - sidebar, no sidebar, etc.
		require_once( WPEX_FRAMEWORK_DIR .'woocommerce/woo-layouts.php' );
		
		// Remove Woo scripts
		require_once( WPEX_FRAMEWORK_DIR .'woocommerce/woo-scripts.php' );
		
		// Alter WooCommerce columns/pagination
		require_once( WPEX_FRAMEWORK_DIR .'woocommerce/woo-columns.php' );
		
		// Change default Woo Image sizes
		require_once( WPEX_FRAMEWORK_DIR .'woocommerce/woo-images.php' );
		
		// Product entry media - featured image / slider / image swap
		require_once( WPEX_FRAMEWORK_DIR .'woocommerce/woo-product-entry-media.php' );
		
		// Overrides the default WooCommerce category image output
		require_once( WPEX_FRAMEWORK_DIR .'woocommerce/woo-category-image.php' );

		// Other Woo Tweaks
		require_once( WPEX_FRAMEWORK_DIR .'woocommerce/woo-other-tweaks.php' );
	
	} // End if is admin

	// Display shopping cart $ in the nav
	if ( wpex_option( 'woo_menu_icon', '1' ) ) {
		require_once( WPEX_FRAMEWORK_DIR .'woocommerce/woo-menucart.php' );
	}
	
}

// Cart widget displays current cart items
if ( ! is_admin() ) {
	require_once( WPEX_FRAMEWORK_DIR .'woocommerce/woo-cartwidget-overlay.php' );
	require_once( WPEX_FRAMEWORK_DIR .'woocommerce/woo-cartwidget-dropdown.php' );
}


/*-----------------------------------------------------------------------------------*/
/*	- Visual Composer Extension
/*	- Adds more useful modules to the Visual Composer
/*-----------------------------------------------------------------------------------*/
if( function_exists( 'vc_set_as_theme' ) ) {

	// Run the Visual Composer Extension Pluin
	if ( function_exists( 'visual_composer_extension_run' ) ) {
		// Admin notice
		function vcex_admin_notice() { ?>
			<div class="error">
				<h4><?php _e( 'IMPORTANT NOTICE', 'wpex' ); ?></h4>
				<p><?php _e( 'The Visual Composer Extension Plugin (not WPBakery VC but the extension created by WPExplorer) for this theme is now built-in, please de-activate and if you want delete the plugin.', 'wpex' ); ?>
				<br /><br />
				<a href="<?php echo admin_url( 'plugins.php?plugin_status=active' ); ?>" class="button button-primary" target="_blank"><?php _e( 'Deactivate', 'wpex' ); ?> &rarr;</a>
				<a href="http://themeforest.net/item/total-responsive-multipurpose-wordpress-theme/6339019/faqs/20545" class="button button-primary" target="_blank"><?php _e( 'Learn More', 'wpex' ); ?> &rarr;</a></p>
				<p></p>
			</div>
		<?php
		}
		add_action( 'admin_notices', 'vcex_admin_notice' );
	}

	// Extend the visual composer
	require_once( WPEX_FRAMEWORK_DIR .'visual-composer/extend/extend.php' );
}


/*-----------------------------------------------------------------------------------*/
/*	- Visual Composer Tweaks
/*-----------------------------------------------------------------------------------*/

// Set composer settings pages as settings page.
if( function_exists( 'vc_set_as_theme' ) ) {
	
	// Set Visual Composer to run in Theme Mode
	function wpex_set_vc_as_theme() {
		if ( ! wpex_option( 'visual_composer_theme_mode', '1' ) ) {
			return;
		}
		vc_set_as_theme( $notifier = false );
	}
	add_action( 'init', 'wpex_set_vc_as_theme' );
	
	// Remove certain default VC modules
	require_once( WPEX_FRAMEWORK_DIR .'visual-composer/core/remove.php' );
	
	// Add new parameters to VC items
	require_once( WPEX_FRAMEWORK_DIR .'visual-composer/core/add-params.php' );
	
	// Visual Composer Filter tweaks
	require_once( WPEX_FRAMEWORK_DIR .'visual-composer/core/filters.php' );

}


/*-----------------------------------------------------------------------------------*/
/*	- Helpers
/*-----------------------------------------------------------------------------------*/

// Displays the number of queries and memory on page load
require_once( WPEX_FRAMEWORK_DIR .'troubleshooting/display-queries-memory.php' );

/*-----------------------------------------------------------------------------------*/
/*	- WP-Updates
/*-----------------------------------------------------------------------------------*/

// Get user envato license as provided in theme panel
$wpex_envato_license_key = wpex_option( 'envato_license_key' );

// If envato license is defined load the auto update class and pass the license to it
if ( $wpex_envato_license_key && wpex_option( 'enable_auto_updates', '0' ) ) {
	require_once( get_template_directory() .'/wp-updates-theme.php');
	new WPUpdatesThemeUpdater_479( 'http://wp-updates.com/api/2/theme', basename( get_template_directory() ), $wpex_envato_license_key );
}
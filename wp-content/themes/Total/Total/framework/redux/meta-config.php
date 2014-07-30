<?php
/**
 * Creates the options array for the Redux Framework
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link  http://www.wpexplorer.com
 * @since Total 1.52
*/

if ( !function_exists( "redux_add_metaboxes" ) ) :
	function redux_add_metaboxes($metaboxes) {

		// ID prefix
		$prefix = 'wpex_';

		// Define arrays
		$metaboxes = array();

		// Title Styles
		$title_styles = array(
			''					=> __( 'Default', 'wpex' ),
			'centered'			=> __( 'Centered', 'wpex' ),
			'centered-minimal'	=> __( 'Centered Minimal', 'wpex' ),
			'background-image'	=> __( 'Background Image', 'wpex' ),
			'solid-color'		=> __( 'Solid Color & White Text', 'wpex' ),
		);
		$title_styles = apply_filters( 'wpex_title_styles', $title_styles );

		// Menus
		$menus_array = array();
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
		$menus_array['default'] = __( 'Default', 'wpex' );
		foreach ( $menus as $menu) {
			$menus_array[$menu->term_id] = $menu->name;
		}

		/**
			Main
		**/
		$main_settings[] = array(
			'title'		=> __( 'Main', 'wpex' ),
			'icon'		=> 'el-icon-cog',
			'fields'	=> array(
				array(
					'title'		=> __( 'Site Layout', 'wpex' ),
					'type'		=> 'select',
					'id'		=> $prefix . 'main_layout',
					'subtitle'	=> __( 'Select the layout for your site. This option should only be used in very specific cases such as landpages. Use the theme option to control globally.', 'wpex' ),
					'options'	=> array(
						''		=> __( 'Default', 'wpex' ),
						'full-width'	=> __( 'Full-Width', 'wpex' ),
						'boxed'			=> __( 'Boxed', 'wpex' ),
					),
					'default'	=> '',
				),
				array(
					'title'		=> __( 'Content Layout', 'wpex' ),
					'type'		=> 'select',
					'id'		=> $prefix . 'post_layout',
					'subtitle'	=> __('Select your custom layout for this page or post content.', 'wpex'),
					'options'	=> array(
						''				=> __( 'Default', 'wpex' ),
						'right-sidebar'	=> __( 'Right Sidebar', 'wpex' ),
						'left-sidebar'	=> __( 'Left Sidebar', 'wpex' ),
						'full-width'	=> __( 'No Sidebar', 'wpex' ),
						'full-screen'	=> __( 'Full Screen', 'wpex' ),
					),
					'default'	=> '',
				),
				array(
					'title'		=> __( 'Custom Menu', 'wpex' ),
					'type'		=> 'select',
					'id'		=> $prefix . 'custom_menu',
					'subtitle'	=> __( 'Select a custom menu for this page or post.', 'wpex' ),
					'options'	=> $menus_array,
					'default'	=> 'default',
				),
				array(
					'title'		=> __( 'Toggle Bar', 'wpex' ),
					'subtitle'	=> __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'id'		=> $prefix . 'disable_toggle_bar',
					'type'		=> 'button_set',
					'options'	=> array(
						''		=> 'Enable',
						'on'	=> 'Disable',
					),
					'default'	=> '',
				),
				array(
					'title'		=> __( 'Top Bar', 'wpex' ),
					'subtitle'	=> __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'id'		=> $prefix . 'disable_top_bar',
					'type'		=> 'button_set',
					'options'	=> array(
						''		=> 'Enable',
						'on'	=> 'Disable',
					),
					'default'	=> '',
				),
				array(
					'title'		=> __( 'Header', 'wpex' ),
					'subtitle'	=> __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'id'		=> $prefix . 'disable_header',
					'type'		=> 'button_set',
					'options'	=> array(
						''		=> 'Enable',
						'on'	=> 'Disable',
					),
					'default'	=> '',
				),
				array(
					'title'		=> __( 'Breadcrumbs', 'wpex' ),
					'subtitle'	=> __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'id'		=> $prefix . 'disable_breadcrumbs',
					'type'		=> 'button_set',
					'options'	=> array(
						''		=> 'Enable',
						'on'	=> 'Disable',
					),
					'default'	=> '',
				),
				array(
					'title'		=> __( 'Social Share', 'wpex' ),
					'subtitle'	=> __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'id'		=> $prefix . 'disable_social',
					'type'		=> 'button_set',
					'options'	=> array(
						''		=> 'Enable',
						'on'	=> 'Disable',
					),
					'default'	=> '',
				),
				array(
					'title'		=> __( 'Footer Callout', 'wpex' ),
					'subtitle'	=> __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'id'		=> $prefix . 'disable_footer_callout',
					'type'		=> 'button_set',
					'options'	=> array(
						''		=> 'Enable',
						'on'	=> 'Disable',
					),
					'default'	=> '',
				),
				array(
					'title'		=> __( 'Footer', 'wpex' ),
					'subtitle'	=> __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'id'		=> $prefix . 'disable_footer',
					'type'		=> 'button_set',
					'options'	=> array(
						''		=> 'Enable',
						'on'	=> 'Disable',
					),
					'default'	=> '',
				),
			),
		);

		/**
			Title
		**/
		$main_settings[] = array(
			'title'		=> __( 'Title', 'wpex' ),
			'icon'		=> 'el-icon-tumblr',
			'fields'	=> array(
				array(
					'title'		=> __( 'Title', 'wpex' ),
					'subtitle'	=> __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'id'		=> $prefix . 'disable_title',
					'type'		=> 'button_set',
					'options'	=> array(
						''		=> 'Enable',
						'on'	=> 'Disable',
					),
					'default'	=> '',
				),
				array(
					'title'		=> __( 'Title Margin', 'wpex' ),
					'id'		=> $prefix . 'disable_header_margin',
					'subtitle'	=> __( 'Enable or disable this element on this page or post.', 'wpex' ),
					'type'		=> 'button_set',
					'options'	=> array(
						''		=> 'Enable',
						'on'	=> 'Disable',
					),
					'default'	=> '',
				),
				array(
					'title'		=> __( 'Subheading', 'wpex' ),
					'type'		=> 'text',
					'id'		=> $prefix . 'post_subheading',
					'subtitle'	=> __( 'Enter your page subheading. Shortcodes & HTML is allowed.', 'wpex' ),
					'default'	=> '',
				),
				array(
					'title'		=> __( 'Title Style', 'wpex' ),
					'type'		=> 'select',
					'id'		=> $prefix . 'post_title_style',
					'subtitle'	=> __( 'Select a custom title style for this page or post.', 'wpex' ),
					'options'	=> $title_styles,
					'default'	=> '',
				),
				array(
					'title'			=> __( 'Title: Background Color', 'wpex' ),
					'subtitle'		=> __( 'Select a custom background color for your main title.', 'wpex' ),
					'id'			=> $prefix .'post_title_background_color',
					'type'			=> 'color',
					'output'		=> false,
					'default'		=> '',
					'validate'		=> false,
					'transparent'	=> false,
					'required'		=> array (
						array( $prefix .'post_title_style', '=', array( 'background-image', 'solid-color' ) ),
					),
				),
				array(
					'title'		=> __( 'Title: Background Image', 'wpex'),
					'id'		=> $prefix . 'post_title_background_redux',
					'type'		=> 'media',
					'url'		=> true,
					'compiler'	=> 'false',
					'subtitle'	=> __( 'Select a custom header image for your main title.', 'wpex' ),
					'default'	=>array(
						'url'	=>''
					),
					'required'		=> array( $prefix .'post_title_style', '=', 'background-image' ),
				),
				array(
					'title'		=> __( 'Title: Background Height', 'wpex' ),
					'type'		=> 'text',
					'id'		=> $prefix . 'post_title_height',
					'subtitle'	=> __( 'Select your custom height for your title background. Default is 400px.', 'wpex' ),
					'default'	=> '',
					'required'		=> array( $prefix .'post_title_style', '=', 'background-image' ),
				),
				array(
					'title'		=> __( 'Title: Background Overlay', 'wpex' ),
					'type'		=> 'select',
					'id'		=> $prefix . 'post_title_background_overlay',
					'subtitle'	=> __( 'Select an overlay for the title background.', 'wpex' ),
					'options'	=> array(
						'none'			=> __( 'None', 'wpex' ),
						'dark'		=> __( 'Dark', 'wpex' ),
						'dotted'	=> __( 'Dotted', 'wpex' ),
						'dashed'	=> __( 'Diagonal Lines', 'wpex' ),
					),
					'default'	=> '',
					'required'		=> array( $prefix .'post_title_style', '=', 'background-image' ),
				),
				array(
					'id'			=> $prefix . 'post_title_background_overlay_opacity',
					'type'			=> 'slider',
					'title'			=> __( 'Title: Background Overlay Opacity', 'wpex' ),
					'subtitle'		=> __( 'Select a custom opacity for your title background overlay.', 'wpex' ),
					'default'		=> .5,
					'min'			=> 0,
					'step'			=> .1,
					'max'			=> 1,
					'resolution'	=> 0.1,
					'display_value'	=> 'text',
					'required'		=> array( $prefix .'post_title_style', '=', 'background-image' ),
				),
			),
		);

		/**
			Slider
		**/
		$main_settings[] = array(
			'title'		=> __( 'Slider', 'wpex' ),
			'icon'		=> 'el-icon-website',
			'fields'	=> array(
				array(
					'title'		=> __( 'Slider Shortcode', 'wpex' ),
					'type'		=> 'text',
					'id'		=> $prefix . 'post_slider_shortcode',
					'subtitle'	=> __( 'Enter a slider shortcode here to display a slider at the top of the page.', 'wpex' ),
					'default'	=> '',
				),
				array(
					'title'		=> __( 'Slider Mobile Alternative', 'wpex' ),
					'type'		=> 'media',
					'id'		=> $prefix . 'post_slider_mobile_alt',
					'subtitle'	=> __( 'Display an alternative for mobile devices. Uses the wp_is_mobile WordPress function. That means it will display for tables and phones. The idea is to speed things up.', 'wpex' ),
					'type'		=> 'media',
					'url'		=> true,
					'compiler'	=> 'false',
					'default'	=>array(
						'url'	=>''
					),
				),
				array(
					'title'		=> __( 'Slider Position', 'wpex' ),
					'type'		=> 'select',
					'id'		=> $prefix . 'post_slider_shortcode_position',
					'subtitle'	=> __( 'Select the position for the slider shortcode.', 'wpex' ),
					'options'	=> array(
						'below_title'	=> __( 'Below Title', 'wpex' ),
						'above_title'	=> __( 'Above Title', 'wpex' ),
						'above_menu'	=> __( 'Above Menu (Header 2 or 3)', 'wpex' ),
						'above_header'	=> __( 'Above Header', 'wpex' ),
						'above_topbar'	=> __( 'Above Top Bar', 'wpex' ),
					),
					'default'	=> 'below_title',
					'required'	=> array( $prefix . 'post_slider_shortcode', '!=', '' ),
				),
				array(
					'title'		=> __( 'Slider Bottom Margin', 'wpex' ),
					'subtitle'	=> __( 'Enter a bottom margin for your slider in pixels', 'wpex' ),
					'id'		=> $prefix . 'post_slider_bottom_margin',
					'type'		=> 'text',
					'default'	=> '',
					'required'	=> array( $prefix . 'post_slider_shortcode', '!=', '' ),
				),
			),
		);

		/**
			Background
		**/
		$main_settings[] = array(
			'title'		=> __( 'Background', 'wpex' ),
			'icon'		=> 'el-icon-picture',
			'fields'	=> array(
				array(
					'title'			=> __( 'Page: Background Color', 'wpex' ),
					'subtitle'		=> __( 'Select a custom background color for this page.', 'wpex' ),
					'id'			=> $prefix . 'page_background_color',
					'type'			=> 'color',
					'output'		=> false,
					'default'		=> '',
					'validate'		=> false,
					'transparent'	=> false,
				),
				array(
					'title'		=> __( 'Page: Background Image', 'wpex' ),
					'id'		=> $prefix . 'page_background_image_redux',
					'type'		=> 'media',
					'url'		=> true,
					'compiler'	=> 'false',
					'subtitle'	=> __( 'Select a custom background image for this page.', 'wpex' ),
					'default'	=>array(
						'url'	=>''
					),
				),
				array(
					'title'		=> __( 'Page: Background Style', 'wpex' ),
					'type'		=> 'select',
					'id'		=> $prefix . 'page_background_image_style',
					'subtitle'	=> __( 'Select the style for your page background.', 'wpex' ),
					'options'	=> array(
						''			=> __( 'Default', 'wpex' ),
						'repeat'	=> __( 'Repeat', 'wpex' ),
						'fixed'		=> __( 'Fixed', 'wpex' ),
						'stretched'	=> __( 'Streched', 'wpex' ),
					),
					'default'	=> '',
				),
			),
		);

		/**
		Set Main settings array for all post types
		**/
		$page_settings = $post_settings = $staff_settings = $portfolio_settings = $main_settings;

		/**
			Formats
		**/
		$post_settings[] = array(
			'title'		=> __( 'Media', 'wpex' ),
			'icon'		=> 'el-icon-video',
			'fields'	=> array(
				array(
					'title'		=> __( 'Media Display/Position', 'wpex' ),
					'id'		=> $prefix . 'post_media_position',
					'type'		=> 'select',
					'subtitle'	=> __( 'Select your preferred position for your post\'s media (featured image or video).', 'wpex' ),
					'options'	=> array(
						''			=> __( 'Default', 'wpex' ),
						'above'		=> __( 'Full-Width Above Content', 'wpex' ),
						'hidden'	=> __( 'None (Do Not Display Featured Image/Video)', 'wpex' ),
						'value'		=> 'hidden',
					),
				),
				array(
					'title'		=> __( 'oEmbed URL', 'wpex' ),
					'subtitle'	=>  __( 'Enter a URL that is compatible with WP\'s built-in oEmbed feature. This setting is used for your video and audio post formats.', 'wpex' ) .'<br /><a href="http://codex.wordpress.org/Embeds" target="_blank">'. __( 'Learn More', 'wpex' ) .' &rarr;</a>',
					'id'		=> $prefix . 'post_oembed',
					'type'		=> 'text',
					'std'		=> ''
				),
				array(
					'title'		=> __( 'Self Hosted', 'wpex' ),
					'subtitle'	=> __( 'Insert your self hosted video or audio url here.', 'wpex' ) .'<br /><a href="http://make.wordpress.org/core/2013/04/08/audio-video-support-in-core/" target="_blank">'. __( 'Learn More', 'wpex' ) .' &rarr;</a>',
					'id'		=> $prefix . 'post_self_hosted_shortcode_redux',
					'type'		=> 'media',
					'url'		=> true,
					'preview'	=> false,
					'mode'		=> false,
					'std'		=> ''
				),
			),
		);

		/**
			Staff Settings
		**/
		$staff_settings[] = array(
			'title'		=> apply_filters( 'wpex_staff_meta_tab_title', __( 'Staff', 'wpex' ) ),
			'icon'		=> 'el-icon-user',
			'fields'	=> array(
				array(
					'title'		=> __( 'Position', 'wpex' ),
					'id'		=> $prefix .'staff_position',
					'type'		=> 'text',
					'std'		=> '',
				),
				array(
					'title'		=> __( 'Twitter URL', 'wpex' ),
					'id'		=> $prefix .'staff_twitter',
					'type'		=> 'text',
					'std'		=> '',
				),
				array(
					'title'		=> __( 'Facebook URL', 'wpex' ),
					'id'		=> $prefix .'staff_facebook',
					'type'		=> 'text',
					'std'		=> '',
				),
				array(
					'title'		=> __( 'Google Plus URL', 'wpex' ),
					'id'		=> $prefix .'staff_google-plus',
					'type'		=> 'text',
					'std'		=> '',
				),
				array(
					'title'		=> __( 'Dribbble URL', 'wpex' ),
					'id'		=> $prefix .'staff_dribbble',
					'type'		=> 'text',
					'std'		=> '',
				),
				array(
					'title'		=> __( 'LinkedIn URL', 'wpex' ),
					'id'		=> $prefix .'staff_linkedin',
					'type'		=> 'text',
					'std'		=> '',
				),
				array(
					'title'		=> __( 'Skype URL', 'wpex' ),
					'id'		=> $prefix .'staff_skype',
					'type'		=> 'text',
					'std'		=> '',
				),
				array(
					'title'		=> __( 'Email URL', 'wpex' ),
					'id'		=> $prefix .'staff_email',
					'type'		=> 'text',
					'std'		=> '',
				),
			),
		);

		/**
			Portfolio Settings
		**/
		$portfolio_settings[] = array(
			'title'		=> apply_filters( 'wpex_portfolio_meta_tab_title', __( 'Portfolio', 'wpex' ) ),
			'icon'		=> 'el-icon-briefcase',
			'fields'	=> array(
				array(
					'title'		=> __( 'Featured Video', 'wpex' ),
					'subtitle'		=> __( 'Define a featured video URL for this portfolio post.', 'wpex' ),
					'id'		=> $prefix .'post_video',
					'type'		=> 'text',
					'std'		=> '',
				),
			),
		);

		/**
			Testimonials Settings
		**/
		$testimonials_settings[] = array(
			'title'		=> '',
			'icon'		=> 'el-icon-briefcase',
			'fields'	=> array(
				array(
					'title'		=> __( 'Author', 'wpex' ),
					'subtitle'		=> __( 'Enter the name of the author for this testimonial.', 'wpex' ),
					'id'		=> $prefix .'testimonial_author',
					'type'		=> 'text',
					'std'		=> '',
				),
				
				array(
					'title'		=> __( 'Company', 'wpex' ),
					'subtitle'		=> __( 'Enter the name of the company for this testimonial.', 'wpex' ),
					'id'		=> $prefix .'testimonial_company',
					'type'		=> 'text',
					'std'		=> '',
				),
				
				array(
					'title'		=> __( 'Company URL', 'wpex' ),
					'subtitle'		=> __( 'Enter the url for the company for this testimonial.', 'wpex' ),
					'id'		=> $prefix .'testimonial_url',
					'type'		=> 'text',
					'std'		=> '',
				),
			),
		);

		/**
			Sidebar Options
		**/
		$sidebar_options = array();
		$sidebar_options[] = array(
			'fields'	=> array(
				array(
					'id' => 'sidebar',
					'title' => __( 'Sidebar', 'wpex' ),
					'desc' => 'Please select the sidebar you would like to display on this page. Note: You must first create the sidebar under Appearance > Widgets.',
					'type' => 'select',
					'data' => 'sidebars',
					'default' => 'None',
				),
			),
		);

		/**
			Define the Metaboxes
		**/

		// Pages, products, tribe events
		$metaboxes[] = array(
			'id'			=> 'total-page-metaboxes',
			'title'			=> __( 'Page Settings', 'wpex' ),
			'post_types'	=> apply_filters( 'wpex_main_metaboxes_post_types', array( 'page', 'product', 'tribe_events' ) ),
			'position'		=> 'normal',
			'priority'		=> 'high',
			'sidebar'		=> true,
			'sections'		=> $page_settings
		);

		// Posts
		$metaboxes[] = array(
			'id'			=> 'total-post-metaboxes',
			'title'			=> __( 'Post Settings', 'wpex' ),
			'post_types'	=> array( 'post' ),
			'position'		=> 'normal',
			'priority'		=> 'high',
			'sidebar'		=> true,
			'sections'		=> $post_settings
		);

		// Staff
		$metaboxes[] = array(
			'id'			=> 'total-staff-metaboxes',
			'title'			=> __( 'Post Settings', 'wpex' ),
			'post_types'	=> array( 'staff' ),
			'position'		=> 'normal',
			'priority'		=> 'high',
			'sidebar'		=> true,
			'sections'		=> $staff_settings
		);

		// Portfolio
		$metaboxes[] = array(
			'id'			=> 'total-portfolio-metaboxes',
			'title'			=> __( 'Post Settings', 'wpex' ),
			'post_types'	=> array( 'portfolio' ),
			'position'		=> 'normal',
			'priority'		=> 'high',
			'sidebar'		=> true,
			'sections'		=> $portfolio_settings
		);

		// Testimonials
		$metaboxes[] = array(
			'id'			=> 'total-testimonials-metaboxes',
			'title'			=> __( 'Post Settings', 'wpex' ),
			'post_types'	=> array( 'testimonials' ),
			'position'		=> 'normal',
			'priority'		=> 'high',
			'sidebar'		=> true,
			'sections'		=> $testimonials_settings
		);

		// Sidebar
		$metaboxes[] = array(
			'id'			=> 'page-options',
			'title'			=> __( 'Sidebar', 'wpex' ),
			'post_types'	=> array( 'page', 'post', 'portfolio', 'staff', 'product', 'tribe_events' ),
			'position'		=> 'side',
			'priority'		=> 'default',
			'sidebar'		=> false,
			'sections'		=> $sidebar_options,
		);

		return $metaboxes;
	}

	add_action( 'redux/metaboxes/wpex_options/boxes', 'redux_add_metaboxes' );

endif;
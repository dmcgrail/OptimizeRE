<?php
/**
 * Creates the options array for the Redux Framework
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link  http://www.wpexplorer.com
 * @since Total 1.0
*/

if ( !class_exists( "ReduxFramework" ) ) {
	return;
}

if ( !class_exists( "WPEX_Redux_Main_Theme_Options" ) ) {

	class WPEX_Redux_Main_Theme_Options {

		/**
			Public Vars
		**/
		public $args = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		/**
			Constructor
		**/
		public function __construct( ) {

			if ( !class_exists( 'ReduxFramework' ) ) {
				return;
			}

			// Initiate the settings
			$this->initSettings();

			// Loads a custom.css file to tweak the admin design for WP 3.8
			add_action('redux-enqueue-wpex_options', array( $this, 'redux_custom_css' ) ) ;

		} // End Construct

		/**
		Initiate Settings
		**/
		public function initSettings() {

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();

			// Create the sections and fields
			$this->setSections();

			if (!isset($this->args['opt_name'])) { // No errors please
				return;
			}

			$this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
		}

		/**
		Return Sections
		**/
		public function getReduxSections() {
			return $this->sections;
		}

		/**
			Custom Admin Design
		**/
		public function redux_custom_css() {
			global $wp_version;
			if ( $wp_version >= 3.8 ) {
				wp_register_style( 'redux-custom-css', WPEX_FRAMEWORK_DIR_URI .'redux/redux-custom.css', array( 'redux-css' ), '', 'all' );  
				wp_enqueue_style('redux-custom-css');
			}
		}

		/**
			Set Sections
		**/
		public function setSections() {

			$sections = array();

			// Skins Args
			$total_skins = wpex_skins();
			$skins = array();
			foreach ( $total_skins as $key => $value ) {
				$skins[$key] = $total_skins[$key]['name'];
			}

			// Theme Post Types
			$theme_post_types = wpex_theme_post_types();

			// Array of dashicons
			$wpex_dashicons = array('admin-appearance','admin-collapse','admin-comments','admin-generic','admin-home','admin-media','admin-network','admin-page','admin-plugins','admin-settings','admin-site','admin-tools','admin-users','align-center','align-left','align-none','align-right','analytics','arrow-down','arrow-down-alt','arrow-down-alt2','arrow-left','arrow-left-alt','arrow-left-alt2','arrow-right','arrow-right-alt','arrow-right-alt2','arrow-up','arrow-up-alt','arrow-up-alt2','art','awards','backup','book','book-alt','businessman','calendar','camera','cart','category','chart-area','chart-bar','chart-line','chart-pie','clock','cloud','dashboard','desktop','dismiss','download','edit','editor-aligncenter','editor-alignleft','editor-alignright','editor-bold','editor-customchar','editor-distractionfree','editor-help','editor-indent','editor-insertmore','editor-italic','editor-justify','editor-kitchensink','editor-ol','editor-outdent','editor-paste-text','editor-paste-word','editor-quote','editor-removeformatting','editor-rtl','editor-spellcheck','editor-strikethrough','editor-textcolor','editor-ul','editor-underline','editor-unlink','editor-video','email','email-alt','exerpt-view','facebook','facebook-alt','feedback','flag','format-aside','format-audio','format-chat','format-gallery','format-image','format-links','format-quote','format-standard','format-status','format-video','forms','googleplus','groups','hammer','id','id-alt','image-crop','image-flip-horizontal','image-flip-vertical','image-rotate-left','image-rotate-right','images-alt','images-alt2','info','leftright','lightbulb','list-view','location','location-alt','lock','marker','menu','migrate','minus','networking','no','no-alt','performance','plus','portfolio','post-status','pressthis','products','redo','rss','screenoptions','search','share','share-alt','share-alt2','share1','shield','shield-alt','slides','smartphone','smiley','sort','sos','star-empty','star-filled','star-half','tablet','tag','testimonial','translation','trash','twitter','undo','update','upload','vault','video-alt','video-alt2','video-alt3','visibility','welcome-add-page','welcome-comments','welcome-edit-page','welcome-learn-more','welcome-view-site','welcome-widgets-menus','wordpress','wordpress-alt','yes');
			$wpex_dashicons = array_combine($wpex_dashicons,$wpex_dashicons);

			// Array of social sharing sites
			$social_sharing_sites =  array(
				'twitter'		=> 'Twitter',
				'facebook'		=> 'Facebook',
				'google_plus'	=> 'Google Plus',
				'pinterest'		=> 'Pinterest',
				'linkedin'		=> 'LinkedIn',
			);
			$social_sharing_sites = apply_filters( 'wpex_social_sharing_sites', $social_sharing_sites );

			// Array of social options
			$social_options = array(
				'twitter'		=> 'twitter.com/wpexplorer/',
				'facebook'		=> 'facebook.com/wpexplorer-themes',
				'google-plus'	=> 'https://plus.google.com/+Wpexplorer',
				'pinterest'		=> 'pinterest.com/wpexplorer',
				'dribbble'		=> 'https://dribbble.com/aj-clarke',
				'vk'			=> '',
				'instagram'		=> '',
				'linkedin'		=> '',
				'tumblr'		=> '',
				'github-alt'	=> '',
				'flickr'		=> '',
				'skype'			=> '',
				'youtube'		=> 'https://www.youtube.com/user/wpexplorertv',
				'vimeo-square'	=> '',
				'xing'			=> '',
				'rss'			=> 'http://feeds.feedburner.com/wpexplorer-feed',
			);
			$social_options = apply_filters ( 'wpex_social_options', $social_options );

			// Visibility options array
			$visibility = array(
				"always-visible"	=> __("Always Visible", "wpex"),
				"hidden-phone"		=> __("Hidden on Phones", "wpex"),
				"hidden-tablet"		=> __("Hidden on Tablets", "wpex"),
				"hidden-desktop"	=> __("Hidden on Desktop", "wpex"),
				"visible-desktop"	=> __("Visible on Desktop Only", "wpex"),
				"visible-phone"		=> __("Visible on Phones Only", "wpex"),
				"visible-tablet"	=> __("Visible on Tablets Only", "wpex"),
			);

			// Built-in background pattern options
			$bg_patterns_url = get_template_directory_uri() .'/images/patterns/';
			$bg_patterns = array(
				array( 'alt'=> "",'img'	=> $bg_patterns_url .'dark_wood.png' ),
				array( 'alt'=> "",'img'	=> $bg_patterns_url .'diagmonds.png' ),
				array( 'alt'=> "",'img'	=> $bg_patterns_url .'grilled.png' ),
				array( 'alt'=> "",'img'	=> $bg_patterns_url .'lined_paper.png' ),
				array( 'alt'=> "",'img'	=> $bg_patterns_url .'old_wall.png' ),
				array( 'alt'=> "",'img'	=> $bg_patterns_url .'ricepaper2.png' ),
				array( 'alt'=> "",'img'	=> $bg_patterns_url .'tree_bark.png' ),
				array( 'alt'=> "",'img'	=> $bg_patterns_url .'triangular.png' ),
				array( 'alt'=> "",'img'	=> $bg_patterns_url .'white_plaster.png' ),
				array( 'alt'=> "",'img'	=> $bg_patterns_url .'wild_flowers.png' ),
				array( 'alt'=> "",'img'	=> $bg_patterns_url .'wood_pattern.png' ),
			);

			// Animation styles
			$image_hovers = array (
				''				=> __('None','vcex'),
				'grow'			=> __('Grow','vcex'),
				'shrink'		=>__('Shrink','vcex'),
				'fade-out'		=>__('Fade Out','vcex'),
				'fade-in'		=>__('Fade In','vcex'),
			);

			/**
				General
			**/
			$sections['general'] = array(
				'id'			=> 'general',
				'title'			=> __( 'General', 'wpex' ),
				'header'		=> __( 'Welcome to the Simple Options Framework Demo', 'wpex' ),
				'desc'			=> '',
				'icon'			=> 'el-icon-cog el-icon-small',
				'submenu'		=> true,
				'customizer'	=> false,
				'fields'		=> array(

					array(
						'id'		=> 'theme_branding',
						'url'		=> true,
						'type'		=> 'text', 
						'title'		=> __( 'Theme Branding', 'wpex' ),
						'default'	=> 'Total',
						'subtitle'	=> __( 'Enter your custom name to re brand your theme. This string is used in situations such as the custom widget titles.', 'wpex' ),
					),

					array(
						'id'		=> 'custom_logo',
						'url'		=> true,
						'type'		=> 'media',
						'title'		=> __( 'Logo', 'wpex' ),
						'read-only'	=> false,
						'default'	=> array( 'url'	=> get_template_directory_uri() .'/images/logo/logo.png' ),
						'subtitle'	=> __( 'Upload your custom site logo.', 'wpex' ),
					),

					array(
						'id'		=> 'retina_logo',
						'url'		=> true,
						'type'		=> 'media', 
						'title'		=> __( 'Retina Logo', 'wpex' ),
						'default'	=> array( 'url'	=> get_template_directory_uri() .'/images/logo/logo-retina.png' ),
						'subtitle'	=> __( 'Upload your retina logo (optional).', 'wpex' ),
					),

					array(
						'id'		=> 'retina_logo_height',
						'type'		=> 'text', 
						'default'	=> '40px',
						'title'		=> __( 'Standard Logo Height', 'wpex' ),
						'subtitle'	=> __( 'Enter your standard logo height. Used for retina logo.', 'wpex' ),
					),

					array(
						'id'	=> 'favicon',
						'url'			=> true,
						'type'		=> 'media', 
						'title'		=> __( 'Favicon', 'wpex' ),
						'default'	=> array( 'url'	=> get_template_directory_uri() .'/images/favicons/favicon.png' ),
						'subtitle'	=> __( 'Upload your custom site favicon.', 'wpex' ),
					),

					array(
						'id'		=> 'iphone_icon',
						'url'		=> true,
						'type'		=> 'media', 
						'title'		=> __( 'Apple iPhone Icon ', 'wpex' ),
						'default'	=> array(
							'url'	=> get_template_directory_uri() .'/images/favicons/apple-touch-icon.png'
						),
						'subtitle'	=> __( 'Upload your custom iPhone icon (57px by 57px).', 'wpex' ),
					),

					array(
						'id'		=> 'iphone_icon_retina',
						'url'		=> true,
						'type'		=> 'media', 
						'title'		=> __( 'Apple iPhone Retina Icon ', 'wpex' ),
						'default'	=> array(
							'url'	=> get_template_directory_uri() .'/images/favicons/apple-touch-icon-114x114.png'
						),
						'subtitle'	=> __( 'Upload your custom iPhone retina icon (114px by 114px).', 'wpex' ),
					),

					array(
						'id'		=> 'ipad_icon',
						'url'		=> true,
						'type'		=> 'media', 
						'title'		=> __( 'Apple iPad Icon ', 'wpex' ),
						'default'	=> array(
							'url'	=> get_template_directory_uri() .'/images/favicons/apple-touch-icon-72x72.png'
						),
						'subtitle'	=> __( 'Upload your custom iPad icon (72px by 72px).', 'wpex' ),
					),

					array(
						'id'		=> 'ipad_icon_retina',
						'url'		=> true,
						'type'		=> 'media', 
						'title'		=> __( 'Apple iPad Retina Icon ', 'wpex' ),
						'default'	=> array(
							'url'	=> get_template_directory_uri() .'/images/favicons/apple-touch-icon-114x114.png'
						),
						'subtitle'	=> __( 'Upload your custom iPad retina icon (144px by 144px).', 'wpex' ),
					),

					array(
						'id'		=> 'tracking',
						'type'		=> 'textarea',
						'title'		=> __( 'Tracking Code', 'wpex' ),
						'subtitle'	=> __( 'Paste your Google Analytics javascript or other tracking code here. This code will be added before the closing <head> tag.', 'wpex' ),
						'default'	=> ""
					),
				),
			);

			/**
				Layout
			**/
			$sections['layout'] = array(
				'id'			=> 'layout',
				'title'			=> __( 'Layout', 'wpex' ),
				'header'		=> '',
				'desc'			=> '',
				'icon_class'	=> 'el-icon-large',
				'icon'			=> 'el-icon-website',
				'submenu'		=> true,
				'customizer'	=> false,
				'fields'		=> array(

					array(
						'id'		=> 'main_layout_style',
						'type'		=> 'button_set',
						'title'		=> __( 'Layout Style', 'wpex' ), 
						'subtitle'	=> __( 'Select your website layout style.', 'wpex' ),
						'options'	=> array(
							'full-width'	=> __( 'Full Width','wpex' ),
							'boxed'			=> __( 'Boxed','wpex' )
						),
						'default'	=> 'full-width',
					),

					array(
						'id'		=> 'boxed_dropdshadow',
						'type'		=> 'switch',
						'title'		=> __( 'Boxed Layout Drop-Shadow', 'wpex' ),
						'subtitle'	=> __( 'Toggle the drop-shadow on or off in the boxed layout.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
						'required'	=> array( 'main_layout_style', 'equals', 'boxed' ),
					),

					array(
						'id'		=> 'boxed_top_margin',
						'type'		=> 'text',
						'title'		=> __( 'Boxed Layout Top Margin', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom margin in pixels.', 'wpex' ),
						"default"	=> '',
						'required'	=> array( 'main_layout_style', 'equals', 'boxed' ),
					),

					array(
						'id'		=> 'boxed_bottom_margin',
						'type'		=> 'text',
						'title'		=> __( 'Boxed Layout Bottom Margin', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom margin in pixels.', 'wpex' ),
						"default"	=> '',
						'required'	=> array( 'main_layout_style', 'equals', 'boxed' ),
					),

					array(
						'id'		=> 'main_container_width',
						'type'		=> 'text',
						'title'		=> __( 'Main Container Width', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom main container width in pixels.', 'wpex' ),
						'default'	=> '980px',
					),

					array(
						'id'		=> 'left_container_width',
						'type'		=> 'text',
						'title'		=> __( 'Left Container Width', 'wpex' ),
						'subtitle'	=> __( 'Enter your width in pixels or percentage for your left container.', 'wpex' ),
						'default'	=> '680px',
					),

					array(
						'id'		=> 'sidebar_width',
						'type'		=> 'text',
						'title'		=> __( 'Sidebar Width', 'wpex' ),
						'subtitle'	=> __( 'Enter your width in pixels or percentage for your sidebar.', 'wpex' ),
						'default'	=> '250px',
					),
				),
			);


			/**
				Responsive
			**/
			$sections['responsive'] = array(
				'id'			=> 'responsive',
				'title'			=> __( 'Responsive', 'wpex' ),
				'header'		=> '',
				'desc'			=> '',
				'icon_class'	=> 'el-icon-large',
				'icon'			=> 'el-icon-resize-small',
				'submenu'		=> true,
				'customizer'	=> false,
				'fields'		=> array(

					array(
						'id'		=> 'responsive',
						'type'		=> 'switch',
						'title'		=> __( 'Responsive', 'wpex' ),
						'subtitle'	=> __( 'Enable this option to make your theme compatible with smart phones and tablets.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),
					
					// Tablet Landscape
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Tablet Landscape & Small Desktops (960px - 1280px)', 'wpex' ),
					),

					array(
						'id'		=> 'tablet_landscape_main_container_width',
						'type'		=> 'text',
						'title'		=> __( 'Main Container Width', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom main container width in pixels. Keep in mind the iPad tablet width is only 1024px.', 'wpex' ),
						'default'	=> '980px',
					),

					array(
						'id'		=> 'tablet_landscape_left_container_width',
						'type'		=> 'text',
						'title'		=> __( 'Left Content Width', 'wpex' ),
						'subtitle'	=> __( 'Enter your width in pixels or percentage for your left container.', 'wpex' ),
						'default'	=> '680px',
					),

					array(
						'id'		=> 'tablet_landscape_sidebar_width',
						'type'		=> 'text',
						'title'		=> __( 'Sidebar Width', 'wpex' ),
						'subtitle'	=> __( 'Enter your width in pixels or percentage for your sidebar.', 'wpex' ),
						'default'	=> '250px',
					),


					// Tablet Portrait
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Tablet Portrait (768px - 959px)', 'wpex' ),
					),

					array(
						'id'		=> 'tablet_main_container_width',
						'type'		=> 'text',
						'title'		=> __( 'Main Container Width', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom main container width in pixels.', 'wpex' ),
						'default'	=> '700px',
					),

					array(
						'id'		=> 'tablet_left_container_width',
						'type'		=> 'text',
						'title'		=> __( 'Left Content Width', 'wpex' ),
						'subtitle'	=> __( 'Enter your width in pixels or percentage for your left container.', 'wpex' ),
						'default'	=> '100%',
					),

					array(
						'id'		=> 'tablet_sidebar_width',
						'type'		=> 'text',
						'title'		=> __( 'Sidebar Width', 'wpex' ),
						'subtitle'	=> __( 'Enter your width in pixels or percentage for your sidebar.', 'wpex' ),
						'default'	=> '100%',
					),

					// Mobile
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Phone Size (0 - 767px)', 'wpex' ),
					),

					array(
						'id'		=> 'mobile_landscape_main_container_width',
						'type'		=> 'text',
						'title'		=> __( 'Landscape: Main Container Width', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom main container width in pixels.', 'wpex' ),
						'default'	=> "90%",
					),

					array(
						'id'		=> 'mobile_portrait_main_container_width',
						'type'		=> 'text',
						'title'		=> __( 'Portrait: Main Container Width', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom main container width in pixels.', 'wpex' ),
						'default'	=> '90%',
					),
				),
			);


			/**
				Background
			**/
			$sections['background'] = array(
				'id'			=> 'background',
				'title'			=> __( 'Background', 'wpex' ),
				'header'		=> '',
				'desc'			=> '',
				'icon_class'	=> 'el-icon-large',
				'icon'			=> 'el-icon-picture',
				'submenu'		=> true,
				'customizer'	=> false,
				'fields'		=> array(

					array(
						'id'			=> 'background_color',
						'transparent'	=> false,
						'type'			=> 'color',
						'title'			=> __( 'Background Color', 'wpex' ),
						'default'		=> '',
						'subtitle'		=> __( 'Select your custom background color.', 'wpex' ),
					),

					array(
						'id'		=> 'background_image_toggle',
						'type'		=> 'switch', 
						'title'		=> __( 'Background Image', 'wpex' ),
						'subtitle'	=> __( 'Toggle the custom background image option on/off.', 'wpex' ),
						"default"	=> '0',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'background_image',
						'url'		=> true,
						'type'		=> 'media', 
						'required'	=> array( 'background_image_toggle', 'equals', '1' ),
						'title'		=> __( 'Custom Background Image', 'wpex' ),
						'default'	=> '',
						'subtitle'	=> __( 'Upload a custom background for your site.', 'wpex' ),
					),

					array(
						'id'		=> 'background_style',
						'type'		=> 'button_set',
						'title'		=> __( 'Background Image Style', 'wpex' ), 
						'required'	=> array('background_image_toggle','equals','1'),
						'subtitle'	=> __( 'Select your preferred background style.', 'wpex' ),
						'options'	=> array(
							'stretched'	=> __( 'Stretched','wpex' ),
							'repeat'	=> __( 'Repeat','wpex' ),
							'fixed'		=> __( 'Center Fixed','wpex' )
						),
						'default'	=> 'stretched'
					),

					array(
						'id'		=> 'background_pattern_toggle',
						'type'		=> 'switch', 
						'title'		=> __( 'Background Pattern', 'wpex' ),
						'subtitle'	=> __( 'Toggle the background pattern option on/off.', 'wpex' ),
						"default"	=> '0',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'background_pattern',
						'type'		=> 'image_select', 
						'tiles'		=> true,
						'required'	=> array('background_pattern_toggle','equals','1'),
						'title'		=> __( 'Pattern', 'wpex' ),
						'subtitle'	=> __( 'Select a background pattern. Best used with the "boxed" layout.', 'wpex' ),
						'default'	=> '',
						'options'	=> $bg_patterns,
					),
				),
			);


			/**
			 Typography
			**/
			$sections['typography'] = array(
				'id'			=> 'typography',
				'title'			=> __( 'Typography', 'wpex' ),
				'header'		=> '',
				'desc'			=> '',
				'icon_class'	=> 'el-icon-large',
				'icon'			=> 'el-icon-font',
				'submenu'		=> true,
				'fields'		=> array(

					array(
						'id'				=> 'body_font',
						'type'				=> 'typography',
						'title'				=> __( 'Body', 'wpex' ),
						'compiler'			=> false,
						'output'			=> false,
						'google'			=> true,
						'font-backup'		=> false,
						'font-style'		=> true,
						'subsets'			=> true,
						'font-size'			=> true,
						'line-height'		=> false,
						'word-spacing'		=> false,
						'letter-spacing'	=> false,
						'text-align'		=> false,
						'color'				=> true,
						'preview'			=> true,
						'units'				=> 'px',
						'all_styles'		=> true,
						'subtitle'			=> __( 'Select your custom font options for your main body font.', 'wpex' ),
						'default'			=> array(
							'font-family'	=> 'Open Sans',
							'font-size'		=> '',
							'font-weight'	=> '',
						),
					),

					array(
						'id'				=> 'headings_font',
						'type'				=> 'typography', 
						'title'				=> __( 'Main Headings', 'wpex' ),
						'compiler'			=> false,
						'output'			=> false,
						'google'			=> true,
						'font-backup'		=> false,
						'font-style'		=> false,
						'subsets'			=> true,
						'font-size'			=> false,
						'line-height'		=> false,
						'word-spacing'		=> false,
						'letter-spacing'	=> false,
						'text-align'		=> false,
						'color'				=> false,
						'preview'			=> true,
						'all_styles'		=> true,
						'units'				=> 'px',
						'subtitle'			=> __( 'Select your custom font options for your headings. h1, h2, h3, h4', 'wpex' ),
						'default'			=> array(
							'font-family'	=> '',
							'font-weight'	=> '',
							),
					),

					array(
						'id'				=> 'logo_font',
						'type'				=> 'typography',
						'title'				=> __( 'Logo', 'wpex' ),
						'compiler'			=> false,
						'output'			=> false,
						'google'			=> true,
						'font-backup'		=> false,
						'font-style'		=> false,
						'subsets'			=> true,
						'font-size'			=> true,
						'line-height'		=> false,
						'word-spacing'		=> false,
						'letter-spacing'	=> false,
						'text-align'		=> false,
						'color'				=> true,
						'preview'			=> true,
						'units'				=> 'px',
						'all_styles'		=> true,
						'subtitle'			=> __( 'Select your custom font options for your logo.', 'wpex' ),
						'default'			=> array(
							'font-family'	=> '',
							'font-size'		=> '',
							'font-weight'	=> '',
						),
					),

					array(
						'id'				=> 'menu_font',
						'type'				=> 'typography', 
						'title'				=> __( 'Menu', 'wpex' ),
						'compiler'			=> false,
						'output'			=> false,
						'google'			=> true,
						'font-backup'		=> false,
						'font-style'		=> false,
						'subsets'			=> true,
						'font-size'			=> true,
						'line-height'		=> false,
						'word-spacing'		=> false,
						'letter-spacing'	=> false,
						'text-align'		=> false,
						'color'				=> false,
						'preview'			=> true,
						'all_styles'		=> true,
						'units'				=> 'px',
						'subtitle'			=> __( 'Select your custom font options for your main navigation menu.', 'wpex' ),
						'default'			=> array(
							'font-family'	=> '', 
							'font-size'		=> '',
							'font-weight'	=> '',
						)
					),

					array(
						'id'				=> 'menu_dropdown_font',
						'type'				=> 'typography', 
						'title'				=> __( 'Menu Dropdowns', 'wpex' ),
						'compiler'			=> false,
						'output'			=> false,
						'google'			=> true,
						'font-backup'		=> false,
						'font-style'		=> false,
						'subsets'			=> true,
						'font-size'			=> true,
						'line-height'		=> false,
						'word-spacing'		=> false,
						'letter-spacing'	=> false,
						'text-align'		=> false,
						'color'				=> false,
						'preview'			=> true,
						'all_styles'		=> true,
						'units'				=> 'px',
						'subtitle'			=> __( 'Select your custom font options for your main navigation menu drop-downs.', 'wpex' ),
						'default'			=> array(
							'font-family'	=> '', 
							'font-size'		=> '',
							'font-weight'	=> '',
						)
					),

					array(
						'id'				=> 'page_header_font',
						'type'				=> 'typography', 
						'title'				=> __( 'Page Title', 'wpex' ),
						'compiler'			=> false,
						'output'			=> false,
						'google'			=> true,
						'font-backup'		=> false,
						'font-style'		=> false,
						'subsets'			=> true,
						'font-size'			=> true,
						'line-height'		=> false,
						'word-spacing'		=> false,
						'letter-spacing'	=> false,
						'text-align'		=> false,
						'color'				=> true,
						'preview'			=> true,
						'all_styles'		=> true,
						'units'				=> 'px',
						'subtitle'			=> __( 'Select your custom font options for your page/post titles.', 'wpex' ),
						'default'			=> array(
							'font-family'	=> '', 
							'font-size'		=> '',
							'font-weight'	=> '',
						)
					),

				),
			);


			/**
				Styling
			**/
			$sections['styling'] = array(
				'id'			=> 'styling',
				'icon'			=> 'el-icon-brush',
				'icon_class'	=> 'el-icon-large',
				'title'			=> __( 'Styling', 'wpex' ),
				'submenu'		=> true,
				'fields'		=> array(

					/**
						Skins
					**/
					array(
						'id'		=> 'site_theme',
						'type'		=> 'select', 
						'tiles'		=> false,
						'title'		=> __( 'Site Skin', 'wpex' ),
						'subtitle'	=> __( 'Select your desired theme (skin) for a quick site re-design without having to alter the styling options.', 'wpex' ),
						'default'	=> 'base',
						'options'	=> $skins,
					),

					/**
						Custom Styling Toggle
					**/
					array(
						'id'		=> 'custom_styling',
						'type'		=> 'switch', 
						'title'		=> __( 'Custom Styling', 'wpex' ),
						'subtitle'	=> __( 'Use this option to toggle the custom styling options below on or off. Great for testing purposes.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					/**
						Styling => Site Header
					**/
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Site Header', 'wpex' ),
					),

					array(
						'id'					=> 'header_background',
						'type'					=> 'color',
						'title'					=> __( 'Header Background Color', 'wpex' ), 
						'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
						'default'				=> '',
						'transparent'			=> false,
						'target_element'		=> '#site-header, #searchform-header-replace, .is-sticky #site-header',
						'target_style'			=> 'background-color',
						'theme_customizer'		=> true,

					),

					array(
						'id'				=> 'logo_color',
						'type'				=> 'color',
						'title'				=> __( 'Logo Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#site-logo a',
						'target_style'		=> 'color',
					),

					array(
						'id'					=> 'search_button_background',
						'type'					=> 'color_gradient',
						'title'					=> __( 'Search Button Background', 'wpex' ),
						'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
						'default'				=> '',
						'default'				=> array(
							'from'	=> '',
							'to'	=> ''
						),
						'transparent'			=> false,
						'target_element'		=> '#site-header .site-search-toggle, #site-header .site-search-toggle:hover, #site-header .site-search-toggle:active',
						'theme_customizer'		=> true,
					),

					array(
						'id'				=> 'search_button_color',
						'type'				=> 'color',
						'title'				=> __( 'Search Button Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#site-header .site-search-toggle, #site-header .site-search-toggle:hover, #site-header .site-search-toggle:active',
						'target_style'		=> 'color',
						'theme_customizer'	=> false,
					),

					/**
						Styling => Page Header
					**/
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Page Header', 'wpex' ),
					),

					array(
						'id'				=> 'page_header_background',
						'type'				=> 'color',
						'title'				=> __( 'Page Header Background', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.page-header',
						'target_style'		=> 'background-color',
					),

					array(
						'id'				=> 'page_header_title_color',
						'type'				=> 'color',
						'title'				=> __( 'Page Header Title Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.page-header-title',
						'target_style'		=> 'color',
					),

					array(
						'id'				=> 'page_header_top_border',
						'type'				=> 'color',
						'title'				=> __( 'Page Header Top Border Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.page-header',
						'target_style'		=> 'border-top-color',
					),

					array(
						'id'				=> 'page_header_bottom_border',
						'type'				=> 'color',
						'title'				=> __( 'Page Header Bottom Border Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.page-header, .theme-gaps .page-header-inner',
						'target_style'		=> 'border-bottom-color',
					),

					array(
						'id'				=> 'breadcrumbs_text_color',
						'type'				=> 'color',
						'title'				=> __( 'Breadcrumbs Text Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.site-breadcrumbs',
						'target_style'		=> 'color',
					),

					array(
						'id'				=> 'breadcrumbs_seperator_color',
						'type'				=> 'color',
						'title'				=> __( 'Breadcrumbs Seperator Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.site-breadcrumbs .sep',
						'target_style'		=> 'color',
					),

					array(
						'id'					=> 'breadcrumbs_link_color',
						'type'					=> 'link_color',
						'title'					=> __( 'Breadcrumbs Link Color', 'wpex' ),
						'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
						'default'				=> array(
							'regular'	=> '',
							'hover'		=> '',
							'active'	=> '',
						),
						'target_element'		=> '.site-breadcrumbs a',
						'target_element_hover'	=> '.site-breadcrumbs a:hover',
						'target_element_active'	=> '.site-breadcrumbs a:active',
						'target_style'			=> 'color',
					),

					/**
						Styling => Navigation
					**/
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Navigation', 'wpex' ),
					),

					array(
						'id'				=> 'menu_background',
						'type'				=> 'color',
						'title'				=> __( 'Menu Background', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#site-navigation-wrap, .is-sticky .fixed-nav',
						'target_style'		=> 'background-color',
					),

					array(
						'id'				=> 'menu_borders',
						'type'				=> 'color',
						'title'				=> __( 'Menu Borders', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#site-navigation li, #site-navigation a, #site-navigation ul, #site-navigation-wrap',
						'target_style'		=> 'border-color',
					),

					array(
						'id'					=> 'menu_link_color',
						'type'					=> 'link_color',
						'title'					=> __( 'Menu Link Color', 'wpex' ),
						'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
						'default'				=> array(
							'regular'	=> '',
							'hover'		=> '',
							'active'	=> '',
						),
						'target_element'		=> '#site-navigation .dropdown-menu > li > a',
						'target_element_hover'	=> '#site-navigation .dropdown-menu > li > a:hover, #site-navigation .dropdown-menu > li.sfHover > a',
						'target_element_active'	=> '#site-navigation .dropdown-menu > .current-menu-item > a, #site-navigation .dropdown-menu > .current-menu-item > a:hover',
						'target_style'			=> 'color',
					),

					array(
						'id'				=> 'menu_link_hover_background',
						'type'				=> 'color',
						'title'				=> __( 'Menu Link Hover Background', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#site-navigation .dropdown-menu > li > a:hover, #site-navigation .dropdown-menu > li.sfHover > a',
						'target_style'		=> 'background-color',
					),

					array(
						'id'				=> 'menu_link_active_background',
						'type'				=> 'color',
						'title'				=> __( 'Active Menu Link Background', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#site-navigation .dropdown-menu > .current-menu-item > a',
						'target_style'		=> 'background-color',
					),

					array(
						'id'				=> 'dropdown_menu_background',
						'type'				=> 'color',
						'title'				=> __( 'Menu Dropdown Background', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#site-navigation .dropdown-menu ul',
						'target_style'		=> 'background-color',
					),

					array(
						'id'				=> 'dropdown_menu_borders',
						'type'				=> 'color',
						'title'				=> __( 'Menu Dropdown Borders', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#site-navigation .dropdown-menu ul, #site-navigation .dropdown-menu ul li, #site-navigation .dropdown-menu ul li a',
						'target_style'		=> 'border-color',
					),

					array(
						'id'					=> 'dropdown_menu_link_color',
						'type'					=> 'link_color',
						'title'					=> __( 'Dropdown Menu Link Color', 'wpex' ),
						'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
						'default'				=> array(
							'regular'	=> '',
							'hover'		=> '',
							'active'	=> '',
						),
						'target_element'		=> '#site-navigation .dropdown-menu ul > li > a',
						'target_element_hover'	=> '#site-navigation .dropdown-menu ul > li > a:hover',
						'target_element_active'	=> '#site-navigation .dropdown-menu ul > .current-menu-item > a',
						'target_style'			=> 'color',
					),

					array(
						'id'				=> 'dropdown_menu_link_hover_bg',
						'type'				=> 'color_gradient',
						'title'				=> __( 'Menu Dropdown Link Hover Background', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> array(
							'from'	=> '',
							'to'	=> ''
						),
						'transparent'		=> false,
						'target_element'	=> '#site-navigation .dropdown-menu ul > li > a:hover'

					),

					array(
						'id'				=> 'mega_menu_title',
						'type'				=> 'color',
						'title'				=> __( 'Megamenu Subtitle Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.sf-menu > li.megamenu > ul.sub-menu > .menu-item-has-children > a'
					),

					/**
						Styling => Mobile Menu
					**/
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Mobile Menu', 'wpex' ),
					),

					array(
						'id'					=> 'mobile_menu_icon_background',
						'type'					=> 'link_color',
						'title'					=> __( 'Mobile Menu Icon Background', 'wpex' ),
						'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
						'default'				=> array(
							'regular'	=> '',
							'hover'		=> '',
							'active'	=> '',
						),
						'target_element'		=> '#mobile-menu a',
						'target_element_hover'	=> '#mobile-menu a:hover',
						'target_element_active'	=> '#mobile-menu a:active',
						'target_style'			=> 'background',
					),

					array(
						'id'					=> 'mobile_menu_icon_border',
						'type'					=> 'link_color',
						'title'					=> __( 'Mobile Menu Icon Border', 'wpex' ),
						'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
						'default'				=> array(
							'regular'	=> '',
							'hover'		=> '',
							'active'	=> '',
						),
						'target_element'		=> '#mobile-menu a',
						'target_element_hover'	=> '#mobile-menu a:hover',
						'target_element_active'	=> '#mobile-menu a:active',
						'target_style'			=> 'border-color',
					),

					array(
						'id'					=> 'mobile_menu_icon_color',
						'type'					=> 'link_color',
						'title'					=> __( 'Mobile Menu Icon Color', 'wpex' ),
						'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
						'default'				=> array(
							'regular'	=> '',
							'hover'		=> '',
							'active'	=> '',
						),
						'target_element'		=> '#mobile-menu a',
						'target_element_hover'	=> '#mobile-menu a:hover',
						'target_element_active'	=> '#mobile-menu a:active',
						'target_style'			=> 'color',
					),

					array(
						'id'		=> 'mobile_menu_icon_size',
						'type'		=> 'text',
						'title'		=> __( 'Mobile Menu Icon Size', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom font size in pixels or em for your mobile menu icons.', 'wpex' ),
						'default'	=> '',
					),

					array(
						'id'				=> 'mobile_menu_sidr_background',
						'type'				=> 'color',
						'title'				=> __( 'Mobile Menu Background', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#sidr-main',
						'target_style'		=> 'background-color',
					),

					array(
						'id'				=> 'mobile_menu_sidr_borders',
						'type'				=> 'color',
						'title'				=> __( 'Mobile Menu Borders', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#sidr-main li, #sidr-main ul',
						'target_style'		=> 'border-color',
					),

					array(
						'id'					=> 'mobile_menu_links',
						'type'					=> 'link_color',
						'title'					=> __( 'Mobile Menu Links', 'wpex' ),
						'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
						'default'				=> array(
							'regular'	=> '',
							'hover'		=> '',
							'active'	=> '',
						),
						'target_element'		=> '#sidr-main li a, .sidr-class-dropdown-toggle',
						'target_element_hover'	=> '#sidr-main li a:hover',
						'target_element_active'	=> '#sidr-main li a:active, .sidr-class-dropdown-toggle.active',
						'target_style'			=> 'color',
					),

					array(
						'id'				=> 'mobile_menu_sidr_search_bg',
						'type'				=> 'color',
						'title'				=> __( 'Mobile Menu Searchbar Background', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.sidr-class-mobile-menu-searchform input',
						'target_style'		=> 'background-color',
					),

					array(
						'id'				=> 'mobile_menu_sidr_search_color',
						'type'				=> 'color',
						'title'				=> __( 'Mobile Menu Searchbar Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.sidr-class-mobile-menu-searchform input',
						'target_style'		=> 'color',
					),

					/**
						Styling => Sidebar
					**/
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Sidebar', 'wpex' ),
					),

					array(
						'id'				=> 'sidebar_background',
						'type'				=> 'color',
						'title'				=> __( 'Sidebar Background', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#sidebar',
						'target_style'		=> 'background-color',
					),

					array(
						'id'		=> 'sidebar_padding',
						'type'		=> 'spacing',
						'output'	=> false,
						'mode'		=> 'padding',
						'units'		=> 'px',
						'title'		=> __( 'Sidebar Padding', 'wpex' ),
						'subtitle'	=> __( 'Select your custom sidebar padding', 'wpex' ),
						'default'	=> array(
							'padding-top'		=> '',
							'padding-right'		=> '',
							'padding-bottom'	=> '',
							'padding-left'		=> ''
						),
					),

					array(
						'id'			=> 'sidebar_border',
						'type'			=> 'border',
						'title'			=> __( 'Sidebar border', 'wpex' ), 
						'subtitle'		=> __( 'Select your border style.', 'wpex' ),
						'default'		=> '',
						'transparent'	=> false,
						'all'			=> false,
						'output'		=> false,
						'default'		=> array(
							'border-color'	=> '',
							'border-style'	=> 'solid',
							'border-top'	=> '',
							'border-right'	=> '',
							'border-bottom'	=> '',
							'border-left'	=> ''
						),
					),

					array(
						'id'				=> 'sidebar_headings_color',
						'type'				=> 'color',
						'transparent'		=> false,
						'title'				=> __( 'Sidebar Headings Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'target_element'	=> '#sidebar .widget-title, #sidebar .widget-title a',
						'target_style'		=> 'color',
					),

					array(
						'id'				=> 'sidebar_text_color',
						'type'				=> 'color',
						'transparent'		=> false,
						'title'				=> __( 'Sidebar Text Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'target_element'	=> '#sidebar, #sidebar p, #sidebar .text_widget',
						'target_style'		=> 'color',
					),

					array(
						'id'			=> 'sidebar_link_color',
						'type'			=> 'link_color',
						'title'			=> __( 'Sidebar Link Color', 'wpex' ),
						'subtitle'		=> __( 'Select your custom hex color.', 'wpex' ),
						'default'		=> array(
							'regular'	=> '',
							'hover'		=> '',
							'active'	=> '',
						),
						'target_element'		=> '#sidebar a',
						'target_element_hover'	=> '#sidebar a:hover',
						'target_element_active'	=> '#sidebar a:active',
						'target_style'			=> 'color',
					),

					array(
						'id'				=> 'sidebar_borders_color',
						'type'				=> 'color',
						'transparent'		=> false,
						'title'				=> __( 'Sidebar Inner Borders Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'target_element'	=> '.wpex-widget-recent-posts-li,.widget_categories li,.widget_recent_entries li,.widget_archive li,.widget_recent_comments li,.widget_product_categories li,.widget_layered_nav li,.widget-recent-posts-icons li,.wpex-widget-recent-posts-li:first-child, .widget_categories li:first-child, .widget_recent_entries li:first-child, .widget_archive li:first-child, .widget_recent_comments li:first-child, .widget_product_categories li:first-child, .widget_layered_nav li:first-child, .widget-recent-posts-icons li:first-child,.wpex-recent-comments-widget li,.wpex-recent-comments-widget li:first-child',
						'target_style'		=> 'border-color',
					),

					/**
						Styling => Footer
					**/
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Footer', 'wpex' ),
					),

					array(
						'id'				=> 'footer_background',
						'type'				=> 'color',
						'title'				=> __( 'Footer Background', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#footer',
						'target_style'		=> 'background-color',
					),

					array(
						'id'			=> 'footer_border',
						'type'			=> 'border',
						'title'			=> __( 'Footer border', 'wpex' ), 
						'subtitle'		=> __( 'Select your border style.', 'wpex' ),
						'default'		=> '',
						'transparent'	=> false,
						'all'			=> false,
						'output'		=> false,
					),

					array(
						'id'				=> 'footer_color',
						'type'				=> 'color',
						'title'				=> __( 'Footer Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#footer, #footer p',
						'target_style'		=> 'color',
					),

					array(
						'id'				=> 'footer_headings_color',
						'type'				=> 'color',
						'title'				=> __( 'Footer Headings Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#footer .widget-title',
						'target_style'		=> 'color',
					),

					array(
						'id'				=> 'footer_borders',
						'type'				=> 'color',
						'title'				=> __( 'Footer Borders', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#footer li, #footer #wp-calendar thead th, #footer #wp-calendar tbody td',
						'target_style'		=> 'border-color',
					),

					array(
						'id'			=> 'footer_link_color',
						'type'			=> 'link_color',
						'title'			=> __( 'Footer Link Color', 'wpex' ),
						'subtitle'		=> __( 'Select your custom hex color.', 'wpex' ),
						'default'		=> array(
							'regular'	=> '',
							'hover'		=> '',
							'active'	=> '',
						),
						'target_element'		=> '#footer a',
						'target_element_hover'	=> '#footer a:hover',
						'target_element_active'	=> '#footer a:active',
						'target_style'			=> 'color',
					),

					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Bottom Footer', 'wpex' ),
					),

					array(
						'id'				=> 'bottom_footer_background',
						'type'				=> 'color',
						'title'				=> __( 'Bottom Footer Background', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#footer-bottom',
						'target_style'		=> 'background-color',
					),

					array(
						'id'			=> 'bottom_footer_border',
						'type'			=> 'border',
						'title'			=> __( 'Bottom Footer Border', 'wpex' ), 
						'subtitle'		=> __( 'Select your border style.', 'wpex' ),
						'default'		=> '',
						'transparent'	=> false,
						'all'			=> false,
						'output'		=> false,
					),

					array(
						'id'				=> 'bottom_footer_color',
						'type'				=> 'color',
						'title'				=> __( 'Bottom Footer Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#footer-bottom, #footer-bottom p',
						'target_style'		=> 'color',
					),

					array(
						'id'			=> 'bottom_footer_link_color',
						'type'			=> 'link_color',
						'title'			=> __( 'Bottom Footer Link Color', 'wpex' ),
						'subtitle'		=> __( 'Select your custom hex color.', 'wpex' ),
						'default'		=> array(
							'regular'	=> '',
							'hover'		=> '',
							'active'	=> '',
						),
						'target_element'		=> '#footer-bottom a',
						'target_element_hover'	=> '#footer-bottom a:hover',
						'target_element_active'	=> '#footer-bottom a:active',
						'target_style'			=> 'color',
					),

					/**
						Styling => Buttons & Links
					**/
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Buttons & Links', 'wpex' ),
					),

					array(
						'id'				=> 'link_color',
						'type'				=> 'color',
						'title'				=> __( 'Links Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> 'body a, h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover',
						'target_style'		=> 'color',
					),

					array(
						'id'				=> 'theme_button_bg',
						'type'				=> 'color_gradient',
						'title'				=> __( 'Theme Button Background', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'transparent'		=> false,
						'target_element'	=> '.edit-post-link a, #commentform #submit, .wpcf7 .wpcf7-submit, .theme-minimal-graphical #comments .comment-reply-link, .theme-button, .readmore-link, #current-shop-items .buttons a, .woocommerce .button, .page-numbers a:hover, .page-numbers.current, .page-numbers.current:hover, input[type="submit"], button',
						'default'			=> array(
							'from'	=> '',
							'to'	=> ''
						),
					),

					array(
						'id'				=> 'theme_button_color',
						'type'				=> 'color',
						'title'				=> __( 'Theme Button Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'transparent'		=> false,
						'target_element'	=> '.edit-post-link a, #commentform #submit, .wpcf7 .wpcf7-submit, .theme-minimal-graphical #comments .comment-reply-link, .theme-button, .readmore-link, #current-shop-items .buttons a, .woocommerce .button, input[type="submit"], button',
						'target_style'		=> 'color',
					),

					array(
						'id'				=> 'theme_button_hover_bg',
						'type'				=> 'color_gradient',
						'title'				=> __( 'Theme Button Hover Background', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'transparent'		=> false,
						'target_element'	=> '.edit-post-link a:hover, #commentform #submit:hover, .wpcf7 .wpcf7-submit:hover, .theme-minimal-graphical #comments .comment-reply-link:hover, .theme-button:hover, .readmore-link:hover, #current-shop-items .buttons a:hover, .woocommerce .button:hover, input[type="submit"]:hover, button:hover',
						'default'			=> array(
							'from'	=> '',
							'to'	=> ''
						),
					),

					array(
						'id'				=> 'theme_button_hover_color',
						'type'				=> 'color',
						'title'				=> __( 'Theme Button Hover Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'theme_customizer'	=> false,
						'target_element'	=> '.edit-post-link a:hover, #commentform #submit:hover, .wpcf7 .wpcf7-submit:hover, #comments .comment-reply-link:hover, .theme-button:hover, .readmore-link:hover, #current-shop-items .buttons a:hover, .woocommerce .button:hover, input[type="submit"]:hover, button:hover, .vcex-filter-links a:hover',
						'target_style'		=> 'color',
					),

				)
			);

			/**
				Toggle Bar
			**/
			$toggle_animations = array(
				'fade'			=> __( 'Fade', 'wpex' ),
				'fade-slide'	=> __( 'Fade & Slide Down', 'wpex' ),
			);
			$toggle_animations = apply_filters( 'wpex_toggle_bar_animations', $toggle_animations );
			$sections['toggle_bar'] = array(
				'id'			=> 'toggle_bar',
				'title'			=> __( 'Toggle Bar', 'wpex' ),
				'icon_class'	=> 'el-icon-plus-sign',
				'submenu'		=> true,
				'fields'		=> array(

					array(
						'id'		=> 'toggle_bar',
						'type'		=> 'switch', 
						'title'		=> __( 'Toggle Bar', 'wpex' ),
						'subtitle'	=> __( 'Set your toggle bar on or off.', 'wpex' ),
						"default"	=> '0',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'toggle_bar_page',
						'type'		=> 'select',
						'data'		=> 'pages',
						'title'		=> __( 'Toggle Bar Content', 'wpex' ),
						'subtitle'	=> __( 'Select a page to grab the content from for your toggle bar.', 'wpex' ),
						'default'	=> '',
						'required'	=> array( 'toggle_bar', 'equals', '1' ),
					),

					array(
						'id'		=> 'toggle_bar_visibility',
						'type'		=> 'select',
						'title'		=> __( 'Toggle Bar Visibility', 'wpex' ), 
						'subtitle'	=> __( 'Select your visibility.', 'wpex' ),
						'options'	=> $visibility,
						'default'	=> 'hidden-phone',
						'required'	=> array( 'toggle_bar', 'equals', '1' ),
					),

					array(
						'id'		=> 'toggle_bar_animation',
						'type'		=> 'select',
						'title'		=> __( 'Toggle Bar Animation', 'wpex' ),
						'subtitle'	=> __( 'Select your animation style.', 'wpex' ),
						'default'	=> 'fade',
						'options'	=> $toggle_animations,
						'required'	=> array( 'toggle_bar', 'equals', '1' ),
					),

					array(
						'id'				=> 'toggle_bar_btn_bg',
						'type'				=> 'color',
						'title'				=> __( 'Toggle Bar Button Background', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'transparent'		=> false,
						'target_element'	=> '.toggle-bar-btn',
						'target_style'		=> array( 'border-top-color', 'border-right-color' ),
						'required'	=> array( 'toggle_bar', 'equals', '1' ),
					),

					array(
						'id'				=> 'toggle_bar_btn_color',
						'type'				=> 'color',
						'title'				=> __( 'Toggle Bar Button Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'transparent'		=> false,
						'target_element'	=> '.toggle-bar-btn span.fa',
						'target_style'		=> 'color',
						'required'	=> array( 'toggle_bar', 'equals', '1' ),
					),

					array(
						'id'				=> 'toggle_bar_btn_hover_bg',
						'type'				=> 'color',
						'title'				=> __( 'Toggle Bar Button Hover Background', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'transparent'		=> false,
						'target_element'	=> '.toggle-bar-btn:hover',
						'target_style'		=> array( 'border-top-color', 'border-right-color' ),
						'required'	=> array( 'toggle_bar', 'equals', '1' ),
					),

					array(
						'id'				=> 'toggle_bar_btn_hover_color',
						'type'				=> 'color',
						'title'				=> __( 'Toggle Bar Button Hover Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'transparent'		=> false,
						'target_element'	=> '.toggle-bar-btn:hover span.fa',
						'target_style'		=> 'color',
						'required'	=> array( 'toggle_bar', 'equals', '1' ),
					),

					array(
						'id'				=> 'toggle_bar_bg',
						'type'				=> 'color',
						'title'				=> __( 'Toggle Bar Background', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'transparent'		=> false,
						'target_element'	=> '#toggle-bar-btn',
						'target_style'		=> 'background-color',
						'required'	=> array( 'toggle_bar', 'equals', '1' ),
					),

					array(
						'id'				=> 'toggle_bar_color',
						'type'				=> 'color',
						'title'				=> __( 'Toggle Bar Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'transparent'		=> false,
						'target_element'	=> '#toggle-bar-wrap, #toggle-bar-wrap strong',
						'target_style'		=> 'color',
						'required'	=> array( 'toggle_bar', 'equals', '1' ),
					),

				)

			);

			/**
				Top Bar
			**/
			$sections['top_bar'] = array(
				'id'			=> 'top_bar',
				'title'			=> __( 'Top Bar', 'wpex' ),
				'header'		=> '',
				'desc'			=> '',
				'icon_class'	=> 'el-icon-arrow-up',
				'submenu'		=> true,
				'fields'		=> array(

					array(
						'id'		=> 'top_bar',
						'type'		=> 'switch', 
						'title'		=> __( 'Top Bar', 'wpex' ),
						'subtitle'	=> __( 'Toggle the top bar above the site on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'top_bar_style',
						'type'		=> 'select',
						'title'		=> __( 'Top Bar Style', 'wpex' ), 
						'subtitle'	=> __( 'Select your preferred top bar style.', 'wpex' ),
						'options'	=> array(
							'one'	=> __( 'Left Content & Right Social', 'wpex' ),
							'two'	=> __( 'Left Social & Right Content', 'wpex' ),
							'three'	=> __( 'Centered Content & Social', 'wpex' ),
						),
						'default'	=> 'one',
						'required'	=> array( 'top_bar', 'equals', '1' ),
					),

					array(
						'id'		=> 'top_bar_visibility',
						'type'		=> 'select',
						'title'		=> __( 'Top Bar Visibility', 'wpex' ), 
						'subtitle'	=> __( 'Select your visibility.', 'wpex' ),
						'options'	=> $visibility,
						'default'	=> 'always-visible',
						'required'	=> array( 'top_bar', 'equals', '1' ),
					),

					array(
						'id'				=> 'top_bar_content',
						'type'				=> 'editor',
						'title'				=> __( 'Top Bar: Content', 'wpex' ), 
						'subtitle'			=> __( 'Enter your custom content for your top bar. Shortcodes are Allowed.', 'wpex' ),
						'default'			=> '[font_awesome icon="phone" margin_right="5px" color="#000"] 1-800-987-654 [font_awesome icon="envelope" margin_right="5px" margin_left="20px" color="#000"] admin@total.com [font_awesome icon="user" margin_right="5px" margin_left="20px" color="#000"] [wp_login_url text="User Login" logout_text="Logout"]',
						'required'			=> array( 'top_bar', 'equals', '1' ),
						'editor_options'	=> '',
						'args'				=> array(
							'teeny'	=> false
						),
					),

					/**
						Top Bar => Social
					**/
					
					array(
						'id'		=> 'top_bar_social',
						'type'		=> 'switch', 
						'title'		=> __( 'Top Bar Social', 'wpex' ),
						'subtitle'	=> __( 'Toggle the top bar social links on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
						'required'	=> array( 'top_bar', 'equals', '1' ),
					),

					array(
						'id'				=> 'top_bar_social_alt',
						'type'				=> 'editor',
						'title'				=> __( 'Social Alternative', 'wpex' ), 
						'subtitle'			=> __( 'Add some alternative text, code, shortcodes where your Social icons would normally go.', 'wpex' ),
						'default'			=> '',
						'required'			=> array( 'top_bar', 'equals', '1' ),
						'editor_options'	=> '',
						'required'			=> array(
							array( 'top_bar_social', '!=','1' ),
							array( 'top_bar', 'equals', '1' )
						),
						'args'				=> array( 'teeny' => false )
					),

					array(
						'id'		=> 'top_bar_social_target',
						'type'		=> 'button_set',
						'title'		=> __( 'Top Bar Social Link Target', 'wpex' ),
						'subtitle'	=> __( 'Select to open the social links in a new or the same window.', 'wpex' ),
						'options'	=> array(
							'blank'	=> __( 'New Window', 'wpex' ),
							'self'	=> __( 'Same Window', 'wpex' )
						),
						'default'	=> 'blank',
						'required'	=> array(
							array( 'top_bar_social', 'equals', '1' ),
							array( 'top_bar', 'equals', '1' ),
						),
					),

					array(
						'id'		=> 'top_bar_social_style',
						'type'		=> 'button_set',
						'title'		=> __( 'Top Bar Social Style', 'wpex' ),
						'subtitle'	=> __( 'Select your preferred social link style.', 'wpex' ),
						'options'	=> array(
							'font_icons'	=> __( 'Font Icons', 'wpex' ),
							'colored-icons'	=> __( 'Colored Image Icons', 'wpex' )
						),
						'default'	=> 'font_icons',
						'required'	=> array(
							array( 'top_bar_social', 'equals', '1' ),
							array( 'top_bar', 'equals', '1' ),
						),
					),

					array(
						'id'		=> 'top_bar_social_options',
						'type'		=> 'sortable',
						'title'		=> __( 'Top Bar Social Options', 'wpex' ),
						'subtitle'	=> __( 'Define and reorder your social icons in the top bar. Clear the input field for any social icon you do not wish to display.', 'wpex' ),
						'desc'		=> '',
						'label'		=> true,
						'required'	=> array(
							array( 'top_bar_social', 'equals', '1' ),
							array( 'top_bar', 'equals', '1' ),
						),
						'options'	=> $social_options,
					),

					/**
						Top Bar => Styling
					**/

					array(
						'id'				=> 'top_bar_bg',
						'type'				=> 'color',
						'title'				=> __( 'Top Bar Background', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#top-bar-wrap',
						'target_style'		=> 'background-color',
						'required'	=> array( 'top_bar', 'equals', '1' ),
					),

					array(
						'id'				=> 'top_bar_border',
						'type'				=> 'color',
						'title'				=> __( 'Top Bar Bottom Border', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#top-bar-wrap',
						'target_style'		=> 'border-color',
						'required'	=> array( 'top_bar', 'equals', '1' ),
					),

					array(
						'id'				=> 'top_bar_text',
						'type'				=> 'color',
						'title'				=> __( 'Top Bar Text Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#top-bar-wrap, #top-bar-content strong',
						'target_style'		=> 'color',
						'required'	=> array( 'top_bar', 'equals', '1' ),
					),

					array(
						'id'					=> 'top_bar_link_color',
						'type'					=> 'link_color',
						'title'					=> __( 'Top bar Link Color', 'wpex' ),
						'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
						'default'				=> array(
							'regular'	=> '',
							'hover'		=> '',
							'active'	=> '',
						),
						'target_element'		=> '#top-bar-content a, #top-bar-social-alt a',
						'target_element_hover'	=> '#top-bar-content a:hover, #top-bar-social-alt a:hover',
						'target_element_active'	=> '#top-bar-content a:active, #top-bar-social-alt a:active',
						'target_style'			=> 'color',
						'required'	=> array( 'top_bar', 'equals', '1' ),
					),

					array(
						'id'				=> 'top_bar_social_color',
						'type'				=> 'color',
						'title'				=> __( 'Top Bar Social Links Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#top-bar-social a',
						'target_style'		=> 'color',
						'required'	=> array( 'top_bar', 'equals', '1' ),
					),

					array(
						'id'				=> 'top_bar_social_hover_color',
						'type'				=> 'color',
						'title'				=> __( 'Top Bar Social Links Hover Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#top-bar-social a:hover',
						'target_style'		=> 'color',
						'required'	=> array( 'top_bar', 'equals', '1' ),
					),
				),
			);


			/**
				Header
			**/
			$sections['header'] = array(
				'id'			=> 'header',
				'title'			=> __( 'Header', 'wpex' ),
				'header'		=> '',
				'desc'			=> '',
				'icon_class'	=> 'el-icon-large',
				'icon'			=> 'el-icon-screen',
				'submenu'		=> true,
				'fields'		=> array(

					array(
						'id'		=> 'header_style',
						'type'		=> 'button_set',
						'title'		=> __( 'Header Style', 'wpex' ), 
						'subtitle'	=> __( 'Select your default header style.', 'wpex' ),
						'options'	=> array(
							'one'	=> __( 'One','wpex' ),
							'two'	=> __( 'Two','wpex' ),
							'three'	=> __( 'Three','wpex' )
						),
						'default'	=> 'one',
					),

					array(
						'id'		=> 'fixed_header',
						'type'		=> 'switch',
						'title'		=> __( 'Fixed Header on Scroll', 'wpex' ),
						'subtitle'	=> __( 'Toggle the fixed header when the user scrolls down the site on or off. Please note that for certain header (two and three) styles only the navigation will become fixed.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'shink_fixed_header',
						'type'		=> 'switch',
						'title'		=> __( 'Shrink Fixed Header', 'wpex' ),
						'subtitle'	=> __( 'Shrink your fixed header on scroll', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
						'required'	=> array(
							array( 'header_style', 'equals', array( 'one' ) ),
							array( 'fixed_header', 'equals', array( '1' ) ),
						),
					),

					array(
						'id'		=> 'fixed_header_opacity',
						'type'		=> 'text',
						'title'		=> __( 'Fixed Header Opacity', 'wpex' ),
						'subtitle'	=> __( 'Enter an opacity for the fixed header. Default is 0.95.', 'wpex' ),
						"default"	=> '0.95',
						'required'	=> array(
							array( 'header_style', 'equals', array( 'one' ) ),
							array( 'fixed_header', 'equals', array( '1' ) ),
						),
					),

					array(
						'id'		=> 'main_search',
						'type'		=> 'switch', 
						'title'		=> __( 'Header Search', 'wpex' ),
						'subtitle'	=> __( 'Toggle the search function in the header on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'main_search_toggle_style',
						'type'		=> 'button_set',
						'title'		=> __( 'Header Search Toggle Style', 'wpex' ), 
						'subtitle'	=> __( 'Select your default header search style.', 'wpex' ),
						'options'	=> array(
							'drop_down'			=> __( 'Drop Down','wpex' ),
							'overlay'			=> __( 'Site Overlay','wpex' ),
							'header_replace'	=> __( 'Header Replace','wpex' )
						),
						'default'	=> 'drop_down',
						'required'	=> array( 'main_search', 'equals', array('1') ),
					),

					array(
						'id'					=> 'search_dropdown_top_border',
						'type'					=> 'color',
						'title'					=> __( 'Header Search Toggle Top Border Color', 'wpex' ), 
						'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
						'default'				=> '',
						'transparent'			=> false,
						'target_element'		=> '#searchform-dropdown',
						'target_style'			=> 'border-top-color',
						'theme_customizer'		=> false,
						'required'				=> array( 'main_search_toggle_style', 'equals', 'drop_down' ),
					),

					array(
						'id'		=> 'main_search_overlay_top_margin',
						'type'		=> 'text',
						'title'		=> __( 'Header Search Overlay Top Margin', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom top margin for the search overlay. The default is 120px.', 'wpex' ),
						'default'	=> '',
						'required'	=> array('main_search_toggle_style','equals','overlay'),
					),

					array(
						'id'		=> 'header_height',
						'type'		=> 'text',
						'title'		=> __( 'Custom Header Height', 'wpex' ),
						'subtitle'	=> __( 'Use this setting to define a fixed header height. Use this option ONLY if your want the navigation drop-downs to fall right under the header. Remove the default height (leave this field empty) if you want the header to auto expand depending on your logo height.', 'wpex' ),
						"default"	=> '40px',
						'required'	=> array( 'header_style', 'equals', array( 'one' ) ),
					),

					array(
						'id'		=> 'header_top_padding',
						'type'		=> 'text',
						'title'		=> __( 'Header Top Padding', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom header top padding in pixels. Ignored if the custom header height field is NOT empty.', 'wpex' ),
						'default'	=> '',
						//'required'	=> array( 'header_height', '=', '' ),
					),

					array(
						'id'		=> 'header_bottom_padding',
						'type'		=> 'text',
						'title'		=> __( 'Header Bottom Padding', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom header top padding in pixels. Ignored if the custom header height field is NOT empty', 'wpex' ),
						'default'	=> '',
						//'required'	=> array( 'header_height', '=', '' ),
					),

					array(
						'id'		=> 'logo_top_margin',
						'type'		=> 'text',
						'title'		=> __( 'Logo Top Margin', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom logo top margin.', 'wpex' ),
						'default'	=> '',
					),

					array(
						'id'		=> 'logo_bottom_margin',
						'type'		=> 'text',
						'title'		=> __( 'Logo Bottom Margin', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom logo top margin.', 'wpex' ),
						'default'	=> '',
					),

					array(
						'id'				=> 'header_aside',
						'type'				=> 'editor',
						'title'				=> __( 'Header Aside Content', 'wpex' ),
						'subtitle'			=> __( 'Enter your custom header aside content for header style 2.', 'wpex' ),
						'default'			=> '30% OFF All Store!',
						'required'			=> array('header_style', 'equals', array( 'two' ) ),
						'editor_options'	=> '',
						'args'				=> array('teeny' => false)
					),

					/**
						Header => Menu
					**/
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Header: Menu', 'wpex' ),
					),


					array(
						'id'		=> 'menu_arrow_down',
						'type'		=> 'switch', 
						'title'		=> __( 'Top Level Dropdown Icon', 'wpex' ),
						'subtitle'	=> __( 'Toggle the top menu dropdown icon indicator on or off.', 'wpex' ),
						"default"	=> '0',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'menu_arrow_side',
						'type'		=> 'switch', 
						'title'		=> __( 'Second+ Level Dropdown Icon', 'wpex' ),
						'subtitle'	=> __( 'Toggle the sub-menu item dropdown icon indicator on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'menu_dropdown_top_border',
						'type'		=> 'switch', 
						'title'		=> __( 'Dropdown Top Border', 'wpex' ),
						'subtitle'	=> __( 'Set this option to "on" if you want to have a thick colorfull border at the top of your drop-down menu.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'				=> 'menu_dropdown_top_border_color',
						'type'				=> 'color',
						'title'				=> __( 'Dropdown Top Border Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> 'body #site-navigation-wrap.nav-dropdown-top-border .dropdown-menu > li > ul, #searchform-dropdown, #current-shop-items-dropdown',
						'target_style'		=> 'border-top-color',
						'required'			=> array( 'menu_dropdown_top_border', 'equals', '1' ),
					),

					/** Header => Mobile

					<>IN PROGRESS<>
					
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Header: Mobile', 'wpex' ),
					),

					array(
						'id'		=> 'mobile_menu_style',
						'type'		=> 'select',
						'title'		=> __( 'Mobile Menu Style', 'wpex' ), 
						'subtitle'	=> __( 'Select your default mobile menu style.', 'wpex' ),
						'options'	=> array(
							'one'	=> __( 'Default','wpex' ),
							'two'		=> __( 'Full-Width Below header', 'wpex' ),
						),
						'default'	=> 'default',
					), */

					/**
						Header => Other
					**/
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Header: Other', 'wpex' ),
					),

					array(
						'id'		=> 'page_header_style',
						'type'		=> 'button_set',
						'title'		=> __( 'Page Header Style', 'wpex' ), 
						'subtitle'	=> __( 'Select your default page header style. This can be altered alter on a per-post basis.', 'wpex' ),
						'options'	=> array(
							'default'			=> __( 'Default','wpex' ),
							'centered'			=> __( 'Centered', 'wpex' ),
							'centered-minimal'	=> __( 'Centered Minimal', 'wpex' ),
						),
						'default'	=> 'default',
					),

				),
			);


			/**
				Portfolio
			**/
			if ( is_array( $theme_post_types ) && in_array( 'portfolio', $theme_post_types ) ) {

				$sections['portfolio'] = array(
					'id'			=> 'portfolio',
					'icon'			=> 'el-icon-briefcase',
					'icon_class'	=> 'el-icon-large',
					'title'			=> __( 'Portfolio', 'wpex' ),
					'submenu'		=> true,
					'customizer'	=> false,
					'fields'		=> array(

						array(
							'id'		=> 'portfolio_enable',
							'type'		=> 'switch', 
							'title'		=> __( 'Portfolio Post Type', 'wpex' ),
							'subtitle'	=> __( 'Toggle the portfolio custom post type on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'portfolio_page',
							'type'		=> 'select',
							'data'		=> 'pages',
							'title'		=> __( 'Portfolio Page', 'wpex' ),
							'subtitle'	=> __( 'Select your main portfolio page. This is used for your breadcrumbs.', 'wpex' ),
							'default'	=> '',
						),

						/**
							Portfolio => Archives
						**/
						array(
							'id'	=> 'multi-info',
							'type'	=> 'info',
							'title'	=> false,
							'desc'	=> __( 'Portfolio: Archives', 'wpex' ),
						),


						array(
							'id'		=> 'portfolio_archive_layout',
							'type'		=> 'button_set',
							'title'		=> __( 'Portfolio Archives Layout', 'wpex' ),
							'subtitle'	=> __( 'Select your preferred layout for your single posts. This setting can be overwritten on a per post basis via the meta options.', 'wpex' ),
							'options'	=> array(
								'right-sidebar'	=> __( 'Right Sidebar','wpex' ),
								'left-sidebar'	=> __( 'Left Sidebar','wpex' ),
								'full-width'	=> __( 'Full Width','wpex' )
							),
							'default'	=> 'full-width',
						),

						array(
							'id'		=> 'portfolio_archive_grid_style',
							'type'		=> 'button_set',
							'title'		=> __( 'Portfolio Archives Grid Style', 'wpex' ),
							'subtitle'	=> __( 'Select your preferred grid style.', 'wpex' ),
							'options'	=> array(
								'fit-rows'		=> __( 'Fit Rows','wpex' ),
								'masonry'		=> __( 'Masonry','wpex' ),
								'no-margins'	=> __( 'No Margins','wpex' )
							),
							'default'	=> 'fit-rows',
						),

						array(
							'id'		=> 'portfolio_entry_columns',
							'type'		=> 'button_set',
							'title'		=> __( 'Portfolio Archive Columns', 'wpex' ), 
							'subtitle'	=> __( 'Select your default column structure for your category and tag archives.', 'wpex' ),
							'options'	=> array(
								'1'	=> '1',
								'2'	=> '2',
								'3'	=> '3',
								'4'	=> '4'
							),
							'default'	=> '4',
						),

						array(
							'id'		=> 'portfolio_archive_posts_per_page',
							'type'		=> 'text', 
							'title'		=> __( 'Portfolio Archives Posts Per Page', 'wpex' ),
							'subtitle'	=> __( 'How many posts do you wish to display on your archives before pagination?', 'wpex' ),
							"default"	=> '12',
						),

						array(
							'id'		=> 'portfolio_entry_overlay_style',
							'type'		=> 'select', 
							'title'		=> __( 'Portfolio Entry Image Overlay', 'wpex' ),
							'subtitle'	=> __( 'Select your preferred overlay style.', 'wpex' ),
							'default'	=> 'none',
							'options'	=> wpex_overlay_styles_array(),
						),

						array(
							'id'		=> 'portfolio_entry_details',
							'type'		=> 'switch', 
							'title'		=> __( 'Portfolio Entry Details', 'wpex' ),
							'subtitle'	=> __( 'Toggle the portfolio entry title/excerpts from your category and tag archives.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'portfolio_entry_excerpt_length',
							'type'		=> 'text', 
							'title'		=> __( 'Portfolio Entry Excerpt Length', 'wpex' ),
							'subtitle'	=> __( 'How many words do you want to show for your entry excerpts?', 'wpex' ),
							"default"	=> '20',
							'required'	=> array( 'portfolio_entry_details', 'equals', '1' ),
						),

						/**
							Portfolio => Single
						**/
						array(
							'id'	=> 'multi-info',
							'type'	=> 'info',
							'title'	=> false,
							'desc'	=> __( 'Portfolio: Single Post', 'wpex' ),
						),

						array(
							'id'		=> 'portfolio_single_layout',
							'type'		=> 'button_set',
							'title'		=> __( 'Portfolio Single Post Layout', 'wpex' ),
							'subtitle'	=> __( 'Select your preferred layout for your single posts. This setting can be overwritten on a per post basis via the meta options.', 'wpex' ),
							'options'	=> array(
								'right-sidebar'		=> __( 'Right Sidebar','wpex' ),
								'left-sidebar'		=> __( 'Left Sidebar','wpex' ),
								'full-width'		=> __( 'Full Width','wpex' )
							),
							'default'	=> 'full-width',
						),

						array(
							'id'		=> 'portfolio_single_media',
							'type'		=> 'switch', 
							'title'		=> __( 'Auto Portfolio Post Media', 'wpex' ),
							'subtitle'	=> __( 'Set this option to "on" if you want to automatically display your portfolio featured image or featured video at the top of posts.', 'wpex' ),
							"default"	=> '0',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'portfolio_comments',
							'type'		=> 'switch', 
							'title'		=> __( 'Portfolio Comments', 'wpex' ),
							'subtitle'	=> __( 'Toggle the comments on or off.', 'wpex' ),
							"default"	=> '0',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'portfolio_next_prev',
							'type'		=> 'switch', 
							'title'		=> __( 'Portfolio Next/Prev Links', 'wpex' ),
							'subtitle'	=> __( 'Toggle the next and previous pagination on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'portfolio_related',
							'type'		=> 'switch', 
							'title'		=> __( 'Portfolio Related', 'wpex' ),
							'subtitle'	=> __( 'Toggle the related portfolio items on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'portfolio_related_columns',
							'type'		=> 'button_set',
							'title'		=> __( 'Portfolio Related Columns', 'wpex' ), 
							'subtitle'	=> __( 'Select your default column structure.', 'wpex' ),
							'options'	=> array(
								'1'	=> '1',
								'2'	=> '2',
								'3'	=> '3',
								'4'	=> '4'
							),
							'default'	=> '4',
							'required'	=> array( 'portfolio_related', 'equals', '1' ),
						),

						array(
							'id'		=> 'portfolio_related_count',
							'type'		=> 'text',
							'title'		=> __( 'Portfolio Related Count', 'wpex' ),
							'subtitle'	=> __( 'Enter the number of related items to display.', 'wpex' ),
							'default'	=> '4',
							'required'	=> array( 'portfolio_related', 'equals', '1' ),
						),

						array(
							'id'		=> 'portfolio_related_title',
							'type'		=> 'text',
							'title'		=> __( 'Portfolio Related Title', 'wpex' ),
							'subtitle'	=> __( 'Enter a custom string for your related portfolio items title.', 'wpex' ),
							'default'	=> '',
							'required'	=> array( 'portfolio_related', 'equals', '1' ),
						),

						array(
							'id'		=> 'portfolio_related_excerpts',
							'type'		=> 'switch',
							'title'		=> __( 'Portfolio Related Entry Content', 'wpex' ),
							'subtitle'	=> __( 'Display The Title & Excerpt for related items?', 'wpex' ),
							'default'	=> '1',
							'required'	=> array( 'portfolio_related', 'equals', '1' ),
						),


						/**
							Portfolio => Branding
						**/
						array(
							'id'	=> 'multi-info',
							'type'	=> 'info',
							'title'	=> false,
							'desc'	=> __( 'Portfolio: Branding', 'wpex' ),
						),

						array(
							'id'		=> 'portfolio_admin_icon',
							'type'		=> 'select',
							'title'		=> __( 'Portfolio Admin Icon', 'wpex' ),
							'subtitle'	=> __( 'Select your custom Dashicon for this post type.', 'wpex' ). '<br /><br /><a href="http://melchoyce.github.io/dashicons/" target="_blank">'. __( 'Learn More','wpex' ) .' &rarr;</a>',
							'options'	=> $wpex_dashicons,
							'default'	=> 'portfolio',
						),

						array(
							'id'		=> 'portfolio_labels',
							'type'		=> 'text',
							'title'		=> __( 'Portfolio Labels', 'wpex' ),
							'subtitle'	=> __( 'Use this field to rename your portfolio custom post type.', 'wpex' ),
							'default'	=> 'Portfolio',
						),

						array(
							'id'		=> 'portfolio_slug',
							'type'		=> 'text',
							'title'		=> __( 'Custom Portfolio Slug', 'wpex' ),
							'subtitle'	=> __( 'Changes the default slug for this post type. After changing this field go to "Settings->Permalinks" and resave your settings to prevent 404 errors.', 'wpex' ),
							'default'	=> 'portfolio-item',
						),

						array(
							'id'		=> 'portfolio_cat_slug',
							'type'		=> 'text',
							'title'		=> __( 'Portfolio Category Slug', 'wpex' ),
							'subtitle'	=> __( 'Use this field to alter the default slug for this taxonomy. After changing this field go to "Settings->Permalinks" and resave your settings to prevent 404 errors.', 'wpex' ),
							'default'	=> 'portfolio-category',
						),

						array(
							'id'		=> 'portfolio_tag_slug',
							'type'		=> 'text',
							'title'		=> __( 'Portfolio Tag Slug', 'wpex' ),
							'subtitle'	=> __( 'Use this field to alter the default slug for this taxonomy. After changing this field go to "Settings->Permalinks" and resave your settings to prevent 404 errors.', 'wpex' ),
							'default'	=> 'portfolio-tag',
						),

						/**
						Portfolio => Other
						**/
						array(
							'id'	=> 'multi-info',
							'type'	=> 'info',
							'title'	=> false,
							'desc'	=> __( 'Portfolio: Other', 'wpex' ),
						),

						array(
							'id'		=> 'portfolio_custom_sidebar',
							'type'		=> 'switch', 
							'title'		=> __( 'Custom Portfolio Sidebar', 'wpex' ),
							'subtitle'	=> __( 'Toggle the built-in custom Portfolio post type sidebar on or off. If disabled it will display the "Main" sidebar as a fallback.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'breadcrumbs_portfolio_cat',
							'type'		=> 'switch', 
							'title'		=> __( 'Portfolio Category In Breadcrumbs', 'wpex' ),
							'subtitle'	=> __( 'Toggle the display of the category in breadcrumbs on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'portfolio_search',
							'type'		=> 'switch', 
							'title'		=> __( 'Portfolio in Search?', 'wpex' ),
							'subtitle'	=> __( 'Toggle whether items from this post type should display in search results on or off. Enabling this option will also cause items to not display in the category & tag archives, so use wisely!', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

					),
				);

			} // End theme_post_types check

			/**
				Staff
			**/
			if ( is_array( $theme_post_types ) && in_array( 'staff', $theme_post_types ) ) {

				$sections['staff'] = array(
					'id'			=> 'staff',
					'icon'			=> 'el-icon-user',
					'icon_class'	=> 'el-icon-large',
					'title'			=> __( 'Staff', 'wpex' ),
					'submenu'		=> true,
					'customizer'	=> false,
					'fields'		=> array(

						array(
							'id'		=> 'staff_enable',
							'type'		=> 'switch', 
							'title'		=> __( 'Staff Post Type', 'wpex' ),
							'subtitle'	=> __( 'Toggle the staff custom post type on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'staff_page',
							'type'		=> 'select',
							'data'		=> 'pages',
							'title'		=> __( 'Staff Page', 'wpex' ),
							'subtitle'	=> __( 'Select your main staff page. This is used for your breadcrumbs.', 'wpex' ),
							'default'	=> '',
						),

						/**
							Staff => Archives
						**/
						array(
							'id'	=> 'multi-info',
							'type'	=> 'info',
							'title'	=> false,
							'desc'	=> __( 'Staff: Archives', 'wpex' ),
						),


						array(
							'id'		=> 'staff_archive_layout',
							'type'		=> 'button_set',
							'title'		=> __( 'Staff Archives Layout', 'wpex' ),
							'subtitle'	=> __( 'Select your preferred layout for your posts. This setting can be overwritten on a per post basis via the meta options.', 'wpex' ),
							'options'	=> array(
								'right-sidebar'	=> __( 'Right Sidebar','wpex' ),
								'left-sidebar'	=> __( 'Left Sidebar','wpex' ),
								'full-width'	=> __( 'Full Width','wpex' )
							),
							'default'	=> 'full-width',
						),

						array(
							'id'		=> 'staff_archive_grid_style',
							'type'		=> 'button_set',
							'title'		=> __( 'Staff Archives Grid Style', 'wpex' ),
							'subtitle'	=> __( 'Select your preferred grid style.', 'wpex' ),
							'options'	=> array(
								'fit-rows'		=> __( 'Fit Rows','wpex' ),
								'masonry'		=> __( 'Masonry','wpex' ),
								'no-margins'	=> __( 'No Margins','wpex' )
							),
							'default'	=> 'fit-rows',
						),

						array(
							'id'		=> 'staff_entry_columns',
							'type'		=> 'button_set',
							'title'		=> __( 'Staff Archive Columns', 'wpex' ), 
							'subtitle'	=> __( 'Select your default column structure for your category and tag archives.', 'wpex' ),
							'options'	=> array(
								'1'	=> '1',
								'2'	=> '2',
								'3'	=> '3',
								'4'	=> '4'
							),
							'default'	=> '4',
						),

						array(
							'id'		=> 'staff_archive_posts_per_page',
							'type'		=> 'text', 
							'title'		=> __( 'Staff Archives Posts Per Page', 'wpex' ),
							'subtitle'	=> __( 'How many posts do you wish to display on your archives before pagination?', 'wpex' ),
							"default"	=> '12',
						),

						array(
							'id'		=> 'staff_entry_overlay_style',
							'type'		=> 'select', 
							'title'		=> __( 'Staff Entry Image Overlay', 'wpex' ),
							'subtitle'	=> __( 'Select your preferred overlay style.', 'wpex' ),
							'default'	=> 'slideup-title-white',
							'options'	=> wpex_overlay_styles_array(),
						),

						array(
							'id'		=> 'staff_entry_details',
							'type'		=> 'switch', 
							'title'		=> __( 'Staff Entry Details', 'wpex' ),
							'subtitle'	=> __( 'Toggle the staff entry title/excerpts from your category and tag archives.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'staff_entry_excerpt_length',
							'type'		=> 'text', 
							'title'		=> __( 'Staff Entry Excerpt Length', 'wpex' ),
							'subtitle'	=> __( 'How many words do you want to show for your entry excerpts?', 'wpex' ),
							"default"	=> '20',
							'required'	=> array( 'staff_entry_details', 'equals', '1' ),
						),

						array(
							'id'		=> 'staff_entry_social',
							'type'		=> 'switch', 
							'title'		=> __( 'Staff Entry Social Links', 'wpex' ),
							'subtitle'	=> __( 'Toggle the social links display on staff entries on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						/**
							Staff => Single Post
						**/
						array(
							'id'	=> 'multi-info',
							'type'	=> 'info',
							'title'	=> false,
							'desc'	=> __( 'Staff: Single Post', 'wpex' ),
						),

						array(
							'id'		=> 'staff_single_layout',
							'type'		=> 'button_set',
							'title'		=> __( 'Staff Single Post Layout', 'wpex' ),
							'subtitle'	=> __( 'Select your preferred layout for your single posts. This setting can be overwritten on a per post basis via the meta options.', 'wpex' ),
							'options'	=> array(
								'right-sidebar'	=> __( 'Right Sidebar','wpex' ),
								'left-sidebar'	=> __( 'Left Sidebar','wpex' ),
								'full-width'	=> __( 'Full Width','wpex' )
							),
							'default'	=> 'right-sidebar',
						),

						array(
							'id'		=> 'staff_comments',
							'type'		=> 'switch', 
							'title'		=> __( 'Staff Comments', 'wpex' ),
							'subtitle'	=> __( 'Toggle the comments on or off.', 'wpex' ),
							"default"	=> '0',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'staff_next_prev',
							'type'		=> 'switch', 
							'title'		=> __( 'Staff Next/Prev Links', 'wpex' ),
							'subtitle'	=> __( 'Toggle the next and previous pagination on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'staff_related',
							'type'		=> 'switch', 
							'title'		=> __( 'Staff Related', 'wpex' ),
							'subtitle'	=> __( 'Toggle the related staff items on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'staff_related_columns',
							'type'		=> 'button_set',
							'title'		=> __( 'Staff Related Columns', 'wpex' ), 
							'subtitle'	=> __( 'Select your default column structure.', 'wpex' ),
							'options'	=> array(
								'1'	=> '1',
								'2'	=> '2',
								'3'	=> '3',
								'4'	=> '4'
							),
							'default'	=> '3',
							'required'	=> array( 'staff_related', 'equals', '1' ),
						),

						array(
							'id'		=> 'staff_related_count',
							'type'		=> 'text',
							'title'		=> __( 'Staff Related Count', 'wpex' ),
							'subtitle'	=> __( 'Enter the number of related items to display', 'wpex' ),
							'default'	=> '3',
							'required'	=> array( 'staff_related', 'equals', '1' ),
						),

						array(
							'id'		=> 'staff_related_title',
							'type'		=> 'text',
							'title'		=> __( 'Staff Related Title', 'wpex' ),
							'subtitle'	=> __( 'Enter a custom string for your related staff items title.', 'wpex' ),
							'default'	=> '',
							'required'	=> array( 'staff_related', 'equals', '1' ),
						),

						array(
							'id'		=> 'staff_related_excerpts',
							'type'		=> 'switch',
							'title'		=> __( 'Staff Related Entry Details', 'wpex' ),
							'subtitle'	=> __( 'Display The Title & Excerpt for related items?', 'wpex' ),
							'default'	=> '1',
							'required'	=> array( 'staff_related', 'equals', '1' ),
						),

						/**
							Staff => Branding
						**/
						array(
							'id'	=> 'multi-info',
							'type'	=> 'info',
							'title'	=> false,
							'desc'	=> __( 'Staff: Branding', 'wpex' ),
						),

						array(
							'id'		=> 'staff_admin_icon',
							'type'		=> 'select', 
							'title'		=> __( 'Staff Admin Icon', 'wpex' ),
							'subtitle'	=> __( 'Select your custom Dashicon for this post type.', 'wpex' ). '<br /><br /><a href="http://melchoyce.github.io/dashicons/" target="_blank">'. __( 'Learn More','wpex' ) .' &rarr;</a>',
							'options'	=> $wpex_dashicons,
							'default'	=> 'groups',
						),

						array(
							'id'		=> 'staff_labels',
							'type'		=> 'text',
							'title'		=> __( 'Staff Labels', 'wpex' ),
							'subtitle'	=> __( 'Use this field to rename your staff custom post type.', 'wpex' ),
							'default'	=> 'Staff',
						),

						array(
							'id'		=> 'staff_slug',
							'type'		=> 'text',
							'title'		=> __( 'Staff Slug', 'wpex' ),
							'subtitle'	=> __( 'Changes the default slug for this post type. After changing this field go to "Settings->Permalinks" and resave your settings to prevent 404 errors.', 'wpex' ),
							'default'	=> 'staff-item',
						),

						array(
							'id'		=> 'staff_cat_slug',
							'type'		=> 'text',
							'title'		=> __( 'Staff Category Slug', 'wpex' ),
							'subtitle'	=> __( 'Use this field to alter the default slug for this taxonomy. After changing this field go to "Settings->Permalinks" and resave your settings to prevent 404 errors.', 'wpex' ),
							'default'	=> 'staff-category',
						),

						array(
							'id'		=> 'staff_tag_slug',
							'type'		=> 'text',
							'title'		=> __( 'Staff Tag Slug', 'wpex' ),
							'subtitle'	=> __( 'Use this field to alter the default slug for this taxonomy. After changing this field go to "Settings->Permalinks" and resave your settings to prevent 404 errors.', 'wpex' ),
							'default'	=> 'staff-tag',
						),

						/**
							Staff => Other
						**/
						array(
							'id'	=> 'multi-info',
							'type'	=> 'info',
							'title'	=> false,
							'desc'	=> __( 'Staff: Other', 'wpex' ),
						),

						array(
							'id'		=> 'staff_custom_sidebar',
							'type'		=> 'switch', 
							'title'		=> __( 'Custom Staff Sidebar', 'wpex' ),
							'subtitle'	=> __( 'Toggle the built-in custom Staff post type sidebar on or off. If disabled it will display the "Main" sidebar as a fallback.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'breadcrumbs_staff_cat',
							'type'		=> 'switch', 
							'title'		=> __( 'Staff Category In Breadcrumbs', 'wpex' ),
							'subtitle'	=> __( 'Toggle the display of the category in breadcrumbs on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
							'required'	=> array( 'staff_enable', 'equals', '1' ),
						),

						array(
							'id'		=> 'staff_search',
							'type'		=> 'switch', 
							'title'		=> __( 'Staff in Search?', 'wpex' ),
							'subtitle'	=> __( 'Toggle whether items from this post type should display in search results on or off. Enabling this option will also cause items to not display in the category & tag archives, so use wisely!', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

					)
				);
			} // End wpex_theme_post_types check

			/**
				Testimonials
			**/
			if ( is_array( $theme_post_types ) && in_array( 'testimonials', $theme_post_types ) ) {

				$sections['testimonials'] = array(
					'id'			=> 'testimonials',
					'icon'			=> 'el-icon-quotes',
					'icon_class'	=> 'el-icon-large',
					'title'			=> __( 'Testimonials', 'wpex' ),
					'submenu'		=> true,
					'customizer'	=> false,
					'fields'		=> array(

						array(
							'id'		=> 'testimonials_enable',
							'type'		=> 'switch', 
							'title'		=> __( 'Testimonials Post Type', 'wpex' ),
							'subtitle'	=> __( 'Toggle the testimonials custom post type on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'testimonials_page',
							'type'		=> 'select',
							'data'		=> 'pages',
							'title'		=> __( 'Testimonials Page', 'wpex' ),
							'subtitle'	=> __( 'Select your main testimonials page. This is used for your breadcrumbs.', 'wpex' ),
							'default'	=> '',
						),

						/**
							Testimonials => Archives
						**/
						array(
							'id'	=> 'multi-info',
							'type'	=> 'info',
							'title'	=> false,
							'desc'	=> __( 'Testimonials: Archives', 'wpex' ),
						),


						array(
							'id'		=> 'testimonials_archive_layout',
							'type'		=> 'button_set',
							'title'		=> __( 'Testimonials Archives Layout', 'wpex' ),
							'subtitle'	=> __( 'Select your preferred layout for your single posts. This setting can be overwritten on a per post basis via the meta options.', 'wpex' ),
							'options'	=> array(
								'right-sidebar'	=> __( 'Right Sidebar','wpex' ),
								'left-sidebar'	=> __( 'Left Sidebar','wpex' ),
								'full-width'	=> __( 'Full Width','wpex' )
							),
							'default'	=> 'full-width',
						),

						array(
							'id'		=> 'testimonials_entry_columns',
							'type'		=> 'button_set',
							'title'		=> __( 'Testimonials Archive Columns', 'wpex' ), 
							'subtitle'	=> __( 'Select your default column structure for your category and tag archives.', 'wpex' ),
							'options'	=> array(
								'1'	=> '1',
								'2'	=> '2',
								'3'	=> '3',
								'4'	=> '4'
							),
							'default'	=> '3',
						),

						array(
							'id'		=> 'testimonials_archive_posts_per_page',
							'type'		=> 'text', 
							'title'		=> __( 'Testimonials Archives Posts Per Page', 'wpex' ),
							'subtitle'	=> __( 'How many posts do you wish to display on your archives before pagination?', 'wpex' ),
							"default"	=> '12',
						),

						/**
							Testimonials => Single Post
						**/
						array(
							'id'	=> 'multi-info',
							'type'	=> 'info',
							'title'	=> false,
							'desc'	=> __( 'Testimonials: Single Post', 'wpex' ),
						),

						array(
							'id'		=> 'testimonial_post_style',
							'type'		=> 'button_set', 
							'title'		=> __( 'Testimonial Post Style', 'wpex' ),
							'subtitle'	=> __( 'Select your style for the singular testimonial post.', 'wpex' ),
							'default'	=> 'blockquote',
							'options'	=> array (
								'blockquote'	=> __( 'Blockquote', 'wpex' ),
								'standard'		=> __( 'Standard', 'wpex' ),
							)
						),

						array(
							'id'		=> 'testimonials_single_layout',
							'type'		=> 'button_set',
							'title'		=> __( 'Testimonials Single Post Layout', 'wpex' ),
							'subtitle'	=> __( 'Select your preferred layout for your single posts. This setting can be overwritten on a per post basis via the meta options.', 'wpex' ),
							'options'	=> array(
								'right-sidebar'	=> __( 'Right Sidebar','wpex' ),
								'left-sidebar'	=> __( 'Left Sidebar','wpex' ),
								'full-width'	=> __( 'Full Width','wpex' )
							),
							'default'	=> 'full-width',
						),

						array(
							'id'		=> 'testimonials_comments',
							'type'		=> 'switch', 
							'title'		=> __( 'Testimonials Comments', 'wpex' ),
							'subtitle'	=> __( 'Toggle the comments on posts on or off.', 'wpex' ),
							"default"	=> '0',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),


						/**
							Testimonials => Branding
						**/
						array(
							'id'	=> 'multi-info',
							'type'	=> 'info',
							'title'	=> false,
							'desc'	=> __( 'Testimonials: Branding', 'wpex' ),
						),

						array(
							'id'		=> 'testimonials_admin_icon',
							'type'		=> 'select', 
							'title'		=> __( 'Testimonials Admin Icon', 'wpex' ),
							'subtitle'	=> __( 'Select your custom dashicon for this post type.', 'wpex' ). '<br /><br /><a href="http://melchoyce.github.io/dashicons/" target="_blank">'. __( 'Learn More','wpex' ) .' &rarr;</a>',
							'options'	=> $wpex_dashicons,
							'default'	=> 'format-status',
						),

						array(
							'id'		=> 'testimonials_labels',
							'type'		=> 'text',
							'title'		=> __( 'Testimonials Labels', 'wpex' ),
							'subtitle'	=> __( 'Use this field to rename your testimonials custom post type.', 'wpex' ),
							'default'	=> 'Testimonials',
						),

						array(
							'id'		=> 'testimonials_slug',
							'type'		=> 'text',
							'title'		=> __( 'Testimonials Slug', 'wpex' ),
							'subtitle'	=> __( 'Changes the default slug for this post type. After changing this field go to "Settings->Permalinks" and resave your settings to prevent 404 errors.', 'wpex' ),
							'default'	=> 'testimonials-item',
						),

						array(
							'id'		=> 'testimonials_cat_slug',
							'type'		=> 'text',
							'title'		=> __( 'Testimonials Category Slug', 'wpex' ),
							'subtitle'	=> __( 'Use this field to alter the default slug for this taxonomy. After changing this field go to "Settings->Permalinks" and resave your settings to prevent 404 errors.', 'wpex' ),
							'default'	=> 'testimonials-category',
						),


						/**
							Testimonials => Other
						**/
						array(
							'id'	=> 'multi-info',
							'type'	=> 'info',
							'title'	=> false,
							'desc'	=> __( 'Testimonials: Other', 'wpex' ),
						),

						array(
							'id'		=> 'testimonials_search',
							'type'		=> 'switch', 
							'title'		=> __( 'Testimonials in Search?', 'wpex' ),
							'subtitle'	=> __( 'Toggle whether items from this post type should display in search results on or off. Enabling this option will also cause items to not display in the category & tag archives, so use wisely!', 'wpex' ),
							"default"	=> '0',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'testimonial_custom_sidebar',
							'type'		=> 'switch', 
							'title'		=> __( 'Custom Testimonials Sidebar', 'wpex' ),
							'subtitle'	=> __( 'Toggle the built-in custom Testimonials post type sidebar on or off. If disabled it will display the "Main" sidebar as a fallback.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'breadcrumbs_testimonials_cat',
							'type'		=> 'switch', 
							'title'		=> __( 'Testimonials Category In Breadcrumbs', 'wpex' ),
							'subtitle'	=> __( 'Toggle the display of the category in breadcrumbs on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

					),

				);
			} // End wpex_theme_post_types check

			/**
				WooCommerce
			**/

			if ( class_exists('Woocommerce') ) {

				$sections['woocommerce'] = array(
					'id'			=> 'woocommerce',
					'icon'			=> 'el-icon-shopping-cart',
					'icon_class'	=> 'el-icon-large',
					'title'			=> __( 'WooCommerce', 'wpex' ),
					'submenu'		=> true,
					'customizer'	=> false,
					'fields'		=> array(
						array(
							'id'		=> 'woo_menu_icon',
							'type'		=> 'switch', 
							'title'		=> __( 'Menu Cart', 'wpex' ),
							'subtitle'	=> __( 'Toggle the menu shopping cart on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'woo_menu_icon_amount',
							'type'		=> 'switch', 
							'title'		=> __( 'Menu Cart: Amount', 'wpex' ),
							'subtitle'	=> __( 'Toggle the display of your cart "amount" in the menu shopping cart on or off.', 'wpex' ),
							"default"	=> '0',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
							'required'	=> array('woo_menu_icon','equals','1'),
						),

						array(
							'id'		=> 'woo_menu_icon_style',
							'type'		=> 'select',
							'title'		=> __( 'Menu Cart: Style', 'wpex' ), 
							'subtitle'	=> __( 'Select your default WooCommerce menu icon style.', 'wpex' ),
							'desc'		=> '',
							'options'	=> array(
								'overlay'		=> __( 'Open Cart Overlay','wpex' ),
								'drop-down'		=> __( 'Drop-Down','wpex' ),
								'store'			=> __( 'Go To Store','wpex' ),
								'custom-link'	=> __( 'Custom Link','wpex' ),
							),
							'default'	=> 'overlay',
							'required'	=> array( 'woo_menu_icon', 'equals', '1' ),
						),

						array(
							'id'		=> 'woo_menu_icon_custom_link',
							'type'		=> 'text',
							'title'		=> __( 'Menu Cart: Custom Link', 'wpex' ),
							'subtitle'	=> __( 'Enter your custom link for the menu cart icon.', 'wpex' ),
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
							'required'	=> array( 'woo_menu_icon_style', 'equals', 'custom-link' ),
						),

						array(
							'id'		=> 'woo_shop_overlay_top_margin',
							'type'		=> 'text',
							'title'		=> __( 'Cart Overlay Top Margin', 'wpex' ),
							'subtitle'	=> __( 'Enter your custom top margin for the WooCommerce cart overlay. The default is 120px.', 'wpex' ),
							'default'	=> '',
							'required'	=> array('woo_menu_icon_style','equals','overlay'),
						),

						array(
							'id'		=> 'woo_custom_sidebar',
							'type'		=> 'switch', 
							'title'		=> __( 'Custom WooCommerce Sidebar', 'wpex' ),
							'subtitle'	=> __( 'Toggle the built-in custom WooCommerce sidebar on or off. If disabled it will display the "Main" sidebar as a fall-back.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						/**
							WooCommerce => Archives
						**/
						array(
							'id'	=> 'multi-info',
							'type'	=> 'info',
							'title'	=> false,
							'desc'	=> __( 'WooCommerce: Archives', 'wpex' ),
						),

						array(
							'id'		=> 'woo_shop_slider',
							'type'		=> 'text',
							'title'		=> __( 'Shop Slider', 'wpex' ),
							'desc'		=> '',
							'subtitle'	=> __( 'Insert your slider shortcode for your products archive.', 'wpex' ),
							'default'	=> '',
						),

						array(
							'id'		=> 'woo_shop_posts_per_page',
							'type'		=> 'text',
							'title'		=> __( 'Shop Posts Per Page', 'wpex' ),
							'desc'		=> '',
							'subtitle'	=> __( 'How many items to display per page on your main shop archive and product category archives.', 'wpex' ),
							'default'	=> '12',
						),

						array(
							'id'		=> 'woo_shop_layout',
							'type'		=> 'button_set',
							'title'		=> __( 'Shop Layout', 'wpex' ), 
							'subtitle'	=> __( 'Select your preferred layout for your WooCommmerce Shop.', 'wpex' ),
							'desc'		=> '',
							'options'	=> array(
								'right-sidebar'	=> __( 'Right Sidebar','wpex' ),
								'left-sidebar'	=> __( 'Left Sidebar','wpex' ),
								'full-width'	=> __( 'Full Width','wpex' )
							),
							'default'	=> 'full-width',
						),

						array(
							'id'		=> 'woocommerce_shop_columns',
							'type'		=> 'button_set',
							'title'		=> __( 'Shop Columns', 'wpex' ), 
							'subtitle'	=> __( 'Select how many columns you want for the main WooCommerce shop.', 'wpex' ),
							'options'	=> array(
								'2'	=> '2',
								'3'	=> '3',
								'4'	=> '4'
							),
							'default'	=> '4',
						),


						array(
							'id'		=> 'woo_shop_title',
							'type'		=> 'switch', 
							'title'		=> __( 'Shop Title', 'wpex' ),
							'subtitle'	=> __( 'Toggle the main shop page title on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'woo_shop_sort',
							'type'		=> 'switch', 
							'title'		=> __( 'Shop Sort', 'wpex' ),
							'subtitle'	=> __( 'Toggle the main shop "sortby" function on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'woo_shop_result_count',
							'type'		=> 'switch', 
							'title'		=> __( 'Shop Result Count', 'wpex' ),
							'subtitle'	=> __( 'Toggle the main shop result count function on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'woo_entry_style',
							'type'		=> 'button_set',
							'title'		=> __( 'Product Entry Style', 'wpex' ), 
							'subtitle'	=> __( 'Select your preferred style for your WooCommmerce product entries.', 'wpex' ),
							'desc'		=> '',
							'options'	=> array(
								'one'		=> __( 'Style 1','wpex' ),
								'two'		=> __( 'Style 2','wpex' ),
							),
							'default'	=> 'two',
						),

						array(
							'id'		=> 'woo_product_entry_style',
							'type'		=> 'button_set',
							'title'		=> __( 'Product Entry Media', 'wpex' ), 
							'subtitle'	=> __( 'Select your preferred style for your WooCommmerce product entry media.', 'wpex' ),
							'desc'		=> '',
							'options'	=> array(
								'featured-image'	=> __( 'Featured Image','wpex' ),
								'image-swap'		=> __( 'Image Swap','wpex' ),
								'gallery-slider'	=> __( 'Gallery Slider','wpex' ),
							),
							'default'	=> 'image-swap',
						),

						/**
							WooCommerce => Single Product
						**/
						array(
							'id'	=> 'multi-info',
							'type'	=> 'info',
							'title'	=> false,
							'desc'	=> __( 'WooCommerce: Single Product', 'wpex' ),
						),

						array(
							'id'		=> 'woo_shop_single_title',
							'type'		=> 'text',
							'title'		=> __( 'Single Product Shop Title', 'wpex' ),
							'desc'		=> '',
							'subtitle'	=> __( 'Enter your custom shop title for single products.', 'wpex' ),
							'default'	=> __( 'Products', 'wpex' ),
						),

						array(
							'id'		=> 'woo_product_layout',
							'type'		=> 'button_set',
							'title'		=> __( 'Product Post Layout', 'wpex' ), 
							'subtitle'	=> __( 'Select your preferred layout for your WooCommmerce products.', 'wpex' ),
							'desc'		=> '',
							'options'	=> array(
								'right-sidebar'	=> __( 'Right Sidebar','wpex' ),
								'left-sidebar'	=> __( 'Left Sidebar','wpex' ),
								'full-width'	=> __( 'Full Width','wpex' )
							),
							'default'	=> 'left-sidebar'
						),

						array(
							'id'		=> 'woocommerce_upsells_count',
							'type'		=> 'text',
							'title'		=> __( 'Up-Sells Count', 'wpex' ), 
							'subtitle'	=> __( 'Enter the ammount of up-sell items to display on product pages.', 'wpex' ),
							'default'	=> '0',
						),

						array(
							'id'		=> 'woocommerce_upsells_columns',
							'type'		=> 'button_set',
							'title'		=> __( 'Up-Sells Columns', 'wpex' ), 
							'subtitle'	=> __( 'Select how many columns you want for the up-sells section.', 'wpex' ),
							'options'	=> array(
								'2'	=> '2',
								'3'	=> '3',
								'4'	=> '4'
							),
							'default'	=> '3',
						),

						array(
							'id'		=> 'woocommerce_related_count',
							'type'		=> 'text',
							'title'		=> __( 'Related Items Count', 'wpex' ), 
							'subtitle'	=> __( 'Enter the ammount of related items to display on product pages. Enter "0" to disable.', 'wpex' ),
							'default'	=> '3',
						),

						array(
							'id'		=> 'woocommerce_related_columns',
							'type'		=> 'button_set',
							'title'		=> __( 'Related Products Columns', 'wpex' ), 
							'subtitle'	=> __( 'Select how many columns you want for the related products section.', 'wpex' ),
							'options'	=> array(
								'2'	=> '2',
								'3'	=> '3',
								'4'	=> '4'
							),
							'default'	=> '3',
						),

						array(
							'id'		=> 'woo_product_meta',
							'type'		=> 'switch', 
							'title'		=> __( 'Product Meta', 'wpex' ),
							'subtitle'	=> __( 'Toggle the product meta (Categories/Tags) on product posts on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'woo_product_tabs_headings',
							'type'		=> 'switch', 
							'title'		=> __( 'Product Tabs: Headings', 'wpex' ),
							'subtitle'	=> __( 'Toggle the headings at the top of the product tabs on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						array(
							'id'		=> 'woo_next_prev',
							'type'		=> 'switch', 
							'title'		=> __( 'Products Next/Prev Links', 'wpex' ),
							'subtitle'	=> __( 'Toggle the next and previous pagination on product posts on or off.', 'wpex' ),
							"default"	=> '1',
							'on'		=> __( 'On', 'wpex' ),
							'off'		=> __( 'Off', 'wpex' ),
						),

						/**
							WooCommerce => Styling
						**/
						array(
							'id'	=> 'multi-info',
							'type'	=> 'info',
							'title'	=> false,
							'desc'	=> __( 'WooCommerce: Styling', 'wpex' ),
						),

						array(
							'id'					=> 'shop_button_background',
							'type'					=> 'color_gradient',
							'title'					=> __( 'Menu Shop Button Background', 'wpex' ),
							'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
							'default'				=> '',
							'default'				=> array(
								'from'	=> '',
								'to'	=> ''
							),
							'transparent'			=> false,
							'target_element'		=> '.header-one .dropdown-menu .wcmenucart, .header-one .dropdown-menu .wcmenucart:hover, .header-one .dropdown-menu .wcmenucart:active',
							'theme_customizer'		=> false,
						),

						array(
							'id'					=> 'shop_button_color',
							'type'					=> 'color',
							'title'					=> __( 'Menu Shop Button Color', 'wpex' ), 
							'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
							'default'				=> '',
							'transparent'			=> false,
							'target_element'		=> '.header-one .dropdown-menu .wcmenucart, .header-one .dropdown-menu .wcmenucart:hover, .header-one .dropdown-menu .wcmenucart:active',
							'target_style'			=> 'color',
							'theme_customizer'		=> false,
						),

						array(
							'id'				=> 'onsale_bg',
							'type'				=> 'color_gradient',
							'title'				=> __( 'On Sale Background', 'wpex' ),
							'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
							'transparent'		=> false,
							'target_element'	=> 'ul.products li.product .onsale, .single-product .onsale',
							'default'			=> array(
								'from'	=> '',
								'to'	=> ''
							),
						),

						array(
							'id'					=> 'woo_product_title_link_color',
							'type'					=> 'link_color',
							'title'					=> __( 'Product Entry Title Color', 'wpex' ),
							'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
							'default'				=> array(
								'regular'	=> '',
								'hover'		=> '',
								'active'	=> '',
							),
							'target_element'		=> 'body .product-entry .product-entry-title a, .related.products .product-entry-title a',
							'target_element_hover'	=> 'body .product-entry .product-entry-title a:hover, body .product-entry .product-entry-title:hover a, .related.products .product-entry-title:hover a, .related.products .product-entry-title a:hover',
							'target_element_active'	=> 'body .product-entry .product-entry-title a:active, .related.products .product-entry-title a:active',
							'target_style'			=> 'color',
						),

						array(
							'id'				=> 'woo_single_price_color',
							'type'				=> 'color',
							'title'				=> __( 'Single Product Price Color', 'wpex' ),
							'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
							'transparent'		=> false,
							'target_element'	=> 'div.product p.price',
							'target_style'		=> 'color',
							'default'			=> ''
						),

						array(
							'id'				=> 'woo_stars_color',
							'type'				=> 'color',
							'title'				=> __( 'Star Ratings Color', 'wpex' ),
							'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
							'transparent'		=> false,
							'target_element'	=> '.star-rating span',
							'target_style'		=> 'color',
							'default'			=> ''
						),

						array(
							'id'				=> 'woo_single_tabs_active_border_color',
							'type'				=> 'color',
							'title'				=> __( 'Product Tabs Active Border Color', 'wpex' ),
							'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
							'transparent'		=> false,
							'target_element'	=> 'div.product .woocommerce-tabs ul.tabs li.active a',
							'target_style'		=> 'border-color',
							'default'			=> ''
						),

					),
				);

			}


			/**
				Blog
			**/
			$sections['blog'] = array(
				'id'			=> 'blog',
				'icon'			=> 'el-icon-edit',
				'icon_class'	=> 'el-icon-large',
				'title'			=> __( 'Blog', 'wpex' ),
				'submenu'		=> true,
				'customizer'	=> false,
				'fields'		=> array(

					array(
						'id'		=> 'blog_page',
						'type'		=> 'select',
						'data'		=> 'pages',
						'title'		=> __( 'Blog Page', 'wpex' ),
						'subtitle'	=> __( 'Select your main blog page. This is used for your breadcrumbs.', 'wpex' ),
						'default'	=> '',
					),

					array(
						'id'		=> 'blog_cats_exclude',
						'type'		=> 'select',
						'data'		=> 'categories',
						'multi'		=> true,
						'title'		=> __( 'Exclude Categories From Blog', 'wpex' ), 
						'subtitle'	=> __( 'Use this option to exclude categories from your main blog template and/or your index (if using the homepage as a blog)', 'wpex' ),
					),

					/**
							Blog => Archives
					**/
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Blog: Archives', 'wpex' ),
					),

					array(
						'id'		=> 'blog_style',
						'type'		=> 'button_set',
						'title'		=> __( 'Blog Style', 'wpex' ), 
						'subtitle'	=> __( 'Select your preferred blog style.', 'wpex' ),
						'options'	=> array(
							'large-image-entry-style'	=> __( 'Large Image','wpex' ),
							'thumbnail-entry-style'		=> __( 'Thumbnail','wpex' ),
							'grid-entry-style'			=> __( 'Grid','wpex' )
						),
						'default'	=> 'large-image-entry-style'
					),

					array(
						'id'		=> 'blog_grid_columns',
						'type'		=> 'button_set',
						'title'		=> __( 'Grid Style Columns', 'wpex' ), 
						'subtitle'	=> __( 'Select how many columns you want for your grid style blog archives.', 'wpex' ),
						'options'	=> array(
							'2'	=> '2',
							'3'	=> '3',
							'4'	=> '4'
						),
						'default'	=> '2',
						'required'	=> array('blog_style','equals','grid-entry-style'),
					),

					array(
						'id'		=> 'blog_archives_layout',
						'type'		=> 'button_set',
						'title'		=> __( 'Blog Archives Layout', 'wpex' ), 
						'subtitle'	=> __( 'Select your preferred layout for your main blog page, categories and tags.', 'wpex' ),
						'options'	=> array(
							'right-sidebar'	=> __( 'Right Sidebar','wpex' ),
							'left-sidebar'	=> __( 'Left Sidebar','wpex' ),
							'full-width'	=> __( 'Full Width','wpex' )
						),
						'default'	=> 'right-sidebar'
					),

					array(
						'id'		=> 'blog_pagination_style',
						'type'		=> 'button_set',
						'title'		=> __( 'Pagination Style', 'wpex' ), 
						'subtitle'	=> __( 'Select your preferred pagination style for the blog.', 'wpex' ),
						'options'	=> array(
							'standard'			=> __( 'Standard','wpex' ),
							'infinite_scroll'	=> __( 'Infinite Scroll','wpex' ),
							'next_prev'			=> __( 'Next/Prev','wpex' )
						),
						'default'	=> 'standard'
					),

					array(
						'id'		=> 'category_descriptions',
						'type'		=> 'switch', 
						'title'		=> __( 'Category Descriptions', 'wpex' ),
						'subtitle'	=> __( 'Toggle category descriptions on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'blog_entry_image_hover_animation',
						'type'		=> 'select',
						'title'		=> __( 'Entry Image Hover Animation', 'wpex' ), 
						'subtitle'	=> __( 'Select your preferred animation style for blog entry images.', 'wpex' ),
						'options'	=> $image_hovers,
						'default'	=> 'standard'
					),

					array(
						'id'		=> 'blog_exceprt',
						'type'		=> 'switch', 
						'title'		=> __( 'Entry Auto Excerpts', 'wpex' ),
						'subtitle'	=> __( 'Toggle your blog auto excerpts on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'blog_excerpt_length',
						'type'		=> 'text',
						'title'		=> __( 'Entry Excerpt length', 'wpex' ),
						'desc'		=> '',
						'subtitle'	=> __( 'How many words do you want to show for your blog entry excerpts?', 'wpex' ),
						'default'	=> '40',
						'required'	=> array( 'blog_exceprt', 'equals', '1' ),
					),

					array(
						'id'		=> 'blog_entry_readmore',
						'type'		=> 'switch', 
						'title'		=> __( 'Entry Read More Button', 'wpex' ),
						'subtitle'	=> __( 'Toggle the blog entry read more button on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'blog_entry_readmore_text',
						'type'		=> 'text', 
						'title'		=> __( 'Entry Read More Text', 'wpex' ),
						'subtitle'	=> __( 'Your custom entry read more button text, default is "Continue Reading".', 'wpex' ),
						"default"	=> '',
						'required'	=> array( 'blog_entry_readmore', 'equals', '1' ),
					),

					array(
						'id'		=> 'blog_entry_author_avatar',
						'type'		=> 'switch', 
						'title'		=> __( 'Entry Author Avatar', 'wpex' ),
						'subtitle'	=> __( 'Toggle the author avatar on your blog entries on or off. Note: This option only applies to certain blog styles.', 'wpex' ),
						"default"	=> 0,
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
						'required'	=> array('blog_style','equals','large-image-entry-style'),
					),

					/**
							Blog => Single Post
					**/
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Blog: Single Post', 'wpex' ),
					),

					array(
						'id'		=> 'blog_single_layout',
						'type'		=> 'button_set',
						'title'		=> __( 'Post Layout', 'wpex' ),
						'subtitle'	=> __( 'Select your preferred layout for your single posts. This setting can be overwritten on a per post basis via the meta options.', 'wpex' ),
						'options'	=> array(
							'right-sidebar'	=> __( 'Right Sidebar','wpex' ),
							'left-sidebar'	=> __( 'Left Sidebar','wpex' ),
							'full-width'	=> __( 'Full Width','wpex' )
						),
						'default'	=> 'right-sidebar'
					),

					array(
						'id'		=> 'blog_single_header',
						'type'		=> 'button_set',
						'title'		=> __( 'Post Header Displays', 'wpex' ),
						'subtitle'	=> __( 'Select what you want to display in the main header for single blog posts. If you select the title then it will not display with the meta within the post content, if you select custom text then the title will display with the meta.', 'wpex' ),
						'options'	=> array(
							'custom_text'	=> __( 'Custom Text','wpex' ),
							'post_title'	=> __( 'Post Title','wpex' ),
						),
						'default'	=> 'custom_text',
					),

					array(
						'id'		=> 'blog_single_header_custom_text',
						'type'		=> 'text', 
						'title'		=> __( 'Post Header Custom Text', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom text for the header on single posts.', 'wpex' ),
						"default"	=> __( 'Blog', 'wpex' ),
						'required'	=> array( 'blog_single_header', '=', 'custom_text' ),
					),

					array(
						'id'		=> 'blog_single_composer',
						'type'		=> 'sorter',
						'title'		=> __( 'Post Elements', 'wpex' ),
						'subtitle'	=> __( 'Select your preferred order for the blog posts.', 'wpex' ),
						'compiler'	=> 'false',
						'options'	=> array(
							'enabled'	=> array(
								'featured_media'	=> __( 'Featured Media','wpex' ),
								'title_meta'		=> __( 'Title & Meta','wpex' ),
								'post_series'		=> __( 'Post Series','wpex' ),
								'the_content'		=> __( 'Content','wpex' ),
								'social_share'		=> __( 'Social Share','wpex' ),
								'author_bio'		=> __( 'Author Bio','wpex' ),
								'related_posts'		=> __( 'Related Posts','wpex' ),
								'comments'			=> __( 'Comments','wpex' ),
							),
							'disabled'	=> array(
								'post_tags'	=> __( 'Post Tags','wpex' ),
							),
						),
					),

					array(
						'id'		=> 'blog_thumbnail_caption',
						'type'		=> 'switch', 
						'title'		=> __( 'Featured Image Caption', 'wpex' ),
						'subtitle'	=> __( 'Toggle the display of the featured image caption for single blog posts on or off (for standard post format only).', 'wpex' ),
						"default"	=> '',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'blog_related_count',
						'type'		=> 'text', 
						'title'		=> __( 'Post Related Articles Count', 'wpex' ),
						'subtitle'	=> __( 'Enter the number of related items to display.', 'wpex' ),
						"default"	=> '3',
					),

					array(
						'id'		=> 'blog_related_excerpt_length',
						'type'		=> 'text', 
						'title'		=> __( 'Post Related Articles Excerpt Length', 'wpex' ),
						'subtitle'	=> __( 'How many words to display for the related articles excerpt?', 'wpex' ),
						"default"	=> '15',
					),

					/**
							Blog => Other
					**/
					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Blog: Other', 'wpex' ),
					),

					array(
						'id'		=> 'breadcrumbs_blog_cat',
						'type'		=> 'switch', 
						'title'		=> __( 'Category In Breadcrumbs', 'wpex' ),
						'subtitle'	=> __( 'Toggle the display of the category in breadcrumbs on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'post_series',
						'type'		=> 'switch',
						'title'		=> __( 'Post Series', 'wpex' ),
						'subtitle'	=> __( 'Toggle the post series custom taxonomy on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

				),

			);


			/**
				Images
			**/
			$sections['images'] = array(
				'id'			=> 'images',
				'icon'			=> 'el-icon-camera',
				'icon_class'	=> 'el-icon-large',
				'title'			=> __( 'Image Cropping', 'wpex' ),
				'submenu'		=> true,
				'customizer'	=> false,
				'fields'		=> array(

					array(
						'id'		=> 'image_resizing',
						'type'		=> 'switch', 
						'title'		=> __( 'Image Cropping', 'wpex' ),
						'subtitle'	=> __( 'Toggle the built-in image resizing function on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'retina',
						'type'		=> 'switch', 
						'title'		=> __( 'Retina Support', 'wpex' ),
						'subtitle'	=> __( 'Toggle the retina support for your resized images on or off.', 'wpex' ),
						"default"	=> 0,
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array( 
						"title"		=> __( 'Blog Entry: Image Width', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom width in pixels.', 'wpex' ),
						"id"		=> "blog_entry_image_width",
						"default"	=> '680',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'Blog Entry: Image Height', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom height in pixels. Enter 9999 to keep your image proportions.', 'wpex' ),
						"id"		=> "blog_entry_image_height",
						"default"	=> '380',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array( 
						"title"		=> __( 'Blog Post: Image Width', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom width in pixels.', 'wpex' ),
						"id"		=> "blog_post_image_width",
						"default"	=> '680',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'Blog Post: Image Height', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom height in pixels. Enter 9999 to keep your image proportions.', 'wpex' ),
						"id"		=> "blog_post_image_height",
						"default"	=> '380',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array( 
						"title"		=> __( 'Blog Full-Width Post: Image Width', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom width in pixels.', 'wpex' ),
						"id"		=> "blog_post_full_image_width",
						"default"	=> '980',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'Blog Full-Width Post: Image Height', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom height in pixels. Enter 9999 to keep your image proportions.', 'wpex' ),
						"id"		=> "blog_post_full_image_height",
						"default"	=> '9999',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array( 
						"title"		=> __( 'Blog Related Posts: Image Width', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom width in pixels.', 'wpex' ),
						"id"		=> "blog_related_image_width",
						"default"	=> '680',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'Blog Related Posts: Image Height', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom height in pixels. Enter 9999 to keep your image proportions.', 'wpex' ),
						"id"		=> "blog_related_image_height",
						"default"	=> '380',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'Portfolio Archive Entry: Image Width', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom width in pixels.', 'wpex' ),
						"id"		=> "portfolio_entry_image_width",
						"default"	=> '500',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'Portfolio Archive Entry: Image Height', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom height in pixels. Enter 9999 to keep your image proportions.', 'wpex' ),
						"id"		=> "portfolio_entry_image_height",
						"default"	=> '350',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array( 
						"title"		=> __( 'Staff Archive Entry: Image Width', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom width in pixels.', 'wpex' ),
						"id"		=> "staff_entry_image_width",
						"default"	=> '500',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'Staff Archive Entry: Image Height', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom height in pixels. Enter 9999 to keep your image proportions.', 'wpex' ),
						"id"		=> "staff_entry_image_height",
						"default"	=> '500',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array( 
						"title"		=> __( 'Testimonial Archive Entry: Image Width', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom width in pixels.', 'wpex' ),
						"id"		=> "testimonial_entry_image_width",
						"default"	=> '45',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'Testimonial Archive Entry: Image Height', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom height in pixels. Enter 9999 to keep your image proportions.', 'wpex' ),
						"id"		=> "testimonial_entry_image_height",
						"default"	=> '45',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'WooCommerce Entry: Image Width', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom width in pixels.', 'wpex' ),
						"id"		=> "woo_entry_width",
						"default"	=> '480',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'WooCommerce Entry: Image Height', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom height in pixels. Enter 9999 to keep your image proportions.', 'wpex' ),
						"id"		=> "woo_entry_height",
						"default"	=> '540',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'WooCommerce Post: Image Width', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom width in pixels.', 'wpex' ),
						"id"		=> "woo_post_image_width",
						"default"	=> '480',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'WooCommerce Post: Image Height', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom height in pixels. Enter 9999 to keep your image proportions.', 'wpex' ),
						"id"		=> "woo_post_image_height",
						"default"	=> '540',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'WooCommerce Category Entry: Image Width', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom width in pixels.', 'wpex' ),
						"id"		=> "woo_cat_entry_width",
						"default"	=> '',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'WooCommerce Category Entry: Image Height', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom height in pixels. Enter 9999 to keep your image proportions.', 'wpex' ),
						"id"		=> "woo_cat_entry_height",
						"default"	=> '',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'Custom WP Gallery: Image Width', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom width in pixels.', 'wpex' ),
						"id"		=> "gallery_image_width",
						"default"	=> '500',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),

					array(
						"title"		=> __( 'Custom WP Gallery: Image Height', 'wpex' ),
						"subtitle"	=> __( 'Enter your custom height in pixels. Enter 9999 to keep your image proportions.', 'wpex' ),
						"id"		=> "gallery_image_height",
						"default"	=> '500',
						"type"		=> "text",
						'required'	=> array( 'image_resizing', 'equals', '1' ),
					),
				)
			);

			/**
				404
			**/
			$sections['error_page'] = array(
				'id'			=> 'error_page',
				'icon'			=> 'el-icon-error',
				'icon_class'	=> 'el-icon-large',
				'title'			=> __( '404 Page', 'wpex' ),
				'submenu'		=> true,
				'customizer'	=> false,
				'fields'		=> array(

					array(
						'id'		=> 'error_page_redirect',
						'type'		=> 'switch', 
						'title'		=> __( 'Redirect 404', 'wpex' ),
						'subtitle'	=> __( 'Toggle on to redirect all 404 errors to your homepage. Some people think this is good for SEO.', 'wpex' ),
						"default"	=> '',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'error_page_title',
						'type'		=> 'text', 
						'title'		=> __( '404 Page Title', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom title for the 404 page.', 'wpex' ),
						"default"	=> '',
						'required'	=> array( 'error_page_redirect', '!=', '1' ),
					),

					array(
						'id'		=> 'error_page_text',
						'type'		=> 'editor',
						'title'		=> __( '404 Page Content', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom content for the 404 page.', 'wpex' ),
						"default"	=> '',
						'required'	=> array( 'error_page_redirect', '!=', '1' ),
						'teeny'		=> false,
					),

					array(
						'id'		=> 'error_page_styling',
						'type'		=> 'switch', 
						'title'		=> __( '404 Page Custom Styling', 'wpex' ),
						'subtitle'	=> __( 'Toggle the custom styling for the 404 page content area (larger and lighter font) on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
						'required'	=> array( 'error_page_redirect', '!=', '1' ),
					),
				),
			);


			/**
				Footer
			**/
			$sections['footer'] = array(
				'id'			=> 'footer',
				'icon'			=> 'el-icon-bookmark',
				'icon_class'	=> 'el-icon-large',
				'title'			=> __( 'Footer', 'wpex' ),
				'submenu'		=> true,
				'fields'		=> array(

					array(
						'id'		=> 'callout',
						'type'		=> 'switch', 
						'title'		=> __( 'Footer Callout', 'wpex' ),
						'subtitle'	=> __( 'Toggle the callout area in the footer on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'callout_visibility',
						'type'		=> 'select',
						'title'		=> __( 'Callout Visibility', 'wpex' ), 
						'subtitle'	=> __( 'Select your visibility.', 'wpex' ),
						'options'	=> $visibility,
						'default'	=> 'always-visible',
						'required'	=> array( 'callout', 'equals', '1' ),
					),

					array(
						'id'				=> 'callout_text',
						'type'				=> 'editor',
						'title'				=> __( 'Footer Callout: Content', 'wpex' ), 
						'subtitle'			=> __( 'Enter your custom content for your footer callout.', 'wpex' ),
						'default'			=> 'I am the footer call-to-action block, here you can add some relevant/important information about your company or product. I can be disabled in the theme options.',
						'required'			=> array( 'callout', 'equals', '1' ),
						'editor_options'	=> '',
						'args'				=> array('teeny' => false)
					),

					array(
						'id'		=> 'callout_link',
						'type'		=> 'text',
						'title'		=> __( 'Footer Callout: Link', 'wpex' ), 
						'subtitle'	=> __( 'Enter a url for your footer callout button. Leave blank to disable and show the content full-width.', 'wpex' ),
						'default'	=> 'http://www.wpexplorer.com',
						'required'	=> array('callout','equals','1'),
					),

					array(
						'id'		=> 'callout_link_txt',
						'type'		=> 'text',
						'title'		=> __( 'Footer Callout: Link Text', 'wpex' ), 
						'subtitle'	=> __( 'Enter the text for your footer callout link.', 'wpex' ),
						'default'	=> 'Get In Touch',
						'required'	=> array('callout','equals','1'),
					),

					array(
						'id'				=> 'footer_callout_bg',
						'type'				=> 'color',
						'title'				=> __( 'Footer Callout: Background', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#footer-callout-wrap',
						'target_style'		=> 'background-color',
						'required'			=> array( 'callout', 'equals', '1' ),
					),

					array(
						'id'				=> 'footer_callout_border',
						'type'				=> 'color',
						'title'				=> __( 'Footer Callout: Border Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#footer-callout-wrap',
						'target_style'		=> 'border-top-color',
						'required'			=> array( 'callout', 'equals', '1' ),
					),

					array(
						'id'				=> 'footer_callout_color',
						'type'				=> 'color',
						'title'				=> __( 'Footer Callout: Color', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '#footer-callout-wrap',
						'target_style'		=> 'color',
						'required'			=> array( 'callout', 'equals', '1' ),
					),

					array(
						'id'					=> 'footer_callout_link_color',
						'type'					=> 'link_color',
						'title'					=> __( 'Footer Callout: Content Link Color', 'wpex' ),
						'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
						'default'				=> array(
							'regular'	=> '',
							'hover'		=> '',
							'active'	=> '',
						),
						'target_element'		=> '.footer-callout-content a',
						'target_element_hover'	=> '.footer-callout-content a:hover',
						'target_element_active'	=> '.footer-callout-content a:active',
						'target_style'			=> 'color',
						'required'				=> array( 'callout', 'equals', '1' ),
					),

					array(
						'id'				=> 'footer_callout_button_bg',
						'type'				=> 'color_gradient',
						'title'				=> __( 'Footer Callout: Button Background', 'wpex' ), 
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> array(
							'from'	=> '',
							'to'	=> ''
						),
						'transparent'		=> false,
						'target_element'	=> '#footer-callout .theme-button',
						'required'			=> array( 'callout', 'equals', '1' ),
					),

					array(
						'id'				=> 'footer_callout_button_color',
						'type'				=> 'color',
						'title'				=> __( 'Footer Callout: Button Text Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'transparent'		=> false,
						'default'			=> '',
						'target_element'	=> '#footer-callout .theme-button',
						'required'			=> array( 'callout', 'equals', '1' ),
						'target_style'		=> 'color',
					),

					array(
						'id'				=> 'footer_callout_button_hover_bg',
						'type'				=> 'color_gradient',
						'title'				=> __( 'Footer Callout: Button Hover Background', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> array(
							'from'	=> '',
							'to'	=> ''
						),
						'transparent'		=> false,
						'target_element'	=> '#footer-callout .theme-button:hover',
						'required'			=> array( 'callout', 'equals', '1' ),
					),

					array(
						'id'				=> 'footer_callout_button_hover_color',
						'type'				=> 'color',
						'title'				=> __( 'Footer Callout: Button Hover Text Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'transparent'		=> false,
						'default'			=> '',
						'target_element'	=> '#footer-callout .theme-button:hover',
						'required'			=> array( 'callout', 'equals', '1' ),
						'target_style'		=> 'color',
					),

					array(
						'id'			=> 'callout_button_target',
						'type'			=> 'button_set',
						'title'			=> __( 'Footer Callout: Button Target', 'wpex' ),
						'subtitle'		=> __( 'Select your footer callout button link target window.', 'wpex' ),
						'options'		=> array(
							'blank'	=> __( 'New Window', 'wpex' ),
							'self'	=> __( 'Same Window', 'wpex' )
						),
						'default'		=> 'blank',
						'required'		=> array('callout','equals','1'),
					),

					array(
						'id'		=> 'callout_button_rel',
						'type'		=> 'button_set',
						'title'		=> __( 'Footer Callout: Button Rel', 'wpex' ),
						'subtitle'	=> __( 'Select your footer callout button link rel value.', 'wpex' ),
						'options'	=> array(
							'dofollow'	=> 'dofollow',
							'nofollow'	=> 'nofollow'
						),
						'default'	=> 'dofollow',
						'required'	=> array('callout','equals','1'),
					),

					array(
						'id'		=> 'callout_button_border_radius',
						'type'		=> 'text',
						'title'		=> __( 'Footer Callout: Button Border Radius', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom border radius for the callout button in px.', 'wpex' ),
						'required'	=> array('callout','equals','1'),
					),

					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Footer Widgets', 'wpex' ),
					),

					array(
						'id'		=> 'footer_widgets',
						'type'		=> 'switch', 
						'title'		=> __( 'Footer Widgets', 'wpex' ),
						'subtitle'	=> __( 'Toggle the footer widgets on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'footer_col',
						'type'		=> 'button_set',
						'title'		=> __( 'Footer Widget Columns', 'wpex' ), 
						'subtitle'	=> __( 'Select how many columns you want for your footer widgets.', 'wpex' ),
						'desc'		=> '',
						'options'	=> array(
							'4'	=> '4',
							'3'	=> '3',
							'2'	=> '2',
							'1'	=> '1',
						),
						'default'	=> '4',
						'required'	=> array('footer_widgets','equals','1'),
					),

					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Bottom Footer Area', 'wpex' ),
					),

					array(
						'id'		=> 'footer_copyright',
						'type'		=> 'switch', 
						'title'		=> __( 'Bottom Footer Area', 'wpex' ),
						'subtitle'	=> __( 'Toggle the bottom footer area on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'				=> 'footer_copyright_text',
						'type'				=> 'editor',
						'title'				=> __( 'Copyright', 'wpex' ), 
						'subtitle'			=> __( 'Enter your custom copyright text.', 'wpex' ),
						'default'			=> 'Copyright 2013 - All Rights Reserved',
						'required'			=> array('footer_copyright','equals','1'),
						'editor_options'	=> '',
						'args'				=> array('teeny' => false)
					),

					array(
						'id'	=> 'multi-info',
						'type'	=> 'info',
						'title'	=> false,
						'desc'	=> __( 'Scroll Up Button', 'wpex' ),
					),

					array(
						'id'		=> 'scroll_top',
						'type'		=> 'switch', 
						'title'		=> __( 'Scroll Up Button', 'wpex' ),
						'subtitle'	=> __( 'Toggle the scroll to top button on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'scroll_top_border_radius',
						'type'		=> 'text',
						'title'		=> __( 'Scroll Up Button Border Radius', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom border radius for the scroll top button. Default is 35px.', 'wpex' ),
						'required'	=> array('scroll_top','equals','1'),
					),

					array(
						'id'			=> 'scroll_top_bg',
						'type'			=> 'link_color',
						'title'			=> __( 'Scroll Up Button Background', 'wpex' ),
						'subtitle'		=> __( 'Select your custom hex color.', 'wpex' ),
						'default'		=> array(
							'regular'	=> '',
							'hover'		=> '',
							'active'	=> '',
						),
						'required'				=> array('scroll_top','equals','1'),
						'target_element'		=> '#site-scroll-top',
						'target_element_hover'	=> '#site-scroll-top:hover',
						'target_element_active'	=> '#site-scroll-top:active',
						'target_style'			=> 'background',
					),

					array(
						'id'					=> 'scroll_top_border',
						'type'					=> 'link_color',
						'title'					=> __( 'Scroll Up Button Border', 'wpex' ),
						'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
						'default'				=> array(
							'regular'	=> '',
							'hover'		=> '',
							'active'	=> '',
						),
						'required'				=> array('scroll_top','equals','1'),
						'target_element'		=> '#site-scroll-top',
						'target_element_hover'	=> '#site-scroll-top:hover',
						'target_element_active'	=> '#site-scroll-top:active',
						'target_style'			=> 'border-color',
					),

					array(
						'id'					=> 'scroll_top_color',
						'type'					=> 'link_color',
						'title'					=> __( 'Scroll Up Button Color', 'wpex' ),
						'subtitle'				=> __( 'Select your custom hex color.', 'wpex' ),
						'default'				=> array(
							'regular'	=> '',
							'hover'		=> '',
							'active'	=> '',
						),
						'required'				=> array('scroll_top','equals','1'),
						'target_element'		=> '#site-scroll-top',
						'target_element_hover'	=> '#site-scroll-top:hover',
						'target_element_active'	=> '#site-scroll-top:active',
						'target_style'			=> 'color',
					),
				)
			);


			/**
				Visual Composer
			**/
			$sections['visual_composer'] = array(
				'id'			=> 'visual_composer',
				'icon'			=> 'el-icon-puzzle',
				'icon_class'	=> 'el-icon-large',
				'title'			=> __( 'Visual Composer', 'wpex' ),
				'submenu'		=> true,
				'fields'		=> array(

					array(
						'id'		=> 'visual_composer_theme_mode',
						'type'		=> 'switch',
						'title'		=> __( 'Run Visual Composer In Theme Mode', 'wpex' ),
						'subtitle'	=> __( 'Please keep this option enabled unless you have purchased a full copy of the Visual Composer plugin directly from the author.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'disable_visual_composer_extension',
						'type'		=> 'switch',
						'title'		=> __( 'Extend The Visual Composer?', 'wpex' ),
						'subtitle'	=> __( 'This theme includes many extensions (more modules) for the Visual Composer plugin. If you do not wish to use any disable them here.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'				=> 'vcex_text_separator_two_border_color',
						'type'				=> 'color',
						'title'				=> __( 'Seperator With Text Border Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color for the seperator with text module style 2.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> 'body .vc_text_separator_two span',
						'target_style'		=> 'border-color',
						'theme_customizer'	=> false,
					),

					array(
						'id'				=> 'vcex_text_tab_two_bottom_border',
						'type'				=> 'color',
						'title'				=> __( 'Tabs Alternative 2 Border Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color for the style 2 tabs that has a bottom border on the active link.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> 'body .wpb_tabs.tab-style-alternative-two .wpb_tabs_nav li.ui-tabs-active a',
						'target_style'		=> 'border-color',
						'theme_customizer'	=> false,
					),

					array(
						'id'				=> 'vcex_carousel_arrows',
						'type'				=> 'color',
						'title'				=> __( 'Carousel Arrows Highlight Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color for the carousel arrows.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.vcex-caroufredsel-wrap .vcex-caroufredsel-prev, .vcex-caroufredsel-wrap .vcex-caroufredsel-next, .vcex-caroufredsel-wrap .vcex-caroufredsel-prev:hover,.vcex-caroufredsel-wrap .vcex-caroufredsel-next:hover',
						'target_style'		=> 'background-color',
						'theme_customizer'	=> false,
					),

					array(
						'id'				=> 'vcex_pricing_featured_default',
						'type'				=> 'color',
						'title'				=> __( 'Featured Pricing Table Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.vcex-pricing.featured .vcex-pricing-header h5',
						'target_style'		=> 'background-color',
						'theme_customizer'	=> false,
					),

					array(
						'id'				=> 'vcex_grid_filter_active_color',
						'type'				=> 'color',
						'title'				=> __( 'Grid Filter: Active Link Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.vcex-filter-links a:hover, .vcex-filter-links li.active a',
						'target_style'		=> 'color',
						'theme_customizer'	=> false,
					),

					array(
						'id'				=> 'vcex_grid_filter_active_bg',
						'type'				=> 'color',
						'title'				=> __( 'Grid Filter: Active Link Background', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.vcex-filter-links a:hover, .vcex-filter-links li.active a',
						'target_style'		=> 'background-color',
						'theme_customizer'	=> false,
					),

					array(
						'id'				=> 'vcex_grid_filter_active_border',
						'type'				=> 'color',
						'title'				=> __( 'Grid Filter: Active Link Border', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.vcex-filter-links a:hover, .vcex-filter-links li.active a',
						'target_style'		=> 'border-color',
						'theme_customizer'	=> false,
					),

					array(
						'id'				=> 'vcex_recent_news_date_bg',
						'type'				=> 'color',
						'title'				=> __( 'Recent News Date: Background', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.vcex-recent-news-date span.month',
						'target_style'		=> 'background',
						'theme_customizer'	=> false,
					),

					array(
						'id'				=> 'vcex_recent_news_date_color',
						'type'				=> 'color',
						'title'				=> __( 'Recent News Date: Color', 'wpex' ),
						'subtitle'			=> __( 'Select your custom hex color.', 'wpex' ),
						'default'			=> '',
						'transparent'		=> false,
						'target_element'	=> '.vcex-recent-news-date span.month',
						'target_style'		=> 'color',
						'theme_customizer'	=> false,
					),

				),
			);

			/**
				Admin Login
			**/
			$sections['admin_login'] = array(
				'id'			=> 'admin_login',
				'icon'			=> 'el-icon-lock',
				'icon_class'	=> 'el-icon-large',
				'title'			=> __( 'Admin Login', 'wpex' ),
				'submenu'		=> true,
				'customizer'	=> false,
				'fields'		=> array(
					
					array(
						'id'		=> 'custom_admin_login',
						'type'		=> 'switch', 
						'title'		=> __( 'Custom Login Screen', 'wpex' ),
						'subtitle'	=> __( 'Toggle the custom login screen design on or off. If you want to disable it, remove the default images below to save on loading time for your theme panel.', 'wpex' ),
						"default"	=> '',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'admin_login_logo',
						'url'		=> true,
						'type'		=> 'media',
						'title'		=> __( 'Logo', 'wpex' ),
						'read-only'	=> false,
						'default'	=> array(
							'url'	=> '',
						),
						'subtitle'	=> __( 'Upload a custom logo for your login screen .', 'wpex' ),
						'required'	=> array( 'custom_admin_login', 'equals', '1' ),
					),

					array(
						'id'		=> 'admin_login_logo_height',
						'type'		=> 'text',
						'default'	=> '',
						'title'		=> __( 'Logo Height', 'wpex' ),
						'subtitle'	=> __( 'Enter a height in pixels for your login logo (required).', 'wpex' ),
						'required'	=> array( 'custom_admin_login', 'equals', '1' ),
					),

					array(
						'id'				=> 'admin_login_logo_url',
						'type'				=> 'text',
						'title'				=> __( 'Logo URL', 'wpex' ), 
						'subtitle'			=> __( 'By default the login screen logo goes to WordPress.org, enter a custom URL here to override it.', 'wpex' ),
						'required'			=> array( 'custom_admin_login', 'equals', '1' ),
						'default'			=> home_url(),
					),

					array(
						'id'			=> 'admin_login_background_color',
						'transparent'	=> false,
						'type'			=> 'color',
						'title'			=> __( 'Body Background Color', 'wpex' ),
						'default'		=> '',
						'subtitle'		=> __( 'Select your custom hex color.', 'wpex' ),
						'required'		=> array( 'custom_admin_login', 'equals', '1' ),
					),

					array(
						'id'		=> 'admin_login_background_img',
						'url'		=> true,
						'type'		=> 'media',
						'title'		=> __( 'Background Image', 'wpex' ),
						'read-only'	=> false,
						'default'	=> array(
							'url'	=> '',
						),
						'subtitle'	=> __( 'Upload a custom background image for your admin login screen.', 'wpex' ),
						'required'	=> array( 'custom_admin_login', 'equals', '1' ),
					),

					array(
						'id'		=> 'admin_login_background_style',
						'type'		=> 'button_set',
						'title'		=> __( 'Background Image Style', 'wpex' ),
						'subtitle'	=> __( 'Select your preferred background style.', 'wpex' ),
						'options'	=> array(
							'stretched'	=> __( 'Stretched','wpex' ),
							'repeat'	=> __( 'Repeat','wpex' ),
							'fixed'		=> __( 'Center Fixed','wpex' )
						),
						'default'	=> 'stretched',
						'required'	=> array( 'custom_admin_login', 'equals', '1' ),
					),

					array(
						'id'			=> 'admin_login_form_background_color',
						'transparent'	=> false,
						'type'			=> 'color',
						'title'			=> __( 'Form Background Color', 'wpex' ),
						'default'		=> '',
						'subtitle'		=> __( 'Select your custom hex color.', 'wpex' ),
						'required'		=> array( 'custom_admin_login', 'equals', '1' ),
					),

					array(
						'id'			=> 'admin_login_form_background_opacity',
						'type'			=> 'slider',
						'title'			=> __( 'Form Background Opacity', 'wpex' ),
						'subtitle'		=> __( 'Select your custom hex color.', 'wpex' ),
						'default'		=> 1,
						'min'			=> 0,
						'step'			=> .1,
						'max'			=> 1,
						'resolution'	=> 0.1,
						'display_value'	=> 'text',
						'required'		=> array( 'custom_admin_login', 'equals', '1' ),
					),

					array(
						'id'			=> 'admin_login_form_text_color',
						'transparent'	=> false,
						'type'			=> 'color',
						'title'			=> __( 'Form Text Color', 'wpex' ),
						'default'		=> '',
						'subtitle'		=> __( 'Select your custom hex color.', 'wpex' ),
						'required'		=> array( 'custom_admin_login', 'equals', '1' ),
					),

					array(
						'id'			=> 'admin_login_form_top',
						'type'			=> 'text',
						'title'			=> __( 'Form Top Margin', 'wpex' ),
						'default'		=> '150',
						'subtitle'		=> __( 'Enter a top margin for your login form in pixels.', 'wpex' ),
						'required'		=> array( 'custom_admin_login', 'equals', '1' ),
					),

				),
			);


			/**
				Social
			**/
			$sections['social'] = array(
				'id'			=> 'social',
				'icon'			=> 'el-icon-twitter',
				'icon_class'	=> 'el-icon-large',
				'title'			=> __( 'Social Sharing', 'wpex' ),
				'customizer'	=> false,
				'submenu'		=> true,
				'fields'		=> array(

					array(
						'id'		=> 'social_share_position',
						'type'		=> 'button_set',
						'title'		=> __( 'Social Sharing Position', 'wpex' ), 
						'subtitle'	=> __( 'Select your preferred social sharing buttons position.', 'wpex' ),
						'options'	=> array(
							'horizontal'	=> __( 'Horizontal','wpex' ),
							'vertical'		=> __( 'Vertical','wpex' ),
						),
						'default'	=> 'horizontal',
					),

					array(
						'id'		=> 'social_share_heading',
						'type'		=> 'text',
						'title'		=> __( 'Social Sharing Heading', 'wpex' ), 
						'subtitle'	=> __( 'Your custom text for the social sharing heading. For mobile and horizontal social sharing.', 'wpex' ),
						'default'	=> __( 'Please Share This', 'wpex' ),
					),

					array(
						'id'		=> 'social_share_style',
						'type'		=> 'button_set',
						'title'		=> __( 'Social Sharing Style', 'wpex' ),
						'desc'		=> '',
						'options'	=> array(
							'minimal'	=> __( 'Minimal','wpex' ),
							'flat'		=> __( 'Flat','wpex' ),
							'three-d'	=> __( '3D','wpex' ),
						),
						'default'	=> 'minimal'
					),

					array(
						'id'		=> 'social_share_blog_posts',
						'type'		=> 'switch', 
						'title'		=> __( 'Blog Posts: Social Share', 'wpex' ),
						'subtitle'	=> __( 'Toggle the social sharing for this section of your site on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'social_share_blog_entries',
						'type'		=> 'switch', 
						'title'		=> __( 'Blog Entries: Social Share', 'wpex' ),
						'subtitle'	=> __( 'Toggle the social sharing icons on your blog entries on or off. Note: They will only display on the Large Image style blog entries and for the vertical social position.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
						'required'	=> array( 'social_share_position', 'equals', 'vertical' ),
					),

					array(
						'id'		=> 'social_share_pages',
						'type'		=> 'switch', 
						'title'		=> __( 'Pages: Social Share', 'wpex' ),
						'subtitle'	=> __( 'Toggle the social sharing for this section of your site on or off.', 'wpex' ),
						"default"	=> '0',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'social_share_portfolio',
						'type'		=> 'switch', 
						'title'		=> __( 'Portfolio: Social Share', 'wpex' ),
						'subtitle'	=> __( 'Toggle the social sharing for this section of your site on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'social_share_staff',
						'type'		=> 'switch', 
						'title'		=> __( 'Staff: Social Share', 'wpex' ),
						'subtitle'	=> __( 'Toggle the social sharing for this section of your site on or off.', 'wpex' ),
						"default"	=> '',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'social_share_woo',
						'type'		=> 'switch', 
						'title'		=> __( 'WooCommerce: Social Share', 'wpex' ),
						'subtitle'	=> __( 'Toggle the social sharing for this section of your site on or off.', 'wpex' ),
						"default"	=> '0',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'social_share_sites',
						'type'		=> 'checkbox',
						'title'		=> __( 'Social Sharing Links', 'wpex' ), 
						'subtitle'	=> __( 'Select the social sharing links to include in the social sharing function.', 'wpex' ),
						'options'	=> $social_sharing_sites,
						'default'	=> array(
							'twitter'		=> '1',
							'facebook'		=> '1',
							'google_plus'	=> '1',
							'pinterest'		=> '1',
							'linkedin'		=> false,
						)
					),

				),
			);


			/**
				Lightbox
			**/
			$sections['lightbox'] = array(
				'id'			=> 'lightbox',
				'icon'			=> 'el-icon-zoom-in',
				'title'			=> __( 'Lightbox', 'wpex' ),
				'submenu'		=> true,
				'fields'		=> array(
					array(
						'id'		=> 'lightbox_skin',
						'type'		=> 'select', 
						'tiles'		=> false,
						'title'		=> __( 'Lightbox Skin', 'wpex' ),
						'subtitle'	=> __( 'Select your lightbox skin.', 'wpex' ),
						'default'	=> 'dark',
						'options'	=> array(
							'dark'			=> __( 'Dark', 'wpex' ),
							'light'			=> __( 'Light', 'wpex' ),
							'mac'			=> __( 'Mac', 'wpex' ),
							'metro-black'	=> __( 'Metro Black', 'wpex' ),
							'metro-white'	=> __( 'Metro White', 'wpex' ),
							'parade'		=> __( 'Parade', 'wpex' ),
							'smooth'		=> __( 'Smooth', 'wpex' ),
						),
					),
					array(
						'id'		=> 'lightbox_thumbnails',
						'type'		=> 'switch', 
						'title'		=> __( 'Lightbox Gallery Thumbnails', 'wpex' ),
						'subtitle'	=> __( 'Toggle the lightbox gallery thumbnails on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),
					array(
						'id'		=> 'lightbox_arrows',
						'type'		=> 'switch', 
						'title'		=> __( 'Lightbox Gallery Arrows', 'wpex' ),
						'subtitle'	=> __( 'Toggle the lightbox gallery arrows on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),
					array(
						'id'		=> 'lightbox_mousewheel',
						'type'		=> 'switch', 
						'title'		=> __( 'Lightbox Mousewheel', 'wpex' ),
						'subtitle'	=> __( 'Toggle the lightbox mousewheel movement on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),
					array(
						'id'		=> 'lightbox_titles',
						'type'		=> 'switch', 
						'title'		=> __( 'Lightbox Titles', 'wpex' ),
						'subtitle'	=> __( 'Toggle the lightbox image titles on or off. Based on the image alt value.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),
					array(
						'id'		=> 'lightbox_fullscreen',
						'type'		=> 'switch', 
						'title'		=> __( 'Lightbox Fullscreen Button', 'wpex' ),
						'subtitle'	=> __( 'Toggle the lightbox fullscreen button on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),
				),
			);


			/**
				SEO
			**/
			$sections['seo'] = array(
				'id'			=> 'seo',
				'icon'			=> 'el-icon-search',
				'icon_class'	=> 'el-icon-large',
				'title'			=> __( 'SEO', 'wpex' ),
				'submenu'		=> true,
				'customizer'	=> false,
				'fields'		=> array(

					array(
						'id'		=> 'sidebar_headings',
						'type'		=> 'select',
						'title'		=> __( 'Sidebar Widget Title Headings', 'wpex' ), 
						'subtitle'	=> __( 'Select your preferred heading type.', 'wpex' ),
						'desc'		=> '',
						'options'	=> array(
							'h2'	=> 'h2',
							'h3'	=> 'h3',
							'h4'	=> 'h4',
							'h5'	=> 'h5',
							'h6'	=> 'h6',
							'span'	=> 'span',
							'div'	=> 'div',
						),
						'default'	=> 'div'
					),

					array(
						'id'		=> 'footer_headings',
						'type'		=> 'select',
						'title'		=> __( 'Footer Widget Title Headings', 'wpex' ), 
						'subtitle'	=> __( 'Select your preferred heading type.', 'wpex' ),
						'options'	=> array(
							'h2'	=> 'h2',
							'h3'	=> 'h3',
							'h4'	=> 'h4',
							'h5'	=> 'h5',
							'h6'	=> 'h6',
							'span'	=> 'span',
							'div'	=> 'div',
						),
						'default'	=> 'div'
					),

					array(
						'id'		=> 'breadcrumbs',
						'type'		=> 'switch', 
						'title'		=> __( 'Breadcrumbs', 'wpex' ),
						'subtitle'	=> __( 'Toggle the site breadcrumbs on or off', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'				=> 'breadcrumbs_position',
						'type'				=> 'button_set', 
						'title'				=> __( 'Breadcrumbs: Position', 'wpex' ),
						'subtitle'			=> __( 'Select your preferred breadcrumbs style.', 'wpex' ),
						'options'			=> array(
							'default'		=> __( 'Absolute Right', 'wpex' ),
							'under-title'	=> __( 'Under Title', 'wpex' ),
						),
						'default'	=> 'default',
						'required'	=> array('breadcrumbs','equals','1'),
					),

					array(
						'id'		=> 'breadcrumbs_home_title',
						'type'		=> 'text', 
						'title'		=> __( 'Breadcrumbs: Custom Home Title', 'wpex' ),
						'subtitle'	=> __( 'Enter your custom breadcrumbs home title. You can enter HTML if you want to display an icon instead (just like adding icons to your menu using FontAwesome).', 'wpex' ),
						"default"	=> '',
						'required'	=> array( 'breadcrumbs', 'equals', '1' ),
					),

					array(
						'id'		=> 'breadcrumbs_title_trim',
						'type'		=> 'text', 
						'title'		=> __( 'Breadcrumbs: Title Trim Length', 'wpex' ),
						'subtitle'	=> __( 'Enter the max number of words to display for your breadcrumbs post title.', 'wpex' ),
						"default"	=> '4',
						'required'	=> array('breadcrumbs','equals','1'),
					),

					array(
						'id'		=> 'remove_posttype_slugs',
						'type'		=> 'switch',
						'title'		=> __( 'Remove Custom Post Type Slugs (Experimental)', 'wpex' ),
						'subtitle'	=> __( 'Toggle the slug on/off for your custom post types (portfolio, staff, testimonials). Custom Post Types in WordPress by default should have a slug to prevent conflicts, you can use this setting to disable them, but be careful.', 'wpex' ),
						'default'	=> '',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

				),
			);


			/**
				Other
			**/
			$sections['other'] = array(
				'id'			=> 'other',
				'icon'			=> 'el-icon-wrench',
				'icon_class'	=> 'el-icon-large',
				'title'			=> __( 'Other', 'wpex' ),
				'submenu'		=> true,
				'customizer'	=> false,
				'fields'		=> array(

					array(
						'id'		=> 'page_single_layout',
						'type'		=> 'button_set',
						'title'		=> __( 'Page Layout', 'wpex' ),
						'subtitle'	=> __( 'Select your preferred layout for your pages. This setting can be overwritten on a per page basis via the meta options.', 'wpex' ),
						'desc'		=> '',
						'options'	=> array(
							'right-sidebar'	=> __( 'Right Sidebar','wpex' ),
							'left-sidebar'	=> __( 'Left Sidebar','wpex' ),
							'full-width'	=> __( 'Full Width','wpex' )
						),
						'default'	=> 'right-sidebar',
					),

					array(
						'id'		=> 'pages_custom_sidebar',
						'type'		=> 'switch', 
						'title'		=> __( 'Custom Pages Sidebar', 'wpex' ),
						'subtitle'	=> __( 'Toggle this custom sidebar area on or off. If disabled it will display the "Main" sidebar as a fallback.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'search_custom_sidebar',
						'type'		=> 'switch', 
						'title'		=> __( 'Custom Search Results Sidebar', 'wpex' ),
						'subtitle'	=> __( 'Toggle this custom sidebar area on or off. If disabled it will display the "Main" sidebar as a fallback.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'shortcodes_tinymce',
						'type'		=> 'switch', 
						'title'		=> __( 'Shortcodes TinyMCE Button', 'wpex' ),
						'subtitle'	=> __( 'Toggle the built-in TinyMCE Shortcodes button that contains some useful shortcodes.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'custom_wp_gallery',
						'type'		=> 'switch', 
						'title'		=> __( 'Custom WordPress Gallery Output', 'wpex' ),
						'subtitle'	=> __( 'Toggle the built-in custom WordPress gallery output on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'blog_dash_thumbs',
						'type'		=> 'switch', 
						'title'		=> __( 'Dashboard Featured Images', 'wpex' ),
						'subtitle'	=> __( 'Toggle the display of featured images in your WP dashboard on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'page_comments',
						'type'		=> 'switch', 
						'title'		=> __( 'Comments on Pages', 'wpex' ),
						'subtitle'	=> __( 'Toggle the display of comments in pages on or off.', 'wpex' ),
						"default"	=> '0',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'widget_icons',
						'type'		=> 'switch', 
						'title'		=> __( 'Widget Icons', 'wpex' ),
						'subtitle'	=> __( 'Certain widgets include little icons such as the recent posts widget. Here you can toggle the icons on or off.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'page_featured_image',
						'type'		=> 'switch', 
						'title'		=> __( 'Automatically Display Featured Images For Pages', 'wpex' ),
						'subtitle'	=> __( 'Set to "on" if you want the featured images for pages to display automatically at the top of the page.', 'wpex' ),
						"default"	=> '0',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'search_posts_per_page',
						'type'		=> 'text', 
						'title'		=> __( 'Search Posts Per Page', 'wpex' ),
						'subtitle'	=> __( 'How many posts do you wish to display on your search page before pagination?', 'wpex' ),
						"default"	=> '10',
					),

					array(
						'id'		=> 'posts_meta_options',
						'type'		=> 'checkbox',
						'title'		=> __( 'Meta Options', 'wpex' ), 
						'subtitle'	=> __( 'Select the items to include in the post meta.', 'wpex' ),
						'options'	=> array(
							'date'		=> 'Date',
							'category'	=> 'Category',
							'comments'	=> 'Comments',
							'author'	=> 'Author',
						),
						'default'	=> array(
							'date'		=> '1',
							'category'	=> '1',
							'comments'	=> '1',
							'author'	=> false,
						),
					),

				),
			);


			/**
				Optimizations
			**/
			$sections['optimizations'] = array(
				'id'			=> 'optimizations',
				'icon'			=> 'el-icon-tasks',
				'icon_class'	=> 'el-icon-large',
				'title'			=> __( 'Optimizations', 'wpex' ),
				'submenu'		=> true,
				'fields'		=> array(

					array(
						'id'		=> 'minify_js',
						'type'		=> 'switch', 
						'title'		=> __( 'Minify JS', 'wpex' ),
						'subtitle'	=> __( 'This theme makes use of a lot of js scripts, use this function to load a single minified file with all the required code. Disable for testing purposes.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'minify_css',
						'type'		=> 'switch', 
						'title'		=> __( 'Minify CSS', 'wpex' ),
						'subtitle'	=> __( 'By default the theme loads a style.css that is not minified along with a responsive.css file (if responsive is enabled) and a WooCommerce.css file (if WooCommerce is enabled). If you wish you can enable this setting to instead load a single style-min.css file with all the code minified. If you are using a child theme REMOVE the @import line for style.css because if you keep it your site will load double the CSS, eww!', 'wpex' ),
						"default"	=> '0',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'remove_scripts_version',
						'type'		=> 'switch', 
						'title'		=> __( 'Remove Version Parameter From JS & CSS Files', 'wpex' ),
						'subtitle'	=> __( 'Most scripts and style-sheets called by WordPress include a query string identifying the version. This can cause issues with caching and such, which will result in less than optimal load times. You can toggle this setting on to remove the query string from such strings.', 'wpex' ),
						"default"	=> '1',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'jpeg_100',
						'type'		=> 'switch', 
						'title'		=> __( 'JPEG 100% Quality', 'wpex' ),
						'subtitle'	=> __( 'By default images cropped with WordPress are resized/cropped at 90% quality. Enable this setting to set all JPEGs to 100% quality.', 'wpex' ),
						"default"	=> '0',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'remove_jetpack_devicepx',
						'type'		=> 'switch', 
						'title'		=> __( 'Remove Jetpack devicepx script', 'wpex' ),
						'subtitle'	=> __( 'Toggle the jetpack devicepx script on/off. The file is used to optionally load retina/HiDPI versions of files (Gravatars etc) which are known to support it, for devices that run at a higher resolution. But can be disabled to prevent the extra js call.', 'wpex' ),
						"default"	=> '0',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'cleanup_wp_head',
						'type'		=> 'checkbox',
						'title'		=> __( 'Cleanup WP Head', 'wpex' ),
						'subtitle'	=> __( 'Select the items to REMOVE from the wp_head hook to clean things up.', 'wpex' ),
						'options'	=> array(
							'feed_links'						=> 'General Feed Links',
							'feed_links_extra'					=> 'Extra Feed Links',
							'rsd_link'							=> 'EditURI/RSD link',
							'wlwmanifest_link'					=> 'Windows Live Writer Manifest',
							'index_rel_link'					=> 'Index Link',
							'parent_post_rel_link'				=> 'Parent Post Rel',
							'start_post_rel_link'				=> 'Start Post Rel',
							'adjacent_posts_rel_link_wp_head'	=> 'Adjecent Posts Rel',
							'wp_generator'						=> 'WordPress Generator (WP Version)',
						),
						'default'	=> array(
							'feed_links_extra'					=> '1',
							'feed_links'						=> '1',
							'rsd_link'							=> '1',
							'wlwmanifest_link'					=> '1',
							'index_rel_link'					=> '1',
							'parent_post_rel_link'				=> '1',
							'start_post_rel_link'				=> '1',
							'adjacent_posts_rel_link_wp_head'	=> '1',
							'wp_generator'						=> '1',
						),
					),

				),
			);


			/**
				Custom CSS
			**/
			$sections['custom_css'] = array(
				'id'			=> 'custom_css',
				'icon'			=> 'el-icon-css',
				'icon_class'	=> 'el-icon-large',
				'title'			=> __( 'Custom CSS', 'wpex' ),
				'submenu'		=> true,
				'fields'		=> array(

					array(
						'id'		=> 'custom_css',
						'type'		=> 'ace_editor',
						'mode'		=> 'css',
						'theme'		=> 'chrome',
						'title'		=> __( 'Design Edits', 'wpex' ),
						'subtitle'	=> __( 'Quickly add some CSS to your theme to make design adjustments by adding it to this block. It is a much better solution then manually editing style.css', 'wpex' ),
						'default'	=> '',
					),
				),
			);


			/**
				Auto Updates
			**/
			$wpex_docs_img_url = get_template_directory_uri() . '/images/docs/';
			$sections['updates'] = array(
				'id'			=> 'updates',
				'icon_class'	=> 'el-icon-large',
				'icon'			=> 'el-icon-retweet',
				'title'			=> __( 'Theme Updates', 'wpex' ),
				'submenu'		=> true,
				'customizer'	=> false,
				'fields'		=> array(

					array(
						'id'		=> 'enable_auto_updates',
						'type'		=> 'switch', 
						'title'		=> __( 'Enable Auto Updates', 'wpex' ),
						'subtitle'	=> __( 'You can toggle the automatic updates for your theme on or off.', 'wpex' ),
						"default"	=> '0',
						'on'		=> __( 'On', 'wpex' ),
						'off'		=> __( 'Off', 'wpex' ),
					),

					array(
						'id'		=> 'envato_license_key',
						'type'		=> 'text',
						'title'		=> __( 'Item Purchase Code', 'wpex' ),
						'subtitle'	=> __( 'Enter your Envato license key here if you wish to receive auto updates for your theme.', 'wpex' ) .'<br /><br /><img src="'. $wpex_docs_img_url .'envato-license-key.gif" />',
						'required'	=> array('enable_auto_updates','equals','1'),
					),
				),
			);

			/**
				Import/Export
			**/
			$sections['import_export'] = array(
				'id'		=> 'import_export',
				'title'		=> __( 'Import / Export', 'wpex' ),
				'icon'		=> 'el-icon-refresh',
				'fields'	=> array(

					array(
						'id'			=> 'opt-import-export',
						'type'			=> 'import_export',
						'title'			=> 'Import Export',
						'subtitle'		=> 'Save and restore your Redux options',
						'full_width'	=> false,
					),
				),
			);

			$this->sections = apply_filters( 'wpex_redux_sections', $sections );

		} // End setSections

		public function setArguments() {

			global $wp_version;
			$wpex_redux_heading_dashicon = $wp_version >= 3.8 ? '<span class="dashicons dashicons-admin-generic"></span>' : '';

			$args = array(
				// TYPICAL -> Change these values as you need/desire
				'opt_name'			=> 'wpex_options', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'		=> $wpex_redux_heading_dashicon . __( 'Theme Options Panel','wpex' ), // Name that appears at the top of your panel
				'display_version'	=> '', // Version that appears at the top of your panel
				'menu_type'			=> 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'	=> true, // Show the sections below the admin menu item or not
				'menu_title'		=> __( 'Theme Options', 'wpex' ),
				'page'				=> __( 'Theme Options', 'wpex' ),
				'google_api_key'	=> 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssIIƒ', // Must be defined to add google fonts to the typography module
				'global_variable'	=> '', // Set a different name for your global variable other than the opt_name
				'dev_mode'			=> false, // Show the time the page took to load, etc
				'customizer'		=> true, // Enable basic customizer support,
				'async_typography'	=> false, // Enable async for fonts,
				'disable_save_warn'	=> true,
				// OPTIONAL -> Give you extra features
				'page_priority'		=> null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
				'page_parent'		=> 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
				'page_permissions'	=> 'manage_options', // Permissions needed to access the options panel.
				'menu_icon'			=> '', // Specify a custom URL to an icon
				'last_tab'			=> '', // Force your panel to always open to a specific tab (by id)
				'page_icon'			=> 'icon-themes', // Icon displayed in the admin panel next to your menu_title
				'page_slug'			=> 'wpex_options', // Page slug used to denote the panel
				'save_defaults'		=> true, // On load save the defaults to DB before user clicks save or not
				'default_show'		=> false, // If true, shows the default value next to each field that is not the default value.
				'default_mark'		=> '', // What to print by the field's title if the value shown is default. Suggested: *
				'admin_bar'			=> true,
				// CAREFUL -> These options are for advanced use only
				'output'				=> false, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
				'output_tag'			=> false, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
				//'domain'				=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
				'footer_credit'			=> '', // Disable the footer credit of Redux. Please leave if you can help it.
				'footer_text'			=> "",
				'show_import_export'	=> false,
				'system_info'			=> false,
			);

			$this->args = apply_filters( 'wpex_redux_args', $args );

		} // End setArguments

	} // End WPEX_Redux_Main_Theme_Options class

}

// Start our class
$wpex_redux_framework_class = new WPEX_Redux_Main_Theme_Options();
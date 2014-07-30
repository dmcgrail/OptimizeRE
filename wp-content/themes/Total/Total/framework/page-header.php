<?php
/**
 * Function used to display the page subheading
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/

/**
	The Title To display
**/
if ( ! function_exists('wpex_page_title') ) {
	function wpex_page_title( $title = '' ) {
		
		// Get post
		global $post;
		
		// Homepage - display blog description if not a static page
		if ( is_front_page() && !is_singular('page') ) {
			
			if ( get_bloginfo( 'description' ) ) {
				$title = get_bloginfo( 'description' );
			} else {
				return __( 'Recent Posts', 'wpex' );
			}

		// Homepage posts page
		} elseif ( is_home() && !is_singular('page') ) {

			$title = get_the_title( get_option('page_for_posts', true) );
			
		// Archives
		} elseif ( is_archive() ) {
			
			// Daily archive title
			if ( is_day() ) {
				$title = sprintf( __( 'Daily Archives: %s', 'wpex' ), get_the_date() );
			
			// Monthly archive title
			} elseif ( is_month() ) {
				$title = sprintf( __( 'Monthly Archives: %s', 'wpex' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'wpex' ) ) );
				
			// Yearly archive title
			} elseif ( is_year() ) {
				$title = sprintf( __( 'Yearly Archives: %s', 'wpex' ), get_the_date( _x( 'Y', 'yearly archives date format', 'wpex' ) ) );

			// Post Type archive title
			} elseif ( is_post_type_archive() ) {

				if ( is_post_type_archive( 'product' ) ) {
					if ( class_exists( 'Woocommerce' ) && function_exists( 'wc_get_page_id' ) ) {
						$title = get_the_title( wc_get_page_id( 'shop' ) );
					} else {
						$title = __( 'Shop', 'wpex' );
					}
				} else {
					$title = post_type_archive_title('', false);
				}
			
			// Standard term title
			} else {
				$title = single_term_title( "", false );
				
				// Fix for bbPress and other plugins that are archives but use
				// Standard templates...zzz
				if ( $title == '' ) {
					$post_id = $post->ID;
					$title = get_the_title($post_id);
				}
			}
			
		// Search
		} elseif( is_search() ) {

			global $wp_query;
			
			$title = '<span id="search-results-count">'. $wp_query->found_posts .'</span> '. __( 'Search Results Found', 'wpex' );
			
		// 404 Page
		} elseif ( is_404() ) {
			
			$title = wpex_option( 'error_page_title', __( '404: Page Not Found', 'wpex') );
		
		// All else
		} elseif ( $post ) {
			$post_id = $post->ID;
			// Singular products
			if ( is_singular( 'product' ) ) {
				$title = wpex_option( 'woo_shop_single_title', __( 'Store', 'wpex' ) );

			// Single posts
			} elseif( is_singular( 'post' ) ) {

				// Display custom text for blog post header
				if ( 'custom_text' == wpex_option( 'blog_single_header', 'custom_text' ) ) {
					$title = wpex_option( 'blog_single_header_custom_text', __( 'Blog', 'wpex' ) );
				}
				// Display post title for single posts
				else {
					$title = get_the_title( $post_id );
				}

			}

			// All other
			else {
				$title = get_the_title($post_id);
			}
		}

		// Tribe Events Calendar Plugin title
		if ( function_exists( 'tribe_is_month' ) ) {
			if( tribe_is_month() ) {
				$title = __( 'Events Calendar', 'wpex' );
			} elseif ( function_exists( 'tribe_is_event' ) && function_exists( 'tribe_is_day' ) && tribe_is_event() && !tribe_is_day() && !is_single() ) {
				$title = __( 'Events List', 'wpex' );
			} elseif ( function_exists( 'tribe_is_event' ) && function_exists( 'tribe_is_day' ) && tribe_is_event() && !tribe_is_day() && is_single() ) {
				$title = __( 'Single Event', 'wpex' );
			} elseif ( function_exists( 'tribe_is_day' ) && tribe_is_day() ) {
				$title = __( 'Single Day', 'wpex' );
			}
		}

		// Backup
		$title = $title ? $title : get_the_title();

		// Return title and apply filters
		return apply_filters( 'wpex_title', $title );
		
	}
}


/**
	Page Subheading
**/
if ( ! function_exists('wpex_post_subheading') ) {
	function wpex_post_subheading() {
		
		// Vars
		global $post;
		$output='';
		
		// Posts & Pages
		if ( is_singular () ) {
			$post_id = $post->ID;
			$subheading = get_post_meta( $post_id, 'wpex_post_subheading', true );
			$subheading = apply_filters( 'wpex_post_subheading', $subheading );
			$output = '';
			if ( $subheading ) {
				$output .= '<div class="clr page-subheading">';
					$output .= do_shortcode( $subheading );
				$output .= '</div>';
			}
		}
		
		// Archives
		if ( is_tax() ) {
			$obj = get_queried_object();
			$taxonomy = $obj->taxonomy;
			$term_id = $obj->term_id;
			$description = term_description($term_id,$taxonomy);
			if ( ! empty( $description ) ){
				$output .= '<div class="clr page-subheading term-description">';
					$output .= $description;
				$output .= '</div>';
			}
		}
		
		// Return content
		return $output;
		
	}
}


/**
	Render Page Header
**/
if ( ! function_exists('wpex_page_header') ) {
	function wpex_page_header( $before='', $after='', $breadcrumbs = true ) {

		// If title is empty return false
		if ( ! wpex_page_title() ) {
			return;
		}
		
		// Not used for author archives
		if ( is_author() ) {
			return;
		}

		// Disable on store
		if ( is_post_type_archive( 'product' ) && !wpex_option( 'woo_shop_title' ) ) {
			return;
		} elseif ( class_exists( 'Woocommerce' ) && function_exists( 'wc_get_page_id' ) ) {
			$shop_id = wc_get_page_id( 'shop' );
			if ( is_post_type_archive( 'product' ) && isset($shop_id) ) {
				$disable_title = get_post_meta( $shop_id, 'wpex_disable_title', true );
			}
		}
		
		// Vars
		global $post;
		$output=$classes=$height=$style=$title_bg=$title_style='';
		$disable_title = isset($disable_title) ? $disable_title : '';
		if ( $post ) {
			$title_style = get_post_meta( $post->ID, 'wpex_post_title_style', true );
		}
		$heading = apply_filters( 'wpex_page_header_heading','h1');
		if ( $post && is_singular() ) {
			$post_id = $post->ID;
			$disable_title = get_post_meta( get_the_ID(), 'wpex_disable_title', true );
			$title = get_the_title();
		}
		$page_title = wpex_page_title();
				
		// If page header is disabled do nothing
		if ( 'on' == $disable_title && 'background-image' != $title_style ) {
			return false;
		}
		
		// Page meta options
		if ( is_singular ( 'page' ) || is_singular ( 'portfolio' ) || is_singular ( 'staff' ) || is_singular ( 'post' ) ) {
			
			// Get title style
			if ( empty( $title_style ) ) {
				$title_style = wpex_option( 'page_header_style' );
			}
			
			// Background image style
			if ( $title_style == 'background-image' ) {
				
				// Title background image
				$title_bg = get_post_meta( $post_id, 'wpex_post_title_background_redux', true );
				if ( is_array($title_bg) && !empty( $title_bg['url'] ) ) {
					$title_bg = $title_bg['url'];
				} else {
					$title_bg = get_post_meta( $post_id, 'wpex_post_title_background', true );
				}
				// Title overlay
				$title_bg_overlay = get_post_meta( $post_id, 'wpex_post_title_background_overlay', true );
				// Set title height
				$title_height = get_post_meta( $post_id, 'wpex_post_title_height', true );
				$title_height = $title_height ? $title_height : '400';
				$title_height = intval($title_height) .'px'; // set height in pixels
			}
			
			
			// Solid Color Title Style
			if ( $title_style == 'solid-color' || $title_style == 'background-image' ) {
				
				// Get meta color option
				$title_bg_color = get_post_meta( $post_id, 'wpex_post_title_background_color', true );
				
				// Set background color in header style
				if ( $title_bg_color ) {
					$style .='background-color: '. $title_bg_color .';';
				}
				
			}
			
			// Custom Classes
			if ( $title_style !== 'default' && $title_style ) { 
				$classes .= $title_style .'-page-header';
			}
			
			// Header Background Image
			if ( $title_bg ) {
				$style .= ' background: url('. $title_bg .') 50% 0;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;height: '.$title_height.';';
			}
			
			// Disable breadcrumbs if background image set
			if ( $title_style == 'background-image' || $title_style == 'centered' || $title_style == 'centered-minimal' ) {
				$breadcrumbs = false;
			}
		
		} ?>
		
		<?php echo $before; ?>
			<header class="page-header <?php echo $classes; ?>" style="<?php echo $style; ?>">
				<?php
				if ( 'on' != $disable_title ) { ?>
				<div class="container clr page-header-inner">
					<?php
					//  Main header
					echo '<'. $heading .' class="page-header-title">'. $page_title .'</'. $heading .'>'; 
					
					// Function used to display the subheading defined in the meta options
					// See previous function
					echo wpex_post_subheading();
					
					// Display built-in breadcrumbs - see functions/breadcrumbs.php
					if ( ! is_front_page() && $breadcrumbs ) wpex_display_breadcrumbs(); ?>
				</div><!-- .page-header-inner -->
				<?php } ?>
				<?php
				// Header background overlay
				if ( $title_bg && 'none' != $title_bg_overlay ) {
					$opacity = get_post_meta( $post_id, 'wpex_post_title_background_overlay_opacity', true );
					if ( $opacity ) {
						$opacity = 'style="opacity:'. $opacity .'"';
					} ?>
					<span class="background-image-page-header-overlay style-<?php echo $title_bg_overlay; ?>" <?php echo $opacity; ?>></span>
				<?php } ?>
			</header><!-- .page-header -->
		<?php echo $after; ?>
		
	<?php
	}
}


/**
	Function to display the page header
**/
if ( ! function_exists( 'wpex_display_page_header' ) ) {
	function wpex_display_page_header( $return = true ) {
		$return = apply_filters( 'wpex_display_page_header', $return );
		if ( $return == true ) {
			return wpex_page_header();
		}
	}
}
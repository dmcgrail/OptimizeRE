<?php
/**
 * Used for your site wide breadcrumbs
 * Support for Yoast SEO Breadcrumbs
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/


/**
 * Returns correct breadcrumbs function
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.52
*/
if ( !function_exists( 'wpex_breadcrumbs_enabled' ) ) {
	function wpex_breadcrumbs_enabled() {
		// Check if enabled by core function
		if ( function_exists( 'wpex_supports' ) && !wpex_supports( 'primary', 'breadcrumbs' ) ) {
			return;
		}
		// Check if disabled by theme options
		if ( !wpex_option( 'breadcrumbs', '1' ) ) {
			return;
		}
		// Check if disabled by meta options
		if ( is_singular() ) {
			global $post;
			$post_id = $post->ID;
			if ( $post_id ) {
				if ( 'on' == get_post_meta($post_id, 'wpex_disable_breadcrumbs', true ) ) {
					return;
				}
			}
		}
		// Return true
		return true;
	}
}


/**
 * Returns correct breadcrumbs function
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( !function_exists( 'wpex_display_breadcrumbs' ) ) {
	function wpex_display_breadcrumbs() {

		// Check if breadcrumbs are disabled
		if ( ! wpex_breadcrumbs_enabled() ) {
			return;
		}
		
		// Yoast breadcrumbs
		$yoast_options = get_option( 'wpseo_internallinks' );
		if( function_exists('yoast_breadcrumb') && $yoast_options['breadcrumbs-enable'] === true ) {
			return yoast_breadcrumb('<nav class="site-breadcrumbs clr">','</nav>');
		
		// Built-in breadcrumbs
		} else {
			echo wpex_breadcrumbs();
		}
		
	}
}

/**
 * Breadcrumbs class
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( !function_exists( 'wpex_breadcrumbs' ) ) {
	function wpex_breadcrumbs( $args = array() ) {
		
		global $wp_query, $wp_rewrite;
		
		// WooCommerce Shop Page
		if ( class_exists( 'Woocommerce' ) && function_exists( 'wc_get_page_id' ) ) {
			$shop_id = wc_get_page_id( 'shop' );
			$shop_page_url = get_permalink( $shop_id );
			$shop_title = get_the_title( $shop_id );
			$shop_title = apply_filters( 'wpex_bcrums_shop_title', $shop_title );
		} else {
			$shop_id = $shop_page_url = $shop_title = '';
		}

		// Get Blog Page URL
		$blog_page = wpex_option( 'blog_page' );
		if ( $blog_page ) {
			$blog_url = get_permalink( $blog_page );
			$blog_name = get_the_title( $blog_page );
		} else {
			$blog_url = wpex_option( 'blog_url' );
			$blog_name = apply_filters( 'wpex_blog_name', __( 'Blog', 'wpex' ) );
		}

		// Get Portfolio Page URL
		$portfolio_page = wpex_option( 'portfolio_page' );
		if ( $portfolio_page ) {
			$portfolio_url = get_permalink( $portfolio_page );
			$portfolio_name = get_the_title( $portfolio_page );
		} else {
			$portfolio_url = wpex_option( 'portfolio_url' );
			$portfolio_name = wpex_option( 'portfolio_labels', __( 'Portfolio', 'wpex' ) );
		}

		// Staf Page URL
		$staff_page = wpex_option( 'staff_page' );
		if ( $staff_page ) {
			$staff_url = get_permalink( $staff_page );
			$staff_name = get_the_title( $staff_page );
		} else {
			$staff_url = wpex_option( 'staff_url' );
			$staff_name = wpex_option( 'staff_labels', __( 'Staff', 'wpex' ) );
		}

		// Testimonials Page URL
		$testimonials_page = wpex_option( 'testimonials_page' );
		if ( $testimonials_page ) {
			$testimonials_url = get_permalink( $testimonials_page );
			$testimonials_name = get_the_title( $testimonials_page );
		} else {
			$testimonials_url = wpex_option( 'testimonials_url' );
			$testimonials_name = wpex_option( 'testimonials_labels', __( 'Tesimonials', 'wpex' ) );
		}

		// Google microdata
		$item_type_scope = 'itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"';

		/* Create an empty variable for the breadcrumb. */
		$breadcrumb = '';

		/* Create an empty array for the trail. */
		$trail = array();
		$path = '';

		/* Set up the default arguments for the breadcrumb. */
		$defaults = array(
			'separator'			=> '<span class="fa fa-angle-right"></span>',
			'before'			=> '',
			'after'				=> false,
			'front_page'		=> true,
			'show_home'			=> true,
			'echo'				=> false, 
			'show_posts_page'	=> true
		);
		$defaults = apply_filters( 'wpex_breadcrumbs_defaults', $defaults );

		/* Apply filters to the arguments. */
		$args = apply_filters( 'wpex_breadcrumbs_args', $args );

		/* Parse the arguments and extract them for easy variable naming. */
		extract( wp_parse_args( $args, $defaults ) );

		/* If $show_home is set and we're not on the front page of the site, link to the home page. */
		if ( !is_front_page() && $show_home )
			$trail[] = '<span '. $item_type_scope .'>
							<a href="' . home_url() . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home" class="trail-begin">
								<span itemprop="title">' . wpex_option( 'breadcrumbs_home_title', __( 'Home', 'wpex' ) ) . '</span>
							</a>
						</span>';

		/* If viewing the front page of the site. */
		if ( is_front_page() ) {
			if ( !$front_page ) {
				$trail = false;
			} elseif ( $show_home ) {
				$trail['trail_end'] = "{$show_home}";
			}
		}

		/* If viewing the "home"/posts page. */
		elseif ( is_home() ) {
			$home_page = get_page( $wp_query->get_queried_object_id() );
			$trail = array_merge( $trail, wpex_breadcrumbs_get_parents( $home_page->post_parent, '' ) );
			$trail['trail_end'] = get_the_title( $home_page->ID );
		}

		/* If viewing a singular post (page, attachment, etc.). */
		elseif ( is_singular() ) {
			
			/* Get singular post variables needed. */
			$post = $wp_query->get_queried_object();
			$post_id = absint( $wp_query->get_queried_object_id() );
			$post_type = $post->post_type;
			$parent = $post->post_parent;
			
			/* If a custom post type, check if there are any pages in its hierarchy based on the slug. */
			if ( 'page' != $post_type && 'post' != $post_type && 'product' != $post_type ) {

				$post_type_object = get_post_type_object( $post_type );
				
				/* If $front has been set, add it to the $path. */
				if ( 'post' == $post_type || 'attachment' == $post_type || ( $post_type_object->rewrite['with_front'] && $wp_rewrite->front ) ) {
					$path .= trailingslashit( $wp_rewrite->front );
				}

				/* If there's a slug, add it to the $path. */
				if ( !empty( $post_type_object->rewrite['slug'] ) ) {
					$path .= $post_type_object->rewrite['slug'];
				}

				/* If there's a path, check for parents. */
				if ( !empty( $path ) ) {
					$trail = array_merge( $trail, wpex_breadcrumbs_get_parents( '', $path ) );
				}

				/* If there's an archive page, add it to the trail. */
				if ( !empty( $post_type_object->has_archive ) && function_exists( 'get_post_type_archive_link' ) ) {
					if ( !is_singular( 'product' ) ) {
						$trail[] = '<span '. $item_type_scope .' class="trail-type-archive">
										<a href="' . get_post_type_archive_link( $post_type ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">
											<span itemprop="title">' . $post_type_object->labels->name . '</span>
										</a>
									</span>';
					}
				}
			}
			
			// Add shop page to cart
			if ( is_singular('page') && class_exists('Woocommerce') ) {
				if ( is_cart() || is_checkout() ) {
					$trail[] = '<span '. $item_type_scope .' class="trail-shop">
									<a href="'. $shop_page_url .'" title="'. $shop_title .'" itemprop="url">
										<span itemprop="title">'. $shop_title .'</span>
									</a>
								</span>';
				}
			}

			// Standard Posts
			if( 'post' == $post_type ) {
				// Main Blog URL
				if ( $blog_url ) {
					$trail[] = '<span '. $item_type_scope .' class="trail-blog-url">
									<a href="'. $blog_url .'" title="'. $blog_name .'" itemprop="url">
										<span itemprop="title">'. $blog_name .'</span>
									</a>
								</span>';
				}
				// 1st Category
				if ( wpex_option( 'breadcrumbs_blog_cat', '1' ) ) {
					$terms = get_the_terms( $post_id, 'category');
					if ( $terms ) {
						$term = reset($terms);
						$trail[] = '<span '. $item_type_scope .' class="trail-blog-cat">
										<a href="'. get_term_link($term) .'" itemprop="url" title="'. $term->name .'">
											<span itemprop="title">'. $term->name .'</span>
										</a>
									</span>';
					}
				}
			}

			// Tribe Events
			if( 'tribe_events' == $post_type && function_exists( 'tribe_get_events_link' ) ) {
				$trail[] = '<span '. $item_type_scope .' class="trail-portfolio-url">
								<a href="'. tribe_get_events_link() .'" title="'. __( 'All Events', 'wpex' ) .'">
									<span itemprop="title">'. __( 'All Events', 'wpex' ) .'</span>
								</a>
							</span>';
			}
			
			//  Main Portfolio
			if( $post_type == 'portfolio' ) {
				if ( $portfolio_url ) {
				$trail[] = '<span '. $item_type_scope .' class="trail-portfolio-url">
								<a href="'. $portfolio_url .'" title="'. $portfolio_name .'">
									<span itemprop="title">'. $portfolio_name .'</span>
								</a>
							</span>';
				}
				// 1st Category
				if ( wpex_option( 'breadcrumbs_portfolio_cat', '1' ) && taxonomy_exists( 'portfolio_category' ) ) {
					$terms = get_the_terms( $post_id, 'portfolio_category' );
					if ( $terms ) {
						$term = reset($terms);
						$trail[] = '<span '. $item_type_scope .' class="trail-portfolio-cat">
										<a href="'. get_term_link($term) .'" itemprop="url" title="'. $term->name .'">
											<span itemprop="title">'. $term->name .'</span>
										</a>
									</span>';
					}
				}
			}
			
			//  Main Staff
			if( $post_type == 'staff' ) {
				if ( $staff_url ) {
					$trail[] = '<span '. $item_type_scope .'>
									<a href="'. $staff_url .'" title="'. $staff_name .'">
										<span itemprop="title">'. $staff_name .'</span>
									</a>
								</span>';
				}
				// 1st Category
				if ( wpex_option( 'breadcrumbs_staff_cat', '1' ) && taxonomy_exists( 'staff_category' ) ) {
					$terms = get_the_terms( $post_id, 'staff_category');
					if ( $terms ) {
						$term = reset($terms);
						$trail[] = '<span '. $item_type_scope .'>
										<a href="'. get_term_link($term) .'" itemprop="url" title="'. $term->name .'">
											<span itemprop="title">'. $term->name .'</span>
										</a>
									</span>';
					}
				}
			}
			
			//  Main Testimonials
			if( $post_type == 'testimonials' ) {
				if ( $testimonials_url ) {
					$trail[] = '<span '. $item_type_scope .'>
									<a href="'. $testimonials_url .'" title="'. $testimonials_name .'">
										<span itemprop="title">'. $testimonials_name .'</span>
									</a>
								</span>';
				}
				// 1st Category
				if ( wpex_option( 'breadcrumbs_testimonials_cat', '1' ) && taxonomy_exists( 'testimonials_category' ) ) {
					$terms = get_the_terms( $post_id, 'testimonials_category');
					if ( $terms ) {
						$term = reset($terms);
						$trail[] = '<span '. $item_type_scope .'>
										<a href="'. get_term_link($term) .'" itemprop="url" title="'. $term->name .'">
											<span itemprop="title">'. $term->name .'</span>
										</a>
									</span>';
					}
				}
			}

			// Products
			if ( is_singular( 'product' ) && class_exists( 'Woocommerce' ) && isset( $shop_id ) ) {
				if ( $shop_id ) {
					$trail[] = '<span '. $item_type_scope .' class="trail-type-archive">
							<a href="' . get_permalink( $shop_id ) . '" title="' . esc_attr( get_the_title( $shop_id ) ) . '">
								<span itemprop="title">' . get_the_title( $shop_id ) . '</span>
							</a>
						</span>';
				}
			}

			/* If the post type path returns nothing and there is a parent, get its parents. */
			if ( empty( $path ) && 0 !== $parent || 'attachment' == $post_type ) {
				$trail = array_merge( $trail, wpex_breadcrumbs_get_parents( $parent, '' ) );
			}


			/* End with the post title. */
			$post_title = get_the_title( $post_id ); // Force the post_id to make sure we get the correct page title.
			if ( !empty( $post_title ) ) {
				$post_title_length = str_word_count($post_title);
				if ( wpex_option( 'breadcrumbs_title_trim' ) ) {
					$post_title = wp_trim_words($post_title, wpex_option( 'breadcrumbs_title_trim', '4' ) );
					$trail['trail_end'] = $post_title;
				} else {
					$trail['trail_end'] = $post_title;
				}
			}

		}

		/* If we're viewing any type of archive. */
		elseif ( is_archive() ) {
			
			// Topics
			if ( is_post_type_archive('topic') ) {
				$forums_link = get_post_type_archive_link('forum');
				$forum_obj = get_post_type_object( 'forum' );
				$forum_name = $forum_obj->labels->name;
				if ( $forums_link ) {
					$trail[] = '<a href="'. $forums_link .'" title="'. $forum_name .'">'. $forum_name .'</a>';
				}
			}

			/* If viewing a taxonomy term archive. */
			if ( is_tax() || is_category() || is_tag() ) {

				/* Get some taxonomy and term variables. */
				$term = $wp_query->get_queried_object();
				$taxonomy = get_taxonomy( $term->taxonomy );
				
				// Portfolio Tax
				if( is_tax('portfolio_category') && $portfolio_url ) {
					$trail[] = '<span '. $item_type_scope .' class="trail-portfolio-url">
								<a href="'. $portfolio_url .'" title="'. $portfolio_name .'">
									<span itemprop="title">'. $portfolio_name .'</span>
								</a>
							</span>';
				}
				
				if( is_tax('portfolio_tag') && $portfolio_url ) {
					$trail[] = '<span '. $item_type_scope .' class="trail-portfolio-url">
								<a href="'. $portfolio_url .'" title="'. $portfolio_name .'">
									<span itemprop="title">'. $portfolio_name .'</span>
								</a>
							</span>';
				}
				
				// Staff Tax
				if( is_tax('staff_category') && $staff_url ) {
					$trail[] = '<span '. $item_type_scope .'>
									<a href="'. $staff_url .'" title="'. $staff_name .'">
										<span itemprop="title">'. $staff_name .'</span>
									</a>
								</span>';
				}
				
				if( is_tax('staff_tag') && $staff_url ) {
					$trail[] = '<span '. $item_type_scope .'>
									<a href="'. $staff_url .'" title="'. $staff_name .'">
										<span itemprop="title">'. $staff_name .'</span>
									</a>
								</span>';
				}
				
				// Testimonials Tax
				if( is_tax('testimonials_category') && $testimonials_url ) {
					$trail[] = '<span '. $item_type_scope .'>
									<a href="'. $testimonials_url .'" title="'. $testimonials_name .'">
										<span itemprop="title">'. $testimonials_name .'</span>
									</a>
								</span>';
				}

				// Woo Product Tax
				if( $shop_page_url && $shop_title ) {
					if ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) {
						$trail[] = '<span '. $item_type_scope .' class="trail-shop">
									<a href="'. $shop_page_url .'" title="'. $shop_title .'" itemprop="url">
										<span itemprop="title">'. $shop_title .'</span>
									</a>
								</span>';
					}
				}

				if ( is_category() || is_tag() ) {
					if ( $blog_url ) {
					$trail[] = '<span '. $item_type_scope .' class="trail-blog-url">
									<a href="'. $blog_url .'" title="'. $blog_name .'" itemprop="url">
										<span itemprop="title">'. $blog_name .'</span>
									</a>
								</span>';
					}
				}

				/* Get the path to the term archive. Use this to determine if a page is present with it. */
				if ( is_category() ) {
					$path = get_option( 'category_base' );
				} elseif ( is_tag() ) {
					$path = get_option( 'tag_base' );
				} else {
					if ( $taxonomy->rewrite['with_front'] && $wp_rewrite->front ) {
						$path = trailingslashit( $wp_rewrite->front );
					}
					$path .= $taxonomy->rewrite['slug'];
				}

				/* Get parent pages by path if they exist. */
				if ( $path ) {
					$trail = array_merge( $trail, wpex_breadcrumbs_get_parents( '', $path ) );
				}

				/* If the taxonomy is hierarchical, list its parent terms. */
				if ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent ) {
					$trail = array_merge( $trail, wpex_breadcrumbs_get_term_parents( $term->parent, $term->taxonomy ) );
				}

				/* Add the term name to the trail end. */
				$trail['trail_end'] = $term->name;
			}

			/* If viewing a post type archive. */
			elseif ( function_exists( 'is_post_type_archive' ) && is_post_type_archive() ) {

				/* Get the post type object. */
				$post_type_object = get_post_type_object( get_query_var( 'post_type' ) );

				/* If $front has been set, add it to the $path. */
				if ( $post_type_object->rewrite['with_front'] && $wp_rewrite->front )
					$path .= trailingslashit( $wp_rewrite->front );

				/* If there's a slug, add it to the $path. */
				if ( !empty( $post_type_object->rewrite['archive'] ) )
					$path .= $post_type_object->rewrite['archive'];

				/* If there's a path, check for parents. */
				if ( !empty( $path ) )
					$trail = array_merge( $trail, wpex_breadcrumbs_get_parents( '', $path ) );

				/* Add the post type [plural] name to the trail end. */
				$trail['trail_end'] = $post_type_object->labels->name;
			}

			/* If viewing an author archive. */
			elseif ( is_author() ) {

				/* If $front has been set, add it to $path. */
				if ( !empty( $wp_rewrite->front ) )
					$path .= trailingslashit( $wp_rewrite->front );

				/* If an $author_base exists, add it to $path. */
				if ( !empty( $wp_rewrite->author_base ) )
					$path .= $wp_rewrite->author_base;

				/* If $path exists, check for parent pages. */
				if ( !empty( $path ) )
					$trail = array_merge( $trail, wpex_breadcrumbs_get_parents( '', $path ) );

				/* Add the author's display name to the trail end. */
				$trail['trail_end'] = get_the_author_meta( 'display_name', get_query_var( 'author' ) );
			}

			/* If viewing a time-based archive. */
			elseif ( is_time() ) {

				if ( get_query_var( 'minute' ) && get_query_var( 'hour' ) )
					$trail['trail_end'] = get_the_time( __( 'g:i a', 'wpex' ) );

				elseif ( get_query_var( 'minute' ) )
					$trail['trail_end'] = sprintf( __( 'Minute %1$s', 'wpex' ), get_the_time( __( 'i', 'wpex' ) ) );

				elseif ( get_query_var( 'hour' ) )
					$trail['trail_end'] = get_the_time( __( 'g a', 'wpex' ) );
			}

			/* If viewing a date-based archive. */
			elseif ( is_date() ) {

				/* If $front has been set, check for parent pages. */
				if ( $wp_rewrite->front )
					$trail = array_merge( $trail, wpex_breadcrumbs_get_parents( '', $wp_rewrite->front ) );

				if ( is_day() ) {
					$trail[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( esc_attr__( 'Y', 'wpex' ) ) . '">' . get_the_time( __( 'Y', 'wpex' ) ) . '</a>';
					$trail[] = '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '" title="' . get_the_time( esc_attr__( 'F', 'wpex' ) ) . '">' . get_the_time( __( 'F', 'wpex' ) ) . '</a>';
					$trail['trail_end'] = get_the_time( __( 'j', 'wpex' ) );
				}

				elseif ( get_query_var( 'w' ) ) {
					$trail[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( esc_attr__( 'Y', 'wpex' ) ) . '">' . get_the_time( __( 'Y', 'wpex' ) ) . '</a>';
					$trail['trail_end'] = sprintf( __( 'Week %1$s', 'wpex' ), get_the_time( esc_attr__( 'W', 'wpex' ) ) );
				}

				elseif ( is_month() ) {
					$trail[] = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '" title="' . get_the_time( esc_attr__( 'Y', 'wpex' ) ) . '">' . get_the_time( __( 'Y', 'wpex' ) ) . '</a>';
					$trail['trail_end'] = get_the_time( __( 'F', 'wpex' ) );
				}

				elseif ( is_year() ) {
					$trail['trail_end'] = get_the_time( __( 'Y', 'wpex' ) );
				}
			}
		}

		/* If viewing search results. */
		elseif ( is_search() ) {
			$trail['trail_end'] = sprintf( __( 'Search results for &quot;%1$s&quot;', 'wpex' ), esc_attr( get_search_query() ) );
		}

		/* If viewing a 404 error page. */
		elseif ( is_404() ) {
			$trail['trail_end'] = wpex_option( 'error_page_title', __( '404 Not Found', 'wpex') );
		} elseif ( function_exists( 'tribe_is_month' ) && tribe_is_month() ) {
			$trail['trail_end'] = __( 'Events Calendar', 'wpex' );
		}

		/* Allow child themes/plugins to filter the trail array. */
		$trail = apply_filters( 'wpex_breadcrumbs_trail', $trail, $args );

		/* Connect the breadcrumb trail if there are items in the trail. */
		if ( is_array( $trail ) ) {

			/* Open the breadcrumb trail containers. */
			$breadcrumb = '<nav class="site-breadcrumbs clr position-'. wpex_option( 'breadcrumbs_position', 'default' ). '"><div class="breadcrumb-trail">';

			/* If $before was set, wrap it in a container. */
			if ( !empty( $before ) ) {
				$breadcrumb .= '<span class="trail-before">' . $before . '</span> ';
			}

			/* Wrap the $trail['trail_end'] value in a container. */
			if ( !empty( $trail['trail_end'] ) ) {
				$trail['trail_end'] = '<span class="trail-end">' . $trail['trail_end'] . '</span>';
			}

			/* Format the separator. */
			if ( !empty( $separator ) ) {
				$separator = '<span class="sep">' . $separator . '</span>';
			}

			/* Join the individual trail items into a single string. */
			$breadcrumb .= join( " {$separator} ", $trail );

			/* If $after was set, wrap it in a container. */
			if ( !empty( $after ) ) {
				$breadcrumb .= ' <span class="trail-after">' . $after . '</span>';
			}

			/* Close the breadcrumb trail containers. */
			$breadcrumb .= '</div></nav>';
		}

		/* Allow developers to filter the breadcrumb trail HTML. */
		$breadcrumb = apply_filters( 'wpex_breadcrumbs', $breadcrumb );

		/* Output the breadcrumb. */
		if ( $echo ) {
			echo $breadcrumb;
		} else {
			return $breadcrumb;
		}

	} // End wpex_breadcrumbs()
}

/**
 * Breadcrumbs Parent links
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( !function_exists( 'wpex_breadcrumbs_get_parents' ) ) {
	function wpex_breadcrumbs_get_parents( $post_id = '', $path = '' ) {

		/* Set up an empty trail array. */
		$trail = array();

		/* If neither a post ID nor path set, return an empty array. */
		if ( empty( $post_id ) && empty( $path ) )
			return $trail;

		/* If the post ID is empty, use the path to get the ID. */
		if ( empty( $post_id ) ) {

			/* Get parent post by the path. */
			$parent_page = get_page_by_path( $path );


			if( empty( $parent_page ) )
			        // search on page name (single word)
				$parent_page = get_page_by_title ( $path );

			if( empty( $parent_page ) )
				// search on page title (multiple words)
				$parent_page = get_page_by_title ( str_replace( array('-', '_'), ' ', $path ) );

			/* End Modification */

			/* If a parent post is found, set the $post_id variable to it. */
			if ( !empty( $parent_page ) )
				$post_id = $parent_page->ID;
		}

		/* If a post ID and path is set, search for a post by the given path. */
		if ( $post_id == 0 && !empty( $path ) ) {

			/* Separate post names into separate paths by '/'. */
			$path = trim( $path, '/' );
			preg_match_all( "/\/.*?\z/", $path, $matches );

			/* If matches are found for the path. */
			if ( isset( $matches ) ) {

				/* Reverse the array of matches to search for posts in the proper order. */
				$matches = array_reverse( $matches );

				/* Loop through each of the path matches. */
				foreach ( $matches as $match ) {

					/* If a match is found. */
					if ( isset( $match[0] ) ) {

						/* Get the parent post by the given path. */
						$path = str_replace( $match[0], '', $path );
						$parent_page = get_page_by_path( trim( $path, '/' ) );

						/* If a parent post is found, set the $post_id and break out of the loop. */
						if ( !empty( $parent_page ) && $parent_page->ID > 0 ) {
							$post_id = $parent_page->ID;
							break;
						}
					}
				}
			}
		}

		/* While there's a post ID, add the post link to the $parents array. */
		while ( $post_id ) {

			/* Get the post by ID. */
			$page = get_page( $post_id );

			/* Add the formatted post link to the array of parents. */
			$parents[]  = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . get_the_title( $post_id ) . '</a>';

			/* Set the parent post's parent to the post ID. */
			$post_id = $page->post_parent;
		}

		/* If we have parent posts, reverse the array to put them in the proper order for the trail. */
		if ( isset( $parents ) )
			$trail = array_reverse( $parents );

		/* Return the trail of parent posts. */
		return $trail;

	} // End wpex_breadcrumbs_get_parents()
}


/**
 * Breadcrumbs Term Parents
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( !function_exists( 'wpex_breadcrumbs_get_term_parents' ) ) {
	function wpex_breadcrumbs_get_term_parents( $parent_id = '', $taxonomy = '' ) {

		/* Set up some default arrays. */
		$trail = array();
		$parents = array();

		/* If no term parent ID or taxonomy is given, return an empty array. */
		if ( empty( $parent_id ) || empty( $taxonomy ) )
			return $trail;

		/* While there is a parent ID, add the parent term link to the $parents array. */
		while ( $parent_id ) {

			/* Get the parent term. */
			$parent = get_term( $parent_id, $taxonomy );

			/* Add the formatted term link to the array of parent terms. */
			$parents[] = '<a href="' . get_term_link( $parent, $taxonomy ) . '" title="' . esc_attr( $parent->name ) . '">' . $parent->name . '</a>';

			/* Set the parent term's parent as the parent ID. */
			$parent_id = $parent->parent;
		}

		/* If we have parent terms, reverse the array to put them in the proper order for the trail. */
		if ( !empty( $parents ) )
			$trail = array_reverse( $parents );

		/* Return the trail of parent terms. */
		return $trail;

	} // End wpex_breadcrumbs_get_term_parents()
}
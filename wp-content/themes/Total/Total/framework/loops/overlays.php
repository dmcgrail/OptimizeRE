<?php
/**
 * Create awesome overlays for image hovers
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
 */


// Create an array of overlay styles so they can be altered via child themes
if ( ! function_exists( 'wpex_overlay_styles_array' ) ) {
	function wpex_overlay_styles_array( $style = 'default' ) {
		if ( 'post_types' == $style) {
			$array = array(
				'none'							=> __( 'None', 'wpex' ),
				'plus-hover'					=> __( 'Plus Icon Hover', 'wpex' ),
				'plus-two-hover'				=> __( 'Plus Icon #2 Hover', 'wpex' ),
				'view-lightbox-buttons-buttons'	=> __( 'View/Lightbox Icons Hover', 'wpex' ),
				'view-lightbox-buttons-text'	=> __( 'View/Lightbox Text Hover', 'wpex' ),
				'title-date-hover'				=> __( 'Title + Date Hover', 'wpex' ),
				'title-date-visible'			=> __( 'Title + Date Visible', 'wpex' ),
				'slideup-title-white'			=> __( 'Slide-Up Title White', 'wpex' ),
				'slideup-title-black'			=> __( 'Slide-Up Title Black', 'wpex' ),
			);
		} else {
			$array = array(
				'none'							=> __( 'None', 'wpex' ),
				'plus-hover'					=> __( 'Plus Icon Hover', 'wpex' ),
				'plus-two-hover'				=> __( 'Plus Icon #2 Hover', 'wpex' ),
				'view-lightbox-buttons-buttons'	=> __( 'View/Lightbox Icons Hover', 'wpex' ),
				'view-lightbox-buttons-text'	=> __( 'View/Lightbox Text Hover', 'wpex' ),
				'title-category-hover'			=> __( 'Title + Category Hover', 'wpex' ),
				'title-category-visible'		=> __( 'Title + Category Visible', 'wpex' ),
				'title-date-hover'				=> __( 'Title + Date Hover', 'wpex' ),
				'title-date-visible'			=> __( 'Title + Date Visible', 'wpex' ),
				'slideup-title-white'			=> __( 'Slide-Up Title White', 'wpex' ),
				'slideup-title-black'			=> __( 'Slide-Up Title Black', 'wpex' ),
			);
		}
		$array = apply_filters( 'wpex_overlay_styles_array', $array );
		return $array;
	}
}

// Returns the overlay type depending on your theme options & post type
if ( ! function_exists( 'wpex_overlay_style' ) ) {
	function wpex_overlay_style() {
		global $post;
		$post_type = get_post_type();
		// Portfolio
		if ( 'portfolio' == $post_type ) {
			return wpex_option( 'portfolio_entry_overlay_style', 'plus-hover' );
		}
		// Staff
		if ( 'staff' == $post_type ) {
			return wpex_option( 'staff_entry_overlay_style', 'slideup-title-white' );
		}

	}
}

// Returns the correct overlay Classname
if ( ! function_exists( 'wpex_overlay_classname' ) ) {
	function wpex_overlay_classname( $style = '' ) {
		$style = $style ? $style : wpex_overlay_style();
		if ( 'none' == $style ) return;
		return 'overlay-parent overlay-parent-'. $style;
	}
}

// Displays the Overlay HTML
if ( ! function_exists( 'wpex_overlay' ) ) {
	function wpex_overlay( $position = 'inside_link', $style = '' ) {
		// Get the correct style
		$style = $style ? $style : wpex_overlay_style();
		// Return nothing if the style is "none"
		if ( empty( $style) || 'none' == $style ) {
			return;
		}
		/**
			Plus Icon Hover
		**/
		elseif ( 'plus-hover' == $style && 'inside_link' == $position ) { ?>
			<span class="overlay-plus-hover"></span>
		<?php
		/**
			Plus Icon #2 Hover
		**/
		} elseif ( 'plus-two-hover' == $style && 'inside_link' == $position ) { ?>
			<div class="overlay-plus-two-hover"><span class="fa fa-plus"></span></div>
		<?php
		/**
			Slide Up Title White
		**/
		} elseif ( 'slideup-title-white' == $style && 'inside_link' == $position ) { ?>
			<div class="overlay-slideup-title white clr">
				<span class="title">
					<?php if ( 'staff' == get_post_type() ) {
						echo get_post_meta( get_the_ID(), 'wpex_staff_position', true );
					} else {
						the_title();
					} ?>
				</span>
			</div>
		<?php
		/**
			Slide Up Title Black
		**/
		} elseif ( 'slideup-title-black' == $style && 'inside_link' == $position ) { ?>
			<div class="overlay-slideup-title black clr">
				<span class="title">
					<?php if ( 'staff' == get_post_type() ) {
						echo get_post_meta( get_the_ID(), 'wpex_staff_position', true );
					} else {
						the_title();
					} ?>
				</span>
		</div>
		<?php
		/**
			Lightbox + View Butttons Style
		**/
		} elseif ( 'view-lightbox-buttons-buttons' == $style && 'outside_link' == $position ) { ?>
			<div class="overlay-view-lightbox-buttons">
				<div class="overlay-view-lightbox-buttons-inner clr">
					<div class="overlay-view-lightbox-buttons-buttons clr">
						<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ); ?>" class="wpex-lightbox" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>"><span class="fa fa-search"></span></a>
						<a href="<?php the_permalink(); ?>" class="view-post" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>"><span class="fa fa-arrow-right"></span></a>
					</div>
				</div>
			</div>
		<?php
		/**
			Lightbox + View Text Style
		**/
		} elseif ( 'view-lightbox-buttons-text' == $style && 'outside_link' == $position ) { ?>
			<div class="overlay-view-lightbox-text">
				<div class="overlay-view-lightbox-text-inner clr">
					<div class="overlay-view-lightbox-text-buttons clr">
						<a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ); ?>" class="wpex-lightbox" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>"><?php _e( 'Zoom', 'wpex' ); ?><span class="fa fa-search"></span></a>
						<a href="<?php the_permalink(); ?>" class="view-post" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>"><?php _e( 'View', 'wpex' ); ?><span class="fa fa-arrow-right"></span></a>
					</div>
				</div>
			</div>
		<?php
		/**
			Title + Category Hover
		**/
		} elseif ( 'title-category-hover' == $style && 'inside_link' == $position ) { ?>
			<div class="overlay-title-category-hover">
				<div class="overlay-title-category-hover-inner clr">
					<div class="overlay-title-category-hover-text clr">
						<div class="overlay-title-category-hover-title">
							<?php the_title(); ?>
						</div>
						<div class="overlay-title-category-hover-category">
							<?php
							$post_type = get_post_type();
							if ( 'portfolio' == $post_type ) {
								$taxonomy = 'portfolio_category';
							} elseif( 'staff' == $post_type ) {
								$taxonomy = 'staff_category';
							} elseif ( 'post' == $post_type ) {
								$taxonomy = 'category';
							} else {
								$taxonomy = false;
							}
							if ( ! empty( $taxonomy ) ) {
								wpex_get_first_term( get_the_ID(), $taxonomy );
							} ?>
						</div>
					</div>
				</div>
			</div>
		<?php
		/**
			Title + Category Visible
		**/
		} elseif ( 'title-category-visible' == $style && 'inside_link' == $position ) { ?>
			<div class="overlay-title-category-visible">
				<div class="overlay-title-category-visible-inner clr">
					<div class="overlay-title-category-visible-text clr">
						<div class="overlay-title-category-visible-title">
							<?php the_title(); ?>
						</div>
						<div class="overlay-title-category-visible-category">
							<?php
							$post_type = get_post_type();
							if ( 'portfolio' == $post_type ) {
								$taxonomy = 'portfolio_category';
							} elseif( 'staff' == $post_type ) {
								$taxonomy = 'staff_category';
							} elseif ( 'post' == $post_type ) {
								$taxonomy = 'category';
							} else {
								$taxonomy = false;
							}
							if ( ! empty( $taxonomy ) ) {
								wpex_get_first_term( get_the_ID(), $taxonomy );
							} ?>
						</div>
					</div>
				</div>
			</div>
		<?php
		/**
			Title + Date Hover
		**/
		} elseif ( 'title-date-hover' == $style && 'inside_link' == $position ) { ?>
			<div class="overlay-title-date-hover">
				<div class="overlay-title-date-hover-inner clr">
					<div class="overlay-title-date-hover-text clr">
						<div class="overlay-title-date-hover-title">
							<?php the_title(); ?>
						</div>
						<div class="overlay-title-date-hover-date">
							<?php
							$date_format = 'F j, Y';
							$date_format = apply_filters( 'wpex_overlay_date_format', $date_format );
							echo get_the_date( $date_format ); ?>
						</div>
					</div>
				</div>
			</div>
		<?php
		/**
			Title + Date Visible
		**/
		} elseif ( 'title-date-visible' == $style && 'inside_link' == $position ) { ?>
			<div class="overlay-title-date-visible">
				<div class="overlay-title-date-visible-inner clr">
					<div class="overlay-title-date-visible-text clr">
						<div class="overlay-title-date-visible-title">
							<?php the_title(); ?>
						</div>
						<div class="overlay-title-date-visible-date">
							<?php
							$date_format = 'F j, Y';
							$date_format = apply_filters( 'wpex_overlay_date_format', $date_format );
							echo get_the_date( $date_format ); ?>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
	}
}
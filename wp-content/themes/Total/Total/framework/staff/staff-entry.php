<?php
/**
 * Returns correct classes for the staff grid
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.52
*/
if ( ! function_exists( 'wpex_staff_column_class' ) ) {
	function wpex_staff_column_class( $query ) {
		if ( 'related' == $query ) {
			return wpex_grid_class( wpex_option( 'staff_related_columns', '3' ) );
		} else {
			return wpex_grid_class( wpex_option( 'staff_entry_columns', '3' ) );
		}
	}
}

/**
 * Displays the media (featured image or video ) for the staff entries
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.36
*/
if ( ! function_exists( 'wpex_staff_entry_media' ) ) {
	function wpex_staff_entry_media() {
		if ( has_post_thumbnail() ) {
			$wpex_image = wpex_image( 'array' ); ?>
			<div class="staff-entry-media <?php echo wpex_overlay_classname(); ?> clr">
				<?php if ( wpex_option( 'staff_links_enable', '1' ) == '1' ) { ?>
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
				<?php } ?>
					<img src="<?php echo $wpex_image['url']; ?>" alt="<?php the_title(); ?>" width="<?php echo $wpex_image['width']; ?>" height="<?php echo $wpex_image['height']; ?>" />
					<?php wpex_overlay( 'inside_link' ); ?>
				<?php if ( wpex_option( 'staff_links_enable', '1' ) == '1' ) echo '</a>'; ?>
				<?php wpex_overlay( 'outside_link' ); ?>
			</div><!-- .staff-entry-media -->
		<?php }
	}
}

/**
 * Displays the details for the staff entries
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.36
*/
if ( ! function_exists( 'wpex_staff_entry_content' ) ) {
	function wpex_staff_entry_content() {
		// Disabled via the theme admin
		if ( ! wpex_option( 'staff_entry_details', '1' ) ) {
			return;
		}
		// Disabled for related entries
		if ( is_singular( 'staff' ) && ! wpex_option( 'staff_related_excerpts', '1' ) ) {
			return;
		} ?>
		<div class="staff-entry-details">
			<h2 class="staff-entry-title">
			<?php if ( wpex_option( 'staff_links_enable', '1' ) == '1' ) { ?>
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a>
			<?php } else { ?>
				<?php the_title(); ?>
			<?php } ?>
			</h2>
			<div class="staff-entry-excerpt clr">
				<?php wpex_excerpt( wpex_option( 'staff_entry_excerpt_length', '20' ), false ); ?>
			</div><!-- .staff-entry-excerpt -->
			<?php
			// Displays social links for current staff member
			// @ functions/staff/staff-social.php
			echo wpex_get_staff_social(); ?>
		</div><!-- .staff-entry-details -->
	<?php }
}
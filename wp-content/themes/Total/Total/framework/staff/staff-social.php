<?php
/**
 * Social profiles for staff members
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/

if ( ! function_exists( 'wpex_get_staff_social' ) ) {
	function wpex_get_staff_social( $atts = NULL ) {

		extract( shortcode_atts( array(
			'link_target'	=> 'blank',
		),
		$atts ) );

		global $post;
		$post_id = $post->ID;
		$output='';
		$profiles = array(
			'twitter'		=> 'Twitter',
			'facebook'		=> 'Facebook',
			'google-plus'	=> 'Google Plus',
			'dribbble'		=> 'Dribbble',
			'linkedin'		=> 'LinkedIn',
			'skype'			=> 'Skype',
			'email'			=> 'Email',
			
		);

		ob_start();

		// Do not display if disabled for the archives
		if ( is_tax() && ! wpex_option( 'staff_entry_social', '1' ) ) {
			return;
		} ?>

			<div class="staff-social clr">
				<?php foreach ( $profiles as $key => $value ) {
					$meta = get_post_meta( $post_id, 'wpex_staff_'. $key, true );
					if ( 'email' == $key ) {
						$key = 'envelope';
					}
					if ( $meta ) { ?>
						<a href="<?php echo $meta; ?>" title="<?php echo $value; ?>" class="staff-<?php echo $key; ?> tooltip-up" target="_<?php echo $link_target; ?>">
							<span class="fa fa-<?php echo $key; ?>"></span>
						</a>
					<?php }
				} ?>
			</div><!-- .staff-social -->

		<?php
		return ob_get_clean();
	}
}
add_shortcode( 'staff_social', 'wpex_get_staff_social' );
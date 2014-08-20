<?php
/**
 * Flickr custom widget
 *
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

class Wpex_Flickr_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'wpex_flickr',
			WPEX_THEME_BRANDING . ' - '. __( 'Flickr Stream', 'wpex' ),
			array(
				'classname'		=> 'flickr_widget',
				'description' => __( 'Shows a listing of your recent or random posts with their thumbnail for any chosen post type.', 'wpex' )
			)
		);
	}
	
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	function widget( $args, $instance ) {
		$title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Flickr Stream', 'wpex' );
		$number = isset( $instance['number'] ) ? (int) strip_tags( $instance['number'] ) : '8';
		$id = isset( $instance['id'] ) ? $instance['id'] : '52617155@N08';
		// Important hook
		echo $args['before_widget'];
			// Display title
			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title']; 
			}
			if ( $id ) { ?>
				<div class="wpex-flickr-widget">
					<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script>
				</div>
			<?php
			}
		// Important hook
		echo $args['after_widget'];
	}
	
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		// Title
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'Flickr Stream', 'wpex' );
		}

		// ID
		if ( isset( $instance['id'] ) ) {
			$id = $instance['id'];
		} else {
			$id = '52617155@N08';
		}

		// Number
		if ( isset( $instance[ 'number' ] ) ) {
			$number = $instance[ 'number' ];
		} else {
			$number = '8';
		} ?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>">
		<?php _e( 'Title:', 'wpex'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo
			esc_attr($title); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('id'); ?>">
		<?php _e( 'Flickr ID ', 'wpex' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo
			esc_attr($id); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('number'); ?>">
		<?php _e( 'Number:', 'wpex' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo
			esc_attr($number); ?>" /></p>

	<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['id'] = ( ! empty( $new_instance['id'] ) ) ? strip_tags( $new_instance['id'] ) : '';
		$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
		return $instance;
	}

}
if ( !function_exists( 'register_wpex_flickr_widget' ) ) {
	function register_wpex_flickr_widget() {
		register_widget( 'Wpex_Flickr_Widget' );
	}
}
add_action( 'widgets_init', 'register_wpex_flickr_widget' ); ?>
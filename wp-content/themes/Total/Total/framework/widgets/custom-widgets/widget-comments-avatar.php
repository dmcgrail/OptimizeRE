<?php
/**
 * Recent comments with avatars custom widget
 *
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

class Wpex_Recent_Comments_Avatars_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'wpex_recent_comments_avatars_widget',
			WPEX_THEME_BRANDING . ' - '. __( 'Recent Comments With Avatars', 'wpex' ),
			array( 'description' => __( 'Displays your recent comments with avatars.', 'wpex' ) )
		);
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		$title = isset( $instance['title'] ) ? $instance['title'] : __( 'Recent Comments', 'wpex' );
		$number = isset( $instance['number'] ) ? $instance['number'] : '3';
		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title;
		} ?>
		<ul class="wpex-recent-comments-widget clr">
			<?php
			// Query Posts
			$comments = get_comments( array (
				'number'		=> $number,
				'status'		=> 'approve',
				'post_status'	=> 'publish',
				'type'			=> 'comment'
			) );
			if ( $comments ) {
				foreach ( $comments as $comment ) { ?>
					<li class="clr">
						<a href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID; ?>" title="<?php the_title(); ?>" class="avatar"><?php echo get_avatar( $comment->comment_author_email, '50' ); ?></a>
						<strong><?php echo get_comment_author( $comment->comment_ID ); ?>:</strong> <?php echo wp_trim_words( $comment->comment_content, '10' ); ?>...
						<br/ >
						<a href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID; ?>" title="<?php the_title(); ?>"><?php _e( 'view comment', 'wpex' ); ?> &rarr;</a>
						</a>
					</li>
				<?php }
			} else { ?>
				<li style="padding-left:0;"><?php _e( 'No comments yet.', 'wpex' ); ?></li>
			<?php } ?>
		</ul>
	<?php echo $after_widget;
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
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'Recent Comments', 'wpex' );
		}
		// Number
		if ( isset( $instance[ 'number' ] ) ) {
			$number = $instance[ 'number' ];
		} else {
			$number = '3';
		} ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wpex' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title', 'wpex' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number to Show:', 'wpex'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" />
		</p>
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
		$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
		return $instance;
	}

}
if ( !function_exists( 'register_wpex_recent_comments_avatars_widget' ) ) {
	function register_wpex_recent_comments_avatars_widget() {
		register_widget( 'Wpex_Recent_Comments_Avatars_Widget' );
	}
}
add_action( 'widgets_init', 'register_wpex_recent_comments_avatars_widget' ); ?>
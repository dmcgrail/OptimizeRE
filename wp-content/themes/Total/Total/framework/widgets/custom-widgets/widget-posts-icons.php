<?php
/**
 * Recent posts with icons custom widget
 *
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

class Wpex_Recent_Posts_Icons extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'wpex_recent_posts_icons',
			WPEX_THEME_BRANDING . ' - '. __( 'Recent Posts With Icons', 'wpex' ),
			array( 'description' => __( 'Displays recent posts with format icons.', 'wpex' ) )
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

		// Vars
		$title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Recent Posts', 'wpex' );
		$number = isset( $instance['number'] ) ? $instance['number'] : '5';
		$order = isset( $instance['order'] ) ? $instance['order'] : 'DESC';
		$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : 'date';
		$category =  isset( $instance['category'] ) ? $instance['category'] : 'all';

		// Get current post ID to exclude
		if ( is_singular() ) {
			$exclude = array( get_the_ID() );
		} else {
			$exclude = NULL;
		}

		// Before Widget Hook
		echo $args['before_widget'];

			// Display title
			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title']; 
			}

			// Category
			if ( !empty( $category ) && 'all' != $category ) {
				$taxonomy = array (
					array (
						'taxonomy'	=> 'category',
						'field'		=> 'id',
						'terms'		=> $category,
					)
				);
			} else {
				$taxonomy = NUll;
			}

			// Query Posts
			global $post;
			$wpex_query = new WP_Query( array(
				'post_type'				=> 'post',
				'posts_per_page'		=> $number,
				'orderby'				=> $orderby,
				'order'					=> $order,
				'no_found_rows'			=> true,
				'post__not_in'			=> $exclude,
				'tax_query'				=> $taxonomy,
				'ignore_sticky_posts'	=> 1,
			) );

			// Loop through posts
			if ( $wpex_query->have_posts() ) { ?>
				<ul class="widget-recent-posts-icons clr">
					<?php foreach( $wpex_query->posts as $post ) : setup_postdata( $post ); ?>
						<li class="clr">
							<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
								<span class="fa <?php wpex_post_format_icon(); ?>"></span><?php the_title(); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php }

		// Reset post data
		wp_reset_postdata();

		// After widget hook
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
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'Recent Posts', 'wpex' );
		}

		// Number
		if ( isset( $instance[ 'number' ] ) ) {
			$number = $instance[ 'number' ];
		} else {
			$number = '5';
		}

		// Order
		if ( isset( $instance[ 'order' ] ) ) {
			$order = $instance[ 'order' ];
		} else {
			$order = 'DESC';
		}

		// Order By
		if ( isset( $instance[ 'orderby' ] ) ) {
			$orderby = $instance[ 'orderby' ];
		} else {
			$orderby = 'date';
		}

		// Category
		if ( isset( $instance[ 'category' ] ) ) {
			$category = $instance[ 'category' ];
		} else {
			$category = '';
		} ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'wpex' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title','wpex'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number', 'wpex' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e( 'Order', 'wpex' ); ?></label>
			<br />
			<select class='wpex-select' name="<?php echo $this->get_field_name( 'order' ); ?>" id="<?php echo $this->get_field_id( 'order' ); ?>">
				<option value="DESC" <?php if( $order == 'DESC' ) { ?>selected="selected"<?php } ?>><?php _e( 'Descending', 'wpex' ); ?></option>
				<option value="ASC" <?php if( $order == 'ASC' ) { ?>selected="selected"<?php } ?>><?php _e( 'Ascending', 'wpex' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By', 'wpex' ); ?></label>
			<br />
			<select class='wpex-select' name="<?php echo $this->get_field_name( 'orderby' ); ?>" id="<?php echo $this->get_field_id( 'orderby' ); ?>">
			<?php $orderby_array = array (
				'date'			=> __( 'Date', 'wpex' ),
				'title'			=> __( 'Title', 'wpex' ),
				'modified'		=> __( 'Modified', 'wpex' ),
				'author'		=> __( 'Author', 'wpex' ),
				'rand'			=> __( 'Random', 'wpex' ),
				'comment_count'	=> __( 'Comment Count', 'wpex' ),
			);
			foreach ( $orderby_array as $key => $value ) { ?>
				<option value="<?php echo $key; ?>" <?php if( $orderby == $key ) { ?>selected="selected"<?php } ?>>
					<?php echo $value; ?>
				</option>
			<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e( 'Category', 'wpex' ); ?>:</label>
			<br />
			<select class='wpex-select' name="<?php echo $this->get_field_name('category'); ?>" id="<?php echo $this->get_field_id('category'); ?>">
			<option value="all" <?php if($category == 'all') { ?>selected="selected"<?php } ?>><?php _e('All', 'wpex'); ?></option>
			<?php
			$terms = get_terms( 'category' );
			foreach ( $terms as $term ) { ?>
				<option value="<?php echo $term->term_id; ?>" <?php if( $category == $term->term_id ) { ?>selected="selected"<?php } ?>><?php echo $term->name; ?></option>
			<?php } ?>
			</select>
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
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
		$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
		$instance['order'] = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';
		$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
		return $instance;
	}

}
if ( !function_exists( 'register_wpex_recent_posts_icons' ) ) {
	function register_wpex_recent_posts_icons() {
		register_widget( 'Wpex_Recent_Posts_Icons' );
	}
}
add_action( 'widgets_init', 'register_wpex_recent_posts_icons' ); ?>
<?php
/**
 * Image social widget
 *
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

class Wpex_Social_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'wpex_social_widget',
			WPEX_THEME_BRANDING . ' - '. __( 'Image Icons Social Widget', 'wpex' ),
			array( 'description' => __( 'Displays icons with links to your social profiles with drag and drop support.', 'wpex' ) )
		);
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$style = $instance['style'];
		$target = $instance['target'];
		$size = $instance['size'];
		$social_services = $instance['social_services']; ?>
		<?php echo $before_widget; ?>
			<?php if ( $title )
				  echo $before_title . $title . $after_title; ?>
					<ul class="wpex-social-widget-output">
						<?php foreach( $social_services as $key => $service ) { ?>
							<?php $link = !empty( $service['url'] ) ? $service['url'] : null; ?>
							<?php $name = $service['name']; ?>
							<?php if ( $link ) { ?>
								<?php echo '<li><a href="'. $link .'" title="'. $name .'" target="_'.$target.'"><img src="'. get_template_directory_uri() .'/images/social-color/'. strtolower ($name) .'.png" alt="'. $name .'" style="width:'.$size.';height='.$size.';" /></a></li>'; ?>
							<?php } ?>
						<?php } ?>
					</ul>
		<?php echo $after_widget; ?>
		<?php
	}

	/** @see WP_Widget::update */
	function update( $new, $old ) {
		$instance = $old;
		$instance['title'] = !empty( $new['title'] ) ? strip_tags( $new['title'] ) : null;
		$instance['style'] = !empty( $new['style'] ) ? strip_tags( $new['style'] ) : 'color-square';
		$instance['target'] = !empty( $new['target'] ) ? strip_tags( $new['target'] ) : 'blank';
		$instance['size'] = !empty( $new['size'] ) ? strip_tags( $new['size'] ) : '32px';
		$instance['social_services'] = $new['social_services'];
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
		$defaults =  array(
			'title'				=> __('Follow Us','wpex'),
			'style'				=> 'color-square',
			'target' 			=> 'blank',
			'size'				=> '30px',
			'social_services'	=> array(
					'dribbble'		=> array(
						'name'		=> 'Dribbble',
						'url'		=> ''
					),
					'facebook'		=> array(
						'name'		=> 'Facebook',
						'url'		=> ''
					),
					'flickr'			=> array(
						'name'		=> 'Flickr',
						'url'		=> ''
					),
					'forrst'		=> array(
						'name'		=> 'Forrst',
						'url'		=> ''
					),
					'github'		=> array(
						'name'		=> 'GitHub',
						'url'		=> ''
					),
					'googleplus'	=> array(
						'name'		=> 'GooglePlus',
						'url'		=> ''
					),
					'instagram'		=> array(
						'name'		=> 'Instagram',
						'url'		=> ''
					),
					'linkedin' 		=> array(
						'name'		=> 'LinkedIn',
						'url'		=> ''
					),
					'pinterest' 	=> array(
						'name'		=> 'Pinterest',
						'url'		=> ''
					),
					'rss' 			=> array(
						'name'		=> 'RSS',
						'url'		=> ''
					),
					'tumblr' 		=> array(
						'name'		=> 'Tumblr',
						'url'		=> ''
					),
					'twitter' 		=> array(
						'name'		=> 'Twitter',
						'url'		=> ''
					),
					'vimeo' 		=> array(
						'name'		=> 'Vimeo',
						'url'		=> ''
					),
					'youtube' 		=> array(
						'name'		=> 'Youtube',
						'url'		=> ''
					),
			),
		);
		
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','wpex'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('target'); ?>"><?php _e('Link Target:', 'wpex'); ?></label>
			<br />
			<select class='wpex-widget-select' name="<?php echo $this->get_field_name('target'); ?>" id="<?php echo $this->get_field_id('target'); ?>">
				<option value="blank" <?php if($instance['target'] == 'blank') { ?>selected="selected"<?php } ?>><?php _e( 'Blank', 'wpex' ); ?></option>
				<option value="self" <?php if($instance['target'] == 'self') { ?>selected="selected"<?php } ?>><?php _e( 'Self', 'wpex' ); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Size:', 'wpex'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="text" value="<?php echo $instance['size']; ?>" />
			<small><?php _e('Size in pixels. Icon images are 36px.', 'wpex'); ?></small>
		</p>

		<h3 style="margin-top:20px;margin-bottom:0;"><?php _e('Social Links','wpex'); ?></h3>  
		<small style="display:block;margin-bottom:10px;"><?php _e('Enter the full URL to your social profile','wpex'); ?></small>           
		<ul id="<?php echo $this->get_field_id( 'social_services' ); ?>" class="wpex-services-list">
			<input type="hidden" id="<?php echo $this->get_field_name( 'social_services' ); ?>" value="<?php echo $this->get_field_name( 'social_services' ); ?>">
			<input type="hidden" id="<?php echo wp_create_nonce('wpex_social_widget_nonce'); ?>">
			<?php
			$social_services = $instance['social_services'];
			$i=0;
			foreach( $social_services as $key => $service ) {
				$url=0;
				if(isset($service['url'])) $url = $service['url'];
				if(isset($service['name'])) $name = $service['name'];
				$i++; ?>
				<li id="<?php echo $this->get_field_id( $service ); ?>_0<?php echo $i ?>">
					<p>
						<label for="<?php echo $this->get_field_id( 'social_services' ); ?>-<?php echo $i ?>-name"><?php echo $name; ?>:</label>
						<input type="hidden" id="<?php echo $this->get_field_id( 'social_services' ); ?>-<?php echo $i ?>-url" name="<?php echo $this->get_field_name( 'social_services' ).'['.$i.'][name]'; ?>" value="<?php echo $name; ?>">
						<input type="url" class="widefat" id="<?php echo $this->get_field_id( 'social_services' ); ?>-<?php echo $i ?>-url" name="<?php echo $this->get_field_name( 'social_services' ).'['.$i.'][url]'; ?>" value="<?php echo $url; ?>" />
					</p>
				</li>
			<?php } ?>
		</ul>
		
	<?php
	}

}
if ( !function_exists( 'register_wpex_social_widget' ) ) {
	function register_wpex_social_widget() {
		register_widget( 'Wpex_Social_Widget' );
	}
}
add_action( 'widgets_init', 'register_wpex_social_widget' );

/* Widget Ajax Function
/*-----------------------------------------------------------------------------------*/
add_action('admin_init','load_wpex_social_widget_scripts');
function load_wpex_social_widget_scripts() {
	global $pagenow;
	if ( is_admin() && $pagenow == "widgets.php" ) {

		add_action('admin_head', 'add_new_wpex_social_style');
		add_action('admin_footer', 'add_new_wpex_social_ajax_trigger');
	
		function add_new_wpex_social_ajax_trigger() { ?>
		<script type="text/javascript" >
			jQuery(document).ready(function($) {
				jQuery(document).ajaxSuccess(function(e, xhr, settings) { //fires when widget saved
					var widget_id_base = 'wpex_social_widget';
					if(settings.data.search('action=save-widget') != -1 && settings.data.search('id_base=' + widget_id_base) != -1) {
						wpexSortServices();
					}
				});
				function wpexSortServices() {
					jQuery('.wpex-services-list').each( function() {
						var id = jQuery(this).attr('id');
						$('#'+ id).sortable({
							placeholder: "placeholder",
							opacity: 0.6
						});
					});
				}
				wpexSortServices();
			});
		</script>
	<?php
	}
}
	
	function add_new_wpex_social_style() { ?>
		<style>.wpex-services-list li {cursor:move;background:#fcfcfc;padding:10px;border:1px solid #e3e3e3;margin-bottom:10px;}.wpex-sw-container label{color: #666;font-weight:bold;}.wpex-sw-container input{margin-top:5px;}
		.wpex-services-list .placeholder {border:1px dashed #e3e3e3; }</style>
	<?php
	}
	
} //end check pagenow
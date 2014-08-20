<?php
/**
 * Font Awesome social widget
 *
 * Learn more: http://codex.wordpress.org/Widgets_API
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

class Wpex_Fontawesome_Social_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'wpex_fontawesome_social_widget',
			WPEX_THEME_BRANDING . ' - '. __( 'Font Awesome Social Widget', 'wpex' ),
			array( 'description' => __( 'Displays icons with links to your social profiles with drag and drop support and Font Awesome Icons.', 'wpex' ) )
		);
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$style = $instance['style'];
		$type = $instance['type'];
		$target = $instance['target'];
		$size = intval($instance['size']);
		$font_size = intval($instance['font_size']);
		$border_radius = intval($instance['border_radius']);
		$social_services = $instance['social_services']; ?>
		<?php echo $before_widget; ?>
			<?php if ( $title )
				echo $before_title . $title . $after_title;
					// ADD Style
					$add_style = array();
					if ( '30' != $size && '' != $size ) {
						$add_style[] = 'height: '. $size .'px;width: '. $size .'px;line-height: '. $size .'px;';
					}
					if ( '14' != $font_size && '' != $font_size ) {
						$add_style[] = 'font-size: '. $font_size .'px;';
					}
					if ( '3' != $border_radius && '' != $border_radius ) {
						$add_style[] = 'border-radius: '. $border_radius .'px;';
					}
					$add_style = implode('', $add_style);
					if ( $add_style ) {
						$add_style = wp_kses( $add_style, array() );
						$add_style = 'style="' . esc_attr($add_style) . '"';
					} ?>
					<ul class="wpex-fontawesome-social-widget-ul social-style-<?php echo $style; ?> social-type-<?php echo $type; ?>">
						<?php
						// Loop through each social service and display font icon
						foreach( $social_services as $key => $service ) {
							$link = !empty( $service['url'] ) ? $service['url'] : null;
							$name = $service['name'];
							if ( $link ) {
								if ( 'youtube' == $key ) {
									$key = 'youtube-play';
								}
								echo '<li class="social-widget-'. $key .'"><a href="'. $link .'" title="'. $name .'" target="_'.$target.'" '. $add_style .'><i class="fa fa-'. $key .'"></i></a></li>';
							}
						} ?>
					</ul>
		<?php echo $after_widget; ?>
		<?php
	}

	/** @see WP_Widget::update */
	function update( $new, $old ) {
		$instance = $old;
		$instance['title'] = !empty( $new['title'] ) ? strip_tags( $new['title'] ) : null;
		$instance['style'] = !empty( $new['style'] ) ? strip_tags( $new['style'] ) : 'black';
		$instance['type'] = !empty( $new['type'] ) ? strip_tags( $new['type'] ) : 'graphical';
		$instance['target'] = !empty( $new['target'] ) ? strip_tags( $new['target'] ) : 'blank';
		$instance['size'] = !empty( $new['size'] ) ? strip_tags( $new['size'] ) : '30px';
		$instance['border_radius'] = !empty( $new['border_radius'] ) ? strip_tags( $new['border_radius'] ) : '3px';
		$instance['font_size'] = !empty( $new['font_size'] ) ? strip_tags( $new['font_size'] ) : '14px';
		$instance['social_services'] = $new['social_services'];
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
		$defaults =  array(
			'title'				=> __('Follow Us','wpex'),
			'style'				=> 'color-square',
			'type'				=> 'flat',
			'font_size'			=> '14px',
			'border_radius'		=> '3px',
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
					'vk'			=> array(
						'name'		=> 'VK',
						'url'		=> ''
					),
					'github'		=> array(
						'name'		=> 'GitHub',
						'url'		=> ''
					),
					'google-plus'	=> array(
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
					'tumblr' 		=> array(
						'name'		=> 'Tumblr',
						'url'		=> ''
					),
					'twitter' 		=> array(
						'name'		=> 'Twitter',
						'url'		=> ''
					),
					'skype' 		=> array(
						'name'		=> 'Skype',
						'url'		=> ''
					),
					'trello' 		=> array(
						'name'		=> 'Trello',
						'url'		=> ''
					),
					'foursquare' 	=> array(
						'name'		=> 'Foursquare',
						'url'		=> ''
					),
					'renren' 		=> array(
						'name'		=> 'RenRen',
						'url'		=> ''
					),
					'vimeo-square' 	=> array(
						'name'		=> 'Vimeo',
						'url'		=> ''
					),
					'youtube' 		=> array(
						'name'		=> 'Youtube',
						'url'		=> ''
					),
					'rss' 			=> array(
						'name'		=> 'RSS',
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
			<label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style', 'wpex'); ?></label>
			<br />
			<select class='wpex-widget-select' name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>">
				<option value="black" <?php if($instance['style'] == 'black') { ?>selected="selected"<?php } ?>><?php _e( 'Black', 'wpex' ); ?></option>
				<option value="black-color-hover" <?php if($instance['style'] == 'black-color-hover') { ?>selected="selected"<?php } ?>><?php _e( 'Black With Color Hover', 'wpex' ); ?></option>
				<option value="color" <?php if($instance['style'] == 'color') { ?>selected="selected"<?php } ?>><?php _e( 'Color', 'wpex' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type', 'wpex'); ?></label>
			<br />
			<select class='wpex-widget-select' name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>">
				<option value="flat" <?php if($instance['type'] == 'flat') { ?>selected="selected"<?php } ?>><?php _e( 'Flat', 'wpex' ); ?></option>
				<option value="graphical" <?php if($instance['type'] == 'graphical') { ?>selected="selected"<?php } ?>><?php _e( 'Graphical', 'wpex' ); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('target'); ?>"><?php _e( 'Link Target:', 'wpex' ); ?></label>
			<br />
			<select class='wpex-widget-select' name="<?php echo $this->get_field_name('target'); ?>" id="<?php echo $this->get_field_id('target'); ?>">
				<option value="blank" <?php if($instance['target'] == 'blank') { ?>selected="selected"<?php } ?>><?php _e( 'Blank', 'wpex' ); ?></option>
				<option value="self" <?php if($instance['target'] == 'self') { ?>selected="selected"<?php } ?>><?php _e( 'Self', 'wpex' ); ?></option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('size'); ?>"><?php _e( 'Icon Size', 'wpex' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="text" value="<?php echo $instance['size']; ?>" />
			<small><?php _e('Enter a size to be used for the height/width for the icon.', 'wpex'); ?></small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('font_size'); ?>"><?php _e( 'Icon Font Size', 'wpex' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('font_size'); ?>" name="<?php echo $this->get_field_name('font_size'); ?>" type="text" value="<?php echo $instance['font_size']; ?>" />
			<small><?php _e('Enter a custom font size for the icons.', 'wpex'); ?></small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('border_radius'); ?>"><?php _e( 'Border Radius', 'wpex' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('border_radius'); ?>" name="<?php echo $this->get_field_name('border_radius'); ?>" type="text" value="<?php echo $instance['border_radius']; ?>" />
			<small><?php _e('Enter a custom border radius. For circular icons enter a number equal or greater to the Icon Size field above.', 'wpex'); ?></small>
		</p>

		<h3 style="margin-top:20px;margin-bottom:0;"><?php _e( 'Social Links','wpex' ); ?></h3>  
		<small style="display:block;margin-bottom:10px;"><?php _e('Enter the full URL to your social profile','wpex'); ?></small>
		<ul id="<?php echo $this->get_field_id( 'social_services' ); ?>" class="wpex-services-list">
			<input type="hidden" id="<?php echo $this->get_field_name( 'social_services' ); ?>" value="<?php echo $this->get_field_name( 'social_services' ); ?>">
			<input type="hidden" id="<?php echo wp_create_nonce('wpex_fontawesome_social_widget_nonce'); ?>">
			<?php
			$social_services = $instance['social_services'];
			foreach( $social_services as $key => $service ) {
				$url=0;
				if(isset($service['url'])) $url = $service['url'];
				if(isset($service['name'])) $name = $service['name']; ?>
				<li id="<?php echo $this->get_field_id( $service ); ?>_0<?php echo $key ?>">
					<p>
						<label for="<?php echo $this->get_field_id( 'social_services' ); ?>-<?php echo $key ?>-name"><?php echo $name; ?>:</label>
						<input type="hidden" id="<?php echo $this->get_field_id( 'social_services' ); ?>-<?php echo $key ?>-url" name="<?php echo $this->get_field_name( 'social_services' ).'['.$key.'][name]'; ?>" value="<?php echo $name; ?>">
						<input type="url" class="widefat" id="<?php echo $this->get_field_id( 'social_services' ); ?>-<?php echo $key ?>-url" name="<?php echo $this->get_field_name( 'social_services' ).'['.$key.'][url]'; ?>" value="<?php echo $url; ?>" />
					</p>
				</li>
			<?php } ?>
		</ul>
		
	<?php
	}

}

if ( !function_exists( 'register_wpex_fontawesome_social_widget' ) ) {
	function register_wpex_fontawesome_social_widget() {
		register_widget( 'Wpex_Fontawesome_Social_Widget' );
	}
}
add_action( 'widgets_init', 'register_wpex_fontawesome_social_widget' );


/* Widget Ajax Function
/*-----------------------------------------------------------------------------------*/
add_action('admin_init','load_wpex_fontawesome_social_widget_scripts');
function load_wpex_fontawesome_social_widget_scripts() {
	global $pagenow;
	if ( is_admin() && $pagenow == "widgets.php" ) {

		add_action('admin_head', 'add_new_wpex_fontawesome_social_style');
		add_action('admin_footer', 'add_new_wpex_fontawesome_social_ajax_trigger');
	
		function add_new_wpex_fontawesome_social_ajax_trigger() { ?>
		<script type="text/javascript" >
			jQuery(document).ready(function($) {
				jQuery(document).ajaxSuccess(function(e, xhr, settings) {
					var widget_id_base = 'wpex_fontawesome_social_widget';
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
	
	function add_new_wpex_fontawesome_social_style() { ?>
		<style>.wpex-services-list li {cursor:move;background:#fcfcfc;padding:10px;border:1px solid #e3e3e3;margin-bottom:10px;}.wpex-sw-container label{color: #666;font-weight:bold;}.wpex-sw-container input{margin-top:5px;}
		.wpex-services-list .placeholder {border:1px dashed #e3e3e3; }</style>
	<?php
	}
	
} //end check pagenow
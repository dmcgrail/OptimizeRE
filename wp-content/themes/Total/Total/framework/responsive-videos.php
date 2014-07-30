<?php
/**
 * Adds a class around video embed for responsiveness
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

// We don't need this in the admin
if ( is_admin() ) return;

if ( ! function_exists( 'wpex_embed_oembed_html' ) ) {
	function wpex_embed_oembed_html($html, $url, $attr, $post_id) {
		return '<div class="responsive-video-wrap entry-video">' . $html . '</div>';
	}
}
add_filter('embed_oembed_html', 'wpex_embed_oembed_html', 99, 4);
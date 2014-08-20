<?php
/**
 * Make a few general site optimizations
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
*/


/**
 * Removes stuff from wp_head hook
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.5
*/
$wpex_cleanhead_ops = wpex_option( 'cleanup_wp_head', array (
	'feed_links_extra'					=> '1',
	'feed_links'						=> '1',
	'rsd_link'							=> '1',
	'wlwmanifest_link'					=> '1',
	'index_rel_link'					=> '1',
	'parent_post_rel_link'				=> '1',
	'start_post_rel_link'				=> '1',
	'adjacent_posts_rel_link_wp_head'	=> '1',
	'wp_generator'						=> '1',
) );

if( '1' == isset( $wpex_cleanhead_ops['feed_links_extra'] ) ) {
	remove_action( 'wp_head', 'feed_links_extra' );

}

if( '1' == isset( $wpex_cleanhead_ops['feed_links'] ) ) {
	remove_action( 'wp_head', 'feed_links' );
}

if( '1' == isset( $wpex_cleanhead_ops['rsd_link'] ) ) {
	remove_action( 'wp_head', 'rsd_link' );
}

if( '1' == isset( $wpex_cleanhead_ops['wlwmanifest_link'] ) ) {
	remove_action( 'wp_head', 'wlwmanifest_link' );
}

if( '1' == isset( $wpex_cleanhead_ops['index_rel_link'] ) ) {
	remove_action( 'wp_head', 'index_rel_link' );
}

if( '1' == isset( $wpex_cleanhead_ops['parent_post_rel_link'] ) ) {
	remove_action( 'wp_head', 'parent_post_rel_link', 10 );
}

if( '1' == isset( $wpex_cleanhead_ops['start_post_rel_link'] ) ) {
	remove_action( 'wp_head', 'start_post_rel_link', 10 );
}

if( '1' == isset( $wpex_cleanhead_ops['adjacent_posts_rel_link_wp_head'] ) ) {
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
}

if( '1' == isset( $wpex_cleanhead_ops['wp_generator'] ) ) {
	remove_action( 'wp_head', 'wp_generator' );
}

/**
 * Removes jetpack devicepx script
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.0
*/
if ( wpex_option( 'remove_jetpack_devicepx', '1' ) ) {
	add_action('wp_enqueue_scripts', create_function( null, "wp_dequeue_script('devicepx');" ), 20);
}
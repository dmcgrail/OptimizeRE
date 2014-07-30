<?php
/**
 * Displays the # of queries and memory in the footer
 *
 * @package WordPress
 * @subpackage Total
 * @since Total 1.33
*/


// Setup core Framework
if ( !function_exists( 'wpex_display_queries_memory' ) ) {
	function wpex_display_queries_memory() {
		if ( ! wpex_supports( 'helpers', 'display_queries_memory' ) ) {
			return;
		} else { ?>
			<div style="text-align:center;padding:10px;background:#F73936;color:#fff;">
				<?php echo get_num_queries() ?> queries.
				<?php if ( function_exists( 'memory_get_usage' ) ) {
					$unit=array('b','kb','mb','gb','tb','pb');
					echo @round(memory_get_usage(true)/pow(1024,($i=floor(log(memory_get_usage(true),1024)))),2).' '.$unit[$i]; ?> Memory usage.
				<?php } ?>
				<?php timer_stop(1) ?> seconds.
			</div>
		<?php }
	}
}
add_filter( 'wp_head', 'wpex_display_queries_memory' );
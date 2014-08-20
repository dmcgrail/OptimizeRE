<?php
/**
 * Used for your staff entries
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Counter for clearing floats and margins
if ( !isset( $wpex_related_query ) ) {
	global $wpex_count;
	$query = 'archive';
} else {
	$query = 'related';
} ?>

<article id="#post-<?php the_ID(); ?>" class="staff-entry col <?php echo wpex_staff_column_class( $query ); ?> col-<?php echo $wpex_count; ?>">
	<?php
	// Displays the entry Media
	// @ functions/portfolio/portfolio-entry.php
	wpex_staff_entry_media();
	// Displays entry details
	// @ functions/portfolio/portfolio-entry.php
	wpex_staff_entry_content(); ?>
</article><!-- .staff-entry -->
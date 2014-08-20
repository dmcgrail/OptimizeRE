<?php
/**
 * Used for your portfolio entries
 * See single-portfolio.php for single post layout
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

<article id="#post-<?php the_ID(); ?>" class="portfolio-entry col <?php echo wpex_portfolio_column_class( $query ); ?> col-<?php echo $wpex_count; ?>">
	<?php
	// Displays the entry Media
	wpex_portfolio_entry_media();
	// Displays entry details
	wpex_portfolio_entry_content(); ?>
</article><!-- .portfolio-entry -->
<?php
/**
 * This file is used for your search result entries
 *
 * @package Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link  http://www.wpexplorer.com
 * @since Total 1.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add classes to the post_class
$search_entry_classes = array();
$search_entry_classes[] = 'search-entry';
$search_entry_classes[] = 'clr';
if( !has_post_thumbnail () ) {
	$search_entry_classes[] = 'search-entry-no-thumb';
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $search_entry_classes ); ?>>
	<?php
	// Display thumbnail if one is set
	if( has_post_thumbnail() ) {
		// Get cropped featured image
		$wpex_image = wpex_image( 'array' ); ?>
		<div class="search-entry-thumb">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" class="search-entry-img-link">
				<img src="<?php echo $wpex_image['url']; ?>" alt="<?php echo the_title(); ?>" width="<?php echo $wpex_image['width']; ?>" height="<?php echo $wpex_image['height']; ?>" />
			</a>
		</div><!-- .search-entry-thumb -->
	<?php } ?>
	<div class="search-entry-text">
		<header>
			<h2><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
		</header>
		<?php
		// Custom excerpt function - see functions/excerpts.php
		wpex_excerpt( '30', false ); ?>
	</div><!-- .search-entry-text -->
</article><!-- .entry -->
<?php

/**
 * Used for your quote format posts
 * The entries and the posts have the same design/layout
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
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-quote-entry-inner clr">
		<span class="fa fa-quote-right"></span>
		<?php
		// Content for single posts
		if ( is_singular( 'post' ) ) { ?>
			<div class="quote-entry-content clr">
				<?php the_content(); ?>
			</div><!-- .quote-entry-content -->
		<?php } else {
			// Content for entries ?>
			<div class="quote-entry-content clr">
				<?php the_content(); ?>
			</div><!-- .quote-entry-content -->
		<?php } ?>
		<div class="quote-entry-author clr">
			<?php the_title(); ?>
		</div><!-- .quote-entry-author -->
		</div><!-- .post-quote-entry-inner -->
</article><!-- .blog-entry -->
<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */

if ( wpex_option( 'error_page_redirect' ) ) {
	wp_redirect( home_url(), 301 ); exit;
}

get_header(); ?>
	
	<div class="container clr">
		<section id="primary" class="content-area full-width clr">
			<div id="content" class="clr site-content" role="main">
				<div class="entry clr <?php if ( wpex_option( 'error_page_styling' ) ) echo 'error404-content'; ?>">
					<?php if ( wpex_option( 'error_page_text' ) ) { ?>
						<?php echo apply_filters( 'the_content', wpex_option( 'error_page_text' ) ); ?>
					<?php } else { ?>
						<h1><?php _e( 'You Broke The Internet!', 'wpex' ) ?></h1>
						<p><?php _e( 'We are just kidding...but sorry the page you were looking for can not be found.', 'wpex' ); ?></p>
					<?php } ?>
				</div><!-- .entry -->
			</div><!-- #content -->
		</section><!-- #primary -->
	</div><!-- .container -->
	
<?php get_footer(); ?>
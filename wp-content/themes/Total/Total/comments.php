 <?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments and the comment
 * form. The actual display of comments is handled by a callback to
 * wpex_comment() which is located at functions/comments-callback.php
 *
 * @package	Total
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 * @since Total 1.0
 */


if ( post_password_required() || get_post_meta( get_the_ID(), 'wpex_post_layout', true ) == 'full-screen' ) {
	return;
} ?>

<section id="comments" class="comments-area <?php if ( ! comments_open() && get_comments_number() < 1 ) echo 'empty-closed-comments'; ?>">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			// Display Comments Title
			$comments_number = number_format_i18n( get_comments_number() );
			if ( '1' == $comments_number ) {
				$comments_title = __( 'This Post Has One Comment', 'wpex' );
			} else {
				$comments_title = sprintf( __( 'This Post Has %s Comments', 'wpex' ), $comments_number );
			}
			$comments_title = apply_filters( 'wpex_comments_title', $comments_title );
			echo $comments_title; ?>
		</h2>
		<ol class="comment-list">
			<?php wp_list_comments( array( 'callback' => 'wpex_comment', 'style' => 'ol' ) ); ?>
		</ol><!-- .comment-list -->
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
			<nav class="navigation comment-navigation row clr" role="navigation">
				<h4 class="assistive-text section-heading heading"><span><?php _e( 'Comment navigation', 'wpex' ); ?></span></h4>
				<div class="nav-previous span_12 col clr-margin"><?php previous_comments_link( __( '&larr; Older Comments', 'wpex' ) ); ?></div>
				<div class="nav-next span_12 col"><?php next_comments_link( __( 'Newer Comments &rarr;', 'wpex' ) ); ?></div>
			</nav>
		<?php } // Check for comment navigation ?>
		<?php if ( ! comments_open() && get_comments_number() ) { ?>
			<p class="no-comments"><i class="icon-remove-circle"></i><?php _e( 'Comments are closed.' , 'wpex' ); ?></p>
		<?php } ?>
	<?php endif; // have_comments() ?>
	<?php comment_form(); ?>
</section><!-- #comments -->
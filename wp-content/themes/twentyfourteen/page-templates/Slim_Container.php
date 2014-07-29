<?php
/*
Template Name: Slim Container
the_content();
*/
?>

<!DOCTYPE HTML>
<html>
<head>
	<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">
		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>


	    <style type="text/css">
	        html, body {
	             height: 100%;
	             margin: 0pt;
	        }
	        body{
	        	background-image:url('<?php bloginfo('template_url'); ?>/images/clouds_large_paddingtopbottom.png');
	        }
			.boxCenter{
				width:35%;
				min-width:500px;
				min-height:30%;
				padding:25px;
				display:block;
				margin: 50px auto;
				border: 3px solid #559AD4;
				border-radius:25px;
				background-color:white;	
			}
	    </style>
	</head>

	<body>
			<div class="boxCenter" >
				<div class="boxContent">
					<div id="primary" class="site-content">
						<div id="content" role="main">
				
							<?php while ( have_posts() ) : the_post(); ?>
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="entry-page-image">
										<?php the_post_thumbnail(); ?>
									</div><!-- .entry-page-image -->
								<?php endif; ?>
				
								<?php get_template_part( 'content', 'page' ); ?>
				
							<?php endwhile; // end of the loop. ?>
				
						</div><!-- #content -->
					</div><!-- #primary -->	
				</div>
			</div>
	</body>
</html>
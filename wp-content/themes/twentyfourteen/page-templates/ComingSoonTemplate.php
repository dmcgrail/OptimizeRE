<?php
/*
Template Name: Coming_Soon
*/
?>



<html>


	<body>
		Coming soon 2.
		<img src="<?php background_image(); ?>" style="width:100px;height:500px;"/>
		<div style="color:<?php background_color(); ?>">
		</div>
		
		'<?php background_image(); ?>'
		color: '<?php background_color(); ?>'
		
		'<?php echo $page_bg_image_url ?>'
		
	</body>
	
	<style type="text/css">
	    body {
		    background-color:#'<?php background-color(); ?>' ;
			background-image: url('<?php background-image(); ?>');
	    }
    </style>

</html>
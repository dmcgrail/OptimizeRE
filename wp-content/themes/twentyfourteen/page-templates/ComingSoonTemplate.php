<?php
/*
Template Name: Coming_Soon
*/
$page_bg_image_url = get_background_image();
?>

<html>
	<body>
		Coming soon 1.
		<img src="<?php background_image(); ?>" style="width:100px;height:500px;"/>
		<div style="color:<?php background_color(); ?>">
		</div>
		
		'<?php background_image(); ?>'
		color: '<?php background_color(); ?>'
		
		'<?php echo $page_bg_image_url ?>'
		
	</body>
	

</html>

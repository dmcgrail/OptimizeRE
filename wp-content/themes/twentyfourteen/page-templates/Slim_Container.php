<?php
/*
Template Name: Slim Container
*/
?>

<!DOCTYPE HTML>
<html>
<head>
	<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">
		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>
	<link href='file:///C:/Users/dmcgrail/Desktop/bootstraptheme/css/bootstrap.css' rel='stylesheet' type='text/css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		
	<script>
		var j$ = jQuery.noConflict();
		j$(document).ready(function(){
			j$('#leadForm').hide();
			j$('#betaButton').click(function(){
				j$('#leadForm').show();
				j$(this).hide();
			});
		});
	</script>

	    <style type="text/css">
	        html, body {
	             height: 100%;
	             margin: 0pt;
	        }
			body{
				background-image: url('file:///C:Users/dmcgrail/Desktop/clouds_large_paddingtopbottom.png');
						
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

	<body class="Frame">
	    <section class="Row Expand">
			<div class="boxCenter" >
				<div class="boxContent">
					
				</div>
			</div>
		</section>
	</body>
</html>
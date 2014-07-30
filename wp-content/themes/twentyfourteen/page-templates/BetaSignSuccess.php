<?php
/*
Template Name: Coming_Soon
*/
?>

<!DOCTYPE HTML>
<html>
<head>
	<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">
		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>
	<link href='<?php bloginfo('template_url'); ?>/css/bootstrap.css' rel='stylesheet' type='text/css'>
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
			background-image: url('<?php bloginfo('template_url'); ?>/images/clouds_large_paddingtopbottom.png');
					
		}
        .Frame {
             display: table;
             height: 100%;
             width: 100%;
        }
        .Row {
             display: table-row;
             height: 1px;
        }
        .Row.Expand {
			 height:100%;
        }
		.phraseLite{
			color:#2278A8;
			font-family: 'Source Sans Pro',sans-serif; 
			font-weight: 100; 
			font-size:48px;
		}
		.phraseHeavy{
			color:#2278A8;
			font-family: 'Source Sans Pro',sans-serif; 
			font-weight: 700; 
			font-size:48px;
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
		.bodyCopy{ 
			color:#4D4D4D;
			font-family: 'Source Sans Pro', sans-serif;
			font-style: normal;
			font-weight: 500;
			font-size:18px;
			padding:20px 0px;
			width:475px;
			margin:auto;
		}
		.formElement{display:inline-block;margin-bottom:2px;width:50%;float:right;}
    </style>
</head>
<body class="Frame">
    <section class="Row Expand">
    	<div class="boxCenter" >
			<div class="boxContent">
				<div>
					<p style="margin: 20px auto;text-align:center;" ><span class="phraseLite">Real estate made </span><span class="phraseHeavy" style="margin-left:5px;">simple.</span></p>
					<p class="bodyCopy">Thank you for signing up! Someone will contact you shortly for more information"</p>
				</div>
			</div>
		</div>
	</section>
    <footer class="Row">
		<img src='<?php bloginfo('template_url'); ?>/images/bottom_noback.png' style="width:100%;"/>
	</footer>
</body>
</html>
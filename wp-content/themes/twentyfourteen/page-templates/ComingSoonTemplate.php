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
	<link href='<?php bloginfo('template_url'); ?>/css/bootstrap.css' type='text/css'>
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
					<p class="bodyCopy">Let OptimizeRE CRM help you take your residential real estate business to the next level.</p>
					<p class="bodyCopy" style="text-align:center;font-style:italic;margin-top:20px;">Coming September 2014!</p>
					<p style="text-align:center;">
						<img id="betaButton" src="http://dabuttonfactory.com/b.png?t=Join%20Beta%20Group&f=sans-serif&ts=24&tc=ffffff&tshs=1&tshc=ff4800&it=png&c=5&bgt=unicolored&bgc=ff6f22&bs=1&bc=ffa340&hp=20&vp=18" />
					</p>
				</div>
				<div id="leadForm" style="width:75%;margin:auto;text-align:center;" >
					<!--  ----------------------------------------------------------------------  -->
						<!--  NOTE: Please add the following <META> element to your page <HEAD>.      -->
						<!--  If necessary, please modify the charset parameter to specify the        -->
						<!--  character set of your HTML page.                                        -->
						<!--  ----------------------------------------------------------------------  -->

									

						<!--  ----------------------------------------------------------------------  -->
						<!--  NOTE: Please add the following <FORM> element to your page.             -->
						<!--  ----------------------------------------------------------------------  -->

						<form action="https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8" method="POST">

						<input type=hidden name="oid" value="00DF00000007jUF">
						<input type=hidden name="retURL" value="http://www.optimizerecrm.com">

						<!--  ----------------------------------------------------------------------  -->
						<!--  NOTE: These fields are optional debugging elements. Please uncomment    -->
						<!--  these lines if you wish to test in debug mode.                          -->
						<!--  <input type="hidden" name="debug" value=1>                              -->
						<!--  <input type="hidden" name="debugEmail"                                  -->
						<!--  value="nancy@optimizerecrm.com">                                        -->
						<!--  ----------------------------------------------------------------------  -->
							<div style="text-align:left;">
								<p><label for="first_name">First Name</label><input  id="first_name" maxlength="40" name="first_name" size="20" type="text" class="form-control input-sm formElement" required="true" /></p>
								<p><label for="last_name">Last Name</label><input  id="last_name" maxlength="80" name="last_name" size="20" type="text"  class="form-control input-sm formElement" required="true"/></p>
								<p><label for="email">Email</label><input  id="email" maxlength="80" name="email" size="20" type="text" class="form-control input-sm formElement" required="true" required="true"/></p>
								<p><label for="company">Brokerage</label><input  id="company" maxlength="40" name="company" size="20" type="text"  class="form-control input-sm formElement" required="true"/></p>
								<p><label for="phone">Phone</label><input  id="phone" maxlength="40" name="phone" size="20" type="text" class="form-control input-sm formElement" require="true"/></p>
								<p><label for="city">City</label><input  id="city" maxlength="40" name="city" size="20" type="text" class="form-control input-sm formElement" /></p>
								<p><label for="state">State/Province</label><input  id="state" maxlength="20" name="state" size="20" type="text" class="form-control input-sm formElement" /></p>
							</div>
							<br/>
							<input type="submit" name="submit" class="btn btn-info" >
							

						</form>
				</div>
			</div>
		</div>
	</section>
    <footer class="Row">
		<img src="<?php bloginfo('template_url'); ?>/images/bottom_noback.png" style="width:100%;'/>
	</footer>
</body>
</html>
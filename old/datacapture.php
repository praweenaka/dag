<?php session_start(); 

if ($_SESSION["dev"]!=""){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="imagetoolbar" content="no" />
<title>Data Capture</title>
<link media="screen" rel="stylesheet" type="text/css" href="css/admin.css"  />
<!--[if lte IE 6]><link media="screen" rel="stylesheet" type="text/css" href="css/admin-ie.css" /><![endif]-->
<script type="text/javascript" src="js/css.js"></script>
<script type="text/javascript" src="js/behaviour.js"></script>
</head>

<body>
	<!--[if !IE]>start wrapper<![endif]-->
	<div id="wrapper">
		<!--[if !IE]>start head<![endif]-->
		<div id="head">
			
			<!--[if !IE]>start logo and user details<![endif]-->
		 
							<!--[if !IE]>start user details<![endif]--><!--[if !IE]>end user details<![endif]-->
				
			 
				
		 
			
			<!--[if !IE]>end logo end user details<![endif]-->
			
			
			
			<!--[if !IE]>start menus_wrapper<![endif]-->
			<?php
				include('menu_datacapture.php');
			?>
			<!--[if !IE]>end menus_wrapper<![endif]-->
			
			
			
		</div>
		<!--[if !IE]>end head<![endif]-->
		
		<!--[if !IE]>start content<![endif]-->
		<div id="content">
			
			
			
			
			
			<!--[if !IE]>start page<![endif]-->
		  <!--[if !IE]>end page<![endif]-->
		  <!--[if !IE]>start sidebar<![endif]-->
		  <!--[if !IE]>end sidebar<![endif]-->
	  </div>
	  <!--[if !IE]>end content<![endif]-->
		
	</div>
	<!--[if !IE]>end wrapper<![endif]-->
	
	<!--[if !IE]>start footer<![endif]-->
	<div id="footer">
	</div>
	<!--[if !IE]>end footer<![endif]-->
	
</body>
</html>
<?php
} else {
	echo "Invalied User !!!"; 
}
?>
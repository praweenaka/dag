<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="imagetoolbar" content="no" />
<title>Administration Panel</title>
<link media="screen" rel="stylesheet" type="text/css" href="css/admin-login.css"  />
<!--[if lte IE 6]><link media="screen" rel="stylesheet" type="text/css" href="css/admin-login-ie.css" /><![endif]-->

<script src="js/user.js"></script>

</head>

<body>
	<!--[if !IE]>start wrapper<![endif]-->
	<div id="wrapper">
		
		
		
		
		<!--[if !IE]>start login wrapper<![endif]-->
		<div id="login_wrapper">
			
			
		
			
			
			
			<!--[if !IE]>start login<![endif]-->
			<form >
				<fieldset>
					
					
					
					
					
					<h1 id="logo"></h1>
					<div class="formular">
						<div class="formular_inner">
						<?php
						require_once("connectioni.php");
				
				
						?>
						<label>
						  <strong>Normal:</strong>
                          <?php
						  $sql_master= "select * from invpara";
    					  $result_master =mysqli_query($GLOBALS['dbinv'],$sql_master);
						  $row_master = mysqli_fetch_array($result_master);
						
						if ($row_master["master_dev"]=="0"){
						  echo "<input type=\"radio\" name=\"radio\" id=\"normal\" value=\"normal\" checked=\"checked\" onclick=\"setdiv();\"/>";
						} else {
							echo "<input type=\"radio\" name=\"radio\" id=\"normal\" value=\"normal\" onclick=\"setdiv();\"/>";
						}  ?>
						</label>
						<label><br />
						<br />
						  <strong>Active:
                          <?php
						  	if ($row_master["master_dev"]=="1"){
						  echo "<input type=\"radio\" name=\"radio\" id=\"activ\" value=\"activ\" checked=\"checked\" onclick=\"setdiv();\"/>";
						} else {
							echo "<input type=\"radio\" name=\"radio\" id=\"activ\" value=\"activ\" onclick=\"setdiv();\"/>";
						} 
						
						?>
						  </strong></label>
						
					<div id="txterror" class="tyre_login_error"></div>
						
						</div>
				</div>
				</fieldset>
			</form>
			<!--[if !IE]>end login<![endif]-->
		</div>
		<!--[if !IE]>end login wrapper<![endif]-->
	</div>
	<!--[if !IE]>end wrapper<![endif]-->
</body>
</html>

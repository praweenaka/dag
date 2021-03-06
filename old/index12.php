<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="imagetoolbar" content="no" />
<title>Administration Panel</title>
<link media="screen" rel="stylesheet" type="text/css" href="css/admin-login.css"  />
<!--[if lte IE 6]><link media="screen" rel="stylesheet" type="text/css" href="css/admin-login-ie.css" /><![endif]-->
<?php

//ini_set("max_connections_per_hour", 0);

include('connection.php');
mysql_close($dbinv);
?>

<script src="js/user.js"></script>

</head>

<body>
	<!--[if !IE]>start wrapper<![endif]-->
	<div id="wrapper"e>
		
		
		
		
		<!--[if !IE]>start login wrapper<![endif]-->
		<div id="login_wrapper">
			
			
		
			
			
			
			<!--[if !IE]>start login<![endif]-->
			<form >
				<fieldset>
					
					
					
					
					
					<h1 id="logo"><a href="#"></a></h1>
					<div class="formular">
						<div class="formular_inner">
						
						<label>
							<strong>Username:</strong>
							<span class="input_wrapper">
								<input name="txtUserName" type="text" id="txtUserName" onkeypress="keyset('txtPassword', event)"  />
							</span>
						</label>
						<label>
							<strong>Password:</strong>
							<span class="input_wrapper">
								<input name="txtPassword" type="password" id="txtPassword" onkeypress="keyset('btn', event)"/>
							</span>
						</label>
						
					<div id="txterror" class="tyre_login_error"></div>
						
						<ul class="form_menu">
							<li><span class="button"><span><span>Login</span></span><input type="button" name="btn" id="btn" onclick="IsValiedData();"/></span></li>
							
							<!--<li><a href="#"><span><span>Forgot Pass</span></span></a></li>-->
						</ul>
						
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

<?php session_start(); ?>
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
			<div id="logo_user_details">
				<h1 id="logo"><img src="images/tyres.png" alt="" width="218" height="165" />	 </h1>
                
                <div class="tyrename">Tyre House Management System</div>
							<!--[if !IE]>start user details<![endif]--><!--[if !IE]>end user details<![endif]-->
				
				
				
			</div>
			
			<!--[if !IE]>end logo end user details<![endif]-->
			
			
			
			<!--[if !IE]>start menus_wrapper<![endif]-->
			<?php
				include('menu_reports.php');
			?>
			<!--[if !IE]>end menus_wrapper<![endif]-->
			
			
			
		</div>
		<!--[if !IE]>end head<![endif]-->
		
		<!--[if !IE]>start content<![endif]-->
		<div id="content">
			
			
			<!--[if !IE]>start section<![endif]-->	
					<div class="section">
						<!--[if !IE]>start title wrapper<![endif]-->
						<div class="title_wrapper">
							<h2>Dashboard</h2>
							<span class="title_wrapper_left"></span>
							<span class="title_wrapper_right"></span>
						</div>
						<!--[if !IE]>end title wrapper<![endif]-->
						<!--[if !IE]>start section content<![endif]-->
						<div class="section_content">
							<!--[if !IE]>start section content top<![endif]-->
							<div class="sct">
								<div class="sct_left">
									<div class="sct_right">
										<div class="sct_left">
											<div class="sct_right">
												<!--[if !IE]>start dashboard menu<![endif]-->
												<ul class="dashboard_menu">
													<li><a href="#" class="d1"><span>User Management Tools</span></a></li>
													
										      <li><a href="#" class="d3"><span>Manage photo galleries</span></a></li>
													<li><a href="#" class="d4"><span>Change site templates</span></a></li>
													<li><a href="#" class="d5"><span>SEO Tools and Settings</span></a></li>
													<li><a href="#" class="d6"><span>Email Settings and Templates</span></a></li>
													<li><a href="#" class="d7"><span>Homepage and Static Pages</span></a></li>
													<li><a href="#" class="d8"><span>Website Security Settings</span></a></li>
													<li><a href="#" class="d9"><span>Printable Pages Template</span></a></li>
													<li><a href="#" class="d10"><span>Date and Time Setup</span></a></li>
													<li><a href="#" class="d11"><span>Favorires Settings</span></a></li>
													<li><a href="#" class="d12"><span>Statistics and Graphs</span></a></li>
												</ul>
												<!--[if !IE]>end dashboard menu<![endif]-->
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--[if !IE]>end section content top<![endif]-->
							<!--[if !IE]>start section content bottom<![endif]-->
							<span class="scb"><span class="scb_left"></span><span class="scb_right"></span></span>
							<!--[if !IE]>end section content bottom<![endif]-->
							
						</div>
						<!--[if !IE]>end section content<![endif]-->
					</div>
			
			
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

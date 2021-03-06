<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="imagetoolbar" content="no" />
<title>Administration Panel</title>
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
				include('menu_index.php');
			?>
			<!--[if !IE]>end menus_wrapper<![endif]-->
			
			
			
		</div>
		<!--[if !IE]>end head<![endif]-->
		
		<!--[if !IE]>start content<![endif]-->
		<div id="content">
			
			
			
			
			
			<!--[if !IE]>start page<![endif]-->
			<div id="page">
				<div class="inner">
					
					
					
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
					<!--[if !IE]>end section<![endif]-->
					
					
					<!--[if !IE]>start section<![endif]-->	
					
					
					
					
					<!--[if !IE]>start section<![endif]-->	
					<div class="section">
						<!--[if !IE]>start title wrapper<![endif]-->
						<div class="title_wrapper">
							<h2>Forms Template</h2>
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
										
												
												
												<!--[if !IE]>start forms<![endif]-->
												<form action="#" class="search_form general_form">
													<!--[if !IE]>start fieldset<![endif]-->
													<fieldset>
														<!--[if !IE]>start forms<![endif]-->
														<div class="forms">
														
														
														
														<!--[if !IE]>start row<![endif]-->
														<div class="row">
															<label>Text Box</label>
															<div class="inputs">
															<input class="text" name="" type="text" /></div>
														</div>
														<!--[if !IE]>end row<![endif]-->
														
														<!--[if !IE]>start row<![endif]-->
														<div class="row"></div>
														<!--[if !IE]>end row<![endif]-->
														
														<!--[if !IE]>start row<![endif]-->
														<div class="row">
															<label>Vertical radio:</label>
															<div class="inputs">
																<ul class="inline">
																	<li> <input class="radio" name="" value="" type="radio" /> all orders</li>
																	<li><input class="radio" name="" value="" type="radio" /> pending</li>
																	<li><input class="radio" name="" value="" type="radio" /> unshipped</li>
																	<li><input class="radio" name="" value="" type="radio" /> shipped</li>
																</ul>
																
																<ul class="inline">
																	<li><input class="checkbox" name="" value="" type="checkbox" /> all orders</li>
																	<li><input class="checkbox" name="" value="" type="checkbox" /> pending</li>
																	<li><input class="checkbox" name="" value="" type="checkbox" /> unshipped</li>
																	<li><input class="checkbox" name="" value="" type="checkbox" /> shipped</li>
																</ul>
																
															</div>
														</div>
														<!--[if !IE]>end row<![endif]-->
														
														
														<!--[if !IE]>start row<![endif]-->
														<div class="row"></div>
														<!--[if !IE]>end row<![endif]-->
														
														
														<!--[if !IE]>start row<![endif]-->
														<div class="row">
															<label>City:</label>
															<div class="inputs">
																<span class="input_wrapper blank">
																	<select>
																		<option>Washington</option>
																		<option>Washington</option>
																		<option>Washington</option>
																		<option>Washington</option>
																		<option>Washington</option>
																	</select>
																</span>
															</div>
														</div>
														<!--[if !IE]>end row<![endif]-->
														
														
														<!--[if !IE]>start row<![endif]-->
														<div class="row"></div>
														<!--[if !IE]>end row<![endif]-->
														
														<!--[if !IE]>start row<![endif]-->
														<div class="row"></div>
														<!--[if !IE]>end row<![endif]-->
														
														
														
														
														<!--[if !IE]>start row<![endif]-->
														<div class="row">
															<div class="buttons">
																
																
																<ul>
																	<li><span class="button send_form_btn"><span><span>SEND FORM</span></span><input name="" type="submit" /></span></li>
																	<li><span class="button cancel_btn"><span><span>CANCEL</span></span><input name="" type="submit" /></span></li>
																</ul>
																
																<ul>
																	<li><span class="button orange_btn"><span><span>ORANGE</span></span><input name="" type="submit" /></span></li>
																	<li><span class="button red_btn"><span><span>RED</span></span><input name="" type="submit" /></span></li>
																</ul>
																
																
																<ul>
																	<li><span class="button grey_btn"><span><span>GREY</span></span><input name="" type="submit" /></span></li>
																	<li><span class="button light_blue_btn"><span><span>LIGHT BLUE</span></span><input name="" type="submit" /></span> </li>
																</ul>
																
																
																
																
																       
															</div>
														</div>
														<!--[if !IE]>end row<![endif]-->
														
														
														
														</div>
														<!--[if !IE]>end forms<![endif]-->
														
													</fieldset>
													<!--[if !IE]>end fieldset<![endif]-->
													
													
													
													
												</form>
												<!--[if !IE]>end forms<![endif]-->	
												
												<!--[if !IE]>start system messages<![endif]-->												<!--[if !IE]>end system messages<![endif]-->
														
												
												
												
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
					<!--[if !IE]>end section<![endif]-->
					
					
					
					
					<!--[if !IE]>start section<![endif]-->	
					
					
					
					
						
				</div>
			</div>
			<!--[if !IE]>end page<![endif]-->
			<!--[if !IE]>start sidebar<![endif]--><!--[if !IE]>end sidebar<![endif]-->
			
			
			
			
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

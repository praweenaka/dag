
<style type="text/css">
#display_selected a {
	color:#000;
}

#display_notSelected a{
	color:#fff;
}




</style>
<?php
require_once("connectioni.php");
	
	
?>
<script src="js/user.js"></script>
<div id="menus_wrapper">
				
				
				
				
				
				<div id="main_menu">
					<ul>
										<li><a href="home.php"><span><span>Home</span></span></a></li>
                        <?php
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Maintenance' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						
						if ($row = mysqli_fetch_array($result)){
							echo "<li><a href=\"masterfiles_acc.php\"  ><span><span>Maintenance</span></span></a></li>";
						}
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Task' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){
                        	echo "<li><a href=\"datacapture_acc.php\"><span><span>Task</span></span></a></li>";
						}	
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Final Account' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){
							echo "<li><a href=\"#\"><span><span>Final Account</span></span></a></li>";
						}	
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Reports' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){
							echo "<li><a href=\"reports.php\"><span><span>Reports</span></span></a></li>";
						}	
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Administration' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){
							echo "<li><a href=\"administration.php\" class=\"selected\"><span><span>Administration</span></span></a></li>";
						}
						?>	
                        <li class="last" onclick="logout();"><a href="#"><span><span>Logout</span></span></a></li>
					</ul>
				</div>
				
				
				
				<div id="sec_menu">
					<ul>
                    	<?php
                    	$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Create User' and grp='Administration' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){
							echo "<li><a href=\"create_user.php\" target=\"_blank\" class=\"sm1\" >Create User</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Change Password' and grp='Administration' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){	
                        	echo "<li><a href=\"change_pass.php\" target=\"_blank\" class=\"sm1\" >Change Password</a></li>";
						}	
                        
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Manage Permission' and grp='Administration' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){	
							echo "<li><a href=\"assign_privilages.php\" target=\"_blank\" class=\"sm1\" >Manage Permission</a></li>";
						}	
	
                      ?> 
                       
					</ul>
				</div>
			</div>
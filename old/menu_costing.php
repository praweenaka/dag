
<style type="text/css">
#display_selected a {
	color:#000;
}

#display_notSelected a{
	color:#fff;
}




</style>
<script src="js/user.js"></script>
<?php
require_once("connectioni.php");
	
	
?>
<div id="menus_wrapper">
				
				
				
				
				
				<div id="main_menu">
					<ul>
									<li><a href="home.php"><span><span>Home</span></span></a></li>
                        <?php
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Master Files' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						
						if ($row = mysqli_fetch_array($result)){
							echo "<li><a href=\"masterfiles.php\" ><span><span>Master Files</span></span></a></li>";
						}
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Data Capture' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){
                        	echo "<li><a href=\"datacapture.php\"><span><span>Data Capture</span></span></a></li>";
						}	
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Costing' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){
							echo "<li><a href=\"costing.php\" class=\"selected\"><span><span>Costing</span></span></a></li>";
						}	
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Inquiries' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){
							echo "<li><a href=\"inquiry.php\"  ><span><span>Inquiries</span></span></a></li>";
						}	
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Analysis' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){
							echo "<li><a href=\"#\"><span><span>Analysis</span></span></a></li>";
						}
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Delivery' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){	
                        	echo "<li><a href=\"#\"><span><span>Delivery</span></span></a></li>";
						}	
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and (grp='Reports-Sales' or grp='Reports-Customer' or grp='Reports-Other' or grp='Reports-Stock') and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){	
                        	echo "<li><a href=\"reports.php\"><span><span>Reports</span></span></a></li>";
						}
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='System Utilities' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){		
							echo "<li><a href=\"utility.php\"><span><span>System Utilities</span></span></a></li>";
						}
						
				// 		$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Stores' and doc_view=1";
				// 		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
				// 		if ($row = mysqli_fetch_array($result)){			
    //                     	echo "<li><a href=\"stores.php\"><span><span>Stores</span></span></a></li>";
				// 		}
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Administration' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){				
                         	echo "<li><a href=\"administration.php\"><span><span>Administration</span></span></a></li>";
						}
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Inventory' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){				
                         	echo "<li><a href=\"Inventory.php\"><span><span>Inventory</span></span></a></li>";
						}
						?>	
                        <li class="last" onclick="logout();"><a href="#"><span><span>Logout</span></span></a></li>
					</ul>
				</div>
				
				
				
				<div id="sec_menu">
					<ul>
                    <?php
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."'  and grp='Costing' and doc_view=1 and block='0'";
						$result =mysqli_query($GLOBALS['dbinv'],$sql); 	
						if ($row = mysqli_fetch_array($result)){	
							echo "<li><a href=\"order_form.php\" target=\"_blank\" class=\"sm1\" >Order Form</a></li>";
						}
                    ?>
                       
					</ul>
				</div>
			</div>
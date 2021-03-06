
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
                        	echo "<li><a href=\"datacapture_acc.php\" class=\"selected\"><span><span>Task</span></span></a></li>";
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
							echo "<li><a href=\"administration.php\" ><span><span>Administration</span></span></a></li>";
						}
						
						?>	
                        <li class="last" onclick="logout();"><a href="#"><span><span>Logout</span></span></a></li>
					</ul>
				</div>
				
				
				
				<div id="sec_menu">
					<ul>
                    	<?php
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Cash Reciept' and grp='Task' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){
							echo "<li><a href=\"cash_reciept_acc.php\" target=\"_blank\" class=\"sm1\" >Cash Reciept</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Cash Pay' and grp='Task' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){	
							echo "<li><a href=\"cash_pay_acc.php\" target=\"_blank\" class=\"sm2\" >Cash Pay</a></li>";
						}	
                        
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Cheque Pay' and grp='Task' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){	
							echo "<li><a href=\"cheque_pay_acc.php\" target=\"_blank\" class=\"sm2\" >Cheque Pay</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Cheque Setup' and grp='Task' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){	
							echo "<li><a href=\"\" target=\"_blank\" class=\"sm2\" >Cheque Setup</a></li>";
						}	
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Reciept Entry' and grp='Task' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){
							echo "<li><a href=\"rec_acc.php\" target=\"_blank\" class=\"sm4\">Reciept Entry</a></li>";
						}	
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Journal Entries' and grp='Task' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){
							echo "<li><a href=\"journal_acc.php\" target=\"_blank\" class=\"sm5\">Journal Entries</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Bank Deposited' and grp='Task' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){	
							echo "<li><a href=\"bankdepo_acc.php\" target=\"_blank\" class=\"sm6\">Bank Deposited</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Bank Transaction' and grp='Task' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){	
							echo "<li><a href=\"bank_transaction_acc.php\" target=\"_blank\" class=\"sm7\">Bank Transaction</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Bank Reconsilation' and grp='Task' and doc_view=1";
						$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	
						if ($row = mysqli_fetch_array($result)){	
                        	echo "<li><a href=\"bank_recons_acc.php\" target=\"_blank\" class=\"sm7\">Bank Reconsilation</a></li>";
						}
						
						?>
					</ul>
				</div>
			</div>
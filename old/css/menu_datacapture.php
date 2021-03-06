
<style type="text/css">
#display_selected a {
	color:#000;
}

#display_notSelected a{
	color:#fff;
}




</style>
<?php
require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
?>
<script src="js/user.js"></script>
<div id="menus_wrapper">
				
				
				
				
				
				<div id="main_menu">
					<ul>
										<li><a href="home.php"><span><span>Home</span></span></a></li>
                        <?php
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Master Files' and doc_view=1";
						$result =$db->RunQuery($sql);	
						
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"masterfiles.php\"  ><span><span>Master Files</span></span></a></li>";
						}
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Data Capture' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
                        	echo "<li><a href=\"datacapture.php\" class=\"selected\"><span><span>Data Capture</span></span></a></li>";
						}	
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Costing' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"#\"><span><span>Costing</span></span></a></li>";
						}	
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Inquiries' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"inquiry.php\"><span><span>Inquiries</span></span></a></li>";
						}	
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Analysis' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"#\"><span><span>Analysis</span></span></a></li>";
						}
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Delivery' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){	
                        	echo "<li><a href=\"#\"><span><span>Delivery</span></span></a></li>";
						}	
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and (grp='Reports-Sales' or grp='Reports-Customer' or grp='Reports-Other' or grp='Reports-Stock') and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){	
                        	echo "<li><a href=\"reports.php\"><span><span>Reports</span></span></a></li>";
						}
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='System Utilities' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){		
							echo "<li><a href=\"utility.php\"><span><span>System Utilities</span></span></a></li>";
						}
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Stores' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){			
                        	echo "<li><a href=\"stores.php\"><span><span>Stores</span></span></a></li>";
						}
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Administration' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){				
                         	echo "<li><a href=\"administration.php\"><span><span>Administration</span></span></a></li>";
						}
						?>	
                        <li class="last" onclick="logout();"><a href="#"><span><span>Logout</span></span></a></li>
					</ul>
				</div>
				
				
				
				<div id="sec_menu">
					<ul>
                    	<?php
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Purchase Order' and grp='Data Capture' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"purchase_ord.php\" target=\"_blank\" class=\"sm1\" >Purchase Order</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='ARN' and grp='Data Capture' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){	
							echo "<li><a href=\"arn.php\" target=\"_blank\" class=\"sm2\" >ARN</a></li>";
						}	
                        
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='ARN2' and grp='Data Capture' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){	
							echo "<li><a href=\"arn2.php\" target=\"_blank\" class=\"sm2\" >ARN2</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='GIN' and grp='Data Capture' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){	
							echo "<li><a href=\"gin.php\" target=\"_blank\" class=\"sm2\" >GIN</a></li>";
						}	
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Marketing Executive Order' and grp='Data Capture' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"sales_ord.php\" target=\"_blank\" class=\"sm4\">Sales Order</a></li>";
						}	
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Sales Invoice' and grp='Data Capture' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"sales_inv.php\" target=\"_blank\" class=\"sm5\">Sales Invoice</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='GRN' and grp='Data Capture' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){	
							echo "<li><a href=\"grn.php\" target=\"_blank\" class=\"sm6\">GRN</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Cash Reciept' and grp='Data Capture' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){	
							echo "<li><a href=\"cash_reciept.php\" target=\"_blank\" class=\"sm7\">Cash Reciept</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Credit Note' and grp='Data Capture' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){	
                        	echo "<li><a href=\"crn.php\" target=\"_blank\" class=\"sm7\">Credit Note</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Purchase Return' and grp='Data Capture' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){	
                        	echo "<li><a href=\"purchase_ret.php\" target=\"_blank\" class=\"sm7\">Purchase Return</a></li>";
						}
						
						
                       ?>
						<li>
							<span class="drop"><span><span><a href="#" class="sm8">More</a></span></span></span>
							<ul>
                            	<?php
								
								$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Advance Payment' and grp='Data Capture' and doc_view=1";
								$result =$db->RunQuery($sql);	
								if ($row = mysql_fetch_array($result)){	
                        			echo "<li><a href=\"advance_payment.php\" target=\"_blank\" class=\"sm7\">Advance Payment</a></li>";
								}	
						
								$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Return Cheque Entry' and grp='Data Capture' and doc_view=1";
								$result =$db->RunQuery($sql);	
								if ($row = mysql_fetch_array($result)){
									echo "<li><a class=\"sm6\" href=\"ret_cheque_entry.php\" target=\"_blank\">Return Cheque Entry</a></li>";
								}
								
								$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Return Cheque Settlement' and grp='Data Capture' and doc_view=1";
								$result =$db->RunQuery($sql);	
								if ($row = mysql_fetch_array($result)){	
                                	echo "<li><a class=\"sm6\" href=\"ret_chq_settle.php\" target=\"_blank\">Return Cheque Settlement</a></li>";
								}
								
								$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Defective Items' and grp='Data Capture' and doc_view=1";
								$result =$db->RunQuery($sql);	
								if ($row = mysql_fetch_array($result)){	
									echo "<li><a class=\"sm6\" href=\"defective_item.php\" target=\"_blank\">Defective Items</a></li>";
								}
								
								$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Credit Note Auto' and grp='Data Capture' and doc_view=1";
								$result =$db->RunQuery($sql);	
								if ($row = mysql_fetch_array($result)){	
									echo "<li><a class=\"sm6\" href=\"credit_note_auto.php\" target=\"_blank\">Credit Note Auto</a></li>";
								}
								
								$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Item Claim' and grp='Data Capture' and doc_view=1";
								$result =$db->RunQuery($sql);	
								if ($row = mysql_fetch_array($result)){	
									echo "<li><a class=\"sm6\" href=\"item_claim.php\" target=\"_blank\">Item Claim </a></li>";
								}	
								
								$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Battery Claim' and grp='Data Capture' and doc_view=1";
								$result =$db->RunQuery($sql);	
								if ($row = mysql_fetch_array($result)){
                                	echo "<li><a class=\"sm6\" href=\"battery_claim.php\" target=\"_blank\">Battery Claim &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>";
								}
								
								$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Utilization' and grp='Data Capture' and doc_view=1";
								$result =$db->RunQuery($sql);	
								if ($row = mysql_fetch_array($result)){	
                                	echo "<li><a class=\"sm6\" href=\"utilization.php\" target=\"_blank\">Utilization</a></li>";
								}
								
								$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Weekly Order Planning' and grp='Data Capture' and doc_view=1";
								$result =$db->RunQuery($sql);	
								if ($row = mysql_fetch_array($result)){	
                                	echo "<li><a class=\"sm6\" href=\"customer_ord.php\" target=\"_blank\">Weekly Order Planning</a></li>";
								}	
                                
								$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='LC Order Rep Wise' and grp='Data Capture' and doc_view=1";
								$result =$db->RunQuery($sql);	
								if ($row = mysql_fetch_array($result)){
									echo "<li><a class=\"sm6\" href=\"purchase_ord_lc.php\" target=\"_blank\">LC Order Rep Wise</a></li>";
								}
								
								$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Over Limit Pendings' and grp='Data Capture' and doc_view=1";
								$result =$db->RunQuery($sql);	
								if ($row = mysql_fetch_array($result)){	
									echo "<li><a class=\"sm6\" href=\"over_limit.php\" target=\"_blank\">Over Limit Pendings</a></li>";
								}	
                                
								$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Quotation' and grp='Data Capture' and doc_view=1";
								$result =$db->RunQuery($sql);	
								if ($row = mysql_fetch_array($result)){	
									echo "<li><a class=\"sm6\" href=\"quotation.php\" target=\"_blank\">Quotation</a></li>";
								}
								
								$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Credit Note From' and grp='Data Capture' and doc_view=1";
								$result =$db->RunQuery($sql);	
								if ($row = mysql_fetch_array($result)){	
									echo "<li><a class=\"sm6\" href=\"credit_note_form.php\" target=\"_blank\">Credit Note From</a></li>";
								}
								
								$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Cash Credit Note From' and grp='Data Capture' and doc_view=1";
								$result =$db->RunQuery($sql);	
								if ($row = mysql_fetch_array($result)){	
									echo "<li><a class=\"sm6\" href=\"cash_credit_note_form.php\" target=\"_blank\">Cash Credit Note From</a></li>";
								}
								
								?>	
							</ul>
						</li>
					</ul>
				</div>
			</div>

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
require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
?>
<div id="menus_wrapper">
				
				
				
				
				
				<div id="main_menu">
					<ul>
						<li><a href="home.php"><span><span>Home</span></span></a></li>
                        <?php
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Master Files' and doc_view=1";
						$result =$db->RunQuery($sql);	
						
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"masterfiles.php\" ><span><span>Master Files</span></span></a></li>";
						}
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Data Capture' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
                        	echo "<li><a href=\"datacapture.php\"><span><span>Data Capture</span></span></a></li>";
						}	
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Costing' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"#\"><span><span>Costing</span></span></a></li>";
						}	
						
						$sql="select * from userpermission where username='".$_SESSION['UserName']."' and grp='Inquiries' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){
							echo "<li><a href=\"inquiry.php\" ><span><span>Inquiries</span></span></a></li>";
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
                        	echo "<li><a href=\"reports.php\" class=\"selected\"><span><span>Reports</span></span></a></li>";
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
					$sql1="select * from view_userpermission where username='".$_SESSION['UserName']."' and grp='Reports-Sales' and doc_view=1";
					$result1 =$db->RunQuery($sql1);	
					if ($row1 = mysql_fetch_array($result1)){	
                    	echo "<li>
							<span class=\"drop\"><span><span><a href=\"#\" class=\"sm1\">Sales</a></span></span></span>
							<ul>";
							$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Sales Summery' and grp='Reports-Sales' and doc_view=1";
							$result =$db->RunQuery($sql);	
							if ($row = mysql_fetch_array($result)){	
								echo "<li><a class=\"sm6\" href=\"rep_sales_summery.php\" target=\"_blank\">Sales Summery</a></li>";
							}	
							
							$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Outstanding Report' and grp='Reports-Sales' and doc_view=1";
							$result =$db->RunQuery($sql);	
							if ($row = mysql_fetch_array($result)){	
                                echo "<li><a class=\"sm6\" href=\"rep_outstanding.php\" target=\"_blank\">Outstanding Report</a></li>";
							}
							
							$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Rep Wise Sales Summery' and grp='Reports-Sales' and doc_view=1";
							$result =$db->RunQuery($sql);	
							if ($row = mysql_fetch_array($result)){		
                                echo "<li><a class=\"sm6\" href=\"rep_rep_wise_sales.php\" target=\"_blank\">Repwise Sales Summery</a></li>";
							}
							
							$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Weekly Sales Report' and grp='Reports-Sales' and doc_view=1";
							$result =$db->RunQuery($sql);	
							if ($row = mysql_fetch_array($result)){		
                                echo "<li><a class=\"sm6\" href=\"rep_weekly_sales.php\" target=\"_blank\">Weekly Sales Report</a></li>";
							}
							
							$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Monthly Sales Summery' and grp='Reports-Sales' and doc_view=1";
							$result =$db->RunQuery($sql);	
							if ($row = mysql_fetch_array($result)){		
                                echo "<li><a class=\"sm6\" href=\"rep_monthly_sales.php\" target=\"_blank\">Monthly Sales Summery</a></li>";
							}
							
							$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Quantity Sales Summery' and grp='Reports-Sales' and doc_view=1";
							$result =$db->RunQuery($sql);	
							if ($row = mysql_fetch_array($result)){		
                                echo "<li><a class=\"sm6\" href=\"rep_qty_sales.php\" target=\"_blank\">Quantity Sales Summery</a></li>";
							}
							
							$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Sales Commission' and grp='Reports-Sales' and doc_view=1";
							$result =$db->RunQuery($sql);	
							if ($row = mysql_fetch_array($result)){		
                                echo "<li><a class=\"sm6\" href=\"sales_commission.php\" target=\"_blank\">Sales Commission</a></li>";
							}	
								
							echo "</ul>
						</li>";
                    }
					
					
					$sql1="select * from view_userpermission where username='".$_SESSION['UserName']."' and grp='Reports-Customer' and doc_view=1";
					$result1 =$db->RunQuery($sql1);	
					if ($row1 = mysql_fetch_array($result1)){		     
                        echo "<li>
							<span class=\"drop\"><span><span><a href=\"#\" class=\"sm1\">Customer</a></span></span></span>
							<ul>";
							
							$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Customer Current Status' and grp='Reports-Customer' and doc_view=1";
							
							$result =$db->RunQuery($sql);	
							if ($row = mysql_fetch_array($result)){		
								echo "<li><a class=\"sm6\" href=\"rep_customer_current.php\" target=\"_blank\">Customer Currnet Status</a></li>";
							}
							
							$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Outstanding Statement' and grp='Reports-Customer' and doc_view=1";
							$result =$db->RunQuery($sql);	
							if ($row = mysql_fetch_array($result)){			
                                echo "<li><a class=\"sm6\" href=\"rep_outstanding_statement.php\" target=\"_blank\">Outstanding Statement</a></li>";
							}	
							
							$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Pending Cheque' and  grp='Reports-Customer' and doc_view=1";
							$result =$db->RunQuery($sql);	
							if ($row = mysql_fetch_array($result)){			
                               	echo "<li><a class=\"sm6\" href=\"rep_pd_chq.php\" target=\"_blank\">Pending Cheque</a></li>";
							}
							
							$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Return Cheque' and  grp='Reports-Customer' and doc_view=1";
							$result =$db->RunQuery($sql);	
							if ($row = mysql_fetch_array($result)){			
                                echo "<li><a class=\"sm6\" href=\"rep_ret_chq.php\" target=\"_blank\">Return Cheque</a></li>";
							}	
								
							echo "</ul>
						</li>";
						
					}	
					
					$sql1="select * from view_userpermission where username='".$_SESSION['UserName']."' and grp='AR and Orders' and doc_view=1";
					$result1 =$db->RunQuery($sql1);	
					if ($row1 = mysql_fetch_array($result1)){	
                        echo "<li><a href=\"\" target=\"_blank\" class=\"sm1\" >AR and Orders</a></li>";
					}	
					
					$sql1="select * from view_userpermission where username='".$_SESSION['UserName']."' and grp='Reports-Other' and doc_view=1";
					$result1 =$db->RunQuery($sql1);	
					if ($row1 = mysql_fetch_array($result1)){	
                        						
                        echo "<li>
								<span class=\"drop\"><span><span><a href=\"#\" class=\"sm1\">Other</a></span></span></span>
								
							<ul>";
							
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Weekly Target' and grp='Reports-Other' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){		
							echo "<li><a class=\"sm6\" href=\"weekly_target.php\" target=\"_blank\">Weekly Target</a></li>";
						}	
								
							echo "</ul>
						</li>";
						
					}	
					
					$sql1="select * from view_userpermission where username='".$_SESSION['UserName']."' and grp='Reports-Stock' and doc_view=1";
					$result1 =$db->RunQuery($sql1);	
					if ($row1 = mysql_fetch_array($result1)){	
                    	echo "<li>
							<span class=\"drop\"><span><span><a href=\"#\" class=\"sm1\">Stock</a></span></span></span>
							
							<ul>";
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Stock Report' and grp='Reports-Stock' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){		
							echo "<li><a class=\"sm6\" href=\"rep_stock.php\" target=\"_blank\">Stock Report</a></li>";
						}	
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Stock Moving Report' and grp='Reports-Stock' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){		
								echo "<li><a class=\"sm6\" href=\"rep_stock_moving.php\" target=\"_blank\">Stock Moving Report</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Stock Consumption Report' and grp='Reports-Stock' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){				
							echo "<li><a class=\"sm6\" href=\"rep_stock_consumption.php\" target=\"_blank\">Stock Consumption Report</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Unsold Stock Report' and grp='Reports-Stock' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){				
							echo "<li><a class=\"sm6\" href=\"rep_unsold.php\" target=\"_blank\">Unsold Stock Report</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Unsold Stk Rep - Rep Wise' and grp='Reports-Stock' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){				
                            echo "<li><a class=\"sm6\" href=\"rep_unsold_rep_wise.php\" target=\"_blank\">Unsold Stk Report - Rep Wise</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='AR Moving Report' and grp='Reports-Stock' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){				
							echo "<li><a class=\"sm6\" href=\"rep_ar_moving.php\" target=\"_blank\">AR Moving Report</a></li>";
						}		
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Current Stock Balance' and grp='Reports-Stock' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){				
                            echo "<li><a class=\"sm6\" href=\"rep_current_stk_bal.php\" target=\"_blank\">Current Stock Balance</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Stock Variation Report' and grp='Reports-Stock' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){				
                            echo "<li><a class=\"sm6\" href=\"rep_stk_variation.php\" target=\"_blank\">Stock Variation Report</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Damage Item' and grp='Reports-Stock' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){				
                            echo "<li><a class=\"sm6\" href=\"rep_damage_item.php\" target=\"_blank\">Damage Item</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='6th Month Pur: with Cons:' and grp='Reports-Stock' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){				
                            echo "<li><a class=\"sm6\" href=\"rep_6month_purchase.php\" target=\"_blank\">6th Month Pur: With Cons:</a></li>";
						}
						
						$sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Stock Report As At' and grp='Reports-Stock' and doc_view=1";
						$result =$db->RunQuery($sql);	
						if ($row = mysql_fetch_array($result)){				
                            echo "<li><a class=\"sm6\" href=\"rep_stk_as_at.php\" target=\"_blank\">Stock Report As At</a></li>";
						}		
							echo "</ul>
						</li>";
                       
					}
					?>
					</ul>
				</div>
			</div>
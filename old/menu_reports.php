
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
            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Master Files' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);

            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"masterfiles.php\" ><span><span>Master Files</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Data Capture' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"datacapture.php\"><span><span>Data Capture</span></span></a></li>";
            }
            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Costing' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"costing.php\"><span><span>Costing</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Inquiries' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"inquiry.php\" ><span><span>Inquiries</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Analysis' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"#\"><span><span>Analysis</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Delivery' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"#\"><span><span>Delivery</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and (grp='Reports-Sales' or grp='Reports-Customer' or grp='Reports-Other' or grp='Reports-Stock') and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"reports.php\" class=\"selected\"><span><span>Reports</span></span></a></li>";
            }


            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='System Utilities' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"utility.php\"><span><span>System Utilities</span></span></a></li>";
            }

            // $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Stores' and doc_view=1";
            // $result = mysqli_query($GLOBALS['dbinv'], $sql);
            // if ($row = mysqli_fetch_array($result)) {
            //     echo "<li><a href=\"stores.php\"><span><span>Stores</span></span></a></li>";
            // }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Administration' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"administration.php\"><span><span>Administration</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Inventory' and doc_view=1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                echo "<li><a href=\"Inventory.php\"><span><span>Inventory</span></span></a></li>";
            }
            ?>	
            <li class="last" onclick="logout();"><a href="#"><span><span>Logout</span></span></a></li>
        </ul>
    </div>



    <div id="sec_menu">
        <ul>
            <?php
            $sql1 = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and grp='Reports-Sales' and doc_view=1 and block='0'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($row1 = mysqli_fetch_array($result1)) {
                echo "<li>
							<span class=\"drop\"><span><span><a href=\"#\" class=\"sm1\">Sales</a></span></span></span>
							<ul>";
                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Sales Summery' and grp='Reports-Sales' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_sales_summery.php\" target=\"_blank\">Sales Summery</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Outstanding Report' and grp='Reports-Sales' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_outstanding.php\" target=\"_blank\">Outstanding Report</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Rep Wise Sales Summery' and grp='Reports-Sales' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href='rep_rep_wise_sales.php' target=\"_blank\">Repwise Sales Summery</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Weekly Sales Report' and grp='Reports-Sales' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_weekly_sales.php\" target=\"_blank\">Weekly Sales Report</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Monthly Sales Summery' and grp='Reports-Sales' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_monthly_sales.php\" target=\"_blank\">Monthly Sales Summery</a></li>";
                }


                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='12 Month Sales Summery' and grp='Reports-Sales' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_yearly_sales.php\" target=\"_blank\">Yearly Sales Summery</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='6 Month Sales Summery' and grp='Reports-Sales' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_6monthsal.php\" target=\"_blank\">6 Month Sales Summery</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Quantity Sales Summery' and grp='Reports-Sales' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_qty_sales.php\" target=\"_blank\">Quantity Sales Summery</a></li>"; 
                }
                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Quantity Sales Customer Summery ' and grp='Reports-Sales' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) { 
                    echo "<li><a class=\"sm6\" href=\"rep_qty_cus_sales.php\" target=\"_blank\">Quantity Sales Customer Summery</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Sales Commission' and grp='Reports-Sales' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"sales_commission.php\" target=\"_blank\">Sales Commission</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Sales Commission - Dist' and grp='Reports-Sales' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"sales_commission_distb.php\" target=\"_blank\">Sales Commission - Dist</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='PCDD Incentive' and grp='Reports-Sales' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_pdcc.php\" target=\"_blank\">PCDD Incentive</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Remaining Stock' and grp='Reports-Sales' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_remaining_stk.php\" target=\"_blank\">Remaining Stock %</a></li>";
                }

                echo "</ul>
						</li>";
            }


            $sql1 = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and grp='Reports-Customer' and doc_view=1 and block='0'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($row1 = mysqli_fetch_array($result1)) {
                echo "<li>
							<span class=\"drop\"><span><span><a href=\"#\" class=\"sm1\">Customer</a></span></span></span>
							<ul>";

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Customer Current Status' and grp='Reports-Customer' and doc_view=1 and block='0'";

                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_customer_current.php\" target=\"_blank\">Customer Currnet Status</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Outstanding Statement' and grp='Reports-Customer' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_outstanding_statement.php\" target=\"_blank\">Outstanding Statement</a></li>";
                }
                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Outstanding Statement Group' and grp='Reports-Customer' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_outstanding_group.php\" target=\"_blank\">Outstanding Group Status</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Pending Cheque' and  grp='Reports-Customer' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_pd_chq.php\" target=\"_blank\">Pending Cheque</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Return Cheque' and  grp='Reports-Customer' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_ret_chq.php\" target=\"_blank\">Return Cheque</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Dealer Card' and  grp='Reports-Customer' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_dealer_card.php\" target=\"_blank\">Dealer Card &nbsp;&nbsp;&nbsp;&nbsp;</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='SVAT Report' and  grp='Reports-Customer' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_svatrepo.php\" target=\"_blank\">SVAT Report</a></li>"; 
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='VAT Schedule Report' and  grp='Reports-Customer' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) { 
                    echo "<li><a class=\"sm6\" href=\"new/home.php?url=vatshdule\" target=\"_blank\">VAT Schedule Report</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Outstanding Credit Limit Balance' and  grp='Reports-Customer' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_outcreditLmt.php\" target=\"_blank\">Outstanding Credit Limit Balance</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Balance Limit' and  grp='Reports-Customer' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_outlimits.php\" target=\"_blank\">Balance Limit</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Cheque Extend' and  grp='Reports-Customer' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_chkextndrepo.php\" target=\"_blank\">Cheque Extend</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Customer Master Report' and  grp='Reports-Customer' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_cusmast_print.php\" target=\"_blank\">Customer Master Report</a></li>";
                }

                /* $sql="select * from view_userpermission where username='".$_SESSION['UserName']."' and docname='Customer Master Print' and  grp='Reports-Customer' and doc_view=1 and block='0'";
                  $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
                  if ($row = mysqli_fetch_array($result)){
                  echo "<li><a class=\"sm6\" href=\"report_customer_print.php\" target=\"_blank\">Customer Master Print</a></li>";
                  } */

                echo "</ul>
						</li>";
            }

            $sql1 = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and grp='AR and Orders' and doc_view=1 and block='0'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($row1 = mysqli_fetch_array($result1)) {

                echo "<li>
								<span class=\"drop\"><span><span><a href=\"#\" class=\"sm1\">AR and Orders</a></span></span></span>
								
							<ul>";

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='AR Report' and grp='AR and Orders' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {

                    echo "<li><a class=\"sm6\" href=\"rep_ar_report.php\" target=\"_blank\">AR Report &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='AR Analysis' and grp='AR and Orders' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {

                    echo "<li><a class=\"sm6\" href=\"rep_ar_analysis.php\" target=\"_blank\">AR Analysis</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Pending Orders' and grp='AR and Orders' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {

                    echo "<li><a class=\"sm6\" href=\"rep_shipmntdet.php\" target=\"_blank\">Pending Orders</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Shipment Details' and grp='AR and Orders' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {

                    echo "<li><a class=\"sm6\" href=\"rep_shipmntdet.php\" target=\"_blank\">Shipment Details</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Purchase Return' and grp='AR and Orders' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {

                    echo "<li><a class=\"sm6\" href=\"rep_pur_ret_report.php\" target=\"_blank\">Purchase Return</a></li>";
                }


                echo "</ul>
						</li>";
            }



            $sql1 = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and grp='Reports-Other' and doc_view=1 and block='0'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($row1 = mysqli_fetch_array($result1)) {

                echo "<li>
								<span class=\"drop\"><span><span><a href=\"#\" class=\"sm1\">Other</a></span></span></span>
								
							<ul>";

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Weekly Target' and grp='Reports-Other' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"weekly_target.php\" target=\"_blank\">Weekly Target</a></li>";
                }

                echo "<li><a class=\"sm6\" href=\"batt_inv.php\" target=\"_blank\">Dealer Stock</a></li>";

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Defective Report' and grp='Reports-Other' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_defective.php\" target=\"_blank\">Defective Report</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='login_report' and grp='Reports-Other' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"new\home.php?url=login_report\" target=\"_blank\">Login Report</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Settlement Summery' and grp='Reports-Other' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_settlement_summery.php\" target=\"_blank\">Settlement Summery	</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Dealer Incentive' and grp='Reports-Other' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"dealer_incentive.php\" target=\"_blank\">Dealer Incentive</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Dealer Incentive Report' and grp='Reports-Other' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"dealer_incentive_report.php\" target=\"_blank\">Dealer Incentive Report</a></li>";
                }


                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Dealer Incentive - G' and grp='Reports-Other' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"dealer_incentived.php\" target=\"_blank\">Dealer Incentive - G</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Dealer Incentive Report - G' and grp='Reports-Other' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"dealer_incentive_reportd.php\" target=\"_blank\">Dealer Incentive Report - G</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Utility' and grp='Reports-Other' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_utility.php\" target=\"_blank\">Utility Report</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Over Payments' and grp='Reports-Other' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_overpayment.php\" target=\"_blank\">Over Payments</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Credit Limit Exceed' and grp='Reports-Other' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_cr_limit_exceed.php\" target=\"_blank\">Credit Limit Exceed</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Return Cheque Report' and grp='Reports-Other' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_return_chq.php\" target=\"_blank\">Return Cheque Report</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Return Cheque Payment' and grp='Reports-Other' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_return_chq_pay.php\" target=\"_blank\">Return Cheque Payment</a></li>";
                }
                echo "<li><a class=\"sm6\" href=\"rep_audit.php\" target=\"_blank\">Audit Trail</a></li>";
                echo "</ul>
						</li>";
            }

            $sql1 = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and grp='Reports-Stock' and doc_view=1 and block='0'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($row1 = mysqli_fetch_array($result1)) {
                echo "<li>
							<span class=\"drop\"><span><span><a href=\"#\" class=\"sm1\">Stock</a></span></span></span>
							
							<ul>";

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Stock Report' and grp='Reports-Stock' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_stock.php\" target=\"_blank\">Stock Report</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Stock Moving Report' and grp='Reports-Stock' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_stock_moving.php\" target=\"_blank\">Stock Moving Report</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Stock Consumption Report' and grp='Reports-Stock' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_6monthitm.php\" target=\"_blank\">Stock Consumption Report</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Stock Consumption Gen Report' and grp='Reports-Stock' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_6monthitm_1.php\" target=\"_blank\">Stock Consumption Gen No</a></li>";
                }


                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Unsold Stock Report' and grp='Reports-Stock' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_unsold.php\" target=\"_blank\">Unsold Stock Report</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Unsold Stk Rep - Rep Wise' and grp='Reports-Stock' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_unsold_rep_wise.php\" target=\"_blank\">Unsold Stk Report - Rep Wise</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Unsold Stock - All Dep' and grp='Reports-Stock' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_unsold_tot.php\" target=\"_blank\">Unsold Stk Report - All Dep</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='AR Moving Report' and grp='Reports-Stock' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_ar_moving.php\" target=\"_blank\">AR Moving Report</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Current Stock Balance' and grp='Reports-Stock' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_current_stk_bal.php\" target=\"_blank\">Current Stock Balance</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Stock Variation Report' and grp='Reports-Stock' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_stk_variation.php\" target=\"_blank\">Stock Variation Report</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Damage Item' and grp='Reports-Stock' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_damage_item.php\" target=\"_blank\">Damage Item</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='6th Month Pur: with Cons:' and grp='Reports-Stock' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"order_form.php\" target=\"_blank\">Order Form&nbsp;</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Stock Report As At' and grp='Reports-Stock' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"rep_stk_as_at.php\" target=\"_blank\">Stock Report As At</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Stock Adjustment Report' and grp='System Stock' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"new\home.php?url=rep_stock_adjustment\" target=\"_blank\">Stock Adjustment Report</a></li>";
                }
                echo "</ul>
						</li>";
            }
            $sql1 = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and grp='Reports-New' and doc_view=1 and block='0'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($row1 = mysqli_fetch_array($result1)) {
                echo "<li>
                        <span class=\"drop\"><span><span><a href=\"#\" class=\"sm1\">New</a></span></span></span>

                        <ul>";

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Rep Lock Active' and grp='Reports-New' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"new\home.php?url=rep_lock_active\" target=\"_blank\">Rep Lock Active</a></li>";
                }
                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Sms Fire' and grp='Reports-New' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"new\home.php?url=sms_fire\" target=\"_blank\">Sms Fire</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Insentive Payment Modification' and grp='Reports-New' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"new\home.php?url=insen_pay_modifi\" target=\"_blank\">Insentive Payment Modification</a></li>";
                }
                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Request Data Modifications' and grp='Reports-New' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"new\home.php?url=reqdata_modification\" target=\"_blank\">Request Data Modifications</a></li>";
                }

                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Credit Note Approve' and grp='Reports-New' and doc_view=1 and block='0'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    echo "<li><a class=\"sm6\" href=\"new\home.php?url=credit_note_app\" target=\"_blank\">Credit Note Approve</a></li>";
                }
                
                echo "</ul>
		 </li>";
            }
            ?>
        </ul>
    </div>
</div>
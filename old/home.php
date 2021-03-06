<?php
session_start();
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60);

if ($_SESSION["dev"] != "") {
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
            <meta http-equiv="imagetoolbar" content="no" />
            <title>Administration Panel</title>
            <link media="screen" rel="stylesheet" type="text/css" href="css/admin.css"  />
            <script src="new/js/jquery-1.6.1.min.js"></script>    

            <script src="track.js"></script>    

            <script language="javascript" type="text/javascript">
                <!--
                /****************************************************
                 Author: Eric King
                 Url: http://redrival.com/eak/index.shtml
                 This script is free to use as long as this info is left in
                 Featured on Dynamic Drive script library (http://www.dynamicdrive.com)
                 ****************************************************/
                var win = null;
                function NewWindow(mypage, myname, w, h, scroll, pos) {
                    if (pos == "random") {
                        LeftPosition = (screen.width) ? Math.floor(Math.random() * (screen.width - w)) : 100;
                        TopPosition = (screen.height) ? Math.floor(Math.random() * ((screen.height - h) - 75)) : 100;
                    }
                    if (pos == "center") {
                        LeftPosition = (screen.width) ? (screen.width - w) / 2 : 100;
                        TopPosition = (screen.height) ? (screen.height - h) / 2 : 100;
                    } else if ((pos != "center" && pos != "random") || pos == null) {
                        LeftPosition = 0;
                        TopPosition = 20
                    }
                    settings = 'width=' + w + ',height=' + h + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=' + scroll + ',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
                    win = window.open(mypage, myname, settings);
                }
                // -->
            </script>

            <!--[if lte IE 6]><link media="screen" rel="stylesheet" type="text/css" href="css/admin-ie.css" /><![endif]-->
        </head>

        <body>
            <!--[if !IE]>start wrapper<![endif]-->
            <div id="wrapper">
                <!--[if !IE]>start head<![endif]-->
                <div id="head">

                    <!--[if !IE]>start logo and user details<![endif]-->
                    <div id="logo_user_details" style="background-color:#4267b2">
                        <h1 id="logo"> 	 </h1>

                        <div class="tyrename" > <?php
                	require_once("connectioni.php");
                	$sql_invpara="SELECT * from invpara";
					$result_invpara =mysqli_query($GLOBALS['dbinv'],$sql_invpara);
					$row_invpara = mysqli_fetch_array($result_invpara);
				
							echo $row_invpara['COMPANY'];
				?> </div>
                    <div class="col-sm-1">
                          <b><p style="float: right; color: yellow;font-size: 20px;" id="time"></p></b> 
                    </div>
                    <script>
                        var myVar = setInterval(myTimer, 1000);

                        function myTimer() {

                            var d = new Date();
                    //        var dd = d.toLocaleDateString();
                            var tt = d.toLocaleTimeString();
                            document.getElementById("time").innerHTML = tt;
                        }

                    </script>
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

                <table style="width:100%">
                    <tr>
                        <th>
                            <div id="content" style="margin-top: -250px;">
                                <?php
                                include('connectioni.php');

                                $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Bank Garntee' and grp='Master Files' and doc_view=1";
                                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                                if ($row = mysqli_fetch_array($result)) {

                                    echo "<table class='CSSTableGenerator'>";
                                    echo "<tr><th colspan=4'>Bank Gurantee</th></tr>";

                                    echo "<tr><th width ='50'>Code</th>";
                                    echo "<th width ='200'>Name</th>";
                                    echo "<th width ='80'>Amount</th>";
                                    echo "<th width ='80'>Expire</th></tr>";
                                    $add_days = 60;
                                    $date = date('Y-m-d');
                                    $date = date('Y-m-d', strtotime($date) + (24 * 3600 * $add_days));
                                    $sql1 = "Select Code,Name,amount,Expire from S_guaratee where expire < '" . $date . "' and type = 'BANK' AND STATUS = '1' order by expire";

                                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                                    while ($row1 = mysqli_fetch_array($result1)) {

                                        echo "<tr><td>" . $row1['Code'] . "</td>";
                                        echo "<td>" . $row1['Name'] . "</td>";
                                        echo "<td>" . $row1['amount'] . "</td>";
                                        echo "<td>" . $row1['Expire'] . "</td></tr>";
                                    }

                                    echo "</table>";
                                }

                                if ($_SESSION["CURRENT_REP"] != "") {
                                    echo "<table class='CSSTableGenerator'>";
                                    echo "<tr><th colspan=8'>Over 90 Outstanding</th></tr>";

                                    echo "<tr> <td width ='150'><b>Invoice no</b></td>
								<td  width ='350'><b>Dealer</b></td>
                                <td  width ='100'><b>Date</b></td>
                                <td  width ='100'><b>Del.Date</b></td>
                                <td align='center' width ='100'><b>Amount </b></td>
                                <td  align='center' width ='100'><b>Paid</b></td>
                                <td  align='center' width ='100'><b>Balance</b></td>
                                <td  align='center' width ='80'><b>Days</b></td>
                                <td  align='center' width ='80'><b>Del.Days</b></td></tr>";

                                    $sql1 = "Select * from s_salma where sal_ex='" . $_SESSION["CURRENT_REP"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 order by SDATE ";

                                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                                    while ($row = mysqli_fetch_array($result1)) {

                                        $sql_ven = "select * from vendor where code = '" . $row["C_CODE"] . "'";
                                        $result_ven = mysqli_query($GLOBALS['dbinv'], $sql_ven);
                                        $row_ven = mysqli_fetch_array($result_ven);


                                        $diff = abs(strtotime(date("Y-m-d")) - strtotime($row["SDATE"]));
                                        $days = floor($diff / (60 * 60 * 24));

                                        if ($days >= 90) {
                                            echo "<tr><td><a href=\"\" class=\"INV\" onClick=\"NewWindow('sales_inv_display.php?refno=" . $row['REF_NO'] . "&trn_type=" . $row['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"> " . $row['REF_NO'] . "</a></td>";
                                            echo "<td>" . $row_ven["CODE"] . " " . $row_ven["NAME"] . " - " . $row_ven["ADD2"] . "</td>";

                                            echo "<td>" . $row["SDATE"] . "</td>";

                                            if (is_null($row["deli_date"]) == false) {
                                                echo "<td>" . $row["deli_date"] . "</td>";
                                            } else {
                                                echo "<td>" . $row["SDATE"] . "</td>";
                                            }
                                            echo "<td align=right >" . number_format($row["GRAND_TOT"], 2, ".", ",") . "</td>";
                                            echo "<td align=right >" . number_format($row["TOTPAY"], 2, ".", ",") . "</td>";
                                            echo "<td align=right >" . number_format($row["GRAND_TOT"] - $row["TOTPAY"], 2, ".", ",") . "</td>";

                                            echo "<td align=right >" . $days . "</font></td>";

                                            if ((is_null($row["deli_date"]) == false) and ( $row["deli_date"] != "1970-01-01") and ( $row["deli_date"] != "0000-00-00")) {
                                                $diff = abs(strtotime(date("Y-m-d")) - strtotime($row["deli_date"]));
                                                $days = floor($diff / (60 * 60 * 24));
                                                echo "<td align=right > " . $days . "</td>";
                                            } else {
                                                $diff = abs(strtotime(date("Y-m-d")) - strtotime($row["SDATE"]));
                                                $days = floor($diff / (60 * 60 * 24));
                                                echo "<td align=right > " . $days . "</td>";
                                            }
                                            echo "</tr>";
                                        }
                                    }
                                    echo "</table><br><br>";


                                    echo "<table class='CSSTableGenerator'>";
                                    echo "<tr><th colspan=8'>Return Cheque</th></tr>";

                                    echo "<tr> <td width ='100'><b>Cheque No</b></td>
								<td  width ='420'><b>Dealer</b></td>
                                <td  width ='100'><b>Date</b></td>
                                <td   align='center'  width ='100'><b>Amount</b></td>
                              
                                <td  align='center'  width ='100'><b>Paid</b></td>
                                <td  align='center'  width ='100'><b>Balance</b></td>
                                <td  align='center'  width ='80'><b>Days</b></td>
                                </tr>";

                                    $sql1 = "Select * from s_cheq where S_REF ='" . $_SESSION["CURRENT_REP"] . "' and CR_FLAG='0' and  CR_CHEVAL>PAID+1 order by cr_date ";

                                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                                    while ($row = mysqli_fetch_array($result1)) {


                                        $sql_ven = "select * from vendor where code = '" . $row["CR_C_CODE"] . "'";
                                        $result_ven = mysqli_query($GLOBALS['dbinv'], $sql_ven);
                                        $row_ven = mysqli_fetch_array($result_ven);

                                        $diff = abs(strtotime(date("Y-m-d")) - strtotime($row["CR_DATE"]));
                                        $days = floor($diff / (60 * 60 * 24));

                                        if($row["clicked"]=="1"){
                                            echo "<tr ><td>" . $row['CR_CHNO'] . "</td>"; 
                                            echo "<td>" . $row_ven["CODE"] . " " . $row_ven["NAME"] . " - " . $row_ven["ADD2"] . "</td>"; 
                                            echo "<td>" . $row["CR_DATE"] . "</td>"; 
                                            echo "<td align=right >" . number_format($row["CR_CHEVAL"], 2, ".", ",") . "</td>";
                                            echo "<td align=right >" . number_format($row["PAID"], 2, ".", ",") . "</td>";
                                            echo "<td align=right >" . number_format($row["CR_CHEVAL"] - $row["PAID"], 2, ".", ",") . "</td>";

                                            echo "<td align=right >" . $days . "</font></td>";
                                            echo "</tr>";
                                        }else{
                                            echo "<tr bgcolor=\"red\" style=\"color:white\" onClick=\"clicked('" . $row['CR_CHNO'] . "');\" ><td onClick=\"clicked('" . $row['CR_CHNO'] . "');\">" . $row['CR_CHNO'] . "</td>"; 
                                            echo "<td>" . $row_ven["CODE"] . " " . $row_ven["NAME"] . " - " . $row_ven["ADD2"] . "</td>"; 
                                            echo "<td>" . $row["CR_DATE"] . "</td>"; 
                                            echo "<td align=right >" . number_format($row["CR_CHEVAL"], 2, ".", ",") . "</td>";
                                            echo "<td align=right >" . number_format($row["PAID"], 2, ".", ",") . "</td>";
                                            echo "<td align=right >" . number_format($row["CR_CHEVAL"] - $row["PAID"], 2, ".", ",") . "</td>";

                                            echo "<td align=right >" . $days . "</font></td>";
                                            echo "</tr>";
                                        }
                                        
                                    }



                                    echo "</table>";
                                }
                                ?>




                                <!--[if !IE]>start page<![endif]-->
                                <!--[if !IE]>end page<![endif]-->
                                <!--[if !IE]>start sidebar<![endif]-->
                                <!--[if !IE]>end sidebar<![endif]-->
                            </div>
                        </th>
                        <th style=""></th>
                        <th><div style="width: 350px; "> 

                                <div style="overflow:scroll;height: 500px;width: 500px;" class='info'>
                                    <?php
                                    include('connectioni.php');

                                    if (($_SESSION["CURRENT_USER"] == "admin") or ($_SESSION["CURRENT_USER"] == "buddhika") or ($_SESSION["CURRENT_USER"] == "buddhika1") or   ($_SESSION["CURRENT_USER"] == "thushara") or ($_SESSION["CURRENT_USER"] == "daham")) {

                                        echo "<table class='CSSTableGenerator' style=\"overflow-y:scroll; color:red; height:100px;overflow:scroll;\">";
                                        echo "<tr><th colspan=4' style='color:blue'>Problem Items</th></tr>";

                                        echo "<tr><th width ='50' style='color:blue'>STK NO</th>";
                                        echo "<th width ='200' style='color:blue'>Qty IN Hand</th>";
                                        echo "<th width ='80' style='color:blue'>True QTY</th>";
                                        echo "<th width ='80' style='color:blue'>Department</th></tr>";
     
                                        $sql11 = "update s_trn set tru_qty = qty where (ledindi = 'ARN' or ledindi ='GRN' or ledindi = 'GINR' or ledindi ='IIN' or ledindi = 'TRN') and sdate>='2015-08-08' and id >=1";
                                        $result_1 = mysqli_query($GLOBALS['dbinv'], $sql11);
                                        $row_1 = mysqli_fetch_array($result_1);
                                                  
                                        $sql12 = "update s_trn set tru_qty = qty * -1 where (ledindi = 'ISO' or ledindi = 'ARR' or ledindi ='INV' or ledindi = 'GINI' or ledindi ='IOU') and sdate>='2015-08-08' and id >=1";
                                        $result_2 = mysqli_query($GLOBALS['dbinv'], $sql12);
                                        $row_2 = mysqli_fetch_array($result_2);
                                                  
                                        $sql13 = "select stk_no,QTYINHAND,sum(tru_qty),department  from view_trn_submas where sdate>='2015-08-08' and id >=1  group by stk_no,department  having qtyinhand <> sum(tru_qty)	";
                                        $result_3 = mysqli_query($GLOBALS['dbinv'], $sql13);
                                        while ($row_3 = mysqli_fetch_array($result_3)) {

                                            echo "<tr><td>" . $row_3['STK_NO'] . "</td>";
                                            echo "<td>" . $row_3['QTYINHAND'] . "</td>";
                                            echo "<td>" . $row_3['sum(tru_qty)'] . "</td>";
                                            echo "<td>" . $row_3['DEPARTMENT'] . "</td></tr>";
                                        }
                                        
                                        echo "<tr><th width ='50' style='color:blue' >STK NO</th>";
                                        echo "<th width ='200' style='color:blue'>Qty IN Hand</th>";
                                        echo "<th width ='80' style='color:blue'>True QTY</th>"; 
     
//                                        $sql14 = "update s_trn set tru_qty = qty where (ledindi = 'ARN' or ledindi ='GRN' or ledindi = 'GINR' or ledindi ='IIN'  or ledindi='TRN');";
//                                        $result_4 = mysqli_query($GLOBALS['dbinv'], $sql14);
//                                        $row_4 = mysqli_fetch_array($result_4);
//                                                  
//                                        $sql15 = "update s_trn set tru_qty = qty * -1 where (ledindi = 'ISO' or ledindi = 'ARR' or ledindi ='INV' or ledindi = 'GINI' or ledindi ='IOU');";
//                                        $result_5 = mysqli_query($GLOBALS['dbinv'], $sql15);
//                                        $row_5 = mysqli_fetch_array($result_5);
                                                  
                                        $sql16 = "select stk_no,QTYINHAND,sum(tru_qty)  from view_trn_smas where sdate>='2015-08-08' and id >=1  group by stk_no  having qtyinhand <> sum(tru_qty)";
                                        $result_6 = mysqli_query($GLOBALS['dbinv'], $sql16);
                                        while ($row_6 = mysqli_fetch_array($result_6)) {

                                            echo "<tr><td>" . $row_6['STK_NO'] . "</td>";
                                            echo "<td>" . $row_6['QTYINHAND'] . "</td>";
                                            echo "<td>" . $row_6['sum(tru_qty)'] . "</td></tr>";
                                        }
                                    }
                                    ?>




                                </div>




                                <!--[if !IE]>end content<![endif]-->

                            </div>
                        </th> 

                    </tr>
                     

                </table>

                <!--[if !IE]>end content<![endif]-->

            </div>
            <!--[if !IE]>end wrapper<![endif]-->
<!-- <div id="footer">
                
            </div>-->
            <!--[if !IE]>start footer<![endif]-->
           

            <?php
            //echo $_SERVER['SERVER_NAME'];
            if ($_SERVER['SERVER_NAME'] != "192.168.101.127") {
                ?>
                <!--[if !IE]>end footer<![endif]-->
                <script>
                        getLocation();
                </script>
                <?php
            }
            ?>

        </body>
    </html>
    <?php
} else {
    echo "Invalied User !!!";
}
?>

 
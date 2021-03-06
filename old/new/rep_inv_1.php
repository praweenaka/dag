<?php
session_start();

date_default_timezone_set('Asia/Colombo');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Print Invoice</title>
        <style type="text/css">
            <!--
            .style1 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 14px;
                font-weight: bold;
            }
            .style2 { 
                font-size: 16px;
            }

            .style3 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 15px;
                font-weight:bold;
            }
            -->
        </style>
    </head>

    <body><center>
            <?php
            require_once("connectioni.php");



            $sql = "Select * from s_salma where REF_NO='" . $_GET["invno"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $row = mysqli_fetch_array($result);

            $sql1 = "Select * from vendor where CODE='" . $row["C_CODE"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            $row1 = mysqli_fetch_array($result1);

            $sql2 = "Select * from s_stomas where CODE='" . $row["DEPARTMENT"] . "'";
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
            $row2 = mysqli_fetch_array($result2);

            $TXTDEP = $row2["DESCRIPTION"];
            $rtxtinvno = $row["invno"];
            $rtxtordno = $row["ORD_NO"];

            $sql2 = "Select * from s_salrep where REPCODE='" . $row["SAL_EX"] . "'";
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
            $row2 = mysqli_fetch_array($result2);

            $rtxtrep = $row2["Name"];
            $rtxtSupCode = $row1["CODE"];
            $rtxtSupName = $row1["NAME"];
            $txtadd = $row1["ADD1"] . " " . $row1["ADD2"];
            $rtxtdate = date("Y-m-d", strtotime($row["SDATE"]));
            $rtxttot = $row["GRAND_TOT"];

            $VAT_per = $row["VAT"];



            $sql_para = "Select * from invpara ";
            $result_para = mysqli_query($GLOBALS['dbinv'], $sql_para);
            $row_para = mysqli_fetch_array($result_para);

            if ($row["VAT"] == "1") {
                $txtcusvat = "Customer VAT  " . $row["vat_no"];
                $txtcomvat = "VAT Reg. " . $row_para["VAT"];
                $RTXTVAT = "VAT " . $row["GST"] . "%  ";
                $RTXVATAMU = $row["BTT"];
                $txttaxinv = "<b>TAX INVOICE</b>";
                $txtsubtot = $row["AMOUNT"];
                $txtsubtotdes = "Sub Total";
            }

            if ($row["SVAT"] != "0") {
                $txtcusvat = "Customer VAT  " . $row["vat_no"];
                $txtcomvat = "VAT Reg. " . $row_para["VAT"];
                $RTXTVAT = "Suspended VAT " . $row["GST"] . "%  ";
                $RTXVATAMU = $row["BTT"];
                $txttaxinv = "<b>SUSPENDED TAX INVOICE</b>";
                $txtsubtot = $row["AMOUNT"];
                $txtsubtotdes = "Nett Total";

                $txtoursvat = "SVAT Reg. " . $row_para["svatno"];
                $txtcussavat = "Customer SVAT " . $row["s_vat_no"];
            }
            ?>

            <table width="922" height="434" border="0">
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td colspan="4" align="center"><span class="style2"><?php echo $txttaxinv; ?></span></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td width="20" align="center">    </td>
                     <td colspan="3" align="center"><span class="style2"><?php echo $txtcomvat; ?></span>&nbsp;&nbsp;&nbsp;<span class="style2"><?php echo $txtoursvat; ?></span></td>
                     <td width="103"><span class="style2">
                            <?php
                            echo $_GET["invno"];
                            ?>
                        </span></td>
                </tr>
                <tr>
                    <td height="21">&nbsp;</td>
                    <td width="85">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3"><span class="style2"><?php  ?></span>&nbsp;&nbsp;&nbsp;<span class="style2"><?php   ?></span></td>
                    <td>&nbsp;</td>
                </tr>
<!--                <tr>
                    <td height="21">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2"></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>-->
                <tr>
                    <td width="10" height="21" align="right"><span class="style2"><?php echo $rtxtSupCode; ?></span></td>
                    <td colspan="4"><span class="style2"><?php
                            $txtCNAME = str_replace("~", "&", $_GET['cus_name']);
                            echo $txtCNAME;
                            ?></span></td>
                    <td width="232"><span class="style2">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtxtordno; ?></span></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                     
                    <td style="vertical-align: text-top;" height="21" colspan="4" rowspan='3'><span class="style2"><?php
                            $cus_address = str_replace("~", "&", $_GET['cus_address']);
                            echo $cus_address;
                            ?></span><br><span class="style2"><?php
                            echo $txtcusvat;
                            ?></span> &nbsp;&nbsp;&nbsp;  <span class="style2"><?php echo $txtcussavat; ?></span></td>
                    <td height="21">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>

                <tr>
                    <td height="21">&nbsp;</td>
                     
                    <td style="vertical-align: text-top;"><span class="style2">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtxtrep; ?></span></td>
                    <td align="center"><span class="style2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtxtdate; ?></span></td>
                </tr>
                 <tr>
                    <td height="21" colspan="2">&nbsp;</td>

                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td height="21" colspan="2">&nbsp;</td>
                    <td colspan="2"></td>
                    <td width="177">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td height="21" colspan="2">&nbsp;</td>
                    <td colspan="2"></td>
                    <td width="177">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td height="56" colspan="7"><table width="904" height="81" border="0" cellspacing="0">
                    <!--  <tr  bgcolor="#999999">
                        <td width="130" height="23"><span class="style1">STK No</span></td>
                        <td width="295"><span class="style1">Description</span></td>
                        <td width="158"><span class="style1">Rate</span></td>
                        <td width="135"><span class="style1">Quantity</span></td>
                        <td width="152"><span class="style1">Sub Total</span></td>
                        </tr> -->
                            <?php
                            $i = 1;
                            $totsuntot = 0;

                            $sql1 = "Select * from s_invo where REF_NO='" . $_GET["invno"] . "' order by PRICE DESC";
                            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $sql_part = "Select * from s_mas where STK_NO='" . $row1["STK_NO"] . "'";
                                $result_part = mysqli_query($GLOBALS['dbinv'], $sql_part);
                                $row_part = mysqli_fetch_array($result_part);

                                if (($VAT_per == "1") or ($VAT_per == "2")) {
                                    $vatr = 100 + $row["GST"];
                                    $PRICE = $row1["PRICE"] / $vatr * 100;
                                } else {
                                    $PRICE = $row1["PRICE"];
                                }

                                $PRICE = $PRICE - ($PRICE * $row1["DIS_per"] / 100);

                                $subtot = ($PRICE * $row1["QTY"]);

                                if ($row1["ad"] == "1") {
                                    echo "<tr><td width=50><span class=\"style3\">" . $row1["STK_NO"] . "</span></td>
				<td width=400><span class=\"style3\">&nbsp;&nbsp;" . $row1["DESCRIPT"] . "</span></td>
				<td width=150><span class=\"style3\">" . substr(trim($row_part["PART_NO"]), 0, 15) . "</span></td>
				<td width=80 align=\"right\"><span class=\"style3\">" . number_format($PRICE, 2, ".", ",") . "</span></td>
				<td width=50 align=\"right\"><span class=\"style3\">" . number_format($row1["QTY"], 0, ".", ",") . "</span></td>
				<td width=70 align=\"right\"><span class=\"style3\">0</span></td>";

                                    echo "<td width=100 align=\"right\"><span class=\"style3\">" . number_format($subtot, 2, ".", ",") . "</span></td>
			<td align=\"right\"><span class=\"style3\">AD</span></tr>";
                                } else {
                                    echo "<tr><td width=50><span class=\"style2\">" . $row1["STK_NO"] . "</span></td>
				<td width=400><span class=\"style2\">&nbsp;&nbsp;" . $row1["DESCRIPT"] . "</span></td>
				<td width=150><span class=\"style2\">" . substr(trim($row_part["PART_NO"]), 0, 15) . "</span></td>
				<td width=80 align=\"right\"><span class=\"style2\">" . number_format($PRICE, 2, ".", ",") . "</span></td>
				<td width=50 align=\"right\"><span class=\"style2\">" . number_format($row1["QTY"], 0, ".", ",") . "</span></td>
				<td width=70 align=\"right\"><span class=\"style2\">0</span></td>";

                                    echo "<td width=100 align=\"right\"><span class=\"style2\">" . number_format($subtot, 2, ".", ",") . "</span></td>
				<td align=\"right\"><span class=\"style3\"></span></tr>";
                                }
                                $totsuntot = $totsuntot + $subtot;
                                $i = $i + 1;
                            }

                            if ($row["DIS1"] > 0) {
                                $txtspdis = ""; // "Special Discount   " . floatval($row["DIS1"]) . " %";
                            }

//	if ($row["VAT"]=="0") {
                            $txtdis2 = 0; // $totsuntot/100 * $row["DIS1"];
//} else {
// 	$txtdis2= (($totsuntot / (1 + $row["GST"] / 100)) / 100) * $row["DIS1"];
//}

                            while ($i < 16) {
                                echo "<tr><td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td></tr>";
                                $i = $i + 1;
                            }
                            ?>


                        </table></td>
                </tr>
                <tr><td colspan="7" valign="top">
                        <table width="900" border="0">

                            <tr>
                                <td colspan="2"><?php echo date('Y-m-d h:i:a') ?></td>
                                <td width="60">&nbsp;</td>
                                <td colspan="2"><?php
                                if ($row["TYPE"] == "CR") {
                                    echo "<p style='font-size:21px;border-style: solid;text-align: center;'><b>60 Days Credit Only</b></p>";
                                }else if ($row["TYPE"] == "CA") {
                                    echo "<p style='font-size:21px;border-style: solid;text-align: center;'><b>Cash On Delivery</b></p>";
                                }
                                
                                ?></td>
                                <td width="236"><span class="style2"><?php echo $txtspdis; ?></span></td>
                                <td width="164" align="right"><span class="style2"><?php
                                        if ($txtdis2 > 0) {
                                            echo number_format($txtdis2, 2, ".", ",");
                                        }
                                        ?></span></td>
                            </tr>
                            <tr>
                                <?php
                                if ($_GET["delivachk"] == "Y") {
                                    echo "<td colspan = '5' style = 'color: black'>Delivary to&nbsp; " . $row['deli_name'] . "</td>";
                                } else {
                                    echo "<td colspan = '5'>&nbsp;</td>";
                                }
                                ?>  
                                <td>&nbsp;</td>


                                <td colspan="2"><span class="style2"><?php echo $txtsubtotdes; ?></span></td>
                                <td align="right"><span class="style2"><?php
                                        if ($txtsubtot > 0) {
                                            echo number_format($txtsubtot, 2, ".", ",");
                                        }
                                        ?></span></td>
                            </tr>
                            <tr>

                                <td colspan="3" style="color: black"><?php echo $row['deli_add'] ?></td>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                <td colspan="2"><span class="style2"><?php echo $RTXTVAT; ?></span></td>
                                <td align="right"><span class="style2"><?php
                                        if ($RTXVATAMU > 0) {
                                            echo number_format($RTXVATAMU, 2, ".", ",");
                                        }
                                        ?></span></td>

                            </tr>
                            <tr>
                                <td colspan="2"><span class="style2"><?php echo $txtPrePoints; ?></span></td>
                                <td ><span class="style2"><?php echo $txtInvPoints; ?></span></td>
                                <td colspan="2"><span class="style2"><?php echo $txtTotpoints; ?></span></td>
                                <td colspan="3">&nbsp;</td>
                                <td   align="right"><span class="style2"><?php
                                        if ($rtxttot > 0) {
                                            echo number_format($rtxttot, 2, ".", ",");
                                        }
                                        ?></span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span class="style2"><?php echo $txtentered; ?></span></td>
                                <td><span class="style2"><?php echo $txtauth; ?></span></td>
                                <td colspan="2">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span class="style2"><?php echo $txtrepono; ?></span></td>
                                <td colspan="2">&nbsp;</td>
                                <td colspan="3">&nbsp;</td>
                                <td></td>
                                <td align="right"><span class="style2"><?php echo $TXTDEP; ?></span></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
    </body>
</html>

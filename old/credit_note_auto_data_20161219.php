<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once("connectioni.php");



////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "view_inv") {


    $ResponseXML = "";
    $ResponseXML .= "<balancedetails>";

    $amount_40 = 0;
    $amount_43 = 0;
    $rtn_40 = 0;
    $rtn_43 = 0;
    $q40 = 0;
    $q43 = 0;
    $r40 = 0;
    $r43 = 0;
    $q37 = 0;
    $r37 = 0;
    $amount_37 = 0;
    $rtn_37 = 0;

    $sql = "delete from tmp_auto_credit_note";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    //$sql = "Select cus_code,sum(QTY) as qty from viewinv   where   s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and cancel_m='0' group by cus_code order by cus_code";
	$sql = "Select cus_code,sum(QTY) as qty from viewinv   where   s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by cus_code order by cus_code";
	
	
    $result = mysqli_query($GLOBALS['dbinv'], $sql);


    $ResponseXML .= "<balance_table><![CDATA[<table width=\"735\" border=\"0\" class=\"form-matrix-table\">";

    $i = 1;

//==============================VOLTA=======================================================================
    if (trim($_GET["combo1"]) == "VOLTA") {
        $ResponseXML .= "<tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
							 
   							</tr>";

        while ($row = mysqli_fetch_array($result)) {
            $amount_40 = 0;
            $amount_43 = 0;
            $amount_37 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;
            $rtn_37 = 0;
            $q40 = 0;
            $q43 = 0;
            $q37 = 0;
            $r40 = 0;
            $r43 = 0;
            $r37 = 0;
            $ccode = $row["cus_code"];


            $code = "";
            $name = "";
            $amount1 = 0;
            $qty1 = 0;
            $amount2 = 0;
            $qty20 = 0;
            $crnno = "";
            $txndate = "";
            $amount = 0;
            $status = "";
            $amount_c = 0;



            $sql = "Select sum(qty) as qty from viewinv where cus_code = '" . trim($row["cus_code"]) . "' and s_brand = 'ATLASBX' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m = '0' ";
            $result_rs = mysqli_query($GLOBALS['dbinv'], $sql);
            $rs = mysqli_fetch_array($result_rs);
            if (!is_null($rs)) {
                $qa = $rs['qty'];
            }

            $sql = "select sum(qty)as qty from viewcrntrn where c_code = '" . trim($row["cus_code"]) . "' and brand = 'ATLASBX' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancell = '0'  ";
            $result_rs = mysqli_query($GLOBALS['dbinv'], $sql);
            $rs = mysqli_fetch_array($result_rs);
            if (!is_null($rs)) {
                $qa = $qa - $rs['qty'];
            }


            if (($qa + $row["qty"]) >= 15 and ( $qa + $row["qty"]) < 40) {

                $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '35' and cancel_m='0' group by cus_code";
                $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

                $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per != '35' and cancel_m='0' group by cus_code";
                $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

                $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
                $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

                $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '35' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
                $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);



                if ($row_40 = mysqli_fetch_array($result_40)) {
                    if ($row_40["qty"] != "") {
                        $q40 = $row_40["qty"];
                    }
                    if ($row_40["amount"] != "") {
                        $amount_40 = $row_40["amount"];
                    }
                }

                if ($row_43 = mysqli_fetch_array($result_43)) {
                    if ($row_43["qty"] != "") {
                        $q43 = $row_43["qty"];
                    }
                    if ($row_43["amount"] != "") {
                        $amount_43 = $row_43["amount"];
                    }
                }

                if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                    if ($row_1_40["qty"] != "") {
                        $r40 = $row_1_40["qty"];
                    }
                    if ($row_1_40["grand_tot"] != "") {
                        $rtn_40 = $row_1_40["grand_tot"];
                    }
                }

                if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                    if ($row_1_43["qty"] != "") {
                        $r43 = $row_1_43["qty"];
                    }
                    if ($row_1_43["grand_tot"] != "") {
                        $rtn_43 = $row_1_43["grand_tot"];
                    }
                }

                $sql_rsven = "Select NAME from vendor where CODE = '" . $row["cus_code"] . "'";
                $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
                if ($row_rsven = mysqli_fetch_array($result_rsven)) {

                    if (((($q40 + $q43 + $qa) - ($r40 + $r43)) >= 15) and ( ($q40 - $r40) != 0)) {
//$ResponseXML .= "<tr><tr>ddddd</td></tr>";			
                        $ResponseXML .= "<tr>";
                        $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                        $ResponseXML .= "<td>" . $row_rsven['NAME'] . "</td>";
                        $ResponseXML .= "<td>" . ($amount_43 - $rtn_43) . "</td>";
                        $ResponseXML .= "<td>" . ($q43 - $r43) . "</td>";
                        $ResponseXML .= "<td>" . ($amount_40 - $rtn_40) . "</td>";
                        $ResponseXML .= "<td>" . ($q40 - $r40) . "</td>";

                        $code = $row["cus_code"];
                        $name = $row_rsven['NAME'];
                        $amount1 = ($amount_43 - $rtn_43);
                        $qty1 = $q43 - $r43;
                        $amount2 = ($amount_40 - $rtn_40);
                        $qty2 = $q40 - $r40;

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/V";

                        $chk = "chk" . $i;

                        $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                        $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                        if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                            $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
							<td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
							<td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
							<td></td>
							<td>Lock</td>
							<td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                            $crnno = $row_rs1["C_REFNO"];
                            $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                            $amount = $row_rs1["C_PAYMENT"];
                            $amount_c = 0;
                            $status = "Lock";

                            $i = $i + 1;
                        } else {
                            $ResponseXML .= "<td>Not Saved</td>
							<td></td>
							<td>" . number_format((($amount_40 - $rtn_40) / 65 * 2.5), 2, ".", ",") . "</td>
							<td></td>
							<td></td>
							<td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";


                            $crnno = "Not Saved";
                            $txndate = "";
                            $amount = (($amount_40 - $rtn_40) / 65 * 2.5);
                            $amount_c = 0;
                            $status = "";
                            $i = $i + 1;
                        }

                        $ResponseXML .= "</tr>";
                    }
                }
            }

            if (($row["qty"] + $qa) >= 40) {


                $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '35' and cancel_m='0' group by cus_code";
                $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

                $sql_37 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '37.5' and cancel_m='0' group by cus_code";
                $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

                $sql_1_37 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '37.5' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
                $result_1_37 = mysqli_query($GLOBALS['dbinv'], $sql_1_37);


                $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per != '35' and DIS_per!='37.5' and cancel_m='0' group by cus_code";
                $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

                $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
                $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

                $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '35' and DIS_P != '37.5' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
                $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);



                if ($row_40 = mysqli_fetch_array($result_40)) {
                    if ($row_40["qty"] != "") {
                        $q40 = $row_40["qty"];
                    }
                    if ($row_40["amount"] != "") {
                        $amount_40 = $row_40["amount"];
                    }
                }

                if ($row_43 = mysqli_fetch_array($result_43)) {
                    if ($row_43["qty"] != "") {
                        $q43 = $row_43["qty"];
                    }
                    if ($row_43["amount"] != "") {
                        $amount_43 = $row_43["amount"];
                    }
                }

                if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                    if ($row_1_40["qty"] != "") {
                        $r40 = $row_1_40["qty"];
                    }
                    if ($row_1_40["grand_tot"] != "") {
                        $rtn_40 = $row_1_40["grand_tot"];
                    }
                }

                if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                    if ($row_1_43["qty"] != "") {
                        $r43 = $row_1_43["qty"];
                    }
                    if ($row_1_43["grand_tot"] != "") {
                        $rtn_43 = $row_1_43["grand_tot"];
                    }
                }

                if ($row_37 = mysqli_fetch_array($result_37)) {
                    if ($row_37["qty"] != "") {
                        $q37 = $row_37["qty"];
                    }
                    if ($row_37["amount"] != "") {
                        $amount_37 = $row_37["amount"];
                    }
                }

                if ($row_1_37 = mysqli_fetch_array($result_1_37)) {
                    if ($row_1_37["qty"] != "") {
                        $r37 = $row_1_37["qty"];
                    }
                    if ($row_1_37["grand_tot"] != "") {
                        $rtn_37 = $row_1_37["grand_tot"];
                    }
                }

                $sql_rsven = "Select name from vendor where code = '" . trim($row["cus_code"]) . "'";
                $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
                $row_rsven = mysqli_fetch_array($result_rsven);
                if (((($q40 + $q43 + $q37 + $qa) - ($r40 + $r43 + $r37)) >= 40) and ( (($q40 + $q37) - ($r40 + $r37)) != 0)) {

                    $ResponseXML .= "<tr>";
                    $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                    $ResponseXML .= "<td>" . $row_rsven['name'] . "</td>";
                    $ResponseXML .= "<td>" . ($amount_43 - $rtn_43) . "</td>";
                    $ResponseXML .= "<td>" . ($q43 - $r43) . "</td>";
                    $ResponseXML .= "<td>" . (($amount_40 + $amount_37) - ($rtn_40 + $rtn_37)) . "</td>";
                    $ResponseXML .= "<td>" . (($q40 + $q37) - ($r40 + $r37)) . "</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['name'];
                    $amount1 = ($amount_43 - $rtn_43);
                    $qty1 = $q43 - $r43;
                    $amount2 = (($amount_40 + $amount_37) - ($rtn_40 + $rtn_37));
                    $qty2 = ($q40 + $q37) - ($r40 + $r37);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/V";

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
												   <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
												   <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td></td>
												   <td>Lock</td>
                                                                                                   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";
                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
												   <td></td>
												   <td>" . number_format((($amount_40 - $rtn_40) / 65 * 5) + (($amount_37 - $rtn_37) / 62.5 * 2.5), 2, ".", ",") . "</td>
												   <td></td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = (($amount_40 - $rtn_40) / 65 * 5) + (($amount_37 - $rtn_37) / 62.5 * 2.5);
                        $amount_c = 0;
                        $status = "";
                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                }
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
//echo "1-".$sql_tmp."</br>";
            }
        }
    }

    if (trim($_GET["combo1"]) == "ATLASBX") { 
        $ResponseXML .= "<tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
							 
   							</tr>";

        while ($row = mysqli_fetch_array($result)) {
            $amount_40 = 0;
            $amount_43 = 0;
            $amount_37 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;
            $rtn_37 = 0;
            $q40 = 0;
            $q43 = 0;
            $q37 = 0;
            $r40 = 0;
            $r43 = 0;
            $r37 = 0;
            $ccode = $row["cus_code"];


            $code = "";
            $name = "";
            $amount1 = 0;
            $qty1 = 0;
            $amount2 = 0;
            $qty20 = 0;
            $crnno = "";
            $txndate = "";
            $amount = 0;
            $status = "";
            $amount_c = 0;
$qa = 0;


            $sql = "Select sum(qty) as qty from viewinv where cus_code = '" . trim($row["cus_code"]) . "' and s_brand = 'VOLTA' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m = '0' ";
            $result_rs = mysqli_query($GLOBALS['dbinv'], $sql);
            $rs = mysqli_fetch_array($result_rs);
            if (!is_null($rs)) {
                $qa = $rs['qty'];
            }

            $sql = "select sum(qty)as qty from viewcrntrn where c_code = '" . trim($row["cus_code"]) . "' and brand = 'VOLTA' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell = '0'  ";
            $result_rs = mysqli_query($GLOBALS['dbinv'], $sql);
            $rs = mysqli_fetch_array($result_rs);
            if (!is_null($rs)) {
                $qa = $qa - $rs['qty'];
            }


            if (($qa + $row["qty"]) >= 20 and ( $qa + $row["qty"]) < 25) {

                $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '30' and cancel_m='0' group by cus_code";
                $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

                $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per != '30' and cancel_m='0' group by cus_code";
                $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

                $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '30' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
                $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

                $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '30' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
                $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);



                if ($row_40 = mysqli_fetch_array($result_40)) {
                    if ($row_40["qty"] != "") {
                        $q40 = $row_40["qty"];
                    }
                    if ($row_40["amount"] != "") {
                        $amount_40 = $row_40["amount"];
                    }
                }

                if ($row_43 = mysqli_fetch_array($result_43)) {
                    if ($row_43["qty"] != "") {
                        $q43 = $row_43["qty"];
                    }
                    if ($row_43["amount"] != "") {
                        $amount_43 = $row_43["amount"];
                    }
                }

                if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                    if ($row_1_40["qty"] != "") {
                        $r40 = $row_1_40["qty"];
                    }
                    if ($row_1_40["grand_tot"] != "") {
                        $rtn_40 = $row_1_40["grand_tot"];
                    }
                }

                if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                    if ($row_1_43["qty"] != "") {
                        $r43 = $row_1_43["qty"];
                    }
                    if ($row_1_43["grand_tot"] != "") {
                        $rtn_43 = $row_1_43["grand_tot"];
                    }
                }

                $sql_rsven = "Select NAME from vendor where CODE = '" . $row["cus_code"] . "'";
                $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
                if ($row_rsven = mysqli_fetch_array($result_rsven)) {

                    if (((($q40 + $q43 + $qa) - ($r40 + $r43)) >= 20) and ( ($q40 - $r40) != 0)) {
//$ResponseXML .= "<tr><tr>ddddd</td></tr>";			
                        $ResponseXML .= "<tr>";
                        $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                        $ResponseXML .= "<td>" . $row_rsven['NAME'] . "</td>";
                        $ResponseXML .= "<td>" . ($amount_43 - $rtn_43) . "</td>";
                        $ResponseXML .= "<td>" . ($q43 - $r43) . "</td>";
                        $ResponseXML .= "<td>" . ($amount_40 - $rtn_40) . "</td>";
                        $ResponseXML .= "<td>" . ($q40 - $r40) . "</td>";

                        $code = $row["cus_code"];
                        $name = $row_rsven['NAME'];
                        $amount1 = ($amount_43 - $rtn_43);
                        $qty1 = $q43 - $r43;
                        $amount2 = ($amount_40 - $rtn_40);
                        $qty2 = $q40 - $r40;

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/A";

                        $chk = "chk" . $i;

                        $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                        $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                        if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                            $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
							<td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
							<td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
							<td></td>
							<td>Lock</td>
							<td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                            $crnno = $row_rs1["C_REFNO"];
                            $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                            $amount = $row_rs1["C_PAYMENT"];
                            $amount_c = 0;
                            $status = "Lock";

                            $i = $i + 1;
                        } else {
                            $ResponseXML .= "<td>Not Saved</td>
							<td></td>
							<td>" . number_format((($amount_40 - $rtn_40) / 70 * 7.5), 2, ".", ",") . "</td>
							<td></td>
							<td></td>
							<td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";


                            $crnno = "Not Saved";
                            $txndate = "";
                            $amount = (($amount_40 - $rtn_40) / 70 * 7.5);
                            $amount_c = 0;
                            $status = "";
                            $i = $i + 1;
                        }

                        $ResponseXML .= "</tr>";
                    }
                }
            }

            if (($row["qty"] + $qa) >= 25) {


                $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '30' and cancel_m='0' group by cus_code";
                $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

                $sql_37 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '32.5' and cancel_m='0' group by cus_code";
                $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

                $sql_1_37 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '32.5' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
                $result_1_37 = mysqli_query($GLOBALS['dbinv'], $sql_1_37);


                $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per != '30' and DIS_per!='32.5' and cancel_m='0' group by cus_code";
                $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

                $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '30' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
                $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

                $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '30' and DIS_P != '32.5' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
                $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);



                if ($row_40 = mysqli_fetch_array($result_40)) {
                    if ($row_40["qty"] != "") {
                        $q40 = $row_40["qty"];
                    }
                    if ($row_40["amount"] != "") {
                        $amount_40 = $row_40["amount"];
                    }
                }

                if ($row_43 = mysqli_fetch_array($result_43)) {
                    if ($row_43["qty"] != "") {
                        $q43 = $row_43["qty"];
                    }
                    if ($row_43["amount"] != "") {
                        $amount_43 = $row_43["amount"];
                    }
                }

                if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                    if ($row_1_40["qty"] != "") {
                        $r40 = $row_1_40["qty"];
                    }
                    if ($row_1_40["grand_tot"] != "") {
                        $rtn_40 = $row_1_40["grand_tot"];
                    }
                }

                if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                    if ($row_1_43["qty"] != "") {
                        $r43 = $row_1_43["qty"];
                    }
                    if ($row_1_43["grand_tot"] != "") {
                        $rtn_43 = $row_1_43["grand_tot"];
                    }
                }

                if ($row_37 = mysqli_fetch_array($result_37)) {
                    if ($row_37["qty"] != "") {
                        $q37 = $row_37["qty"];
                    }
                    if ($row_37["amount"] != "") {
                        $amount_37 = $row_37["amount"];
                    }
                }

                if ($row_1_37 = mysqli_fetch_array($result_1_37)) {
                    if ($row_1_37["qty"] != "") {
                        $r37 = $row_1_37["qty"];
                    }
                    if ($row_1_37["grand_tot"] != "") {
                        $rtn_37 = $row_1_37["grand_tot"];
                    }
                }

                $sql_rsven = "Select name from vendor where code = '" . trim($row["cus_code"]) . "'";
                $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
                $row_rsven = mysqli_fetch_array($result_rsven);
                if (((($q40 + $q43 + $q37 + $qa) - ($r40 + $r43 + $r37)) >= 25) and ( (($q40 + $q37) - ($r40 + $r37)) != 0)) {

                    $ResponseXML .= "<tr>";
                    $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                    $ResponseXML .= "<td>" . $row_rsven['name'] . "</td>";
                    $ResponseXML .= "<td>" . ($amount_43 - $rtn_43) . "</td>";
                    $ResponseXML .= "<td>" . ($q43 - $r43) . "</td>";
                    $ResponseXML .= "<td>" . (($amount_40 + $amount_37) - ($rtn_40 + $rtn_37)) . "</td>";
                    $ResponseXML .= "<td>" . (($q40 + $q37) - ($r40 + $r37)) . "</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['name'];
                    $amount1 = ($amount_43 - $rtn_43);
                    $qty1 = $q43 - $r43;
                    $amount2 = (($amount_40 + $amount_37) - ($rtn_40 + $rtn_37));
                    $qty2 = ($q40 + $q37) - ($r40 + $r37);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/A";

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
												   <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
												   <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td></td>
												   <td>Lock</td>
                                                                                                   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";
                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
												   <td></td>
												   <td>" . number_format((($amount_40 - $rtn_40) / 70 * 10) + (($amount_37 - $rtn_37) / 67.5 * 7.5), 2, ".", ",") . "</td>
												   <td></td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = (($amount_40 - $rtn_40) / 70 * 10) + (($amount_37 - $rtn_37) / 67.5 * 7.5);
                        $amount_c = 0;
                        $status = "";
                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                }
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
//echo "1-".$sql_tmp."</br>";
            }
        }
    }

    


//==============================LINGLONG=======================================================================
    if (trim($_GET["combo1"]) == "LINGLONG") {
        $ResponseXML .= "
                   <tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
							 
   							</tr>";
//echo $sql;	
        while ($row = mysqli_fetch_array($result)) {
			$qa = 0;
            $amount_40 = 0;
            $amount_43 = 0;
            $amount_37 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;
            $rtn_37 = 0;
            $q40 = 0;
            $q43 = 0;
            $q37 = 0;
            $r40 = 0;
            $r43 = 0;
            $r37 = 0;
            $ccode = $row["cus_code"];


            $sql = "Select sum(qty) as qty from viewinv where cus_code = '" . trim($row["cus_code"]) . "' and s_brand = 'COOPER' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and cancel_m = '0' ";
            $result_rs = mysqli_query($GLOBALS['dbinv'], $sql);
            $rs = mysqli_fetch_array($result_rs);
            if (!is_null($rs)) {
                $qa = $rs['qty'];
            }

            $sql = "select sum(qty)as qty from viewcrntrn where c_code = '" . trim($row["cus_code"]) . "' and brand = 'COOPER' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and cancell = '0'  ";
            $result_rs = mysqli_query($GLOBALS['dbinv'], $sql);
            $rs = mysqli_fetch_array($result_rs);
            if (!is_null($rs)) {
                $qa = $qa - $rs['qty'];
            }

            $code = "";
            $name = "";
            $amount1 = 0;
            $qty1 = 0;
            $amount2 = 0;
            $qty20 = 0;
            $crnno = "";
            $txndate = "";
            $amount = 0;
            $status = "";
            $amount_c = 0;

            $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '35' and cancel_m='0' group by cus_code";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

            $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and dis_per <> '35' AND DIS_PER <> '37.5' and cancel_m='0' group by cus_code";
            $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

            $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0' group by C_CODE";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P <> '35' AND DIS_P <> '37.5' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0' group by C_CODE";
            $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

            $sql_37 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '37.5' and cancel_m='0' group by cus_code";
            $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

            $sql_1_37 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '37.5' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0' group by C_CODE";
            $result_1_37 = mysqli_query($GLOBALS['dbinv'], $sql_1_37);

            if ($row_40 = mysqli_fetch_array($result_40)) {
                if ($row_40["qty"] != "") {
                    $q40 = $row_40["qty"];
                }
                if ($row_40["amount"] != "") {
                    $amount_40 = $row_40["amount"];
                }
            }

            if ($row_43 = mysqli_fetch_array($result_43)) {
                if ($row_43["qty"] != "") {
                    $q43 = $row_43["qty"];
                }
                if ($row_43["amount"] != "") {
                    $amount_43 = $row_43["amount"];
                }
            }

            if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                if ($row_1_40["qty"] != "") {
                    $r40 = $row_1_40["qty"];
                }
                if ($row_1_40["grand_tot"] != "") {
                    $rtn_40 = $row_1_40["grand_tot"];
                }
            }

            if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                if ($row_1_43["qty"] != "") {
                    $r43 = $row_1_43["qty"];
                }
                if ($row_1_43["grand_tot"] != "") {
                    $rtn_43 = $row_1_43["grand_tot"];
                }
            }

            if ($row_37 = mysqli_fetch_array($result_37)) {
                if ($row_37["qty"] != "") {
                    $q37 = $row_37["qty"];
                }
                if ($row_37["amount"] != "") {
                    $amount_37 = $row_37["amount"];
                }
            }

            if ($row_1_37 = mysqli_fetch_array($result_1_37)) {
                if ($row_1_37["qty"] != "") {
                    $r37 = $row_1_37["qty"];
                }
                if ($row_1_37["grand_tot"] != "") {
                    $rtn_37 = $row_1_37["grand_tot"];
                }
            }



            $sql_rsven = "Select NAME from vendor where CODE = '" . $row["cus_code"] . "'";
            $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
            if ($row_rsven = mysqli_fetch_array($result_rsven)) {

                if (((($q40 + $q43 + $q37 + $qa) - ($r40 + $r43 + $r37)) >= 50) and ( ($q40 - $r40) != 0)) {
					 
                    $ResponseXML .= "<tr>
                           	  			<td>" . $row["cus_code"] . "</td>
                              			<td>" . $row_rsven['NAME'] . "</td>
                              			<td>" . number_format(($amount_43 - $rtn_43), 2, ".", ",") . "</td>
                                        <td>" . ($q43 - $r43) . "</td>
										<td>" . number_format(($amount_40 - $rtn_40), 2, ".", ",") . "</td>
										<td>" . ($q40 - $r40) . "</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['NAME'];
                    $amount1 = ($amount_43 - $rtn_43);
                    $qty1 = $q43 - $r43;
                    $amount2 = ($amount_40 - $rtn_40);
                    $qty2 = $q40 - $r40;

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L";

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
												   <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
												   <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td></td>
												   <td>Lock</td>";
                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";
                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
												   <td></td>
												   <td>" . number_format(((($amount_40 - $rtn_40) / 65 * 5.625) + (($amount_37 - $rtn_37) / 62.5 * 3.125)), 2, ".", ",") . "</td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = ((($amount_40 - $rtn_40) / 65 * 5.625) + (($amount_37 - $rtn_37) / 62.5 * 3.125));
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }


                    $ResponseXML .= "</tr>";
                } else if (((($q40 + $q43 + $q37 + $qa) - ($r40 + $r43 + $r37)) >= 30) And ( ($q40 - $r40) <> 0)) {
					 
                    $ResponseXML .= "<tr>
                           	  			<td>" . $row["cus_code"] . "</td>
                              			<td>" . $row_rsven['NAME'] . "</td>
                              			<td>" . number_format(($amount_37 - $rtn_37), 2, ".", ",") . "</td>
                                        <td>" . ($q37 - $r37) . "</td>
										<td>" . number_format(($amount_40 - $rtn_40), 2, ".", ",") . "</td>
										<td>" . ($q40 - $r40) . "</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['NAME'];
                    $amount1 = ($amount_43 - $rtn_43);
                    $qty1 = $q43 - $r43;
                    $amount2 = ($amount_40 - $rtn_40);
                    $qty2 = $q40 - $r40;

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L";

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
												   <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
												   <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td></td>
												   <td>Lock</td>";
                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";
                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
												   <td></td>
												   <td>" . number_format((($amount_40 - $rtn_40) / 65 * 2.5), 2, ".", ",") . "</td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = (($amount_40 - $rtn_40) / 65 * 2.5);
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }
                }
            }
			if ($code != "") {
            $sql_tmp = "insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
//echo "2-".$sql_tmp."</br>";
            $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
			
			IF (!$result_tmp) {
				ECHO mysqli_error($GLOBALS['dbinv']);
			}
        }
        }

//echo $row["cus_code"].":".$code." - ";
        
    }

//==============================COOPER=======================================================================
    if (trim($_GET["combo1"]) == "COOPER1") {
        $ResponseXML .= "
                            <tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
							 
   							</tr>";

        while ($row = mysqli_fetch_array($result)) {
            $amount_40 = 0;
            $amount_43 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;
            $q40 = 0;
            $q43 = 0;
            $r40 = 0;
            $r43 = 0;
            $ccode = $row["cus_code"];

            $code = "";
            $name = "";
            $amount1 = 0;
            $qty1 = 0;
            $amount2 = 0;
            $qty20 = 0;
            $crnno = "";
            $txndate = "";
            $amount = 0;
            $status = "";
            $amount_c = 0;

            $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '35' and cancel_m='0' group by cus_code";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

            $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != '35' and cancel_m='0' group by cus_code";
            $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

            $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0' group by C_CODE";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '35' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0' group by C_CODE";
            $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

            if ($row_40 = mysqli_fetch_array($result_40)) {
                if ($row_40["qty"] != "") {
                    $q40 = $row_40["qty"];
                }
                if ($row_40["amount"] != "") {
                    $amount_40 = $row_40["amount"];
                }
            }

            if ($row_43 = mysqli_fetch_array($result_43)) {
                if ($row_43["qty"] != "") {
                    $q43 = $row_43["qty"];
                }
                if ($row_43["amount"] != "") {
                    $amount_43 = $row_43["amount"];
                }
            }

            if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                if ($row_1_40["qty"] != "") {
                    $r40 = $row_1_40["qty"];
                }
                if ($row_1_40["grand_tot"] != "") {
                    $rtn_40 = $row_1_40["grand_tot"];
                }
            }

            if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                if ($row_1_43["qty"] != "") {
                    $r43 = $row_1_43["qty"];
                }
                if ($row_1_43["grand_tot"] != "") {
                    $rtn_43 = $row_1_43["grand_tot"];
                }
            }

            $sql_rsven = "Select NAME from vendor where CODE = '" . $row["cus_code"] . "'";
            $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
            if ($row_rsven = mysqli_fetch_array($result_rsven)) {

                if (((($q40 + $q43) - ($r40 + $r43)) >= 20) and ( ($q40 - $r40) != 0)) {

                    $ResponseXML .= "<tr>
                           	  			<td>" . $row["cus_code"] . "</td>
                              			<td>" . $row_rsven['NAME'] . "</td>
                              			<td>" . number_format(($amount_43 - $rtn_43), 2, ".", ",") . "</td>
                                        <td>" . ($q43 - $r43) . "</td>
										<td>" . number_format(($amount_40 - $rtn_40), 2, ".", ",") . "</td>
										<td>" . ($q40 - $r40) . "</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['NAME'];
                    $amount1 = ($amount_43 - $rtn_43);
                    $qty1 = $q43 - $r43;
                    $amount2 = ($amount_40 - $rtn_40);
                    $qty2 = $q40 - $r40;

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/C";

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
												   <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
												   <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td></td>
												   <td>Lock</td>";
//<td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";

                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
												   <td></td>
												   <td>" . number_format((($amount_40 - $rtn_40) / 65 * 2.5), 2, ".", ",") . "</td>
												   <td></td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = (($amount_40 - $rtn_40) / 65 * 2.5);
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                }
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
//echo "3-".$sql_tmp."</br>";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
            }
        }
    }

	
		    if (trim($_GET["combo1"]) == "CONSTANCY") {
        $ResponseXML .= "<tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
							 
   							</tr>";

        while ($row = mysqli_fetch_array($result)) {
            $amount_40 = 0;
            $amount_43 = 0;
            $amount_37 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;
            $rtn_37 = 0;
            $q40 = 0;
            $q43 = 0;
            $q37 = 0;
            $r40 = 0;
            $r43 = 0;
            $r37 = 0;
            $ccode = $row["cus_code"];


            $code = "";
            $name = "";
            $amount1 = 0;
            $qty1 = 0;
            $amount2 = 0;
            $qty20 = 0;
            $crnno = "";
            $txndate = "";
            $amount = 0;
            $status = "";
            $amount_c = 0;
$qa = 0;

 


            if (($qa + $row["qty"]) >= 10) {

                $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '35' and cancel_m='0' group by cus_code";
                $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

                $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per != '35' and cancel_m='0' group by cus_code";
                $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

                $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
                $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

                $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '35' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
                $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);



                if ($row_40 = mysqli_fetch_array($result_40)) {
                    if ($row_40["qty"] != "") {
                        $q40 = $row_40["qty"];
                    }
                    if ($row_40["amount"] != "") {
                        $amount_40 = $row_40["amount"];
                    }
                }

                if ($row_43 = mysqli_fetch_array($result_43)) {
                    if ($row_43["qty"] != "") {
                        $q43 = $row_43["qty"];
                    }
                    if ($row_43["amount"] != "") {
                        $amount_43 = $row_43["amount"];
                    }
                }

                if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                    if ($row_1_40["qty"] != "") {
                        $r40 = $row_1_40["qty"];
                    }
                    if ($row_1_40["grand_tot"] != "") {
                        $rtn_40 = $row_1_40["grand_tot"];
                    }
                }

                if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                    if ($row_1_43["qty"] != "") {
                        $r43 = $row_1_43["qty"];
                    }
                    if ($row_1_43["grand_tot"] != "") {
                        $rtn_43 = $row_1_43["grand_tot"];
                    }
                }

                $sql_rsven = "Select NAME from vendor where CODE = '" . $row["cus_code"] . "'";
                $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
                if ($row_rsven = mysqli_fetch_array($result_rsven)) {

                    if (((($q40 + $q43 + $qa) - ($r40 + $r43)) >= 10) and ( ($q40 - $r40) != 0)) {
//$ResponseXML .= "<tr><tr>ddddd</td></tr>";			
                        $ResponseXML .= "<tr>";
                        $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                        $ResponseXML .= "<td>" . $row_rsven['NAME'] . "</td>";
                        $ResponseXML .= "<td>" . ($amount_43 - $rtn_43) . "</td>";
                        $ResponseXML .= "<td>" . ($q43 - $r43) . "</td>";
                        $ResponseXML .= "<td>" . ($amount_40 - $rtn_40) . "</td>";
                        $ResponseXML .= "<td>" . ($q40 - $r40) . "</td>";

                        $code = $row["cus_code"];
                        $name = $row_rsven['NAME'];
                        $amount1 = ($amount_43 - $rtn_43);
                        $qty1 = $q43 - $r43;
                        $amount2 = ($amount_40 - $rtn_40);
                        $qty2 = $q40 - $r40;

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/CO";

                        $chk = "chk" . $i;

                        $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                        $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                        if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                            $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
							<td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
							<td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
							<td></td>
							<td>Lock</td>
							<td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                            $crnno = $row_rs1["C_REFNO"];
                            $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                            $amount = $row_rs1["C_PAYMENT"];
                            $amount_c = 0;
                            $status = "Lock";

                            $i = $i + 1;
                        } else {
                            $ResponseXML .= "<td>Not Saved</td>
							<td></td>
							<td>" . number_format((($amount_40 - $rtn_40) / 65 * 2.5), 2, ".", ",") . "</td>
							<td></td>
							<td></td>
							<td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";


                            $crnno = "Not Saved";
                            $txndate = "";
                            $amount = (($amount_40 - $rtn_40) / 65 * 2.5);
                            $amount_c = 0;
                            $status = "";
                            $i = $i + 1;
                        }

                        $ResponseXML .= "</tr>";
                    }
                }
            }

            

            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
//echo "1-".$sql_tmp."</br>";
            }
        }
    }
	
	
	
	    if (trim($_GET["combo1"]) == "COOPER") {
        $ResponseXML .= "<tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
							 
   							</tr>";

        while ($row = mysqli_fetch_array($result)) {
            $amount_40 = 0;
            $amount_43 = 0;
            $amount_37 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;
            $rtn_37 = 0;
            $q40 = 0;
            $q43 = 0;
            $q37 = 0;
            $r40 = 0;
            $r43 = 0;
            $r37 = 0;
            $ccode = $row["cus_code"];


            $code = "";
            $name = "";
            $amount1 = 0;
            $qty1 = 0;
            $amount2 = 0;
            $qty20 = 0;
            $crnno = "";
            $txndate = "";
            $amount = 0;
            $status = "";
            $amount_c = 0;
$qa = 0;

 




            if (($row["qty"] + $qa >= 25)) {


                $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '35' and cancel_m='0' group by cus_code";
                $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

                $sql_37 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '37.5' and cancel_m='0' group by cus_code";
                $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

                $sql_1_37 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '37.5' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
                $result_1_37 = mysqli_query($GLOBALS['dbinv'], $sql_1_37);


                $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per != '35' and DIS_per!='37.5' and cancel_m='0' group by cus_code";
                $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

                $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
                $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

                $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '35' and DIS_P != '37.5' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
                $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);



                if ($row_40 = mysqli_fetch_array($result_40)) {
                    if ($row_40["qty"] != "") {
                        $q40 = $row_40["qty"];
                    }
                    if ($row_40["amount"] != "") {
                        $amount_40 = $row_40["amount"];
                    }
                }

                if ($row_43 = mysqli_fetch_array($result_43)) {
                    if ($row_43["qty"] != "") {
                        $q43 = $row_43["qty"];
                    }
                    if ($row_43["amount"] != "") {
                        $amount_43 = $row_43["amount"];
                    }
                }

                if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                    if ($row_1_40["qty"] != "") {
                        $r40 = $row_1_40["qty"];
                    }
                    if ($row_1_40["grand_tot"] != "") {
                        $rtn_40 = $row_1_40["grand_tot"];
                    }
                }

                if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                    if ($row_1_43["qty"] != "") {
                        $r43 = $row_1_43["qty"];
                    }
                    if ($row_1_43["grand_tot"] != "") {
                        $rtn_43 = $row_1_43["grand_tot"];
                    }
                }

                if ($row_37 = mysqli_fetch_array($result_37)) {
                    if ($row_37["qty"] != "") {
                        $q37 = $row_37["qty"];
                    }
                    if ($row_37["amount"] != "") {
                        $amount_37 = $row_37["amount"];
                    }
                }

                if ($row_1_37 = mysqli_fetch_array($result_1_37)) {
                    if ($row_1_37["qty"] != "") {
                        $r37 = $row_1_37["qty"];
                    }
                    if ($row_1_37["grand_tot"] != "") {
                        $rtn_37 = $row_1_37["grand_tot"];
                    }
                }

                $sql_rsven = "Select name from vendor where code = '" . trim($row["cus_code"]) . "'";
                $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
                $row_rsven = mysqli_fetch_array($result_rsven);
                if (((($q40 + $q43 + $q37 + $qa) - ($r40 + $r43 + $r37)) >= 25) and ( (($q40 + $q37) - ($r40 + $r37)) != 0)) {

                    $ResponseXML .= "<tr>";
                    $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                    $ResponseXML .= "<td>" . $row_rsven['name'] . "</td>";
                    $ResponseXML .= "<td>" . ($amount_43 - $rtn_43) . "</td>";
                    $ResponseXML .= "<td>" . ($q43 - $r43) . "</td>";
                    $ResponseXML .= "<td>" . (($amount_40 + $amount_37) - ($rtn_40 + $rtn_37)) . "</td>";
                    $ResponseXML .= "<td>" . (($q40 + $q37) - ($r40 + $r37)) . "</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['name'];
                    $amount1 = ($amount_43 - $rtn_43);
                    $qty1 = $q43 - $r43;
                    $amount2 = (($amount_40 + $amount_37) - ($rtn_40 + $rtn_37));
                    $qty2 = ($q40 + $q37) - ($r40 + $r37);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/A";

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
												   <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
												   <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td></td>
												   <td>Lock</td>
                                                                                                   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";
                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
												   <td></td>
												   <td>" . number_format((($amount_40 - $rtn_40) / 65 * 2.5), 2, ".", ",") . "</td>
												   <td></td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = (($amount_40 - $rtn_40) / 65 * 2.5);
                        $amount_c = 0;
                        $status = "";
                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                }
            }
			
			
			
			
			
			
			

            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
//echo "1-".$sql_tmp."</br>";
            }
        }
    }

   

	    if (trim($_GET["combo1"]) == "GREENTOUR") {
        $ResponseXML .= "<tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
							 
   							</tr>";

        while ($row = mysqli_fetch_array($result)) {
            $amount_40 = 0;
            $amount_43 = 0;
            $amount_37 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;
            $rtn_37 = 0;
            $q40 = 0;
            $q43 = 0;
            $q37 = 0;
            $r40 = 0;
            $r43 = 0;
            $r37 = 0;
            $ccode = $row["cus_code"];


            $code = "";
            $name = "";
            $amount1 = 0;
            $qty1 = 0;
            $amount2 = 0;
            $qty20 = 0;
            $crnno = "";
            $txndate = "";
            $amount = 0;
            $status = "";
            $amount_c = 0;


			$qa  =0;	
           


            if (($qa + $row["qty"]) >= 20 and ( $qa + $row["qty"]) < 75) {

                $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '35' and cancel_m='0'  and stk_no <> 'G0034' and stk_no <> 'G0035' group by cus_code";
                $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

                $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != '35'  and DIS_per != '0' and cancel_m='0'  and stk_no <> 'G0034' and stk_no <> 'G0035' group by cus_code";
                $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

                $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0'  and stk_no <> 'G0034' and stk_no <> 'G0035'  group by C_CODE";
                $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

                $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '35'  and DIS_p != '0' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0'  and stk_no <> 'G0034' and stk_no <> 'G0035' group by C_CODE";
                $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);



                if ($row_40 = mysqli_fetch_array($result_40)) {
                    if ($row_40["qty"] != "") {
                        $q40 = $row_40["qty"];
                    }
                    if ($row_40["amount"] != "") {
                        $amount_40 = $row_40["amount"];
                    }
                }

                if ($row_43 = mysqli_fetch_array($result_43)) {
                    if ($row_43["qty"] != "") {
                        $q43 = $row_43["qty"];
                    }
                    if ($row_43["amount"] != "") {
                        $amount_43 = $row_43["amount"];
                    }
                }

                if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                    if ($row_1_40["qty"] != "") {
                        $r40 = $row_1_40["qty"];
                    }
                    if ($row_1_40["grand_tot"] != "") {
                        $rtn_40 = $row_1_40["grand_tot"];
                    }
                }

                if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                    if ($row_1_43["qty"] != "") {
                        $r43 = $row_1_43["qty"];
                    }
                    if ($row_1_43["grand_tot"] != "") {
                        $rtn_43 = $row_1_43["grand_tot"];
                    }
                }

                $sql_rsven = "Select NAME from vendor where CODE = '" . $row["cus_code"] . "'";
                $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
                if ($row_rsven = mysqli_fetch_array($result_rsven)) {

                    if (((($q40 + $q43 + $qa) - ($r40 + $r43)) >= 20) and ( ($q40 - $r40) != 0)) {
//$ResponseXML .= "<tr><tr>ddddd</td></tr>";			
                        $ResponseXML .= "<tr>";
                        $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                        $ResponseXML .= "<td>" . $row_rsven['NAME'] . "</td>";
                        $ResponseXML .= "<td>" . ($amount_43 - $rtn_43) . "</td>";
                        $ResponseXML .= "<td>" . ($q43 - $r43) . "</td>";
                        $ResponseXML .= "<td>" . ($amount_40 - $rtn_40) . "</td>";
                        $ResponseXML .= "<td>" . ($q40 - $r40) . "</td>";

                        $code = $row["cus_code"];
                        $name = $row_rsven['NAME'];
                        $amount1 = ($amount_43 - $rtn_43);
                        $qty1 = $q43 - $r43;
                        $amount2 = ($amount_40 - $rtn_40);
                        $qty2 = $q40 - $r40;

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/G";

                        $chk = "chk" . $i;

                        $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                        $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                        if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                            $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
							<td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
							<td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
							<td></td>
							<td>Lock</td>
							<td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                            $crnno = $row_rs1["C_REFNO"];
                            $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                            $amount = $row_rs1["C_PAYMENT"];
                            $amount_c = 0;
                            $status = "Lock";

                            $i = $i + 1;
                        } else {
                            $ResponseXML .= "<td>Not Saved</td>
							<td></td>
							<td>" . number_format((($amount_40 - $rtn_40) / 65 * 2.5), 2, ".", ",") . "</td>
							<td></td>
							<td></td>
							<td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";


                            $crnno = "Not Saved";
                            $txndate = "";
                            $amount = (($amount_40 - $rtn_40) / 65 * 2.5);
                            $amount_c = 0;
                            $status = "";
                            $i = $i + 1;
                        }

                        $ResponseXML .= "</tr>";
                    }
                }
            }

            if (($row["qty"] + $qa) >= 76) {


                $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '35' and cancel_m='0'  and stk_no <> 'G0034' and stk_no <> 'G0035' group by cus_code";
                $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

                $sql_37 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '37.5' and cancel_m='0' group by cus_code";
                $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

                $sql_1_37 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '37.5' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0'  and stk_no <> 'G0034' and stk_no <> 'G0035' group by C_CODE";
                $result_1_37 = mysqli_query($GLOBALS['dbinv'], $sql_1_37);


                $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != '35' and DIS_per!='37.5'  and stk_no <> 'G0034' and stk_no <> 'G0035' and cancel_m='0' group by cus_code";
                $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

                $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0'  and stk_no <> 'G0034' and stk_no <> 'G0035' group by C_CODE";
                $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

                $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '35' and DIS_P != '37.5' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0'  and stk_no <> 'G0034' and stk_no <> 'G0035' group by C_CODE";
                $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);



                if ($row_40 = mysqli_fetch_array($result_40)) {
                    if ($row_40["qty"] != "") {
                        $q40 = $row_40["qty"];
                    }
                    if ($row_40["amount"] != "") {
                        $amount_40 = $row_40["amount"];
                    }
                }

                if ($row_43 = mysqli_fetch_array($result_43)) {
                    if ($row_43["qty"] != "") {
                        $q43 = $row_43["qty"];
                    }
                    if ($row_43["amount"] != "") {
                        $amount_43 = $row_43["amount"];
                    }
                }

                if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                    if ($row_1_40["qty"] != "") {
                        $r40 = $row_1_40["qty"];
                    }
                    if ($row_1_40["grand_tot"] != "") {
                        $rtn_40 = $row_1_40["grand_tot"];
                    }
                }

                if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                    if ($row_1_43["qty"] != "") {
                        $r43 = $row_1_43["qty"];
                    }
                    if ($row_1_43["grand_tot"] != "") {
                        $rtn_43 = $row_1_43["grand_tot"];
                    }
                }

                if ($row_37 = mysqli_fetch_array($result_37)) {
                    if ($row_37["qty"] != "") {
                        $q37 = $row_37["qty"];
                    }
                    if ($row_37["amount"] != "") {
                        $amount_37 = $row_37["amount"];
                    }
                }

                if ($row_1_37 = mysqli_fetch_array($result_1_37)) {
                    if ($row_1_37["qty"] != "") {
                        $r37 = $row_1_37["qty"];
                    }
                    if ($row_1_37["grand_tot"] != "") {
                        $rtn_37 = $row_1_37["grand_tot"];
                    }
                }

                $sql_rsven = "Select name from vendor where code = '" . trim($row["cus_code"]) . "'";
                $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
                $row_rsven = mysqli_fetch_array($result_rsven);
                if (((($q40 + $q43 + $q37 + $qa) - ($r40 + $r43 + $r37)) >= 40) and ( (($q40 + $q37) - ($r40 + $r37)) != 0)) {

                    $ResponseXML .= "<tr>";
                    $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                    $ResponseXML .= "<td>" . $row_rsven['name'] . "</td>";
                    $ResponseXML .= "<td>" . ($amount_43 - $rtn_43) . "</td>";
                    $ResponseXML .= "<td>" . ($q43 - $r43) . "</td>";
                    $ResponseXML .= "<td>" . (($amount_40 + $amount_37) - ($rtn_40 + $rtn_37)) . "</td>";
                    $ResponseXML .= "<td>" . (($q40 + $q37) - ($r40 + $r37)) . "</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['name'];
                    $amount1 = ($amount_43 - $rtn_43);
                    $qty1 = $q43 - $r43;
                    $amount2 = (($amount_40 + $amount_37) - ($rtn_40 + $rtn_37));
                    $qty2 = ($q40 + $q37) - ($r40 + $r37);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/G";

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
												   <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
												   <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td></td>
												   <td>Lock</td>
                                                                                                   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";
                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
												   <td></td>
												   <td>" . number_format((($amount_40 - $rtn_40) / 65 * 5) + (($amount_37 - $rtn_37) / 62.5 * 2.5), 2, ".", ",") . "</td>
												   <td></td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = (($amount_40 - $rtn_40) / 65 * 5) + (($amount_37 - $rtn_37) / 62.5 * 2.5);
                        $amount_c = 0;
                        $status = "";
                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                }
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
//echo "1-".$sql_tmp."</br>";
            }
        }
    }


//==============================ROADSTONE=======================================================================
    if (trim($_GET["combo1"]) == "ROADSTONE") {
        $co = 1;
        $ResponseXML .= "
                            <tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">43%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">43%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">40%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">40%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
							 
   							</tr>";
//echo $sql;			
        while ($row = mysqli_fetch_array($result)) {


            $code = "";
            $name = "";
            $amount1 = 0;
            $qty1 = 0;
            $amount2 = 0;
            $qty2 = 0;
            $crnno = "";
            $txndate = "";
            $amount = 0;
            $status = "";


            $amount_40 = 0;
            $amount_43 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;
            $q40 = 0;
            $q43 = 0;
            $r40 = 0;
            $r43 = 0;

            $RTn = 0;
            $amount_40_C = 0;
            $amount_43_C = 0;
            $rtn_40_C = 0;
            $rtn_43_C = 0;
            $q40_C = 0;
            $q43_C = 0;
            $r40_C = 0;
            $r43_C = 0;
            $rtn_c = 0;
            $ccode = $row["cus_code"];

            $code = "";
            $name = "";
            $amount1 = 0;
            $qty1 = 0;
            $amount2 = 0;
            $qty20 = 0;
            $crnno = "";
            $txndate = "";
            $amount = 0;
            $status = "";
            $amount_c = 0;


            $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where  cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = 45 and cancel_m='0' group by cus_code";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

            $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != 45  and DIS_per != 0 and cancel_m='0' group by cus_code";
            $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

            $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = 45 and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_P != 0 and CANCELL='0' group by C_CODE";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != 45 and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_P != 0 and CANCELL='0' group by C_CODE";
            $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

            $sql_rst = "Select C_CODE,sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and CANCELL='0' and DIS_P != 0 group by C_CODE";
            $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);

            if (date("Y", strtotime($_GET["dte_dor"])) >= 2014) {
                $sql_RS_40_C = "Select cus_code,sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='ROADSTONE CHINA' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and DIS_per = 45 and cancel_m='0' group by cus_code";
                $result_RS_40_C = mysqli_query($GLOBALS['dbinv'], $sql_RS_40_C);

                $sql_43_C = "Select cus_code,sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='ROADSTONE CHINA' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(sdate)=" . date("Y", strtotime($_GET["dte_dor"])) . " and DIS_per != 45 and DIS_per != 0 and  cancel_m='0' group by cus_code";
                $result_43_C = mysqli_query($GLOBALS['dbinv'], $sql_43_C);

                $sql_RS1_40_C = "Select C_CODE,sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='ROADSTONE CHINA' and DIS_P = '45' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and DIS_P != 0 and CANCELL='0' group by C_CODE";
                $result_RS1_40_C = mysqli_query($GLOBALS['dbinv'], $sql_RS1_40_C);

                $sql_RS1_43_C = "Select C_CODE,sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='ROADSTONE CHINA' and DIS_P != 45 and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and DIS_P != 0 and CANCELL='0' group by C_CODE";
                $result_RS1_43_C = mysqli_query($GLOBALS['dbinv'], $sql_RS1_43_C);

                $sql_rst_c = "Select C_CODE,sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='ROADSTONE CHINA' and month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and DIS_P != 0 and CANCELL='0' group by C_CODE";
                $result_rst_c = mysqli_query($GLOBALS['dbinv'], $sql_rst_c);
            }


            if ($row_40 = mysqli_fetch_array($result_40)) {
                if ($row_40["qty"] != "") {
                    $q40 = $row_40["qty"];
                }
                if ($row_40["amount"] != "") {
                    $amount_40 = $row_40["amount"];
                }
            }

            if ($row_43 = mysqli_fetch_array($result_43)) {
                if ($row_43["qty"] != "") {
                    $q43 = $row_43["qty"];
                }
                if ($row_43["amount"] != "") {
                    $amount_43 = $row_43["amount"];
                }
            }

            if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                if ($row_1_40["qty"] != "") {
                    $r40 = $row_1_40["qty"];
                }
                if ($row_1_40["grand_tot"] != "") {
                    $rtn_40 = $row_1_40["grand_tot"];
                }
            }

            if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                if ($row_1_43["qty"] != "") {
                    $r43 = $row_1_43["qty"];
                }
                if ($row_1_43["grand_tot"] != "") {
                    $rtn_43 = $row_1_43["grand_tot"];
                }
            }

            if ($row_rst = mysqli_fetch_array($result_rst)) {

                if ($row_rst["grand_tot"] != "") {
                    $RTn = $row_rst["grand_tot"];
                }
            }

            if (date("Y", strtotime($_GET["dte_dor"])) >= 2014) {
                if ($row_RS_40_C = mysqli_fetch_array($result_RS_40_C)) {
                    if ($row_RS_40_C["qty"] != "") {
                        $q40_C = $row_RS_40_C["qty"];
                    }
                    if ($row_RS_40_C["amount"] != "") {
                        $amount_40_C = $row_RS_40_C["amount"];
                    }
                }
                if ($row_43_C = mysqli_fetch_array($result_43_C)) {
                    if ($row_43_C["qty"] != "") {
                        $q43_C = $row_43_C["qty"];
                    }
                    if ($row_43_C["amount"] != "") {
                        $amount_43_C = $row_43_C["amount"];
                    }
                }
                if ($row_RS1_40_C = mysqli_fetch_array($result_RS1_40_C)) {
                    if ($row_RS1_40_C["qty"] != "") {
                        $r40_C = $row_RS1_40_C["qty"];
                    }
                    if ($row_RS1_40_C["grand_tot"] != "") {
                        $rtn_40_C = $row_RS1_40_C["grand_tot"];
                    }
                }
                if ($row_RS1_43_C = mysqli_fetch_array($result_RS1_43_C)) {
                    if ($row_RS1_43_C["qty"] != "") {
                        $r43_C = $row_RS1_43_C["qty"];
                    }
                    if ($row_RS1_43_C["grand_tot"] != "") {
                        $rtn_43_C = $row_RS1_43_C["grand_tot"];
                    }
                }
                if ($row_rst_c = mysqli_fetch_array($result_rst_c)) {
                    if ($row_rst_c["grand_tot"] != "") {
                        $rtn_c = $row_rst_c["grand_tot"];
                    }
                }
            }

            $sql_rsven = "Select NAME from vendor where CODE = '" . $row["cus_code"] . "'";
            $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
            if ($row_rsven = mysqli_fetch_array($result_rsven)) {

                if ((($q40 + $q43 + $q40_C + $q43_C) - ($r40 + $r43 + $r40_C + $r43_C)) >= 100) {


                    $ResponseXML .= "<tr>";
                    $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                    $ResponseXML .= "<td>" . $row_rsven['NAME'] . "</td>";
                    $ResponseXML .= "<td>" . number_format(($amount_43 + $amount_43_C - $rtn_43 - $rtn_43_C), 2, ".", ",") . "</td>";
                    $ResponseXML .= "<td>" . ($q43 + $q43_C - $r43 - $r43_C) . "</td>";
                    $ResponseXML .= "<td>" . number_format(($amount_40 + $amount_40_C - $rtn_40 - $rtn_40_C), 2, ".", ",") . "</td>";
                    $ResponseXML .= "<td>" . ($q40 + $q40_C - $r40 - $r40_C) . "</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['NAME'];
                    $amount1 = ($amount_43 + $amount_43_C - $rtn_43 - $rtn_43_C);
                    $qty1 = $q43 + $q43_C - $r43 - $r43_C;
                    $amount2 = ($amount_40 + $amount_40_C - $rtn_40 - $rtn_40_C);
                    $qty2 = $q40 + $q40_C - $r40 - $r40_C;

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R";
                    $m_flag1 = date("m/Y", strtotime($_GET["dte_dor"])) . "/R-C";

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "' and CANCELL='0'";
                    $sql_rs2 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag1) . "' and CANCELL='0'";

                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);

                    $result_rs2 = mysqli_query($GLOBALS['dbinv'], $sql_rs2);
                    $row_rs2 = mysqli_fetch_array($result_rs2);

                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
												   <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
												   <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td>" . number_format($row_rs2["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td>Lock</td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = $row_rs2["C_PAYMENT"];
                        $status = "Lock";

                        $i = $i + 1;
                    } else {

                        $ResponseXML .= "<td>Not Saved</td>
												   <td></td>
												   <td>" . number_format((($amount_40 - $RTn) / 100) * 10, 2, ".", ",") . "</td>
												   <td>" . number_format((($amount_40_C - $rtn_c) / 100) * 10, 2, ".", ",") . "</td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = (($amount_40 - $RTn) / 100) * 10;
                        $amount_c = (($amount_40_C - $rtn_c) / 100) * 10;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                } else if ((($q40 + $q43 + $q40_C + $q43_C) - ($r40 + $r43 + $r40_C + $r43_C)) >= 50) {

                    $ResponseXML .= "<tr>
                           	  			<td>" . $row["cus_code"] . "</td>
                              			<td>" . $row_rsven['NAME'] . "</td>
                              			<td>" . number_format(($amount_43 + $amount_43_C - $rtn_43 - $rtn_43_C), 2, ".", ",") . "</td>
                                        <td>" . ($q43 + $q43_C - $r43 - $r43_C) . "</td>
										<td>" . number_format(($amount_40 + $amount_40_C - $rtn_40 - $rtn_40_C), 2, ".", ",") . "</td>
										<td>" . ($q40 + $q40_C - $r40 - $r40_C) . "</td>";



                    $code = $row["cus_code"];
                    $name = $row_rsven['NAME'];
                    $amount1 = ($amount_43 + $amount_43_C - $rtn_43 - $rtn_43_C);
                    $qty1 = $q43 + $q43_C - $r43 - $r43_C;
                    $amount2 = ($amount_40 + $amount_40_C - $rtn_40 - $rtn_40_C);
                    $qty2 = $q40 + $q40_C - $r40 - $r40_C;

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R";
                    $m_flag1 = date("m/Y", strtotime($_GET["dte_dor"])) . "/R-C";

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "' and CANCELL='0'";
                    $sql_rs2 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag1) . "' and CANCELL='0'";
//echo "2-".$sql_rs1;
                    $result_rs2 = mysqli_query($GLOBALS['dbinv'], $sql_rs2);
                    $row_rs2 = mysqli_fetch_array($result_rs2);

                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
												   <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
												   <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td>" . number_format($row_rs2["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td>Lock</td>
												   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = $row_rs2["C_PAYMENT"];
                        $status = "Lock";
                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
												   <td></td>
												   <td>" . number_format((($amount_40 - $RTn) / 100) * 8, 2, ".", ",") . "</td>
												   <td>" . number_format((($amount_40_C - $rtn_c) / 100) * 8, 2, ".", ",") . "</td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";



                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = (($amount_40 - $RTn) / 100) * 8;
                        $amount_c = (($amount_40_C - $rtn_c) / 100) * 8;
                        $status = "";
                        $i = $i + 1;
                    }
                    $ResponseXML .= "</tr>";
                } else if ((($q40 + $q43 + $q40_C + $q43_C) - ($r40 + $r43 + $r40_C + $r43_C)) >= 25) {

                    $ResponseXML .= "<tr>
                           	  			<td>" . $row["cus_code"] . "</td>
                              			<td>" . $row_rsven['NAME'] . "</td>
                              			<td>" . number_format(($amount_43 + $amount_43_C - $rtn_43 - $rtn_43_C), 2, ".", ",") . "</td>
                                        <td>" . ($q43 + $q43_C - $r43 - $r43_C) . "</td>
										<td>" . number_format(($amount_40 + $amount_40_C - $rtn_40 - $rtn_40_C), 2, ".", ",") . "</td>
										<td>" . ($q40 + $q40_C - $r40 - $r40_C) . "</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['NAME'];
                    $amount1 = ($amount_43 + $amount_43_C - $rtn_43 - $rtn_43_C);
                    $qty1 = $q43 + $q43_C - $r43 - $r43_C;
                    $amount2 = ($amount_40 + $amount_40_C - $rtn_40 - $rtn_40_C);
                    $qty2 = $q40 + $q40_C - $r40 - $r40_C;

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R";
                    $m_flag1 = date("m/Y", strtotime($_GET["dte_dor"])) . "/R-C";


                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "' and CANCELL='0'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
//echo "3-".$sql_rs1;
                    $sql_rs2 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag1) . "' and CANCELL='0'";
                    $result_rs2 = mysqli_query($GLOBALS['dbinv'], $sql_rs2);
                    $row_rs2 = mysqli_fetch_array($result_rs2);

                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
												   <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
												   <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td>" . number_format($row_rs2["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td>Lock</td>";
//<td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = $row_rs2["C_PAYMENT"];
                        $status = "Lock";
                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
												   <td></td>
												   <td>" . number_format((($amount_40 - $RTn) / 100) * 5, 2, ".", ",") . "</td>
												   <td>" . number_format((($amount_40_C - $rtn_c) / 100) * 5, 2, ".", ",") . "</td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";


                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = (($amount_40 - $RTn) / 100) * 5;
                        $amount_c = (($amount_40_C - $rtn_c) / 100) * 5;
                        $status = "";
                        $i = $i + 1;
                    }
                    $ResponseXML .= "</tr>";
                } else if ((($q40 + $q43 + $q40_C + $q43_C) - ($r40 + $r43 + $r40_C + $r43_C)) >= 15) {

                    $ResponseXML .= "<tr>
                     	  			<td>" . $row["cus_code"] . "</td>
                              			<td>" . $row_rsven['NAME'] . "</td>
                              			<td>" . number_format(($amount_43 + $amount_43_C - $rtn_43 - $rtn_43_C), 2, ".", ",") . "</td>
                                        <td>" . ($q43 + $q43_C - $r43 - $r43_C) . "</td>
										<td>" . number_format(($amount_40 + $amount_40_C - $rtn_40 - $rtn_40_C), 2, ".", ",") . "</td>
										<td>" . ($q40 + $q40_C - $r40 - $r40_C) . "</td>";




                    $code = $row["cus_code"];
                    $name = $row_rsven['NAME'];
                    $amount1 = ($amount_43 + $amount_43_C - $rtn_43 - $rtn_43_C);
                    $qty1 = $q43 + $q43_C - $r43 - $r43_C;
                    $amount2 = ($amount_40 + $amount_40_C - $rtn_40 - $rtn_40_C);
                    $qty2 = $q40 + $q40_C - $r40 - $r40_C;

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R";
                    $m_flag1 = date("m/Y", strtotime($_GET["dte_dor"])) . "/R-C";

                    $chk = "chk" . $i;


                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "' and CANCELL='0'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
//echo "4-".$sql_rs1;
                    $sql_rs2 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag1) . "' and CANCELL='0'";
                    $result_rs2 = mysqli_query($GLOBALS['dbinv'], $sql_rs2);
                    $row_rs2 = mysqli_fetch_array($result_rs2);

                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
												   <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
												   <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td>" . number_format($row_rs2["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td>Lock</td>";
//<td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $status = "Lock";
                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
												   <td></td>
												   <td>" . number_format((($amount_40 - $RTn) / 100) * 3, 2, ".", ",") . "</td>
												    <td>" . number_format((($amount_40_C - $rtn_c) / 100) * 3, 2, ".", ",") . "</td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = (($amount_40 - $RTn) / 100) * 3;
                        $amount_c = (($amount_40_C - $rtn_c) / 100) * 3;
                        $status = "";
                        $i = $i + 1;
                    }
                    $ResponseXML .= "</tr>";
                }
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
				if (!$result_tmp) {
					echo mysqli_error($GLOBALS['dbinv']);
				}
//echo "4-".$sql_tmp."</br>";
            }
        }
    }


    if (trim($_GET["combo1"]) == "PRESA1") {
        $ResponseXML .= "
                            <tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
							 
   							</tr>";

        while ($row = mysqli_fetch_array($result)) {
            $amount_40 = 0;
            $amount_43 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;

            $ccode = $row["cus_code"];

            $code = "";
            $name = "";
            $amount1 = 0;
            $qty1 = 0;
            $amount2 = 0;
            $qty20 = 0;
            $crnno = "";
            $txndate = "";
            $amount = 0;
            $status = "";
            $amount_c = 0;
            $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/P";

            $sql_40 = "SELECT GST, SUM(GRAND_TOT) AS TOT FROM S_SALMA WHERE C_CODE = '" . trim($row["cus_code"]) . "' and BRAND='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0'   GROUP BY GST";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);


            $sql_1_40 = "Select vatrate, sum(amount) as tot from View_cbal_cred where cuscode = '" . trim($row["cus_code"]) . "' and   brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0' AND TRN_TYPE = 'CNT' AND FLAG1 <> '1' AND C_SETINV <> '" . $m_flag . "' GROUP BY VATRATE";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select vatrate, sum(amount) as tot from C_bal where cuscode = '" . trim($row["cus_code"]) . "' and  TRN_TYPE = 'GRN' and Brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0'  GROUP BY VATRATE";
            $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

            while ($row_40 = mysqli_fetch_array($result_40)) {
                if ($row_40["TOT"] != "") {
                    $amount_40 = $amount_40 + ($row_40["TOT"] / (1 + ($row_40["GST"] / 100)));
                    $amount_43 = $amount_43 + $row_40["TOT"];
                }
            }

            while ($row_1_43 = mysqli_fetch_array($result_1_40)) {
                if ($row_1_43["tot"] != "") {
                    $rtn_40 = $rtn_40 + ($row_1_43["tot"] / (1 + ($row_1_43["vatrate"] / 100)));
                    $rtn_43 = $rtn_43 + $row_1_43["tot"];
                }
            }

            while ($row_1_40 = mysqli_fetch_array($result_1_43)) {
                if ($row_1_40["tot"] != "") {
                    $rtn_40 = $rtn_40 + ($row_1_40["tot"] / (1 + ($row_1_40["vatrate"] / 100)));
                    $rtn_43 = $rtn_43 + $row_1_40["tot"];
                }
            }



            $sql_rsven = "Select NAME from vendor where CODE = '" . $row["cus_code"] . "'";
            $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
            if ($row_rsven = mysqli_fetch_array($result_rsven)) {
				 
                if ($amount_40 - $rtn_40 >= 750000) {

                    $ResponseXML .= "<tr>
                           	  			<td>" . $row["cus_code"] . "</td>
                              			<td>" . $row_rsven['NAME'] . "</td>
                              			<td>0</td>
                                        <td>0</td>
										<td>" . number_format(($amount_43 - $rtn_43), 2, ".", ",") . "</td>
										<td>0</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['NAME'];
                    $amount1 = ($amount_43 - $rtn_43);
                    $qty1 = $q43 - $r43;
                    $amount2 = ($amount_40 - $rtn_40);
                    $qty2 = $q40 - $r40;



                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
												   <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
												   <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td></td>
												   <td>Lock</td>";
//<td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";

                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
                                       <td></td>
                                       <td>" . number_format(((($amount_43 - $rtn_43) / 100) * 6), 2, ".", ",") . "</td>
                                       <td></td>
                                       <td></td>
                                       <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = ((($amount_43 - $rtn_43) / 100) * 6);
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                } else if ($amount_40 - $rtn_40 >= 500000) {

                    $ResponseXML .= "<tr>
                           	  			<td>" . $row["cus_code"] . "</td>
                              			<td>" . $row_rsven['NAME'] . "</td>
                              			<td>0</td>
                                        <td>0</td>
										<td>" . number_format(($amount_43 - $rtn_43), 2, ".", ",") . "</td>
										<td>0</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['NAME'];
                    $amount1 = ($amount_43 - $rtn_43);
                    $qty1 = $q43 - $r43;
                    $amount2 = ($amount_40 - $rtn_40);
                    $qty2 = $q40 - $r40;



                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
												   <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
												   <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td></td>
												   <td>Lock</td>";
//<td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";

                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
                                       <td></td>
                                       <td>" . number_format(((($amount_43 - $rtn_43) / 100) * 5), 2, ".", ",") . "</td>
                                       <td></td>
                                       <td></td>
                                       <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = ((($amount_43 - $rtn_43) / 100) * 5);
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                } else if ($amount_40 - $rtn_40 >= 250000) {

                    $ResponseXML .= "<tr>
                           	  			<td>" . $row["cus_code"] . "</td>
                              			<td>" . $row_rsven['NAME'] . "</td>
                              			<td>0</td>
                                        <td>0</td>
										<td>" . number_format(($amount_43 - $rtn_43), 2, ".", ",") . "</td>
										<td>0</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['NAME'];
                    $amount1 = ($amount_43 - $rtn_43);
                    $qty1 = $q43 - $r43;
                    $amount2 = ($amount_40 - $rtn_40);
                    $qty2 = $q40 - $r40;



                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
                                       <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
                                       <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
                                       <td></td>
                                       <td>Lock</td>";
//<td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";

                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
                                       <td></td>
                                       <td>" . number_format(((($amount_43 - $rtn_43) / 100) * 3.5), 2, ".", ",") . "</td>
                                       <td></td>
                                       <td></td>
                                       <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = ((($amount_43 - $rtn_43) / 100) * 3.5);
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                }
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
//echo "3-".$sql_tmp."</br>";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
            }
        }
    }


	
    if (trim($_GET["combo1"]) == "PRESA") {
        $ResponseXML .= "<tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
							 
   							</tr>";

        while ($row = mysqli_fetch_array($result)) {
            $amount_40 = 0;
            $amount_43 = 0;
            $amount_37 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;
            $rtn_37 = 0;
            $q40 = 0;
            $q43 = 0;
            $q37 = 0;
            $r40 = 0;
            $r43 = 0;
            $r37 = 0;
            $ccode = $row["cus_code"];


            $code = "";
            $name = "";
            $amount1 = 0;
            $qty1 = 0;
            $amount2 = 0;
            $qty20 = 0;
            $crnno = "";
            $txndate = "";
            $amount = 0;
            $status = "";
            $amount_c = 0;
            $qa = 0;




            if (($qa + $row["qty"]) >= 1) {

                $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '40' and cancel_m='0' group by cus_code";
                $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

                $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != '40' and DIS_per !=0 and cancel_m='0' group by cus_code";
                $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

                $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '40' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_P !=0  and CANCELL='0' group by C_CODE";
                $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

                $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '40' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "'  and DIS_P !=0  and CANCELL='0' group by C_CODE";
                $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

                $sql_37 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '42.5' and cancel_m='0' group by cus_code";
                $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

                $sql_1_37 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '42.5' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0'  and DIS_P !=0  group by C_CODE";
                $result_1_37 = mysqli_query($GLOBALS['dbinv'], $sql_1_37);

                if ($row_40 = mysqli_fetch_array($result_40)) {
                    if ($row_40["qty"] != "") {
                        $q40 = $row_40["qty"];
                    }
                    if ($row_40["amount"] != "") {
                        $amount_40 = $row_40["amount"];
                    }
                }

                if ($row_43 = mysqli_fetch_array($result_43)) {
                    if ($row_43["qty"] != "") {
                        $q43 = $row_43["qty"];
                    }
                    if ($row_43["amount"] != "") {
                        $amount_43 = $row_43["amount"];
                    }
                }

                if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                    if ($row_1_40["qty"] != "") {
                        $r40 = $row_1_40["qty"];
                    }
                    if ($row_1_40["grand_tot"] != "") {
                        $rtn_40 = $row_1_40["grand_tot"];
                    }
                }

                if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                    if ($row_1_43["qty"] != "") {
                        $r43 = $row_1_43["qty"];
                    }
                    if ($row_1_43["grand_tot"] != "") {
                        $rtn_43 = $row_1_43["grand_tot"];
                    }
                }


                if ($row_37 = mysqli_fetch_array($result_37)) {
                    if ($row_37["qty"] != "") {
                        $q37 = $row_37["qty"];
                    }
                    if ($row_37["amount"] != "") {
                        $amount_37 = $row_37["amount"];
                    }
                }

                if ($row_1_37 = mysqli_fetch_array($result_1_37)) {
                    if ($row_1_37["qty"] != "") {
                        $r37 = $row_1_37["qty"];
                    }
                    if ($row_1_37["grand_tot"] != "") {
                        $rtn_37 = $row_1_37["grand_tot"];
                    }
                }

                    
                $sql_rsven = "Select NAME from vendor where CODE = '" . $row["cus_code"] . "'";
                $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
                $row_rsven = mysqli_fetch_array($result_rsven);
				
				$q1 = 0;
				$q2 =0;
				$va1 = 0;
				$va2 =0;
				$comm1 = 0;
			    $comm2 = 0;
							
                    if (($q40 + $q43 + $q37 + $qa) - ($r40 + $r43 + $r37) >= 25 And ( $q40 - $r40) <> 0) {
 					
							
							$va1 = ($amount_43 - $rtn_43);
                       		$q1 = ($q43 - $r43);
                       		$va2 = ($amount_40 - $rtn_40);
                       	    $q2 =($q40 - $r40);
							
							$comm1 = (($amount_40 - $rtn_40) / 60 * 2.5) + (($amount_43 - $rtn_43) / 60 * 2.5);
							$comm2 = 0;
											
                    }
                
                $amount_40 = 0;
                $amount_43 = 0;
                $amount_37 = 0;
                $rtn_40 = 0;
                $rtn_43 = 0;
                $rtn_37 = 0;
                $q40 = 0;
                $q43 = 0;
                $q37 = 0;
                $r40 = 0;
                $r43 = 0;
                $r37 = 0;
                $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv1   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '35' and cancel_m='0'  AND GROUP1 = '1000'  group by cus_code";
                $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

                $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv1   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != '35'  and DIS_per !=0   and  cancel_m='0'  AND GROUP1 = '1000'  group by cus_code";
                $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

                $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0'  AND GROUP1 = '1000'  group by C_CODE";
                $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

                $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '35'  and DIS_per !=0  and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0'  and DIS_P !=0   AND GROUP1 = '1000'  group by C_CODE";
                $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

                $sql_37 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv1   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '37.5' and cancel_m='0'  AND GROUP1 = '1000'   and DIS_per !=0  group by cus_code";
                $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

                $sql_1_37 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '37.5' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0'  AND GROUP1 = '1000'  and DIS_P !=0  group by C_CODE";
                $result_1_37 = mysqli_query($GLOBALS['dbinv'], $sql_1_37);

                if ($row_40 = mysqli_fetch_array($result_40)) {
                    if ($row_40["qty"] != "") {
                        $q40 = $row_40["qty"];
                    }
                    if ($row_40["amount"] != "") {
                        $amount_40 = $row_40["amount"];
                    }
                }

                if ($row_43 = mysqli_fetch_array($result_43)) {
                    if ($row_43["qty"] != "") {
                        $q43 = $row_43["qty"];
                    }
                    if ($row_43["amount"] != "") {
                        $amount_43 = $row_43["amount"];
                    }
                }

                if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                    if ($row_1_40["qty"] != "") {
                        $r40 = $row_1_40["qty"];
                    }
                    if ($row_1_40["grand_tot"] != "") {
                        $rtn_40 = $row_1_40["grand_tot"];
                    }
                }

                if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                    if ($row_1_43["qty"] != "") {
                        $r43 = $row_1_43["qty"];
                    }
                    if ($row_1_43["grand_tot"] != "") {
                        $rtn_43 = $row_1_43["grand_tot"];
                    }
                }


                if ($row_37 = mysqli_fetch_array($result_37)) {
                    if ($row_37["qty"] != "") {
                        $q37 = $row_37["qty"];
                    }
                    if ($row_37["amount"] != "") {
                        $amount_37 = $row_37["amount"];
                    }
                }

                if ($row_1_37 = mysqli_fetch_array($result_1_37)) {
                    if ($row_1_37["qty"] != "") {
                        $r37 = $row_1_37["qty"];
                    }
                    if ($row_1_37["grand_tot"] != "") {
                        $rtn_37 = $row_1_37["grand_tot"];
                    }
                }

                $gq1 = 0;
				$gq2 =0;
				$gva1 = 0;
				$gva2 =0;
				$gcomm1 = 0;
			    $gcomm2 = 0;

                    if (($q40 + $q43 + $q37 + $qa) - ($r40 + $r43 + $r37) >= 6 And ( $q40 - $r40) <> 0) {
 
                       		$va1 = ($amount_43 - $rtn_43) + ($va1-($amount_43 - $rtn_43))  ;
                       		$q1 =  ($q43 - $r43) + ($q1 -($q43 - $r43) ) ;
                       		$va2 =  ($amount_40 - $rtn_40) + ($va2- ($amount_40 - $rtn_40)) ;
                       	    $q2 = ($q40 - $r40)+($q2-($q40 - $r40));
							
							$comm1 = $comm1 + ((($amount_40 - $rtn_40) / 60 * 2.5) + (($amount_43 - $rtn_43) / 60 * 2.5));
							$gcomm2 = 0;
			
                         
                    }
                 

				//t col
				 
				if ($comm1 >0) {
					$ResponseXML .= "<tr>";
                        $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                        $ResponseXML .= "<td>" . $row_rsven['NAME'] . "</td>";
                        $ResponseXML .= "<td>" . ($va1) . "</td>";
                        $ResponseXML .= "<td>" . ($q1) . "</td>";
                        $ResponseXML .= "<td>" . ($va2) . "</td>";
                        $ResponseXML .= "<td>" . ($q2) . "</td>";

                        $code = $row["cus_code"];
                        $name = $row_rsven['NAME'];
                        $amount1 = ($va1);
                        $qty1 =$q1;
                        $amount2 = ($va2);
                        $qty2 =$q2;

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/AG";

                        $chk = "chk" . $i;

                        $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                        $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                        if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                            $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
							<td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
							<td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
							<td></td>
							<td>Lock</td>
							<td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                            $crnno = $row_rs1["C_REFNO"];
                            $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                            $amount = $row_rs1["C_PAYMENT"];
                            $amount_c = 0;
                            $status = "Lock";

                            $i = $i + 1;
                        } else {
                            $ResponseXML .= "<td>Not Saved</td>
							<td></td>
							<td>" . number_format($comm1, 2, ".", ",") . "</td>
							<td></td>
							<td></td>
							<td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";


                            $crnno = "Not Saved";
                            $txndate = "";
                            $amount = ($comm1);
                            $amount_c = 0;
                            $status = "";
                            $i = $i + 1;
                        }

                        $ResponseXML .= "</tr>";
				}


            } 
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
//echo "1-".$sql_tmp."</br>";
            }
        }
    }


	
	
    if (trim($_GET["combo1"]) == "WILLFLY") {
        $ResponseXML .= "
                            <tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
							 
   							</tr>";

        while ($row = mysqli_fetch_array($result)) {
            $amount_40 = 0;
            $amount_43 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;
            $q40 = 0;
            $q43 = 0;
            $r40 = 0;
            $r43 = 0;
            $ccode = $row["cus_code"];

            $code = "";
            $name = "";
            $amount1 = 0;
            $qty1 = 0;
            $amount2 = 0;
            $qty20 = 0;
            $crnno = "";
            $txndate = "";
            $amount = 0;
            $status = "";
            $amount_c = 0;

            $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '35' and cancel_m='0' AND STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' group by cus_code";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

            $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != '35' and cancel_m='0' AND STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' group by cus_code";
            $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

            $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0' AND STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003'  group by C_CODE";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '35'  and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0' AND STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' group by C_CODE";
            $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

            if ($row_40 = mysqli_fetch_array($result_40)) {
                if ($row_40["qty"] != "") {
                    $q40 = $row_40["qty"];
                }
                if ($row_40["amount"] != "") {
                    $amount_40 = $row_40["amount"];
                }
            }

            if ($row_43 = mysqli_fetch_array($result_43)) {
                if ($row_43["qty"] != "") {
                    $q43 = $row_43["qty"];
                }
                if ($row_43["amount"] != "") {
                    $amount_43 = $row_43["amount"];
                }
            }

            if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                if ($row_1_40["qty"] != "") {
                    $r40 = $row_1_40["qty"];
                }
                if ($row_1_40["grand_tot"] != "") {
                    $rtn_40 = $row_1_40["grand_tot"];
                }
            }

            if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                if ($row_1_43["qty"] != "") {
                    $r43 = $row_1_43["qty"];
                }
                if ($row_1_43["grand_tot"] != "") {
                    $rtn_43 = $row_1_43["grand_tot"];
                }
            }

            $sql_rsven = "Select NAME from vendor where CODE = '" . $row["cus_code"] . "'";
            $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
            if ($row_rsven = mysqli_fetch_array($result_rsven)) {

			
				//   if (((($q40 + $q43) - ($r40 + $r43)) >= 120) and ( ($q40 - $r40) != 0)) {
                if (((($q40 + $q43) - ($r40 + $r43)) >= 80) and ( ($q40 - $r40) != 0)) {

                    $ResponseXML .= "<tr>
                           	  			<td>" . $row["cus_code"] . "</td>
                              			<td>" . $row_rsven['NAME'] . "</td>
                              			<td>" . number_format(($amount_43 - $rtn_43), 2, ".", ",") . "</td>
                                        <td>" . ($q43 - $r43) . "</td>
										<td>" . number_format(($amount_40 - $rtn_40), 2, ".", ",") . "</td>
										<td>" . ($q40 - $r40) . "</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['NAME'];
                    $amount1 = ($amount_43 - $rtn_43);
                    $qty1 = $q43 - $r43;
                    $amount2 = ($amount_40 - $rtn_40);
                    $qty2 = $q40 - $r40;

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/W";

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
												   <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
												   <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td></td>
												   <td>Lock</td>";
//<td><input type=\"checkbox\" name=\"".$chk."\" id=\"".$chk."\" onclick=\"changechk('".$i."', '".$code."');\"  /></td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";

                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
												   <td></td>
												   <td>" . number_format((($amount_40 - $rtn_40) / 65 * 2.5), 2, ".", ",") . "</td>
												   <td></td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = (($amount_40 - $rtn_40) / 65 *2.5);   // from 2.5 
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                }
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
//echo "3-".$sql_tmp."</br>";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
            }
        }
    }


    if (trim($_GET["combo1"]) == "AGATE") {
        $ResponseXML .= "<tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">37.5%/40%Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5%Amt</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/37.5Qty</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN No</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Date</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Amount</font></td>
							  <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\"></font></td>
							 
   							</tr>";

        while ($row = mysqli_fetch_array($result)) {
            $amount_40 = 0;
            $amount_43 = 0;
            $amount_37 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;
            $rtn_37 = 0;
            $q40 = 0;
            $q43 = 0;
            $q37 = 0;
            $r40 = 0;
            $r43 = 0;
            $r37 = 0;
            $ccode = $row["cus_code"];


            $code = "";
            $name = "";
            $amount1 = 0;
            $qty1 = 0;
            $amount2 = 0;
            $qty20 = 0;
            $crnno = "";
            $txndate = "";
            $amount = 0;
            $status = "";
            $amount_c = 0;
            $qa = 0;




            if (($qa + $row["qty"]) >= 10) {

                $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '35' and cancel_m='0' group by cus_code";
                $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

                $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != '35' and cancel_m='0' group by cus_code";
                $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

                $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0' group by C_CODE";
                $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

                $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '35' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0' group by C_CODE";
                $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

                $sql_37 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '37.5' and cancel_m='0' group by cus_code";
                $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

                $sql_1_37 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '37.5' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0' group by C_CODE";
                $result_1_37 = mysqli_query($GLOBALS['dbinv'], $sql_1_37);

                if ($row_40 = mysqli_fetch_array($result_40)) {
                    if ($row_40["qty"] != "") {
                        $q40 = $row_40["qty"];
                    }
                    if ($row_40["amount"] != "") {
                        $amount_40 = $row_40["amount"];
                    }
                }

                if ($row_43 = mysqli_fetch_array($result_43)) {
                    if ($row_43["qty"] != "") {
                        $q43 = $row_43["qty"];
                    }
                    if ($row_43["amount"] != "") {
                        $amount_43 = $row_43["amount"];
                    }
                }

                if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                    if ($row_1_40["qty"] != "") {
                        $r40 = $row_1_40["qty"];
                    }
                    if ($row_1_40["grand_tot"] != "") {
                        $rtn_40 = $row_1_40["grand_tot"];
                    }
                }

                if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                    if ($row_1_43["qty"] != "") {
                        $r43 = $row_1_43["qty"];
                    }
                    if ($row_1_43["grand_tot"] != "") {
                        $rtn_43 = $row_1_43["grand_tot"];
                    }
                }


                if ($row_37 = mysqli_fetch_array($result_37)) {
                    if ($row_37["qty"] != "") {
                        $q37 = $row_37["qty"];
                    }
                    if ($row_37["amount"] != "") {
                        $amount_37 = $row_37["amount"];
                    }
                }

                if ($row_1_37 = mysqli_fetch_array($result_1_37)) {
                    if ($row_1_37["qty"] != "") {
                        $r37 = $row_1_37["qty"];
                    }
                    if ($row_1_37["grand_tot"] != "") {
                        $rtn_37 = $row_1_37["grand_tot"];
                    }
                }

                    
                $sql_rsven = "Select NAME from vendor where CODE = '" . $row["cus_code"] . "'";
                $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
                $row_rsven = mysqli_fetch_array($result_rsven);
				
				$q1 = 0;
				$q2 =0;
				$va1 = 0;
				$va2 =0;
				$comm1 = 0;
			    $comm2 = 0;
							
                    if (($q40 + $q43 + $q37 + $qa) - ($r40 + $r43 + $r37) >= 10 And ( $q40 - $r40) <> 0) {
 					
							
							$va1 = ($amount_43 - $rtn_43);
                       		$q1 = ($q43 - $r43);
                       		$va2 = ($amount_40 - $rtn_40);
                       	    $q2 =($q40 - $r40);
							
							$comm1 = (($amount_40 - $rtn_40) / 65 * 5.625) + (($amount_43 - $rtn_43) / 62.5 * 3.125);
							$comm2 = 0;
											
                    }
                
                $amount_40 = 0;
                $amount_43 = 0;
                $amount_37 = 0;
                $rtn_40 = 0;
                $rtn_43 = 0;
                $rtn_37 = 0;
                $q40 = 0;
                $q43 = 0;
                $q37 = 0;
                $r40 = 0;
                $r43 = 0;
                $r37 = 0;
                $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv1   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '35' and cancel_m='0'  AND GROUP1 = '1000'  group by cus_code";
                $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

                $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv1   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != '35' and cancel_m='0'  AND GROUP1 = '1000'  group by cus_code";
                $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

                $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0'  AND GROUP1 = '1000'  group by C_CODE";
                $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

                $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '35' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0'  AND GROUP1 = '1000'  group by C_CODE";
                $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

                $sql_37 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv1   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '37.5' and cancel_m='0'  AND GROUP1 = '1000'  group by cus_code";
                $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

                $sql_1_37 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '37.5' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0'  AND GROUP1 = '1000'  group by C_CODE";
                $result_1_37 = mysqli_query($GLOBALS['dbinv'], $sql_1_37);

                if ($row_40 = mysqli_fetch_array($result_40)) {
                    if ($row_40["qty"] != "") {
                        $q40 = $row_40["qty"];
                    }
                    if ($row_40["amount"] != "") {
                        $amount_40 = $row_40["amount"];
                    }
                }

                if ($row_43 = mysqli_fetch_array($result_43)) {
                    if ($row_43["qty"] != "") {
                        $q43 = $row_43["qty"];
                    }
                    if ($row_43["amount"] != "") {
                        $amount_43 = $row_43["amount"];
                    }
                }

                if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                    if ($row_1_40["qty"] != "") {
                        $r40 = $row_1_40["qty"];
                    }
                    if ($row_1_40["grand_tot"] != "") {
                        $rtn_40 = $row_1_40["grand_tot"];
                    }
                }

                if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                    if ($row_1_43["qty"] != "") {
                        $r43 = $row_1_43["qty"];
                    }
                    if ($row_1_43["grand_tot"] != "") {
                        $rtn_43 = $row_1_43["grand_tot"];
                    }
                }


                if ($row_37 = mysqli_fetch_array($result_37)) {
                    if ($row_37["qty"] != "") {
                        $q37 = $row_37["qty"];
                    }
                    if ($row_37["amount"] != "") {
                        $amount_37 = $row_37["amount"];
                    }
                }

                if ($row_1_37 = mysqli_fetch_array($result_1_37)) {
                    if ($row_1_37["qty"] != "") {
                        $r37 = $row_1_37["qty"];
                    }
                    if ($row_1_37["grand_tot"] != "") {
                        $rtn_37 = $row_1_37["grand_tot"];
                    }
                }

                $gq1 = 0;
				$gq2 =0;
				$gva1 = 0;
				$gva2 =0;
				$gcomm1 = 0;
			    $gcomm2 = 0;

                    if (($q40 + $q43 + $q37 + $qa) - ($r40 + $r43 + $r37) >= 10 And ( $q40 - $r40) <> 0) {
 
                       		$va1 = ($amount_43 - $rtn_43) + ($va1-($amount_43 - $rtn_43))  ;
                       		$q1 =  ($q43 - $r43) + ($q1 -($q43 - $r43) ) ;
                       		$va2 =  ($amount_40 - $rtn_40) + ($va2- ($amount_40 - $rtn_40)) ;
                       	    $q2 = ($q40 - $r40)+($q2-($q40 - $r40));
							
							$comm1 = $comm1 + ((($amount_40 - $rtn_40) / 65 * 5.225) + (($amount_43 - $rtn_43) / 62.5 * 5.225));
							$gcomm2 = 0;
			
                         
                    }
                 

				//t col
				 
				if ($comm1 >0) {
					$ResponseXML .= "<tr>";
                        $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                        $ResponseXML .= "<td>" . $row_rsven['NAME'] . "</td>";
                        $ResponseXML .= "<td>" . ($va1) . "</td>";
                        $ResponseXML .= "<td>" . ($q1) . "</td>";
                        $ResponseXML .= "<td>" . ($va2) . "</td>";
                        $ResponseXML .= "<td>" . ($q2) . "</td>";

                        $code = $row["cus_code"];
                        $name = $row_rsven['NAME'];
                        $amount1 = ($va1);
                        $qty1 =$q1;
                        $amount2 = ($va2);
                        $qty2 =$q2;

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/AG";

                        $chk = "chk" . $i;

                        $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                        $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                        if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                            $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
							<td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
							<td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
							<td></td>
							<td>Lock</td>
							<td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                            $crnno = $row_rs1["C_REFNO"];
                            $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                            $amount = $row_rs1["C_PAYMENT"];
                            $amount_c = 0;
                            $status = "Lock";

                            $i = $i + 1;
                        } else {
                            $ResponseXML .= "<td>Not Saved</td>
							<td></td>
							<td>" . number_format($comm1, 2, ".", ",") . "</td>
							<td></td>
							<td></td>
							<td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";


                            $crnno = "Not Saved";
                            $txndate = "";
                            $amount = ($comm1);
                            $amount_c = 0;
                            $status = "";
                            $i = $i + 1;
                        }

                        $ResponseXML .= "</tr>";
				}


            } else if (($row["qty"] + $qa) >= 6) {


                $sql_40 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '35' and cancel_m='0' group by cus_code";
                $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

                $sql_37 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = '37.5' and cancel_m='0' group by cus_code";
                $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

                $sql_1_37 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '37.5' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0' group by C_CODE";
                $result_1_37 = mysqli_query($GLOBALS['dbinv'], $sql_1_37);


                $sql_43 = "Select cus_code, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where cus_code = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != '35' and DIS_per!='37.5' and cancel_m='0' group by cus_code";
                $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

                $sql_1_40 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0' group by C_CODE";
                $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

                $sql_1_43 = "Select C_CODE, sum(qty) as qty, sum((price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '35' and DIS_P != '37.5' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and CANCELL='0' group by C_CODE";
                $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);



                if ($row_40 = mysqli_fetch_array($result_40)) {
                    if ($row_40["qty"] != "") {
                        $q40 = $row_40["qty"];
                    }
                    if ($row_40["amount"] != "") {
                        $amount_40 = $row_40["amount"];
                    }
                }

                if ($row_43 = mysqli_fetch_array($result_43)) {
                    if ($row_43["qty"] != "") {
                        $q43 = $row_43["qty"];
                    }
                    if ($row_43["amount"] != "") {
                        $amount_43 = $row_43["amount"];
                    }
                }

                if ($row_1_40 = mysqli_fetch_array($result_1_40)) {
                    if ($row_1_40["qty"] != "") {
                        $r40 = $row_1_40["qty"];
                    }
                    if ($row_1_40["grand_tot"] != "") {
                        $rtn_40 = $row_1_40["grand_tot"];
                    }
                }

                if ($row_1_43 = mysqli_fetch_array($result_1_43)) {
                    if ($row_1_43["qty"] != "") {
                        $r43 = $row_1_43["qty"];
                    }
                    if ($row_1_43["grand_tot"] != "") {
                        $rtn_43 = $row_1_43["grand_tot"];
                    }
                }

                if ($row_37 = mysqli_fetch_array($result_37)) {
                    if ($row_37["qty"] != "") {
                        $q37 = $row_37["qty"];
                    }
                    if ($row_37["amount"] != "") {
                        $amount_37 = $row_37["amount"];
                    }
                }

                if ($row_1_37 = mysqli_fetch_array($result_1_37)) {
                    if ($row_1_37["qty"] != "") {
                        $r37 = $row_1_37["qty"];
                    }
                    if ($row_1_37["grand_tot"] != "") {
                        $rtn_37 = $row_1_37["grand_tot"];
                    }
                }

                $sql_rsven = "Select name from vendor where code = '" . trim($row["cus_code"]) . "'";
                $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
                $row_rsven = mysqli_fetch_array($result_rsven);
                if (($q40 + $q43 + $qa) - ($r40 + $r43) >= 6 And ( ($q40 + $q37) - ($r40 + $r37)) <> 0) {

                    $ResponseXML .= "<tr>";
                    $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                    $ResponseXML .= "<td>" . $row_rsven['name'] . "</td>";
                    $ResponseXML .= "<td>" . ($amount_43 - $rtn_43) . "</td>";
                    $ResponseXML .= "<td>" . ($q43 - $r43) . "</td>";
                    $ResponseXML .= "<td>" . (($amount_40 + $amount_37) - ($rtn_40 + $rtn_37)) . "</td>";
                    $ResponseXML .= "<td>" . (($q40 + $q37) - ($r40 + $r37)) . "</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['name'];
                    $amount1 = ($amount_43 - $rtn_43);
                    $qty1 = $q43 - $r43;
                    $amount2 = (($amount_40 + $amount_37) - ($rtn_40 + $rtn_37));
                    $qty2 = ($q40 + $q37) - ($r40 + $r37);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/AG";

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
												   <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
												   <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
												   <td></td>
												   <td>Lock</td>
                                                                                                   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";
                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
												   <td></td>
												   <td>" . number_format((($amount_40 - $rtn_40) / 65 * 2.5), 2, ".", ",") . "</td>
												   <td></td>
												   <td></td>
												   <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = (($amount_40 - $rtn_40) / 65 * 2.5);
                        $amount_c = 0;
                        $status = "";
                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                }
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
//echo "1-".$sql_tmp."</br>";
            }
        }
    }




    $ResponseXML .= "</table>]]></balance_table>";
    $ResponseXML .= "</balancedetails>";
    echo $ResponseXML;
}




if ($_GET["Command"] == "changechk") {
    $sql_tmp = "update tmp_auto_credit_note set status= '" . $_GET["chk"] . "' where code='" . $_GET["code"] . "'";
    echo $sql_tmp;
    $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
}


if ($_GET["Command"] == "save_inv") {

    $mvatrate = 11;

	$sql = "Select vatrate from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
	$mvatrate = $row['vatrate'];
	
    /* 	$sql_tmp="select * from tmp_auto_credit_note";
      $result_tmp =mysqli_query($GLOBALS['dbinv'],$sql_tmp);
      while ($row_tmp = mysqli_fetch_array($result_tmp)){

      if ($row_tmp["status"]=="Yes"){

      $txt_cuscode = $row_tmp["code"];

      if (($row_tmp["amount"]=="") or (is_null($row_tmp["amount"])==true)){
      $txtamount=0;
      } else {
      $txtamount = $row_tmp["amount"];
      }

      $sql="Select CRN from invpara";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
      $row = mysqli_fetch_array($result);
      $tmpinvno="00000000".$row["CRN"];
      $lenth=strlen($tmpinvno);
      $txtrefno=trim("CRN/ ").substr($tmpinvno, $lenth-9);

      if (trim($_GET["combo1"]) == "VOLTA") {
      $sql_RSINVO="Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '".trim($row_tmp["code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per != '40' and cancel_m='0' order by id";
      $result_RSINVO =mysqli_query($GLOBALS['dbinv'],$sql_RSINVO);
      $row_RSINVO = mysqli_fetch_array($result_RSINVO);
      }

      if (trim($_GET["combo1"]) == "LINGLONG") {
      $sql_RSINVO="Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '".trim($row_tmp["code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per = '35' and cancel_m='0' order by id";
      $result_RSINVO =mysqli_query($GLOBALS['dbinv'],$sql_RSINVO);
      $row_RSINVO = mysqli_fetch_array($result_RSINVO);
      }

      if (trim($_GET["combo1"]) == "COOPER") {
      $sql_RSINVO="Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '".trim($row_tmp["code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per = '35' and cancel_m='0' order by id";
      $result_RSINVO =mysqli_query($GLOBALS['dbinv'],$sql_RSINVO);
      $row_RSINVO = mysqli_fetch_array($result_RSINVO);
      }

      if (trim($_GET["combo1"]) == "ROADSTONE") {
      $sql_RSINVO="Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '".trim($row_tmp["code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per = '45' and cancel_m='0' order by id";
      $result_RSINVO =mysqli_query($GLOBALS['dbinv'],$sql_RSINVO);
      $row_RSINVO = mysqli_fetch_array($result_RSINVO);
      }

      $txt_invno = $row_RSINVO["REF_NO"];
      $m_rep = $row_RSINVO["SAL_EX"];
      $m_dep = $row_RSINVO["DEPARTMENT"];
      $m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/R";
      if (trim($_GET["combo1"]) == "VOLTA") { $m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/V"; }
      if (trim($_GET["combo1"]) == "LINGLONG") { $m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/L"; }
      if (trim($_GET["combo1"]) == "COOPER") { $m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/C"; }
      if (trim($_GET["combo1"]) == "ROADSTONE") { $m_flag = date("m/Y",strtotime($_GET["dte_dor"]))."/R"; }

      if (trim($_GET["combo1"]) == "VOLTA") { $txt_remark = "Additional 5%/2.5% Trade Discount for VOLTA - month of ".date("m/Y",strtotime($_GET["dte_dor"])); }

      if (trim($_GET["combo1"]) == "LINGLONG") { $txt_remark = "Additional 2.5% Trade Discount for LING LONG month of ".date("m/Y",strtotime($_GET["dte_dor"])); }

      if (trim($_GET["combo1"]) == "COOPER") { $txt_remark = "Additional 2.5% Trade Discount for COOPER month of ".date("m/Y",strtotime($_GET["dte_dor"])); }

      if (trim($_GET["combo1"]) == "ROADSTONE") { $txt_remark = "Additional Trade Discounts for Roadstone month of ".date("m/Y",strtotime($_GET["dte_dor"])); }

      $sql_cbal= "insert into c_bal (REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate) values('".trim($txtrefno)."', '".date("Y-m-d")."', 'CNT', '".trim($txt_cuscode)."', ".$txtamount.", ".$txtamount.", '".trim($_GET["combo1"])."', '".$m_dep."', '".$m_rep."', '0', '".$mvatrate."')";
      echo $sql_cbal;
      $result_cbal =mysqli_query($GLOBALS['dbinv'],$sql_cbal);

      //	$sql_cbal= "insert into c_bal (REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate, flag1) values('".trim($txtrefno)."', '".date("Y-m-d",strtotime($_GET["dte_dor"]))."', 'CNQ', '".trim($txt_cuscode)."', ".$txtamount.", ".$txtamount.", '".trim($_GET["combo1"])."', '01', '".$m_rep."', '0', '".$mvatrate."', '".$txtamount."')";
      //	$result_cbal =mysqli_query($GLOBALS['dbinv'],$sql_cbal);


      $sql_cred= "Insert into cred (C_REFNO, C_DATE, C_INVNO, C_CODE, C_PAYMENT, C_REMARK, C_SALEX, Brand, DEV, C_SETINV) values ('".trim($txtrefno)."', '".date("Y-m-d"). "', '".trim($txt_invno)."', '".trim($txt_cuscode)."', ".$txtamount.", '".trim($txt_remark)."', '".trim($m_rep)."', '".trim($_GET["combo1"])."', '0', '".trim($m_flag)."')";
      echo $sql_cred;
      $result_cred =mysqli_query($GLOBALS['dbinv'],$sql_cred);

      $sql_s_led= "Insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT, DEV) values ('".trim($txtrefno)."', '".date("Y-m-d")."', '".trim($txt_cuscode)."', ".$txtamount.", 'CRN', '".$m_dep."', '0')";
      $result_s_led =mysqli_query($GLOBALS['dbinv'],$sql_s_led);

      //==============update credit limit==========================================
      $sql_s= "update vendor set CUR_BAL= CUR_BAL-".$txtamount." where CODE='".trim($txt_cuscode)."'";
      $result_s =mysqli_query($GLOBALS['dbinv'],$sql_s);

      $sql_s= "update invpara set CRN=CRN+1";
      $result_s =mysqli_query($GLOBALS['dbinv'],$sql_s);
      }
      } */



    $sql_tmp = "select * from tmp_auto_credit_note";
    $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
    while ($row_tmp = mysqli_fetch_array($result_tmp)) {
        if ($row_tmp["status"] == "Yes") {

            if ($row_tmp["amount_c"] > 0) {
                for ($X = 1; $X <= 2; $X++) {

                    $sql = "Select CRN from invpara";
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    $row = mysqli_fetch_array($result);
                    $tmpinvno = "00000000" . $row["CRN"];
                    $lenth = strlen($tmpinvno);
                    $txtrefno = trim("CRN/ ") . substr($tmpinvno, $lenth - 9);

                    $txt_cuscode = $row_tmp["code"];

                    if ($X == 1) {
                        $txtamount = $row_tmp["amount"];
                    }
                    if ($X == 2) {
                        $txtamount = $row_tmp["amount_c"];
                    }

                    if (trim($_GET["combo1"]) == "VOLTA") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != 40 and cancel_m='0' order by id";


                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/V";
                    }
					if (trim($_GET["combo1"]) == "WILLFLY") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != 40 and cancel_m='0' order by id";


                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/W";
                    }
					
                    if (trim($_GET["combo1"]) == "ATLASBX") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != 40 and cancel_m='0' order by id";


                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/A";
                    }					
					
					
					
                    if (trim($_GET["combo1"]) == "LINGLONG") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = 35 and cancel_m='0' order by id";


                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L";
                    }
					
					if (trim($_GET["combo1"]) == "AGATE") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = 35 and cancel_m='0' order by id";


                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/AG";
                    }
					

                    if (trim($_GET["combo1"]) == "COOPER") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = 35 and cancel_m='0' order by id";

                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/C";
                    }
					
					if (trim($_GET["combo1"]) == "CONSTANCY") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = 35 and cancel_m='0' order by id";

                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/CO";
                    }
					

                    if (trim($_GET["combo1"]) == "GREENTOUR") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = 35 and cancel_m='0' order by id";

                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/G";
                    }
					
					
				     if (trim($_GET["combo1"]) == "PRESA") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and cancel_m='0' order by id";

                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/P";
                    }

                    if (trim($_GET["combo1"]) == "ROADSTONE") {
//$sql_RSINVO="Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '".trim($row_tmp["code"])."' and s_brand='".trim($_GET["combo1"])."' and  month(SDATE)='".date("m",strtotime($_GET["dte_dor"]))."' and year(SDATE)='".date("Y",strtotime($_GET["dte_dor"]))."' and DIS_per = '45' and cancel_m='0' order by id";

                        if ($X == 1) {
                            $sql_RSINVO = "select REF_NO, SAL_EX, DEPARTMENT from viewinv where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . "  and cancel_m='0' order by id ";
                        }
                        if ($X == 2) {
                            $sql_RSINVO = "select REF_NO, SAL_EX, DEPARTMENT from viewinv where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='ROADSTONE CHINA' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . "  and cancel_m='0' order by id ";
                        }

                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R";
                    }


                    $txt_invno = $row_RSINVO["REF_NO"];
                    $m_rep = $row_RSINVO["SAL_EX"];
                    $m_dep = $row_RSINVO["DEPARTMENT"];


                    if (trim($_GET["Combo1"]) == "VOLTA") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/V";
                    }
					if (trim($_GET["Combo1"]) == "WILLFLY") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/W";
                    }
                    if (trim($_GET["Combo1"]) == "ATLASBX") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/A";
                    }					
                    if (trim($_GET["Combo1"]) == "LINGLONG") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/L";
                    }
					 if (trim($_GET["Combo1"]) == "AGATE") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/AG";
                    }
                    if (trim($_GET["Combo1"]) == "COOPER") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/C";
                    }
					
					if (trim($_GET["Combo1"]) == "CONSTANCY") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/CO";
                    }
					
					
					 if (trim($_GET["Combo1"]) == "PRESA") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/P";
                    }
					
                    if (trim($_GET["Combo1"]) == "ROADSTONE") {
                        if ($X == 1) {
                            $$m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/R";
                        }
                        if ($X == 2) {
                            $$m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/R-C";
                        }
                    }




                    if (trim($_GET["combo1"]) == "VOLTA") {
                        $txt_remark = "Additional 5%/2.5% Trade Discount for VOLTA - month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
					if (trim($_GET["combo1"]) == "WILLFLY") {
                        $txt_remark = "Additional 2.5% Trade Discount for WILLFLY - month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
					
                    if (trim($_GET["combo1"]) == "ATLASBX") {
                        $txt_remark = "Additional 5%/2.5% Trade Discount for ATLASBX - month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
                    if (trim($_GET["combo1"]) == "LINGLONG") {
                        $txt_remark = "Additional 2.5% Trade Discount for LING LONG month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
					if (trim($_GET["combo1"]) == "AGATE") {
                        $txt_remark = "Additional 2.5% Trade Discount for AGATE month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
                    if (trim($_GET["combo1"]) == "COOPER") {
                        $txt_remark = "Additional 2.5% Trade Discount for COOPER month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
					
					if (trim($_GET["combo1"]) == "CONSTANCY") {
                        $txt_remark = "Additional 2.5% Trade Discount for CONSTANCY month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
					
					if (trim($_GET["combo1"]) == "GREENTOUR") {
                        $txt_remark = "Additional 5%/2.5% Trade Discount for GREENTOUR month of " . date("m/Y", strtotime($_GET["dte_dor"]));
						$m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/G";
                    }
					
					if (trim($_GET["combo1"]) == "PRESA") {
                        $txt_remark = "Additional  Trade Discount for PRESA month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
                    if (trim($_GET["combo1"]) == "ROADSTONE") {
                        $txt_remark = "Additional Trade Discounts for Roadstone month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }




                    if ($X == 1) {


                        $sql_cbal = "insert into c_bal (REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate) values('" . trim($txtrefno) . "', '" . date("Y-m-d") . "', 'CNT', '" . trim($txt_cuscode) . "', " . $txtamount . ", " . $txtamount . ", '" . trim($_GET["combo1"]) . "', '" . $m_dep . "', '" . $m_rep . "', '0', '" . $mvatrate . "')";
                        echo $sql_cbal;
                        $result_cbal = mysqli_query($GLOBALS['dbinv'], $sql_cbal);
                    }

                    if ($X == 2) {
                        $sql_cbal = "insert into c_bal (REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate) values('" . trim($txtrefno) . "', '" . date("Y-m-d") . "', 'CNT', '" . trim($txt_cuscode) . "', " . $txtamount . ", " . $txtamount . ", 'ROADSTONE CHINA', '" . $m_dep . "', '" . $m_rep . "', '0', '" . $mvatrate . "')";
                        echo $sql_cbal;
                        $result_cbal = mysqli_query($GLOBALS['dbinv'], $sql_cbal);
                    }

                    if ($X == 1) {
                        $sql_cred = "Insert into cred (C_REFNO, C_DATE, C_INVNO, C_CODE, C_PAYMENT, C_REMARK, C_SALEX, Brand, DEV, C_SETINV) values ('" . trim($txtrefno) . "', '" . date("Y-m-d") . "', '" . trim($txt_invno) . "', '" . trim($txt_cuscode) . "', " . $txtamount . ", '" . trim($txt_remark) . "', '" . trim($m_rep) . "', '" . trim($_GET["combo1"]) . "', '0', '" . trim($m_flag) . "')";
                        echo $sql_cred;
                        $result_cred = mysqli_query($GLOBALS['dbinv'], $sql_cred);
                    }


                    if ($X == 2) {
                        $sql_cred = "Insert into cred (C_REFNO, C_DATE, C_INVNO, C_CODE, C_PAYMENT, C_REMARK, C_SALEX, Brand, DEV, C_SETINV) values ('" . trim($txtrefno) . "', '" . date("Y-m-d") . "', '" . trim($txt_invno) . "', '" . trim($txt_cuscode) . "', " . $txtamount . ", '" . trim($txt_remark) . "', '" . trim($m_rep) . "', 'ROADSTONE CHINA', '0', '" . trim($m_flag) . "')";
                        echo $sql_cred;
                        $result_cred = mysqli_query($GLOBALS['dbinv'], $sql_cred);
                    }

                    $sql_s_led = "Insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT, DEV) values ('" . trim($txtrefno) . "', '" . date("Y-m-d") . "', '" . trim($txt_cuscode) . "', " . $txtamount . ", 'CRN', '" . $m_dep . "', '0')";
                    $result_s_led = mysqli_query($GLOBALS['dbinv'], $sql_s_led);


//==============update credit limit==========================================
                    $sql_s = "update vendor set CUR_BAL= CUR_BAL-" . $txtamount . " where CODE='" . trim($txt_cuscode) . "'";
                    $result_s = mysqli_query($GLOBALS['dbinv'], $sql_s);

                    $sql_s = "update invpara set CRN=CRN+1";
                    $result_s = mysqli_query($GLOBALS['dbinv'], $sql_s);
                }
            } else {

                $sql = "Select CRN from invpara";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                $row = mysqli_fetch_array($result);
                $tmpinvno = "00000000" . $row["CRN"];
                $lenth = strlen($tmpinvno);
                $txtrefno = trim("CRN/ ") . substr($tmpinvno, $lenth - 9);

                $txt_cuscode = $row_tmp["code"];

                $txtamount = $row_tmp["amount"];


                if (trim($_GET["combo1"]) == "VOLTA") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != 40 and cancel_m='0' order by id";

                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/V";
                }
				if (trim($_GET["combo1"]) == "WILLFLY") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != 40 and cancel_m='0' order by id";

                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/W";
                }

                if (trim($_GET["combo1"]) == "ATLASBX") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per != 40 and cancel_m='0' order by id";

                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/A";
                }				
				
				
                if (trim($_GET["combo1"]) == "LINGLONG") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = 35 and cancel_m='0' order by id";


                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L";
                }
				
				if (trim($_GET["combo1"]) == "AGATE") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = 35 and cancel_m='0' order by id";


                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/AG";
                }

                if (trim($_GET["combo1"]) == "COOPER") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = 35 and cancel_m='0' order by id";

                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/C";
                }
				
				if (trim($_GET["combo1"]) == "CONSTANCY") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = 35 and cancel_m='0' order by id";

                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/CO";
                }
				
				
				
				if (trim($_GET["combo1"]) == "GREENTOUR") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)='" . date("m", strtotime($_GET["dte_dor"])) . "' and year(SDATE)='" . date("Y", strtotime($_GET["dte_dor"])) . "' and DIS_per = 35 and cancel_m='0' order by id";

                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/G";
                }

				if (trim($_GET["combo1"]) == "PRESA") {
                    $sql_RSINVO = "select REF_NO, SAL_EX, DEPARTMENT from viewinv where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . "  and cancel_m='0' order by id ";
						
                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/P";
                }

                if (trim($_GET["combo1"]) == "ROADSTONE") {


                    $sql_RSINVO = "select REF_NO, SAL_EX, DEPARTMENT from viewinv where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . "  and cancel_m='0' order by id ";



                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R";
                }

                $txt_invno = $row_RSINVO["REF_NO"];
                $m_rep = $row_RSINVO["SAL_EX"];
                $m_dep = $row_RSINVO["DEPARTMENT"];


                if (trim($_GET["Combo1"]) == "VOLTA") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/V";
                }
				 if (trim($_GET["Combo1"]) == "WILLFLY") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/W";
                }
				                if (trim($_GET["Combo1"]) == "ATLASBX") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/A";
                }
                if (trim($_GET["Combo1"]) == "LINGLONG") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/L";
                }
				if (trim($_GET["Combo1"]) == "AGATE") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/AG";
                }
				
                if (trim($_GET["Combo1"]) == "COOPER") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/C";
                }
				
				if (trim($_GET["Combo1"]) == "CONSTANCY") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/CO";
                }
				
				
				If (trim($_GET["Combo1"]) == "GREENTOUR") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/G";
					 $txt_remark = "Additional 5%/2.5% Trade Discount for GREENTOUR month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
				if (trim($_GET["Combo1"]) == "PRESA") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/P";
                }
                if (trim($_GET["Combo1"]) == "ROADSTONE") {
                    $$m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/R";
                }

                if (trim($_GET["combo1"]) == "VOLTA") {
                    $txt_remark = "Additional 5%/2.5% Trade Discount for VOLTA - month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
				if (trim($_GET["combo1"]) == "WILLFLY") {
                    $txt_remark = "Additional 2.5% Trade Discount for WILLFLY - month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
                if (trim($_GET["combo1"]) == "ATLASBX") {
                    $txt_remark = "Additional 5%/2.5% Trade Discount for ATLASBX - month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
                if (trim($_GET["combo1"]) == "LINGLONG") {
                    $txt_remark = "Additional 2.5% Trade Discount for LING LONG month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
				if (trim($_GET["combo1"]) == "AGATE") {
                    $txt_remark = "Additional 2.5% Trade Discount for AGATE month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
				
                if (trim($_GET["combo1"]) == "COOPER") {
                    $txt_remark = "Additional 2.5% Trade Discount for COOPER month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
				
				if (trim($_GET["combo1"]) == "CONSTANCY") {
                    $txt_remark = "Additional 2.5% Trade Discount for CONSTANCY month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
				
				if (trim($_GET["combo1"]) == "PRESA") {
                    $txt_remark = "Additional Trade Discount for PRESA month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
                if (trim($_GET["combo1"]) == "ROADSTONE") {
                    $txt_remark = "Additional Trade Discounts for Roadstone month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }




                $sql_cbal = "insert into c_bal (REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate) values('" . trim($txtrefno) . "', '" . date("Y-m-d") . "', 'CNT', '" . trim($txt_cuscode) . "', " . $txtamount . ", " . $txtamount . ", '" . trim($_GET["combo1"]) . "', '" . $m_dep . "', '" . $m_rep . "', '0', '" . $mvatrate . "')";
                echo $sql_cbal;
                $result_cbal = mysqli_query($GLOBALS['dbinv'], $sql_cbal);


                $sql_cred = "Insert into cred (C_REFNO, C_DATE, C_INVNO, C_CODE, C_PAYMENT, C_REMARK, C_SALEX, Brand, DEV, C_SETINV) values ('" . trim($txtrefno) . "', '" . date("Y-m-d") . "', '" . trim($txt_invno) . "', '" . trim($txt_cuscode) . "', " . $txtamount . ", '" . trim($txt_remark) . "', '" . trim($m_rep) . "', '" . trim($_GET["combo1"]) . "', '0', '" . trim($m_flag) . "')";
                echo $sql_cred;
                $result_cred = mysqli_query($GLOBALS['dbinv'], $sql_cred);



                $sql_s_led = "Insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT, DEV) values ('" . trim($txtrefno) . "', '" . date("Y-m-d") . "', '" . trim($txt_cuscode) . "', " . $txtamount . ", 'CRN', '" . $m_dep . "', '0')";
                $result_s_led = mysqli_query($GLOBALS['dbinv'], $sql_s_led);

//==============update credit limit==========================================

                $sql_s = "update vendor set CUR_BAL= CUR_BAL-" . $txtamount . " where CODE='" . trim($txt_cuscode) . "'";
                $result_s = mysqli_query($GLOBALS['dbinv'], $sql_s);

                $sql_s = "update invpara set CRN=CRN+1";
                $result_s = mysqli_query($GLOBALS['dbinv'], $sql_s);
            }
        }
    }
}

if ($_GET["Command"] == "chk_number") {
    $sql = "select * from vendor where CODE = '" . trim($_GET["txt_cuscode"]) . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        echo "included";
    } else {
        echo "no";
    }
}


if ($_GET["Command"] == "new_inv") {




    $_SESSION["print"] = 0;

    /* 	$sql="Select CAS_INV_NO_m from invpara";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
      $row = mysqli_fetch_array($result);
      $tmpinvno="000000".$row["CAS_INV_NO_m"];
      $lenth=strlen($tmpinvno);
      $invno="INV".substr($tmpinvno, $lenth-7);
      echo $invno; */

    $sql = "Select debnoteno from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "000000" . $row["debnoteno"];
    $lenth = strlen($tmpinvno);
    $invno = trim("CRI/ ") . substr($tmpinvno, $lenth - 7);
    $_SESSION["invno"] = $invno;

    $sql = "delete from tmp_inv_data where str_invno='" . $invno . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    echo $invno;
}


if ($_GET["Command"] == "cancel_inv") {
    $sql = "select last_update from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);

    $sqlinv = "select * from s_salma where REF_NO='" . $_GET["invno"] . "' ";
    $resultinv = mysqli_query($GLOBALS['dbinv'], $sqlinv);
    if ($rowinv = mysqli_fetch_array($resultinv)) {
        if (($rowinv["TOTPAY"] == 0) and ( $rowinv["SDATE"] > $row["last_update"])) {
            $sql2 = "update s_salma set CANCELL='1' where REF_NO='" . $_GET["invno"] . "'";
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);

            $sql2 = "update vendor set CUR_BAL=CUR_BAL-" . $rowinv["GRAND_TOT"] . " where CODE='" . $_GET["customer_code"] . "'";
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);

            $sql2 = "update br_trn set credit=credit-" . $rowinv["GRAND_TOT"] . " where CODE='" . $_GET["customer_code"] . "' and cus_code='" . $_GET["customer_code"] . "' and Rep='" . $_GET["salesrep"] . "'";
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);

            $sqltmp = "select * from tmp_inv_data where str_invno='" . $_GET['invno'] . "' ";
            $resulttmp = mysqli_query($GLOBALS['dbinv'], $sqltmp);
            while ($rowtmp = mysqli_fetch_array($resulttmp)) {
                $sql2 = "update s_invo set CANCELL='1' where REF_NO='" . $_GET['invno'] . "'";
                $resul2 = mysqli_query($GLOBALS['dbinv'], $sql2);

                $sql2 = "update s_mas set QTYINHAND=QTYINHAND+" . $rowtmp["cur_qty"] . " where STK_NO='" . $rowtmp['str_code'] . "'";
                $resul2 = mysqli_query($GLOBALS['dbinv'], $sql2);

                $sql2 = "update s_submas set QTYINHAND=QTYINHAND+" . $rowtmp["cur_qty"] . " where STO_CODE='" . $_GET['department'] . "' and STK_NO='" . $rowtmp['str_code'] . "'";
                $resul2 = mysqli_query($GLOBALS['dbinv'], $sql2);

                $sql2 = "delete from s_trn where REFNO='" . $_GET['invno'] . "'";
                $resul2 = mysqli_query($GLOBALS['dbinv'], $sql2);

                $sql2 = "delete from s_led where REF_NO='" . $_GET['invno'] . "'";
                $resul2 = mysqli_query($GLOBALS['dbinv'], $sql2);
            }
            echo "Canceled";
        } else {
            echo "Can't Cancel";
        }
    }
}


if ($_GET["Command"] == "add_tmp") {

    $department = $_GET["department"];

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_inv_data where str_code='" . $_GET['itemcode'] . "' and str_invno='" . $_GET['invno'] . "' ";
//$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

//echo $_GET['rate'];
//echo $_GET['qty'];
    $rate = str_replace(",", "", $_GET["rate"]);
    $qty = str_replace(",", "", $_GET["qty"]);
    $discount = str_replace(",", "", $_GET["discount"]);
    $subtotal = str_replace(",", "", $_GET["subtotal"]);

    $sql = "Insert into tmp_inv_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot)values 
			('" . $_GET['invno'] . "', '" . $_GET['itemcode'] . "', '" . $_GET['item'] . "', " . $rate . ", " . $qty . ", " . $_GET["discountper"] . ", " . $discount . ", " . $subtotal . ") ";
//$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);


    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";


    $sql = "Select * from tmp_inv_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>                              
                             <td >" . $row['str_code'] . "</a></td>
							 <td >" . $row['str_description'] . "</a></td>
							 <td >" . number_format($row['cur_rate'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['cur_qty'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($_GET["discountper"], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['cur_subtot'], 2, ".", ",") . "</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>";

        include_once("connectioni.php");

        $sqlqty = mysqli_query($GLOBALS['dbinv'], "select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $department . "'") or die(mysqli_error());
        if ($rowqty = mysqli_fetch_array($sqlqty)) {
            $qty = $rowqty['QTYINHAND'];
        } else {
            $qty = 0;
        }

        $ResponseXML .= "<td >" . $qty . "</a></td>
							 
                            </tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_inv_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

    $vatrate = 0.12;

    if ($_GET["vatmethod"] == "vat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "svat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "evat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "non") {
//$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
        $ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";

        $invtot = number_format($row['tot_sub'], 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    }

    $ResponseXML .= " </salesdetails>";

//	}	


    echo $ResponseXML;
}
if ($_GET["Command"] == "setord") {

    include_once("connectioni.php");

    $len = strlen($_GET["salesord1"]);
    $need = substr($_GET["salesord1"], $len - 7, $len);
    $salesord1 = trim("ORD/ ") . $_GET["salesrep"] . trim(" / ") . $need;


    $_SESSION["custno"] = $_GET['custno'];
    $_SESSION["brand"] = $_GET["brand"];
    $_SESSION["department"] = $_GET["department"];



    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];
    $salesrep = $_GET["salesrep"];
    $brand = $_GET["brand"];

//		$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";
//Call SETLIMIT ====================================================================



    /* 	$sql = mysqli_query($GLOBALS['dbinv'],"DROP VIEW view_s_salma") or die(mysqli_error());
      $sql = mysqli_query($GLOBALS['dbinv'],"CREATE VIEW view_s_salma
      AS
      SELECT     s_salma.*, brand_mas.class AS class
      FROM         brand_mas RIGHT OUTER JOIN
      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysqli_error()); */

    $OutpDAMT = 0;
    $OutREtAmt = 0;
    $OutInvAmt = 0;
    $InvClass = "";

    $sqlclass = mysqli_query($GLOBALS['dbinv'], "select class from brand_mas where barnd_name='" . trim($brand) . "'") or die(mysqli_error());
    if ($rowclass = mysqli_fetch_array($sqlclass)) {
        if (is_null($rowclass["class"]) == false) {
            $InvClass = $rowclass["class"];
        }
    }

    $sqloutinv = mysqli_query($GLOBALS['dbinv'], "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='" . trim($cuscode) . "' and SAL_EX='" . trim($salesrep) . "' and class='" . $InvClass . "'") or die(mysqli_error());
    if ($rowoutinv = mysqli_fetch_array($sqloutinv)) {
        if (is_null($rowoutinv["totout"]) == false) {
            $OutInvAmt = $rowoutinv["totout"];
        }
    }

    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM s_invcheq WHERE che_date>'" . date("d-m-Y") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='REC' and sal_ex='" . trim($salesrep) . "'") or die(mysqli_error());
    while ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {

        $sqlsttr = mysqli_query($GLOBALS['dbinv'], "select * from s_sttr where ST_REFNO='" . trim($rowinvcheq["refno"]) . "' and ST_CHNO ='" . trim($rowinvcheq["cheque_no"]) . "'") or die(mysqli_error());
        while ($rowsttr = mysqli_fetch_array($sqlsttr)) {
            $sqlview_s_salma = mysqli_query($GLOBALS['dbinv'], "select class from view_s_salma where REF_NO='" . trim($rowsttr["ST_INVONO"]) . "'") or die(mysqli_error());
            if ($rowview_s_salma = mysqli_fetch_array($sqlview_s_salma)) {

                if (trim($rowview_s_salma["class"]) == $InvClass) {
                    $OutpDAMT = $OutpDAMT + $rowsttr["ST_PAID"];
                }
            }
        }
    }



    $pend_ret_set = 0;

    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'" . date("d-m-Y") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='RET'") or die(mysqli_error());
    if ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {
        if (is_null($rowinvcheq["che_amount"]) == false) {
            $pend_ret_set = $rowinvcheq["che_amount"];
        }
    }


    $sqlcheq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='" . trim($salesrep) . "'") or die(mysqli_error());
    if ($rowcheq = mysqli_fetch_array($sqlcheq)) {
        if (is_null($rowcheq["tot"]) == false) {
            $OutREtAmt = $rowcheq["tot"];
        } else {
            $OutREtAmt = 0;
        }
    }





    $ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutREtAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutpDAMT, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt + $OutREtAmt + $OutpDAMT + $pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table_acc>";




    $sqlbr_trn = mysqli_query($GLOBALS['dbinv'], "select * from br_trn where Rep='" . trim($salesrep) . "' and brand='" . trim($InvClass) . "' and cus_code='" . trim($cuscode) . "'") or die(mysqli_error());
    if ($rowbr_trn = mysqli_fetch_array($sqlbr_trn)) {
        if (is_null($rowbr_trn["credit_lim"]) == false) {
            $crLmt = $rowbr_trn["credit_lim"];
        } else {
            $crLmt = 0;
        }


        if (is_null($rowbr_trn["tmpLmt"]) == false) {
            $tmpLmt = $rowbr_trn["tmpLmt"];
        } else {
            $tmpLmt = 0;
        }

        if (is_null($rowbr_trn["CAT"]) == false) {
            $cuscat = trim($rowbr_trn["cat"]);
            if ($cuscat = "A") {
                $m = 2.5;
            }
            if ($cuscat = "B") {
                $m = 2.5;
            }
            if ($cuscat = "C") {
                $m = 1;
            }
            $txt_crelimi = "0";
            $txt_crebal = "0";
            $txt_crelimi = number_format($crLmt, 2, ".", ",");
//$crebal=$crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            $txt_crebal = $crLmt * $m - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            $crebal = $crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
//$txt_crebal = number_format($crebal, "2", ".", ",");
        } else {
            $txt_crelimi = "0";
            $txt_crebal = "0";
        }
        $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
    }
    $ResponseXML .= "<txt_crelimi><![CDATA[" . $txt_crelimi . "]]></txt_crelimi>";
    $ResponseXML .= "<txt_crebal><![CDATA[" . $txt_crebal . "]]></txt_crebal>";

    $ResponseXML .= "<creditbalance><![CDATA[" . number_format($txt_crebal, "2", ".", ",") . "]]></creditbalance>";



    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "del_item") {


    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_inv_data where str_code='" . $_GET['code'] . "' and str_invno='" . $_GET['invno'] . "' ";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";


    $sql = "Select * from tmp_inv_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td >" . $row['str_code'] . "</a></td>
							 <td>" . $row['str_description'] . "</a></td>
							 <td >" . $row['cur_rate'] . "</a></td>
							 <td  >" . $row['cur_qty'] . "</a></td>
							 <td  >" . $row['cur_discount'] . "</a></td>
							 <td  >" . $row['cur_subtot'] . "</a></td>
							 <td  ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>";

        include_once("connectioni.php");

        $sqlqty = mysqli_query($GLOBALS['dbinv'], "select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $_GET["department"] . "'") or die(mysqli_error());
        if ($rowqty = mysqli_fetch_array($sqlqty)) {
            $qty = $rowqty['QTYINHAND'];
        } else {
            $qty = 0;
        }

        $ResponseXML .= "<td  >" . $qty . "</a></td>
                            </tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $sql = "Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_inv_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $ResponseXML .= "<subtot><![CDATA[" . number_format($row['tot_sub'], 2, ".", ",") . "]]></subtot>";
    $ResponseXML .= "<tot_dis><![CDATA[" . number_format($row['tot_dis'], 2, ".", ",") . "]]></tot_dis>";

    $vatrate = 0.12;

    if ($_GET["vatmethod"] == "vat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "svat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "evat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "non") {
//$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
        $ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";

        $invtot = number_format($row['tot_sub'], 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    }

    $ResponseXML .= " </salesdetails>";


//	}	


    echo $ResponseXML;
}





if ($_GET["Command"] == "check_print") {

    echo $_SESSION["print"];
}


if ($_GET["Command"] == "tmp_crelimit") {
    echo "abc";
    $crLmt = 0;
    $cat = "";

    $rep = trim(substr($_GET["Com_rep1"], 0, 5));

    $sql = "select * from br_trn where rep='" . $rep . "' and cus_code='" . trim($_GET["txt_cuscode"]) . "' and brand='" . trim($_GET["cmbbrand1"]) . "'";
    echo $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $crLmt = $row["credit_lim"];
        If (is_null($row["cat"]) == false) {
            $cat = trim($row["cat"]);
        } else {
            $crLmt = 0;
        }
    }
    /* 	
      $_SESSION["CURRENT_DOC"] = 66     //document ID
      //$_SESSION["VIEW_DOC"] = true      //  view current document
      $_SESSION["FEED_DOC"] = true      //  save  current document
      //$_SESSION["MOD_DOC"] = true       //   delete   current document
      //$_SESSION["PRINT_DOC"] = true     // get additional print   of  current document
      //$_SESSION["PRICE_EDIT"]= true     // edit selling price
      $_SESSION["CHECK_USER"] = true    // check user permission again
      $crLmt = $crLmt;
      setlocale(LC_MONETARY, "en_US");
      $CrTmpLmt = number_format($_GET["txt_tmeplimit"], 2, ".", ",");

      $REFNO = trim($_GET["txt_cuscode"]) ;

      $AUTH_USER="tmpuser";

      $sql = "insert into tmpCrLmt (sdate, stime, username, tmpLmt, class, rep, cuscode, crLmt, cat) values
      ('".date("Y-m-d")."','".date("H:i:s", time())."' ,'".$AUTH_USER."',".$CrTmpLmt." ,'".trim($_GET["cmbbrand1"])."','".$rep."','".trim($_GET["txt_cuscode"])."',".$crLmt.",'".$cat"' )";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;

      $sql = "select * from  br_trn where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."'";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
      if ($row = mysqli_fetch_array($result)) {
      $sqlbrtrn= "insert into br_trn (cus_code, rep, credit_lim, brand, tmplmt) values ('".trim($_GET["txt_cuscode"])."','".$rep."','0','".trim($_GET["cmbbrand1"])."',".$CrTmpLmt." )";
      $resultbrtrn =mysqli_query($GLOBALS['dbinv'],$sqlbrtrn);

      } else {

      $sqlbrtrn= "update br_trn set tmplmt= ".$CrTmpLmt."  where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."' ";
      $resultbrtrn =mysqli_query($GLOBALS['dbinv'],$sqlbrtrn);

      //	$sqlbrtrn= "update vendor set temp_limit= ".$CrTmpLmt."  where code='".trim($_GET["txt_cuscode"])."' "
      }

      If ($_GET["Check1"] == 1) {
      $sqlblack= "update vendor set blacklist= '1'  where code='".trim($_GET["txt_cuscode"])."' ";
      $resultblack =mysqli_query($GLOBALS['dbinv'],$sqlblack);
      } else {
      $sqlblack= "update vendor set blacklist= '0'  where code='".trim($_GET["txt_cuscode"])."' ";
      $resultblack =mysqli_query($GLOBALS['dbinv'],$sqlblack);
      }

      echo "Tempory limit updated"; */
}
?>

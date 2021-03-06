<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

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

    //$sql = "Select cus_code,sum(QTY) as qty from viewinv   where   s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by cus_code order by cus_code";
    $sql = "Select c_code1 as cus_code,cus_code as cus_code1,sum(QTY) as qty from viewinv   where   s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by c_code1,cus_code order by c_code1";
//echo $sql;

    $result = mysqli_query($GLOBALS['dbinv'], $sql);


    $ResponseXML .= "<balance_table><![CDATA[<table width=\"735\" border=\"0\" class=\"form-matrix-table\">";

    $i = 1;

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


            $sql = "Select sum(qty) as qty from viewinv where cus_code = '" . trim($row["cus_code1"]) . "' and s_brand = 'ALCEED' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m = '0' and DIS_per != 0 and DIS_per != 100 ";
            $result_rs = mysqli_query($GLOBALS['dbinv'], $sql);
            $rs = mysqli_fetch_array($result_rs);
            if (!is_null($rs['qty'])) {
                $qa = $rs['qty'];
            }

            $sql = "select sum(qty)as qty from viewcrntrn where c_code = '" . trim($row["cus_code1"]) . "' and brand = 'ALCEED' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancell = '0'  and DIS_P != 0 and DIS_P != 100 ";
            $result_rs = mysqli_query($GLOBALS['dbinv'], $sql);
            $rs = mysqli_fetch_array($result_rs);
            if (!is_null($rs['qty'])) {
                $qa = $qa - $rs['qty'];
            }


            $mqty = 0;
            $sql = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where  cus_code = '" . trim($row["cus_code1"]) . "' and DIS_per != 0 and DIS_per != 100 and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty + $row_m['qty'];
            }

            $sql = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code1"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != 0 and DIS_P != 100 and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' ";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty - $row_m['qty'];
            }



            if ($mqty + $qa < 50) {
                $qa = 0;
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

            $sql_40 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '35' and cancel_m='0'";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

            $sql_43 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and dis_per <> '35' AND DIS_PER <> '37.5' and cancel_m='0' ";
            $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

            $sql_1_40 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' ";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P <> '35' AND DIS_P <> '37.5' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' ";
            $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

            $sql_37 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '37.5' and cancel_m='0'  ";
            $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

            $sql_1_37 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where  c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '37.5' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' ";
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



            $sql_rsven = "Select c_NAME as NAME  from vender_sub where C_CODE = '" . $row["cus_code"] . "'";
            $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
            if ($row_rsven = mysqli_fetch_array($result_rsven)) {

                if (($mqty + $qa) >= 50) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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

                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and stk_no <> 'L0301' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 43) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (43 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' and stk_no <> 'L0301'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 43) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (43 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = ($lastamount);
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }


                    $ResponseXML .= "</tr>";
                } else if (($mqty + $qa) >= 30) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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

                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and stk_no <> 'L0301' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 40.625) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (40.625 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' and stk_no <> 'L0301'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 40.625) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (40.625 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = ($lastamount);
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }


                    $ResponseXML .= "</tr>";
                } else if ((($mqty + $qa) >= 20)) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and stk_no <> 'L0301' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 37.5) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (37.5 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  and stk_no <> 'L0301' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 37.5) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (37.5 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format($lastamount) . "</td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = ($lastamount);
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }
                } else {
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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and stk_no <> 'L0301' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 35) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (35 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  and stk_no <> 'L0301' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 35) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (35 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;
                        if ($lastamount == 0) {
                            $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td >" . number_format($lastamount) . "</td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                        } else {
                            $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td bgcolor='yellow'>" . number_format($lastamount) . "</td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                        }
                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = ($lastamount);
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }
                }
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code1,code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "','" . $row['cus_code1'] . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
//echo "2-".$sql_tmp."</br>";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);

                IF (!$result_tmp) {
                    ECHO mysqli_error($GLOBALS['dbinv']);
                }
            }
        }

//echo $row["cus_code"].":".$code." - ";
    }

    if (trim($_GET["combo1"]) == "SUNFUL") {
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
            $amount_45 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;
            $rtn_37 = 0;
            $rtn_45 = 0;
            $q40 = 0;
            $q43 = 0;
            $q37 = 0;
            $q45 = 0;
            $r40 = 0;
            $r43 = 0;
            $r37 = 0;
            $r45 = 0;
            $ccode = $row["cus_code"];


            $sql = "Select sum(qty) as qty from viewinv where cus_code = '" . trim($row["cus_code1"]) . "' and s_brand = 'SUNFUL TBR' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m = '0'   ";
//            echo $sql;
            $result_rs = mysqli_query($GLOBALS['dbinv'], $sql);
            $rs = mysqli_fetch_array($result_rs);
            if (!is_null($rs['qty'])) {
                $qa = $rs['qty'];
            }

            $sql = "select sum(qty)as qty from viewcrntrn where c_code = '" . trim($row["cus_code1"]) . "' and brand = 'SUNFUL TBR' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancell = '0'    ";
            $result_rs = mysqli_query($GLOBALS['dbinv'], $sql);
            $rs = mysqli_fetch_array($result_rs);
            if (!is_null($rs['qty'])) {
                $qa = $qa - $rs['qty'];
            }


            $mqty = 0;
            //$sql = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where  cus_code = '" . trim($row["cus_code1"]) . "' and DIS_per != 0 and DIS_per != 100 and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'";
            $sql = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv1   where  DIS_per !=100 and DIS_per !=0 and cus_code = '" . trim($row["cus_code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' ";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty + $row_m['qty'];
            }

            $sql = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code1"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != 0 and DIS_P != 100 and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' ";
//            $sql = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code1"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != 0 and DIS_P != 100 and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' ";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty - $row_m['qty'];
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

            $sql_40 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '30' and cancel_m='0'";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

            $sql_43 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and dis_per <> '30' AND DIS_PER <> '35' AND DIS_PER <> '37.5' and cancel_m='0' ";
            $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

            $sql_45 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and dis_per = '35' and cancel_m='0' ";
            $result_45 = mysqli_query($GLOBALS['dbinv'], $sql_45);

            $sql_37 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '37.5' and cancel_m='0'  ";
            $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

//////////////////////////////
            $sql_1_40 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '30' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' ";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P <> '30' and DIS_P <> '35' AND DIS_P <> '37.5' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' ";
            $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

            $sql_1_45 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35'  and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' ";
            $result_1_45 = mysqli_query($GLOBALS['dbinv'], $sql_1_45);

            $sql_1_37 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where  c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '37.5' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' ";
            $result_1_37 = mysqli_query($GLOBALS['dbinv'], $sql_1_37);
///////////////////////////

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

            if ($row_37 = mysqli_fetch_array($result_37)) {
                if ($row_37["qty"] != "") {
                    $q37 = $row_37["qty"];
                }
                if ($row_37["amount"] != "") {
                    $amount_37 = $row_37["amount"];
                }
            }

            if ($row_45 = mysqli_fetch_array($result_45)) {
                if ($row_45["qty"] != "") {
                    $q45 = $row_45["qty"];
                }
                if ($row_45["amount"] != "") {
                    $amount_45 = $row_45["amount"];
                }
            }
////////////////////////
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

            if ($row_1_45 = mysqli_fetch_array($result_1_45)) {
                if ($row_1_45["qty"] != "") {
                    $r45 = $row_1_45["qty"];
                }
                if ($row_1_43["grand_tot"] != "") {
                    $rtn_45 = $row_1_45["grand_tot"];
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
//////////////////////////////////


            $sql_rsven = "Select c_NAME as NAME  from vender_sub where C_CODE = '" . $row["cus_code"] . "'";
            $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
            if ($row_rsven = mysqli_fetch_array($result_rsven)) {

                if (($mqty + $qa) >= 200) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/S/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'  group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 40) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (40 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 40) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (40 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                            <td></td>
                            <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                            <td></td>
                            <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }


                    $ResponseXML .= "</tr>";
                } else if ((($mqty + $qa) >= 100)) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/S/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'  group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 37.5) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (37.5 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 37.5) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (37.5 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                        <td></td>
                        <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                        <td></td>
                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }
                } else if ((($mqty + $qa) >= 30)) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/S/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'  group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 35) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (35 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 35) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (35 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                        <td></td>
                       <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                        <td></td>
                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }
                } else {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/S/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
                        <td >" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
                        <td >" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
                        <td></td>
                        <td>Lock</td>";
                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";
                        $i = $i + 1;
                    } else {
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'  group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 30) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (30 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 30) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (30 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;
                        if ($lastamount == 0) {
                            $ResponseXML .= "<td>Not Saved</td>
                        <td></td>
                       <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                        <td></td>
                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                        } else {
                            $ResponseXML .= "<td>Not Saved</td>
                        <td></td>
                       <td bgcolor='yellow'>" . number_format($lastamount, 2, ".", ",") . "</td>
                        <td></td>
                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                        }
                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }
                }
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code1,code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "','" . $row['cus_code1'] . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
//echo "2-".$sql_tmp."</br>";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);

                IF (!$result_tmp) {
                    ECHO mysqli_error($GLOBALS['dbinv']);
                }
            }
        }

//echo $row["cus_code"].":".$code." - ";
    }

    if (trim($_GET["combo1"]) == "GREENTOUR") {
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
            $amount_45 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;
            $rtn_37 = 0;
            $rtn_45 = 0;
            $q40 = 0;
            $q43 = 0;
            $q37 = 0;
            $q45 = 0;
            $r40 = 0;
            $r43 = 0;
            $r37 = 0;
            $r45 = 0;
            $ccode = $row["cus_code"];


            $sql = "Select sum(qty) as qty from viewinv where cus_code = '" . trim($row["cus_code1"]) . "' and s_brand = 'SUNFUL TBR' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m = '0'   ";
            $result_rs = mysqli_query($GLOBALS['dbinv'], $sql);
            $rs = mysqli_fetch_array($result_rs);
            if (!is_null($rs['qty'])) {
                $qa = $rs['qty'];
            }

            $sql = "select sum(qty)as qty from viewcrntrn where c_code = '" . trim($row["cus_code1"]) . "' and brand = 'SUNFUL TBR' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancell = '0'    ";
            $result_rs = mysqli_query($GLOBALS['dbinv'], $sql);
            $rs = mysqli_fetch_array($result_rs);
            if (!is_null($rs['qty'])) {
                $qa = $qa - $rs['qty'];
            }


            $mqty = 0;
            $sql = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where  cus_code = '" . trim($row["cus_code1"]) . "' and DIS_per != 0 and DIS_per != 100 and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty + $row_m['qty'];
            }

            $sql = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code1"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != 0 and DIS_P != 100 and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' ";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty - $row_m['qty'];
            }



//            if ($mqty + $qa < 50) {
//                $qa = 0;
//            }


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

            $sql_40 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '35'  and stk_no <> 'G0034' and stk_no <> 'G0035' and stk_no <> 'G0048' and cancel_m='0'";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

            $sql_43 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'   and stk_no <> 'G0034' and stk_no <> 'G0035' and stk_no <> 'G0048' AND dis_per <> '35' AND DIS_PER <> '37.5' AND DIS_PER <> '40' and cancel_m='0' ";
            $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

            $sql_45 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and dis_per = '37.5'  and stk_no <> 'G0034' and stk_no <> 'G0035' and stk_no <> 'G0048' and cancel_m='0' ";
            $result_45 = mysqli_query($GLOBALS['dbinv'], $sql_45);

            $sql_37 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '40'  and stk_no <> 'G0034' and stk_no <> 'G0035' and stk_no <> 'G0048' and cancel_m='0'  ";
            $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

//////////////////////////////
            $sql_1_40 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0'  and stk_no <> 'G0034' and stk_no <> 'G0035' and stk_no <> 'G0048' ";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P <> '35' and DIS_P <> '37.5' AND DIS_P <> '40' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0'  and stk_no <> 'G0034' and stk_no <> 'G0035' and stk_no <> 'G0048' ";
            $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

            $sql_1_45 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '37.5'  and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0'  and stk_no <> 'G0034' and stk_no <> 'G0035' and stk_no <> 'G0048'";
            $result_1_45 = mysqli_query($GLOBALS['dbinv'], $sql_1_45);

            $sql_1_37 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where  c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '40' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0'  and stk_no <> 'G0034' and stk_no <> 'G0035' and stk_no <> 'G0048'";
            $result_1_37 = mysqli_query($GLOBALS['dbinv'], $sql_1_37);
///////////////////////////

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

            if ($row_37 = mysqli_fetch_array($result_37)) {
                if ($row_37["qty"] != "") {
                    $q37 = $row_37["qty"];
                }
                if ($row_37["amount"] != "") {
                    $amount_37 = $row_37["amount"];
                }
            }

            if ($row_45 = mysqli_fetch_array($result_45)) {
                if ($row_45["qty"] != "") {
                    $q45 = $row_45["qty"];
                }
                if ($row_45["amount"] != "") {
                    $amount_45 = $row_45["amount"];
                }
            }
////////////////////////
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

            if ($row_1_45 = mysqli_fetch_array($result_1_45)) {
                if ($row_1_45["qty"] != "") {
                    $r45 = $row_1_45["qty"];
                }
                if ($row_1_43["grand_tot"] != "") {
                    $rtn_45 = $row_1_45["grand_tot"];
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
//////////////////////////////////


            $sql_rsven = "Select c_NAME as NAME  from vender_sub where C_CODE = '" . $row["cus_code"] . "'";
            $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
            if ($row_rsven = mysqli_fetch_array($result_rsven)) {

                if (($mqty ) >= 36) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/G/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and  stk_no <> 'G0034' and stk_no <> 'G0035' and stk_no <> 'G0048' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 45) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (45 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' and  stk_no <> 'G0034' and stk_no <> 'G0035' and stk_no <> 'G0048' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 45) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (45 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                            <td></td>
                            <td>" . number_format(((($amount_37 - $rtn_37) / 60 * 2.5) + (($amount_45 - $rtn_45) / 62.5 * 5) + (($amount_40 - $rtn_40) / 65 * 7.5))) . "</td>
                            <td></td>
                            <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = ((($amount_37 - $rtn_37) / 60 * 2.5) + (($amount_45 - $rtn_45) / 62.5 * 5) + (($amount_40 - $rtn_40) / 65 * 7.5));
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }


                    $ResponseXML .= "</tr>";
                } else if ((($mqty ) >= 16)) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/G/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and  stk_no <> 'G0034' and stk_no <> 'G0035' and stk_no <> 'G0048' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 45) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (45 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' and  stk_no <> 'G0034' and stk_no <> 'G0035' and stk_no <> 'G0048' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 45) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (45 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                        <td></td>
                        <td>" . number_format(((($amount_45 - $rtn_45) / 62.5 * 2.5) + (($amount_40 - $rtn_40) / 65 * 5))) . "</td>
                        <td></td>
                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = ((($amount_45 - $rtn_45) / 62.5 * 2.5) + (($amount_40 - $rtn_40) / 65 * 5));
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }
                } else if ((($mqty ) >= 1)) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/G/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and  stk_no <> 'G0034' and stk_no <> 'G0035' and stk_no <> 'G0048' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 45) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (45 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' and  stk_no <> 'G0034' and stk_no <> 'G0035' and stk_no <> 'G0048' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 45) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (45 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                        <td></td>
                        <td>" . number_format(((($amount_40 - $rtn_40) / 65 * 2.5))) . "</td>
                        <td></td>
                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = ((($amount_40 - $rtn_40) / 65 * 2.5));
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }
                }
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code1,code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "','" . $row['cus_code1'] . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
//echo "2-".$sql_tmp."</br>";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);

                IF (!$result_tmp) {
                    ECHO mysqli_error($GLOBALS['dbinv']);
                }
            }
        }

//echo $row["cus_code"].":".$code." - ";
    }

    if (trim($_GET["combo1"]) == "OTANI") {
        $ResponseXML .= "<tr>
                              <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"20%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Name</font></td>
                                <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">38%/40%Amt</font></td>
                                <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">38%/40%Qty</font></td>
                                <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/38%Amt</font></td>
                                <td width=\"10%\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">35%/38Qty</font></td>
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


            $mqty = 0;
            $sql = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where  DIS_per !=100 and DIS_per !=0 and cus_code = '" . trim($row["cus_code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty + $row_m['qty'];
            }

            $sql = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where DIS_p !=100 and DIS_p !=0 and C_CODE='" . trim($row["cus_code1"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0'";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty - $row_m['qty'];
            }

            $sql = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where  DIS_per !=100 and DIS_per !=0 and cus_code = '" . trim($row["cus_code1"]) . "' and s_brand='ROADSTONE' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty + $row_m['qty'];
            }

            $sql = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where DIS_p !=100 and DIS_p !=0 and C_CODE='" . trim($row["cus_code1"]) . "' and   Brand='ROADSTONE' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0'";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty - $row_m['qty'];
            }


            $sql_40 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '35' and cancel_m='0' ";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

            $sql_37 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '38' and cancel_m='0'";
            $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

            $sql_1_37 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where costcenter ='0' and c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '38' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' ";
            $result_1_37 = mysqli_query($GLOBALS['dbinv'], $sql_1_37);

            $sql_43 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per != '35' and DIS_per!='38' and cancel_m='0' ";
            $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

            $sql_1_40 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' ";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '35' and DIS_P != '38' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' ";
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

            $sql_rsven = "Select c_name as name from vender_sub where c_code = '" . trim($row["cus_code"]) . "'";
            $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
            $row_rsven = mysqli_fetch_array($result_rsven);
            if ($mqty >= 15) {

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

                $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/O/" . $row["cus_code"];

                $chk = "chk" . $i;

                $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";

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
                    $amount_newinv = 0;
                    $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'   group by REF_NO,DIS_per,GRAND_TOT,c_code1";
                    $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                    while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                        if ($row_newinv['DIS_per'] <= 38) {
                            $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (38 - $row_newinv['DIS_per']);
                        }
                    }

                    $amount_newgrn = 0;
                    $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'    group by REF_NO,DIS_P,GRAND_TOT,c_code1";
                    $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                    while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                        if ($$row_newgrn['DIS_P'] <= 38) {
                            $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (38 - $row_newgrn['DIS_P']);
                        }
                    }

                    $lastamount = $amount_newinv - $amount_newgrn;

                    $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                    $crnno = "Not Saved";
                    $txndate = "";
                    $amount = $lastamount;
                    $amount_c = 0;
                    $status = "";
                    $i = $i + 1;
                }

                $ResponseXML .= "</tr>";
            } else {

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

                $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/O/" . $row["cus_code"];

                $chk = "chk" . $i;

                $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";

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
                    $amount_newinv = 0;
                    $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'   group by REF_NO,DIS_per,GRAND_TOT,c_code1";
                    $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                    while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                        if ($row_newinv['DIS_per'] <= 35) {
                            $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (35 - $row_newinv['DIS_per']);
                        }
                    }

                    $amount_newgrn = 0;
                    $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'    group by REF_NO,DIS_P,GRAND_TOT,c_code1";
                    $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                    while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                        if ($row_newgrn['DIS_P'] <= 35) {
                            $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (35 - $row_newgrn['DIS_P']);
                        }
                    }

                    $lastamount = $amount_newinv - $amount_newgrn;
                    if ($mqty >= 15) {
                        $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td bgcolor='yellow'>" . number_format($lastamount, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                    }
                    $crnno = "Not Saved";
                    $txndate = "";
                    $amount = $lastamount;
                    $amount_c = 0;
                    $status = "";
                    $i = $i + 1;
                }

                $ResponseXML .= "</tr>";
            }


            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code1,code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "','" . $row['cus_code1'] . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
//echo "1-".$sql_tmp."</br>";
            }
        }
    }

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
            $mqty = 0;

            $sql = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where dis_per != 0 and dis_per !=100 and cus_code = '" . trim($row["cus_code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty + $row_m['qty'];
            }

            $sql = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code1"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != 0 and dis_p !=100 and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty - $row_m['qty'];
            }

            $sql = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where  dis_per != 0 and dis_per !=100 and cus_code = '" . trim($row["cus_code1"]) . "' and s_brand='ROADSTONE CHINA' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty + $row_m['qty'];
            }

            $sql = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code1"]) . "' and   Brand='ROADSTONE CHINA' and DIS_P != 0 and dis_p !=100 and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty - $row_m['qty'];
            }
            $sql = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where  dis_per != 0 and dis_per !=100 and cus_code = '" . trim($row["cus_code1"]) . "' and s_brand='OTANI' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty + $row_m['qty'];
            }

            $sql = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code1"]) . "' and   Brand='OTANI' and DIS_P != 0 and dis_p !=100 and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty - $row_m['qty'];
            }

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

            $sql_40 = "Select c_code1, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where  costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and (DIS_per = 45 or dis_per = 47.5) and cancel_m='0' group by c_code1";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

            $sql_43 = "Select c_code1, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per != 45 and dis_per != 47.5  and DIS_per != 0 and cancel_m='0' group by c_code1";
            $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

            $sql_1_40 = "Select C_CODE1, sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and (DIS_P = 45 or dis_p = 47.5) and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_P != 0 and CANCELL='0' group by C_CODE";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select C_CODE1, sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and (DIS_P != 45 and dis_p != 47.5) and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_P != 0 and CANCELL='0' group by C_CODE";
            $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

            $sql_rst = "Select C_CODE1,sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and CANCELL='0' and DIS_P != 0 group by C_CODE";

            $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);

            if (date("Y", strtotime($_GET["dte_dor"])) >= 2014) {
                $sql_RS_40_C = "Select c_code1,sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='ROADSTONE CHINA' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and (DIS_per = 45 or DIS_per = 47.5) and cancel_m='0' group by c_code1";
                $result_RS_40_C = mysqli_query($GLOBALS['dbinv'], $sql_RS_40_C);

                $sql_43_C = "Select c_code1,sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='ROADSTONE CHINA' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(sdate)=" . date("Y", strtotime($_GET["dte_dor"])) . " and (DIS_per != 45 and DIS_per != 47.5) and DIS_per != 0 and  cancel_m='0' group by c_code1";
                $result_43_C = mysqli_query($GLOBALS['dbinv'], $sql_43_C);

                $sql_RS1_40_C = "Select C_CODE1,sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE1='" . trim($row["cus_code"]) . "' and   Brand='ROADSTONE CHINA' and (DIS_P = 45 or dis_p = 47.5) and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and DIS_P != 0 and CANCELL='0' group by C_CODE1";
                $result_RS1_40_C = mysqli_query($GLOBALS['dbinv'], $sql_RS1_40_C);

                $sql_RS1_43_C = "Select C_CODE1,sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE1='" . trim($row["cus_code"]) . "' and   Brand='ROADSTONE CHINA' and (DIS_P != 45 and dis_p != 47.5) and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and DIS_P != 0 and CANCELL='0' group by C_CODE1";
                $result_RS1_43_C = mysqli_query($GLOBALS['dbinv'], $sql_RS1_43_C);

                $sql_rst_c = "Select C_CODE1,sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE1='" . trim($row["cus_code"]) . "' and   Brand='ROADSTONE CHINA' and month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and DIS_P != 0 and CANCELL='0' group by C_CODE1";
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

            $sql_rsven = "Select c_name as NAME from vender_sub where c_CODE = '" . $row["cus_code"] . "'";
            $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
            if ($row_rsven = mysqli_fetch_array($result_rsven)) {

                if ($mqty >= 100) {


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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R/" . $row["cus_code"];
                    $m_flag1 = date("m/Y", strtotime($_GET["dte_dor"])) . "/R-C/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "' and CANCELL='0'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {

                            if ($row_newinv['DIS_per'] <= 50.5) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (50.5 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 50.5) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (50.5 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;
                        ///////////////////////ROADSTONE CHINA
                        $amount_newinv1 = 0;
                        $sql_newinv1 = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and BRAND='ROADSTONE CHINA' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv1 = mysqli_query($GLOBALS['dbinv'], $sql_newinv1);
                        while ($row_newinv1 = mysqli_fetch_array($result_newinv1)) {
                            if ($row_newinv1['DIS_per'] <= 50.5) {
                                $amount_newinv1 = $amount_newinv1 + ($row_newinv1['GRAND_TOT'] / (100 - $row_newinv1['DIS_per'])) * (50.5 - $row_newinv1['DIS_per']);
                            }
                        }

                        $amount_newgrn1 = 0;
                        $sql_newgrn1 = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and BRAND='ROADSTONE CHINA' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn1 = mysqli_query($GLOBALS['dbinv'], $sql_newgrn1);
                        while ($row_newgrn1 = mysqli_fetch_array($result_newgrn1)) {
                            if ($row_newgrn1['DIS_P'] <= 50.5) {
                                $amount_newgrn1 = $amount_newgrn1 + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn1['DIS_P'])) * (50.5 - $row_newgrn1['DIS_P']);
                            }
                        }

                        $lastamount1 = $amount_newinv1 - $amount_newgrn1;

                        $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                                        <td>" . number_format($lastamount1, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = $lastamount1;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                } elseif ($mqty >= 50) {


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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R/" . $row["cus_code"];
                    $m_flag1 = date("m/Y", strtotime($_GET["dte_dor"])) . "/R-C/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "' and CANCELL='0'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 49.125) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (49.125 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 49.125) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (49.125 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;
                        ///////////////////////ROADSTONE CHINA
                        $amount_newinv1 = 0;
                        $sql_newinv1 = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and BRAND='ROADSTONE CHINA' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv1 = mysqli_query($GLOBALS['dbinv'], $sql_newinv1);
                        while ($row_newinv1 = mysqli_fetch_array($result_newinv1)) {
                            if ($row_newinv1['DIS_per'] <= 49.125) {
                                $amount_newinv1 = $amount_newinv1 + ($row_newinv1['GRAND_TOT'] / (100 - $row_newinv1['DIS_per'])) * (49.125 - $row_newinv1['DIS_per']);
                            }
                        }

                        $amount_newgrn1 = 0;
                        $sql_newgrn1 = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and BRAND='ROADSTONE CHINA' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn1 = mysqli_query($GLOBALS['dbinv'], $sql_newgrn1);
                        while ($row_newgrn1 = mysqli_fetch_array($result_newgrn1)) {
                            if ($row_newgrn1['DIS_P'] <= 49.125) {
                                $amount_newgrn1 = $amount_newgrn1 + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn1['DIS_P'])) * (49.125 - $row_newgrn1['DIS_P']);
                            }
                        }

                        $lastamount1 = $amount_newinv1 - $amount_newgrn1;

                        $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                                        <td>" . number_format($lastamount1, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = $lastamount1;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                } elseif ($mqty >= 16) {


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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R/" . $row["cus_code"];
                    $m_flag1 = date("m/Y", strtotime($_GET["dte_dor"])) . "/R-C/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "' and CANCELL='0'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 47.75) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (47.75 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 47.75) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (47.75 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;
                        ///////////////////////ROADSTONE CHINA
                        $amount_newinv1 = 0;
                        $sql_newinv1 = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and BRAND='ROADSTONE CHINA' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv1 = mysqli_query($GLOBALS['dbinv'], $sql_newinv1);
                        while ($row_newinv1 = mysqli_fetch_array($result_newinv1)) {
                            if ($row_newinv1['DIS_per'] <= 47.75) {
                                $amount_newinv1 = $amount_newinv1 + ($row_newinv1['GRAND_TOT'] / (100 - $row_newinv1['DIS_per'])) * (47.75 - $row_newinv1['DIS_per']);
                            }
                        }

                        $amount_newgrn1 = 0;
                        $sql_newgrn1 = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and BRAND='ROADSTONE CHINA' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn1 = mysqli_query($GLOBALS['dbinv'], $sql_newgrn1);
                        while ($row_newgrn1 = mysqli_fetch_array($result_newgrn1)) {
                            if ($row_newgrn1['DIS_P'] <= 47.75) {
                                $amount_newgrn1 = $amount_newgrn1 + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn1['DIS_P'])) * (47.75 - $row_newgrn1['DIS_P']);
                            }
                        }

                        $lastamount1 = $amount_newinv1 - $amount_newgrn1;

                        $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                                        <td>" . number_format($lastamount1, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = $lastamount1;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                } elseif ($mqty >= 10) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R/" . $row["cus_code"];
                    $m_flag1 = date("m/Y", strtotime($_GET["dte_dor"])) . "/R-C/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "' and CANCELL='0'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 46.65) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (46.65 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 46.65) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (46.65 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;
                        ///////////////////////ROADSTONE CHINA
                        $amount_newinv1 = 0;
                        $sql_newinv1 = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and BRAND='ROADSTONE CHINA' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv1 = mysqli_query($GLOBALS['dbinv'], $sql_newinv1);
                        while ($row_newinv1 = mysqli_fetch_array($result_newinv1)) {
                            if ($row_newinv1['DIS_per'] <= 46.65) {
                                $amount_newinv1 = $amount_newinv1 + ($row_newinv1['GRAND_TOT'] / (100 - $row_newinv1['DIS_per'])) * (46.65 - $row_newinv1['DIS_per']);
                            }
                        }

                        $amount_newgrn1 = 0;
                        $sql_newgrn1 = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and BRAND='ROADSTONE CHINA' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn1 = mysqli_query($GLOBALS['dbinv'], $sql_newgrn1);
                        while ($row_newgrn1 = mysqli_fetch_array($result_newgrn1)) {
                            if ($row_newgrn1['DIS_P'] <= 46.65) {
                                $amount_newgrn1 = $amount_newgrn1 + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn1['DIS_P'])) * (46.65 - $row_newgrn1['DIS_P']);
                            }
                        }

                        $lastamount1 = $amount_newinv1 - $amount_newgrn1;

                        $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                                        <td>" . number_format($lastamount1, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = $lastamount1;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                } else {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R/" . $row["cus_code"];
                    $m_flag1 = date("m/Y", strtotime($_GET["dte_dor"])) . "/R-C/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "' and CANCELL='0'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 45) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (45 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 45) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (45 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;
                        ///////////////////////ROADSTONE CHINA
                        $amount_newinv1 = 0;
                        $sql_newinv1 = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and BRAND='ROADSTONE CHINA' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv1 = mysqli_query($GLOBALS['dbinv'], $sql_newinv1);
                        while ($row_newinv1 = mysqli_fetch_array($result_newinv1)) {
                            if ($row_newinv1['DIS_per'] <= 45) {
                                $amount_newinv1 = $amount_newinv1 + ($row_newinv1['GRAND_TOT'] / (100 - $row_newinv1['DIS_per'])) * (45 - $row_newinv1['DIS_per']);
                            }
                        }

                        $amount_newgrn1 = 0;
                        $sql_newgrn1 = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and BRAND='ROADSTONE CHINA' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn1 = mysqli_query($GLOBALS['dbinv'], $sql_newgrn1);
                        while ($row_newgrn1 = mysqli_fetch_array($result_newgrn1)) {
                            if ($row_newgrn1['DIS_P'] <= 45) {
                                $amount_newgrn1 = $amount_newgrn1 + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn1['DIS_P'])) * (45 - $row_newgrn1['DIS_P']);
                            }
                        }

                        $lastamount1 = $amount_newinv1 - $amount_newgrn1;
                        if ($lastamount == 0) {
                            $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                                        <td>" . number_format($lastamount1, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                        } else {
                            $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td bgcolor='yellow'>" . number_format($lastamount, 2, ".", ",") . "</td>
                                        <td bgcolor='yellow'>" . number_format($lastamount1, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                        }
                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = $lastamount1;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                }
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code1,code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "','" . $row['cus_code1'] . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', '" . $amount_c . "')";

                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
                if (!$result_tmp) {
                    echo mysqli_error($GLOBALS['dbinv']);
                }
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

            $mqty = 0;
            $sql = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv1   where  DIS_per !=100 and DIS_per !=0 and cus_code = '" . trim($row["cus_code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' AND type <> 'TBR'";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty + $row_m['qty'];
            }

            $sql = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where DIS_p !=100 and DIS_p !=0 and C_CODE='" . trim($row["cus_code1"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0'  AND s_type <> 'TBR'";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty - $row_m['qty'];
            }

            $sql_40 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv1   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '40' and cancel_m='0'  AND type <> 'TBR' ";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

            $sql_43 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv1   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per != '40' and DIS_per !=0 and cancel_m='0'  AND type <> 'TBR' ";
            $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

            $sql_1_40 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '40' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_P !=0  and CANCELL='0'  AND s_type <> 'TBR' ";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '40' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and DIS_P !=0  and CANCELL='0'  AND s_type <> 'TBR'";
            $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

            $sql_37 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv1   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '43' and cancel_m='0'  AND type <> 'TBR' ";
            $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

            $sql_1_37 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '43' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0'  and DIS_P !=0  AND s_type <> 'TBR' ";
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


            $sql_rsven = "Select c_name as NAME from vender_sub where c_CODE = '" . $row["cus_code"] . "'";
            $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
            $row_rsven = mysqli_fetch_array($result_rsven);

            $q1 = 0;
            $q2 = 0;
            $va1 = 0;
            $va2 = 0;
            $comm1 = 0;
            $comm2 = 0;
            $mtotqty = $mqty;
//                if ($mqty >= 75) {
//
//                    $va1 = ($amount_43 - $rtn_43);
//                    $q1 = ($q43 - $r43);
//                    $va2 = ($amount_40 - $rtn_40);
//                    $q2 = ($q40 - $r40);
//
//                    $comm1 = (($amount_40 - $rtn_40) / 100 * 7.5);
//                    $comm2 = 0;
//                } else 
            if ($mqty >= 40) {

                $va1 = ($amount_43 - $rtn_43);
                $q1 = ($q43 - $r43);
                $va2 = ($amount_40 - $rtn_40);
                $q2 = ($q40 - $r40);

                $amount_newinv = 0;
                $sql_newinv = "Select * from viewinv1   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and type <> 'TBR'  group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                    if ($row_newinv['DIS_per'] <= 45.85) {
                        $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (45.85 - $row_newinv['DIS_per']);
                    }
                }

                $amount_newgrn = 0;
                $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' and s_type <> 'TBR'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                    if ($row_newgrn['DIS_P'] <= 45.85) {
                        $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (45.85 - $row_newgrn['DIS_P']);
                    }
                }

                $comm1 = $amount_newinv - $amount_newgrn;
                $comm2 = 0;
            } else if ($mqty >= 20) {


                $va1 = ($amount_43 - $rtn_43);
                $q1 = ($q43 - $r43);
                $va2 = ($amount_40 - $rtn_40);
                $q2 = ($q40 - $r40);
                $amount_newinv = 0;
                $sql_newinv = "Select * from viewinv1   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and type <> 'TBR' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                    if ($row_newinv['DIS_per'] <= 43) {
                        $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (43 - $row_newinv['DIS_per']);
                    }
                }

                $amount_newgrn = 0;
                $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  and s_type <> 'TBR' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                    if ($row_newgrn['DIS_P'] <= 43) {
                        $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (43 - $row_newgrn['DIS_P']);
                    }
                }

                $comm1 = $amount_newinv - $amount_newgrn;
                $comm2 = 0;
            } else {
                $va1 = ($amount_43 - $rtn_43);
                $q1 = ($q43 - $r43);
                $va2 = ($amount_40 - $rtn_40);
                $q2 = ($q40 - $r40);

                $amount_newinv = 0;
                $sql_newinv = "Select * from viewinv1   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and type <> 'TBR' group by REF_NO,DIS_per,GRAND_TOT,c_code1";
//echo $sql_newinv;
                $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                    if ($row_newinv['DIS_per'] <= 40) {
                        $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (40 - $row_newinv['DIS_per']);
                    }
                }

                $amount_newgrn = 0;
                $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  and s_type <> 'TBR' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                    if ($row_newgrn['DIS_P'] <= 40) {
                        $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (40 - $row_newgrn['DIS_P']);
                    }
                }

                $comm1 = $amount_newinv - $amount_newgrn;
                $comm2 = 0;
            }


            $gq1 = 0;
            $gq2 = 0;
            $gva1 = 0;
            $gva2 = 0;
            $gcomm1 = 0;
            $gcomm2 = 0;



            if ($comm1 >= 0) {
                $ResponseXML .= "<tr>";
                $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                $ResponseXML .= "<td>" . $row_rsven['NAME'] . " / " . $mqty . "</td>";
                $ResponseXML .= "<td>" . ($va1) . "</td>";
                $ResponseXML .= "<td>" . ($q1) . "</td>";
                $ResponseXML .= "<td>" . ($va2) . "</td>";
                $ResponseXML .= "<td>" . ($q2) . "</td>";

                $code = $row["cus_code"];
                $name = $row_rsven['NAME'];
                $amount1 = ($va1);
                $qty1 = $q1;
                $amount2 = ($va2);
                $qty2 = $q2;

                $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/P/" . $row["cus_code"];


                $chk = "chk" . $i;
                $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
//                echo $sql_rs1;
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
                    if ($mqty >= 20) {
                        $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td >" . number_format($comm1, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                    } else {
                        if ($comm1 == 0) {
                            $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td >" . number_format($comm1, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                        } else {
                            $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td bgcolor='yellow'>" . number_format($comm1, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                        }
                    }
                    $crnno = "Not Saved";
                    $txndate = "";
                    $amount = ($comm1);
                    $amount_c = 0;
                    $status = "";
                    $i = $i + 1;
                }
                $ResponseXML .= "</tr>";
            }

            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code1,code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "','" . $row['cus_code1'] . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', '" . $amount_c . "')";
//               echo $sql_tmp;
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
//                if (!$result_tmp) {
//                    echo mysqli_error($GLOBALS['dbinv']);
//                }
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

            $mqty = 0;

            $sql = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where  cus_code = '" . trim($row["cus_code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and DIS_per != 0  and DIS_per != 100 and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' AND STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352'  AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359' ";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty + $row_m['qty'];
            }

            $sql = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code1"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != 0  and dis_p != 100 and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0'  AND STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359'  ";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty - $row_m['qty'];
            }


            $sql_40 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '35' and cancel_m='0' AND STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359'";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

            $sql_43 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per != '35' and cancel_m='0' AND STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359'";
            $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

            $sql_37 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '37.5' and cancel_m='0' AND STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359'";
            $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

            $sql_1_40 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' AND STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359'";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != '35'  and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' AND STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359'";
            $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

            $sql_1_37 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where  c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '37.5' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' AND STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359'";
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

            $sql_rsven = "Select c_name as NAME from vender_sub where c_CODE = '" . $row["cus_code"] . "'";
            $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
            if ($row_rsven = mysqli_fetch_array($result_rsven)) {

                if (($mqty >= 48)) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/W/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and  STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 43) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (43 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' and  STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 43) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (43 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format((($lastamount)), 2, ".", ",") . "</td>
                                        <td></td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                } else if (($mqty >= 20)) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/W/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and  STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 40.625) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (40.625 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' and  STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 40.625) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (40.625 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format((($lastamount)), 2, ".", ",") . "</td>
                                        <td></td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                } else if (($mqty >= 1)) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/W/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and  STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 35) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (35 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' and  STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 35) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (35 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format((($lastamount)), 2, ".", ",") . "</td>
                                        <td></td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                } else {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/W/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and  STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 35) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (35 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' and  STK_NO <> 'A0350' AND STK_NO <> 'A0351' AND STK_NO <> 'A0352' AND  STK_NO <> 'A0797' AND STK_NO <> 'A0353' AND STK_NO <> 'A0354' AND STK_NO <> 'A0356' AND STK_NO <> 'AL001' AND STK_NO <> 'AL002' AND STK_NO <> 'AL003' and stk_no <>'A0359' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newinv['DIS_per'] <= 35) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (35 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;
                        if ($lastamount == 0) {
                            $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format((($lastamount)), 2, ".", ",") . "</td>
                                        <td></td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                        } else {
                            $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td bgcolor='yellow'>" . number_format((($lastamount)), 2, ".", ",") . "</td>
                                        <td></td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                        }
                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                }
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code1,code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "','" . $row['cus_code1'] . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
//echo "3-".$sql_tmp."</br>";
                //echo $sql_tmp;	
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
            }
        }
    }

    if (trim($_GET["combo1"]) == "ZEETEX") {
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
            $mqty = 0;

            $sql = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where dis_per != 0 and dis_per !=100 and cus_code = '" . trim($row["cus_code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty + $row_m['qty'];
            }

            $sql = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code1"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != 0 and dis_p !=100 and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty - $row_m['qty'];
            }

//            $sql = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where  dis_per != 0 and dis_per !=100 and cus_code = '" . trim($row["cus_code1"]) . "' and s_brand='ROADSTONE CHINA' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'";
//            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
//            if ($row_m = mysqli_fetch_array($result_m)) {
//                $mqty = $mqty + $row_m['qty'];
//            }
//
//            $sql = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code1"]) . "' and   Brand='ROADSTONE CHINA' and DIS_P != 0 and dis_p !=100 and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' group by C_CODE";
//            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
//            if ($row_m = mysqli_fetch_array($result_m)) {
//                $mqty = $mqty - $row_m['qty'];
//            }

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

            $sql_40 = "Select c_code1, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where  costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and (DIS_per = 45 or dis_per = 47.5) and cancel_m='0' group by c_code1";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

            $sql_43 = "Select c_code1, sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per != 45 and dis_per != 47.5  and DIS_per != 0 and cancel_m='0' group by c_code1";
            $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

            $sql_1_40 = "Select C_CODE1, sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and (DIS_P = 45 or dis_p = 47.5) and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_P != 0 and CANCELL='0' group by C_CODE";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select C_CODE1, sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and (DIS_P != 45 and dis_p != 47.5) and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_P != 0 and CANCELL='0' group by C_CODE";
            $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

            $sql_rst = "Select C_CODE1,sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and CANCELL='0' and DIS_P != 0 group by C_CODE";

            $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);

            if (date("Y", strtotime($_GET["dte_dor"])) >= 2014) {
//                $sql_RS_40_C = "Select c_code1,sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='ROADSTONE CHINA' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and (DIS_per = 45 or DIS_per = 47.5) and cancel_m='0' group by c_code1";
//                $result_RS_40_C = mysqli_query($GLOBALS['dbinv'], $sql_RS_40_C);
//
//                $sql_43_C = "Select c_code1,sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='ROADSTONE CHINA' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(sdate)=" . date("Y", strtotime($_GET["dte_dor"])) . " and (DIS_per != 45 and DIS_per != 47.5) and DIS_per != 0 and  cancel_m='0' group by c_code1";
//                $result_43_C = mysqli_query($GLOBALS['dbinv'], $sql_43_C);
//
//                $sql_RS1_40_C = "Select C_CODE1,sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE1='" . trim($row["cus_code"]) . "' and   Brand='ROADSTONE CHINA' and (DIS_P = 45 or dis_p = 47.5) and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and DIS_P != 0 and CANCELL='0' group by C_CODE1";
//                $result_RS1_40_C = mysqli_query($GLOBALS['dbinv'], $sql_RS1_40_C);
//
//                $sql_RS1_43_C = "Select C_CODE1,sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE1='" . trim($row["cus_code"]) . "' and   Brand='ROADSTONE CHINA' and (DIS_P != 45 and dis_p != 47.5) and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and DIS_P != 0 and CANCELL='0' group by C_CODE1";
//                $result_RS1_43_C = mysqli_query($GLOBALS['dbinv'], $sql_RS1_43_C);
//
//                $sql_rst_c = "Select C_CODE1,sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE1='" . trim($row["cus_code"]) . "' and   Brand='ROADSTONE CHINA' and month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . " and DIS_P != 0 and CANCELL='0' group by C_CODE1";
//
//                $result_rst_c = mysqli_query($GLOBALS['dbinv'], $sql_rst_c);
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
//                if ($row_RS_40_C = mysqli_fetch_array($result_RS_40_C)) {
//                    if ($row_RS_40_C["qty"] != "") {
//                        $q40_C = $row_RS_40_C["qty"];
//                    }
//                    if ($row_RS_40_C["amount"] != "") {
//                        $amount_40_C = $row_RS_40_C["amount"];
//                    }
//                }
//                if ($row_43_C = mysqli_fetch_array($result_43_C)) {
//                    if ($row_43_C["qty"] != "") {
//                        $q43_C = $row_43_C["qty"];
//                    }
//                    if ($row_43_C["amount"] != "") {
//                        $amount_43_C = $row_43_C["amount"];
//                    }
//                }
//                if ($row_RS1_40_C = mysqli_fetch_array($result_RS1_40_C)) {
//                    if ($row_RS1_40_C["qty"] != "") {
//                        $r40_C = $row_RS1_40_C["qty"];
//                    }
//                    if ($row_RS1_40_C["grand_tot"] != "") {
//                        $rtn_40_C = $row_RS1_40_C["grand_tot"];
//                    }
//                }
//                if ($row_RS1_43_C = mysqli_fetch_array($result_RS1_43_C)) {
//                    if ($row_RS1_43_C["qty"] != "") {
//                        $r43_C = $row_RS1_43_C["qty"];
//                    }
//                    if ($row_RS1_43_C["grand_tot"] != "") {
//                        $rtn_43_C = $row_RS1_43_C["grand_tot"];
//                    }
//                }
//                if ($row_rst_c = mysqli_fetch_array($result_rst_c)) {
//                    if ($row_rst_c["grand_tot"] != "") {
//                        $rtn_c = $row_rst_c["grand_tot"];
//                    }
//                }
            }

            $sql_rsven = "Select c_name as NAME from vender_sub where c_CODE = '" . $row["cus_code"] . "'";
            $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
            if ($row_rsven = mysqli_fetch_array($result_rsven)) {

                if ($mqty >= 20) {


                    $ResponseXML .= "<tr>";
                    $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                    $ResponseXML .= "<td>" . $row_rsven['NAME'] . "</td>";
                    $ResponseXML .= "<td>" . number_format(($amount_43 - $rtn_43), 2, ".", ",") . "</td>";
                    $ResponseXML .= "<td>" . ($q43 + $q43_C - $r43 - $r43_C) . "</td>";
                    $ResponseXML .= "<td>" . number_format(($amount_40 - $rtn_40), 2, ".", ",") . "</td>";
                    $ResponseXML .= "<td>" . ($q40 - $r40) . "</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['NAME'];
                    $amount1 = ($amount_43 - $rtn_43);
                    $qty1 = $q43 - $r43;
                    $amount2 = ($amount_40 - $rtn_40);
                    $qty2 = $q40 - $r40;

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/ZE/" . $row["cus_code"];
//                    $m_flag1 = date("m/Y", strtotime($_GET["dte_dor"])) . "/R-C/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "' and CANCELL='0'";
//                    $sql_rs2 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag1) . "' and CANCELL='0'";

                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);

//                    $result_rs2 = mysqli_query($GLOBALS['dbinv'], $sql_rs2);
//                    $row_rs2 = mysqli_fetch_array($result_rs2);

                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
                                        <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
                                        <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td> 
                                         <td>" . number_format(0, 2, ".", ",") . "</td>
                                        <td>Lock</td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
//                        $amount_c = $row_rs2["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";

                        $i = $i + 1;
                    } else {
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {

                            if ($row_newinv['DIS_per'] <= 34.2) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (34.2 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 34.2) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (34.2 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;


                        $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format($lastamount, 2, ".", ",") . "</td> 
                                        <td>" . number_format(0, 2, ".", ",") . "</td> 
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                } elseif ($mqty >= 10) {


                    $ResponseXML .= "<tr>";
                    $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                    $ResponseXML .= "<td>" . $row_rsven['NAME'] . "</td>";
                    $ResponseXML .= "<td>" . number_format(($amount_43 - $rtn_43), 2, ".", ",") . "</td>";
                    $ResponseXML .= "<td>" . ($q43 + $q43_C - $r43 - $r43_C) . "</td>";
                    $ResponseXML .= "<td>" . number_format(($amount_40 - $rtn_40), 2, ".", ",") . "</td>";
                    $ResponseXML .= "<td>" . ($q40 - $r40) . "</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['NAME'];
                    $amount1 = ($amount_43 - $rtn_43);
                    $qty1 = $q43 + $q43_C - $r43 - $r43_C;
                    $amount2 = ($amount_40 - $rtn_40);
                    $qty2 = $q40 - $r40;

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/ZE/" . $row["cus_code"];
//                    $m_flag1 = date("m/Y", strtotime($_GET["dte_dor"])) . "/R-C/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "' and CANCELL='0'";
//                    $sql_rs2 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag1) . "' and CANCELL='0'";

                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);

//                    $result_rs2 = mysqli_query($GLOBALS['dbinv'], $sql_rs2);
//                    $row_rs2 = mysqli_fetch_array($result_rs2);

                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
                                        <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
                                        <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
                                        <td>" . number_format(0, 2, ".", ",") . "</td>
                                        <td>Lock</td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";

                        $i = $i + 1;
                    } else {
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 32.1) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (32.1 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 32.1) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (32.1 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                                        <td>" . number_format(0, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                } else {

                    $ResponseXML .= "<tr>";
                    $ResponseXML .= "<td>" . $row["cus_code"] . "</td>";
                    $ResponseXML .= "<td>" . $row_rsven['NAME'] . "</td>";
                    $ResponseXML .= "<td>" . number_format(($amount_43 - $rtn_43), 2, ".", ",") . "</td>";
                    $ResponseXML .= "<td>" . ($q43 - $r43) . "</td>";
                    $ResponseXML .= "<td>" . number_format(($amount_40 - $rtn_40), 2, ".", ",") . "</td>";
                    $ResponseXML .= "<td>" . ($q40 - $r40) . "</td>";

                    $code = $row["cus_code"];
                    $name = $row_rsven['NAME'];
                    $amount1 = ($amount_43 - $rtn_43);
                    $qty1 = $q43 - $r43;
                    $amount2 = ($amount_40 - $rtn_40);
                    $qty2 = $q40 - $r40;

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/ZE/" . $row["cus_code"];
//                    $m_flag1 = date("m/Y", strtotime($_GET["dte_dor"])) . "/R-C/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "' and CANCELL='0'";
//                    $sql_rs2 = "Select * from cred where C_CODE='" . $row["cus_code"] . "' and C_SETINV ='" . trim($m_flag1) . "' and CANCELL='0'";

                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);

//                    $result_rs2 = mysqli_query($GLOBALS['dbinv'], $sql_rs2);
//                    $row_rs2 = mysqli_fetch_array($result_rs2);

                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
                                        <td>" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
                                        <td>" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
                                        <td>" . number_format(0, 2, ".", ",") . "</td>
                                        <td>Lock</td>";

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";

                        $i = $i + 1;
                    } else {
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 30) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (30 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0'  group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 30) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (30 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;


                        if ($lastamount == 0) {
                            $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                                        <td>" . number_format(0, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                        } else {
                            $ResponseXML .= "<td>Not Saved</td>
                                        <td></td>
                                        <td bgcolor='yellow'>" . number_format($lastamount, 2, ".", ",") . "</td>
                                        <td bgcolor='yellow'>" . number_format(0, 2, ".", ",") . "</td>
                                        <td></td>
                                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                        }
                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                }
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code1,code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "','" . $row['cus_code1'] . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', '" . $amount_c . "')";

                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
                if (!$result_tmp) {
                    echo mysqli_error($GLOBALS['dbinv']);
                }
            }
        }
    }

    if (trim($_GET["combo1"]) == "MIRAGE") {
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
            $amount_45 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;
            $rtn_37 = 0;
            $rtn_45 = 0;
            $q40 = 0;
            $q43 = 0;
            $q37 = 0;
            $q45 = 0;
            $r40 = 0;
            $r43 = 0;
            $r37 = 0;
            $r45 = 0;
            $ccode = $row["cus_code"];


            $sql = "Select sum(qty) as qty from viewinv where cus_code = '" . trim($row["cus_code1"]) . "' and s_brand = 'MIRAGE' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m = '0'  and STK_NO <> 'MR099' ";
//            echo $sql;
            $result_rs = mysqli_query($GLOBALS['dbinv'], $sql);
            $rs = mysqli_fetch_array($result_rs);
            if (!is_null($rs['qty'])) {
                $qa = $rs['qty'];
            }

            $sql = "select sum(qty)as qty from viewcrntrn where c_code = '" . trim($row["cus_code1"]) . "' and brand = 'MIRAGE' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancell = '0'  and STK_NO <> 'MR099'  ";
            $result_rs = mysqli_query($GLOBALS['dbinv'], $sql);
            $rs = mysqli_fetch_array($result_rs);
            if (!is_null($rs['qty'])) {
                $qa = $qa - $rs['qty'];
            }


            $mqty = 0;
            //$sql = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where  cus_code = '" . trim($row["cus_code1"]) . "' and DIS_per != 0 and DIS_per != 100 and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'";
            $sql = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv1   where  DIS_per !=100 and DIS_per !=0 and cus_code = '" . trim($row["cus_code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and STK_NO <> 'MR099'";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty + $row_m['qty'];
            }

            $sql = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code1"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != 0 and DIS_P != 100 and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' and STK_NO <> 'MR099' ";
//            $sql = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where C_CODE='" . trim($row["cus_code1"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P != 0 and DIS_P != 100 and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' ";
            $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_m = mysqli_fetch_array($result_m)) {
                $mqty = $mqty - $row_m['qty'];
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

            $sql_40 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '30' and cancel_m='0' and STK_NO <> 'MR099'";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

            $sql_43 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and dis_per <> '30' AND DIS_PER <> '35' AND DIS_PER <> '37.5' and cancel_m='0' and STK_NO <> 'MR099' ";
            $result_43 = mysqli_query($GLOBALS['dbinv'], $sql_43);

            $sql_45 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and dis_per = '35' and cancel_m='0' and STK_NO <> 'MR099'";
            $result_45 = mysqli_query($GLOBALS['dbinv'], $sql_45);

            $sql_37 = "Select  sum(QTY) as qty, sum((PRICE * QTY) * ((100 - DIS_per)/100)) as amount from viewinv   where costcenter ='0' and c_code1 = '" . trim($row["cus_code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = '37.5' and cancel_m='0' and STK_NO <> 'MR099' ";
            $result_37 = mysqli_query($GLOBALS['dbinv'], $sql_37);

//////////////////////////////
            $sql_1_40 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '30' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' and STK_NO <> 'MR099'";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P <> '30' and DIS_P <> '35' AND DIS_P <> '37.5' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' and STK_NO <> 'MR099'";
            $result_1_43 = mysqli_query($GLOBALS['dbinv'], $sql_1_43);

            $sql_1_45 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '35'  and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' and STK_NO <> 'MR099'";
            $result_1_45 = mysqli_query($GLOBALS['dbinv'], $sql_1_45);

            $sql_1_37 = "Select  sum(qty) as qty, sum((s_price * qty) * ((100 - DIS_P)/100)) as grand_tot from viewcrntrn where  c_code1='" . trim($row["cus_code"]) . "' and   Brand='" . trim($_GET["combo1"]) . "' and DIS_P = '37.5' and    SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and CANCELL='0' and STK_NO <> 'MR099'";
            $result_1_37 = mysqli_query($GLOBALS['dbinv'], $sql_1_37);
///////////////////////////

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

            if ($row_37 = mysqli_fetch_array($result_37)) {
                if ($row_37["qty"] != "") {
                    $q37 = $row_37["qty"];
                }
                if ($row_37["amount"] != "") {
                    $amount_37 = $row_37["amount"];
                }
            }

            if ($row_45 = mysqli_fetch_array($result_45)) {
                if ($row_45["qty"] != "") {
                    $q45 = $row_45["qty"];
                }
                if ($row_45["amount"] != "") {
                    $amount_45 = $row_45["amount"];
                }
            }
////////////////////////
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

            if ($row_1_45 = mysqli_fetch_array($result_1_45)) {
                if ($row_1_45["qty"] != "") {
                    $r45 = $row_1_45["qty"];
                }
                if ($row_1_43["grand_tot"] != "") {
                    $rtn_45 = $row_1_45["grand_tot"];
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
//////////////////////////////////


            $sql_rsven = "Select c_NAME as NAME  from vender_sub where C_CODE = '" . $row["cus_code"] . "'";
            $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
            if ($row_rsven = mysqli_fetch_array($result_rsven)) {

                if (($mqty) >= 200) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/MI/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and STK_NO <> 'MR099' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 40) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (40 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' and STK_NO <> 'MR099' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 40) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (40 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                            <td></td>
                            <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                            <td></td>
                            <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }


                    $ResponseXML .= "</tr>";
                } else if ((($mqty) >= 100)) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/MI/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0'  and STK_NO <> 'MR099' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 37.5) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (37.5 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' and STK_NO <> 'MR099' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 37.5) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (37.5 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                        <td></td>
                        <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                        <td></td>
                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }
                } else if ((($mqty) >= 30)) {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/MI/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
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
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and STK_NO <> 'MR099' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 35) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (35 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' and STK_NO <> 'MR099' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 35) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (35 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;

                        $ResponseXML .= "<td>Not Saved</td>
                        <td></td>
                       <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                        <td></td>
                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }
                } else {

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

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/MI/" . $row["cus_code"];

                    $chk = "chk" . $i;

                    $sql_rs1 = "Select * from cred where C_CODE='" . $row["cus_code1"] . "' and C_SETINV ='" . trim($m_flag) . "'";
                    $result_rs1 = mysqli_query($GLOBALS['dbinv'], $sql_rs1);
                    if ($row_rs1 = mysqli_fetch_array($result_rs1)) {
                        $ResponseXML .= "<td>" . $row_rs1["C_REFNO"] . "</td>
                        <td >" . date("Y-m-d", strtotime($row_rs1["C_DATE"])) . "</td>
                        <td >" . number_format($row_rs1["C_PAYMENT"], 2, ".", ",") . "</td>
                        <td></td>
                        <td>Lock</td>";
                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";
                        $i = $i + 1;
                    } else {
                        $amount_newinv = 0;
                        $sql_newinv = "Select * from viewinv   where c_code1='" . trim($row["cus_code"]) . "' and Brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' and STK_NO <> 'MR099' group by REF_NO,DIS_per,GRAND_TOT,c_code1";

                        $result_newinv = mysqli_query($GLOBALS['dbinv'], $sql_newinv);
                        while ($row_newinv = mysqli_fetch_array($result_newinv)) {
                            if ($row_newinv['DIS_per'] <= 30) {
                                $amount_newinv = $amount_newinv + ($row_newinv['GRAND_TOT'] / (100 - $row_newinv['DIS_per'])) * (30 - $row_newinv['DIS_per']);
                            }
                        }

                        $amount_newgrn = 0;
                        $sql_newgrn = "Select * from viewcrntrn   where c_code1='" . trim($row["cus_code"]) . "'  and Brand='" . trim($_GET["combo1"]) . "' and (month(SDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "' and  month(DDATE)='" . date("m", strtotime($_GET["dtfrom"])) . "') and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancell='0' and STK_NO <> 'MR099' group by REF_NO,DIS_P,GRAND_TOT,c_code1";

                        $result_newgrn = mysqli_query($GLOBALS['dbinv'], $sql_newgrn);
                        while ($row_newgrn = mysqli_fetch_array($result_newgrn)) {
                            if ($row_newgrn['DIS_P'] <= 30) {
                                $amount_newgrn = $amount_newgrn + ($row_newgrn['GRAND_TOT'] / (100 - $row_newgrn['DIS_P'])) * (30 - $row_newgrn['DIS_P']);
                            }
                        }

                        $lastamount = $amount_newinv - $amount_newgrn;
                        if ($lastamount == 0) {
                            $ResponseXML .= "<td>Not Saved</td>
                        <td></td>
                       <td>" . number_format($lastamount, 2, ".", ",") . "</td>
                        <td></td>
                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                        } else {
                            $ResponseXML .= "<td>Not Saved</td>
                        <td></td>
                       <td bgcolor='yellow'>" . number_format($lastamount, 2, ".", ",") . "</td>
                        <td></td>
                        <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";
                        }
                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = $lastamount;
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }
                }
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code1,code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "','" . $row['cus_code1'] . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
//echo "2-".$sql_tmp."</br>";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);

                IF (!$result_tmp) {
                    ECHO mysqli_error($GLOBALS['dbinv']);
                }
            }
        }

//echo $row["cus_code"].":".$code." - ";
    }
 
    $ResponseXML .= "</table>]]></balance_table>";
    $ResponseXML .= "</balancedetails>";
    echo $ResponseXML;
}




if ($_GET["Command"] == "changechk") {
    $sql_tmp = "update tmp_auto_credit_note set status= '" . $_GET["chk"] . "' where code1='" . $_GET["code"] . "'";
    // echo $sql_tmp;
    $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
}

if ($_GET["Command"] == "save_inv") {

    $mvatrate = 8;

    $sql = "Select vatrate from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);

    $mvatrate = $row['vatrate'];




    $sql_tmp = "select * from tmp_auto_credit_note";
    $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
    while ($row_tmp = mysqli_fetch_array($result_tmp)) {
//        echo 'sad'; 
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


                    if (trim($_GET["combo1"]) == "WILLFLY") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per != 40 and cancel_m='0' order by id";


                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/W/" . trim($row_tmp['code1']);
                    }


                    if (trim($_GET["combo1"]) == "LINGLONG") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = 35 and cancel_m='0' order by id";


                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L/" . trim($row_tmp['code1']);
                    }

                    if (trim($_GET["combo1"]) == "SUNFUL") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = 30 and cancel_m='0' order by id";


                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/S/" . trim($row_tmp['code1']);
                    }
                    if (trim($_GET["combo1"]) == "MIRAGE") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = 30 and cancel_m='0' order by id";


                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/MI/" . trim($row_tmp['code1']);
                    }

                    if (trim($_GET["combo1"]) == "OTANI") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = 35 and cancel_m='0' order by id";

                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/C/" . trim($row_tmp['code1']);
                    }


                    if (trim($_GET["combo1"]) == "GREENTOUR") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancel_m='0' order by id";

                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/G/" . trim($row_tmp['code1']);
                    }


                    if (trim($_GET["combo1"]) == "PRESA") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' order by id";
//echo  $sql_RSINVO.'tt';
                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/P/" . trim($row_tmp['code1']);
                    }

                    if (trim($_GET["combo1"]) == "ROADSTONE") {

                        if ($X == 1) {
                            $sql_RSINVO = "select REF_NO, SAL_EX, DEPARTMENT from viewinv where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . "  and cancel_m='0' order by id ";
                        }
                        if ($X == 2) {
                            $sql_RSINVO = "select REF_NO, SAL_EX, DEPARTMENT from viewinv where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='ROADSTONE CHINA' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . "  and cancel_m='0' order by id ";
                        }

                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R/" . trim($row_tmp['code1']);
                    }

                    $txt_invno = $row_RSINVO["REF_NO"];
                    $m_rep = $row_RSINVO["SAL_EX"];
                    $m_dep = $row_RSINVO["DEPARTMENT"];



                    if (trim($_GET["combo1"]) == "ZEETEX") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/ZE/" . trim($row_tmp['code1']);
                    }
                    if (trim($_GET["combo1"]) == "WILLFLY") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/W/" . trim($row_tmp['code1']);
                    }

                    if (trim($_GET["combo1"]) == "LINGLONG") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/L/" . trim($row_tmp['code1']);
                    }
                    if (trim($_GET["combo1"]) == "SUNFUL") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/S/" . trim($row_tmp['code1']);
                    }
                    if (trim($_GET["combo1"]) == "MIRAGE") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/MI/" . trim($row_tmp['code1']);
                    }
                    if (trim($_GET["combo1"]) == "OTANI") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/C/" . trim($row_tmp['code1']);
                    }

                    if (trim($_GET["combo1"]) == "PRESA") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/P/" . trim($row_tmp['code1']);
                    }

                    if (trim($_GET["combo1"]) == "ROADSTONE") {
                        if ($X == 1) {
                            $$m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/R/" . trim($row_tmp['code1']);
                        }
                        if ($X == 2) {
                            $$m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/R-C/" . trim($row_tmp['code1']);
                        }
                    }

                    if (trim($_GET["combo1"]) == "WILLFLY") {
                        $txt_remark = "Additional 2.5% Trade Discount for WILLFLY - month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }


                    if (trim($_GET["combo1"]) == "LINGLONG") {
                        $txt_remark = "Additional 2.5% Trade Discount for LING LONG month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
                    if (trim($_GET["combo1"]) == "SUNFUL") {
                        $txt_remark = "Additional 2.5% Trade Discount for SUNFUL month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
                    if (trim($_GET["combo1"]) == "MIRAGE") {
                        $txt_remark = "Additional 2.5% Trade Discount for MIRAGE month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }

                    if (trim($_GET["combo1"]) == "OTANI") {
                        $txt_remark = "Additional 3% Trade Discount for OTANI month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }


                    if (trim($_GET["combo1"]) == "GREENTOUR") {
                        $txt_remark = "Additional 5%/2.5% Trade Discount for GREENTOUR month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/G/" . trim($row_tmp['code1']);
                    }

                    if (trim($_GET["combo1"]) == "PRESA") {
                        $txt_remark = "Additional  Trade Discount for PRESA month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
                    if (trim($_GET["combo1"]) == "ROADSTONE") {
                        $txt_remark = "Additional Trade Discounts for Roadstone month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
                    if (trim($_GET["combo1"]) == "ZEETEX") {
                        $txt_remark = "Additional Trade Discounts for ZEETEX month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
//

                    $sql145 = "select * from s_salma where REF_NO='" . $txt_invno . "'";

                    $result145 = mysqli_query($GLOBALS['dbinv'], $sql145);
                    if ($row145 = mysqli_fetch_array($result145)) {
                        $mvatrate = $row145["GST"];
                    } else {
                        $mvatrate = $row_invpara["vatrate"];
                    }

                    if ($X == 1) {

                        $sql_cbal = "insert into c_bal (c_code1,REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate,sdate1) values('" . trim($row_tmp['code1']) . "','" . trim($txtrefno) . "', '" . date("Y-m-d") . "', 'CNT', '" . trim($txt_cuscode) . "', " . $txtamount . ", " . $txtamount . ", '" . trim($_GET["combo1"]) . "', '" . $m_dep . "', '" . $m_rep . "', '0', '" . $mvatrate . "','" . date("Y-m-d") . "')";
                        echo $sql_cbal;
                        $result_cbal = mysqli_query($GLOBALS['dbinv'], $sql_cbal);
                    }

                    if ($X == 2) {
                        $sql_cbal = "insert into c_bal (c_code1,REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate,sdate1) values('" . trim($row_tmp['code1']) . "','" . trim($txtrefno) . "', '" . date("Y-m-d") . "', 'CNT', '" . trim($txt_cuscode) . "', " . $txtamount . ", " . $txtamount . ", 'ROADSTONE CHINA', '" . $m_dep . "', '" . $m_rep . "', '0', '" . $mvatrate . "','" . date("Y-m-d") . "')";
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



                if (trim($_GET["combo1"]) == "WILLFLY") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancel_m='0' order by id";

                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/W/" . trim($row_tmp['code1']);
                }



                if (trim($_GET["combo1"]) == "LINGLONG") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancel_m='0' order by id";


                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L/" . trim($row_tmp['code1']);
                }

                if (trim($_GET["combo1"]) == "SUNFUL") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancel_m='0' order by id";


                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/S/" . trim($row_tmp['code1']);
                }

                if (trim($_GET["combo1"]) == "MIRAGE") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancel_m='0' order by id";


                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/MI/" . trim($row_tmp['code1']);
                }

                if (trim($_GET["combo1"]) == "OTANI") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' order by id";

                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/C/" . trim($row_tmp['code1']);
                }


                if (trim($_GET["combo1"]) == "GREENTOUR") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and  cancel_m='0' order by id";

                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/G/" . trim($row_tmp['code1']);
                }

                if (trim($_GET["combo1"]) == "PRESA") {
                    $sql_RSINVO = "select REF_NO, SAL_EX, DEPARTMENT from viewinv where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and (SDATE)<='" . $_GET["dtto"] . "'  and cancel_m='0' order by id ";

                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/P/" . trim($row_tmp['code1']);
                }

                if (trim($_GET["combo1"]) == "ROADSTONE") {


                    $sql_RSINVO = "select REF_NO, SAL_EX, DEPARTMENT from viewinv where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . "  and cancel_m='0' order by id ";



                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R/" . trim($row_tmp['code1']);
                }
                if (trim($_GET["combo1"]) == "ZEETEX") {


                    $sql_RSINVO = "select REF_NO, SAL_EX, DEPARTMENT from viewinv where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . "  and cancel_m='0' order by id ";


                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/ZE/" . trim($row_tmp['code1']);
                }
                $txt_invno = $row_RSINVO["REF_NO"];
                $m_rep = $row_RSINVO["SAL_EX"];
                $m_dep = $row_RSINVO["DEPARTMENT"];



                if (trim($_GET["combo1"]) == "WILLFLY") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/W/" . trim($row_tmp['code1']);
                }

                if (trim($_GET["combo1"]) == "LINGLONG") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L/" . trim($row_tmp['code1']);
                }
                if (trim($_GET["combo1"]) == "SUNFUL") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L/" . trim($row_tmp['code1']);
                }
                if (trim($_GET["combo1"]) == "MIRAGE") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/MI/" . trim($row_tmp['code1']);
                }

                if (trim($_GET["combo1"]) == "OTANI") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/C/" . trim($row_tmp['code1']);
                }


                If (trim($_GET["combo1"]) == "GREENTOUR") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/G/" . trim($row_tmp['code1']);
                    $txt_remark = "Additional 5%/2.5% Trade Discount for GREENTOUR month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
                if (trim($_GET["combo1"]) == "PRESA") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/P/" . trim($row_tmp['code1']);
                }
                if (trim($_GET["combo1"]) == "ROADSTONE") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R/" . trim($row_tmp['code1']);
                }
                if (trim($_GET["combo1"]) == "ZEETEX") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/ZE/" . trim($row_tmp['code1']);
                }
                ///////////
                if (trim($_GET["combo1"]) == "WILLFLY") {
                    $txt_remark = "Additional 2.5% Trade Discount for WILLFLY - month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }

                if (trim($_GET["combo1"]) == "LINGLONG") {
                    $txt_remark = "Additional 2.5% Trade Discount for LING LONG month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
                if (trim($_GET["combo1"]) == "SUNFUL") {
                    $txt_remark = "Additional 2.5% Trade Discount for SUNFUL month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
                if (trim($_GET["combo1"]) == "MIRAGE") {
                    $txt_remark = "Additional 2.5% Trade Discount for MIRAGE month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }

                if (trim($_GET["combo1"]) == "OTANI") {
                    $txt_remark = "Additional 3% Trade Discount for OTANI month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }

                if (trim($_GET["combo1"]) == "PRESA") {
                    $txt_remark = "Additional Trade Discount for PRESA month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
                if (trim($_GET["combo1"]) == "ROADSTONE") {
                    $txt_remark = "Additional Trade Discounts for Roadstone month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
                $sql145 = "select * from s_salma where REF_NO='" . $txt_invno . "'";
                $result145 = mysqli_query($GLOBALS['dbinv'], $sql145);
                if ($row145 = mysqli_fetch_array($result145)) {
                    $mvatrate = $row145["GST"];
                } else {
                    $mvatrate = $row_invpara["vatrate"];
                }

                $sql_cbal = "insert into c_bal (c_code1,REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate,sdate1) values('" . trim($row_tmp['code1']) . "','" . trim($txtrefno) . "', '" . date("Y-m-d") . "', 'CNT', '" . trim($txt_cuscode) . "', " . $txtamount . ", " . $txtamount . ", '" . trim($_GET["combo1"]) . "', '" . $m_dep . "', '" . $m_rep . "', '0', '" . $mvatrate . "','" . date("Y-m-d") . "')";
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

if ($_GET["Command"] == "save_inv1111111") {

    $mvatrate = 15;

    $sql = "Select vatrate from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $mvatrate = $row['vatrate'];




    $sql_tmp = "select * from tmp_auto_credit_note";
    $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
    while ($row_tmp = mysqli_fetch_array($result_tmp)) {
//        echo 'sad'; 
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


                    if (trim($_GET["combo1"]) == "WILLFLY") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per != 40 and cancel_m='0' order by id";


                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/W/" . trim($row_tmp['code1']);
                    }


                    if (trim($_GET["combo1"]) == "LINGLONG") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = 35 and cancel_m='0' order by id";


                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L/" . trim($row_tmp['code1']);
                    }

                    if (trim($_GET["combo1"]) == "SUNFUL") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = 30 and cancel_m='0' order by id";


                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/S/" . trim($row_tmp['code1']);
                    }


                    if (trim($_GET["combo1"]) == "OTANI") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and DIS_per = 35 and cancel_m='0' order by id";

                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/C/" . trim($row_tmp['code1']);
                    }


                    if (trim($_GET["combo1"]) == "GREENTOUR") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancel_m='0' order by id";

                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/G/" . trim($row_tmp['code1']);
                    }


                    if (trim($_GET["combo1"]) == "PRESA") {
                        $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' order by id";
//echo  $sql_RSINVO.'tt';
                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/P/" . trim($row_tmp['code1']);
                    }

                    if (trim($_GET["combo1"]) == "ROADSTONE") {

                        if ($X == 1) {
                            $sql_RSINVO = "select REF_NO, SAL_EX, DEPARTMENT from viewinv where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . "  and cancel_m='0' order by id ";
                        }
                        if ($X == 2) {
                            $sql_RSINVO = "select REF_NO, SAL_EX, DEPARTMENT from viewinv where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='ROADSTONE CHINA' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . "  and cancel_m='0' order by id ";
                        }

                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R/" . trim($row_tmp['code1']);
                    }


                    $txt_invno = $row_RSINVO["REF_NO"];
                    $m_rep = $row_RSINVO["SAL_EX"];
                    $m_dep = $row_RSINVO["DEPARTMENT"];



                    if (trim($_GET["combo1"]) == "WILLFLY") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/W/" . trim($row_tmp['code1']);
                    }

                    if (trim($_GET["combo1"]) == "LINGLONG") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/L/" . trim($row_tmp['code1']);
                    }
                    if (trim($_GET["combo1"]) == "SUNFUL") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/S/" . trim($row_tmp['code1']);
                    }

                    if (trim($_GET["combo1"]) == "OTANI") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/C/" . trim($row_tmp['code1']);
                    }

                    if (trim($_GET["combo1"]) == "PRESA") {
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/P/" . trim($row_tmp['code1']);
                    }

                    if (trim($_GET["combo1"]) == "ROADSTONE") {
                        if ($X == 1) {
                            $$m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/R/" . trim($row_tmp['code1']);
                        }
                        if ($X == 2) {
                            $$m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/R-C/" . trim($row_tmp['code1']);
                        }
                    }

                    if (trim($_GET["combo1"]) == "WILLFLY") {
                        $txt_remark = "Additional 2.5% Trade Discount for WILLFLY - month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }


                    if (trim($_GET["combo1"]) == "LINGLONG") {
                        $txt_remark = "Additional 2.5% Trade Discount for LING LONG month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
                    if (trim($_GET["combo1"]) == "SUNFUL") {
                        $txt_remark = "Additional 2.5% Trade Discount for SUNFUL month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }

                    if (trim($_GET["combo1"]) == "OTANI") {
                        $txt_remark = "Additional 3% Trade Discount for OTANI month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }


                    if (trim($_GET["combo1"]) == "GREENTOUR") {
                        $txt_remark = "Additional 5%/2.5% Trade Discount for GREENTOUR month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                        $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) + "/G/" . trim($row_tmp['code1']);
                    }

                    if (trim($_GET["combo1"]) == "PRESA") {
                        $txt_remark = "Additional  Trade Discount for PRESA month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
                    if (trim($_GET["combo1"]) == "ROADSTONE") {
                        $txt_remark = "Additional Trade Discounts for Roadstone month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
                    if (trim($_GET["combo1"]) == "ZEETEX") {
                        $txt_remark = "Additional Trade Discounts for ZEETEX month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }
                    if (trim($_GET["combo1"]) == "MIRAGE") {
                        $txt_remark = "Additional Trade Discounts for MIRAGE month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                    }

                    if ($X == 1) {


                        $sql_cbal = "insert into c_bal (c_code1,REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate) values('" . trim($row_tmp['code1']) . "','" . trim($txtrefno) . "', '" . date("Y-m-d") . "', 'CNT', '" . trim($txt_cuscode) . "', " . $txtamount . ", " . $txtamount . ", '" . trim($_GET["combo1"]) . "', '" . $m_dep . "', '" . $m_rep . "', '0', '" . $mvatrate . "')";
                        echo $sql_cbal;
                        $result_cbal = mysqli_query($GLOBALS['dbinv'], $sql_cbal);
                    }

                    if ($X == 2) {
                        $sql_cbal = "insert into c_bal (c_code1,REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate) values('" . trim($row_tmp['code1']) . "','" . trim($txtrefno) . "', '" . date("Y-m-d") . "', 'CNT', '" . trim($txt_cuscode) . "', " . $txtamount . ", " . $txtamount . ", 'ROADSTONE CHINA', '" . $m_dep . "', '" . $m_rep . "', '0', '" . $mvatrate . "')";
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



                if (trim($_GET["combo1"]) == "WILLFLY") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancel_m='0' order by id";

                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/W/" . trim($row_tmp['code1']);
                }



                if (trim($_GET["combo1"]) == "LINGLONG") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancel_m='0' order by id";


                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L/" . trim($row_tmp['code1']);
                }

                if (trim($_GET["combo1"]) == "SUNFUL") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancel_m='0' order by id";


                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/S/" . trim($row_tmp['code1']);
                }


                if (trim($_GET["combo1"]) == "OTANI") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and cancel_m='0' order by id";

                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/C/" . trim($row_tmp['code1']);
                }


                if (trim($_GET["combo1"]) == "GREENTOUR") {
                    $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv   where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "' and  cancel_m='0' order by id";

                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/G/" . trim($row_tmp['code1']);
                }

                if (trim($_GET["combo1"]) == "PRESA") {
                    $sql_RSINVO = "select REF_NO, SAL_EX, DEPARTMENT from viewinv where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and (SDATE)<='" . $_GET["dtto"] . "'  and cancel_m='0' order by id ";

                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/P/" . trim($row_tmp['code1']);
                }

                if (trim($_GET["combo1"]) == "ROADSTONE") {


                    $sql_RSINVO = "select REF_NO, SAL_EX, DEPARTMENT from viewinv where c_code1 = '" . trim($row_tmp["code1"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and  month(SDATE)=" . date("m", strtotime($_GET["dte_dor"])) . " and year(SDATE)=" . date("Y", strtotime($_GET["dte_dor"])) . "  and cancel_m='0' order by id ";



                    $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                    $row_RSINVO = mysqli_fetch_array($result_RSINVO);

                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R/" . trim($row_tmp['code1']);
                }

                $txt_invno = $row_RSINVO["REF_NO"];
                $m_rep = $row_RSINVO["SAL_EX"];
                $m_dep = $row_RSINVO["DEPARTMENT"];



                if (trim($_GET["combo1"]) == "WILLFLY") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/W/" . trim($row_tmp['code1']);
                }

                if (trim($_GET["combo1"]) == "LINGLONG") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L/" . trim($row_tmp['code1']);
                }
                if (trim($_GET["combo1"]) == "SUNFUL") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/L/" . trim($row_tmp['code1']);
                }

                if (trim($_GET["combo1"]) == "OTANI") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/C/" . trim($row_tmp['code1']);
                }
                if (trim($_GET["combo1"]) == "ZEETEX") {
                    $$m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/ZE/" . trim($row_tmp['code1']);
                }
                if (trim($_GET["combo1"]) == "MIRAGE") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/MI/" . trim($row_tmp['code1']);
                }

                If (trim($_GET["combo1"]) == "GREENTOUR") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/G/" . trim($row_tmp['code1']);
                    $txt_remark = "Additional 5%/2.5% Trade Discount for GREENTOUR month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
                if (trim($_GET["combo1"]) == "PRESA") {
                    $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/P/" . trim($row_tmp['code1']);
                }
                if (trim($_GET["combo1"]) == "ROADSTONE") {
                    $$m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/R/" . trim($row_tmp['code1']);
                }
                ///////////
                if (trim($_GET["combo1"]) == "WILLFLY") {
                    $txt_remark = "Additional 2.5% Trade Discount for WILLFLY - month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }

                if (trim($_GET["combo1"]) == "LINGLONG") {
                    $txt_remark = "Additional 2.5% Trade Discount for LING LONG month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
                if (trim($_GET["combo1"]) == "SUNFUL") {
                    $txt_remark = "Additional 2.5% Trade Discount for SUNFUL month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }

                if (trim($_GET["combo1"]) == "OTANI") {
                    $txt_remark = "Additional 3% Trade Discount for OTANI month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }

                if (trim($_GET["combo1"]) == "PRESA") {
                    $txt_remark = "Additional Trade Discount for PRESA month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }
                if (trim($_GET["combo1"]) == "ROADSTONE") {
                    $txt_remark = "Additional Trade Discounts for Roadstone month of " . date("m/Y", strtotime($_GET["dte_dor"]));
                }

                $sql_cbal = "insert into c_bal (c_code1,REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate) values('" . trim($row_tmp['code1']) . "','" . trim($txtrefno) . "', '" . date("Y-m-d") . "', 'CNT', '" . trim($txt_cuscode) . "', " . $txtamount . ", " . $txtamount . ", '" . trim($_GET["combo1"]) . "', '" . $m_dep . "', '" . $m_rep . "', '0', '" . $mvatrate . "')";
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
?>

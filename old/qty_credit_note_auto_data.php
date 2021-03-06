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


    $Mon = date("m", strtotime(($_GET['dte_dor'])));
    $Yer = date("Y", strtotime(($_GET['dte_dor'])));
    $sql = "delete from tmp_auto_credit_note";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);


    $ResponseXML .= "<balance_table><![CDATA[<table width=\"735\" border=\"0\" class=\"form-matrix-table\">";
    $i = 1;

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

    if ($_GET["combo1"] == "LINGLONG") {

        $sql = "Select cus_code,sum(QTY) as qty from viewinv   where   s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancel_m='0' group by cus_code order by cus_code";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $ccode = "";

        while ($row = mysqli_fetch_array($result)) {

            $ccode = $row["cus_code"];
            $invqty = 0;
            $rtnqty = 0;
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
            $amount_40 = 0;
            $amount_43 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;

            $sql_40 = "SELECT GST, SUM(GRAND_TOT) AS TOT FROM S_SALMA WHERE C_CODE = '" . trim($row["cus_code"]) . "' and BRAND='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and CANCELL='0'   GROUP BY GST";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

            $sql_1_40 = "Select vatrate, sum(amount) as tot from View_cbal_cred where cuscode = '" . trim($row["cus_code"]) . "' and   brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and CANCELL='0' AND TRN_TYPE = 'CNT' AND FLAG1 <> '1'  GROUP BY VATRATE";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select vatrate, sum(amount) as tot from C_bal where cuscode = '" . trim($row["cus_code"]) . "' and  TRN_TYPE = 'GRN' and Brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and CANCELL='0'  GROUP BY VATRATE";
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
//
            $sql_inv = "Select sum(Qty)  as totQty from viewinv     where    Cus_CODE = '" . trim($ccode) . "' and s_Brand = '" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancel_m = '0'  and price <> 0 and  dis_per <> 100";
            $sql_grn = " Select sum(Qty) as totQty from viewcrntrn where    C_CODE = '" . trim($ccode) . "' and Brand = '" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancell = '0'    ";

            $res_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
            if ($row_inv = mysqli_fetch_array($res_inv)) {

                if (!is_null($row_inv['totQty'])) {
                    $invqty = $row_inv['totQty'];
                }
            }

            $res_grn = mysqli_query($GLOBALS['dbinv'], $sql_grn);
            if ($row_grn = mysqli_fetch_array($res_grn)) {
                if (!is_null($row_grn['totQty'])) {
                    $rtnqty = $row_grn['totQty'];
                }
            }
            $netqty = $invqty - $rtnqty;
            $cashbakamou = "";
            $invqty1 = 0;
            $rtnqty1 = 0;
            if ($netqty >= 30) {
                $sql_inv1 = "Select sum(Qty)  as totQty from viewinv     where    Cus_CODE = '" . trim($ccode) . "' and disitem='250pertyre' and s_Brand = '" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancel_m = '0'  and price <> 0 and  dis_per <> 100";

                $res_inv1 = mysqli_query($GLOBALS['dbinv'], $sql_inv1);
                if ($row_inv1 = mysqli_fetch_array($res_inv1)) {
                    if (!is_null($row_inv1['totQty'])) {
                        $invqty1 = $row_inv1['totQty'];
                    }
                }
                $sql_grn1 = " Select sum(Qty) as totQty from viewcrntrn where    C_CODE = '" . trim($ccode) . "' and disitem='250pertyre' and Brand = '" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancell = '0'    ";

                $res_grn1 = mysqli_query($GLOBALS['dbinv'], $sql_grn1);
                if ($row_grn1 = mysqli_fetch_array($res_grn1)) {
                    if (!is_null($row_grn1['totQty'])) {
                        $rtnqty1 = $row_grn1['totQty'];
                    }
                }
                $cashbakamou = ($invqty1 - $rtnqty1) * 250;
            } else {
                $cashbakamou = 0;
            }

            $mbrand = substr($_GET["combo1"], 0, 1);
            $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/" . $mbrand . "-Q";

            $sql_rsven = "Select NAME from vendor where CODE = '" . $row["cus_code"] . "'";
            $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
            if ($row_rsven = mysqli_fetch_array($result_rsven)) {
                $ResponseXML .= "<tr>
                                <td>" . $row["cus_code"] . "</td>
                                <td>" . $row_rsven['NAME'] . "</td>
                                <td>0</td>
                                <td>0</td>
                                <td>" . number_format(($amount_43 - $rtn_43), 2, ".", ",") . "</td>
                                <td>" . $netqty . "</td>";

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

                    $crnno = $row_rs1["C_REFNO"];
                    $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                    $amount = $row_rs1["C_PAYMENT"];
                    $amount_c = 0;
                    $status = "Lock";

                    $i = $i + 1;
                } else {
                    $ResponseXML .= "<td>Not Saved</td>
                                       <td></td>
                                       <td>" . number_format(($cashbakamou), 2, ".", ",") . "</td>
                                       <td></td>
                                       <td></td>
                                       <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                    $crnno = "Not Saved";
                    $txndate = "";
                    $amount = $cashbakamou;
                    $amount_c = 0;
                    $status = "";

                    $i = $i + 1;
                }

                $ResponseXML .= "</tr>";
            }
            if ($code != "") {
                $sql_tmp = "insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
            }
        }
    } else {

        $sql = "Select cus_code,sum(QTY) as qty from viewinv   where   s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancel_m='0' group by cus_code order by cus_code";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        while ($row = mysqli_fetch_array($result)) {

            $ccode = $row["cus_code"];
            $invqty = 0;
            $rtnqty = 0;
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
            $amount_40 = 0;
            $amount_43 = 0;
            $rtn_40 = 0;
            $rtn_43 = 0;

            $sql_40 = "SELECT GST, SUM(GRAND_TOT) AS TOT FROM S_SALMA WHERE C_CODE = '" . trim($row["cus_code"]) . "' and BRAND='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and CANCELL='0'   GROUP BY GST";
            $result_40 = mysqli_query($GLOBALS['dbinv'], $sql_40);

            $sql_1_40 = "Select vatrate, sum(amount) as tot from View_cbal_cred where cuscode = '" . trim($row["cus_code"]) . "' and   brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and CANCELL='0' AND TRN_TYPE = 'CNT' AND FLAG1 <> '1'  GROUP BY VATRATE";
            $result_1_40 = mysqli_query($GLOBALS['dbinv'], $sql_1_40);

            $sql_1_43 = "Select vatrate, sum(amount) as tot from C_bal where cuscode = '" . trim($row["cus_code"]) . "' and  TRN_TYPE = 'GRN' and Brand='" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and CANCELL='0'  GROUP BY VATRATE";
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


            if ($_GET["combo1"] == "ATLASBX") {
                $sql_inv = "Select sum(Qty) as totQty from viewinv where  Cus_CODE = '" . trim($ccode) . "' and s_Brand = '" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancel_m = '0' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0797' and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'L0531' AND stk_no <> 'T3520' AND stk_no <> 'T3522' and stk_no <> 'A0356' and price <> 0 and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003' and dis_per <> 100";
                $sql_grn = " Select sum(Qty) as totQty from viewcrntrn where  C_CODE = '" . trim($ccode) . "' and Brand = '" . trim($_GET["combo1"]) . "' and  SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancell = '0' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0797' and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'L0531' AND stk_no <> 'T3520' AND stk_no <> 'T3522' and stk_no <> 'A0356' ";

                $res_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
                if ($row_inv = mysqli_fetch_array($res_inv)) {
                    if (!is_null($row_inv['totQty'])) {
                        $invqty = $row_inv['totQty'];
                    }
                }

                $res_grn = mysqli_query($GLOBALS['dbinv'], $sql_grn);
                if ($row_grn = mysqli_fetch_array($res_grn)) {
                    if (!is_null($row_grn['totQty'])) {
                        $rtnqty = $row_grn['totQty'];
                    }
                }
                $netqty = $invqty - $rtnqty;

                $mdate = date("Y-m-t", strtotime($_GET['dte_dor']));
                $sql_p = "select * from qty_discount_auto where brand_name = '" . trim($_GET["combo1"]) . "' and sdate <='" . $mdate . "' and qty <='" . ($netqty) . "' order by per desc";
            }

            if ($_GET["combo1"] == "PRESA") {

                $mdate = date("Y-m-t", strtotime($_GET['dte_dor']));
                $sql_p = "select * from qty_discount_auto where brand_name = '" . trim($_GET["combo1"]) . "' and sdate <='" . $mdate . "' and qty <='" . ($amount_40 - $rtn_40) . "' order by per desc";
            }

            $res_inv = mysqli_query($GLOBALS['dbinv'], $sql_p);
            if ($row_inv = mysqli_fetch_array($res_inv)) {

                $ccode = $row["cus_code"];

                $mbrand = substr($_GET["combo1"], 0, 1);
                $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/" . $mbrand . "-Q";

                $sql_rsven = "Select NAME from vendor where CODE = '" . $row["cus_code"] . "'";
                $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
                if ($row_rsven = mysqli_fetch_array($result_rsven)) {
                    $ResponseXML .= "<tr>
                                <td>" . $row["cus_code"] . "</td>
                                <td>" . $row_rsven['NAME'] . "</td>
                                <td>0</td>
                                <td>0</td>
                                <td>" . number_format(($amount_43 - $rtn_43), 2, ".", ",") . "</td>
                                <td>" . $netqty . "</td>";

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

                        $crnno = $row_rs1["C_REFNO"];
                        $txndate = date("Y-m-d", strtotime($row_rs1["C_DATE"]));
                        $amount = $row_rs1["C_PAYMENT"];
                        $amount_c = 0;
                        $status = "Lock";

                        $i = $i + 1;
                    } else {
                        $ResponseXML .= "<td>Not Saved</td>
                                       <td></td>
                                       <td>" . number_format(((($amount_43 - $rtn_43) / 100) * $row_inv['per']), 2, ".", ",") . "</td>
                                       <td></td>
                                       <td></td>
                                       <td><input type=\"checkbox\" name=\"" . $chk . "\" id=\"" . $chk . "\" onclick=\"changechk('" . $i . "', '" . $code . "');\"  /></td>";

                        $crnno = "Not Saved";
                        $txndate = "";
                        $amount = ((($amount_43 - $rtn_43) / 100) * $row_inv['per']);
                        $amount_c = 0;
                        $status = "";

                        $i = $i + 1;
                    }

                    $ResponseXML .= "</tr>";
                }
                if ($code != "") {
                    $sql_tmp = "insert into tmp_auto_credit_note (code, name, amount1, qty1, amount2, qty2, crnno, txndate, amount, status, amount_c) values ('" . $code . "', '" . $name . "', " . $amount1 . ", " . $qty1 . ", " . $amount2 . ", " . $qty2 . ", '" . $crnno . "', '" . $txndate . "', " . $amount . ", '" . $status . "', " . $amount_c . ")";
                    $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
                }
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

    $mvatrate = 8;

    $sql = "Select vatrate from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $mvatrate = $row['vatrate'];




    $sql_tmp = "select * from tmp_auto_credit_note";
    $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
    while ($row_tmp = mysqli_fetch_array($result_tmp)) {
        if ($row_tmp["status"] == "Yes") {

            $sql = "Select CRN from invpara";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $row = mysqli_fetch_array($result);
            $tmpinvno = "00000000" . $row["CRN"];
            $lenth = strlen($tmpinvno);
            $txtrefno = trim("CRN/ ") . substr($tmpinvno, $lenth - 9);

            $txt_cuscode = $row_tmp["code"];

            $txtamount = $row_tmp["amount"];



            $sql_RSINVO = "Select REF_NO, SAL_EX, DEPARTMENT from viewinv  where cus_code = '" . trim($row_tmp["code"]) . "' and s_brand='" . trim($_GET["combo1"]) . "' and   SDATE>='" . $_GET["dtfrom"] . "' and SDATE<='" . $_GET["dtto"] . "'  and cancel_m='0' order by id";

            $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
            $row_RSINVO = mysqli_fetch_array($result_RSINVO);

            $mbrand = substr($_GET["combo1"], 0, 1);

            $m_flag = date("m/Y", strtotime($_GET["dte_dor"])) . "/" . $mbrand . "-Q";


            $txt_invno = $row_RSINVO["REF_NO"];
            $m_rep = $row_RSINVO["SAL_EX"];
            $m_dep = $row_RSINVO["DEPARTMENT"];


            $txt_remark = "Additional Trade Discount for " . $_GET["combo1"] . " month of " . date("m/Y", strtotime($_GET["dte_dor"]));

            $sql_cbal = "insert into c_bal (REFNO, SDATE, trn_type, CUSCODE,c_code1,AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate,sdate1,block) values('" . trim($txtrefno) . "', '" . date("Y-m-d") . "', 'CNT', '" . trim($txt_cuscode) . "','" . trim($txt_cuscode) . "', " . $txtamount . ", " . $txtamount . ", '" . trim($_GET["combo1"]) . "', '" . $m_dep . "', '" . $m_rep . "', '0', '" . $mvatrate . "','" . date("Y-m-d") . "','1')";
            echo $sql_cbal;
            $result_cbal = mysqli_query($GLOBALS['dbinv'], $sql_cbal);

            $sql_cred = "Insert into cred (C_REFNO, C_DATE, C_INVNO, C_CODE, C_PAYMENT, C_REMARK, C_SALEX, Brand, DEV, C_SETINV,sdate1) values ('" . trim($txtrefno) . "', '" . date("Y-m-d") . "', '" . trim($txt_invno) . "', '" . trim($txt_cuscode) . "', " . $txtamount . ", '" . trim($txt_remark) . "', '" . trim($m_rep) . "', '" . trim($_GET["combo1"]) . "', '0', '" . trim($m_flag) . "','" . date("Y-m-d") . "')";
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
?>

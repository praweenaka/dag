<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connectioni.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');
date_default_timezone_set('Asia/Colombo');

$MSHFlexGrid1 = array(array());
$MSHFlexGrid1_count = 0;
$gridchk = array(array());

if ($_GET["Command"] == "getdATA") {




    $j = 1;
    $mcmbrep = $_GET["cmbrep"];
    $Mon = date("m", strtotime($_GET["dtMonth"]));
    $Yer = date("Y", strtotime($_GET["dtMonth"]));

    if ($_SESSION ["dev"] == "0") {
        $sql_ven = "select sdate1,REF_NO,C_CODE,CUS_NAME,Brand,GRAND_TOT,TOTPAY,cre_pe from view_salma_vendor where SAL_EX='" . trim($mcmbrep) . "' and month(sdate1) = '" . $Mon . "' and year(sdate1) = '" . $Yer . "' and CANCELL = '0' and DEV='0' order by C_CODE";
    } else if ($_SESSION["dev"] == "1") {
        $sql_ven = "select sdate1,REF_NO,C_CODE,CUS_NAME,Brand,GRAND_TOT,TOTPAY,cre_pe from view_salma_vendor where SAL_EX='" . trim($mcmbrep) . "' and month(sdate1) = '" . $Mon . "' and year(sdate1) = '" . $Yer . "' and CANCELL = '0' order by C_CODE";
    } $result_ven = mysqli_query($GLOBALS['dbinv'], $sql_ven);
    while ($row_ven = mysqli_fetch_array($result_ven)) {
        $invNo = "";

        if ($_GET['radio'] == "All") {
            $invNo = $row_ven["REF_NO"];
        }

        if ($_GET['radio'] == "2") {
            $sql = "select * from s_sttr where st_invono= '" . $row_ven["REF_NO"] . "' ";
            $result_rsstn = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($rsstn = mysqli_fetch_array($result_rsstn)) {

                If ($rsstn['ST_FLAG'] == "UT") {
                    $apdays = 0;
                } else {
                    If (!is_null($rsstn['del_days'])) {
                        $apdays = $rsstn ['del_days'];
                    } else {
                        $apdays = $rsstn['ap_days'];
                    }
                }

                $sql = "select * from com_she where sal_ex='" . trim($mcmbrep) . "' and brand= '" . $row_ven["Brand"] . "' ";

                $result_rsstn1 = mysqli_query($GLOBALS['dbinv'], $sql);
                $rsstn1 = mysqli_fetch_array($result_rsstn1);

                $dayn1 = $rsstn1['Day1'];
                $dayn2 = $rsstn1['Day2'];

                $sql = "Select incdays from vendor where code = '" . $row_ven["C_CODE"] . "'";
                $result_rsstn2 = mysqli_query($GLOBALS['dbinv'], $sql);
                $rsstn2 = mysqli_fetch_array($result_rsstn2);

                If ($rsstn2['incdays'] > $dayn1) {
                    $dayn1 = $rsstn2['incdays'] + 1;
                    $dayn2 = $rsstn2['incdays'] + 1;
                } If ($row_ven['cre_pe'] > $dayn1) {
                    $dayn1 = $row_ven['cre_pe'] + 1;
                    $dayn2 = $row_ven['cre_pe'] + 1;
                }

                If ($apdays < $dayn2 And $apdays > $dayn1) {
                    $invNo = $rsstn["ST_INVONO"];
                }
            }
        }

        if ($_GET ['radio'] == "3") {
            $sql = "select * from s_sttr where st_invono= '" . $row_ven["REF_NO"] . "' ";
            $result_rsstn = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($rsstn = mysqli_fetch_array($result_rsstn)) {

                If ($rsstn['ST_FLAG'] == "UT") {
                    $apdays = 0;
                } else {
                    If (!is_null($rsstn['del_days'])) {
                        $apdays = $rsstn['del_days'];
                    } else {
                        $apdays = $rsstn['ap_days'];
                    }
                }

                $sql = "select * from com_she where sal_ex='" . trim($mcmbrep) . "' and brand= '" . $row_ven["Brand"] . "' ";
                $result_rsstn1 = mysqli_query($GLOBALS['dbinv'], $sql);
                $rsstn1 = mysqli_fetch_array($result_rsstn1);

                $dayn1 = $rsstn1['Day1'];
                $dayn2 = $rsstn1['Day2'];

                $sql = "Select incdays from vendor where code = '" . $row_ven["C_CODE"] . "'";
                $result_rsstn2 = mysqli_query($GLOBALS['dbinv'], $sql);
                $rsstn2 = mysqli_fetch_array($result_rsstn2);

                If ($rsstn2['incdays'] > $dayn1) {
                    $dayn1 = $rsstn2['incdays'] + 1;
                    $dayn2 = $rsstn2 ['incdays'] + 1;
                }

                If ($row_ven['cre_pe'] > $dayn1) {
                    $dayn1 = $row_ven['cre_pe'] + 1;
                    $dayn2 = $row_ven['cre_pe'] + 1;
                }

                If ($apdays >= $dayn2) {
                    $invNo = $rsstn["ST_INVONO"];
                }
            }
        }

        If ($invNo != "") {
            $gridinv[$j][0] = $row_ven["sdate1"];
            $gridinv[$j][1] = $row_ven["REF_NO"];
            $gridinv[$j][2] = $row_ven["C_CODE"] . "  " . $row_ven["CUS_NAME"];
            $gridinv[$j][3] = $row_ven["Brand"];
            $gridinv[$j][4] = $row_ven["GRAND_TOT"];
            $gridinv[$j][5] = $row_ven["TOTPAY"];

            $sql_venype = "Select * from view_inv_item where REF_NO = '" . $row_ven ["REF_NO"] . "' order by id";
            $result_venype = mysqli_query($GLOBALS['dbinv'], $sql_venype);
            $row_venype = mysqli_fetch_array($result_venype);

            if (trim($row_venype ["type"]) == "TBR") {
                $gridinv[$j][6] = "INV - TBR";
            } else {
                $gridinv [$j][6] = "INV";
            }

            $j = $j + 1;
        }
    }

    echo " <table class='mytb' >
    <tr>
    <td width=\"5%\" ><font color=\"#FFFFFF\">Date</font></td>
    <td width=\"10%\" ><font color=\"#FFFFFF\">Inv. NO</font></td>
    <td width=\"30%\" ><font color=\"#FFFFFF\">Customer</font></td>
    <td width=\"15%\" ><font color=\"#FFFFFF\">Brand</font></td>
    <td width=\"15%\" ><font color=\"#FFFFFF\">Inv. Amount</font></td>
    <td width=\"15%\" ><font color=\"#FFFFFF\">Paid Amount</font></td>
    <td width=\"10%\" ><font color=\"#FFFFFF\"></font></td>
    </tr>";

    $count = $j;
    $j = 1;

    while ($count >= $j) {
        echo "<tr>
        <td onclick=\"getsett('" . $gridinv[$j][1] . "', '" . $gridinv[$j][3] . "');\">" . $gridinv[$j][0] . "</td>
        <td onclick=\"getsett('" . $gridinv[$j][1] . "', '" . $gridinv[$j][3] . "');\">" . $gridinv[$j][1] . "</td>
        <td onclick=\"getsett('" . $gridinv[$j][1] . "', '" . $gridinv[$j][3] . "');\">" . $gridinv[$j][2] . "</td>
        <td onclick=\"getsett('" . $gridinv[$j][1] . "', '" . $gridinv[$j][3] . "');\">" . $gridinv[$j][3] . "</td>
        <td onclick=\"getsett('" . $gridinv[$j][1] . "', '" . $gridinv[$j][3] . "');\">" . $gridinv[$j][4] . "</td>
        <td onclick=\"getsett('" . $gridinv[$j][1] . "', '" . $gridinv[$j][3] . "');\">" . $gridinv[$j][5] . "</td>
        <td onclick=\"getsett('" . $gridinv[$j][1] . "', '" . $gridinv[$j][3] . "');\">" . $gridinv[$j][6] . "</td>
        </tr>";
        $j = $j + 1;
    }
    echo "</table>";
}

if ($_GET["Command"] == "getsett") {
    include ('connectioni.php' );

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<TypeGrid1><![CDATA[
    <table >
    <tr>
    <td width=\"5%\" ><font color=\"#FFFFFF\">ID</font></td>
    <td width=\"5%\" ><font color=\"#FFFFFF\">Date</font></td>
    <td width=\"10%\" ><font color=\"#FFFFFF\">Rec. NO</font></td>
    <td width=\"30%\" ><font color=\"#FFFFFF\">Ch.No</font></td>
    <td width=\"15%\" ><font color=\"#FFFFFF\">Paid</font></td>
    <td width=\"15%\" ><font color=\"#FFFFFF\">Days</font></td>
    <td width=\"15%\" ><font color=\"#FFFFFF\">Paid Amount</font></td>
    <td width=\"10%\" ><font color=\"#FFFFFF\">Commission</font></td>
    <td width=\"10%\" ><font color=\"#FFFFFF\">Comment</font></td>
    <td width=\"10%\" ><font color=\"#FFFFFF\">Last Update</font></td>
    </tr>";

    $MSHFlexGrid1[0][0] = "Days";
    $MSHFlexGrid1[0][1] = "Rate %";

    $lblBrand = trim($_GET["brand"]);

    if (trim($lblBrand) != "") {
        $sql_cat = "select * from com_she where sal_ex='" . trim($_GET["cmbrep"]) . "' and Brand='" . trim($lblBrand) . "'";
//echo $sql_cat;
        $result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
        $row_cat = mysqli_fetch_array($result_cat);

        $day1 = $row_cat["Day1"];
        $day2 = $row_cat["Day2"];
        if ($_GET["txtnet"] > $_GET["txtt2"]) {
            $cat1 = $row_cat["T3_cat1"];
            $cat2 = $row_cat["T3_cat2"];
            $cat3 = $row_cat ["T3_cat3"];
        } else if ($_GET["txtnet"] > $_GET["txtt1"]) {
            $cat1 = $row_cat["T2_Cat1"];
            $cat2 = $row_cat["T2_cat2"];
            $cat3 = $row_cat ["T2_Cat3"];
        } else {
            $cat1 = $row_cat["T1_Cat1"];
            $cat2 = $row_cat["T1_cat2"];
            $cat3 = $row_cat["T1_cat3"];
        }
    }

    $MSHFlexGrid1[1][1] = $cat1;
    $MSHFlexGrid1[2][1] = $cat2;
    $MSHFlexGrid1[3][1] = $cat3;
    $MSHFlexGrid1[1][0] = "Bel. " . $day1;
    $MSHFlexGrid1[2][0] = $day1 . " To " . $day2;
    $MSHFlexGrid1 [3][0] = "Ovr. " . $day2;

    $sql_commSta = "select * from s_salma where Accname != 'NON STOCK' and REF_NO='" . trim($_GET["invno"]) . "'";
    $result_commSta = mysqli_query($GLOBALS['dbinv'], $sql_commSta);
    if ($row_commSta = mysqli_fetch_array($result_commSta)) {
        if ($row_commSta["Comm"] == "Y") {
            //TypeGrid1.Enabled = False
        } else {
            //TypeGrid1.Enabled = True
        }
    }

    $i = 1;
    $sql_rst = "select * from s_sttr where ST_INVONO='" . trim($_GET["invno"]) . "'";
    $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
    while ($row_rst = mysqli_fetch_array($result_rst)) {
        if (is_null($row_rst["ST_DATE"]) == false) {
            $TypeGrid1 [$i][1] = $row_rst["ST_DATE"];
        }
        if (is_null($row_rst["ST_REFNO"]) == false) {
            $TypeGrid1 [$i][2] = $row_rst["ST_REFNO"];
        }
        if (is_null($row_rst ["ST_CHNO"]) == false) {
            $TypeGrid1[$i][3] = $row_rst["ST_CHNO"];
        }
        if (is_null($row_rst ["ST_PAID"]) == false) {
            $TypeGrid1 [$i][4] = $row_rst ["ST_PAID"];
        }
        if ($row_rst ["ST_FLAG"] == "UT") {
            $apdays = 0;
        } else {
            if (is_null($row_rst["del_days"]) == false) {
                $apdays = $row_rst["del_days"];
            } else {
                $apdays = 0;
            }
        }

        $TypeGrid1 [$i][5] = $apdays;
        //echo "cat2-".$cat2."/apdays-".$apdays."day2-".$day2."cat1-".$cat1;
        if ($cat2 > 0) {
            if ($apdays < $day2) {
                $TypeGrid1[$i] [6] = "Yes";
            } else {
                $TypeGrid1[$i][6] = "No";
            }
        } else if ($cat1 > 0) {
            if ($apdays < $day1) {
                $TypeGrid1 [$i][6] = "Yes";
            } else {
                $TypeGrid1[$i] [6] = "No";
            }
        }

        if (is_null($row_rst["ID"]) == false) {
            $TypeGrid1[$i][0] = $row_rst["ID"];
        }
        if (is_null($row_rst["ap_rem"]) == false) {
            $TypeGrid1[$i][7] = $row_rst["ap_rem"];
        }

        $id_name = "id_" . $i;
        $paid_name = "paid_" . $i;
        $day_name = "days_" . $i;
        $pay_name = "pay_" . $i;
        $ap_rem_name = "ap_rem_" . $i;

        $sql_sinvch = "Select * from s_invcheq where cheque_no = '" . $TypeGrid1[$i][3]  . "' and Sdate='".$TypeGrid1 [$i][1]."' and refno='".$TypeGrid1 [$i][2]."'";
        $result_sinvch = mysqli_query($GLOBALS['dbinv'], $sql_sinvch);
        $row_sinvch = mysqli_fetch_array($result_sinvch);

        $bgcolour = "";

        if ($row_sinvch['ex_date1'] != "") {
            $bgcolour = "yellow";
        }

        $ResponseXML .= "<tr style=\"background-color:$bgcolour \">
        <td width=\"5%\" ><div id=\"" . $id_name . "\">" . $TypeGrid1[$i] [0] . "</div></td>
        <td width=\"10%\" >" . $TypeGrid1 [$i][1] . "</td>
        <td width=\"30%\" >" . $TypeGrid1[$i][2] . "</td>
        <td width=\"15%\" >" . $TypeGrid1[$i][3] . "</td>
        <td width=\"15%\" ><div id=\"" . $paid_name . "\">" . $TypeGrid1 [$i][4] . "</div></td>
        <td width=\"15%\" ><input type=\"text\" name=\"" . $day_name . "\" id=\"" . $day_name . "\" value=\"" . $TypeGrid1[$i][5] . "\" onblur=\"setcell(" . $i . ", " . $day1 . ", " . $day2 . ");\"  /></td>
        <td width=\"10%\" ><div id=\"" . $pay_name . "\">" . $TypeGrid1 [$i] [6] . "</div></td>
        <td width=\"10%\" ></td>
        <td width=\"10%\" ><input type=\"text\" name=\"" . $ap_rem_name . "\" id=\"" . $ap_rem_name . "\" value=\"" . $TypeGrid1[$i][7] . "\" /></td>
        <td width=\"10%\" >" . $row_rst['userid'] . "</td>
        </tr>";

        $i = $i + 1;
    }
    $ResponseXML .= " </table >]]></TypeGrid1>";

    $ResponseXML .= "<mcount><![CDATA[" . $i . "]]></mcount>";
    $ResponseXML .= "<MSHFlexGrid1><![CDATA[<table >";
    $ResponseXML .= "<tr>
    <td width=\"10%\"><font color=\"#FFFFFF\">" . $MSHFlexGrid1[0][0] . "</font></td>
    <td width=\"20%\"><font color=\"#FFFFFF\">" . $MSHFlexGrid1[0][1] . "</font></td>
    </tr>";
    $i = 1;
    while ($i <= 3) {
        $ResponseXML .= "<tr>
        <td width=\"10%\">" . $MSHFlexGrid1[$i][0] . "</td>
        <td width=\"20%\">" . $MSHFlexGrid1[$i][1] . "</td>
        </tr>";
        $i = $i + 1;
    }

    $ResponseXML .= " </table >]]></MSHFlexGrid1>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "savegrn") {
    include('connectioni.php');

    $r = 1;
    while ($_GET["grngrid"] > $r) {

        $gtype = "gtype" . $r;
        $grnno = "grnno" . $r;
        $Commi = "Commi" . $r;
        $commman = "CommManu" . $r;

        if ($_GET[$Commi] == "") {
            $Commi_val = 0;
        } else {
            $Commi_val = $_GET [$Commi];
        }

        if ($_GET[$commman] == "") {
            $commman_val = 0;
        } else {
            $commman_val = $_GET[$commman];
        }

        if ($_GET[$gtype] == "GRN") {

            $sql_inv = "update s_crnma set DUMMY_VAL=" . $Commi_val . " ,DIS1=" . $commman_val . "  where  REF_NO='" . $_GET[$grnno] . "'";
            //echo $sql_inv;
            $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
        } else {

            $sql_inv = "update cred set dummy_val=" . $Commi_val . " ,SETTLED=" . $commman_val . "  where  C_REFNO='" . $_GET[$grnno] . "'";
            //echo $sql_inv;
            $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
        }

        $r = $r + 1;
    }

    echo "Updated";
}

if ($_GET["Command"] == "view_report") {
    $txtpr4 = $_GET ["txtpre"] . " %";
    $txtNoComCOm = $_GET["txtNoCom_COm"];

//$txtsale4= $_GET["nosale"];

    $year = substr($_GET["dtMonth"], 0, 4);
    $month = substr($_GET["dtMonth"], 5, 2);

    $rep = $_GET ["cmbrep"];

    //If DNUSER.CONUSER.State = 0 Then DNUSER.CONUSER.Open
    $sql = "delete from tmpcommition ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sql_inv = "select * from s_salma where Accname != 'NON STOCK' and SAL_EX='" . $rep . "' and month(sdate1)=" . $month . " AND YEAR(sdate1)=" . $year . " and CANCELL='0' and DEV='" . $_GET["cmbdev"] . "'";
    $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
    while ($row_inv = mysqli_fetch_array($result_inv)) {

        //===============================================Choose Commission Catogory=====================================
        $day1 = 0;
        $day2 = 0;
        $cat1 = 0;
        $cat2 = 0;
        $cat3 = 0;

        $sql_cat = "select * from com_she where sal_ex='" . trim($_GET["cmbrep"]) . "' and Brand='" . trim($row_inv["Brand"]) . "'";
        $result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
        $row_cat = mysqli_fetch_array($result_cat);
        $day1 = $row_cat["day1"];
        $day2 = $row_cat["day2"];
        if ($_GET["txtbalSAleTOT"] > $_GET["txtt2"]) {
            $cat1 = $row_cat["t3_cat1"];
            $cat2 = $row_cat ["t3_cat2"];
            $cat3 = $row_cat ["t3_cat3"];
            $tarcat = 3;
        } else if ($_GET["txtbalSAleTOT"] > $_GET["txtt1"]) {
            $cat1 = $row_cat["t2_cat1"];
            $cat2 = $row_cat["t2_cat2"];
            $cat3 = $row_cat["t2_cat3"];
            $tarcat = 2;
        } else {
            $cat1 = $row_cat["t1_cat1"];
            $cat2 = $row_cat["t1_cat2"];
            $cat3 = $row_cat["t1_cat3"];
            $tarcat = 1;
        }

        $sql_rsven = "Select incdays from vendor where CODE = '" . trim($row_inv["C_CODE"]) . "'";
        $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
        $row_rsven = mysqli_fetch_array($result_rsven);
        if ($row_rsven["incdays"] > $day1) {
            $day1 = $row_rsven["incdays"] + 1;
            $day2 = $row_rsven["incdays"] + 1;
        }

        if ($row_inv ["cre_pe"] > $day1) {
            $day1 = $row_inv["cre_pe"] + 1;
            $day2 = $row_inv["cre_pe"] + 1;
        }

        //=========================================================================

        $sql_sttr = "SELECT * FROM tmp_s_sttr WHERE ST_INVONO='" . $row_inv["REF_NO"] . "'";
        $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
        if ($row_sttr = mysqli_fetch_array($result_sttr)) {

            while ($row_sttr = mysqli_fetch_array($result_sttr)) {

                $sql_compr = "select * from brand_mas where barnd_name='" . trim($roq_inv ["Brand"]) . "'";
                $result_compr = mysqli_query($GLOBALS ['dbinv'], $sql_compr);
                $row_compr = mysqli_fetch_array($result_compr);

                $due = $row_inv ["GRAND_TOT"] - $row_inv["TOTPAY"];
                $pay_type = $row_sttr["ST_REFNO"] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $row_sttr["ST_CHNO"];

                $D_75 = 0;
                $D_76_90 = 0;
                $D_91 = 0;
                $commission = 0;

                if ($row_sttr ["ST_FLAG"] == "UT") {
                    $days = 0;
                    $apdays = 0;
                } else {
                    $apdays = $row_sttr["del_days"];
                    $diff = abs(strtotime($row_inv["sdate1"]) - strtotime($row_sttr["ST_CHDATE"]));
                    $days = floor($diff / (60 * 60 * 24));
                }

                if ($apdays < $day1) {
                    $D_75 = $row_sttr["ST_PAID"];
                    if ($row_inv["DEV"] == "1") {
                        $commission = $cat1 * $row_sttr["ST_PAID"] * 0.01;
                    }
                    if ($row_inv["DEV"] == "0") {
                        $commission = $cat1 * $row_sttr ["ST_PAID"] * 0.01 / (1 + ($_GET["txtvat"] / 100));
                    }
                }

                if (($apdays > $day1 - 1) and ($apdays < $day2 )) {
                    if ($cat2 > 0) {
                        $D_76_90 = $row_sttr["ST_PAID"];
                        if ($row_inv["DEV"] == "1") {
                            $commission = $cat2 * $row_sttr["ST_PAID"] * 0.01;
                        }
                        if ($row_inv["DEV"] == "0") {
                            $commission = $cat2 * $row_sttr["ST_PAID"] * 0.01 / (1 + ($_GET["txtvat"] / 100));
                        }
                    } else {
                        $D_91 = $row_sttr["ST_PAID"];
                        if ($row_inv["DEV"] == "1") {
                            $commission = $cat2 * $row_sttr ["ST_PAID"] * 0.01;
                        }
                        if ($row_inv["DEV"] == "0") {
                            $commission = $cat2 * $row_sttr ["ST_PAID"] * 0.01 / (1 + ($_GET["txtvat"] / 100));
                        }
                    }
                }

                if ($apdays > ($day2 - 1)) {
                    $D_91 = $row_sttr["ST_PAID"];
                    if ($row_inv["DEV"] == "1") {
                        $commission = $cat3 * $row_sttr["ST_PAID"] * 0.01;
                    }
                    if ($row_inv["DEV"] == "0") {
                        $commission = $cat3 * $row_sttr ["ST_PAID"] * 0.01 / (1 + ($_GET ["txtvat"] / 100));
                    }
                }

                $sql = "insert into tmpcommition(SDATE, REFNO, COS_CODE, cus_name, AMOUNT, DUE, pay_type, PAY_DATE, PAY_AMOUNT, brand, dev, DATES, apdays, D_75, D_76_90, D_91, commission)  values ('" . $row_inv["sdate1"] . "', '" . $row_inv["REF_NO"] . "', '" . $row_inv["C_CODE"] . "', '" . $row_inv ["CUS_NAME"] . "', " . $row_inv["GRAND_TOT"] . ", " . $due . ", '" . $pay_type . "', '" . $row_sttr["ST_DATE"] . "', " . $row_sttr["ST_PAID"] . ", '" . $row_inv["Brand"] . "', '" . $row_inv["dev"] . "', " . $days . ", " . $apdays . ", " . $D_75 . ", " . $D_76_90 . ", " . $D_91 . ", " . $commission . ")";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
            }
        } else {

            $due = $row_inv ["GRAND_TOT"] - $row_inv["TOTPAY"];
            $sql = "insert into tmpcommition(SDATE, REFNO, COS_CODE, cus_name, AMOUNT, DUE, brand, dev, PAY_AMOUNT)  values ('" . $row_inv["sdate1"] . "', '" . $row_inv["REF_NO"] . "', '" . $row_inv["C_CODE"] . "', '" . $row_inv["CUS_NAME"] . "', " . $row_inv["GRAND_TOT"] . ", " . $due . ", '" . $row_inv["Brand"] . "', '" . $row_inv["dev"] . "', 0)";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
        }

        $totamount = $totamount + $row_inv["GRAND_TOT"];
        $totdue = $totdue + $row_inv["GRAND_TOT"] - $row_inv["TOTPAY"];
    }

    if ($_GET["cmbdev"] == "0") {

        $sql_CRN = "select * from cred where year(sdate1) =" . $year . " and  month(sdate1) =" . $month . " and   C_SALEX='" . trim($_GET["cmbrep"]) . "'   and CANCELL='0'";
        $result_CRN = mysqli_query($GLOBALS ['dbinv'], $sql_CRN);
        while ($row_CRN = mysqli_fetch_array($result_CRN)) {

            $cat1 = 0;
            $sql_cat = "select * from com_she where sal_ex='" . trim($_GET ["cmbrep"]) . "' and Brand='" . trim($row_CRN ["Brand"]) . "'";
            $result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
            if ($row_cat = mysqli_fetch_array($result_cat)) {

                if ($tarcat == 1) {
                    $cat1 = $row_cat["t1_cat1"];
                }
                if ($tarcat == 2) {
                    $cat1 = $row_cat["t2_cat1"];
                }
                if ($tarcat == 3) {
                    $cat1 = $row_cat["t3_cat1"];
                }
            }

            $sql_rst = "select NAME from vendor where CODE ='" . $row_CRN["C_CODE"] . "'";
            $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
            if ($row_rst = mysqli_fetch_array($result_rst)) {
                $cus_name = $row_rst["NAME"];
            }

            $sql_invdiv = "select *  from s_salma where Accname <> 'NON STOCK' and REF_NO='" . $row_CRN["C_INVNO"] . "'";
            $result_invdiv = mysqli_query($GLOBALS['dbinv'], $sql_invdiv);

            $sql_compr = "select * from brand_mas where barnd_name='" . trim($row_CRN["Brand"]) . "'";
            $result_compr = mysqli_query($GLOBALS['dbinv'], $sql_compr);

            if (($row_invdiv = mysqli_fetch_array($result_invdiv)) and ($row_compr = mysqli_fetch_array($result_compr))) {
                $dev = $row_invdiv["DEV"];
            } else if ($row_compr = mysqli_fetch_array($result_compr)) {
                $dev = "0";
            }

            $commission = $row_CRN["dummy_val"] + $row_CRN["SETTLED"];

            $sql = "insert into tmpcommition(SDATE, REFNO, COS_CODE, cus_name, return, AMOUNT, dev, commission, brand)  values ('" . $row_CRN["sdate1"] . "', '" . $row_CRN["C_REFNO"] . "', '" . $row_CRN["C_CODE"] . "', '" . $cus_name . "', " . $row_CRN["C_PAYMENT"] . ", " . (-1 * $row_CRN["C_PAYMENT"]) . ", '" . $dev . "', " . $commission . ", '" . $row_CRN["Brand"] . "')";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);

            $totreturn = $totreturn + $row_CRN["C_PAYMENT"];
        } $sql_grn = "select * from view_crnma where month(SDATE) =" . $month . " and   year(SDATE) =" . $year . " and SAL_EX='" . trim($_GET["cmbrep"]) . "' and CANCELL='0' and trn_type2='GRN'";
        $result_grn = mysqli_query($GLOBALS['dbinv'], $sql_grn);
        while ($row_grn = mysqli_fetch_array($result_grn)) {

            $cat1 = 0;
            $sql_cat = "select * from com_she where sal_ex='" . trim($_GET["cmbrep"]) . "' and Brand='" . trim($row_grn["Brand"]) . "'";
            $result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
            if ($row_cat = mysqli_fetch_array($result_cat)) {

                if ($tarcat == 1) {
                    $cat1 = $row_cat["t1_cat1"];
                }
                if ($tarcat == 2) {
                    $cat1 = $row_cat["t2_cat1"];
                }
                if ($tarcat == 3) {
                    $cat1 = $row_cat["t3_cat1"];
                }
            }

            $sql_invdiv = "select *  from s_salma where Accname <> 'NON STOCK' and REF_NO='" . $row_grn ["INVOICENO"] . "'";
            $result_invdiv = mysqli_query($GLOBALS['dbinv'], $sql_invdiv);

            $sql_compr = "select * from brand_mas where barnd_name='" . trim($row_grn ["Brand"]) . "'";
            $result_compr = mysqli_query($GLOBALS['dbinv'], $sql_compr);

            if (($row_invdiv = mysqli_fetch_array($result_invdiv)) and ($row_compr = mysqli_fetch_array($result_compr))) {
                $dev = $row_invdiv ["DEV"];
            } else if ($row_compr = mysqli_fetch_array($result_compr)) {
                $dev = "0";
            }

            $sql = "insert into tmpcommition(SDATE, REFNO, COS_CODE, cus_name, return, AMOUNT, dev, brand)  values ('" . $row_grn["SDATE"] . "', '" . $row_grn["REF_NO"] . "', '" . $row_grn ["C_CODE"] . "', '" . $row_grn["CUS_NAME"] . "', " . $row_grn["GRAND_TOT"] . ", " . (-1 * $row_grn["GRAND_TOT"] ) . ", '" . $dev . "', '" . $row_CRN ["Brand"] . "')";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);

            $totreturn = $totreturn + $row_grn["GRAND_TOT"];
        }
    }
//...........................................................................................................
//Call Print_Report(m_Report, 42)
    /*

      If m_update = flase Then Exit Sub
      msg = MsgBox("Do You Wish to save Commtion", vbYesNo, "Warning")
      If Not msg = vbYes Then Exit Sub
      '==================================check Permission===========================
      CURRENT_DOC = 42      'document ID
      'VIEW_DOC = True      '  view current document
      FEED_DOC = True      '   save  current document
      'MOD_DOC = True       '   delete   current document
      'PRINT_DOC = True     ' get additional print   of  current document
      'PRICE_EDIT=true      ' edit selling price
      CHECK_USER = True    ' check user permission again
      REFNO = REFNO = Trim(cmbrep) + Format(dtMonth, "MM/YYYY") + " Save"
      frmGetAuth.Show 1
      If Not AUTH_OK Then Exit Sub
      //=============================================================================

      Probar.Visible = True
      Dim rsTMPCOMMITION As New ADODB.Recordset
      rsTMPCOMMITION.Open "select * from tmpcommition where commission > 0 and  PAY_AMOUNT > 0 ", DNUSER.CONUSER
      Probar.Max = rsTMPCOMMITION.RecordCount
      Do While Not rsTMPCOMMITION.EOF
      dnINV.conINV.Execute "update s_salma set DUMMY_VAL=0  where ref_no='" . rsTMPCOMMITION!REFNO . "'"
      Probar.Value = rsTMPCOMMITION.AbsolutePosition
      rsTMPCOMMITION.MoveNext
      Loop
      Probar.Visible = False

      rsTMPCOMMITION.MoveFirst
      Do While Not rsTMPCOMMITION.EOF
      dnINV.conINV.Execute "update s_salma set DUMMY_VAL=DUMMY_VAL+" . rsTMPCOMMITION!commission + 1 . " where ref_no='" . rsTMPCOMMITION!REFNO . "'"
      Probar.Value = rsTMPCOMMITION.AbsolutePosition
      rsTMPCOMMITION.MoveNext
      Loop
      rsTMPCOMMITION.Close
      Probar.Visible = False */
  }

  if ($_GET["Command"] == "com_lock") {

    include("connectioni.php" );

    $year = substr($_GET ["dtMonth"], 0, 4);
    $month = substr($_GET["dtMonth"], 5, 2);

    if ($_GET ["lblComm"] == "Locked") {
        $sql = "update s_salma set Comm='Y' where SAL_EX='" . trim($_GET["cmbrep"]) . "' and month(sdate1)='" . $month . "' and year(sdate1)='" . $year . "'";

        $result = mysqli_query($GLOBALS ['dbinv'], $sql);
    }

    $txtComBal = str_replace(",", "", $_GET["txtComBal"]);
    $txtAdd = str_replace(",", "", $_GET["txtAdd"]);
    $txtdedamt1 = str_replace(",", "", $_GET["txtdedamt1"]);
    $txtdedamt2 = str_replace(",", "", $_GET["txtdedamt2"]);
    $txtdedamt3 = str_replace(",", "", $_GET["txtdedamt3"]);
    $txtdedamt4 = str_replace(",", "", $_GET["txtdedamt4"]);
    $txtdedamt5 = str_replace(",", "", $_GET["txtdedamt5"]);

    $txtBalsale = str_replace(",", "", $_GET["txtBalsale"]);
    $txtComGRN = str_replace(",", "", $_GET["txtComGRN"]);
    $txtNocomm = str_replace(",", "", $_GET ["txtNocomm"]);
    $txtcat2com = str_replace(",", "", $_GET["txtcat2com"]);
    $txtNoCom_COm = str_replace(",", "", $_GET["txtNoCom_COm"]);

    $txtcat1sale = str_replace(",", "", $_GET["txtcat1sale"]);
    $txtcat1Spsale = str_replace(",", "", $_GET["txtcat1Spsale"]);
    $txtcat2sale = str_replace(",", "", $_GET["txtcat2sale"]);
    $txtcat1Com = str_replace(",", "", $_GET["txtcat1Com"]);
    $txtcat1Spcomm = str_replace(",", "", $_GET["txtcat1Spcomm"]);
    $txtret = str_replace(",", "", $_GET ["txtret"]);

    $txtRetChkAmou_Do = str_replace(",", "", $_GET["txtRetChkAmou_Do"]);
    $txtRetChkAmou_D1 = str_replace(",", "", $_GET["txtRetChkAmou_D1"]);

    if ($txtRetChkAmou_Do == "") {
        $txtRetChkAmou_Do = 0;
    }

    if ($txtRetChkAmou_D1 == "") {
        $txtRetChkAmou_D1 = 0;
    }

    if ($txtret == "") {
        $txtret = 0;
    }

    if ($txtcat1sale == "") {
        $txtcat1sale = 0;
    }

    if ($txtcat1Spsale == "") {
        $txtcat1Spsale = 0;
    }

    if ($txtcat2sale == "") {
        $txtcat2sale = 0;
    }

    if ($txtcat1Com == "") {
        $txtcat1Com = 0;
    }

    if ($txtcat1Spcomm == "") {
        $txtcat1Spcomm = 0;
    }

    if ($txtComBal == "") {
        $txtComBal = 0;
    }

    if ($txtAdd == "") {
        $txtAdd = 0;
    }

    if ($txtdedamt1 == "") {
        $txtdedamt1 = 0;
    }

    if ($txtdedamt2 == "") {
        $txtdedamt2 = 0;
    }

    if ($txtdedamt3 == "") {
        $txtdedamt3 = 0;
    }

    if ($txtdedamt4 == "") {
        $txtdedamt4 = 0;
    }

    if ($txtdedamt5 == "") {
        $txtdedamt5 = 0;
    }

    if ($txtBalsale == "") {
        $txtBalsale = 0;
    } if ($txtComGRN == "") {
        $txtComGRN = 0;
    }
    if ($txtNocomm == "") {
        $txtNocomm = 0;
    }
    if ($txtcat2com == "") {
        $txtcat2com = 0;
    }
    if ($txtNoCom_COm == "") {
        $txtNoCom_COm = 0;
    }

    if (($txtComBal + $txtAdd) > 0) {

        $year = substr($_GET["dtMonth"], 0, 4);
        $month = substr($_GET["dtMonth"], 5, 2);

        $mrefno = $month . "/" . $year . "-" . substr($_GET["cmbrep"], 1, 2) . "-" . $_GET["cmbdev"];

        $sql_commadva = "select * from s_commadva where FLAG='BAL' AND refno='" . $mrefno . "'";
        $result_commadva = mysqli_query($GLOBALS['dbinv'], $sql_commadva);
        if ($row_commadva = mysqli_fetch_array($result_commadva)) {
            if ($row_commadva["Lock"] == 1) {
                exit("Sorry this month locked");
            }
        }

        $sql = "Delete from s_commadva where refno = '" . $mrefno . "' AND FLAG='BAL'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $ded = $txtdedamt1 + $txtdedamt2 + $txtdedamt3 + $txtdedamt4 + $txtdedamt5;
        $advance = $txtComBal + $txtAdd;
        $returnchk = $txtRetChkAmou_Do + $txtRetChkAmou_D1;

        $sql = "insert into s_commadva(refno, sale, ded, advance, rep, comdate, sdate, Dedcap1, Dedcap2, Dedcap3, Dedcap4, Dedcap5, Dedcap6, Dedcap7, Dedamount1, Dedamount2, Dedamount3, Dedamount4, Dedamount5, Dedamount6, Dedamount7, Over60out, Returnchk, Over60Ratio, Sale_tyre, Sale_battery, Sale_AW, Com_tyre, Com_battery, Com_AW, Com_tube, FLAG, Lock1, appby, appdate) values ('" . $mrefno . "', " . $txtBalsale . ", " . $ded . ", " . $advance . ", '" . $_GET["cmbrep"] . "', '" . $_GET["dtMonth"] . "', '" . date("Y-m-d") . "', '" . $_GET["txtdes1"] . "', '" . $_GET["txtdes2"] . "', '" . $_GET["txtdes3"] . "', '" . $_GET["txtdes4"] . "', '" . $_GET ["txtdes5"] . "', 'GRN', 'GRN Com', " . $txtdedamt1 . ", " . $txtdedamt2 . ", " . $txtdedamt3 . ", " . $txtdedamt4 . ", " . $txtdedamt5 . ", " . $txtret . ", " . $txtComGRN . ", " . $txtNocomm . ",  " . $returnchk . ", '" . $_GET["txtpre"] . "', " . $txtcat1sale . ", " . $txtcat1Spsale . ", " . $txtcat2sale . ", " . $txtcat1Com . ", " . $txtcat1Spcomm . ", " . $txtcat2com . ", " . $txtNoCom_COm . ", 'BAL', 1, '" . $_SESSION["CURRENT_USER"] . "', '" . date("Y-m-d") . "')";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        echo $sql;
        echo "Locked";
    }
}

if ($_GET["Command"] == "lock_advance") {

    $year = substr($_GET["dtMonth"], 0, 4);
    $month = substr($_GET["dtMonth"], 5, 2);

    $mrefno = $month . "/" . $year . "-" . substr($_GET["cmbrep"], 0, 2) . "-" . $_GET["cmbdev"];

    $sql_commadva = "select * from s_commadva where refno='" . $mrefno . "'";
    $result_commadva = mysqli_query($GLOBALS['dbinv'], $sql_commadva);
    if ($row_commadva = mysqli_fetch_array($result_commadva)) {
        $sql = "Update s_commadva set Lock1 ='1' where refno = '" . $mrefno . "' AND FLAG='ADV'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $sql = "Update s_commadva set Over60out = '" . $_GET["txtover60"] . "' where refno = '" . $mrefno . "' AND FLAG='ADV'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $sql = "Update s_commadva set Returnchk = '" . $_GET["txtretcheq"] . "' where refno = '" . $mrefno . "' AND FLAG='ADV'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $sql = "Update s_commadva set appby = '" . $_SESSION["CURRENT_USER"] . "' where refno = '" . $mrefno . "' AND FLAG='ADV'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $sql = "Update s_commadva set appdate = '" . date("Y-m-d") . "' where refno = '" . $mrefno . "' AND FLAG='ADV'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        echo "Records are Locked";
    } else {
        echo "No Records Found";
    }
}

if ($_GET["Command"] == "update") {
    include ('connectioni.php');

    $time_now = mktime(date('h') + 5, date('i') + 30, date('s'));

    $time = date('h:i:s', $time_now);
    $today = date('Y-m-d h:i:sa');

    $i = 1;
    while ($_GET["mcount"] > $i) {

        $id_name = "id_" . $i;
        $paid_name = "paid_" . $i;
        $day_name = "days_" . $i;
        $pay_name = "pay_" . $i;
        $ap_rem_name = "ap_rem_" . $i;


        if ($_GET[$paid_name] != "") {

//if (trim($_GET[$pay_name]) == "Yes") {
            if (is_numeric($_GET[$day_name]) == true) {
                $sql = "update s_sttr set ap_days =" . $_GET[$day_name] . ", del_days =" . $_GET[$day_name] . ", comm='" . trim($_GET[$pay_name]) . "', ap_rem='" . trim($_GET[$ap_rem_name]) . "',userid='" . $today . "-" . $_SESSION["CURRENT_USER"] . "' where ID=" . $_GET[$id_name];
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                echo $sql;
            }
        }

        $i = $i + 1;
    }
    
    
    $month = substr($_GET["dtMonth"], 0, 7);  
    $sql_utmas = "SELECT * FROM commisionremark WHERE month  ='" . $month . "' and rep='" . $_GET["cmbrep"] . "' and type='Bal'";
    
    $result_utmas = mysqli_query($GLOBALS['dbinv'], $sql_utmas);
    if ($row_utmas = mysqli_fetch_array($result_utmas)) {
        $sql1 = "update commisionremark set remark ='" . $_GET["TXTREMARK"] . "' where month  ='" . $month . "' and rep='" . $_GET["cmbrep"] . "' and type='Bal'";
        
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

        $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $month . '-' . $_GET["cmbrep"] . "', '" . $_SESSION["CURRENT_USER"] . "', 'commition remark', 'Update', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $resul2 = mysqli_query($GLOBALS['dbinv'], $sql2);
    } else {
        $sql_com = "insert into commisionremark(month, rep, remark, sdate, user,type) values ('" . $month . "', '" . $_GET["cmbrep"] . "', '" . $_GET["TXTREMARK"] . "', '" . date("Y-m-d H:i:s") . "', '" . $_SESSION["CURRENT_USER"] . "','Bal')";
        $result_com = mysqli_query($GLOBALS['dbinv'], $sql_com);

        $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $month . '-' . $_GET["cmbrep"] . "', '" . $_SESSION["CURRENT_USER"] . "', 'commition remark', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $resul2 = mysqli_query($GLOBALS['dbinv'], $sql2);
    }


    /* For i = 1 To TypeGrid1.Rows - 1
      If Trim(TypeGrid1.TextMatrix(i, 4)) <> "" Then
      If TypeGrid1.TextMatrix(TypeGrid1.Row, 6) = "Y" Then TypeGrid1.TextMatrix(TypeGrid1.Row, 6) = "Yes"
      If TypeGrid1.TextMatrix(TypeGrid1.Row, 6) = "y" Then TypeGrid1.TextMatrix(TypeGrid1.Row, 6) = "Yes"
      If TypeGrid1.TextMatrix(TypeGrid1.Row, 6) = "N" Then TypeGrid1.TextMatrix(TypeGrid1.Row, 6) = "No"
      If TypeGrid1.TextMatrix(TypeGrid1.Row, 6) = "n" Then TypeGrid1.TextMatrix(TypeGrid1.Row, 6) = "No"
      If Trim(TypeGrid1.TextMatrix(TypeGrid1.Row, 6)) = "Yes" Then
      DNinv.Coninv.Execute "update s_STTR set ap_days =" & Val(TypeGrid1.TextMatrix(i, 5)) & ",del_days =" & Val(TypeGrid1.TextMatrix(i, 5)) & ",comm='" & Trim(TypeGrid1.TextMatrix(i, 6)) & "',ap_rem='" & Trim(TypeGrid1.TextMatrix(i, 7)) & "' where id=" & Val(TypeGrid1.TextMatrix(i, 0)) & ""
      End If
      End If
      Next i */
  }

  if ($_GET["Command"] == "view_summery") {
    include ('connectioni.php');

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql_st = "delete from tmp_s_sttr ";
    $result_st = mysqli_query($GLOBALS['dbinv'], $sql_st);

    $TOTnOcOMMpAY = 0;
    $TOTcOMMpAY = 0;

    $sql_ret = "SELECT SUM(AMOUNT)AS RETAMU  FROM c_bal WHERE MONTH(sdate1)='" . date("m", strtotime($_GET["dtMonth"])) . "' AND YEAR(sdate1) ='" . date("Y", strtotime($_GET["dtMonth"])) . "' AND SAL_EX='" . trim($_GET["cmbrep"]) . "' AND CANCELL='0' and (trn_type='GRN' or  trn_type='CNT'  ) ";
    $result_ret = mysqli_query($GLOBALS['dbinv'], $sql_ret);
    if ($row_ret = mysqli_fetch_array($result_ret)) {
        if (is_null($row_ret["RETAMU"]) == false) {
            $totret = $row_ret ["RETAMU"];
        }
    }

    $sql_inv = "select SUM(GRAND_TOT) AS SALEAMU from s_salma where Accname != 'NON STOCK' and month(sdate1)='" . date("m", strtotime($_GET["dtMonth"])) . "' AND YEAR(sdate1)='" . date("Y", strtotime($_GET["dtMonth"])) . "' AND SAL_EX='" . trim($_GET["cmbrep"]) . "' AND CANCELL='0' ";
    $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
    if ($row_inv = mysqli_fetch_array($result_inv)) {
        if (is_null($row_inv["SALEAMU"]) == false) {
            $TOTSALE = $row_inv["SALEAMU"];
        }
    }

//==============find target=============================================
    $sql_TAR = "select * from sal_comm where sal_ex='" . trim($_GET["cmbrep"]) . "'";
    $result_TAR = mysqli_query($GLOBALS ['dbinv'], $sql_TAR);
    if ($row_TAR = mysqli_fetch_array($result_TAR)) {
        $txtt1 = $row_TAR["T1"];
        $txtt2 = $row_TAR["T2"];
    }

//========================================
    $netSale = ($TOTSALE - $totret) / 1.15;
    $txtnet = ($TOTSALE - $totret) / 1.15;

    $sql_inv = "select * from s_salma where Accname != 'NON STOCK' and month(sdate1)='" . date("m", strtotime($_GET["dtMonth"])) . "' AND YEAR(sdate1)='" . date("Y", strtotime($_GET["dtMonth"])) . "' AND SAL_EX='" . trim($_GET["cmbrep"]) . "' AND CANCELL='0' ";
    $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
    while ($row_inv = mysqli_fetch_array($result_inv)) {

//===============================================Choose Commission Catogory=====================================
        $day1 = 0;
        $day2 = 0;
        $cat1 = 0;
        $cat2 = 0;
        $cat3 = 0;

        $sql_cat = "select * from com_she where sal_ex='" . trim($_GET["cmbrep"]) . "' and Brand='" . trim($row_inv["Brand"]) . "'";
        $result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
        $row_cat = mysqli_fetch_array($result_cat);
        $day1 = $row_cat["day1"];
        $day2 = $row_cat["day2"];

        if ($netSale > $txtt2) {
            $cat1 = $row_cat["T3_cat1"];
            $cat2 = $row_cat ["T3_cat2"];
            $cat3 = $row_cat["T3_cat3"];
        } else if ($netSale > $txtt1) {
            $cat1 = $row_cat["T2_Cat1"];
            $cat2 = $row_cat["T2_cat2"];
            $cat3 = $row_cat["T2_Cat3"];
        } else {
            $cat1 = $row_cat["t1_cat1"];
            $cat2 = $row_cat["t1_cat2"];
            $cat3 = $row_cat["t1_cat3"];
        }

//=================================================================================================================================

        $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND del_days<" . $day1 . " and ST_FLAG!='UT'  ";
        echo $sql_sttr;
        $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
        if ($row_sttr = mysqli_fetch_array($result_sttr)) {
            if (is_null($row_sttr ["INVPAID"]) == false) {
                $tot_Comm_cat_1 = $tot_Comm_cat_1 + $row_sttr ["INVPAID"];
                if ($cat1 > 0) {
                    $TOTcOMMpAY = $TOTcOMMpAY + $row_sttr["INVPAID"];
                } else {
                    $TOTnOcOMMpAY = $TOTnOcOMMpAY + $row_sttr["INVPAID"];
                }
            }
        }

        $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND  ST_FLAG='UT' ";
        $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
        if ($row_sttr = mysqli_fetch_array($result_sttr)) {
            if (is_null($row_sttr["INVPAID"]) == false) {
                $tot_Comm_cat_1 = $tot_Comm_cat_1 + $row_sttr["INVPAID"];
                if ($cat1 > 0) {
                    $TOTcOMMpAY = $TOTcOMMpAY + $row_sttr["INVPAID"];
                } else {
                    $TOTnOcOMMpAY = $TOTnOcOMMpAY + $row_sttr["INVPAID"];
                }
            }
        }

        $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days> " . $day1 . " or del_days= " . $day1 . ") AND del_days<" . $day2 . " and ST_FLAG!='UT'";
        $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
        if ($row_sttr = mysqli_fetch_array($result_sttr)) {
            if (is_null($row_sttr["INVPAID"]) == false) {
                $tot_Comm_cat_2 = $tot_Comm_cat_2 + $row_sttr["INVPAID"];
                if ($cat2 > 0) {
                    $TOTcOMMpAY = $TOTcOMMpAY + $row_sttr ["INVPAID"];
                } else {
                    $TOTnOcOMMpAY = $TOTnOcOMMpAY + $row_sttr["INVPAID"];
                }
            }
        }

        $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND   (del_days>" . $day2 . " or del_days=" . $day2 . " ) and ST_FLAG!='UT'";
        $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
        if ($row_sttr = mysqli_fetch_array($result_sttr)) {
            if (is_null($row_sttr["INVPAID"]) == false) {
                $tot_Comm_cat_3 = $tot_Comm_cat_3 + $row_sttr["INVPAID"];
                if ($cat3 > 0) {
                    $TOTcOMMpAY = $TOTcOMMpAY + $row_sttr ["INVPAID"];
                } else {
                    $TOTnOcOMMpAY = $TOTnOcOMMpAY + $row_sttr["INVPAID"];
                }
            }
        }
    }

    $Frame1 = date("m", $_GET["dtMonth"]) . "/" . date("Y", $_GET["dtMonth"]) . " -  " . $_GET ["cmbrep"];
    $txtnetsale = $TOTSALE;
    $txtpaid = $TOTcOMMpAY + $TOTnOcOMMpAY;
    $txtout = $TOTSALE - $TOTcOMMpAY - $TOTnOcOMMpAY;
    $txtret = $totret;
    $txtNocomm = $TOTnOcOMMpAY;
    $txtpre = $TOTnOcOMMpAY / ($TOTcOMMpAY + $TOTnOcOMMpAY ) * 100 . " %";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}

if ($_GET ["Command"] == "eff_sale") {

    if ($txtpre <= 15) {

        if ($_GET["cmbdev"] == "1") {
            $txtBalsale = $txtnet;
        }
        if ($_GET["cmbdev"] == "0") {
            $txtBalsale = $txtnet;
        }
        if ($_GET["cmbdev"] == "All") {
            $txtBalsale = $txtnet;
        }
        $txtbalSAleTOT = $txtTotnet;
    } else {

        if ($_GET["cmbdev"] == "1") {
            $txtBalsale = $txtnet - $_GET["txtRetChkAmou_D1"] - $txtNocomm;
        }
        if ($_GET["cmbdev"] == "0") {
            $txtBalsale = $txtnet - $_GET ["txtRetChkAmou_Do"] - $txtNocomm;
        }
        if ($_GET["cmbdev"] == "All") {
            $txtBalsale = $txtnet - $_GET["txtRetChkAmou_D1"] - $_GET["txtRetChkAmou_Do"] - $txtNocomm;
        }

        $txtbalSAleTOT = $txtTotnet - $_GET["txtRetChkAmou_D1"] - $_GET["txtRetChkAmou_Do"] - $txtTOTNocom;
    }

    $ResponseXML .= "<txtBalsale><![CDATA[" . number_format($txtBalsale, 2, ".", ",") . "]]></txtBalsale>";
    $ResponseXML .= "<txtbalSAleTOT><![CDATA[" . number_format($txtbalSAleTOT, 2, ".", ",") . "]]></txtbalSAleTOT>";
}

if ($_GET["Command"] == "calculation") {

    include ('connectioni.php' );

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $year = substr($_GET["dtMonth"], 0, 4);
    $month = substr($_GET["dtMonth"], 5, 2);

    $sql_inv = "select * from s_salma where Accname != 'NON STOCK' and month(sdate1)='" . $month . "' AND YEAR(sdate1)='" . $year . "' AND SAL_EX='" . trim($_GET["cmbrep"]) . "' AND CANCELL='0' ";
//echo $sql_inv;
    $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);

    while ($row_inv = mysqli_fetch_array($result_inv)) {
//===============================================Choose Commission Catogory=====================================
        $day1 = 0;
        $day2 = 0;
        $cat1 = 0;
        $cat2 = 0;
        $cat3 = 0;

        $sql_cat = "select * from com_she where sal_ex='" . trim($_GET["cmbrep"]) . "' and Brand='" . trim($row_inv["Brand"]) . "' ";
        $result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
        $row_cat = mysqli_fetch_array($result_cat);

        $day1 = $row_cat["day1"];
        $day2 = $row_cat["day2"];

        if ($_GET["txtbalSAleTOT"] > $_GET["txtt2"]) {
            $cat1 = $row_cat["T3_cat1"];
            $cat2 = $row_cat ["T3_cat2"];
            $cat3 = $row_cat["T3_cat3"];
            $tarcat = 3;
        } else if ($_GET["txtbalSAleTOT"] > $_GET["txtt1"]) {
            $cat1 = $row_cat["T2_Cat1"];
            $cat2 = $row_cat ["T2_cat2"];
            $cat3 = $row_cat ["T2_Cat3"];
            $tarcat = 2;
        } else {
            $cat1 = $row_cat["T1_Cat1"];
            $cat2 = $row_cat["T1_cat2"];
            $cat3 = $row_cat["T1_cat3"];
            $tarcat = 1;
        }

        $sql_rsven = "Select incdays from vendor where CODE = '" . trim($row_inv["C_CODE"]) . "'";
        $result_rsven = mysqli_query($GLOBALS ['dbinv'], $sql_rsven);
        $row_rsven = mysqli_fetch_array($result_rsven);
        if ($row_rsven["incdays"] > $day1) {
            $day1 = $row_rsven ["incdays"] + 1;
            $day2 = $row_rsven["incdays"] + 1;
        }

        if ($row_inv["cre_pe"] > $day1) {
            $day1 = $row_inv["cre_pe"] + 1;
            $day2 = $row_inv ["cre_pe"] + 1;
        } if ($_GET["cmbdev"] == "All") {
            $dv = "A";
        }
        if ($_GET["cmbdev"] == "1") {
            $dv = "0";
        }
        if ($_GET["cmbdev"] == "0") {
            $dv = "1";
        }

        if ($row_inv["DEV"] != $dv) {
//=========================================================================
//echo "select * FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day1 . "   or ST_FLAG = 'UT') ";
            $sql_sttr = "select sum(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day1 . "   or ST_FLAG = 'UT') ";
//echo  $sql_sttr;
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                if (is_null($row_sttr["INVPAID"]) == false) {
                    if ($row_inv["DEV"] == "1") {
                        $ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat1 * 0.01;
                        $cat1Comm = cat1Comm + $row_sttr["INVPAID"] * $cat1 * 0.01;
                    } else {
                        $ComAmou = $ComAmou + $row_sttr ["INVPAID"] * $cat1 * 0.01 / (1 + ($_GET["txtvat"] / 100));
                        $cat1Comm = $cat1Comm + $row_sttr["INVPAID"] * $cat1 * 0.01 / (1 + ($_GET["txtvat"] / 100));
                    }
                }
            }
// echo $row_inv["REF_NO"].$cat1Comm
//=================================================================
//  echo  "SELECT * FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day1 . ") AND (del_days>60)  and ST_FLAG!='UT'";
            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day1 . ") AND (del_days>60)  and ST_FLAG!='UT'";

            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                if (is_null($row_sttr["INVPAID"]) == false) {
                    if ($row_inv["DEV"] == "1") {
                        $cat1SpComm = $cat1SpComm + $row_sttr["INVPAID"] * $cat1 * 0.01;
                    } else {
                        $cat1SpComm = $cat1SpComm + $row_sttr["INVPAID"] * $cat1 * 0.01 / (1 + ( $_GET ["txtvat"] / 100));
                    }
                }
            }

//=======================================================================
            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days> " . $day1 . " or del_days= " . $day1 . ")AND del_days<" . $day2 . "  and ST_FLAG!='UT' ";
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                if (is_null($row_sttr["INVPAID"]) == false) {
                    if ($row_inv["DEV"] == "1") {
                        $ComAmou = $ComAmou + $row_inv["INVPAID"] * $cat2 * 0.01;
                        $cat2Comm = $cat2Comm + $row_inv["INVPAID"] * $cat2 * 0.01;
                    } else {
                        $t = $t + $row_inv["INVPAID"];
                        $ComAmou = $ComAmou + $row_inv["INVPAID"] * $cat2 * 0.01 / (1 + ($_GET["txtvat"] / 100));
                        $cat2Comm = $cat2Comm + $row_inv["INVPAID"] * $cat2 * 0.01 / ( 1 + ($_GET["txtvat"] / 100));
                    }
                }
            }

            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND  ( del_days>" . $day2 . " or  del_days=" . $day2 . " ) and ST_FLAG!='UT'";
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                if (is_null($row_sttr["INVPAID"]) == false) {
                    if ($row_inv["DEV"] == "1") {
                        $ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat3 * 0.01;
                        if (($cat3 == 0) and ($_GET["txtpre"] <= 15 )) {
                            $cat2NoComm = $cat2NoComm + $row_sttr["INVPAID"] * $cat2 * 0.01;
                            $ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat2 * 0.01;

                            if ($m_update == true) {
                                $row_inv["DIS"] = $row_inv["DIS"] + $row_sttr["INVPAID"] * $cat2 * 0.01;
                            }
                        }
                    } else {
                        $ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat3 * 0.01 / (1 + ($_GET["txtvat"] / 100));
                        if (($cat3 == 0) and ($_GET ["txtpre"] <= 15 )) {
                            $cat2NoComm = $cat2NoComm + $row_sttr ["INVPAID"] * $cat2 * 0.01 / (1 + ($_GET ["txtvat"] / 100 ) );
                            $ComAmou = $ComAmou + $row_sttr ["INVPAID"] * $cat2 * 0.01 / ( 1 + ($_GET ["txtvat"] / 100) );
                            if ($m_update == true) {
                                $row_inv["DIS"] = $row_inv ["DIS"] + $row_inv ["INVPAID"] * $cat2 * 0.01 / (1 + ($_GET ["txtvat"] / 100 ) );
                            }
                        }
                    }
                }
            }
        }
    }

    $year = substr($_GET ["dtMonth"], 0, 4);
    $month = substr($_GET ["dtMonth"], 5, 2);

    $retcommamou = 0;

    if ($_GET["cmbdev"] != "1") {
        $retcommamou = 0;

        $sql_rsgen = "select * from s_crnma where CANCELL='0' and month(SDATE) =" . $month . " and   year(SDATE) =" . $year . " and SAL_EX='" . trim($_GET["cmbrep"]) . "'  ";
// echo $sql_rsgen;
        $result_rsgen = mysqli_query($GLOBALS['dbinv'], $sql_rsgen);
        while ($row_rsgen = mysqli_fetch_array($result_rsgen)) {

            $retcommamou = $retcommamou + $row_rsgen["DUMMY_VAL"] + $row_rsgen["DIS1"];
        }

        $row_rsgen = "select * from cred where CANCELL='0' and  month(sdate1) =" . $month . " and   year(sdate1) =" . $year . " and C_SALEX='" . trim($_GET["cmbrep"]) . "'  ";
// echo $row_rsgen;
        $result_rsgen = mysqli_query($GLOBALS ['dbinv'], $sql_rsgen);

        while ($row_rsgen = mysqli_fetch_array($result_rsgen)) {
            $sql_rsbal = "Select * from c_bal where REFNO = '" . $row_rsgen ["C_REFNO"] . " ' and flag1 != '1'";
            $result_rsbal = mysqli_query($GLOBALS ['dbinv'], $sql_rsbal);
            if ($row_rsbal = mysqli_fetch_array($result_rsbal)) {
                if (is_null($row_rsgen ["dummy_val"]) == false) {
                    $retcommamou = $retcommamou + $row_rsgen ["dummy_val"];
                }
                if (is_null($row_rsgen ["SETTLED"]) == false) {
                    $retcommamou = $retcommamou + $row_rsgen["SETTLED"];
                }
            }
        }
    }
//=============================================================================================================
    $txtComSale = $ComAmou;
    $txtComGRN = $retcommamou;
    $txtComBal = $ComAmou - $retcommamou - $txtretch;

    $txtcat1Com = $cat1Comm - $cat1SpComm;
    $txtcat1Spcomm = $cat1SpComm;
    $txtcat2com = $cat2Comm;
    $txtdedamt1 = $txtComBal * $_GET["txtpr"] * 0.01;
    $txtNoCom_COm = $cat2NoComm;

    $ResponseXML .= "<txtComSale><![CDATA[" . number_format($txtComSale, 2, ".", ",") . "]]></txtComSale>";
    $ResponseXML .= "<txtComGRN><![CDATA[" . number_format($txtComGRN, 2, ".", ",") . "]]></txtComGRN>";
    $ResponseXML .= "<txtComBal><![CDATA[" . number_format($txtComBal, 2, ".", ",") . "]]></txtComBal>";
    $ResponseXML .= "<txtcat1Com><![CDATA[" . number_format($txtcat1Com, 2, ".", ",") . "]]></txtcat1Com>";
    $ResponseXML .= "<txtcat1Spcomm><![CDATA[" . number_format($txtcat1Spcomm, 2, ".", ",") . "]]></txtcat1Spcomm>";
    $ResponseXML .= "<txtcat2com><![CDATA[" . number_format($txtcat2com, 2, ".", ",") . "]]></txtcat2com>";
    $ResponseXML .= "<txtdedamt1><![CDATA[" . number_format($txtdedamt1, 2, ".", ",") . "]]></txtdedamt1>";
    $ResponseXML .= "<txtNoCom_COm><![CDATA[" . number_format($txtNoCom_COm, 2, ".", ",") . "]]></txtNoCom_COm>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "save_advance") {
    $mtyre = 0;
    $mbattery = 0;
    $malloy = 0;
    $mtube = 0;
    $mtyre_com = 0;
    $mbattery_com = 0;
    $malloy_com = 0;
    $mtube_com = 0;
    $i = 1;

    while ($_GET["mgridcount"] > $i) {

        $msgrid1 = "msgrid1_" . $i;
        $msgrid2 = "msgrid2_" . $i;
        $msgrid3 = "msgrid3_" . $i;
        $msgrid4 = "msgrid4_" . $i;
        $msgrid5 = "msgrid5_" . $i;
        $msgrid6 = "msgrid6_" . $i;

        $sql_rsbrand = "Select * from brand_mas where barnd_name = '" . trim($_GET[$msgrid1]) . "' ";
//echo $sql_rsbrand;
        $result_rsbrand = mysqli_query($GLOBALS['dbinv'], $sql_rsbrand);
        if ($row_rsbrand = mysqli_fetch_array($result_rsbrand)) {

            if ($row_rsbrand ["class"] == "TYRE") {
                $mtyre = $mtyre + str_replace(",", "", $_GET[$msgrid5]);
            }
            if ($row_rsbrand["class"] == "BATTERY") {
                $mbattery = $mbattery + str_replace(",", "", $_GET[$msgrid5]);
            }
            if ($row_rsbrand ["class"] == "ALLOY WHEEL") {
                $malloy = $malloy + str_replace(",", "", $_GET[$msgrid5]);
            }
            if ($row_rsbrand ["class"] == "TUBE") {
                $mtube = $mtube + str_replace(",", "", $_GET[$msgrid5]);
            } if ($row_rsbrand ["class"] == "TYRE") {
                $mtyre_com = $mtyre_com + str_replace(",", "", $_GET[$msgrid6]);
            }
            if ($row_rsbrand["class"] == "BATTERY") {
                $mbattery_com = $mbattery_com + str_replace(",", "", $_GET[$msgrid6]);
            }
            if ($row_rsbrand["class"] == "ALLOY WHEEL") {
                $malloy_com = $malloy_com + str_replace(",", "", $_GET[$msgrid6]);
            }
            if ($row_rsbrand["class"] == "TUBE") {
                $mtube_com = $mtube_com + str_replace(",", "", $_GET[$msgrid6]);
            }
        }

        $i = $i + 1;
    }

    $year = substr($_GET["dtMonth"], 0, 4);
    $month = substr($_GET["dtMonth"], 5, 2);

    $txtded = str_replace(",", "", $_GET["txtded"]);
    $txtad = str_replace(",", "", $_GET["txtad"]);
    $TXTADJ = str_replace(",", "", $_GET["TXTADJ"]);
    $txtded1 = str_replace(",", "", $_GET["txtded1"]);
    $txtded2 = str_replace(",", "", $_GET["txtded2"]);
    $txtded3 = str_replace(",", "", $_GET["txtded3"]);
    $txtded4 = str_replace(",", "", $_GET["txtded4"]);
    $txtded5 = str_replace(",", "", $_GET["txtded5"]);
    $txtded6 = str_replace(",", "", $_GET["txtded6"]);
    $txtded7 = str_replace(",", "", $_GET["txtded7"]);
    $txtded8 = str_replace(",", "", $_GET["txtded8"]);

    $txtdedamou1 = str_replace(",", "", $_GET["txtdedamou1"]);
    $txtdedamou2 = str_replace(",", "", $_GET["txtdedamou2"]);
    $txtdedamou3 = str_replace(",", "", $_GET["txtdedamou3"]);
    $txtdedamou4 = str_replace(",", "", $_GET["txtdedamou4"]);
    $txtdedamou5 = str_replace(",", "", $_GET["txtdedamou5"]);
    $txtdedamou6 = str_replace(",", "", $_GET["txtdedamou6"]);
    $txtdedamou7 = str_replace(",", "", $_GET["txtdedamou7"]);
    $txtdedamou8 = str_replace(",", "", $_GET["txtdedamou8"]);

    $txtover60 = str_replace(",", "", $_GET ["txtover60"]);
    $txtretioded = str_replace(",", "", $_GET["txtretioded"]);

    $txtdedremark = str_replace(",", "", $_GET ["txtdedremark"]);
    $txtretcheq = str_replace(",", "", $_GET["txtretcheq"]);

    $mrefno = $month . "/" . $year . "-" . substr($_GET["cmbrep"], 0, 2) . "-" . $_GET["cmbdev"];

    $sql_rss_commadva = "select * from s_commadva where FLAG='ADV' AND refno='" . $mrefno . "' ";
    $result_rss_commadva = mysqli_query($GLOBALS ['dbinv'], $sql_rss_commadva);
    if ($row_rss_commadva = mysqli_fetch_array($result_rss_commadva)) {
        if ($row_rss_commadva["Lock1"] == 1) {
            exit("Sorry this month locked");
        }

        $sql = "Delete from s_commadva where refno = '" . $mrefno . "' AND FLAG='ADV'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $sale = $mtyre + $mbattery + $malloy + $mtube;

        $sql = "insert s_commadva (refno, sale, per, ded, remark, advance, rep, comdate, sdate, ADJ, Dedcap1, Dedcap2, Dedcap3, Dedcap4, Dedcap5, Dedcap6, Dedcap7, Dedcap8, Dedamount1, Dedamount2, Dedamount3, Dedamount4, Dedamount5, Dedamount6, Dedamount7, Dedamount8, Over60out, Returnchk, Over60Ratio, RatioDed, sale_tyre, Sale_battery, Sale_AW, Sale_Tube, Com_tyre, Com_battery, Com_AW, Com_tube, flag) values ('" . $mrefno . "', " . $sale . ", " . $_GET["txtper"] . ", " . $txtded . ", '" . $txtdedremark . "', " . $txtad . ", '" . $_GET["cmbrep"] . "', '" . $month . "', '" . date("Y-m-d") . "', " . $TXTADJ . ", '" . $txtded1 . "', '" . $txtded2 . "', '" . $txtded3 . "', '" . $txtded4 . "', '" . $txtded5 . "', '" . $txtded6 . "', '" . $txtded7 . "', '" . $txtded8 . "', " . $txtdedamou1 . ", " . $txtdedamou2 . ", " . $txtdedamou3 . ", " . $txtdedamou4 . ", " . $txtdedamou5 . ", " . $txtdedamou6 . ", " . $txtdedamou7 . ", " . $txtdedamou8 . ", " . $txtover60 . ", " . $txtretcheq . ", " . $_GET ["TXTRATO"] . ", " . $txtretioded . ", " . $mtyre . ", " . $mbattery . ", " . $malloy . ", " . $mtube . ", " . $mtyre_com . ", " . $mbattery_com . ", " . $malloy_com . ", " . $mtube_com . ", 'ADV' )";
        echo $sql;
        $result = mysqli_query($GLOBALS ['dbinv'], $sql);
    } else {

        $sale = $mtyre + $mbattery + $malloy + $mtube;

        $sql = "insert s_commadva (refno, sale, per, ded, remark, advance, rep, comdate, sdate, ADJ, Dedcap1, Dedcap2, Dedcap3, Dedcap4, Dedcap5, Dedcap6, Dedcap7, Dedcap8, Dedamount1, Dedamount2, Dedamount3, Dedamount4, Dedamount5, Dedamount6, Dedamount7, Dedamount8, Over60out, Returnchk, Over60Ratio, RatioDed, sale_tyre, Sale_battery, Sale_AW, Sale_Tube, Com_tyre, Com_battery, Com_AW, Com_tube, flag) values ('" . $mrefno . "', " . $sale . ", " . $_GET["txtper"] . ", " . $txtded . ", '" . $txtdedremark . "', " . $txtad . ", '" . $_GET["cmbrep"] . "', '" . $month . "', '" . date("Y-m-d") . "', " . $TXTADJ . ", '" . $txtded1 . "', '" . $txtded2 . "', '" . $txtded3 . "', '" . $txtded4 . "', '" . $txtded5 . "', '" . $txtded6 . "', '" . $txtded7 . "', '" . $txtded8 . "', " . $txtdedamou1 . ", " . $txtdedamou2 . ", " . $txtdedamou3 . ", " . $txtdedamou4 . ", " . $txtdedamou5 . ", " . $txtdedamou6 . ", " . $txtdedamou7 . ", " . $txtdedamou8 . ", " . $txtover60 . ", " . $txtretcheq . ", " . $_GET["TXTRATO"] . ", " . $txtretioded . ", " . $mtyre . ", " . $mbattery . ", " . $malloy . ", " . $mtube . ", " . $mtyre_com . ", " . $mbattery_com . ", " . $malloy_com . ", " . $mtube_com . ", '' )";
        echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
    }
}

if ($_GET["Command"] == "advance_proces") {

    $msgrid = array();

    $madjust = $_GET ["TXTADJ"];

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql_rs = "select * from sal_comm where sal_ex='" . trim($_GET["cmbrep"]) . "'";
//echo $sql_rs;
    $result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
    if ($row_rs = mysqli_fetch_array($result_rs)) {

        $txtt1 = $row_rs["T1"];
        $txtt2 = $row_rs["T2"];
    }

    $ResponseXML .= "<txtt1><![CDATA[" . number_format($txtt1, 2, ".", ",") . "]]></txtt1>";
    $ResponseXML .= "<txtt2><![CDATA[" . number_format($txtt2, 2, ".", ",") . "]]></txtt2>";
    $txtnett = 0;
    $txtsales = 0;
    $txtrtn = 0;
    $txtcrn = 0;
    $txtretcheq = 0;
    $txtover60 = 0;
    $TXTADJ = $madjust;

//.....................................................................................................................................
    $mrep = trim($_GET["cmbrep"]);

    $mdev = trim($_GET["cmbdev"]);

    $year = substr($_GET["dtMonth"], 0, 4);
    $month = substr($_GET["dtMonth"], 5, 2);

    $sql_rs = "Select  sum(GRAND_TOT) as sales from s_salma where Accname != 'NON STOCK' and  CANCELL='0' and SAL_EX='" . $mrep . "' and year(sdate1)='" . $year . "' and month(sdate1)='" . $month . "'   ";
    $result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
    if ($row_rs = mysqli_fetch_array($result_rs)) {
        if (is_null($row_rs["sales"]) == false) {
            $txtsales = $row_rs["sales"];
        }
    }

    $ResponseXML .= "<txtsales><![CDATA[" . number_format($txtsales, 2, ".", ",") . "]]></txtsales>";

    $sql_rs = "Select  sum(AMOUNT) as salesret from c_bal  where  CANCELL='0' and trn_type='CNT' and SAL_EX='" . $mrep . "' and year(sdate1)='" . $year . "' and month(sdate1)='" . $month . "' and flag1='0'   ";
    $result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
    if ($row_rs = mysqli_fetch_array($result_rs)) {
        if (is_null($row_rs["salesret"]) == false) {
            $txtcrn = $row_rs["salesret"];
        }
    }

    $ResponseXML .= "<txtcrn><![CDATA[" . number_format($txtcrn, 2, ".", ",") . "]]></txtcrn>";

    $sql_rs = "Select  sum(AMOUNT) as salesret from c_bal  where CANCELL='0' and trn_type='GRN' and SAL_EX='" . $mrep . "' and year(sdate1)='" . $year . "' and month(sdate1)='" . $month . "' and flag1='0'  ";
    $result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
    if ($row_rs = mysqli_fetch_array($result_rs)) {
        if (is_null($row_rs["salesret"]) == false) {
            $txtrtn = $row_rs["salesret"];
        }
    }
    $ResponseXML .= "<txtrtn><![CDATA[" . number_format($txtrtn, 2, ".", ",") . "]]></txtrtn>";

    $txtnett = ( $txtsales - ($txtcrn + $txtrtn)) / 1.12;
    $ResponseXML .= "<txtnett><![CDATA[" . number_format($txtnett, 2, ".", ",") . "]]></txtnett>";

    $mrefno = $month . "/" . $year . "-" . substr($_GET["cmbrep"], 0, 2) . "-" . $_GET ["cmbdev"];

    $sql_rs_old = "Select * from s_commadva where refno = '" . $mrefno . "' and FLAG='ADV'";

    $result_rs_old = mysqli_query($GLOBALS['dbinv'], $sql_rs_old);
    if ($row_rs_old = mysqli_fetch_array($result_rs_old)) {

        if (is_null($row_rs_old ["ADJ"]) == false) {
            $TXTADJ = $row_rs_old["ADJ"];
        }
        if (is_null($row_rs_old ["Dedcap1"]) == false) {
            $txtded1 = $row_rs_old ["Dedcap1"];
        }
        if (is_null($row_rs_old ["Dedcap2"] == false)) {
            $txtded2 = $row_rs_old["Dedcap2"];
        }
        if (is_null($row_rs_old ["Dedcap3"]) == false) {
            $txtded3 = $row_rs_old ["Dedcap3"];
        }
        if (is_null($row_rs_old["Dedcap4"]) == false) {
            $txtded4 = $row_rs_old["Dedcap4"];
        }
        if (is_null($row_rs_old["Dedcap5"]) == false) {
            $txtded5 = $row_rs_old["Dedcap5"];
        }
        if (is_null($row_rs_old["Dedcap6"] == false)) {
            $txtded6 = $row_rs_old["Dedcap6"];
        }
        if (is_null($row_rs_old["Dedcap7"]) == false) {
            $txtded7 = $row_rs_old["Dedcap7"];
        }
        if (is_null($row_rs_old["Dedcap8"]) == false) {
            $txtded8 = $row_rs_old["Dedcap8"];
        }
        if (is_null($row_rs_old["Dedamount1"]) == false) {
            $txtdedamou1 = $row_rs_old["Dedamount1"];
        }
        if (is_null($row_rs_old["Dedamount2"]) == false) {
            $txtdedamou2 = $row_rs_old["Dedamount2"];
        }
        if (is_null($row_rs_old ["Dedamount3"]) == false) {
            $txtdedamou3 = $row_rs_old["Dedamount3"];
        }
        if (is_null($row_rs_old["Dedamount4"]) == false) {
            $txtdedamou4 = $row_rs_old ["Dedamount4"];
        }
        if (is_null($row_rs_old["Dedamount5"]) == false) {
            $txtdedamou5 = $row_rs_old["Dedamount5"];
        }
        if (is_null($row_rs_old["Dedamount6"]) == false) {
            $txtdedamou6 = $row_rs_old["Dedamount6"];
        }
        if (is_null($row_rs_old["Dedamount7"]) == false) {
            $txtdedamou7 = $row_rs_old["Dedamount7"];
        }
        if (is_null($row_rs_old["Dedamount8"]) == false) {
            $txtdedamou8 = $row_rs_old["Dedamount8"];
        }
        if (is_null($row_rs_old ["remark"]) == false) {
            $txtdedremark = $row_rs_old["remark"];
        }
        if ($row_rs_old ["Lock1"] == 1) {
            if (is_null($row_rs_old["Returnchk"]) == false) {
                $txtretcheq = $row_rs_old["Returnchk"];
            }
            if (is_null($row_rs_old["Over60out"]) == false) {
                $txtover60 = $row_rs_old["Over60out"];
            }
        }
        if (is_null($row_rs_old["remark"]) == false) {
            $txtdedremark = trim($row_rs_old["remark"]);
        }
        if ($row_rs_old["chno"] > 0) {
            $txtdedremark = trim($txtdedremark) . "-" . trim($row_rs_old["chno"]) . "-" . trim($row_rs_old["Bank"]) . "-" . trim($row_rs_old ["PCHNO"]);
        }
    }

    $ResponseXML .= "<TXTADJ><![CDATA[" . $TXTADJ . "]]></TXTADJ>";
    $ResponseXML .= "<txtded1><![CDATA[" . $txtded1 . "]]></txtded1>";
    $ResponseXML .= "<txtded2><![CDATA[" . $txtded2 . "]]></txtded2>";
    $ResponseXML .= "<txtded3><![CDATA[" . $txtded3 . "]]></txtded3>";
    $ResponseXML .= "<txtded4><![CDATA[" . $txtded4 . "]]></txtded4>";
    $ResponseXML .= "<txtded5><![CDATA[" . $txtded5 . "]]></txtded5>";
    $ResponseXML .= "<txtded6><![CDATA[" . $txtded6 . "]]></txtded6>";
    $ResponseXML .= "<txtded7><![CDATA[" . $txtded7 . "]]></txtded7>";
    $ResponseXML .= "<txtded8><![CDATA[" . $txtded8 . "]]></txtded8>";
    $ResponseXML .= "<txtdedamou1><![CDATA[" . number_format($txtdedamou1, 2, ".", ",") . "]]></txtdedamou1>";
    $ResponseXML .= "<txtdedamou2><![CDATA[" . number_format($txtdedamou2, 2, ".", ",") . "]]></txtdedamou2>";
    $ResponseXML .= "<txtdedamou3><![CDATA[" . number_format($txtdedamou3, 2, ".", ",") . "]]></txtdedamou3>";
    $ResponseXML .= "<txtdedamou4><![CDATA[" . number_format($txtdedamou4, 2, ".", ",") . "]]></txtdedamou4>";
    $ResponseXML .= "<txtdedamou5><![CDATA[" . number_format($txtdedamou5, 2, ".", ",") . "]]></txtdedamou5>";
    $ResponseXML .= "<txtdedamou6><![CDATA[" . number_format($txtdedamou6, 2, ".", ",") . "]]></txtdedamou6>";
    $ResponseXML .= "<txtdedamou7><![CDATA[" . number_format($txtdedamou7, 2, ".", ",") . "]]></txtdedamou7>";
    $ResponseXML .= "<txtdedamou8><![CDATA[" . number_format($txtdedamou8, 2, ".", ",") . "]]></txtdedamou8>";

    $ResponseXML .= "<txtdedremark><![CDATA[" . number_format($txtdedremark, 2, ".", ",") . "]]></txtdedremark>";

    if ($txtretcheq <= 0) {
        $mretche = 0;

        $sql_rs_salm = "Select  sum(CR_CHEVAL-PAID) as retche  from  s_cheq  where S_REF='" . $mrep . "' and CR_FLAG = '0' ";
        $result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
        $row_rs_salm = mysqli_fetch_array($result_rs_salm);
        if (is_null($row_rs_salm["retche"]) == false) {
            $mretche = $row_rs_salm ["retche"];
            $txtretcheq = $txtretcheq + $row_rs_salm ["retche"];
        }
        $txtretcheq = $txtretcheq;
    }

    $ResponseXML .= "<txtretcheq><![CDATA[" . number_format($txtretcheq, 2, ".", ",") . "]]></txtretcheq>";

    if ($txtover60 <= 0) {
        $mout = 0;
        $sql_rs_salm = "Select  * from s_salma where Accname != 'NON STOCK' and  CANCELL='0' and  GRAND_TOT > TOTPAY and SAL_EX='" . $mrep . "'  ";
        $result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
        while ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {

            $date1 = date("Y-m-d");
            $date2 = $row_rs_salm["sdate1"];

            $diff = abs(strtotime($date2) - strtotime($date1));
            $days = floor($diff / (60 * 60 * 24));

            if ($days >= 61) {
                $mout = $mout + $row_rs_salm["GRAND_TOT"] - $row_rs_salm["TOTPAY"];

                $txtover60 = $mout;
            }
        }
    }

    $ResponseXML .= "<txtover60><![CDATA[" . number_format($txtover60, 2, ".", ",") . "]]></txtover60>";

    $netSale = $txtsales - $txtrtn - $txtcrn;

    if ($txtnett != "") {
        if ($txtnett != 0) {
            $TXTRATO = ($txtover60 + $TXTADJ + $txtretcheq ) / ($txtnett * 1.12) * 100;
        }
    }

    $netSale = (($txtsales - $txtrtn - $txtcrn ) / 112 ) * 100;

//msgrid.clear
//.....................................................................................................................................
    $ai = 1;
    $mcom = 0;

    $sql_rs_salm = "Select Brand , sum(GRAND_TOT) as sales from s_salma where Accname != 'NON STOCK' and CANCELL='0' and DEV='" . $mdev . "' and SAL_EX='" . $mrep . "' and year(sdate1)='" . $year . "' and month(sdate1)='" . $month . "'  group by Brand  ";
    $result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
    while ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {

        if ($mdev == "1") {
            $msale = $row_rs_salm["sales"];
        } else {
            $msale = ((($row_rs_salm["sales"] / 112) * 100));
        }

        $sql_rs_table = "SELECT *   from com_she where sal_ex='" . $mrep . "' and Brand='" . trim($row_rs_salm["Brand"]) . "'  ";
        $result_rs_table = mysqli_query($GLOBALS['dbinv'], $sql_rs_table);
        if ($row_rs_table = mysqli_fetch_array($result_rs_table)) {

            if ($TXTRATO <= 15) {
                if ($netSale >= $txtt2) {
                    $mcom = $mcom + $msale * $row_rs_table["T3_cat1"];
                }
                if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
                    $mcom = $mcom + $msale * $row_rs_table["T2_Cat1"];
                }
                if ($netSale < $txtt1) {
                    $mcom = $mcom + $msale * $row_rs_table["T1_Cat1"];
                }
            } else {
                if ($netSale >= $txtt2) {
                    $mcom = $mcom + $msale * $row_rs_table ["T3_cat2"];
                }
                if (( $netSale < $txtt2 ) and ($netSale >= $txtt1)) {
                    $mcom = $mcom + $msale * $row_rs_table["T2_cat2"];
                }
                if ($netSale < $txtt1) {
                    $mcom = $mcom + $msale * $row_rs_table ["T1_cat2"];
                }
            }
        } else {
            $mcom = $mcom + 0;
        }

        $msgrid [$ai] [1] = $row_rs_salm["Brand"];
        $msgrid [$ai][2] = $msale;
        $ai = $ai + 1;
    }

    $row_count = $ai;
//.... CNT ......................................................................................................................................

    $sql_rs_salm = "Select  brand, sum(AMOUNT) as salesret from c_bal  where CANCELL='0' and  trn_type='CNT' and SAL_EX='" . $mrep . "' and year(sdate1)='" . $year . "' and month(sdate1)='" . $month . "' and flag1='0' and DEV='" . $mdev . "' group by brand  ";

    $result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
    while ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {

        if ($mdev == "1") {
            $msale = $row_rs_salm["salesret"];
        } else {
            $msale = ((($row_rs_salm["salesret"] / 112) * 100));
        }

        $sql_rs_table = "SELECT *   from com_she where   sal_ex='" . $mrep . "' AND Brand='" . trim($row_rs_salm["brand"]) . "' ";
        $result_rs_table = mysqli_query($GLOBALS['dbinv'], $sql_rs_table);
        if ($row_rs_table = mysqli_fetch_array($result_rs_table)) {

            if ($TXTRATO <= 15) {
                if ($netSale >= $txtt2) {
                    $mcom = $mcom - $msale * $row_rs_table["T3_cat1"];
                }
                if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
                    $mcom = $mcom - $msale * $row_rs_table ["T2_Cat1"];
                }
                if ($netSale < $txtt1) {
                    $mcom = $mcom - $msale * $row_rs_table["T1_Cat1"];
                }
            } else {
                if ($netSale >= $txtt2) {
                    $mcom = $mcom - $msale * $row_rs_table["T3_cat2"];
                }
                if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
                    $mcom = $mcom - $msale * $row_rs_table["T2_cat2"];
                }
                if ($netSale < $txtt1) {
                    $mcom = $mcom - $msale * $row_rs_table["T1_cat2"];
                }
            }
        } else {
            $mcom = $mcom - $msale * 1.5;
        }

        $mstat = "NEW";
        $xx = 1;
        while ($xx < $row_count) {
            if (trim($msgrid[$xx][1]) == trim($row_rs_salm ["brand"])) {

                $msgrid[$xx][1] = $row_rs_salm["brand"];
                $msgrid [$xx][3] = $msale * -1;
                $xx = $row_count;
                $mstat = "OLD";
            }
            $xx = $xx + 1;
        }
        if ($mstat == "NEW") {

            $msgrid[$ai][1] = $row_rs_salm["brand"];
            $msgrid[$ai][3] = $msale * -1;
        }
        $ai = $ai + 1;
    }
//.... GRN ......................................................................................................................................

    $sql_rs_salm = "Select  brand, sum(AMOUNT) as salesret from c_bal  where DEV='" . $mdev . "' and trn_type='GRN' and SAL_EX='" . $mrep . "' and year(sdate1)='" . $year . "' and month(sdate1)='" . $month . "'  group by brand  ";
    $result_rs_salm = mysqli_query($GLOBALS ['dbinv'], $sql_rs_salm);
    while ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {

        if ($mdev == "1") {
            $msale = $row_rs_salm["salesret"];
        } else {
            $msale = ((($row_rs_salm["salesret"] / 112) * 100));
        }

        $sql_rs_table = "SELECT *   from com_she where sal_ex='" . $mrep . "' AND Brand='" . trim($row_rs_salm["brand"]) . "' ";
        $result_rs_table = mysqli_query($GLOBALS['dbinv'], $sql_rs_table);
        if ($row_rs_table = mysqli_fetch_array($result_rs_table)) {

            if ($TXTRATO <= 15) {
                if ($netSale >= $txtt2) {
                    $mcom = $mcom - $msale * $row_rs_table ["T3_cat1"];
                }
                if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
                    $mcom = $mcom - $msale * $row_rs_table["T2_Cat1"];
                }
                if ($netSale < $txtt1) {
                    $mcom = $mcom - $msale * $row_rs_table ["T1_Cat1"];
                }
            } else {
                if ($netSale >= $txtt2) {
                    $mcom = $mcom - $msale * $row_rs_table["T3_cat2"];
                }
                if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
                    $mcom = $mcom - $msale * $row_rs_table["T2_cat2"];
                }
                if ($netSale < $txtt1) {
                    $mcom = $mcom - $msale * $row_rs_table["T1_cat2"];
                }
            }
        } else {
            $mcom = $mcom - $msale * 1.5;
        }

        $mstat = "NEW";
        $xx = 1;
        while ($xx < $row_count) {
            if (trim($msgrid[$xx][1]) == trim($row_rs_salm["brand"])) {
                $msgrid[$xx][1] = $row_rs_salm["brand"];
                $msgrid[$xx] [4] = $msale * -1;
                $xx = $row_count;
                $mstat = "OLD";
            }
            $xx = $xx + 1;
        }
        if ($mstat == "NEW") {

            $msgrid[$ai][1] = $row_rs_salm["brand"];
            $msgrid[$ai][4] = $msale * - 1;
        }
        $ai = $ai + 1;
    }
    $TXTCOM = $mcom;

    $Txtadva = 0;
    $mtotcom = 0;
    $mtotded = 0;
    $mded = 0;
    $mretioded = 0;
    $mroundadvance = 0;
    $mdecimal = 0;

    $ai = 1;
    while ($ai < $row_count) {

        $sql_rs_table = "SELECT *   from com_she where   sal_ex='" . $mrep . "' AND Brand='" . trim($msgrid[$ai][1]) . "' ";

        $msale = $msgrid [$ai][2] + $msgrid[$ai] [3] + $msgrid[$ai][4];
        $msgrid [$ai][5] = $msale;

        $result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
        if ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {
            if ($TXTRATO <= 15) {
                if ($netSale >= $txtt2) {
                    $mcom = $msale * $row_rs_table ["T3_cat1"];
                    $txtper = $row_rs_table ["T3_cat1"];
                }
                if (($netSale < $txtt2 ) and ($netSale >= $txtt1)) {
                    $mcom = $msale * $row_rs_table["T2_Cat1"];
                    $txtper = $row_rs_table["T2_Cat1"];
                }
                if ($netSale < $txtt1) {
                    $mcom = $msale * $row_rs_table["T1_Cat1"];
                    $txtper = $row_rs_table ["T1_Cat1"];
                }
            } else {
                if ($netSale >= $txtt2) {
                    $mcom = $msale * $row_rs_table["T3_cat2"];
                    $txtper = $row_rs_table["T3_cat2"];
                }
                if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
                    $mcom = $msale * $row_rs_table ["T2_cat2"];
                    $txtper = $row_rs_table ["T2_cat2"];
                }
                if ($netSale < $txtt1) {
                    $mcom = $msale * $row_rs_table["T1_cat2"];
                    $txtper = $row_rs_table ["T1_cat2"];
                }
            }
        } else {
            $mcom = $msale * 1.5;
        }
        $msgrid[$ai][6] = $mcom / 100;
        $mtotcom = $mtotcom + (($mcom / 100) / 2);

        $ai = $ai + 1;
    }

    $mded = $txtdedamou1 + $txtdedamou2 + $txtdedamou3 + $txtdedamou4 + $txtdedamou5 + $txtdedamou6 + $txtdedamou7 + $txtdedamou8;

    if ($TXTRATO > 15) {
        $mretioded = ($mtotcom * $TXTRATO) / 100;
        $mtotded = $mretioded + $mded;
        $mroundadvance = $mtotcom - $mretioded;
        $mroundadvance = $mroundadvance / 1000;
        $mroundadvance = number_format($mroundadvance, 0, ".", "");
        if ($mroundadvance != "") {
            $mroundadvance = $mroundadvance * 1000;
        } else {
            $mroundadvance = 0;
        }

        $txtadvance = $mtotcom - $mretioded;
        if ($mroundadvance > ($mtotcom - $mretioded)) {
            $mroundadvance = $mroundadvance - 1000;
            $txtad = $mroundadvance;
        } else {
            $txtad = $mroundadvance;
        }
        $txtded = $mded;
        $txtretioded = $mretioded;
        $Txtadva = $mroundadvance - $mded;
    } else {
        $mretioded = 0;
        $mtotded = $mretioded + $mtded;
        $mroundadvance = $mtotcom - $mretioded;
        $mroundadvance = $mroundadvance / 1000;
        $mroundadvance = number_format($mroundadvance, 0, ".", "");
        if ($mroundadvance != "") {
            $mroundadvance = $mroundadvance * 1000;
        } else {
            $mroundadvance = 0;
        }
        $txtadvance = $mtotcom - $mretioded;
        if ($mroundadvance > ($mtotcom - $mretioded)) {
            $mroundadvance = $mroundadvance - 1000;
            $txtad = $mroundadvance;
        } else {
            $txtad = $mroundadvance;
        }
        $txtad = $mroundadvance;
        $txtded = $mded;
        $txtretioded = $mretioded;
        $Txtadva = $mroundadvance - $mded;
    }

    /* msgrid.TextMatrix(0, 1) = "Brand"
      msgrid.TextMatrix(0, 2) = "Sales"
      msgrid.TextMatrix(0, 3) = "CRN"
      msgrid.TextMatrix(0, 4) = "GRN"
      msgrid.TextMatrix(0, 5) = "Net"
      msgrid.TextMatrix(0, 6) = "Comm" */ $ResponseXML .= "<TXTRATO><![CDATA[" . number_format($TXTRATO, 2, ".", ",") . "]]></TXTRATO>";
      $ResponseXML .= "<TXTADJ><![CDATA[" . $TXTADJ . "]]></TXTADJ>";
      $ResponseXML .= "<txtadvance><![CDATA[" . number_format($txtadvance, 2, ".", ",") . "]]></txtadvance>";
      $ResponseXML .= "<TXTCOM><![CDATA[" . number_format($TXTCOM, 2, ".", ",") . "]]></TXTCOM>";
      $ResponseXML .= "<txtad><![CDATA[" . number_format($txtad, 2, ".", ",") . "]]></txtad>";
      $ResponseXML .= "<txtded><![CDATA[" . number_format($txtded, 2, ".", ",") . "]]></txtded>";
      $ResponseXML .= "<txtretioded><![CDATA[" . number_format($txtretioded, 2, ".", ",") . "]]></txtretioded>";
      $ResponseXML .= "<Txtadva><![CDATA[" . number_format($Txtadva, 2, ".", ",") . "]]></Txtadva>";
      $ResponseXML .= "<txtper><![CDATA[" . number_format($txtper, 2, ".", ",") . "]]></txtper>";

      $ResponseXML .= "<msgrid><![CDATA[ <table   border=1  cellspacing=0>
      <tr><td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Brand</font></td>
      <td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Sales</font></td>
      <td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">CRN</font></td>
      <td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">GRN</font></td>
      <td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Net</font></td>
      <td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Comm</font></td>
      </tr>";

      $i = 1;
      while ($row_count > $i) {

        $msgrid1 = "msgrid1_" . $i;
        $msgrid2 = "msgrid2_" . $i;
        $msgrid3 = "msgrid3_" . $i;
        $msgrid4 = "msgrid4_" . $i;
        $msgrid5 = "msgrid5_" . $i;
        $msgrid6 = "msgrid6_" . $i;

        $ResponseXML .= "<tr><td><div id=" . $msgrid1 . ">" . $msgrid [$i][1] . "</div></td>
        <td align=\"right\"><div id=" . $msgrid2 . ">" . number_format($msgrid[$i][2], 2, ".", ",") . "</div></td>
        <td align=\"right\"><div id=" . $msgrid3 . ">" . number_format($msgrid[$i][3], 2, ".", ",") . "</div></td>
        <td align=\"right\"><div id=" . $msgrid4 . ">" . number_format($msgrid [$i][4], 2, ".", ",") . "</div></td>
        <td align=\"right\"><div id=" . $msgrid5 . ">" . number_format($msgrid [$i][5], 2, ".", ",") . "</div></td>
        <td align=\"right\"><div id=" . $msgrid6 . ">" . number_format($msgrid[$i][6], 2, ".", ",") . "</div></td>
        </tr>";
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></msgrid>";

    $ResponseXML .= "<mgridcount><![CDATA[" . $row_count . "]]></mgridcount>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "settlement") {

    $sql = "SELECT * FROM c_bal";
    $result = mysqli_query($GLOBALS ['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $sql1 = "Select sum(C_PAYMENT) as paid  from s_ut where CRE_NO_NO='" . $row['REFNO'] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        if ($row1 = mysqli_fetch_array($result1)) {
            if (is_null($row1["paid"])) {
                $mpaid = $row1 ["paid"];
            }

            $sql2 = "update c_bal set totpay ='" . $mpaid . "' where REF_NO='" . $row["REF_NO"] . "'";
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
        }
    }
}

if ($_GET["Command"] == "utilization") {

    if (($_GET["paytype"] != "R/Deposit") and ($_GET["paytype"] != "C/TT" )) {
        $sql = "select * from tmp_ret_chq_sett where recno='" . $_GET["recno"] . "'";
        $result = mysqli_query($GLOBALS ['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {
            if ($row["chqdate"] != "") {
                if ((strtotime("Y-m-d", $row["chqdate"]) < strtotime(date("Y-m-d"))) or (strtotime("Y-m-d", $row["chqdate"]) == strtotime(date("Y-m-d")))) {
                    $d = date('Y-m-d', strtotime("+1 days"));
                    $sql1 = "update tmp_ret_chq_sett set chqdate='" . $d . "' where recno='" . $_GET["recno"] . "'";
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                }
            }
        }
    }
    $tmp = array();
    $msset = array(array());
    $i = 1;
    $docno = "docno" . $i;
    while ($_GET[$docno] != "") {
        $docno = "docno" . $i;
        $setamount = "setamount" . $i;
        if ($_GET[$setamount] != "") {
            $tmp [$i] = $_GET[$setamount];
        }
        $i = $i + 1;
    }

    $k = 1;

    $sql = "select * from tmp_ret_chq_sett where recno='" . $_GET ["recno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $chqbalval = $row["chqamt"];
        $chqvalval = $row["chqamt"];

        $j = 1;
        while (($_GET["mcount"] > $j) and ($chqbalval > 0)) {
            $invset = $tmp[$j];
            $docno = "docno" . $j;
            $docdate = "docdate" . $j;
            $chqval = "chqval" . $j;
            $chqno = "chqno" . $j;
            $chqdate = "chqdate" . $j;

            if ($invset > 0) {
                if ($invset <= $chqbalval) {
                    if ($tmp[$j] > 0) {
                        $tmp[$j] = 0;
                    }

                    $chqbalval = $chqbalval - $invset;

                    $diff = abs(strtotime($_GET [$docdate]) - strtotime($row ["chqdate"]));
                    $days = floor($diff / (60 * 60 * 24));

                    $ResponseXML .= "<tr><td>" . $_GET[$docno] . "</td>
                    <td>" . $_GET[$docdate] . "</td>
                    <td>" . $row["chqno"] . "</td>
                    <td>" . $row["chqdate"] . "</td>
                    <td>" . $invset . "</td>
                    <td>" . $days . "</td>
                    <td>0</td>
                    <td>" . $_GET[$chqval] . "</td>
                    <td>" . $_GET[$chqno] . "</td>
                    <td>" . $_GET[$chqdate] . "</td></tr>";

                    $msset[$k] [0] = $_GET[$docno];
                    $msset[$k][1] = $_GET[$docdate];
                    $msset[$k][2] = $row["chqno"];
                    $msset [$k][3] = $row["chqdate"];
                    $msset [$k][4] = $invset;
                    $msset[$k][5] = $days;
                    $msset[$k][6] = 0;
                    $msset[$k][7] = $_GET[$chqval];
                    $msset[$k][8] = $_GET[$chqno];
                    $msset[$k][9] = $_GET[$chqdate];
                    $tmp[$j] = 0;
                } else {
                    if ($tmp[$j] > 0) {
                        $tmp[$j] = $invset - $chqbalval;
                    }

                    $diff = abs(strtotime($_GET[$docdate]) - strtotime($row["chqdate"]));
                    $days = floor($diff / (60 * 60 * 24));

                    $ResponseXML .= "<tr><td>" . $_GET[$docno] . "</td>
                    <td>" . $_GET[$docdate] . "</td>
                    <td>" . $row["chqno"] . "</td>
                    <td>" . $row["chqdate"] . "</td>
                    <td>" . $chqbalval . "</td>
                    <td>" . $days . "</td>";

                    $tmp[$j] = $invset - $chqbalval;

                    $ResponseXML .= "<td>" . $tmp[$j] . "</td>
                    <td>" . $_GET[$chqval] . "</td>
                    <td>" . $_GET[$chqno] . "</td>
                    <td>" . $_GET[$chqdate] . "</td></tr>";

                    $msset[$k][0] = $_GET[$docno];
                    $msset [$k][1] = $_GET[$docdate];
                    $msset[$k][2] = $row["chqno"];
                    $msset[$k][3] = $row["chqdate"];
                    $msset[$k][4] = $chqbalval;
                    $msset[$k][5] = $days;
                    $msset[$k][6] = $tmp[$j];
                    $msset[$k][7] = $_GET[$chqval];
                    $msset[$k][8] = $_GET[$chqno];
                    $msset[$k][9] = $_GET[$chqdate];
                    $chqbalval = 0;
                }
                $k = $k + 1;
            }
            $j = $j + 1;
        }
        $i = $i + 1;
    }

    $ii = 1;
    while ($_GET[$docdate] != "") {
        if ($_GET[$cash] != "") {

            $docno = "docno" . $ii;
            $docdate = "docdate" . $ii;
            $chqval = "chqval" . $ii;
            $chqno = "chqno" . $ii;
            $chqdate = "chqdate" . $ii;
            $cash = "cash" . $ii;

            $diff = abs(strtotime($_GET[$docdate]) - strtotime(date("Y-m-d")));
            $days = floor($diff / (60 * 60 * 24));

            $ResponseXML .= "<tr><td>" . $_GET[$docno] . "</td>
            <td>" . $_GET[$docdate] . "</td>
            <td>Cash</td>
            <td>" . date("Y-m-d") . "</td>
            <td>" . $_GET[$cash] . "</td>
            <td>" . $days . "</td>
            <td></td>
            <td>" . $_GET[$chqval] . "</td>
            <td>" . $_GET [$chqno] . "</td>
            <td>" . $_GET[$chqdate] . "</td></tr>";
        }
        $ii = $ii + 1;
    }

    $S = 1;
    while ($_GET[$docno] != "") {
        $docno = "docno" . $S;
        $docdate = "docdate" . $S;
        $chqval = "chqval" . $S;
        $chqno = "chqno" . $S;
        $chqdate = "chqdate" . $S;
        $cash = "cash" . $S;
        $retchqbal = "retchqbal" . $S;

        $H = 10;
        while ($H != 0) {
            if ($_GET[$docno] == $msset[$H][0]) {
                if ($msset[$H + 1][0] == $msset[$H][0]) {
                    if (trim($msset[$H][2]) != "Cash") {
                        $msset[$H][6] = $msset[$H + 1][6] + $msset[$H + 1][4] - $_GET[$cash];
                    } else {
                        $msset[$H][6] = $msset[$H + 1][6] + $msset[$H + 1][4];
                    }
                } else {
                    if ($msset[$H][2] != "Cash") {
                        $msset[$H][6] = $_GET[$retchqbal] - $_GET[$cash];
                    } else {
                        $msset[$H][6] = $_GET [$retchqbal];
                    }
                }
            }
            $H = $H - 1;
        }
        $deutot = $deutot + $_GET[$retchqbal];
        $S = $S + 1;
    }

    $sql1 = "delete from tmp_utilization_ret_chq_set where recno='" . $_GET["recno"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

    $i = 1;
    while ($k > $i) {
        $sql1 = "insert into tmp_utilization_ret_chq_set(recno, docno, docdate, chequeno, chequedate, settled, days, retchbal, retchqval, col1, col2) values ('" . $_GET["recno"] . "', '" . $msset[$i][0] . "', '" . $msset[$i][1] . "', '" . $msset [$i][2] . "', '" . $msset[$i][3] . "', '" . $msset[$i][4] . "', '" . $msset[$i][5] . "', '" . $msset[$i] [6] . "', '" . $msset[$i][7] . "', '" . $msset[$i][8] . "', '" . $msset[$i][9] . "')";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        $i = $i + 1;
    }

    $ResponseXML .= "<uti_table><![CDATA[ <table  bgcolor=\"#003366\" border=1  cellspacing=0>
    <tr><td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Doc.No</font></td>
    <td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Doc.Date</font></td>
    <td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cheque No</font></td>
    <td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cheque Date</font></td>
    <td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Settled</font></td>
    <td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Days</font></td>
    <td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ret.ch.bal</font></td>
    <td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ret.chq.val</font></td>
    </tr>";
    $sql = "select * from tmp_utilization_ret_chq_set where recno='" . $_GET["recno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr><td>" . $row["docno"] . "</td>
        <td>" . $row ["docdate"] . "</td>
        <td>" . $row ["chequeno"] . "</td>
        <td>" . $row["chequedate"] . "</td>
        <td>" . $row["settled"] . "</td>
        <td>" . $row["days"] . "</td>
        <td>" . $row ["retchbal"] . "</td>
        <td>" . $row["retchqval"] . "</td>
        <td>" . $row["col1"] . "</td>
        <td>" . $row["col2"] . "</td></tr>";
    }

    $ResponseXML .= "   </table>]]></uti_table>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "new_rec") {

    /* 	$sql="Select CAS_INV_NO_m from invpara";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
      $row = mysqli_fetch_array($result);
      $tmpinvno="000000".$row["CAS_INV_NO_m"];
      $lenth=strlen($tmpinvno);
      $invno="INV".substr($tmpinvno, $lenth-7);
      echo $invno; */ $sql = "Select Guti from invpara";
      $result = mysqli_query($GLOBALS ['dbinv'], $sql);
      $row = mysqli_fetch_array($result);
      $tmprecno = "000000" . $row["Guti"];
      $lenth = strlen($tmprecno);
      $recno = trim("CUTI/ ") . substr($tmprecno, $lenth - 7);
      $_SESSION["recno"] = $recno;
      echo $recno;
  }

  if ($_GET["Command"] == "setTotal") {
    $r = 1;
    $chtotal = 0;
    $total = 0;

    while ($GLOBALS[$gridchk[$r][1]] != "") {
        $GLOBALS[$gridchk[$r][7]] = "";
        $chtotal = $chtotal + $GLOBALS[$gridchk[$r][6]];
        $r = $r + 1;
    }

    while ($GLOBALS[$Gridinv[$r][1]] != "") {
        $GLOBALS[$Gridinv[$r][7]] = "";
        $total = $total + $GLOBALS[$Gridinv[$r][6]];
        $r = $r + 1;
    }
//$re = Val(Format(txtcrnamount.Text, General)) - (total + chtotal + Val(Format(txtcash, General)))
}

if ($_GET["Command"] == "save_crec") {
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = "Select Guti from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmprecno = "000000" . $row["Guti"];
    $lenth = strlen($tmprecno);
    $recno = trim("CUTI/ ") . substr($tmprecno, $lenth - 7);
    $_SESSION ["recno"] = $recno;

    $sql_ch = "select * from ch_sttr where ST_REFNO='" . trim($_GET["txtrefno"]) . "'";
    $result_ch = mysqli_query($GLOBALS['dbinv'], $sql_ch);
    $row_ch = mysqli_fetch_array($result_ch);

    $sql = "select * from ch_sttr";
    $result = mysqli_query($GLOBALS ['dbinv'], $sql);

    $sql_utmas = "SELECT * FROM s_utmas WHERE C_REFNO ='" . trim($_GET["txtrefno"]) . "'";
    $result_utmas = mysqli_query($GLOBALS['dbinv'], $sql_utmas);
    if ($row_utmas = mysqli_fetch_array($result_utmas)) {
        exit("Ref. No Already Exists");
    }

    if ($_GET["txtcash"] != "") {
        $txtcash = $_GET["txtcash"];
    } else {
        $txtcash = 0;
    }

    $sql_utmas = "insert into s_utmas(C_REFNO, C_DATE, C_CODE, C_CRNNo, C_Amount, C_cash, c_chno, c_chdate, ch_val, ch_bank) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $_GET["Txtcusco"] . "', '" . $_GET["txtcrnno"] . "', '" . $_GET["lblPaid"] . "', '" . $_GET["txtcash"] . "', '" . $_GET["txtchno"] . "', '" . $_GET["DTPicker1"] . "', '" . $_GET["txtamount"] . "', '" . $_GET["txtchbank"] . "')";
    $result_utmas = mysqli_query($GLOBALS['dbinv'], $sql_utmas);

    if ($_GET["chkcash"] == "on") {
        $sql_cruti = "insert into s_ut(C_REFNO, C_DATE, C_CODE, C_INVNO, C_PAYMENT, CRE_NO_NO, TYPE) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $_GET["Txtcusco"] . "', 'CASH', '" . $_GET["lblPaid"] . "', '" . trim($_GET["txtcrnno"]) . "', 'CAS')";
        $result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);
    }

    if ($_GET["chkinv"] == "on") {
        $r = 1;
        while ($GLOBALS[$Gridinv[$r][1]] != "") {
            if (($GLOBALS[$Gridinv[$r][6]] > 0) and ($GLOBALS[$Gridinv[$r] [1]] != "") and ( $GLOBALS[$Gridinv[$r][2]] != "") and ($GLOBALS[$Gridinv[$r][5]] > 0)) {
                $sql_cruti = "insert into s_ut(C_REFNO, C_DATE, C_CODE, C_INVNO, C_PAYMENT, CRE_NO_NO, TYPE) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $_GET["Txtcusco"] . "', '" . $GLOBALS[$Gridinv[$r][1]] . "', '" . $GLOBALS[$Gridinv [$r][6]] . "', '" . trim($_GET["txtcrnno"]) . "', 'INV')";
                $result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);

                $sql_cruti = "UPDATE s_salma SET TOTPAY = TOTPAY + " . $GLOBALS[$Gridinv [$r][6]] . " WHERE ((REF_NO='" . trim($GLOBALS [$Gridinv[$r][1]]) . "'))";
                $result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);

                $diff = abs(strtotime($_GET["dtdate"]) - strtotime($GLOBALS [$Gridinv[$r][6]]));
                $days = floor($diff / (60 * 60 * 24));

                $sql_cruti = "insert into s_sttr(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_FLAG, ST_CHNO, st_days, ap_days) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $GLOBALS[$Gridinv[$r][1]] . "', '" . $GLOBALS[$Gridinv [$r][6]] . "', 'UT', '" . trim($_GET ["txtcrnno"]) . "', '" . $days . "', '" . $days . "')";
                $result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);

//==================credit limit=============================
                $sql_rsinv = "select Brand from s_salma where Accname != 'NON STOCK' and REF_NO='" . trim($GLOBALS [$Gridinv[$r][1]]) . "'";
                $result_rsinv = mysqli_query($GLOBALS['dbinv'], $sql_rsinv);
                if ($row_rsinv = mysqli_fetch_array($result_rsinv)) {

                    $sql_class = "select class from brand_mas where barnd_name='" . $row_rsinv["Brand"] . "'";
                    $result_class = mysqli_query($GLOBALS['dbinv'], $sql_class);
                    if ($row_class = mysqli_fetch_array($result_class)) {

                        $sql_inv = "update br_trn set credit=credit - " . $GLOBALS[$Gridinv[$r][6]] . " where cus_code='" . trim($_GET["txtcrnno"]) . "' and Class='" . $row_class["class"] . "'";
                        $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
                    }
                }
            }

            $r = $r + 1;
        }
    }

    if ($_GET["chkret"] == "on") {

        $r = 1;
        while ($GLOBALS[$gridchk[$r][1]] != "") {
            if (($GLOBALS[$gridchk [$r][6]] > 0) and ($GLOBALS[$gridchk [$r][1]] != "") and ($GLOBALS[$gridchk[$r][2]] != "") and ($GLOBALS[$gridchk[$r] [5]] > 0)) {
                $sql_cruti = "insert into s_ut(C_REFNO, C_DATE, C_CODE, C_INVNO, C_PAYMENT, CRE_NO_NO, TYPE) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $_GET["Txtcusco"] . "', '" . $GLOBALS[$gridchk[$r][1]] . "', '" . $GLOBALS [$gridchk[$r][6]] . "', '" . trim($_GET["txtcrnno"]) . "', 'CHQ')";
                $result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);

                $sql_cruti = "insert into s_sttr(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_FLAG, ST_CHNO) values ('" . trim($_GET ["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $GLOBALS[$gridchk[$r][1]] . "', '" . $GLOBALS[$Gridinv[$r][6]] . "', 'UT', '" . trim($_GET["txtcrnno"]) . "')";
                $result_cruti = mysqli_query($GLOBALS ['dbinv'], $sql_cruti);

                $sql_inv = "UPDATE s_cheq SET PAID = PAID + " . $GLOBALS[$Gridinv[$r][6]] . " WHERE (((CR_REFNO)='" . trim($GLOBALS[$gridchk[$r][1]]) . "'))";
                $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);

                $sql_inv = "UPDATE vendor SET RET_CHEQ = RET_CHEQ - " . $GLOBALS[$Gridinv[$r][6]] . " WHERE CODE='" . trim($GLOBALS[$gridchk[$r][1]]) . "'";
                $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
            }
        }
    }

    $sql_inv = "UPDATE c_bal SET BALANCE = BALANCE - " . $_GET["lblPaid"] . " WHERE ((REFNO='" . trim($_GET ["txtcrnno"]) . "'))";
    $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);

    $sql_inv = "UPDATE invpara SET Guti=Guti+1";
    $result_inv = mysqli_query($GLOBALS ['dbinv'], $sql_inv);

    echo "Saved";
}

if ($_GET["Command"] == "search_rec") {

    $ResponseXML .= "";
//$ResponseXML .= "<invdetails>";

    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
    <tr>
    <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ref No</font></td>
    <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
    <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Amount</font></td>
    <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer</font></td>

    </tr>";
    if ($_GET["mfield"] == "recno") {
        $letters = $_GET['recno'];
//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
//$letters="/".$letters;
//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
//echo $a;

        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_crec where  CA_REFNO like  '$letters%'") or die(mysqli_error());
    } else if ($_GET["mstatus"] == "recdate") {
        $letters = $_GET['recdate'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_crec where CA_DATE like  '$letters%'") or die(mysqli_error());
    } else if ($_GET["mstatus"] == "recamt") {
        $letters = $_GET['recamt'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_crec where CA_AMOUNT like  '$letters%'") or die(mysqli_error());
    } else {
        $letters = $_GET['recno'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_crec where CA_REFNO like  '$letters%'") or die(mysqli_error());
    }

    while ($row = mysqli_fetch_array($sql)) {
        $REF_NO = $row['CA_REFNO'];
        $stname = $_GET["mstatus"];
        $ResponseXML .= "<tr>
        <td bgcolor=\"#222222\" onclick=\"recno('$REF_NO');\">" . $row['CA_REFNO'] . "</a></td>
        <td bgcolor=\"#222222\" onclick=\"recno('$REF_NO');\">" . $row['CA_DATE'] . "</a></td>
        <td bgcolor=\"#222222\" onclick=\"recno('$REF_NO');\">" . $row['CA_AMOUNT'] . "</a></td>";

        $sql1 = "SELECT * FROM vendor where CODE = '" . $row["CA_CODE"] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        $row1 = mysqli_fetch_array($result1);
        $ResponseXML .= "<td bgcolor=\"#222222\" onclick=\"recno('$REF_NO');\">" . $row1['NAME'] . "</a></td>                          	
        </tr>";
    }

    $ResponseXML .= "   </table>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_recno") {
    //header('Content-Type: text/xml');
    /* echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"; */

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $sql = "select * from s_crec where CA_REFNO='" . $_GET["recno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<CA_REFNO><![CDATA[" . $row["CA_REFNO"] . "]]></CA_REFNO>";
        $ResponseXML .= "<CA_DATE><![CDATA[" . $row["CA_DATE"] . "]]></CA_DATE>";
        $ResponseXML .= "<CA_CODE><![CDATA[" . $row["CA_CODE"] . "]]></CA_CODE>";

        $sql1 = "select * from vendor where CODE='" . $row["CA_CODE"] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        if ($row1 = mysqli_fetch_array($result1)) {
            $ResponseXML .= "<cusname><![CDATA[" . $row1["NAME"] . "]]></cusname>";
        }
        $ResponseXML .= "<CA_CASSH><![CDATA[" . $row["CA_CASSH"] . "]]></CA_CASSH>";
        $ResponseXML .= "<CA_AMOUNT><![CDATA[" . $row["CA_AMOUNT"] . "]]></CA_AMOUNT>";
        $ResponseXML .= "<CA_SALESEX><![CDATA[" . $row["CA_SALESEX"] . "]]></CA_SALESEX>";

        $sql1 = "select * from s_salrep where REPCODE='" . $row["CA_SALESEX"] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        if ($row1 = mysqli_fetch_array($result1)) {
            $ResponseXML .= "<repname><![CDATA[" . $row1["Name"] . "]]></repname>";
        }
    }

    $sql = "select * from s_invcheq where refno='" . $_GET["recno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<collectcode><![CDATA[" . $row["ch_owner"] . "]]></collectcode>";
    }

    $sql = "delete from tmp_ret_chq_sett where recno='" . $_GET["recno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sql = "select * from s_invcheq where refno='" . $_GET["recno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $sql1 = "insert into tmp_ret_chq_sett(recno, chqno, chqdate, chqbank, chqamt) values ('" . $row["refno"] . "', '" . $row["cheque_no"] . "', '" . $row["che_date"] . "', '" . $row["bank"] . "', " . $row["che_amount"] . ")";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }

    $ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
    <td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
    <td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
    <td width=\"230\"  background=\"images/headingbg.gif\">Bank</td>
    <td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
    </tr>";

    $sql = "select * from tmp_ret_chq_sett where recno='" . $_GET["recno"] . "' ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>
        <td>" . $row["chqno"] . "</td>
        <td>" . $row["chqdate"] . "</td>
        <td>" . $row["chqbank"] . "</td>
        <td align=right>" . number_format($row["chqamt"], 2, ".", ",") . "</td>
        </tr>";
        $totchq = $totchq + $row["chqamt"];
    }

    $ResponseXML .= "   </table>]]></chq_table>";

    $sql = "delete from tmp_utilization where recno='" . $_GET["recno"] . "' ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sql = "select * from s_sttr where ST_REFNO='" . $_GET["recno"] . "' ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $sql1 = "select * from s_salma where REF_NO='" . $row["ST_INVONO"] . "' ";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        $row1 = mysqli_fetch_array($result1);

        $sql2 = "insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days) values ('" . $_GET["recno"] . "', '" . $row["ST_INVONO"] . "', '" . $row1["sdate1"] . "', '" . $row["ST_CHNO"] . "', '" . $row["st_chdate"] . "', '" . $row["st_chbank"] . "', " . $row["ST_PAID"] . ", " . $row["st_days"] . ")";
        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
    }

    $ResponseXML .= "<uti_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
    <td width=\"200\"  background=\"images/headingbg.gif\">Invoice No</td>
    <td width=\"100\"  background=\"images/headingbg.gif\">Invoice Date</td>
    <td width=\"230\"  background=\"images/headingbg.gif\">Cheque No</td>
    <td width=\"140\"  background=\"images/headingbg.gif\">Cheque Date</td>
    <td width=\"140\"  background=\"images/headingbg.gif\">Settled</td>
    <td width=\"140\"  background=\"images/headingbg.gif\">Days</td>
    </tr>";

    $sql = "select * from tmp_utilization where recno='" . $_GET["recno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>
        <td>" . $row["invno"] . "</td>
        <td>" . $row["invdate"] . "</td>
        <td>" . $row["chqno"] . "</td>
        <td>" . $row["chqdate"] . "</td>
        <td align=right>" . number_format($row["settled"], 2, ".", ",") . "</td>
        <td>" . $row["days"] . "</td>
        </tr>";
    }

    $ResponseXML .= "   </table>]]></uti_table>";
    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "calcc") {
    //header('Content-Type: text/xml');
    /* echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"; */

    $year = substr($_GET["dtMonth"], 0, 4);
    $month = substr($_GET["dtMonth"], 5, 2);

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql_inv = "select SUM(GRAND_TOT) AS SALEAMU,SUM(GRAND_TOT/(1 +gst/100)) AS SALEAMU1,sum(grand_tot-totpay) as outs,sum(totpay) as totpay from s_salma where month(sdate1)='" . $month . "' AND YEAR(sdate1)='" . $year . "' AND SAL_EX='" . $_GET["cmbrep"] . "' AND CANCELL='0' ";
    //echo $sql_inv;
    $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
    if ($row_inv = mysqli_fetch_array($result_inv)) {
        if (is_null($row_inv["SALEAMU"]) == false) {
            $TOTSALEALL = $row_inv["SALEAMU"];

            $TOTNSALEALL = $row_inv["SALEAMU1"];
            $out = $row_inv['outs'];
            $totpay = $row_inv['totpay'];
        }
    }
    $TOTRETS = 0;

    $sql1 = "SELECT SUM(AMOUNT)AS RETAMU,SUM(AMOUNT/(1 +vatrate/100)) AS RETAMU1   FROM c_bal WHERE (flag1 = '0') and MONTH(sdate1)='" . $month . "' AND YEAR(sdate1) ='" . $year . "' AND SAL_EX='" . $_GET["cmbrep"] . "' AND CANCELL='0' and (trn_type='GRN' or  trn_type='CNT' )  ";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    if ($row1 = mysqli_fetch_array($result1)) {
        if (is_null($row1["RETAMU"]) == false) {
            $TOTNSALEALL = $TOTNSALEALL - $row1["RETAMU1"];
            $TOTRETS = $row1["RETAMU"];
        }
    }

    $sql_rs_salm = "Select  sum(CR_CHEVAL-PAID) as retche  from  s_cheq  where S_REF='" . $_GET["cmbrep"] . "' and CR_FLAG = '0' ";
    $result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
    $row_rs_salm = mysqli_fetch_array($result_rs_salm);
    if (is_null($row_rs_salm["retche"]) == false) {
        $mretche = $row_rs_salm["retche"];
    }
    $txtretcheq = $txtretcheq;

    $sql_TAR = "select * from sal_comm where sal_ex='" . $_GET["cmbrep"] . "'";
    $result_TAR = mysqli_query($GLOBALS['dbinv'], $sql_TAR);
    if ($row_TAR = mysqli_fetch_array($result_TAR)) {
        $txtt1 = $row_TAR["T1"];
        $txtt2 = $row_TAR["T2"];
    }

    $j = 1;
    $mcmbrep = $_GET["cmbrep"];
    $Mon = date("m", strtotime($_GET["dtMonth"]));
    $Yer = date("Y", strtotime($_GET["dtMonth"]));

    if ($_SESSION["dev"] == "0") {
        $sql_ven = "select sdate1,REF_NO,C_CODE,CUS_NAME,Brand,GRAND_TOT,TOTPAY,cre_pe from view_salma_vendor where SAL_EX='" . trim($_GET["cmbrep"]) . "' and month(sdate1) = '" . $month . "' and year(sdate1) = '" . $year . "' and CANCELL = '0' and DEV='0' order by REF_NO";
    } else if ($_SESSION["dev"] == "1") {
        $sql_ven = "select sdate1,REF_NO,C_CODE,CUS_NAME,Brand,GRAND_TOT,TOTPAY,cre_pe from view_salma_vendor where SAL_EX='" . trim($_GET["cmbrep"]) . "' and month(sdate1) = '" . $month . "' and year(sdate1) = '" . $year . "' and CANCELL = '0' order by REF_NO";
    }

    $result_ven = mysqli_query($GLOBALS['dbinv'], $sql_ven);
    while ($row_ven = mysqli_fetch_array($result_ven)) {
        $day1 = 0;
        $day2 = 0;
        $cat1 = 0;
        $cat2 = 0;
        $cat3 = 0;

        $sql = "select * from com_she where sal_ex='" . trim($mcmbrep) . "' and brand= '" . $row_ven["Brand"] . "' ";
        $result_rsstn1 = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($rsstn1 = mysqli_fetch_array($result_rsstn1)) {

            $day1 = $rsstn1['Day1'];
            $day2 = $rsstn1['Day2'];
        }

        if ($TOTNSALEALL > $txtt2) {
            $cat1 = $rsstn1["T3_cat1"];
            $cat2 = $rsstn1["T3_cat2"];
            $cat3 = $rsstn1["T3_cat3"];
        } else if ($TOTNSALEALL > $txtt1) {
            $cat1 = $rsstn1["T2_Cat1"];
            $cat2 = $rsstn1["T2_cat2"];
            $cat3 = $rsstn1["T2_Cat3"];
        } else {
            $cat1 = $rsstn1["T1_Cat1"];
            $cat2 = $rsstn1["T1_cat2"];
            $cat3 = $rsstn1["T1_cat3"];
        }

        $sql = "Select incdays from vendor where code = '" . $row_ven["C_CODE"] . "'";
        $result_rsstn2 = mysqli_query($GLOBALS['dbinv'], $sql);
        $rsstn2 = mysqli_fetch_array($result_rsstn2);

        If ($rsstn2['incdays'] > $day1) {
            $day1 = $rsstn2['incdays'] + 1;
            $day2 = $rsstn2['incdays'] + 1;
        }

        If ($row_ven['cre_pe'] > $day1) {
            $day1 = $row_ven['cre_pe'] + 1;
            $day2 = $row_ven['cre_pe'] + 1;
        }

        $sql = "SELECT SUM(ST_PAID) AS INVPAID FROM S_STTR WHERE ST_INVONO='" . $row_ven['REF_NO'] . "' AND (del_days<" . $day1 . " and ST_flag <> 'UT')";
        $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql);
        $rsstn_sttr = mysqli_fetch_array($result_sttr);
        If (!Is_Null($rsstn_sttr['INVPAID'])) {
            $tot_Comm_cat_1 = $tot_Comm_cat_1 + $rsstn_sttr['INVPAID'];
            If ($cat1 > 0) {
                $TOTcOMMpAY = $TOTcOMMpAY + $rsstn_sttr['INVPAID'];
            } else {
                $TOTnOcOMMpAY = $TOTnOcOMMpAY + $rsstn_sttr['INVPAID'];
            }
        }

        $sql = "SELECT SUM(ST_PAID) AS INVPAID FROM S_STTR WHERE ST_INVONO='" . $row_ven['REF_NO'] . "' AND   ST_flag = 'UT' ";
        $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql);
        $rsstn_sttr = mysqli_fetch_array($result_sttr);
        If (!Is_Null($rsstn_sttr['INVPAID'])) {
            $tot_Comm_cat_2 = $tot_Comm_cat_2 + $rsstn_sttr['INVPAID'];
            If ($cat2 > 0) {
                $TOTcOMMpAY = $TOTcOMMpAY + $rsstn_sttr['INVPAID'];
            } else {
                $TOTnOcOMMpAY = $TOTnOcOMMpAY + $rsstn_sttr['INVPAID'];
            }
        }

        $sql = "SELECT SUM(ST_PAID) AS INVPAID FROM S_STTR WHERE ST_INVONO='" . $row_ven['REF_NO'] . "' AND   (del_days>" . $day2 . " or del_days=" . $day2 . ") and st_flag<>'UT'";
        $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql);
        $rsstn_sttr = mysqli_fetch_array($result_sttr);
        If (!Is_Null($rsstn_sttr['INVPAID'])) {
            //echo $rsstn_sttr['INVPAID'] . ";";

            $tot_Comm_cat_3 = $tot_Comm_cat_3 + $rsstn_sttr['INVPAID'];
            If ($cat3 > 0) {
                $TOTcOMMpAY = $TOTcOMMpAY + $rsstn_sttr['INVPAID'];
            } else {
                $TOTnOcOMMpAY = $TOTnOcOMMpAY + $rsstn_sttr['INVPAID'];
            }
        }
    }

    $txtper = $TOTnOcOMMpAY / ($TOTSALEALL - $TOTRETS) * 100;

    $ResponseXML .= "<totnocom><![CDATA[" . number_format($TOTnOcOMMpAY, 2, ".", ",") . "]]></totnocom>";
    $ResponseXML .= "<txtper><![CDATA[" . number_format($txtper, 2, ".", ",") . "]]></txtper>";
    $ResponseXML .= "<txtt1><![CDATA[" . number_format($txtt1, 2, ".", ",") . "]]></txtt1>";
    $ResponseXML .= "<txtt2><![CDATA[" . number_format($txtt2, 2, ".", ",") . "]]></txtt2>";
    $ResponseXML .= "<totpay><![CDATA[" . number_format($totpay, 2, ".", ",") . "]]></totpay>";
    $ResponseXML .= "<out><![CDATA[" . number_format($out, 2, ".", ",") . "]]></out>";
    $ResponseXML .= "<txtretcheq><![CDATA[" . number_format($mretche, 2, ".", ",") . "]]></txtretcheq>";
    $ResponseXML .= "<TOTRETS><![CDATA[" . number_format($TOTRETS, 2, ".", ",") . "]]></TOTRETS>";

    $ResponseXML .= "<TOTSALEALL><![CDATA[" . number_format($TOTSALEALL, 2, ".", ",") . "]]></TOTSALEALL>";
    $ResponseXML .= "<TOTNSALEALL><![CDATA[" . number_format($TOTNSALEALL, 2, ".", ",") . "]]></TOTNSALEALL>";

    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}



if ($_GET["Command"] == "setremark") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $month = substr($_GET["dtMonth"], 0, 7);
    $sql_utmas = "SELECT * FROM commisionremark WHERE month  ='" . $month . "' and rep='" . $_GET["cmbrep"] . "' and type='Bal'";

    $result_utmas = mysqli_query($GLOBALS['dbinv'], $sql_utmas);
    if ($row_utmas = mysqli_fetch_array($result_utmas)) {

        $ResponseXML .= "<mcount1><![CDATA[" . $row_utmas['remark'] . "]]></mcount1>";
    } else {
        $ResponseXML .= "<mcount1><![CDATA[" . '' . "]]></mcount1>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}
?>
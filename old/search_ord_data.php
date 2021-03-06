<?php

session_start();

date_default_timezone_set('Asia/Colombo');

include_once ("connectioni.php");

if ($_GET["Command"] == "search_inv") {

    $ResponseXML = "";
    //$ResponseXML .= "<invdetails>";

    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Order No</font></td>
                              <td width=\"171\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer</font></td>
                             <td width=\"70\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Order Date</font></td>
							 <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Grand Total</font></td>
							 
							 <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Status</font></td>
							 <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rep</font></td>
							 <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Approve By</font></td>
							 <td width=\"70\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\"></font></td>
   							</tr>";

    if ($_GET["Option1"] == "true") {
        if ($_GET["mstatus"] == "invno") {
            $letters = $_GET['invno'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where REF_NO like  '$letters%' and  INVNO='0'  and CANCELL='0'  order by id asc limit 50") or die(mysqli_error());
        } else if ($_GET["mstatus"] == "customername") {
            $letters = $_GET['customername'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO='0'  and CANCELL='0' order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        } else {
            $letters = $_GET['rep'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where sal_ex like  '$letters%' and  INVNO='0' and CANCELL='0'   order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        }
    }

    if ($_GET["Option2"] == "true") {
        if ($_GET["mstatus"] == "invno") {
            $letters = $_GET['invno'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where REF_NO like  '$letters%' and  INVNO='0' and Forward<>'WD' and CANCELL='0' and Result='P'   order by id asc limit 50") or die(mysqli_error());
        } else if ($_GET["mstatus"] == "customername") {
            $letters = $_GET['customername'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO='0' and Forward<>'WD'  and CANCELL='0' and Result='P'  order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        } else {
            $letters = $_GET['rep'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where sal_ex like  '$letters%' and  INVNO='0' and Forward<>'WD' and CANCELL='0' and Result='P'  order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        }
    }

    if ($_GET["Option3"] == "true") {
        if ($_GET["mstatus"] == "invno") {
            $letters = $_GET['invno'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where REF_NO like  '$letters%' and  INVNO='0' and Forward='WD' and CANCELL='0' and Result='P' order by id asc limit 50") or die(mysqli_error());
        } else if ($_GET["mstatus"] == "customername") {
            $letters = $_GET['customername'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO='0' and Forward='WD' and CANCELL='0' and Result='P' order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        } else {
            $letters = $_GET['rep'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where sal_ex like  '$letters%' and  INVNO='0' and Forward='WD' and CANCELL='0' and Result='P' order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        }
    }

    if ($_GET["Option4"] == "true") {
        if ($_GET["mstatus"] == "invno") {
            $letters = $_GET['invno'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where REF_NO like  '$letters%' and  INVNO!='0' and CANCELL='0'  order by id asc limit 50") or die(mysqli_error());
        } else if ($_GET["mstatus"] == "customername") {
            $letters = $_GET['customername'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO!='0' and CANCELL='0'  order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        } else {
            $letters = $_GET['rep'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where sal_ex like  '$letters%' and  INVNO!='0' and CANCELL='0'  order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        }
    }

    if ($_GET["Option5"] == "true") {
        if ($_GET["mstatus"] == "invno") {
            $letters = $_GET['invno'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where REF_NO like  '$letters%' and  INVNO='0' and CANCELL='0' and result = 'OK' order by id asc limit 50") or die(mysqli_error());
        } else if ($_GET["mstatus"] == "customername") {
            $letters = $_GET['customername'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where CUS_NAME like  '$letters%' and  INVNO='0' and CANCELL='0' and result = 'OK' order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        } else {
            $letters = $_GET['rep'];
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where sal_ex like  '$letters%' and  INVNO='0' and CANCELL='0' and result = 'OK' order by id asc limit 50") or die(mysqli_error()) or die(mysqli_error());
        }
    }

    while ($row = mysqli_fetch_array($sql)) {
        $REF_NO = $row['REF_NO'];
        $stname = $_SESSION["stname"];
        $ResponseXML .= "<tr>
                           	  <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['CUS_NAME'] . "</a></td>
                              <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['SDATE'] . "</a></td>
							  <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['GRAND_TOT'] . "</a></td>
							  <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['Result'] . "</a></td>
							  <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['SAL_EX'] . "</a></td>
							  <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['Brand'] . "</a></td>							  
                              <td onclick=\"invno('$REF_NO', '$stname');\">" . $row['Forward'] . "</a></td>                          	
                            </tr>";
    }

    $ResponseXML .= "   </table>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_invno_cus_ord") {
    $txt_stat = "OLD";

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM s_wcusordmas where REF_NO='" . $_GET["invno"] . "'") or die(mysqli_error());
    if ($row_rssalma = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<invno><![CDATA[" . $_GET["invno"] . "]]></invno>";
        $ResponseXML .= "<DTappdate><![CDATA[" . $row_rssalma["appdate"] . "]]></DTappdate>";
        $ResponseXML .= "<txt_cuscode><![CDATA[" . $row_rssalma["C_CODE"] . "]]></txt_cuscode>";
        $ResponseXML .= "<txt_cusname><![CDATA[" . $row_rssalma["CUS_NAME"] . "]]></txt_cusname>";

        $sql_cus = mysqli_query($GLOBALS['dbinv'], "select * from vendor where CODE='" . $row_rssalma["C_CODE"] . "'") or die(mysqli_error());
        if ($row_cus = mysqli_fetch_array($sql_cus)) {
            $ResponseXML .= "<lblvatno><![CDATA[" . $row_cus["vatno"] . "]]></lblvatno>";
            $ResponseXML .= "<txt_cusadd><![CDATA[" . $row_cus["ADD1"] . " " . $row_cus["ADD2"] . "]]></txt_cusadd>";
        }
        // Call setcus

        if ($row_rssalma["TYPE"] == "CA") {
            $ResponseXML .= "<Op_cash><![CDATA[true]]></Op_cash>";
            $ResponseXML .= "<Op_credit><![CDATA[false]]></Op_credit>";
        }
        if ($row_rssalma["TYPE"] == "CR") {
            $ResponseXML .= "<Op_cash><![CDATA[false]]></Op_cash>";
            $ResponseXML .= "<Op_credit><![CDATA[true]]></Op_credit>";
        }

        $ResponseXML .= "<txt_dis><![CDATA[" . $row_rssalma["DISCOU"] . "]]></txt_dis>";
        $ResponseXML .= "<txt_subtot><![CDATA[" . $row_rssalma["AMOUNT"] . "]]></txt_subtot>";
        $ResponseXML .= "<txt_net><![CDATA[" . $row_rssalma["GRAND_TOT"] . "]]></txt_net>";
        $ResponseXML .= "<txt_ordno><![CDATA[" . $row_rssalma["ORD_NO"] . "]]></txt_ordno>";
        $ResponseXML .= "<dtdate><![CDATA[" . $row_rssalma["SDATE"] . "]]></dtdate>";

        $date = $row_rssalma["SDATE"];
        $date = strtotime(date("Y-m-d", strtotime($date)) . " +6 days");
        $caldate = date("Y-m-d", $date);

        $ResponseXML .= "<DTdateto><![CDATA[" . $caldate . "]]></DTdateto>";
        $ResponseXML .= "<DTREQ_DATE><![CDATA[" . $row_rssalma["REQ_DATE"] . "]]></DTREQ_DATE>";

        $ResponseXML .= "<DTappdate><![CDATA[" . $row_rssalma["REQ_DATE"] . "]]></DTappdate>";

        $ResponseXML .= "<com_dep><![CDATA[" . $row_rssalma["DEPARTMENT"] . "]]></com_dep>";

        $ResponseXML .= "<Com_rep><![CDATA[" . $row_rssalma["SAL_EX"] . "]]></Com_rep>";

        $ResponseXML .= "<cmbbrand><![CDATA[" . $row_rssalma["Brand"] . "]]></cmbbrand>";

        if (is_null($row_rssalma["VAT"]) == false) {
            if ($row_rssalma["VAT"] == "1") {
                $ResponseXML .= "<Op_vat><![CDATA[true]]></Op_vat>";
                $ResponseXML .= "<Op_nonvat><![CDATA[false]]></Op_nonvat>";
            } else {
                $ResponseXML .= "<Op_vat><![CDATA[false]]></Op_vat>";
                $ResponseXML .= "<Op_nonvat><![CDATA[true]]></Op_nonvat>";
            }
        } else {
            $ResponseXML .= "<Op_vat><![CDATA[false]]></Op_vat>";
            $ResponseXML .= "<Op_nonvat><![CDATA[true]]></Op_nonvat>";
        }

        if (is_null($row_rssalma["CASH"]) == false) {
            $ResponseXML .= "<txt_cash><![CDATA[" . $row_rssalma["CASH"] . "]]></txt_cash>";
        }

        $sql_invpara = mysqli_query($GLOBALS['dbinv'], "SELECT * from invpara") or die(mysqli_error());
        $row_invpara = mysqli_fetch_array($sql_invpara);

        $sql_vat = mysqli_query($GLOBALS['dbinv'], "SELECT * from vatrate where sdate<='" . $row_rssalma["SDATE"] . "' order by sdate desc") or die(mysqli_error());
        $row_vat = mysqli_fetch_array($sql_vat);

        $mvatrate = $row_vat["vatrate"];

        $sql_del = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM tmp_cusord_data where str_invno='" . $_GET["invno"] . "'") or die(mysqli_error());

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

        $sql_rsinv = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM s_cusordtrn where REF_NO='" . $_GET["invno"] . "'") or die(mysqli_error());
        while ($row_rsinv = mysqli_fetch_array($sql_rsinv)) {

            if ($row_rssalma["VAT"] == "1") {
                $PRICE = $row_rsinv["PRICE"] / (1 + $mvatrate / 100);
            } else {
                $PRICE = $row_rsinv["PRICE"];
            }

            $sql = mysqli_query($GLOBALS['dbinv'], "Insert into tmp_cusord_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand, tmp_no)values 
			('" . $_GET["invno"] . "', '" . $row_rsinv["STK_NO"] . "', '" . $row_rsinv["DESCRIPT"] . "', " . $PRICE . ", " . $row_rsinv["QTY"] . ", " . $row_rsinv["DIS_per"] . ", " . $row_rsinv["DIS_rs"] . ", " . (($row_rsinv["QTY"] * $PRICE) - $row_rsinv["DIS_rs"]) . ", '" . $row_rsinv["STK_NO"] . "', '" . $row_rsinv["STK_NO"] . "')") or die(mysqli_error());

            $DIS_per = $row_rsinv["DIS_per"];

            $ResponseXML .= "<tr>
                              
                             <td >" . $row_rsinv["STK_NO"] . "</td>
							 <td >" . $row_rsinv["DESCRIPT"] . "</a></td>
							 <td >" . number_format($PRICE, 2, ".", ",") . "</a></td>
							 <td >" . number_format($row_rsinv["QTY"], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row_rsinv["DIS_per"], 2, ".", ",") . "</a></td>
							 <td >" . number_format((($row_rsinv["QTY"] * $PRICE) - $row_rsinv["DIS_rs"]), 2, ".", ",") . "</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row_rsinv["STK_NO"] . "  name=" . $row_rsinv["STK_NO"] . " onClick=\"del_item('" . $row_rsinv["STK_NO"] . "');\"></td>";

            //include_once("connectioni.php");

            $sqlqty = mysqli_query($GLOBALS['dbinv'], "select QTYINHAND from s_submas where STK_NO='" . $row_rsinv["STK_NO"] . "' AND STO_CODE='" . $_GET["department"] . "'") or die(mysqli_error());
            if ($rowqty = mysqli_fetch_array($sqlqty)) {
                $qty = $rowqty['QTYINHAND'];
            } else {
                $qty = 0;
            }

            $ResponseXML .= "<td >" . $qty . "</a></td>
						
                            </tr>";
        }

        $ResponseXML .= "   </table>]]></sales_table>";

        $ResponseXML .= "<DIS_per><![CDATA[" . $DIS_per . "]]></DIS_per>";
    }

    $ResponseXML .= "</salesdetails>";

    $_SESSION["print"] = 1;

    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_invno") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $brand = "";
    $salrep = "";
    $cuscode = "";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<stname><![CDATA[" . $_GET["stname"] . "]]></stname>";
    $inv = $_GET['invno'];
    $_SESSION["invno"] = $_GET['invno'];
    $_SESSION["salesord1"] = $_GET['invno'];

    $_SESSION["custno"] = $_GET['custno'];


    if ($_GET['stname'] != "ord1") {
        $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_cusordmas where REF_NO='" . $inv . "'") or die(mysqli_error());

        if ($row = mysqli_fetch_array($sql)) {
            $cuscode = $row['C_CODE'];
            $ResponseXML .= "<str_invoiceno><![CDATA[" . $row['REF_NO'] . "]]></str_invoiceno>";
            $ResponseXML .= "<str_crecash><![CDATA[" . $row['TYPE'] . "]]></str_crecash>";
            $ResponseXML .= "<sdate><![CDATA[" . $row['SDATE'] . "]]></sdate>";
            $orddate = $row['SDATE'];
            $cuscode = $row['C_CODE'];
            $ResponseXML .= "<str_customecode><![CDATA[" . $row['C_CODE'] . "]]></str_customecode>";
            $_SESSION["tmp_no_ord"] = $row['tmp_no'];
            //echo "Select * from vendor where CODE='".$row['C_CODE']."'";
            $sqlcustomer = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $row['C_CODE'] . "'") or die(mysqli_error());
            if ($rowcustomer = mysqli_fetch_array($sqlcustomer)) {
                $ResponseXML .= "<str_customername><![CDATA[" . $rowcustomer['NAME'] . "]]></str_customername>";
                $ResponseXML .= "<str_address><![CDATA[" . $rowcustomer['ADD1'] . " " . $rowcustomer['ADD2'] . "]]></str_address>";
                $ResponseXML .= "<str_vatno1><![CDATA[" . $rowcustomer['vatno'] . "]]></str_vatno1>";
                $ResponseXML .= "<str_vatno2><![CDATA[" . $rowcustomer['svatno'] . "]]></str_vatno2>";
            }

            //$ResponseXML .= "<str_vatno2><![CDATA[".$row['str_vatno2']."]]></str_vatno2>";
            $ResponseXML .= "<str_salesrep><![CDATA[" . $row['SAL_EX'] . "]]></str_salesrep>";
            $salesrep = $row['SAL_EX'];
            //$ResponseXML .= "<str_salesorder1><![CDATA[".$row['str_salesorder1']."]]></str_salesorder1>";
            //$ResponseXML .= "<str_salesorder2><![CDATA[".$row['str_salesorder2']."]]></str_salesorder2>";
            $ResponseXML .= "<dte_deliverdate><![CDATA[" . $row['REQ_DATE'] . "]]></dte_deliverdate>";
            //$ResponseXML .= "<str_orderno1><![CDATA[".$row['ORD_NO']."]]></str_orderno1>";
            //$ResponseXML .= "<str_orderno2><![CDATA[".$row['ORD_DA']."]]></str_orderno2>";
            //$ResponseXML .= "<cur_credit><![CDATA[".$row['cur_credit']."]]></cur_credit>";
            //$ResponseXML .= "<cur_balance><![CDATA[".$row['cur_balance']."]]></cur_balance>";

            $ResponseXML .= "<dis><![CDATA[" . $row['DIS'] . "]]></dis>";
            $ResponseXML .= "<dis1><![CDATA[" . $row['DIS1'] . "]]></dis1>";
            $ResponseXML .= "<dis2><![CDATA[" . $row['DIS2'] . "]]></dis2>";

            $ResponseXML .= "<str_department><![CDATA[" . $row['DEPARTMENT'] . "]]></str_department>";
            $department = $row['DEPARTMENT'];
            $_SESSION["department"] = $department;

            $ResponseXML .= "<str_brand><![CDATA[" . $row['Brand'] . "]]></str_brand>";
            $brand = $row['Brand'];
            $_SESSION["brand"] = $brand;

            $ResponseXML .= "<str_vat><![CDATA[" . number_format($row['VAT'], 0, "", "") . "]]></str_vat>";
            //$ResponseXML .= "<cur_discount1><![CDATA[".$row['cur_discount1']."]]></cur_discount1>";
            //$ResponseXML .= "<cur_discount2><![CDATA[".$row['cur_discount2']."]]></cur_discount2>";
            $ResponseXML .= "<cur_subtotal><![CDATA[" . number_format($row['AMOUNT'], 2, ".", ",") . "]]></cur_subtotal>";
            $ResponseXML .= "<cur_discount><![CDATA[" . number_format($row['DISCOU'], 2, ".", ",") . "]]></cur_discount>";
            $ResponseXML .= "<cur_tax><![CDATA[" . number_format($row['VAT_VAL'], 2, ".", ",") . "]]></cur_tax>";
            $ResponseXML .= "<cur_invoiceval><![CDATA[" . number_format($row['GRAND_TOT'], 2, ".", ",") . "]]></cur_invoiceval>";
        }

        $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"70\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"350\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";

        /* $sql_data = mysqli_query($GLOBALS['dbinv'],"Select CAS_INV_NO_m from invpara") or die(mysqli_error());
          $row = mysqli_fetch_array($sql_data);
          $tmpinvno="000000".$row["CAS_INV_NO_m"];
          $lenth=strlen($tmpinvno);
          $invno=trim("CRI/ ").substr($tmpinvno, $lenth-7); */

        $sql_data = mysqli_query($GLOBALS['dbinv'], "delete from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "'") or die(mysqli_error());
        //echo "Select * from s_cusordtrn where REF_NO='".$inv."'";
        $sql_data = mysqli_query($GLOBALS['dbinv'], "Select * from s_cusordtrn where REF_NO='" . $inv . "'") or die(mysqli_error());
        while ($row = mysqli_fetch_array($sql_data)) {
            //echo "Select * from s_mas where STK_NO='".$row['STK_NO']."' and BRAND_NAME='".$brand."'";
            $sql_itdata = mysqli_query($GLOBALS['dbinv'], "Select * from s_mas where STK_NO='" . $row['STK_NO'] . "' and BRAND_NAME='" . $brand . "'") or die(mysqli_error());
            $rowit = mysqli_fetch_array($sql_itdata);

            //$a="Insert into tmp_ord_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$row['REF_NO']."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".$row["subtot"].", '".$row['BRAND']."')";
            //echo $a;
            //echo "Insert into tmp_ord_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand, tmp_no) values ( '".$inv."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".($row['PRICE']*$row['QTY']).", '".$row['BRAND']."', '".$_SESSION["tmp_no_ord"]."')";
            $sql_tmp = mysqli_query($GLOBALS['dbinv'], "Insert into tmp_ord_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand, tmp_no) values ( '" . $inv . "', '" . $row['STK_NO'] . "', '" . $row['DESCRIPT'] . "', " . $row['PRICE'] . ", " . $row['QTY'] . ", " . $row['DIS_per'] . ", " . $row['DIS_rs'] . ", " . ($row['PRICE'] * $row['QTY']) . ", '" . $row['BRAND'] . "', '" . $_SESSION["tmp_no_ord"] . "')") or die(mysqli_error());

            $ResponseXML .= "<tr>
                              
                             <td >" . $row['STK_NO'] . "</a></td>
  							 <td >" . $row['DESCRIPT'] . "</a></td>
							 <td >" . number_format($row['PRICE'], 2, ".", ",") . "</a></td>
							 <td >" . $row['QTY'] . "</a></td>
							 <td >" . number_format($row['DIS_per'], 2, ".", ",") . "</td>
							 <td >" . number_format(($row['PRICE'] * $row['QTY']), 2, ".", ",") . "</a></td>";

            include_once ("connectioni.php");
            // echo "select QTYINHAND from s_submas where STK_NO='".$row['STK_NO']."' AND STO_CODE='".$department."'";
            $sqlqty = mysqli_query($GLOBALS['dbinv'], "select QTYINHAND from s_submas where STK_NO='" . $row['STK_NO'] . "' AND STO_CODE='" . $department . "'") or die(mysqli_error());
            if ($rowqty = mysqli_fetch_array($sqlqty)) {
                $qty = $rowqty['QTYINHAND'];
            } else {
                $qty = 0;
            }

            $ResponseXML .= "<td >" . $qty . "</a></td>
                            </tr>";
        }

        $ResponseXML .= "   </table>]]></sales_table>";



        $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $cuscode . "'") or die(mysqli_error());
        if ($row = mysqli_fetch_array($sql)) {

            $OldRefno = "";
            $NewRefNo = "";
            //echo "SELECT  * From ref_history WHERE NewRefNo = '".$salesrep."'";
            $sql1 = mysqli_query($GLOBALS['dbinv'], "SELECT  * From ref_history WHERE NewRefNo = '" . $salesrep . "'") or die(mysqli_error());
            if ($row1 = mysqli_fetch_array($sql1)) {
                $OldRefno = trim($row1["OldRefno"]);
                $NewRefNo = trim($row1["NewRefNo"]);
            }

            $OutpDAMT = 0;
            $OutREtAmt = 0;
            $OutInvAmt = 0;

            $sql1 = mysqli_query($GLOBALS['dbinv'], "select * from brand_mas where barnd_name='" . trim($brand) . "'") or die(mysqli_error());

            if ($row1 = mysqli_fetch_array($sql1)) {
                if (is_null($row1["class"]) == false) {
                    $InvClass = trim($row1["class"]);
                }
            }

            //$sql1 = mysqli_query($GLOBALS['dbinv'],"select sum(grand_tot-totpay) as totOut from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='".trim($cuscode)."' and sal_ex='".trim($salesrep)."' and class='".$InvClass."'") or die(mysqli_error());

            if ($NewRefNo == $salesrep) {

                $sqlview = mysqli_query($GLOBALS['dbinv'], "select sum(grand_tot-totpay) as totout from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='" . trim($cuscode) . "' and (sal_ex='" . $OldRefno . "' or sal_ex='" . trim($salesrep) . "') and class='" . $InvClass . "'") or die(mysqli_error());
            } else {

                $sqlview = mysqli_query($GLOBALS['dbinv'], "select sum(grand_tot-totpay) as totout from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='" . trim($cuscode) . "' and sal_ex='" . trim($salesrep) . "' and class='" . $InvClass . "'") or die(mysqli_error());
            }

            $rowview = mysqli_fetch_array($sqlview);
            if (is_null($rowview["totout"]) == false) {
                $OutInvAmt = $rowview["totout"];
            }

            $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM s_invcheq WHERE che_date>'" . $orddate . "' AND cus_code='" . trim($cuscode) . "' and trn_type='REC' and sal_ex='" . trim($salesrep) . "'") or die(mysqli_error());
            //echo "SELECT * FROM s_invcheq WHERE che_date>'".$_GET["invdate"]."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($salesrep)."'";
            while ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {

                $sqlsttr = mysqli_query($GLOBALS['dbinv'], "select * from s_sttr where ST_REFNO='" . trim($rowinvcheq["refno"]) . "' and ST_CHNO ='" . trim($rowinvcheq["cheque_no"]) . "'") or die(mysqli_error());
                //echo "select * from s_sttr where ST_REFNO='".trim($rowinvcheq["refno"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"]) ."'";
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

            $sqlview = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE CHE_DATE >'" . $_GET["invdate"] . "' AND CUS_CODE='" . trim($cuscode) . "' and trn_type='RET'") or die(mysqli_error());
            $rowsview = mysqli_fetch_array($sqlview);
            if (is_null($rowsview["che_amount"]) == false) {
                $pend_ret_set = $rowsview["che_amount"];
            }

            if ($NewRefNo == $salesrep) {

                $sqlcheq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and (S_REF='" . $salesrep . "' or S_REF='" . $OldRefno . "') ") or die(mysqli_error());
            } else {

                $sqlcheq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='" . $salesrep . "' ") or die(mysqli_error());
            }
            $rowscheq = mysqli_fetch_array($sqlcheq);
            if (is_null($rowscheq["tot"]) == false) {
                $OutREtAmt = $rowscheq["tot"];
            } else {
                $OutREtAmt = 0;
            }

            $d = date("Y-m-d");

            $date = date('Y-m-d', strtotime($d . ' -60 days'));

            $sql_rssal = mysqli_query($GLOBALS['dbinv'], "Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where C_CODE = '" . trim($cuscode) . "' and (SDATE < '" . $date . "') and GRAND_TOT - TOTPAY > 1 and CANCELL = '0'") or die(mysqli_error());

            if ($row_rssal = mysqli_fetch_array($sql_rssal)) {

                if (is_null($row_rssal["out1"]) == false) {
                    $rtxover60 = number_format($row_rssal["out1"], 2, ".", ",");
                }
            }

            $ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td width=\"200\"><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutREtAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutpDAMT, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Over 60 Outstandings\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . $rtxover60 . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt + $OutREtAmt + $OutpDAMT + $pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table_acc>";

            $ResponseXML .= "<OutInvAmt><![CDATA[" . $OutInvAmt . "]]></OutInvAmt>";
            $ResponseXML .= "<OutREtAmt><![CDATA[" . $OutREtAmt . "]]></OutREtAmt>";
            $ResponseXML .= "<OutpDAMT><![CDATA[" . $OutpDAMT . "]]></OutpDAMT>";

            $sqlbrtrn = mysqli_query($GLOBALS['dbinv'], "select * from br_trn where Rep='" . trim($salesrep) . "' and brand='" . $InvClass . "' and cus_code='" . trim($cuscode) . "' ") or die(mysqli_error());
            if ($rowsbrtrn = mysqli_fetch_array($sqlbrtrn)) {
                if (is_null($rowsbrtrn["credit_lim"]) == false) {
                    $crLmt = $rowsbrtrn["credit_lim"];
                } else {
                    $crLmt = 0;
                }

                if (is_null($rowsbrtrn["tmpLmt"]) == false) {
                    $tmpLmt = $rowsbrtrn["tmpLmt"];
                } else {
                    $tmpLmt = 0;
                }

                if (is_null($rowsbrtrn["CAT"]) == false) {
                    $cuscat = $rowsbrtrn["CAT"];
                }
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

                $txt_crebal = number_format($crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set, 2, ".", ",");

                $ResponseXML .= "<txt_crelimi><![CDATA[" . $txt_crelimi . "]]></txt_crelimi>";
                $ResponseXML .= "<txt_crebal><![CDATA[" . $txt_crebal . "]]></txt_crebal>";
            } else {
                $ResponseXML .= "<txt_crelimi><![CDATA[0.00]]></txt_crelimi>";
                $ResponseXML .= "<txt_crebal><![CDATA[0.00]]></txt_crebal>";
            }

            $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;

            $ResponseXML .= "<creditbalance><![CDATA[" . number_format($creditbalance, 2, ".", ",") . "]]></creditbalance>";

            //echo "select dis from brand_mas where barnd_name = '".trim($brand)."'";
            $sql = mysqli_query($GLOBALS['dbinv'], "select dis from brand_mas where barnd_name = '" . trim($brand) . "'") or die(mysqli_error());
            if ($row = mysqli_fetch_array($sql)) {
                $ResponseXML .= "<dis><![CDATA[" . $row["dis"] . "]]></dis>";
            }
        }
    } else {

        $sqlxl = mysqli_query($GLOBALS['dbinv'], "Select * from s_quomas1 where REF_NO='" . $inv . "'") or die(mysqli_error());
        $row_xl = mysqli_fetch_array($sqlxl);

        $sql_invpara = mysqli_query($GLOBALS['dbinv'], "SELECT * from invpara") or die(mysqli_error());
        $row_invpara = mysqli_fetch_array($sql_invpara);

        $sql_vat = mysqli_query($GLOBALS['dbinv'], "SELECT * from vatrate where sdate<='" . $row_xl["SDATE"] . "' order by sdate desc") or die(mysqli_error());
        $row_vat = mysqli_fetch_array($sql_vat);

        $vatrate = $row_vat["vatrate"] / 100;


        $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_quomas1 where REF_NO='" . $inv . "'") or die(mysqli_error());
        $_SESSION["tmp_no_ord"] = $inv;
        if ($row = mysqli_fetch_array($sql)) {
            $cuscode = $row['C_CODE'];
            $ResponseXML .= "<str_invoiceno><![CDATA[" . $row['REF_NO'] . "]]></str_invoiceno>";
            $ResponseXML .= "<str_crecash><![CDATA[CR]]></str_crecash>";
            $ResponseXML .= "<sdate><![CDATA[" . $row['SDATE'] . "]]></sdate>";
            $orddate = $row['SDATE'];
            $cuscode = $row['C_CODE'];
            $ResponseXML .= "<str_customecode><![CDATA[" . $row['C_CODE'] . "]]></str_customecode>";
            $_SESSION["tmp_no_ord"] = $row['REF_NO'];
            //echo "Select * from vendor where CODE='".$row['C_CODE']."'";
            $sqlcustomer = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $row['C_CODE'] . "'") or die(mysqli_error());
            if ($rowcustomer = mysqli_fetch_array($sqlcustomer)) {
                $ResponseXML .= "<str_customername><![CDATA[" . $rowcustomer['NAME'] . "]]></str_customername>";
                $ResponseXML .= "<str_address><![CDATA[" . $rowcustomer['ADD1'] . " " . $rowcustomer['ADD2'] . "]]></str_address>";
                $ResponseXML .= "<str_vatno1><![CDATA[" . $rowcustomer['vatno'] . "]]></str_vatno1>";
                $ResponseXML .= "<str_vatno2><![CDATA[" . $rowcustomer['svatno'] . "]]></str_vatno2>";
            }


            $ResponseXML .= "<str_salesrep><![CDATA[" . $row['SAL_EX'] . "]]></str_salesrep>";
            $salesrep = $row['SAL_EX'];

            $ResponseXML .= "<dte_deliverdate><![CDATA[]]></dte_deliverdate>";


            $ResponseXML .= "<dis><![CDATA[" . $row['DIS'] . "]]></dis>";
            $ResponseXML .= "<dis1><![CDATA[0]]></dis1>";
            $ResponseXML .= "<dis2><![CDATA[0]]></dis2>";

            $ResponseXML .= "<str_department><![CDATA[" . $row['DEPARTMENT'] . "]]></str_department>";
            $department = 1;
            $_SESSION["department"] = $department;

            $ResponseXML .= "<str_brand><![CDATA[" . $row['Brand'] . "]]></str_brand>";
            $brand = $row['Brand'];
            $_SESSION["brand"] = $brand;

            $ResponseXML .= "<str_vat><![CDATA[" . $row['VAT'] . "]]></str_vat>";
            $mvat = $row['VAT'];

            if ($mvat != 0) {
                $mtot = $row['GRAND_TOT'] / (1 + $vatrate);
                $mtot1 = $row['AMOUNT'] / (1 + $vatrate);
                $mtax = $row['GRAND_TOT'] - $mtot;
            } else {
                $mtot = $row['GRAND_TOT'];
                $mtot1 = $row['AMOUNT'];
                $mtax = 0;
            }


            $ResponseXML .= "<cur_subtotal><![CDATA[" . number_format($mtot, 2, ".", ",") . "]]></cur_subtotal>";
            $ResponseXML .= "<cur_discount><![CDATA[" . number_format(($mtot1 - $mtot), 2, ".", ",") . "]]></cur_discount>";
            $ResponseXML .= "<cur_tax><![CDATA[" . number_format($mtax, 2, ".", ",") . "]]></cur_tax>";
            $ResponseXML .= "<cur_invoiceval><![CDATA[" . number_format($row['GRAND_TOT'], 2, ".", ",") . "]]></cur_invoiceval>";
        }

        $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"50\"  background=\"\" ><font color=\"#FFFFFF\">ID</font></td>
							  <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate With VAT</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
							  <td></td>
							  <td width=\"70\">Qty In Hand</td>
							  
                            </tr>";


        $sql_data = mysqli_query($GLOBALS['dbinv'], "delete from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "'") or die(mysqli_error());

        $sql_data = mysqli_query($GLOBALS['dbinv'], "Select * from s_quotrn1 where REF_NO='" . $inv . "'") or die(mysqli_error());
        $mdis = $row['DIS'];
        while ($row = mysqli_fetch_array($sql_data)) {

            $sql_itdata = mysqli_query($GLOBALS['dbinv'], "Select * from s_mas where STK_NO='" . $row['STK_NO'] . "' and BRAND_NAME='" . $brand . "'") or die(mysqli_error());
            $rowit = mysqli_fetch_array($sql_itdata);


            $acrate = $row['PRICE'];
            $mdisv = (($row["PRICE"] * $row["QTY"]) * $mdis / 100);
            $mtot = ($acrate * $row["QTY"]) - $mdisv;

            if ($mvat != 0) {
                $rate = $row['PRICE'] / (1 + $vatrate);
                $mtot = $mtot / (1 + $vatrate);
            } else {
                $rate = $row['PRICE'];
            }




            $sql_tmp = mysqli_query($GLOBALS['dbinv'], "Insert into tmp_ord_data(str_invno, str_code, str_description, cur_rate,actual_selling, cur_qty, dis_per,cur_discount,cur_subtot, brand, tmp_no) values ( '" . $inv . "', '" . $row['STK_NO'] . "', '" . $row['DESCRIPT'] . "'," . $rate . ", " . $acrate . ", " . $row['QTY'] . "," . $mdis . "," . $mdisv . ", " . $mtot . ", '" . $row['BRAND'] . "', '" . $_SESSION["tmp_no_ord"] . "')") or die(mysqli_error());
        }

        $i = 1;
        $sql = "Select * from tmp_ord_data where tmp_no='" . $_SESSION["tmp_no_ord"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {

            $id = "id" . $i;
            $code = "code" . $i;
            $itemd = "itemd" . $i;
            $rate = "rate" . $i;
            $actual_selling = "actual_selling" . $i;
            $qty = "qty" . $i;
            $discountper = "discountper" . $i;
            $subtotal = "subtotal" . $i;
            $discount = "discount" . $i;
            $ad = "ad" . $i;

            $sql_mas = "Select * from s_mas where STK_NO='" . $row['str_code'] . "'";
            $result_mas = mysqli_query($GLOBALS['dbinv'], $sql_mas);
            $row_mas = mysqli_fetch_array($result_mas);

            $ResponseXML .= "<tr>                              
                             <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $id . "'>" . $row['id'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $code . "'>" . $row['str_code'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row_mas["DESCRIPT"] . "</div></td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $rate . "\" id=\"" . $rate . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" /></td>
							  <td align=right ><input type=\"text\"  class=\"text_purchase3\" name=\"" . $actual_selling . "\" id=\"" . $actual_selling . "\" size=\"15\"  value=\"" . number_format($row['actual_selling'], 2, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"   /></td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $qty . "\" id=\"" . $qty . "\" size=\"15\"  value=\"" . number_format($row['cur_qty'], 0, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $discountper . "'>" . $row['dis_per'] . "</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"" . $discount . "\" id=\"" . $discount . "\" size=\"15\"  value=\"" . number_format($row['cur_rate'], 2, ".", ",") . "\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $subtotal . "'>" . number_format($row['cur_subtot'], 2, ".", ",") . "</div></td>
							
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['id'] . "');\"></td>";

            // include_once("connectioni.php");
            $sqlqty = "select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $_GET["department"] . "'";
            $resultqty = mysqli_query($GLOBALS['dbinv'], $sqlqty);

            // $sqlqty = mysqli_query($GLOBALS['dbinv'],"select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysqli_error());
            if ($rowqty = mysqli_fetch_array($resultqty)) {
                $qty = number_format($rowqty['QTYINHAND'], 0, ".", ",");
            } else {
                $qty = 0;
            }

            /* if ($row['ad']=="1"){
              $ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."' checked></td>";
              } else {
              $ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>";
              } */

            $ResponseXML .= "<td  >" . $qty . "</td>
						
							
							 
                            </tr>";
            $i = $i + 1;
        }


        $ResponseXML .= "   </table>]]></sales_table>";


        $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $cuscode . "'") or die(mysqli_error());
        if ($row = mysqli_fetch_array($sql)) {

            $OldRefno = "";
            $NewRefNo = "";

            $sql1 = mysqli_query($GLOBALS['dbinv'], "SELECT  * From ref_history WHERE NewRefNo = '" . $salesrep . "'") or die(mysqli_error());
            if ($row1 = mysqli_fetch_array($sql1)) {
                $OldRefno = trim($row1["OldRefno"]);
                $NewRefNo = trim($row1["NewRefNo"]);
            }

            $OutpDAMT = 0;
            $OutREtAmt = 0;
            $OutInvAmt = 0;

            $sql1 = mysqli_query($GLOBALS['dbinv'], "select * from brand_mas where barnd_name='" . trim($brand) . "'") or die(mysqli_error());

            if ($row1 = mysqli_fetch_array($sql1)) {
                if (is_null($row1["class"]) == false) {
                    $InvClass = trim($row1["class"]);
                }
                $ResponseXML .= "<dis><![CDATA[" . $row1["dis"] . "]]></dis>";
            }

            if ($NewRefNo == $salesrep) {
                $sqlview = mysqli_query($GLOBALS['dbinv'], "select sum(grand_tot-totpay) as totout from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='" . trim($cuscode) . "' and (sal_ex='" . $OldRefno . "' or sal_ex='" . trim($salesrep) . "') and class='" . $InvClass . "'") or die(mysqli_error());
            } else {
                $sqlview = mysqli_query($GLOBALS['dbinv'], "select sum(grand_tot-totpay) as totout from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='" . trim($cuscode) . "' and sal_ex='" . trim($salesrep) . "' and class='" . $InvClass . "'") or die(mysqli_error());
            }

            $rowview = mysqli_fetch_array($sqlview);
            if (is_null($rowview["totout"]) == false) {
                $OutInvAmt = $rowview["totout"];
            }

            $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM s_invcheq WHERE che_date>'" . $orddate . "' AND cus_code='" . trim($cuscode) . "' and trn_type='REC' and sal_ex='" . trim($salesrep) . "'") or die(mysqli_error());
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

            $sqlview = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE CHE_DATE >'" . $_GET["invdate"] . "' AND CUS_CODE='" . trim($cuscode) . "' and trn_type='RET'") or die(mysqli_error());
            $rowsview = mysqli_fetch_array($sqlview);
            if (is_null($rowsview["che_amount"]) == false) {
                $pend_ret_set = $rowsview["che_amount"];
            }

            if ($NewRefNo == $salesrep) {

                $sqlcheq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and (S_REF='" . $salesrep . "' or S_REF='" . $OldRefno . "') ") or die(mysqli_error());
            } else {

                $sqlcheq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='" . $salesrep . "' ") or die(mysqli_error());
            }
            $rowscheq = mysqli_fetch_array($sqlcheq);
            if (is_null($rowscheq["tot"]) == false) {
                $OutREtAmt = $rowscheq["tot"];
            } else {
                $OutREtAmt = 0;
            }

            $d = date("Y-m-d");

            $date = date('Y-m-d', strtotime($d . ' -60 days'));

            $sql_rssal = mysqli_query($GLOBALS['dbinv'], "Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where C_CODE = '" . trim($cuscode) . "' and (SDATE < '" . $date . "') and GRAND_TOT - TOTPAY > 1 and CANCELL = '0'") or die(mysqli_error());

            if ($row_rssal = mysqli_fetch_array($sql_rssal)) {

                if (is_null($row_rssal["out1"]) == false) {
                    $rtxover60 = number_format($row_rssal["out1"], 2, ".", ",");
                }
            }

            $ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td width=\"200\"><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutREtAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutpDAMT, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Over 60 Outstandings\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . $rtxover60 . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt + $OutREtAmt + $OutpDAMT + $pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table_acc>";

            $ResponseXML .= "<OutInvAmt><![CDATA[" . $OutInvAmt . "]]></OutInvAmt>";
            $ResponseXML .= "<OutREtAmt><![CDATA[" . $OutREtAmt . "]]></OutREtAmt>";
            $ResponseXML .= "<OutpDAMT><![CDATA[" . $OutpDAMT . "]]></OutpDAMT>";

            $sqlbrtrn = mysqli_query($GLOBALS['dbinv'], "select * from br_trn where Rep='" . trim($salesrep) . "' and brand='" . $InvClass . "' and cus_code='" . trim($cuscode) . "' ") or die(mysqli_error());
            if ($rowsbrtrn = mysqli_fetch_array($sqlbrtrn)) {
                if (is_null($rowsbrtrn["credit_lim"]) == false) {
                    $crLmt = $rowsbrtrn["credit_lim"];
                } else {
                    $crLmt = 0;
                }

                if (is_null($rowsbrtrn["tmpLmt"]) == false) {
                    $tmpLmt = $rowsbrtrn["tmpLmt"];
                } else {
                    $tmpLmt = 0;
                }

                if (is_null($rowsbrtrn["CAT"]) == false) {
                    $cuscat = $rowsbrtrn["CAT"];
                }
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

                $txt_crebal = number_format($crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set, 2, ".", ",");

                $ResponseXML .= "<txt_crelimi><![CDATA[" . $txt_crelimi . "]]></txt_crelimi>";
                $ResponseXML .= "<txt_crebal><![CDATA[" . $txt_crebal . "]]></txt_crebal>";
            } else {
                $ResponseXML .= "<txt_crelimi><![CDATA[0.00]]></txt_crelimi>";
                $ResponseXML .= "<txt_crebal><![CDATA[0.00]]></txt_crebal>";
            }

            $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;

            $ResponseXML .= "<creditbalance><![CDATA[" . number_format($creditbalance, 2, ".", ",") . "]]></creditbalance>";
        }
    }

    $ResponseXML .= "</salesdetails>";

    $_SESSION["print"] = 1;

    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_invno_to_inv") {

    if ($_SESSION["tmp_no_salinv"] == "") {
        exit("Please click New again!!!");
    }

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $brand = "";
    $salrep = "";
    $cuscode = "";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<stname><![CDATA[" . $_GET["stname"] . "]]></stname>";
    $inv = $_GET['invno'];
    $_SESSION["invno"] = $_GET['invno'];
    $_SESSION["salesord1"] = $_GET['invno'];

    $sqlxl = mysqli_query($GLOBALS['dbinv'], "Select * from s_cusordmas where REF_NO='" . $inv . "'") or die(mysqli_error());
    $row_xl = mysqli_fetch_array($sqlxl);

    $sql_invpara = mysqli_query($GLOBALS['dbinv'], "SELECT * from invpara") or die(mysqli_error());
    $row_invpara = mysqli_fetch_array($sql_invpara);

    $sql_vat = mysqli_query($GLOBALS['dbinv'], "SELECT * from vatrate where sdate<='" . $row_xl["SDATE"] . "' order by sdate desc") or die(mysqli_error());
    $row_vat = mysqli_fetch_array($sql_vat);

    $vatrate = $row_vat["vatrate"] / 100;

    $vatmethod = "";

    if ($_SESSION['company'] == "THT") {

        $sql = mysqli_query($GLOBALS['dbinv'], "Select SPINV from tmpinvpara") or die(mysqli_error());

        $row = mysqli_fetch_array($sql);

        $sql = mysqli_query($GLOBALS['dbinv'], "delete from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'") or die(mysqli_error());

        $sql = mysqli_query($GLOBALS['dbinv'], "update tmpinvpara set SPINV=SPINV+1") or die(mysqli_error());

        $sql = mysqli_query($GLOBALS['dbinv'], "Select SPINV, CRE_INV_NO, CAS_INV_NO from invpara") or die(mysqli_error());

        $rown = mysqli_fetch_array($sql);
    }

    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_cusordmas where REF_NO='" . $inv . "'") or die(mysqli_error());

    if ($row = mysqli_fetch_array($sql)) {
        $SAL_EX = $row['SAL_EX'];
        $tmpinvno = "000000" . ($rown["SPINV"] + 1);
        $lenth = strlen($tmpinvno);

        $invno = trim("CRI/ ") . substr($tmpinvno, $lenth - 6) . "/" . $SAL_EX;
        $_SESSION["invno"] = $invno;
        $txtdono = $rown["CRE_INV_NO"] + 1;
        $ResponseXML .= "<str_order_no><![CDATA[" . $inv . "]]></str_order_no>";
        $ResponseXML .= "<Result><![CDATA[" . $row["Result"] . "]]></Result>";
        $ResponseXML .= "<str_invoiceno><![CDATA[" . $invno . "]]></str_invoiceno>";
        $ResponseXML .= "<str_crecash><![CDATA[" . $row['TYPE'] . "]]></str_crecash>";
        $ResponseXML .= "<sdate><![CDATA[" . $row['SDATE'] . "]]></sdate>";
        $cuscode = $row['C_CODE'];
        $ResponseXML .= "<str_customecode><![CDATA[" . $row['C_CODE'] . "]]></str_customecode>";

        if (trim($row['VAT']) == "0") {
            $ResponseXML .= "<str_vat><![CDATA[0]]></str_vat>";
            $vatmethod = "0";
        }
        if (trim($row['VAT']) == "1") {
            $ResponseXML .= "<str_vat><![CDATA[1]]></str_vat>";
            $vatmethod = "1";
        }
        if (trim($row['VAT']) == "2") {
            $ResponseXML .= "<str_vat><![CDATA[2]]></str_vat>";
            $vatmethod = "2";
        }
        if (trim($row['VAT']) == "3") {
            $ResponseXML .= "<str_vat><![CDATA[3]]></str_vat>";
            $vatmethod = "3";
        }

        $_SESSION["custno"] = $row['C_CODE'];
        //$_SESSION["tmp_no_salinv"]= $row['tmp_no'];
        //	echo "Select * from vendor where CODE='".$row['C_CODE']."'";
        $sqlcustomer = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $row['C_CODE'] . "'") or die(mysqli_error());
        if ($rowcustomer = mysqli_fetch_array($sqlcustomer)) {
            $sql = "select * from vender_sub where c_code = '" . $row["c_code1"] . "'";
            $result_1 = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row_1 = mysqli_fetch_array($result_1)) {
                $ResponseXML .= "<str_customername><![CDATA[" . trim($row_1['c_name']) . "]]></str_customername>";
                $address = trim($row_1['c_add']) . ",  " . trim($row_1['c_add1']);
                $ResponseXML .= "<str_address><![CDATA[" . trim($address) . "]]></str_address>";
                $ResponseXML .= "<str_address2>.</str_address2>";
                $ResponseXML .= "<str_vatno1><![CDATA[" . trim($row_1["c_vatno"]) . "]]></str_vatno1>";
                $ResponseXML .= "<str_vatno2><![CDATA[" . trim($row_1["c_svatno"]) . "]]></str_vatno2>";
                $ResponseXML .= "<cur_balance>0</cur_balance>";
            } else {
                $ResponseXML .= "<str_customername><![CDATA[" . trim($rowcustomer['NAME']) . "]]></str_customername>";
                $ResponseXML .= "<str_address><![CDATA[" . trim($rowcustomer['ADD1']) . "]]></str_address>";
                $ResponseXML .= "<str_address2><![CDATA[" . trim($rowcustomer['ADD2']) . "]]></str_address2>";
                $ResponseXML .= "<str_vatno1><![CDATA[" . trim($rowcustomer['vatno']) . "]]></str_vatno1>";
                $ResponseXML .= "<str_vatno2><![CDATA[" . trim($rowcustomer['svatno']) . "]]></str_vatno2>";
                $ResponseXML .= "<cur_balance>0</cur_balance>";
            }
        }
        $ResponseXML .= "<c_subcode><![CDATA[" . $row['c_code1'] . "]]></c_subcode>";
        $ResponseXML .= "<str_salesrep><![CDATA[" . $row['SAL_EX'] . "]]></str_salesrep>";
        $salrep = $row['SAL_EX'];

        $ResponseXML .= "<dte_deliverdate><![CDATA[" . $row['REQ_DATE'] . "]]></dte_deliverdate>";

        $ResponseXML .= "<dis><![CDATA[" . $row['DIS'] . "]]></dis>";
        $ResponseXML .= "<dis1><![CDATA[" . $row['DIS1'] . "]]></dis1>";
        $ResponseXML .= "<dis2><![CDATA[" . $row['DIS2'] . "]]></dis2>";

        $ResponseXML .= "<str_department><![CDATA[" . $row['DEPARTMENT'] . "]]></str_department>";
        $department = $row['DEPARTMENT'];
        $_SESSION["department"] = $row['DEPARTMENT'];
        $ResponseXML .= "<str_brand><![CDATA[" . $row['Brand'] . "]]></str_brand>";
        $_SESSION["brand"] = $row['Brand'];
        $brand = $row['Brand'];
    }

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"50\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">ID</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate With VAT</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							  <td></td>
							  <td width=\"50\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">AD</font></td>
							  <td width=\"70\">Qty In Hand</td>
                            </tr>";

    $i = 1;

    $sql_data = mysqli_query($GLOBALS['dbinv'], "delete from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'") or die(mysqli_error());

    $sql_data = mysqli_query($GLOBALS['dbinv'], "Select * from s_cusordtrn where REF_NO='" . $inv . "'") or die(mysqli_error());
    while ($row = mysqli_fetch_array($sql_data)) {

        if ($vatmethod == "0") {
            $actual_rate = $row['PRICE'];
        } else {
            $actual_rate = $row['PRICE'] * ($vatrate + 1);
        }

        $SELLING = $row['PRICE'];

        $dis_val = $SELLING * $row['QTY'] * $row['DIS_per'] / 100;
        $usr[] = "( '" . $_GET["newinvno"] . "', '" . $row['STK_NO'] . "', '" . $row['DESCRIPT'] . "', " . $SELLING . ", " . $row['QTY'] . ", " . $row['DIS_per'] . ", " . $dis_val . ", " . (($SELLING * $row['QTY']) - $dis_val) . ", '" . $row['BRAND'] . "', " . $actual_rate . ", '0', '" . $_SESSION["tmp_no_salinv"] . "')";
    }

    $sql_tmp = mysqli_query($GLOBALS['dbinv'], "Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand, actual_selling, ad, tmp_no) values " . implode($usr, ","));

    $i = 1;
    $cur_subtot = 0;
    $cur_discount = 0;
    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "' order by id") or die(mysqli_error());
    while ($row = mysqli_fetch_array($sql)) {

        $id = "id" . $i;
        $code = "code" . $i;
        $itemd = "itemd" . $i;
        $rate = "rate" . $i;
        $actual_selling = "actual_selling" . $i;
        $qty = "qty" . $i;
        $discountper = "discountper" . $i;
        $subtotal = "subtotal" . $i;
        $discount = "discount" . $i;
        $ad = "ad" . $i;

        $sql_mas = mysqli_query($GLOBALS['dbinv'], "Select * from s_mas where STK_NO='" . $row['str_code'] . "' and BRAND_NAME='" . $brand . "'") or die(mysqli_error());

        $rowmas = mysqli_fetch_array($sql_mas);

        $SELLING = $rowmas['SELLING'];

        if ($vatmethod == "0") {
            $rate_amt = $rowmas['SELLING'];
        } else {
            $rate_amt = $rowmas['SELLING'] / ($vatrate + 1);
        }

        $ResponseXML .= "<tr>  
				             <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $id . "'>" . $row['id'] . "</div></td>                             <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $code . "'>" . $row['str_code'] . "</div></td>
							 <td onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $itemd . "'>" . $row['str_description'] . "</div></td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $rate . "\" id=\"" . $rate . "\" size=\"15\"  value=\"" . number_format($rate_amt, 2, ".", ",") . "\"  disable  onkeypress=\"keyset('credper',event);\" /></td>
							 <td align=right ><input type=\"text\"  class=\"text_purchase3\" name=\"" . $actual_selling . "\" id=\"" . $actual_selling . "\" size=\"15\"  value=\"" . number_format($row["actual_selling"], 2, ".", ",") . "\" onblur=\"calc1_table('" . $i . "');\" /></td>
							  <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><input type=\"text\"  class=\"text_purchase3\" name=\"" . $qty . "\" id=\"" . $qty . "\" size=\"15\"  value=\"" . number_format($row['cur_qty'], 0, ".", ",") . "\"  onblur=\"calc1_table('" . $i . "');\"  onkeypress=\"keyset('credper',event);\" />    </td>
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $discountper . "'>" . $row['dis_per'] . "</div><input type=\"hidden\"  class=\"text_purchase3\" name=\"" . $discount . "\" id=\"" . $discount . "\" size=\"15\"  value=\"" . number_format($row['cur_discount'], 2, ".", ",") . "\"    /></td>
							 
							 <td align=right onClick=\"disp_qty('" . $row['str_code'] . "');\"><div id='" . $subtotal . "'>" . number_format($row['cur_subtot'], 2, ".", ",") . "</div></td>";

        $ResponseXML .= "<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['id'] . "');\"></td>";

        if ($row['ad'] == "1") {
            $ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('" . $i . "');\" name='" . $ad . "' id='" . $ad . "' checked></td>";
        } else {
            $ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('" . $i . "');\" name='" . $ad . "' id='" . $ad . "'></td>";
        }

        $sqlqty = mysqli_query($GLOBALS['dbinv'], "select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $department . "'") or die(mysqli_error());
        if ($rowqty = mysqli_fetch_array($sqlqty)) {
            $qty = number_format($rowqty['QTYINHAND'], 0, ".", ",");
        } else {
            $qty = 0;
        }

        $ResponseXML .= "<td  >" . $qty . "</td>";

        $ResponseXML .= "</tr>";

        $cur_subtot = $cur_subtot + $row['cur_subtot'];
        $cur_discount = $cur_discount + $row['cur_discount'];

        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

    $ResponseXML .= "<cur_subtotal><![CDATA[" . number_format($cur_subtot, 2, ".", ",") . "]]></cur_subtotal>";
    $ResponseXML .= "<cur_discount><![CDATA[" . number_format($cur_discount, 2, ".", ",") . "]]></cur_discount>";

    $vatrate = $row_vat["vatrate"] / 100;

    if (($vatmethod == "1") or ( $vatmethod == "2") or ( $vatmethod == "3")) {
        $tax = $cur_subtot * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<cur_tax><![CDATA[" . $taxf . "]]></cur_tax>";
        $invtot = number_format($cur_subtot + $tax, 2, ".", ",");
        $ResponseXML .= "<cur_invoiceval><![CDATA[" . $invtot . "]]></cur_invoiceval>";
    } else {
        $ResponseXML .= "<cur_tax><![CDATA[0.00]]></cur_tax>";
        $invtot = number_format($cur_subtot, 2, ".", ",");
        $ResponseXML .= "<cur_invoiceval><![CDATA[" . $invtot . "]]></cur_invoiceval>";
    }

    $RET_AMOUNT = 0;
    $PD_AMOUNT = 0;
    $OUT_AMOUNT = 0;

    $sql = mysqli_query($GLOBALS['dbinv'], "select * from vendor where CODE = '" . trim($cuscode) . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $sqlchq = mysqli_query($GLOBALS['dbinv'], "SELECT che_amount FROM s_invcheq WHERE che_date>'" . $_GET["invdate"] . "' AND cus_code='" . $row["CODE"] . "'") or die(mysqli_error());

        while ($rowchq = mysqli_fetch_array($sqlchq)) {
            $PD_AMOUNT = $PD_AMOUNT + $rowchq["che_amount"];
        }

        if (is_null($row["AltMessage"]) == false) {
            if (trim($row["AltMessage"]) != "") {
                $ResponseXML .= "<AltMessage><![CDATA[" . $row['AltMessage'] . "]]></AltMessage>";
            } else {
                $ResponseXML .= "<AltMessage><![CDATA[]]></AltMessage>";
            }
        } else {
            $ResponseXML .= "<AltMessage><![CDATA[]]></AltMessage>";
        }

        if ($row["chk_bangr"] == "1") {

            $dateDiff = $row["bank_gr_date"] - $_GET["invdate"];
            $m_dates = floor($dateDiff / (60 * 60 * 24));
            if ($m_dates > 30 and $m_dates < 60) {
                $ResponseXML .= "<bank_message><![CDATA[Please Re-New Bank Grantee Date]]></bank_message>";
                $_SESSION["inv_status"] = 0;
            } else if ($m_dates <= 30) {
                $ResponseXML .= "<bank_message><![CDATA[No Permission For Invoice For This Customer Please Re-New Bank Grantee Date]]></bank_message>";
                $_SESSION["inv_status"] = 0;
            }
        } else {
            $ResponseXML .= "<bank_message><![CDATA[]]></bank_message>";
        }

        $adddate = date('Y-m-d', strtotime("-60 days"));
        $sql60 = mysqli_query($GLOBALS['dbinv'], "select SDATE from  s_salma where  C_CODE='" . trim($cuscode) . "' and GRAND_TOT-TOTPAY >1 and CANCELL=0 and sdate <='" . $adddate . "' order by SDATE") or die(mysqli_error());
        if ($row60 = mysqli_fetch_array($sql60)) {

            $_SESSION["inv_status"] = "0";
            if (is_null($row["Over_DUE_IG_Date"]) == false) {

                if (strtotime($row["Over_DUE_IG_Date"]) != strtotime(date("Y-m-d"))) {
                    $ResponseXML .= "<over60_qst><![CDATA[No Permission For Invoice For This Customer Please Re-New LIMIT Grantee Date]]></over60_qst>";
                    $ResponseXML .= "<over60_message><![CDATA[Over 60 Outsnding Avilabale]]></over60_message>";
                    $ResponseXML .= "<over60_txt><![CDATA[60]]></over60_txt>";

                    //$sqltmpCrLmt = mysqli_query($GLOBALS['dbinv'], "insert into tmpcrlmt (sdate, stime, tmpLmt, Class, Rep,cuscode, crLmt,  FLAG) values ('" . $_GET["invdate"] . "','" . date("h:i:s") . "' , " . $mdays . " ,'NB','NR','" . trim($cuscode) . "','0', 'O60')") or die(mysqli_error());
                } else {

                    $ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
                    $ResponseXML .= "<over60_message><![CDATA[]]></over60_message>";
                    $ResponseXML .= "<over60_txt><![CDATA[0]]></over60_txt>";
                }
            } else {
                $ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
                $ResponseXML .= "<over60_message><![CDATA[]]></over60_message>";
                $ResponseXML .= "<over60_txt><![CDATA[0]]></over60_txt>";
            }
        } else {
            $ResponseXML .= "<over60_message><![CDATA[]]></over60_message>";
            $ResponseXML .= "<over60_qst><![CDATA[]]></over60_qst>";
            $ResponseXML .= "<over60_txt><![CDATA[0]]></over60_txt>";
        }

        $sqls_cheq = mysqli_query($GLOBALS['dbinv'], "Select * from s_cheq where CR_CHEVAL-PAID>5 and CR_FLAG='0' and CR_C_CODE='" . trim($cuscode) . "'") or die(mysqli_error());
        if ($rows_cheq = mysqli_fetch_array($sqls_cheq)) {
            $ResponseXML .= "<chq_message><![CDATA[Return Cheque]]></chq_message>";
            $_SESSION["inv_status"] = 0;
            if (is_null($row["Over_DUE_IG_Date"]) == false) {
                if ($row["Over_DUE_IG_Date"] == date("Y-m-d")) {
                    $ResponseXML .= "<chq_message_que><![CDATA[Do You Want To Continue with Return Cheques]]></chq_message_que>";
                    $sqltmpCrLmt = mysqli_query($GLOBALS['dbinv'], "insert into tmpcrlmt (sdate, stime, tmpLmt, Class, Rep,cuscode, crLmt, FLAG) values ('" . $_GET["invdate"] . "', '" . date("h:i:s") . "', '0' ,'NB','NR','" . trim($cuscode) . "','0', 'RTN')") or die(mysqli_error());
                } else {
                    $ResponseXML .= "<chq_message_que><![CDATA[]]></chq_message_que>";
                }
            }
        } else {
            $ResponseXML .= "<chq_message><![CDATA[]]></chq_message>";
            $ResponseXML .= "<chq_message_que><![CDATA[]]></chq_message_que>";
        }

        if (is_null($row["CUR_BAL"]) == false) {
            $OUT_AMOUNT = $row["CUR_BAL"];
        }

        if (is_null($row["CAT"]) == false) {
            $cuscat = $row["CAT"];
        }

        $sqlretchq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-PAID) as CR_CHEVAL  from s_cheq where CR_C_CODE='" . trim($cuscode) . "' and CR_CHEVAL-PAID>0 and CR_FLAG='0'") or die(mysqli_error());
        while ($rowretchq = mysqli_fetch_array($sqlretchq)) {
            $RET_AMOUNT = $RET_AMOUNT + $rowretchq["CR_CHEVAL"];
        }
    }

    //Call SETLIMIT ====================================================================

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

    $sqloutinv = mysqli_query($GLOBALS['dbinv'], "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='" . trim($cuscode) . "' and SAL_EX='" . trim($salrep) . "' and class='" . $InvClass . "'") or die(mysqli_error());
    if ($rowoutinv = mysqli_fetch_array($sqloutinv)) {
        if (is_null($rowoutinv["totout"]) == false) {
            $OutInvAmt = $rowoutinv["totout"];
        }
    }

    $rs0 = "Select sum(ST_PAID) as out1 from view_sinvcheq_sttr_salma1  where che_date >  '" . $_GET["invdate"] . "' and C_CODE='" . trim($cuscode) . "' and SAL_EX = '" . trim($salrep) . "' and class = '" . $InvClass . "'  ";
    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], $rs0);
    while ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {
        $OutpDAMT = $OutpDAMT + $rowinvcheq["out1"];
    }

    $pend_ret_set = 0;
    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'" . $_GET["invdate"] . "' AND cus_code='" . trim($cuscode) . "' and trn_type='RET'") or die(mysqli_error());
    if ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {
        if (is_null($rowinvcheq["che_amount"]) == false) {
            $pend_ret_set = $rowinvcheq["che_amount"];
        }
    }

    $sqlcheq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>5 and CR_FLAG='0' and S_REF='" . trim($salrep) . "'") or die(mysqli_error());
    if ($rowcheq = mysqli_fetch_array($sqlcheq)) {
        if (is_null($rowcheq["tot"]) == false) {
            $OutREtAmt = $rowcheq["tot"];
            $ResponseXML .= "<msg_return><![CDATA[Return Cheques Available]]></msg_return>";
        } else {
            $OutREtAmt = 0;
            $ResponseXML .= "<msg_return><![CDATA[]]></msg_return>";
        }
    } else {
        $ResponseXML .= "<msg_return><![CDATA[]]></msg_return>";
    }

    $d = date("Y-m-d");

    $date = date('Y-m-d', strtotime($d . ' -60 days'));
    $rtxover60 = 0;
    $sql_rssal = mysqli_query($GLOBALS['dbinv'], "Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where C_CODE = '" . trim($cuscode) . "' and (SDATE < '" . $date . "') and GRAND_TOT - TOTPAY > 1 and CANCELL = '0'") or die(mysqli_error());

    if ($row_rssal = mysqli_fetch_array($sql_rssal)) {
        if (is_null($row_rssal["out1"]) == false) {
            $rtxover60 = number_format($row_rssal["out1"], 2, ".", ",");
        }
    }

    $ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutREtAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutpDAMT, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Over 60 Outstandings\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . $rtxover60 . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt + $OutREtAmt + $OutpDAMT + $pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table_acc>";

    $sqlbr_trn = mysqli_query($GLOBALS['dbinv'], "select * from br_trn where Rep='" . trim($salrep) . "' and brand='" . trim($InvClass) . "' and cus_code='" . trim($cuscode) . "'") or die(mysqli_error());

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
            $cuscat = trim($rowbr_trn["CAT"]);
            if ($cuscat == "A") {
                $m = 2.5;
            }
            if ($cuscat == "B") {
                $m = 2.5;
            }
            if ($cuscat == "C") {
                $m = 1;
            }
            if ($cuscat == "D") {
                $m = 0;
            }
            $txt_crelimi = "0";
            $txt_crebal = "0";
            $txt_crelimi = number_format($crLmt, 2, ".", ",");
        } else {
            $txt_crelimi = "0";
            $txt_crebal = "0";
        }

        $crebal = $crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
        $txt_crebal = $crLmt * $m - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
        $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
    }
    $ResponseXML .= "<txt_crelimi><![CDATA[" . $txt_crelimi . "]]></txt_crelimi>";
    $ResponseXML .= "<txt_crebal><![CDATA[" . $txt_crebal . "]]></txt_crebal>";
    $ResponseXML .= "<crebal><![CDATA[" . $crebal . "]]></crebal>";
    $ResponseXML .= "<creditbalance><![CDATA[" . number_format($txt_crebal, "2", ".", ",") . "]]></creditbalance>";

    $invqty = 0;
    $rtnqty = 0;
    $Mon = date("m", strtotime(date("Y-m-d")));
    $Yer = date("Y", strtotime(date("Y-m-d")));
    $sql_inv = "Select sum(Qty) as totQty from viewinv where  Cus_CODE = '" . trim($cuscode) . "' and s_Brand = '" . $brand . "' and month(SDATE) = '" . $Mon . "' and year(SDATE) = '" . $Yer . "' and cancel_m = '0' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'L0531' AND stk_no <> 'T3520' AND stk_no <> 'T3522' and stk_no <> 'A0356' and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003' and dis_per <> 100";
    $sql_grn = " Select sum(Qty) as totQty from viewcrntrn where  C_CODE = '" . trim($cuscode) . "' and Brand = '" . $brand . "' and month(SDATE) = '" . $Mon . "' and year(SDATE) = '" . $Yer . "' and cancell = '0' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'L0531' AND stk_no <> 'T3520' AND stk_no <> 'T3522' and stk_no <> 'A0356' ";

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

    $ResponseXML .= "<netqty><![CDATA[" . $netqty . "]]></netqty>";

    $ResponseXML .= "</salesdetails>";

    $_SESSION["print"] = 1;
    echo $ResponseXML;
}

if ($_GET["Command"] == "assign_brand") {
    $_SESSION["brand"] = $_GET["brand"];
    //echo $_SESSION["brand"];

    $sql = mysqli_query($GLOBALS['dbinv'], "DROP VIEW view_s_salma") or die(mysqli_error());

    $sql = mysqli_query($GLOBALS['dbinv'], "CREATE VIEW view_s_salma
AS
SELECT     s_salma.*, brand_mas.class AS class
FROM         brand_mas RIGHT OUTER JOIN
                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysqli_error());

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $OutpDAMT = 0;
    $OutREtAmt = 0;
    $OutInvAmt = 0;

    $InvClass = " ";

    $sql = mysqli_query($GLOBALS['dbinv'], "select class from brand_mas where barnd_name = '" . trim($_GET["brand"]) . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        if (is_null($row["class"]) == false) {
            $InvClass = trim($row["class"]);
        }
    }

    /* If InvClass = "" Then
      MsgBox "Brand master file not complete"
      Exit Sub
      End If */

    if ($InvClass != "") {
        $cmbrep = trim(substr($_GET["salesrep"], 0, 5));

        $sql = mysqli_query($GLOBALS['dbinv'], "select sum(grand_tot-totpay) as totOut from view_s_salma where grand_tot>totpay and cancell='0' and c_code='" . trim($cuscode) . "' and sal_ex='" . $cmbrep . "' and class='" . $InvClass . "'") or die(mysqli_error());
        if ($row = mysqli_fetch_array($sql)) {

            if (is_null($row["totOut"]) == false) {
                $OutInvAmt = $row["totOut"];
            }
        }

        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM s_invcheq WHERE CHE_DATE>'" . $_GET["invdate"] . "' AND CUS_CODE='" . trim($cuscode) . "' and trn_type='REC' and sal_ex='" . $cmbrep . "'") or die(mysqli_error());
        while ($row = mysqli_fetch_array($sql)) {
            $sql1 = mysqli_query($GLOBALS['dbinv'], "select * from s_sttr where st_refno='" . trim($row["REFNO"]) . "' and st_chno ='" . trim($row["cheque_no"]) . "'") or die(mysqli_error());
            while ($row1 = mysqli_fetch_array($sql1)) {
                $sql2 = mysqli_query($GLOBALS['dbinv'], "select class from view_s_salma where ref_no='" . trim($row["ST_INVONO"]) . "' ") or die(mysqli_error());
                if ($row2 = mysqli_fetch_array($sql2)) {
                    if (trim($row2["Class"]) == $InvClass) {
                        $OutpDAMT = $OutpDAMT + $row1["ST_PAID"];
                    }
                }
            }
        }

        $pend_ret_set = 0;
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE CHE_DATE >'" . $_GET["invdate"] . "' AND CUS_CODE='" . trim($cuscode) . "' and trn_type='RET' ") or die(mysqli_error());
        if ($row = mysqli_fetch_array($sql)) {
            if (is_null($row["che_amount"]) == false) {
                $pend_ret_set = $row["che_amount"];
            }
        }

        /*       $pend_ret_set = 0;
          $sql = mysqli_query($GLOBALS['dbinv'],"SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE CHE_DATE >'".$_GET["invdate"]."' AND CUS_CODE='".trim(txt_cuscode)."' and trn_type='RET' ") or die(mysqli_error());
          if ($row = mysqli_fetch_array($sql)){

          if (is_null($row["che_amount"]==false))
          {
          $pend_ret_set = $row["che_amount"];
          }
          } */

        $sql = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='" . trim(txt_cuscode) . "'  and CR_CHEVAL-paid>0 and cr_flag='0' and s_ref='" . trim($cmbrep) . "' ") or die(mysqli_error());
        if ($row = mysqli_fetch_array($sql)) {

            if (is_null($row["tot"] == false)) {
                $OutREtAmt = $row["tot"];
            } else {
                $OutREtAmt = 0;
            }
        }

        $ResponseXML .= "<sales_table><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
						<tr><td>Outstanding Invoice Amount</td><td>" . number_format($OutInvAmt, 2, ".", ",") . "</td></tr>
						 <td>Return Cheqe Amount</td><td>" . number_format($OutREtAmt, 2, ".", ",") . "</td></tr>
						 <td>Pending Cheque Amount</td><td>" . number_format($OutpDAMT, 2, ".", ",") . "</td></tr>
						 <td>PSD Cheque Settlments</td><td>" . number_format($pend_ret_set, 2, ".", ",") . "</td></tr>
						 <td>Total</td><td>" . number_format($OutInvAmt + $OutREtAmt + $OutpDAMT + $pend_ret_set, 2, ".", ",") . "</td></tr>
						 </table></table>]]></sales_table>";

        $sql = mysqli_query($GLOBALS['dbinv'], "select * from br_trn where rep='" . $cmbrep . "' and brand='" . trim($InvClass) . "' and cus_code='" . trim($cuscode) . "' ") or die(mysqli_error());
        if ($row = mysqli_fetch_array($sql)) {

            if (is_null($row["credit_lim"] == false)) {
                $crLmt = $row["credit_lim"];
            } else {
                $crLmt = 0;
            }

            if (is_null($row["tmpLmt"] == false)) {
                $tmpLmt = $row["tmpLmt"];
            } else {
                $tmpLmt = 0;
            }

            if (is_null($row["cat"] == false)) {
                $cuscat = trim($row["cat"]);
            }

            if ($cuscat == "A") {
                $m = 2.5;
            }
            if ($cuscat == "B") {
                $m = 2.5;
            }
            if ($cuscat == "C") {
                $m = 1;
            }

            $txt_crelimi = "0";
            $txt_crebal = "0";
            $txt_crelimi = number_format($crLmt, 2, ".", ",");
            $txt_crebal = number_format($crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set, 2, ".", ",");

            $ResponseXML .= "<txt_crelimi><![CDATA[" . $txt_crelimi . "]]></txt_crelimi>";
            $ResponseXML .= "<txt_crebal><![CDATA[" . $txt_crebal . "]]></txt_crebal>";
        } else {
            $txt_crelimi = "0";
            $txt_crebal = "0";

            $ResponseXML .= "<txt_crelimi><![CDATA[" . $txt_crelimi . "]]></txt_crelimi>";
            $ResponseXML .= "<txt_crebal><![CDATA[" . $txt_crebal . "]]></txt_crebal>";
        }
        $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
        $ResponseXML .= "<creditbalance><![CDATA[" . $creditbalance . "]]></creditbalance>";

        $sql = mysqli_query($GLOBALS['dbinv'], "select dis from brand_mas where barnd_name = '" . trim($_GET["brand"]) . "'") or die(mysqli_error());
        if ($row = mysqli_fetch_array($sql)) {
            $ResponseXML .= "<dis><![CDATA[" . $row["dis"] . "]]></dis>";
        }
        $xx = 1;
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

mysqli_close($GLOBALS['dbinv']);
?>

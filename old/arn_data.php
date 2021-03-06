<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connectioni.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////


if ($_GET["Command"] == "new_inv") {

    $_SESSION["print"] = 0;

    /* 	$sql="Select CAS_INV_NO_m from invpara";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
      $row = mysqli_fetch_array($result);
      $tmpinvno="000000".$row["CAS_INV_NO_m"];
      $lenth=strlen($tmpinvno);
      $invno="INV".substr($tmpinvno, $lenth-7);
      echo $invno; */

    $sql = "Select ARN from invpara";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "000000" . $row["ARN"];
    $lenth = strlen($tmpinvno);
    $invno = trim("ARN/ ") . substr($tmpinvno, $lenth - 8);
    $_SESSION["invno"] = $invno;

    $sql = "Select ARN from tmpinvpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $_SESSION["tmp_no_arn"] = "ARN/" . $row["ARN"];

    $sql1 = "delete from tmp_purord_data where tmp_no='" . $_SESSION["tmp_no_arn"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

    $sql1 = "update tmpinvpara set ARN=ARN+1";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<invdate><![CDATA[" . date('Y-m-d') . "]]></invdate>";
    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "add_tmp") {

    $department = $_GET["department"];

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $sql = "delete from tmp_purord_data where str_code='" . $_GET['itemcode'] . "' and str_invno='" . $_GET['invno'] . "' ";
    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    //echo $_GET['rate'];
    //echo $_GET['qty'];

    $qty = str_replace(",", "", $_GET["qty"]);

    $sql = "Insert into tmp_purord_data (str_invno, str_code, str_description, partno, qty)values 
			('" . $_GET['invno'] . "', '" . $_GET['itemcode'] . "', '" . $_GET['item'] . "', '" . $_GET["partno"] . "', " . $qty . ") ";
    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                             
                            </tr>";

    $sql = "Select * from tmp_purord_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>                              
                             <td  >" . $row['str_code'] . "</a></td>
							 <td  >" . $row['str_description'] . "</a></td>
							 <td  >" . $row['partno'] . "</a></td>
							 <td  >" . number_format($row['qty'], 2, ".", ",") . "</a></td>
							 <td  ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td></tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= " </salesdetails>";

    //	}

    echo $ResponseXML;
}

if ($_GET["Command"] == "arn") {

    //$department=$_GET["department"];

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    $sql = "select * from s_ordmas where REFNO='" . $_GET['invno'] . "' ";
    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<REFNO><![CDATA[" . $row['REFNO'] . "]]></REFNO>";
        $ResponseXML .= "<SDATE><![CDATA[" . $row['SDATE'] . "]]></SDATE>";
        $ResponseXML .= "<SUP_CODE><![CDATA[" . $row['SUP_CODE'] . "]]></SUP_CODE>";
        $ResponseXML .= "<SUP_NAME><![CDATA[" . $row['SUP_NAME'] . "]]></SUP_NAME>";
        $ResponseXML .= "<REMARK><![CDATA[" . $row['REMARK'] . "]]></REMARK>";
        $ResponseXML .= "<DEP_CODE><![CDATA[" . $row['DEP_CODE'] . "]]></DEP_CODE>";
        $ResponseXML .= "<DEP_NAME><![CDATA[" . $row['DEP_NAME'] . "]]></DEP_NAME>";
        $ResponseXML .= "<REP_CODE><![CDATA[" . $row['REP_CODE'] . "]]></REP_CODE>";
        $ResponseXML .= "<REP_NAME><![CDATA[" . $row['REP_NAME'] . "]]></REP_NAME>";
        $ResponseXML .= "<S_date><![CDATA[" . $row['S_date'] . "]]></S_date>";
        $ResponseXML .= "<LC_No><![CDATA[" . $row['LC_No'] . "]]></LC_No>";
        $ResponseXML .= "<pi_no><![CDATA[" . $row['pi_no'] . "]]></pi_no>";
        $ResponseXML .= "<Brand><![CDATA[" . $row['Brand'] . "]]></Brand>";
        $ResponseXML .= "<COUNTRY><![CDATA[" . $row["COUNTRY"] . "]]></COUNTRY>";
    }

    //	$sql="delete from tmp_purord_data where str_invno='".$_GET['invno']."' ";
    //$ResponseXML .= $sql;
    //	$result =mysqli_query($GLOBALS['dbinv'],$sql) ;
    //	$sql="select * from s_ordtrn where REFNO='".$_GET['invno']."' ";
    //$ResponseXML .= $sql;
    //	$result =mysqli_query($GLOBALS['dbinv'],$sql) ;
    //	while($row = mysqli_fetch_array($result)){
    //		$sql1="Insert into tmp_purord_data (str_invno, str_code, str_description, partno, qty)values
    //		('".$row['REFNO']."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', '".$row["partno"]."', ".$row["ORD_QTY"].") ";
    //$ResponseXML .= $sql;
    //		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ;
    //	}

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"200\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"800\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Order CTN</font></td>
                               <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Order CTNQty</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Order Qty</font></td>
                              <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">FOB</font></td>
                                <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">CTN</font></td>
                                <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">CTN Qty</font></td>
                                <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Cost</font></td>
							   <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Selling</font></td>
							    <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Margin</font></td>
								 <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
							
                            </tr>";

    $mcou = 0;
    $sql = "Select count(*) as mcou from s_ordtrn where REFNO='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $mcou = $row["mcou"] + 1;

    $i = 1;
    $sql = "Select * from s_ordtrn where REFNO='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $itemcode = "itemcode" . $i;
        $itemname = "itemname" . $i;
        $ctn = "ctn" . $i;
        $ctnqty = "ctnqty" . $i;
        $ord_qty = "ord_qty" . $i;
        $fob = "fob" . $i;
        $ctn1 = "ctn1" . $i;
        $ctnqty1 = "ctnqty1" . $i;
        $qty = "qty" . $i;
        $cost = "cost" . $i;
        $selling = "selling" . $i;
        $margin = "margin" . $i;
        $subtotal = "subtotal" . $i;

        $sql_selling = "select SELLING from s_mas where STK_NO='" . $row['STK_NO'] . "'";
        $result_selling = mysqli_query($GLOBALS['dbinv'], $sql_selling);
        $row_selling = mysqli_fetch_array($result_selling);

        $ResponseXML .= "<tr>                              
                             <td ><input type=\"text\" size=\"15\" name=" . $itemcode . " id=" . $itemcode . "   value=" . $row['STK_NO'] . " class=\"text_purchase3\" disabled=\"disabled\"/></td>
							  <td ><input type=\"text\" size=\"15\" name=" . $itemname . " id=" . $itemname . "  value='" . $row['DESCRIPT'] . "' class=\"text_purchase3\" disabled=\"disabled\"/></td>
							  <td ><input type=\"text\" size=\"15\" name=" . $ctn . " id=" . $ctn . "  value=" . $row['ctn'] . " class=\"text_purchase3\" disabled=\"disabled\"/></td>
							  <td ><input type=\"text\" size=\"15\" name=" . $ctnqty . " id=" . $ctnqty . "  value=" . $row['ctnqty'] . " class=\"text_purchase3\" disabled=\"disabled\"/></td>
							  <td ><input type=\"text\" size=\"15\" name=" . $ord_qty . " id=" . $ord_qty . "  value=" . $row['ORD_QTY'] . " class=\"text_purchase3\" disabled=\"disabled\"/></td>
							
							 <td ><input type=\"text\" size=\"15\" name=" . $fob . " id=" . $fob . "  class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"15\" name=" . $ctn1 . " id=" . $ctn1 . "  class=\"text_purchase3\" value=" . $row['ctn'] . " onBlur=\"cal_subtot('" . $i . "');\"/></td>
							 <td ><input type=\"text\" size=\"15\" name=" . $ctnqty1 . " id=" . $ctnqty1 . "  class=\"text_purchase3\" value=" . $row['ctnqty'] . " onBlur=\"cal_subtot('" . $i . "');\"/></td>
							 <td ><input type=\"text\" size=\"15\" name=" . $qty . " id=" . $qty . " disabled  class=\"text_purchase3\"  value=" . $row['ORD_QTY'] . "  onBlur=\"cal_subtot('" . $i . "', '" . $mcou . "');\"/></td>
							 <td ><input type=\"text\" size=\"15\" name=" . $cost . " id=" . $cost . "  class=\"text_purchase3\" onBlur=\"cal_subtot('" . $i . "', '" . $mcou . "');\"/></td>
							 <td ><input type=\"text\" size=\"15\" name=" . $selling . " id=" . $selling . " onBlur=\"cal_margine('" . $i . "', '" . $mcou . "');\" value=" . $row_selling['SELLING'] . "  class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"15\" name=" . $margin . " id=" . $margin . "  class=\"text_purchase3\" disabled=\"disabled\"/></td>
							 <td ><input type=\"text\" size=\"15\" name=" . $subtotal . " id=" . $subtotal . "  class=\"text_purchase3\" disabled=\"disabled\"/></td>
							</tr>";
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></sales_table>";
    $ResponseXML .= "<count><![CDATA[" . $i . "]]></count>";
    $ResponseXML .= " </salesdetails>";

    //	}

    echo $ResponseXML;
}

if ($_GET["Command"] == "setord") {

    include_once ("connectioni.php");

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

    $ResponseXML .= "<sales_table_acc><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
						<tr><td>Outstanding Invoice Amount</td><td>" . number_format($OutInvAmt, 2, ".", ",") . "</td></tr>
						 <td>Return Cheque Amount</td><td>" . number_format($OutREtAmt, 2, ".", ",") . "</td></tr>
						 <td>Pending Cheque Amount</td><td>" . number_format($OutpDAMT, 2, ".", ",") . "</td></tr>
						 <td>PSD Cheque Settlments</td><td>" . number_format($pend_ret_set, 2, ".", ",") . "</td></tr>
						 <td>Total</td><td>" . number_format($OutInvAmt + $OutREtAmt + $OutpDAMT + $pend_ret_set, 2, ".", ",") . "</td></tr>
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
            $crebal = $crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            $txt_crebal = number_format($crebal, "2", ".", ",");
        } else {
            $txt_crelimi = "0";
            $txt_crebal = "0";
        }
        $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
    }
    $ResponseXML .= "<txt_crelimi><![CDATA[" . $txt_crelimi . "]]></txt_crelimi>";
    $ResponseXML .= "<txt_crebal><![CDATA[" . $txt_crebal . "]]></txt_crebal>";

    $ResponseXML .= "<creditbalance><![CDATA[" . $creditbalance . "]]></creditbalance>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "del_item") {

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    $sql = "delete from tmp_purord_data where str_code='" . $_GET['code'] . "' and str_invno='" . $_GET['invno'] . "' ";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                            </tr>";

    $sql = "Select * from tmp_purord_data where str_invno='" . $_GET['invno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td  >" . $row['str_code'] . "</a></td>
							 <td  >" . $row['str_description'] . "</a></td>
							 <td  >" . $row['partno'] . "</a></td>
							 <td  >" . $row['qty'] . "</a></td>
							 <td  ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td></tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= " </salesdetails>";

    //	}

    echo $ResponseXML;
}

if ($_GET['Command'] == "update_arstat") {

    $sql = "update s_trn set seri_no='" . $_GET['arpend'] . "' where refno = '" . $_GET['refno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    echo "Updated";
}

if ($_POST["Command"] == "save_item") {
    if ($_SESSION['dev'] == "") {
        exit("logout");
    }

    if ($_POST["count"] > 0) {

        $sql_invpara = "SELECT * from invpara";
        $result_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
        $row_invpara = mysqli_fetch_array($result_invpara);
        
        $sql_vat = "SELECT * from vatrate where sdate<='" . $_POST["invdate"] . "' order by sdate desc";
        $result_vat = mysqli_query($GLOBALS['dbinv'], $sql_vat);
        $row_vat = mysqli_fetch_array($result_vat);

        $vatrate = $row_vat["vatrate"];

        $ResponseXML .= "";
        $ResponseXML .= "<salesdetails>";

        $_SESSION["CURRENT_DOC"] = 1;
        //document ID
        $_SESSION["VIEW_DOC"] = false;
        //view current document
        $_SESSION["FEED_DOC"] = true;
        //save  current document
        $_GET["MOD_DOC"] = false;
        //delete   current document
        $_GET["PRINT_DOC"] = false;
        //get additional print   of  current document
        $_GET["PRICE_EDIT"] = false;
        //edit selling price
        $_GET["CHECK_USER"] = false;
        //check user permission again
        //$cre_balance=str_replace(",", "", $_GET["balance"]);

        $sql = "select * from s_purmas where REFNO='" . $_POST["invno"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        //echo $sql;
        if ($row = mysqli_fetch_array($result)) {
            exit("AR Number Already Exists");
        } else {

            mysqli_query($GLOBALS['dbinv'], "SET AUTOCOMMIT=0");
            mysqli_query($GLOBALS['dbinv'], "START TRANSACTION");

            $sqlrep = "select * from s_salrep where REPCODE = '" . $_POST["salesrep"] . "'";
            $resultrep = mysqli_query($GLOBALS['dbinv'], $sqlrep);
            if ($rowrep = mysqli_fetch_array($resultrep)) {
                $maindepart = $rowrep['RGROUP1'];
            } else {
                $maindepart = "";
            }

            $sql1 = "insert into c_bal(REFNO, SDATE, CUSCODE, AMOUNT, BALANCE, DEP, SAL_EX, Cancell, brand, DEV, trn_type, vatrate, old, flag1, active, totpay,maindepartment,sdate1,c_code1) values ('" . $_POST["invno"] . "', '" . $_POST["invdate"] . "', '" . $_POST["supplier_code"] . "', '" . $_POST["total_value"] . "', '" . $_POST["total_value"] . "', '" . $_POST["department"] . "', '" . $_POST["salesrep"] . "', '0', '" . $_POST["brand"] . "', '" . $_SESSION['dev'] . "', 'ARN', '" . $vatrate . "', '0', 0, 1, 0,'".$maindepart."','" . $_POST["invdate"] . "','" . $_POST["supplier_code"] . "')";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($result1 != 1) {
                $sql_status = 1;
            }

            $sql1 = "insert into s_sttr_all(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, balance, netamount, cus_code, cusname, DEV, del_days, deliin_days, deliin_amo, deliin_lock, department, form_type, trn_type) values
	  ('" . $_POST["invno"] . "', '" . $_POST["invdate"] . "', '" . $_POST["invno"] . "', " . $_POST["total_value"] . ", " . $_POST["total_value"] . ", " . (-1 * $_POST["total_value"]) . ", '" . $_POST["supplier_code"] . "', '" . $_POST["supplier_name"] . "', '" . $_SESSION['dev'] . "', 0, 0, 0, '0', 'O', 'ARN', 'OVER')";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($result1 != 1) {
                $sql_status = 2;
            }

            $sql1 = "insert into s_purmas(REFNO, SDATE, ORDNO, LCNO, pi_no, COUNTRY, SUP_CODE, SUP_NAME, REMARK, DEPARTMENT, AMOUNT, PUR_DATE,
TYPE, brand,book_no) values ('" . $_POST["invno"] . "', '" . $_POST["invdate"] . "', '" . $_POST["orderno1"] . "', '" . $_POST["lc_no"] . "', '" . $_POST["pi_no"] . "', '" . $_POST["country"] . "', '" . $_POST["supplier_code"] . "', '" . $_POST["supplier_name"] . "', '" . $_POST["textarea"] . "', '" . $_POST["department"] . "', '" . $_POST["total_value"] . "', '" . $_POST["dte_dor"] . "', '" . $_POST["purtype"] . "', '" . $_POST["brand"] . "','" . $_POST['contsize'] . "')";
            //echo $sql1;
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($result1 != 1) {
                $sql_status = 3;
            }
        }

        $i = 1;
        //echo $_GET["count"];
        while ($i < $_POST["count"]) {

            $itemcode_name = "itemcode" . $i;
            $itemname_name = "itemname" . $i;
            $ord_qty_name = "ord_qty" . $i;
            $fob_name = "fob" . $i;
            $qty_name = "qty" . $i;
            $cost_name = "cost" . $i;
            $selling_name = "selling" . $i;
            // $ctn = "ctn" . $i;
            // $ctn= "ctn" . $i;
            // $ctnqty = "ctnqty" . $i;
            // $ctn1 = "ctn1" . $i;
            // $ctnqty1 = "ctnqty1" . $i;
            $margin_name = "margin" + $i;
            

            $QTYINHAND = 0;
            $cost = 0;
            $acc_cost = 0;
            $acc_cost_c = 0;
            $m_qty = 0;
            $m_totval = 0;
            $COST_mas = 0;

            if ($_POST[$qty_name] > 0) {
                if ($_POST["purtype"] == "Local") {
                    $cost = $_POST[$cost_name];
                } else {
                    $cost = 0;
                }
                $acc_cost = $_POST[$cost_name];

                $sql = "select * from s_mas where STK_NO='" . $_POST[$itemcode_name] . "'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row = mysqli_fetch_array($result)) {
                    $QTYINHAND = $row["QTYINHAND"];
                    $COST_mas = $row["COST"];
                    $acc_cost_c = $row["acc_cost"];
                }

                $m_qty = $QTYINHAND + $_POST[$qty_name];

                if ($QTYINHAND > 0) {
                    $m_totval = (($QTYINHAND * $acc_cost_c) + ($_POST[$qty_name] * $_POST[$cost_name])) / $m_qty;
                } else {
                    $m_totval = $_POST[$cost_name];
                }
                if ($acc_cost_c < 1) {
                    $m_totval = $_POST[$cost_name];
                }
                //echo $itemcode_name;
                //echo $_GET[$itemcode_name];

                if (trim($_POST[$fob_name]) == "") {
                    $fob_val = 0;
                } else {
                    $fob_val = $_POST[$fob_name];
                }
                // ,octn,octnqty,ctn,ctnqty   ," . $ctn . "," . $ctnqty . "," . $ctn1 . "," . $ctnqty1 . "
                $sql1 = "insert into s_purtrn(REFNO, SDATE, STK_NO, DESCRIPT, COST, MARGIN, SELLING, REC_QTY, FOB, DEPARTMENT, QTYINHAND, O_QTY, 
 Cost_c, acc_cost, acc_cost_c, brand, vatrate, DISCOUNT, ret_qty, cost_seling, cost_margin, CANCEL, soldqty, days) values ('" . $_POST["invno"] . "', '" . $_POST["invdate"] . "', '" . $_POST[$itemcode_name] . "', '" . $_POST[$itemname_name] . "', " . $cost . ", " . $margin_name . ", " . $_POST[$selling_name] . ", " . $_POST[$qty_name] . ", " . $fob_val . ", '" . $_POST["department"] . "', " . $QTYINHAND . ", " . $_POST[$ord_qty_name] . ", " . $COST_mas . ", '" . $acc_cost . "', '" . $acc_cost_c . "', '" . $_POST["brand"] . "', '" . $vatrate . "', 0, 0, 0, 0, '0', '', 0)";
                echo $sql1;
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                if ($result1 != 1) {
                    $sql_status = 4;
                }

                if ($m_totval > 0) {
                    $marg = ($_POST[$selling_name] - $m_totval) / $m_totval * 100;
                } else {
                    $marg = 0;
                }
                if ($_POST["purtype"] == "Local") {
                    $sql1 = "update s_mas set COST=" . $m_totval . " where  STK_NO='" . $_POST[$itemcode_name] . "'";
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    if ($result1 != 1) {
                        $sql_status = 5;
                    }
                }

                if (($m_totval > 0) and (trim($m_totval) != "")) {
                    $margin = ($_POST[$selling_name] - $m_totval) / $m_totval * 100;
                } else {
                    $margin = 0;
                }

                $sql1 = "update s_mas set acc_cost=" . $m_totval . ", SELLING='" . $_POST[$selling_name] . "', AR_selling='" . $_POST[$selling_name] . "', MARGIN ='" . $margin . "', QTYINHAND=QTYINHAND+" . $_POST[$qty_name] . " where  STK_NO='" . $_POST[$itemcode_name] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                if ($result1 != 1) {
                    $sql_status = 6;
                }

                $sql3 = "select * from s_submas where STK_NO='" . $_POST[$itemcode_name] . "' and STO_CODE='" . $_POST["department"] . "'";
                //echo $sql1;
                $result3 = mysqli_query($GLOBALS['dbinv'], $sql3);
                if ($row3 = mysqli_fetch_array($result3)) {
                    $sql1 = "update s_submas set QTYINHAND=QTYINHAND+" . $_POST[$qty_name] . " where STK_NO='" . $_POST[$itemcode_name] . "' and STO_CODE='" . $_POST["department"] . "'";
                    //	echo $sql1;
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    if ($result1 != 1) {
                        $sql_status = 7;
                    }
                } else {

                    $sql1 = "insert into s_submas(STO_CODE, STK_NO, DESCRIPt, OPENT_DATE, QTYINHAND) values ('" . $_POST["department"] . "', '" . $_POST[$itemcode_name] . "', '" . $_POST[$itemname_name] . "', '" . $_POST["invdate"] . "', " . $_POST[$qty_name] . " )";
                    //echo $sql1;
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    if ($result1 != 1) {
                        $sql_status = 8;
                    }
                }

                $sql1 = "update s_ordmas set cancel='1' where REFNO='" . $_POST["orderno1"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                if ($result1 != 1) {
                    $sql_status = 9;
                }

                $sql1 = "update s_ordtrn set rec_qty= rec_qty + '" . $_POST[$qty_name] . "',CANCEL='1' where REFNO='" . $_POST["orderno1"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                if ($result1 != 1) {
                    $sql_status = 10;
                }

                $sql1 = "insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO) values ('" . $_POST[$itemcode_name] . "', '" . $_POST["invdate"] . "', '" . $_POST[$qty_name] . "', 'ARN', '" . $_POST["invno"] . "', '" . $_POST["department"] . "', '" . $_POST['arpend'] . "', '" . $_SESSION['dev'] . "', '', '1', '')";
                //echo $sql1;
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                if ($result1 != 1) {
                    $sql_status = 11;
                }
            }

            $i = $i + 1;
        }

        $sql1 = "update invpara set ARN=ARN+1";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        if ($result1 != 1) {
            $sql_status = 13;
        }


        $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_POST["invno"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'ARN', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $resul2 = mysqli_query($GLOBALS['dbinv'], $sql2);

        if ($sql_status == 0) {
            mysqli_query($GLOBALS['dbinv'], "COMMIT");
            echo "Saved";
        } else {
            mysqli_query($GLOBALS['dbinv'], "ROLLBACK");
            echo "Error -" . $sql_status;
        }
    } else {
        echo "no";
    }
}

if ($_GET["Command"] == "pass_arnno") {
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $sql = "Select * from s_purmas where REFNO='" . $_GET['arnno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<REFNO><![CDATA[" . $row["REFNO"] . "]]></REFNO>";
        $ResponseXML .= "<SDATE><![CDATA[" . $row["SDATE"] . "]]></SDATE>";
        $ResponseXML .= "<ORDNO><![CDATA[" . $row["ORDNO"] . "]]></ORDNO>";
        $ResponseXML .= "<LCNO><![CDATA[" . $row["LCNO"] . "]]></LCNO>";
        $ResponseXML .= "<pi_no><![CDATA[" . $row["pi_no"] . "]]></pi_no>";
        $ResponseXML .= "<COUNTRY><![CDATA[" . $row["COUNTRY"] . "]]></COUNTRY>";
        $ResponseXML .= "<SUP_CODE><![CDATA[" . $row["SUP_CODE"] . "]]></SUP_CODE>";
        $ResponseXML .= "<SUP_NAME><![CDATA[" . $row["SUP_NAME"] . "]]></SUP_NAME>";
        $ResponseXML .= "<REMARK><![CDATA[" . $row["REMARK"] . "]]></REMARK>";
        $ResponseXML .= "<DEPARTMENT><![CDATA[" . $row["DEPARTMENT"] . "]]></DEPARTMENT>";
        $ResponseXML .= "<AMOUNT><![CDATA[" . $row["AMOUNT"] . "]]></AMOUNT>";
        $ResponseXML .= "<PUR_DATE><![CDATA[" . $row["PUR_DATE"] . "]]></PUR_DATE>";
        $ResponseXML .= "<brand><![CDATA[" . $row["brand"] . "]]></brand>";
        $ResponseXML .= "<TYPE><![CDATA[" . $row["TYPE"] . "]]></TYPE>";
        $ResponseXML .= "<contsize><![CDATA[" . $row["book_no"] . "]]></contsize>";


        $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                               <td width=\"200\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"800\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Order CTN</font></td>
                               <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Order CTNQty</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Order Qty</font></td>
                              <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">FOB</font></td>
                                <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">CTN</font></td>
                                <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">CTN Qty</font></td>
                                <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Cost</font></td>
							   <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Selling</font></td>
							    <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Margin</font></td>
								 <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
							
                            </tr>";

        $mcou = 0;
        $sql = "Select count(*) as mcou from s_purtrn where REFNO='" . $_GET['arnno'] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $mcou = $row["mcou"] + 1;

        $i = 1;
        $tot = 0;
        $sql = "Select * from s_purtrn where REFNO='" . $_GET['arnno'] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {

            $itemcode = "itemcode" . $i;
            $itemname = "itemname" . $i;
            $ord_qty = "ord_qty" . $i;
            $fob = "fob" . $i;
            $qty = "qty" . $i;
            $cost = "cost" . $i;
            $selling = "selling" . $i;
            $margin = "margin" . $i;
            $subtotal = "subtotal" . $i; 
             
            $ctn = "ctn" . $i;
            $ctnqty = "ctnqty" . $i; 
            $ctn1 = "ctn1" . $i;
            $ctnqty1 = "ctnqty1" . $i; 
        

            if (($row['REC_QTY'] > 0) and ($row['acc_cost'] > 0) and ($row['SELLING'] > 0)) {
                $stot = $row['REC_QTY'] * $row['acc_cost'];
                $margine_val = ($row['SELLING'] - $row['acc_cost']) / $row['acc_cost'] * 100;
            } else {
                $stot = "";
                $margine_val = "";
            }

            $ResponseXML .= "<tr>            
                         
            
                            <td  ><input type=\"text\" size=\"15\" name=" . $itemcode . " id=" . $itemcode . "   value='" . $row['STK_NO'] . "' class=\"text_purchase3\" disabled=\"disabled\"/></td>
							<td  ><input type=\"text\" size=\"15\" name=" . $itemname . " id=" . $itemname . "  value='" . $row['DESCRIPT'] . "' class=\"text_purchase3\" disabled=\"disabled\"/></td>
						    <td  ><input type=\"text\" size=\"15\" name=" . $ctnqty . " id=" . $ctn . "  value='" . $row['octn'] . "' class=\"text_purchase3_right\" disabled=\"disabled\"/></td> 
						    <td  ><input type=\"text\" size=\"15\" name=" . $ctnqty . " id=" . $ctnqty . "  value='" . $row['octnqty'] . "' class=\"text_purchase3_right\" disabled=\"disabled\"/></td>  
							<td  ><input type=\"text\" size=\"15\" name=" . $ord_qty . " id=" . $ord_qty . "  value='" . $row['O_QTY'] . "' class=\"text_purchase3_right\" disabled=\"disabled\"/></td>
							<td  ><input type=\"text\" size=\"15\" name=" . $fob . " id=" . $fob . " value='" . $row['FOB'] . "'  class=\"text_purchase3\"/></td>
							<td  ><input type=\"text\" size=\"15\" name=" . $ctn1 . " id=" . $ctn1 . "  value='" . $row['ctn'] . "' class=\"text_purchase3_right\" disabled=\"disabled\"/></td>
							<td  ><input type=\"text\" size=\"15\" name=" . $ctnqty1 . " id=" . $ctnqty1 . "  value='" . $row['ctnqty'] . "' class=\"text_purchase3_right\" disabled=\"disabled\"/></td>
							<td  ><input type=\"text\" size=\"15\" name=" . $qty . " id=" . $qty . " value='" . $row['REC_QTY'] . "'  class=\"text_purchase3_right\" onBlur=\"cal_subtot('" . $i . "', '" . $mcou . "');\"/></td>
							<td  ><input type=\"text\" size=\"15\" name=" . $cost . " id=" . $cost . " value='" . $row['acc_cost'] . "'  class=\"text_purchase3_right\" onBlur=\"cal_subtot('" . $i . "', '" . $mcou . "');\"/></td>
							<td  ><input type=\"text\" size=\"15\" name=" . $selling . " id=" . $selling . " value='" . $row['SELLING'] . "'  class=\"text_purchase3_right\"/></td>
							<td  ><input type=\"text\" size=\"15\" name=" . $margin . " id=" . $margin . " value='" . $margine_val . "'  class=\"text_purchase3_right\" disabled=\"disabled\"/></td>
							<td  ><input type=\"text\" size=\"15\" name=" . $subtotal . " id=" . $subtotal . " value='" . $stot . "'  class=\"text_purchase3_right\" disabled=\"disabled\"/></td>
							</tr>";
            //$tot=$tot+($row['COST']*$row['REC_QTY']);
            $subtot = $subtot + $stot;
            $i = $i + 1;
        }

        $sql = "select * from s_trn where refno = '" . $_GET['arnno'] . "' limit 1";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);



        $ResponseXML .= "</table>]]></sales_table>";
        $ResponseXML .= "<arpend><![CDATA[" . $row['seri_no'] . "]]></arpend>";
        $ResponseXML .= "<tot><![CDATA[" . $tot . "]]></tot>";
        $ResponseXML .= "<subtot><![CDATA[" . number_format($subtot, 2, ".", ",") . "]]></subtot>";
        $ResponseXML .= "<count><![CDATA[" . $i . "]]></count>";
    }

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_arnno_gin") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $sql = "Select * from s_purmas where REFNO='" . $_GET['arnno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<REFNO><![CDATA[" . $row["REFNO"] . "]]></REFNO>";
        $ResponseXML .= "<SDATE><![CDATA[" . $row["SDATE"] . "]]></SDATE>";
    }
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "cancel_inv") {

//    if (date("Y-m") != date("Y-m", strtotime($_GET["invdate"]))) {
//        exit("Sorry Cant Cancel.... Not in Current Month..");
//    }

    $sql = "select * from s_purmas where CANCEL='0' order by id desc";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);

    $sql_status = 0;
    mysqli_query($GLOBALS['dbinv'], "SET AUTOCOMMIT=0");
    mysqli_query($GLOBALS['dbinv'], "START TRANSACTION");

    $sql1 = "update s_purmas set CANCEL='1' where REFNO='" . $_GET["invno"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    if ($result1 != 1) {
        $sql_status = 1;
    }

    $sql1 = "update s_purtrn set CANCEL='1' where REFNO='" . $_GET["invno"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    if ($result1 != 1) {
        $sql_status = 2;
    }

    $sql1 = "update s_ordmas set cancel='0' where REFNO='" . $_GET["orderno1"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    if ($result1 != 1) {
        $sql_status = 3;
    }

    $sql1 = "update s_ordtrn set CANCEL='0' where REFNO='" . $_GET["orderno1"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    if ($result1 != 1) {
        $sql_status = 4;
    }

    $sql1 = "delete from s_trn  where REFNO='" . $_GET["invno"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    if ($result1 != 1) {
        $sql_status = 5;
    }

    $sql1 = "delete from s_trn_all  where REFNO='" . $_GET["invno"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    if ($result1 != 1) {
        $sql_status = 6;
    }

    $sql1 = "delete from c_bal where REFNO='" . $_GET["invno"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    if ($result1 != 1) {
        $sql_status = 7;
    }

    $sql1 = "delete from s_sttr_all where ST_REFNO='" . $_GET["invno"] . "'";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    if ($result1 != 1) {
        $sql_status = 8;
    }


    $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_GET["invno"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'ARN', 'Delete', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
    $resul2 = mysqli_query($GLOBALS['dbinv'], $sql2);

    $sql1 = "select * from s_purtrn where REFNO='" . $_GET["invno"] . "'";

    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    while ($row1 = mysqli_fetch_array($result1)) {

        $sql2 = "update s_mas set COST=" . $row1["Cost_c"] . ", acc_cost=" . $row1["acc_cost_c"] . " where STK_NO='" . $row1["STK_NO"] . "'";
        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
        if ($result2 != 1) {
            $sql_status = 9;
        }

        $sql2 = "update s_ordtrn set rec_qty= rec_qty - '" . $row1["REC_QTY"] . "' where REFNO='" . $row ["ORDNO"] . "'";
        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
        if ($result2 != 1) {
            $sql_status = 10;
        }


        $sql2 = "update s_submas set QTYINHAND=QTYINHAND-" . $row1["REC_QTY"] . " where STK_NO='" . $row1["STK_NO"] . "' and STO_CODE='" . $_GET["department"] . "'";

        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
        if ($result2 != 1) {
            $sql_status = 10;
        }

        $sql2 = "update s_mas set QTYINHAND=QTYINHAND-" . $row1["REC_QTY"] . " where STK_NO='" . $row1["STK_NO"] . "'";
        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
        if ($result2 != 1) {
            $sql_status = 11;
        }
    }

    if ($sql_status == 0) {

        mysqli_query($GLOBALS['dbinv'], "COMMIT");
        echo "Canceled!";
    } else {

        mysqli_query($GLOBALS['dbinv'], "ROLLBACK");
        echo "Error -" . $sql_status;
    }

    //}
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
        If (is_null($row["CAT"]) == false) {
            $cat = trim($row["CAT"]);
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
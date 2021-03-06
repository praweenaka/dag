<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once("connectioni.php");



////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "add_address") {
    //echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;


    /* 		$sql="Select * from tmp_army_no where edu= '".$_GET['edu']."'";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
      if($row = mysqli_fetch_array($result)){
      $ResponseXML .= "exist";



      }	else { */

    //	$ResponseXML .= "";
    //$ResponseXML .= "<ArmyDetails>";

    /* 	$sql1="Select * from mas_educational_qualifications where str_Educational_Qualification= '".$_GET['edu']."'";
      $result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ;
      $row1 = mysqli_fetch_array($result1);
      $ResponseXML .=  $row1["int_Educational_Qulifications"]; */

    $sqlt = "Select * from customer_mast where id ='" . $_GET['customerid'] . "'";

    $resultt = mysqli_query($GLOBALS['dbinv'], $sqlt);
    if ($rowt = mysqli_fetch_array($resultt)) {
        echo $rowt["str_address"];
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


    if ($_SESSION["dev"] == "") {
        exit("no");
    }
    $_SESSION["print"] = 0;

    /* 	$sql="Select CAS_INV_NO_m from invpara";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
      $row = mysqli_fetch_array($result);
      $tmpinvno="000000".$row["CAS_INV_NO_m"];
      $lenth=strlen($tmpinvno);
      $invno="INV".substr($tmpinvno, $lenth-7);
      echo $invno; */


    //echo $_GET["chk_crenote"];
    if ($_GET["chk_crenote"] == "true") {
        $sql = "Select debnoteno from invpara";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $tmpinvno = "0000000" . $row["debnoteno"];
        $lenth = strlen($tmpinvno);
        $invno = trim("DEB/ ") . substr($tmpinvno, $lenth - 8);
    } else {
        $sql = "Select CHE_RET from invpara";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $tmpinvno = "0000000" . $row["CHE_RET"];
        $lenth = strlen($tmpinvno);

        $invno = trim("RCH/ ") . substr($tmpinvno, $lenth - 8);
    }
    $_SESSION["invno"] = $invno;

    //echo ("okkkkkkkkkkkkkk");

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<curdate><![CDATA[" . date("Y-m-d") . "]]></curdate>";
    $ResponseXML .= " </salesdetails>";

    //	}	


    echo $ResponseXML;
}


if ($_GET["Command"] == "cancel_inv") {
    include('connectioni.php');

    $sql_status = 0;

    mysqli_query($GLOBALS['dbinv'], "SET AUTOCOMMIT=0");
    mysqli_query($GLOBALS['dbinv'], "START TRANSACTION");

    $sql_rscheque = "Select * from s_cheq where CR_REFNO='" . trim($_GET["lblReciptNo"]) . "' and PAID=0";
    $result_rscheque = mysqli_query($GLOBALS['dbinv'], $sql_rscheque);
    if ($row_rscheque = mysqli_fetch_array($result_rscheque)) {

        $sql_strsqlstr = "update s_cheq set CR_FLAG='c' where CR_REFNO='" . trim($_GET["lblReciptNo"]) . "'";
        $result_strsqlstr = mysqli_query($GLOBALS['dbinv'], $sql_strsqlstr);
        if ($result_strsqlstr != 1) {
            $sql_status = 1;
        }

        $sql = "delete  from s_led where REF_NO='" . $_GET["lblReciptNo"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 1;
        }

        $sql = "delete  from ledger where l_refno='" . trim($_GET["lblReciptNo"]) . "' and chno='" . $_GET["txtChequeNo"] . "'";
        //echo $sql;
        $result = mysqli_query($GLOBALS['dbacc'], $sql);
        if ($result != 1) {
            $sql_status = 1;
        }


        $sql = "update s_invcheq set ch_count_ret= '0' where cheque_no = '" . trim($_GET["txtChequeNo"]) . "' and cus_code = '" . trim($_GET["Txtcusco"]) . "' and bank = '" . trim($_GET["cmbBankname"]) . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 1;
        }

        $sql = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_GET["lblReciptNo"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'RetChqEntry', 'Cancel', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 1;
        }

        if ($sql_status == 0) {
            mysqli_query($GLOBALS['dbinv'], "COMMIT");
            echo "Deleted";
        } else {
            mysqli_query($GLOBALS['dbinv'], "ROLLBACK");
            echo "Error has occured. Can't Delete";
        }
    } else {
        echo "Not Exist";
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



if ($_GET["Command"] == "save_item") {

    if ($_SESSION["dev"] == "") {
        exit("no");
    }

    include('connectioni.php');

    $sqltmp = "select * from invpara";
    $resulttmp = mysqli_query($GLOBALS['dbinv'], $sqltmp);
    $rowtmp = mysqli_fetch_array($resulttmp);

    if ($rowtmp["form_loc"] == "1") {
        exit("no");
    }
    $_SESSION["CURRENT_DOC"] = 1;      //document ID
    $_SESSION["VIEW_DOC"] = false;     //view current document
    $_SESSION["FEED_DOC"] = true;       //save  current document
    $_GET["MOD_DOC"] = false;         //delete   current document
    $_GET["PRINT_DOC"] = false;       //get additional print   of  current document
    $_GET["PRICE_EDIT"] = false;       //edit selling price
    $_GET["CHECK_USER"] = false;       //check user permission again


    $sql_status = 0;

    mysqli_query($GLOBALS['dbinv'], "SET AUTOCOMMIT=0");
    mysqli_query($GLOBALS['dbinv'], "START TRANSACTION");

    $sql_strsqlstr = "Select * from vendor where CODE='" . trim($_GET["Txtcusco"]) . "'";
    $result_strsqlstr = mysqli_query($GLOBALS['dbinv'], $sql_strsqlstr);
    if ($row_strsqlstr = mysqli_fetch_array($result_strsqlstr)) {
        
    } else {
        exit("Invalid Customer");
    }



    $sql_rscheque = "Select CR_CHNO from s_cheq where CR_CHNO='" . trim($_GET["txtChequeNo"]) . "' AND CR_CHNO='0'";

    $result_rscheque = mysqli_query($GLOBALS['dbinv'], $sql_rscheque);
    if ($row_rscheque = mysqli_fetch_array($result_rscheque)) {
        if ($_GET["txt_stat"] == "NEW") {
            exit("Cheque No Already Entered");
        }
    }

    $sql_rscheque = "Select * from s_cheq where CR_REFNO='" . trim($_GET["lblReciptNo"]) . "'";
    $result_rscheque = mysqli_query($GLOBALS['dbinv'], $sql_rscheque);
    if ($row_rscheque = mysqli_fetch_array($result_rscheque)) {
        $m_oldval = $row_rscheque["CR_CHEVAL"];
        $PAID = $row_rscheque["PAID"];
    } else {
        $sql = "update invpara set CHE_RET=CHE_RET+1";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result == false) {
            $sql_status = 1;
        }
    }



    if ($_GET["op_computer"] == "true") {
        $dev = 0;
    } else {
//        $dev = 1;
        $dev = 0;
    }
    if ($_GET["chk_crenote"] == "true") {
        $chk_crenote = 1;
    } else {
        $chk_crenote = 0;
    }
    $lblnoof = $_GET["lblnoof"] + 1;

    //if (($PAID=="") or ($PAID==0)){
    if ($_GET["Check1"] == "true") {
        $countrtn=1;
    }else{
        $countrtn=0;
    }

    $sql_rscheque1 = "Select * from s_cheq where CR_REFNO='" . trim($_GET["lblReciptNo"]) . "'";
    //echo $sql_rscheque1;
    $result_rscheque1 = mysqli_query($GLOBALS['dbinv'], $sql_rscheque1);
    if ($row_rscheque1 = mysqli_fetch_array($result_rscheque1)) {
        $sql_rscheque = "update s_cheq set depobank='" . $_GET["cheq_dpo_bank"] . "', REMARK='" . $_GET["txtremark"] . "',ch_count_ret='" . $countrtn . "', reason='" . $_GET["reason"] . "' where CR_REFNO='" . $_GET["lblReciptNo"] . "'";
//echo $sql_rscheque;
        $result_rscheque = mysqli_query($GLOBALS['dbinv'], $sql_rscheque);
        if ($result_rscheque != 1) {
            $sql_status = 2;
        }
    } else {
        $sql_rscheque = "insert into s_cheq (CR_REFNO, CR_DATE, CR_C_CODE, CR_C_NAME, CR_REPAY, CR_BANK, REMARK, reason, CR_CHEVAL, CR_CHNO, DEPARTMENT, S_REF, CR_CHDATE, DEBACC, depobank, ret_chno, ret_chdate, noof, ret_refno, tmp, FORwhat, crenoteno, crenoteamo, dev, debnoteno, CR_REPOSIT, CR_FLAG, PAID, CR_CRVAL,retcout,pdno,ch_count_ret) values ('" . $_GET["lblReciptNo"] . "', '" . $_GET["DTPicker1"] . "', '" . $_GET["Txtcusco"] . "', '" . $_GET["txtcusname"] . "', '" . $_GET["txtRetChCha"] . "', '" . $_GET["cmbBankname"] . "', '" . $_GET["txtremark"] . "', '" . $_GET["reason"] . "', '" . $_GET["txtChequeAmount"] . "', '" . $_GET["txtChequeNo"] . "', '" . $_GET["com_dep"] . "', '" . $_GET["com_rep"] . "', '" . $_GET["DTPicker2"] . "', '" . $_GET["Txtacco"] . "', '" . $_GET["cheq_dpo_bank"] . "', '" . $_GET["lblRET_chno"] . "', '" . $_GET["lblretdate"] . "', '" . $lblnoof . "', '" . $_GET["lblretrefno"] . "', '0', '" . $_GET["txtforwhat"] . "', '" . $_GET["txtcrenoteno"] . "', '" . $_GET["txtcrenoteamo"] . "', '" . $dev . "', '" . $chk_crenote . "', 1, '0', 0, 0,'" . $_GET['txtretcount'] . "','" . $_GET['txtoriginal'] . "','" . $countrtn . "')";
//echo $sql_rscheque;

        $result_rscheque = mysqli_query($GLOBALS['dbinv'], $sql_rscheque);
        if ($result_rscheque != 1) {
            $sql_status = 3;
        }
    }

    $sql_rscheque = "insert into s_cheq_tmp (CR_REFNO, CR_DATE, CR_C_CODE, CR_C_NAME, CR_REPAY, CR_BANK, REMARK, reason, CR_CHEVAL, CR_CHNO, DEPARTMENT, S_REF, CR_CHDATE, DEBACC, depobank, ret_chno, ret_chdate, noof, ret_refno, tmp, FORwhat, crenoteno, crenoteamo, dev, debnoteno, CR_REPOSIT, CR_FLAG, PAID, CR_CRVAL, updated) values ('" . $_GET["lblReciptNo"] . "', '" . $_GET["DTPicker1"] . "', '" . $_GET["Txtcusco"] . "', '" . $_GET["txtcusname"] . "', '" . $_GET["txtRetChCha"] . "', '" . $_GET["cmbBankname"] . "', '" . $_GET["txtremark"] . "', '" . $_GET["reason"] . "', '" . $_GET["txtChequeAmount"] . "', '" . $_GET["txtChequeNo"] . "', '" . $_GET["com_dep"] . "', '" . $_GET["com_rep"] . "', '" . $_GET["DTPicker2"] . "', '" . $_GET["Txtacco"] . "', '" . $_GET["cheq_dpo_bank"] . "', '" . $_GET["lblRET_chno"] . "', '" . $_GET["lblretdate"] . "', '" . $lblnoof . "', '" . $_GET["lblretrefno"] . "', '0', '" . $_GET["txtforwhat"] . "', '" . $_GET["txtcrenoteno"] . "', '" . $_GET["txtcrenoteamo"] . "', '" . $dev . "', '" . $chk_crenote . "', 1, '0', 0, 0, '0')";
//echo $sql_rscheque;

    $result_rscheque = mysqli_query($GLOBALS['dbinv'], $sql_rscheque);
    if ($result_rscheque != 1) {
        $sql_status = 4;
    }

///////////////////////////////////	

    /* if ($_GET["txt_stat"]=="NEW"){
      // echo $_GET["chk_crenote"];
      if ($_GET["chk_crenote"]== "true") {
      // echo $sql;
      $sql="update invpara set debnoteno=debnoteno+1";
      $result=mysqli_query($GLOBALS['dbinv'],$sql);

      } else {
      $sql="update invpara set CHE_RET=CHE_RET+1";
      $result=mysqli_query($GLOBALS['dbinv'],$sql);

      }
 
      } */
////////////////////////////////////////////////////		

    $sql = "delete  from s_led where REF_NO='" . $_GET["lblReciptNo"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($result != 1) {
        $sql_status = 5;
    }


    $m_flag = "RCH";

    $sql = "Insert into s_led (REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT) values ('" . trim($_GET["lblReciptNo"]) . "', '" . $_GET["DTPicker1"] . "','" . trim($_GET["Txtcusco"]) . "', " . $_GET["txtChequeAmount"] . ", '" . $m_flag . "','" . trim($_GET["com_dep"]) . "')";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($result != 1) {
        $sql_status = 6;
    }


    include_once("connectioni.php");

    $mretch = 0;
    if ($_GET["txtRetChCha"] != "") {
        $mretch = floatval($_GET["txtRetChCha"]);
    }

    $macc = "";
    $sql_para = "select * from invpara";
    $result_para = mysqli_query($GLOBALS['dbinv'], $sql_para);
    if ($row_para = mysqli_fetch_array($result_para)) {
        $macc = $row_para['RETCH_AC'];
    }

    $mNara = "RETURN CHEQUE - " . $_GET["txtChequeNo"];

    $sql = "delete  from ledger where l_refno='" . trim($_GET["lblReciptNo"]) . "' and chno='" . $_GET["txtChequeNo"] . "'";
    $result = mysqli_query($GLOBALS['dbacc'], $sql);
    if ($result != 1) {
        $sql_status = 1;
    }

    $sql1 = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_lmem, rights, l_flag2, l_flag3, comcode, l_yearfl, recdate, l_year, chno) Values ('" . trim($_GET["lblReciptNo"]) . "', '" . $_GET["bank_st_date"] . "', '" . trim($_GET["accno"]) . "', " . ($_GET["txtChequeAmount"] + $mretch) . ", 'RTN', 'DEB', '" . $mNara . "', '" . $_SESSION['UserName'] . "', '0', 'R', '" . $_SESSION['company'] . "', 0, '0', " . date("Y") . ", '" . $_GET["txtChequeNo"] . "')";

    $result1 = mysqli_query($GLOBALS['dbacc'], $sql1);
    if ($result1 != 1) {
        $sql_status = 1;
    }

    $sql1 = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_lmem, rights, l_flag2, l_flag3, comcode, l_yearfl, recdate, l_year, chno) Values ('" . trim($_GET["lblReciptNo"]) . "', '" . $_GET["bank_st_date"] . "', '" . trim($_GET["cheq_dpo_bank"]) . "', " . $_GET["txtChequeAmount"] . ", 'RTN', 'CRE', '" . $mNara . "', '" . $_SESSION['UserName'] . "', '0', 'R', '" . $_SESSION['company'] . "', 0, '0', " . date("Y") . ", '" . $_GET["txtChequeNo"] . "')";
    //echo $sql1;
    $result1 = mysqli_query($GLOBALS['dbacc'], $sql1);
    if ($result1 != 1) {
        $sql_status = 1;
    }

    $sql1 = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_lmem, rights, l_flag2, l_flag3, comcode, l_yearfl, recdate, l_year, chno) Values ('" . trim($_GET["lblReciptNo"]) . "', '" . $_GET["bank_st_date"] . "', '" . trim($macc) . "', " . ($mretch) . ", 'RTN', 'CRE', '" . $mNara . "', '" . $_SESSION['UserName'] . "', '0', 'R', '" . $_SESSION['company'] . "', 0, '0', " . date("Y") . ", '" . $_GET["txtChequeNo"] . "')";

    $result1 = mysqli_query($GLOBALS['dbacc'], $sql1);
    if ($result1 != 1) {
        $sql_status = 1;
    }

    $a = 1;
    while ($_GET["mcount"] > $a) {
        $REF_NO = "REF_NO_" . $a;
        $SDATE = "SDATE_" . $a;
        $GRAND_TOT = "GRAND_TOT_" . $a;
        $st_amou = "st_amou_" . $a;

        if (trim($_GET[$REF_NO]) != "") {
            $sql_strsqlstr = "delete from ret_chq_history where Ref_no='" . trim($_GET[$REF_NO]) . "' and chk_no='" . $_GET["txtChequeNo"] . "'";
            $result_strsqlstr = mysqli_query($GLOBALS['dbinv'], $sql_strsqlstr);
            if ($result_strsqlstr != 1) {
                $sql_status = 7;
            }

            $sql_chq = "insert into ret_chq_history (Ref_no, Inv_no, Inv_date, inv_Amt, st_amt, chk_no) values ('" . trim($_GET["lblReciptNo"]) . "','" . trim($_GET[$REF_NO]) . "', '" . $_GET[$SDATE] . "', " . $_GET[$GRAND_TOT] . ", " . $_GET[$st_amou] . ", '" . $_GET[txtChequeNo] . "')";
            //echo $sql_chq;
            $result_chq = mysqli_query($GLOBALS['dbinv'], $sql_chq);
            if ($result_chq != 1) {
                $sql_status = 8;
            }
        }
        $a = $a + 1;
    }


    if ($_GET["Check1"] == "true") {
        $sql = "update s_invcheq set ch_count_ret= '1' where cheque_no = '" . trim($_GET["txtChequeNo"]) . "' and cus_code = '" . trim($_GET["Txtcusco"]) . "' and bank = '" . trim($_GET["cmbBankname"]) . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 9;
        }

        $sql = "insert into s_invcheq_tmp (CR_REFNO, ch_count_ret, cheque_no, cus_code, bank) value ('" . trim($_GET["lblReciptNo"]) . "', '1', '" . trim($_GET["txtChequeNo"]) . "', '" . trim($_GET["Txtcusco"]) . "', '" . trim($_GET["cmbBankname"]) . "')";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 10;
        }
    } else {
        $sql = "update s_invcheq set ch_count_ret= '0' where cheque_no = '" . trim($_GET["txtChequeNo"]) . "' and cus_code = '" . trim($_GET["Txtcusco"]) . "' and bank = '" . trim($_GET["cmbBankname"]) . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 11;
        }

        $sql = "insert into s_invcheq_tmp (CR_REFNO, ch_count_ret, cheque_no, cus_code, bank) value ('" . trim($_GET["lblReciptNo"]) . "', '0', '" . trim($_GET["txtChequeNo"]) . "', '" . trim($_GET["Txtcusco"]) . "', '" . trim($_GET["cmbBankname"]) . "')";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 1) {
            $sql_status = 12;
        }
    }

    $sqlSave = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_GET["lblReciptNo"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'RetChqEntry', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
    $resultSave = mysqli_query($GLOBALS['dbinv'], $sqlSave);
    if ($resultSave != 1) {
        $sql_status = 13;
    }

    if ($sql_status == 0) {
        mysqli_query($GLOBALS['dbinv'], "COMMIT");
        mysqli_query($GLOBALS['dbacc'], "COMMIT");
        echo "Saved";
    } else {
        mysqli_query($GLOBALS['dbinv'], "ROLLBACK");
        mysqli_query($GLOBALS['dbacc'], "ROLLBACK");
        echo "Error has occured. Can't Save - Error No : " . $sql_status;
    }
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


if ($_GET["Command"] == "up_remark") {

    $sqlblack = "update s_cheq set reason='" . $_GET["reason"] . "'  where CR_REFNO='" . trim($_GET["lblReciptNo"]) . "'";
    $resultblack = mysqli_query($GLOBALS['dbinv'], $sqlblack);

    $sqlblack1 = "update s_cheq_tmp set reason='" . $_GET["reason"] . "'  where CR_REFNO='" . trim($_GET["lblReciptNo"]) . "'";
    $resultblack1 = mysqli_query($GLOBALS['dbinv'], $sqlblack1);

    echo "Updated..";
}
?>
<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once("connectioni.php");



////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "new_inv") {

    include_once("connectioni.php");
    $sql = mysqli_query($GLOBALS['dbinv'], "delete from tmp_stk_take_undelever where user_name = '" . $_SESSION["CURRENT_USER"] . "'") or die(mysqli_error());
    //$sql1="delete from tmp_stk_take_undelever where REF_NO='".$_SESSION["tmp_no_ord"]."'";
    //$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
}


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


if ($_GET["Command"] == "new_inv") {


    /* 	$sql="Select CAS_INV_NO_m from invpara";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
      $row = mysqli_fetch_array($result);
      $tmpinvno="000000".$row["CAS_INV_NO_m"];
      $lenth=strlen($tmpinvno);
      $invno="INV".substr($tmpinvno, $lenth-7);
      echo $invno; */



    //$sql1="delete from tmp_stk_take_undelever where REF_NO='".$_SESSION["tmp_no_ord"]."'";
    //$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
}
if ($_GET["Command"] == "setord") {

    include_once("connectioni.php");

    $len = strlen($_GET["salesord1"]);
    $need = substr($_GET["salesord1"], $len - 7, $len);
    $salesord1 = trim("ORD/ ") . $_GET["salesrep"] . trim(" / ") . $need;


    $_SESSION["custno"] = $_GET['custno'];
    $_SESSION["brand"] = $_GET["brand"];
    $_SESSION["department"] = $_GET["department"];

    //$sql = mysqli_query($GLOBALS['dbinv'],"DROP VIEW view_s_salma") or die(mysqli_error());
    //				$sql = mysqli_query($GLOBALS['dbinv'],"CREATE VIEW view_s_salma
//AS
//SELECT     s_salma.*, brand_mas.class AS class
//FROM         brand_mas RIGHT OUTER JOIN
//                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysqli_error());


    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];


    $ResponseXML .= "<salesord><![CDATA[" . $salesord1 . "]]></salesord>";


    $cuscode = $_GET["custno"];
    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $cuscode . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {
        //echo $ResponseXML;
        $OldRefno = "";
        $NewRefNo = "";

        $sql1 = mysqli_query($GLOBALS['dbinv'], "SELECT  * From ref_history WHERE NewRefNo = '" . $_GET["salesrep"] . "'") or die(mysqli_error());
        if ($row1 = mysqli_fetch_array($sql1)) {

            $OldRefno = trim($row1["OldRefno"]);
            $NewRefNo = trim($row1["NewRefNo"]);
        }

        $OutpDAMT = 0;
        $OutREtAmt = 0;
        $OutInvAmt = 0;



        $sql1 = mysqli_query($GLOBALS['dbinv'], "select * from brand_mas where barnd_name='" . trim($_GET["brand"]) . "'") or die(mysqli_error());

        if ($row1 = mysqli_fetch_array($sql1)) {
            if (is_null($row1["class"]) == false) {
                $InvClass = trim($row1["class"]);
            }
        }

        //////// Total Invoice Amount ///////////////////////////////////////////////////////////////	/						
        if ($NewRefNo == $_GET["salesrep"]) {
            //echo "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and (SAL_EX='".$OldRefno."' or SAL_EX='".trim($_GET["salesrep"])."' and class='".$InvClass."'";
            $sqlview = mysqli_query($GLOBALS['dbinv'], "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='" . trim($cuscode) . "' and (SAL_EX='" . $OldRefno . "' or SAL_EX='" . trim($_GET["salesrep"]) . "' and class='" . $InvClass . "')") or die(mysqli_error());
        } else {
            //	echo "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where Accname != 'NON STOCK' and GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($_GET["salesrep"])."' and class='".$InvClass."'";
            $sqlview = mysqli_query($GLOBALS['dbinv'], "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='" . trim($cuscode) . "' and SAL_EX='" . trim($_GET["salesrep"]) . "' and class='" . $InvClass . "'") or die(mysqli_error());
        }

        $rowview = mysqli_fetch_array($sqlview);
        if (is_null($rowview["totout"]) == false) {
            $OutInvAmt = $rowview["totout"];
        }


////////// PD Cheques ////////////////////////////////////////////////////////////////////////////
        if ($NewRefNo == $_GET["salesrep"]) {

            $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM s_invcheq WHERE che_date>'" . date("Y-m-d") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='REC' and (sal_ex='" . $OldRefno . "' or sal_ex='" . trim($_GET["salesrep"]) . "')") or die(mysqli_error());
        } else {

            $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM s_invcheq WHERE che_date>'" . date("Y-m-d") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='REC' and sal_ex='" . trim($_GET["salesrep"]) . "'") or die(mysqli_error());
        }
        while ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {

            $sqlstr = mysqli_query($GLOBALS['dbinv'], "select * from s_sttr where ST_REFNO='" . trim($rowinvcheq["refno"]) . "' and ST_CHNO ='" . trim($rowinvcheq["cheque_no"]) . "'") or die(mysqli_error());

            while ($rowstr = mysqli_fetch_array($sqlstr)) {
                //echo "select class from view_s_salma where Accname <> 'NON STOCK' and REF_NO='".trim($rowstr["ST_INVONO"])."' ";
                $sqltmp = mysqli_query($GLOBALS['dbinv'], "select class from view_s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($rowstr["ST_INVONO"]) . "' ") or die(mysqli_error());
                if ($rowstmp = mysqli_fetch_array($sqltmp)) {
                    //echo $rowstmp["class"];
                    if (trim($rowstmp["class"] == $InvClass)) {
                        $OutpDAMT = $OutpDAMT + $rowstr["ST_PAID"];
                    }
                }
            }
        }

////////////  Return Settlement PD Cheques////////////////////////////////////////////////////////	 
        $pend_ret_set = 0;
        $sqlview = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE CHE_DATE >'" . date("Y-m-d") . "' AND CUS_CODE='" . trim($cuscode) . "' and trn_type='RET'") or die(mysqli_error());
        $rowsview = mysqli_fetch_array($sqlview);
        if (is_null($rowsview["che_amount"]) == false) {
            $pend_ret_set = $rowsview["che_amount"];
        }


//////////// Reurn Cheques////////////////////////////////////// //   /////////////////////////////////
        if ($NewRefNo == $_GET["salesrep"]) {

            $sqlcheq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and (S_REF='" . $_GET["salesrep"] . "' or S_REF='" . $OldRefno . "') ") or die(mysqli_error());
        } else {

            $sqlcheq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='" . $_GET["salesrep"] . "' ") or die(mysqli_error());
        }
        $rowscheq = mysqli_fetch_array($sqlcheq);
        if (is_null($rowscheq["tot"]) == false) {
            $OutREtAmt = $rowscheq["tot"];
        } else {
            $OutREtAmt = 0;
        }


        /* $ResponseXML .= "<sales_table><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
          <tr><td>Outstanding Invoice Amount</td><td>".number_format($OutInvAmt, 2, ".", ",")."</td></tr>
          <td>Return Cheque Amount</td><td>".number_format($OutREtAmt, 2, ".", ",")."</td></tr>
          <td>Pending Cheque Amount</td><td>".number_format($OutpDAMT, 2, ".", ",")."</td></tr>
          <td>PSD Cheque Settlments</td><td>".number_format($pend_ret_set, 2, ".", ",")."</td></tr>
          <td>Total</td><td>".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."</td></tr>
          </table></table>]]></sales_table>"; */


        $ResponseXML .= "<sales_table><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutREtAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutpDAMT, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt + $OutREtAmt + $OutpDAMT + $pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table>";


        $sqlbrtrn = mysqli_query($GLOBALS['dbinv'], "select * from br_trn where Rep='" . trim($_GET["salesrep"]) . "' and brand='" . $InvClass . "' and cus_code='" . trim($cuscode) . "' ") or die(mysqli_error());
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





        $sql = mysqli_query($GLOBALS['dbinv'], "select dis from brand_mas where barnd_name = '" . trim($_GET["brand"]) . "'") or die(mysqli_error());
        if ($row = mysqli_fetch_array($sql)) {
            $ResponseXML .= "<dis><![CDATA[" . $row["dis"] . "]]></dis>";
        }
    }


    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "cancel_inv") {
    $sql = "select last_update from invpara  ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);

    mysqli_query($GLOBALS['dbinv'], "BEGIN");
    $sql1 = "delete from stk_take_mas_undelever where ref_no ='" . trim($_GET['refno']) . "' ";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

    $sql1 = "delete from stk_take_undelever where REF_NO ='" . trim($_GET['refno']) . "' ";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

    $sql1 = "delete from tmp_stk_take_undelever where REF_NO ='" . trim($_GET['refno']) . "' ";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);


    mysqli_query($GLOBALS['dbinv'], "COMMIT");

    echo "Canceled";
}

if ($_GET["Command"] == "add_tmp") {


    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    $mcount = 0;

    //$sql="delete from tmp_ord_data where tmp_no='".$_SESSION["tmp_no_ord"]."' and str_code='".$_GET['itemcode']."' ";
    //echo $sql;
    //$ResponseXML .= $sql;
    //$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
    //echo $_GET['rate'];
    //echo $_GET['qty'];
    //$sql="delete from tmp_stk_take_undelever  where REF_NO='".$_GET['refno']."'";
    //$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 	

    $rate = str_replace(",", "", $_GET["rate"]);
    $qty = str_replace(",", "", $_GET["qty"]);

    $sql_brand = "select * from s_mas where STK_NO='" . $_GET['itemcode'] . "'";
    $result_brand = mysqli_query($GLOBALS['dbinv'], $sql_brand);
    $row_brand = mysqli_fetch_array($result_brand);

    $sql = "Insert into tmp_stk_take_undelever (REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, QTY, damage, BRAND, COST,user_name)values 
			('" . $_GET['refno'] . "', '" . date("Y-m-d") . "', '" . $_GET['itemcode'] . "', '" . $_GET['item'] . "', '" . $_GET['part_no'] . "', " . $qty . ", 0, '" . $row_brand["BRAND_NAME"] . "', " . $rate . ",'" . $_SESSION["CURRENT_USER"] . "') ";

    //$ResponseXML .= $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);


    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              							 
                            </tr>";


    $sql = "Select * from tmp_stk_take_undelever where REF_NO='" . $_GET['refno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td >" . $row['STK_NO'] . "</a></td>
							 <td >" . $row['DESCRIPT'] . "</a></td>
							 <td >" . $row['PART_NO'] . "</a></td>
							 <td >" . number_format($row['COST'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['QTY'], 2, ".", ",") . "</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['STK_NO'] . "  name=" . $row['STK_NO'] . " onClick=\"del_item('" . $row['STK_NO'] . "');\"></td>";
    }
    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= " </salesdetails>";




    echo $ResponseXML;
}



if ($_GET['Command'] == "load_inv") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $mcount = 0;



    $sql = "select * from s_invo where ref_no like 'CRI/" . $_GET['refno'] . "%'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $sql = "delete from tmp_stk_take_undelever where ref_no = '" . $_GET['refno'] . "' and stk_no = '" . $row['STK_NO'] . "' and id = '" . $row['id'] . "' ";
        $result_m1 = mysqli_query($GLOBALS['dbinv'], $sql);

        $sql_brand = "select * from s_mas where STK_NO='" . $row['STK_NO'] . "'";
        $result_brand = mysqli_query($GLOBALS['dbinv'], $sql_brand);
        $row_brand = mysqli_fetch_array($result_brand);

        $sql = "Insert into tmp_stk_take_undelever (REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, QTY, damage, BRAND, COST,user_name)values 
			('" . $_GET['refno'] . "', '" . date("Y-m-d") . "', '" . $row['STK_NO'] . "', '" . $row_brand['DESCRIPT'] . "', '" . $row_brand['PART_NO'] . "', " . $row['QTY'] . ", 0, '" . $row_brand["BRAND_NAME"] . "', " . $row_brand['SELLING'] . ",'" . $_SESSION["CURRENT_USER"] . "') ";

        //$ResponseXML .= $sql;
        $result_m = mysqli_query($GLOBALS['dbinv'], $sql);
    }


    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              							 
                            </tr>";


    $sql = "Select * from tmp_stk_take_undelever where REF_NO='" . $_GET['refno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td >" . $row['STK_NO'] . "</a></td>
							 <td >" . $row['DESCRIPT'] . "</a></td>
							 <td >" . $row['PART_NO'] . "</a></td>
							 <td >" . number_format($row['COST'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['QTY'], 2, ".", ",") . "</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['STK_NO'] . "  name=" . $row['STK_NO'] . " onClick=\"del_item('" . $row['STK_NO'] . "');\"></td>";
    }
    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= " </salesdetails>";




    echo $ResponseXML;
}


if ($_GET["Command"] == "find_inv") {


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $mcount = 0;



    $rate = str_replace(",", "", $_GET["rate"]);
    $qty = str_replace(",", "", $_GET["qty"]);

    $sql = "select * from stk_take_undelever where REF_NO='" . $_GET['refno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $sql1 = "Insert into tmp_stk_take_undelever (REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, QTY, damage, BRAND, COST)values 
			('" . $row["REF_NO"] . "', '" . $row["SDATE"] . "', '" . $row["STK_NO"] . "', '" . $row['DESCRIPT'] . "', '" . $_GET['part_no'] . "', " . $row['QTY'] . ", 0, '" . $row["BRAND"] . "', " . $row["COST"] . ") ";

        $result_m = mysqli_query($GLOBALS['dbinv'], $sql1);
    }

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              							 
                            </tr>";


    $sql = "Select * from tmp_stk_take_undelever where REF_NO='" . $_GET['refno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td >" . $row['STK_NO'] . "</a></td>
							 <td >" . $row['DESCRIPT'] . "</a></td>
							 <td >" . number_format($row['PART_NO'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['cost'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['QTY'], 2, ".", ",") . "</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['STK_NO'] . "  name=" . $row['STK_NO'] . " onClick=\"del_item('" . $row['STK_NO'] . "');\"></td>";
    }
    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= " </salesdetails>";




    echo $ResponseXML;
}

if ($_GET["Command"] == "delete_inv") {
    $sql = "select * from S_CUSORDMAS where REF_NO= '" . trim($_GET["salesord1"]) . "' ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $sql1 = "UPDATE S_CUSORDMAS SET S_CUSORDMAS.CANCELL = '1' WHERE (((S_CUSORDMAS.REF_NO)='" . trim($_GET["salesord1"]) . "'))";

        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

        $sql1 = "UPDATE S_CUSORDTRN SET S_CUSORDTRN.CANCELL = '1' WHERE (((S_CUSORDTRN.REF_NO)='" . trim($_GET["salesord1"]) . "'))";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }
    echo "Canceled";
}


if ($_GET["Command"] == "del_item") {


    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_stk_take_undelever where REF_NO='" . $_GET['refno'] . "' and STK_NO='" . $_GET['code'] . "' ";
    //echo $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Part No</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              							 
                            </tr>";


    $sql = "Select * from tmp_stk_take_undelever where REF_NO='" . $_GET['refno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td >" . $row['STK_NO'] . "</a></td>
							 <td >" . $row['DESCRIPT'] . "</a></td>
							 <td >" . number_format($row['PART_NO'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['cost'], 2, ".", ",") . "</a></td>
							 <td >" . number_format($row['QTY'], 2, ".", ",") . "</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['STK_NO'] . "  name=" . $row['STK_NO'] . " onClick=\"del_item('" . $row['STK_NO'] . "');\"></td>";
    }
    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= " </salesdetails>";




    echo $ResponseXML;
}



if ($_GET["Command"] == "save_item") {


    //	$_SESSION["CURRENT_DOC"] = 1;      //document ID
    //$_SESSION["VIEW_DOC"] = false ;     //view current document
    //	$_SESSION["FEED_DOC"] = true;       //save  current document
    //	$_GET["MOD_DOC"] = false  ;         //delete   current document
    //	$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
    //	$_GET["PRICE_EDIT"] = false ;       //edit selling price
    //	$_GET["CHECK_USER"] = false ;       //check user permission again





    $sql = "Select *  from stk_take_mas_undelever where ref_no ='" . trim($_GET['refno']) . "' ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {

        $sql1 = "delete from stk_take_mas_undelever where ref_no ='" . trim($_GET['refno']) . "' ";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

        $sql1 = "delete from stk_take_undelever where REF_NO ='" . trim($_GET['refno']) . "' ";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }

    mysqli_query($GLOBALS['dbinv'], "BEGIN");

    $sql1 = "Insert into stk_take_mas_undelever (ref_no, sdate) values('" . trim($_GET['refno']) . "', '" . date("Y-m-d") . "')";
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);


    $sql = "Select *  from tmp_stk_take_undelever where REF_NO ='" . trim($_GET['refno']) . "' ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $sql1 = "Insert into stk_take_undelever (REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, QTY, damage, BRAND, COST) values('" . trim($row["REF_NO"]) . "', '" . date("Y-m-d") . "', '" . trim($row["STK_NO"]) . "','" . trim($row["DESCRIPT"]) . "','" . trim($row["PART_NO"]) . "'," . $row["QTY"] . "," . $row["damage"] . ",'" . trim($row["BRAND"]) . "'," . $row["COST"] . ")";
        //echo $sql1;
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }

    $sql = "delete  from tmp_stk_take_undelever where REF_NO ='" . trim($_GET['refno']) . "' ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    mysqli_query($GLOBALS['dbinv'], "COMMIT");


    echo "Saved";
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
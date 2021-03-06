<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once("connectioni.php");



////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "setbrand") {

    if ($_GET["stname"] == "claim_item") {

        echo "<table width=\"535\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><strong><font color=\"#FFFFFF\">Item No</font></strong></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><strong><font color=\"#FFFFFF\">Item Description</font></strong></td>
                              <td width=\"200\"  background=\"images/headingbg.gif\"><strong><font color=\"#FFFFFF\">Brand</font></strong></td>";

        $sql = "SELECT * from s_mas where BRAND_NAME='" . $_GET["brand"] . "' order by DESCRIPT limit 50";

        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        while ($row = mysqli_fetch_array($result)) {

            echo "<tr>               
                              <td onclick=\"itno_claim('" . $row['STK_NO'] . "', '" . $_GET["stname"] . "');\">" . $row['STK_NO'] . "</a></td>
                              <td onclick=\"itno_claim('" . $row['STK_NO'] . "', '" . $_GET["stname"] . "');\">" . $row['DESCRIPT'] . "</a></td>
							  <td onclick=\"itno_claim('" . $row['STK_NO'] . "', '" . $_GET["stname"] . "');\">" . $row['BRAND_NAME'] . "</a></td>";


            echo "</tr>";
        }
    }
}


if ($_GET["Command"] == "new_inv") {
    $sql = "select rebrefno from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "0000000" . $row["rebrefno"];
    $lenth = strlen($tmpinvno);
    $invno = trim("DEF/ ") . substr($tmpinvno, $lenth - 8);

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<cur_date><![CDATA[" . date("Y-m-d") . "]]></cur_date>";
    $ResponseXML .= "<cur_date2><![CDATA[" . date("Y-m-d") . "]]></cur_date2>";
    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}




if ($_GET["Command"] == "changechk") {

    $sql_tmp = "update tmp_auto_credit_note set status= '" . $_GET["chk"] . "' where code='" . $_GET["code"] . "'";
    $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
}

if ($_GET["Command"] == "update_man") {
    $sql_tmp = "update c_clamas set Mn_ob= '" . $_GET["txtmn_ob"] . "' where refno='" . $_GET["txtrefno"] . "'";

    $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
}

if ($_GET["Command"] == "save_inv") {

    if ((trim($_GET["Cmb_refund"]) == "Not Recommended") and ( trim($_GET["cmb_comm"]) == "Not Allowed")) {
        $commercial = 0;
    }
    if ((trim($_GET["Cmb_refund"]) == "Not Recommended") and ( trim($_GET["cmb_comm"]) == "Allowed")) {
        $commercial = 1;
    }
    if ((trim($_GET["Cmb_refund"]) == "Not Recommended") and ( trim($_GET["cmb_comm"]) == "Allowed") and ( $_GET["txtadd_ref1"] != 0)) {
        $commercial = 3;
    }
    if ((trim($_GET["Cmb_refund"]) == "Recommended") and ( trim($_GET["cmb_comm"]) == "Allowed") and ( $_GET["txtadd_ref1"] != 0)) {
        $commercial = 2;
    }
    if ((trim($_GET["Cmb_refund"]) == "Recommended") and ( trim($_GET["cmb_comm"]) == "Allowed") and ( $_GET["txtadd_ref1"] != 0) and ( $_GET["txtadd_ref2"] != 0)) {
        $commercial = 3;
    }

    if ((trim($_GET["Cmb_refund"]) == "Recommended") and ( trim($_GET["cmb_comm"]) == "Not Allowed")) {
        $commercial = 0;
    }

    if ((trim($_GET["Cmb_refund"]) == "Pending") and ( trim($_GET["cmb_comm"]) == "Not Allowed")) {
        $commercial = 0;
    }
    if ((trim($_GET["Cmb_refund"]) == "Pending") and ( trim($_GET["cmb_comm"]) == "Allowed")) {
        $commercial = 1;
    }



    if ($commercial == 0) {
        $approvedby = "";
    } else {
        $approvedby = $_GET["approvedby"];
    }

    if (trim($_GET["txtCRD_no"]) == "") {
        $txtCRD_no = 0;
    } else {
        $txtCRD_no = $_GET["txtCRD_no"];
    }

    if (trim($_GET["txtCRD_no2"]) == "") {
        $txtCRD_no2 = 0;
    } else {
        $txtCRD_no2 = $_GET["txtCRD_no2"];
    }

    if (trim($_GET["txtCRD_no3"]) == "") {
        $txtCRD_no3 = 0;
    } else {
        $txtCRD_no3 = $_GET["txtCRD_no3"];
    }

    $txtag_name = str_replace("~", "&", $_GET["txtag_name"]);
    $txtagadd = str_replace("~", "&", $_GET["txtagadd"]);
    $txtcus_name = str_replace("~", "&", $_GET["txtcus_name"]);
    $txtcus_add = str_replace("~", "&", $_GET["txtcus_add"]);

    $txttc_ob = str_replace("~", "&", $_GET["txttc_ob"]);
    $txttc_ob = str_replace("&nbsp;", " ", $txttc_ob);



    $sql = "SELECT * FROM c_clamas WHERE refno = '" . $_GET["txtrefno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {

        if (trim($_GET["txtadd_ref2"]) != "") {
            $txtadd_ref1 = $row["add_ref1"];
        } else {
            $txtadd_ref1 = $_GET["txtadd_ref1"];
        }

        $sql1 = "update c_clamas set c_subcode='" . $_GET['c_subcode'] . "', entdate='" . $_GET["txtentdate"] . "', recieve_date='" . $_GET["DTPicker_recdate"] . "', cl_no='" . $_GET["txtcl_no"] . "', ag_code='" . $_GET["txtag_code"] . "', ag_name='" . $txtag_name . "', agadd='" . $txtagadd . "', cus_name='" . $txtcus_name . "', cus_add='" . $txtcus_add . "', stk_no='" . $_GET["txtstk_no"] . "', des='" . $_GET["txtdes"] . "', brand='" . $_GET["txtbrand"] . "', siz='" . $_GET["txtsiz"] . "', pr='" . $_GET["txtpr"] . "', patt='" . $_GET["txtpatt"] . "', seri_no='" . $_GET["txtseri_no"] . "', tc_ob='" . $txttc_ob . "', Mn_ob='" . $_GET["txtmn_ob"] . "', remin='" . $_GET["txtremin"] . "', cldate='" . $_GET["txtCRE_date"] . "', spec='" . $_GET["txtspec"] . "', remming='" . $_GET["txtremming"] . "', ref_per='" . $_GET["txtref_per"] . "', CRD_no='" . $_GET["txtCRD_no"] . "', CRE_date='" . $_GET["txtCRE_date"] . "', CRE_amount='" . $_GET["txtCRE_amount"] . "', origin1='" . $_GET["txtorigin1"] . "', origin2='" . $_GET["txtorigin2"] . "', origin3='" . $_GET["txtorigin3"] . "', origin4='" . $_GET["txtorigin4"] . "', origin5='" . $_GET["txtorigin5"] . "', remin1='" . $_GET["txtremin1"] . "', remin2='" . $_GET["txtremin2"] . "', remin3='" . $_GET["txtremin3"] . "', remin4='" . $_GET["txtremin4"] . "', remin5='" . $_GET["txtremin5"] . "', rem_per='" . $_GET["txtrem_per"] . "', Refund='" . $_GET["Cmb_refund"] . "', Commercialy='" . $commercial . "', add_ref1='" . $txtadd_ref1 . "', add_ref2='" . $_GET["txtadd_ref2"] . "', approve_md_wd='" . $approvedby . "', gatepass='" . $_GET["dtf"] . "', returndate='" . $_GET["dtto"] . "', type='TYRE', DGRN_NO= '" . $txtCRD_no . "', DGRN_NO2= '" . $txtCRD_no2 . "', DGRN_NO3= '" . $txtCRD_no3 . "' where refno='" . $_GET["txtrefno"] . "'";
//        echo $sql1;
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);


        $sql = "delete from s_trn_defective where refno = '" . $_GET["txtrefno"] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql);
        $sql = "insert into s_trn_defective (SDATE,STK_NO,REFNO,QTY,LEDINDI) values ('" . $_GET["txtentdate"] . "','" . $_GET["txtstk_no"] . "','" . $_GET["txtrefno"] . "','1','DGRN') ";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql);
    } else {
        
        $sql1 = "SELECT * FROM c_clamas WHERE cl_no = '" . $_GET["txtcl_no"] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        if ($row1 = mysqli_fetch_array($result1)) {
            exit('Duplicate Claim No...!!! ');
        }
        
        $sql1 = "Update invpara set rebrefno=rebrefno+1";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

        $sql1 = "Update invpara set Claimno=Claimno+1";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);


        if ($_GET["txtCRE_date"] == "") {
            $mcredt1 = "0000-00-00";
        } else {
            $mcredt1 = $_GET["txtCRE_date"];
        }
        $sql1 = "insert into c_clamas  (c_subcode,refno, entdate, recieve_date, cl_no, ag_code, ag_name, agadd, cus_name, cus_add, stk_no, des, brand, siz, pr, patt, seri_no, tc_ob, Mn_ob, remin, cldate, spec, remming, ref_per, CRD_no, CRE_date, CRE_amount, origin1, origin2, origin3, origin4, origin5, remin1, remin2, remin3, remin4, remin5, rem_per, Refund, Commercialy, add_ref1, add_ref2, approve_md_wd, gatepass, returndate, type, DGRN_NO, DGRN_NO2, DGRN_NO3) values ('" . $_GET['c_subcode'] . "','" . $_GET["txtrefno"] . "', '" . $_GET["txtentdate"] . "', '" . $_GET["DTPicker_recdate"] . "', '" . $_GET["txtcl_no"] . "', '" . $_GET["txtag_code"] . "', '" . $txtag_name . "', '" . $txtagadd . "', '" . $txtcus_name . "', '" . $txtcus_add . "', '" . $_GET["txtstk_no"] . "', '" . $_GET["txtdes"] . "', '" . $_GET["txtbrand"] . "', '" . $_GET["txtsiz"] . "', '" . $_GET["txtpr"] . "', '" . $_GET["txtpatt"] . "', '" . $_GET["txtseri_no"] . "', '" . $txttc_ob . "', '" . $_GET["txtmn_ob"] . "', '" . $_GET["txtremin"] . "', '" . $mcredt1 . "', '" . $_GET["txtspec"] . "', '" . $_GET["txtremming"] . "', '" . $_GET["txtref_per"] . "', '" . $_GET["txtCRD_no"] . "', '" . $_GET["txtCRE_date"] . "', '" . $_GET["txtCRE_amount"] . "', '" . $_GET["txtorigin1"] . "', '" . $_GET["txtorigin2"] . "', '" . $_GET["txtorigin3"] . "', '" . $_GET["txtorigin4"] . "', '" . $_GET["txtorigin5"] . "', '" . $_GET["txtremin1"] . "', '" . $_GET["txtremin2"] . "', '" . $_GET["txtremin3"] . "', '" . $_GET["txtremin4"] . "', '" . $_GET["txtremin5"] . "', '" . $_GET["txtrem_per"] . "', '" . $_GET["Cmb_refund"] . "', '" . $commercial . "', '" . $_GET["txtadd_ref1"] . "', '" . $_GET["txtadd_ref2"] . "', '" . $approvedby . "', '" . $_GET["dtf"] . "', '" . $_GET["dtto"] . "', 'TYRE', '" . $txtCRD_no . "', '" . $txtCRD_no2 . "', '" . $txtCRD_no3 . "' )";
//        echo $sql1;
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

        $sql = "insert into s_trn_defective (SDATE,STK_NO,REFNO,QTY,LEDINDI) values ('" . $_GET["txtentdate"] . "','" . $_GET["txtstk_no"] . "','" . $_GET["txtrefno"] . "','1','DGRN') ";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql);

        $sql = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_GET["txtrefno"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'Item Claim', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql);
    }
    echo "Successfully Saved";
    /*
      $sql="delete from entry_log where refno = '".trim($_GET["invno"])."' and docname = 'Invoice' and trnType = 'Dlvrd'";
      $result =$db->RunQuery($sql);

      $sql="insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('".trim($_GET["invno"])."', '".$_SESSION["CURRENT_USER"]."', 'Invoice', 'Dlvrd', '".date("Y-m-d H:i:s")."', '".date("Y-m-d")."')";
      $result =$db->RunQuery($sql); */
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




if ($_GET["Command"] == "cancel_inv1") {
    $sql = "select * from c_clamas where refno='" . $_GET["txtrefno"] . "' and DGRN_NO='0' and DGRN_NO2='0' and DGRN_NO3='0'"; 
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    if (date("m", strtotime($row["entdate"])) == date("m")) {
        $sql1 = "delete from c_clamas where refno='" . $_GET["txtrefno"] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

         $sql = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_GET["txtrefno"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'Item Claim', 'Cancel', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql);

        echo "Deleted";
    } else {
        echo "Not in Current Month";
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

    $vatrate = 0.08;

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

    $vatrate = 0.08;

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
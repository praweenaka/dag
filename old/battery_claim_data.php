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
    $sql = "select Rebrefno_b from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "0000000" . $row["Rebrefno_b"];
    $lenth = strlen($tmpinvno);


    $ResponseXML = "";
    $invno = trim("DEF/BAT/") . substr($tmpinvno, $lenth - 8);
    $ResponseXML .= " <salesdetails>";
    $ResponseXML .= "<refno><![CDATA[" . $invno . "]]></refno>";
    $ResponseXML .= "<sdate><![CDATA[" . date('Y-m-d') . "]]></sdate>";
    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "changechk") {

    $sql_tmp = "update tmp_auto_credit_note set status= '" . $_GET["chk"] . "' where code='" . $_GET["code"] . "'";
    $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
}

if ($_GET["Command"] == "save_inv") {



    if ($_GET["Check1"] == "false") {
        $mchk = 0;
    } else {
        $mchk = 1;
    }

    $mcel1 = 0;
    $mcel2 = 0;
    $mcel3 = 0;
    $mcel4 = 0;
    $mcel5 = 0;
    $mcel6 = 0;

    if ($_GET["t11"] == "Good") {
        $mcel1 = 1;
    }
    if ($_GET["t12"] == "Good") {
        $mcel2 = 1;
    }
    if ($_GET["t13"] == "Good") {
        $mcel3 = 1;
    }
    if ($_GET["t14"] == "Good") {
        $mcel4 = 1;
    }
    if ($_GET["t15"] == "Good") {
        $mcel5 = 1;
    }
    if ($_GET["t16"] == "Good") {
        $mcel6 = 1;
    }

    if ($_GET["Cmb_refund"] == "Select") {
        $ResponseXML .= "<approval><![CDATA[Please select Claim Approval]]></approval>";

        exit();
    } else {
        $refund = $_GET["Cmb_refund"];
    }

    if ($_GET["Cmb_refund"] == "Recommended") {
        if ($_GET["cmb_cl_type"] == "Select") {
            $ResponseXML .= "<approval><![CDATA[Please select Approved Type]]></approval>";
            exit();
        } else {
            if ($_GET["cmb_cl_type"] == "FULL") {
                $ref_per = "100.00";
                $rem_per = "100.00";
            } else {
                $ref_per = "P-R";
                $rem_per = "P-R";
            }
            $spec = $_GET["cmb_cl_type"];
        }
    } else {
        if ($_GET["Cmb_refund"] == "Not Recommended") {
            if ($_GET["cmb_comm"] == "Select") {
                $ResponseXML .= "<approval><![CDATA[Please select Commercial Type]]></approval>";
                exit();
            } else {
                if ($_GET["cmb_comm"] == "Allowed") {
                    if ($_GET["cmb_c_Cl_type"] == "Select") {
                        $ResponseXML .= "<approval><![CDATA[Please select Commercial Approved Type]]></approval>";
                        exit();
                    } else {
                        if ($_GET["cmb_c_Cl_type"] == "FULL") {
                            $spec = $_GET["cmb_c_Cl_type"];
                            $mctype = 1;
                            $ref_per = "100.00";
                            $rem_per = "100.00";
                        } else {
                            $spec = $_GET["cmb_c_Cl_type"];
                            if ($_GET["txtadd_ref1"] != "") {
                                $mctype = 2;
                                $add_ref1 = $_GET["txtadd_ref1"];
                                $ref_per = $_GET["txtadd_ref1"];
                                $rem_per = $_GET["txtadd_ref1"];
                            } else {
                                if ($_GET["txtadd_ref2"] != "") {
                                    $ResponseXML .= "<message><![CDATA[Please Enter first adtional refund to 1]]></message>";
                                    exit();
                                }
                            }
                            if ($_GET["txtadd_ref2"] != "") {
                                $mctype = 3;
                                $add_ref2 = $_GET["txtadd_ref2"];
                                $ref_per = $_GET["txtadd_ref1"] + $_GET["txtadd_ref2"];
                                $rem_per = $_GET["txtadd_ref1"] + $_GET["txtadd_ref2"];
                            }
                        }
                    }
                }
                if ($_GET["cmb_comm"] == "Not Allowed") {
                    $mctype = 0;
                }
                $Commercialy = $mctype;
            }
        }
        $Type = "BAT";
    }

    $sql = "SELECT * FROM c_clamas WHERE refno = '" . $_GET["txtrefno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $sql1 = "update c_clamas  set c_subcode='" .  $_GET["c_subcode"] .  "',CCA='" . $_GET["t18"] . "',CCA2='" . $_GET["t28"] . "',CCA3='" . $_GET["t38"] . "' ,OCV='" . $_GET["t17"] . "',OCV2='" . $_GET["t27"] . "',OCV3='" . $_GET["t37"] . "' ,approve_md_wd ='" . $_GET['approvedby'] . "',entdate='" . $_GET["txtentdate"] . "', recieve_date='" . $_GET["DTPicker_recdate"] . "', Sold_date='" . $_GET["DTPicker_ddate"] . "', Sold_date_c='" . $_GET["DTPicker_cdate"] . "', Chk_date='" . $mchk . "', cl_no='" . $_GET["txtcl_no"] . "', ag_code='" . $_GET["txtag_code"] . "', ag_name='" . $_GET["txtag_name"] . "', agadd='" . $_GET["txtagadd"] . "', cus_name='" . $_GET["TXTCUS_NAME"] . "', cus_add='" . $_GET["txtcus_add"] . "', stk_no='" . $_GET["txtstk_no"] . "', des='" . $_GET["txtdes"] . "', brand='" . $_GET["txtbrand"] . "', siz='" . $_GET["txtsiz"] . "', pr='" . $_GET["txtpr"] . "', patt='" . $_GET["txtpatt"] . "', seri_no='" . $_GET["txtseri_no"] . "', Cell1_el=" . $mcel1 . ", Cell2_el=" . $mcel2 . ", Cell3_el=" . $mcel3 . ", Cell4_el=" . $mcel4 . ", Cell5_el=" . $mcel5 . ", Cell6_el=" . $mcel6 . ", Cell1_Ispg=" . $_GET["t21"] . ", Cell2_Ispg=" . $_GET["t22"] . ", Cell3_Ispg=" . $_GET["t23"] . ", Cell4_Ispg=" . $_GET["t24"] . ", Cell5_Ispg=" . $_GET["t25"] . ", Cell6_Ispg=" . $_GET["t26"] . ", Cell1_Aspg=" . $_GET["t31"] . ", Cell2_Aspg=" . $_GET["t32"] . ", Cell3_Aspg=" . $_GET["t33"] . ", Cell4_Aspg=" . $_GET["t34"] . ", Cell5_Aspg=" . $_GET["t35"] . ", Cell6_Aspg=" . $_GET["t36"] . ", tc_ob='" . $_GET["txttc_ob"] . "', Mn_ob='" . $_GET["txtmn_ob"] . "', Refund='" . $_GET["Cmb_refund"] . "', ref_per='" . $ref_per . "', rem_per='" . $rem_per . "', spec='" . $spec . "', add_ref1='" . $add_ref1 . "', add_ref2='" . $add_ref2 . "', Commercialy='" . $mctype . "', type='BAT' where refno='" . $_GET["txtrefno"] . "'";
        echo $sql1;
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
		$sql = "delete from s_trn_defective where refno = '"  . $_GET["txtrefno"] . "'";	
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		$sql = "insert into s_trn_defective (SDATE,STK_NO,REFNO,QTY,LEDINDI) values ('" . $_GET["txtentdate"]  . "','" . $_GET["txtstk_no"]  . "','" . $_GET["txtrefno"]  . "','1','DGRN') ";
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql) ; 		
			
	} else {
        $sql1 = "Update invpara set Rebrefno_b=Rebrefno_b+1";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        $sql1 = "insert into c_clamas  (c_subcode,approve_md_wd,refno, entdate, recieve_date, Sold_date, Sold_date_c, Chk_date, cl_no, ag_code, ag_name, agadd, cus_name, cus_add, stk_no, des, brand, siz, pr, patt, seri_no, Cell1_el, Cell2_el, Cell3_el, Cell4_el, Cell5_el, Cell6_el, Cell1_Ispg, Cell2_Ispg, Cell3_Ispg, Cell4_Ispg, Cell5_Ispg, Cell6_Ispg, Cell1_Aspg, Cell2_Aspg, Cell3_Aspg, Cell4_Aspg, Cell5_Aspg, Cell6_Aspg, tc_ob, Mn_ob, Refund, ref_per, rem_per, spec, add_ref1, add_ref2, Commercialy, type,OCV,OCV2,OCV3,CCA,CCA2,CCA3) values ('"  . $_GET["c_subcode"] . "','" . $_GET['approvedby'] . "','" . $_GET["txtrefno"] . "', '" . $_GET["txtentdate"] . "', '" . $_GET["DTPicker_recdate"] . "', '" . $_GET["DTPicker_ddate"] . "', '" . $_GET["DTPicker_cdate"] . "', '" . $mchk . "', '" . $_GET["txtcl_no"] . "', '" . $_GET["txtag_code"] . "', '" . $_GET["txtag_name"] . "', '" . $_GET["txtagadd"] . "', '" . $_GET["TXTCUS_NAME"] . "', '" . $_GET["txtcus_add"] . "', '" . $_GET["txtstk_no"] . "', '" . $_GET["txtdes"] . "', '" . $_GET["txtbrand"] . "', '" . $_GET["txtsiz"] . "', '" . $_GET["txtpr"] . "', '" . $_GET["txtpatt"] . "', '" . $_GET["txtseri_no"] . "', " . $mcel1 . ", " . $mcel2 . ", " . $mcel3 . ", " . $mcel4 . ", " . $mcel5 . ", " . $mcel6 . ", " . $_GET["t21"] . ", " . $_GET["t22"] . ", " . $_GET["t23"] . ", " . $_GET["t24"] . ", " . $_GET["t25"] . ", " . $_GET["t26"] . ", " . $_GET["t31"] . ", " . $_GET["t32"] . ", " . $_GET["t33"] . ", " . $_GET["t34"] . ", " . $_GET["t35"] . ", " . $_GET["t36"] . ", '" . $_GET["txttc_ob"] . "', '" . $_GET["txtmn_ob"] . "', '" . $_GET["Cmb_refund"] . "', '" . $ref_per . "', '" . $rem_per . "', '" . $spec . "', '" . $add_ref1 . "', '" . $add_ref2 . "', '" . $mctype . "', 'BAT', '" . $_GET["t17"] . "', '" . $_GET["t27"] . "', '" . $_GET["t37"] . "','" . $_GET["t18"] . "', '" . $_GET["t28"] . "', '" . $_GET["t38"] . "')";
        echo $sql1;
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
		
			$sql = "delete from s_trn_defective where refno = '"  . $_GET["txtrefno"] . "'";	
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql) ; 
		$sql = "insert into s_trn_defective (SDATE,STK_NO,REFNO,QTY,LEDINDI) values ('" . $_GET["txtentdate"]  . "','" . $_GET["txtstk_no"]  . "','" . $_GET["txtrefno"]  . "','1','DGRN') ";
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql) ; 		
			
		
	}
}

if ($_GET['Command'] == "dtdiff") {
    $dt1 = $_GET['dt1'];
    $dt2 = $_GET['dt2'];
    $dt3 = $_GET['dt11'];
   // echo $dt1;
     $numMonths = (strtotime($dt2)-strtotime($dt1));   
   //$numMonths = 1 + (date("Y", $timeEnd) - date("Y", $timeStart)) * 12;
// Add/subtract month difference
   // $numMonths += date("m", $timeEnd) - date("m", $timeStart);
   
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
   
    $diff = abs(strtotime($dt2) - strtotime($dt1));
    $days = floor($diff / (60*60*24*30));
    

    $diff = abs(strtotime($dt2) - strtotime($dt3));
    $days1 = floor($diff / (60*60*24*30));
    
	
	
	 $ResponseXML .= "<ddays><![CDATA[" . ($days+1) . "]]></ddays>";
	 $ResponseXML .= "<ddays1><![CDATA[" . ($days1+1) . "]]></ddays1>";
     $ResponseXML .= " </salesdetails>";
	echo $ResponseXML;
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

if ($_GET["Command"] == "cancel_inv") {
    $sql = "select * from c_clamas where refno='" . $_GET["txtrefno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    if (date("m", strtotime($row["entdate"])) == date("m")) {
        $sql1 = "delete from c_clamas where refno='" . $_GET["txtrefno"] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        echo "Deleted";
    } else {
        echo "Can't Delete";
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
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
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

        include_once ("connectioni.php");

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
        $ResponseXML .= "<taxname><![CDATA[Tax (VAT 8%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "svat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (SVAT 8%)]]></taxname>";

        $invtot = number_format($row['tot_sub'] + $tax, 2, ".", ",");
        $ResponseXML .= "<invtot><![CDATA[" . $invtot . "]]></invtot>";
    } else if ($_GET["vatmethod"] == "evat") {
        $tax = $row['tot_sub'] * $vatrate;
        $taxf = number_format($tax, 2, ".", ",");

        $ResponseXML .= "<tax><![CDATA[" . $taxf . "]]></tax>";
        $ResponseXML .= "<taxname><![CDATA[Tax (EVAT 8%)]]></taxname>";

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
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
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

        include_once ("connectioni.php");

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
  
}
?>
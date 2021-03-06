<?php

session_start();



include_once("connectioni.php");

if ($_GET["Command"] == "search_inv") {

    $ResponseXML = "";

    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"table-bordered\">
                            <tr>
                              <td width=\"220\" >Invoice No</td>
                              <td width=\"424\" >Customer</td>
							  <td width=\"424\" >Invoice Date</td>
							  <td width=\"424\" >Invoice Value</td>
                             
   							</tr>";

    if ($_GET["mstatus"] == "invno") {
        $letters = $_GET['invno'];
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_salma where CANCELL='0' and DEV='" . $_SESSION["dev"] . "' and REF_NO like  '$letters%' limit 50") or die(mysqli_error());
    } else if ($_GET["mstatus"] == "customername") {
        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_salma where CANCELL='0' and DEV='" . $_SESSION["dev"] . "' and CUS_NAME like  '$letters%' limit 50") or die(mysqli_error()) or die(mysqli_error());
    } else {
        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_salma where CANCELL='0' and DEV='" . $_SESSION["dev"] . "' and CUS_NAME like  '$letters%' limit 50") or die(mysqli_error()) or die(mysqli_error());
    }



    while ($row = mysqli_fetch_array($sql)) {
        $REF_NO = $row['REF_NO'];
        $stname = "inv_mast";

        if ($_GET["stname"] == "grn") {

            $ResponseXML .= "<tr>               
                              	<td onclick=\"invno_inv('" . $row['REF_NO'] . "', '" . $_GET['stname'] . "');\">" . $row['REF_NO'] . "</a></td>
                              	<td onclick=\"invno_inv('" . $row['REF_NO'] . "', '" . $_GET['stname'] . "');\">" . $row["CUS_NAME"] . "</a></td>
                              	<td onclick=\"invno_inv('" . $row['REF_NO'] . "', '" . $_GET['stname'] . "');\">" . $row['SDATE'] . "</a></td>
                                <td onclick=\"invno_inv('" . $row['REF_NO'] . "', '" . $_GET['stname'] . "');\">" . $row['GRAND_TOT'] . "</a></td>
                            	</tr>";
        } else {
            $ResponseXML .= "<tr>
                           	<td onclick=\"invno_inv('" . $row['REF_NO'] . "', '" . $_GET['stname'] . "');\">" . $row['REF_NO'] . "</a></td>
                              	<td onclick=\"invno_inv('" . $row['REF_NO'] . "', '" . $_GET['stname'] . "');\">" . $row['CUS_NAME'] . "</a></td>
                              	<td onclick=\"invno_inv('" . $row['REF_NO'] . "', '" . $_GET['stname'] . "');\">" . $row['SDATE'] . "</a></td>
                                <td onclick=\"invno_inv('" . $row['REF_NO'] . "', '" . $_GET['stname'] . "');\">" . $row['GRAND_TOT'] . "</a></td>                        	
                            	</tr>";
        }
    }

    $ResponseXML .= "   </table>";


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
    $inv = $_GET['invno'];
    $_SESSION["invno"] = $_GET['invno'];

    $_SESSION["custno"] = $_GET['custno'];
    $_SESSION["brand"] = $_GET["brand"];
    $_SESSION["department"] = $_GET["department"];
    //$tmpinvno="0000".substr($_GET['invno'], 4, 7) ;
    //$lenth=strlen($tmpinvno);
    //$serial=substr($tmpinvno, $lenth-7);
    //$inv=substr($_GET['invno'], 0, 3).substr("\ ", 0, 1).$serial;
    //$a="Select * from s_salma where REF_NO='".$inv."'";
    //echo $a;
    $sqlxl = mysqli_query($GLOBALS['dbinv'], "Select * from s_salma where REF_NO='" . $inv . "'") or die(mysqli_error());
    $row_xl = mysqli_fetch_array($sqlxl);

    $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from invpara") or die(mysqli_error());
    $row_invpara = mysqli_fetch_array($sql);

    $sql_vat = mysqli_query($GLOBALS['dbinv'], "SELECT * from vatrate where sdate<='" . $row_xl["SDATE"] . "' order by sdate desc") or die(mysqli_error());
    $row_vat = mysqli_fetch_array($sql_vat);

    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_salma where REF_NO='" . $inv . "'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($sql)) {

        $sdate = $row['SDATE'];
        $ResponseXML .= "<str_invoiceno><![CDATA[" . $row['REF_NO'] . "]]></str_invoiceno>";
        $ResponseXML .= "<SDATE><![CDATA[" . $row['SDATE'] . "]]></SDATE>";
        $ResponseXML .= "<str_crecash><![CDATA[" . $row['TYPE'] . "]]></str_crecash>";
        $cuscode = $row['C_CODE'];
        $ResponseXML .= "<str_customecode><![CDATA[" . $row['C_CODE'] . "]]></str_customecode>";
        $_SESSION["tmp_no_salinv"] = $row['tmp_no'];

        /* $sqlcustomer = mysqli_query($GLOBALS['dbinv'],"Select * from vendor where CODE='".$row['C_CODE']."'") or die(mysqli_error());
          if($rowcustomer = mysqli_fetch_array($sqlcustomer)){
          $ResponseXML .= "<str_customername><![CDATA[".$rowcustomer['NAME']."]]></str_customername>";
          $ResponseXML .= "<str_address><![CDATA[".$rowcustomer['ADD1']." ".$rowcustomer['ADD2']."]]></str_address>";
          $ResponseXML .= "<str_vatno1><![CDATA[".$rowcustomer['vatno']."]]></str_vatno1>";
          $ResponseXML .= "<str_vatno2><![CDATA[".$rowcustomer['svatno']."]]></str_vatno2>";
          } */

        $ResponseXML .= "<str_customername><![CDATA[" . $row['CUS_NAME'] . "]]></str_customername>";
        $ResponseXML .= "<SVAT><![CDATA[" . $row['SVAT'] . "]]></SVAT>";

        $sql_mas = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $row['C_CODE'] . "'") or die(mysqli_error());
        $row_mas = mysqli_fetch_array($sql_mas);
        //$add=$row_mas['ADD1']." ".$row_mas['ADD2'];

        $ResponseXML .= "<str_address><![CDATA[" . $row_mas['ADD1'] . "]]></str_address>";
        $ResponseXML .= "<str_address2><![CDATA[" . $row_mas['ADD2'] . "]]></str_address2>";
        $ResponseXML .= "<str_vatno1><![CDATA[" . $row_mas['vatno'] . "]]></str_vatno1>";
        $ResponseXML .= "<str_vatno2><![CDATA[" . $row_mas['svatno'] . "]]></str_vatno2>";
        $ResponseXML .= "<delitype><![CDATA[" . $row['transp'] . "]]></delitype>";

        //$ResponseXML .= "<str_vatno2><![CDATA[".$row['str_vatno2']."]]></str_vatno2>";
        $ResponseXML .= "<str_salesrep><![CDATA[" . $row['SAL_EX'] . "]]></str_salesrep>";
        $salrep = $row['SAL_EX'];
        //$ResponseXML .= "<str_salesorder1><![CDATA[".$row['str_salesorder1']."]]></str_salesorder1>";
        //$ResponseXML .= "<str_salesorder2><![CDATA[".$row['str_salesorder2']."]]></str_salesorder2>";
        $ResponseXML .= "<dte_deliverdate><![CDATA[" . $row['REQ_DATE'] . "]]></dte_deliverdate>";
        $ResponseXML .= "<str_orderno1><![CDATA[" . $row['ORD_NO'] . "]]></str_orderno1>";
        $ResponseXML .= "<str_orderno2><![CDATA[" . $row['ORD_DA'] . "]]></str_orderno2>";
        //$ResponseXML .= "<cur_credit><![CDATA[".$row['cur_credit']."]]></cur_credit>";
        //$ResponseXML .= "<cur_balance><![CDATA[".$row['cur_balance']."]]></cur_balance>";
        $ResponseXML .= "<promotion><![CDATA[" . $row['Costcenter'] . "]]></promotion>";


        $ResponseXML .= "<str_department><![CDATA[" . $row['DEPARTMENT'] . "]]></str_department>";
        $ResponseXML .= "<str_brand><![CDATA[" . $row['Brand'] . "]]></str_brand>";
        $brand = $row['Brand'];
        $ResponseXML .= "<str_vat><![CDATA[" . $row['VAT'] . "]]></str_vat>";
        $VAT_add = $row['VAT'];
        //$ResponseXML .= "<cur_discount1><![CDATA[".$row['cur_discount1']."]]></cur_discount1>";
        //$ResponseXML .= "<cur_discount2><![CDATA[".$row['cur_discount2']."]]></cur_discount2>";
        $ResponseXML .= "<cur_subtotal><![CDATA[" . number_format($row['AMOUNT'], 2, ".", ",") . "]]></cur_subtotal>";
        $ResponseXML .= "<cur_discount><![CDATA[" . number_format($row['DISCOU'], 2, ".", ",") . "]]></cur_discount>";
        if (($VAT_add == "1") or ( $VAT_add == "2") or ( $VAT_add == "3")) {
            $vat_val = $row['AMOUNT'] * $row_vat["vatrate"] / 100;
        } else {
            $vat_val = 0;
        }

        $ResponseXML .= "<cur_tax><![CDATA[" . number_format($vat_val, 2, ".", ",") . "]]></cur_tax>";
        $grand_tot = $row['AMOUNT'] + $vat_val;

        //$ResponseXML .= "<cur_invoiceval><![CDATA[".number_format($grand_tot, 2, ".", ",")."]]></cur_invoiceval>";
        $ResponseXML .= "<cur_invoiceval><![CDATA[" . number_format($row['GRAND_TOT'], 2, ".", ",") . "]]></cur_invoiceval>";
        if ($row['deli_name'] == "") {
            $ResponseXML .= "<deli_chk1><![CDATA[" . 'N' . "]]></deli_chk1>";
        } else {
            $ResponseXML .= "<deli_chk1><![CDATA[" . 'Y' . "]]></deli_chk1>";
        }


        $ResponseXML .= "<deli_name><![CDATA[" . $row['deli_name'] . "]]></deli_name>";
        $ResponseXML .= "<deli_add><![CDATA[" . $row['deli_add'] . "]]></deli_add>";
        $ResponseXML .= "<cred_per><![CDATA[" . $row['cre_pe'] . "]]></cred_per>";

        if ($_SESSION["CURRENT_USER"] == "buddhika1" or $_SESSION["CURRENT_USER"] == "BUDDHIKA1" or $_SESSION["CURRENT_USER"] == "Buddhika1" or $_SESSION["CURRENT_USER"] == "admin") {
            $ResponseXML .= "<cred_but><![CDATA[" . 'Y' . "]]></cred_but>";
        } else {
            $ResponseXML .= "<cred_but><![CDATA[" . 'N' . "]]></cred_but>";
        }
    }


    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\"><tr>
                              <td>Code</td>
                              <td>Description</td>
                              <td>Rate</td>
                              <td>Qty</td>
                              <td>Discount</td>
                              <td>Sub Total</td>
							  <td>AD</td>
                            </tr>";

    $i = 1;
    $sql_data = mysqli_query($GLOBALS['dbinv'], "delete from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_salinv"] . "'") or die(mysqli_error());
    //echo "Select * from s_invo where REF_NO='".$inv."'";
    $sql_data = mysqli_query($GLOBALS['dbinv'], "Select * from s_invo where REF_NO='" . $inv . "'") or die(mysqli_error());
    while ($row = mysqli_fetch_array($sql_data)) {
        $sql_itdata = mysqli_query($GLOBALS['dbinv'], "Select * from s_mas where STK_NO='" . $row['STK_NO'] . "' and BRAND_NAME='" . $brand . "'") or die(mysqli_error());
        $rowit = mysqli_fetch_array($sql_itdata);


        //$sql_tmp = mysqli_query($GLOBALS['dbinv'],"Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, cur_subtot) values ( '".$row['REFNO']."', '".$row['STK_NO']."', '".$rowit['DESCRIPT']."', ".$rowit['SELLING'].", ".$row['QTY'].", ".$rowit['SELLING']*$row['QTY'].")") or die(mysqli_error());
        //	echo "Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$inv."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".$row["subtot"].", '".$row['BRAND']."')";
        //$sql="Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$inv."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', ".$row['PRICE'].", ".$row['QTY'].", ".$row['DIS_per'].", ".$row['DIS_rs'].", ".$row["subtot"].", '".$row['BRAND']."')";

        if ($VAT_add == "1") {

            $PRICE = $row['PRICE'] / (1 + ($row["TAX_PER"] / 100));
        } else {
            $PRICE = $row['PRICE'];
        }

        $subtot_wo_disc = (floatval($PRICE) * floatval($row['QTY']));
        $disco = $subtot_wo_disc * floatval($row['DIS_per']) / 100;
        $subtot = $subtot_wo_disc - $disco;
        //echo $subtot;

        $dis_per1 = $row["Print_dis1"];
        $dis_per2 = $row["Print_dis2"];
        $dis_per3 = $row["Print_dis3"];



        $sql_tmp = mysqli_query($GLOBALS['dbinv'], "Insert into tmp_inv_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand, ad, tmp_no) values ( '" . $inv . "', '" . $row['STK_NO'] . "', '" . $row['DESCRIPT'] . "', " . $PRICE . ", " . $row['QTY'] . ", " . $row['DIS_per'] . ", " . $row['DIS_rs'] . ", " . $subtot . ", '" . $row['BRAND'] . "', '" . $row['ad'] . "', '" . $_SESSION["tmp_no_salinv"] . "')") or die(mysqli_error());

        $ad = "ad" . $i;


        $ResponseXML .= "<tr>
                           	
						    <td onClick=\"disp_qty('" . $row['STK_NO'] . "');\">" . $row['STK_NO'] . "</a></td>
  							 <td onClick=\"disp_qty('" . $row['STK_NO'] . "');\">" . $row['DESCRIPT'] . "</a></td>
							 <td onClick=\"disp_qty('" . $row['STK_NO'] . "');\">" . number_format($PRICE, 2, ".", ",") . "</a></td>
							 <td onClick=\"disp_qty('" . $row['STK_NO'] . "');\">" . $row['QTY'] . "</a></td>
							 <td onClick=\"disp_qty('" . $row['STK_NO'] . "');\">" . $row['DIS_per'] . "</td>
							 <td onClick=\"disp_qty('" . $row['STK_NO'] . "');\">" . number_format($subtot, 2, ".", ",") . "</a></td>
							 <td>" . $row['ad'] . "</td>";

        /* 	 if ($row['ad']=="1"){
          $ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."' checked></td>";
          } else {
          $ResponseXML .= "<td><input type=\"checkbox\" onClick=\"chk_ad('".$i."');\" name='".$ad."' id='".$ad."'></td>";
          }
          $ResponseXML .= "<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td> */

        $ResponseXML .= "</tr>";

        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= "<dis><![CDATA[" . $dis_per1 . "]]></dis>";
    $ResponseXML .= "<dis1><![CDATA[" . $dis_per2 . "]]></dis1>";
    $ResponseXML .= "<dis2><![CDATA[" . $dis_per3 . "]]></dis2>";
    $ResponseXML .= "<cur_discount1><![CDATA[" . number_format($dis_per1, 2, ".", ",") . "]]></cur_discount1>";
    $ResponseXML .= "<cur_discount2><![CDATA[" . number_format($dis_per2, 2, ".", ",") . "]]></cur_discount2>";
    $ResponseXML .= "<cur_discount3><![CDATA[" . number_format($dis_per3, 2, ".", ",") . "]]></cur_discount3>";


    /* 		$sql = mysqli_query($GLOBALS['dbinv'],"DROP VIEW view_s_salma") or die(mysqli_error());
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

    $sqloutinv = mysqli_query($GLOBALS['dbinv'], "select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='" . trim($cuscode) . "' and SAL_EX='" . trim($salrep) . "' and class='" . $InvClass . "'") or die(mysqli_error());
    if ($rowoutinv = mysqli_fetch_array($sqloutinv)) {
        if (is_null($rowoutinv["totout"]) == false) {
            $OutInvAmt = $rowoutinv["totout"];
        }
    }

    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM s_invcheq WHERE che_date>'" . date("Y-m-d") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='REC' and sal_ex='" . trim($salrep) . "'") or die(mysqli_error());
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

    $sqlinvcheq = mysqli_query($GLOBALS['dbinv'], "SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'" . date("Y-m-d") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='RET'") or die(mysqli_error());
    if ($rowinvcheq = mysqli_fetch_array($sqlinvcheq)) {
        if (is_null($rowinvcheq["che_amount"]) == false) {
            $pend_ret_set = $rowinvcheq["che_amount"];
        }
    }


    $sqlcheq = mysqli_query($GLOBALS['dbinv'], "Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='" . trim($salrep) . "'") or die(mysqli_error());
    if ($rowcheq = mysqli_fetch_array($sqlcheq)) {
        if (is_null($rowcheq["tot"]) == false) {
            $OutREtAmt = $rowcheq["tot"];
        } else {
            $OutREtAmt = 0;
        }
    }





    $ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td width=\"200\"><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutInvAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutREtAmt, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($OutpDAMT, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"" . number_format($pend_ret_set, 2, ".", ",") . "\" disabled=\"disabled\"/></td></tr>
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


    $_SESSION["print"] = 1;

    echo $ResponseXML;
}

if ($_GET["Command"] == "assign_brand") {
    $_SESSION["brand"] = $_GET["brand"];
}

mysqli_close($GLOBALS['dbinv']);
?>

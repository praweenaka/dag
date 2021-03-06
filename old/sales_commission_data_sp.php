<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once("connectioni.php");



////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');
date_default_timezone_set('Asia/Colombo');

$MSHFlexGrid1 = array(array());
$MSHFlexGrid1_count = 0;
$gridchk = array(array());


if ($_GET["Command"] == "grnhistory") {

    $txtgrntot = "";

    $year = substr($_GET["dtMonth"], 0, 4);
    $month = substr($_GET["dtMonth"], 5, 2);

    $ii = 1;

    $sql_rsgen = "select * from s_crnma where CANCELL='0' and month(SDATE) =" . $month . " and   year(SDATE) =" . $year . " and SAL_EX='" . trim($_GET["cmbrep"]) . "' and DEV='" . $_GET["cmbdev"] . "'";
    $result_rsgen = mysqli_query($GLOBALS['dbinv'], $sql_rsgen);
    while ($row_rsgen = mysqli_fetch_array($result_rsgen)) {

        $TypeGrid1[$ii][0] = "GRN";
        $TypeGrid1[$ii][1] = $row_rsgen["REF_NO"];
        $TypeGrid1[$ii][2] = $row_rsgen["GRAND_TOT"];
        $TypeGrid1[$ii][3] = $row_rsgen["INVOICENO"];


        $sql_rs_salm = "Select SDATE, GRAND_TOT, DUMMY_VAL from s_salma where Accname <> 'NON STOCK' and REF_NO='" . $row_rsgen["INVOICENO"] . "' ";
        $result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
        if ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {
            $TypeGrid1[$ii][4] = $row_rs_salm["SDATE"];
            $TypeGrid1[$ii][5] = $row_rs_salm["GRAND_TOT"];
            $TypeGrid1[$ii][6] = $row_rs_salm["DUMMY_VAL"];
            if (($row_rs_salm["DUMMY_VAL"] > 0) and ($row_rs_salm["GRAND_TOT"] > 0)) {
                $TypeGrid1[$ii][7] = ($row_rs_salm["DUMMY_VAL"] / $row_rs_salm["GRAND_TOT"]) * $row_rsgen["GRAND_TOT"];
            }
        }
        $TypeGrid1[$ii][8] = $row_rsgen["DIS1"];
        $txtgrntot = $_GET["txtgrntot"] + $TypeGrid1[$ii][7] + $TypeGrid1[$ii][8];
        $ii = $ii + 1;
    }




    $sql_rsgen = "select * from cred where CANCELL='0' and month(C_DATE) =" . $month . " and   year(C_DATE) =" . $year . " and C_SALEX='" . trim($_GET["cmbrep"]) . "' and DEV='" . $_GET["cmbdev"] . "' ";
    $result_rsgen = mysqli_query($GLOBALS['dbinv'], $sql_rsgen);
    while ($row_rsgen = mysqli_fetch_array($result_rsgen)) {

        $sql_rsbal = "Select * from c_bal where REFNO = '" . $row_rsgen["C_REFNO"] . " ' and flag1 <> '1'";
        $result_rsbal = mysqli_query($GLOBALS['dbinv'], $sql_rsbal);
        if ($row_rsbal = mysqli_fetch_array($result_rsbal)) {

            $TypeGrid1[$ii][0] = "CRN";
            $TypeGrid1[$ii][1] = $row_rsgen["C_REFNO"];
            $TypeGrid1[$ii][2] = $row_rsgen["C_PAYMENT"];
            $TypeGrid1[$ii][3] = $row_rsgen["C_INVNO"];

            $sql_rs_salm = "Select SDATE,GRAND_TOT,DUMMY_VAL from s_salma where Accname <> 'NON STOCK' and REF_NO='" . $row_rsgen["C_INVNO"] . "'";
            $result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
            if ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {

                $TypeGrid1[$ii][4] = $row_rs_salm["SDATE"];
                $TypeGrid1[$ii][5] = $row_rs_salm["GRAND_TOT"];
                $TypeGrid1[$ii][6] = $row_rs_salm["DUMMY_VAL"];
                if ($row_rs_salm["DUMMY_VAL"] == 0) {
                    $TypeGrid1[$ii][7] = 0;
                } else {
                    $TypeGrid1[$ii][7] = ($row_rs_salm["DUMMY_VAL"] / $row_rs_salm["GRAND_TOT"]) * $row_rsgen["C_PAYMENT"];
                }
            }
            if (is_null($row_rsgen["SETTLED"]) == false) {
                $TypeGrid1[$ii][8] = $row_rsgen["SETTLED"];
            }
            $txtgrntot = $txtgrntot + $TypeGrid1[$ii][7] + $TypeGrid1[$ii][8];
            $ii = $ii + 1;
        }
    }

    $TypeGrid1_count = $ii;

    $TypeGrid1[0][1] = "";
    $TypeGrid1[0][1] = "GRN/CRN NO";
    $TypeGrid1[0][2] = "Amount";
    $TypeGrid1[0][3] = "Invoice No";
    $TypeGrid1[0][4] = "IN.Date";
    $TypeGrid1[0][5] = "IN.Amount";
    $TypeGrid1[0][6] = "Paid";
    $TypeGrid1[0][7] = "Commi";
    $TypeGrid1[0][8] = "Comm.Manu";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $ResponseXML .= "<TypeGrid1><![CDATA[ <table  border=1  cellspacing=0>		";
    $r = 0;
    while ($TypeGrid1_count > $r) {

        $gtype = "gtype" . $r;
        $grnno = "grnno" . $r;
        $Commi = "Commi" . $r;
        $commman = "CommManu" . $r;


        $ResponseXML .= "<tr>
						<td><div id=\"" . $gtype . "\">" . $TypeGrid1[$r][0] . "</div></td>
						<td><div id=\"" . $grnno . "\">" . $TypeGrid1[$r][1] . "</div></td>
						<td>" . $TypeGrid1[$r][2] . "</td>
						<td>" . $TypeGrid1[$r][3] . "</td>
						<td>" . $TypeGrid1[$r][4] . "</td>
						<td>" . $TypeGrid1[$r][5] . "</td>
						<td>" . $TypeGrid1[$r][6] . "</td>
						<td><div id=\"" . $Commi . "\">" . $TypeGrid1[$r][7] . "</div></td>";
        if ($r != 0) {
            $ResponseXML .= "<td><input type=\"text\" name=\"" . $commman . "\" id=\"" . $commman . "\" value=\"" . $TypeGrid1[$r][8] . "\" /></td>
						</tr>";
        } else {
            $ResponseXML .= "<td>" . $TypeGrid1[$r][8] . "</td>
						</tr>";
        }
        $r = $r + 1;
    }

    $ResponseXML .= "   </table>]]></TypeGrid1>";
    $ResponseXML .= "<mcount><![CDATA[" . $r . "]]></mcount>";


    $ResponseXML .= " </salesdetails>";
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
            $Commi_val = $_GET[$Commi];
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
    $txtpr4 = $_GET["txtpre"] . " %";
    $txtNoComCOm = $_GET["txtNoCom_COm"];

    //$txtsale4= $_GET["nosale"];

    $year = substr($_GET["dtMonth"], 0, 4);
    $month = substr($_GET["dtMonth"], 5, 2);

    $rep = $_GET["cmbrep"];

    /* if ($year<=2014){	
      $txtvat_new=12;
      } else {
      $txtvat_new=11;
      } */

    //If DNUSER.CONUSER.State = 0 Then DNUSER.CONUSER.Open
    $sql = "delete from tmpcommition ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sql_inv = "select * from s_salma where Accname != 'NON STOCK' and SAL_EX='" . $rep . "' and month(SDATE)=" . $month . " AND YEAR(SDATE)=" . $year . " and CANCELL='0' and DEV='" . $_GET["cmbdev"] . "'";
    //echo $sql_inv;
    $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
    while ($row_inv = mysqli_fetch_array($result_inv)) {

//===============================================Choose Commission Catogory=====================================
        $day1 = 0;
        $day2 = 0;
        $cat1 = 0;
        $cat2 = 0;
        $cat3 = 0;

        $sql_cat = "select * from com_she where sal_ex='" . trim($_GET["cmbrep"]) . "' and Brand='" . trim($row_inv["Brand"]) . "'";
        // if (trim($row_inv["REF_NO"])=="BEN/CR/070701/12"){	
        //echo $sql_cat;
        //}
        $result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
        $row_cat = mysqli_fetch_array($result_cat);
        $day1 = $row_cat["Day1"];
        $day2 = $row_cat["Day2"];

        $txtbalSAleTOT = str_replace(",", "", $_GET["txtbalSAleTOT"]);
        $txtt2 = str_replace(",", "", $_GET["txtt2"]);
        $txtt1 = str_replace(",", "", $_GET["txtt1"]);

        if ($txtbalSAleTOT > $txtt2) {
            $cat1 = $row_cat["T3_cat1"];
            $cat2 = $row_cat["T3_cat2"];
            $cat3 = $row_cat["T3_cat3"];
            $tarcat = 3;
        } else if ($txtbalSAleTOT > $txtt1) {
            $cat1 = $row_cat["T2_Cat1"];
            $cat2 = $row_cat["T2_cat2"];
            $cat3 = $row_cat["T2_Cat3"];
            $tarcat = 2;
        } else {
            $cat1 = $row_cat["T1_Cat1"];
            $cat2 = $row_cat["T1_cat2"];
            $cat3 = $row_cat["T1_cat3"];
            $tarcat = 1;
        }

        $sql_rsven = "Select incdays from vendor where CODE = '" . trim($row_inv["C_CODE"]) . "'";
        $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
        $row_rsven = mysqli_fetch_array($result_rsven);
        if ($row_rsven["incdays"] > $day1) {
            $day1 = $row_rsven["incdays"] + 1;
            $day2 = $row_rsven["incdays"] + 1;
        }

        /* if ($row_inv["cre_pe"] > $day1) {
          $day1 = $row_inv["cre_pe"] + 1;
          $day2 = $row_inv["cre_pe"] + 1;
          } */

//=========================================================================


        $sql_sttr = "SELECT * FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' and userid='" . $_SESSION['UserName'] . "'";
        //echo $sql_sttr;
        $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
        if ($row_sttr = mysqli_fetch_array($result_sttr)) {

            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            while ($row_sttr = mysqli_fetch_array($result_sttr)) {

                $sql_compr = "select * from brand_mas where barnd_name='" . trim($roq_inv["Brand"]) . "'";
                $result_compr = mysqli_query($GLOBALS['dbinv'], $sql_compr);
                $row_compr = mysqli_fetch_array($result_compr);

                $due = $row_inv["GRAND_TOT"] - $row_inv["TOTPAY"];
                $pay_type = $row_sttr["ST_REFNO"] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $row_sttr["ST_CHNO"];

                $D_75 = 0;
                $D_76_90 = 0;
                $D_91 = 0;
                $commission = 0;

                if ($row_sttr["ST_FLAG"] == "UT") {
                    $days = 0;
                    $apdays = 0;
                } else {
                    $apdays = $row_sttr["del_days"];
                    $diff = abs(strtotime($row_inv["SDATE"]) - strtotime($row_sttr["ST_CHDATE"]));
                    $days = floor($diff / (60 * 60 * 24));
                }
                //echo "apdays-".$apdays."/day1-".$day1."/day2-".$day2."/cat2-".$cat2."/ST_PAID-".$row_sttr["ST_PAID"]."/txtvat-".$_GET["txtvat"]."/DEV-".$row_inv["DEV"]."#";
                if ($year <= 2014) {
                    $txtvat_new = 12;
                } else {
                    $txtvat_new = 11;
                }
                if ($apdays < $day1) {
                    //echo "(S1)";
                    $D_75 = $row_sttr["ST_PAID"];
                    if ($row_inv["DEV"] == "1") {
                        $commission = $cat1 * $row_sttr["ST_PAID"] * 0.01;
                    }
                    if ($row_inv["DEV"] == "0") {
                        $commission = $cat1 * $row_sttr["ST_PAID"] * 0.01 / (1 + ($txtvat_new / 100));
                    }
                }

                if (($apdays > $day1 - 1) and ($apdays < $day2)) {
                    if ($cat2 > 0) {
                        //echo "(S2)";
                        $D_76_90 = $row_sttr["ST_PAID"];
                        if ($row_inv["DEV"] == "1") {
                            $commission = $cat2 * $row_sttr["ST_PAID"] * 0.01;
                        }
                        if ($row_inv["DEV"] == "0") {
                            $commission = $cat2 * $row_sttr["ST_PAID"] * 0.01 / (1 + ($txtvat_new / 100));
                        }
                    } else {
                        //echo "(S3)";
                        $D_91 = $row_sttr["ST_PAID"];
                        if ($row_inv["DEV"] == "1") {
                            $commission = $cat2 * $row_sttr["ST_PAID"] * 0.01;
                        }
                        if ($row_inv["DEV"] == "0") {
                            $commission = $cat2 * $row_sttr["ST_PAID"] * 0.01 / (1 + ($txtvat_new / 100));
                        }
                    }
                }

                if ($apdays > ($day2 - 1)) {

                    // if (trim($row_inv["REF_NO"])=="BEN/CR/070701/12"){	
                    //	echo "day 2-".$day2;
                    // }	
                    //	echo "(S4)";
                    $D_91 = $row_sttr["ST_PAID"];
                    if ($row_inv["DEV"] == "1") {
                        $commission = $cat3 * $row_sttr["ST_PAID"] * 0.01;
                    }
                    if ($row_inv["DEV"] == "0") {
                        $commission = $cat3 * $row_sttr["ST_PAID"] * 0.01 / (1 + ($txtvat_new / 100));
                    }
                }

                $sql = "insert into tmpcommition(SDATE, REFNO, COS_CODE, cus_name, AMOUNT, DUE, pay_type, PAY_DATE, PAY_AMOUNT, brand, dev, DATES, apdays, D_75, D_76_90, D_91, commission)  values ('" . $row_inv["SDATE"] . "', '" . trim($row_inv["REF_NO"]) . "', '" . $row_inv["C_CODE"] . "', '" . $row_inv["CUS_NAME"] . "', " . $row_inv["GRAND_TOT"] . ", " . $due . ", '" . $pay_type . "', '" . $row_sttr["ST_DATE"] . "', " . $row_sttr["ST_PAID"] . ", '" . $row_inv["Brand"] . "', '" . $row_inv["dev"] . "', " . $days . ", " . $apdays . ", " . $D_75 . ", " . $D_76_90 . ", " . $D_91 . ", " . $commission . ")";
                //echo "1-".$sql;
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
            }
        } else {

            $due = $row_inv["GRAND_TOT"] - $row_inv["TOTPAY"];
            $sql = "insert into tmpcommition(SDATE, REFNO, COS_CODE, cus_name, AMOUNT, DUE, brand, dev, PAY_AMOUNT)  values ('" . $row_inv["SDATE"] . "', '" . trim($row_inv["REF_NO"]) . "', '" . $row_inv["C_CODE"] . "', '" . $row_inv["CUS_NAME"] . "', " . $row_inv["GRAND_TOT"] . ", " . $due . ", '" . $row_inv["Brand"] . "', '" . $row_inv["dev"] . "', 0)";
            //echo "2-".$sql;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
        }


        $totamount = $totamount + $row_inv["GRAND_TOT"];
        $totdue = $totdue + $row_inv["GRAND_TOT"] - $row_inv["TOTPAY"];
    }

    if ($_GET["cmbdev"] == "0") {

        $sql_CRN = "select * from cred where year(C_DATE) =" . $year . " and  month(C_DATE) =" . $month . " and   C_SALEX='" . trim($_GET["cmbrep"]) . "'   and CANCELL='0'";
        $result_CRN = mysqli_query($GLOBALS['dbinv'], $sql_CRN);
        while ($row_CRN = mysqli_fetch_array($result_CRN)) {

            $cat1 = 0;
            $sql_cat = "select * from com_she where sal_ex='" . trim($_GET["cmbrep"]) . "' and Brand='" . trim($row_CRN["Brand"]) . "'";
            $result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
            if ($row_cat = mysqli_fetch_array($result_cat)) {

                if ($tarcat == 1) {
                    $cat1 = $row_cat["T1_Cat1"];
                }
                if ($tarcat == 2) {
                    $cat1 = $row_cat["T2_Cat1"];
                }
                if ($tarcat == 3) {
                    $cat1 = $row_cat["T3_cat1"];
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

            $sql = "insert into tmpcommition(SDATE, REFNO, COS_CODE, cus_name, return, AMOUNT, dev, commission, brand)  values ('" . $row_CRN["C_DATE"] . "', '" . $row_CRN["C_REFNO"] . "', '" . $row_CRN["C_CODE"] . "', '" . $cus_name . "', " . $row_CRN["C_PAYMENT"] . ", " . (-1 * $row_CRN["C_PAYMENT"]) . ", '" . $dev . "', " . $commission . ", '" . $row_CRN["Brand"] . "')";
            //echo "3-".$sql;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);


            $totreturn = $totreturn + $row_CRN["C_PAYMENT"];
        }

        $sql_grn = "select * from view_crnma where month(SDATE) =" . $month . " and   year(SDATE) =" . $year . " and SAL_EX='" . trim($_GET["cmbrep"]) . "' and CANCELL='0' and trn_type2='GRN'";
        $result_grn = mysqli_query($GLOBALS['dbinv'], $sql_grn);
        while ($row_grn = mysqli_fetch_array($result_grn)) {

            $cat1 = 0;

            $sql_cat = "select * from com_she where sal_ex='" . trim($_GET["cmbrep"]) . "' and Brand='" . trim($row_grn["Brand"]) . "'";
            $result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
            if ($row_cat = mysqli_fetch_array($result_cat)) {

                if ($tarcat == 1) {
                    $cat1 = $row_cat["T1_Cat1"];
                }
                if ($tarcat == 2) {
                    $cat1 = $row_cat["T2_Cat1"];
                }
                if ($tarcat == 3) {
                    $cat1 = $row_cat["T3_cat1"];
                }
            }

            $sql_invdiv = "select *  from s_salma where Accname <> 'NON STOCK' and REF_NO='" . $row_grn["INVOICENO"] . "'";
            $result_invdiv = mysqli_query($GLOBALS['dbinv'], $sql_invdiv);

            $sql_compr = "select * from brand_mas where barnd_name='" . trim($row_grn["Brand"]) . "'";
            $result_compr = mysqli_query($GLOBALS['dbinv'], $sql_compr);

            if (($row_invdiv = mysqli_fetch_array($result_invdiv)) and ($row_compr = mysqli_fetch_array($result_compr))) {
                $dev = $row_invdiv["DEV"];
            } else if ($row_compr = mysqli_fetch_array($result_compr)) {
                $dev = "0";
            }

            $sql = "insert into tmpcommition(SDATE, REFNO, COS_CODE, cus_name, return, AMOUNT, dev, brand)  values ('" . $row_grn["SDATE"] . "', '" . $row_grn["REF_NO"] . "', '" . $row_grn["C_CODE"] . "', '" . $row_grn["CUS_NAME"] . "', " . $row_grn["GRAND_TOT"] . ", " . (-1 * $row_grn["GRAND_TOT"]) . ", '" . $dev . "', '" . $row_CRN["Brand"] . "')";
            //echo "4-".$sql;
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

    include("connectioni.php");

    $year = substr($_GET["dtMonth"], 0, 4);
    $month = substr($_GET["dtMonth"], 5, 2);

    if ($_GET["lblComm"] == "Locked") {
        $sql = "update s_salma set Comm='Y' where SAL_EX='" . trim($_GET["cmbrep"]) . "' and month(SDATE)='" . $month . "' and year(SDATE)='" . $year . "'";

        $result = mysqli_query($GLOBALS['dbinv'], $sql);
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
    $txtNocomm = str_replace(",", "", $_GET["txtNocomm"]);
    $txtcat2com = str_replace(",", "", $_GET["txtcat2com"]);
    $txtNoCom_COm = str_replace(",", "", $_GET["txtNoCom_COm"]);


    $txtcat1sale = str_replace(",", "", $_GET["txtcat1sale"]);
    $txtcat1Spsale = str_replace(",", "", $_GET["txtcat1Spsale"]);
    $txtcat2sale = str_replace(",", "", $_GET["txtcat2sale"]);
    $txtcat1Com = str_replace(",", "", $_GET["txtcat1Com"]);
    $txtcat1Spcomm = str_replace(",", "", $_GET["txtcat1Spcomm"]);
    $txtret = str_replace(",", "", $_GET["txtret"]);

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
    }
    if ($txtComGRN == "") {
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

        //$year=substr($_GET["dtMonth"], 0, 4);
        //$month=substr($_GET["dtMonth"], 5, 2);

        $year = date("Y", strtotime($_GET["dtMonth"]));
        $month = date("m", strtotime($_GET["dtMonth"]));

        $mrefno = $month . "/" . $year . "-" . $_GET["cmbrep"] . "- Bal -" . $_GET["cmbdev"];

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

        $sql = "insert into s_commadva(refno, sale, ded, advance, rep, comdate, sdate, Dedcap1, Dedcap2, Dedcap3, Dedcap4, Dedcap5, Dedcap6, Dedcap7, Dedamount1, Dedamount2, Dedamount3, Dedamount4, Dedamount5, Dedamount6, Dedamount7, Over60out, Returnchk, Over60Ratio, Sale_tyre, Sale_battery, Sale_AW, Com_tyre, Com_battery, Com_AW, Com_tube, FLAG, Lock1, appby, appdate, chno, dev) values ('" . $mrefno . "', " . $txtBalsale . ", " . $ded . ", " . $advance . ", '" . $_GET["cmbrep"] . "', '" . $_GET["dtMonth"] . "', '" . date("Y-m-d") . "', '" . $_GET["txtdes1"] . "', '" . $_GET["txtdes2"] . "', '" . $_GET["txtdes3"] . "', '" . $_GET["txtdes4"] . "', '" . $_GET["txtdes5"] . "', 'GRN', 'GRN Com', " . $txtdedamt1 . ", " . $txtdedamt2 . ", " . $txtdedamt3 . ", " . $txtdedamt4 . ", " . $txtdedamt5 . ", " . $txtret . ", " . $txtComGRN . ", " . $txtNocomm . ",  " . $returnchk . ", '" . $_GET["txtpre"] . "', " . $txtcat1sale . ", " . $txtcat1Spsale . ", " . $txtcat2sale . ", " . $txtcat1Com . ", " . $txtcat1Spcomm . ", " . $txtcat2com . ", " . $txtNoCom_COm . ", 'BAL', 1, '" . $_SESSION["CURRENT_USER"] . "', '" . date("Y-m-d") . "', '0', '" . $_GET["cmbdev"] . "')";
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


if ($_GET["Command"] == "view_summery") {
    include('connectioni.php');

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql_st = "delete from tmp_s_sttr where userid='" . $_SESSION['UserName'] . "'";
    $result_st = mysqli_query($GLOBALS['dbinv'], $sql_st);

    $sql_st = "delete from tmp_s_salma  where userid='" . $_SESSION['UserName'] . "'";
    $result_st = mysqli_query($GLOBALS['dbinv'], $sql_st);


    $year = substr($_GET["dtMonth"], 0, 4);
    $month = substr($_GET["dtMonth"], 5, 2);

    /* if ($year<=2014){	
      $txtvat_new=12;
      } else {
      $txtvat_new=11;
      } */

    $mrefno = $month . "/" . $year . "-" . $_GET["cmbrep"] . "-" . $_GET["cmbdev"];

    $sql_commadva = "select * from s_commadva where refno='" . $mrefno . "'";
    //echo $sql_commadva;
    $result_commadva = mysqli_query($GLOBALS['dbinv'], $sql_commadva);
    if ($row_commadva = mysqli_fetch_array($result_commadva)) {
        $ResponseXML .= "<txtdedamt2><![CDATA[" . $row_commadva["advance"] . "]]></txtdedamt2>";
    }

    //$GRAND_TOT=0;
    //$outstanding=0;

    $sql = "select * from s_salma where Accname != 'NON STOCK' and month(SDATE)='" . $month . "' and year(SDATE)='" . $year . "' and SAL_EX='" . $_GET["cmbrep"] . "' and CANCELL='0'";
    //echo $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {


        //$GRAND_TOT=$row["GRAND_TOT"];
        $sql_st1 = "insert into tmp_s_salma (REF_NO, TRN_TYPE, SDATE, C_CODE, CUS_NAME, C_ADD1, TYPE, SAL_EX, DISCOU, AMOUNT, GST, GRAND_TOT, DUMMY_VAL, DIS, DIS1, DIS2, DIS_RUP, CASH, TOTPAY, ORD_NO, ORD_DA, SETTLED, TOTPAY1, DES_CAT, DEPARTMENT, REMARK, CANCELL, BTT, VAT, VAT_VAL, Brand, DEV, Account, Accname, Costcenter, RET_AMO, cre_pe, Comm, red, deli_date, seri_no, points, LOCK1, deliin, SVAT, REQ_DATE, tmp_no, vat_no, s_vat_no, userid) values ('" . $row["REF_NO"] . "', '" . $row["TRN_TYPE"] . "', '" . $row["SDATE"] . "', '" . $row["C_CODE"] . "', '" . $row["CUS_NAME"] . "', '" . $row["C_ADD1"] . "', '" . $row["TYPE"] . "', '" . $row["SAL_EX"] . "', " . $row["DISCOU"] . ", " . $row["AMOUNT"] . ", " . $row["GST"] . ", " . $row["GRAND_TOT"] . ", " . $row["DUMMY_VAL"] . ", " . $row["DIS"] . ", " . $row["DIS1"] . ", " . $row["DIS2"] . ", " . $row["DIS_RUP"] . ", " . $row["CASH"] . ", " . $row["TOTPAY"] . ", '" . $row["ORD_NO"] . "', '" . $row["ORD_DA"] . "', '" . $row["SETTLED"] . "', '" . $row["TOTPAY1"] . "', '" . $row["DES_CAT"] . "', '" . $row["DEPARTMENT"] . "', '" . $row["REMARK"] . "', '" . $row["CANCELL"] . "', '" . $row["BTT"] . "', '" . $row["VAT"] . "', " . $row["VAT_VAL"] . ", '" . $row["Brand"] . "', '" . $row["DEV"] . "', '" . $row["Account"] . "', '" . $row["Accname"] . "', '" . $row["Costcenter"] . "', " . $row["RET_AMO"] . ", " . $row["cre_pe"] . ", '" . $row["Comm"] . "', '" . $row["red"] . "', '" . $row["deli_date"] . "', '" . $row["seri_no"] . "', '" . $row["points"] . "', '" . $row["LOCK1"] . "', '" . $row["deliin"] . "', " . $row["SVAT"] . ", '" . $row["REQ_DATE"] . "', '" . $row["tmp_no"] . "', '" . $row["vat_no"] . "', '" . $row["s_vat_no"] . "', '" . $_SESSION['UserName'] . "')";
        //echo $sql_st;
        $result_st1 = mysqli_query($GLOBALS['dbinv'], $sql_st1);

        //$sql_st1="insert into tmp_s_salma select * FROM s_salma where REF_NO='".$row["REF_NO"]."'";
        //echo $sql_st;
        //$result_st1=mysqli_query($GLOBALS['dbinv'],$sql_st1); 

        $sql_sttr = "select * FROM s_sttr where ST_INVONO='" . $row["REF_NO"] . "'";
        //echo $sql;
        $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
        while ($row_sttr = mysqli_fetch_array($result_sttr)) {

            if (is_numeric($row_sttr["del_days"]) == false) {
                $del_days = 0;
            } else {
                $del_days = $row_sttr["del_days"];
            }
            $sql_sttr1 = "insert into tmp_s_sttr (ID, ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_FLAG, ST_INDATE, st_chbank, st_days, ST_CHNO, DUE, SETTLED_NO, DEV, ret_chval, ret_chset, st_chedate, st_chdate, cus_code, ap_days, comm, ap_rem, del_days, deliin_days, deliin_amo, deliin_lock, department, tmp_no, userid) values (" . $row_sttr["ID"] . ", '" . $row_sttr["ST_REFNO"] . "', '" . $row_sttr["ST_DATE"] . "', '" . $row_sttr["ST_INVONO"] . "', " . $row_sttr["ST_PAID"] . ", '" . $row_sttr["ST_FLAG"] . "', '" . $row_sttr["ST_INDATE"] . "', '" . $row_sttr["st_chbank"] . "', " . $row_sttr["st_days"] . ", '" . $row_sttr["ST_CHNO"] . "', " . $row_sttr["DUE"] . ", " . $row_sttr["SETTLED_NO"] . ", '" . $row_sttr["DEV"] . "', " . $row_sttr["ret_chval"] . ", " . $row_sttr["ret_chset"] . ", '" . $row_sttr["st_chedate"] . "', '" . $row_sttr["st_chdate"] . "', '" . $row_sttr["cus_code"] . "', " . $row_sttr["ap_days"] . ", '" . $row_sttr["comm"] . "', '" . $row_sttr["ap_rem"] . "', " . $del_days . ", " . $row_sttr["deliin_days"] . ", " . $row_sttr["deliin_amo"] . ", '" . $row_sttr["deliin_lock"] . "', '" . $row_sttr["department"] . "', '" . $row_sttr["tmp_no"] . "', '" . $_SESSION['UserName'] . "')";
            //if ($row_sttr["ST_INVONO"]=="BEN/CR/066135/1"){
            //echo $sql_sttr1."</br>";
            //}	
            //echo $sql_sttr1;
            $result_sttr1 = mysqli_query($GLOBALS['dbinv'], $sql_sttr1);
        }
        //$sql_st="insert into tmp_s_sttr select * FROM s_sttr where ST_INVONO='".$row["REF_NO"]."'";
        //echo $sql_st;
        //$result_st=mysqli_query($GLOBALS['dbinv'],$sql_st); 
    }

    $sql_st = "select * from tmp_s_sttr where userid='" . $_SESSION['UserName'] . "' order by ST_INVONO";
    //echo $sql_st;
    $result_st = mysqli_query($GLOBALS['dbinv'], $sql_st);
    while ($row_st = mysqli_fetch_array($result_st)) {

        $sql = "select * from tmp_s_salma where REF_NO = '" . $row_st["ST_INVONO"] . "'";
        //echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);

        //$GRAND_TOT=$GRAND_TOT-$row_st["ST_PAID"];
        //if (($row_st["ST_INVONO"]=="BEN/CR/072131/20") or ($row_st["ST_INVONO"]=="BEN/CR/072280/20")){
        //	echo "Inv-".$row_st["ST_INVONO"]."--";
        //}

        $days = 0;
        if (trim($row_st["ST_FLAG"]) == "UT") {
            if ((is_null($row["deli_date"]) == false) and ($row["deli_date"] != "0000-00-00")) {
                $diff = abs(strtotime($row_st["ST_DATE"]) - strtotime($row["deli_date"]));
                $days = floor($diff / (60 * 60 * 24));

                //	if (($row_st["ST_INVONO"]=="BEN/CR/072131/20") or ($row_st["ST_INVONO"]=="BEN/CR/072280/20")){
                //	echo $row_st["ST_INVONO"]."-3-".$row["deli_date"]."-".$days."-".$row_st["st_chdate"];
                //}
            } else {
                $diff = abs(strtotime($row_st["ST_DATE"]) - strtotime($row["SDATE"]));
                $days = floor($diff / (60 * 60 * 24));
                //if (($row_st["ST_INVONO"]=="BEN/CR/072131/20") or ($row_st["ST_INVONO"]=="BEN/CR/072280/20")){
                //	echo "2-".$row["SDATE"]."-".$days."-".$row_st["ST_DATE"];
                //}	
            }
        } else {
            if ((is_null($row["deli_date"]) == false) and ($row["deli_date"] != "0000-00-00")) {
                $diff = abs(strtotime($row_st["st_chdate"]) - strtotime($row["deli_date"]));
                $days = floor($diff / (60 * 60 * 24));
                //if (($row_st["ST_INVONO"]=="BEN/CR/072131/20") or ($row_st["ST_INVONO"]=="BEN/CR/072280/20")){
                //	echo $row_st["ST_INVONO"]."-3-".$row["deli_date"]."-".$days."-".$row_st["st_chdate"];
                //}	
            } else {
                $diff = abs(strtotime($row_st["st_chdate"]) - strtotime($row["SDATE"]));
                $days = floor($diff / (60 * 60 * 24));
                //if (($row_st["st_chdate"]=="BEN/CR/072131/20") or ($row_st["SDATE"]=="BEN/CR/072280/20")){
                //	echo "4-".$row["st_chdate"]."-".$days."-".$row_st["deli_date"];
                //}	
            }
        }



        if (is_null($row_st["comm"]) == false) {
            if (trim($row_st["comm"]) == "Yes") {
                $sql1 = "update s_sttr set del_days=" . $row_st["ap_days"] . " where ID=" . $row_st["ID"];
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                //echo "1-".$sql1;
                $sql1 = "update tmp_s_sttr set del_days=" . $row_st["ap_days"] . " where ID=" . $row_st["ID"] . " and userid='" . $_SESSION['UserName'] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

                //if (($row_st["ID"]=="138019") or ($row_st["ID"]=="138016")){
                //	echo $sql1;
                //}	
            } else {
                $sql1 = "update s_sttr set del_days=" . $days . " where ID=" . $row_st["ID"];
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                //	echo "2-".$sql1;

                $sql1 = "update tmp_s_sttr set del_days=" . $days . " where ID=" . $row_st["ID"] . " and userid='" . $_SESSION['UserName'] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

                //if (($row_st["ID"]=="138019") or ($row_st["ID"]=="138016")){
                //	echo $sql1;
                //}
            }
        } else {
            $sql1 = "update s_sttr set del_days=" . $days . " where ID=" . $row_st["ID"];
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

            $sql1 = "update tmp_s_sttr set del_days=" . $days . " where ID=" . $row_st["ID"] . " and userid='" . $_SESSION['UserName'] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

            //if (($row_st["ID"]=="138019") or ($row_st["ID"]=="138016")){
            //		echo $sql1;
            //	}
        }
    }
    //if ($GRAND_TOT>0){
    //echo $row["REF_NO"]."-".$GRAND_TOT;
    //}	
    //}



    $m_update = true;
    if ($m_update == true) {
        $sql1 = "update s_salma set DIS='0' where month(SDATE)='" . $month . "' AND year(SDATE)='" . $year . "' AND SAL_EX='" . $_GET["cmbrep"] . "' AND CANCELL='0'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

        $sql1 = "update tmp_s_salma set DIS='0' where month(SDATE)='" . $month . "' AND year(SDATE)='" . $year . "' AND SAL_EX='" . $_GET["cmbrep"] . "' AND CANCELL='0' and userid='" . $_SESSION['UserName'] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }

    $sql1 = "SELECT SUM(AMOUNT)AS RETAMU,SUM(AMOUNT/(1+vatrate/100))AS RETAMU1   FROM c_bal WHERE (flag1 = '0') and MONTH(SDATE)='" . $month . "' AND YEAR(SDATE) ='" . $year . "' AND SAL_EX='" . $_GET["cmbrep"] . "' AND CANCELL='0' and (trn_type='GRN' or  trn_type='CNT' ) and DEV='" . $_GET["cmbdev"] . "' ";
    //echo $sql1;
    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    if ($row1 = mysqli_fetch_array($result1)) {
        if (is_null($row1["RETAMU"]) == false) {
            $totret = $row1["RETAMU"];
            $totret_w = $row1["RETAMU1"];
        }
    }

    if ($_GET["cmbdev"] == "All") {
        $sql_inv = "select SUM(GRAND_TOT) AS SALEAMU,SUM(GRAND_TOT/(1+gst/100)) AS SALEAMU1  from tmp_s_salma where Accname != 'NON STOCK' and month(SDATE)='" . $month . "' AND YEAR(SDATE)='" . $year . "' AND SAL_EX='" . $_GET["cmbrep"] . "' AND CANCELL='0' and userid='" . $_SESSION['UserName'] . "'";
        $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
        if ($row_inv = mysqli_fetch_array($result_inv)) {
            if (is_null($row_inv["SALEAMU"]) == false) {
                $TOTSALE = $row_inv["SALEAMU"];
                $TOTSALE_w = $row_inv["SALEAMU1"];
            }
        }
    } else {
        $sql_inv = "select SUM(GRAND_TOT) AS SALEAMU,SUM(GRAND_TOT/(1+gst/100)) AS SALEAMU1  from tmp_s_salma where Accname != 'NON STOCK' and month(SDATE)='" . $month . "' AND YEAR(SDATE)='" . $year . "' AND SAL_EX='" . $_GET["cmbrep"] . "' AND CANCELL='0' and dev='" . trim($_GET["cmbdev"]) . "' and userid='" . $_SESSION['UserName'] . "'";
        $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
        if ($row_inv = mysqli_fetch_array($result_inv)) {
            if (is_null($row_inv["SALEAMU"]) == false) {
                $TOTSALE = $row_inv["SALEAMU"];
                $TOTSALE_w = $row_inv["SALEAMU1"];
            }
        }
    }

    $sql_inv = "select SUM(GRAND_TOT) AS SALEAMU,SUM(GRAND_TOT/(1+gst/100)) AS SALEAMU1  from tmp_s_salma where Accname != 'NON STOCK' and month(SDATE)='" . $month . "' AND YEAR(SDATE)='" . $year . "' AND SAL_EX='" . $_GET["cmbrep"] . "' AND CANCELL='0' and userid='" . $_SESSION['UserName'] . "'";
    $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
    if ($row_inv = mysqli_fetch_array($result_inv)) {
        if (is_null($row_inv["SALEAMU"]) == false) {
            $TOTSALEALL = $row_inv["SALEAMU"];
            $TOTSALEALL_w = $row_inv["SALEAMU1"];
        }
    }



//==============find target=============================================

    $sql_TAR = "select * from sal_comm where sal_ex='" . $_GET["cmbrep"] . "'";
    $result_TAR = mysqli_query($GLOBALS['dbinv'], $sql_TAR);
    if ($row_TAR = mysqli_fetch_array($result_TAR)) {
        $txtt1 = $row_TAR["T1"];
        $txtt2 = $row_TAR["T2"];
    }

    $ResponseXML .= "<txtt1><![CDATA[" . $txtt1 . "]]></txtt1>";
    $ResponseXML .= "<txtt2><![CDATA[" . $txtt2 . "]]></txtt2>";
//========================================
    /* if ($year<=2014){		
      //$txtvat=0.12;
      $txtvat=12;
      } else {
      //$txtvat=0.11;
      $txtvat=11;
      } */

    $netSale = ($TOTSALEALL - $totret) / (1 + ($txtvat / 100)) - $_GET["txtRetChkAmou_D1"];
    $netSale = ($TOTSALEALL_w - $totret_w) - $_GET["txtRetChkAmou_D1"];

    if ($_GET["cmbdev"] == "1") {
        $txtBalsale = $TOTSALE / (1 + ($txtvat_new / 100)) - $_GET["txtRetChkAmou_D1"];
        //$ResponseXML .= "<txtBalsale><![CDATA[".$txtBalsale."]]></txtBalsale>";	
    }

    if ($_GET["cmbdev"] == "0") {
        $txtBalsale = ($TOTSALE - $totret) / (1 + ($txtvat_new / 100)) - $_GET["txtRetChkAmou_Do"];
        //$ResponseXML .= "<txtBalsale><![CDATA[".$txtBalsale."]]></txtBalsale>";	
    }

    if ($_GET["cmbdev"] == "1") {
        $txtnet = $TOTSALE / (1 + ($txtvat_new / 100));
        $ResponseXML .= "<txtnet><![CDATA[" . number_format($txtnet, 2, ".", ",") . "]]></txtnet>";
    }

    if ($_GET["cmbdev"] == "0") {
        $txtnet = ($TOTSALE - $totret) / (1 + ($txtvat_new / 100));
        $ResponseXML .= "<txtnet><![CDATA[" . number_format($txtnet, 2, ".", ",") . "]]></txtnet>";
    }


    $X = 0;

    $sql_inv = "select * from tmp_s_salma where Accname != 'NON STOCK' and month(SDATE)='" . $month . "' AND YEAR(SDATE)='" . $year . "' AND SAL_EX='" . $_GET["cmbrep"] . "' AND CANCELL='0' and userid='" . $_SESSION['UserName'] . "' order by C_CODE";
    //echo $sql_inv;
    $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
    while ($row_inv = mysqli_fetch_array($result_inv)) {
        $invamou = 0;
        $invamou = $row_inv["GRAND_TOT"];
        if ($row_inv["GRAND_TOT"] == "Y") {
            $lblComm = "Locked";
        }

        //===============================================Choose Commission Catogory=====================================
        $day1 = 0;
        $day2 = 0;
        $cat1 = 0;
        $cat2 = 0;
        $cat3 = 0;

        $sql_cat = "select * from com_she where sal_ex='" . $_GET["cmbrep"] . "' and Brand='" . trim($row_inv["Brand"]) . "'";
        $result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
        $row_cat = mysqli_fetch_array($result_cat);
        $day1 = $row_cat["Day1"];
        $day2 = $row_cat["Day2"];

        if ($netSale > $_GET["txtt2"]) {
            $cat1 = $row_cat["T3_cat1"];
            $cat2 = $row_cat["T3_cat2"];
            $cat3 = $row_cat["T3_cat3"];
        } else if ($netSale > $_GET["txtt1"]) {
            $cat1 = $row_cat["T2_Cat1"];
            $cat2 = $row_cat["T2_cat2"];
            $cat3 = $row_cat["T2_Cat3"];
        } else {
            $cat1 = $row_cat["T1_Cat1"];
            $cat2 = $row_cat["T1_cat2"];
            $cat3 = $row_cat["T1_cat3"];
        }


        $sql_rsven = "Select incdays from vendor where CODE = '" . trim($row_inv["C_CODE"]) . "'";
        $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
        if ($row_rsven = mysqli_fetch_array($result_rsven)) {
            if ($row_rsven["incdays"] > $day1) {
                $day1 = $row_rsven["incdays"] + 1;
                $day2 = $row_rsven["incdays"] + 1;
            }
        }


        /* 	if ($row_inv["cre_pe"] > $day1){
          $day1 = $row_inv["cre_pe"] + 1;
          $day2 = $row_inv["cre_pe"] + 1;
          } */

        if ($row_inv["DEV"] == "1") {
            //=========================================================================
            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day1 . " and ST_FLAG != 'UT') and userid='" . $_SESSION['UserName'] . "'";
            //echo $sql_sttr."</br>";
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                if (is_null($row_sttr["INVPAID"]) == false) {
                    $tot_Comm_cat_1_D1 = $tot_Comm_cat_1_D1 + $row_sttr["INVPAID"];
                    if ($cat1 > 0) {
                        //echo "Com-".$row_inv["REF_NO"]."-".$row_sttr["INVPAID"]."/";
                        $t = $t + $row_sttr["INVPAID"];
                        $TOTcOMMpAY_D1 = $TOTcOMMpAY_D1 + $row_sttr["INVPAID"];
                        if (trim($_GET["cmbdev"]) == "1") {
                            $cat1SALE = $cat1SALE + $row_sttr["INVPAID"];
                        }
                    } else {
                        //echo "noncom-".$row_inv["REF_NO"]."-".$row_sttr["INVPAID"]."/";
                        $TOTnOcOMMpAY_D1 = $TOTnOcOMMpAY_D1 + $row_sttr["INVPAID"];
                        //echo "C1 - ".$TOTnOcOMMpAY_D1."</br>";
                        if ($_GET["cmbdev"] == "1") {
                            ///////SetNoComm/////////////
                            $sql = "select Brand from tmp_s_salma where Accname != 'NON STOCK' and REF_NO='" . trim($row_inv["REF_NO"]) . "' and userid='" . $_SESSION['UserName'] . "'";
                            $result = mysqli_query($GLOBALS['dbinv'], $sql);
                            if ($row = mysqli_fetch_array($result)) {

                                $sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
                                $result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
                                if ($row_brType = mysqli_fetch_array($result_brType)) {

                                    $r = 0;
                                    while ($MSHFlexGrid1_count > $r) {
                                        if ($MSHFlexGrid1[$r][0] == trim($row_brType["class"])) {
                                            $MSHFlexGrid1[$r][1] = $MSHFlexGrid1[$r][1] + $row_sttr["INVPAID"];
                                            $r = $MSHFlexGrid1_count;
                                        }
                                        $r = $r + 1;
                                        //echo "aaa : ".$GLOBALS[$MSHFlexGrid1[$r][1]];
                                    }
                                }
                            }
                        }
                    }
                }
            }
            //============================================

            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day1 . " and del_days>60 ) and ST_FLAG != 'UT' and userid='" . $_SESSION['UserName'] . "'";
            //echo $sql_sttr."</br>";
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                if (is_null($row_sttr["INVPAID"]) == false) {
                    // $tot_Comm_cat_1_D1 = $tot_Comm_cat_1_D1 + $row_sttr["INVPAID"];
                    if ($cat1 > 0) {
                        //$TOTcOMMpAY_D1 = $TOTcOMMpAY_D1 + $sttr["INVPAID"];
                        //echo "spcom-".$row_inv["REF_NO"]."-".$row_sttr["INVPAID"]."/";
                        if (trim($_GET["cmbdev"]) == "1") {
                            //echo $row_inv["REF_NO"]."-".$cat1SpSALE."-".$row_sttr["INVPAID"]."</br>";
                            $cat1SpSALE = $cat1SpSALE + $row_sttr["INVPAID"];
                        }
                    }
                }
            }


            //============================================

            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND   ST_FLAG = 'UT' and userid='" . $_SESSION['UserName'] . "'";
            //echo $sql_sttr."</br>";
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                $tot_Comm_cat_1_D1 = $tot_Comm_cat_1_D1 + $row_sttr["INVPAID"];
                // echo "Cat1-".$cat1;
                if ($cat1 > 0) {
                    //echo "----ok";
                    $TOTcOMMpAY_D1 = $TOTcOMMpAY_D1 + $row_sttr["INVPAID"];
                    $t = $t + $row_sttr["INVPAID"];

                    if (trim($_GET["cmbdev"]) == "1") {
                        $cat1SALE = $cat1SALE + $row_sttr["INVPAID"];
                    }
                } else {
                    $TOTnOcOMMpAY_D1 = $TOTnOcOMMpAY_D1 + $row_sttr["INVPAID"];
                    //echo "C2 - ".$TOTnOcOMMpAY_D1."</br>";
                    if ($_GET["cmbdev"] == "1") {
                        ///////SetNoComm/////////////
                        $sql = "select Brand from tmp_s_salma where Accname != 'NON STOCK' and REF_NO='" . trim($row_inv["REF_NO"]) . "' and userid='" . $_SESSION['UserName'] . "'";
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                        if ($row = mysqli_fetch_array($result)) {

                            $sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
                            $result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
                            if ($row_brType = mysqli_fetch_array($result_brType)) {

                                $r = 0;
                                while ($MSHFlexGrid1_count > $r) {
                                    if ($MSHFlexGrid1[$r][0] == trim($row_brType["class"])) {
                                        $MSHFlexGrid1[$r][1] = $MSHFlexGrid1[$r][1] + $row_sttr["INVPAID"];
                                        $r = $MSHFlexGrid1_count;
                                    }
                                    $r = $r + 1;
                                }
                            }
                        }
                    }
                }
            }

            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days> " . $day1 . " or del_days= " . $day1 . ") AND del_days<" . $day2 . " and ST_FLAG!='UT' and userid='" . $_SESSION['UserName'] . "'";
            //echo $sql_sttr."</br>";
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                $tot_Comm_cat_2_D1 = $tot_Comm_cat_2_D1 + $row_sttr["INVPAID"];
                if ($cat2 > 0) {
                    $t1 = $t1 + $row_sttr["INVPAID"];
                    $TOTcOMMpAY_D1 = $TOTcOMMpAY_D1 + $row_sttr["INVPAID"];
                    if (trim($_GET["cmbdev"]) == "1") {
                        $cat2SALE = $cat2SALE + $row_sttr["INVPAID"];
                    }
                } else {
                    $TOTnOcOMMpAY_D1 = $TOTnOcOMMpAY_D1 + $row_sttr["INVPAID"];
                    //echo "C3 - ".$TOTnOcOMMpAY_D1."</br>";
                    if ($_GET["cmbdev"] == "1") {
                        ///////SetNoComm/////////////
                        $sql = "select Brand from tmp_s_salma where Accname != 'NON STOCK' and REF_NO='" . trim($row_inv["REF_NO"]) . "' and userid='" . $_SESSION['UserName'] . "'";
                        $result = mysqli_query($GLOBALS['dbinv'], $sql);
                        if ($row = mysqli_fetch_array($result)) {

                            $sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
                            $result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
                            if ($row_brType = mysqli_fetch_array($result_brType)) {

                                $r = 0;
                                while ($MSHFlexGrid1_count > $r) {
                                    if ($MSHFlexGrid1[$r][0] == trim($row_brType["class"])) {
                                        $MSHFlexGrid1[$r][1] = $MSHFlexGrid1[$r][1] + $row_sttr["INVPAID"];
                                        $r = $MSHFlexGrid1_count;
                                    }
                                    $r = $r + 1;
                                }
                            }
                        }
                    }
                }
            }

            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND   (del_days>" . $day2 . " or del_days=" . $day2 . ") and ST_FLAG<>'UT' and userid='" . $_SESSION['UserName'] . "'";
            //echo $sql_sttr."</br>";
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                if (is_null($row_sttr["INVPAID"]) == false) {
                    $tot_Comm_cat_3_D1 = $tot_Comm_cat_3_D1 + $row_sttr["INVPAID"];
                    if ($cat3 > 0) {
                        $TOTcOMMpAY_D1 = $TOTcOMMpAY_D1 + $row_sttr["INVPAID"];
                    } else {
                        $TOTnOcOMMpAY_D1 = $TOTnOcOMMpAY_D1 + $row_sttr["INVPAID"];
                        //echo "C4 - ".$TOTnOcOMMpAY_D1."</br>";
                        if ($_GET["cmbdev"] == "1") {
                            ///////SetNoComm/////////////
                            $sql = "select Brand from tmp_s_salma where Accname != 'NON STOCK' and REF_NO='" . trim($row_inv["REF_NO"]) . "' and userid='" . $_SESSION['UserName'] . "'";
                            $result = mysqli_query($GLOBALS['dbinv'], $sql);
                            if ($row = mysqli_fetch_array($result)) {

                                $sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
                                $result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
                                if ($row_brType = mysqli_fetch_array($result_brType)) {

                                    $r = 0;
                                    while ($MSHFlexGrid1_count > $r) {
                                        if ($MSHFlexGrid1[$r][0] == trim($row_brType["class"])) {
                                            $MSHFlexGrid1[$r][1] = $MSHFlexGrid1[$r][1] + $row_sttr["INVPAID"];
                                            $r = $MSHFlexGrid1_count;
                                        }
                                        $r = $r + 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {


            //=========================================================================
            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND  del_days<" . $day1 . "  and ST_FLAG!='UT' and userid='" . $_SESSION['UserName'] . "'";
            //echo $sql_sttr;
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);

            if ($row_sttr = mysqli_fetch_array($result_sttr)) {

                if (is_null($row_sttr["INVPAID"]) == false) {

                    $tot_Comm_cat_1_Do = $tot_Comm_cat_1_Do + $row_sttr["INVPAID"];
                    if ($cat1 > 0) {
                        $TOTcOMMpAY_Do = $TOTcOMMpAY_Do + $row_sttr["INVPAID"];
                        $invamou = $invamou - $row_sttr["INVPAID"];
                        if (trim($_GET["cmbdev"]) == "0") {
                            $cat1SALE = $cat1SALE + $row_sttr["INVPAID"];
                        }
                    } else {
                        $TOTnOcOMMpAY_Do = $TOTnOcOMMpAY_Do + $row_sttr["INVPAID"];
                        //echo "1-".$TOTnOcOMMpAY_Do."</br>";
                        $invamou = $invamou - $row_sttr["INVPAID"];
                        if ($_GET["cmbdev"] == "0") {
                            ///////SetNoComm/////////////
                            $sql = "select Brand from tmp_s_salma where Accname != 'NON STOCK' and REF_NO='" . trim($row_inv["REF_NO"]) . "' and userid='" . $_SESSION['UserName'] . "'";
                            $result = mysqli_query($GLOBALS['dbinv'], $sql);
                            if ($row = mysqli_fetch_array($result)) {

                                $sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
                                $result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
                                if ($row_brType = mysqli_fetch_array($result_brType)) {

                                    $r = 0;
                                    while ($MSHFlexGrid1_count > $r) {
                                        if ($MSHFlexGrid1[$r][0] == trim($row_brType["class"])) {
                                            $MSHFlexGrid1[$r][1] = $MSHFlexGrid1[$r][1] + $row_sttr["INVPAID"];
                                            $r = $MSHFlexGrid1_count;
                                        }
                                        $r = $r + 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }


            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' and ST_FLAG='UT' and userid='" . $_SESSION['UserName'] . "'";
            //echo $sql_sttr;
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                if (is_null($row_sttr["INVPAID"]) == false) {
                    $tot_Comm_cat_1_Do = $tot_Comm_cat_1_Do + $row_sttr["INVPAID"];
                    if ($cat1 > 0) {
                        $TOTcOMMpAY_Do = $TOTcOMMpAY_Do + $row_sttr["INVPAID"];
                        $invamou = $invamou - $row_sttr["INVPAID"];
                        if (trim($_GET["cmbdev"]) == "0") {
                            $cat1SALE = $cat1SALE + $row_sttr["INVPAID"];
                        }
                    } else {
                        $TOTnOcOMMpAY_Do = $TOTnOcOMMpAY_Do + $row_sttr["INVPAID"];
                        //echo " 2 - ".$TOTnOcOMMpAY_Do."</br>";
                        $invamou = $invamou - $row_sttr["INVPAID"];
                        if ($_GET["cmbdev"] == "0") {
                            ///////SetNoComm/////////////
                            $sql = "select Brand from tmp_s_salma where Accname != 'NON STOCK' and REF_NO='" . trim($row_inv["REF_NO"]) . "' and userid='" . $_SESSION['UserName'] . "'";
                            $result = mysqli_query($GLOBALS['dbinv'], $sql);
                            if ($row = mysqli_fetch_array($result)) {

                                $sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
                                $result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
                                if ($row_brType = mysqli_fetch_array($result_brType)) {

                                    $r = 0;
                                    while ($MSHFlexGrid1_count > $r) {
                                        if ($MSHFlexGrid1[$r][0] == trim($row_brType["class"])) {
                                            $MSHFlexGrid1[$r][1] = $MSHFlexGrid1[$r][1] + $row_sttr["INVPAID"];
                                            $r = $MSHFlexGrid1_count;
                                        }
                                        $r = $r + 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }


            //======================================================================================================
            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day1 . "  and del_days>60) and ST_FLAG != 'UT' and userid='" . $_SESSION['UserName'] . "'";
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);

            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                if (is_null($row_sttr["INVPAID"]) == false) {
                    if ($cat1 > 0) {
                        //$TOTcOMMpAY_Do = $TOTcOMMpAY_Do + $row_sttr["INVPAID"];
                        if (trim($_GET["cmbdev"]) == "0") {
                            $cat1SpSALE = $cat1SpSALE + $row_sttr["INVPAID"];
                        }
                        $X = $X + 1;
                    }
                }
            }


            //====================================================================================================
            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days>=" . $day1 . "  and  del_days<" . $day2 . ") and ST_FLAG != 'UT' and userid='" . $_SESSION['UserName'] . "'";
            //echo $sql_sttr;
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                if (is_null($row_sttr["INVPAID"]) == false) {
                    $tot_Comm_cat_2_Do = $tot_Comm_cat_2_Do + $row_sttr["INVPAID"];
                    if ($cat2 > 0) {
                        $TOTcOMMpAY_Do = $TOTcOMMpAY_Do + $row_sttr["INVPAID"];
                        $invamou = $invamou - $row_sttr["INVPAID"];
                        if (trim($_GET["cmbdev"]) == "0") {
                            $cat2SALE = $cat2SALE + $row_sttr["INVPAID"];
                        }
                    } else {
                        $TOTnOcOMMpAY_Do = $TOTnOcOMMpAY_Do + $row_sttr["INVPAID"];
                        //echo " 3 - ".$TOTnOcOMMpAY_Do."</br>";
                        $invamou = $invamou - $row_sttr["INVPAID"];
                        if ($_GET["cmbdev"] == "0") {
                            ///////SetNoComm/////////////
                            $sql = "select Brand from tmp_s_salma where Accname != 'NON STOCK' and REF_NO='" . trim($row_inv["REF_NO"]) . "' and userid='" . $_SESSION['UserName'] . "'";
                            $result = mysqli_query($GLOBALS['dbinv'], $sql);
                            if ($row = mysqli_fetch_array($result)) {

                                $sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
                                $result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
                                if ($row_brType = mysqli_fetch_array($result_brType)) {

                                    $r = 0;
                                    while ($MSHFlexGrid1_count > $r) {
                                        if ($MSHFlexGrid1[$r][0] == trim($row_brType["class"])) {
                                            $MSHFlexGrid1[$r][1] = $MSHFlexGrid1[$r][1] + $row_sttr["INVPAID"];
                                            $r = $MSHFlexGrid1_count;
                                        }
                                        $r = $r + 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days>=" . $day2 . ") and ST_FLAG != 'UT' and userid='" . $_SESSION['UserName'] . "'";
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                if (is_null($row_sttr["INVPAID"]) == false) {
                    $tot_Comm_cat_3_Do = $tot_Comm_cat_3_Do + $row_sttr["INVPAID"];
                    if ($cat3 > 0) {
                        $TOTcOMMpAY_Do = $TOTcOMMpAY_Do + $row_sttr["INVPAID"];
                        $invamou = $invamou - $row_sttr["INVPAID"];
                    } else {
                        $TOTnOcOMMpAY_Do = $TOTnOcOMMpAY_Do + $row_sttr["INVPAID"];

                        //if (trim($row_inv["REF_NO"])=="BEN/CR/070701/12"){
                        //	echo $sql_sttr;
                        //}
                        //echo " 4 - ".trim($row_inv["REF_NO"])."-".$row_sttr["INVPAID"]." = ".$TOTnOcOMMpAY_Do."</br>";
                        $invamou = $invamou - $row_sttr["INVPAID"];
                        if ($_GET["cmbdev"] == "0") {
                            ///////SetNoComm/////////////
                            $sql = "select Brand from tmp_s_salma where Accname != 'NON STOCK' and REF_NO='" . trim($row_inv["REF_NO"]) . "' and userid='" . $_SESSION['UserName'] . "'";
                            $result = mysqli_query($GLOBALS['dbinv'], $sql);
                            if ($row = mysqli_fetch_array($result)) {

                                $sql_brType = "SELECT  class from brand_mas where barnd_name='" . trim($row["Brand"]) . "'";
                                $result_brType = mysqli_query($GLOBALS['dbinv'], $sql_brType);
                                if ($row_brType = mysqli_fetch_array($result_brType)) {

                                    $r = 0;
                                    while ($MSHFlexGrid1_count > $r) {
                                        if ($MSHFlexGrid1[$r][0] == trim($row_brType["class"])) {
                                            $MSHFlexGrid1[$r][1] = $MSHFlexGrid1[$r][1] + $row_sttr["INVPAID"];
                                            $r = $MSHFlexGrid1_count;
                                        }
                                        $r = $r + 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }


            if ($invamou < -1) {
                $invamou = 0;
                $REFNO = trim($row_inv["REF_NO"]);
            }
        }
    }
//===========================================Del days update ==============================================
    $Y = $X;
    $Frame1 = $month . "/" . $year . " -  " . $_GET["cmbrep"];
    $ResponseXML .= "<Frame1><![CDATA[" . $Frame1 . "]]></Frame1>";
    $ResponseXML .= "<txtnetsale><![CDATA[" . number_format($TOTSALE, 2, ".", ",") . "]]></txtnetsale>";

    //if ($_GET["cmbdev"] == "0"){
    $ResponseXML .= "<txtret><![CDATA[" . number_format($totret, 2, ".", ",") . "]]></txtret>";
//	} else {
    //	$ResponseXML .= "<txtret><![CDATA[]]></txtret>";		
    //}
    //echo "TOTSALE-".$TOTSALE." /TOTcOMMpAY_D1-".$TOTcOMMpAY_D1." /TOTnOcOMMpAY_D1-".$TOTnOcOMMpAY_D1."/ ";
    //echo "TOTcOMMpAY_Do-".$TOTcOMMpAY_Do." /TOTnOcOMMpAY_Do-".$TOTnOcOMMpAY_Do;

    if ($_GET["cmbdev"] == "1") {
        $txtout = $TOTSALE - $TOTcOMMpAY_D1 - $TOTnOcOMMpAY_D1;
        $ResponseXML .= "<txtout><![CDATA[" . number_format($txtout, 2, ".", ",") . "]]></txtout>";

        $txtpaid = $TOTcOMMpAY_D1 + $TOTnOcOMMpAY_D1;
        $ResponseXML .= "<txtpaid><![CDATA[" . number_format($txtpaid, 2, ".", ",") . "]]></txtpaid>";

        $txtNocomm = $TOTnOcOMMpAY_D1;
        $ResponseXML .= "<txtNocomm><![CDATA[" . number_format($txtNocomm, 2, ".", ",") . "]]></txtNocomm>";
    }

    if ($_GET["cmbdev"] == "0") {
        $txtout = $TOTSALE - $TOTcOMMpAY_Do - $TOTnOcOMMpAY_Do;
        $ResponseXML .= "<txtout><![CDATA[" . number_format($txtout, 2, ".", ",") . "]]></txtout>";
        //echo $TOTcOMMpAY_Do."/".$TOTnOcOMMpAY_Do;
        $txtpaid = $TOTcOMMpAY_Do + $TOTnOcOMMpAY_Do;
        $ResponseXML .= "<txtpaid><![CDATA[" . number_format($txtpaid, 2, ".", ",") . "]]></txtpaid>";

        $txtNocomm = $TOTnOcOMMpAY_Do;
        $ResponseXML .= "<txtNocomm><![CDATA[" . number_format($txtNocomm, 2, ".", ",") . "]]></txtNocomm>";
    }

    if ($_GET["cmbdev"] == "All") {

        $txtNocomm = $TOTnOcOMMpAY_D1 + $TOTnOcOMMpAY_Do / (1 + ($txtvat_new / 100));
        $ResponseXML .= "<txtNocomm><![CDATA[" . number_format($txtNocomm, 2, ".", ",") . "]]></txtNocomm>";

        $txtout = $TOTSALE - ($TOTcOMMpAY_D1 + $TOTcOMMpAY_Do) - ($TOTnOcOMMpAY_D1 + $TOTnOcOMMpAY_Do);
        $ResponseXML .= "<txtout><![CDATA[" . number_format($txtout, 2, ".", ",") . "]]></txtout>";

        $txtpaid = $TOTcOMMpAY_D1 + $TOTcOMMpAY_Do + $TOTnOcOMMpAY_D1 + $TOTnOcOMMpAY_Do;
        $ResponseXML .= "<txtpaid><![CDATA[" . number_format($txtpaid, 2, ".", ",") . "]]></txtpaid>";
    }

    $netsaleall = ($TOTSALEALL - $totret) / (1 + ($txtvat_new / 100));
    $txtTotnet = ($TOTSALEALL - $totret) / (1 + ($txtvat_new / 100));
    $ResponseXML .= "<txtTotnet><![CDATA[" . number_format($netsaleall, 2, ".", ",") . "]]></txtTotnet>";

    //====================Dis chng done coz req of malaka & Milroy================


    $txtTOTNocom = ($TOTnOcOMMpAY_D1 + $TOTnOcOMMpAY_Do) / (1 + ($txtvat_new / 100));
    $ResponseXML .= "<txtTOTNocom><![CDATA[" . number_format($txtTOTNocom, 2, ".", ",") . "]]></txtTOTNocom>";


    $txtpre = (($TOTnOcOMMpAY_D1 + $TOTnOcOMMpAY_Do) / (1 + ($txtvat_new / 100)) + $_GET["txtRetChkAmou_D1"] + $_GET["txtRetChkAmou_Do"]) / $netsaleall * 100;
    $ResponseXML .= "<txtpre><![CDATA[" . number_format($txtpre, 2, ".", ",") . "]]></txtpre>";

    $txtcat1sale = $cat1SALE - $cat1SpSALE;
    $ResponseXML .= "<txtcat1sale><![CDATA[" . number_format($txtcat1sale, 2, ".", ",") . "]]></txtcat1sale>";

    $txtcat1Spsale = $cat1SpSALE;
    $ResponseXML .= "<txtcat1Spsale><![CDATA[" . number_format($txtcat1Spsale, 2, ".", ",") . "]]></txtcat1Spsale>";

    $txtcat2sale = $cat2SALE;
    $ResponseXML .= "<txtcat2sale><![CDATA[" . number_format($txtcat2sale, 2, ".", ",") . "]]></txtcat2sale>";


////////////////////eFFSAle/////////////////////////////////////
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
            $txtBalsale = $txtnet - $_GET["txtRetChkAmou_Do"] - $txtNocomm;
        }
        if ($_GET["cmbdev"] == "All") {
            $txtBalsale = $txtnet - $_GET["txtRetChkAmou_D1"] - $_GET["txtRetChkAmou_Do"] - $txtNocomm;
        }

        $txtbalSAleTOT = $txtTotnet - $_GET["txtRetChkAmou_D1"] - $_GET["txtRetChkAmou_Do"] - $txtTOTNocom;
    }

    $ResponseXML .= "<txtBalsale><![CDATA[" . number_format($txtBalsale, 2, ".", ",") . "]]></txtBalsale>";
    $ResponseXML .= "<txtbalSAleTOT><![CDATA[" . number_format($txtbalSAleTOT, 2, ".", ",") . "]]></txtbalSAleTOT>";


    ////////////////////end eFFSAle/////////////////////////////////////

    $ResponseXML .= "<MSHFlexGrid1><![CDATA[ <table  bgcolor=\"#003366\" border=1  cellspacing=0>
								<tr><td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Class</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Paid Amount</font></td>
								
								
							</tr>";

    $r = 0;
    while ($MSHFlexGrid1_count > $r) {
        $ResponseXML .= "<tr><td>" . $MSHFlexGrid1[$r][0] . "</td>
						<td>" . $MSHFlexGrid1[$r][1] . "</td>
						</tr>";
        $r = $r + 1;
    }

    $ResponseXML .= "   </table>]]></MSHFlexGrid1>";

    $month = substr($_GET["dtMonth"], 0, 7);
    $sql_utmas123 = "SELECT * FROM commisionremark WHERE month  ='" . $month . "' and rep='" . $_GET["cmbrep"] . "' and type='Bal'";
//    echo $sql_utmas123;
    $result_utmas123 = mysqli_query($GLOBALS['dbinv'], $sql_utmas123);
    if ($row_utmas123 = mysqli_fetch_array($result_utmas123)) {

        $ResponseXML .= "<remark123><![CDATA[" . $row_utmas123['remark'] . "]]></remark123>";
    } else {
        $ResponseXML .= "<remark123><![CDATA[" . '' . "]]></remark123>";
    }

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}




if ($_GET["Command"] == "eff_sale") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $txtTOTNocom = str_replace(",", "", $_GET["txtTOTNocom"]);
    $txtRetChkAmou_D1 = str_replace(",", "", $_GET["txtRetChkAmou_D1"]);
    $txtRetChkAmou_Do = str_replace(",", "", $_GET["txtRetChkAmou_Do"]);
    $txtTotnet = str_replace(",", "", $_GET["txtTotnet"]);
    $txtnet = str_replace(",", "", $_GET["txtnet"]);
    $txtNocomm = str_replace(",", "", $_GET["txtNocomm"]);

    if ($year <= 2014) {
        $txtvat_new = 12;
    } else {
        $txtvat_new = 11;
    }

    $txtpre = (($txtTOTNocom + $txtRetChkAmou_D1 + $txtRetChkAmou_Do) / $txtTotnet) * 100;
//echo "cmbdev-".$_GET["cmbdev"]."/txtpre-".$txtpre."</br>";
    if ($txtpre <= 15) {

        if ($_GET["cmbdev"] == "1") {
            $txtBalsale = $txtnet;
        }
        if ($_GET["cmbdev"] == "0") {
            $txtBalsale = $txtnet;
        }
        if ($_GET["cmbdev"] = "All") {
            $txtBalsale = $txtnet;
        }
        $txtbalSAleTOT = $txtTotnet;
    } else {
        if ($_GET["cmbdev"] == "1") {
            $txtBalsale = $txtnet - $txtRetChkAmou_D1 - $txtNocomm;
        }
        //echo "cmbdev-".$_GET["cmbdev"]."/".$txtnet."/".$txtRetChkAmou_Do."/".$txtNocomm;
        if ($_GET["cmbdev"] == "0") {
            $txtBalsale = $txtnet - $txtRetChkAmou_Do - $txtNocomm;
        }
        if ($_GET["cmbdev"] == "All") {
            $txtBalsale = $txtnet - $txtRetChkAmou_D1 - $txtRetChkAmou_Do - $txtNocomm;
        }
        $txtbalSAleTOT = $txtTotnet - $txtRetChkAmou_D1 - $txtRetChkAmou_Do - $txtTOTNocom;
    }

    $ResponseXML .= "<txtpre><![CDATA[" . number_format(($txtpre), 2, ".", ",") . "]]></txtpre>";
    $ResponseXML .= "<txtBalsale><![CDATA[" . number_format($txtBalsale, 2, ".", ",") . "]]></txtBalsale>";
    $ResponseXML .= "<txtbalSAleTOT><![CDATA[" . number_format($txtbalSAleTOT, 2, ".", ",") . "]]></txtbalSAleTOT>";

    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}







if ($_GET["Command"] == "calculation") {

    include('connectioni.php');

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $year = substr($_GET["dtMonth"], 0, 4);
    $month = substr($_GET["dtMonth"], 5, 2);

    if ($year <= 2014) {
        $txtvat_new = 12;
    } else {
        $txtvat_new = 11;
    }

    $sql_inv = "select * from s_salma where Accname != 'NON STOCK' and month(SDATE)='" . $month . "' AND YEAR(SDATE)='" . $year . "' AND SAL_EX='" . trim($_GET["cmbrep"]) . "' AND CANCELL='0' ";
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
        //echo $sql_cat;

        $result_cat = mysqli_query($GLOBALS['dbinv'], $sql_cat);
        $row_cat = mysqli_fetch_array($result_cat);

        $day1 = $row_cat["Day1"];
        $day2 = $row_cat["Day2"];

        //echo "day1-".$day1."/Day2-".$day2;
        $txtbalSAleTOT = str_replace(",", "", $_GET["txtbalSAleTOT"]);
        $txtt2 = str_replace(",", "", $_GET["txtt2"]);
        $txtt1 = str_replace(",", "", $_GET["txtt1"]);

        if ($txtbalSAleTOT > $txtt2) {
            $cat1 = $row_cat["T3_cat1"];
            $cat2 = $row_cat["T3_cat2"];
            $cat3 = $row_cat["T3_cat3"];
            $tarcat = 3;
        } else if ($txtbalSAleTOT > $txtt1) {
            $cat1 = $row_cat["T2_Cat1"];
            $cat2 = $row_cat["T2_cat2"];
            $cat3 = $row_cat["T2_Cat3"];
            $tarcat = 2;
        } else {
            $cat1 = $row_cat["T1_Cat1"];
            $cat2 = $row_cat["T1_cat2"];
            $cat3 = $row_cat["T1_cat3"];
            $tarcat = 1;
        }
        //echo "cat1-".$cat1."/cat2-".$cat2."/cat3-".$cat3."</br>";

        $sql_rsven = "Select incdays from vendor where CODE = '" . trim($row_inv["C_CODE"]) . "'";

        $result_rsven = mysqli_query($GLOBALS['dbinv'], $sql_rsven);
        $row_rsven = mysqli_fetch_array($result_rsven);
        if ($row_rsven["incdays"] > $day1) {
            $day1 = $row_rsven["incdays"] + 1;
            $day2 = $row_rsven["incdays"] + 1;
        }

        /* if ($row_inv["cre_pe"] > $day1){
          $day1 = $row_inv["cre_pe"] + 1;
          $day2 = $row_inv["cre_pe"] + 1;
          } */
        if ($_GET["cmbdev"] == "All") {
            $dv = "A";
        }
        if ($_GET["cmbdev"] == "1") {
            $dv = "0";
        }
        if ($_GET["cmbdev"] == "0") {
            $dv = "1";
        }

        //echo "Cat-".$cat1;
        //echo $row_inv["REF_NO"]."---";
        if ($row_inv["DEV"] != $dv) {
            //=========================================================================
            //echo "select * FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day1 . "   or ST_FLAG = 'UT') ";
            $sql_sttr = "select sum(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day1 . "   or ST_FLAG = 'UT') and userid='" . $_SESSION['UserName'] . "'";

            //	echo $sql_sttr;

            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                if (is_null($row_sttr["INVPAID"]) == false) {
                    if ($row_inv["DEV"] == "1") {

                        $ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat1 * 0.01;
                        $cat1Comm = $cat1Comm + $row_sttr["INVPAID"] * $cat1 * 0.01;
                        //echo $row_inv["REF_NO"]."-".$row_sttr["INVPAID"]."-".$cat1Comm."</br>";
                    } else {
                        $ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat1 * 0.01 / (1 + ($txtvat_new / 100));
                        $cat1Comm = $cat1Comm + $row_sttr["INVPAID"] * $cat1 * 0.01 / (1 + ($txtvat_new / 100));

                        if ($row_inv["REF_NO"] == "BEN/CR/065577/23") {
                            //echo "1-".$row_sttr["INVPAID"] * $cat1 * 0.01 / (1 + ($_GET["txtvat"] / 100))."</br>";
                        }
                    }
                }
            }


            // echo $row_inv["REF_NO"].$cat1Comm
//=================================================================
            //  echo  "SELECT * FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day1 . ") AND (del_days>60)  and ST_FLAG!='UT'";
            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days<" . $day1 . ") AND (del_days>60)  and ST_FLAG!='UT' and userid='" . $_SESSION['UserName'] . "'";
            //echo $sql_sttr;
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                if (is_null($row_sttr["INVPAID"]) == false) {
                    if ($row_inv["DEV"] == "1") {
                        $cat1SpComm = $cat1SpComm + $row_sttr["INVPAID"] * $cat1 * 0.01;
                    } else {
                        $cat1SpComm = $cat1SpComm + $row_sttr["INVPAID"] * $cat1 * 0.01 / (1 + ($txtvat_new / 100));

                        /* if ($row_inv["REF_NO"]=="BEN/CR/067963/7"){
                          echo "2-".$sql_sttr."</br>";
                          echo $row_sttr["INVPAID"] * $cat1 * 0.01 / (1 + ($_GET["txtvat"] / 100))."</br>";
                          } */
                    }
                }
            }


            //=======================================================================
            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND (del_days> " . $day1 . " or del_days= " . $day1 . ")AND del_days<" . $day2 . "  and ST_FLAG!='UT' and userid='" . $_SESSION['UserName'] . "'";
            //echo $sql_sttr;
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                if (is_null($row_sttr["INVPAID"]) == false) {
                    if ($row_inv["DEV"] == "1") {
                        $ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat2 * 0.01;
                        $cat2Comm = $cat2Comm + $row_sttr["INVPAID"] * $cat2 * 0.01;
                    } else {
                        $t = $t + $row_sttr["INVPAID"];
                        $ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat2 * 0.01 / (1 + ($txtvat_new / 100));
                        $cat2Comm = $cat2Comm + $row_sttr["INVPAID"] * $cat2 * 0.01 / (1 + ($txtvat_new / 100));

                        if ($row_inv["REF_NO"] == "BEN/CR/065577/23") {
                            //echo "3-".$row_sttr["INVPAID"]."/".$cat2."/".$_GET["txtvat"]."/".$row_sttr["INVPAID"] * $cat2 * 0.01 / (1 + ($_GET["txtvat"] / 100))."</br>";
                        }
                    }
                }
            }


            $sql_sttr = "SELECT SUM(ST_PAID) AS INVPAID FROM tmp_s_sttr WHERE ST_INVONO='" . trim($row_inv["REF_NO"]) . "' AND  ( del_days>" . $day2 . " or  del_days=" . $day2 . " ) and ST_FLAG!='UT' and userid='" . $_SESSION['UserName'] . "'";
            //echo $sql_sttr;
            $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
            if ($row_sttr = mysqli_fetch_array($result_sttr)) {
                if (is_null($row_sttr["INVPAID"]) == false) {
                    if ($row_inv["DEV"] == "1") {
                        $ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat3 * 0.01;
                        //echo "Cat3-".$cat3."/".$_GET["txtpre"]."</br>";
                        if (($cat3 == 0) and ($_GET["txtpre"] <= 15)) {
                            $cat2NoComm = $cat2NoComm + $row_sttr["INVPAID"] * $cat2 * 0.01;
                            $ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat2 * 0.01;

                            if ($m_update == true) {
                                $row_inv["DIS"] = $row_inv["DIS"] + $row_sttr["INVPAID"] * $cat2 * 0.01;
                            }
                            /* if ($row_inv["REF_NO"]=="BEN/CR/067963/7"){
                              echo "3-".$sql_sttr."</br>";
                              //echo $row_sttr["INVPAID"] * $cat1 * 0.01 / (1 + ($_GET["txtvat"] / 100))."</br>";
                              } */
                        }
                    } else {
                        $ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat3 * 0.01 / (1 + ($txtvat_new / 100));
                        // echo "Cat3-".$cat3."/".$_GET["txtpre"]."</br>";
                        if (($cat3 == 0) and ($_GET["txtpre"] <= 15)) {
                            $cat2NoComm = $cat2NoComm + $row_sttr["INVPAID"] * $cat2 * 0.01 / (1 + ($txtvat_new / 100));
                            $ComAmou = $ComAmou + $row_sttr["INVPAID"] * $cat2 * 0.01 / (1 + ($txtvat_new / 100));
                            if ($m_update == true) {
                                $row_inv["DIS"] = $row_inv["DIS"] + $row_sttr["INVPAID"] * $cat2 * 0.01 / (1 + ($txtvat_new / 100));
                            }
                        }

                        /* if ($row_inv["REF_NO"]=="BEN/CR/067963/7"){
                          echo "4-".$sql_sttr."</br>";
                          //echo $row_sttr["INVPAID"] * $cat1 * 0.01 / (1 + ($_GET["txtvat"] / 100))."</br>";
                          } */
                        //if ($row_inv["REF_NO"]=="BEN/CR/065577/23"){
                        //echo "4-".$row_sttr["INVPAID"] * $cat2 * 0.01 / (1 + ($_GET["txtvat"] / 100))."</br>";
                        //}
                    }
                }
            }
        }
    }


    $year = substr($_GET["dtMonth"], 0, 4);
    $month = substr($_GET["dtMonth"], 5, 2);

    $retcommamou = 0;

    if ($_GET["cmbdev"] != "1") {
        $retcommamou = 0;

        $sql_rsgen = "select * from s_crnma where CANCELL='0' and month(SDATE) =" . $month . " and   year(SDATE) =" . $year . " and SAL_EX='" . trim($_GET["cmbrep"]) . "'  ";
        // echo $sql_rsgen;
        $result_rsgen = mysqli_query($GLOBALS['dbinv'], $sql_rsgen);
        while ($row_rsgen = mysqli_fetch_array($result_rsgen)) {

            $retcommamou = $retcommamou + $row_rsgen["DUMMY_VAL"] + $row_rsgen["DIS1"];
        }


        $sql_rsgen = "select * from cred where CANCELL='0' and  month(C_DATE) =" . $month . " and   year(C_DATE) =" . $year . " and C_SALEX='" . trim($_GET["cmbrep"]) . "'  ";
        // echo $row_rsgen;
        $result_rsgen = mysqli_query($GLOBALS['dbinv'], $sql_rsgen);

        while ($row_rsgen = mysqli_fetch_array($result_rsgen)) {
            $sql_rsbal = "Select * from c_bal where REFNO = '" . $row_rsgen["C_REFNO"] . " ' and flag1 != '1'";
            // echo $sql_rsbal;
            $result_rsbal = mysqli_query($GLOBALS['dbinv'], $sql_rsbal);
            if ($row_rsbal = mysqli_fetch_array($result_rsbal)) {
                if (is_null($row_rsgen["dummy_val"]) == false) {
                    $retcommamou = $retcommamou + $row_rsgen["dummy_val"];
                }
                if (is_null($row_rsgen["SETTLED"]) == false) {
                    $retcommamou = $retcommamou + $row_rsgen["SETTLED"];
                }
            }
        }
    }
//=============================================================================================================
    $txtComSale = $ComAmou;
    $txtComGRN = $retcommamou;
//echo  "ComAmou-".$ComAmou."/retcommamou-".$retcommamou."/txtretch-".$txtretch;
    $txtComBal = $ComAmou - $retcommamou - $txtretch;
//echo "=".$cat1Comm."/".$cat1SpComm;
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

            if ($row_rsbrand["class"] == "TYRE") {
                $mtyre = $mtyre + str_replace(",", "", $_GET[$msgrid5]);
            }
            if ($row_rsbrand["class"] == "BATTERY") {
                $mbattery = $mbattery + str_replace(",", "", $_GET[$msgrid5]);
            }
            if ($row_rsbrand["class"] == "ALLOY WHEEL") {
                $malloy = $malloy + str_replace(",", "", $_GET[$msgrid5]);
            }
            if ($row_rsbrand["class"] == "TUBE") {
                $mtube = $mtube + str_replace(",", "", $_GET[$msgrid5]);
            }

            if ($row_rsbrand["class"] == "TYRE") {
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


    $year = date("Y", strtotime($_GET["dtMonth"]));
    $month = date("m", strtotime($_GET["dtMonth"]));


    $txtded = str_replace(",", "", $_GET["txtded"]);
    $txtad = str_replace(",", "", $_GET["txtad"]);
    $TXTADJ = str_replace(",", "", $_GET["TXTADJ"]);
    if ($TXTADJ == "") {
        $TXTADJ = 0;
    }
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

    $txtover60 = str_replace(",", "", $_GET["txtover60"]);
    $txtretioded = str_replace(",", "", $_GET["txtretioded"]);

    $txtdedremark = str_replace(",", "", $_GET["txtdedremark"]);
    $txtretcheq = str_replace(",", "", $_GET["txtretcheq"]);

    $mrefno = $month . "/" . $year . "-" . $_GET["cmbrep"] . "-" . $_GET["cmbdev"];

    $sql_rss_commadva = "select * from s_commadva where FLAG='ADV' AND refno='" . $mrefno . "' ";
    $result_rss_commadva = mysqli_query($GLOBALS['dbinv'], $sql_rss_commadva);
    if ($row_rss_commadva = mysqli_fetch_array($result_rss_commadva)) {
        if ($row_rss_commadva["Lock1"] == 1) {
            exit("Sorry this month locked");
        }

        $sql = "Delete from s_commadva where refno = '" . $mrefno . "' AND FLAG='ADV'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $sale = $mtyre + $mbattery + $malloy + $mtube;


        $sql = "insert s_commadva (refno, sale, per, ded, remark, advance, rep, comdate, sdate, ADJ, Dedcap1, Dedcap2, Dedcap3, Dedcap4, Dedcap5, Dedcap6, Dedcap7, Dedcap8, Dedamount1, Dedamount2, Dedamount3, Dedamount4, Dedamount5, Dedamount6, Dedamount7, Dedamount8, Over60out, Returnchk, Over60Ratio, RatioDed, sale_tyre, Sale_battery, Sale_AW, Sale_Tube, Com_tyre, Com_battery, Com_AW, Com_tube, flag, chno, dev) values ('" . $mrefno . "', " . $sale . ", " . $_GET["txtper"] . ", " . $txtded . ", '" . $txtdedremark . "', " . $txtad . ", '" . $_GET["cmbrep"] . "', '" . $_GET["dtMonth"] . "', '" . date("Y-m-d") . "', " . $TXTADJ . ", '" . $txtded1 . "', '" . $txtded2 . "', '" . $txtded3 . "', '" . $txtded4 . "', '" . $txtded5 . "', '" . $txtded6 . "', '" . $txtded7 . "', '" . $txtded8 . "', " . $txtdedamou1 . ", " . $txtdedamou2 . ", " . $txtdedamou3 . ", " . $txtdedamou4 . ", " . $txtdedamou5 . ", " . $txtdedamou6 . ", " . $txtdedamou7 . ", " . $txtdedamou8 . ", " . $txtover60 . ", " . $txtretcheq . ", " . $_GET["TXTRATO"] . ", " . $txtretioded . ", " . $mtyre . ", " . $mbattery . ", " . $malloy . ", " . $mtube . ", " . $mtyre_com . ", " . $mbattery_com . ", " . $malloy_com . ", " . $mtube_com . ", 'ADV', '0', '" . $_GET["cmbdev"] . "')";
        echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
    } else {

        $sale = $mtyre + $mbattery + $malloy + $mtube;

        $sql = "insert s_commadva (refno, sale, per, ded, remark, advance, rep, comdate, sdate, ADJ, Dedcap1, Dedcap2, Dedcap3, Dedcap4, Dedcap5, Dedcap6, Dedcap7, Dedcap8, Dedamount1, Dedamount2, Dedamount3, Dedamount4, Dedamount5, Dedamount6, Dedamount7, Dedamount8, Over60out, Returnchk, Over60Ratio, RatioDed, sale_tyre, Sale_battery, Sale_AW, Sale_Tube, Com_tyre, Com_battery, Com_AW, Com_tube, flag, chno, dev) values ('" . $mrefno . "', " . $sale . ", " . $_GET["txtper"] . ", " . $txtded . ", '" . $txtdedremark . "', " . $txtad . ", '" . $_GET["cmbrep"] . "', '" . $_GET["dtMonth"] . "', '" . date("Y-m-d") . "', " . $TXTADJ . ", '" . $txtded1 . "', '" . $txtded2 . "', '" . $txtded3 . "', '" . $txtded4 . "', '" . $txtded5 . "', '" . $txtded6 . "', '" . $txtded7 . "', '" . $txtded8 . "', " . $txtdedamou1 . ", " . $txtdedamou2 . ", " . $txtdedamou3 . ", " . $txtdedamou4 . ", " . $txtdedamou5 . ", " . $txtdedamou6 . ", " . $txtdedamou7 . ", " . $txtdedamou8 . ", " . $txtover60 . ", " . $txtretcheq . ", " . $_GET["TXTRATO"] . ", " . $txtretioded . ", " . $mtyre . ", " . $mbattery . ", " . $malloy . ", " . $mtube . ", " . $mtyre_com . ", " . $mbattery_com . ", " . $malloy_com . ", " . $mtube_com . ", 'ADV', '0', '" . $_GET["cmbdev"] . "')";
        echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
    }
}

if ($_GET["Command"] == "advance_proces") {

    $msgrid = array();

    $madjust = $_GET["TXTADJ"];

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

    $year = date("Y", strtotime($_GET["dtMonth"]));
    $month = date("m", strtotime($_GET["dtMonth"]));

    $sql_rs = "Select  sum(GRAND_TOT) as sales from s_salma where Accname != 'NON STOCK' and  CANCELL='0' and SAL_EX='" . $mrep . "' and year(SDATE)='" . $year . "' and month(SDATE)='" . $month . "'   ";
    $result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
    if ($row_rs = mysqli_fetch_array($result_rs)) {
        if (is_null($row_rs["sales"]) == false) {
            $txtsales = $row_rs["sales"];
        }
    }

    $ResponseXML .= "<txtsales><![CDATA[" . number_format($txtsales, 2, ".", ",") . "]]></txtsales>";

    $sql_rs = "Select  sum(AMOUNT) as salesret from c_bal  where  CANCELL='0' and trn_type='CNT' and SAL_EX='" . $mrep . "' and year(SDATE)='" . $year . "' and month(SDATE)='" . $month . "' and flag1='0'   ";
    $result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
    if ($row_rs = mysqli_fetch_array($result_rs)) {
        if (is_null($row_rs["salesret"]) == false) {
            $txtcrn = $row_rs["salesret"];
        }
    }

    $ResponseXML .= "<txtcrn><![CDATA[" . number_format($txtcrn, 2, ".", ",") . "]]></txtcrn>";

    $sql_rs = "Select  sum(AMOUNT) as salesret from c_bal  where CANCELL='0' and trn_type='GRN' and SAL_EX='" . $mrep . "' and year(SDATE)='" . $year . "' and month(SDATE)='" . $month . "' and flag1='0'  ";
    $result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
    if ($row_rs = mysqli_fetch_array($result_rs)) {
        if (is_null($row_rs["salesret"]) == false) {
            $txtrtn = $row_rs["salesret"];
        }
    }
    $ResponseXML .= "<txtrtn><![CDATA[" . number_format($txtrtn, 2, ".", ",") . "]]></txtrtn>";

    if ($year <= 2014) {
        $txtnett = ($txtsales - ($txtcrn + $txtrtn)) / 1.12;
    } else {
        $txtnett = ($txtsales - ($txtcrn + $txtrtn)) / 1.11;
    }
    $ResponseXML .= "<txtnett><![CDATA[" . number_format($txtnett, 2, ".", ",") . "]]></txtnett>";


    $mrefno = $month . "/" . $year . "-" . $_GET["cmbrep"] . "-" . $_GET["cmbdev"];

    $sql_rs_old = "Select * from s_commadva where refno = '" . $mrefno . "' and FLAG='ADV'";

    $result_rs_old = mysqli_query($GLOBALS['dbinv'], $sql_rs_old);
    if ($row_rs_old = mysqli_fetch_array($result_rs_old)) {

        if (is_null($row_rs_old["ADJ"]) == false) {
            $TXTADJ = $row_rs_old["ADJ"];
        }
        if (is_null($row_rs_old["Dedcap1"]) == false) {
            $txtded1 = $row_rs_old["Dedcap1"];
        }
        if (is_null($row_rs_old["Dedcap2"]) == false) {
            $txtded2 = $row_rs_old["Dedcap2"];
        }
        if (is_null($row_rs_old["Dedcap3"]) == false) {
            $txtded3 = $row_rs_old["Dedcap3"];
        }
        if (is_null($row_rs_old["Dedcap4"]) == false) {
            $txtded4 = $row_rs_old["Dedcap4"];
        }
        if (is_null($row_rs_old["Dedcap5"]) == false) {
            $txtded5 = $row_rs_old["Dedcap5"];
        }
        if (is_null($row_rs_old["Dedcap6"]) == false) {
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
        if (is_null($row_rs_old["Dedamount3"]) == false) {
            $txtdedamou3 = $row_rs_old["Dedamount3"];
        }
        if (is_null($row_rs_old["Dedamount4"]) == false) {
            $txtdedamou4 = $row_rs_old["Dedamount4"];
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
        if (is_null($row_rs_old["remark"]) == false) {
            $txtdedremark = $row_rs_old["remark"];
        }
        if ($row_rs_old["Lock1"] == 1) {
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
            $txtdedremark = trim($txtdedremark) . "-" . trim($row_rs_old["chno"]) . "-" . trim($row_rs_old["Bank"]) . "-" . trim($row_rs_old["PCHNO"]);
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
            $mretche = $row_rs_salm["retche"];
            $txtretcheq = $txtretcheq + $row_rs_salm["retche"];
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
            $date2 = $row_rs_salm["SDATE"];

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
        if ($year <= 2014) {
            if ($txtnett != 0) {
                $TXTRATO = ($txtover60 + $TXTADJ + $txtretcheq) / ($txtnett * 1.12) * 100;
            }
        } else {
            if ($txtnett != 0) {
                $TXTRATO = ($txtover60 + $TXTADJ + $txtretcheq) / ($txtnett * 1.11) * 100;
            }
        }
    }

    if ($year <= 2014) {
        $netSale = (($txtsales - $txtrtn - $txtcrn) / 112) * 100;
    } else {
        $netSale = (($txtsales - $txtrtn - $txtcrn) / 111) * 100;
    }


//msgrid.clear
//.....................................................................................................................................
    $ai = 1;
    $mcom = 0;

    $sql_rs_salm = "Select Brand , sum(GRAND_TOT) as sales from s_salma where Accname != 'NON STOCK' and CANCELL='0' and DEV='" . $mdev . "' and SAL_EX='" . $mrep . "' and year(SDATE)='" . $year . "' and month(SDATE)='" . $month . "'  group by Brand  ";
    $result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
    while ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {

        if ($mdev == "1") {
            $msale = $row_rs_salm["sales"];
        } else {
            if ($year <= 2014) {
                $msale = ((($row_rs_salm["sales"] / 112) * 100));
            } else {
                $msale = ((($row_rs_salm["sales"] / 111) * 100));
            }
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
                    $mcom = $mcom + $msale * $row_rs_table["T3_cat2"];
                }
                if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
                    $mcom = $mcom + $msale * $row_rs_table["T2_cat2"];
                }
                if ($netSale < $txtt1) {
                    $mcom = $mcom + $msale * $row_rs_table["T1_cat2"];
                }
            }
        } else {
            $mcom = $mcom + 0;
        }

        $msgrid[$ai][1] = $row_rs_salm["Brand"];
        $msgrid[$ai][2] = $msale;
        $ai = $ai + 1;
    }
//echo $mcom;
    $row_count = $ai;
//.... CNT ......................................................................................................................................

    $sql_rs_salm = "Select  brand, sum(AMOUNT) as salesret from c_bal  where CANCELL='0' and  trn_type='CNT' and SAL_EX='" . $mrep . "' and year(SDATE)='" . $year . "' and month(SDATE)='" . $month . "' and flag1='0' and DEV='" . $mdev . "' group by brand  ";

    $result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
    while ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {


        if ($mdev == "1") {
            $msale = $row_rs_salm["salesret"];
        } else {
            if ($year <= 2014) {
                $msale = ((($row_rs_salm["salesret"] / 112) * 100));
            } else {
                $msale = ((($row_rs_salm["salesret"] / 111) * 100));
            }
        }


        $sql_rs_table = "SELECT *   from com_she where   sal_ex='" . $mrep . "' AND Brand='" . trim($row_rs_salm["brand"]) . "' ";
        $result_rs_table = mysqli_query($GLOBALS['dbinv'], $sql_rs_table);
        if ($row_rs_table = mysqli_fetch_array($result_rs_table)) {

            if ($TXTRATO <= 15) {
                if ($netSale >= $txtt2) {
                    $mcom = $mcom - $msale * $row_rs_table["T3_cat1"];
                }
                if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
                    $mcom = $mcom - $msale * $row_rs_table["T2_Cat1"];
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
            if (trim($msgrid[$xx][1]) == trim($row_rs_salm["brand"])) {

                $msgrid[$xx][1] = $row_rs_salm["brand"];
                $msgrid[$xx][3] = $msale * -1;
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

    //echo $mcom;
//.... GRN ......................................................................................................................................

    $sql_rs_salm = "Select  brand, sum(AMOUNT) as salesret from c_bal  where DEV='" . $mdev . "' and trn_type='GRN' and SAL_EX='" . $mrep . "' and year(SDATE)='" . $year . "' and month(SDATE)='" . $month . "'  group by brand  ";
    $result_rs_salm = mysqli_query($GLOBALS['dbinv'], $sql_rs_salm);
    while ($row_rs_salm = mysqli_fetch_array($result_rs_salm)) {

        if ($mdev == "1") {
            $msale = $row_rs_salm["salesret"];
        } else {
            if ($year <= 2014) {
                $msale = ((($row_rs_salm["salesret"] / 112) * 100));
            } else {
                $msale = ((($row_rs_salm["salesret"] / 111) * 100));
            }
        }

        $sql_rs_table = "SELECT *   from com_she where sal_ex='" . $mrep . "' AND Brand='" . trim($row_rs_salm["brand"]) . "' ";
        $result_rs_table = mysqli_query($GLOBALS['dbinv'], $sql_rs_table);
        if ($row_rs_table = mysqli_fetch_array($result_rs_table)) {

            if ($TXTRATO <= 15) {
                if ($netSale >= $txtt2) {
                    $mcom = $mcom - $msale * $row_rs_table["T3_cat1"];
                }
                if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
                    $mcom = $mcom - $msale * $row_rs_table["T2_Cat1"];
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
            if (trim($msgrid[$xx][1]) == trim($row_rs_salm["brand"])) {
                $msgrid[$xx][1] = $row_rs_salm["brand"];
                $msgrid[$xx][4] = $msale * -1;
                $xx = $row_count;
                $mstat = "OLD";
            }
            $xx = $xx + 1;
        }
        if ($mstat == "NEW") {

            $msgrid[$ai][1] = $row_rs_salm["brand"];
            $msgrid[$ai][4] = $msale * -1;
        }
        $ai = $ai + 1;
    }
    $TXTCOM = $mcom;
    //echo $mcom;

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


        $msale = $msgrid[$ai][2] + $msgrid[$ai][3] + $msgrid[$ai][4];
        $msgrid[$ai][5] = $msale;

        $result_rs_table = mysqli_query($GLOBALS['dbinv'], $sql_rs_table);
        if ($row_rs_table = mysqli_fetch_array($result_rs_table)) {
            if ($TXTRATO <= 15) {
                if ($netSale >= $txtt2) {
                    $mcom = $msale * $row_rs_table["T3_cat1"];
                    $txtper = $row_rs_table["T3_cat1"];
                }
                if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
                    $mcom = $msale * $row_rs_table["T2_Cat1"];
                    $txtper = $row_rs_table["T2_Cat1"];
                }
                if ($netSale < $txtt1) {
                    $mcom = $msale * $row_rs_table["T1_Cat1"];
                    $txtper = $row_rs_table["T1_Cat1"];
                }
            } else {
                if ($netSale >= $txtt2) {
                    $mcom = $msale * $row_rs_table["T3_cat2"];
                    $txtper = $row_rs_table["T3_cat2"];
                }
                if (($netSale < $txtt2) and ($netSale >= $txtt1)) {
                    $mcom = $msale * $row_rs_table["T2_cat2"];
                    $txtper = $row_rs_table["T2_cat2"];
                }
                if ($netSale < $txtt1) {
                    $mcom = $msale * $row_rs_table["T1_cat2"];
                    $txtper = $row_rs_table["T1_cat2"];
                }
            }
        } else {
            $mcom = $msale * 1.5;
        }
        $msgrid[$ai][6] = $mcom / 100;


        $mtotcom = $mtotcom + (($mcom / 100) * 0.5);

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
        //echo "mtotcom-".$mtotcom;
        //echo "mretioded-".$mretioded;
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
      msgrid.TextMatrix(0, 6) = "Comm" */


    $ResponseXML .= "<TXTRATO><![CDATA[" . number_format($TXTRATO, 2, ".", ",") . "]]></TXTRATO>";
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

        $ResponseXML .= "<tr><td><div id=" . $msgrid1 . ">" . $msgrid[$i][1] . "</div></td>
						<td align=\"right\"><div id=" . $msgrid2 . ">" . number_format($msgrid[$i][2], 2, ".", ",") . "</div></td>
						<td align=\"right\"><div id=" . $msgrid3 . ">" . number_format($msgrid[$i][3], 2, ".", ",") . "</div></td>
						<td align=\"right\"><div id=" . $msgrid4 . ">" . number_format($msgrid[$i][4], 2, ".", ",") . "</div></td>
						<td align=\"right\"><div id=" . $msgrid5 . ">" . number_format($msgrid[$i][5], 2, ".", ",") . "</div></td>
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
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $sql1 = "Select sum(C_PAYMENT) as paid  from s_ut where CRE_NO_NO='" . $row['REFNO'] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        if ($row1 = mysqli_fetch_array($result1)) {
            if (is_null($row1["paid"])) {
                $mpaid = $row1["paid"];
            }

            $sql2 = "update c_bal set totpay ='" . $mpaid . "' where REF_NO='" . $row["REF_NO"] . "'";
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
        }
    }
}

if ($_GET["Command"] == "utilization") {


    if (($_GET["paytype"] != "R/Deposit") and ($_GET["paytype"] != "C/TT")) {
        $sql = "select * from tmp_ret_chq_sett where recno='" . $_GET["recno"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
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
            $tmp[$i] = $_GET[$setamount];
        }
        $i = $i + 1;
    }

    $k = 1;


    $sql = "select * from tmp_ret_chq_sett where recno='" . $_GET["recno"] . "'";
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



                    $diff = abs(strtotime($_GET[$docdate]) - strtotime($row["chqdate"]));
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

                    $msset[$k][0] = $_GET[$docno];
                    $msset[$k][1] = $_GET[$docdate];
                    $msset[$k][2] = $row["chqno"];
                    $msset[$k][3] = $row["chqdate"];
                    $msset[$k][4] = $invset;
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
                    $msset[$k][1] = $_GET[$docdate];
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
										<td>" . $_GET[$chqno] . "</td>
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
                        $msset[$H][6] = $_GET[$retchqbal];
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
        $sql1 = "insert into tmp_utilization_ret_chq_set(recno, docno, docdate, chequeno, chequedate, settled, days, retchbal, retchqval, col1, col2) values ('" . $_GET["recno"] . "', '" . $msset[$i][0] . "', '" . $msset[$i][1] . "', '" . $msset[$i][2] . "', '" . $msset[$i][3] . "', '" . $msset[$i][4] . "', '" . $msset[$i][5] . "', '" . $msset[$i][6] . "', '" . $msset[$i][7] . "', '" . $msset[$i][8] . "', '" . $msset[$i][9] . "')";
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
						<td>" . $row["docdate"] . "</td>
						<td>" . $row["chequeno"] . "</td>
						<td>" . $row["chequedate"] . "</td>
						<td>" . $row["settled"] . "</td>
						<td>" . $row["days"] . "</td>
						<td>" . $row["retchbal"] . "</td>
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
      echo $invno; */

    $sql = "Select Guti from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
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

    while ($gridchk[$r][1] != "") {
        $gridchk[$r][7] = "";
        $chtotal = $chtotal + $gridchk[$r][6];
        $r = $r + 1;
    }

    while ($Gridinv[$r][1] != "") {
        $Gridinv[$r][7] = "";
        $total = $total + $Gridinv[$r][6];
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
    $_SESSION["recno"] = $recno;

    $sql_ch = "select * from ch_sttr where ST_REFNO='" . trim($_GET["txtrefno"]) . "'";
    $result_ch = mysqli_query($GLOBALS['dbinv'], $sql_ch);
    $row_ch = mysqli_fetch_array($result_ch);

    $sql = "select * from ch_sttr";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

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
            if (($GLOBALS[$Gridinv[$r][6]] > 0) and ($GLOBALS[$Gridinv[$r][1]] != "") and ($GLOBALS[$Gridinv[$r][2]] != "") and ($GLOBALS[$Gridinv[$r][5]] > 0)) {
                $sql_cruti = "insert into s_ut(C_REFNO, C_DATE, C_CODE, C_INVNO, C_PAYMENT, CRE_NO_NO, TYPE) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $_GET["Txtcusco"] . "', '" . $GLOBALS[$Gridinv[$r][1]] . "', '" . $GLOBALS[$Gridinv[$r][6]] . "', '" . trim($_GET["txtcrnno"]) . "', 'INV')";
                $result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);

                $sql_cruti = "UPDATE s_salma SET TOTPAY = TOTPAY + " . $GLOBALS[$Gridinv[$r][6]] . " WHERE ((REF_NO='" . trim($GLOBALS[$Gridinv[$r][1]]) . "'))";
                $result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);

                $diff = abs(strtotime($_GET["dtdate"]) - strtotime($GLOBALS[$Gridinv[$r][6]]));
                $days = floor($diff / (60 * 60 * 24));

                $sql_cruti = "insert into s_sttr(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_FLAG, ST_CHNO, st_days, ap_days) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $GLOBALS[$Gridinv[$r][1]] . "', '" . $GLOBALS[$Gridinv[$r][6]] . "', 'UT', '" . trim($_GET["txtcrnno"]) . "', '" . $days . "', '" . $days . "')";
                $result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);


                //==================credit limit=============================
                $sql_rsinv = "select Brand from s_salma where Accname != 'NON STOCK' and REF_NO='" . trim($GLOBALS[$Gridinv[$r][1]]) . "'";
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
            if (($GLOBALS[$gridchk[$r][6]] > 0) and ($GLOBALS[$gridchk[$r][1]] != "") and ($GLOBALS[$gridchk[$r][2]] != "") and ($GLOBALS[$gridchk[$r][5]] > 0)) {
                $sql_cruti = "insert into s_ut(C_REFNO, C_DATE, C_CODE, C_INVNO, C_PAYMENT, CRE_NO_NO, TYPE) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $_GET["Txtcusco"] . "', '" . $GLOBALS[$gridchk[$r][1]] . "', '" . $GLOBALS[$gridchk[$r][6]] . "', '" . trim($_GET["txtcrnno"]) . "', 'CHQ')";
                $result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);


                $sql_cruti = "insert into s_sttr(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_FLAG, ST_CHNO) values ('" . trim($_GET["txtrefno"]) . "', '" . $_GET["dtdate"] . "', '" . $GLOBALS[$gridchk[$r][1]] . "', '" . $GLOBALS[$Gridinv[$r][6]] . "', 'UT', '" . trim($_GET["txtcrnno"]) . "')";
                $result_cruti = mysqli_query($GLOBALS['dbinv'], $sql_cruti);

                $sql_inv = "UPDATE s_cheq SET PAID = PAID + " . $GLOBALS[$Gridinv[$r][6]] . " WHERE (((CR_REFNO)='" . trim($GLOBALS[$gridchk[$r][1]]) . "'))";
                $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);

                $sql_inv = "UPDATE vendor SET RET_CHEQ = RET_CHEQ - " . $GLOBALS[$Gridinv[$r][6]] . " WHERE CODE='" . trim($GLOBALS[$gridchk[$r][1]]) . "'";
                $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
            }
        }
    }


    $sql_inv = "UPDATE c_bal SET BALANCE = BALANCE - " . $_GET["lblPaid"] . " WHERE ((REFNO='" . trim($_GET["txtcrnno"]) . "'))";
    $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);

    $sql_inv = "UPDATE invpara SET Guti=Guti+1";
    $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);


    echo "Saved";
}

if ($_GET["Command"] == "search_rec") {

    include_once("connectioni.php");

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

        $sql2 = "insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days) values ('" . $_GET["recno"] . "', '" . $row["ST_INVONO"] . "', '" . $row1["SDATE"] . "', '" . $row["ST_CHNO"] . "', '" . $row["st_chdate"] . "', '" . $row["st_chbank"] . "', " . $row["ST_PAID"] . ", " . $row["st_days"] . ")";
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


if ($_GET["Command"] == "delete_rec") {
    $ResponseXML = "";

    if ($_GET["invdate"] == date("Y-m-d")) {
        $sql = "select * from c_bal where REFNO='" . $_GET["recno"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row = mysqli_fetch_array($result)) {
            if ($row["AMOUNT"] == $row["BALANCE"]) {
                $sql1 = "delete from s_crec where CA_REFNO='" . $_GET["recno"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

                $sql1 = "delete from s_sttr where ST_REFNO='" . $_GET["recno"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

                $sql1 = "delete from s_led where REF_NO='" . $_GET["recno"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

                $sql1 = "delete from s_invcheq where refno='" . $_GET["recno"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

                $sql1 = "update vendor set CUR_BAL=CUR_BAL+ " . $_GET["txtpaytot"] . " where CODE='" . $_GET["cuscode"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

                $sql1 = "delete from c_bal where REFNO='" . $_GET["recno"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

                $sql1 = "update br_trn set credit=credit- " . $_GET["txtpaytot"] . " where cus_code='" . $_GET["cuscode"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

                $sql1 = "select * from tmp_utilization where recno='" . $_GET["recno"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                while ($row1 = mysqli_fetch_array($result1)) {
                    $sql2 = "update s_salma set TOTPAY=TOTPAY- " . $row1["settled"] . " where recno='" . $row1["invno"] . "'";
                    $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);

                    if ($row1["chqno"] == "Cash") {
                        $sql2 = "update s_salma set CASH=CASH- " . $row1["settled"] . " where REF_NO='" . $row1["invno"] . "'";
                        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                    }
                }
                $ResponseXML = "Reciept Canceled";
            } else {
                $ResponseXML .= "Sorry over payment utilized.... Cant Cancel";
            }
        } else {
            $sql1 = "delete from s_crec where CA_REFNO='" . $_GET["recno"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

            $sql1 = "delete from s_sttr where ST_REFNO='" . $_GET["recno"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

            $sql1 = "delete from s_led where REF_NO='" . $_GET["recno"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

            $sql1 = "delete from s_invcheq where refno='" . $_GET["recno"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

            $sql1 = "update vendor set CUR_BAL=CUR_BAL+ " . $_GET["txtpaytot"] . " where CODE='" . $_GET["cuscode"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

            $sql1 = "delete from c_bal where REFNO='" . $_GET["recno"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

            $sql1 = "update br_trn set credit=credit- " . $_GET["txtpaytot"] . " where cus_code='" . $_GET["cuscode"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

            $sql1 = "select * from tmp_utilization where recno='" . $_GET["recno"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            while ($row1 = mysqli_fetch_array($result1)) {
                $sql2 = "update s_salma set TOTPAY=TOTPAY- " . $row1["settled"] . " where recno='" . $row1["invno"] . "'";
                $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);

                if ($row1["chqno"] == "Cash") {
                    $sql2 = "update s_salma set CASH=CASH- " . $row1["settled"] . " where REF_NO='" . $row1["invno"] . "'";
                    $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                }
            }
            $ResponseXML = "Reciept Canceled";
        }
    } else {
        $ResponseXML = "Sorry Cant Cancel.... please check reciept date";
    }

    echo $ResponseXML;
}
?>
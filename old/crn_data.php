<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once("connectioni.php");



////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////


include_once("connectioni.php");

if ($_GET["Command"] == "search_inv") {

    $ResponseXML = "";
    //$ResponseXML .= "<invdetails>";



    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
    <tr>
    <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">CRN No</font></td>
    <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Customer</font></td>
    <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">CRN Date</font></td>
    </tr>";


    if ($_GET["mstatus"] == "invno") {
        $letters = $_GET['invno'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        //$letters="/".$letters;
        //$a="SELECT * from s_salma where REF_NO like  '$letters%'";
        //echo $a;
        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM cred where CANCELL!='1' and C_REFNO like  '%$letters%'  order by C_DATE desc limit 50") or die(mysqli_error());
    } else if ($_GET["mstatus"] == "customername") {
        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);

        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * FROM cred where CANCELL!='1' and C_REFNO like  '$letters%'  order by C_DATE desc limit 50") or die(mysqli_error());
    } else {
        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);

        $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_cusordmas where CANCELL!='1' and CUS_NAME like  '$letters%' limit 50") or die(mysqli_error()) or die(mysqli_error());
    }





    while ($row = mysqli_fetch_array($sql)) {


        $ResponseXML .= "<tr>               
        <td onclick=\"crnno('" . $row['C_REFNO'] . "');\">" . $row['C_REFNO'] . "</a></td>";

        $sql1 = "SELECT * FROM vendor where CODE='" . $row["C_CODE"] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        if ($row1 = mysqli_fetch_array($result1)) {
            $ResponseXML .= "<td onclick=\"crnno('" . $row['C_REFNO'] . "');\">" . $row1["NAME"] . "</a></td>";
        }
        $ResponseXML .= "<td onclick=\"crnno('" . $row['C_REFNO'] . "');\">" . $row['C_DATE'] . "</a></td>
        
        </tr>";
    }

    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}


if ($_GET["Command"] == "new_crn") {



    if ($_SESSION["dev"] == "") {
        exit("no");
    }

    $sql = "Select CRN from invpara";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "000000" . $row["CRN"];
    $lenth = strlen($tmpinvno);
    if ($_SESSION['company'] == "BEN") {
        $crn = trim("BCRN/ ") . substr($tmpinvno, $lenth - 6);
    } else {
        $crn = trim("CRN/ ") . substr($tmpinvno, $lenth - 6);
    }
    $_SESSION["crn"] = $crn;

    $_SESSION["custno"] = "";
    //	$sql1="delete from tmp_ord_data where str_invno='".$invno."'";
    //	$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
    //echo $crn;	

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<crn><![CDATA[" . $crn . "]]></crn>";
    $ResponseXML .= "<cur_date><![CDATA[" . date("Y-m-d") . "]]></cur_date>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}




if ($_GET["Command"] == "delete_crn") {
    $sql_status = 0;

    mysqli_query($GLOBALS['dbinv'], "SET AUTOCOMMIT=0");
    mysqli_query($GLOBALS['dbinv'], "START TRANSACTION");

    $sql = "select * from c_bal where REFNO= '" . trim($_GET["crnno"]) . "' and BALANCE=AMOUNT ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    if ($row = mysqli_fetch_array($result)) {
        if (date("Y-m", strtotime($row["SDATE"])) == date("Y-m")) {
            $sql1 = "delete from c_bal where REFNO='" . $_GET["crnno"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($result1 != 1) {
                $sql_status = 1;
            }

            $sql1 = "update cred set CANCELL='1' where C_REFNO='" . $_GET["crnno"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($result1 != 1) {
                $sql_status = 2;
            }

            $sql1 = "update s_salma set RET_AMO=RET_AMO-" . $_GET["amount"] . " where REF_NO='" . $_GET["invno"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($result1 != 1) {
                $sql_status = 3;
            }

            $sql1 = "delete from s_led  where REF_NO = '" . $_GET["crnno"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($result1 != 1) {
                $sql_status = 4;
            }

            //$sql1="update vendor set CUR_BAL=CUR_BAL+ ".$_GET["amount"]."  where CODE='".$_GET["cus_code"]."'";
            //$result1=mysqli_query($GLOBALS['dbinv'],$sql1);
            //if ($result1!=1){ $sql_status=5; }	
            //$sql1="update br_trn set credit=credit+ ".$_GET["amount"]."  where cus_code='".$_GET["cus_code"]."' and Rep='".$_GET["salesrep"]."'";
            //$result1=mysqli_query($GLOBALS['dbinv'],$sql1);
            //if ($result1!=1){ $sql_status=6; }	

            $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . $_GET["crnno"] . "', '" . $_SESSION["CURRENT_USER"] . "', 'Credit Note', 'Cancel', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $resul2 = mysqli_query($GLOBALS['dbinv'], $sql2);
            if ($resul2 != 1) {
                $sql_status = 7;
            }

            //echo $sql_status;
            if ($sql_status == 0) {
                mysqli_query($GLOBALS['dbinv'], "COMMIT");
                $ResponseXML .= "<msg_cancel><![CDATA[Cancelled]]></msg_cancel>";
            } else {
                mysqli_query($GLOBALS['dbinv'], "ROLLBACK");
                $ResponseXML .= "<msg_cancel><![CDATA[Error has occured. Can't Cancel]]></msg_cancel>";
            }
        } else {
            $ResponseXML .= "<msg_cancel><![CDATA[Cant Cancel]]></msg_cancel>";
        }
    }



    echo $ResponseXML;
}
if ($_GET['Command'] == "p_remk") {


    $sql = "update cred set p_remk ='" . $_GET['remk'] . "' where C_REFNO='" . $_GET['refno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
}

if ($_GET["Command"] == "pass_crnno") {
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $sql = "Select * from cred where C_REFNO='" . $_GET['crnno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<C_REFNO><![CDATA[" . $row["C_REFNO"] . "]]></C_REFNO>";
        $ResponseXML .= "<C_DATE><![CDATA[" . $row["C_DATE"] . "]]></C_DATE>";
        $ResponseXML .= "<C_CODE><![CDATA[" . $row["C_CODE"] . "]]></C_CODE>";

        $_SESSION["CURRENT_DOC"] = "30";     //document ID
        //VIEW_DOC = True      '  view current document
        $_SESSION["PRICE_EDIT"] = "true";      //   save  current document
        //MOD_DOC = True       '   delete   current document
        //PRINT_DOC = True     ' get additional print   of  current document
        //PRICE_EDIT=true      ' edit selling price
        $_SESSION["CHECK_USER"] = "true";    // check user permission again





        $ResponseXML .= "<C_INVNO><![CDATA[" . $row["C_INVNO"] . "]]></C_INVNO>";
        $ResponseXML .= "<p_remk><![CDATA[" . $row["p_remk"] . "]]></p_remk>";

        $sql1 = "Select * from s_salma where REF_NO='" . $row["C_INVNO"] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        if ($row1 = mysqli_fetch_array($result1)) {
            $ResponseXML .= "<invdate><![CDATA[" . $row1['SDATE'] . "]]></invdate>";
            $ResponseXML .= "<inv_amt><![CDATA[" . $row1['GRAND_TOT'] . "]]></inv_amt>";
            $ResponseXML .= "<TOTPAY><![CDATA[" . $row1['TOTPAY'] . "]]></TOTPAY>";
            $bal = $row1['GRAND_TOT'] - $row1['TOTPAY'];
            $ResponseXML .= "<balance><![CDATA[" . $bal . "]]></balance>";
        } else {
            $ResponseXML .= "<invdate><![CDATA[]]></invdate>";
            $ResponseXML .= "<inv_amt><![CDATA[]]></inv_amt>";
            $ResponseXML .= "<TOTPAY><![CDATA[]]></TOTPAY>";
            $ResponseXML .= "<balance><![CDATA[]]></balance>";
        }
        $ResponseXML .= "<C_REMARK><![CDATA[" . $row["C_REMARK"] . "]]></C_REMARK>";
        $ResponseXML .= "<C_SALEX><![CDATA[" . $row["C_SALEX"] . "]]></C_SALEX>";
        $ResponseXML .= "<Brand><![CDATA[" . $row["Brand"] . "]]></Brand>";
        $ResponseXML .= "<C_PAYMENT><![CDATA[" . $row["C_PAYMENT"] . "]]></C_PAYMENT>";
    }

    $sql = "Select * from c_bal where REFNO='" . $_GET['crnno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row_c = mysqli_fetch_array($result)) {
        $mid = $row_c['ID'];

        $sql1 = "Select * from vender_sub where c_code='" . $row_c["c_code1"] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        if ($row1 = mysqli_fetch_array($result1)) {
            $ResponseXML .= "<name><![CDATA[" . $row1["c_name"] . "]]></name>";
        } else {

            $sql1 = "Select * from vendor where CODE='" . $row_c["CUSCODE"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($row1 = mysqli_fetch_array($result1)) {
                $ResponseXML .= "<name><![CDATA[" . $row1["NAME"] . "]]></name>";
            }
        }

        if ($row_c['active'] == "2") {
            $ResponseXML .= "<lock><![CDATA[" . $row_c["active"] . "]]></lock>";
        } else {
            $ResponseXML .= "<lock><![CDATA[" . $row_c["active"] . "]]></lock>";
        }
        $ResponseXML .= "<DEP><![CDATA[" . $row_c["DEP"] . "]]></DEP>";
        $ResponseXML .= "<flag1><![CDATA[" . $row_c["active"] . "]]></flag1>";
    } else {
        $ResponseXML .= "<DEP><![CDATA[]]></DEP>";
        $ResponseXML .= "<flag1><![CDATA[]]></flag1>";
    }


    $tb = "";
    if ($row_c['active'] == "2") {

        $tb .= "<table class='form-matrix-table' style='font-size:16px;font-family:Arial, Helvetica, sans-serif;padding:5px;border-collapse:collapse;' border='1'><tr><th style='width:120px;'>Ref No</th>
        <th style='width:120px;'>Date</th>
        <th style='width:120px;'>Del. Date</th>
        <th style='width:120px;'>Invoice Total</th>
        <th style='width:120px;'>Credit Period</th>
        <th style='width:100px;'>Pay Date</th>
        <th style='width:100px;'>Che. Date</th>
        <th style='width:120px;'>Paid</th>
        <th style='width:120px;'>Days</th>								
        </tr>";

        $year = substr($row["C_DATE"], 0, 4);
        $month = substr($row["C_DATE"], 5, 2);





        $sql = "select * from view_sttr where c_code = '" . $row["C_CODE"] . "' and brand = '" . $row["Brand"] . "' and cancell='0'";
        if (($year == "2017") && ($month == "04")) {
            $sql .= " and sdate>='2017-03-01' and sdate<='2017-04-30'";
        } elseif (($year == "2017") && ($month == "06")) {
            $sql .= " and sdate>='2017-05-01' and sdate<='2017-06-30'";
        } else {
            $sql .= "  and month(sdate) = '" . $month . "' and year(sdate) ='" . $year . "'";
        }
        $i = 0;

        $result_inv = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row_inv = mysqli_fetch_array($result_inv)) {

            if ($row_inv['REF_NO'] != $mrefno) {
                $i = 0;
            }
            if ($i != 0) {
                $col = 5;
            }

            $mdays = $row_inv['cre_pe'];
            $sql1 = "Select * from vendor where CODE='" . $row["C_CODE"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($row1 = mysqli_fetch_array($result1)) {
                if ($row_inv['cre_pe'] < $row1['incdays']) {
                    $mdays = $row1['incdays'];
                }
            }

            $tb .= "<tr>";

            if ($i == 0) {
                $tb .= "<td>" . $row_inv['REF_NO'] . "</td>
                <td>" . $row_inv['SDATE'] . "</td>
                <td>" . $row_inv['deli_date'] . "</td>
                <td align='right'>" . number_format($row_inv['GRAND_TOT'], 2, ".", ",") . "</td>
                <td>" . $mdays . "</td>";
                $grand = $grand + $row_inv['GRAND_TOT'];
            } else {
                $tb .= "<td colspan ='" . $col . "'></td>";
            }

            $tb .= "<td>" . $row_inv['ST_DATE'] . "</td>
            <td>" . $row_inv['st_chdate'] . "</td>
            <td align='right'>" . number_format($row_inv['ST_PAID'], 2, ".", ",") . "</td>";

            if ((is_null($row_inv["deli_date"]) == false) and ($row_inv["deli_date"] != "0000-00-00")) {
                $Inv_date = $row_inv["deli_date"];
            } else {
                $Inv_date = $row_inv["SDATE"];
            }

            if ((is_null($row_inv["st_chdate"]) == false) and ($row_inv["st_chdate"] != "0000-00-00")) {
                $settledate = $row_inv["st_chdate"];
            } else {
                $settledate = $row_inv["ST_DATE"];
            }

            $days = 0;
            if ($settledate != "") {

                $date1 = $Inv_date;
                $date2 = $settledate;
                $diff = (strtotime($date2) - strtotime($date1));
                $days = floor($diff / (60 * 60 * 24));
            }
            $tb .= "<td>" . $days . "</td>";

            $tb .="</tr>";
            $i = $i + 1;

            $mrefno = $row_inv['REF_NO'];
        }

        $sql = "select * from c_bal where id <='" . $mid . "'  and cuscode = '" . $row["C_CODE"] . "' and brand = '" . $row["Brand"] . "' and refno not like 'DGRN%' and cancell='0' and refno <> '" . $row["C_REFNO"] . "'";
        if (($year == "2017") && ($month == "04")) {
            $sql .= " and sdate>='2017-03-01' and sdate<='2017-04-30'";
        } elseif (($year == "2017") && ($month == "06")) {
            $sql .= " and sdate>='2017-05-01' and sdate<='2017-06-30'";
        } else {
            $sql .= "  and month(sdate) = '" . $month . "' and year(sdate) ='" . $year . "'";
        }


        $result_inv = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row_inv = mysqli_fetch_array($result_inv)) {

            $tb .= "<tr>";


            $tb .= "<td>" . $row_inv['REFNO'] . "</td>
            <td>" . $row_inv['SDATE'] . "</td>
            <td></td>
            <td align='right'>" . number_format($row_inv['AMOUNT'] * -1, 2, ".", ",") . "</td>
            <td colspan='5'></td>";
            $grand = $grand - $row_inv['AMOUNT'];
            $tb .= "</tr>";
        }

        $tb .= "<tr>";
        $tb .= "<th colspan='3'>Sales Total</th>";
        $tb .= "<th align='right'>" . number_format($grand, 2, ".", ",") . "</th>";
        $tb .= "</tr>";

        $mper = (($row["C_PAYMENT"] / $grand) * 100);


        $tb .= "<tr>";
        $tb .= "<th colspan='3'>Insentive %</th>";
        $tb .= "<th align='right'>" . number_format($mper, 2, ".", ",") . "</th>";
        $tb .= "</tr>";
    }

    $ResponseXML .= "<tb><![CDATA[" . $tb . "]]></tb>";

    $sql_c = "select * from s_crnfrm where Credit_note = '" . trim($_GET['crnno']) . "'";
    $result_c = mysqli_query($GLOBALS['dbinv'], $sql_c);
    $row_c = mysqli_fetch_array($result_c);
    $ResponseXML .= "<form_no><![CDATA[" . $row_c["Refno"] . "]]></form_no>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "save_crn") {
    /* 		$_SESSION["CURRENT_DOC"] = 1;      //document ID
      $_SESSION["VIEW_DOC"] = false ;     //view current document
      $_SESSION["FEED_DOC"] = true;       //save  current document
      $_GET["MOD_DOC"] = false  ;         //delete   current document
      $_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
      $_GET["PRICE_EDIT"] = false ;       //edit selling price
      $_GET["CHECK_USER"] = false ;       //check user permission again */

    //$ResponseXML .= "";
    //$ResponseXML .= "<salesdetails>";

      if ($_SESSION["dev"] == "") {
        exit("no");
    }

    include_once("connectioni.php");

    $sqltmp = "select * from invpara";
    $resulttmp = mysqli_query($GLOBALS['dbinv'], $sqltmp);
    $rowtmp = mysqli_fetch_array($resulttmp);

    if ($rowtmp["form_loc"] == "1") {
        exit("no");
    }

    $sql_status = 0;

    mysqli_query($GLOBALS['dbinv'], "SET AUTOCOMMIT=0");
    mysqli_query($GLOBALS['dbinv'], "START TRANSACTION");

    $sql = "Select C_REFNO from cred where C_REFNO='" . $_GET['crnno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    if ($row = mysqli_fetch_array($result)) {
        //$ResponseXML .= "<msg_exist><![CDATA[Credit Note NO Already Exists]]></msg_exist>";
        exit("Credit Note NO Already Exists");
    }
    $block=1;
    $mcash = 0;
    if ($_GET["chkcash_disc"] == "true") {
        $mcash = 1;
        $block=0;
    }

    $remarks = str_replace("~", "&", $_GET["remarks"]);
    $remarks = str_replace("&nbsp;", " ", $remarks);

    $sql_invpara = "SELECT * from invpara";
    $result_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
    $row_invpara = mysqli_fetch_array($result_invpara);

    $sql = "select * from s_salma where REF_NO='" . $_GET["invno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $mvatrate = $row["GST"];
    } else {
        $mvatrate = $row_invpara["vatrate"];
    }
    $sqlrep = "select * from s_salrep where REPCODE = '" . trim($_GET["salesrep"]) . "'";
    $resultrep = mysqli_query($GLOBALS['dbinv'], $sqlrep);
    if ($rowrep = mysqli_fetch_array($resultrep)) {
        $maindepart = $rowrep['RGROUP1'];
    } else {
        $maindepart = "";
    }

    $sql = "Insert into c_bal (REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, vatrate, RNO, flag1, DEV, CANCELL, old, active, totpay ,c_code1,maindepartment,sdate1,block) values 
    ('" . $_GET["crnno"] . "', '" . $_GET["crndate"] . "', 'CNT', '" . $_GET["cus_code"] . "', '" . $_GET["amount"] . "', '" . $_GET["amount"] . "', '" . $_GET["brand"] . "', '" . $_GET["department"] . "', '" . $_GET["salesrep"] . "', '" . $mvatrate . "', '" . $_GET["txtrno"] . "', '" . $mcash . "', '" . $_SESSION['dev'] . "', '0', '0', 1, 0,'" . $_GET['c_subcode'] . "','" . $maindepart . "','" . $_GET["crndate"] . "','".$block."') ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($result != 9) {
        $sql_status = 9;
    }



    $sql = "Insert into cred (C_REFNO, C_DATE, C_INVNO, C_CODE, C_PAYMENT, C_REMARK, C_SALEX, Brand, DEV, CANCELL,maindepartment,sdate1) values 
    ('" . $_GET["crnno"] . "', '" . $_GET["crndate"] . "', '" . $_GET["invno"] . "', '" . $_GET["cus_code"] . "', '" . $_GET["amount"] . "', '" . $remarks . "', '" . $_GET["salesrep"] . "', '" . $_GET["brand"] . "', '" . $_SESSION['dev'] . "', '0','" . $maindepart . "','" . $_GET["crndate"] . "') ";
    //echo $sql;
    //dnINV.conINV.Execute "Insert into cred (C_REFNO,C_DATE,C_INVNO,C_CODE,C_PAYMENT,C_REMARK,C_SALEX,brand,dev)" _
//& " values('" & Trim(txtrefno) & "','" & DateValue(dtdate) & "','" & Trim(txt_invno) & "', '" & Trim(txt_cuscode) & "'," & Val(Format(txtamount, General)) & ",'" & Trim(txt_remark) & "','" & Trim(Left(Com_rep, 5)) & "','" & Trim(cmbbrand) & "','0')"
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($result != 8) {
        $sql_status = 8;
    }

    $sql = "update s_salma set RET_AMO=RET_AMO+" . $_GET["amount"] . " where REF_NO='" . $_GET["invno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($result != 7) {
        $sql_status = 7;
    }


    $sql = "Insert into s_led (REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT, DEV) values 
    ('" . $_GET["crnno"] . "', '" . $_GET["crndate"] . "', '" . $_GET["cus_code"] . "', '" . $_GET["amount"] . "', 'CRN', '" . $_GET["department"] . "', '" . $_SESSION['dev'] . "') ";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($result != 6) {
        $sql_status = 6;
    }

    $sql = "update vendor set CUR_BAL = CUR_BAL - " . $_GET["amount"] . " where CODE='" . $_GET["cus_code"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($result != 5) {
        $sql_status = 5;
    }


    $sql = "update br_trn set credit = credit - " . $_GET["amount"] . " where cus_code='" . $_GET["cus_code"] . "' and Rep='" . $_GET["salesrep"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($result != 4) {
        $sql_status = 4;
    }


    //==============update CRN Form ============================================
    if (trim($_GET["txt_frmno"]) != "") {
        $sql = "Update s_crnfrm set Credit_note = '" . trim($_GET["crnno"]) . "' where Refno = '" . trim($_GET["txt_frmno"]) . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($result != 3) {
            $sql_status = 3;
        }


        //echo $sql;
    }


    $sql = "update invpara set CRN = CRN + 1";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($result != 2) {
        $sql_status = 2;
    }


    $sql2 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_GET["crnno"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'Credit Note', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
    $resul2 = mysqli_query($GLOBALS['dbinv'], $sql2);
    if ($resul2 != 1) {
        $sql_status = 1;
    }

    if ($sql_status == 0) {
        mysqli_query($GLOBALS['dbinv'], "COMMIT");
        echo "Saved";
    } else {
        mysqli_query($GLOBALS['dbinv'], "ROLLBACK");
        echo "Error has occured. Can't Save-" . $sql_status;
    }
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
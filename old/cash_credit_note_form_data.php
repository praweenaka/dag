<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once("connectioni.php");



////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////


if ($_GET["Command"] == "chk_ccrnf") {

    $_SESSION["CURRENT_DOC"] = "17";     //document ID
    //VIEW_DOC = True      '  view current document
    $_SESSION["FEED_DOC"] = "true";      //   save  current document
    //MOD_DOC = True       '   delete   current document
    //PRINT_DOC = True     ' get additional print   of  current document
    //PRICE_EDIT=true      ' edit selling price
    $_SESSION["CHECK_USER"] = "true";    // check user permission again
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

    $_SESSION["MonthView1"] = "";

    $sql = "Select CCRNNO from invpara";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "000000" . $row["CCRNNO"];
    $lenth = strlen($tmpinvno);
    //txtrefno = "CCRN\" + dnINV.conINV.DefaultDatabase + "\" + Right("0000" + Trim(Str(rsinvpara.Fields("CCRNNO"))), 4)
    $invno = trim("CCRN/" . $_SESSION['company'] . "/ ") . substr($tmpinvno, $lenth - 7);
    $_SESSION["invno"] = $invno;

    $sql = "Select CCRNNO from tmpinvpara";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "000000" . $row["CCRNNO"];
    $lenth = strlen($tmpinvno);
    $invno1 = trim("CCRN/" . $_SESSION['company'] . "/ ") . substr($tmpinvno, $lenth - 7);
    $_SESSION["credit_note_form"] = $invno1;

    $sql = "update tmpinvpara set CCRNNO=CCRNNO+1";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sql_tmpinst = " delete from tmp_cash_credit_note_form where crn_form_no='" . $invno . "'";

    $result_tmpinst = mysqli_query($GLOBALS['dbinv'], $sql_tmpinst);



    echo $invno;
}

if ($_GET["Command"] == "set_check") {

    //mrefno = Trim(txtrefno)
    $sql = "Select * from s_crnfrm where Refno = '" . $_GET["txtrefno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $sql1 = "update s_crnfrm set Checked = '" . $_SESSION['UserName'] . "',Check_date = '" . date("Y-m-d") . "' where Refno = '" . $_GET["txtrefno"] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
    }

    echo "Recordes are marked as Checked";
}

if ($_GET["Command"] == "search_inv") {
    $ResponseXML = "";
    //$ResponseXML .= "<invdetails>";

    include_once("connectioni.php");

    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Customer</font></td>
                              <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Invoice Date</font></td>
   							</tr>";

    if ($_GET["mstatus"] == "invno") {
        $letters = $_GET['invno'];
        if ($_SESSION["slected"] == "all") {
            $sql = mysqli_query($GLOBALS['dbinv'], "select Refno, Code, Amount   from s_crnfrm where Refno like  '$letters%' and cancell = '0' and flag = 'CCRN' order BY Refno desc limit 50") or die(mysqli_error());
        } else if ($_SESSION["slected"] == "locked") {
            $sql = mysqli_query($GLOBALS['dbinv'], "select Refno, Code, Amount   from s_crnfrm where Refno like  '$letters%' cancell = '0' and Lock1='1' and flag = 'CCRN' order BY Refno desc limit 50") or die(mysqli_error());
        } else if ($_SESSION["slected"] == "pending") {
            $sql = mysqli_query($GLOBALS['dbinv'], "select Refno, Code, Amount   from s_crnfrm where Refno like  '$letters%' cancell = '0' and Lock1='0' and flag = 'CCRN' order BY Refno desc limit 50") or die(mysqli_error());
        }
    }




    while ($row = mysqli_fetch_array($sql)) {
        $cuscode = $row["CODE"];
        $stname = $_GET["stname"];
        $ResponseXML .= "<tr>               
                              <td onclick=\"invno_check('" . $row['Refno'] . "', '" . $_GET['stname'] . "');\">" . $row['Refno'] . "</a></td>
                              <td onclick=\"invno_check('" . $row['Refno'] . "', '" . $_GET['stname'] . "');\">" . $row["Code"] . "</a></td>
                              <td onclick=\"invno_check('" . $row['Refno'] . "', '" . $_GET['stname'] . "');\">" . $row['Amount'] . "</a></td>
                              
                            </tr>";
    }

    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}


if ($_GET["Command"] == "select_list") {

    $_SESSION["slected"] = $_GET["mstatus"];
    if ($_GET["mstatus"] == "all") {
        $sql = "select Refno, Code, Amount   from s_crnfrm where cancell = '0' and flag = 'CCRN' order BY Refno desc limit 50";
    } else if ($_GET["mstatus"] == "locked") {
        $sql = "select Refno, Code, Amount   from s_crnfrm where cancell = '0' and Lock1='1' and flag = 'CCRN' order BY Refno desc limit 50";
    } else if ($_GET["mstatus"] == "pending") {
        $sql = "select Refno, Code, Amount   from s_crnfrm where cancell = '0' and Lock1='0' and flag = 'CCRN' order BY Refno desc limit 50";
    }

    //}
    echo "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Customer</font></td>
                              <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Invoice Date</font></td>
   </tr>";

    //echo $sql;
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        echo "<tr>               
                              <td onclick=\"invno_check('" . $row['Refno'] . "', '" . $_GET['stname'] . "');\">" . $row['Refno'] . "</a></td>
                              <td onclick=\"invno_check('" . $row['Refno'] . "', '" . $_GET['stname'] . "');\">" . $row["Code"] . "</a></td>
                              <td onclick=\"invno_check('" . $row['Refno'] . "', '" . $_GET['stname'] . "');\">" . $row['Amount'] . "</a></td>
                              
                            </tr>";
    }
    echo "</table>";
}

if ($_GET["Command"] == "set_session_month") {
    $_SESSION["MonthView1"] = $_GET["MonthView1"];
    echo $_SESSION["MonthView1"];
}


if ($_GET["Command"] == "setord") {

    echo "   <table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Amount</font></td>
                              <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Balance</font></td>
   </tr>";


    if ($_SESSION["MonthView1"] != "") {


        $year = substr($_SESSION["MonthView1"], 0, 4);
        $month = substr($_SESSION["MonthView1"], 5, 2);

        $sql = "select REF_NO , SDATE, GRAND_TOT, TOTPAY  from s_salma where Accname != 'NON STOCK' and CANCELL='0' and C_CODE='" . $_SESSION["suppno"] . "' and year(SDATE)='" . $year . "' and month(SDATE)='" . $month . "' and Brand='" . $_GET["brand"] . "' ORDER BY SDATE desc limit 50";
        //echo $sql;
        //$sql = "select REF_NO , SDATE, GRAND_TOT  from s_salma where Accname='OFFICE' and CANCELL='0'and C_CODE='" . $_SESSION["crn_form_supplierno"] . "' and year(SDATE)='".$year."' and month(SDATE)='".$month."'   ORDER BY SDATE desc limit 50";
        //}
        //echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {

            echo "<tr>               
                              <td onclick=\"invno1('" . $row['REF_NO'] . "', '" . $_GET['stname'] . "');\">" . $row['REF_NO'] . "</a></td>
                              <td align=\"right\" onclick=\"invno1('" . $row['REF_NO'] . "', '" . $_GET['stname'] . "');\">" . number_format($row["GRAND_TOT"], 2, ".", ",") . "</a></td>";
            $balance = $row["GRAND_TOT"] - $row["TOTPAY"];
            echo "<td align=\"right\" onclick=\"invno1('" . $row['REF_NO'] . "', '" . $_GET['stname'] . "');\">" . number_format($balance, 2, ".", ",") . "</a></td>
                              
                            </tr>";
        }
    }

    echo "</table>";
}


if ($_GET["Command"] == "pass_crn_form") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    //$sql_tmpinst= " delete from tmp_credit_note_form where crn_form_no='".$_GET["txtrefno"]."' and inv_no='".$_GET["invno"]."'";
    $sql_tmpinst = " delete from tmp_cash_credit_note_form where crn_form_no='" . $_GET["txtrefno"] . "' and inv_no='" . $_GET["invno"] . "'";
    //echo $sql_tmpinst;
    $result_tmpinst = mysqli_query($GLOBALS['dbinv'], $sql_tmpinst);

    $ResponseXML = "<salesdetails>";



    $i = 1;
    $tot = 0;
    // Do While MSFlexGrid1.TextMatrix(i, 1) <> ""
    $mqty = 0;
    $sql_rscrn = " Select * from s_crnfrmtrn where Inv_no = '" . $_GET["invno"] . "' and Flag = 'CCRN'";
    //echo $sql_rscrn;
    $result_rscrn = mysqli_query($GLOBALS['dbinv'], $sql_rscrn);
    if ($row_rscrn = mysqli_fetch_array($result_rscrn)) {



        $ResponseXML .= "<msg><![CDATA[Sorry this Invoice Incentive Already Paid]]></msg>";
        $ResponseXML .= "<Incen_val><![CDATA[]]></Incen_val>";
        $ResponseXML .= "<mcou><![CDATA[]]></mcou>";
        $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Deli.Date</font></td>
							  <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Inv.Date</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Inv.Amount</font></td>
							  
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Dis 2</font></td>
							  
							  
							  
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Settle Amou</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Settle Date</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Balance</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Days</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Cash Dis%</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Dis Amount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Balance%</font></td>
       						</tr>";

        $sql_rsstr = "Select * from view_s_sttr_copy where ST_INVONO = '" . trim($_GET["invno"]) . "'  ";
        $result_rsstr = mysqli_query($GLOBALS['dbinv'], $sql_rsstr);
        $row_rsstr = mysqli_fetch_array($result_rsstr);

        if ((is_null($row_rsstr["deli_date"]) == false) and ( $row_rsstr["deli_date"] != "0000-00-00")) {
            $Inv_date = $row_rsstr["deli_date"];
        } else {

            $Inv_date = $row_rsstr["SDATE"];
        }
        $balance_val = $row_rsstr["GRAND_TOT"] - $row_rsstr["ST_PAID"];

        //$settledate = $row_rsstr["ST_DATE"];
        $settledate = $row_rsstr["st_chdate"];
        $date1 = $Inv_date;
        $date2 = $settledate;
        $diff = (strtotime($date2) - strtotime($date1));
        $days = floor($diff / (60 * 60 * 24));
// prawee 20.07.16
        // if ($row_rsstr['ST_FLAG'] == "UT") {
        //     $days=$days;
        // }else{
        //     $days=$days;
        // }
        // ============
        $ResponseXML .= "<tr>
                              <td width=\"100\" >" . $Inv_date . "</td>
							  <td width=\"100\" >" . $row_rsstr["SDATE"] . "</td>
                              <td width=\"300\" >" . $row_rsstr["ST_INVONO"] . "</td>
                              <td width=\"100\" >" . $row_rsstr["GRAND_TOT"] . "</td>
							  
							  <td width=\"100\" ></td>
							  <td width=\"100\" ></td>
							  
                              <td width=\"100\" >" . $row_rsstr["ST_PAID"] . "</td>
							  <td width=\"100\" >" . $settledate . "</td>
							  <td width=\"100\" >" . $balance_val . "</td>
							  <td width=\"100\" >" . $days . "</td>
							  <td width=\"100\" >" . $row_rscrn["Incen_per"] . "</td>
							  <td width=\"100\" >" . $row_rscrn["Incen_val"] . "</td>
                               <td width=\"100\" >" . $row_rscrn["disc1"] . "</td>
                               <td width=\"100\" >" . $row_rsstr["ST_REFNO"] . "</td>
       						</tr>";
        $ResponseXML .= "   </table>]]></sales_table>";
        $ResponseXML .= "</salesdetails>";
    } else {


        $sql_rssalma = "Select * from view_s_sttr_copy where ST_INVONO = '" . trim($_GET["invno"]) . "' AND (ST_FLAG = 'CHK' or ST_FLAG = 'J/Entry' or ST_FLAG ='Cash TT' or ST_FLAG ='CAS' or ST_FLAG ='UT')";
        //echo $sql_rssalma;
        $result_rssalma = mysqli_query($GLOBALS['dbinv'], $sql_rssalma);

        if ($row_rssalma = mysqli_fetch_array($result_rssalma)) {
            $result_rssalma = mysqli_query($GLOBALS['dbinv'], $sql_rssalma);
            while ($row_rssalma = mysqli_fetch_array($result_rssalma)) {

                if ((!is_null($row_rssalma["deli_date"])) and ( $row_rssalma["deli_date"] != "0000-00-00")) {
                    $Inv_date = $row_rssalma["deli_date"];
                } else {
                    $Inv_date = $row_rssalma["SDATE"];
                }

                //echo $result_rssalma["GRAND_TOT"]."/".$result_rssalma["TOTPAY"];
                if ($Inv_date == "") {
                    $Inv_date = "0000-00-00";
                }
                $balance_val = $row_rssalma["GRAND_TOT"] - $row_rssalma["ST_PAID"];

                $inv_no = $row_rssalma["ST_INVONO"];
                $invamount = $row_rssalma["GRAND_TOT"];
                $settleamt = $row_rssalma["ST_PAID"];
                //$settledate = $row_rssalma["ST_DATE"];

                if ($row_rssalma['ST_FLAG'] == "UT") {
                    $settledate = $row_rssalma["ST_DATE"];
                } else {
                    $settledate = $row_rssalma["st_chdate"];
                }
                $date1 = $Inv_date;
                $date2 = $settledate;

                $diff = (strtotime($date2) - strtotime($date1));

                if ($row_rssalma['ST_FLAG'] == "UT") {
                    $days = 0;
                    // $days = string($days); 
                } else {
                    $days = floor($diff / (60 * 60 * 24));
                }

                $sql_RSINVO = "Select * from s_invo  where REF_NO =  '" . trim($_GET["invno"]) . "'";
                $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                $row_sinvo = mysqli_fetch_array($result_RSINVO);



                $sql_tmpinst = " insert into tmp_cash_credit_note_form (id, crn_form_no, Inv_date, InvInv_date, inv_no, Amount, settleamt, settledate,  days, tmp_no, balance,disc,st_refno) values (" . $row_rssalma["ID"] . ", '" . $_GET["txtrefno"] . "', '" . $Inv_date . "', '" . $row_rssalma["SDATE"] . "', '" . $inv_no . "', " . $invamount . ", " . $settleamt . ", '" . $settledate . "', " . $days . " , '" . $_SESSION["credit_note_form"] . "', " . $balance_val . ",'" . $row_sinvo['DIS_per'] . "','" . $row_rssalma["ST_REFNO"] . "')";
                //echo $sql_tmpinst;
                $result_tmpinst = mysqli_query($GLOBALS['dbinv'], $sql_tmpinst);
                if (!$result_tmpinst) {
                    echo mysqli_error($GLOBALS['dbinv']);
                }
            }
        } else {
            if ($_SESSION["check"] == "new") {
                $msg = "No cash/cheque settlement records found in this invoice";
            } else {
                $msg = "yes";
            }
            if ($msg == "yes") {

                $sql_rsstr = "Select * from view_s_sttr_copy where ST_INVONO = '" . trim($_GET["invno"]) . "'  ";
                $result_rsstr = mysqli_query($GLOBALS['dbinv'], $sql_rsstr);
                if ($row_rsstr = mysqli_fetch_array($result_rsstr)) {

                    $result_rsstr = mysqli_query($GLOBALS['dbinv'], $sql_rsstr);
                    while ($row_rsstr = mysqli_fetch_array($result_rsstr)) {

                        if ((is_null($row_rsstr["deli_date"]) == false) and ( $row_rsstr["deli_date"] != "0000-00-00")) {
                            $Inv_date = $row_rsstr["deli_date"];
                        } else {
                            $Inv_date = $row_rsstr["SDATE"];
                        }

                        $balance_val = $row_rsstr["GRAND_TOT"] - $row_rsstr["ST_PAID"];

                        $inv_no = $row_rsstr["ST_INVONO"];
                        $invamount = $row_rsstr["GRAND_TOT"];
                        $settleamt = $row_rsstr["ST_PAID"];
                        $settledate = $row_rsstr["ST_DATE"];

                        $date1 = $Inv_date;
                        $date2 = $settledate;
                        $diff = (strtotime($date2) - strtotime($date1));
                        $days = floor($diff / (60 * 60 * 24));


                        $sql_RSINVO = "Select * from s_invo  where REF_NO =  '" . trim($_GET["invno"]) . "'";
                        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
                        $row_sinvo = mysqli_fetch_array($result_RSINVO);

                        $sql_tmpinst = " insert into tmp_cash_credit_note_form (id, crn_form_no, Inv_date, InvInv_date, inv_no, Amount, settleamt, settledate,  days, tmp_no, balance,disc,st_refno) values (" . $row_rsstr["ID"] . ", '" . $_GET["txtrefno"] . "', '" . $Inv_date . "', '" . $row_rsstr["SDATE"] . "', '" . $inv_no . "', " . $invamount . ", " . $settleamt . ", '" . $settledate . "', " . $days . " , '" . $_SESSION["credit_note_form"] . "', " . $balance_val . ",'" . $row_sinvo['DIS_per'] . "','" . $row_rsstr["ST_REFNO"] . "')";


                        $result_tmpinst = mysqli_query($GLOBALS['dbinv'], $sql_tmpinst);
                        if (!$result_tmpinst) {
                            echo mysqli_error($GLOBALS['dbinv']);
                        }
                    }
                } else {
                    $msgbox = "No any records found in this invoice";
                }
            } else {
                
            }
        }
        $_SESSION["check"] = "";




        $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"50\"  background=\"\" ><font color=\"#FFFFFF\">ID</font></td>
							  <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Deli.Date</font></td>
							  <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Inv.Date</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Inv.Amount</font></td>
							  
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Dis 2</font></td>
							  
							  
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Settle Amou</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Settle Date</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Balance</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Days</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Cash Dis%</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Dis Amount</font></td>
                              <td width=\"20\" ></td>
                              <td width=\"20\" ></td>
                              <td width=\"80\"  background=\"\"><font color=\"#FFFFFF\">Balance %</font></td>
                              <td width=\"120\"  background=\"\"><font color=\"#FFFFFF\">Ref No</font></td>
       						</tr>";

        $Incen_val_val = 0;

        $sql = "Select * from tmp_cash_credit_note_form where tmp_no = '" . $_SESSION["credit_note_form"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {

            $inv_id = "id" . $i;
            $Inv_date = "Inv_date" . $i;
            $InvInv_date = "InvInv_date" . $i;
            $inv_no = "inv_no" . $i;
            $Amount = "Amount" . $i;

            $disc = "disc" . $i;
            $disc1 = "disc1" . $i;


            $settleamt = "settleamt" . $i;
            $settledate = "settledate" . $i;
            $days = "days" . $i;
            $Incen_per = "Incen_per" . $i;
            $Incen_val = "Incen_val" . $i;
            $balance = "balance" . $i;
            $disc1 = "disc1" . $i;
            $st_refno = "st_refno" . $i;


// prawee 20.07.16
        //        $sql_rssalma = "Select * from view_s_sttr_copy where ST_INVONO = '" . trim($_GET["invno"]) . "' AND (ST_FLAG = 'CHK' or ST_FLAG = 'J/Entry' or ST_FLAG ='Cash TT' or ST_FLAG ='CAS' or ST_FLAG ='UT')";
        // //echo $sql_rssalma;
        // $result_rssalma = mysqli_query($GLOBALS['dbinv'], $sql_rssalma);

        // if ($row_rssalma = mysqli_fetch_array($result_rssalma)) {
        //      if ($row_rssalma['ST_FLAG'] == "UT") {
        //             $days = ;
        //             // $days = string($days); 
        //         } else {
        //             $days = $row['days']
        //         }
        // }
// =====================




            $ResponseXML .= "<tr>
                        	
							 <td ><input type=\"text\" size=\"10\" name=" . $inv_id . "  disabled id=" . $inv_id . " value='" . $row['id'] . "'  class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $Inv_date . "  disabled id=" . $Inv_date . " value='" . $row['Inv_date'] . "'  class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $InvInv_date . "  disabled id=" . $InvInv_date . " value='" . $row['InvInv_date'] . "'  class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"30\" name=" . $inv_no . "  disabled id=" . $inv_no . " value='" . $row["inv_no"] . "' class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $Amount . "  disabled id=" . $Amount . " value=" . $row['Amount'] . " class=\"text_purchase3_right\"/></td>
							 
							 <td ><input type=\"text\" size=\"10\" name=" . $disc . "  disabled id=" . $disc . " value=" . $row['disc'] . " class=\"text_purchase3_right\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $disc1 . "   id=" . $disc1 . " value=" . $row['disc1'] . " class=\"text_purchase3_right\"/></td>
							 
							 
							 <td ><input type=\"text\" size=\"10\" name=" . $settleamt . "  disabled id=" . $settleamt . " value=" . $row['settleamt'] . " class=\"text_purchase3_right\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $settledate . "  disabled id=" . $settledate . " value=" . $row['settledate'] . " class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $balance . "  disabled id=" . $balance . " value='" . $row["balance"] . "' class=\"text_purchase3_right\"/></td>
							  <td ><input type=\"text\" size=\"10\" name=" . $days . "  disabled id=" . $days . " value=" . $row['days'] . " class=\"text_purchase3_right\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=" . $Incen_per . " id=" . $Incen_per . "   onkeyup='caldis($i);'   id=" . $Incen_per . " value='" . $row['Incen_per'] . "' class=\"text_purchase3_right\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=" . $Incen_val . " onBlur=\"cal_incentive_val_cash('" . $i . "')\" onkeypress=\"cal_incentive_val_cash('" . $i . "')\"  id=" . $Incen_val . " value='" . $row['Incen_val'] . "' class=\"text_purchase3_right\"/></td>
            	            	
            	
				
				<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row["inv_no"] . "  name=" . $row["inv_no"] . " onClick=\"del_item('" . $row["inv_no"] . "');\"></td>
				<td ><a href=\"\" class=\"INV\" onClick=\"NewWindow('sales_inv_display.php?refno=" . $row["inv_no"] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"><input type=\"button\" name=\"searchcust\" id=\"searchcust\" value=\"...\"  class=\"btn_purchase\"></a></td>
				
                <td ><input type=\"text\" size=\"10\" disabled name=" . $disc1 . " onBlur=\"cal_incentive_val_cash('" . $i . "')\" onkeypress=\"cal_incentive_val_cash('" . $i . "')\"  id=" . $disc1 . " value='" . $row['disc1'] . "' class=\"text_purchase3_right\"/></td>
                <td ><input type=\"text\" size=\"10\" disabled name=" . $st_refno . " onBlur=\"cal_incentive_val_cash('" . $i . "')\" onkeypress=\"cal_incentive_val_cash('" . $i . "')\"  id=" . $st_refno . " value='" . $row['st_refno'] . "' class=\"text_purchase3_right\"/></td>
				
				</tr>";



            if ((is_null($row['Incen_val']) == false) and ( $row['Incen_val'] != "")) {
                $Incen_val_val = $Incen_val_val + $row['Incen_val'];
            }
            $i = $i + 1;
        }

        $ResponseXML .= "   </table>]]></sales_table>";
        $ResponseXML .= "<Incen_val><![CDATA[" . $Incen_val_val . "]]></Incen_val>";
        $ResponseXML .= "<mcou><![CDATA[" . $i . "]]></mcou>";
        $ResponseXML .= "<msg><![CDATA[]]></msg>";
        $ResponseXML .= "</salesdetails>";
    }


    //Loop
    //txttot = Format(tot, "######.00")		




    echo $ResponseXML;
}

if ($_GET["Command"] == "invno_check") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $sql_tmpinst = " delete from tmp_cash_credit_note_form where crn_form_no='" . $_GET["txtrefno"] . "' and inv_no='" . $_GET["invno"] . "'";
    $result_tmpinst = mysqli_query($GLOBALS['dbinv'], $sql_tmpinst);

    $ResponseXML = "<salesdetails>";

    $_SESSION["REFNO"] = $_GET["invno"];

    $i = 1;
    $tot = 0;
    // Do While MSFlexGrid1.TextMatrix(i, 1) <> ""
    $mqty = 0;
    $sql_rscrn = " Select * from s_crnfrm where Refno = '" . $_GET["invno"] . "'";
    $result_rscrn = mysqli_query($GLOBALS['dbinv'], $sql_rscrn);
    if ($row_rscrn = mysqli_fetch_array($result_rscrn)) {

        $_SESSION["credit_note_form"] = $row_rscrn["tmp_no"];

        if (is_null($row_rscrn["Sdate"]) == false) {
            $ResponseXML .= "<DTPicker1><![CDATA[" . $row_rscrn["Sdate"] . "]]></DTPicker1>";
        } else {
            $ResponseXML .= "<DTPicker1><![CDATA[]]></DTPicker1>";
        }
        if (is_null($row_rscrn["Code"]) == false) {
            $ResponseXML .= "<txt_cuscode><![CDATA[" . $row_rscrn["Code"] . "]]></txt_cuscode>";
        } else {
            $ResponseXML .= "<txt_cuscode><![CDATA[]]></txt_cuscode>";
        }

        $sql2 = " Select * from vendor where CODE = '" . $row_rscrn["Code"] . "'";
        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
        $row2 = mysqli_fetch_array($result2);
        if (is_null($row2["NAME"]) == false) {
            $ResponseXML .= "<txt_cusname><![CDATA[" . $row2["NAME"] . "]]></txt_cusname>";
        } else {
            $ResponseXML .= "<txt_cusname><![CDATA[]]></txt_cusname>";
        }

        if (is_null($row_rscrn["Mon"]) == false) {
            $ResponseXML .= "<MonthView1><![CDATA[" . $row_rscrn["Mon"] . "]]></MonthView1>";
        } else {
            $ResponseXML .= "<MonthView1><![CDATA[]]></MonthView1>";
        }
        if (trim($row_rscrn["Checked"]) == "A") {
            $ResponseXML .= "<txt_check><![CDATA[]]></txt_check>";
        } else {
            $ResponseXML .= "<txt_check><![CDATA[" . $row_rscrn["Checked"] . "]]></txt_check>";
        }

        if (is_null($row_rscrn["Check_date"]) == false) {
            $ResponseXML .= "<DTPicker2><![CDATA[" . $row_rscrn["Check_date"] . "]]></DTPicker2>";
        } else {
            $ResponseXML .= "<DTPicker2><![CDATA[]]></DTPicker2>";
        }
        if (is_null($row_rscrn["Approved"]) == false) {
            $ResponseXML .= "<txt_auth><![CDATA[" . $row_rscrn["Approved"] . "]]></txt_auth>";
        } else {
            $ResponseXML .= "<txt_auth><![CDATA[]]></txt_auth>";
        }

        if (is_null($row_rscrn["App_date"]) == false) {
            $ResponseXML .= "<DTPicker5><![CDATA[" . $row_rscrn["App_date"] . "]]></DTPicker5>";
        } else {
            $ResponseXML .= "<DTPicker5><![CDATA[]]></DTPicker5>";
        }

        if (is_null($row_rscrn["Sal_ex"]) == false) {
            $sql1 = " Select * from s_salrep where REPCODE = '" . $row_rscrn["Sal_ex"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($row1 = mysqli_fetch_array($result1)) {
                $ResponseXML .= "<Com_rep><![CDATA[" . $row1["REPCODE"] . " " . $row1["Name"] . "]]></Com_rep>";
            }
        } else {
            $ResponseXML .= "<Com_rep><![CDATA[]]></Com_rep>";
        }

        if (is_null($row_rscrn["Refno"]) == false) {
            $ResponseXML .= "<txtrefno><![CDATA[" . $row_rscrn["Refno"] . "]]></txtrefno>";
        } else {
            $ResponseXML .= "<txtrefno><![CDATA[]]></txtrefno>";
        }

        if (is_null($row_rscrn["Remark"]) == false) {
            $ResponseXML .= "<txtremark><![CDATA[" . $row_rscrn["Remark"] . "]]></txtremark>";
        } else {
            $ResponseXML .= "<txtremark><![CDATA[]]></txtremark>";
        }

        if ($row_rscrn["Checked"] == "A") {
            $ResponseXML .= "<cmd_check><![CDATA[Check]]></cmd_check>";
        } else {
            $ResponseXML .= "<cmd_check><![CDATA[Checked]]></cmd_check>";
        }

        if (is_null($row_rscrn["Approved"]) == true) {
            $ResponseXML .= "<cmd_auth><![CDATA[Autorize]]></cmd_auth>";
        } else {
            $ResponseXML .= "<cmd_auth><![CDATA[Autorized]]></cmd_auth>";
        }

        $ResponseXML .= "<txttot><![CDATA[" . $row_rscrn["Amount"] . "]]></txttot>";
        if ($row_rscrn["Lock1"] == "1") {
            $ResponseXML .= "<lbllock><![CDATA[Locked]]></lbllock>";
        } else {
            $ResponseXML .= "<lbllock><![CDATA[]]></lbllock>";
        }


        $sql = "delete from tmp_cash_credit_note_form where tmp_no = '" . $_SESSION["credit_note_form"] . "'";
        //echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);



        $sql_rscrntrn = "Select * from s_crnfrmtrn where Refno = '" . $_GET["invno"] . "'";

        $result_rscrntrn = mysqli_query($GLOBALS['dbinv'], $sql_rscrntrn);
        while ($row_rscrntrn = mysqli_fetch_array($result_rscrntrn)) { 

            $sql_rssal = "select deli_date, GRAND_TOT, TOTPAY from s_salma where REF_NO = '" . trim($row_rscrntrn["Inv_no"]) . "'";

            $result_rssal = mysqli_query($GLOBALS['dbinv'], $sql_rssal);
            $row_rssal = mysqli_fetch_array($result_rssal);
            if ((is_null($row_rssal["deli_date"]) == false) and ( $row_rssal["deli_date"] != "0000-00-00")) {
                $Inv_date = $row_rssal["deli_date"];
            } else {
                if ((is_null($row_rscrntrn["Inv_date"]) == false) and ( $row_rscrntrn["Inv_date"] != "0000-00-00")) {
                    $Inv_date = $row_rscrntrn["Inv_date"];
                }
            }

            $balance_val = $row_rssal["GRAND_TOT"] - $row_rssal["TOTPAY"];

            if ((is_null($row_rscrntrn['Settle_amo']) == false) and ( $row_rscrntrn['Settle_amo'] != "")) {
                $Settle_amo = $row_rscrntrn['Settle_amo'];
            } else {
                $Settle_amo = 0;
            }
            //$Settle_amo = $row_rscrntrn['Amount1'];

            $date1 = $Inv_date;
            $date2 = $row_rscrntrn["Mon"];
            $diff = (strtotime($date2) - strtotime($date1));
// ===================== ppppppppppppp
            // $sql_rssalma123 = "Select * from view_s_sttr_copy where ST_INVONO = '" . trim($row_rscrntrn["Inv_no"]) . "' AND  ST_FLAG ='UT' "; 
            // $result_rssalma123 = mysqli_query($GLOBALS['dbinv'], $sql_rssalma123);
            // while ($row_rssalma123 = mysqli_fetch_array($result_rssalma123)) { 
                 
            //      $days = floor($diff / (60 * 60 * 24));
            // }else{
                 $days = floor($diff / (60 * 60 * 24));
            // }

           


            IF ($Inv_date == "") {
                $Inv_date = "0000-00-00";
            }

            $sql_tmpinst = " insert into tmp_cash_credit_note_form (crn_form_no, Inv_date, inv_no, Amount, settleamt, settledate, days,  Incen_per, Incen_val, tmp_no, balance,disc,disc1,st_refno) values ('" . $_GET["invno"] . "', '" . $Inv_date . "', '" . $row_rscrntrn["Inv_no"] . "', '" . $row_rscrntrn['Amount'] . "', " . $Settle_amo . ", '" . $row_rscrntrn["Mon"] . "', " . $days . ", " . $row_rscrntrn["Incen_per"] . ", " . $row_rscrntrn["Incen_val"] . ", '" . $_SESSION["credit_note_form"] . "', " . $balance_val . ",'" . $row_rscrntrn["disc"] . "','" . $row_rscrntrn["disc1"] . "','" . $row_rscrntrn["st_refno"] . "')";
            //echo $sql_tmpinst;
            $result_tmpinst = mysqli_query($GLOBALS['dbinv'], $sql_tmpinst);
            if (!$result_tmpinst) {
                echo mysqli_error($GLOBALS['dbinv']);
            }
        }

        $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Deli.Date</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Inv.Amount</font></td>
							   <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Dis 2</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Settle Amou</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Settle Date</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Balance</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Days</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Cash Dis%</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Dis Amount</font></td>
                               <td width=\"20\"></td>
                              <td width=\"20\"></td>
                              <td width=\"80\">Balance %.</td>       
                             <td width=\"120\">Ref No</td>        
                             
                            </tr>";

        $Incen_val_val = 0;

        $sql = "Select * from tmp_cash_credit_note_form where tmp_no = '" . $_SESSION["credit_note_form"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {

// prawee 20.07.16
            // $sql_rsstr1 = "Select * from view_s_sttr_copy where ST_INVONO = '" . trim($row["inv_no"]) . "'  ";
            // $result_rsstr1 = mysqli_query($GLOBALS['dbinv'], $sql_rsstr1);
            // $row_rsstr1 = mysqli_fetch_array($result_rsstr1);
            // if ($row_rsstr1['ST_FLAG'] == "UT") {
            //     $days1=$row['days'];
            // }else{
            //     $days1=$row['days'];
            // }
// =====================
            $Inv_date = "Inv_date" . $i;
            $inv_no = "inv_no" . $i;
            $Amount = "Amount" . $i;

            $disc = "disc" . $i;
            $disc1 = "disc1" . $i;

            $settleamt = "settleamt" . $i;
            $settledate = "settledate" . $i;
            $Incen_per = "Incen_per" . $i;
            $Incen_val = "Incen_val" . $i;
            $days = "days" . $i;
            $balance = "balance" . $i;
            $st_refno = "st_refno" . $i;

            $ResponseXML .= "<tr>
                        
							 <td ><input type=\"text\" size=\"10\" name=" . $Inv_date . "  disabled id=" . $Inv_date . " value='" . $row['Inv_date'] . "' class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"30\" name=" . $inv_no . "  disabled id=" . $inv_no . " value='" . $row["inv_no"] . "' class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $Amount . "  disabled id=" . $Amount . " value=" . $row['Amount'] . " class=\"text_purchase3_right\"/></td>
							 
							 
							 <td><input type=\"text\" size=\"10\" name=" . $disc . "  disabled id=" . $disc . " value=" . $row['disc'] . " class=\"txtbox\"/></td>
							 <td><input type=\"text\" size=\"10\" name=" . $disc1 . "  disabled id=" . $disc1 . " value=" . $row['disc1'] . " class=\"txtbox\"/></td>
				 
							 <td ><input type=\"text\" size=\"10\" name=" . $settleamt . "  disabled id=" . $settleamt . " value=" . $row['settleamt'] . " class=\"text_purchase3_right\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $settledate . "  disabled id=" . $settledate . " value=" . $row['settledate'] . " class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $balance . "  disabled id=" . $balance . " value='" . $row["balance"] . "' class=\"text_purchase3_right\"/></td>
							 
							  <td ><input type=\"text\" size=\"10\" name=" . $days . "  disabled id=" . $days . " value='" . $row['days'] . "' class=\"text_purchase3_right\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=" . $Incen_per . " disabled onBlur=\"cal_incentive('" . $i . "')\"  id=" . $Incen_per . " value='" . $row['Incen_per'] . "' class=\"text_purchase3_right\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=" . $Incen_val . " disabled onBlur=\"cal_incentive_val('" . $i . "')\"  id=" . $Incen_val . " value='" . $row['Incen_val'] . "' class=\"text_purchase3_right\"/></td>
            	            	
            	
				
				<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row["inv_no"] . "  name=" . $row["inv_no"] . " onClick=\"del_item('" . $row["inv_no"] . "');\"></td>
				<td ><a href=\"\" class=\"INV\" onClick=\"NewWindow('sales_inv_display.php?refno=" . $row["inv_no"] . "&trn_type=" . $rstemp['TRN_TYPE'] . "','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"><input type=\"button\" name=\"searchcust\" id=\"searchcust\" value=\"...\"  class=\"btn_purchase\"></a></td>
                <td><input type=\"text\" size=\"10\" name=" . $disc1 . "   disabled id=" . $disc1 . " value=" . $row['disc1'] . " class=\"txtbox\"/></td>
                 <td><input type=\"text\" size=\"10\" name=" . $st_refno . "  disabled   id=" . $st_refno . " value=" . $row['st_refno'] . " class=\"txtbox\"/></td>
				</tr>";
                

            if ((is_null($row['Incen_val']) == false) and ( $row['Incen_val'] != "")) {
                $Incen_val_val = $Incen_val_val + $row['Incen_val'];
            }
            $i = $i + 1;
        }

        $ResponseXML .= "   </table>]]></sales_table>";
        $ResponseXML .= "<Incen_val><![CDATA[" . $Incen_val_val . "]]></Incen_val>";
        $ResponseXML .= "<mcou><![CDATA[" . $i . "]]></mcou>";
        $ResponseXML .= "<mcou><![CDATA[0]]></mcou>";
        $ResponseXML .= "<msg><![CDATA[]]></msg>";
    }


    //Loop
    //txttot = Format(tot, "######.00")		


    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}



if ($_GET["Command"] == "save_incent") {





    $sql_tmpinst = " update tmp_cash_credit_note_form set Incen_per=" . $_GET["Incen_per"] . ", Incen_val=" . $_GET["Incen_val"] . " where crn_form_no='" . $_GET["txtrefno"] . "' and inv_no='" . $_GET["inv_no"] . "' and id=" . $_GET["id"];
    echo $sql_tmpinst;
    $result_tmpinst = mysqli_query($GLOBALS['dbinv'], $sql_tmpinst);
}




if ($_GET["Command"] == "del_item") {


    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $sql_tmpinst = " delete from tmp_cash_credit_note_form where crn_form_no='" . $_GET["txtrefno"] . "' and inv_no='" . $_GET["code"] . "'";
    $result_tmpinst = mysqli_query($GLOBALS['dbinv'], $sql_tmpinst);

    $ResponseXML = "<salesdetails>";



    $i = 1;
    $tot = 0;
    // Do While MSFlexGrid1.TextMatrix(i, 1) <> ""
    $mqty = 0;


    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Amount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Incentive (%)</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Incentive Val</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Brand</font></td>
                             
                            </tr>";

    $Incen_val_val = 0;

    $sql = "Select * from tmp_cash_credit_note_form where crn_form_no = '" . $_GET["txtrefno"] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    while ($row = mysqli_fetch_array($result)) {

        $Inv_date = "Inv_date" . $i;
        $inv_no = "inv_no" . $i;
        $Amount = "Amount" . $i;
        $disc = "disc" . $i;
        $Qty = "Qty" . $i;
        $Incen_per = "Incen_per" . $i;
        $Incen_val = "Incen_val" . $i;
        $Brands = "Brands" . $i;

        $ResponseXML .= "<tr>
                        
							 <td ><input type=\"text\" size=\"10\" name=" . $Inv_date . "  disabled id=" . $Inv_date . " value='" . $row['Inv_date'] . "' class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"30\" name=" . $inv_no . "  disabled id=" . $inv_no . " value='" . $row["inv_no"] . "' class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $Amount . "  disabled id=" . $Amount . " value=" . $row['Amount'] . " class=\"text_purchase3\"/></td>
							 
							 <td ><input type=\"text\" size=\"10\" name=" . $disc . "  disabled id=" . $disc . " value=" . $row['disc'] . " class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $Qty . "  disabled id=" . $Qty . " value=" . $row['Qty'] . " class=\"text_purchase3\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=" . $Incen_per . "  onBlur=\"cal_incentive('" . $i . "')\" id=" . $Incen_per . " value='" . $row['Incen_per'] . "' class=\"text_purchase3\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=" . $Incen_val . "  disabled id=" . $Incen_val . " value='" . $row['Incen_val'] . "' class=\"text_purchase3\"/></td>
            	            	
            	<td ><input type=\"text\" size=\"10\" name=" . $Brands . "  disabled id=" . $Brands . " value=" . $row['Brands'] . " class=\"text_purchase3\"/></td>
				
				<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row["inv_no"] . "  name=" . $row["inv_no"] . " onClick=\"del_item('" . $row["inv_no"] . "');\"></td></tr>";

        if ((is_null($row['Incen_val']) == false) and ( $row['Incen_val'] != "")) {
            $Incen_val_val = $Incen_val_val + $row['Incen_val'];
        }
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></sales_table>";
    $ResponseXML .= "<Incen_val><![CDATA[" . $Incen_val_val . "]]></Incen_val>";
    $ResponseXML .= "<mcou><![CDATA[" . $i . "]]></mcou>";
    $ResponseXML .= "<msg><![CDATA[]]></msg>";




    //Loop
    //txttot = Format(tot, "######.00")		


    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}



if ($_GET["Command"] == "save_item") {

    if ($_SESSION["dev"] == "") {
        exit("no");
    }

    include('connectioni.php');

    $sql_status = 0;

    mysqli_query($GLOBALS['dbinv'], "SET AUTOCOMMIT=0");
    mysqli_query($GLOBALS['dbinv'], "START TRANSACTION");

    $sql_invpara = "SELECT * from invpara";
    $result_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
    $row_invpara = mysqli_fetch_array($result_invpara);

    $vatrate = $row_invpara["vatrate"] / 100;

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    if (($_GET["txt_cuscode"] != "") and ( $_GET["mcou"] > 0)) {
        $mrefno = trim($_GET["txtrefno"]);

        $sql_rscrnfrm = "Select * from s_crnfrmtrn where Refno = '" . $mrefno . "'";
        $result_rscrnfrm = mysqli_query($GLOBALS['dbinv'], $sql_rscrnfrm);

        $sql_rscrn = "Select * From s_crnfrm where Refno = '" . $mrefno . "'";
        $result_rscrn = mysqli_query($GLOBALS['dbinv'], $sql_rscrn);
        if ($row_rscrnfrm = mysqli_fetch_array($result_rscrnfrm)) {
            $row_rscrn = mysqli_fetch_array($result_rscrn);
            if ($row_rscrn["Lock1"] == "1") {
                exit("Sorry this Credit note is locked");
            }
            $sql1 = "Delete from s_crnfrmtrn where Refno = '" . $mrefno . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($result1 != 1) {
                $sql_status = 1;
            }

            $sql1 = "Delete from s_crnfrm where REfno = '" . $mrefno . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($result1 != 1) {
                $sql_status = 1;
            }

            $i = 1;
            $mamount = 0;
            while ($_GET["mcou"] > $i) {

                $Inv_date = "Inv_date" . $i;
                $inv_no = "inv_no" . $i;
                $Amount = "Amount" . $i;
                $disc = "disc" . $i;
                $disc1 = "disc1" . $i;

                $Qty = "Qty" . $i;
                $Incen_per = "Incen_per" . $i;
                $Incen_val = "Incen_val" . $i;
                $Brands = "Brands" . $i;
                $settledate = "settledate" . $i;
                $refno = "st_refno" . $i;

                IF (isset($_GET[$Qty])) {
                    $mqty = 0;
                } else {


                    if ($_GET[$Qty] == "") {
                        $mqty = 0;
                    } else {
                        $mqty = $_GET[$Qty];
                    }
                }
                if ($_GET[$Incen_val] != "") {
                    $sql1 = "Insert into s_crnfrmtrn (Sdate, Refno, Code, Name, Sal_ex, Mon, Inv_no, Inv_date, Amount, Qty, Incen_per, Incen_val, Brand, Flag, tmp_no,disc,disc1,st_refno) values('" . $_GET["DTPicker1"] . "', '" . $mrefno . "','" . trim($_GET["txt_cuscode"]) . "', '" . trim($_GET["txt_cusname"]) . "', '" . $_GET["Com_rep"] . "', '" . $_GET[$settledate] . "','" . trim($_GET[$inv_no]) . "', '" . $_GET[$Inv_date] . "', '" . $_GET[$Amount] . "', '" . $mqty . "', '" . $_GET[$Incen_per] . "', '" . $_GET[$Incen_val] . "','" . $_GET[$Brands] . "','CCRN', '" . $_SESSION["credit_note_form"] . "','" . $_GET[$disc] . "','" . $_GET[$disc1] . "','" . $_GET[$refno] . "')";
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    if ($result1 != 1) {
                        $sql_status = 1;
                    }
                }

                $mamount = $mamount + $_GET[$Incen_val];
                $i = $i + 1;
            }

            $sql1 = "insert into s_crnfrm (Refno, Sdate, Code, Mon, Amount, Remark, Sal_ex, Flag, Checked, Lock1, Cancell, Credit_note, tmp_no) Values('" . $mrefno . "','" . $_GET["DTPicker1"] . "', '" . trim($_GET["txt_cuscode"]) . "', '" . $_GET["MonthView1"] . "', '" . $mamount . "','" . trim($_GET["txtremark"]) . "','" . $_GET["Com_rep"] . "','CCRN', 'A', '0', '0', 'A', '" . $_SESSION["credit_note_form"] . "')";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($result1 != 1) {
                $sql_status = 1;
            }

            $sql1 = "Update invpara set CCRNNO = CCRNNO+1";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($result1 != 1) {
                $sql_status = 1;
            }


            if ($sql_status == 0) {
                mysqli_query($GLOBALS['dbinv'], "COMMIT");
                echo "Saved";
            } else {
                mysqli_query($GLOBALS['dbinv'], "ROLLBACK");
                echo "Error has occures. Can't Save";
            }
        } else {
            $i = 1;
            $mamount = 0;
            while ($_GET["mcou"] > $i) {

                $Inv_date = "Inv_date" . $i;
                $inv_no = "inv_no" . $i;
                $Amount = "Amount" . $i;
                $disc = "disc" . $i;
                $disc1 = "disc1" . $i;
                $Qty = "Qty" . $i;
                $Incen_per = "Incen_per" . $i;
                $Incen_val = "Incen_val" . $i;
                $Brands = "Brands" . $i;
                $settledate = "settledate" . $i;
                $settle_amo = "settleamt" . $i;
                $refno = "st_refno" . $i;


                $mqty = $_GET[$Qty];
                $minsp = $_GET[$Incen_per];
                $minsv = $_GET[$Incen_val];





                $sql1 = "Insert into s_crnfrmtrn (Sdate, Refno, Code, Name, Sal_ex, Mon, Inv_no, Inv_date, Amount, Qty, Incen_per, Incen_val, Brand, Flag, tmp_no,Settle_amo,disc,disc1,st_refno) values('" . $_GET["DTPicker1"] . "','" . $mrefno . "','" . trim($_GET["txt_cuscode"]) . "','" . trim($_GET["txt_cuscode"]) . "','" . $_GET["Com_rep"] . "', '" . $_GET[$settledate] . "','" . trim($_GET[$inv_no]) . "','" . $_GET[$Inv_date] . "','" . $_GET[$Amount] . "', '" . $mqty . "', '" . $minsp . "', '" . $minsv . "','" . $_GET[$Brands] . "','CCRN', '" . $_SESSION["credit_note_form"] . "','" . $_GET[$settle_amo] . "','" . $_GET[$disc] . "','" . $_GET[$disc1] . "','" . $_GET[$refno] . "')";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                if (!$result1) {
                    echo mysqli_error($GLOBALS['dbinv']);
                    $sql_status = 1;
                }
                $mamount = $mamount + $_GET[$Incen_val];
                $i = $i + 1;
            }

            $sql1 = "insert into s_crnfrm (Refno,sdate,code,mon,Amount,Remark,sal_ex,flag, Checked, Lock1, Cancell, Credit_note, tmp_no) Values('" . $mrefno . "','" . $_GET["DTPicker1"] . "', '" . trim($_GET["txt_cuscode"]) . "','" . $_GET["MonthView1"] . "', '" . $mamount . "','" . trim($_GET["txtremark"]) . "','" . $_GET["Com_rep"] . "','CCRN', 'A', '0', '0', 'A', '" . $_SESSION["credit_note_form"] . "')";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if (!$result1) {
                echo mysqli_error($GLOBALS['dbinv']);
                $sql_status = 2;
            }

            $sql1 = "Update invpara set CCRNNO = CCRNNO+1";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

            if ($sql_status == 0) {
                mysqli_query($GLOBALS['dbinv'], "COMMIT");
                echo "Saved";
            } else {
                mysqli_query($GLOBALS['dbinv'], "ROLLBACK");
                echo "Error has occures. Can't Save";
            }
        }
    } else {
        echo "Can't Saved";
    }
}



if ($_GET["Command"] == "cancel_inv") {
    include('connectioni.php');

    $sql_status = 0;

    mysqli_query($GLOBALS['dbinv'], "SET AUTOCOMMIT=0");
    mysqli_query($GLOBALS['dbinv'], "START TRANSACTION");


    if (($_GET["txt_cuscode"] != "") and ( $_GET["mcou"] > 0)) {
        $mrefno = trim($_GET["txtrefno"]);
        $sql_rscrnfrm = "Select * from s_crnfrmtrn where Refno = '" . $mrefno . "'";
        $result_rscrnfrm = mysqli_query($GLOBALS['dbinv'], $sql_rscrnfrm);
        if ($result_rscrnfrm != 1) {
            $sql_status = 1;
        }

        $sql_rscrn = " Select * from s_crnfrm where Refno = '" . $mrefno . "'";
        $result_rscrn = mysqli_query($GLOBALS['dbinv'], $sql_rscrn);
        if ($row_rscrnfrm = mysqli_fetch_array($result_rscrnfrm)) {

            $row_rscrn = mysqli_fetch_array($result_rscrn);

            if ($row_rscrn["Lock1"] == "1") {
                exit("Sorry this credit note cannot Cancel");
            }

            $sql1 = "Update s_crnfrm set Cancell = '1' where Refno = '" . $mrefno . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($result1 != 1) {
                $sql_status = 1;
            }

            $sql1 = "Delete from s_crnfrmtrn where Refno = '" . $mrefno . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($result1 != 1) {
                $sql_status = 2;
            }

            if ($sql_status == 0) {
                mysqli_query($GLOBALS['dbinv'], "COMMIT");
                echo "Canceled";
            } else {
                mysqli_query($GLOBALS['dbinv'], "ROLLBACK");
                echo "Error has occures. Can't Cancel";
            }
        }
    }
}

if ($_GET["Command"] == "set_month") {

    $_SESSION["MonthView1"] = $_GET["MonthView1"];
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
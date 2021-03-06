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


if ($_GET["Command"] == "new_inv") {

    $_SESSION["print"] = 0;

    /* 	$sql="Select CAS_INV_NO_m from invpara";
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ;
      $row = mysqli_fetch_array($result);
      $tmpinvno="000000".$row["CAS_INV_NO_m"];
      $lenth=strlen($tmpinvno);
      $invno="INV".substr($tmpinvno, $lenth-7);
      echo $invno; */

    $_SESSION["MonthView1"] = "";

    $sql = "Select crnfrmno from invpara";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "000000" . $row["crnfrmno"];
    $lenth = strlen($tmpinvno);
    //$invno=trim("CFRM/".$_SESSION['company']."/ ").substr($tmpinvno, $lenth-7);
    $invno = trim("CFRM/" . $_GET["Com_rep"] . "/ ") . substr($tmpinvno, $lenth - 7);
    $_SESSION["invno"] = $invno;

    $sql = "Select crnfrmno from tmpinvpara";

    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    $row = mysqli_fetch_array($result);
    $tmpinvno = "000000" . $row["crnfrmno"];
    $lenth = strlen($tmpinvno);
    //$invno1=trim("CFRM/".$_SESSION['company']."/ ").substr($tmpinvno, $lenth-7);
    $invno1 = trim("CFRM/" . $_GET["Com_rep"] . "/ ") . substr($tmpinvno, $lenth - 7);
    $_SESSION["credit_note_form"] = $invno1;

    $sql = "update tmpinvpara set crnfrmno=crnfrmno+1";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);

    $sql_tmpinst = " delete from tmp_credit_note_form where crn_form_no='" . $invno . "'";
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
    $ResponseXML .= "";
    //$ResponseXML .= "<invdetails>";

    include_once("connectioni.php");

    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Customer</font></td>
                              <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Invoice Date</font></td>
   							</tr>";

    if ($_GET["stname"] == "crn") {
        if ($_GET["mstatus"] == "invno") {
            $letters = $_GET['invno'];
            // echo "select Refno, Code, Amount   from s_crnfrm where Refno like  '$letters%' and cancell = '0'  order BY Refno desc limit 50";
            $sql = mysqli_query($GLOBALS['dbinv'], "select Refno, Code, Amount   from s_crnfrm where Refno like  '$letters%' and Cancell = '0'  and Lock1='1' order BY Refno  desc limit 50") or die(mysqli_error());
        }
    } else {

        if ($_GET["mstatus"] == "invno") {
            $letters = $_GET['invno'];
            if ($_SESSION["slected"] == "all") {
                $sql = mysqli_query($GLOBALS['dbinv'], "select Refno, Code, Amount   from s_crnfrm where Refno like  '$letters%' and cancell = '0' and flag = 'ACRN' order BY Refno desc limit 50") or die(mysqli_error());
            } else if ($_SESSION["slected"] == "locked") {
                $sql = mysqli_query($GLOBALS['dbinv'], "select Refno, Code, Amount   from s_crnfrm where Refno like  '$letters%' cancell = '0' and Lock1='1' and flag = 'ACRN' order BY Refno desc limit 50") or die(mysqli_error());
            } else if ($_SESSION["slected"] == "pending") {
                $sql = mysqli_query($GLOBALS['dbinv'], "select Refno, Code, Amount   from s_crnfrm where Refno like  '$letters%' cancell = '0' and Lock1='0' and flag = 'ACRN' order BY Refno desc limit 50") or die(mysqli_error());
            }
        }
    }







    if ($_GET["stname"] == "crn") {

        while ($row = mysqli_fetch_array($sql)) {
            $cuscode = $row["CODE"];
            $stname = $_GET["stname"];
            $ResponseXML .= "<tr>               
                              <td onclick=\"invno_check_crn('" . $row['Refno'] . "', '" . $_GET['stname'] . "', '" . $row['Amount'] . "');\">" . $row['Refno'] . "</a></td>
                              <td onclick=\"invno_check_crn('" . $row['Refno'] . "', '" . $_GET['stname'] . "', '" . $row['Amount'] . "');\">" . $row["Code"] . "</a></td>
                              <td onclick=\"invno_check_crn('" . $row['Refno'] . "', '" . $_GET['stname'] . "', '" . $row['Amount'] . "');\">" . $row['Amount'] . "</a></td>
                              
                            </tr>";
        }
    } else {

        while ($row = mysqli_fetch_array($sql)) {
            $cuscode = $row["CODE"];
            $stname = $_GET["stname"];
            $ResponseXML .= "<tr>               
                              <td onclick=\"invno_check('" . $row['Refno'] . "', '" . $_GET['stname'] . "');\">" . $row['Refno'] . "</a></td>
                              <td onclick=\"invno_check('" . $row['Refno'] . "', '" . $_GET['stname'] . "');\">" . $row["Code"] . "</a></td>
                              <td onclick=\"invno_check('" . $row['Refno'] . "', '" . $_GET['stname'] . "');\">" . $row['Amount'] . "</a></td>
                              
                            </tr>";
        }
    }
    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}

if ($_GET["Command"] == "select_list") {

    if ($_GET["stname"] == "crn") {
        $_SESSION["slected"] = $_GET["mstatus"];
        if ($_GET["mstatus"] == "all") {
            $sql = "select Refno, Code, Amount   from s_crnfrm where cancell = '0' and flag = 'CCRN' order BY Refno desc limit 50";
        } else if ($_GET["mstatus"] == "locked") {
            $sql = "select Refno, Code, Amount   from s_crnfrm where cancell = '0' and Lock1='1' and flag = 'CCRN' order BY Refno desc limit 50";
        } else if ($_GET["mstatus"] == "pending") {
            $sql = "select Refno, Code, Amount   from s_crnfrm where cancell = '0' and Lock1='0' and flag = 'CCRN' order BY Refno desc limit 50";
        }

        //echo $sql;
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
                              <td onclick=\"invno_check('" . $row['Refno'] . "', '" . $_GET['stname'] . "');\">" . $row['Refno'] . "</a></td>";

            $sql_v = "select * from vendor where CODE='" . $row["Code"] . "'";
            $result_v = mysqli_query($GLOBALS['dbinv'], $sql_v);
            $row_v = mysqli_fetch_array($result_v);
            echo "<td onclick=\"invno_check('" . $row['Refno'] . "', '" . $_GET['stname'] . "');\">" . $row["Code"] . " " . $row_v["NAME"] . "</a></td>
                              <td onclick=\"invno_check('" . $row['Refno'] . "', '" . $_GET['stname'] . "');\">" . $row['Amount'] . "</a></td>
                              
                            </tr>";
        }
        echo "</table>";
    }
}

if ($_GET["Command"] == "set_session_month") {
    $_SESSION["MonthView1"] = $_GET["MonthView1"];
    echo $_SESSION["MonthView1"];
}

if ($_GET["Command"] == "pass_crn_form") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $sql_tmpinst = " delete from tmp_credit_note_form where crn_form_no='" . $_GET["txtrefno"] . "' and inv_no='" . $_GET["invno"] . "'";
    $result_tmpinst = mysqli_query($GLOBALS['dbinv'], $sql_tmpinst);

    $ResponseXML = "<salesdetails>";



    $i = 1;
    $tot = 0;
    // Do While MSFlexGrid1.TextMatrix(i, 1) <> ""
    $mqty = 0;
    $sql_rscrn = " Select * from s_crnfrmtrn where Inv_no = '" . $_GET["invno"] . "' and Flag = 'ACRN'";
    //echo $sql_rscrn;
    $result_rscrn = mysqli_query($GLOBALS['dbinv'], $sql_rscrn);
    if ($row_rscrn = mysqli_fetch_array($result_rscrn)) {



        $ResponseXML .= "<msg><![CDATA[Sorry this Invoice Incentive Already Paid]]></msg>";
    } else {


        $sql_RSINVO = "Select * from s_invo  where REF_NO =  '" . $_GET["invno"] . "'";
        $result_RSINVO = mysqli_query($GLOBALS['dbinv'], $sql_RSINVO);
        $row_sinvo = mysqli_fetch_array($result_RSINVO);
        $sql_rssalma = "Select * from s_salma where REF_NO = '" . $_GET["invno"] . "'";
        $result_rssalma = mysqli_query($GLOBALS['dbinv'], $sql_rssalma);
        if ($row_rssalma = mysqli_fetch_array($result_rssalma)) {


            $sql_rsqty = " select * from view_salma_sinvo where REF_NO = '" . trim($row_rssalma["REF_NO"]) . "'";
            $result_rsqty = mysqli_query($GLOBALS['dbinv'], $sql_rsqty);
            while ($row_rsqty = mysqli_fetch_array($result_rsqty)) {
                $mqty = $mqty + $row_rsqty["QTY"];
            }


            $sql_tmpinst = " insert into tmp_credit_note_form (crn_form_no, Inv_date, inv_no, Amount, disc, Qty,  Brands, tmp_no) values ('" . $_GET["txtrefno"] . "', '" . $row_rssalma['SDATE'] . "', '" . $_GET["invno"] . "', " . $row_rssalma['GRAND_TOT'] . ", " . $row_sinvo['DIS_per'] . ", " . $mqty . ", '" . $row_rssalma['Brand'] . "' , '" . $_SESSION["credit_note_form"] . "')";
            //echo $sql_tmpinst;
            $result_tmpinst = mysqli_query($GLOBALS['dbinv'], $sql_tmpinst);
        }

        $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Amount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Dis 2</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount (%)</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount Val</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Brand</font></td>
                             
                            </tr>";

        $Incen_val_val = 0;

        $sql = "Select * from tmp_credit_note_form where tmp_no = '" . $_SESSION["credit_note_form"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {

            $Inv_date = "Inv_date" . $i;
            $inv_no = "inv_no" . $i;
            $Amount = "Amount" . $i;
            $disc = "disc" . $i;
            $disc_i = "disc_i" . $i;
            $Qty = "Qty" . $i;
            $Incen_per = "Incen_per" . $i;
            $Incen_val = "Incen_val" . $i;
            $Brands = "Brands" . $i;

            $ResponseXML .= "<tr>
                        
							 <td ><input type=\"text\" size=\"10\" name=" . $Inv_date . "  disabled id=" . $Inv_date . " value='" . $row['Inv_date'] . "' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"30\" name=" . $inv_no . "  disabled id=" . $inv_no . " value='" . $row["inv_no"] . "' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $Amount . "  disabled id=" . $Amount . " value=" . $row['Amount'] . " class=\"txtbox\"/></td>
							 
							 <td ><input type=\"text\" size=\"10\" name=" . $disc . "  disabled id=" . $disc . " value=" . $row['disc'] . " class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $disc_i . "  id=" . $disc_i . " value=" . $row['disc1'] . " class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $Qty . "  disabled id=" . $Qty . " value=" . $row['Qty'] . " class=\"txtbox\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=" . $Incen_per . "  onBlur=\"cal_incentive('" . $i . "')\" id=" . $Incen_per . " value='" . $row['Incen_per'] . "' class=\"txtbox\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=" . $Incen_val . "  id=" . $Incen_val . " value='" . $row['Incen_val'] . "' onBlur=\"cal_incentive_val('" . $i . "')\" class=\"txtbox\"/></td>
            	            	
            	<td ><input type=\"text\" size=\"10\" name=" . $Brands . "  disabled id=" . $Brands . " value=" . $row['Brands'] . " class=\"txtbox\"/></td>
				
				<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row["inv_no"] . "  name=" . $row["inv_no"] . " onClick=\"del_item('" . $row["inv_no"] . "');\"></td></tr>";

            if ((is_null($row['Incen_val']) == false) and ($row['Incen_val'] != "")) {
                $Incen_val_val = $Incen_val_val + $row['Incen_val'];
            }
            $i = $i + 1;
        }

        $ResponseXML .= "   </table>]]></sales_table>";
        $ResponseXML .= "<Incen_val><![CDATA[" . $Incen_val_val . "]]></Incen_val>";
        $ResponseXML .= "<mcou><![CDATA[" . $i . "]]></mcou>";
        $ResponseXML .= "<msg><![CDATA[]]></msg>";
    }


    //Loop
    //txttot = Format(tot, "######.00")		


    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "invno_check") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $sql_tmpinst = " delete from tmp_credit_note_form where crn_form_no='" . $_GET["txtrefno"] . "' and inv_no='" . $_GET["invno"] . "'";
    $result_tmpinst = mysqli_query($GLOBALS['dbinv'], $sql_tmpinst);

    $ResponseXML = "<salesdetails>";
    $_SESSION["CURRENT_DOC"] = "20";     //document ID
    //VIEW_DOC = True      '  view current document
    $_SESSION["PRICE_EDIT"] = "true";      //   save  current document
    //MOD_DOC = True       '   delete   current document
    //PRINT_DOC = True     ' get additional print   of  current document
    //PRICE_EDIT=true      ' edit selling price
    $_SESSION["CHECK_USER"] = "true";    // check user permission again


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
        }
        $sql2 = " Select * from vendor where CODE = '" . $row_rscrn["Code"] . "'";
        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
        $row2 = mysqli_fetch_array($result2);
        if (is_null($row2["NAME"]) == false) {
            $ResponseXML .= "<txt_cusname><![CDATA[" . $row2["NAME"] . "]]></txt_cusname>";
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
                $ResponseXML .= "<Com_rep><![CDATA[" . $row1["REPCODE"] . "]]></Com_rep>";
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


        $sql = "delete from tmp_credit_note_form where tmp_no = '" . $_SESSION["credit_note_form"] . "'";
        //echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);



        $sql_rscrntrn = "Select * from s_crnfrmtrn where Refno = '" . $_GET["invno"] . "'";
        $result_rscrntrn = mysqli_query($GLOBALS['dbinv'], $sql_rscrntrn);
        while ($row_rscrntrn = mysqli_fetch_array($result_rscrntrn)) {

            if ((is_null($row_rscrntrn['disc']) == false) and ($row_rscrntrn['disc'] != "")) {
                $disc = $row_rscrntrn['disc'];
            } else {
                $disc = 0;
            }

            $sql_tmpinst = " insert into tmp_credit_note_form (crn_form_no, Inv_date, inv_no, Amount, disc, Qty, Incen_per, Incen_val, Brands, tmp_no,disc1) values ('" . $_GET["invno"] . "', '" . $row_rscrntrn['Inv_date'] . "', '" . $row_rscrntrn["Inv_no"] . "', '" . $row_rscrntrn['Amount'] . "', " . $disc . ", " . $row_rscrntrn["Qty"] . ", " . $row_rscrntrn["Incen_per"] . ", " . $row_rscrntrn["Incen_val"] . ", '" . $row_rscrntrn['Brand'] . "', '" . $_SESSION["credit_note_form"] . "','" . $row_rscrntrn["disc1"] . "')";
            //echo $sql_tmpinst;
            $result_tmpinst = mysqli_query($GLOBALS['dbinv'], $sql_tmpinst);
        }

        $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Amount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Dis 2</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount (%)</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount Val</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Brand</font></td>
                             
                            </tr>";

        $Incen_val_val = 0;



        $sql = "Select * from tmp_credit_note_form where tmp_no = '" . $_SESSION["credit_note_form"] . "'";
        //echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {

            $Inv_date = "Inv_date" . $i;
            $inv_no = "inv_no" . $i;
            $Amount = "Amount" . $i;
            $disc = "disc" . $i;
            $disc_i = "disc_i" . $i;
            $Qty = "Qty" . $i;
            $Incen_per = "Incen_per" . $i;
            $Incen_val = "Incen_val" . $i;
            $Brands = "Brands" . $i;

            $ResponseXML .= "<tr>
                        
				 <td><input type=\"text\" size=\"10\" name=" . $Inv_date . "  disabled id=" . $Inv_date . " value='" . $row['Inv_date'] . "' class=\"txtbox\"/></td>
				 <td><input type=\"text\" size=\"30\" name=" . $inv_no . "  disabled id=" . $inv_no . " value='" . $row["inv_no"] . "' class=\"txtbox\"/></td>
				 <td><input type=\"text\" size=\"10\" name=" . $Amount . "  disabled id=" . $Amount . " value=" . $row['Amount'] . " class=\"txtbox\"/></td>
							 
				 <td><input type=\"text\" size=\"10\" name=" . $disc . "  disabled id=" . $disc . " value=" . $row['disc'] . " class=\"txtbox\"/></td>
				 <td><input type=\"text\" size=\"10\" name=" . $disc_i . "  disabled id=" . $disc_i . " value=" . $row['disc1'] . " class=\"txtbox\"/></td>
				 <td><input type=\"text\" size=\"10\" name=" . $Qty . "  disabled id=" . $Qty . " value=" . $row['Qty'] . " class=\"txtbox\"/></td>
				
				<td><input type=\"text\" size=\"10\" name=" . $Incen_per . "  onBlur=\"cal_incentive('" . $i . "')\" id=" . $Incen_per . " value='" . $row['Incen_per'] . "' class=\"txtbox\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=" . $Incen_val . "   id=" . $Incen_val . " value='" . $row['Incen_val'] . "' class=\"txtbox\"/></td>
            	            	
            	<td ><input type=\"text\" size=\"10\" name=" . $Brands . "  disabled id=" . $Brands . " value=" . $row['Brands'] . " class=\"txtbox\"/></td>
				
				<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row["inv_no"] . "  name=" . $row["inv_no"] . " onClick=\"del_item('" . $row["inv_no"] . "');\"></td></tr>";

            if ((is_null($row['Incen_val']) == false) and ($row['Incen_val'] != "")) {
                $Incen_val_val = $Incen_val_val + $row['Incen_val'];
            }
            $i = $i + 1;
        }

        $ResponseXML .= "   </table>]]></sales_table>";
        $ResponseXML .= "<Incen_val><![CDATA[" . $Incen_val_val . "]]></Incen_val>";
        $ResponseXML .= "<mcou><![CDATA[" . $i . "]]></mcou>";
        $ResponseXML .= "<msg><![CDATA[]]></msg>";
    }


    //Loop
    //txttot = Format(tot, "######.00")		


    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}



if ($_GET["Command"] == "invno_check_crn") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";


    $ResponseXML = "<salesdetails>";

    $sql_rscrn = " Select * from s_crnfrmtrn where Refno = '" . $_GET["invno"] . "' ";
    $result_rscrn = mysqli_query($GLOBALS['dbinv'], $sql_rscrn);
    $row_rscrn = mysqli_fetch_array($result_rscrn);
    $ResponseXML .= "<txt_invno><![CDATA[" . $row_rscrn["Inv_no"] . "]]></txt_invno>";
    //$ResponseXML .= "<txt_invno><![CDATA[".$row_rscrn["Inv_no"]."]]></txt_invno>";	


    $sql_stsql = "SELECT * FROM s_salma where REF_NO='" . trim($row_rscrn["Inv_no"]) . "' ";
    //echo $sql_stsql;
    $result_stsql = mysqli_query($GLOBALS['dbinv'], $sql_stsql);
    if ($row_rssalma = mysqli_fetch_array($result_stsql)) {
        $ResponseXML .= "<txt_cuscode><![CDATA[" . $row_rssalma["C_CODE"] . "]]></txt_cuscode>";
        $ResponseXML .= "<txt_cusname><![CDATA[" . $row_rssalma["CUS_NAME"] . "]]></txt_cusname>";
        $ResponseXML .= "<txt_net><![CDATA[" . $row_rssalma["GRAND_TOT"] . "]]></txt_net>";
        $ResponseXML .= "<txt_totpay><![CDATA[" . $row_rssalma["TOTPAY"] . "]]></txt_totpay>";

        $txtbal = $row_rssalma["GRAND_TOT"] - $row_rssalma["TOTPAY"];
        $ResponseXML .= "<txtbal><![CDATA[" . $txtbal . "]]></txtbal>";
        $ResponseXML .= "<txtinvdate><![CDATA[" . $row_rssalma["SDATE"] . "]]></txtinvdate>";
        $ResponseXML .= "<txtdiv><![CDATA[" . $row_rssalma["DEV"] . "]]></txtdiv>";
        $ResponseXML .= "<cmbbrand><![CDATA[" . $row_rssalma["Brand"] . "]]></cmbbrand>";
        $ResponseXML .= "<com_dep><![CDATA[" . $row_rssalma["DEPARTMENT"] . "]]></com_dep>";
        $ResponseXML .= "<Com_rep><![CDATA[" . $row_rssalma["SAL_EX"] . "]]></Com_rep>";
        $ResponseXML .= "<cmbbrand><![CDATA[" . $row_rssalma["Brand"] . "]]></cmbbrand>";

        $ResponseXML .= "<c_subcode><![CDATA[" . $row_rssalma["C_CODE"] . "]]></c_subcode>";
    }

    $sql_crnfrm = " Select * from s_crnfrm where Refno = '" . $_GET["invno"] . "' ";
    $result_crnfrm = mysqli_query($GLOBALS['dbinv'], $sql_crnfrm);
    $row_crnfrm = mysqli_fetch_array($result_crnfrm);
    $ResponseXML .= "<Remark><![CDATA[" . $row_crnfrm["Remark"] . "]]></Remark>";




    if ($row_rscrn["Flag"] == "CCRN") {
        $ResponseXML .= "<chkcashdis><![CDATA[1]]></chkcashdis>";
    } else {
        $ResponseXML .= "<chkcashdis><![CDATA[0]]></chkcashdis>";
    }

    $ResponseXML .= "<txt_remark><![CDATA[" . $_GET["invno"] . "]]></txt_remark>";
    $ResponseXML .= "<txtamount><![CDATA[" . $_GET["amt"] . "]]></txtamount>";
    $ResponseXML .= "<txt_frmno><![CDATA[" . $_GET["invno"] . "]]></txt_frmno>";

    /* 	rscrntrn.Open " Select * from s_crnfrmtrn where refno = '" & Trim(fI_MEMver.txtcus_code) & "' order by ID", DNinv.Coninv
      txt_invno = rscrntrn!Inv_no
      Call VIEWinvoice
      txt_frmno = fI_MEMver.txtcus_code
      txtamount = Format(fI_MEMver.txtcrnamount, "######.00")
      txt_remark = fI_MEMver.txt_cus_name
      If Trim(rscrntrn!flag) = "CCRN" Then chkcashdis.Value = 1 */





    //Loop
    //txttot = Format(tot, "######.00")		


    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}



if ($_GET["Command"] == "save_incent") {





    $sql_tmpinst = " update tmp_credit_note_form set Incen_per=" . $_GET["Incen_per"] . ", Incen_val=" . $_GET["Incen_val"] . " where crn_form_no='" . $_GET["txtrefno"] . "' and inv_no='" . $_GET["inv_no"] . "'";
    echo $sql_tmpinst;
    $result_tmpinst = mysqli_query($GLOBALS['dbinv'], $sql_tmpinst);
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
                             <td bgcolor=\"#222222\" >" . $row['str_code'] . "</a></td>
							 <td bgcolor=\"#222222\" >" . $row['str_description'] . "</a></td>
							 <td bgcolor=\"#222222\" >" . $row['partno'] . "</a></td>
							 <td bgcolor=\"#222222\" >" . number_format($row['qty'], 2, ".", ",") . "</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td></tr>";
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
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Order Qty</font></td>
                              <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">FOB</font></td>
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
        $ord_qty = "ord_qty" . $i;
        $fob = "fob" . $i;
        $qty = "qty" . $i;
        $cost = "cost" . $i;
        $selling = "selling" . $i;
        $margin = "margin" . $i;
        $subtotal = "subtotal" . $i;

        $ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $itemcode . " id=" . $itemcode . "   value=" . $row['STK_NO'] . " class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $itemname . " id=" . $itemname . "  value='" . $row['DESCRIPT'] . "' class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $ord_qty . " id=" . $ord_qty . "  value=" . $row['ORD_QTY'] . " class=\"txtbox\"/></td>
							
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $fob . " id=" . $fob . "  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $qty . " id=" . $qty . "  class=\"txtbox\" onBlur=\"cal_subtot('" . $i . "', '" . $mcou . "');\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $cost . " id=" . $cost . "  class=\"txtbox\" onBlur=\"cal_subtot('" . $i . "', '" . $mcou . "');\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $selling . " id=" . $selling . "  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $margin . " id=" . $margin . "  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $subtotal . " id=" . $subtotal . "  class=\"txtbox\"/></td>
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

    echo "   <table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Amount</font></td>
                              <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Balance</font></td>
   </tr>";


    if ($_SESSION["MonthView1"] != "") {


        $year = substr($_SESSION["MonthView1"], 0, 4);
        $month = substr($_SESSION["MonthView1"], 5, 2);

        $sql = "select REF_NO , SDATE, GRAND_TOT, TOTPAY  from s_salma where Accname='OFFICE' and CANCELL='0'and C_CODE='" . $_SESSION["crn_form_supplierno"] . "' and year(SDATE)='" . $year . "' and month(SDATE)='" . $month . "' and Brand='" . $_GET["brand"] . "'   ORDER BY SDATE desc limit 50";


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


if ($_GET["Command"] == "del_item") {


    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $sql_tmpinst = " delete from tmp_credit_note_form where crn_form_no='" . $_GET["txtrefno"] . "' and inv_no='" . $_GET["code"] . "'";
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
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount (%)</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount Val</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Brand</font></td>
                             
                            </tr>";

    $Incen_val_val = 0;

    $sql = "Select * from tmp_credit_note_form where crn_form_no = '" . $_GET["txtrefno"] . "'";
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
                        
							 <td ><input type=\"text\" size=\"10\" name=" . $Inv_date . "  disabled id=" . $Inv_date . " value='" . $row['Inv_date'] . "' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"30\" name=" . $inv_no . "  disabled id=" . $inv_no . " value='" . $row["inv_no"] . "' class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $Amount . "  disabled id=" . $Amount . " value=" . $row['Amount'] . " class=\"txtbox\"/></td>
							 
							 <td ><input type=\"text\" size=\"10\" name=" . $disc . "  disabled id=" . $disc . " value=" . $row['disc'] . " class=\"txtbox\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $Qty . "  disabled id=" . $Qty . " value=" . $row['Qty'] . " class=\"txtbox\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=" . $Incen_per . "  onBlur=\"cal_incentive('" . $i . "')\" id=" . $Incen_per . " value='" . $row['Incen_per'] . "' class=\"txtbox\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=" . $Incen_val . "   id=" . $Incen_val . " value='" . $row['Incen_val'] . "' class=\"txtbox\"/></td>
            	            	
            	<td ><input type=\"text\" size=\"10\" name=" . $Brands . "  disabled id=" . $Brands . " value=" . $row['Brands'] . " class=\"txtbox\"/></td>
				
				<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row["inv_no"] . "  name=" . $row["inv_no"] . " onClick=\"del_item('" . $row["inv_no"] . "');\"></td></tr>";

        if ((is_null($row['Incen_val']) == false) and ($row['Incen_val'] != "")) {
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

    $vatrate = 12;
    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    if (($_GET["txt_cuscode"] != "") and ($_GET["mcou"] > 0)) {

        $sql = "Select * from s_salma where REF_NO='" . $_GET["inv_no1"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $com_rep = $row["SAL_EX"];


        $sql = "Select crnfrmno from invpara";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $tmpinvno = "000000" . $row["crnfrmno"];
        $lenth = strlen($tmpinvno);
        //$invno=trim("CFRM/".$_SESSION['company']."/ ").substr($tmpinvno, $lenth-7);
        $invno = trim("CFRM/" . $com_rep . "/ ") . substr($tmpinvno, $lenth - 7);
        $_SESSION["invno"] = $invno;



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

            $sql1 = "Delete from s_crnfrm where Refno = '" . $mrefno . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);


            $i = 1;
            $mamount = 0;
            while ($_GET["mcou"] > $i) {

                $Inv_date = "Inv_date" . $i;
                $inv_no = "inv_no" . $i;
                $Amount = "Amount" . $i;
                $disc = "disc" . $i;
                $disc_i = "disc_i" . $i;
                $Qty = "Qty" . $i;
                $Incen_per = "Incen_per" . $i;
                $Incen_val = "Incen_val" . $i;
                $Brands = "Brands" . $i;

                $sql1 = "Insert into s_crnfrmtrn (Sdate, Refno, Code, Name, Sal_ex, Mon, Inv_no, Inv_date, Amount, Qty, Incen_per, Incen_val, Brand, Flag,disc,disc1) values('" . $_GET["DTPicker1"] . "', '" . $mrefno . "','" . trim($_GET["txt_cuscode"]) . "', '" . trim($_GET["txt_cusname"]) . "', '" . $_GET["Com_rep"] . "', '" . $_GET["MonthView1"] . "','" . trim($_GET[$inv_no]) . "', '" . $_GET[$Inv_date] . "', '" . $_GET[$Amount] . "', '" . $_GET[$Qty] . "', '" . $_GET[$Incen_per] . "', '" . $_GET[$Incen_val] . "','" . $_GET[$Brands] . "','ACRN','" . $_GET[$disc] . "','" . $_GET[$disc_i] . "')";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                echo $sql1;

                $mamount = $mamount + $_GET[$Incen_val];
                $i = $i + 1;
            }

            $sql1 = "insert into s_crnfrm (Refno, Sdate, Code, Mon, Amount, Remark, Sal_ex, Flag, Checked, Lock1, Cancell, Credit_note) Values('" . $mrefno . "','" . $_GET["DTPicker1"] . "', '" . trim($_GET["txt_cuscode"]) . "', '" . $_GET["MonthView1"] . "', '" . $mamount . "','" . trim($_GET["txtremark"]) . "','" . $_GET["Com_rep"] . "','ACRN', 'A', '0', '0', 'A')";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);


            $sql1 = "Update invpara set crnfrmno = crnfrmno+1";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

            $sqlbrand = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($mrefno) . "', '" . $_SESSION["CURRENT_USER"] . "', 'Credit Note Form', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $resultbrand = mysqli_query($GLOBALS['dbinv'], $sqlbrand);
//            $resultbrand = $conn->query($sqlbrand);

            echo "Saved";
        } else {
            $i = 1;
            $mamount = 0;
            while ($_GET["mcou"] > $i) {

                $Inv_date = "Inv_date" . $i;
                $inv_no = "inv_no" . $i;
                $Amount = "Amount" . $i;
                $disc = "disc" . $i;
                $Qty = "Qty" . $i;
                $Incen_per = "Incen_per" . $i;
                $Incen_val = "Incen_val" . $i;
                $Brands = "Brands" . $i;
                $disc_i = "disc_i" . $i;
                $sql1 = "Insert into s_crnfrmtrn (Sdate, Refno, Code, Name, Sal_ex, Mon, Inv_no, Inv_date, Amount, Qty, Incen_per, Incen_val, Brand, Flag,disc,disc1) values('" . $_GET["DTPicker1"] . "','" . $mrefno . "','" . trim($_GET["txt_cuscode"]) . "','" . trim($_GET["txt_cuscode"]) . "','" . $_GET["Com_rep"] . "', '" . $_GET["MonthView1"] . "','" . trim($_GET[$inv_no]) . "','" . $_GET[$Inv_date] . "','" . $_GET[$Amount] . "', '" . $_GET[$Qty] . "', '" . $_GET[$Incen_per] . "', '" . $_GET[$Incen_val] . "','" . $_GET[$Brands] . "','ACRN','" . $_GET[$disc] . "','" . $_GET[$disc_i] . "')";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

                $mamount = $mamount + $_GET[$Incen_val];
                $i = $i + 1;
            }

            $sql1 = "insert into s_crnfrm (Refno,sdate,code,mon,Amount,Remark,sal_ex,flag, Checked, Lock1, Cancell, Credit_note) Values('" . $mrefno . "','" . $_GET["DTPicker1"] . "', '" . trim($_GET["txt_cuscode"]) . "','" . $_GET["MonthView1"] . "', '" . $mamount . "','" . trim($_GET["txtremark"]) . "','" . $_GET["Com_rep"] . "','ACRN', 'A', '0', '0', 'A')";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);



            $sql1 = "Update invpara set crnfrmno = crnfrmno+1";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            echo "Saved";
        }
    }
}


if ($_GET["Command"] == "pass_arnno") {
    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";
    $sql = "Select * from s_purmas where REFNO='" . $_GET['arnno'] . "'";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
    if ($row = mysqli_fetch_array($result)) {
        $ResponseXML .= "<REFNO><![CDATA[" . $row["REFNO"] . "]]></REFNO>";
        $ResponseXML .= "<SDATE><![CDATA[" . $row["SDATE"] . "]]></SDATE>";
        $ResponseXML .= "<ORDNO><![CDATA[" . $row["ORDNO"] . "]]></ORDNO>";
        $ResponseXML .= "<LCNO><![CDATA[" . $row["LCNO"] . "]]></LCNO>";
        $ResponseXML .= "<COUNTRY><![CDATA[" . $row["COUNTRY"] . "]]></COUNTRY>";
        $ResponseXML .= "<SUP_CODE><![CDATA[" . $row["SUP_CODE"] . "]]></SUP_CODE>";
        $ResponseXML .= "<SUP_NAME><![CDATA[" . $row["SUP_NAME"] . "]]></SUP_NAME>";
        $ResponseXML .= "<REMARK><![CDATA[" . $row["REMARK"] . "]]></REMARK>";
        $ResponseXML .= "<DEPARTMENT><![CDATA[" . $row["DEPARTMENT"] . "]]></DEPARTMENT>";
        $ResponseXML .= "<AMOUNT><![CDATA[" . $row["AMOUNT"] . "]]></AMOUNT>";
        $ResponseXML .= "<PUR_DATE><![CDATA[" . $row["PUR_DATE"] . "]]></PUR_DATE>";
        $ResponseXML .= "<brand><![CDATA[" . $row["brand"] . "]]></brand>";
        $ResponseXML .= "<TYPE><![CDATA[" . $row["TYPE"] . "]]></TYPE>";

        $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"200\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"800\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Unit</font></td>
                              <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Pre. Ret. Qty</font></td>
							  <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Price</font></td>
							   <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Ret Qty</font></td>
							    <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Value</font></td>
							
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
            $unit = "unit" . $i;
            $qty = "qty" . $i;
            $preretqty = "preretqty" . $i;
            $price = "price" . $i;
            $retqty = "retqty" . $i;
            $value = "value" . $i;


            if (($row['ret_qty'] == "") or ($row['ret_qty'] == 0) or is_null($row['ret_qty'])) {
                $val_ret_qty = 0;
            } else {
                $val_ret_qty = $row['ret_qty'];
            }

            $ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $itemcode . " id=" . $itemcode . "   value='" . $row['STK_NO'] . "' class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $itemname . " id=" . $itemname . "  value='" . $row['DESCRIPT'] . "' class=\"txtbox\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $unit . " id=" . $unit . "  value='' class=\"txtbox\"/></td>
							
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $qty . " id=" . $qty . " value='" . $row['REC_QTY'] . "'  class=\"txtbox\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $preretqty . " id=" . $preretqty . " value='" . $val_ret_qty . "'  class=\"txtbox\" /></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $price . " id=" . $price . " value='" . $row['SELLING'] . "'  class=\"txtbox\" /></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $retqty . " id=" . $retqty . " value=''  class=\"txtbox\" onBlur=\"cal_subtot('" . $i . "', '" . $mcou . "');\" /></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=" . $value . " id=" . $value . " value=''  class=\"txtbox\"/></td>
							
							</tr>";
            $tot = $tot + ($row['COST'] * $row['REC_QTY']);
            $i = $i + 1;
        }

        $ResponseXML .= "</table>]]></sales_table>";
        $ResponseXML .= "<tot><![CDATA[" . $tot . "]]></tot>";
        $ResponseXML .= "<count><![CDATA[" . $i . "]]></count>";
    }



    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "cancel_inv") {
    if (($_GET["txt_cuscode"] != "") and ($_GET["mcou"] > 0)) {
        $mrefno = trim($_GET["txtrefno"]);
        $sql_rscrnfrm = "Select * from s_crnfrmtrn where Refno = '" . $mrefno . "'";
        $result_rscrnfrm = mysqli_query($GLOBALS['dbinv'], $sql_rscrnfrm);

        $sql_rscrn = " Select * from s_crnfrm where Refno = '" . $mrefno . "'";
        $result_rscrn = mysqli_query($GLOBALS['dbinv'], $sql_rscrn);
        if ($row_rscrnfrm = mysqli_fetch_array($result_rscrnfrm)) {

            $row_rscrn = mysqli_fetch_array($result_rscrn);

            if ($row_rscrn["Lock1"] == "1") {
                exit("Sorry this credit note cannot Cancel");
            }
            $sql1 = "Update s_crnfrm set Cancell = '1' where Refno = '" . $mrefno . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

            $sql1 = "Delete from s_crnfrmtrn where Refno = '" . $mrefno . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

            echo "Cancelled";
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
<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once ("connectioni.php");

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if (isset($_GET["Command"])) {
    if ($_GET["Command"] == "get_bank") {
        $sql = "select * from bankmas where bcode='" . $_GET["bankcode"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row = mysqli_fetch_array($result)) {
            echo $row["bname"];
        }
    }

    if ($_GET["Command"] == "pass_cus_cash_rec") {
        include_once ("connectioni.php");

        header('Content-Type: text/xml');
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

        $ResponseXML = "";
        $ResponseXML .= "<salesdetails>";
 
        $sql = mysqli_query($GLOBALS['dbinv'], "Select * from vendor where CODE='" . $_GET['custno'] . "'") or die(mysqli_error());
        if ($row = mysqli_fetch_array($sql)) {
            $ResponseXML .= "<code><![CDATA[" . $row['CODE'] . "]]></code>";
            $ResponseXML .= "<name><![CDATA[" . $row['NAME'] . "]]></name>"; 
        }

        $ResponseXML .= "<sales_table_acc><![CDATA[ <table class=\"table\">
								<tr class=\"info\"><td width=\"80\" ></font></td>
								<td width=\"80\"   >Date</font></td>
								<td width=\"100\" >Invoice No</font></td>
								<td width=\"80\" >Value</font></td>
								<td width=\"80\" >Paid</font></td>
								<td width=\"80\" >Overdue</font></td>
								<td width=\"80\" >Chq Pay</font></td>
								<td width=\"80\" >Chq Balance</font></td>
								<td width=\"80\" >Cash Pay</font></td>
								<td width=\"80\" >Inv Balance</font></td></tr>";

        //$sql = mysqli_query($GLOBALS['dbinv'],"Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and DEV='" & rsusercon!dev & "' and CANCELL='0' and SAL_EX='" & Trim(Left(Com_rep, 5)) & "' and Accname <> 'NON STOCK' ORDER BY SDATE") or die(mysqli_error());
        //	echo "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and CANCELL='0' and SAL_EX='".$_GET["refno"]."' and Accname <> 'NON STOCK' ORDER BY SDATE";

        $i = 1;
        // 	echo "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='".$_GET['custno']."' and GRAND_TOT > TOTPAY and CANCELL='0'  ORDER BY SDATE";

        // if ($_GET['refno'] == "") {
            $sql = mysqli_query($GLOBALS['dbinv'], "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='" . $_GET['custno'] . "' and GRAND_TOT > TOTPAY and (GRAND_TOT-TOTPAY)>0.5 and CANCELL='0'   ORDER BY SDATE") or die(mysqli_error());
        // } else {

        //     $sql = mysqli_query($GLOBALS['dbinv'], "Select C_CODE, REF_NO, deli_date, GRAND_TOT, TOTPAY, SDATE from s_salma where C_CODE='" . $_GET['custno'] . "' and GRAND_TOT > TOTPAY and (GRAND_TOT-TOTPAY)>0.5 and CANCELL='0' and SAL_EX='" . $_GET['refno'] . "'    ORDER BY SDATE") or die(mysqli_error());
        // } 
        while ($row = mysqli_fetch_array($sql)) {

            $sdate = "sdate" . $i;
            $delidate = "delidate" . $i;

            $invval = "invval" . $i;

            if (is_null($row["deli_date"] == false)) {
                $ResponseXML .= "<tr><td><div id=" . $delidate . ">" . $row["deli_date"] . "</div></td>";
            } else {
                $ResponseXML .= "<tr><td><div id=" . $delidate . ">" . $row["SDATE"] . "</div></td>";
            }

            $ResponseXML .= "<td><div id=" . $sdate . ">" . $row["SDATE"] . "</div></td>";

            $j = $i + 1;

            $overdue = "overdue" . $i;

            $chq_pay = "chq_pay" . $i;
            $chq_pay_next = "chq_pay" . $j;

            $chq_balance = "chq_balance" . $i;
            $chq_balance_next = "chq_balance" . $j;

            $cash_pay = "cash_pay" . $i;
            $cash_pay_next = "cash_pay" . $j;

            $inv_balance = "inv_balance" . $i;
            $overdueamt = $row["GRAND_TOT"] - $row["TOTPAY"];
            //number_format($row["GRAND_TOT"]-$row["TOTPAY"], 2, ".")

            $invno = "invno" . $i;

            $ResponseXML .= "<td><div id=" . $invno . ">" . $row["REF_NO"] . "</div></td>
									 <td><div id=" . $invval . " align=\"left\">" . number_format($row["GRAND_TOT"], 2, ".", ",") . "</div></td>
									 <td ><div align=\"left\">" . number_format($row["TOTPAY"], 2, ".", ",") . "</div></td>
									 <td><input type=\"number\"  class=\"form-control   input-sm\" name=" . $overdue . " id=" . $overdue . " value=" . $overdueamt . " size=\"10\" disabled align=\"right\" /></td>
									 <td><input type=\"number\"  class=\"form-control   input-sm\" name=" . $chq_pay . " id=" . $chq_pay . " onBlur=\"calc_bal('$overdue', '$chq_pay', '$inv_balance', '$chq_balance', '$chq_balance_next', '$cash_pay', '$i', event);\"  onKeyPress=\"keyset('$chq_pay_next', event);\"   size=\"10\" align=\"right\"/></td>									
									 <td><input type=\"number\"  class=\"form-control   input-sm\" name=" . $chq_balance . " disabled id=" . $chq_balance . " onKeyPress=\"keysetvalue('$chq_balance','$chq_balance_next', '$chq_pay', event);\" size=\"10\" align=\"right\"  /></td>
									 <td><input type=\"number\"  class=\"form-control   input-sm\" name=" . $cash_pay . " id=" . $cash_pay . " onBlur=\"calc_bal_cash('$overdue', '$cash_pay_next', '$chq_pay', '$inv_balance', '$cash_pay', event);\" onKeyPress=\"keyset('$cash_pay_next', event);\" size=\"10\" align=\"right\"/></td>
									 <td><input type=\"number\"  class=\"form-control   input-sm\" name=" . $inv_balance . " id=" . $inv_balance . " disabled size=\"10\" align=\"right\"/></td></tr>";
            $i = $i + 1;
        }

        $overdue = "overdue" . $i;

        $chq_pay = "chq_pay" . $i;
        $chq_pay_next = "chq_pay" . $j;

        $chq_balance = "chq_balance" . $i;
        $chq_balance_next = "chq_balance" . $j;

        $cash_pay = "cash_pay" . $i;
        $cash_pay_next = "cash_pay" . $j;

        $inv_balance = "inv_balance" . $i;
        $overdueamt = $row["GRAND_TOT"] - $row["TOTPAY"];
        $invno = "invno" . $i;
        $ResponseXML .= "<tr><td><td></td>
									 <td></td><div id=" . $invno . "></div></td>
									 <td></td>
									 <td></td>
									 <td><input type=\"text\" disabled class=\"form-control   input-sm\" name=" . $overdue . " id=" . $overdue . " value=" . $overdueamt . " size=\"10\"/></td>
									 <td><input type=\"text\" disabled class=\"form-control   input-sm\" name=" . $chq_pay . " id=" . $chq_pay . " onBlur=\"calc_bal('$overdue', '$chq_pay', '$inv_balance', '$chq_balance', '$chq_balance_next', '$cash_pay', '$i', event);\"  onKeyPress=\"keyset('$chq_pay_next', event);\"   size=\"10\"/></td>									
									 <td><input type=\"text\" disabled class=\"form-control   input-sm\" name=" . $chq_balance . " id=" . $chq_balance . " onKeyPress=\"keysetvalue('$chq_balance','$chq_balance_next', '$chq_pay', event);\" size=\"10\"/></td>
									 <td><input type=\"text\" disabled class=\"form-control   input-sm\" name=" . $cash_pay . " id=" . $cash_pay . " onKeyPress=\"calc_bal_cash('$overdue', '$cash_pay_next', '$chq_pay', '$inv_balance', '$cash_pay', event);\" size=\"10\"/></td>
									 <td><input type=\"text\" disabled class=\"form-control   input-sm\" name=" . $inv_balance . " id=" . $inv_balance . " disabled size=\"10\"/></td></tr>";

        $_SESSION["count"] = $i;
        $ResponseXML .= "   </table>]]></sales_table_acc>";
        $ResponseXML .= "<mcount><![CDATA[" . $_SESSION["count"] . "]]></mcount>";
        $ResponseXML .= "</salesdetails>";
        echo $ResponseXML;
    }

    if ($_GET["Command"] == "chng_chqno") {
        $sql = "update tmp_cash_chq set chqno='" . $_GET["chqno"] . "' where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "' and tmp_count=" . $_GET["i"];
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
    }

    if ($_GET["Command"] == "chng_chqdate") {
        $sql = "update tmp_cash_chq set chqdate='" . $_GET["chqdate"] . "' where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "' and tmp_count=" . $_GET["i"];
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
    }

    if ($_GET["Command"] == "chng_bank") {
        $sql = "update tmp_cash_chq set chqbank='" . $_GET["bank"] . "' where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "' and tmp_count=" . $_GET["i"];
        //echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
    }

    if ($_GET["Command"] == "chng_chqamt") {
        $chqamt = str_replace(",", "", $_GET["chqamt"]);

        $sql = "update tmp_cash_chq set chqamt='" . $chqamt . "' where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "' and tmp_count=" . $_GET["i"];
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $sql = "select sum(chqamt) as totamt from tmp_cash_chq where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        echo $row["totamt"];
    }

    if ($_GET["Command"] == "addchq_cash_rec") {

        //echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec

        if ($_SESSION["tmp_no_cashrec"] != "") {
            if (date("Y-m-d", strtotime($_GET["chqdate"])) <= date("Y-m-d", strtotime($_GET["invdate"]))) {
                //$chqdate = DateAdd("d", 1, Date)
                $date = $_GET["invdate"];
                $date1 = date('Y-m-d', strtotime($date . ' + 1 days'));
            } else {
                $date1 = $_GET["chqdate"];
            }

            $sql = "delete from tmp_cash_chq where chqno='" . $_GET["chqno"] . "' and tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);

            $sql = "select max(tmp_count) as max_num from tmp_cash_chq where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
            //echo $sql;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                if ((is_null($row["max_num"]) == false) and ($row["max_num"] != "")) {
                    $i = $row["max_num"] + 1;
                } else {
                    $i = 1;
                }
            }
            $chqamtval = str_replace(",", "", $_GET["chqamt"]);

            $sql = "insert into tmp_cash_chq(recno, chqno, chqdate, chqbank, chqamt, tmp_no, tmp_count) values ('" . $_GET["invno"] . "', '" . $_GET["chqno"] . "', '" . $date1 . "', '" . $_GET["bank"] . "', '" . $chqamtval . "', '" . $_SESSION["tmp_no_cashrec"] . "', " . $i . ")";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);

            $totchq = 0;
            $ResponseXML = "";
            $ResponseXML .= "<salesdetails>";

            $ResponseXML .= "<chq_table><![CDATA[ <table class=\"table\"><tr height=\"25\">
					<td width=\"200\"  background=\"\">Cheque No</td>
					<td width=\"100\"  background=\"\">Cheque Date</td>
					<td width=\"230\"  background=\"\">Bank</td>
					<td width=\"140\"  background=\"\">Amount</td>
					</tr>";

            $sql = "select * from tmp_cash_chq where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "' order by tmp_count";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {
                $chqno = "chqno" . $row["tmp_count"];
                $chqdate = "chqdate" . $row["tmp_count"];
                $bank = "bank" . $row["tmp_count"];
                $chqamt = "chqamt" . $row["tmp_count"];

                $ResponseXML .= "<tr>
					<td><input type=\"text\"  class=\"text_purchase3\" name=\"" . $chqno . "\" id=\"" . $chqno . "\" size=\"10\" onblur=\"chng_chqno('" . $row["tmp_count"] . "');\" value=\"" . $row["chqno"] . "\"     /></td>
					<td><input type=\"text\"  class=\"text_purchase3\" size=\"10\" id=\"" . $chqdate . "\" name=\"" . $chqdate . "\" onblur=\"chng_chqdate('" . $row["tmp_count"] . "');\" value=\"" . $row["chqdate"] . "\" /></td>
					<td><input type=\"text\" size=\"15\" name=\"" . $bank . "\" id=\"" . $bank . "\" value=\"" . $row["chqbank"] . "\" class=\"text_purchase3\" onblur=\"chng_bank('" . $row["tmp_count"] . "');\" /></td>
					<td align=right><input type=\"text\" size=\"15\" name=\"" . $chqamt . "\" id=\"" . $chqamt . "\" value=\"" . number_format($row["chqamt"], 2, ".", ",") . "\" onblur=\"chng_chqamt('" . $row["tmp_count"] . "');\" class=\"text_purchase3_right\" /></td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['chqno'] . "  name=" . $row['chqno'] . " onClick=\"del_item('" . $row['chqno'] . "');\"></td></tr>";

                $totchq = $totchq + $row["chqamt"];
            }

            $ResponseXML .= "   </table>]]></chq_table>";
            $ResponseXML .= "<chqtot><![CDATA[" . $totchq . "]]></chqtot>";
            $ResponseXML .= "<chqbal><![CDATA[" . $totchq . "]]></chqbal>";
            $ResponseXML .= "<chq_validity><![CDATA[yes]]></chq_validity>";

            $ResponseXML .= " </salesdetails>";
            echo $ResponseXML;
        } else {

            $ResponseXML = " <salesdetails>";
            $ResponseXML .= "<chq_validity><![CDATA[no]]></chq_validity>";

            $ResponseXML .= " </salesdetails>";
            echo $ResponseXML;
        }
    }

    if ($_GET["Command"] == "del_item") {

        $ResponseXML .= "";
        $ResponseXML .= "<salesdetails>";

        $sql = "delete from tmp_cash_chq where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "' and chqno='" . $_GET["chqno"] . "'";
        //echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $ResponseXML .= "<chq_table><![CDATA[ <table class=\"table\"><tr height=\"25\">
					<td width=\"200\"  background=\"\">Cheque No</td>
					<td width=\"100\"  background=\"\">Cheque Date</td>
					<td width=\"230\"  background=\"\">Bank</td>
					<td width=\"140\"  background=\"\">Amount</td>
					</tr>";

        $sql = "select * from tmp_cash_chq where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "' ";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {
            $ResponseXML .= "<tr>
					<td>" . $row["chqno"] . "</td>
					<td>" . $row["chqdate"] . "</td>
					<td>" . $row["chqbank"] . "</td>
					<td align=right>" . number_format($row["chqamt"], 2, ".", ",") . "</td>
					<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['chqno'] . "  name=" . $row['chqno'] . " onClick=\"del_item('" . $row['chqno'] . "');\"></td></tr>";

            $totchq = $totchq + $row["chqamt"];
        }

        $ResponseXML .= "   </table>]]></chq_table>";
        $ResponseXML .= "<chqtot><![CDATA[" . $totchq . "]]></chqtot>";
        $ResponseXML .= "<chqbal><![CDATA[" . $totchq . "]]></chqbal>";

        $ResponseXML .= " </salesdetails>";
        echo $ResponseXML;
    }

    if ($_GET["Command"] == "new_rec") {
 

        // if ($_SESSION["dev"] != "") {

            

            $sql = "select RECNO from invpara";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $row = mysqli_fetch_array($result);

            $tmprecno = "000000" . $row["RECNO"];
            $lenth = strlen($tmprecno);
            $recno = trim("CRN/ ") . substr($tmprecno, $lenth - 6);
            $_SESSION["recno"] = $recno;

            $sql = "Select RECNO from tmpinvpara";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $row = mysqli_fetch_array($result);
            $_SESSION["tmp_no_cashrec"] = "CRN/" . $row["RECNO"];

            $sql = "update tmpinvpara set RECNO=RECNO+1";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
               
                $sql = "delete from tmp_inv_data where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);

                $sql = "delete from tmp_cash_chq where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);

                $sql = "delete from tmp_cash_chq where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);

                $sql = "delete from tmp_utilization where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
             
            $ResponseXML = "";
            $ResponseXML .= "<salesdetails>";

            $ResponseXML .= "<recno><![CDATA[" . $recno . "]]></recno>";
            $ResponseXML .= "<cur_date><![CDATA[" . date("Y-m-d") . "]]></cur_date>";
            $ResponseXML .= "<chq_validity><![CDATA[yes]]></chq_validity>";

            $ResponseXML .= " </salesdetails>";
            echo $ResponseXML;
        // } else {

        //     $ResponseXML = " <salesdetails>";
        //     $ResponseXML .= "<chq_validity><![CDATA[no]]></chq_validity>";

        //     $ResponseXML .= " </salesdetails>";
        //     echo $ResponseXML;
        // }
    }

    if ($_GET["Command"] == "check_print") {
        $sql = "delete from tmprct where recno='" . $_GET["recno"] . "'";
        //echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $i = 1;
        //echo $_GET["mcount"];
        while ($_GET["mcount"] >= $i) {
            $sdate = "sdate" . $i;
            $invno = "invno" . $i;
            $invval = "invval" . $i;
            $overdue = "overdue" . $i;
            $chq_pay = "chq_pay" . $i;
            $cash_pay = "cash_pay" . $i;
            $inv_balance = "inv_balance" . $i;

            $invval_val = str_replace(",", "", $_GET[$invval]);
            $overdue_val = str_replace(",", "", $_GET[$overdue]);
            $chq_pay_val = str_replace(",", "", $_GET[$chq_pay]);
            $cash_pay_val = str_replace(",", "", $_GET[$cash_pay]);
            $inv_balance_val = str_replace(",", "", $_GET[$inv_balance]);

            if ((($_GET[$chq_pay_val] != "") and ($_GET[$chq_pay_val] != "0")) or (($_GET[$cash_pay_val] != "") and ($_GET[$cash_pay_val] != "0"))) {

                $paid = $_GET[$chq_pay_val] + $_GET[$cash_pay_val];

                $sql = "insert into  tmprct (SDATE, REFNO, AMOUNT, balance, paid, OVERDUE, flag) value ('" . $_GET[$sdate] . "', '" . $_GET[$invno] . "', '" . $_GET[$invval_val] . "', '" . $_GET[$overdue_val] . "', '" . $paid . "', 'INV')";
                //echo $sql;
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
            }

            $i = $i + 1;
        }

        $sql1 = "select * from tmp_cash_chq where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        while ($row1 = mysqli_fetch_array($result1)) {
            $sql = "insert into  tmprct (SDATE, REFNO, AMOUNT, balance, CH_VAL, flag) value ('" . $row1["chqdate"] . "', '" . $row1["chqno"] . "', '" . $row1["chqbank"] . "', '" . $row1["chqamt"] . "', '" . $row1["chqamt"] . "', 'CHK')";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
        }
    }

    if ($_GET["Command"] == "search_rec") {

        include_once ("connectioni.php");

        $ResponseXML .= "";
        //$ResponseXML .= "<invdetails>";

        $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\" >Ref No</font></td>
                              <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Date</font></td>
							   <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Amount</font></td>
							    <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Customer</font></td>
                             
   							</tr>";

        if ($_GET["mfield"] == "recno") {
            $letters = $_GET['recno'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            //$letters="/".$letters;
            //$a="SELECT * from s_salma where REF_NO like  '$letters%'";
            //echo $a;
            //echo "SELECT * from s_crec where  CA_REFNO and DEV='".$_SESSION["dev"]."' like  '$letters%' limit 50";
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_crec where   DEV='" . $_SESSION["dev"] . "' and CA_REFNO like  '$letters%' limit 50") or die(mysqli_error());
        } else if ($_GET["mstatus"] == "recdate") {
            $letters = $_GET['recdate'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_crec where DEV='" . $_SESSION["dev"] . "' and CA_DATE like  '$letters%' limit 50") or die(mysqli_error());
        } else if ($_GET["mstatus"] == "recamt") {
            $letters = $_GET['recamt'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_crec where DEV='" . $_SESSION["dev"] . "' and CA_AMOUNT like  '$letters%' limit 50") or die(mysqli_error());
        } else {
            $letters = $_GET['recno'];
            //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
            $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from s_crec where DEV='" . $_SESSION["dev"] . "' and CA_REFNO like  '$letters%' limit 50") or die(mysqli_error());
        }

        while ($row = mysqli_fetch_array($sql)) {
            $REF_NO = $row['CA_REFNO'];
            $stname = $_GET["mstatus"];
            $ResponseXML .= "<tr>
                           	  <td onclick=\"recno('$REF_NO');\">" . $row['CA_REFNO'] . "</a></td>
                              <td onclick=\"recno('$REF_NO');\">" . $row['CA_DATE'] . "</a></td>
                              <td onclick=\"recno('$REF_NO');\">" . $row['CA_AMOUNT'] . "</a></td>";

            $sql1 = "SELECT * FROM vendor where CODE = '" . $row["CA_CODE"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            $row1 = mysqli_fetch_array($result1);
            $ResponseXML .= "<td onclick=\"recno('$REF_NO');\">" . $row1['NAME'] . "</a></td>                          	
                            </tr>";
        }

        $ResponseXML .= "   </table>";

        echo $ResponseXML;
    }

    if ($_GET["Command"] == "search_bank") {

        include_once ("connectioni.php");

        $ResponseXML .= "";
        //$ResponseXML .= "<invdetails>";

        $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\" >Bank Code</font></td>
                              <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Banl Name</font></td>
							  
                             
   							</tr>";

        if ($_GET["mstatus"] == "cash_rec") {
            if ($_GET["mfield"] == "bcode") {
                $letters = $_GET['bcode'];
                $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from bankmas where  bcode like  '$letters%' order by bname limit 50") or die(mysqli_error());
            } else if ($_GET["mfield"] == "bank") {
                $letters = $_GET['bank'];
                $sql = mysqli_query($GLOBALS['dbinv'], "SELECT * from bankmas where  bname like  '$letters%' order by bname limit 50") or die(mysqli_error());
            }
        }

        while ($row = mysqli_fetch_array($sql)) {

            $ResponseXML .= "<tr>
                           	    <td onclick=\"selbank('" . $row["bcode"] . "', '" . $stname . "');\">" . $row["bcode"] . "</a></td>
                              <td onclick=\"selbank('" . $row["bcode"] . "', '" . $stname . "');\">" . $row["bname"] . "</a></td>
				
							                           	
                            </tr>";
        }

        $ResponseXML .= "   </table>";

        echo $ResponseXML;
    }

    if ($_GET["Command"] == "pass_selbank") {
        //header('Content-Type: text/xml');
        /* echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"; */

        $ResponseXML = "";
        $ResponseXML .= "<salesdetails>";
        $sql = "select * from bankmas where bcode='" . $_GET["bcode"] . "' order by bname limit 50";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row = mysqli_fetch_array($result)) {
            $ResponseXML .= "<bname><![CDATA[" . $row["bname"] . "]]></bname>";
        }

        $ResponseXML .= "</salesdetails>";

        echo $ResponseXML;
    }

    if ($_GET["Command"] == "pass_recno") {
        //header('Content-Type: text/xml');
        /* echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"; */

        $ResponseXML = "";
        $ResponseXML .= "<salesdetails>";
        $sql = "select * from s_crec where CA_REFNO='" . $_GET["recno"] . "'";
        //echo $sql;
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if ($row = mysqli_fetch_array($result)) {
            $ResponseXML .= "<CA_REFNO><![CDATA[" . $row["CA_REFNO"] . "]]></CA_REFNO>";
            $ResponseXML .= "<CA_DATE><![CDATA[" . $row["CA_DATE"] . "]]></CA_DATE>";
            $ResponseXML .= "<CA_CODE><![CDATA[" . $row["CA_CODE"] . "]]></CA_CODE>";
            $_SESSION["tmp_no_cashrec"] = $row["tmp_no"];

            $sql1 = "select * from vendor where CODE='" . $row["CA_CODE"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            if ($row1 = mysqli_fetch_array($result1)) {
                $ResponseXML .= "<cusname><![CDATA[" . $row1["NAME"] . "]]></cusname>";
            }
            $ResponseXML .= "<CA_CASSH><![CDATA[" . $row["CA_CASSH"] . "]]></CA_CASSH>";
            $ResponseXML .= "<CA_AMOUNT><![CDATA[" . $row["CA_AMOUNT"] . "]]></CA_AMOUNT>";
            $ResponseXML .= "<CA_SALESEX><![CDATA[" . $row["CA_SALESEX"] . "]]></CA_SALESEX>";
            $ResponseXML .= "<pay_type><![CDATA[" . $row["pay_type"] . "]]></pay_type>";
            $ResponseXML .= "<TTDATE><![CDATA[" . $row["TTDATE"] . "]]></TTDATE>";
            $ResponseXML .= "<AC_REFNO><![CDATA[" . $row["AC_REFNO"] . "]]></AC_REFNO>";

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
        } else {
            $ResponseXML .= "<collectcode><![CDATA[]]></collectcode>";
        }

        $sql = "delete from tmp_cash_chq where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $sql = "delete from tmp_cash_chq where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $sql = "delete from tmp_utilization where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $sql = "select * from s_invcheq where refno='" . $_GET["recno"] . "' order by ID";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {
            $sql1 = "insert into tmp_cash_chq(recno, chqno, chqdate, chqbank, chqamt, tmp_no) values ('" . $row["refno"] . "', '" . $row["cheque_no"] . "', '" . $row["che_date"] . "', '" . $row["bank"] . "', " . $row["che_amount"] . ", '" . $_SESSION["tmp_no_cashrec"] . "')";
            //echo $sql1;
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
        }

        $ResponseXML .= "<chq_table><![CDATA[ <table class=\"table\"><tr height=\"25\">
					 
					</tr>";

        $sql = "select * from tmp_cash_chq where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
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

        $sql = "delete from tmp_utilization where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "' ";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $sql = "select * from s_sttr where ST_REFNO='" . $_GET["recno"] . "' ";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {
            $sql1 = "select * from s_salma where REF_NO='" . $row["ST_INVONO"] . "' ";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            $row1 = mysqli_fetch_array($result1);

            $sql2 = "insert into tmp_utilization(recno, invno, invdate, org_invdate, chqno, chqdate, chbank, settled, days, tmp_no) values ('" . $_GET["recno"] . "', '" . $row["ST_INVONO"] . "', '" . $row1["SDATE"] . "', '" . $row1["SDATE"] . "', '" . $row["ST_CHNO"] . "', '" . $row["st_chdate"] . "', '" . $row["st_chbank"] . "', " . $row["ST_PAID"] . ", " . $row["st_days"] . ", '" . $_SESSION["tmp_no_cashrec"] . "')";
            //echo $sql2;
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
        }

        $ResponseXML .= "<uti_table><![CDATA[ <table class=\"table\"><tr  class=\"info\" height=\"25\">
					<td width=\"200\"  background=\"\">Invoice No</td>
					<td width=\"100\"  background=\"\">Inv. Date</td>
					<td width=\"230\"  background=\"\">Cheque No</td>
					<td width=\"140\"  background=\"\">Cheque Date</td>
					<td width=\"140\"  background=\"\">Settled</td>
					<td width=\"140\"  background=\"\">Days</td>
					</tr>";

        $sql = "select * from tmp_utilization where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
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

        include_once ("connectioni.php");

        $sql_status = 0;

        mysqli_query($GLOBALS['dbinv'], "SET AUTOCOMMIT=0");
        mysqli_query($GLOBALS['dbinv'], "START TRANSACTION");



        // if (date("Y-m-d") == date("Y-m-d", strtotime($_GET["invdate"]))) {
            $sql = "select * from c_bal where REFNO='" . $_GET["recno"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);

            if ($row = mysqli_fetch_array($result)) {
                if ($row["AMOUNT"] == $row["BALANCE"]) {
                    $sql1 = "delete from s_crec where CA_REFNO='" . $_GET["recno"] . "'";
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    if ($result1 != 1) {
                        $sql_status = 1;
                    }

                    $sql1 = "delete from s_led where REF_NO='" . $_GET["recno"] . "'";
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    if ($result1 != 1) {
                        $sql_status = 2;
                    }

                    $sql1 = "delete from s_invcheq where refno='" . $_GET["recno"] . "'";
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    if ($result1 != 1) {
                        $sql_status = 3;
                    }

                    //$sql1="update vendor set CUR_BAL=CUR_BAL+ ".$_GET["txtpaytot"]." where CODE='".$_GET["cuscode"]."'";
                    //$result1=mysqli_query($GLOBALS['dbinv'],$sql1);
                    //if ($result1!=1){ $sql_status=5; }

                    $sql1 = "delete from c_bal where REFNO='" . $_GET["recno"] . "'";
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    if ($result1 != 1) {
                        $sql_status = 4;
                    }

                    //$sql1="update br_trn set credit=credit- ".$_GET["txtpaytot"]." where cus_code='".$_GET["cuscode"]."' and Rep='".$_GET["salesrep"]."'";
                    //$result1=mysqli_query($GLOBALS['dbinv'],$sql1);
                    //if ($result1!=1){ $sql_status=7; }

                    $sql1 = "select * from s_sttr where ST_REFNO='" . $_GET["recno"] . "'";
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    //if ($result1!=1){ $sql_status=5; }

                    while ($row1 = mysqli_fetch_array($result1)) {
                        $sql2 = "update s_salma set TOTPAY=TOTPAY- " . $row1["ST_PAID"] . " where REF_NO='" . $row1["ST_INVONO"] . "'";
                        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                        if ($result2 != 1) {
                            $sql_status = 6;
                        }

                        //$sql2="update s_salma set CANCELL= '1' where recno='".$row1["invno"]."'";
                        //$result2 =mysqli_query($GLOBALS['dbinv'],$sql2);

                        if ((strtoupper($row1["ST_CHNO"]) == "CAS") or ($row1["ST_CHNO"] == "Cash") or ($row1["ST_CHNO"] == "Cash TT") or ($row1["ST_CHNO"] == "J/Entry")) {
                            $sql2 = "update s_salma set CASH=CASH- " . $row1["ST_PAID"] . " where REF_NO='" . $row1["ST_INVONO"] . "'";
                            $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                            if ($result2 != 1) {
                                $sql_status = 7;
                            }
                        }
                    }

                    $sql1 = "delete from s_sttr where ST_REFNO='" . $_GET["recno"] . "'";
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    if ($result1 != 1) {
                        $sql_status = 8;
                    }

                    $sql_l = "delete from ledger where l_refno = '" . trim($_GET["recno"]) . "'";
                    $result_l = mysqli_query($GLOBALS['dbinv'], $sql_l);
                    if ($result_l != 1) {
                        $sql_status = 9;
                    }

                    $sql_l = "delete from bankdeptrn where refno = '" . trim($_GET["recno"]) . "'";
                    $result_l = mysqli_query($GLOBALS['dbinv'], $sql_l);
                    if ($result_l != 1) {
                        $sql_status = 10;
                    }

                    $sql_l = "delete from bankdepche where refno = '" . trim($_GET["recno"]) . "'";
                    $result_l = mysqli_query($GLOBALS['dbinv'], $sql_l);
                    if ($result_l != 1) {
                        $sql_status = 11;
                    }

                    // $sql_l = "delete from tmp_ret_chq_sett where recno = '" . trim($_GET["recno"]) . "'";
                    // $result_l = mysqli_query($GLOBALS['dbinv'], $sql_l);
                    // if ($result_l != 1) {
                    //     $sql_status = 12;
                    // }

                    $sql1 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_GET["recno"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'Cash Reciept', 'Cancel', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    if ($result1 != 1) {
                        $sql_status = 13;
                    }

                    if ($sql_status == 0) {
                        mysqli_query($GLOBALS['dbinv'], "COMMIT");
                        

                        $ResponseXML = "Reciept Canceled";
                    } else {
                        mysqli_query($GLOBALS['dbinv'], "ROLLBACK");
                        
                        $ResponseXML = "Error has occured. Can't Cancel";
                    }
                } else {
                    $ResponseXML .= "Sorry over payment utilized.... Cant Cancel";
                }
            } else {
                $sql1 = "delete from s_crec where CA_REFNO='" . $_GET["recno"] . "'"; 
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                if ($result1 != 1) {
                    $sql_status = 1;
                }

                $sql1 = "delete from s_sttr where ST_REFNO='" . $_GET["recno"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                if ($result1 != 2) {
                    $sql_status = 2;
                }

                $sql1 = "delete from s_led where REF_NO='" . $_GET["recno"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                if ($result1 != 3) {
                    $sql_status = 3;
                }

                $sql1 = "delete from s_invcheq where refno='" . $_GET["recno"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                if ($result1 != 4) {
                    $sql_status = 4;
                }

                //	$sql1="update vendor set CUR_BAL=CUR_BAL+ ".$_GET["txtpaytot"]." where CODE='".$_GET["cuscode"]."'";
                //	$result1=mysqli_query($GLOBALS['dbinv'],$sql1);
                //	if ($result1!=1){ $sql_status=5; }

                $sql1 = "delete from c_bal where REFNO='" . $_GET["recno"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                if ($result1 != 5) {
                    $sql_status = 5;
                }

                //$sql1="update br_trn set credit=credit- ".$_GET["txtpaytot"]." where cus_code='".$_GET["cuscode"]."' and Rep='".$_GET["salesrep"]."'";
                //$result1=mysqli_query($GLOBALS['dbinv'],$sql1);
                //if ($result1!=1){ $sql_status=7; }

                $sql1 = "select * from tmp_utilization where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                while ($row1 = mysqli_fetch_array($result1)) {
                    $sql2 = "update s_salma set TOTPAY=TOTPAY- " . $row1["settled"] . " where REF_NO='" . $row1["invno"] . "'";
                    $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                    if ($result2 != 6) {
                        $sql_status = 6;
                    }

                    //$sql2="update s_salma set CANCELL= '1' where recno='".$row1["invno"]."'";
                    //$result2 =mysqli_query($GLOBALS['dbinv'],$sql2);

                    if (($row1["chqno"] == "Cash") or ($row1["chqno"] == "Cash TT") or ($row1["chqno"] == "J/Entry")) {

                        $sql2 = "update s_salma set CASH=CASH- " . $row1["settled"] . " where REF_NO='" . $row1["invno"] . "'";
                        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                        if ($result2 != 7) {
                            $sql_status = 7;
                        }
                    }
                }

                $sql_l = "delete from ledger where l_refno = '" . trim($_GET["recno"]) . "'";
                $result_l = mysqli_query($GLOBALS['dbinv'], $sql_l);
                if ($result_l != 8) {
                    $sql_status = 8;
                }

                $sql_l = "delete from bankdeptrn where refno = '" . trim($_GET["recno"]) . "'";
                $result_l = mysqli_query($GLOBALS['dbinv'], $sql_l);
                if ($result_l != 9) {
                    $sql_status = 9;
                }

                $sql_l = "delete from bankdepche where refno = '" . trim($_GET["recno"]) . "'";
                $result_l = mysqli_query($GLOBALS['dbinv'], $sql_l);
                if ($result_l != 10) {
                    $sql_status = 10;
                }

                // $sql_l = "delete from tmp_ret_chq_sett where recno = '" . trim($_GET["recno"]) . "'";
                // $result_l = mysqli_query($GLOBALS['dbinv'], $sql_l);
                // if ($result_l != 11) {
                //     $sql_status = 11;
                // }

                $sql1 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_GET["recno"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'Cash Reciept', 'Cancel', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";

                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                if ($result1 != 12) {
                    $sql_status = 12;
                }

                if ($sql_status == 0) {
                    mysqli_query($GLOBALS['dbinv'], "COMMIT");
                    
                    $ResponseXML = "Reciept Canceled";
                } else {
                    mysqli_query($GLOBALS['dbinv'], "ROLLBACK");
                    
                    $ResponseXML = "Error has occured. Can't Cancel";
                }
            }

            echo $sql_status;
        // } else {
        //     $ResponseXML = "Sorry Cant Cancel.... please check reciept date";
        // }

        echo $ResponseXML;
    }
}

if (isset($_POST["Command"])) {
    if ($_POST["Command"] == "utilization") {
        require_once ("connectioni.php");

        if ($_SESSION["tmp_no_cashrec"] != "") {
            $i = 1;
            $a_chq_no = array();
            $a_chq_date = array();
            $a_chq_amt = array();
            $a_chq_bank = array();

            $chq_pay = "";
            $invno = "";
            $delidate = "";
            $available_inv_amt = 0;
            $available_chq_amt = 0;

            $sql = "delete from tmp_utilization where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);

            $sql = "select * from tmp_cash_chq where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {

                if ((strtotime($row["chqdate"]) < strtotime($_POST["invdate"])) or (strtotime($row["chqdate"]) == strtotime($_POST["invdate"]))) {

                    $date = date('Y-m-d', strtotime(($_POST["invdate"]) . ' +1 days'));

                    $a_chq_date[$i] = $date;
                } else {
                    $a_chq_date[$i] = $row["chqdate"];
                }
                $a_chq_no[$i] = $row["chqno"];
                $a_chq_amt[$i] = $row["chqamt"];
                $a_chq_bank[$i] = $row["chqbank"];

                $i = $i + 1;
            }

            $mcou = $i;

            $j = 1;
            $chq_pay_8 = array();

            while ($j < $_POST["mcount"]) {
                $chq_pay = "chq_pay" . $j;

                if ($_POST[$chq_pay] != "") {
                    $chq_pay_8[$j] = $_POST[$chq_pay];
                } else {
                    $chq_pay_8[$j] = "";
                }

                $j = $j + 1;
            }

            $invset = 0;

            $i = 1;
            $K = 1;
            $invpos = 1;

            while ($mcou >= $i) {

                if ($invset == 0) {
                    $j = 1;
                } else {
                    $j = $invpos;
                }
                $chqbal = $a_chq_amt[$i];
                $chqval = $a_chq_amt[$i];

                while (($j < $_POST["mcount"]) and ($chqbal > 0)) {

                    $chq_pay = "chq_pay" . $j;
                    $chq_balance = "chq_balance" . $j;
                    $invno = "invno" . $j;
                    $delidate = "delidate" . $j;
                    $invval = "invval" . $j;
                    $sdate = "sdate" . $j;

                    if ($invset == 0) {
                        //echo $chq_pay."/";
                        //echo $_POST[$chq_pay];

                        $invset = $chq_pay_8[$j];
                        $chq_pay_8[$j] = "";
                    }
                    if ($invset > 0) {
                        if ($invset <= $chqbal) {

                            //echo $invset;
                            $chqbal = $chqbal - $invset;

                            if (($_POST[$delidate] == "0000-00-00") or ($_POST[$delidate] == "")) {
                                $date1 = $_POST[$sdate];
                            } else {
                                $date1 = $_POST[$delidate];
                            }

                            $date2 = $a_chq_date[$i];
                            $diff = abs(strtotime($date2) - strtotime($date1));
                            $days = floor($diff / (60 * 60 * 24));

                            $col2 = str_replace(",", "", $_POST[$invval]);
                            $invset_val = str_replace(",", "", $invset);
                            if ($_POST[$sdate] == "") {
                                $msdate = "0000-00-00";
                            } else {
                                $msdate = $_POST[$sdate];
                            }
                            if ($date1 == "") {
                                $date1 = "0000-00-00";
                            }
                            $sql1 = "insert into tmp_utilization(recno, invno, invdate, org_invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('" . $_POST["recno"] . "', '" . $_POST[$invno] . "', '" . $date1 . "', '" . $msdate . "', '" . $a_chq_no[$i] . "', '" . $a_chq_date[$i] . "', '" . $a_chq_bank[$i] . "', " . $invset_val . ", " . $days . ", " . $col2 . ", 0, '" . $_SESSION["tmp_no_cashrec"] . "')";
                            //echo $sql1." 1 /";
                            $result = mysqli_query($GLOBALS['dbinv'], $sql1);
                            if (!$result) {
                                echo mysqli_error($GLOBALS['dbinv']);
                            }
                            $invset = 0;
                        } else {
                            if ($invset > 0) {
                                $invset = $invset - $chqbal;
                            }

                            if (($_POST[$delidate] == "0000-00-00") or ($_POST[$delidate] == "")) {
                                $date1 = $_POST[$sdate];
                            } else {
                                $date1 = $_POST[$delidate];
                            }
                            //$date1 = $_POST[$delidate];
                            $date2 = $a_chq_date[$i];
                            $diff = abs(strtotime($date2) - strtotime($date1));
                            $days = floor($diff / (60 * 60 * 24));

                            $col2 = str_replace(",", "", $_POST[$invval]);
                            $chqbal_val = str_replace(",", "", $chqbal);
                            if ($_POST[$sdate] == "") {
                                $msdate = "0000-00-00";
                            } else {
                                $msdate = $_POST[$sdate];
                            }

                            if ($date1 == "") {
                                $date1 = "0000-00-00";
                            }
                            $sql1 = "insert into tmp_utilization(recno, invno, invdate, org_invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('" . $_POST["recno"] . "', '" . $_POST[$invno] . "', '" . $date1 . "', '" . $msdate . "', '" . $a_chq_no[$i] . "', '" . $a_chq_date[$i] . "', '" . $a_chq_bank[$i] . "', " . $chqbal_val . ", " . $days . ", " . $col2 . ", 0, '" . $_SESSION["tmp_no_cashrec"] . "')";
                            //echo $sql1." 2 /";
                            $result = mysqli_query($GLOBALS['dbinv'], $sql1);

                            $chqbal = 0;
                            $invpos = $j;
                        }
                        $K = $K + 1;
                    }
                    // echo "----".$j."----";
                    $j = $j + 1;
                }
                $i = $i + 1;
            }
            $ii = 1;

            while ($_POST["mcount"] > $ii) {

                $cash_pay = "cash_pay" . $ii;
                $invno = "invno" . $ii;
                $delidate = "delidate" . $ii;
                $invval = "invval" . $ii;

                if ($_POST[$cash_pay] != "") {

                    if ($_POST["paytype"] == "Cash TT") {
                        $chqdate = $_POST["dt"];

                        if (($_POST[$delidate] == "0000-00-00") or ($_POST[$delidate] == "")) {
                            $date1 = $_POST[$sdate];
                        } else {
                            $date1 = $_POST[$delidate];
                        }
                        //$date1 = $_POST[$delidate];
                        $date2 = $chqdate;
                        $diff = abs(strtotime($date2) - strtotime($date1));
                        $days = floor($diff / (60 * 60 * 24));
                    } else {
                        $chqdate = strtotime($_POST["invdate"]);

                        if (($_POST[$delidate] == "0000-00-00") or ($_POST[$delidate] == "")) {
                            $date1 = $_POST[$sdate];
                        } else {
                            $date1 = $_POST[$delidate];
                        }

                        //$date1 = $_POST[$delidate];
                        $date2 = $_POST["invdate"];
                        $diff = abs(strtotime($date2) - strtotime($date1));
                        $days = floor($diff / (60 * 60 * 24));
                    }

                    $col2 = str_replace(",", "", $_POST[$invval]);
                    $cash_pay_val = str_replace(",", "", $_POST[$cash_pay]);
                    if ($_POST[$sdate] == "") {
                        $msdate = "0000-00-00";
                    } else {
                        $msdate = $_POST[$sdate];
                    }

                    if ($date1 == "") {
                        $date1 = "0000-00-00";
                    }



                    $sql1 = "insert into tmp_utilization(recno, invno, invdate, org_invdate, chqno, chqdate, chbank, settled, days, invval, c1, tmp_no) values ('" . $_POST["recno"] . "', '" . $_POST[$invno] . "', '" . $date1 . "', '" . $msdate . "', '" . $_POST["paytype"] . "', '" . $_POST["invdate"] . "', '" . $a_chq_bank[$i] . "', " . $cash_pay_val . ", " . $days . ", " . $col2 . ", 0, '" . $_SESSION["tmp_no_cashrec"] . "')";
                    //echo $sql1." 3 /";
                    $result = mysqli_query($GLOBALS['dbinv'], $sql1);
                    $K = $K + 1;
                }
                $ii = $ii + 1;
            }

            $invno_0 = array();
            $invdate_1 = array();
            $chqno_2 = array();
            $chqdate_3 = array();
            $settled_4 = array();
            $days_5 = array();

            $r = 1;
            $sql = "select * from tmp_utilization where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
            //echo $sql;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {
                $id[$r] = $row["id"];
                $invno_0[$r] = $row["invno"];
                $invdate_1[$r] = $row["invdate"];
                $chqno_2[$r] = $row["chqno"];
                $chqdate_3[$r] = $row["chqdate"];
                $settled_4[$r] = $row["settled"];
                $days_5[$r] = $row["days"];
                $c1_6[$r] = $row["c1"];
                $r = $r + 1;
            }

            $S = 1;
            while ($_POST["mcount"] > $S) {
                $H = 10;
                while ($H != 0) {

                    $invno = "invno" . $S;
                    $cash_pay = "cash_pay" . $S;
                    $inv_balance = "inv_balance" . $S;

                    if ($_POST[$invno] == $invno_0[$H]) {
                        if ($invno_0[$H + 1] == $invno_0[$H]) {
                            if (trim($chqno_2[$H]) != "Cash") {
                                $c1_6[$H] = $c1_6[$H + 1] + $settled_4[$H + 1] - $_POST[$cash_pay];
                            } else {
                                $c1_6[$H] = $c1_6[$H + 1] + $settled_4[$H + 1];
                            }

                            $sql11 = "update tmp_utilization set c1=" . $c1_6[$H] . " where id=" . $id[$H];
                            $result1 = mysqli_query($GLOBALS['dbinv'], $sql11);
                        } else {
                            if (trim($chqno_2[$H]) != "Cash") {
                                $c1_6[$H] = $_POST[$inv_balance] - $_POST[$cash_pay];
                            } else {
                                $c1_6[$H] = $_POST[$inv_balance];
                            }
                            $sql11 = "update tmp_utilization set c1=" . $c1_6[$H] . " where id=" . $id[$H];
                            $result1 = mysqli_query($GLOBALS['dbinv'], $sql11);
                        }
                    }
                    $H = $H - 1;
                }
                $deutot = $deutot + $_POST[$inv_balance];
                $S = $S + 1;
            }
 

            $ResponseXML = "";
            $ResponseXML .= "<salesdetails>";

            $ResponseXML .= "<uti_table><![CDATA[ <table class=\"table\"><tr  class=\"info\" height=\"25\">
					<td width=\"200\"  background=\"\">Invoice No1</td>
					<td width=\"100\"  background=\"\">Invoice Date</td>
					<td width=\"230\"  background=\"\">Cheque No</td>
					<td width=\"140\"  background=\"\">Cheque Date</td>
					<td width=\"140\"  background=\"\">Settled</td>
					<td width=\"140\"  background=\"\">Days</td>
					</tr>";

            $sql = "select * from tmp_utilization where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
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
            $ResponseXML .= "<chq_validity><![CDATA[yes]]></chq_validity>";

            $ResponseXML .= " </salesdetails>";
            echo $ResponseXML;
        } else {
            $ResponseXML = " <salesdetails>";
            $ResponseXML .= "<chq_validity><![CDATA[no]]></chq_validity>";
            $ResponseXML .= " </salesdetails>";
            echo $ResponseXML;
        }
    }

    if ($_POST["Command"] == "save_crec") {



        // if ($_SESSION["dev"] == "") {
        //     exit("no");
        // }

        if ($_SESSION["tmp_no_cashrec"] != "") {



            $sqltmp = "select * from invpara";
            $resulttmp = mysqli_query($GLOBALS['dbinv'], $sqltmp);
            $rowtmp = mysqli_fetch_array($resulttmp);

            // if ($rowtmp["form_loc"] == "1") {
            //     exit("no");
            // }

            $sql_status = 0;

            mysqli_query($GLOBALS['dbinv'], "SET AUTOCOMMIT=0");
            mysqli_query($GLOBALS['dbinv'], "START TRANSACTION");
 

             

            

                    $sql = "select RECNO from invpara";
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    $row = mysqli_fetch_array($result);

                    $tmprecno = "000000" . $row["RECNO"];
                    $lenth = strlen($tmprecno);
                    $recno = trim("CRN/CR/ ") . substr($tmprecno, $lenth - 6);
                    $_SESSION["recno"] = $recno;
             

                
         

            $ResponseXML = "";
            $ResponseXML .= "<salesdetails>";

            $sql = "select * from s_crec where CA_REFNO='" . $recno . "'";

            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row = mysqli_fetch_array($result)) {
                $ResponseXML .= "<msg_dup><![CDATA[Reciept No Already Saved]]></msg_dup>";
                exit();
            } else {
                $ResponseXML .= "<msg_dup><![CDATA[0]]></msg_dup>";
            }

            //	Call accsave====================================================================================???????????????
            //=============================================================================
            if ($recno != '') {
                if (is_numeric($_POST["cashtot"]) == true) {
                    $cashtot = $_POST["cashtot"];
                } else {
                    $cashtot = 0;
                }

                if (is_numeric($_POST["txtpaytot"]) == true) {
                    $txtpaytot = $_POST["txtpaytot"];
                } else {
                    $txtpaytot = 0;
                }

                if (is_numeric($_POST["txtoverpay"]) == true) {
                    $txtoverpay = $_POST["txtoverpay"];
                } else {
                    $txtoverpay = 0;
                }
                $recDate = $_POST["invdate"];
                $sql = "insert into s_crec(CA_REFNO, CA_DATE, CA_CODE, CA_CASSH, CA_AMOUNT, overpay, FLAG, pay_type, CA_SALESEX, CANCELL, tmp_no, DEPARTMENT, cus_ref, AC_REFNO, TTDATE, DEV) values
	  ('" . $recno . "', '" . $recDate . "', '" . $_POST["cuscode"] . "', " . $cashtot . ", " . $txtpaytot . ", " . $txtoverpay . ", 'REC', '" . $_POST["paytype"] . "', '" . $_POST["salesrep"] . "', '0', '" . $_SESSION["tmp_no_cashrec"] . "', 'O', '0', '" . $_POST["ca_refno"] . "', '" . $_POST["dt"] . "',  '" . $_SESSION['dev'] . "' )";
                //echo $sql;
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($result != 1) {
                    $sql_status = 1;
                }
                $tmputiamou = 0;
                $sql = "select * from tmp_utilization where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
                //echo $sql;
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                while ($row = mysqli_fetch_array($result)) {
                    if ($row["chqno"] == "Cash") {
                        $ST_flag = "CAS";
                        $ST_CHDATE = $recDate;
                    } else if ($row["chqno"] == "Cash TT") {
                        $ST_flag = "Cash TT";
                        $ST_CHDATE = $_POST["dt"];
                    } else if ($row["chqno"] == "J/Entry") {
                        $ST_flag = "J/Entry";
                        $ST_CHDATE = $recDate;
                    } else {
                        $ST_flag = "CHK";
                        $ST_CHDATE = $row["chqdate"];
                    }

                    if (is_numeric($row["settled"]) == true) {
                        $settled = $row["settled"];
                    } else {
                        $settled = 0;
                    }
                    $sql1 = "insert into s_sttr(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_CHNO, st_chdate, ST_FLAG, st_days, ap_days, st_chbank, cus_code, DEV, del_days, deliin_days, deliin_amo, deliin_lock, department) values
	  ('" . $recno . "', '" . $recDate . "', '" . $row["invno"] . "', " . $settled . ", '" . $row["chqno"] . "', '" . $ST_CHDATE . "', '" . $ST_flag . "', '" . $row["days"] . "', '" . $row["days"] . "', '" . $row["chbank"] . "', '" . $_POST["cuscode"] . "', '" . $_SESSION['dev'] . "', 0, 0, 0, '0', 'O')";
                    //  echo $sql1;
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    if ($result1 != 1) {
                        $sql_status = 2;
                    }

                    $sql1 = "insert into s_sttr_all(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, netamount, ST_CHNO, st_chdate, ST_FLAG, st_days, ap_days, st_chbank, cus_code, cusname, sal_ex, DEV, del_days, deliin_days, deliin_amo, deliin_lock, department, form_type, trn_type) values
	  ('" . $recno . "', '" . $recDate . "', '" . $row["invno"] . "', " . $settled . ", " . (-1 * $settled) . ", '" . $row["chqno"] . "', '" . $ST_CHDATE . "', '" . $ST_flag . "', '" . $row["days"] . "', '" . $row["days"] . "', '" . $row["chbank"] . "', '" . $_POST["cuscode"] . "', '" . $_POST["cusname"] . "', '" . $_POST["salesrep"] . "', '" . $_SESSION['dev'] . "', 0, 0, 0, '0', 'O', 'REC', 'SET')";
                    //  echo $sql1;
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    if ($result1 != 1) {
                        $sql_status = 3;
                    }

                    $tmputiamou = $tmputiamou + $row["settled"];
                }

                $i = 1;
                while ($_POST[mcount] >= $i) {
                    $chq_pay = "chq_pay" . $i;
                    $cash_pay = "cash_pay" . $i;
                    $invno = "invno" . $i;
                    $cash = 0;
                    $chk = 0;
                    $tot = 0;

                    if ((is_numeric($_POST[$chq_pay]) == true and $_POST[$chq_pay] != 0) or (is_numeric($_POST[$cash_pay]) == true and $_POST[$cash_pay] != 0)) {

                        if (is_numeric($_POST[$cash_pay]) == true) {
                            $cash = $_POST[$cash_pay];
                        } else {
                            $cash = 0;
                        }
                        if (is_numeric($_POST[$chq_pay]) == true) {
                            $chk = $_POST[$chq_pay];
                        } else {
                            $chk = 0;
                        }

                        $tot = $cash + $chk;

                        // $sql = "select brand from s_salma where REF_NO='" . $_POST[$invno] . "'";
                        // $result = mysqli_query($GLOBALS['dbinv'], $sql);
                        // if ($row = mysqli_fetch_array($result)) {
                        //     $sql1 = "select class from brand_mas where barnd_name='" . $row["brand"] . "'";
                        //     $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                        //     if ($row1 = mysqli_fetch_array($result1)) {
                        //         $sql2 = "update br_trn set credit=credit - " . $tot . " where cus_code = '" . $_POST["cuscode"] . "' and Class = '" . $row1["class"] . "'";
                        //         $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                        //         if ($result2 != 1) {
                        //             $sql_status = 4;
                        //         }
                        //     }
                        // }

                        $sql2 = "update vendor set CUR_BAL=CUR_BAL - " . $tot . " where CODE = '" . $_POST["cuscode"] . "'";
                        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                        if ($result2 != 1) {
                            $sql_status = 5;
                        }

                        // $sql2 = "update br_trn set credit=credit - " . $tot . " where cus_code = '" . $_POST["cuscode"] . "' and Rep='" . $_POST["salesrep"] . "'";
                        // $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                        // if ($result2 != 1) {
                        //     $sql_status = 6;
                        // }

                        $sql2 = "update s_salma set TOTPAY=TOTPAY + " . $tot . " where REF_NO = '" . $_POST[$invno] . "'";
                        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                        if ($result2 != 1) {
                            $sql_status = 7;
                        }

                        $sql2 = "update s_salma set CASH=CASH + " . $cash . " where REF_NO = '" . $_POST[$invno] . "'";
                        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                        if ($result2 != 1) {
                            $sql_status = 8;
                        }
                    }
                    $i = $i + 1;
                }

                $chqno = "";
                $tmpchkamou = 0;
                $sql = "select * from tmp_cash_chq where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                while ($row = mysqli_fetch_array($result)) {
                    $sql1 = "select * from vendor where CODE='" . $_POST["cuscode"] . "'";
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    $row1 = mysqli_fetch_array($result1);

                    if (is_numeric($row["chqamt"]) == true) {
                        $chqamt = $row["chqamt"];
                    } else {
                        $chqamt = 0;
                    }

                    $sql2 = "insert into s_invcheq(refno, Sdate, cus_code, CUS_NAME, cheque_no, che_date, bank, che_amount, sal_ex, trn_type, ex_flag, ch_owner, noof, ret_refno, ch_count_ret, department) values
	  ('" . $recno . "', '" . $recDate . "', '" . $_POST["cuscode"] . "', '" . $row1["NAME"] . "', '" . $row["chqno"] . "', '" . $row["chqdate"] . "', '" . $row["chqbank"] . "',  " . $chqamt . ", '" . $_POST["salesrep"] . "', 'REC', 'N', '" . $_POST["chqcollect"] . "', 0, '1', '0', 'O')";
                    $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                    if ($result2 != 1) {
                        $sql_status = 9;
                    }

                    $chqno = $chqno . " " . $row["chqno"] . "-" . $row["chqamt"];
                    $tmpchkamou = $tmpchkamou + $row["chqamt"];
                }

//                $n1 = floatval($tmputiamou + $_POST["txtoverpay"]);
//                $n2 = floatval($tmpchkamou);
                $n1 = floatval($_POST["txtpaytot"] + $_POST["txtoverpay"]);
                $n2 = floatval($_POST["chqtot"]);
                // if (($_POST["paytype"] == "Cheque")) {
                //     if ($n1 != $n2) {
                //         exit("Check amount and settlement amount not equal");
                //     }
                // }
//                $n1 = floatval($tmputiamou + $_POST["txtoverpay"]);
//                $n2 = floatval($tmpchkamou);
//                if (($_POST["paytype"] == "Cheque")) {
//                    if ($n1 != $n2) {
//                        exit("Check amount and settlement amount not equal");
//                    }
//                }
//                if (($_POST["paytype"] == "Cheque")) {
//                    if (number_format($tmputiamou, 1, ".", ",") + number_format($_POST["txtoverpay"], 1, ".", ",") != number_format($tmpchkamou, 1, ".", ",")) {
////                    if ($tmputiamou +$_POST["txtoverpay"] != $tmpchkamou) {
//                        exit("Check amount and settlement amount not equal");
//                    } else {
//                        
//                    }
//                }

                if (is_numeric($_POST["chqtot"]) == true) {
                    $chqtot = $_POST["chqtot"];
                } else {
                    $chqtot = 0;
                }

                if (is_numeric($_POST["cashtot"]) == true) {
                    $cashtot = $_POST["cashtot"];
                } else {
                    $cashtot = 0;
                }

                $cash_chq_tot = $chqtot + $cashtot;
                $sql = "insert into s_led(REF_NO, C_CODE, SDATE, FLAG, AMOUNT) values
	  ('" . $recno . "', '" . $_POST["cuscode"] . "', '" . $recDate . "', 'REC', " . $cash_chq_tot . ")";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($result != 1) {
                    $sql_status = 10;
                }
                $sqlrep = "select * from s_salrep where REPCODE = '" . $_POST["salesrep"] . "'";
                $resultrep = mysqli_query($GLOBALS['dbinv'], $sqlrep);
                if ($rowrep = mysqli_fetch_array($resultrep)) {
                    $maindepart = $rowrep['RGROUP1'];
                } else {
                    $maindepart = "";
                }
                
                if ($_POST["txtoverpay"] > 0) {
                    $sql = "insert into c_bal(REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, SAL_EX, DEV,maindepartment,sdate1,c_code1) values
	  ('" . $recno . "', '" . $recDate . "', 'REC', '" . $_POST["cuscode"] . "',  " . $_POST["txtoverpay"] . ", " . $_POST["txtoverpay"] . ", '" . $_POST["salesrep"] . "', '" . $_SESSION["dev"] . "','" . $maindepart . "','".$recDate."','" . $_POST["cuscode"] . "')";
                    // echo $sql;
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    if ($result != 1) {
                        $sql_status = 11;
                    }

                    $sql1 = "insert into s_sttr_all(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, balance, netamount, cus_code, cusname, sal_ex, DEV, del_days, deliin_days, deliin_amo, deliin_lock, form_type, trn_type) values
	  ('" . $recno . "', '" . $recDate . "', '" . $recno . "', " . $_POST["txtoverpay"] . ", " . $_POST["txtoverpay"] . ", " . (-1 * $_POST["txtoverpay"]) . ", '" . $_POST["cuscode"] . "', '" . $_POST["cusname"] . "', '" . $_POST["salesrep"] . "', '" . $_SESSION['dev'] . "', 0, 0, 0, '0', 'REC', 'OVER')";
                    //echo $sql1;
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    if ($result1 != 1) {
                        $sql_status = 12;
                    }
                }
                

                
                    $sql2 = "update invpara set RECNO=RECNO + 1";
                    $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                    if ($result2 != 1) {
                        $sql_status = 14;
                    }
                

                //////////////////////////////		Account System////////////////////
                //include_once("connectioni.php");
                if (($_POST["paytype"] == "Cash") or ($_POST["paytype"] == "Cash TT") or ($_POST["paytype"] == "Cheque")) {
//                if ($_POST["paytype"] == "Cash TT") {
                    //$mHead="CASH TT RECEIVED FROM ".$_POST["cuscode"]." ".$_POST["cusname"]." TO SETTLE RET.CHE.NO.- ".$chqno;
                    $mHead = $_POST["paytype"] . " RECEIVED FROM " . $_POST["cuscode"] . " " . $_POST["cusname"];

                    if (trim($_POST["ledg_ref_no"]) != "") {
                        $sql_rst = "update ledger set l_recno='" . $_POST["recno"] . "' where refno='" . trim($_POST["ledg_ref_no"]) . "'";
                        //echo $sql_rst;
                        $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
                        if ($result_rst != 1) {
                            $sql_status = 15;
                        }
                    }

                    $sql_rst = "delete from bankdepmas where refno='" . trim($recno) . "'";
                    $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
                    if ($result_rst != 1) {
                        $sql_status = 16;
                    }

                    $fulltot = $txtpaytot + $txtoverpay;

                    $sql_rst = "Insert into bankdepmas (refno, bdate, heading, code, name, amount, cash, comcode, cancel, type, tmp_no) Values ('" . trim($recno) . "', '" . $_POST["dt"] . "', '" . $mHead . "', '" . $_POST["accno"] . "', '" . $_POST["acc_name"] . "', " . $fulltot . ", 0,'THT', '0', 'D', '" . trim($recno) . "')";
                    // echo $sql_rst;
                    $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
                    if ($result_rst != 1) {
                        $sql_status = 17;
                    }

                    $l_lmem = $_POST["paytype"] . " recieved from " . trim($_POST["cusname"]);
                    $l_lmem = $mHead;

                    $sql = "delete from  ledger where l_refno='" . trim($recno) . "'";
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    if ($result != 1) {
                        $sql_status = 18;
                    }

                    $sql = "insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_lmem, l_flag2, l_flag3, l_yearfl, comcode, chno, recdate, l_year) values ('" . trim($recno) . "', '" . $_POST["dt"] . "', '" . trim($_POST["accno2"]) . "', " . $fulltot . ", 'REC', 'CRE', '" . $l_lmem . "', '0', 'R', 0, 'THT', '', '0', " . date("Y") . ")";
                    //echo $sql;
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    if ($result != 1) {
                        $sql_status = 19;
                    }

                    $sql = "insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_lmem, l_flag2, l_flag3, l_yearfl, comcode, chno, recdate, l_year) values ('" . trim($recno) . "', '" . $_POST["dt"] . "', '" . trim($_POST["accno"]) . "', " . $fulltot . ", 'REC', 'DEB', '" . $l_lmem . "', '0', 'R', 0, 'THT', '', '0', " . date("Y") . ")";
                    //echo $sql;
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    if ($result != 1) {
                        $sql_status = 20;
                    }

                    $sql = "delete from bankdeptrn where refno='" . trim($recno) . "'";
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    if ($result != 1) {
                        $sql_status = 21;
                    }

                    $sql = "Insert into bankdeptrn(refno, bdate, code, amount, flag, nara, comcode, tmp_no) Values ('" . trim($recno) . "', '" . $_POST["dt"] . "', '" . $_POST["accno2"] . "', " . $_POST["txtpaytot"] . ", 'CRE', '" . trim($l_lmem) . "' ,'THT', '" . $_POST["recno"] . "')";
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    if ($result != 1) {
                        $sql_status = 22;
                    }

                    $sql = "select * from tmp_cash_chq where tmp_no='" . $_SESSION["tmp_no_cashrec"] . "'";
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    //$result =mysqli_query($GLOBALS['dbinv'],$sql) ;
                    while ($row = mysqli_fetch_array($result)) {

                        if (is_numeric($row["chqamt"]) == true) {
                            $chqamt = $row["chqamt"];
                        } else {
                            $chqamt = 0;
                        }

                        $sql2 = "delete from bankdeptrn where refno='" . trim($recno) . "'";
                        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                        if ($result2 != 1) {
                            $sql_status = 23;
                        }

                        $sql2 = "Insert into bankdeptrn(refno, bdate, code, amount, flag, nara, comcode, tmp_no) Values ('" . trim($recno) . "', '" . $_POST["dt"] . "', '" . trim($_POST["accno"]) . "', " . $chqamt . ", 'DEB', '" . trim($l_lmem) . ", 'THT', '" . trim($_POST["recno"]) . "' )";
                        $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                        if ($result2 != 1) {
                            $sql_status = 24;
                        }

                        $sql1 = "delete from bankdepche where refno='" . trim($recno) . "'";
                        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                        if ($result1 != 1) {
                            $sql_status = 25;
                        }

                        $sql1 = "Insert into bankdepche(refno, cheno, bdate, ven_code, ven_name, bank, amount ,comcode, id  ) Values ('" . trim($recno) . "', '" . $row["chqno"] . "', '" . $_POST["dt"] . "', '" . $l_lmem . "', '" . $l_lmem . "', '" . $row["chqbank"] . "', " . $chqamt . ",'THT', 0 )";
                        //echo $sql;
                        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                        if ($result1 != 1) {
                            $sql_status = 26;
                        }
                    }
                }

                $sql1 = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($recno) . "', '" . $_SESSION["CURRENT_USER"] . "', 'Cash Reciept', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
                //echo $sql1;
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                if ($result1 != 1) {
                    $sql_status = 27;
                }

                //////////////////////////////////
                //include_once("connectioni.php");
                // echo $sql_status;
                if ($sql_status == 0) {

                    mysqli_query($GLOBALS['dbinv'], "COMMIT");
                    
                    $ResponseXML .= "<recno><![CDATA[" . $recno . "]]></recno>";
                    $ResponseXML .= "<msg_incom><![CDATA[0]]></msg_incom>";
                    //echo "Saved";
                } else {

                    mysqli_query($GLOBALS['dbinv'], "ROLLBACK");
                    
                    $ResponseXML .= "<msg_incom><![CDATA[Error has occured. Not Saved]]></msg_incom>";
                    //echo "Error has occured. Not Saved";
                }
            } else {
                $ResponseXML .= "<msg_incom><![CDATA[Incomplete Detail]]></msg_incom>";
            }

            $ResponseXML .= "<chq_rec_validity><![CDATA[yes]]></chq_rec_validity>";
            $ResponseXML .= "</salesdetails>";

            //$sql="delete from tmp_cash_chq where recno='".$recno."'";
            //$result =mysqli_query($GLOBALS['dbinv'],$sql) ;

            echo $ResponseXML;
        } else {

            $ResponseXML .= "<salesdetails>";
            $ResponseXML .= "<chq_rec_validity><![CDATA[no]]></chq_rec_validity>";
            $ResponseXML .= "</salesdetails>";
        }
    }
}
?>
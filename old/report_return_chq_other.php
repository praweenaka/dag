<?php session_start(); ?>
<?php date_default_timezone_set('Asia/Colombo'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Return Cheque Report</title>

        <style>
            table
            {
                border-collapse:collapse;
            }

            table, td, th
            {
                border:0px solid black;
                font-family:Arial, Helvetica, sans-serif;
                padding:5px;
            }

            th
            {
                font-weight:bold;
                font-size:12px;

            }
            td
            {
                font-size:12px;

            }
            .style1 {
                font-size: 16px;
                font-weight: bold;
                color: #FF0000;
            }
        </style>

    </head>

    <body>


        <p>
            <?php
            require_once("connectioni.php");








            if ($_GET["radio"] == "optout") {
                outrep();
            }
            if ($_GET["radio"] == "optreceipt") {
                receipt();
            }
            if ($_GET["radio"] == "optRetChk") {
                RTn();
            }
            if ($_GET["radio"] == "optRetChkreason") {
                RTnreason();
            }
            if ($_GET["radio"] == "optOverpay") { //Overpay();
            }
            if ($_GET["radio"] == "counterreturn") { //Overpay();
                countrtn();
            }

            //////////////////////
             function countrtn() {

                require_once("connectioni.php");



                if ($_GET["cmbdev"] == "ALL") {
                    $sysdiv = "A";
                }
                if ($_GET["cmbdev"] == "Computer") {
                    $sysdiv = "1";
                }
                if ($_GET["cmbdev"] == "Manual") {
                    $sysdiv = "0";
                }


                $txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

                $sql_head = "select * from invpara";
                $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
                $row_head = mysqli_fetch_array($result_head);


                $Text1 = "Counter Return Return Cheque    " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"]));



                echo "<table width=\"1000\" border=\"0\">
  <tr>
    <td colspan=\"6\">" . $Text1 . "</td>
  </tr>";

                echo " <tr>
    <td colspan=\"6\"><table width=\"1000\" border=\"1\">
      <tr>
        <td ><b>Date</b></td>
        <td ><b>Reo No</b></td>
        <td ><b>Rch No</b></td>
        <td ><b>Cheq. No</b></td>
        <td colspan='2'><b>Customer</b></td>
        <td ><b>Amount</b></td>
       
      </tr>";

                $CA_AMOUNT1 = 0;
                $CA_AMOUNT2 = 0;
                $CA_AMOUNT3 = 0;
                $CA_AMOUNT4 = 0;

                // $sql = "select  * from s_invcheq where   ch_count_ret='1' and che_date>='" . $_GET["dtfrom"] . "' and che_date<='" . $_GET["dtto"] . "' ";
//                 echo $sql;
                $sql = "select  * from s_cheq where dev!='" . $sysdiv . "' and ch_count_ret= '1' and  CR_FLAG='0' and CR_DATE>='" . $_GET["dtfrom"] . "' and CR_DATE<='" . $_GET["dtto"] . "' order by S_REF";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                while ($row = mysqli_fetch_array($result)) {
  

                    echo "<tr>
                    <td>" . $row["CR_DATE"] . "</td>
                    <td>" . $row["pdno"] . "</td>
                    <td>" . $row["CR_REFNO"] . "</td>
                    <td>" . $row["CR_CHNO"] . "</td>
                    <td>" . $row["CR_C_CODE"] . "</td>
                    <td>" . $row["CR_C_NAME"] . "</td>
                    <td align=right>" . number_format(($row["CR_CHEVAL"]), 2, ".", ",") . "</td> </tr>";

                    $CR_CHEVAL = $CR_CHEVAL + $row["CR_CHEVAL"] ;
                }


                echo "<tr>
                    <td colspan=6></td>";

                echo "<td align=right><b>" . number_format($CR_CHEVAL, 2, ".", ",") . "</b></td></tr>";

                echo "</table></td>
                    </tr>

                  </table>";
            }

            function RTn() {

                require_once("connectioni.php");



                if ($_GET["cmbdev"] == "ALL") {
                    $sysdiv = "A";
                }
                if ($_GET["cmbdev"] == "Computer") {
                    $sysdiv = "1";
                }
                if ($_GET["cmbdev"] == "Manual") {
                    $sysdiv = "0";
                }


                $txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

                $sql_head = "select * from invpara";
                $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
                $row_head = mysqli_fetch_array($result_head);


                $Text1 = "Return Cheque   " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"]));



                echo "<table width=\"1000\" border=\"0\">
                  <tr>
                    <td colspan=\"6\">" . $Text1 . "</td>
                  </tr>";

                                echo " <tr>
                    <td colspan=\"6\"><table width=\"1000\" border=\"1\">
                      <tr>
                        <td ><b>Date</b></td>
                        <td ><b>Refno</b></td>
                        <td ><b>Cheq. No</b></td>
                        <td colspan='2'><b>Customer</b></td>
                        <td ><b>Amount</b></td>
                       
                      </tr>";

                $CA_AMOUNT1 = 0;
                $CA_AMOUNT2 = 0;
                $CA_AMOUNT3 = 0;
                $CA_AMOUNT4 = 0;

                $sql = "select  * from s_cheq where dev!='" . $sysdiv . "' and  CR_FLAG='0' and CR_DATE>='" . $_GET["dtfrom"] . "' and CR_DATE<='" . $_GET["dtto"] . "' ";
//                 echo $sql;
                $color="";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                while ($row = mysqli_fetch_array($result)) {
                    if($row['ch_count_ret']=="1"){
                        $color="yellow";
                    }else{
                        $color="";
                    }
                $sql_ref = "select * from s_salrep where REPCODE='".$row["S_REF"]."'";
                $result_ref = mysqli_query($GLOBALS['dbinv'], $sql_ref);
                $row_ref = mysqli_fetch_array($result_ref);

                    echo "<tr style=\"background-color:$color\">
                    <td>" . $row["CR_DATE"] . "</td>
                    <td>" . $row["CR_REFNO"] . "</td>
                    <td>" . $row["CR_CHNO"] . "</td>
                    <td>" . $row["CR_C_CODE"] . "</td>
                    <td>" . $row["CR_C_NAME"] . "</td>
                      <td align=right>" . number_format(($row["CR_CHEVAL"]), 2, ".", ",") . "</td>";

                    echo "<td align=right>" . number_format(($row["CR_REPAY"]), 2, ".", ",") . "</td>";
                    echo "<td align=right>" . number_format(($row["CR_CHEVAL"] + $row["CR_REPAY"]), 2, ".", ",") . "</td>
<td>" . $row_ref["Name"] . "</td>
                    </tr>";

                    $CR_CHEVAL = $CR_CHEVAL + $row["CR_CHEVAL"] + $row["CR_REPAY"];
                }


                echo "<tr>
                    <td colspan=5></td>";

                            echo "<td align=right><b>" . number_format($CR_CHEVAL, 2, ".", ",") . "</b></td></tr>";

                            echo "</table></td>
              </tr>
             
            </table>";
            }

             function RTnreason() {

                require_once("connectioni.php");



                if ($_GET["cmbdev"] == "ALL") {
                    $sysdiv = "A";
                }
                if ($_GET["cmbdev"] == "Computer") {
                    $sysdiv = "1";
                }
                if ($_GET["cmbdev"] == "Manual") {
                    $sysdiv = "0";
                }


                $txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

                $sql_head = "select * from invpara";
                $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
                $row_head = mysqli_fetch_array($result_head);


                $Text1 = "Return Cheque With Reason without Counter Rtn   " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"]));



                echo "<table width=\"1000\" border=\"0\">
                  <tr>
                    <td colspan=\"6\">" . $Text1 . "</td>
                  </tr>";

                                echo " <tr>
                    <td colspan=\"6\"><table width=\"1000\" border=\"1\">
                      <tr> 
                        <td ><b>Cheq. No</b></td>
                        <td colspan='2'><b>Customer</b></td>
                        <td ><b>Amount</b></td>
                        <td ><b>Reason</b></td> 
                      </tr>";

                $CA_AMOUNT1 = 0;
                $CA_AMOUNT2 = 0;
                $CA_AMOUNT3 = 0;
                $CA_AMOUNT4 = 0;

                $sql = "select  * from s_cheq where dev!='" . $sysdiv . "' and ch_count_ret= '0' and  CR_FLAG='0' and CR_DATE>='" . $_GET["dtfrom"] . "' and CR_DATE<='" . $_GET["dtto"] . "' order by S_REF";
                 
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                while ($row = mysqli_fetch_array($result)) { 
                        $sql_rea = "select * from reason where reason_id ='".$row["reason"]."'";
                        $result_rea= mysqli_query($GLOBALS['dbinv'], $sql_rea);
                        $row_rea = mysqli_fetch_array($result_rea);

                        $sql_rep = "select * from s_salrep where REPCODE ='".$row["S_REF"]."'";
                        $result_rep= mysqli_query($GLOBALS['dbinv'], $sql_rep);
                        $row_rep = mysqli_fetch_array($result_rep);

                        if($date!=$row["CR_DATE"]){
                            echo "<tr>
                                <td><b>" . $row["CR_DATE"]. "</b></td> 
                            </tr>";
                        }
                        if($rep!=$row["S_REF"]){
                            echo "<tr>
                                <td><b>" . $row_rep["Name"]. "</b></td> 
                            </tr>";
                        }
                    echo "<tr>
                        <td>" . $row["CR_DATE"] . "</td> 
                        <td>" . $row["CR_CHNO"] . "</td> 
                        <td>" . $row["CR_C_CODE"] . "</td>
                        <td>" . $row["CR_C_NAME"] . "</td>
                        <td  >" . number_format(($row["CR_CHEVAL"]), 2, ".", ",") . "</td>
                        <td>" . $row_rea["short"] . "</td>";

                        $CR_CHEVAL = $CR_CHEVAL + $row["CR_CHEVAL"] ;
                         $rep=$row["S_REF"]; 
                         $date=$row["CR_DATE"]; 
                }

                echo "<tr>
                    <td colspan=3></td>";

                            echo "<td  ><b>" . number_format($CR_CHEVAL, 2, ".", ",") . "</b></td></tr>";

                            echo "</table></td>
              </tr>
             
            </table>";
            }

            function receipt() {

                require_once("connectioni.php");



                if ($_GET["cmbdev"] == "ALL") {
                    $sysdiv = "A";
                }
                if ($_GET["cmbdev"] == "Computer") {
                    $sysdiv = "1";
                }
                if ($_GET["cmbdev"] == "Manual") {
                    $sysdiv = "0";
                }


                $txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

                $sql_head = "select * from invpara";
                $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
                $row_head = mysqli_fetch_array($result_head);


                $Text1 = "Receipt  from   " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"]));



                echo "<table width=\"1000\" border=\"0\">
  <tr>
    <td colspan=\"6\">" . $Text1 . "</td>
  </tr>
  <tr>
    <td colspan=\"6\">Current Date - " . date("Y-m-d") . "</td>
  </tr>";

                echo " <tr>
    <td colspan=\"6\"><table width=\"1000\" border=\"1\">
      <tr>
        <td ><b>Refno</b></td>
        <td ><b>Date</b></td>
        <td ><b>Customer</b></td>
        <td align=right><b>Cash/Cheque</b></td>
        <td align=right><b>C/TT</b></td>
        <td align=right><b>RD</b></td>
        <td align=right><b>J/Entry</b></td>
        <td align=right><b>Total Amt</b></td>
      </tr>";

                $CA_AMOUNT1 = 0;
                $CA_AMOUNT2 = 0;
                $CA_AMOUNT3 = 0;
                $CA_AMOUNT4 = 0;

                $sql = "select  * from s_crec where DEV!='" . $sysdiv . "' and FLAG='RET' and CA_DATE>='" . $_GET["dtfrom"] . "' and CA_DATE<='" . $_GET["dtto"] . "' and CANCELL='0'";
                // echo $sql;
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>
        <td>" . $row["CA_REFNO"] . "</td>
        <td>" . $row["CA_DATE"] . "</td>
        <td>" . $row["CA_CODE"] . "</td>";

                    if (($row["pay_type"] == 'Cheque') or ( $row["pay_type"] == 'Cash')) {
                        echo "<td align=right>" . ($row["CA_AMOUNT"] + $row["overpay"]) . "</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>";
                        $CA_AMOUNT1 = $CA_AMOUNT1 + $row["CA_AMOUNT"] + $row["overpay"];
                    }

                    if ($row["pay_type"] == 'Cash TT') {
                        echo "<td>&nbsp;</td>
					<td align=right>" . ($row["CA_AMOUNT"] + $row["overpay"]) . "</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>";
                        $CA_AMOUNT2 = $CA_AMOUNT2 + $row["CA_AMOUNT"] + $row["overpay"];
                    }

                    if ($row["pay_type"] == 'R/Deposit') {
                        echo "<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align=right>" . ($row["CA_AMOUNT"] + $row["overpay"]) . "</td>
			<td>&nbsp;</td>";
                        $CA_AMOUNT3 = $CA_AMOUNT3 + $row["CA_AMOUNT"] + $row["overpay"];
                    }

                    if ($row["pay_type"] == 'J/Entry') {
                        echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=right>" . ($row["CA_AMOUNT"] + $row["overpay"]) . "</td>";
                        $CA_AMOUNT4 = $CA_AMOUNT4 + $row["CA_AMOUNT"] + $row["overpay"];
                    }

                    echo "
        <td align=right>" . ($row["CA_AMOUNT"] + $row["overpay"]) . "</td></tr>";

                    $CA_AMOUNT = $CA_AMOUNT + $row["CA_AMOUNT"] + $row["overpay"];
                }


                echo "<tr>
        <td colspan=3></td>";

                echo "<td align=right><b>" . $CA_AMOUNT1 . "</b></td>";
                echo "<td align=right><b>" . $CA_AMOUNT2 . "</b></td>";
                echo "<td align=right><b>" . $CA_AMOUNT3 . "</b></td>";
                echo "<td align=right><b>" . $CA_AMOUNT4 . "</b></td>";

                echo "<td align=right><b>" . ($CA_AMOUNT1 + $CA_AMOUNT2 + $CA_AMOUNT3 + $CA_AMOUNT4) . "</td>
        </tr>";



                echo "</table></td>
  </tr>
 
</table>";
            }

            function outrep() {

                require_once("connectioni.php");



                if ($_GET["cmbdev"] == "ALL") {
                    $sysdiv = "A";
                }
                if ($_GET["cmbdev"] == "Computer") {
                    $sysdiv = "1";
                }
                if ($_GET["cmbdev"] == "Manual") {
                    $sysdiv = "0";
                }


                $sql = "delete from tmpsttr";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);

                $sql = "select * from s_cheq where  dev!='" . $sysdiv . "' and  CR_FLAG='0' and CR_DATE<='" . $_GET["dtdate"] . "' and year(CR_DATE)>2011";
                //echo $sql;
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                while ($row = mysqli_fetch_array($result)) {
                    $paid = 0;
                    $sql_sttr = "select sum(ST_PAID) as paid from ch_sttr where ST_INVONO='" . trim($row["CR_REFNO"]) . "' and ST_DATE <='" . $_GET["dtdate"] . "' ";
                    $result_sttr = mysqli_query($GLOBALS['dbinv'], $sql_sttr);
                    $row_sttr = mysqli_fetch_array($result_sttr);

                    if (is_null($row_sttr["paid"]) == false) {
                        $paid = $row_sttr["paid"];
                    }

                    if ((($row["CR_CHEVAL"] + $row["CR_REPAY"]) - $paid) > 1) {
                        $sql_tmp[] = "('" . $row["CR_REFNO"] . "', '" . $row["CR_DATE"] . "','" . ($row["CR_CHEVAL"] + $row["CR_REPAY"]) . "' ," . $paid . ",'" . $row["CR_CHNO"] . "' ,'" . $row["CR_C_CODE"] . "','" . $row["CR_C_NAME"] . "','" . $row["S_REF"] . "')";
                    }
                }

                $sqli = "insert into tmpsttr (refno, sdate, cheVal, paid, che_no, code, cusname,rep) values  " . implode(",", $sql_tmp);
                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sqli);

                $txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

                $sql_head = "select * from invpara";
                $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
                $row_head = mysqli_fetch_array($result_head);





                $Text1 = "Return Cheque Outstanding As At " . date("Y-m-d", strtotime($_GET["dtdate"]));


                echo "<table width=\"1000\" border=\"0\">
  <tr>
    <td colspan=\"6\">" . $Text1 . "</td>
  </tr>
  <tr>
    <td colspan=\"6\">Current Date - " . date("Y-m-d") . "</td>
  </tr>
  <tr>
    <td colspan=\"6\"><table width=\"1000\" border=\"1\">
      <tr>
        <td ><b>Date</b></td>
        <td ><b>Refno</b></td>
        <td ><b>Che. No</b></td>
        <td ><b>Customer Code</b></td>
		<td ><b>Customer Name</b></td>
        <td align=right ><b>Amount</b></td>
        <td align=right ><b>Paid</b></td>
        <td align=right ><b>Balance</b></td>
        <td align=right ><b>Rep</b></td>
       
      </tr>";

                $balance = 0;
                $sql = "Select * from tmpsttr order by sdate";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>
                            <td>" . $row["sdate"] . "</td>
                            <td>" . $row["refno"] . "</td>
                            <td>" . $row["che_no"] . "</td>
                            <td>" . $row["code"] . "</td>
                            <td>" . $row["cusname"] . "</td>
                            <td align=right>" . $row["cheVal"] . "</td>
                            <td align=right>" . $row["paid"] . "</td>";

                    echo "<td align=right>" . ($row["cheVal"] - $row["paid"]) . "</td>
                        <td align=right>" . $row["rep"] . "</td>
                            
      </tr>";

                    $balance = $balance + ($row["cheVal"] - $row["paid"]);
                }

                echo "<tr>
        <td colspan=7></td>
        <td align=right><b>" . $balance . "</b></td>
               
      </tr>";




                echo "</table></td>
  </tr>
 
</table>";
            }
            ?> 
    </body>
</html>

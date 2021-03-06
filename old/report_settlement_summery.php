<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Settlement Summery Report</title>
        <style>
            body{
                font-family:Arial, Helvetica, sans-serif;
                font-size:14px;
            }
            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {
                border:0px solid black ;
                font-family:Arial, Helvetica, sans-serif;
                padding:5px;
            }
            th
            {
                font-weight:bold;
                font-size:12px;
                border-bottom:dotted 1px black;

            }
            td
            {
                font-size:12px;
            }
        </style>
        <style type="text/css">
            <!--
            .style1 {
                color: #0000FF;
                font-weight: bold;
                font-size: 24px;
            }
            -->
        </style>
    </head>

    <body>
        <!-- Progress bar holder -->


        <?php
        require_once("connectioni.php");




        if ($_GET["radio"] == "optret") {
            invReT();
        }
        if ($_GET["radio"] == "optinv") {
            invRec();
        }
        if ($_GET["radio"] == "op_sales") {
            inv_sales();
        }

        function inv_sales() {

            require_once("connectioni.php");



            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            $repcode = $_GET["cmbrep"];

            $sql_invpara = "select * from invpara";
            $result_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
            $row_invpara = mysqli_fetch_array($result_invpara);


            if ($_GET["cmbbrand"] == "All") {

                if ($_GET["chkcus"] == "on") {
                    if (trim($_GET["cmbrep"]) == "All") {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_salma_sttr where C_CODE= '" . trim($_GET["cuscode"]) . "'  and (SDATE >= '" . $_GET["dtfrom"] . "' and SDATE <='" . $_GET["dtto"] . "') order by salma_id";
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_salma_sttr where  C_CODE='" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "' or SDATE<'" . $_GET["dtto"] . "') and DiV1='1' order by salma_id";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_salma_sttr where  C_CODE='" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and DiV1='0' order by salma_id";
                        }
                    } else {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_salma_sttr where C_CODE='" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "' or SDATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $repcode . " order by salma_id ";
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_salma_sttr where  C_CODE='" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $repcode . " and DiV1='1' order by salma_id";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_salma_sttr where  C_CODE='" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "' or SDATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $repcode . " and DiV1='0' order by salma_id ";
                        }
                        $txtrep = "Sales Rep : " . trim($_GET["cmbrep"]);
                    }
                } else {
                    if (trim($_GET["cmbrep"]) == "All") {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_salma_sttr where (SDATE='" . $_GET["dtfrom"] . "' or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') order by salma_id ";
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_salma_sttr where (SDATE='" . $_GET["dtfrom"] . "' or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and DiV1='1' order by salma_id ";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_salma_sttr where (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and DiV1='0' order by salma_id ";
                        }
                    } else {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_salma_sttr where (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $repcode . " order by salma_id ";
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_salma_sttr where (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $repcode . " and DiV1='1' order by salma_id ";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_salma_sttr where (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $repcode . " and DiV1='0' order by salma_id ";
                        }
                        $txtrep = "Sales Rep : " + trim($_GET["cmbrep"]);
                    }
                }
            }
            if ($_GET["cmbbrand"] != "All") {
                if ($_GET["chkcus"] == "on") {
                    if (trim($_GET["cmbrep"]) == "All") {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_salma_sttr where Brand='" . $_GET["cmbbrand"] . "' and  C_CODE= '" . trim($_GET["cuscode"]) . "'  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "' or SDATE<'" . $_GET["dtto"] . "') order by salma_id ";
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_salma_sttr where  Brand='" . $_GET["cmbbrand"] . "' and  C_CODE='" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and DiV1='1' order by salma_id ";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_salma_sttr where  Brand='" . $_GET["cmbbrand"] . "' and  C_CODE='" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and DiV1='0' order by salma_id ";
                        }
                    } else {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_salma_sttr where  Brand='" . $_GET["cmbbrand"] . "' and C_CODE='" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $repcode . " order by salma_id ";
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_salma_sttr where  Brand='" . $_GET["cmbbrand"] . "' and  C_CODE='" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $repcode . " and DiV1='1' order by salma_id ";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_salma_sttr where  Brand='" . $_GET["cmbbrand"] . "' and  C_CODE='" . trim($_GET["cuscode"]) . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $repcode . " and DiV1='0' order by salma_id ";
                        }
                        $txtrep = "Sales Rep : " + trim($_GET["cmbrep"]);
                    }
                } else {
                    if (trim($_GET["cmbrep"]) == "All") {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_salma_sttr where Brand='" . $_GET["cmbbrand"] . "' and  (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') order by salma_id ";
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_salma_sttr where  Brand='" . $_GET["cmbbrand"] . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and DiV1='1' order by salma_id ";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_salma_sttr where  Brand='" . $_GET["cmbbrand"] . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and DiV1='0' order by salma_id ";
                        }
                    } else {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_salma_sttr where Brand='" . $_GET["cmbbrand"] . "' and  (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $repcode . " order by salma_id ";
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_salma_sttr where  Brand='" . $_GET["cmbbrand"] . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $repcode . " and DiV1='1' order by salma_id ";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_salma_sttr where  Brand='" . $_GET["cmbbrand"] . "' and (SDATE='" . $_GET["dtfrom"] . "'or SDATE>'" . $_GET["dtfrom"] . "') and  (SDATE='" . $_GET["dtto"] . "'or SDATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $repcode . " and DiV1='0' order by salma_id ";
                        }
                        $txtrep = "Sales Rep : " + trim($_GET["cmbrep"]);
                    }
                }
            }


            $txtcomname = $row_invpara["COMPANY"];

            $txtDATE = date("Y-m-d", strtotime($_GET["dtfrom"]));
            if ($_GET["chkcus"] == "on") {
                $txtcus = trim($_GET["cuscode"]);
            }

            if ($_GET["cmbdev"] == "All") {
                $txtdev = "S";
            }
            if ($_GET["cmbdev"] == "Manual") {
                $txtdev = "S-1";
            }
            if ($_GET["cmbdev"] == "Computer") {
                $txtdev = "S-2";
            }


            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $heading . "</center><br>";
            echo "<center>Daily Settlement Summery/Receipt Report<br>";
            echo "<center><br>";
            echo "<center>" . $_GET["dtfrom"];

            echo "<center><table border=1><tr>
		<th>Inv.Date</th>
		<th>Del.Date</th>
		<th>Inv.No</th>
		<th>Customer</th>
		<th>Inv.Amo</th>
		<th>Due.</th>
		<th width=150>Rec.No</th>
		<th>Che.No</th>
		<th>Che.Date</th>
		<th>Bank</th>
		<th>Days</th>
		<th>Approve Days</th>
		<th>Cash/Cash TT</th>
		<th>Cheque</th>
		<th>Uti/J.Entry</th>
		</tr>";
            //echo $sql;
            $totgross = 0;
            $totvat = 0;
            $totnet = 0;
            //echo $sql;



            $cash_tot = 0;
            $chk_tot = 0;
            $acc_tot = 0;
            $i = 0;

            //$sql=$sql." order by SDATE, ST_INVONO"; 
            //echo $sql;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {

                if ($row["ST_INVONO"] != "") {
                    if ($ST_INVONO != $row["ST_INVONO"]) {

                        if ($i == 1) {
                            echo "<tr><td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><b>" . $cash . "</b></td>
				<td><b>" . $chk . "</b></td>
				<td><b>" . $acc . "</b></td></tr>";
                            $i = 0;
                        }
                        if ($i == 0) {
                            $cash = 0;
                            $chk = 0;
                            $acc = 0;

                            echo "<tr>
				<td><b>" . $row["SDATE"] . "</b></td>
				<td><b>" . $row["Deli_date"] . "</b></td>
				<td><b>" . $row["ST_INVONO"] . "</b></td>
				<td><b>" . $row["C_CODE"] . " " . $row["CUS_NAME"] . "</b></td>
				<td align=\"right\"><b>" . $row["GRAND_TOT"] . "</b></td>";

                            $due = $row["GRAND_TOT"] - $row["TOTPAY"];
                            if (($due > 0) or ($due < 0)) {
                                echo "<td align=\"right\"><b>" . $due . "</b></td>";
                            } else {
                                echo "<td align=\"right\"></td>";
                            }

                            echo "<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td style='text-align: center'><b>" . $row["cre_pe"] . "</b></td>
				<td></td>
				<td></td></tr>";

                            $ST_INVONO = $row["ST_INVONO"];
                            $i = 1;
                        }

                        $totgross = $totgross + $row["GRAND_TOT"];
                        $totvat = $totvat + $vat;
                        $totnet = $totnet + $net;
                    }
                    $days = "";

                    if (!is_null($row["Deli_date"])) {
                        $date1 = $row["Deli_date"];
                    } else {
                        $date1 = $row["SDATE"];
                    }
                    if (!is_null($row["st_chdate"])) {
                        $date2 = $row["st_chdate"];
                    } else {
                        $date2 = $row["ST_DATE"];
                    }
                    $diff = abs(strtotime($date2) - strtotime($date1));
                    $days = floor($diff / (60 * 60 * 24));
                    if ($row["cre_pe"] < $days) {
                        echo "<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style='background-color:yellow'>" . $row["ST_REFNO"] . "</td>
			<td style='background-color:yellow'>" . $row["ST_CHNO"] . "</td>";
                        if ($row["st_chdate"] != "0000-00-00") {
                            echo "<td style='background-color:yellow'>" . $row["st_chdate"] . "</td>";
                        } else {
                            echo "<td></td>";
                        }
                        echo "<td style='background-color:yellow'>" . $row["st_chbank"] . "</td>";

                        $days = "";

                        if (!is_null($row["Deli_date"])) {
                            $date1 = $row["Deli_date"];
                        } else {
                            $date1 = $row["SDATE"];
                        }
                        if (!is_null($row["st_chdate"])) {
                            $date2 = $row["st_chdate"];
                        } else {
                            $date2 = $row["ST_DATE"];
                        }
                        $diff = abs(strtotime($date2) - strtotime($date1));
                        $days = floor($diff / (60 * 60 * 24));

                        echo "<td align=right style='background-color:yellow'>" . $days . "</td>";
                        echo "<td align=right></td>";

                        if ((($row["pay_type"] == 'Cash TT') or ($row["pay_type"] == 'C/TT') or ($row["ST_CHNO"] == 'Cash')) and ($row["pay_type"] != 'J/Entry')) {
                            echo "<td align=right>" . number_format($row["ST_PAID"], 2, ".", ",") . "</td>";
                            $cash = $cash + $row["ST_PAID"];
                        } else {
                            echo "<td></td>";
                        }

                        if (($row["ST_FLAG"] == 'CHK') and (($row["ST_CHNO"] != 'Cash TT') and ($row["ST_CHNO"] != 'Cash') and ($row["pay_type"] != 'J/Entry'))) {
                            echo "<td align=right>" . number_format($row["ST_PAID"], 2, ".", ",") . "</td>";
                            $chk = $chk + $row["ST_PAID"];
                        } else {
                            echo "<td></td>";
                        }



                        if (($row["ST_FLAG"] == 'UT') or ($row["pay_type"] == 'J/Entry')) {
                            echo "<td align=right>" . number_format($row["ST_PAID"], 2, ".", ",") . "</td>";
                            $acc = $acc + $row["ST_PAID"];
                        } else {
                            echo "<td></td>";
                        }
                    } else {
                        echo "<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>" . $row["ST_REFNO"] . "</td>
			<td>" . $row["ST_CHNO"] . "</td>";
                        if ($row["st_chdate"] != "0000-00-00") {
                            echo "<td>" . $row["st_chdate"] . "</td>";
                        } else {
                            echo "<td></td>";
                        }
                        echo "<td>" . $row["st_chbank"] . "</td>";

                        $days = "";

                        if (!is_null($row["Deli_date"])) {
                            $date1 = $row["Deli_date"];
                        } else {
                            $date1 = $row["SDATE"];
                        }
                        if (!is_null($row["st_chdate"])) {
                            $date2 = $row["st_chdate"];
                        } else {
                            $date2 = $row["ST_DATE"];
                        }
                        $diff = abs(strtotime($date2) - strtotime($date1));
                        $days = floor($diff / (60 * 60 * 24));

                        echo "<td align=right>" . $days . "</td>";
                        echo "<td align=right></td>";

                        if ((($row["pay_type"] == 'Cash TT') or ($row["pay_type"] == 'C/TT') or ($row["ST_CHNO"] == 'Cash')) and ($row["pay_type"] != 'J/Entry')) {
                            echo "<td align=right>" . number_format($row["ST_PAID"], 2, ".", ",") . "</td>";
                            $cash = $cash + $row["ST_PAID"];
                        } else {
                            echo "<td></td>";
                        }

                        if (($row["ST_FLAG"] == 'CHK') and (($row["ST_CHNO"] != 'Cash TT') and ($row["ST_CHNO"] != 'Cash') and ($row["pay_type"] != 'J/Entry'))) {
                            echo "<td align=right>" . number_format($row["ST_PAID"], 2, ".", ",") . "</td>";
                            $chk = $chk + $row["ST_PAID"];
                        } else {
                            echo "<td></td>";
                        }



                        if (($row["ST_FLAG"] == 'UT') or ($row["pay_type"] == 'J/Entry')) {
                            echo "<td align=right>" . number_format($row["ST_PAID"], 2, ".", ",") . "</td>";
                            $acc = $acc + $row["ST_PAID"];
                        } else {
                            echo "<td></td>";
                        }
                    }
                }


                echo "</tr>";
            }
            echo "<table>";
        }

        function invRec() {

            require_once("connectioni.php");



            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            $sql_invpara = "select * from invpara";
            $result_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
            $row_invpara = mysqli_fetch_array($result_invpara);



            if ($_GET["cmbbrand"] == "All") {
                if ($_GET["chkcus"] == "on") {

                    if (trim($_GET["cmbrep"]) == "All") {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_sttr where C_CODE= '" . trim($_GET["cuscode"]) . "'  and (ST_DATE='" . $_GET["dtfrom"] . "' or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "' or ST_DATE<'" . $_GET["dtto"] . "')";
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_sttr where  C_CODE='" . $_GET["cuscode"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and DEV='1'";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_sttr where  C_CODE='" . $_GET["cuscode"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and DEV='0'";
                        }
                    } else {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_sttr where C_CODE='" . $_GET["cuscode"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "' or ST_DATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $_GET["cmbrep"];
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_sttr where  C_CODE='" . $_GET["cuscode"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $_GET["cmbrep"] . " and DEV='1'";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_sttr where  C_CODE='" . $_GET["cuscode"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $_GET["cmbrep"] . " and DEV='0'";
                        }
                        $txtrep = "Sales Rep : " + trim($_GET["cmbrep"]);
                    }
                } else {
                    if (trim($_GET["cmbrep"]) == "All") {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_sttr where (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "')";
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_sttr where (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and DEV='1'";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_sttr where (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and DEV='0'";
                        }
                    } else {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_sttr where (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $_GET["cmbrep"];
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_sttr where (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $_GET["cmbrep"] . " and DEV='1'";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_sttr where (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $_GET["cmbrep"] . " and DEV='0'";
                        }
                        $txtrep = "Sales Rep : " + trim($_GET["cmbrep"]);
                    }
                }
            }
            if ($_GET["cmbbrand"] != "All") {
                if ($_GET["chkcus"] == "on") {
                    if (trim($_GET["cmbrep"]) == "All") {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_sttr where brand='" . $_GET["cmbbrand"] . "' and  C_CODE= '" . trim($_GET["cuscode"]) . "'  and (ST_DATE='" . $_GET["dtfrom"] . "' or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "' or ST_DATE<'" . $_GET["dtto"] . "')";
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_sttr where  brand='" . $_GET["cmbbrand"] . "' and  C_CODE='" . $_GET["cuscode"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and DEV='1'";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_sttr where  brand='" . $_GET["cmbbrand"] . "' and  C_CODE='" . $_GET["cuscode"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and DEV='0'";
                        }
                    } else {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_sttr where  brand='" . $_GET["cmbbrand"] . "' and C_CODE='" . $_GET["cuscode"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $_GET["cmbrep"] . "";
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_sttr where  brand='" . $_GET["cmbbrand"] . "' and  C_CODE='" . $_GET["cuscode"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $_GET["cmbrep"] . " and DEV='1'";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_sttr where  brand='" . $_GET["cmbbrand"] . "' and  C_CODE='" . $_GET["cuscode"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $_GET["cmbrep"] . " and DEV='0'";
                        }
                        $txtrep = "Sales Rep : " + trim($_GET["cmbrep"]);
                    }
                } else {
                    if (trim($_GET["cmbrep"]) == "All") {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_sttr where brand='" . $_GET["cmbbrand"] . "' and  (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "')";
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_sttr where  brand='" . $_GET["cmbbrand"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and DEV='1'";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_sttr where  brand='" . $_GET["cmbbrand"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and DEV='0'";
                        }
                    } else {
                        if ($_GET["cmbdev"] == "All") {
                            $sql = "SELECT * from view_sttr where brand='" . $_GET["cmbbrand"] . "' and  (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $_GET["cmbrep"] . "";
                        }
                        if ($_GET["cmbdev"] == "Manual") {
                            $sql = "SELECT * from view_sttr where  brand='" . $_GET["cmbbrand"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $_GET["cmbrep"] . " and DEV='1'";
                        }
                        if ($_GET["cmbdev"] == "Computer") {
                            $sql = "SELECT * from view_sttr where  brand='" . $_GET["cmbbrand"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') and SAL_EX = " . $_GET["cmbrep"] . " and DEV='0'";
                        }
                        $txtrep = "Sales Rep : " + trim($_GET["cmbrep"]);
                    }
                }
            }

////////////////////////////

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            $txtcomname = $row_head["COMPANY"];
            $txtDATE = date("Y-m-d", strtotime($_GET["dtfrom"]));

            if ($_GET["chkcus"] == "on") {
                $txtcus = $_GET["txt_cusname"];
            }

            if ($_GET["cmbdev"] == "All") {
                $txtdev = "S";
            }
            if ($_GET["cmbdev"] == "Manual") {
                $txtdev = "S-1";
            }
            if ($_GET["cmbdev"] == "Computer") {
                $txtdev = "S-2";
            }

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $heading . "</center><br>";
            echo "<center>Daily Settlement Summery/Receipt Report<br>";
            echo "<center><br>";
            echo "<center>" . $_GET["dtfrom"];

            echo "<center><table border=1><tr>";
            if ($_GET['chkdeli']) {
                echo "<th>Deli.Date</th>";
            } else {
                echo "<th>Inv.Date</th>";
            }
            echo "<th>Inv.No</th>
		<th>Customer</th>
		<th>Inv.Amo</th>
		<th>Due.</th>
		<th width=150>Rec.No</th>
		<th>Che.No</th>
		<th>Che.Date</th>
		<th>Bank</th>
		<th>Days</th>
		<th>Cash/Cash TT</th>
		<th>Cheque</th>
		<th>Uti/J.Entry</th>
		</tr>";
            //echo $sql;
            $totgross = 0;
            $totvat = 0;
            $totnet = 0;
            //echo $sql;



            $cash_tot = 0;
            $chk_tot = 0;
            $acc_tot = 0;
            $i = 0;
            $j = 0;

            $sql = $sql . " order by SDATE, ST_INVONO";
            //echo $sql;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {

                if ($ST_INVONO != $row["ST_INVONO"]) {

                    if ($i == 1) {
                        echo "<tr><th colspan=10></th>
				<th align=\"right\"><b>" . $cash . "</b></th>
				<th align=\"right\"><b>" . $chk . "</b></th>
				<th align=\"right\"><b>" . $acc . "</b></th></tr>";
                        $i = 0;
                    }
                    if ($i == 0) {
                        $cash = 0;
                        $chk = 0;
                        $acc = 0;
                        $sdate = $row["SDATE"];
                        if ($_GET['chkdeli']) {
                            if (is_null($row["deli_date"]) == false) {
                                $sdate = $row["deli_date"];
                            }
                        }
                        echo "<tr>
				<td>" . $sdate . "</td>
				<td>" . $row["ST_INVONO"] . "</td>
				<td>" . $row["C_CODE"] . " " . $row["CUS_NAME"] . "</td>
				<td align=\"right\">" . $row["GRAND_TOT"] . "</td>";

                        $due = $row["GRAND_TOT"] - $row["TOTPAY"];
                        if (($due > 0) or ($due < 0)) {
                            echo "<td align=\"right\">" . $due . "</td>";
                        } else {
                            echo "<td align=\"right\"></td>";
                        }

                        //echo "<td colspan=8></td>
                        //</tr>";

                        $ST_INVONO = $row["ST_INVONO"];
                        $i = 1;
                        $j = 0;
                    }

                    $totgross = $totgross + $row["GRAND_TOT"];
                    $totvat = $totvat + $vat;
                    $totnet = $totnet + $net;
                }

                if ($j != 0) {
                    echo "<tr>
			<td colspan=5></td>";
                } else {
                    $j = 1;
                }
                echo "<td>" . $row["ST_REFNO"] . "</td>
			<td>" . $row["ST_CHNO"] . "</td>";

                if ($row["ST_CHNO"] != "Cash TT") {
                    if ($row["st_chdate"] != "0000-00-00") {
                        echo "<td>" . $row["st_chdate"] . "</td>";
                        echo "<td>" . $row["st_chbank"] . "</td>";
                    } else {
                        echo "<td></td>";
                        echo "<td></td>";
                    }
                } else {
                    echo "<td>" . $row["st_chdate"] . "</td>";
                    echo "<td>" . $row["AC_REFNO"] . "</td>";
                }


                $days = "";
                if ((is_null($row["deli_date"]) == false) and ($row["st_chdate"] != "0000-00-00")) {
                    if (($row["st_chdate"] != "0000-00-00") and (is_null($row["st_chdate"]) == false)) {
                        //echo "1";
                        $date1 = $sdate;
                        $date2 = $row["st_chdate"];
                        $diff = abs(strtotime($date2) - strtotime($date1));
                        $days = floor($diff / (60 * 60 * 24));
                    } else {
                        //echo "2";
                        $sql1 = "Select * from s_utmas where C_REFNO='" . $row["ST_REFNO"] . "'";
                        //echo $sql1;
                        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                        $row1 = mysqli_fetch_array($result1);

                        $date1 = $sdate;
                        $date2 = $row1["C_DATE"];
                        $diff = abs(strtotime($date2) - strtotime($date1));
                        $days = floor($diff / (60 * 60 * 24));
                    }
                } else {
                    if (($row["st_chdate"] != "0000-00-00") and (is_null($row["st_chdate"]) == false)) {
                        //echo "3";
                        $date1 = $sdate;
                        $date2 = $row["st_chdate"];
                        $diff = abs(strtotime($date2) - strtotime($date1));
                        $days = floor($diff / (60 * 60 * 24));
                    } else {
                        //echo "4";
                        $sql1 = "Select * from s_utmas where C_REFNO='" . $row["ST_REFNO"] . "'";

                        $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                        $row1 = mysqli_fetch_array($result1);

                        $date1 = $sdate;
                        $date2 = $row1["C_DATE"];
                        $diff = abs(strtotime($date2) - strtotime($date1));
                        $days = floor($diff / (60 * 60 * 24));
                    }
                }
                echo "<td>" . $days . "</td>";

                if ((($row["pay_type"] == 'C/TT') or ($row["pay_type"] == 'Cash TT') or ($row["ST_CHNO"] == 'Cash')) and ($row["pay_type"] != 'J/Entry')) {
                    echo "<td align=\"right\">" . $row["ST_PAID"] . "</td>";
                    $cash = $cash + $row["ST_PAID"];
                } else {
                    echo "<td></td>";
                }

                if (($row["ST_FLAG"] == 'CHK') and ($row["ST_CHNO"] != 'Cash') and ($row["pay_type"] != 'J/Entry')) {
                    echo "<td align=\"right\">" . $row["ST_PAID"] . "</td>";
                    $chk = $chk + $row["ST_PAID"];
                } else {
                    echo "<td></td>";
                }



                if (($row["ST_FLAG"] == 'UT') or ($row["pay_type"] == 'J/Entry')) {
                    echo "<td align=\"right\">" . $row["ST_PAID"] . "</td>";
                    $acc = $acc + $row["ST_PAID"];
                } else {
                    echo "<td></td>";
                }




                echo "</tr>";
            }
            echo "<table>";
        }

        function invReT() {

            require_once("connectioni.php");



            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            $sql_invpara = "select * from invpara";
            $result_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
            $row_invpara = mysqli_fetch_array($result_invpara);

            if ($_GET["chkcus"] == "on") {
                if ($_GET["cmbrep"] == "All") {
                    $sql = "SELECT * from view_ch_sttr where CR_C_CODE = '" . trim($_GET["cuscode"]) . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "')  order by ST_DATE ";
                } else {
                    $sql = "SELECT * from view_ch_sttr where CR_C_CODE = '" . trim($_GET["cuscode"]) . "' and S_REF='" . $_GET["cmbrep"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "'or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "')  order by ST_DATE ";
                }
            } else {
                if ($_GET["cmbrep"] == "All") {
                    $sql = "SELECT * from view_ch_sttr where (ST_DATE='" . $_GET["dtfrom"] . "' or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') order by ST_DATE ";
                } else {
                    $sql = "SELECT * from view_ch_sttr where   S_REF='" . $_GET["cmbrep"] . "' and (ST_DATE='" . $_GET["dtfrom"] . "' or ST_DATE>'" . $_GET["dtfrom"] . "') and  (ST_DATE='" . $_GET["dtto"] . "'or ST_DATE<'" . $_GET["dtto"] . "') order by ST_DATE ";
                }
            }

            $txtcomname = $row_invpara["COMPANY"];
            $txtDATE = date("Y-m-d");
            $txtdev = "R";

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $heading . "</center><br>";
            echo "<center>Daily Settlement Summery/Receipt Report<br>";
            echo "<center>Return Cheque<br>";
            echo "<center>" . $_GET["dtfrom"];

            echo "<center><table border=1><tr>
		<th>Chq.Date</th>
		<th>Chq.No</th>
		<th>Customer</th>
		<th>Chq.Amo</th>
		<th>Due.</th>
		<th>Rec.No</th>
		<th>Rec.Date</th>
		<th>Che.No</th>
		<th>Che.Da</th>
		<th>Bank</th>
		<th>Days</th>
		<th>Cash/Cash TT</th>
		<th>Re Deposit</th>
		<th>Cheque</th>
		<th>Uti/J.Entry</th>
		</tr>";
            //echo $sql;
            $totgross = 0;
            $totvat = 0;
            $totnet = 0;


            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {

                if ($CR_REFNO != $row["CR_REFNO"]) {
                    echo "<tr>
			<td>" . $row["CR_CHDATE"] . "</td>
			<td>" . $row["CR_CHNO"] . "</td>
			<td>" . $row["CR_C_CODE"] . " " . $row["CR_C_NAME"] . "</td>
			<td align=\"right\">" . $row["CR_CHEVAL"] . "<br>" . $row["CR_REPAY"] . "</td>
			<td align=\"right\">" . ($row["CR_CHEVAL"] + $row["CR_REPAY"] - $row["PAID"]) . "</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>";


                    $totgross = $totgross + $row["GRAND_TOT"];
                    $totvat = $totvat + $vat;
                    $totnet = $totnet + $net;
                }
                $CR_REFNO = $row['CR_REFNO'];

                echo "<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>" . $row["ST_REFNO"] . "</td>
			<td>" . $row["ST_DATE"] . "</td>
			<td>" . $row["ST_CHNO"] . "</td>
			<td>" . $row["ST_CHEDATE"] . "</td>
			<td>" . $row["ST_CHBANK"] . "</td>
			<td>" . $row["ST_DAYS"] . "</td>";

                if ((trim($row["pay_type"]) == 'C/TT') or (trim($row["ST_CHNO"]) == 'Cash')) {
                    echo "<td>" . $row["ST_PAID"] . "</td>";
                } else {
                    echo "<td>0</td>";
                }

                if (trim($row["pay_type"]) == 'R/Deposit') {
                    echo "<td>" . $row["PAID"] . "</td>";
                } else {
                    echo "<td>0</td>";
                }

                if ((trim($row["pay_type"]) != 'R/Deposit') and (trim($row["ST_CHNO"]) != 'Cash') and (trim($row["pay_type"]) != 'J/Entry') and (trim($row["ST_FLAG"]) != 'UT')) {
                    echo "<td>" . $row["ST_PAID"] . "</td>";
                } else {
                    echo "<td>0</td>";
                }

                if ((trim($row["pay_type"]) == 'J/Entry') or (trim($row["ST_FLAG"]) == 'UT')) {
                    echo "<td>" . $row["ST_PAID"] . "</td>";
                } else {
                    echo "<td>0</td>";
                }


                echo "</tr>";
            }
            echo "<table>";
        }

        function dis_sales() {
            require_once("connectioni.php");



            if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                $sql = "SELECT * from view_s_invo where DIS_per=" . $_GET["txt_disper"] . " and    (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
            }
            if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                $sql = "SELECT * from view_s_invo where DIS_per=" . $_GET["txt_disper"] . " and    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
            }
            if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] = "optperiod")) {
                $sql = "SELECT * from view_s_invo where Brand_name='" . $_GET["CmbBrand"] . "' and DIS_per=" . $_GET["txt_disper"] . " and    (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
            }
            if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                $sql = "SELECT * from view_s_invo where Brand_name='" . $_GET["CmbBrand"] . "' and DIS_per=" . $_GET["txt_disper"] . " and    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
            }

            if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                $sql = "SELECT * from view_s_invo where Brand_name='" . $_GET["CmbBrand"] . "' and DIS_per=" . $_GET["txt_disper"] . " and    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and CANCELL='0'  order by SDATE";
            }
            if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                $sql = "SELECT * from view_s_invo where Brand_name='" . $_GET["CmbBrand"] . "' and DIS_per=" . $_GET["txt_disper"] . " and    (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and CANCELL='0'  order by SDATE";
            }

            if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                $sql = "SELECT * from view_s_invo where Brand_name='" . $_GET["CmbBrand"] . "' and DIS_per=" . $_GET["txt_disper"] . " and    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and  CANCELL='0'  order by SDATE";
            }
            if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                $sql = "SELECT * from view_s_invo where Brand_name='" . $_GET["CmbBrand"] . "' and DIS_per=" . $_GET["txt_disper"] . " and    (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and  CANCELL='0'  order by SDATE";
            }

            if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                $sql = "SELECT * from view_s_invo where DIS_per=" . $_GET["txt_disper"] . " and    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and CANCELL='0'  order by SDATE";
            }
            if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                $sql = "SELECT * from view_s_invo where  DIS_per=" . $_GET["txt_disper"] . " and    (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and CANCELL='0'  order by SDATE";
            }

            if (($_GET["radio"] == "optsales") and ($_GET["radio2"] == "optdaily")) {
                $heading = "Sales Summery Report(  " . $_GET["txt_disper"] . " % Discount)  On " . date("Y-m-d", strtotime($_GET['dtfrom']));
            }
            if (($_GET["radio"] == "optsales") and ($_GET["radio2"] == "optperiod")) {
                $heading = "Sales Summery Report   " . $_GET["txt_disper"] . " % Discount) From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
            }
            if (($_GET["radio"] == "optreturn") and ($_GET["radio2"] == "optdaily")) {
                $heading = "Sales Return Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom']));
            }
            if (($_GET["radio"] == "optreturn") and ($_GET["radio2"] == "optperiod")) {
                $heading = "Sales Return Summery Report From  " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
            }
        }

//////////// Scrap //////////////////////////////////////
        function printscrap() {
            require_once("connectioni.php");



            if ($_GET["radio"] == "optscrap") {
                if ($_GET["chk_svat"] != "on") {
                    if ($_GET["chkcus"] == "on") {
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] = "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by REF_NO";
                        }
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] = "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by id";
                        }
                    } else {
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0'  order by REF_NO";
                        }
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] = "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and CANCELL='0' order by id";
                        }
                    }
                } else {

                    if ($_GET["chkcus"] == "true") {
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and svat > '0'  order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and svat > '0' order by REF_NO";
                        }
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0'  order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and svat > '0' order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and svat > '0' order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and C_CODE='" . $_GET["cuscode"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by id";
                        }
                    } else {
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and svat > '0' order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' and svat > '0' order by id";
                        }
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by REF_NO";
                        }
                        if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by id";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and svat > '0' order by REF_NO";
                        }
                        if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                            $sql = "SELECT * from s_salma where Accname = 'NON STOCK' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')  and Brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and CANCELL='0' and svat > '0' order by id";
                        }
                    }
                }
            }

            if ($_GET["chk_discount"] == "on") {
                dis_sales();
            } else {
                if ($_GET["chk_svat"] != "on") {
                    if (($_GET["radio"] == "optsales") and ($_GET["radio2"] == "optdaily")) {
                        $heading = "Sales Summery Report with " . $_GET["txt_disper"] . " Discount On " . date("Y-m-d", strtotime($_GET['dtfrom']));
                    }
                    if (($_GET["radio"] == "optsales") and ($_GET["radio2"] == "optdaily")) {
                        $heading = "Sales Summery Report with" . $_GET["txt_disper"] . " Discount From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
                    }
                } else {
                    if (($_GET["radio"] == "optsales") and ($_GET["radio2"] == "optdaily")) {
                        $heading = "S.V.A.T. Sales Summery Report with" . $_GET["txt_disper"] . " Discount On " . date("Y-m-d", strtotime($_GET['dtfrom']));
                    }
                    if (($_GET["radio"] == "optsales") and ($_GET["radio2"] == "optdaily")) {
                        $heading = "S.V.A.T. Sales Summery Report with" . $_GET["txt_disper"] . " Discount From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
                    }
                }
                if (($_GET["radio"] == "optreturn") and ($_GET["radio2"] == "optdaily")) {
                    $heading = "Sales Return Summery Report with" . $_GET["txt_disper"] . " Discount On " . date("Y-m-d", strtotime($_GET['dtfrom']));
                }
                if (($_GET["radio"] == "optreturn") and ($_GET["radio2"] == "optdaily")) {
                    $heading = "Sales Return Summery Report with" . $_GET["txt_disper"] . " Discount From  " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
                }
            }



            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $heading . "</center><br>";

            echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Invoice No</th>
		<th>Customer</th>
		<th>Cr. Days</th>
		<th>Gross Amount</th>
		<th>VAT</th>
		<th>Net Amount</th>
		</tr>";
            //echo $sql;
            $totgross = 0;
            $totvat = 0;
            $totnet = 0;

            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td>" . $row["C_CODE"] . " " . $row["CUS_NAME"] . "</td>
			<td align=\"right\">" . $row["cre_pe"] . "</td>
			<td align=\"right\">" . number_format($row["GRAND_TOT"], 2, ".", ",") . "</td>";

                $net = $row["GRAND_TOT"] / (1 + ($row["GST"] / 100));
                $vat = $row["GRAND_TOT"] - $net;

                echo "<td align=\"right\">" . number_format($vat, 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($net, 2, ".", ",") . "</td>
			</tr>";

                $totgross = $totgross + $row["GRAND_TOT"];
                $totvat = $totvat + $vat;
                $totnet = $totnet + $net;
            }

            echo "<tr>
			<td colspan=4>" . $row["SDATE"] . "</td>
			
			<td align=\"right\"><b>" . number_format($totgross, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totvat, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totnet, 2, ".", ",") . "</b></td>
			</tr>";

            echo "<table>";
        }

        function Printret() {
            require_once("connectioni.php");



            if ($_GET["radio"] == "optreturn") {
                if ($_GET["chkcus"] == "on") {
                    if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "' and  trn_type!='ARN' and   trn_type!='INC' and   trn_type!='REC' and CUSCODE ='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'order by brand, id";
                    }
                    if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and   trn_type!='REC' and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and   trn_type!='ARN' and   trn_type!='INC' and CUSCODE ='" . $_GET["cuscode"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'   order by brand, id";
                    }
                    if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "' and  trn_type!='ARN' and   trn_type!='INC' and   trn_type!='REC' and brand='" . $_GET["CmbBrand"] . "' and CUSCODE ='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by brand, id";
                    }
                    if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and   trn_type!='REC' and  (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')and  trn_type!='ARN' and   trn_type!='INC' and brand='" . $_GET["CmbBrand"] . "' and CUSCODE ='" . $_GET["cuscode"] . "' order by brand, id";
                    }
                    if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "' and   trn_type!='ARN' and   trn_type!='REC' and trn_type!='INC' and sal_ex ='" . $_GET["cmbrep"] . "' and CUSCODE ='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by brand, id";
                    }
                    if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and   trn_type!='REC' and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and   trn_type!='ARN'  and  trn_type!='INC' and sal_ex ='" . $_GET["cmbrep"] . "' and CUSCODE ='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by brand, id";
                    }
                    if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "' and  trn_type!='ARN' and   trn_type!='REC' and   trn_type!='INC'and brand='" . $_GET["CmbBrand"] . "'and sal_ex =" . $_GET["cmbrep"] . " and CUSCODE ='" . $_GET["cuscode"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "' order by brand, id";
                    }
                    if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and   trn_type!='REC' and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and  trn_type!='ARN'  and  trn_type!='INC' and brand='" . $_GET["CmbBrand"] . "' and sal_ex ='" . $_GET["cmbrep"] . "' and CUSCODE ='" . $_GET["cuscode"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by brand, id";
                    }
                } else {
                    if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "' and  trn_type!='ARN' and   trn_type!='REC' and   trn_type!='INC' and DEV!='" . $GLOBALS[$sysdiv] . "' order by brand, id";
                    }
                    if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and  trn_type!='ARN' and   trn_type!='REC' and   trn_type!='INC' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by brand, id";
                    }
                    if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "'and  trn_type!='ARN' and   trn_type!='INC' and brand='" . $_GET["CmbBrand"] . "'and   trn_type!='REC' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by brand, id";
                    }
                    if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and   trn_type!='REC' and  trn_type!='ARN' and   trn_type!='INC' and brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by brand, id";
                    }
                    if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "'and  trn_type!='ARN' and    trn_type!='INC'and   trn_type!='REC' and sal_ex ='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'order by brand, id";
                    }
                    if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and  trn_type!='ARN' and   trn_type!='REC' and   trn_type!='INC' and sal_ex ='" . $_GET["cmbrep"] . " 'and DEV!='" . $GLOBALS[$sysdiv] . "' order by brand, id";
                    }
                    if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                        $sql = "SELECT * from viewreturn where SDATE='" . $_GET["dtfrom"] . "' and  trn_type!='ARN' and   trn_type!='INC' and brand='" . $_GET["CmbBrand"] . "' and    trn_type!='REC'AND  sal_ex =" . $_GET["cmbrep"] . "and DEV!='" . $GLOBALS[$sysdiv] . "' order by brand, id";
                    }
                    if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                        $sql = "SELECT * from viewreturn where (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')and   trn_type!='REC' and  trn_type!='ARN' and   trn_type!='INC' and brand='" . $_GET["CmbBrand"] . "'and sal_ex ='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by brand, id";
                    }
                }
            }

            if (($_GET["radio"] == "optsales") and ($_GET["radio2"] == "optdaily")) {
                $heading = "Sales Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom']));
            }
            if (($_GET["radio"] == "optsales") and ($_GET["radio2"] == "optperiod")) {
                $heading = "Sales Summery Report From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
            }
            if (($_GET["radio"] == "optreturn") and ($_GET["radio2"] == "optdaily")) {
                $heading = "Sales Return Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom']));
            }
            if (($_GET["radio"] == "optreturn") and ($_GET["radio2"] == "optperiod")) {
                $heading = "Sales Return Summery Report From  " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtfrom']));
            }
            $txtremark = "Sales By    " . $_GET["cmbrep"] . "   Brand  :  " . $_GET["CmbBrand"];

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $heading . "</center><br>";
            echo "<center>" . $txtremark . "</center><br>";

            echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Invoice No</th>
		<th>Customer</th>
		<th>Gross Amount</th>
		<th>VAT</th>
		<th>Net Amount</th>
		</tr>";
            //echo $sql;
            $i = 0;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {

                if ($row["brand"] != $brand) {
                    if ($i == 1) {
                        echo "<tr><td colspan=3>&nbsp;</td><td align=\"right\"><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($VAT_VAL, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($GRAND_TOT, 2, ".", ",") . "</b></td></tr>";
                        echo "<tr><td colspan=7 align=left><b>" . $row["brand"] . "</b></td></tr>";
                    } else {
                        echo "<tr><td colspan=7 align=left><b>" . $row["brand"] . "</b></td></tr>";
                        $i = 1;
                    }
                }

                $AMOUNT = $AMOUNT + $row["AMOUNT"];

                $grand = $row["AMOUNT"] / (1 + ($row["vatrate"] / 100 ));
                $GRAND_TOT = $GRAND_TOT + $grand;

                $vat = $row["AMOUNT"] - $grand;
                $VAT_VAL = $VAT_VAL + $vat;

                echo "<tr>
				<td>" . $row["SDATE"] . "</td>
				<td>" . $row["REFNO"] . "</td>";
                $sql_cus = "Select * from vendor where CODE='" . $row["CUSCODE"] . "'";
                $result_cus = mysqli_query($GLOBALS['dbinv'], $sql_cus);
                $row_cus = mysqli_fetch_array($result_cus);

                echo "<td>" . $row["CUSCODE"] . " " . $row_cus["NAME"] . "</td>
				<td align=\"right\">" . number_format($row["AMOUNT"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($vat, 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($grand, 2, ".", ",") . "</td>
				</tr>";
                $brand = $row["brand"];
            }

            echo "<table>";
        }

        function grnsummery() {

            require_once("connectioni.php");



            if ($_GET["chk_svat"] != "on") {
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "') and (SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and    trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and Brand='" . $_GET["CmbBrand"] . "' ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "') and (SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'";
                }

                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                }

                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "') and (SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "') and (SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'";
                }

                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "') and (SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "') and (SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                }
            } else {
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn_svat where CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "') and (SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0'";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn_svat where  CUSCODE='" . $_GET["cuscode"] . "' and    trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0'";
                }

                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn_svat where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn_svat where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where  CUSCODE='" . $_GET["cuscode"] . "' and   trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0'";
                }

                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0'";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0'";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] = "optdaily")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and SVAT > '0' ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn_svat where trn_type='GRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and SVAT > '0' ";
                }
            }

            if (($_GET["radio"] == "optsales") and ($_GET["radio2"] == "optdaily")) {
                $rtxtdate = "Sales Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom'])) . "   Brand  :   " . $_GET["CmbBrand"];
            }
            if (($_GET["radio"] == "optsales") and ($_GET["radio2"] == "optperiod")) {
                $rtxtdate = "Sales Summery Report From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto'])) . "   Brand  :   " . $_GET["CmbBrand"];
            }
            if (($_GET["radio"] == "optreturn") and ($_GET["radio2"] == "optdaily")) {
                $rtxtdate = "Sales Return Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom'])) . "   Brand  :   " . $_GET["CmbBrand"];
            }
            if (($_GET["radio"] == "optreturn") and ($_GET["radio2"] = "optperiod")) {
                $rtxtdate = "Sales Return Summery Report From  " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto'])) . "   Brand  :   " . $_GET["CmbBrand"];
            }

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $rtxtdate . "</center><br>";

            echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Ref No</th>
		<th>Customer</th>
		<th>Gross Amount</th>
		<th>VAT</th>
		<th>Net Amount</th>
		</tr>";

            $strsql = $strsql . " order by brand";
            //echo $strsql;
            $br = "";
            $AMOUNT = 0;
            $SVAT = 0;
            $BALANCE = 0;

            $status = 0;

            $result = mysqli_query($GLOBALS['dbinv'], $strsql);
            while ($row = mysqli_fetch_array($result)) {
                if ($br != $row["brand"]) {
                    if ($status != 0) {
                        echo "<tr>
					<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=right><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td><td><b>" . number_format($SVAT, 2, ".", ",") . "</b></td><td align=right><b>" . number_format($BALANCE, 2, ".", ",") . "</b></td>
					</tr>";
                    }

                    echo "<tr>
				<td colspan=\"6\" align=\"left\"><b>" . $row["brand"] . "</b></td>
				</tr>";
                    $br = $row["brand"];
                    $AMOUNT = 0;
                    $SVAT = 0;
                    $BALANCE = 0;

                    $status = 1;
                }
                echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REFNO"] . "</td>
			<td>" . $row["CUSCODE"] . " " . $row["NAME"] . "</td>
			<td align=\"right\">" . number_format($row["AMOUNT"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["SVAT"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["BALANCE"], 2, ".", ",") . "</td>
			</tr>";

                $AMOUNT = $AMOUNT + $row["AMOUNT"];
                $SVAT = $$SVAT + $row["SVAT"];
                $BALANCE = $BALANCE + $row["BALANCE"];
            }

            echo "<tr>
				<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($SVAT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($BALANCE, 2, ".", ",") . "</b></td>
				</tr>";

            echo "<table>";
        }

//////
        function crnsummery() {
            require_once("connectioni.php");



            if ($_GET["chk_cash"] != "on") {
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and(trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (Sdate='" . $_GET["dtfrom"] . "' or Sdate >'" . $_GET["dtfrom"] . "')and(Sdate='" . $_GET["dtto"] . "' or Sdate < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }

                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (Sdate='" . $_GET["dtfrom"] . "' or Sdate >'" . $_GET["dtfrom"] . "')and(Sdate='" . $_GET["dtto"] . "' or Sdate < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by refno";
                }
            } else {

                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and flag1 = '1' order by refno ";
                }

                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  CUSCODE='" . $_GET["cuscode"] . "' and(trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and (trn_type='CNT' OR  trn_type='INC')  and (Sdate='" . $_GET["dtfrom"] . "' or Sdate >'" . $_GET["dtfrom"] . "')and(Sdate='" . $_GET["dtto"] . "' or Sdate < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }

                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and flag1 = '1' order by refno ";
                }

                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC') and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where (trn_type='CNT' OR  trn_type='INC')  and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
                if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                    $strsql = "select * from viewreturn where  (trn_type='CNT' OR  trn_type='INC')  and (Sdate='" . $_GET["dtfrom"] . "' or Sdate >'" . $_GET["dtfrom"] . "')and(Sdate='" . $_GET["dtto"] . "' or Sdate < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' and flag1 = '1' order by refno ";
                }
            }

            if (($_GET["radio"] == "optsales") and ($_GET["radio2"] == "optdaily")) {
                $rtxtdate = "Sales Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom']));
            }
            if (($_GET["radio"] == "optsales") and ($_GET["radio2"] == "optperiod")) {
                $rtxtdate = "Sales Summery Report From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto'])) . "   Brand  :   " . $_GET["CmbBrand"];
            }
            if (($_GET["radio"] == "optreturn") and ($_GET["radio2"] == "optdaily")) {
                $rtxtdate = "Sales Return Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom'])) . "   Brand  :   " . $_GET["CmbBrand"];
            }
            if (($_GET["radio"] == "optreturn") and ($_GET["radio2"] == "optperiod")) {
                $rtxtdate = "Sales Return Summery Report From  " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto'])) . "   Brand  :   " . $_GET["CmbBrand"];
            }

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $rtxtdate . "</center><br>";

            echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Ref No</th>
		<th>Customer</th>
		<th>Gross Amount</th>
		<th>VAT</th>
		<th>Net Amount</th>
		</tr>";

            //$strsql=$strsql." order by brand";
            //echo $strsql;
            $br = "";
            $AMOUNT = 0;
            $SVAT = 0;
            $BALANCE = 0;

            $status = 0;

            $result = mysqli_query($GLOBALS['dbinv'], $strsql);
            while ($row = mysqli_fetch_array($result)) {
                if ($br != $row["brand"]) {
                    if ($status != 0) {
                        echo "<tr>
					<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=right><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td><td><b>" . number_format($SVAT, 2, ".", ",") . "</b></td><td align=right><b>" . number_format($BALANCE, 2, ".", ",") . "</b></td>
					</tr>";
                    }

                    echo "<tr>
				<td colspan=\"6\" align=\"left\"><b>" . $row["brand"] . "</b></td>
				</tr>";
                    $br = $row["brand"];
                    $AMOUNT = 0;
                    $SVAT = 0;
                    $BALANCE = 0;

                    $status = 1;
                }
                echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REFNO"] . "</td>
			<td>" . $row["CUSCODE"] . " " . $row["NAME"] . "</td>
			<td align=\"right\">" . number_format($row["AMOUNT"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["SVAT"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["BALANCE"], 2, ".", ",") . "</td>
			</tr>";

                $AMOUNT = $AMOUNT + $row["AMOUNT"];
                $SVAT = $$SVAT + $row["SVAT"];
                $BALANCE = $BALANCE + $row["BALANCE"];
            }

            echo "<tr>
				<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($SVAT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($BALANCE, 2, ".", ",") . "</b></td>
				</tr>";

            echo "<table>";
        }

        function Dgrnsummery() {
            require_once("connectioni.php");



            if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by REFNO";
            }
            if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' order by REFNO";
            }
            if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
            }
            if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
            }

            if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
            }
            if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
            }
            if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
            }
            if (($_GET["chkcus"] == "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where CUSCODE='" . $_GET["cuscode"] . "' and trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
            }

            if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "' order by REFNO";
            }
            if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or  SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "')and DEV!='" . $GLOBALS[$sysdiv] . "' order by REFNO";
            }
            if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
            }
            if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
            }

            if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
            }
            if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
            }
            if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
            }
            if (($_GET["chkcus"] != "on") and ($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                $strsql = "select * from viewreturn where trn_type='DGRN' and (SDATE='" . $_GET["dtfrom"] . "' or SDATE >'" . $_GET["dtfrom"] . "')and(SDATE='" . $_GET["dtto"] . "' or SDATE < '" . $_GET["dtto"] . "') and brand='" . $_GET["CmbBrand"] . "' and SAL_EX='" . $_GET["cmbrep"] . "'and DEV!='" . $GLOBALS[$sysdiv] . "'  order by REFNO";
            }


            if ($_GET["radio2"] == "optdaily") {
                $rtxtdate = "Defective Item Report  On         " . date("Y-m-d", strtotime($_GET['dtfrom'])) . "   Rep :    " . $_GET["cmbrep"] . "   Brand  :   " . $_GET["CmbBrand"];
            }
            if ($_GET["radio2"] == "optperiod") {
                $rtxtdate = "Defective Item Report  From      " . date("Y-m-d", strtotime($_GET['dtfrom'])) . "   To   " . date("Y-m-d", strtotime($_GET['dtto'])) . "   Rep : " . $_GET["cmbrep"] . "   Brand  :  " . $_GET["CmbBrand"];
            }

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $rtxtdate . "</center><br>";

            echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Ref No</th>
		<th>Customer</th>
		<th>Gross Amount</th>
		<th>VAT</th>
		<th>Net Amount</th>
		</tr>";

            //$strsql=$strsql." order by brand";
            //echo $strsql;
            $br = "";
            $AMOUNT = 0;
            $SVAT = 0;
            $BALANCE = 0;

            $status = 0;

            $result = mysqli_query($GLOBALS['dbinv'], $strsql);
            while ($row = mysqli_fetch_array($result)) {
                if ($br != $row["brand"]) {
                    if ($status != 0) {
                        echo "<tr>
					<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=right><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td><td><b>" . number_format($SVAT, 2, ".", ",") . "</b></td><td align=right><b>" . number_format($BALANCE, 2, ".", ",") . "</b></td>
					</tr>";
                    }

                    echo "<tr>
				<td colspan=\"6\" align=\"left\"><b>" . $row["brand"] . "</b></td>
				</tr>";
                    $br = $row["brand"];
                    $AMOUNT = 0;
                    $SVAT = 0;
                    $BALANCE = 0;

                    $status = 1;
                }
                echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REFNO"] . "</td>
			<td>" . $row["CUSCODE"] . " " . $row["NAME"] . "</td>
			<td align=\"right\">" . number_format($row["AMOUNT"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["SVAT"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["BALANCE"], 2, ".", ",") . "</td>
			</tr>";

                $AMOUNT = $AMOUNT + $row["AMOUNT"];
                $SVAT = $$SVAT + $row["SVAT"];
                $BALANCE = $BALANCE + $row["BALANCE"];
            }

            echo "<tr>
				<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($SVAT, 2, ".", ",") . "</b></td><td align=\"right\"><b>" . number_format($BALANCE, 2, ".", ",") . "</b></td>
				</tr>";

            echo "<table>";
        }

        function recieptrep() {
            require_once("connectioni.php");



            $sql = "delete from tmpreceipt ";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);

            if ($_GET["cmbRECtype"] == "Ret.ch") {
                $rettype = "RET";
            }
            if ($_GET["cmbRECtype"] == "Normal") {
                $rettype = "REC";
            }
            if ($_GET["chkcus"] != "on") {
                if ($_GET["cmbretchktype"] == "All") {
                    if (($_GET["radio2"] == "optdaily") and ($_GET["cmbRECtype"] == "All")) {
                        $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' order by CA_REFNO ";
                    }
                    if (($_GET["radio2"] == "optperiod") and ($_GET["cmbRECtype"] == "All")) {
                        $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' order by CA_REFNO";
                    }

                    if (($_GET["radio2"] == "optdaily") and ($_GET["cmbRECtype"] != "All")) {
                        $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and  CANCELL='0' order by CA_REFNO ";
                    }

                    if (($_GET["radio2"] == "optperiod") and ($_GET["cmbRECtype"] != "All")) {
                        $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and  CANCELL='0' order by CA_REFNO ";
                    }
                } else {

                    if (($_GET["radio2"] == "optdaily") and ($_GET["cmbRECtype"] == "All")) {
                        $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $_GET["cmbretchktype"] . "' and  CANCELL='0' order by CA_REFNO ";
                    }
                    if (($_GET["radio2"] == "optperiod") and ($_GET["cmbRECtype"] == "All")) {
                        $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' ) and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $_GET["cmbretchktype"] . "' and  CANCELL='0' order by CA_REFNO";
                    }

                    if (($_GET["radio2"] == "optdaily") and ($_GET["cmbRECtype"] != "All")) {
                        $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and pay_type='" . $_GET["cmbretchktype"] . "' and  CANCELL='0' order by CA_REFNO";
                    }
                    if (($_GET["radio2"] == "optperiod") and ($_GET["cmbRECtype"] != "All")) {
                        $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and pay_type='" . $_GET["cmbretchktype"] . "' and  CANCELL='0' order by CA_REFNO";
                    }
                }
            }

            if ($_GET["chkcus"] == "on") {
                if ($_GET["cmbretchktype"] == "All") {
                    if (($_GET["radio2"] == "optdaily") and ($_GET["cmbRECtype"] == "All")) {
                        $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO ";
                    }
                    if (($_GET["radio2"] == "optperiod") and ($_GET["cmbRECtype"] == "All")) {
                        $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO";
                    }

                    if (($_GET["radio2"] == "optdaily") and ($_GET["cmbRECtype"] != "All")) {
                        $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO ";
                    }
                    if (($_GET["radio2"] == "optperiod") and ($_GET["cmbRECtype"] != "All")) {
                        $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO ";
                    }
                } else {

                    if (($_GET["radio2"] == "optdaily") and ($_GET["cmbRECtype"] == "All")) {
                        $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $_GET["cmbretchktype"] . "'and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO";
                    }
                    if (($_GET["radio2"] == "optperiod") and ($_GET["cmbRECtype"] == "All")) {
                        $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and pay_type='" . $_GET["cmbretchktype"] . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO ";
                    }

                    if (($_GET["radio2"] == "optdaily") and ($_GET["cmbRECtype"] != "All")) {
                        $rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "'and pay_type='" . $_GET["cmbretchktype"] . "' and  CANCELL='0' and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO ";
                    }
                    if (($_GET["radio2"] == "optperiod") and ($_GET["cmbRECtype"] != "All")) {
                        $rct = "select * from s_crec where (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and flag ='" . $rettype . "' and pay_type='" . $_GET["cmbretchktype"] . "' and  CANCELL='0'and CA_CODE='" . trim($_GET["cuscode"]) . "' order by CA_REFNO";
                    }
                }
            }
            $tota = 0;
            //echo $rct;
            $result_rct = mysqli_query($GLOBALS['dbinv'], $rct);
            while ($row_rct = mysqli_fetch_array($result_rct)) {
                if ($row_rct["CA_CASSH"] > 0) {

                    if (trim($row_rct["pay_type"]) == "Cheque") {
                        $ptype = "Cash";
                    } else {
                        $ptype = trim($row_rct["pay_type"]);
                    }

                    $sql = "insert into tmpreceipt(REF_NO, CUS_REF, ptype, SDATE, cash, DEPARTMENT) values ('" . $row_rct["CA_REFNO"] . "', '" . $row_rct["CUS_REF"] . "', '" . $ptype . "', '" . $row_rct["CA_DATE"] . "', '" . $row_rct["CA_CASSH"] . "', '" . $row_rct["DEPARTMENT"] . "')";
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    $tota = tota + $row_rct["CA_CASSH"];
                }

                $sql_invch = "select * from s_invcheq where refno='" . $row_rct["CA_REFNO"] . "'";
                $result_invch = mysqli_query($GLOBALS['dbinv'], $sql_invch);
                while ($row_invch = mysqli_fetch_array($result_invch)) {
                    $sql_tmpCh = "select * from tmpreceipt where ch_no='" . trim($row_invch["cheque_no"]) . "' and branch='" . trim($row_invch["bank"]) . "'";
                    $result_tmpCh = mysqli_query($GLOBALS['dbinv'], $sql_tmpCh);
                    if ($row_tmpCh = mysqli_fetch_array($result_tmpCh)) {
                        
                    } else {
                        $chQty = $chQty + 1;
                    }
                    $sql = "insert into tmpreceipt(REF_NO, SDATE, ch_date, ch_no, ch_amount, bank, branch, DEPARTMENT) values ('" . $row_rct["CA_REFNO"] . "', '" . $row_rct["CA_DATE"] . "', '" . $row_invch["che_date"] . "', '" . $row_invch["cheque_no"] . "', '" . $row_invch["che_amount"] . "', '" . $row_invch["cus_code"] . "', '" . $row_invch["bank"] . "', '" . $row_invch["department"] . "')";
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);
                    $tota = $tota + $row_invch["che_amount"];
                }
            }


            if ($_GET["radio2"] == "optdaily") {
                $rtxtdate = "Receipt Summery Report On " . date("Y-m-d", strtotime($_GET['dtfrom']));
            }
            if ($_GET["radio2"] == "optperiod") {
                $rtxtdate = "Receipt Summery Report From " . date("Y-m-d", strtotime($_GET['dtfrom'])) . " To " . date("Y-m-d", strtotime($_GET['dtto']));
            }
            if ($_GET["cmbRECtype"] == "Ret.ch") {
                $txtrectype = "Return Cheque";
            }
            if ($_GET["cmbRECtype"] == "Normal") {
                $txtrectype = "Invoice";
            }
            if ($_GET["cmbRECtype"] == "All") {
                $txtrectype = "All";
            }
            if ($_GET["chkcus"] == "on") {
                $txtcus = "Customer    " . $_GET["cuscode"] . "    " . $_GET["txt_cusname"];
            }


            if ($_GET["cmbretchktype"] == "All") {

                if ($_GET["chkcus"] != "on") {

                    if (($_GET["radio2"] == "optdaily") and ($_GET["cmbRECtype"] == "All")) {

                        $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV !='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque')  ";

                        $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";

                        $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";

                        $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT')  ";

                        $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='J/Entry')  ";

                        $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='R/Deposit')  ";
                    }

                    if (($_GET["radio2"] == "optperiod") and ($_GET["cmbRECtype"] == "All")) {
                        $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque') ";
                        $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";
                        $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";
                        $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT') ";
                        $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "') and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='J/Entry') ";
                        $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='R/Deposit')";
                    }

                    if (($_GET["radio2"] == "optdaily") and ($_GET["cmbRECtype"] != "All")) {
                        $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque')  ";

                        $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";

                        $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";

                        $sql_tt = "select sum(CA_AMOUNT) as ttamo  from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT')  ";

                        $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='J/Entry')  ";

                        $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='R/Deposit') ";
                    }

                    if (($_GET["radio2"] == "optperiod") and ($_GET["cmbRECtype"] != "All")) {

                        $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0'and (pay_type='Cash' or pay_type='Cheque') ";

                        $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";

                        $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";

                        $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT') ";

                        $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='J/Entry') ";

                        $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='R/Deposit') ";
                    }
                }

                if ($_GET["chkcus"] == "on") {

                    if (($_GET["radio2"] == "optdaily") and ($_GET["cmbRECtype"] == "All")) {
                        $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                        $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";

                        $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";

                        $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                        $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='J/Entry') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                        $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='R/Deposit')  and CA_CODE='" . trim($_GET["cuscode"]) . "'";
                    }

                    if (($_GET["radio2"] == "optperiod") and ($_GET["cmbRECtype"] == "All")) {
                        $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                        $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";

                        $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";

                        $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                        $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='J/Entry') and CA_CODE='" . trim($_GET["cuscode"]) . "'  ";

                        $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and  CANCELL='0' and (pay_type='R/Deposit') and CA_CODE='" . trim($_GET["cuscode"]) . "'";
                    }

                    if (($_GET["radio2"] == "optdaily") and ($_GET["cmbRECtype"] != "All")) {
                        $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='Cash' or pay_type='Cheque') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                        $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";

                        $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";

                        $sql_tt = "select sum(CA_AMOUNT) as ttamo  from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT')  and CA_CODE='" . trim($_GET["cuscode"]) . "'";
                        $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='J/Entry')  and CA_CODE='" . trim($_GET["cuscode"]) . "'";
                        $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "' and  CANCELL='0' and (pay_type='R/Deposit') and CA_CODE='" . trim($_GET["cuscode"]) . "'";
                    }

                    if (($_GET["radio2"] == "optperiod") and ($_GET["cmbRECtype"] != "All")) {
                        $sql_ch = "select sum(CA_AMOUNT) as chamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0'and (pay_type='Cash' or pay_type='Cheque') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                        $sql_ch1 = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'O'  ";

                        $sql_ch_sc = "select sum(ch_amount) as chamo from tmpreceipt where DEPARTMENT = 'S'  ";

                        $sql_tt = "select sum(CA_AMOUNT) as ttamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='C/TT' or pay_type='Cash TT')  and CA_CODE='" . trim($_GET["cuscode"]) . "'";

                        $sql_jn = "select sum(CA_AMOUNT) as jnamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='J/Entry') and CA_CODE='" . trim($_GET["cuscode"]) . "' ";

                        $sql_re = "select sum(CA_AMOUNT) as reamo from s_crec where DEPARTMENT = 'O' and  (CA_DATE='" . $_GET["dtfrom"] . "' or CA_DATE>'" . $_GET["dtfrom"] . "' )and (CA_DATE='" . $_GET["dtto"] . "' or CA_DATE<'" . $_GET["dtto"] . "'  ) and DEV!='" . $GLOBALS[$sysdiv] . "' and FLAG ='" . $rettype . "'and  CANCELL='0' and (pay_type='R/Deposit')  and CA_CODE='" . trim($_GET["cuscode"]) . "' ";
                    }
                }


                $result_ch = mysqli_query($GLOBALS['dbinv'], $sql_ch);
                $row_ch = mysqli_fetch_array($result_ch);

                $result_ch1 = mysqli_query($GLOBALS['dbinv'], $sql_ch1);
                $row_ch1 = mysqli_fetch_array($result_ch1);

                $result_ch_sc = mysqli_query($GLOBALS['dbinv'], $sql_ch_sc);
                $row_ch_sc = mysqli_fetch_array($result_ch_sc);

                $result_tt = mysqli_query($GLOBALS['dbinv'], $sql_tt);
                $row_tt = mysqli_fetch_array($result_tt);

                $result_jn = mysqli_query($GLOBALS['dbinv'], $sql_jn);
                $row_jn = mysqli_fetch_array($result_jn);

                $result_re = mysqli_query($GLOBALS['dbinv'], $sql_re);
                $row_re = mysqli_fetch_array($result_re);

                if (is_null($row_ch["chamo"]) == false) {
                    $CHA = $row_ch["chamo"];
                } else {
                    $CHA = 0;
                }

                if (is_null($row_ch["chamo"]) == false) {
                    $CHA1 = $row_ch1["chamo"];
                } else {
                    $CHA1 = 0;
                }

                if (is_null($row_ch_sc["chamo"]) == false) {
                    $CHA_SC = $row_ch_sc["chamo"];
                } else {
                    $CHA_SC = 0;
                }

                if (is_null($row_tt["ttamo"]) == false) {
                    $TTA = $row_tt["ttamo"];
                } else {
                    $TTA = 0;
                }

                if (is_null($row_jn["jnamo"]) == false) {
                    $JNA = $row_jn["jnamo"];
                } else {
                    $JNA = 0;
                }

                if (is_null($row_re["reamo"]) == false) {
                    $REA = $row_re["reamo"];
                } else {
                    $REA = 0;
                }




                $rtxcash = number_format($CHA1 - $REA, 2, ".", ",");
                $rtxscchq = number_format($CHA_SC, 2, ".", ",");
                $rtxtt = number_format($TTA, 2, ".", ",");
                $rtxj = number_format($JNA, 2, ".", ",");
                $rtxre = number_format($REA, 2, ".", ",");
                $txttot = number_format($CHA + $TTA + $JNA + $REA, 2, ".", ",");
            }


            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";



            echo "<center>" . $rtxtdate . "</center><br>";
            echo "<center>" . $txtrectype . "</center><br>";
            echo "<center>" . $txtcus . "</center><br>";

            echo "<center><table border=1><tr>
		<th>Date</th>
		<th>Ref No</th>
		<th>Cash</th>
		<th>Cash TT</th>
		<th>J/Entry</th>
		<th>Cheque No</th>
		<th>Cheque Date</th>
		<th>Amount</th>
		<th>Scrap</th>
		</tr>";
            //echo $sql;

            $totcash = 0;
            $totjentry = 0;
            $tottt = 0;

            $sql = "select * from tmpreceipt  order by SDATE,id";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {

                if (($row["DEPARTMENT"] == "O") and (($row["ptype"] == "Cash TT") or ($row["ptype"] == "C/TT"))) {

                    echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td align=\"right\"></td>
			<td align=\"right\">" . number_format($row["cash"], 2, ".", ",") . "</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			</tr>";
                    $tottt = $tottt + $row["cash"];
                } else if (($row["DEPARTMENT"] == "O") and ($row["ptype"] == "J/Entry")) {

                    echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\">" . number_format($row["cash"], 2, ".", ",") . "</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			</tr>";
                    $totjentry = $totjentry + $row["cash"];
                } else if (($row["DEPARTMENT"] == "S") and (trim($row["ptype"]) == "Cash")) {
                    echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\">" . number_format($row["cash"], 2, ".", ",") . "</td>
			</tr>";
                    $totcrap = $totcrap + $row["cash"];
                } else if (($row["DEPARTMENT"] == "O") and (trim($row["ptype"]) == "Cash")) {

                    echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td align=\"right\">" . number_format($row["cash"], 2, ".", ",") . "</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			</tr>";

                    $totcash = $totcash + $row["cash"];
                } else {

                    echo "<tr>
			<td>" . $row["SDATE"] . "</td>
			<td>" . $row["REF_NO"] . "</td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\">" . $row["ch_no"] . "</td>
			<td align=\"right\">" . $row["ch_date"] . "</td>
			<td align=\"right\">" . $row["ch_amount"] . "</td>
			<td align=\"right\"></td>
			</tr>";
                    $ch_amount = $ch_amount + $row["ch_amount"];
                }
            }

            echo "<tr>
			<td colspan=2></td>
			<td align=\"right\"><b>" . number_format($totcash, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($tottt, 2, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($totjentry, 2, ".", ",") . "</b></td>
			<td align=\"right\"></td>
			<td align=\"right\"></td>
			<td align=\"right\">" . number_format($ch_amount, 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($totcrap, 2, ".", ",") . "</td>
			</tr>";

            echo "<table>";

            echo "<br><br>";

            echo "<table border=1 width=700>
		<tr><td><b>Normal</b></td><td>&nbsp;</td><td>&nbsp;</td><td><b>Scrap</b></td><td>&nbsp;</td></tr>
		<tr><td>Cheque</td><td align=right>" . $rtxcash . "</td><td>&nbsp;</td><td><b>Cheque</b></td><td align=right>" . $rtxscchq . "</td></tr>
		<tr><td><b>Cash</b></td><td align=right>" . number_format($totcash, 2, ".", ",") . "</td><td>&nbsp;</td><td><b>Cash</b></td><td align=right>" . number_format($totcrap, 2, ".", ",") . "</td></tr>
		<tr><td><b>J/Entry</b></td><td align=right>" . number_format($totjentry, 2, ".", ",") . "</td><td>&nbsp;</td><td><b>&nbsp;</b></td><td>&nbsp;</td></tr>
		<tr><td><b>Cash TT</b></td><td align=right>" . number_format($tottt, 2, ".", ",") . "</td><td>&nbsp;</td><td><b>&nbsp;</b></td><td>&nbsp;</td></tr>
		<tr><td><b>Redeposit</b></td><td align=right>" . $rtxre . "</td><td>&nbsp;</td><td><b>&nbsp;</b></td><td>&nbsp;</td></tr>
		<tr><td><b>Total</b></td><td align=right>" . $txttot . "</td><td>&nbsp;</td><td><b>&nbsp;</b></td><td>&nbsp;</td></tr>
		</table>";
        }

        function summeryrep() {
            require_once("connectioni.php");



            $totGrosaleVatamt = 0;
            $VatGdRetAmt = 0;
            $VATnetSaleAmt = 0;

            if ($_GET["cmbdev"] == "All") {
                $dev = "All";
            }
            if ($_GET["cmbdev"] == "Manual") {
                $dev = "0";
            }
            if ($_GET["cmbdev"] == "Computer") {
                $dev = "1";
            }

            $TotGroSale = 0;
            $VATgroSale = 0;
            $NVATatgross = 0;

            $totsvatgrosale = 0;
            $SVATgrosale = 0;
            $totgrosaleSVATamou = 0;
            $SVATgdRet = 0;
            $SVATret = 0;
            $SVATNetSale = 0;
            $SVATAmount = 0;
            $NonSvatNet = 0;

            $Totsalret = 0;
            $VATGdRet = 0;
            $NvaGdRet = 0;

            $TotNetSale = 0;
            $VATnetSale = 0;
            $NonVatNet = 0;

            if ($_GET["radio2"] == "optdaily") {
                $sql_sale = "select * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and DEV!='" . $dev . "' and CANCELL='0' ";
            }
            if ($_GET["radio2"] == "optperiod") {
                $sql_sale = "select * from s_salma where Accname != 'NON STOCK' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and DEV!='" . $dev . "' and CANCELL='0'";
            }

            $result_sale = mysqli_query($GLOBALS['dbinv'], $sql_sale);
            while ($row_sale = mysqli_fetch_array($result_sale)) {

                $TotGroSale = $TotGroSale + $row_sale["GRAND_TOT"];
                if ($row_sale["DEV"] == "0") {

                    $totGrosaleVatamt = $totGrosaleVatamt + $row_sale["GRAND_TOT"] * ($row_sale["GST"] / 100) / (1 + ($row_sale["GST"] / 100));
                } else {

                    $totGrosaleVatamt = $totGrosaleVatamt + $row_sale["GRAND_TOT"] * ($row_sale["GST"] / 100) / (1 + ($row_sale["GST"] / 100));
                }

                if ($row_sale["SVAT"] > 0) {
                    $totsvatgrosale = $totsvatgrosale + $row_sale["GRAND_TOT"];
                    if ($row_sale["DEV"] == "0") {

                        $totgrosaleSVATamou = $totgrosaleSVATamou + $row_sale["GRAND_TOT"] * ($row_sale["GST"] / 100) / (1 + ($row_sale["GST"] / 100));
                    } else {

                        $totgrosaleSVATamou = $totgrosaleSVATamou + $row_sale["GRAND_TOT"] * ($row_sale["GST"] / 100) / (1 + ($row_sale["GST"] / 100));
                    }
                }
            }


            if ($_GET["radio2"] == "optdaily") {
                $sql_c_bal = "select * from c_bal where SDATE='" . $_GET["dtfrom"] . "' AND trn_type!='ARN' and  trn_type!='INC' and trn_type!='REC'  and DEV!='" . $dev . "' ";
            }
            if ($_GET["radio2"] == "optperiod") {
                $sql_c_bal = "select * from c_bal where ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )AND trn_type!='ARN' and trn_type!='REC' and trn_type!='INC'  and DEV!='" . $dev . "'";
            }

            $result_c_bal = mysqli_query($GLOBALS['dbinv'], $sql_c_bal);
            while ($row_c_bal = mysqli_fetch_array($result_c_bal)) {

                $TotGdRet = $TotGdRet + $row_c_bal["AMOUNT"];

                $sql_crnma = "Select * From s_crnma where REF_NO = '" . $row_c_bal["REFNO"] . "'";
                $result_crnma = mysqli_query($GLOBALS['dbinv'], $sql_crnma);
                if ($row_crnma = mysqli_fetch_array($result_crnma)) {
                    $sql_salma = " Select * from s_salma where Accname != 'NON STOCK' and REF_NO = '" . $row_crnma["INVOICENO"] . "' ";
                    $result_salma = mysqli_query($GLOBALS['dbinv'], $sql_salma);
                    if ($row_salma = mysqli_fetch_array($result_salma)) {
                        if ($row_salma["SVAT"] > 0) {
                            $SVATgdRet = $SVATgdRet + $row_c_bal["AMOUNT"] * ($row_c_bal["vatrate"] / 100) / (1 + ($row_c_bal["vatrate"] / 100));
                            $SVATret = $SVATret + $row_c_bal["AMOUNT"];
                        }
                    }
                }

                if ($row_c_bal["DEV"] == "0") {

                    $VatGdRetAmt = $VatGdRetAmt + $row_c_bal["AMOUNT"] * ($row_c_bal["vatrate"] / 100) / (1 + ($row_c_bal["vatrate"] / 100));
                } else {

                    $VatGdRetAmt = $VatGdRetAmt + $row_c_bal["AMOUNT"] * ($row_c_bal["vatrate"] / 100) / (1 + ($row_c_bal["vatrate"] / 100));
                }
            }

            if ($_GET["radio2"] == "optdaily") {
                $sql_rct = "select * from s_crec where CA_DATE='" . $_GET["dtfrom"] . "' and DEV!='" . $dev . "' and CANCELL='0' and FLAG='REC' and DEPARTMENT = 'O' ";
            }
            if ($_GET["radio2"] == "optperiod") {
                $sql_rct = "select * from s_crec where ( CA_DATE='" . $_GET["dtfrom"] . "' OR  CA_DATE>'" . $_GET["dtfrom"] . "' ) AND ( CA_DATE='" . $_GET["dtto"] . "'  OR  CA_DATE<'" . $_GET["dtto"] . "' ) and DEV!='" . $dev . "' and CANCELL='0' and FLAG='REC' and department = 'O' ";
            }
            $result_rct = mysqli_query($GLOBALS['dbinv'], $sql_rct);
            while ($row_rct = mysqli_fetch_array($result_rct)) {

                $RctAmount = $RctAmount + $row_rct["CA_AMOUNT"];
                if (is_null($row_rct["overpay"]) == false) {
                    $OVpAYMENT = $OVpAYMENT + $row_rct["overpay"];
                }
            }

            $VATgroSale = $totGrosaleVatamt;
            $VATGdRet = $VatGdRetAmt;
            $TotNetSale = $TotGroSale - $TotGdRet;
            $VATnetSale = $totGrosaleVatamt - $VatGdRetAmt;
            $NonVatNet = $TotNetSale - $VATnetSale;

            $SVATgrosale = $totgrosaleSVATamou;
            $SVATgdRet = $SVATgdRet;
            $SVATNetSale = $totsvatgrosale - $SVATret;
            $SVATAmount = $totgrosaleSVATamou - $SVATgdRet;
            $NonSvatNet = $SVATNetSale - $SVATAmount;


            if ($_GET["radio2"] == "optdaily") {
                $rtxtdate = "Sales Report On " . date("Y-m-d", strtotime($_GET["dtfrom"]));
            }
            if ($_GET["radio2"] == "optperiod") {
                $rtxtdate = "Sales Report  From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"]));
            }
            $Text1 = number_format($TotGroSale, 2, ".", ",");
            $Text2 = number_format($VATgroSale, 2, ".", ",");

            $Text3 = number_format($TotGdRet, 2, ".", ",");
            $Text4 = number_format($VATGdRet, 2, ".", ",");
            $Text5 = number_format($TotNetSale, 2, ".", ",");
            $Text6 = number_format($VATnetSale, 2, ".", ",");
            $Text7 = number_format($NonVatNet, 2, ".", ",");
            $Text8 = number_format($RctAmount, 2, ".", ",");
            $txtoverpay = number_format($OVpAYMENT, 2, ".", ",");
            $txtRecTot = number_format($RctAmount - $OVpAYMENT, 2, ".", ",");


            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $rtxtdate . "</center><br>";

            echo "<center><table border=1 width=500>
		<tr><td>Total Sale</td><td align=right>" . number_format($TotGroSale, 2, ".", ",") . "</td><tr>
		<tr><td>VAT/SVAT on Sales</td><td align=right>" . number_format($VATgroSale, 2, ".", ",") . "</td><tr>
		<tr><td colspan=2>&nbsp;</td><tr>
		<tr><td>Total Good Return</td><td align=right>" . number_format($TotGdRet, 2, ".", ",") . "</td><tr>
		<tr><td>VAT/SVAT on Goods Returns</td><td align=right>" . number_format($VATGdRet, 2, ".", ",") . "</td><tr>
		<tr><td colspan=2>&nbsp;</td><tr>
		<tr><td>Total Gross Sales</td><td align=right>" . number_format($TotNetSale, 2, ".", ",") . "</td><tr>
		<tr><td>VAT/SVAT On Gross Sales</td><td align=right>" . number_format($VATnetSale, 2, ".", ",") . "</td><tr>
		<tr><td colspan=2>&nbsp;</td><tr>
		<tr><td>Net  Sales (Without VAT/SVAT)</td><td align=right>" . number_format($NonVatNet, 2, ".", ",") . "</td><tr>
		<tr><td>Receipt Summery(Settlement)</td><td align=right>" . number_format($RctAmount, 2, ".", ",") . "</td><tr>
		<tr><td>Over Payment</td><td align=right>" . $txtoverpay . "</td><tr>
		<tr><td>Receipt Total</td><td align=right>" . $txtRecTot . "</td><tr>
	
		
		<table>";

            if ($_GET["cmbdev"] == "Computer") {


                //=============================== VAT ======================================================
                $Text45 = number_format($TotGroSale - $totsvatgrosale, 2, ".", ",");
                $Text46 = number_format($VATgroSale - $SVATgrosale, 2, ".", ",");
                $Text47 = number_format($TotGdRet - $SVATret, 2, ".", ",");
                $Text48 = number_format($VATGdRet - $SVATgdRet, 2, ".", ",");
                $Text49 = number_format($TotNetSale - $SVATNetSale, 2, ".", ",");
                $Text50 = number_format($VATnetSale - $SVATAmount, 2, ".", ",");
                $Text51 = number_format($NonVatNet - $NonSvatNet, 2, ".", ",");

                echo "<br><b>VAT SALE</b><br>";
                echo "<center><table border=1  width=500>
		<tr><td>Total Sales</td><td align=right>" . $Text45 . "</td><tr>
		<tr><td>VAT On Sales</td><td align=right>" . $Text46 . "</td><tr>
		<tr><td colspan=2>&nbsp;</td><tr>
		<tr><td>Total Goods Returns</td><td align=right>" . $Text47 . "</td><tr>
		<tr><td>VAT on Goods  Returns</td><td align=right>" . $Text48 . "</td><tr>
		<tr><td colspan=2>&nbsp;</td><tr>
		<tr><td>Total Gross Sales</td><td align=right>" . $Text49 . "</td><tr>
		<tr><td>VAT On Gross Sales</td><td align=right>" . $Text50 . "</td><tr>
		<tr><td colspan=2>&nbsp;</td><tr>
		<tr><td>Net  Sales (Without VAT)</td><td align=right>" . $Text51 . "</td><tr>
		
		<table>";

                //=============================== SVAT =====================================================
                $Text67 = number_format($totsvatgrosale, 2, ".", ",");
                $Text68 = number_format($SVATgrosale, 2, ".", ",");
                $Text69 = number_format($SVATret, 2, ".", ",");
                $Text70 = number_format($SVATgdRet, 2, ".", ",");
                $Text71 = number_format($SVATNetSale, 2, ".", ",");
                $Text72 = number_format($SVATAmount, 2, ".", ",");
                $Text73 = number_format($NonSvatNet, 2, ".", ",");

                echo "<br><b>SVAT SALE</b><br>";
                echo "<center><table border=1  width=500>
		<tr><td>Total Sales</td><td align=right>" . $Text67 . "</td><tr>
		<tr><td>SVAT On Sales</td><td align=right>" . $Text68 . "</td><tr>
		<tr><td colspan=2>&nbsp;</td><tr>
		<tr><td>Total Goods Returns</td><td align=right>" . $Text69 . "</td><tr>
		<tr><td>SVAT on Goods  Returns</td><td align=right>" . $Text70 . "</td><tr>
		<tr><td colspan=2>&nbsp;</td><tr>
		<tr><td>Total Gross Sales</td><td align=right>" . $Text71 . "</td><tr>
		<tr><td>SVAT On Gross Sales</td><td align=right>" . $Text72 . "</td><tr>
		<tr><td colspan=2>&nbsp;</td><tr>
		<tr><td>Net  Sales (Without SVAT)</td><td align=right>" . $Text73 . "</td><tr>
		
		<table>";
            } else {
                
            }
        }

        function summerysprte() {
            require_once("connectioni.php");



            $sql = "delete from tmptotbrandsale";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);


            $sql_brand = "select * from brand_mas";
            $result_brand = mysqli_query($GLOBALS['dbinv'], $sql_brand);
            while ($row_brand = mysqli_fetch_array($result_brand)) {
                $TotGroSaleAmt = 0;
                $TotGdRetAmt = 0;

                if ($_GET["chkcus"] == "on") {
                    if ($_GET["cmbrep"] == "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            $sql_sale = "select * from s_salma where Accname != 'NON STOCK' and C_CODE ='" . trim($_GET["cuscode"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
                        }
                        if ($_GET["radio2"] == "optperiod") {
                            $sql_sale = "select * from s_salma where Accname != 'NON STOCK' and c_code ='" . trim($_GET["cuscode"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
                        }
                    }

                    if ($_GET["cmbrep"] != "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            $sql_sale = "select * from s_salma where Accname != 'NON STOCK' and c_code ='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and  SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
                        }

                        if ($_GET["radio2"] == "optperiod") {
                            $sql_sale = "select * from s_salma where Accname != 'NON STOCK' and c_code ='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
                        }
                    }
                }

                if ($_GET["chkcus"] != "on") {
                    if ($_GET["cmbrep"] == "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            $sql_sale = "select * from s_salma where Accname != 'NON STOCK' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
                        }

                        if ($_GET["radio2"] == "optperiod") {
                            $sql_sale = "select * from s_salma where Accname != 'NON STOCK' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . trim($row_brand["barnd_name"]) . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
                        }
                    }

                    if ($_GET["cmbrep"] != "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            $sql_sale = "select * from s_salma where Accname != 'NON STOCK' and sal_ex='" . trim($_GET["cmbrep"]) . "' and  SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "' and CANCELL='0' ";
                        }

                        if ($_GET["radio2"] == "optperiod") {
                            $sql_sale = "select * from s_salma where Accname != 'NON STOCK' and sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "' and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  ";
                        }
                    }
                }

                $result_sale = mysqli_query($GLOBALS['dbinv'], $sql_sale);
                while ($row_sale = mysqli_fetch_array($result_sale)) {

                    $TotGroSale = $TotGroSale + $row_sale["GRAND_TOT"];
                    $TotGroSaleAmt = $TotGroSaleAmt + ($row_sale["GRAND_TOT"] / (1 + ($row_sale["GST"] / 100)));
                }

                if ($_GET["chkcus"] == "on") {

                    if ($_GET["cmbrep"] == "All") {
                        if ($_GET["radio2"] = "optdaily") {
                            $sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["cuscode"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "' AND trn_type!='ARN' AND trn_type!='INC' and trn_type!='REC' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }

                        if ($_GET["radio2"] == "optperiod") {
                            $sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["cuscode"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC'and trn_type!='REC'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }
                    }

                    if ($_GET["cmbrep"] != "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            $sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC' and trn_type!='REC' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }

                        if ($_GET["radio2"] == "optperiod") {
                            $sql_c_bal = "select * from c_bal where cuscode='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC'and trn_type!='REC'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }
                    }
                }

                if ($_GET["chkcus"] != "on") {
                    if ($_GET["cmbrep"] == "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            $sql_c_bal = "select * from c_bal where SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC' and trn_type!='REC' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }

                        if ($_GET["radio2"] == "optperiod") {
                            $sql_c_bal = "select * from c_bal where ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC'and trn_type!='REC'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }
                    }

                    if ($_GET["cmbrep"] != "All") {
                        if ($_GET["radio2"] == "optdaily") {
                            $sql_c_bal = "select * from c_bal where sal_ex='" . trim($_GET["cmbrep"]) . "' and SDATE='" . $_GET["dtfrom"] . "' and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC' and trn_type!='REC' and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }
                        if ($_GET["radio2"] == "optperiod") {
                            $sql_c_bal = "select * from c_bal where sal_ex='" . trim($_GET["cmbrep"]) . "' and ( SDATE='" . $_GET["dtfrom"] . "' OR  SDATE>'" . $_GET["dtfrom"] . "' ) AND ( SDATE='" . $_GET["dtto"] . "'  OR  SDATE<'" . $_GET["dtto"] . "' )and brand='" . $row_brand["barnd_name"] . "'AND trn_type!='ARN' AND trn_type!='INC'and trn_type!='REC'  and DEV!='" . $GLOBALS[$sysdiv] . "' ";
                        }
                    }
                }

                $result_c_bal = mysqli_query($GLOBALS['dbinv'], $sql_c_bal);
                while ($row_c_bal = mysqli_fetch_array($result_c_bal)) {

                    $TotGdRet = $TotGdRet + $row_c_bal["AMOUNT"];
                    $TotGdRetAmt = TotGdRetAmt + ($row_c_bal["AMOUNT"] / (1 + ($row_c_bal["vatrate"] / 100)));
                }

                $nett = ($TotGroSaleAmt - $TotGdRetAmt);

                if ($nett > 0) {
                    $sql_tmp = "insert into tmptotbrandsale(brand, gross, grn, nett) values ('" . trim($row_brand["barnd_name"]) . "', " . $TotGroSale . ", " . $TotGdRet . ", " . $nett . ")";
                    $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
                }
                $TotGdRet = 0;
                $TotGroSale = 0;
            }

            if ($_GET["radio2"] == "optdaily") {
                $rtxtdate = "Total Sales  On " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "Rep   :" . $_GET["cmbrep"];
            }
            if ($_GET["radio2"] == "optperiod") {
                $rtxtdate = "Total Sales  From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"])) . " Rep   :" . $_GET["cmbrep"];
            }


            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $heading . "</center><br>";

            echo "<center><table border=1><tr>
		<th>Brand</th>
		<th>Gross</th>
		<th>GRN</th>
		<th>Net</th>
		</tr>";
            //echo $sql;
            $sql = "select * from tmptotbrandsale";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>
			<td>" . $row["brand"] . "</td>
			<td align=\"right\">" . number_format($row["gross"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["grn"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["nett"], 2, ".", ",") . "</td>
			</tr>";
            }

            echo "<table>";
        }

        function item_sales() {
            require_once("connectioni.php");



            if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                $sql = "SELECT * from view_s_invo where     (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
            }

            if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                $sql = "SELECT * from view_s_invo where    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
            }

            if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optperiod")) {
                $sql = "SELECT * from view_s_invo where     (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
            }

            if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] == "All") and ($_GET["radio2"] == "optdaily")) {
                $sql = "SELECT * from view_s_invo where    SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
            }

            if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                $sql = "SELECT * from view_s_invo where BRAND='" . $_GET["CmbBrand"] . "' and     (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
            }

            if (($_GET["cmbrep"] == "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                $sql = "SELECT * from view_s_invo where brand='" . $_GET["CmbBrand"] . "' and     SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0'  order by SDATE";
            }

            if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optperiod")) {
                $sql = "SELECT * from view_s_invo where  brand='" . $_GET["CmbBrand"] . "' and     (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
            }

            if (($_GET["cmbrep"] != "All") and ($_GET["CmbBrand"] != "All") and ($_GET["radio2"] == "optdaily")) {
                $sql = "SELECT * from view_s_invo where   brand='" . $_GET["CmbBrand"] . "' and   SDATE='" . $_GET["dtfrom"] . "'  and DEV!='" . $GLOBALS[$sysdiv] . "'and CANCELL='0' and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE";
            }

            if (($_GET["radio"] == "optitem") and ($_GET["radio2"] == "optdaily")) {
                $rtxtdate = "Item Sales Summery Report  On " . date("Y-m-d", strtotime($_GET["dtfrom"]));
            }

            if (($_GET["radio"] == "optitem") and ($_GET["radio2"] == "optperiod")) {
                $rtxtdate = "Item Sales Summery Report    From " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"]));
            }


            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $rtxtdate . "</center><br>";

            echo "<center><table border=1><tr>
		<th></th>
		<th></th>
		<th></th>
		<th>Type</th>
		<th></th>
		<th></th>
		<th></th>
		<th>Rep</th>
		</tr>";
            //echo $sql;
            $i = 0;
            $REF_NO = "";
            $sql = $sql . ", REF_NO, REP";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {

                if ($REF_NO != $row["REF_NO"]) {
                    if ($i == 1) {
                        echo "<tr>
					<td colspan=6></td>
					<td align=\"right\">" . number_format($GRAND_TOT, 2, ".", ",") . "</td>
					<td></td>
					</tr>";
                    } else {
                        $i = 1;
                    }
                    echo "<tr>
				<td>" . $row["SDATE"] . "</td>
				<td>" . $row["REF_NO"] . "</td>
				<td>" . $row["C_CODE"] . " " . $row["CUS_NAME"] . "</td>
				<td>" . $row["Brand_name"] . "</td>
				<td colspan=4></td>
			
				</tr>";

                    echo "<tr>
					<td colspan=4></td>
					<td>" . $row["PART_NO"] . "</td>
					<td align=\"right\">" . number_format($row["QTY"], 2, ".", ",") . "</td>
					<td align=\"right\">" . number_format($row["PRICE"], 2, ".", ",") . "</td>
					<td >" . $row["REP"] . "</td>
					</tr>";

                    $REF_NO = $row["REF_NO"];
                } else {

                    echo "<tr>
				<td colspan=4></td>
				<td>" . $row["PART_NO"] . "</td>
				<td align=\"right\">" . number_format($row["QTY"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row["PRICE"], 2, ".", ",") . "</td>
				<td >" . $row["REP"] . "</td>
				</tr>";
                }
                $GRAND_TOT = $row["GRAND_TOT"];
            }

            echo "<table>";
        }
        ?>



    </body>
</html>

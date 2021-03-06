<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Extended Cheque Report</title>

        <style>
            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {
                border:1px solid black;
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
                font-size:11px;

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

        <?php
        require_once("connectioni.php");

        $sql_head = "select * from invpara";
        $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
        $row_head = mysqli_fetch_array($result_head);

        echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

        if (!isset($_GET['chk_ins'])) {
            $heading = "<center>Cheque Extended Report From  " . $_GET["dtfrom"] . " To  " . $_GET["dtto"] . "<br>";
            echo $heading;



            echo "<br><table border=1>";
            echo "<tr><th>Invoice No</th><th>Invoice Date</th><th>Days</th><td><b>Cheque No</b></td>"
            . "<td><b>Customer</b></td>"
            . "<td><b>Amount</b></td>"
            . "<td><b>Cheq. Date I</b></td>"
            . "<td><b>Cheq Date II</b></td>"
            . "<td><b>Current Cheq. Date</b></td>"
            . "<td><b>Dealer Insentive</b></td>"
            . "<td><b>Ded Ins</b></td>"
            . "</tr>";

            $sql = "SELECT class,cheque_no,CUS_NAME,che_amount,ex_date1,ex_date2,che_date,che_amount,SDATE,C_CODE,REF_NO,sum(ST_PAID)as ST_PAID1 From view_sinvcheq_sttr_salma wHERE ((ex_date1 >= '" . $_GET["dtfrom"] . "'  and ex_date1 <= '" . $_GET["dtto"] . "') or (ex_date2 >= '" . $_GET["dtfrom"] . "'  and ex_date2 <= '" . $_GET["dtto"] . "'))  ";


            if (isset($_GET["Check1"])) {
                $sql .= " and cus_code='" . $_GET["cuscode"] . "' ";
            }
            $sql .= " group by class,cheque_no,CUS_NAME,che_amount,ex_date1,ex_date2,che_date,che_amount order by class";
            $mgroup = "";

            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {


                if ($mgroup != $row['class']) {

                    if ($mgroup != "") {
                        echo "<tr>
				<th colspan='5'></th>
				<th align='right'>" . number_format($mtot1, 2, ".", ",") . "</th>
				</tr>";
                    }


                    echo "<tr>
				<th colspan='11'>" . $row['class'] . "</th>
				</tr>";


                    $mtot1 = 0;
                }


                $mgroup = $row['class'];

                $mrefno = "";
                $mdt = "";
                $mdays = "";

                $sql = "select ref_no,SDATE,deli_date,ST_PAID from view_sinvcheq_sttr_salma where cheque_no='" . $row["cheque_no"] . "' and che_date='" . $row["che_date"] . "' and cus_name='" . $row["CUS_NAME"] . "' and class='".$mgroup."' group by ref_no,SDATE,Deli_date";
 
                $result_inv = mysqli_query($GLOBALS['dbinv'], $sql);
                while ($row_inv = mysqli_fetch_array($result_inv)) {
                    $mrefno .= $row_inv["REF_NO"] . "<br>";
                    $mdt .= $row_inv["SDATE"] . "<br>";


                    $days = "";

                    if (!is_null($row_inv["deli_date"])) {
                        $date1 = $row_inv["deli_date"];
                    } else {
                        $date1 = $row_inv["SDATE"];
                    }

                    $date2 = $row["che_date"];

                    $diff = abs(strtotime($date2) - strtotime($date1));
                    $days = floor($diff / (60 * 60 * 24));

                    $mdays .= $days . "<br>";
                }
//<td><a onfocus=\"this.blur()\" onclick=\"NewWindow('sales_inv_display.php?refno=" . trim($mrefno) . "&trn_type=INV','mywin','900','700','yes','center');return false\" class=\"INV\" href=\"\">" . trim($mrefno) . "</a></td>
                echo "<tr>
			
			<td>" . $mrefno . "</td>
			<td>" . $mdt . "</td>
			<td>" . $mdays . "</td>
			<td>" . $row["cheque_no"] . "</td>
			<td>" . $row["CUS_NAME"] . "</td>
			<td align=\"right\">" . number_format($row["ST_PAID1"], 2, ".", ",") . "</td>";

                $dt1 = "";
                $dt2 = "";
                if (($row["ex_date1"] != "0000-00-00")) {
                    $dt1 = $row["ex_date1"];
                }

                if (($row["ex_date2"] != "0000-00-00")) {
                    $dt2 = $row["ex_date2"];
                }
///prawwnaka 19.02.01
                $sql12 = "select * from ins_payment where cuscode = '" . $row["C_CODE"] . "' and (I_month) = '" . intval(date("m", strtotime($row["SDATE"]))) . "' and (I_year) = '" . date("Y", strtotime($row["SDATE"])) . "'";
                $sql_ins = mysqli_query($GLOBALS['dbinv'], $sql12);
                $numr_ins = 0;
                $myes = "";
                $numr_ins = mysqli_num_rows($sql_ins);

                if ($numr_ins > 0) {
                    $myes = "YES";
                }
                $dedins = "";
                $sql15 = "SELECT *  FROM s_cheque_extend WHERE ch_no = '" . trim($row["cheque_no"]) . "' ";

                $result_inv15 = mysqli_query($GLOBALS['dbinv'], $sql15);
                while ($row_inv15 = mysqli_fetch_array($result_inv15)) {
                    $dedins = $row_inv15["ded"];
                }
///prawwnaka
                echo "<td>" . $dt1 . "</td>
                        <td>" . $dt2 . "</td>    
                        <td>" . $row["che_date"] . "</td>
                        <td>" . $myes . "</td>
                        <td>" . $dedins . "</td>";

                $mtot = $mtot + $row["ST_PAID1"];
                $mtot1 = $mtot1 + $row["ST_PAID1"];

                echo "</tr>";
            }

            echo "<tr>
				<th colspan='5'></th>
				<th align='right'>" . number_format($mtot1, 2, ".", ",") . "</th>
				</tr>";

            echo "<tr><td colspan= '5'></td><th  align=\"right\">" . number_format($mtot, 2, ".", ",") . "</th><td colspan='5'></td></tr>";
        } else {

            $heading = "<center>Cheque Extended Report With Insentive From  " . $_GET["dtfrom"] . " To  " . $_GET["dtto"] . "<br>";
            echo $heading;



            echo "<br><table border=1>";
            echo "<tr><th>Invoice No</th><td><b>Cheque No</b></td>"
            . "<td><b>Customer</b></td>"
            . "<td><b>Amount</b></td>"
            . "<td><b>Cheq. Date I</b></td>"
            . "<td><b>Cheq Date II</b></td>"
            . "<td><b>Current Cheq. Date</b></td>"
            . "<td><b>Extended Date</b></td>"
            . "<td><b>Sales Month</b></td>"
            . "<td><b>Insentive Date</b></td>"
            . "</tr>";

            $sql = "SELECT sdate_extend,c_code,ST_REFNO,cheque_no,CUS_NAME,che_amount,ex_date1,ex_date2,che_date From view_chextend wHERE ((ex_date1 >= '" . $_GET["dtfrom"] . "'  and ex_date1 <= '" . $_GET["dtto"] . "') or (ex_date2 >= '" . $_GET["dtfrom"] . "'  and ex_date2 <= '" . $_GET["dtto"] . "'))  ";


            if (isset($_GET["Check1"])) {
                $sql .= " and cus_code='" . $_GET["cuscode"] . "' ";
            }
            $sql .= " and deliin_amo >0";
            $sql .= " group by  sdate_extend,c_code,ST_REFNO,cheque_no,CUS_NAME,che_amount,ex_date1,ex_date2,che_date";


            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {

                $mok = "";
                $mdate = "";
                $month = "";
                $sql = "select class,month(sdate) as smonth,year(sdate) syear from view_salma_sttr_brand where st_refno = '" . $row['ST_REFNO'] . "' group by class,month(sdate),year(sdate)";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql);
                while ($row1 = mysqli_fetch_array($result1)) {
                    $sql = "select * from ins_payment where sdate >='" . $row['sdate_extend'] . "' and i_month= '" . $row1['smonth'] . "' and i_year ='" . $row1['syear'] . "' and cuscode = '" . $row['c_code'] . "' and Type = '" . $row1['class'] . "'";
                    $month = $row1['syear'] . "-" . $row1['smonth'] . "/" . $row1['class'] . "," . $month;
                    $result2 = mysqli_query($GLOBALS['dbinv'], $sql);
                    if ($row2 = mysqli_fetch_array($result2)) {
                        $mok = "1";
                        $mdate = $row2['sdate'] . "," . $mdate;
                    }
                }
                if ($mok == "1") {

                    $mrefno = "";
                    $mdt = "";
                    $sql = "select ref_no,SDATE from view_sinvcheq_sttr_salma where cheque_no='" . $row["cheque_no"] . "' and che_date='" . $row["che_date"] . "' and cus_name='" . $row["CUS_NAME"] . "' group by ref_no,SDATE";

                    $result_inv = mysqli_query($GLOBALS['dbinv'], $sql);
                    while ($row_inv = mysqli_fetch_array($result_inv)) {
                        $mrefno .= $row_inv["REF_NO"] . "<br>";
                        $mdt .= $row_inv["SDATE"] . "<br>";
                    }

                    echo "<tr>
			<td>" . $mrefno . "</td>
			<td>" . $mdt . "</td>
			
			<td>" . $row["cheque_no"] . "</td>
			<td>" . $row["CUS_NAME"] . "</td>
			<td align=\"right\">" . number_format($row["che_amount"], 2, ".", ",") . "</td>";

                    $dt1 = "";
                    $dt2 = "";
                    if (($row["ex_date1"] != "0000-00-00")) {
                        $dt1 = $row["ex_date1"];
                    }

                    if (($row["ex_date2"] != "0000-00-00")) {
                        $dt2 = $row["ex_date2"];
                    }



                    echo "<td>" . $dt1 . "</td>
                        <td>" . $dt2 . "</td>    
                        <td>" . $row["che_date"] . "</td>
						<td>" . $row["sdate_extend"] . "</td>
						<td>" . $month . "</td>
						
						<td>" . $mdate . "</td>";

                    $mtot = $mtot + $row["che_amount"];

                    echo "</tr>";
                }
            }

            echo "<tr><td colspan= '3'></td><td  align=\"right\">" . number_format($mtot, 2, ".", ",") . "</td><td colspan='3'></td></tr>";
        }
        ?>




    </body>
</html>

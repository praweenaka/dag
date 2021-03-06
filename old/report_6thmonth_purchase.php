<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>6th Month Sales Consumption Report</title>

        <style>
            table {
                border-collapse: collapse;
            }
            table, td, th {

                font-family: Arial, Helvetica, sans-serif;
                padding: 5px;
            }
            th {
                font-weight: bold;
                font-size: 12px;
            }
            td {
                font-size: 11px;
                border-bottom: none;
                border-top: none;
            }
        </style>

    </head>

    <body>
        <?php
        require_once ("connectioni.php");

        $heading = "Order Form With 6 Month Stock Consumption Brand   :  " . $_GET["brand"] . "     Data As At    :" . date("Y-m-d");

        $month = date("m", strtotime(date("Y-m-d")));
        $month = $month - 1;
        $month1 = date("Y-m", strtotime(date("Y-m")));
        if ($month1 == "2018-01") {
            $month = 12;
        }

        if ($month == 1) {
            $txtmon1 = "Aug";
            $txtmon2 = "Sep";
            $txtmon3 = "Oct";
            $txtmon4 = "Nov";
            $txtmon5 = "Dec";
            $txtmon6 = "Jan";
        }

        if ($month == 2) {
            $txtmon1 = "Sep";
            $txtmon2 = "Oct";
            $txtmon3 = "Nov";
            $txtmon4 = "Dec";
            $txtmon5 = "Jan";
            $txtmon6 = "Feb";
        }
        if ($month == 3) {
            $txtmon1 = "Oct";
            $txtmon2 = "Nov";
            $txtmon3 = "Dec";
            $txtmon4 = "Jan";
            $txtmon5 = "Feb";
            $txtmon6 = "Mar";
        }
        if ($month == 4) {
            $txtmon1 = "Nov";
            $txtmon2 = "Dec";
            $txtmon3 = "Jan";
            $txtmon4 = "Feb";
            $txtmon5 = "Mar";
            $txtmon6 = "Apr";
        }
        if ($month == 5) {
            $txtmon1 = "Dec";
            $txtmon2 = "Jan";
            $txtmon3 = "Feb";
            $txtmon4 = "Mar";
            $txtmon5 = "Apr";
            $txtmon6 = "May";
        }
        if ($month == 6) {
            $txtmon1 = "Jan";
            $txtmon2 = "Feb";
            $txtmon3 = "Mar";
            $txtmon4 = "Apr";
            $txtmon5 = "May";
            $txtmon6 = "Jun";
        }
        if ($month == 7) {
            $txtmon1 = "Feb";
            $txtmon2 = "Mar";
            $txtmon3 = "Apr";
            $txtmon4 = "May";
            $txtmon5 = "Jun";
            $txtmon6 = "Jul";
        }
        if ($month == 8) {
            $txtmon1 = "Mar";
            $txtmon2 = "Apr";
            $txtmon3 = "May";
            $txtmon4 = "Jun";
            $txtmon5 = "Jul";
            $txtmon6 = "Aug";
        }
        if ($month == 9) {
            $txtmon1 = "Apr";
            $txtmon2 = "May";
            $txtmon3 = "Jun";
            $txtmon4 = "Jul";
            $txtmon5 = "Aug";
            $txtmon6 = "Sep";
        }
        if ($month == 10) {
            $txtmon1 = "May";
            $txtmon2 = "Jun";
            $txtmon3 = "Jul";
            $txtmon4 = "Aug";
            $txtmon5 = "Sep";
            $txtmon6 = "Oct";
        }
        if ($month == 11) {
            $txtmon1 = "Jun";
            $txtmon2 = "Jul";
            $txtmon3 = "Aug";
            $txtmon4 = "Sep";
            $txtmon5 = "Oct";
            $txtmon6 = "Nov";
        }
        if ($month == 12) {
            $txtmon1 = "Jul";
            $txtmon2 = "Aug";
            $txtmon3 = "Sep";
            $txtmon4 = "Oct";
            $txtmon5 = "Nov";
            $txtmon6 = "Dec";
        }

        function MonthName($mon) {
            switch ($mon) {
                case 1 :
                    return "Jan";
                case 2 :
                    return "Feb";
                case 3 :
                    return "Mar";
                case 4 :
                    return "Apr";
                case 5 :
                    return "May";
                case 6 :
                    return "Jun";
                case 7 :
                    return "Jul";
                case 8 :
                    return "Aug";
                case 9 :
                    return "Sep";
                case 10 :
                    return "Oct";
                case 11 :
                    return "Nov";
                case 12 :
                    return "Dec";
            }
        }

        $sql_head = "select * from invpara";
        $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
        $row_head = mysqli_fetch_array($result_head);

        echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

        echo "<center>" . $heading . "</center><br>";

        echo "<center><table border ='1'><tr>
		<th rowspan=\"2\" scope=\"col\">Stock No</th>
		<th rowspan=\"2\" scope=\"col\">Description</th>
		<th rowspan=\"2\" scope=\"col\">Part No</th>
		<th colspan='3' scope=\"col\">Stock</th>
		
		<th colspan=\"14\" scope=\"col\">6 Months Consumption</th>
		<th colspan=\"2\" scope=\"col\">On Order</th>
		<th rowspan=\"2\" scope=\"col\">To Be order</th>
		</tr>
		<tr>
		
		<th scope=\"col\">Brand</th>
		<th scope=\"col\">Other</th>
		<th scope=\"col\">Over 90</th>
		<th colspan=\"2\" scope=\"col\">" . $txtmon1 . "</th>
		<th colspan=\"2\" scope=\"col\">" . $txtmon2 . "</th>
		<th colspan=\"2\" scope=\"col\">" . $txtmon3 . "</th>
		<th colspan=\"2\" scope=\"col\">" . $txtmon4 . "</th>
		<th colspan=\"2\" scope=\"col\">" . $txtmon5 . "</th>
		<th colspan=\"2\" scope=\"col\">" . $txtmon6 . "</th>
		<th colspan=\"2\" scope=\"col\">Avg For 6 Month</th>
		<th scope=\"col\">Brand</th>
		<th scope=\"col\">Other</th>
		</tr>";
        //echo $sql;
        $totsort_val = 0;
        $totexceed_val = 0;

        $sql = "SELECT * from tmppurcon  where  user_nm ='" . $_SESSION["CURRENT_USER"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row = mysqli_fetch_array($result)) {
            $sql_mas = "select * from s_mas where STK_NO='" . $row["STK_NO"] . "'";
            $result_mas = mysqli_query($GLOBALS['dbinv'], $sql_mas);
            $row_mas = mysqli_fetch_array($result_mas);

            echo '<tr>';
            if ($row_mas["active_t1"] == 1) {
                echo "<td bgcolor = \"#FF0000\">" . $row["STK_NO"] . "</td>";
            } else {
                echo "<td >" . $row["STK_NO"] . "</td>";
            }


            echo "<td>" . $row["desctript"] . "</td>
		<td>" . $row["PART_NO"] . "</td>
		<td align=\"right\">" . number_format($row["QTYINHAND"], 0, ".", ",") . "</td>
		<td align=\"right\">" . number_format($row["otherqty"], 0, ".", ",") . "</td>
		<td align=\"right\">" . number_format($row["over90"], 0, ".", ",") . "</td>";

            echo "
		
		<td colspan='2' align=\"right\">" . number_format($row["con5"], 0, ".", ",") . "</td>
		
		<td colspan='2' align=\"right\">" . number_format($row["con4"], 0, ".", ",") . "</td>
		
		<td colspan='2' align=\"right\">" . number_format($row["con3"], 0, ".", ",") . "</td>
		
		<td colspan='2' align=\"right\">" . number_format($row["con2"], 0, ".", ",") . "</td>
		
		<td colspan='2' align=\"right\">" . number_format($row["con1"], 0, ".", ",") . "</td>
		
		<td colspan='2' align=\"right\">" . number_format($row["con0"], 0, ".", ",") . "</td>";

            $mavg = (($row["con0"] + $row["con1"] + $row["con2"] + $row["con3"] + $row["con4"] + $row["con5"]) / 6);

            echo "<td  colspan='2'  align=\"right\">" . number_format($mavg, 0, ".", ",") . "</td>";

            echo "<td align=\"right\">" . number_format($row["ordqty"], 0, ".", ",") . "</td>";
            echo "<td align=\"right\">" . number_format($row["otherord"], 0, ".", ",") . "</td>";

            if ($row["over90"] > 0) {
                $over90 = $row["over90"];
            } else {
                $over90 = "";
            }

            //echo "<td align=\"right\">".number_format($over90, 2, ".", ",")."</td>";
            echo "</tr>";
        }

        echo "</table>";




        echo "<table >
		<tr>
		 
		
		<td colspan='4' width='150'>&nbsp;</td>
		
		 
		
		</tr>
		<tr>
		 
		
		<td colspan='4' width='150'>&nbsp;</td>
		
		 
		
		</tr>
		<tr>
		 
		
		<td colspan='4' width='150'>&nbsp;</td>
		
		 
		
		</tr>
		<tr>
		 
		
		<td colspan='4' width='150'>&nbsp;</td>
		
		 
		
		</tr>
		
		<tr>
		
	    <td width='150'>.................................</td>
		
		<td width='150'>.................................</td>
		
		<td width='150'>.................................</td>
		
		<td width='150'>.................................</td>

        <td width='150'>.................................</td>
		
		<td width='150'>.................................</td>
		
		</tr>
		<tr>
		
	    <td width='150'>Marketing Manager</td>

        <td width='150'>Marketing Manager</td>
		
		<td width='150'>Working Director</td>
		
		<td width='150'>Director</td>
		
		<td width='150'>Managing Director</td>
 
		
		<td width='150'>Chairman</td>
		
		</tr>
		<tr>
		
	    <td width='150'></td>
		
		<td width='150'>&nbsp;</td>
		
		<td width='150'>&nbsp;</td>
		
		<td width='150'>&nbsp;</td>
		
		</tr>
				
		
		<tr>
		 
		
		<td colspan='4' width='150'>&nbsp;</td>
		
		 
		
		</tr>
		<tr>
		 
		
		<td colspan='4' width='150'>&nbsp;</td>
		
		 
		
		</tr>
		
		<tr>
		
	    <td width='150'>.................................</td>
        <td width='150'>.................................</td>
        <td width='150'>.................................</td>
		
		<td width='150'>.................................</td>
		
		<td width='150'>.................................</td>
		
		<td width='150'>.................................</td>
		
		</tr>
		<tr>
		<td width='150'>&nbsp;</td>
		
		<td width='150'>&nbsp;</td>
		
		<td width='150'>&nbsp;</td>
		
		<td width='150'></td>
		
		</tr>
		
		 
		<tr>
		<td width='150'>&nbsp;</td>
		
		<td width='150'>&nbsp;</td>
		
		<td width='150'>&nbsp;</td>
		
		<td width='150'></td>
		
		</tr>
		
		
			<tr>
		
	    <td width='150'>.................................</td>

        <td width='150'>.................................</td>
        <td width='150'>.................................</td>
		
		<td width='150'>.................................</td>
		
		<td width='150'>.................................</td>
		
		<td width='150'>.................................</td>
		
		</tr>
		<tr>
		<td width='150'>&nbsp;</td>
		
		<td width='150'>&nbsp;</td>
		
		<td width='150'>&nbsp;</td>
		
		<td width='150'></td>
		
		</tr>
		
		
		</table>";

        echo "</br>";
        ?>
    </body>
</html>

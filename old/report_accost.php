<?php session_start();
?>
<?php date_default_timezone_set('Asia/Colombo'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cost Report</title>
        <style>
            body{
                font-family:Arial, Helvetica, sans-serif;
                font-size:16px;
            }
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
                font-size:15px;

            }
            td
            {
                font-size:15px;
                border-bottom:thick;
                border-left:none;
                border-right:none;


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

        $dt1 = $_GET['dtfrom'];
        $dt2 = $_GET['dtto'];



        echo "<center>
   		<table>";
        echo "<tr>";
        echo "<td><b>Stk No</b></td>";
        echo "<td><b>Descript</b></td>";
        echo "<td><b>Opening Cost</b></td>";

        echo "</tr>";


        $rst_sql = "select stk_no,DESCRIPT from s_purtrn where cancel = '0' and sdate >='" . $dt1 . "' and sdate <='" . $dt2 . "' group by stk_no,DESCRIPT  ";

        $result_sql = mysqli_query($GLOBALS['dbinv'], $rst_sql);
        while ($row_sql = mysqli_fetch_array($result_sql)) {

            $mbf = 0;



            $rst_sql = "select * from stk_cost_all where   stk_no ='" . $row_sql['stk_no'] . "'  and sdate <'" . $dt1 . "' order by sdate desc ";

            $result_sql1 = mysqli_query($GLOBALS['dbinv'], $rst_sql);
            if ($row_sql1 = mysqli_fetch_array($result_sql1)) {
                $mbf = $row_sql1['acc_cost'];
            }


            echo "<tr>";
            echo "<td>" . $row_sql["stk_no"] . "</td>";
            echo "<td>" . $row_sql["DESCRIPT"] . "</td>";
            echo "<td>" . number_format($mbf, 2, ".", ",") . "</td>";


            $rst_sql = "select * from s_purtrn where   stk_no ='" . $row_sql['stk_no'] . "' and cancel = '0' and sdate >='" . $dt1 . "' and sdate <='" . $dt2 . "' order by sdate  ";
            $result_sql2 = mysqli_query($GLOBALS['dbinv'], $rst_sql);
            while ($row_sql2 = mysqli_fetch_array($result_sql2)) {

                $merr = "0";
                if ($row_sql['acc_cost'] != $mbf) {
                    $merr = "1";
                }

                if ($row_sql2['QTYINHAND'] > 0) {
                    $mbf = (($row_sql2['QTYINHAND'] * $mbf) + ($row_sql2['REC_QTY'] * $row_sql2['acc_cost'])) / ($row_sql2['QTYINHAND'] + $row_sql2['REC_QTY']);
                } else {
                    $mbf = $row_sql2['acc_cost'];
                }

               /*  echo "<td>" . number_format($row_sql2['acc_cost'], 2, ".", ",") . "</td>";
               echo "<td>" . number_format(($row_sql2['REC_QTY'] + $row_sql2['QTYINHAND']), 2, ".", ",") . "</td>";
                echo "<td>" . number_format($mbf, 2, ".", ",") . "</td>"; */
            }
			 echo "<td>" . number_format($mbf, 2, ".", ",") . "</td>";
            $rst_sql = "select * from s_mas where   stk_no ='" . $row_sql['stk_no'] . "'";
            $result_sql3 = mysqli_query($GLOBALS['dbinv'], $rst_sql);
            if ($row_sql3 = mysqli_fetch_array($result_sql3)) {
                echo "<td>" . number_format(($row_sql3['acc_cost'] - $mbf), 2, ".", ",") . "</td>";
            }
			 


            echo "</tr>";
        }




        echo "</table>";
        ?>
    </body>
</html>

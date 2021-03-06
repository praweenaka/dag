<?php session_start();
?>
<?php date_default_timezone_set('Asia/Colombo'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Defective Report</title>
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
                font-size:12px;

            }
            td
            {
                font-size:12px;
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




        $txthead = "For The Month " . date("Y-m", strtotime($_GET["DTPicker1"]));
        $txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");



        echo "<center>";

        echo "</br><b>" . $txthead . "</b></br></br>";
        echo "<b>" . $txtrepono . "</b></br>";
        echo "<table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
        echo "<tr align=center bgcolor=#00aaaa>";
        echo "<td width=50><b>Code</b></td>";
        echo "<td width=200><b>Name</b></td>";
        echo "<td width=100><b>Incentive</b></td>";
        echo "<td width=100><b>Inc.Paid</b></td>";
        echo "<td width=100><b>Type</b></td>";
        echo "</tr>";



        $sql = "SELECT * from Dealer_inc where  print = 1";
        $result_sql = mysqli_query($GLOBALS['dbinv'], $sql);
        while ($row_sql = mysqli_fetch_array($result_sql)) {


            echo "<tr>";
            echo "<td align=left>" . $row_sql["Cus_Code"] . "</td>";
            echo "<td align=left>" . $row_sql["CUS_NAME"] . "</td>";
            echo "<td align=left>" . number_format($row_sql["Month3"], 2, ".", ",") . "</td>";
            echo "<td align=left>" . number_format($row_sql["target"], 2, ".", ",") . "</td>";
            echo "<td align=left>" . ($row_sql["C_TYPE"]) . "</td>";
            echo "</tr>";
        }




        echo "</table>";
        ?>
    </body>
</html>

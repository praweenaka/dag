<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Vehicle Report</title>

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
                font-size:14px;

            }
            td
            {
                font-size:14px;
                border-bottom:none;
                border-top:none;
            }
        </style>

    </head>

    <body>


        <?php
        require_once("connectioni.php");
        $rep = trim($_GET["rep"]);

        $sql_head = "select * from invpara";
        $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
        $row_head = mysqli_fetch_array($result_head);


        $tb = "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

        $tb .= "<center>Vehicle Report";


        $tb .= "<center><table border=1><tr>";

        $tb .= "<tr>";
        $tb .= "<th width=\"10\"  background=\"\"></th>";
        $tb .= "<th width=\"150\"  background=\"\">Driver Name</th>";
        $tb .= "<th width=\"100\"  background=\"\">Vehicle No</th>";
        $tb .= "<th width=\"250\"  background=\"\">Customer</th>";
        $tb .= "<th width=\"350\"  background=\"\">Address</th>";
        $tb .= "<th width=\"50\"  background=\"\">Invoice No</th>";

        $sql = "select * from view_salma_vendor where CANCELL='0' and loaddate between '" . $_GET['from'] . "' AND '" . $_GET['to'] . "' and (veheno='QY-4907' or veheno='AAI-3491' or veheno='QY-4344' or veheno='AAA-4869')";

        if ($_GET['vehicle'] != "All") {
            $sql .= " and  veheno ='" . $_GET['vehicle'] . "'";
        }
        $sql .= " order by loaddate desc";

        $result = mysqli_query($GLOBALS['dbinv'], $sql);
//echo $sql;
        $ddate = "";
        $i = 1;
        while ($row = mysqli_fetch_array($result)) {

            if ($ddate != $row['loaddate']) {

                $tb .= "<tr><th align='left' colspan='6'>" . $row['loaddate'] . "</th></tr>";
            }
            $ddate = $row['loaddate'];
            $tb .= "<tr><td>" . $i . "</td>";
            $tb .= "<td>" . $row['driver'] . "</td>";
            $tb .= "<td>" . $row['veheno'] . "</td>";
            $tb .= "<td>" . $row['NAME'] . "</td>";
            $tb .= "<td>" . $row['ADD1'] . "</td>";
            $tb .= "<td>" . $row['REF_NO'] . "</td>";

            $tb .= "</tr>";
            $i += 1;
        }
//        $tb .= "<tr><th colspan='2'></th><th align='right' >" . $mqty . "</th></tr>";
//        $tb .= "<tr><th colspan='2'></th><th align='right' >" . $totqty . "</th></tr>";
        $tb .= "</table>";

        echo $tb;
        ?>


    </body>
</html>


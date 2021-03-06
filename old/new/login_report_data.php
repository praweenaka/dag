<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Login Report</title>

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



    <!--     $end_month = date('Y-m-d', strtotime("+1 months", strtotime("NOW")));-->

    <body>


        <?php
        require_once("connectioni.php");
        $rep = trim($_GET["rep"]);

        $sql_head = "select * from invpara";
        $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
        $row_head = mysqli_fetch_array($result_head);




        $tb = "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center>";
        $tb .= "<center><h3>Login Report</h3>";

        $sql_head1 = "select Name from s_salrep where REPCODE='" . $_GET['rep_code'] . "'";
        $result_head1 = mysqli_query($GLOBALS['dbinv'], $sql_head1);
        $row_head1 = mysqli_fetch_array($result_head1);

        $tb .= "<center><b>From Date = "  . $_GET["from_date"]  . "&nbsp " . "  ,  To Date = "  . $_GET["to_date"]  . "&nbsp " .  "</b></center>";

        $tb .= "<center>";

        $tb .= "<table border=1><tr>";
        $tb .= "<tr>";
        $tb .= "<th width=\"170\"  background=\"\" style=\"text-align: center;background-color: blue;color: white\">Name</th>";
        $tb .= "<th width=\"100\"  background=\"\" style=\"text-align: center;background-color: blue;color: white\">Date</th>";
        $tb .= "<th width=\"100\"  background=\"\" style=\"text-align: center;background-color: blue;color: white\">Log On Time</th>";
        $tb .= "<th width=\"100\"  background=\"\" style=\"text-align: center;background-color: blue;color: white\">Log Off Time</th>";
        $tb .= "<th width=\"100\"  background=\"\" style=\"text-align: center;background-color: blue;color: white\">IP</th>";
        
       if ($_GET['logchk'] == "on") {
                 $sql = "select * FROM loging where Date >='" . $_GET['from_date'] . "'  and Date <='" . $_GET['to_date'] . "'";
        } else {
            $tb .= "<h2>No Record Found (Please Check The Date Check Box)</h2>";
        }
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $mbrand = "";

        while ($row = mysqli_fetch_array($result)) {

            $sql_head1 = "select * from vendor where CODE='" . $row['cus_code'] . "'";
            $result_head1 = mysqli_query($GLOBALS['dbinv'], $sql_head1);
            $row_head1 = mysqli_fetch_array($result_head1);


            if ($row['Name']=='admin' || $row['Name']=='Admin' || $row['Name']=='ADMIN'){
                $tb .= "<tr><td style=\"text-align: center;display:none;\">" . $row['Name'] . "</td>";
            $tb .= "<td style=\"text-align: center;display:none;\">" . $row['Date'] . "</td>";
            $tb .= "<td style=\"text-align: center;display:none;\">" . $row['Logon_Time'] . "</td>";
            $tb .= "<td style=\"text-align: center;display:none;\">" . $row['Logout_Time'] . "</td>";
            $tb .= "<td style=\"text-align: center;display:none;\">" . $row['ip'] . "</td>";

            $tb .= "</tr>";
                
            } else {
                $tb .= "<tr><td style=\"text-align: center;\">" . $row['Name'] . "</td>";
            $tb .= "<td style=\"text-align: center;\">" . $row['Date'] . "</td>";
            $tb .= "<td style=\"text-align: center;\">" . $row['Logon_Time'] . "</td>";
            $tb .= "<td style=\"text-align: center;\">" . $row['Logout_Time'] . "</td>";
            $tb .= "<td style=\"text-align: center;\">" . $row['ip'] . "</td>";
            }
            
        }
        $tb .= "</table>";



        echo $tb;
        ?>


    </body>
</html>

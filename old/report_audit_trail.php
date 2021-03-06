<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Audit Trail</title>

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


        $txtName = "Audit Trail From " . $_GET["DTfrom"] . " To  " . $_GET["DT1"];

        echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

        echo "<center>" . $heading . "</center><br>";

        echo "<center>" . $txtName . "</center><br>";

        echo "<center><table>";
        echo "<tr>";
        echo "<th>Ref No</th>";
        echo "<th>User Name</th>";
        echo "<th>Document</th>";
        echo "<th>Type</th>";
        echo "<th>Time</th>";
        echo "<th>Date</th>";
        echo "</tr>";

        if ($_GET["refno"] == null) {
            $sqlinv = "select * from entry_log where SDATE >= '" . $_GET["DT1"] . "' and SDATE <= '" . $_GET["DT2"] . "'   order by username,id";
        } else {
            if ($_GET["DT1"] == null or $_GET["DT2"] == null) {
                $sqlinv = "select * from entry_log where  refno='" . $_GET["refno"] . "'  order by username,id";
            } else {
                $sqlinv = "select * from entry_log where SDATE >= '" . $_GET["DT1"] . "' and SDATE <= '" . $_GET["DT2"] . "' and refno='" . $_GET["refno"] . "'  order by username,id";
            }
        }
        $result3 = mysqli_query($GLOBALS['dbinv'], $sqlinv);
        $muser = "";

        while ($row2 = mysqli_fetch_array($result3)) {

            if ($muser != $row2['username']) {
                echo "<tr><td colspan='6'>" . $row2['username'] . "</td></tr>";
            }

            $muser = $row2['username'];

            echo "<tr>";
            echo "<td>" . $row2['refno'] . "</td>";
            echo "<td>" . $row2['username'] . "</td>";
            echo "<td>" . $row2['docname'] . "</td>";
            echo "<td>" . $row2['trnType'] . "</td>";
            echo "<td>" . $row2['stime'] . "</td>";
            echo "<td>" . $row2['sdate'] . "</td>";
            echo "</tr>";
        }




        echo "</table>";
        ?>



    </body>
</html>

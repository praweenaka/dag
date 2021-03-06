<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Pending Orders</title>

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
        
        





        if (($_GET["ordt"] == "brand")) {

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

            $heading = "<center>Pending Order Report  Brand " .  $_GET['cmbbrand']  . "<br><br>";
            echo $heading;


            $sql = "delete  from ord_shed";
            $result0 = mysqli_query($GLOBALS['dbinv'],$sql) ; 

            $sql = "SELECT * from s_mas where BRAND_NAME = '" . $_GET['cmbbrand'] . "'";

            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 

            while ($row = mysqli_fetch_array($result)) {

                $sql1 = "insert into ord_shed (code,des,partno,stk)   values ( '" . $row['STK_NO'] . "','" . $row['DESCRIPT'] . "','" . $row['PART_NO'] . "','" . $row['QTYINHAND'] . "') ";
                $resultr = mysqli_query($GLOBALS['dbinv'],$sql1) ; 
            }

            $sql = "SELECT * from s_ORDMAS where BRAND = '" . $_GET['cmbbrand'] . "' AND cancel=0  ";
            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
            $i = 1;
            while ($row = mysqli_fetch_array($result)) {

                $sql = "select * from s_ordtrn where REFNO='" . $row['REFNO'] . "' AND cancel=0  ";
                $result1 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
                while ($row1 = mysqli_fetch_array($result1)) {
                    $sql = "select * from ord_shed where code='" . $row1['STK_NO'] . "' ";

                    $result2 = mysqli_query($GLOBALS['dbinv'],$sql) ; 

                    while ($row2 = mysqli_fetch_array($result2)) {

                        if ($i == 1) {
                            $q1 = $row1['ORD_QTY'];
                            $sql = "update ord_shed set q1 = '" . $row1['ORD_QTY'] . "' where code= '" . $row1['STK_NO'] . "'";
                            $result3 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
                            $sd1 = $row['S_date'];
                            $lc1 = $row['LC_No'];
                        }
                        if ($i == 2) {
                            $q2 = $row1['ORD_QTY'];
                            $sql = "update ord_shed set q2 = '" . $row1['ORD_QTY'] . "' where code= '" . $row1['STK_NO'] . "'";
                            $result3 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
                            $sd2 = $row['S_date'];
                            $lc2 = $row['LC_No'];
                        }
                        if ($i == 3) {
                            $q3 = $row1['ORD_QTY'];
                            $sql = "update ord_shed set q3 = '" . $row1['ORD_QTY'] . "' where code= '" . $row1['STK_NO'] . "'";
                            $result3 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
                            $sd3 = $row['S_date'];
                            $lc3 = $row['LC_No'];
                        }
                        if ($i == 4) {
                            $q4 = $row1['ORD_QTY'];
                            $sql = "update ord_shed set q4 = '" . $row1['ORD_QTY'] . "' where code= '" . $row1['STK_NO'] . "'";
                            $result3 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
                            $sd4 = $row['S_date'];
                            $lc4 = $row['LC_No'];
                        }
                        if ($i == 5) {
                            $q5 = $row1['ORD_QTY'];
                            $sql = "update ord_shed set q5 = '" . $row1['ORD_QTY'] . "' where code= '" . $row1['STK_NO'] . "'";
                            $result3 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
                            $sd5 = $row['S_date'];
                            $lc5 = $row['LC_No'];
                        }
                        if ($i == 6) {
                            $q6 = $row1['ORD_QTY'];
                            $sql = "update ord_shed set q6 = '" . $row1['ORD_QTY'] . "' where code= '" . $row1['STK_NO'] . "'";
                            $result3 = mysqli_query($GLOBALS['dbinv'],$sql) ; 
                            $sd6 = $row['S_date'];
                            $lc6 = $row['LC_No'];
                        }
                    }
                }

                $i = $i + 1;
            }




            echo "<table border = 1>";
            echo "<tr><td><b>Code</b></td>"
            . "<td><b>Description</b></td>"
            . "<td><b>Part No</b></td>"
            . "<td><b>Stock</b></td>"
            . "<td  width='50'><b>" . $sd1 . "/" . $lc1 . "</b></td>"
            . "<td  width='50'><b>" . $sd2 . "/" . $lc2 . "</b></td>"
            . "<td  width='50'><b>" . $sd3 . "/" . $lc3 . "</b></td>"
            . "<td  width='50'><b>" . $sd4 . "/" . $lc4 . "</b></td>"
            . "<td width='50'><b>" . $sd5 . "/" . $lc5 . "</b></td>"
            . "<td><b>" . $sd6 . "/" . $lc6 . "</b></td>"
            . "<td><b>To Be Order</b></td>"
            . "</tr>";

            $sql = "select  *from ord_shed order by code";
            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>
                <td>" . $row["code"] . "</td>
                <td>" . $row["des"] . "</td>
                <td>" . $row["partno"] . "</td>
                <td align = 'right'>" . $row["stk"] . "</td>
                <td width='50' align = 'right'>" . $row["q1"] . "</td>"
                . "<td width='50' align = 'right'>" . $row["q2"] . "</td>"
                . "<td width='50' align = 'right'>" . $row["q3"] . "</td>"
                . "<td width='50' align = 'right'>" . $row["q4"] . "</td>"
                . "<td width='50' align = 'right'>" . $row["q5"] . "</td>"
                . "<td width='50' align = 'right'>" . $row["q6"] . "</td>"
                . "<td width='50'>..........</td>";
                "<td align = \"right\"></td>";
                echo "</tr>";
            }
        }



        if (($_GET["ordt"] == "type")) {

            if ($_GET["cmbordt"] == "Order") {
                $sql_head = "select * from invpara";
                $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
                $row_head = mysqli_fetch_array($result_head);

                echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

                $heading = "<center>Pending Orders Report  From "  . $_GET["DT1"]  .   " To "  .  $_GET["DT2"]  .  " <br><br>";
                echo $heading;


                $sql = "SELECT REFNO,SDATE,lc_no from vieword where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "'   AND cancel=0 group by refno,sdate,lc_no order by refno  ";

                $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
                while ($row = mysqli_fetch_array($result)) {
                    $sql_02 = "SELECT * from vieword where refno = '" . $row['REFNO'] . "'";


                    $result1 = mysqli_query($GLOBALS['dbinv'],$sql_02);
                    $numr = mysqli_num_rows($result1);

                    if ($numr > 0) {
                        echo "<table><tr> <td><b>" . $row['REFNO'] . "</td> <td><b>Date :" . $row['SDATE'] . "</td> <td colspan='3'><b>LC No: " . $row['LC_No'] . " </td></tr>";
                    }

                    while ($row1 = mysqli_fetch_array($result1)) {
                        echo "<tr> <td width='150'>" . $row1['STK_NO'] . "</td>            "
                        . "<td width='300'>" . $row1['DESCRIPT'] . "</td>"
                        . "<td width='100'>" . $row1['partno'] . "</td>"
                        . "<td width='90'>" . $row1['ORD_QTY'] . "</td>"
                        . "<td width='90'>" . $row1['S_date'] . "</td>"
                        . " </tr>";
                    }
                    echo "</table><br>";
                }
            }


            if ($_GET["cmbordt"] == "Item") {
                $sql_head = "select * from invpara";
                $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
                $row_head = mysqli_fetch_array($result_head);

                echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

                $heading = "<center>Pending Orders Report From "  . $_GET["DT1"]  .   " To "  .  $_GET["DT2"]  .  " <br><br>";
                echo $heading;


                $sql = "SELECT STK_NO,DESCRIPT,partno from vieword where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "'   AND cancel=0 group by STK_NO,DESCRIPT,partno order by STK_NO  ";

                $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
                while ($row = mysqli_fetch_array($result)) {
                    $sql_02 = "SELECT * from vieword where STK_NO = '" . $row['STK_NO'] . "' and cancel=0";


                    $result1 = mysqli_query($GLOBALS['dbinv'],$sql_02);
                    $numr = mysqli_num_rows($result1);

                    if ($numr > 0) {
                        echo "<table><tr> <td><b>" . $row['STK_NO'] . "<b></td> <td>" . $row['DESCRIPT'] . "</td> <td colspan='3'>" . $row['partno'] . " </td></tr>"
                        . "<tr> <td><b>Ref No</td> <td><b>Ord . No</td>   <td><b>LC NO</td>  <td><b>Qty</td>    <td><b>Shedule Datee</b></td>                                                                                                                   </tr>  ";
                    }

                    while ($row1 = mysqli_fetch_array($result1)) {
                        echo "<tr> <td width='150'>" . $row1['REFNO'] . "</td>            "
                        . "<td width='300'>" . $row1['SDATE'] . "</td>"
                        . "<td width='100'>" . $row1['LC_No'] . "</td>"
                        . "<td width='90'>" . $row1['ORD_QTY'] . "</td>"
                        . "<td width='90'>" . $row1['S_date'] . "</td>"
                        . " </tr>";
                    }
                    echo "</table><br>";
                }
            }
        }
        ?>



    </body>
</html>

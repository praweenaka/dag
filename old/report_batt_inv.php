<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Dealer Inventry</title>

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
        $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
        $row_head = mysqli_fetch_array($result_head);


        $tb = "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

        $tb .= "<center>Delaer Inventry";

		$sql = "select NAME from vendor where code = '".  $_GET["c_code"]  . "'";
		$result_v = mysqli_query($GLOBALS['dbinv'],$sql);			
		$row_v = mysqli_fetch_array($result_v);
		 
		 
			
			 
		 
        $tb .= "<center>Dealer - ". $row_v['NAME'];
		
		$sql = "select * from s_salrep where REPCODE ='" .  $rep  . "'";
		$result_v1 = mysqli_query($GLOBALS['dbinv'],$sql);			
		$row_v1 = mysqli_fetch_array($result_v1);	
		
		
		$tb .= "<center>Sales Rep - " . $row_v1['Name']   ;
		 
		 
        $tb .= "<center><table border=1><tr>";

        $tb .= "<tr>";
        $tb .= "<th width=\"50\"  background=\"\">Stock No</th>";
        $tb .= "<th width=\"350\"  background=\"\">Description</th>";

        $sql = "select sdate from battry_inv where rep='" . $rep . "' and c_code='" . trim($_GET["c_code"]) . "' and sdate>='" . $_GET['dtfrom'] . "' and sdate<='" . $_GET['dtto'] . "'  group by sdate order by sdate desc limit 2";


        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        while ($row = mysqli_fetch_array($result)) {
            $tb .= "<th  width=\"70\">" . $row['sdate'] . "</th>";
        }

        $tb .= "<th  width=\"70\">Deliverd</th>";
        $tb .= "<th width=\"70\">Movement</th>";
        $tb .= "</tr>";

        $sql = "select stk_no from battry_inv where rep='" . $rep . "' and c_code='" . trim($_GET["c_code"]) . "' group by stk_no";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);

        $mdate1 = "";
        $mdate2 = "";

        $date1 = date('Y-m-d');
        $date2 = date('Y-m-d');



        while ($row = mysqli_fetch_array($result)) {
            $mqty1 = 0;
            $mqty2 = 0;
            $mdate1 = "";
            $mdate2 = "";
            $tb .= "<td>" . $row['stk_no'] . "</td>";

            $sql = "select * from s_mas where stk_no ='" . $row['stk_no'] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row1 = mysqli_fetch_array($result1)) {
                $tb .= "<td>" . $row1['DESCRIPT'] . "</td>";
            }

            $sql = "select sdate from battry_inv where rep='" . $rep . "' and c_code='" . trim($_GET["c_code"]) . "' and sdate>='" . $_GET['dtfrom'] . "' and  sdate<='" . $_GET['dtto'] . "'  group by sdate order by sdate desc limit 2";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row1 = mysqli_fetch_array($result1)) {

                $sql = "select qty from battry_inv where rep='" . $rep . "' and c_code='" . trim($_GET["c_code"]) . "' and stk_no = '" . $row['stk_no'] . "' and sdate = '" . $row1['sdate'] . "'";
                $result2 = mysqli_query($GLOBALS['dbinv'], $sql);

                if ($row2 = mysqli_fetch_array($result2)) {
                    $tb .= "<td align='right'>" . $row2['qty'] . "</td>";
                } else {
                    $tb .= "<td align='right'>-</td>";
                }

                if ($mdate1 != "" and $mdate2 == "") {
                    $mdate2 = $row1['sdate'];
                    $mqty2 = $row2['qty'];
                }

                if ($mdate1 == "") {
                    $mdate1 = $row1['sdate'];
                    $mqty1 = $row2['qty'];
                }
            }

            if ($mdate1 == "") {
                $mdate1 = $date1;
            }
            if ($mdate2 == "") {
                $mdate2 = $date2;
            }

            $sql = "select sum(qty) as qty from view_salma_invo_smas where sal_ex='" . $rep . "' and c_code='" . trim($_GET["c_code"]) . "' and stk_no = '" . $row['stk_no'] . "' and deli_Date>'" . $mdate2 . "' and deli_Date<'" . $mdate1 . "'";

            $result2 = mysqli_query($GLOBALS['dbinv'], $sql);
            if ($row2 = mysqli_fetch_array($result2)) {
                $tb .= "<td align='right'>" . $row2['qty'] . "</td>";
                $tb .= "<td align='right'>" . (($row2['qty'] + $mqty2) - ($mqty1)) . "</td>";
            } else {
                $tb .= "<td align='right'>-</td>";
            }


            $tb .= "</tr>";
        }

        $tb .= "</table>";

        echo $tb;
        ?>


    </body>
</html>


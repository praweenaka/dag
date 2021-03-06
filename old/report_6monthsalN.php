<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>6 Month Sales Report</title>

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
        othersales();

        function othersales() {

            require_once("connectioni.php");


            $sql = "delete from 6monsales";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $date = date("Y-m-d", strtotime($_GET["DTPicker1"]));
            $caldays = " - 90 days";
            $tmpdate = date('Y-m-d', strtotime($date . $caldays));
            $i = 0;

            $strinv = "select sum(grand_tot/(1 +gst/100)) as gtot,c_code,month(sdate) as month ,year(sdate) as year,sal_ex,brand from s_salma where ACCNAME <> 'NON STOCK'   and CANCELL='0' ";
            if ($_GET["cmbrep"] != "All") {
                $strinv .=" and sal_ex= '" . $_GET['cmbrep'] . "'";
            }


            if ($_GET["cmbbrand"] != "All") {
                $strinv .=" and brand= '" . $_GET['cmbbrand'] . "'";
            }

            if ($_GET["ChKCUS"] == "on") {
                $strinv .=" and c_code= '" . trim($_GET["cuscode"]) . "'";
            }

            $month1 = date("m", strtotime($_GET["month1"]));
            $month2 = date("m", strtotime($_GET["month2"]));
            $month3 = date("m", strtotime($_GET["month3"]));
            $month4 = date("m", strtotime($_GET["month4"]));
            $month5 = date("m", strtotime($_GET["month5"]));
            $month6 = date("m", strtotime($_GET["month6"]));
            $month7 = date("m", strtotime($_GET["month7"]));
            $month8 = date("m", strtotime($_GET["month8"]));
            $month9 = date("m", strtotime($_GET["month9"]));
            $month10 = date("m", strtotime($_GET["month10"]));
            $month11 = date("m", strtotime($_GET["month11"]));
            $month12 = date("m", strtotime($_GET["month12"]));


            $month1_y = date("Y", strtotime($_GET["month1"]));
            $month2_y = date("Y", strtotime($_GET["month2"]));
            $month3_y = date("Y", strtotime($_GET["month3"]));
            $month4_y = date("Y", strtotime($_GET["month4"]));
            $month5_y = date("Y", strtotime($_GET["month5"]));
            $month6_y = date("Y", strtotime($_GET["month6"]));
            $month7_y = date("Y", strtotime($_GET["month7"]));
            $month8_y = date("Y", strtotime($_GET["month8"]));
            $month9_y = date("Y", strtotime($_GET["month9"]));
            $month10_y = date("Y", strtotime($_GET["month10"]));
            $month11_y = date("Y", strtotime($_GET["month11"]));
            $month12_y = date("Y", strtotime($_GET["month12"]));


            $strinv.= " and (( month(sdate) = '" . $month1 . "'  and year(sdate) = '" . $month1_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month2 . "'  and year(sdate) = '" . $month2_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month3 . "'  and year(sdate) = '" . $month3_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month4 . "'  and year(sdate) = '" . $month4_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month5 . "'  and year(sdate) = '" . $month5_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month6 . "'  and year(sdate) = '" . $month6_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month7 . "'  and year(sdate) = '" . $month7_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month8 . "'  and year(sdate) = '" . $month8_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month9 . "'  and year(sdate) = '" . $month9_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month10 . "'  and year(sdate) = '" . $month10_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month11 . "'  and year(sdate) = '" . $month11_y . "') ";
            $strinv.= " or ( month(sdate) = '" . $month12 . "'  and year(sdate) = '" . $month12_y . "')) ";
            $strinv .="  group by c_code,year(sdate), month(sdate),sal_ex,brand ";


            $mon1 = 0;
            $mon2 = 0;
            $mon3 = 0;
            $mon4 = 0;
            $mon5 = 0;
            $mon6 = 0;
            $mon7 = 0;
            $mon8 = 0;
            $mon9 = 0;
            $mon10 = 0;
            $mon11 = 0;
            $mon12 = 0;

            $Gmon12 = 0;
            $Gmon11 = 0;
            $Gmon10 = 0;
            $Gmon9 = 0;
            $Gmon8 = 0;
            $Gmon7 = 0;
            $Gmon6 = 0;
            $Gmon5 = 0;
            $Gmon4 = 0;
            $Gmon3 = 0;
            $Gmon2 = 0;
            $Gmon1 = 0;

            $result2 = mysqli_query($GLOBALS['dbinv'], $strinv);
            while ($row_RSINVO01 = mysqli_fetch_array($result2)) {

                $yy = "y";

                if ($yy == "y") {

                    $mon1 = 0;
                    $mon2 = 0;
                    $mon3 = 0;
                    $mon4 = 0;
                    $mon5 = 0;
                    $mon6 = 0;
                    $mon7 = 0;
                    $mon8 = 0;
                    $mon9 = 0;
                    $mon10 = 0;
                    $mon11 = 0;
                    $mon12 = 0;

                    $Gmon12 = 0;
                    $Gmon11 = 0;
                    $Gmon10 = 0;
                    $Gmon9 = 0;
                    $Gmon8 = 0;
                    $Gmon7 = 0;

                    $Gmon6 = 0;
                    $Gmon5 = 0;
                    $Gmon4 = 0;
                    $Gmon3 = 0;
                    $Gmon2 = 0;
                    $Gmon1 = 0;


                    $sql_rsVENDOR = "SELECT * FROM vendor WHERE CODE='" . trim($row_RSINVO01['c_code']) . "' ";
                    $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sql_rsVENDOR);
                    $row_rsVENDOR = mysqli_fetch_array($result_rsVENDOR);
                    if ($month1 == $row_RSINVO01["month"] and $month1_y == $row_RSINVO01["year"]) {
                        $mon1 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month2 == $row_RSINVO01["month"] and $month2_y == $row_RSINVO01["year"]) {
                        $mon2 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month3 == $row_RSINVO01["month"] and $month3_y == $row_RSINVO01["year"]) {
                        $mon3 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month4 == $row_RSINVO01["month"] and $month4_y == $row_RSINVO01["year"]) {
                        $mon4 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month5 == $row_RSINVO01["month"] and $month5_y == $row_RSINVO01["year"]) {
                        $mon5 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month6 == $row_RSINVO01["month"] and $month6_y == $row_RSINVO01["year"]) {
                        $mon6 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month7 == $row_RSINVO01["month"] and $month7_y == $row_RSINVO01["year"]) {
                        $mon7 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month8 == $row_RSINVO01["month"] and $month8_y == $row_RSINVO01["year"]) {
                        $mon8 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month9 == $row_RSINVO01["month"] and $month9_y == $row_RSINVO01["year"]) {
                        $mon9 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month10 == $row_RSINVO01["month"] and $month10_y == $row_RSINVO01["year"]) {
                        $mon10 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month11 == $row_RSINVO01["month"] and $month11_y == $row_RSINVO01["year"]) {
                        $mon11 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month12 == $row_RSINVO01["month"] and $month12_y == $row_RSINVO01["year"]) {
                        $mon12 = ($row_RSINVO01["gtot"]);
                    }

                    $cat = $row_rsVENDOR["CAT"];
//                    $sql_RSMONSALES = "insert into 6monsales(Cus_Code, cus_name, cat,  month1, month2, month3,month4,month5,month6,month7,month8,month9,month10,month11,month12) values "
//                            . "('" . $row_RSINVO01['c_code'] . "', '" . $row_rsVENDOR["NAME"] . "',  '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "' , '" . ($mon4 - $Gmon4) . "','" . ($mon5 - $Gmon5) . "','" . ($mon6 - $Gmon6) . "', '" . ($mon7 - $Gmon7) . "', '" . ($mon8 - $Gmon8) . "', '" . ($mon9 - $Gmon9) . "' , '" . ($mon10 - $Gmon10) . "','" . ($mon11 - $Gmon11) . "','" . ($mon12 - $Gmon12) . "' )";

                    $userData1[] = "('" . $row_RSINVO01['c_code'] . "', '" . $row_rsVENDOR["NAME"] . "',  '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "' , '" . ($mon4 - $Gmon4) . "','" . ($mon5 - $Gmon5) . "','" . ($mon6 - $Gmon6) . "', '" . ($mon7 - $Gmon7) . "', '" . ($mon8 - $Gmon8) . "', '" . ($mon9 - $Gmon9) . "' , '" . ($mon10 - $Gmon10) . "','" . ($mon11 - $Gmon11) . "','" . ($mon12 - $Gmon12) . "','" . $row_RSINVO01['sal_ex'] . "','" . $row_RSINVO01['brand'] . "' )";


                    // $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'],$sql_RSMONSALES);
                }
            }

            $sql_RSMONSALES = "insert into 6monsales(Cus_Code, cus_name, cat,  month1, month2, month3,month4,month5,month6,month7,month8,month9,month10,month11,month12,sal_ex,brand) values " . implode(',', $userData1);
            $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sql_RSMONSALES);

            $i = $i + 1;



            //  }
            //$strinv = "select sum(GRAND_TOT/(1 +GST/100)) as gtot,brand,c_code from s_salma where ACCNAME <> 'NON STOCK'   and CANCELL='0' ";
            $strgrn = "select sum(amount/(1 +vatrate/100)) as gtot,CUSCODE,month(sdate) as month ,year(sdate) as year,sal_ex,brand from c_bal where   trn_type<>'INC'and trn_type<>'REC' and trn_type<>'PAY' and trn_type<>'ARN' ";
            //sum(amount/(1 +vatrate/100))
            if ($_GET["cmbrep"] != "All") {
                $strgrn .=" and SAL_EX ='" . $_GET['cmbrep'] . "'";
            }
            if ($_GET["cmbreptype"] != "cus1") {
                $strgrn .= "  and flag1 <> '1'";
            }

            if ($_GET["ChKCUS"] == "on") {
                $strgrn .=" and CUSCODE ='" . $_GET['cuscode'] . "'";
            }

            if (!isset($_GET["chkdef"])) {
                $strgrn .=" and trn_type <> 'DGRN'";
            }

            if ($_GET["cmbbrand"] != "All") {
                $strgrn .=" and brand= '" . $_GET['cmbbrand'] . "'";
            }

            $strgrn.= " and (( month(sdate) = '" . $month1 . "'  and year(sdate) = '" . $month1_y . "') ";
            $strgrn.= " or ( month(sdate) = '" . $month2 . "'  and year(sdate) = '" . $month2_y . "') ";
            $strgrn.= " or ( month(sdate) = '" . $month3 . "'  and year(sdate) = '" . $month3_y . "') ";
            $strgrn.= " or ( month(sdate) = '" . $month4 . "'  and year(sdate) = '" . $month4_y . "') ";
            $strgrn.= " or ( month(sdate) = '" . $month5 . "'  and year(sdate) = '" . $month5_y . "') ";
            $strgrn.= " or ( month(sdate) = '" . $month6 . "'  and year(sdate) = '" . $month6_y . "') ";
            $strgrn.= " or ( month(sdate) = '" . $month7 . "'  and year(sdate) = '" . $month7_y . "') ";
            $strgrn.= " or ( month(sdate) = '" . $month8 . "'  and year(sdate) = '" . $month8_y . "') ";
            $strgrn.= " or ( month(sdate) = '" . $month9 . "'  and year(sdate) = '" . $month9_y . "') ";
            $strgrn.= " or ( month(sdate) = '" . $month10 . "'  and year(sdate) = '" . $month10_y . "') ";
            $strgrn.= " or ( month(sdate) = '" . $month11 . "'  and year(sdate) = '" . $month11_y . "') ";
            $strgrn.= " or ( month(sdate) = '" . $month12 . "'  and year(sdate) = '" . $month12_y . "')) ";
            $strgrn .="  group by CUSCODE,year(sdate), month(sdate),sal_ex,brand ";



            $result2 = mysqli_query($GLOBALS['dbinv'], $strgrn);
            while ($row_RSINVO01 = mysqli_fetch_array($result2)) {


                $yy = "y";

                if ($yy == "y") {
                    $mon1 = 0;
                    $mon2 = 0;
                    $mon3 = 0;
                    $mon4 = 0;
                    $mon5 = 0;
                    $mon6 = 0;
                    $mon7 = 0;
                    $mon8 = 0;
                    $mon9 = 0;
                    $mon10 = 0;
                    $mon11 = 0;
                    $mon12 = 0;

                    $Gmon12 = 0;
                    $Gmon11 = 0;
                    $Gmon10 = 0;
                    $Gmon9 = 0;
                    $Gmon8 = 0;
                    $Gmon7 = 0;

                    $Gmon6 = 0;
                    $Gmon5 = 0;
                    $Gmon4 = 0;
                    $Gmon3 = 0;
                    $Gmon2 = 0;
                    $Gmon1 = 0;


                    $sql_rsVENDOR = "SELECT * FROM vendor WHERE CODE='" . trim($row_RSINVO01['CUSCODE']) . "' ";
                    $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sql_rsVENDOR);
                    $row_rsVENDOR = mysqli_fetch_array($result_rsVENDOR);

                    if ($month1 == $row_RSINVO01["month"] and $month1_y == $row_RSINVO01["year"]) {
                        $Gmon1 = $row_RSINVO01["gtot"];
                    }
                    if ($month2 == $row_RSINVO01["month"] and $month2_y == $row_RSINVO01["year"]) {
                        $Gmon2 = $row_RSINVO01["gtot"];
                    }
                    if ($month3 == $row_RSINVO01["month"] and $month3_y == $row_RSINVO01["year"]) {
                        $Gmon3 = $row_RSINVO01["gtot"];
                    }

                    if ($month4 == $row_RSINVO01["month"] and $month4_y == $row_RSINVO01["year"]) {
                        $Gmon4 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month5 == $row_RSINVO01["month"] and $month5_y == $row_RSINVO01["year"]) {
                        $Gmon5 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month6 == $row_RSINVO01["month"] and $month6_y == $row_RSINVO01["year"]) {
                        $Gmon6 = ($row_RSINVO01["gtot"]);
                    }

                    if ($month7 == $row_RSINVO01["month"] and $month7_y == $row_RSINVO01["year"]) {
                        $Gmon7 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month7 == $row_RSINVO01["month"] and $month7_y == $row_RSINVO01["year"]) {
                        $Gmon7 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month8 == $row_RSINVO01["month"] and $month8_y == $row_RSINVO01["year"]) {
                        $Gmon8 = ($row_RSINVO01["gtot"]);
                    }

                    if ($month9 == $row_RSINVO01["month"] and $month9_y == $row_RSINVO01["year"]) {
                        $Gmon9 = ($row_RSINVO01["gtot"]);
                    }
                    if ($month10 == $row_RSINVO01["month"] and $month10_y == $row_RSINVO01["year"]) {
                        $Gmon10 = ($row_RSINVO01["gtot"]);
                    }

                    if ($month11 == $row_RSINVO01["month"] and $month11_y == $row_RSINVO01["year"]) {
                        $Gmon11 = ($row_RSINVO01["gtot"]);
                    }

                    if ($month12 == $row_RSINVO01["month"] and $month12_y == $row_RSINVO01["year"]) {
                        $Gmon12 = ($row_RSINVO01["gtot"]);
                    }


                    $cat = $row_rsVENDOR["CAT"];

//                    $sql_RSMONSALES = "insert into 6monsales(Cus_Code, cus_name, cat,  month1, month2, month3,month4,month5,month6,month7,month8,month9,month10,month11,month12) values "
//                            . "('" . $row_RSINVO01['CUSCODE'] . "', '" . $row_rsVENDOR["NAME"] . "',  '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "',  '" . ($mon4 - $Gmon4) . "','" . ($mon5 - $Gmon5) . "','" . ($mon6 - $Gmon6) . "' , '" . ($mon7 - $Gmon7) . "', '" . ($mon8 - $Gmon8) . "', '" . ($mon9 - $Gmon9) . "' , '" . ($mon10 - $Gmon10) . "','" . ($mon11 - $Gmon11) . "','" . ($mon12 - $Gmon12) . "')";

                    $userData2[] = "('" . $row_RSINVO01['CUSCODE'] . "', '" . $row_rsVENDOR["NAME"] . "',  '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "',  '" . ($mon4 - $Gmon4) . "','" . ($mon5 - $Gmon5) . "','" . ($mon6 - $Gmon6) . "' , '" . ($mon7 - $Gmon7) . "', '" . ($mon8 - $Gmon8) . "', '" . ($mon9 - $Gmon9) . "' , '" . ($mon10 - $Gmon10) . "','" . ($mon11 - $Gmon11) . "','" . ($mon12 - $Gmon12) . "','" . $row_RSINVO01['sal_ex'] . "','" . $row_RSINVO01['brand'] . "' )";

                    //  $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'],$sql_RSMONSALES);
                }
            }


            //  if (!$userData2) {
            $sql_RSMONSALES = "insert into 6monsales(Cus_Code, cus_name, cat,  month1, month2, month3,month4,month5,month6,month7,month8,month9,month10,month11,month12,sal_ex,brand) values " . implode(',', $userData2);
            $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sql_RSMONSALES);
            //   }
//                    $i = $i + 1;
//                }
            //brand loop



            if ($_GET["cmbreptype"] == "cus") {
                PrintRep2();
            } elseif ($_GET["cmbreptype"] == "cus1") {
                PrintRep_3();
            } else {
                PrintRep3();
            }
        }

        function PrintRep_3() {
            //echo "aaaa";
            require_once("connectioni.php");



            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            $rtxtComName = $row_head["COMPANY"];
            $rtxtcomadd1 = $row_head["ADD1"];
            $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
            if ($_GET["cmbrep"] != "All") {
                $rtxtrep = "Person : " . trim($_GET["cmbrep"]);
            }
            if ($_GET["cmbrep"] == "All") {
                $rtxtrep = "Person : " . $_GET["cmbrep"];
            }
            $rtxtbrand = "Brand : " . $_GET["cmbbrand"];



            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";
            if ($_GET["radio"] == "Option2") {
                echo "<center>12 Month Sales Summery";
            } else {
                echo "<center>6 Month Sales Summery";
            }
            echo $rtxtrep . "</br>";
            echo $rtxtbrand . "</br>";
            echo $heading;
            echo "<center><table border=1><tr>
		<th>Code</th>
		
		<th>Customer Name</th>
		<th>Address</th>
		<th>TIN No</th>
		<th>Phone No</th>";



            echo "<th>Total</th>";
            //echo "<th>Per. Month Avg.</th>";
            echo "</tr>";
            //echo $sql;

            $month1_tot = 0;
            $month2_tot = 0;
            $month3_tot = 0;
            $month4_tot = 0;
            $month5_tot = 0;
            $month6_tot = 0;
            $month7_tot = 0;
            $month8_tot = 0;
            $month9_tot = 0;
            $month10_tot = 0;
            $month11_tot = 0;
            $month12_tot = 0;

            $sql_sql = "SELECT cus_code,cus_name from 6monsales where cus_code <> '' group by cus_code,cus_name ";
            $result_sql = mysqli_query($GLOBALS['dbinv'], $sql_sql);

            while ($row_sql = mysqli_fetch_array($result_sql)) {
                $sql_sql1 = "SELECT sum(month1)as month1,sum(month2) as month2,sum(month3) as month3,sum(month4) as month4,sum(month5) as month5,sum(month6) as month6,sum(month7) as month7,sum(month8) as month8,sum(month9) as month9,sum(month10) as month10,sum(month11) as month11,sum(month12) as month12 from 6monsales where cus_code ='" . $row_sql["cus_code"] . "'   ";
                $result_sql1 = mysqli_query($GLOBALS['dbinv'], $sql_sql1);

                while ($row_sql1 = mysqli_fetch_array($result_sql1)) {

                    $sql_vendor = "select * from vendor where code ='" . $row_sql["cus_code"] . "' ";
                    $result_v = mysqli_query($GLOBALS['dbinv'], $sql_vendor);
                    $result_v = mysqli_fetch_array($result_v);
                    echo "<tr>
				<td>" . $row_sql["cus_code"] . "</td>
				<td>" . $row_sql["cus_name"] . "</td>
				<td>" . $result_v["ADD1"] . "</td>
				<td>" . $result_v["vatno"] . "</td>
				<td>" . $result_v["TELE1"] . "</td>";

                    $rowt = $row_sql1["month1"] + $row_sql1["month2"] + $row_sql1["month3"] + $row_sql1["month4"] + $row_sql1["month5"] + $row_sql1["month6"];
                    if ($_GET["radio"] == "Option2") {
                        $rowt = $rowt + $row_sql1["month7"] + $row_sql1["month8"] + $row_sql1["month9"] + $row_sql1["month10"] + $row_sql1["month11"] + $row_sql1["month12"];
                    }
                    echo "<td  align=\"right\" >" . number_format($rowt, 2, ".", ",") . "</td>";

                    if ($_GET["radio"] == "Option2") {
                        $avgmon = $rowt / 12;
                    } else {
                        $avgmon = $rowt / 6;
                    }

                    //echo "<td  align=\"right\">" . number_format($avgmon, 0, ".", ",") . "</td>";

                    echo "</tr>";
                    $month1_tot = $month1_tot + $row_sql1["month1"];
                    $month2_tot = $month2_tot + $row_sql1["month2"];
                    $month3_tot = $month3_tot + $row_sql1["month3"];
                    $month4_tot = $month4_tot + $row_sql1["month4"];
                    $month5_tot = $month5_tot + $row_sql1["month5"];
                    $month6_tot = $month6_tot + $row_sql1["month6"];
                    $month7_tot = $month7_tot + $row_sql1["month7"];
                    $month8_tot = $month8_tot + $row_sql1["month8"];
                    $month9_tot = $month9_tot + $row_sql1["month9"];
                    $month10_tot = $month10_tot + $row_sql1["month10"];
                    $month11_tot = $month11_tot + $row_sql1["month11"];
                    $month12_tot = $month12_tot + $row_sql1["month12"];
                }
            }
            echo "<tr>
			<th colspan='5'>Total</td>";



            $rowft = $month1_tot + $month2_tot + $month3_tot + $month4_tot + $month5_tot + $month6_tot;
            if ($_GET["radio"] == "Option2") {
                $rowft = $rowft + $month7_tot + $month8_tot + $month9_tot + $month10_tot + $month11_tot + $month12_tot;
            }
            echo "<th  align=\"right\"><b>" . number_format($rowft, 0, ".", ",") . "</b></th>";


            if ($_GET["radio"] == "Option2") {
                $avgmon = $rowft / 12;
            } else {
                $avgmon = $rowft / 6;
            }

            // echo "<th  align=\"right\"><b>" . number_format($avgmon, 0, ".", ",") . "</b></th>";



            echo "</tr>";
        }

        function PrintRep2() {
            //echo "aaaa";
            require_once("connectioni.php");



            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            $rtxtComName = $row_head["COMPANY"];
            $rtxtcomadd1 = $row_head["ADD1"];
            $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
            if ($_GET["cmbrep"] != "All") {
                $rtxtrep = "Person : " . trim($_GET["cmbrep"]);
            }
            if ($_GET["cmbrep"] == "All") {
                $rtxtrep = "Person : " . $_GET["cmbrep"];
            }
            $rtxtbrand = "Brand : " . $_GET["cmbbrand"];

            $rtxtm1 = date("M", strtotime($_GET["month1"])) . " " . date("Y", strtotime($_GET["month1"]));
            $rtxtm2 = date("M", strtotime($_GET["month2"])) . " " . date("Y", strtotime($_GET["month2"]));
            $rtxtm3 = date("M", strtotime($_GET["month3"])) . " " . date("Y", strtotime($_GET["month3"]));
            $rtxtm4 = date("M", strtotime($_GET["month4"])) . " " . date("Y", strtotime($_GET["month4"]));
            $rtxtm5 = date("M", strtotime($_GET["month5"])) . " " . date("Y", strtotime($_GET["month5"]));
            $rtxtm6 = date("M", strtotime($_GET["month6"])) . " " . date("Y", strtotime($_GET["month6"]));
            $rtxtm7 = date("M", strtotime($_GET["month7"])) . " " . date("Y", strtotime($_GET["month7"]));
            $rtxtm8 = date("M", strtotime($_GET["month8"])) . " " . date("Y", strtotime($_GET["month8"]));
            $rtxtm9 = date("M", strtotime($_GET["month9"])) . " " . date("Y", strtotime($_GET["month9"]));
            $rtxtm10 = date("M", strtotime($_GET["month10"])) . " " . date("Y", strtotime($_GET["month10"]));
            $rtxtm11 = date("M", strtotime($_GET["month11"])) . " " . date("Y", strtotime($_GET["month11"]));
            $rtxtm12 = date("M", strtotime($_GET["month12"])) . " " . date("Y", strtotime($_GET["month12"]));

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";
            if ($_GET["radio"] == "Option2") {
                echo "<center>12 Month Sales Summery";
            } else {
                echo "<center>6 Month Sales Summery";
            }
            echo $rtxtrep . "</br>";
            echo $rtxtbrand . "</br>";
            echo $heading;
            echo "<center><table border=1><tr>
		<th>Code</th>
		
		<th>Customer Name</th>
		
		<th>" . $rtxtm1 . "</th>
		<th>" . $rtxtm2 . "</th>
		<th>" . $rtxtm3 . "</th>
                <th>" . $rtxtm4 . "</th>   
                <th>" . $rtxtm5 . "</th>
                <th>" . $rtxtm6 . "</th>";

            if ($_GET["radio"] == "Option2") {
                echo "<th>" . $rtxtm7 . "</th>    
                <th>" . $rtxtm8 . "</th>    
                <th>" . $rtxtm9 . "</th>    
                <th>" . $rtxtm10 . "</th>    
                <th>" . $rtxtm11 . "</th>    
                <th>" . $rtxtm12 . "</th> ";
            }

            echo "<th>Total</th>";
            echo "<th>Per. Month Avg.</th>";
            echo "</tr>";
            //echo $sql;

            $month1_tot = 0;
            $month2_tot = 0;
            $month3_tot = 0;
            $month4_tot = 0;
            $month5_tot = 0;
            $month6_tot = 0;
            $month7_tot = 0;
            $month8_tot = 0;
            $month9_tot = 0;
            $month10_tot = 0;
            $month11_tot = 0;
            $month12_tot = 0;

            $sql_sql = "SELECT cus_code,cus_name from 6monsales where cus_code <> '' group by cus_code,cus_name ";
            $result_sql = mysqli_query($GLOBALS['dbinv'], $sql_sql);

            while ($row_sql = mysqli_fetch_array($result_sql)) {
                $sql_sql1 = "SELECT sum(month1)as month1,sum(month2) as month2,sum(month3) as month3,sum(month4) as month4,sum(month5) as month5,sum(month6) as month6,sum(month7) as month7,sum(month8) as month8,sum(month9) as month9,sum(month10) as month10,sum(month11) as month11,sum(month12) as month12 from 6monsales where cus_code ='" . $row_sql["cus_code"] . "'   ";
                $result_sql1 = mysqli_query($GLOBALS['dbinv'], $sql_sql1);

                while ($row_sql1 = mysqli_fetch_array($result_sql1)) {

                    $sql_vendor = "select * from vendor where code ='" . $row_sql["cus_code"] . "' ";


                    echo "<tr>
				<td>" . $row_sql["cus_code"] . "</td>
				<td>" . $row_sql["cus_name"] . "</td>		
				<td align=\"right\">" . number_format($row_sql1["month1"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month2"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month3"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month4"], 2, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month5"], 2, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month6"], 2, ".", ",") . "</td>";
                    if ($_GET["radio"] == "Option2") {
                        echo "<td align=\"right\">" . number_format($row_sql1["month7"], 2, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month8"], 2, ".", ",") . "</td>                                
                                <td align=\"right\">" . number_format($row_sql1["month9"], 2, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month10"], 2, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month11"], 2, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month12"], 2, ".", ",") . "</td>";
                    }
                    $rowt = $row_sql1["month1"] + $row_sql1["month2"] + $row_sql1["month3"] + $row_sql1["month4"] + $row_sql1["month5"] + $row_sql1["month6"];
                    if ($_GET["radio"] == "Option2") {
                        $rowt = $rowt + $row_sql1["month7"] + $row_sql1["month8"] + $row_sql1["month9"] + $row_sql1["month10"] + $row_sql1["month11"] + $row_sql1["month12"];
                    }
                    echo "<td  align=\"right\" >" . number_format($rowt, 2, ".", ",") . "</td>";

                    if ($_GET["radio"] == "Option2") {
                        $avgmon = $rowt / 12;
                    } else {
                        $avgmon = $rowt / 6;
                    }

                    echo "<td  align=\"right\">" . number_format($avgmon, 2, ".", ",") . "</td>";

                    echo "</tr>";
                    $month1_tot = $month1_tot + $row_sql1["month1"];
                    $month2_tot = $month2_tot + $row_sql1["month2"];
                    $month3_tot = $month3_tot + $row_sql1["month3"];
                    $month4_tot = $month4_tot + $row_sql1["month4"];
                    $month5_tot = $month5_tot + $row_sql1["month5"];
                    $month6_tot = $month6_tot + $row_sql1["month6"];
                    $month7_tot = $month7_tot + $row_sql1["month7"];
                    $month8_tot = $month8_tot + $row_sql1["month8"];
                    $month9_tot = $month9_tot + $row_sql1["month9"];
                    $month10_tot = $month10_tot + $row_sql1["month10"];
                    $month11_tot = $month11_tot + $row_sql1["month11"];
                    $month12_tot = $month12_tot + $row_sql1["month12"];
                }
            }
            echo "<tr>
			<th colspan='2'>Total</td>
			
			
			<th align=\"right\"><b>" . number_format($month1_tot, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month2_tot, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month3_tot, 2, ".", ",") . "</b></th>	
			<th align=\"right\"><b>" . number_format($month4_tot, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month5_tot, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month6_tot, 2, ".", ",") . "</b></th>";
            if ($_GET["radio"] == "Option2") {
                echo "<th align=\"right\"><b>" . number_format($month7_tot, 2, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month8_tot, 2, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month9_tot, 2, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month10_tot, 2, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month11_tot, 2, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month12_tot, 2, ".", ",") . "</b></th>";
            }


            $rowft = $month1_tot + $month2_tot + $month3_tot + $month4_tot + $month5_tot + $month6_tot;
            if ($_GET["radio"] == "Option2") {
                $rowft = $rowft + $month7_tot + $month8_tot + $month9_tot + $month10_tot + $month11_tot + $month12_tot;
            }
            echo "<th  align=\"right\"><b>" . number_format($rowft, 2, ".", ",") . "</b></th>";


            if ($_GET["radio"] == "Option2") {
                $avgmon = $rowft / 12;
            } else {
                $avgmon = $rowft / 6;
            }

            echo "<th  align=\"right\"><b>" . number_format($avgmon, 2, ".", ",") . "</b></th>";



            echo "</tr>";
        }

        function PrintRep3() {
            require_once("connectioni.php");



            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

            $rtxtComName = $row_head["COMPANY"];
            $rtxtcomadd1 = $row_head["ADD1"];
            $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];
            if ($_GET["cmbrep"] != "All") {
                $rtxtrep = "Person : " . trim($_GET["cmbrep"]);
            }
            if ($_GET["cmbrep"] == "All") {
                $rtxtrep = "Person : " . $_GET["cmbrep"];
            }
            $rtxtbrand = "Brand : " . $_GET["cmbbrand"];

            $rtxtm1 = date("M", strtotime($_GET["month1"])) . " " . date("Y", strtotime($_GET["month1"]));
            $rtxtm2 = date("M", strtotime($_GET["month2"])) . " " . date("Y", strtotime($_GET["month2"]));
            $rtxtm3 = date("M", strtotime($_GET["month3"])) . " " . date("Y", strtotime($_GET["month3"]));
            $rtxtm4 = date("M", strtotime($_GET["month4"])) . " " . date("Y", strtotime($_GET["month4"]));
            $rtxtm5 = date("M", strtotime($_GET["month5"])) . " " . date("Y", strtotime($_GET["month5"]));
            $rtxtm6 = date("M", strtotime($_GET["month6"])) . " " . date("Y", strtotime($_GET["month6"]));
            $rtxtm7 = date("M", strtotime($_GET["month7"])) . " " . date("Y", strtotime($_GET["month7"]));
            $rtxtm8 = date("M", strtotime($_GET["month8"])) . " " . date("Y", strtotime($_GET["month8"]));
            $rtxtm9 = date("M", strtotime($_GET["month9"])) . " " . date("Y", strtotime($_GET["month9"]));
            $rtxtm10 = date("M", strtotime($_GET["month10"])) . " " . date("Y", strtotime($_GET["month10"]));
            $rtxtm11 = date("M", strtotime($_GET["month11"])) . " " . date("Y", strtotime($_GET["month11"]));
            $rtxtm12 = date("M", strtotime($_GET["month12"])) . " " . date("Y", strtotime($_GET["month12"]));

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";
            
            if ($_GET["radio"] == "Option3") {
                 echo "<center>3 Month Sales Summery";
            }elseif ($_GET["radio"] == "Option1") {
                 echo "<center>6 Month Sales Summery";
            }else{
                 echo "<center>12 Month Sales Summery";
            }
           
            echo $rtxtrep . "</br>";
            echo $rtxtbrand . "</br>";
            echo $heading;
            echo "<center><table border=1><tr>";

            if ($_GET["cmbreptype"] == "rep") {
                echo "<th>Rep Code</th>	
		  <th>Rep Name</th>";
            } else {
                echo "<th></th>	
		  <th>Brand Name</th>";
            }


            if ($_GET["radio"] == "Option3") {
                echo "<th>" . $rtxtm1 . "</th>
		<th>" . $rtxtm2 . "</th>
		<th>" . $rtxtm3 . "</th>";
            } elseif ($_GET["radio"] == "Option1") {
                echo "<th>" . $rtxtm1 . "</th>
		<th>" . $rtxtm2 . "</th>
		<th>" . $rtxtm3 . "</th>
                <th>" . $rtxtm4 . "</th>   
                <th>" . $rtxtm5 . "</th>
                <th>" . $rtxtm6 . "</th>";
            } else {
                echo "<th>" . $rtxtm1 . "</th>
		<th>" . $rtxtm2 . "</th>
		<th>" . $rtxtm3 . "</th>
                <th>" . $rtxtm4 . "</th>   
                <th>" . $rtxtm5 . "</th>
                <th>" . $rtxtm6 . "</th>
                <th>" . $rtxtm7 . "</th>    
                <th>" . $rtxtm8 . "</th>    
                <th>" . $rtxtm9 . "</th>    
                <th>" . $rtxtm10 . "</th>    
                <th>" . $rtxtm11 . "</th>    
                <th>" . $rtxtm12 . "</th> ";
            }


            echo "<th>Total</th>";
            echo "</tr>";
            //echo $sql;

            $month1_tot = 0;
            $month2_tot = 0;
            $month3_tot = 0;
            $month4_tot = 0;
            $month5_tot = 0;
            $month6_tot = 0;
            $month7_tot = 0;
            $month8_tot = 0;
            $month9_tot = 0;
            $month10_tot = 0;
            $month11_tot = 0;
            $month12_tot = 0;


            if ($_GET["cmbreptype"] == "rep") {
                $sql_sql = "SELECT sal_ex from 6monsales  group by sal_ex ";
            } else {
                $sql_sql = "SELECT brand from 6monsales  group by brand ";
            }
            $result_sql = mysqli_query($GLOBALS['dbinv'], $sql_sql);

            while ($row_sql = mysqli_fetch_array($result_sql)) {

                if ($_GET["cmbreptype"] == "rep") {
                    $sql_sql1 = "SELECT sum(month1)as month1,sum(month2) as month2,sum(month3) as month3,sum(month4) as month4,sum(month5) as month5,sum(month6) as month6,sum(month7) as month7,sum(month8) as month8,sum(month9) as month9,sum(month10) as month10,sum(month11) as month11,sum(month12) as month12 from 6monsales where sal_ex ='" . $row_sql["sal_ex"] . "'   ";
                } else {
                    $sql_sql1 = "SELECT sum(month1)as month1,sum(month2) as month2,sum(month3) as month3,sum(month4) as month4,sum(month5) as month5,sum(month6) as month6,sum(month7) as month7,sum(month8) as month8,sum(month9) as month9,sum(month10) as month10,sum(month11) as month11,sum(month12) as month12 from 6monsales where brand ='" . $row_sql["brand"] . "'   ";
                }
                $result_sql1 = mysqli_query($GLOBALS['dbinv'], $sql_sql1);

                while ($row_sql1 = mysqli_fetch_array($result_sql1)) {

                    if ($_GET["cmbreptype"] == "rep") {
                        $sql_vendor = "select * from s_salrep where repcode ='" . $row_sql["sal_ex"] . "' ";
                        $result_vendor = mysqli_query($GLOBALS['dbinv'], $sql_vendor);
                        $row_vendor = mysqli_fetch_array($result_vendor);
                    }

                    echo "<tr>";

                    if ($_GET["cmbreptype"] == "rep") {
                        echo "<td>" . $row_sql["sal_ex"] . "</td>
				<td>" . $row_vendor["Name"] . "</td>";
                    } else {
                        echo "<td></td>
				<td>" . $row_sql["brand"] . "</td>";
                    }

                    if ($_GET["radio"] == "Option3") {
                        echo "<td align=\"right\">" . number_format($row_sql1["month1"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month2"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month3"], 2, ".", ",") . "</td> ";
                    } elseif ($_GET["radio"] == "Option1") {
                        echo "<td align=\"right\">" . number_format($row_sql1["month1"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month2"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month3"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month4"], 2, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month5"], 2, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month6"], 2, ".", ",") . "</td>";
                    } else {
                        echo "<td align=\"right\">" . number_format($row_sql1["month1"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month2"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month3"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month4"], 2, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month5"], 2, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month6"], 2, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month7"], 2, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month8"], 2, ".", ",") . "</td>                                
                                <td align=\"right\">" . number_format($row_sql1["month9"], 2, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month10"], 2, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month11"], 2, ".", ",") . "</td>
                                <td align=\"right\">" . number_format($row_sql1["month12"], 2, ".", ",") . "</td>";
                    }
                    if ($_GET["radio"] == "Option3") {
                        $rowt = $row_sql1["month1"] + $row_sql1["month2"] + $row_sql1["month3"];
                    } elseif ($_GET["radio"] == "Option1") {
                        $rowt = $row_sql1["month1"] + $row_sql1["month2"] + $row_sql1["month3"] + $row_sql1["month4"] + $row_sql1["month5"] + $row_sql1["month6"];
                    } else {
                        $rowt = $row_sql1["month1"] + $row_sql1["month2"] + $row_sql1["month3"] + $row_sql1["month4"] + $row_sql1["month5"] + $row_sql1["month6"] + $row_sql1["month7"] + $row_sql1["month8"] + $row_sql1["month9"] + $row_sql1["month10"] + $row_sql1["month11"] + $row_sql1["month12"];
                    }

                    echo "<td  align=\"right\" >" . number_format($rowt, 2, ".", ",") . "</td>";
                    echo "</tr>";
                    $month1_tot = $month1_tot + $row_sql1["month1"];
                    $month2_tot = $month2_tot + $row_sql1["month2"];
                    $month3_tot = $month3_tot + $row_sql1["month3"];
                    $month4_tot = $month4_tot + $row_sql1["month4"];
                    $month5_tot = $month5_tot + $row_sql1["month5"];
                    $month6_tot = $month6_tot + $row_sql1["month6"];
                    $month7_tot = $month7_tot + $row_sql1["month7"];
                    $month8_tot = $month8_tot + $row_sql1["month8"];
                    $month9_tot = $month9_tot + $row_sql1["month9"];
                    $month10_tot = $month10_tot + $row_sql1["month10"];
                    $month11_tot = $month11_tot + $row_sql1["month11"];
                    $month12_tot = $month12_tot + $row_sql1["month12"];
                }
            }
            if ($_GET["radio"] == "Option3") {
                echo "<tr>
			<th colspan='2'>Total</th>
			
			
			<th align=\"right\"><b>" . number_format($month1_tot, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month2_tot, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month3_tot, 2, ".", ",") . "</b></th> ";
            } elseif ($_GET["radio"] == "Option1") {
                echo "<tr>
			<th colspan='2'>Total</th>
			 <th align=\"right\"><b>" . number_format($month1_tot, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month2_tot, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month3_tot, 2, ".", ",") . "</b></th>	
			<th align=\"right\"><b>" . number_format($month4_tot, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month5_tot, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month6_tot, 2, ".", ",") . "</b></th>";
            } else {
                echo "<tr>
			<th colspan='2'>Total</th>
			 <th align=\"right\"><b>" . number_format($month1_tot, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month2_tot, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month3_tot, 2, ".", ",") . "</b></th>	
			<th align=\"right\"><b>" . number_format($month4_tot, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month5_tot, 2, ".", ",") . "</b></th>
			<th align=\"right\"><b>" . number_format($month6_tot, 2, ".", ",") . "</b></th>
                        <th align=\"right\"><b>" . number_format($month7_tot, 2, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month8_tot, 2, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month9_tot, 2, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month10_tot, 2, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month11_tot, 2, ".", ",") . "</b></th>	                            
			<th align=\"right\"><b>" . number_format($month12_tot, 2, ".", ",") . "</b></th>";
            }

            if ($_GET["radio"] == "Option3") {
                $rowft = $month1_tot + $month2_tot + $month3_tot;
            } elseif ($_GET["radio"] == "Option1") {
                $rowft = $month1_tot + $month2_tot + $month3_tot + $month4_tot + $month5_tot + $month6_tot;
            } else {
                $rowft = $month1_tot + $month2_tot + $month3_tot + $month4_tot + $month5_tot + $month6_tot + $month7_tot + $month8_tot + $month9_tot + $month10_tot + $month11_tot + $month12_tot;
            }

            echo "<th  align=\"right\"><b>" . number_format($rowft, 2, ".", ",") . "</b></th>";

            echo "</tr>";
        }
        ?>


    </body>
</html>

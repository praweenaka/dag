<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>6 Month Sales Report</title>

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
            font-size: 10px;
        }
        td {
            font-size: 10px;
            border-bottom: none;
            border-top: none;
        }
    </style>

</head>

<body>

    <?php
    require_once ("connectioni.php");

    othersales();

        //        }

    function othersales() {

        $sql = "delete from 6moncons where user_id='" . $_SESSION["CURRENT_USER"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $date = date("Y-m-d", strtotime($_GET["DTPicker1"]));
        $caldays = " - 90 days";
        $tmpdate = date('Y-m-d', strtotime($date . $caldays));
        $i = 0;

        $strinv = "select stk_no,LEDINDI,sum(qty) as gtot,month(sdate) as month ,year(sdate) as year from viewstran where  (LEDINDI='INV' or LEDINDI = 'GRN' or LEDINDI = 'ARN') ";

        if ($_GET['cmbbrand'] != "All") {
            $strinv .= " and brand_name ='" . $_GET['cmbbrand'] . "'";
        }

        $strinv .= " and gen_no ='" . $_GET['cmbgen'] . "'";

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

        $strinv .= " and (( month(sdate) = '" . $month1 . "'  and year(sdate) = '" . $month1_y . "') ";
        $strinv .= " or ( month(sdate) = '" . $month2 . "'  and year(sdate) = '" . $month2_y . "') ";
        $strinv .= " or ( month(sdate) = '" . $month3 . "'  and year(sdate) = '" . $month3_y . "') ";
        $strinv .= " or ( month(sdate) = '" . $month4 . "'  and year(sdate) = '" . $month4_y . "') ";
        $strinv .= " or ( month(sdate) = '" . $month5 . "'  and year(sdate) = '" . $month5_y . "') ";
        $strinv .= " or ( month(sdate) = '" . $month6 . "'  and year(sdate) = '" . $month6_y . "') ";
        $strinv .= " or ( month(sdate) = '" . $month7 . "'  and year(sdate) = '" . $month7_y . "') ";
        $strinv .= " or ( month(sdate) = '" . $month8 . "'  and year(sdate) = '" . $month8_y . "') ";
        $strinv .= " or ( month(sdate) = '" . $month9 . "'  and year(sdate) = '" . $month9_y . "') ";
        $strinv .= " or ( month(sdate) = '" . $month10 . "'  and year(sdate) = '" . $month10_y . "') ";
        $strinv .= " or ( month(sdate) = '" . $month11 . "'  and year(sdate) = '" . $month11_y . "') ";
        $strinv .= " or ( month(sdate) = '" . $month12 . "'  and year(sdate) = '" . $month12_y . "')) ";
        $strinv .= "  group by stk_no,LEDINDI,year(sdate), month(sdate) ";

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

        $j = 0;
        $i = 0;
            //echo $strinv;
        $result2 = mysqli_query($GLOBALS['dbinv'], $strinv);
        while ($row_RSINVO01 = mysqli_fetch_array($result2)) {

            $yy = "y";

            if ($yy == "y") {
                $mtot = 0;
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

                $pmon1 = 0;
                $pmon2 = 0;
                $pmon3 = 0;
                $pmon4 = 0;
                $pmon5 = 0;
                $pmon6 = 0;
                $pmon7 = 0;
                $pmon8 = 0;
                $pmon9 = 0;
                $pmon10 = 0;
                $pmon11 = 0;
                $pmon12 = 0;

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
                $pmtot = 0;

                if ($row_RSINVO01["LEDINDI"] == "INV") {
                    $mtot = $row_RSINVO01["gtot"];
                }

                if ($row_RSINVO01["LEDINDI"] == "GRN") {
                    $mtot = $row_RSINVO01["gtot"] * -1;
                }
                if ($row_RSINVO01["LEDINDI"] == "ARN") {
                    $pmtot = $row_RSINVO01["gtot"];
                }

                $sql_rsVENDOR = "SELECT * FROM s_mas WHERE stk_no='" . trim($row_RSINVO01['STK_NO']) . "' ";
                $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sql_rsVENDOR);
                $row_rsVENDOR = mysqli_fetch_array($result_rsVENDOR);

                if ($month1 == $row_RSINVO01["month"] and $month1_y == $row_RSINVO01["year"]) {
                    $mon1 = ($mtot);
                    $pmon1 = ($pmtot);
                }

                if ($month2 == $row_RSINVO01["month"] and $month2_y == $row_RSINVO01["year"]) {
                    $mon2 = ($mtot);
                    $pmon2 = ($pmtot);
                }
                if ($month3 == $row_RSINVO01["month"] and $month3_y == $row_RSINVO01["year"]) {
                    $mon3 = ($mtot);
                    $pmon3 = ($pmtot);
                }
                if ($month4 == $row_RSINVO01["month"] and $month4_y == $row_RSINVO01["year"]) {
                    $mon4 = ($mtot);
                    $pmon4 = ($pmtot);
                }
                if ($month5 == $row_RSINVO01["month"] and $month5_y == $row_RSINVO01["year"]) {
                    $mon5 = ($mtot);
                    $pmon5 = ($pmtot);
                }
                if ($month6 == $row_RSINVO01["month"] and $month6_y == $row_RSINVO01["year"]) {
                    $mon6 = ($mtot);
                    $pmon6 = ($pmtot);
                }
                if ($month7 == $row_RSINVO01["month"] and $month7_y == $row_RSINVO01["year"]) {
                    $mon7 = ($mtot);
                    $pmon6 = ($pmtot);
                }
                if ($month8 == $row_RSINVO01["month"] and $month8_y == $row_RSINVO01["year"]) {
                    $mon8 = ($mtot);
                    $pmon8 = ($pmtot);
                }

                if ($month9 == $row_RSINVO01["month"] and $month9_y == $row_RSINVO01["year"]) {
                    $mon9 = ($mtot);
                    $pmon9 = ($pmtot);
                }

                if ($month10 == $row_RSINVO01["month"] and $month10_y == $row_RSINVO01["year"]) {
                    $mon10 = ($mtot);
                    $pmon10 = ($pmtot);
                }

                if ($month11 == $row_RSINVO01["month"] and $month11_y == $row_RSINVO01["year"]) {
                    $mon11 = ($mtot);
                    $pmon11 = ($pmtot);
                }

                if ($month12 == $row_RSINVO01["month"] and $month12_y == $row_RSINVO01["year"]) {
                    $mon12 = ($mtot);
                    $pmon12 = ($pmtot);
                }

                $cat = $row_rsVENDOR["CAT"];

                $insert[] = "('" . $row_RSINVO01['STK_NO'] . "', '" . $row_rsVENDOR["PART_NO"] . " " . $row_rsVENDOR["DESCRIPT"] . "',  '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "' , '" . ($mon4 - $Gmon4) . "','" . ($mon5 - $Gmon5) . "','" . ($mon6 - $Gmon6) . "', '" . ($mon7 - $Gmon7) . "', '" . ($mon8 - $Gmon8) . "', '" . ($mon9 - $Gmon9) . "' , '" . ($mon10 - $Gmon10) . "','" . ($mon11 - $Gmon11) . "','" . ($mon12 - $Gmon12) . "','','" . $row_rsVENDOR['BRAND_NAME'] . "', '" . $_SESSION["CURRENT_USER"] . "','" . ($pmon1) . "', '" . ($pmon2) . "', '" . ($pmon3) . "' , '" . ($pmon4) . "','" . ($pmon5) . "','" . ($pmon6) . "', '" . ($pmon7) . "', '" . ($pmon8) . "', '" . ($pmon9) . "' , '" . ($pmon10) . "','" . ($pmon11) . "','" . ($pmon12) . "' ,  '" . $row_rsVENDOR["model"] . "', '" . $row_rsVENDOR["GROUP1"] . "','" . $row_rsVENDOR["GROUP2"] . "')";
            }
        }

        $sql_RSMONSALES = "insert into 6moncons(Cus_Code, cus_name, cat,  month1, month2, month3,month4,month5,month6,month7,month8,month9,month10,month11,month12,sal_ex,brand, user_id, pmon1, pmon2, pmon3,pmon4,pmon5,pmon6,pmon7,pmon8,pmon9,pmon10,pmon11,pmon12,model,group1,group2) values " . implode(",", $insert);

        $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sql_RSMONSALES);

        $sql_rsVENDOR = "SELECT * FROM s_mas where gen_no <>'' ";
        if ($_GET['cmbbrand'] != "All") {
            $sql_rsVENDOR .= " and brand_name ='" . $_GET['cmbbrand'] . "'";
        }

        $sql_rsVENDOR .= " and gen_no ='" . $_GET['cmbgen'] . "'";


        $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sql_rsVENDOR);
        while ($row_rsVENDOR = mysqli_fetch_array($result_rsVENDOR)) {
            $ssq = "select * from 6moncons where cus_code = '" . $row_rsVENDOR['STK_NO'] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'";
            $result_rsVENDOR1 = mysqli_query($GLOBALS['dbinv'], $ssq);
            if ($row_rsVENDOR1 = mysqli_fetch_array($result_rsVENDOR1)) {

            } else {
                $cat = $row_rsVENDOR["CAT"];
                $insert1[] = "('" . $row_rsVENDOR['STK_NO'] . "', '" . $row_rsVENDOR["PART_NO"] . " " . $row_rsVENDOR["DESCRIPT"] . "',  '" . $cat . "', '0', '0', '0' , '0','0','0', '0', '0', '0' , '0','0','0','','" . $row_rsVENDOR['BRAND_NAME'] . "', '" . $_SESSION["CURRENT_USER"] . "','0', '0', '0' , '0','0','0', '0', '0', '0' , '0','0','0' ,  '" . $row_rsVENDOR["model"] . "', '" . $row_rsVENDOR["GROUP1"] . "','" . $row_rsVENDOR["GROUP2"] . "')";
            }
        }
        $sql_RSMONSALES = "insert into 6moncons(Cus_Code, cus_name, cat,  month1, month2, month3,month4,month5,month6,month7,month8,month9,month10,month11,month12,sal_ex,brand, user_id, pmon1, pmon2, pmon3,pmon4,pmon5,pmon6,pmon7,pmon8,pmon9,pmon10,pmon11,pmon12,model,group1,group2) values " . implode(",", $insert1);

        $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sql_RSMONSALES);



        $i = $i + 1;
        if ($_GET["radio1"] == "opdetail") {
            PrintRep2();
        } else {
            PrintRep1();
        }
    }

    function PrintRep2() {
            //echo "aaaa";
        require_once ("connectioni.php");

        $sql_head = "select * from invpara";
        $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
        $row_head = mysqli_fetch_array($result_head);

        $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

        $rtxtComName = $row_head["COMPANY"];
        $rtxtcomadd1 = $row_head["ADD1"];
        $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];

        $rtxtbrand = "Brand : " . $_GET["cmbbrand"];
        $rtxtbrand1 = "GEN No : " . $_GET["cmbgen"];
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
            echo "<center>12 Stock Consumption Summery";
        } else {
            echo "<center>6 Stock Consumption Summery";
        }
        echo $rtxtrep . "</br>";
        echo $rtxtbrand . "</br>";
        echo $rtxtbrand1 ;

        echo "<center><table border=1><tr>
        <th rowspan='2' width='30'>Code</th>

        <th rowspan='2' width='250'>Name</th>

        <th colspan='2'>" . $rtxtm1 . "</th>
        <th colspan='2'>" . $rtxtm2 . "</th>
        <th colspan='2'>" . $rtxtm3 . "</th>
        <th colspan='2'>" . $rtxtm4 . "</th>   
        <th colspan='2'>" . $rtxtm5 . "</th>
        <th colspan='2'>" . $rtxtm6 . "</th>";

        if ($_GET["radio"] == "Option2") {
            echo "<th colspan='2'>" . $rtxtm7 . "</th>    
            <th colspan='2' >" . $rtxtm8 . "</th>    
            <th colspan='2'>" . $rtxtm9 . "</th>    
            <th colspan='2'>" . $rtxtm10 . "</th>    
            <th colspan='2'>" . $rtxtm11 . "</th>    
            <th colspan='2'>" . $rtxtm12 . "</th> ";
        }

        echo "<th  width='30' rowspan='2'>Total</th>";
        echo "<th  width='30' rowspan='2'>Per. Month Avg.</th>";
        echo "<th  width='30' rowspan='2'>Pending Orders.</th>";
        echo "<th  width='30' rowspan='2'>Stock In Hand</th>";
        echo "<th  width='30' rowspan='2'>Over 90</th>";
        echo "</tr>";

        echo "<tr>

        <th width='30'>Purchase</th>
        <th width='30'>Sale</th>
        <th width='30'>Purchase</th>
        <th width='30'>Sale</th>
        <th width='30'>Purchase</th>
        <th width='30'>Sale</th>
        <th width='30'>Purchase</th>
        <th width='30'>Sale</th>
        <th width='30'>Purchase</th>
        <th width='30'>Sale</th>
        <th width='30'>Purchase</th>
        <th width='30'>Sale</th>";

        if ($_GET["radio"] == "Option2") {
            echo "<th width='30'>Purchase</th>
            <th width='30'>Sale</th>
            <th width='30'>Purchase</th>
            <th width='30'>Sale</th>
            <th width='30'>Purchase</th>
            <th width='30'>Sale</th>
            <th width='30'>Purchase</th>
            <th width='30'>Sale</th>
            <th width='30'>Purchase</th>
            <th width='30'>Sale</th>
            <th width='30'>Purchase</th>
            <th width='30'>Sale</th>";
        }

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

        $sql_sql = "SELECT cus_code,cus_name from 6moncons where cus_code <> '' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by cus_code,cus_name order by  model,group1,group2";
        $result_sql = mysqli_query($GLOBALS['dbinv'], $sql_sql);

        while ($row_sql = mysqli_fetch_array($result_sql)) {
            $sql_sql1 = "SELECT sum(month1)as month1,sum(month2) as month2,sum(month3) as month3,sum(month4) as month4,sum(month5) as month5,sum(month6) as month6,sum(month7) as month7,sum(month8) as month8,sum(month9) as month9,sum(month10) as month10,sum(month11) as month11,sum(month12) as month12,sum(pmon1) as pmon1,sum(pmon2) as pmon2,sum(pmon3) as pmon3,sum(pmon4) as pmon4,sum(pmon5) as pmon5,sum(pmon6) as pmon6,sum(pmon7) as pmon7,sum(pmon8) as pmon8,sum(pmon9) as pmon9,sum(pmon10) as pmon10,sum(pmon11) as pmon11,sum(pmon12) as pmon12 from 6moncons where cus_code ='" . $row_sql["cus_code"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'";
            $result_sql1 = mysqli_query($GLOBALS['dbinv'], $sql_sql1);

            while ($row_sql1 = mysqli_fetch_array($result_sql1)) {

                $sql_vendor = "select * from vendor where code ='" . $row_sql["cus_code"] . "' ";

                $rowt = $row_sql1["month1"] + $row_sql1["month2"] + $row_sql1["month3"] + $row_sql1["month4"] + $row_sql1["month5"] + $row_sql1["month6"];
                if ($_GET["radio"] == "Option2") {
                    $rowt = $rowt + $row_sql1["month7"] + $row_sql1["month8"] + $row_sql1["month9"] + $row_sql1["month10"] + $row_sql1["month11"] + $row_sql1["month12"];
                }

                $ordqty = 0;
                $sql = "select sum(ord_qty) as ord_qty from vieword where stk_no='" . $row_sql["cus_code"] . "'and cancel=0 ";
                $result_LASTAR1 = mysqli_query($GLOBALS['dbinv'], $sql);
                While ($row_LASTAR1 = mysqli_fetch_array($result_LASTAR1)) {
                    if (!is_null($row_LASTAR1["ord_qty"])) {
                        $ordqty = $row_LASTAR1['ord_qty'];
                    }
                }

                if ($_GET["radio"] == "Option2") {
                    $avgmon = $rowt / 12;
                } else {
                    $avgmon = $rowt / 6;
                }

                if(($rowt!=0) or ($ordqty!=0) ){
                    

                        echo "<tr>

                        <td>" . $row_sql["cus_code"] . "</td>
                        <td>" . $row_sql["cus_name"] . "</td>		
                        <td align=\"right\">" . number_format($row_sql1["pmon1"], 0, ".", ",") . "</td>				
                        <td align=\"right\">" . number_format($row_sql1["month1"], 0, ".", ",") . "</td>
                        <td align=\"right\">" . number_format($row_sql1["pmon2"], 0, ".", ",") . "</td>    
                        <td align=\"right\">" . number_format($row_sql1["month2"], 0, ".", ",") . "</td>
                        <td align=\"right\">" . number_format($row_sql1["pmon3"], 0, ".", ",") . "</td>
                        <td align=\"right\">" . number_format($row_sql1["month3"], 0, ".", ",") . "</td>
                        <td align=\"right\">" . number_format($row_sql1["pmon4"], 0, ".", ",") . "</td>
                        <td align=\"right\">" . number_format($row_sql1["month4"], 0, ".", ",") . "</td>
                        <td align=\"right\">" . number_format($row_sql1["pmon5"], 0, ".", ",") . "</td>
                        <td align=\"right\">" . number_format($row_sql1["month5"], 0, ".", ",") . "</td>
                        <td align=\"right\">" . number_format($row_sql1["pmon6"], 0, ".", ",") . "</td>
                        <td align=\"right\">" . number_format($row_sql1["month6"], 0, ".", ",") . "</td>";
                        if ($_GET["radio"] == "Option2") {

                            echo "<td align=\"right\">" . number_format($row_sql1["pmon7"], 0, ".", ",") . "</td>
                            <td align=\"right\">" . number_format($row_sql1["month7"], 0, ".", ",") . "</td>
                            <td align=\"right\">" . number_format($row_sql1["pmon8"], 0, ".", ",") . "</td>
                            <td align=\"right\">" . number_format($row_sql1["month8"], 0, ".", ",") . "</td> 
                            <td align=\"right\">" . number_format($row_sql1["pmon9"], 0, ".", ",") . "</td>    
                            <td align=\"right\">" . number_format($row_sql1["month9"], 0, ".", ",") . "</td>
                            <td align=\"right\">" . number_format($row_sql1["pmon10"], 0, ".", ",") . "</td>
                            <td align=\"right\">" . number_format($row_sql1["month10"], 0, ".", ",") . "</td>
                            <td align=\"right\">" . number_format($row_sql1["pmon11"], 0, ".", ",") . "</td>
                            <td align=\"right\">" . number_format($row_sql1["month11"], 0, ".", ",") . "</td>
                            <td align=\"right\">" . number_format($row_sql1["pmon12"], 0, ".", ",") . "</td>
                            <td align=\"right\">" . number_format($row_sql1["month12"], 0, ".", ",") . "</td>";
                        }





                        echo "<td  align=\"right\" >" . number_format($rowt, 0, ".", ",") . "</td>";





                        echo "<td  align=\"right\">" . number_format($avgmon, 0, ".", ",") . "</td>";
                        echo "<td  align=\"right\" >" . number_format($ordqty, 0, ".", ",") . "</td>";

                        $sql = "select * from s_mas where stk_no='" . $row_sql["cus_code"] . "' ";
                        $result_LASTAR1 = mysqli_query($GLOBALS['dbinv'], $sql);
                        $row_LASTAR1 = mysqli_fetch_array($result_LASTAR1);

                        echo "<td  align=\"right\" >" . number_format($row_LASTAR1['QTYINHAND'], 0, ".", ",") . "</td>";


                        $date = date("Y-m-d");
                        $date = strtotime(date("Y-m-d", strtotime($date)) . " -91 days");
                        $dt = date("Y-m-d", $date);

                        $sql_rs = "select sum(REC_QTY) as stk from s_purtrn where STK_NO='" . $row_LASTAR1["STK_NO"] . "' and CANCEL='0' and SDATE > '" . $dt . "' ";
                        $result_rs = mysqli_query($GLOBALS['dbinv'], $sql_rs);
                        $row_rs = mysqli_fetch_array($result_rs);
                        $mnewstk = 0;
                        $munsold = 0;

                        if (!is_null($row_rs["stk"])) {
                            $mnewstk = $row_rs["stk"];
                        }

                        if ($row_LASTAR1["QTYINHAND"] > $mnewstk) {
                            $munsold = $row_LASTAR1["QTYINHAND"] - $mnewstk;
                        }

                        echo "<td  align=\"right\" >" . number_format($munsold, 0, ".", ",") . "</td>";

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

                        $pmon1 = $pmon1 + $row_sql1["pmon1"];
                        $pmon2 = $pmon2 + $row_sql1["pmon2"];
                        $pmon3 = $pmon3 + $row_sql1["pmon3"];
                        $pmon4 = $pmon4 + $row_sql1["pmon4"];
                        $pmon5 = $pmon5 + $row_sql1["pmon5"];
                        $pmon6 = $pmon6 + $row_sql1["pmon6"];
                        $pmon7 = $pmon7 + $row_sql1["pmon7"];
                        $pmon8 = $pmon8 + $row_sql1["pmon8"];
                        $pmon9 = $pmon9 + $row_sql1["pmon9"];
                        $pmon10 = $pmon10 + $row_sql1["pmon10"];
                        $pmon11 = $pmon11 + $row_sql1["pmon11"];
                        $pmon12 = $pmon12 + $row_sql1["pmon12"];


                    

                }else{

                    echo "<tr  align=\"right\" >  </tr>";
                }

            }
        }




        echo "<tr>
        <th colspan='2'>Total</td>

        <th align=\"right\"><b>" . number_format($pmon1, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($month1_tot, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($pmon2, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($month2_tot, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($pmon3, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($month3_tot, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($pmon4, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($month4_tot, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($pmon5, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($month5_tot, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($pmon6, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($month6_tot, 0, ".", ",") . "</b></th>";
        if ($_GET["radio"] == "Option2") {

            echo "  <th align=\"right\"><b>" . number_format($pmon7, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($month7_tot, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($pmon8, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($month8_tot, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($pmon9, 0, ".", ",") . "</b></th>    
            <th align=\"right\"><b>" . number_format($month9_tot, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($pmon10, 0, ".", ",") . "</b></th>   
            <th align=\"right\"><b>" . number_format($month10_tot, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($pmon11, 0, ".", ",") . "</b></th>    
            <th align=\"right\"><b>" . number_format($month11_tot, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($pmon12, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($month12_tot, 0, ".", ",") . "</b></th>";
        }

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

        echo "<th  align=\"right\"><b>" . number_format($avgmon, 0, ".", ",") . "</b></th>";


        echo "<th align=\"right\"><b></b></th>";
        echo "<th align=\"right\"><b></b></th>";
        echo "<th align=\"right\"><b></b></th>";
        echo "</tr>";







        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";

        echo "<table  border=0>

        <tr>
        <td colspan='3'>&nbsp;</td>
        </tr>
        <tr>
        <td colspan='3'>&nbsp;</td>
        </tr>

        <tr>
        <td colspan='3'>&nbsp;</td>
        </tr>


        <tr>
        <td width='250' colspan='2'>
        __________________________
        </td>

        <td width='250' colspan='2'>
        __________________________
        </td>			


        <td width='250' colspan='2'>
        __________________________
        </td>	
        </tr>



        <tr>
        <td width='250' colspan='2'>
        Marketing Manager
        </td>

        <td width='250' colspan='2'>
        Working Director
        </td>			


        <td width='250' colspan='2'>
        Managing Director
        </td>	

        </tr></table>";
    }


    function PrintRep1() {
            //echo "aaaa";
        require_once ("connectioni.php");

        $sql_head = "select * from invpara";
        $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
        $row_head = mysqli_fetch_array($result_head);

        $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

        $rtxtComName = $row_head["COMPANY"];
        $rtxtcomadd1 = $row_head["ADD1"];
        $rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];

        $rtxtbrand = "Brand : " . $_GET["cmbbrand"];
        $rtxtbrand1 = "GEN No : " . $_GET["cmbgen"];
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
            echo "<center>12 Stock Consumption Summery";
        } else {
            echo "<center>6 Stock Consumption Summery";
        }
        echo $rtxtrep . "</br>";
        echo $rtxtbrand . "</br>";
        echo $rtxtbrand1  ;


        echo "<center>
        <table border=1><tr>
        <th rowspan='2' width='30'>Code</th>

        <th rowspan='2' width='250'>Name</th>

        <th colspan='2'>" . $rtxtm1 . "</th>
        <th colspan='2'>" . $rtxtm2 . "</th>
        <th colspan='2'>" . $rtxtm3 . "</th>
        <th colspan='2'>" . $rtxtm4 . "</th>   
        <th colspan='2'>" . $rtxtm5 . "</th>
        <th colspan='2'>" . $rtxtm6 . "</th>";

        if ($_GET["radio"] == "Option2") {
            echo "<th colspan='2'>" . $rtxtm7 . "</th>    
            <th colspan='2' >" . $rtxtm8 . "</th>    
            <th colspan='2'>" . $rtxtm9 . "</th>    
            <th colspan='2'>" . $rtxtm10 . "</th>    
            <th colspan='2'>" . $rtxtm11 . "</th>    
            <th colspan='2'>" . $rtxtm12 . "</th> ";
        }

        echo "<th  width='30' rowspan='2'>Total</th>";
        echo "<th  width='30' rowspan='2'>Per. Month Avg.</th>";

        echo "</tr>";

        echo "<tr>

        <th width='30'>Purchase</th>
        <th width='30'>Sale</th>
        <th width='30'>Purchase</th>
        <th width='30'>Sale</th>
        <th width='30'>Purchase</th>
        <th width='30'>Sale</th>
        <th width='30'>Purchase</th>
        <th width='30'>Sale</th>
        <th width='30'>Purchase</th>
        <th width='30'>Sale</th>
        <th width='30'>Purchase</th>
        <th width='30'>Sale</th>";

        if ($_GET["radio"] == "Option2") {
            echo "<th width='30'>Purchase</th>
            <th width='30'>Sale</th>
            <th width='30'>Purchase</th>
            <th width='30'>Sale</th>
            <th width='30'>Purchase</th>
            <th width='30'>Sale</th>
            <th width='30'>Purchase</th>
            <th width='30'>Sale</th>
            <th width='30'>Purchase</th>
            <th width='30'>Sale</th>
            <th width='30'>Purchase</th>
            <th width='30'>Sale</th>";
        }

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

        $sql_sql = "SELECT brand from 6moncons where cus_code <> '' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by brand order by brand";
        $result_sql = mysqli_query($GLOBALS['dbinv'], $sql_sql);

        while ($row_sql = mysqli_fetch_array($result_sql)) {
            $sql_sql1 = "SELECT sum(month1)as month1,sum(month2) as month2,sum(month3) as month3,sum(month4) as month4,sum(month5) as month5,sum(month6) as month6,sum(month7) as month7,sum(month8) as month8,sum(month9) as month9,sum(month10) as month10,sum(month11) as month11,sum(month12) as month12,sum(pmon1) as pmon1,sum(pmon2) as pmon2,sum(pmon3) as pmon3,sum(pmon4) as pmon4,sum(pmon5) as pmon5,sum(pmon6) as pmon6,sum(pmon7) as pmon7,sum(pmon8) as pmon8,sum(pmon9) as pmon9,sum(pmon10) as pmon10,sum(pmon11) as pmon11,sum(pmon12) as pmon12 from 6moncons where brand ='" . $row_sql["brand"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'";
            $result_sql1 = mysqli_query($GLOBALS['dbinv'], $sql_sql1);

            while ($row_sql1 = mysqli_fetch_array($result_sql1)) {



                echo "<tr>
                <td></td>
                <td>" . $row_sql["brand"] . "</td>		
                <td align=\"right\">" . number_format($row_sql1["pmon1"], 0, ".", ",") . "</td>				
                <td align=\"right\">" . number_format($row_sql1["month1"], 0, ".", ",") . "</td>
                <td align=\"right\">" . number_format($row_sql1["pmon2"], 0, ".", ",") . "</td>    
                <td align=\"right\">" . number_format($row_sql1["month2"], 0, ".", ",") . "</td>
                <td align=\"right\">" . number_format($row_sql1["pmon3"], 0, ".", ",") . "</td>
                <td align=\"right\">" . number_format($row_sql1["month3"], 0, ".", ",") . "</td>
                <td align=\"right\">" . number_format($row_sql1["pmon4"], 0, ".", ",") . "</td>
                <td align=\"right\">" . number_format($row_sql1["month4"], 0, ".", ",") . "</td>
                <td align=\"right\">" . number_format($row_sql1["pmon5"], 0, ".", ",") . "</td>
                <td align=\"right\">" . number_format($row_sql1["month5"], 0, ".", ",") . "</td>
                <td align=\"right\">" . number_format($row_sql1["pmon6"], 0, ".", ",") . "</td>
                <td align=\"right\">" . number_format($row_sql1["month6"], 0, ".", ",") . "</td>";
                if ($_GET["radio"] == "Option2") {

                    echo "<td align=\"right\">" . number_format($row_sql1["pmon7"], 0, ".", ",") . "</td>
                    <td align=\"right\">" . number_format($row_sql1["month7"], 0, ".", ",") . "</td>
                    <td align=\"right\">" . number_format($row_sql1["pmon8"], 0, ".", ",") . "</td>
                    <td align=\"right\">" . number_format($row_sql1["month8"], 0, ".", ",") . "</td> 
                    <td align=\"right\">" . number_format($row_sql1["pmon9"], 0, ".", ",") . "</td>    
                    <td align=\"right\">" . number_format($row_sql1["month9"], 0, ".", ",") . "</td>
                    <td align=\"right\">" . number_format($row_sql1["pmon10"], 0, ".", ",") . "</td>
                    <td align=\"right\">" . number_format($row_sql1["month10"], 0, ".", ",") . "</td>
                    <td align=\"right\">" . number_format($row_sql1["pmon11"], 0, ".", ",") . "</td>
                    <td align=\"right\">" . number_format($row_sql1["month11"], 0, ".", ",") . "</td>
                    <td align=\"right\">" . number_format($row_sql1["pmon12"], 0, ".", ",") . "</td>
                    <td align=\"right\">" . number_format($row_sql1["month12"], 0, ".", ",") . "</td>";
                }
                $rowt = $row_sql1["month1"] + $row_sql1["month2"] + $row_sql1["month3"] + $row_sql1["month4"] + $row_sql1["month5"] + $row_sql1["month6"];
                if ($_GET["radio"] == "Option2") {
                    $rowt = $rowt + $row_sql1["month7"] + $row_sql1["month8"] + $row_sql1["month9"] + $row_sql1["month10"] + $row_sql1["month11"] + $row_sql1["month12"];
                }
                echo "<td  align=\"right\" >" . number_format($rowt, 0, ".", ",") . "</td>";



                if ($_GET["radio"] == "Option2") {
                    $avgmon = $rowt / 12;
                } else {
                    $avgmon = $rowt / 6;
                }

                echo "<td  align=\"right\">" . number_format($avgmon, 0, ".", ",") . "</td>";







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

                $pmon1 = $pmon1 + $row_sql1["pmon1"];
                $pmon2 = $pmon2 + $row_sql1["pmon2"];
                $pmon3 = $pmon3 + $row_sql1["pmon3"];
                $pmon4 = $pmon4 + $row_sql1["pmon4"];
                $pmon5 = $pmon5 + $row_sql1["pmon5"];
                $pmon6 = $pmon6 + $row_sql1["pmon6"];
                $pmon7 = $pmon7 + $row_sql1["pmon7"];
                $pmon8 = $pmon8 + $row_sql1["pmon8"];
                $pmon9 = $pmon9 + $row_sql1["pmon9"];
                $pmon10 = $pmon10 + $row_sql1["pmon10"];
                $pmon11 = $pmon11 + $row_sql1["pmon11"];
                $pmon12 = $pmon12 + $row_sql1["pmon12"];
            }
        }
        echo "<tr>
        <th colspan='2'>Total</td>

        <th align=\"right\"><b>" . number_format($pmon1, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($month1_tot, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($pmon2, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($month2_tot, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($pmon3, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($month3_tot, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($pmon4, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($month4_tot, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($pmon5, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($month5_tot, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($pmon6, 0, ".", ",") . "</b></th>
        <th align=\"right\"><b>" . number_format($month6_tot, 0, ".", ",") . "</b></th>";
        if ($_GET["radio"] == "Option2") {

            echo "  <th align=\"right\"><b>" . number_format($pmon7, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($month7_tot, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($pmon8, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($month8_tot, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($pmon9, 0, ".", ",") . "</b></th>    
            <th align=\"right\"><b>" . number_format($month9_tot, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($pmon10, 0, ".", ",") . "</b></th>   
            <th align=\"right\"><b>" . number_format($month10_tot, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($pmon11, 0, ".", ",") . "</b></th>    
            <th align=\"right\"><b>" . number_format($month11_tot, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($pmon12, 0, ".", ",") . "</b></th>
            <th align=\"right\"><b>" . number_format($month12_tot, 0, ".", ",") . "</b></th>";
        }

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

        echo "<th  align=\"right\"><b>" . number_format($avgmon, 0, ".", ",") . "</b></th>";



        echo "</tr>";


        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";

        echo "<table  border=0>

        <tr>
        <td colspan='3'>&nbsp;</td>
        </tr>
        <tr>
        <td colspan='3'>&nbsp;</td>
        </tr>

        <tr>
        <td colspan='3'>&nbsp;</td>
        </tr>


        <tr>
        <td width='250' colspan='2'>
        __________________________
        </td>

        <td width='250' colspan='2'>
        __________________________
        </td>			


        <td width='250' colspan='2'>
        __________________________
        </td>	
        </tr>



        <tr>
        <td width='250' colspan='2'>
        Marketing Manager
        </td>

        <td width='250' colspan='2'>
        Working Director
        </td>			


        <td width='250' colspan='2'>
        Managing Director
        </td>	

        </tr></table>";
    }


    ?>
</body>
</html>

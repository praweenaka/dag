<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sales Summery</title>
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
        <!-- Progress bar holder -->


        <?php
        if ($_SESSION["CURRENT_USER"] == "") {
            exit("Please login again !");
        }

        require_once("connectioni.php");



        $sql_tmp = "delete from tmpqtysale where user_id='" . $_SESSION["CURRENT_USER"] . "'";
        $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);


        //$insert="";
        //echo "dddddddddd ". $_GET["cmbtype"];
        if ($_GET["cmbdev"] == "All") {
            $GLOBALS['dev'] = "A";
        }
        if ($_GET["cmbdev"] == "Manual") {
            $GLOBALS['dev'] = "0";
        }
        if ($_GET["cmbdev"] == "Computer") {
            $GLOBALS['dev'] = "1";
        }



        prin();

/////////// Sales Summery////////////////////////////////////////
        function prin() {
            // $insert=array();
            $j = 0;

            require_once("connectioni.php");





            $sqlinv = "select * from viewinv1  where   SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancel_m='0'  ";
            if ($_GET["cmbrep"] != "All") {
                $sqlinv .= " and sal_ex='" . $_GET["cmbrep"] . "'";
            }
            if (isset($_GET["Chk_cus"])) {
                if ($_GET["Chk_cus"] == "on") {
                    $sqlinv .= " and cus_code='" . trim($_GET["cuscode"]) . "'";
                }
            }
            if ($_GET["cmbbrand"] != "All") {
                $sqlinv .= " and s_brand = '" . trim($_GET["cmbbrand"]) . "'";
            }

            //if ($GLOBALS[$dev] == "A") {
            //   $sqlinv .=" and Dev != '" . $GLOBALS['dev']  . "'";
            //}

            if ($_GET["cmb_t"] != "ALL") {
                $sqlinv .=" and type = '" . $_GET["cmb_t"] . "'";
            }

            if ((isset($_GET["Chk_cus_wise"]) and ($_GET['cmbtype'] == "Summary")) or (isset($_GET["Chk_cus"]))) {
                $sqlinv .=" and price <> '0'";
            }



            if (!isset($_GET["chk_over"])) {
                $sqlinv .= " and stk_no <> 'SC01' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0797'  and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'A0356' and stk_no <> 'L0531' and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003'  and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003' and stk_no <> 'AL004' and stk_no <> 'AL005' and stk_no <> 'AL006' and stk_no <> 'AL007' and stk_no <> 'AL008' and stk_no <> 'AL009'  and stk_no <>'A0359'  and stk_no <>'AL011' and dis_per <> 100";
            } else {
                $sqlinv .= " and stk_no <> '06432' and stk_no <> '06433' and stk_no <> 'M6424' and stk_no <> 'M6425' and stk_no <> '06055' and stk_no <> '06426' and stk_no <> '06428' and  stk_no <> '06173' and stk_no <> '06169' and stk_no <> '06160' and stk_no <> '06155' and stk_no <> 'SC01' and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003'  and stk_no <>'A0359' and stk_no <>'AL011' and dis_per <> 100 ";
            }



            $sqlgrn = "select * from viewcrntrn  where   SDATE >= '" . $_GET["DTfrom"] . "' and SDATE <= '" . $_GET["DTTO"] . "' and cancell='0'  ";

            if ($_GET["cmbrep"] != "All") {
                $sqlgrn .= " and sal_ex='" . $_GET["cmbrep"] . "'";
            }
            if (isset($_GET["Chk_cus"])) {
                if ($_GET["Chk_cus"] == "on") {
                    $sqlgrn .= " and c_code='" . trim($_GET["cuscode"]) . "'";
                }
            }
            if ($_GET["cmbbrand"] != "All") {
                $sqlgrn .= " and brand = '" . trim($_GET["cmbbrand"]) . "'";
            }

            //if ($GLOBALS[$dev] == "A") {
            $sqlgrn .=" and Dev != '" . $GLOBALS['dev'] . "'";
            //}

            if ($_GET["cmb_t"] != "ALL") {
                $sqlgrn .=" and s_type = '" . $_GET["cmb_t"] . "'";
            }

            if (!isset($_GET["chk_over"])) {
                $sqlgrn .= " and stk_no <> 'SC01' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0797' and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'A0356' and stk_no <> 'L0531' and stk_no <> 'AL001' and stk_no <> 'AL002'  and stk_no <> 'AL003'  and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003' and stk_no <> 'AL004' and stk_no <> 'AL005' and stk_no <> 'AL006' and stk_no <> 'AL007' and stk_no <> 'AL008' and stk_no <> 'AL009' and stk_no <> 'A0359' and stk_no <>'AL011'";
            } else {
                $sqlgrn .= " and stk_no <> '06432' and stk_no <> '06433' and stk_no <> 'M6424' and stk_no <> 'M6425' and stk_no <> '06055' and stk_no <> '06426' and stk_no <> '06428' and  stk_no <> '06173' and stk_no <> '06169' and stk_no <> '06160' and stk_no <> '06155' and stk_no <> 'SC01' and stk_no <> 'AL001' and stk_no <> 'AL002'  and stk_no <> 'AL003' and stk_no <> 'AL004' and stk_no <> 'AL005' and stk_no <> 'AL006' and stk_no <> 'AL007' and stk_no <> 'AL008' and stk_no <> 'AL009' and stk_no <> 'A0359' and stk_no <>'AL011'";
            }


            $result2 = mysqli_query($GLOBALS['dbinv'], $sqlinv);
            $num = mysqli_num_rows($result2);

            $i = 0;

            while ($row2 = mysqli_fetch_array($result2)) {

                if ($i % 50 == 0) {
                    $j = $i / 50;
                } else {
                    $insert[$j] = $insert[$j] . ", ";
                }

                /* if ($i!=0){
                  $insert[$j]=$insert[$j].", ";
                  } */

                $insert[$j] = $insert[$j] . "('" . trim($row2["SDATE"]) . "', '" . trim($row2["REF_NO"]) . "', '" . trim($row2["cus_code"]) . "', '" . trim($row2["cust_name"]) . "', '0',  '" . trim($row2["STK_NO"]) . "', '" . $row2["DESCRIPT"] . "', '" . $row2["s_brand"] . "', '" . trim($row2["QTY"]) . "', '" . $row2["DIS_per"] . "', '" . $row2["PRICE"] . "', '" . $_SESSION["CURRENT_USER"] . "')";

                $i = $i + 1;
            }



            $result3 = mysqli_query($GLOBALS['dbinv'], $sqlgrn);
            //echo $sqlgrn;
            while ($row3 = mysqli_fetch_array($result3)) {

                $sql_rep = "select name from s_salrep where REPCODE='" . $row3["SAL_EX"] . "'";
                $result_rep = mysqli_query($GLOBALS['dbinv'], $sql_rep);

                if ($i % 50 == 0) {
                    $j = $i / 50;
                } else {
                    $insert[$j] = $insert[$j] . ", ";
                }

                $insert[$j] = $insert[$j] . "('" . trim($row3["SDATE"]) . "', '" . trim($row3["REF_NO"]) . "', '" . trim($row3["C_CODE"]) . "', '" . trim($row3["CUS_NAME"]) . "', '" . trim($row3["qty"]) . "',  '" . trim($row3["STK_NO"]) . "', '" . $row3["descript"] . "', '" . $row3["Brand"] . "', '0', '" . $row2["DIS_per"] . "', '" . $row2["PRICE"] . "', '" . $_SESSION["CURRENT_USER"] . "')";

                $i = $i + 1;
            }

            $k = 0;
            while ($j >= $k) {

                $sql_tmp = "insert into tmpqtysale (sdate, refno, ccode, cname, RETqty, stkno, description, brand, INVqty, dis,value, user_id) values " . $insert[$k];

                $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);

                $k = $k + 1;
            }


            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            $heading = "Qty Sales For " . $_GET["cusname"] . "</br>";
            $heading .="Sales Rep :" . $_GET["cmbrep"] . " Date Range From : " . $_GET["DTfrom"] . "   To : " . $_GET["DTTO"];

            echo "<center>" . $heading . "</center><br>";

            if ($_GET["cmbtype"] == "Detail") {
                print_det();
            } else if (isset($_GET["chk_over25"])) {
                print_ov25();
            } else if (isset($_GET["Chk_cus_wise"])) {
                print_cuswise();
            } else {
                print_summ();
            }
        }

        function print_det() {
            require_once("connectioni.php");




            echo "<center><table border=1><tr>
		<th>Stk No</th>
		<th>Description</th><th>Brand</th><th>Invoice Qty</th>
		<th>Return Qty</th>
		<th>Effective Qty</th>";

            if ($_GET['chk_o90'] == "on") {


                $dt1 = date('Y-m-d', strtotime(($_GET["DTfrom"]) . ' - 1 days'));
                $st = $_GET['txt_90'] . " days";

                $dt = date('Y-m-d', strtotime(($dt1) . " -" . $st));

                echo "<th>OP Over " . $_GET['txt_90'] . "</th>";
                echo "<th>Closing Over " . $_GET['txt_90'] . "</th>";
                echo "<th>Over " . $_GET['txt_90'] . " Change</th>";
            }
            echo "</tr>";
            $sql = "Select stkno from tmpqtysale where user_id='" . $_SESSION["CURRENT_USER"] . "' group by stkno order by  brand,stkno";

            $totINVqty = 0;
            $totRETqty = 0;
            $tot = 0;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {

                $sql = "Select sum(INVqty)as totINVqty,sum(RETqty) as totRETqty  from tmpqtysale where user_id='" . $_SESSION["CURRENT_USER"] . "' and stkno='" . $row["stkno"] . "' group by stkno";

                $result1 = mysqli_query($GLOBALS['dbinv'], $sql);
                while ($row1 = mysqli_fetch_array($result1)) {
                    echo "<tr>
			<td>" . $row["stkno"] . "</td>";

                    $sqli = "select * from s_mas where stk_no= '" . $row["stkno"] . "'";
                    $result2 = mysqli_query($GLOBALS['dbinv'], $sqli);
                    $row2 = mysqli_fetch_array($result2);

                    echo "<td>" . $row2["DESCRIPT"] . "</td> 
                        <td>" . $row2["BRAND_NAME"] . "</td>"
                    . "<td align='right'>" . number_format($row1["totINVqty"], 0, ".", ",") . "</td>"
                    . "<td align='right'>" . number_format($row1["totRETqty"], 0, ".", ",") . "</td>
			<td  align='right'>" . number_format($row1["totINVqty"] - $row1["totRETqty"], 0, ".", ",") . "</td>";


                    if ($_GET['chk_o90'] == "on") {

                        $dt1 = date('Y-m-d', strtotime(($_GET["DTfrom"]) . ' - 1 days'));
                        $st = $_GET['txt_90'] . " days";

                        $dt = date('Y-m-d', strtotime(($dt1) . " -" . $st));


                        $sql1 = mysqli_query($GLOBALS['dbinv'], "Select sum(REC_QTY) as stk from s_purtrn where STK_NO='" . $row['stkno'] . "' and CANCEL='0' and SDATE>'" . $dt . "' ") or die(mysqli_error());
                        $row3 = mysqli_fetch_array($sql1);


                        $sql = "update s_trn set tru_qty = qty where  (LEDINDI = 'ARN' or LEDINDI = 'IIN' or LEDINDI = 'TRN' or LEDINDI = 'GRN') and stk_no ='" . $row['stkno'] . "'";
                        $res = mysqli_query($GLOBALS['dbinv'], $sql);

                        $sql = "update s_trn set  tru_qty = qty*-1 where  (LEDINDI = 'INV' or LEDINDI = 'IOU' or LEDINDI = 'ARR') and stk_no ='" . $row['stkno'] . "'";
                        $res = mysqli_query($GLOBALS['dbinv'], $sql);

                        $sql = "select sum(tru_qty) as QTYINHAND from s_trn where (ledindi<>'GINR' and ledindi <>'GINI') and stk_no ='" . $row['stkno'] . "' and sdate >='2017-04-04' and sdate <='" . $dt1 . "' and tru_qty <> '0'";

                        $res = mysqli_query($GLOBALS['dbinv'], $sql);
                        $row4 = mysqli_fetch_array($res);

                        $sql1 = mysqli_query($GLOBALS['dbinv'], "Select sum(REC_QTY) as stk from s_purtrn where STK_NO='" . $row['stkno'] . "' and CANCEL='0' and SDATE>'" . $dt . "' ") or die(mysqli_error());
                        $row3 = mysqli_fetch_array($sql1);



                        $mnewstk = 0;
                        $unsold = 0;
                        if (is_null($row3["stk"]) == false) {
                            $mnewstk = $row3["stk"];
                        }

                        if ($row4["QTYINHAND"] > $row3["stk"]) {
                            $unsold = $row4["QTYINHAND"] - $mnewstk;
                        }

                        if ($row['stkno'] == "A5301") {
                            //echo $sql ."<br>";	
                            //echo "Select sum(REC_QTY) as stk from s_purtrn where STK_NO='".$row['stkno']."' and CANCEL='0' and SDATE>'".$dt."' "  . "<br>";
                            //echo $unsold  . "<br>";
                            //echo $row4["QTYINHAND"] . "<br>";
                            //echo $mnewstk . "<br>";					
                        }

                        echo "<td  align='right'>" . number_format($unsold, 0, ".", ",") . "</td>";


                        $dt1 = date('Y-m-d', strtotime(($_GET["DTTO"])));
                        $st = $_GET['txt_90'] . " days";

                        $dt = date('Y-m-d', strtotime(($dt1) . " -" . $st));


                        //current o90
                        $sql1 = mysqli_query($GLOBALS['dbinv'], "Select sum(REC_QTY) as stk from s_purtrn where STK_NO='" . $row['stkno'] . "' and CANCEL='0' and SDATE>'" . $dt . "' ") or die(mysqli_error());
                        $row3 = mysqli_fetch_array($sql1);


                        $sql = "update s_trn set tru_qty = qty where  (LEDINDI = 'ARN' or LEDINDI = 'IIN' or LEDINDI = 'TRN' or LEDINDI = 'GRN') and stk_no ='" . $row['stkno'] . "'";
                        $res = mysqli_query($GLOBALS['dbinv'], $sql);

                        $sql = "update s_trn set  tru_qty = qty*-1 where  (LEDINDI = 'INV' or LEDINDI = 'IOU' or LEDINDI = 'ARR') and stk_no ='" . $row['stkno'] . "'";
                        $res = mysqli_query($GLOBALS['dbinv'], $sql);

                        $sql = "select sum(tru_qty) as QTYINHAND from s_trn where (ledindi<>'GINR' and ledindi <>'GINI') and stk_no ='" . $row['stkno'] . "' and sdate >='2017-04-04' and sdate <='" . $dt1 . "' and tru_qty <> '0'";

                        $res = mysqli_query($GLOBALS['dbinv'], $sql);
                        $row4 = mysqli_fetch_array($res);

                        $sql1 = mysqli_query($GLOBALS['dbinv'], "Select sum(REC_QTY) as stk from s_purtrn where STK_NO='" . $row['stkno'] . "' and CANCEL='0' and SDATE>'" . $dt . "' ") or die(mysqli_error());
                        $row3 = mysqli_fetch_array($sql1);



                        $mnewstk1 = 0;
                        $unsold1 = 0;
                        if (is_null($row3["stk"]) == false) {
                            $mnewstk1 = $row3["stk"];
                        }

                        if ($row4["QTYINHAND"] > $row3["stk"]) {
                            $unsold1 = $row4["QTYINHAND"] - $mnewstk1;
                        }

                        if ($row['stkno'] == "A5301") {
                            //echo $sql ."<br>";	
                            //echo "Select sum(REC_QTY) as stk from s_purtrn where STK_NO='".$row['stkno']."' and CANCEL='0' and SDATE>'".$dt."' "  . "<br>";
                            //echo $unsold  . "<br>";
                            //echo $row4["QTYINHAND"] . "<br>";
                            //echo $mnewstk . "<br>";					
                        }

                        echo "<td  align='right'>" . number_format($unsold1, 0, ".", ",") . "</td>";
                        echo "<td  align='right'>" . number_format(($unsold1 - $unsold), 0, ".", ",") . "</td>";
                    }

                    echo "</tr>";
                    $totINVqty = $totINVqty + $row1["totINVqty"];
                    $totRETqty = $totRETqty + $row1["totRETqty"];
                    $totqty = $row1["totINVqty"] - $row1["totRETqty"];
                    $tot = $tot + $totqty;
                }
            }

            echo "<tr>
			<td colspan=3></td>
			<td align='right'><b>" . $totINVqty . "</b></td>
			<td align='right'><b>" . $totRETqty . "</b></td>
			<td align='right'><b>" . $tot . "</b></td>";
            echo "<table>";
        }

        function print_summ() {
            require_once("connectioni.php");




            echo "<center><table border=1><tr>
		<th>Brand</th><th>Invoice Qty</th>
		<th>Return Qty</th>
		<th>Effective Qty</th>
		</tr>";
            $sql = "Select brand,sum(INVqty)as totINVqty,sum(RETqty) as totRETqty  from tmpqtysale where user_id='" . $_SESSION["CURRENT_USER"] . "' group by brand order by brand";
//            echo $sql;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $totRETqty = 0;
            $totINVqty = 0;
            $tot = 0;
            while ($row = mysqli_fetch_array($result)) {
//                echo $row["brand"];
                echo "<tr>
			
                        <td width ='450'>" . $row["brand"] . "</td>"
                . "<td align='right'>" . number_format($row["totINVqty"], 0, ".", ",") . "</td>"
                . "<td align='right'>" . number_format($row["totRETqty"], 0, ".", ",") . "</td>
			<td align='right'>" . number_format($row["totINVqty"] - $row["totRETqty"], 0, ".", ",") . "</td>
			</tr>";
                $totINVqty = $totINVqty + $row["totINVqty"];
                $totRETqty = $totRETqty + $row["totRETqty"];
                $totqty = $row["totINVqty"] - $row["totRETqty"];
                $tot = $tot + $totqty;
            }
            
            echo "<tr>
			<td></td>
			<td align='right'><b>" . $totINVqty . "</b></td>
			<td align='right'><b>" . $totRETqty . "</b></td>
			<td align='right'><b>" . $tot . "</b></td>";
            echo "<table>";
        }

        function print_cuswise() {

            require_once("connectioni.php");




            echo "<center><table border=1><tr>
		<th colspan='2'>Dealer</th><th>Brand</th><th>Invoice Qty</th>
		<th>Return Qty</th>
		<th>Effective Qty</th>
		</tr>";
            $sql = "Select ccode  from tmpqtysale where user_id='" . $_SESSION["CURRENT_USER"] . "' group by ccode order by ccode";
            $resultr = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row2 = mysqli_fetch_array($resultr)) {

                $sql = "Select brand,sum(INVqty)as totINVqty,sum(RETqty) as totRETqty  from tmpqtysale where ccode ='" . $row2['ccode'] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by brand order by brand";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);


                $sql_ven = "Select * from vendor where code = '" . $row2["ccode"] . "'";
                $result_ven = mysqli_query($GLOBALS['dbinv'], $sql_ven);
                $row_ven = mysqli_fetch_array($result_ven);

                echo "<tr><td>" . $row2["ccode"] . "</td>     
			<td >" . $row_ven["NAME"] . "</td><td></td>  </tr>";

                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>
						<td colspan='2'></td>
						 	
                        <td align='right'>" . $row["brand"] . "</td>"
                    . "<td align='right'>" . number_format($row["totINVqty"], 0, ".", ",") . "</td>"
                    . "<td align='right'>" . number_format($row["totRETqty"], 0, ".", ",") . "</td>
			<td>" . number_format($row["totINVqty"] - $row["totRETqty"], 0, ".", ",") . "</td>
			</tr>";
                    $totINVqty = $totINVqty + $row["totINVqty"];
                    $totRETqty = $totRETqty + $row["totRETqty"];
                    $totqty = $row["totINVqty"] - $row["totRETqty"];
                    $tot = $tot + $totqty;
                }
            }
            echo "<tr>
			<td colspan='3'></td>
			<td align='right'><b>" . $totINVqty . "</b></td>
			<td align='right'><b>" . $totRETqty . "</b></td>
			<td align='right'><b>" . $tot . "</b></td>";
            echo "<table>";
        }

        function print_ov25() {

            require_once("connectioni.php");




            echo "<center><table border=1><tr>
		<th colspan='2'>Brand</th><th>Invoice Qty</th>
		<th>Return Qty</th>
		<th>Effective Qty</th>  <td>40%</td><td>43%</td> <td>CRN</td> 
		</tr>";
            $sql = "Select ccode  from tmpqtysale where user_id='" . $_SESSION["CURRENT_USER"] . "' group by ccode order by ccode";
            $resultr = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row2 = mysqli_fetch_array($resultr)) {

                $sql = "Select brand,sum(INVqty)as totINVqty,sum(RETqty) as totRETqty  from tmpqtysale where ccode ='" . $row2['ccode'] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "' group by brand order by brand";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);


                while ($row = mysqli_fetch_array($result)) {

                    $sql = "select* from tmpqtysale where brand = '" . $row["brand"] . "' and ccode ='" . $row2['ccode'] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'";

                    $t40 = 0;
                    $t43 = 0;
                    $crn = 0;
                    $crn_t = 0;
                    $totq = 0;
                    if ($row2['ccode'] == "P105") {
                        $a = $a;
                    }

                    $result_tot = mysqli_query($GLOBALS['dbinv'], $sql);
                    while ($row_tot = mysqli_fetch_array($result_tot)) {
                        if ($row_tot['INVqty'] > 0) {
                            if ($row_tot['dis'] == 40) {
                                $t40 = $t40 + $row_tot["INVqty"];
                            }
                            if ($row_tot['dis'] != 40) {
                                $t43 = $t43 + $row_tot["INVqty"];
                            }

                            if (($row_tot['dis']) < 37.5 and $row_tot['dis'] > 0) {
                                $crn = $crn + (($row_tot['value']) * ((37.5 - $row_tot['dis']) / 100)) * $row_tot['INVqty'];
                            }
                            $totq = $totq + $row_tot['INVqty'];
                        }
                    }
                    //if {@Eff qty} >= 20 and {@Eff qty} < 50  then Sum ({@CRN}, {ado.Brand}) 

                    if ($totq >= 20 and $totq < 50) {
                        $crn_t = $crn_t + $crn;
                        $ocrn = $ocrn + $crn_t;
                    }


                    if ($crn_t > 0) {


                        $sql_ven = "Select * from vendor where code = '" . $row2["ccode"] . "'";
                        $result_ven = mysqli_query($GLOBALS['dbinv'], $sql_ven);
                        $row_ven = mysqli_fetch_array($result_ven);

                        echo "<tr><td>" . $row2["ccode"] . "</td>     
			<td colspan='7'>" . $row_ven["NAME"] . "</td> </tr>";



                        echo "<tr>
			
                        <td align='right' width = '350' colspan='2'>" . $row["brand"] . "</td>"
                        . "<td align='right'>" . number_format($row["totINVqty"], 0, ".", ",") . "</td>"
                        . "<td align='right'>" . number_format($row["totRETqty"], 0, ".", ",") . "</td>
			<td>" . number_format($row["totINVqty"] - $row["totRETqty"], 0, ".", ",") . "</td><td>" . $t40 . "</td>    
		     <td>" . $t43 . "</td>    "
                        . "<td>" . $crn_t . "</td>    "
                        . "	</tr>";
                        $totINVqty = $totINVqty + $row["totINVqty"];
                        $totRETqty = $totRETqty + $row["totRETqty"];
                        $totqty = $row["totINVqty"] - $row["totRETqty"];
                        $tot = $tot + $totqty;
                    }
                }
            }
            echo "<tr>
			<td></td><td></td>
			<td align='right'><b>" . $totINVqty . "</b></td>
			<td align='right'><b>" . $totRETqty . "</b></td>
			<td align='right'><b>" . $tot . "</b></td><td></td><td></td> <td>" . $ocrn . "</td> ";
            echo "<table>";
        }

        $sql_tmp = "delete from tmpqtysale where user_id='" . $_SESSION["CURRENT_USER"] . "'";
        $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
        ?>



    </body>
</html>

<?php
session_start();
if (!isset($_SESSION["UserName"])) {
    echo "Invalid Login";
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sales Summery</title>
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
                font-size:16px;

            }
            td
            {
                font-size:16px;;
                border-bottom:none;
                border-top:none;            }
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
        if ($_GET["cmbtype"] == "All") {
            if ($_GET["salesrep"] == "All") {
                repoall();
            }
            if ($_GET["salesrep"] != "All") {
                repoall();
            }
        } else {
            type_wise();
        }

/////////// Sales Summery////////////////////////////////////////

        function type_wise() {

            $tar = 0;

            $insert = "";

            require_once("connectioni.php");



            if ($_GET["cmbdev"] == "All") {
                $dev = "A";
            }
            if ($_GET["cmbdev"] == "Manual") {
                $dev = "0";
            }
            if ($_GET["cmbdev"] == "Computer") {
                $dev = "1";
            }
            $i = 0;
            $sql = "delete from tmprepsale where user_id='" . $_SESSION["CURRENT_USER"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);


            if ($_GET["salesrep"] == "All") {
                $sql_rep = "SELECT * FROM s_salrep where cancel='1' order by REPCODE";
            } else {
                $sql_rep = "SELECT * FROM s_salrep where REPCODE='" . $_GET["salesrep"] . "' order by REPCODE ";
            }

            $result_rep = mysqli_query($GLOBALS['dbinv'], $sql_rep);
            $row_rep = mysqli_fetch_array($result_rep);

            $mname = "";
            if (is_null($row_rep["Name"]) == false) {
                $mname = $row_rep["Name"];
            }


            $result_rep = mysqli_query($GLOBALS['dbinv'], $sql_rep);
            while ($row_rep = mysqli_fetch_array($result_rep)) {
                $SAL = 0;
                $ret = 0;
                $mnet = 0;

                if ($_GET["cmbbrand"] == "All") {
                    $sql_rst = "SELECT * FROM s_salma where Accname != 'NON STOCK' and SAL_EX='" . $row_rep["REPCODE"] . "' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' order by id ";
                } else {
                    $sql_rst = "SELECT * FROM s_salma where Accname != 'NON STOCK' and Brand='" . $_GET["cmbbrand"] . "' and SAL_EX='" . $row_rep["REPCODE"] . "' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' order by id  ";
                }

                //echo $sql_rst;
                $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
                while ($row_rst = mysqli_fetch_array($result_rst)) {

                    $sql_rs0 = "Select ittype from view_salma_invo_smas where REF_NO='" . trim($row_rst["REF_NO"]) . "'";
                    //echo $sql_rs0;
                    $result_rs0 = mysqli_query($GLOBALS['dbinv'], $sql_rs0);
                    if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
                        //echo $row_rs0["ittype"]."/".$_GET["cmbtype"]."</br>";
                        if (trim($row_rs0["ittype"]) == trim($_GET["cmbtype"])) {
                            $SAL = $SAL + $row_rst["GRAND_TOT"];
                            $mnet = $mnet + ($row_rst["GRAND_TOT"] / (1 + ($row_rst["GST"] / 100)));
                        }
                    }
                }
                //echo $mnet."</br>";
                if ($_GET["cmbbrand"] == "All") {

                    if ($_GET["chkdef"] != "on") {

                        $sql_rst2 = "SELECT * FROM c_bal WHERE SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "' or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "' or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' and flag1 != '1' ";
                    }
                    if ($_GET["chkdef"] == "on") {

                        $sql_rst2 = "SELECT * FROM c_bal WHERE SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' and flag1 != '1' ";
                    }
                } else {

                    if ($_GET["chkdef"] != "on") {

                        $sql_rst2 = "SELECT * FROM c_bal WHERE brand='" . $_GET["cmbbrand"] . "' and  SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "' or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "' or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' and flag1 != '1' ";
                    }
                    if ($_GET["chkdef"] == "on") {

                        $sql_rst2 = "SELECT * FROM c_bal WHERE brand='" . $_GET["cmbbrand"] . "' and  SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "' or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "' or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and dev!='" . $dev . "' and flag1 != '1' ";
                    }
                }

                $result_rst2 = mysqli_query($GLOBALS['dbinv'], $sql_rst2);
                while ($row_rst2 = mysqli_fetch_array($result_rst2)) {

                    $mok = 0;
                    if ($row_rst2["trn_type"] == "GRN") {
                        $sql_rs0 = "Select ittype from view_cbal_crnma_sinvo_smas where REFNO='" . trim($row_rst2["REFNO"]) . "'";
                        $result_rs0 = mysqli_query($GLOBALS['dbinv'], $sql_rs0);
                        if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
                            if (trim($row_rs0["ittype"]) == trim($_GET["cmbtype"])) {
                                $mok = 1;
                            }
                        }
                    }

                    if ($row_rst2["trn_type"] == "CNT") {
                        $sql_rs0 = "Select ittype from view_cbal_credit_sinvo_smas where REFNO='" . trim($row_rst2["REFNO"]) . "'";
                        $result_rs0 = mysqli_query($GLOBALS['dbinv'], $sql_rs0);
                        if ($row_rs0 = mysqli_fetch_array($result_rs0)) {
                            if (trim($row_rs0["ittype"]) == trim($_GET["cmbtype"])) {
                                $mok = 1;
                            }
                        }
                    }

                    if ($mok == 1) {
                        $ret = $ret + $row_rst2["AMOUNT"];
                        $mnet = $mnet - ($row_rst2["AMOUNT"] / (1 + ($row_rst2["vatrate"] / 100)));
                    }
                    //echo "lm-".$mnet;
                }

                if ($i != 0) {
                    $insert = $insert . ", ";
                }

                $insert = $insert . "('" . trim($row_rep["REPCODE"]) . "', " . $SAL . ", " . $ret . ", '" . $row_rep["Name"] . "', '" . trim($row_rep["RGROUP"]) . "', " . $mnet . ", " . $tar . ", '" . $_SESSION["CURRENT_USER"] . "')";
                $i = 1;
            }

            $sql_tem = "insert into tmprepsale(rep, grossale, grossgrn, Name, rgroup, net,targ, user_id) values " . $insert;
            //echo $sql_tem;
            $result_tem = mysqli_query($GLOBALS['dbinv'], $sql_tem);

            if ($_GET["chktar"] == "on") {
                print2();
            } else {
                print1();
            }
        }

        function repoall() {

            require_once("connectioni.php");

            $insert = "";

            if ($_GET["cmbdev"] == "All") {
                $dev = "A";
            }
            if ($_GET["cmbdev"] == "Manual") {
                $dev = "0";
            }
            if ($_GET["cmbdev"] == "Computer") {
                $dev = "1";
            }

            $sql = "delete from tmprepsale where user_id='" . $_SESSION["CURRENT_USER"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);

            //$row = mysqli_fetch_array($result);

            if ($_GET["cmbbrand"] == "All") {
                $sql_rst = "SELECT sum(grand_tot) as grand_tot,sum(grand_tot/(1+gst/100)) as grand_tot1,SAL_EX FROM view_salma_brand where   Accname != 'NON STOCK'  AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "' or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' and DEV!='" . $dev . "'";
            }

            if ($_GET["cmbbrand"] != "All") {
                $sql_rst = "SELECT sum(grand_tot) as grand_tot,sum(grand_tot/(1+gst/100)) as grand_tot1,SAL_EX FROM view_salma_brand where Accname != 'NON STOCK' and Brand='" . $_GET["cmbbrand"] . "'  AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' and DEV!='" . $dev . "'";
            }
            if ($_GET["salesrep"] != "All") {
                $sql_rst .= " and sal_ex = '" . $_GET["salesrep"] . "'";
            }

            if ($_GET['cmbbrand1'] != "All") {
                $sql_rst .= " and class = '" . $_GET["cmbbrand1"] . "'";
            }

            if (($_SESSION["CURRENT_DEP"] != "") and (!is_numeric($_SESSION["CURRENT_DEP"]))) {
//                $sql_rst .= " and costcenter ='" . trim($_SESSION["CURRENT_DEP"]) . "'";
            }

            $sql_rst .= " group by SAL_EX";
            $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
            while ($row_rst = mysqli_fetch_array($result_rst)) {
                $SAL = $row_rst["grand_tot"];
                $mnet = $row_rst["grand_tot1"];
                $ret = 0;

                $sql_rep = "SELECT * FROM s_salrep where REPCODE ='" . $row_rst["SAL_EX"] . "'";

                if (($_SESSION["CURRENT_DEP"] != "") and (!is_numeric($_SESSION["CURRENT_DEP"]))) {
                    $mok = "";


                    if (($_GET['DT1'] >= "2017-06-01")) {

                        $sql_rep .= " AND RGROUP1 = '" . $_SESSION["CURRENT_DEP"] . "'";
                    } else {
                        if ($_SESSION["CURRENT_DEP"] == "AREA II") {
                            $sql_rep .= " and ( RGROUP = 'AREA II' or  RGROUP = 'AREA I')";
                        } else {
                            $sql_rep .= " AND RGROUP = '" . $_SESSION["CURRENT_DEP"] . "'";
                        }
                    }
                }

                $result_rep = mysqli_query($GLOBALS['dbinv'], $sql_rep);
                if ($row_rep = mysqli_fetch_array($result_rep)) {
                    $mname = trim($row_rep["Name"]);


                    $sql_t = "select sum(Target) as target  from reptrn where rep_code='" . trim($row_rep["REPCODE"]) . "'";
                    if ($_GET["cmbbrand"] != "All") {
                        $sql_t .= " and brand = '" . $_GET["cmbbrand"] . "'";
                    }

                    $result_tar = mysqli_query($GLOBALS['dbinv'], $sql_t);
                    $tar = 0;
                    $row_tar = mysqli_fetch_array($result_tar);
                    if ($row_tar["target"] > 0) {
                        $tar = $row_tar["target"];
                    }

                    $mgroup = trim($row_rep["RGROUP"]);

                    $mgroup1 = "";
                    if (($_GET['DT1'] >= "2017-06-01")) {
                        $mgroup = trim($row_rep["RGROUP1"]);
                        $mgroup1 = trim($row_rep["RGROUP2"]);
                    }

                    if (($_GET['DT1'] >= "2018-08-01")) {
                        if ($mgroup == "Department II") {
                            $mgroup1 = "";
                        }
                    }

                    $insert[] = "('" . $mgroup1 . "','" . trim($row_rep["REPCODE"]) . "', " . $SAL . ", " . $ret . ", '" . $mname . "', '" . trim($mgroup) . "',  " . $mnet . ", " . $tar . ", '" . $_SESSION["CURRENT_USER"] . "')";
                }
            }

            if ($_GET["cmbbrand"] == "All") {
                if ($_GET["chkdef"] != "on") {
                    $sql_rst2 = "SELECT sum(AMOUNT) as grand_tot,sum(AMOUNT/(1+vatrate/100)) as grand_tot1,SAL_EX FROM view_cbal_brand WHERE  (flag1 <> '1')  AND trn_type!='REC' and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "'";
                }

                if ($_GET["chkdef"] == "on") {
                    $sql_rst2 = "SELECT sum(AMOUNT) as grand_tot,sum(AMOUNT/(1+vatrate/100)) as grand_tot1,SAL_EX FROM view_cbal_brand WHERE  (flag1 <> '1')  AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
                }
            } else {

                if ($_GET["chkdef"] != "on") {
                    $sql_rst2 = "SELECT sum(AMOUNT) as grand_tot,sum(AMOUNT/(1+vatrate/100)) as grand_tot1,SAL_EX FROM view_cbal_brand WHERE (flag1 <> '1') and brand='" . $_GET["cmbbrand"] . "'  AND trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "'";
                }

                if ($_GET["chkdef"] == "on") {
                    $sql_rst2 = "SELECT sum(AMOUNT) as grand_tot,sum(AMOUNT/(1+vatrate/100)) as grand_tot1,SAL_EX FROM view_cbal_brand WHERE (flag1 <> '1') and brand='" . $_GET["cmbbrand"] . "'  AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "'  ";
                }
            }
            if ($_GET["salesrep"] != "All") {
                $sql_rst2 .= " and sal_ex = '" . $_GET["salesrep"] . "'";
            }

            if ($_GET['cmbbrand1'] != "All") {
                $sql_rst2 .= " and class = '" . $_GET["cmbbrand1"] . "'";
            }

            if (($_SESSION["CURRENT_DEP"] != "") and (!is_numeric($_SESSION["CURRENT_DEP"]))) {
                //	$sql_rst2 .= " and costcenter ='" . trim($_SESSION["CURRENT_DEP"]) . "'";
            }

            $sql_rst2 .= " group by SAL_EX";

            //echo  $sql_rst2;
            $result_rst2 = mysqli_query($GLOBALS['dbinv'], $sql_rst2);
            while ($row_rst2 = mysqli_fetch_array($result_rst2)) {
                $ret = $row_rst2["grand_tot"];
                $mnet = $row_rst2["grand_tot1"] * -1;
                $SAL = 0;

                $sql_rep = "SELECT * FROM s_salrep where REPCODE ='" . $row_rst2["SAL_EX"] . "'";
                if (($_SESSION["CURRENT_DEP"] != "") and (!is_numeric($_SESSION["CURRENT_DEP"]))) {
                    $mok = "";
                    if (($_GET['DT1'] >= "2017-06-01")) {

                        $sql_rep .= " AND RGROUP1 = '" . $_SESSION["CURRENT_DEP"] . "'";
                    } else {
                        if ($_SESSION["CURRENT_DEP"] == "AREA II") {
                            $sql_rep .= " and ( RGROUP = 'AREA II' or  RGROUP = 'AREA I')";
                        } else {
                            $sql_rep .= " AND RGROUP = '" . $_SESSION["CURRENT_DEP"] . "'";
                        }
                    }
                }


                $result_rep = mysqli_query($GLOBALS['dbinv'], $sql_rep);
                if ($row_rep = mysqli_fetch_array($result_rep)) {
                    $mname = trim($row_rep["Name"]);
                    $sql_t = "select sum(Target) as target  from reptrn where rep_code='" . trim($row_rep["REPCODE"]) . "'";
                    if ($_GET["cmbbrand"] != "All") {
                        $sql_t .= " and brand = '" . $_GET["cmbbrand"] . "'";
                    }
                    $result_tar = mysqli_query($GLOBALS['dbinv'], $sql_t);
                    $tar = 0;
                    $row_tar = mysqli_fetch_array($result_tar);
                    if ($row_tar["target"] > 0) {
                        $tar = $row_tar["target"];
                    }

                    $mgroup = trim($row_rep["RGROUP"]);
                    if (($_GET['DT1'] >= "2017-06-01")) {
                        $mgroup = trim($row_rep["RGROUP1"]);
                        $mgroup1 = trim($row_rep["RGROUP2"]);
                    }
                    if (($_GET['DT1'] >= "2018-08-01")) {
                        if ($mgroup == "Department II") {
                            $mgroup1 = "";
                        }
                    }



                    $insert[] = "('" . $mgroup1 . "','" . trim($row_rep["REPCODE"]) . "', " . $SAL . ", " . $ret . ", '" . $mname . "', '" . trim($mgroup) . "',  " . $mnet . ", " . $tar . ", '" . $_SESSION["CURRENT_USER"] . "')";
                }
            }






            $sql_t = "select sum(Target) as target,REPCODE,Name,RGROUP,RGROUP1,RGROUP2  from view_repmas_reptrn where RGROUP2 <> '' and target >0";
            if ($_GET["cmbbrand"] != "All") {
                $sql_t .= " and brand = '" . $_GET["cmbbrand"] . "'";
            }
            $sql_t .= " group by RGROUP,REPCODE,Name,RGROUP1,RGROUP2";

            $result_tar = mysqli_query($GLOBALS['dbinv'], $sql_t);
            $tar = 0;
            while ($row_tar = mysqli_fetch_array($result_tar)) {
                if ($row_tar["target"] > 0) {


                    $mname = trim($row_tar["Name"]);


                    $tar = $row_tar["target"];
                    $SAL = 0;
                    $ret = 0;
                    $mnet = 0;

                    if (($_GET['DT1'] >= "2017-06-01")) {
                        $mgroup = trim($row_tar["RGROUP1"]);
                        $mgroup1 = trim($row_tar["RGROUP2"]);
                    }

                    if (($_GET['DT1'] >= "2018-08-01")) {
                        if ($mgroup == "Department II") {
                            $mgroup1 = "";
                        }
                    }
                    $insert[] = "('" . $mgroup1 . "','" . trim($row_tar["REPCODE"]) . "',0, 0, '" . $mname . "', '" . trim($mgroup) . "',0, " . $tar . ", '" . $_SESSION["CURRENT_USER"] . "')";
                }
            }

            $sql_tem = "insert into tmprepsale(rgroup1,rep, grossale, grossgrn, Name, rgroup, net, targ, user_id) values " . implode($insert, ",");
            $result_tem = mysqli_query($GLOBALS['dbinv'], $sql_tem);




            if ($_GET["chktar"] == "on") {
                print2();
            } else {
                print1();
            }
        }

        function print2() {

            require_once("connectioni.php");

            if ($_GET["chkdef"] != "on") {
                $txtName = "Rep wise Sales Summery (Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
            }

            if ($_GET["chkdef"] == "on") {
                $txtName = "Rep wise Sales Summery (with Defective)(Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
            }


            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $heading . "</center><br>";

            echo "<center>" . $txtName . "</center><br>";

            echo "<center><table border=1><tr>
		 
                <th colspan='2'>Sales Rep</th>
		<th>Target</th>
		<th>Achievement</th>
		<th>Balance</th>
        <th>Ach %</th>
		<th>Qty</th>
		</tr>";
            //echo $sql;
            $totgrossale = 0;
            $totgrossgrn = 0;
            $totnet = 0;
            $totnetq = 0;
            $chk = 0;
//            echo $_SESSION["CURRENT_USER"] . '/' . $_GET["salesrep"];
            $sql = "select * from tmprepsale where user_id='" . $_SESSION["CURRENT_USER"] . "' order by rgroup";
//            $sql = "select rep,Name,rgroup,rgroup1,targ,sum(grossale) as grossale,sum(grossgrn) as grossgrn,sum(net) as net from tmprepsale where user_id='" . $_SESSION["CURRENT_USER"] . "' group by  rep,name,rgroup,rgroup1,targ order by rgroup,rgroup1,rep desc";
            $sql = "select rep,Name,rgroup,rgroup1,targ,sum(grossale) as grossale,sum(grossgrn) as grossgrn,sum(net) as net from tmprepsale where user_id='" . $_SESSION["CURRENT_USER"] . "'";
//           ===============================================
//prawee 19.10.08
            if (($_SESSION["CURRENT_DEP"] != "") and (!is_numeric($_SESSION["CURRENT_DEP"]))) {
                if ($_SESSION["CURRENT_DEP"] == "Department II") {
                    $sql .= " and rgroup='" . trim($_SESSION["CURRENT_DEP"]) . "'";
                }
            } else {
                if (($_SESSION["CURRENT_DEP"] != "") and (is_numeric($_SESSION["CURRENT_DEP"]))) {
                    $sql23 = "SELECT * FROM s_salrep WHERE REPCODE =  '" . $_SESSION["CURRENT_REP"] . "'";
                    $result23 = mysqli_query($GLOBALS['dbinv'], $sql23);
                    if ($row23 = mysqli_fetch_array($result23)) {
                        if ($row23["RGROUP1"] == "Department II") {
                            $sql .= " and rgroup='" . $row23["RGROUP1"] . "'";
                        }
                    }
                }
            }

            $sql .= " group by  rep,name,rgroup,rgroup1,targ order by rgroup,rgroup1,rep desc";
//            ===================================
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {
                if ($row["rgroup"] != $rgroup) {
                    if ($grossale != 0) {
                        $grngrp = $grossgrn / $grossale * 100;
                    } else {
                        $grngrp = 0;
                    }
                    if ($rgroup1 != "") {


                        if ($grossale1 != 0) {
                            $grngrp1 = $grossgrn1 / $grossale1 * 100;
                        } else {
                            $grngrp1 = 0;
                        }

                        echo "<tr><td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align=\"right\"><b>" . number_format($grossale1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grossgrn1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($net1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grngrp1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($net1q, 0, ".", ",") . "</b></td>
					</tr>";
                    }
                    if ($chk != 0) {

                        echo "<tr><td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align=\"right\"><b>" . number_format($grossale, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grossgrn, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($net, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grngrp, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($netq, 0, ".", ",") . "</b></td>
					</tr>";
                        $grngrp = 0;
                        $grossale = 0;
                        $grossgrn = 0;
                        $net = 0;
                        $net1q = 0;
                        $grngrp = 0;
                    }
                    $chk = 1;
                    echo "<tr>
					<th colspan=7 align=left><b>" . $row["rgroup"] . "</b></th>
					<tr>";
                    $grossale = 0;
                    $grossgrn = 0;
                    $net = 0;
                    $netq = 0;
                    $grossale1 = 0;
                    $grossgrn1 = 0;
                    $net1 = 0;
                    $net1q = 0;
                    $rgroup1 = "";
                }


                if ($row["rgroup1"] != $rgroup1) {
                    if ($grossale1 != 0) {
                        $grngrp1 = $grossgrn1 / $grossale1 * 100;
                    } else {
                        $grngrp1 = 0;
                    }

                    if ($rgroup1 != "") {
                        echo "<tr><td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align=\"right\"><b>" . number_format($grossale1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grossgrn1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($net1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grngrp1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($net1q, 0, ".", ",") . "</b></td>
					</tr>";
                    }
                    $chk1 = 1;

                    echo "<tr><th></th>
					<th align=left><b>" . $row["rgroup1"] . "</b></th><th colspan='5'></th>
					<tr>";
                    $grossale1 = 0;
                    $grossgrn1 = 0;
                    $net1 = 0;
                    $net1q = 0;
                    $rgroup1 = "";
                }

                if (($row["grossale"] > 0) or ( $row["grossgrn"] > 0) or ( $row["net"] > 0) or ( $row["targ"] > 0)) {


                    $grngrp = 0;


                    if ($row["targ"] != 0) {
                        $grn = $row["net"] / $row["targ"] * 100;
                    } else {
                        $grn = 0;
                    }

                    $invqty = 0;
                    $rtnqty = 0;
                    $sql_inv = "Select sum(Qty) as totQty from viewinv where  sal_ex = '" . trim($row["rep"]) . "'  and sdate>='" . $_GET['DT1'] . "' and sdate<='" . $_GET['DT2'] . "' and cancel_m = '0' and  stk_no <> 'SC01' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'A0356' and stk_no <> 'L0531' and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003'  and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003' and stk_no <> 'AL004' and stk_no <> 'AL005' and stk_no <> 'AL006' and stk_no <> 'AL007' and stk_no <> 'AL008' and stk_no <> 'AL009'  and stk_no <>'A0359'  and stk_no <>'AL011' and dis_per <> 100";
                    $sql_grn = " Select sum(Qty) as totQty from viewcrntrn where  sal_ex = '" . trim($row["rep"]) . "' and  sdate>='" . $_GET['DT1'] . "' and sdate<='" . $_GET['DT2'] . "' and cancell = '0' and  stk_no <> 'SC01' and stk_no <> 'A0350' and stk_no <> 'A0351' and stk_no <> 'A0352' and stk_no <> 'A0353' and stk_no <> 'A0354' and stk_no <> 'A0356' and stk_no <> 'L0531' and stk_no <> 'AL001' and stk_no <> 'AL002'  and stk_no <> 'AL003'  and stk_no <> 'AL001' and stk_no <> 'AL002' and stk_no <> 'AL003' and stk_no <> 'AL004' and stk_no <> 'AL005' and stk_no <> 'AL006' and stk_no <> 'AL007' and stk_no <> 'AL008' and stk_no <> 'AL009' and stk_no <> 'A0359' and stk_no <>'AL011'";


                    if ($_GET['cmbbrand'] != "All") {
                        $sql_inv .= " and s_Brand='" . $_GET['cmbbrand'] . "'";
                        $sql_grn .= " and Brand='" . $_GET['cmbbrand'] . "'";
                    }

                    $res_inv = mysqli_query($GLOBALS['dbinv'], $sql_inv);
                    if ($row_inv = mysqli_fetch_array($res_inv)) {
                        if (!is_null($row_inv['totQty'])) {
                            $invqty = $row_inv['totQty'];
                        }
                    }
                    $res_grn = mysqli_query($GLOBALS['dbinv'], $sql_grn);
                    if ($row_grn = mysqli_fetch_array($res_grn)) {
                        if (!is_null($row_grn['totQty'])) {
                            $rtnqty = $row_grn['totQty'];
                        }
                    }

                    $netqty = $invqty - $rtnqty;




                    echo "<tr><td>" . $row["rep"] . "</td>
				<td>" . $row["Name"] . "</td>
				<td align=\"right\">" . number_format($row["targ"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row["net"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row["targ"] - $row["net"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($grn, 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($netqty, 0, ".", ",") . "</td>
				</tr>";

                    $grossale = $grossale + $row["targ"];
                    $grossgrn = $grossgrn + $row["net"];
                    $net = $net + ($row["targ"] - $row["net"]);
                    $netq = $netq + ($netqty);


                    $grossale1 = $grossale1 + $row["targ"];
                    $grossgrn1 = $grossgrn1 + $row["net"];
                    $net1 = $net1 + ($row["targ"] - $row["net"]);
                    $net1q = $net1q + ($netqty);

                    $totgrossale = $totgrossale + $row["targ"];
                    $totgrossgrn = $totgrossgrn + $row["net"];
                    $totnet = $totnet + ($row["targ"] - $row["net"]);
                    $totnetq = $totnetq + ($netqty);
                }
                $rgroup = $row["rgroup"];
                $rgroup1 = $row["rgroup1"];
            }

            if ($totgrossale != 0) {
                $totgrngrp = $totgrossgrn / $totgrossale * 100;
            } else {
                $grngrp = 0;
            }

            if ($grossale1 != 0) {
                $grngrp1 = $grossgrn1 / $grossale1 * 100;
            } else {
                $grngrp1 = 0;
            }
            echo "<tr><td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align=\"right\"><b>" . number_format($grossale1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grossgrn1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($net1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grngrp1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($net1q, 0, ".", ",") . "</b></td>
					</tr>";
            if ($grossale != 0) {
                $grngrp = $grossgrn / $grossale * 100;
            } else {
                $grngrp = 0;
            }
            echo "<tr><td>&nbsp;</td>
					<th>&nbsp;</td>
					<th align=\"right\"><b>" . number_format($grossale, 2, ".", ",") . "</b></th>
					<th align=\"right\"><b>" . number_format($grossgrn, 2, ".", ",") . "</b></th>
					<th align=\"right\"><b>" . number_format($net, 2, ".", ",") . "</b></th>
					<th align=\"right\"><b>" . number_format($grngrp, 2, ".", ",") . "</b></th>
					<th align=\"right\"><b>" . number_format($netq, 0, ".", ",") . "</b></th>
					</tr>";
            $grngrp = 0;
            $grossale = 0;
            $grossgrn = 0;
            $net = 0;
            $grngrp = 0;


            echo "<tr><td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align=\"right\"><b>" . number_format($totgrossale, 2, ".", ",") . "</b></td>
				<td align=\"right\"><b>" . number_format($totgrossgrn, 2, ".", ",") . "</b></td>
				<td align=\"right\"><b>" . number_format($totnet, 2, ".", ",") . "</b></td>
				<td align=\"right\"><b>" . number_format($totgrngrp, 2, ".", ",") . "</b></td>
				<td align=\"right\"><b>" . number_format($totnetq, 0, ".", ",") . "</b></td>
				</tr>";

            echo "<table>";
        }

        function print1() {

            require_once("connectioni.php");


            if ($_GET["chkdef"] != "on") {
                $txtName = "Rep wise Sales Summery (Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
            }

            if ($_GET["chkdef"] == "on") {
                $txtName = "Rep wise Sales Summery (with Defective)(Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
            }


            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $heading . "</center><br>";

            echo "<center>" . $txtName . "</center><br>";

            echo "<center><table border=1><tr>
		 
                <th colspan='2'>Sales Rep</th>
		<th>Gross Sales</th>
		<th>Gross Return</th>
		<th>GRN %</th>
                <th>Net Sale</th>
		</tr>";
            //echo $sql;
            $totgrossale = 0;
            $totgrossgrn = 0;
            $totnet = 0;
            $rgroup1 = "";
            $chk = 0;
            $chk1 = 0;
            $sql = "select rep,Name,rgroup,rgroup1,sum(grossale) as grossale,sum(grossgrn) as grossgrn,sum(net) as net from tmprepsale where user_id='" . $_SESSION["CURRENT_USER"] . "' group by  rep,name,rgroup,rgroup1 order by rgroup,rgroup1,rep desc";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {



                if ($row["rgroup"] != $rgroup) {
                    if ($grossale != 0) {
                        $grngrp = $grossgrn / $grossale * 100;
                    } else {
                        $grngrp = 0;
                    }
                    if ($rgroup1 != "") {
                        echo "<tr><td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align=\"right\"><b>" . number_format($grossale1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grossgrn1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grngrp1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($net1, 2, ".", ",") . "</b></td>
					</tr>";
                    }
                    if ($rgroup != "") {
                        echo "<tr><td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align=\"right\"><b>" . number_format($grossale, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grossgrn, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grngrp, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($net, 2, ".", ",") . "</b></td>
					</tr>";
                    }
                    $chk = 1;
                    echo "<tr>
					<th colspan=6 align=left><b>" . $row["rgroup"] . "</b></th>
					<tr>";
                    $grossale = 0;
                    $grossgrn = 0;
                    $net = 0;
                    $grossale1 = 0;
                    $grossgrn1 = 0;
                    $net1 = 0;
                    $rgroup1 = "";
                }


                if ($row["rgroup1"] != $rgroup1) {
                    if ($grossale1 != 0) {
                        $grngrp1 = $grossgrn1 / $grossale1 * 100;
                    } else {
                        $grngrp1 = 0;
                    }

                    if ($rgroup1 != "") {
                        echo "<tr><td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align=\"right\"><b>" . number_format($grossale1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grossgrn1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grngrp1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($net1, 2, ".", ",") . "</b></td>
					</tr>";
                    }
                    $chk1 = 1;

                    echo "<tr><th></th>
					<th align=left><b>" . $row["rgroup1"] . "</b></th><th colspan='4'></th>
					<tr>";
                    $grossale1 = 0;
                    $grossgrn1 = 0;
                    $net1 = 0;
                    $rgroup1 = "";
                }

                if (($row["grossale"] > 0) or ( $row["grossgrn"] > 0) or ( $row["net"] > 0)) {

                    if ($row["grossale"] != 0) {
                        $grn = $row["grossgrn"] / $row["grossale"] * 100;
                    } else {
                        $grn = 0;
                    }

                    echo "<tr><td>" . $row["rep"] . "</td>
				<td>" . $row["Name"] . "</td>
				<td align=\"right\">" . number_format($row["grossale"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row["grossgrn"], 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($grn, 2, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row["net"], 2, ".", ",") . "</td>
				</tr>";

                    $grossale = $grossale + $row["grossale"];
                    $grossgrn = $grossgrn + $row["grossgrn"];
                    $net = $net + $row["net"];

                    $grossale1 = $grossale1 + $row["grossale"];
                    $grossgrn1 = $grossgrn1 + $row["grossgrn"];
                    $net1 = $net1 + $row["net"];

                    $totgrossale = $totgrossale + $row["grossale"];
                    $totgrossgrn = $totgrossgrn + $row["grossgrn"];
                    $totnet = $totnet + $row["net"];
                }
                $rgroup = $row["rgroup"];
                $rgroup1 = $row["rgroup1"];
            }

            if ($totgrossale != 0) {
                $totgrngrp = $totgrossgrn / $totgrossale * 100;
            } else {
                $grngrp = 0;
            }

            echo "<tr><td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align=\"right\"><b>" . number_format($grossale1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grossgrn1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($grngrp1, 2, ".", ",") . "</b></td>
					<td align=\"right\"><b>" . number_format($net1, 2, ".", ",") . "</b></td>
					</tr>";
            echo "<tr><td>&nbsp;</td>
					<th>&nbsp;</td>
					<th align=\"right\"><b>" . number_format($grossale, 2, ".", ",") . "</b></td>
					<th align=\"right\"><b>" . number_format($grossgrn, 2, ".", ",") . "</b></td>
					<th align=\"right\"><b>" . number_format($grngrp, 2, ".", ",") . "</b></td>
					<th align=\"right\"><b>" . number_format($net, 2, ".", ",") . "</b></td>
					</tr>";
            echo "<tr><td>&nbsp;</td>
				<th>&nbsp;</td>
				<th align=\"right\"><b>" . number_format($totgrossale, 2, ".", ",") . "</b></td>
				<th align=\"right\"><b>" . number_format($totgrossgrn, 2, ".", ",") . "</b></td>
				<th align=\"right\"><b>" . number_format($totgrngrp, 2, ".", ",") . "</b></td>
				<th align=\"right\"><b>" . number_format($totnet, 2, ".", ",") . "</b></td>
				</tr>";

            echo "<table>";
        }

        function reporecrd() {

            require_once("connectioni.php");



            $insert = "";

            if ($_GET["cmbdev"] == "All") {
                $dev = "A";
            }
            if ($_GET["cmbdev"] == "Manual") {
                $dev = "0";
            }
            if ($_GET["cmbdev"] == "Computer") {
                $dev = "1";
            }

            $sql = "delete from tmprepsale where user_id='" . $_SESSION["CURRENT_USER"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);


            $sql_rep = "SELECT * FROM s_salrep where REPCODE='" . $_GET["salesrep"] . "'  order by REPCODE desc";
            $result_rep = mysqli_query($GLOBALS['dbinv'], $sql_rep);
            while ($row_rep = mysqli_fetch_array($result_rep)) {

                $mname = "";
                if (is_null($row_rep["Name"]) == false) {
                    $mname = $row_rep["Name"];
                }
                $SAL = 0;
                $ret = 0;
                $mnet = 0;

                if ($_GET["cmbbrand"] == "All") {
                    $sql_rst = "SELECT * FROM s_salma where Accname != 'NON STOCK' and SAL_EX='" . $row_rep["REPCODE"] . "' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "' or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' and DEV!='" . $dev . "'";
                }

                if ($_GET["cmbbrand"] != "All") {
                    $sql_rst = "SELECT * FROM s_salma where Accname != 'NON STOCK' and Brand='" . $_GET["cmbbrand"] . "' and SAL_EX='" . $row_rep["REPCODE"] . "' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "')and CANCELL='0' and DEV!='" . $dev . "'";
                }
                //echo $sql_rst;
                $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
                while ($row_rst = mysqli_fetch_array($result_rst)) {
                    $SAL = $SAL + $row_rst["GRAND_TOT"];
                    $mnet = $mnet + ($row_rst["GRAND_TOT"] / (1 + ($row_rst["GST"] / 100)));
                }

                if ($_GET["cmbbrand"] == "All") {
                    if ($_GET["chkdef"] != "on") {

                        $sql_rst2 = "SELECT * FROM c_bal WHERE  (flag1 = '0') and SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
                    }

                    if ($_GET["chkdef"] == "on") {
                        $sql_rst2 = "SELECT * FROM c_bal WHERE  (flag1 = '0') and SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
                    }
                } else {

                    if ($_GET["chkdef"] != "on") {
                        $sql_rst2 = "SELECT * FROM c_bal WHERE (flag1 = '0') and brand='" . $_GET["cmbbrand"] . "' and  SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
                    }

                    if ($_GET["chkdef"] == "on") {
                        $sql_rst2 = "SELECT * FROM c_bal WHERE (flag1 = '0') and brand='" . $_GET["cmbbrand"] . "' and  SAL_EX='" . $row_rep["REPCODE"] . "' AND trn_type!='REC' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY' AND (SDATE>'" . $_GET["DT1"] . "'or SDATE='" . $_GET["DT1"] . "')  AND( SDATE<'" . $_GET["DT2"] . "'or  SDATE='" . $_GET["DT2"] . "') and CANCELL='0' and DEV!='" . $dev . "' ";
                    }
                }


                $result_rst2 = mysqli_query($GLOBALS['dbinv'], $sql_rst2);
                while ($row_rst2 = mysqli_fetch_array($result_rst2)) {
                    $ret = $ret + $row_rst2["AMOUNT"];
                    $mnet = $mnet - ($row_rst2["AMOUNT"] / (1 + ($row_rst2["vatrate"] / 100)));
                }

                if ($i != 0) {
                    $insert = $insert . ", ";
                }

                $insert = $insert . "('" . $row_rep["REPCODE"] . "', " . $SAL . ", " . $ret . ", '" . $mname . "', " . $mnet . ", '" . $_SESSION["CURRENT_USER"] . "')";
                $i = 1;
            }

            $sql_tem = "insert into tmprepsale(rep, grossale, grossgrn, Name, net, user_id) values " . $insert;
            $result_tem = mysqli_query($GLOBALS['dbinv'], $sql_tem);
            //echo $sql_tem;

            if ($_GET["chkdef"] != "on") {
                $txtName = "Rep wise Sales Summery (Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
            }

            if ($_GET["chkdef"] == "on") {
                $txtName = "Rep wise Sales Summery (with Defective)(Brand :" . $_GET["cmbbrand"] . ") From  " . $_GET["DT1"] . "   To   " . $_GET["DT2"];
            }


            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $heading . "</center><br>";

            echo "<center>" . $txtName . "</center><br>";

            echo "<center><table border=1><tr>
		<th>Rep Code</th>
		<th>Rep Name</th>
		<th>Gross Sales</th>
		<th>Gross Return</th>
		<th>Net Sales</th>
		</tr>";
            //echo $sql;
            $sql = "select * from tmprepsale where user_id='" . $_SESSION["CURRENT_USER"] . "' order by rgroup";
            $rgroup = "";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {
                if ($row["rgroup"] != $rgroup) {
                    echo "<tr>
					<td colspan=4 align=left><b>" . $row["rgroup"] . "</b></td>
					<tr>";
                }
                echo "<td>" . $row["rep"] . "</td>
			<td>" . $row["Name"] . "</td>
			<td align=\"right\">" . number_format($row["grossale"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["grossgrn"], 2, ".", ",") . "</td>
			<td align=\"right\">" . number_format($row["net"], 2, ".", ",") . "</td>
			</tr>";
                $rgroup = $row["rgroup"];
            }

            echo "<table>";
        }

        $sql = "delete from tmprepsale where user_id='" . $_SESSION["CURRENT_USER"] . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        ?>



    </body>
</html>

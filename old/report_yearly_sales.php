<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Yearly Sales Report</title>

        <style>
            table {
                border-collapse: collapse;
            }
            table, td, th {
                border: 1px solid black;
                font-family: Arial, Helvetica, sans-serif;
                padding: 5px;
            }
            th {
                font-weight: bold;
                font-size: 14px;
            }
            td {
                font-size: 14px;;
                border-bottom: none;
                border-top: none;
            }
        </style>

    </head>

    <body>

        <?php
        require_once ("connectioni.php");

        if ($_GET["radio"] == "Option2") {
            nilsal();
        } else {
            othersales();
        }

        function nilsal() {

            require_once ("connectioni.php");

            $sql = "delete from monsales where user_id='" . $_SESSION["CURRENT_USER"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $date = date("Y-m-d", strtotime($_GET["DTPicker1"]));
            $caldays = " - 90 days";
            $tmpdate = date('Y-m-d', strtotime($date . $caldays));
            $i = 0;

            $month1 = date("m", strtotime($_GET["month1"]));
            $month2 = date("m", strtotime($_GET["month2"]));
            $month3 = date("m", strtotime($_GET["month3"]));
            $month1_y = date("Y", strtotime($_GET["month1"]));
            $month2_y = date("Y", strtotime($_GET["month2"]));
            $month3_y = date("Y", strtotime($_GET["month3"]));

            //$sqlv = "SELECT cus_code FROM view_brtrn_vendor  WHERE pen0  <>'1' and  opdate <= '" . $tmpdate . "'";
            $sqlv = "SELECT cus_code FROM view_brtrn_vendor  WHERE opdate <= '" . $tmpdate . "'";
            if ($_GET["cmbrep"] != "All") {
                $sqlv .= " and rep= '" . $_GET['cmbrep'] . "'";
            }
            if ($_GET["ChKCUS"] == "on") {
                $sqlv .= " and cus_CODE= '" . trim($_GET["cuscode"]) . "'";
            }
            $sqlv .= " group by cus_code";

            $i = 0;
            $result_v = mysqli_query($GLOBALS['dbinv'], $sqlv);
            while ($row_v = mysqli_fetch_array($result_v)) {

                $strinv = "select sum(grand_tot/(1 +gst/100)) as gtot,brand,c_code,month(sdate) as month ,year(sdate) as year from s_salma where ACCNAME <> 'NON STOCK'   and CANCELL='0' ";
                if ($_GET["cmbrep"] != "All") {
                    $strinv .= " and sal_ex= '" . $_GET['cmbrep'] . "'";
                }
                if ($_GET["cmbbrand"] != "All") {
                    $strinv .= " and brand= '" . $_GET['cmbbrand'] . "'";
                }
                $strinv .= " and c_code= '" . trim($row_v["cus_code"]) . "'";
                $strinv .= " and (( month(sdate) = '" . $month1 . "'  and year(sdate) = '" . $month1_y . "') ";
                $strinv .= " or ( month(sdate) = '" . $month2 . "'  and year(sdate) = '" . $month2_y . "') ";
                $strinv .= " or ( month(sdate) = '" . $month3 . "'  and year(sdate) = '" . $month3_y . "')) ";
                $strinv .= "  group by brand,c_code,year(sdate), month(sdate) ";

                $result2 = mysqli_query($GLOBALS['dbinv'], $strinv);
                $nmr = mysqli_num_rows($result2);

                $strgrn = "select sum(amount/(1 +vatrate/100)) as gtot,CUSCODE,brand,month(sdate) as month ,year(sdate) as year from c_bal where  trn_type<>'INC'and trn_type<>'REC' and trn_type<>'PAY' and trn_type<>'ARN'  and flag1 <> '1'";
                if ($_GET["cmbrep"] != "All") {
                    $strgrn .= " and SAL_EX ='" . $_GET['cmbrep'] . "'";
                }
                $strgrn .= " and cuscode= '" . trim($row_v["cus_code"]) . "'";
                if (!isset($_GET["chkdef"])) {
                    $strgrn .= " and trn_type <> 'DGRN'";
                }
                if ($_GET["cmbbrand"] != "All") {
                    $strgrn .= " and brand= '" . $_GET['cmbbrand'] . "'";
                }
                $strgrn .= " and (( month(sdate) = '" . $month1 . "'  and year(sdate) = '" . $month1_y . "') ";
                $strgrn .= " or ( month(sdate) = '" . $month2 . "'  and year(sdate) = '" . $month2_y . "') ";
                $strgrn .= " or ( month(sdate) = '" . $month3 . "'  and year(sdate) = '" . $month3_y . "')) ";
                $strgrn .= "  group by brand,CUSCODE,year(sdate), month(sdate) ";

                $result2 = mysqli_query($GLOBALS['dbinv'], $strgrn);
                //                if ($nmr==0 && mysqli_num_rows($result2)>0)
                //                    {
                //
				//                $nmr =0;
                //                    } else {
                $nmr = $nmr + mysqli_num_rows($result2);
                //}
                if ($nmr == 0) {
                    $sql = "select * from br_trn where  cus_code='" . trim($row_v["cus_code"]) . "' ";
                    if ($_GET["cmbrep"] != "All") {
                        $sql .= " and Rep ='" . $_GET['cmbrep'] . "'";
                    }
                    //echo $sql;
                    $result4 = mysqli_query($GLOBALS['dbinv'], $sql);
                    $lmt = 0;
                    $numr = mysqli_num_rows($result4);
                    $exist = 0;

                    $cat = "";
                    if ($numr == 1) {
                        $row_tmpLmt = mysqli_fetch_array($result4);
                        $lmt = $lmt + $row_tmpLmt["credit_lim"];

                        //if ((trim($row_tmpLmt["CAT"])!="") and (trim($row_tmpLmt["CAT"])!="D")) {
                        $exist = 1;
                        $cat = $row_tmpLmt["CAT"];
                        //}
                    } else {

                        while ($row_tmpLmt = mysqli_fetch_array($result4)) {
                            if (trim($row_tmpLmt["CAT"]) == "A") {
                                $lmt = $lmt + ($row_tmpLmt["credit_lim"] * 2.5);
                                $exist = 1;
                            }
                            if (trim($row_tmpLmt["CAT"]) == "B") {
                                $lmt = $lmt + ($row_tmpLmt["credit_lim"] * 2.5);
                                $exist = 1;
                            }
                            if (trim($row_tmpLmt["CAT"]) == "C") {
                                $lmt = $lmt + $row_tmpLmt["credit_lim"];
                                $exist = 1;
                            }

                            if (trim($row_tmpLmt["CAT"]) == "Z") {
                                $lmt = $lmt + $row_tmpLmt["credit_lim"];
                                $exist = 1;
                            }

                            if ($_GET["cmbrep"] != "All") {
                                $cat = $row_tmpLmt["CAT"];
                            }
                        }
                    }

                    if ($exist == 1) {
                        $sql_rsVENDOR = "SELECT * FROM vendor WHERE CODE='" . trim($row_v["cus_code"]) . "' ";
                        $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sql_rsVENDOR);
                        $row_rsVENDOR = mysqli_fetch_array($result_rsVENDOR);

                        //if ($_GET["cmbrep"] == "All") {
                        $cat = $row_rsVENDOR["CAT"];
                        //}

                        if ($i != 0) {
                            $insert = $insert . ", ";
                        }

                        $insert = $insert . "('" . trim($row_v["cus_code"]) . "', '" . $row_rsVENDOR["NAME"] . "', '" . $lmt . "', '" . $cat . "', '" . ($mon1 - $Gmon1) . "',  '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "', '" . trim($row_rsVENDOR["cus_type"]) . "', '', '" . $_SESSION["CURRENT_USER"] . "')";

                        $i = 1;

                        //$sql_RSMONSALES = "insert into monsales(Cus_Code, cus_name, limit1, cat,  month1, month2, month3, C_TYPE,brand) values "
                        //    . "('" . trim($row_v["cus_code"]) . "', '" . $row_rsVENDOR["NAME"] . "', '" . $lmt . "', '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "', '" . $row_rsVENDOR["cus_type"] . "' , '' )";
                        //$result_rsVENDOR = mysqli_query($GLOBALS['dbinv'],$sql_RSMONSALES);
                    }
                }
            }

            $sql_RSMONSALES = "insert into monsales(Cus_Code, cus_name, limit1, cat,  month1, month2, month3, C_TYPE, brand, user_id) values " . $insert;
            //echo $sql_RSMONSALES;
            $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sql_RSMONSALES);
            PrintRep2();
        }

        function othersales() {

            require_once ("connectioni.php");

            $sql = "delete from monsales where user_id='" . $_SESSION["CURRENT_USER"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $date = date("Y-m-d", strtotime($_GET["DTPicker1"]));
            $caldays = " - 90 days";
            $tmpdate = date('Y-m-d', strtotime($date . $caldays));
            $i = 0;

            $month1 = date("m", strtotime($_GET["month1"]));
            $month2 = date("m", strtotime($_GET["month2"]));
            $month3 = date("m", strtotime($_GET["month3"]));
            $month1_y = date("Y", strtotime($_GET["month1"]));
            $month2_y = date("Y", strtotime($_GET["month2"]));
            $month3_y = date("Y", strtotime($_GET["month3"]));


            $month12 = date("m", strtotime($_GET["month12"]));
            $month22 = date("m", strtotime($_GET["month22"]));
            $month32 = date("m", strtotime($_GET["month32"]));
            $month12_y = date("Y", strtotime($_GET["month12"]));
            $month22_y = date("Y", strtotime($_GET["month22"]));
            $month32_y = date("Y", strtotime($_GET["month32"]));

            $strinv = "select sum(grand_tot/(1 +gst/100)) as gtot,brand,c_code,c_code1,CUS_NAME,month(sdate) as month ,year(sdate) as year from s_salma where ACCNAME <> 'NON STOCK'   and CANCELL='0' ";
            if ($_GET["cmbrep"] != "All") {
                $strinv .= " and sal_ex= '" . $_GET['cmbrep'] . "'";
            }
            if ($_GET["cmbbrand"] != "All") {
                $strinv .= " and brand= '" . $_GET['cmbbrand'] . "'";
            }

            if ($_GET["radio"] == "op_traget") {
                $strinv .= " and totpay1= '1'";
            }

            if ($_GET["ChKCUS"] == "on") {
                $strinv .= " and c_code= '" . trim($_GET["cuscode"]) . "'";
            }
            //$month1 = substr($_GET["month1"], 5 , 2);  // date("m", strtotime($_GET["month1"]));

            $sdate1 = $month1_y . "-" . $month1 . "-01";
            $sdate2 = $month2_y . "-" . $month2 . "-01";
            $sdate3 = $month3_y . "-" . $month3 . "-01";

            $sdate12 = $_GET["month12"];
            $sdate22 = $_GET["month22"];
            $sdate32 = $_GET["month32"];



            $strinv .= " and (sdate>='" . $sdate1 . "' and sdate <='" . $sdate32 . "')";
            $strinv .= "  group by brand,c_code,c_code1,year(sdate), month(sdate) ";

            $mon1 = 0;
            $mon2 = 0;
            $mon3 = 0;
            $Gmon3 = 0;
            $Gmon2 = 0;
            $Gmon1 = 0;
            $result2 = mysqli_query($GLOBALS['dbinv'], $strinv);
            while ($row_RSINVO01 = mysqli_fetch_array($result2)) {

                $yy = "n";
                if ($_GET["radio"] == "op_traget") {


                    $dt = $row_RSINVO01['year'] . "-" . $row_RSINVO01['month'] . "-01";
                    $dtftom = date("Y-m-t", strtotime($dt));


                    $sql_itclas = "select * from insentive_scheme where   sfrom <='" . $dtftom . "' and sto >='" . $dtftom . "' and brand ='" . $row_RSINVO01['brand'] . "' ";
                    if ($_GET['cmb_t'] != "All") {

                        if ($_GET['cmb_t'] == "TYRE") {
                            $sql_itclas .= " and (inc_type='TYRE' or inc_type='ALLOY WHEEL')";
                        } else {
                            $sql_itclas .= " and inc_type='" . $_GET['cmb_t'] . "'";
                        }
                    }


                    $result_itclas = mysqli_query($GLOBALS['dbinv'], $sql_itclas);

                    if (mysqli_num_rows($result_itclas) > 0) {
                        $yy = "y";
                    }
                } else {
                    $yy = "y";
                }

                if ($yy == "y") {

                    $mon1 = 0;
                    $mon2 = 0;
                    $mon3 = 0;
                    $Gmon3 = 0;
                    $Gmon2 = 0;
                    $Gmon1 = 0;
                    $sql = "select * from br_trn where  cus_code='" . Trim($row_RSINVO01['c_code']) . "' ";
                    if ($_GET["cmbrep"] != "All") {
                        $sql .= " and Rep ='" . $_GET['cmbrep'] . "'";
                    }
                    $result4 = mysqli_query($GLOBALS['dbinv'], $sql);
                    $lmt = 0;
                    $numr = mysqli_num_rows($result4);

                    if ($numr == 1) {
                        $row_tmpLmt = mysqli_fetch_array($result4);
                        $lmt = $lmt + $row_tmpLmt["credit_lim"];
                    } else {

                        while ($row_tmpLmt = mysqli_fetch_array($result4)) {
                            if (trim($row_tmpLmt["CAT"]) == "A") {
                                $lmt = $lmt + ($row_tmpLmt["credit_lim"] * 2.5);
                            }
                            if (trim($row_tmpLmt["CAT"]) == "B") {
                                $lmt = $lmt + ($row_tmpLmt["credit_lim"] * 2.5);
                            }
                            if (trim($row_tmpLmt["CAT"]) == "C") {
                                $lmt = $lmt + $row_tmpLmt["credit_lim"];
                            }
                            if (trim($row_tmpLmt["CAT"]) == "Z") {
                                $lmt = $lmt + $row_tmpLmt["credit_lim"];
                            }
                        }
                    }
                    $sql_rsVENDOR = "SELECT * FROM vendor WHERE CODE='" . trim($row_RSINVO01['c_code']) . "' ";
                    if ($_GET['cmbprovince'] != "All") {
                        $sql_rsVENDOR .= " and province='" . $_GET['cmbprovince'] . "'";
                    }
                    if ($_GET['cmbdistrict'] != "All") {
                        $sql_rsVENDOR .= " and district='" . $_GET['cmbdistrict'] . "'";
                    }

                    $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sql_rsVENDOR);
                    if ($row_rsVENDOR = mysqli_fetch_array($result_rsVENDOR)) {

                        $sdate = $row_RSINVO01["year"] . "-" . $row_RSINVO01["month"] . "-01";



                        if ((strtotime($sdate) <= strtotime($sdate12))) {
                            $mon1 = ($row_RSINVO01["gtot"]);
                        }
                        if ((strtotime($sdate) >= strtotime($sdate2)) and ( strtotime($sdate) <= strtotime($sdate22))) {

                            $mon2 = ($row_RSINVO01["gtot"]);
                        }
                        if ((strtotime($sdate) >= strtotime($sdate3)) and ( strtotime($sdate) <= strtotime($sdate32))) {
                            $mon3 = ($row_RSINVO01["gtot"]);
                        }


                        $sql_rsVENDOR_SUB = "SELECT c_name FROM vender_sub WHERE c_code='" . $row_RSINVO01['c_code1'] . "' ";
                        $result_rsVENDOR_SUB = mysqli_query($GLOBALS['dbinv'], $sql_rsVENDOR_SUB);
                        $row_rsVENDOR_SUB = mysqli_fetch_array($result_rsVENDOR_SUB);


                        $cat = $row_rsVENDOR["CAT"];

                        if ($_GET["chkdevelo_cus"] == "on") {
                            if ($cat == "Z") {
                                $usr[] = "('" . $row_RSINVO01['c_code1'] . "', '" . $row_rsVENDOR_SUB["c_name"] . "', '" . $lmt . "', '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "', '" . $row_rsVENDOR["cus_type"] . "' , '" . $row_RSINVO01['brand'] . "', '" . $_SESSION["CURRENT_USER"] . "' )";
                            }
                        } else {
                            $usr[] = "('" . $row_RSINVO01['c_code1'] . "', '" . $row_rsVENDOR_SUB["c_name"] . "', '" . $lmt . "', '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "', '" . $row_rsVENDOR["cus_type"] . "' , '" . $row_RSINVO01['brand'] . "', '" . $_SESSION["CURRENT_USER"] . "' )";
                        }
                    }
                }
            }

            $sql_RSMONSALES = "insert into monsales(Cus_Code, cus_name, limit1, cat,  month1, month2, month3, C_TYPE,brand, user_id) values " . implode(",", $usr);
            $result_RSMONSALES = mysqli_query($GLOBALS['dbinv'], $sql_RSMONSALES);

            $i = $i + 1;

            $strgrn = "select sum(amount/(1 +vatrate/100)) as gtot,CUSCODE,c_code1,brand,month(sdate) as month ,year(sdate) as year from c_bal where  trn_type<>'INC'and trn_type<>'REC' and trn_type<>'PAY' and trn_type<>'ARN'";

            if ($_GET["cmbrep"] != "All") {
                $strgrn .= " and SAL_EX ='" . $_GET['cmbrep'] . "'";
            }
            if ($_GET["ChKCUS"] == "on") {
                $strgrn .= " and CUSCODE ='" . $_GET['cuscode'] . "'";
            }
            if (!isset($_GET["chkdef"])) {
                //$strgrn .= " and trn_type <> 'DGRN'";
            }
            if ($_GET["cmbbrand"] != "All") {
                $strgrn .= " and brand= '" . $_GET['cmbbrand'] . "'";
            }

            $month1 = date("m", strtotime($_GET["month1"]));
            $month2 = date("m", strtotime($_GET["month2"]));
            $month3 = date("m", strtotime($_GET["month3"]));

            $month1_y = date("Y", strtotime($_GET["month1"]));
            $month2_y = date("Y", strtotime($_GET["month2"]));
            $month3_y = date("Y", strtotime($_GET["month3"]));




            $strgrn .= " and (sdate>='" . $sdate1 . "' and sdate <='" . $sdate32 . "') ";
            $strgrn .= "  group by brand,CUSCODE,c_code1,year(sdate), month(sdate) ";

            $mon1 = 0;
            $mon2 = 0;
            $mon3 = 0;
            $Gmon3 = 0;
            $Gmon2 = 0;
            $Gmon1 = 0;

            $result2 = mysqli_query($GLOBALS['dbinv'], $strgrn);
            while ($row_RSINVO01 = mysqli_fetch_array($result2)) {

                $yy = "n";
                if ($_GET["radio"] == "op_traget") {
                    $dt = $row_RSINVO01['year'] . "-" . $row_RSINVO01['month'] . "-01";
                    $dtftom = date("Y-m-t", strtotime($dt));


                    $sql_itclas = "select * from insentive_scheme where   sfrom <='" . $dtftom . "' and sto >='" . $dtftom . "' and brand ='" . $row_RSINVO01['brand'] . "' ";
                    if ($_GET['cmb_t'] != "All") {

                        if ($_GET['cmb_t'] == "TYRE") {
                            $sql_itclas .= " and (inc_type='TYRE' or inc_type='ALLOY WHEEL')";
                        } else {
                            $sql_itclas .= " and inc_type='" . $_GET['cmb_t'] . "'";
                        }
                    }
                    $result_itclas = mysqli_query($GLOBALS['dbinv'], $sql_itclas);

                    if (mysqli_num_rows($result_itclas) > 0) {
                        $yy = "y";
                    }
                } else {
                    $yy = "y";
                }

                if ($yy == "y") {
                    $mon1 = 0;
                    $mon2 = 0;
                    $mon3 = 0;
                    $Gmon3 = 0;
                    $Gmon2 = 0;
                    $Gmon1 = 0;
                    $sql = "select * from br_trn where  cus_code='" . Trim($row_RSINVO01['CUSCODE']) . "' ";
                    if ($_GET["cmbrep"] != "All") {
                        $sql .= " and rep= '" . $_GET['cmbrep'] . "'";
                    }
                    $result4 = mysqli_query($GLOBALS['dbinv'], $sql);
                    $lmt = 0;
                    $numr = mysqli_num_rows($result4);

                    if ($numr == 1) {
                        $row_tmpLmt = mysqli_fetch_array($result4);
                        $lmt = $lmt + $row_tmpLmt["credit_lim"];
                    } else {
                        while ($row_tmpLmt = mysqli_fetch_array($result4)) {
                            if (trim($row_tmpLmt["CAT"]) == "A") {
                                $lmt = $lmt + ($row_tmpLmt["credit_lim"] * 2.5);
                            }
                            if (trim($row_tmpLmt["CAT"]) == "B") {
                                $lmt = $lmt + ($row_tmpLmt["credit_lim"] * 2.5);
                            }
                            if (trim($row_tmpLmt["CAT"]) == "C") {
                                $lmt = $lmt + $row_tmpLmt["credit_lim"];
                            }
                            if (trim($row_tmpLmt["CAT"]) == "Z") {
                                $lmt = $lmt + $row_tmpLmt["credit_lim"];
                            }
                        }
                    }

                    $sql_rsVENDOR = "SELECT * FROM vendor WHERE CODE='" . trim($row_RSINVO01['CUSCODE']) . "' ";
                    if ($_GET['cmbprovince'] != "All") {
                        $sql_rsVENDOR .= " and province='" . $_GET['cmbprovince'] . "'";
                    }
                    if ($_GET['cmbdistrict'] != "All") {
                        $sql_rsVENDOR .= " and district='" . $_GET['cmbdistrict'] . "'";
                    }
                    $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sql_rsVENDOR);
                    if ($row_rsVENDOR = mysqli_fetch_array($result_rsVENDOR)) {



                        $sdate = $row_RSINVO01["year"] . "-" . $row_RSINVO01["month"] . "-01";

                        if ((strtotime($sdate) <= strtotime($sdate12))) {

                            $Gmon1 = ($row_RSINVO01["gtot"]);
                        }
                        if ((strtotime($sdate) >= strtotime($sdate2)) and ( strtotime($sdate) <= strtotime($sdate22))) {
                            $Gmon2 = ($row_RSINVO01["gtot"]);
                        }
                        if ((strtotime($sdate) >= strtotime($sdate3)) and ( strtotime($sdate) <= strtotime($sdate32))) {
                            $Gmon3 = ($row_RSINVO01["gtot"]);
                        }
                        $cat = $row_rsVENDOR["CAT"];

                        $sql_rsVENDOR_SUB = "SELECT c_name FROM vender_sub WHERE c_code='" . $row_RSINVO01['c_code1'] . "' ";
                        $result_rsVENDOR_SUB = mysqli_query($GLOBALS['dbinv'], $sql_rsVENDOR_SUB);
                        $row_rsVENDOR_SUB = mysqli_fetch_array($result_rsVENDOR_SUB);

                        if ($_GET["chkdevelo_cus"] == "on") {
                            if ($cat == "Z") {
                                $usr1[] = "('" . $row_RSINVO01['c_code1'] . "', '" . $row_rsVENDOR_SUB["c_name"] . "', '" . $lmt . "', '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "', '" . $row_rsVENDOR["cus_type"] . "' , '" . $row_RSINVO01['brand'] . "', '" . $_SESSION["CURRENT_USER"] . "' )";
                            }
                        } else {
                            $usr1[] = "('" . $row_RSINVO01['c_code1'] . "', '" . $row_rsVENDOR_SUB["c_name"] . "', '" . $lmt . "', '" . $cat . "', '" . ($mon1 - $Gmon1) . "', '" . ($mon2 - $Gmon2) . "', '" . ($mon3 - $Gmon3) . "', '" . $row_rsVENDOR["cus_type"] . "' , '" . $row_RSINVO01['brand'] . "', '" . $_SESSION["CURRENT_USER"] . "' )";
                        }
                    }
                }
            }

            $sql_RSMONSALES = "insert into monsales(Cus_Code, cus_name, limit1, cat,  month1, month2, month3, C_TYPE,brand, user_id) values " . implode(",", $usr1);
            $result_RSMONSALES = mysqli_query($GLOBALS['dbinv'], $sql_RSMONSALES);

            if ($_GET["radio"] == "op_traget") {

                $sql = "select Cus_Code,C_TYPE,limit1,cus_name,cat from monsales  where  user_id='" . $_SESSION["CURRENT_USER"] . "' group by Cus_Code,C_TYPE,limit1,cus_name,cat";
                $result_mas = mysqli_query($GLOBALS['dbinv'], $sql);

                while ($row = mysqli_fetch_array($result_mas)) {
                    $sql_itclas = "select * from insentive_scheme where year(sfrom) >='" . ($month1_y - 1) . "'";

                    if ($_GET['cmb_t'] != "All") {
                        if ($_GET['cmb_t'] == "TYRE") {
                            $sql_itclas .= " and (inc_type='TYRE' or inc_type='ALLOY WHEEL')";
                        } else {
                            $sql_itclas .= " and inc_type='" . $_GET['cmb_t'] . "'";
                        }
                    }


                    $dt = $row_RSINVO01['year'] . "-" . $row_RSINVO01['month'] . "-01";
                    $dtftom = date("Y-m-t", strtotime($dt));

                    $dtfrom = $_GET["year1"] . "-" . $_GET["month1"] . "-01";
                    $dtfrom = date("Y-m-t", strtotime($dtfrom));
                    $dtto = $_GET["year3"] . "-" . $_GET["month3"] . "-01";
                    $dtto = date("Y-m-t", strtotime($dtto));



                    $result_mas1 = mysqli_query($GLOBALS['dbinv'], $sql_itclas);

                    while ($row1 = mysqli_fetch_array($result_mas1)) {

                        $sql = "select * from monsales where cus_code = '" . $row['Cus_Code'] . "' and brand ='" . $row1['brand'] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'";

                        $result_mas0 = mysqli_query($GLOBALS['dbinv'], $sql);
                        $num = mysqli_num_rows($result_mas0);

                        if ($num == 0) {
                            $usr2[] = "('" . $row['Cus_Code'] . "', '" . $row_rsVENDOR["NAME"] . "', '" . $row['limit1'] . "', '" . $row['cat'] . "', '0', '0', '0', '" . $row["C_TYPE"] . "' , '" . $row1['brand'] . "', '" . $_SESSION["CURRENT_USER"] . "' )";
                        }
                    }
                }

                $sql_RSMONSALES1 = "insert into monsales(Cus_Code, cus_name, limit1, cat,  month1, month2, month3, C_TYPE,brand, user_id) values " . implode(",", $usr2);
                $result_RSMONSALES = mysqli_query($GLOBALS['dbinv'], $sql_RSMONSALES1);
                if (!$result_RSMONSALES) {
                    echo mysqli_error($GLOBALS['dbinv']);
                }
            }

            if ($_GET["chkdevelo_cus"] == "on") {

                $sql_rsVENDOR = "SELECT * FROM vendor WHERE CAT='Z' ";
                $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sql_rsVENDOR);
                while ($row_rsVENDOR = mysqli_fetch_array($result_rsVENDOR)) {

                    $sql_mon = "SELECT * FROM monsales WHERE Cus_Code='" . $row_rsVENDOR["CODE"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'";
                    $result_mon = mysqli_query($GLOBALS['dbinv'], $sql_mon);
                    if ($row_mon = mysqli_fetch_array($result_mon)) {
                        //echo "<b>".$row_rsVENDOR["CODE"]."</b> ";
                    } else {
                        //echo $row_rsVENDOR["CODE"]." ";
                        if ($_GET['cmbrep'] != "All") {
                            $sql_br = "SELECT * FROM br_trn WHERE cus_code='" . $row_rsVENDOR["CODE"] . "' and Rep='" . $_GET['cmbrep'] . "'";
                        } else {
                            $sql_br = "SELECT * FROM br_trn WHERE cus_code='" . $row_rsVENDOR["CODE"] . "'";
                        }

                        $result_br = mysqli_query($GLOBALS['dbinv'], $sql_br);
                        if ($row_br = mysqli_fetch_array($result_br)) {

                            $sql_RSMONSALES = "insert into monsales(Cus_Code, cus_name, limit1, cat,  month1, month2, month3, C_TYPE,brand, user_id) values " . "('" . $row_rsVENDOR["CODE"] . "', '" . $row_rsVENDOR["NAME"] . "', '" . $row_br["credit_lim"] . "', 'Z', '0', '0', '0', '" . $row_rsVENDOR["cus_type"] . "' , '" . $row_br['brand'] . "', '" . $_SESSION["CURRENT_USER"] . "' )";
                            //echo $sql_RSMONSALES;
                            $result_RSMONSALES = mysqli_query($GLOBALS['dbinv'], $sql_RSMONSALES);
                        }
                    }
                }
            }

            //                    $i = $i + 1;
            //                }
            //brand loop
            if ($_GET["radio"] == "op_traget") {
                PrintRep1();
            } else {
                PrintRep2();
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
            if ($_GET["cmbrep"] != "All") {
                $rtxtrep = "Person : " . trim($_GET["cmbrep"]);
            }
            if ($_GET["cmbrep"] == "All") {
                $rtxtrep = "Person : " . $_GET["cmbrep"];
            }
            $rtxtbrand = "Brand : " . $_GET["cmbbrand"];

            $rtxtm1 = date("M", strtotime($_GET["month1"])) . " " . date("Y", strtotime($_GET["month1"])) . "/" . date("M", strtotime($_GET["month12"])) . " " . date("Y", strtotime($_GET["month12"]));
            $rtxtm2 = date("M", strtotime($_GET["month2"])) . " " . date("Y", strtotime($_GET["month2"])) . "/" . date("M", strtotime($_GET["month22"])) . " " . date("Y", strtotime($_GET["month22"]));
            $rtxtm3 = date("M", strtotime($_GET["month3"])) . " " . date("Y", strtotime($_GET["month3"])) . "/" . date("M", strtotime($_GET["month32"])) . " " . date("Y", strtotime($_GET["month32"]));

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";
            echo "<center>Monthly Sales Summery  ";
            echo $rtxtrep . "</br>";
            echo $rtxtbrand . "</br>";
            echo $heading;
            echo "Province : " . $_GET['cmbprovince'] . "</br>";
            echo "District : " . $_GET['cmbdistrict'] . "</br>";
            echo "<center><table border=1><tr>
		<th></th>	
		<th>Code</th>
		<th>Customer Name</th>
		 
		<th>" . $rtxtm1 . "</th>
		<th>" . $rtxtm2 . "</th>
		<th>" . $rtxtm3 . "</th>
		
		</tr>";
            //echo $sql;
            $month1 = 0;
            $month2 = 0;
            $month3 = 0;
            $limit = 0;

            if ($_GET["radio"] == "Option2") {
                $sql_sql = "SELECT cus_code,cus_name,cat,limit1 from monsales where user_id='" . $_SESSION["CURRENT_USER"] . "' and cat <> 'D' and c_type <> 'F' and cat <> '' and limit1 <> 0  group by cus_code,cus_name,cat,limit1 ";
            } else {
                $sql_sql = "SELECT cus_code,cus_name,cat,limit1 from monsales where user_id='" . $_SESSION["CURRENT_USER"] . "'    group by cus_code,cus_name,cat,limit1 ";
            }
            $result_sql = mysqli_query($GLOBALS['dbinv'], $sql_sql);
            $i = 1;
            while ($row_sql = mysqli_fetch_array($result_sql)) {
                $sql_sql1 = "SELECT sum(month1)as month1,sum(month2) as month2,sum(month3) as month3 from monsales where cus_code ='" . $row_sql["cus_code"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'  ";
                $result_sql1 = mysqli_query($GLOBALS['dbinv'], $sql_sql1);
                while ($row_sql1 = mysqli_fetch_array($result_sql1)) {

                    $sql_vendor = "select * from vendor where code ='" . $row_sql["cus_code"] . "' ";

                    echo "<tr>
				<td>" . $i . "</td>	
				<td>" . $row_sql["cus_code"] . "</td>
				 
				<td>" . $row_sql["cus_name"] . "</td>";

                    echo "<td align=\"right\">" . number_format($row_sql1["month1"], 0, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month2"], 0, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month3"], 0, ".", ",") . "</td>";

                    echo "</tr>";
                    $month1_tot = $month1_tot + $row_sql1["month1"];
                    $month2_tot = $month2_tot + $row_sql1["month2"];
                    $month3_tot = $month3_tot + $row_sql1["month3"];

                    $i = $i + 1;
                }
            }
            echo "<tr>
			<td colspan='3'>Total</td>
			
		
			<td align=\"right\"><b>" . number_format($month1_tot, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month2_tot, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month3_tot, 0, ".", ",") . "</b></td>	
			</tr>";
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

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";
            echo "<center>Monthly Sales Summery  ";
            echo $rtxtrep . "</br>";
            echo $rtxtbrand . "</br>";
            echo $heading;
            echo "<center><table border=1><tr>
		<th>Code</th>
		<th>Cat</th>
		<th>Customer Name</th>
		<th>Brand</th>
		<th>" . $rtxtm1 . "</th>
		<th>" . $rtxtm2 . "</th>
		<th>" . $rtxtm3 . "</th>
		</tr>";
            //echo $sql;
            $month1 = 0;
            $month2 = 0;
            $month3 = 0;
            $limit = 0;


            $dmonth1 = date("m", strtotime($_GET["month1"]));
            $dmonth2 = date("m", strtotime($_GET["month2"]));
            $dmonth3 = date("m", strtotime($_GET["month3"]));

            $dmonth1_y = date("Y", strtotime($_GET["month1"]));
            $dmonth2_y = date("Y", strtotime($_GET["month2"]));
            $dmonth3_y = date("Y", strtotime($_GET["month3"]));

            if ($_GET["radio"] == "op_traget") {
                $sql_sql = "SELECT cus_code,cus_name,limit1 from monsales where (month1<>0 or month2<>0 or month3<>0) and user_id='" . $_SESSION["CURRENT_USER"] . "' group by cus_code,cus_name ,limit1";
            } else {
                $sql_sql = "SELECT cus_code,cus_name,limit1 from monsales where user_id='" . $_SESSION["CURRENT_USER"] . "'  group by cus_code,cus_name,limit1";
            }

            $result_sql = mysqli_query($GLOBALS['dbinv'], $sql_sql);
            while ($row_sql = mysqli_fetch_array($result_sql)) {

                $mok = "ok";
                if ($_GET["radio"] == "op_traget") {

                    if ($_GET["txt_amou"] > 0) {

                        $sql_sql1 = "SELECT sum(month1+month2+month3) as month1 from monsales where cus_code ='" . $row_sql["cus_code"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'";
                        $result_sql1 = mysqli_query($GLOBALS['dbinv'], $sql_sql1);
                        $row_sql1 = mysqli_fetch_array($result_sql1);

                        if ($row_sql1["month1"] < $_GET["txt_amou"]) {
                            $mok = "no";
                        }
                    }
                }
                if ($mok == "ok") {


                    echo "<tr>
				<td>" . $row_sql["cus_code"] . "</td>
				<td></td>
				<td  colspan='5'>" . $row_sql["cus_name"] . "</td>
				 
				</tr>";



                    $sql_sql1 = "SELECT brand,sum(month1)as month1,sum(month2) as month2,sum(month3) as month3 from monsales where cus_code ='" . $row_sql["cus_code"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'  group by brand ";
                    $result_sql1 = mysqli_query($GLOBALS['dbinv'], $sql_sql1);
                    $month1 = 0;
                    $month2 = 0;
                    $month3 = 0;
                    while ($row_sql1 = mysqli_fetch_array($result_sql1)) {




                        $oth1 = 0;
                        $oth2 = 0;
                        $oth3 = 0;

                        if ($_GET["cmbrep"] != "All") {

                            $sql_oothinv = "select sum(grand_tot/(1 +gst/100)) as gtot,brand,c_code,month(sdate) as month ,year(sdate) as year from s_salma where ACCNAME <> 'NON STOCK'   and CANCELL='0' ";

                            $sql_oothinv .= " and sal_ex <> '" . $_GET['cmbrep'] . "'";
                            $sql_oothinv .= " and brand= '" . $row_sql1['brand'] . "'";
                            $sql_oothinv .= " and c_code= '" . trim($row_sql["cus_code"]) . "' and TOTPAY1='1'";

                            //$month1 = substr($_GET["month1"], 5 , 2);  // date("m", strtotime($_GET["month1"]));

                            $sql_oothinv .= " and (( month(sdate) = '" . $dmonth1 . "'  and year(sdate) = '" . $dmonth1_y . "')";
                            $sql_oothinv .= " or ( month(sdate) = '" . $dmonth2 . "'  and year(sdate) = '" . $dmonth2_y . "')";
                            $sql_oothinv .= " or ( month(sdate) = '" . $dmonth3 . "'  and year(sdate) = '" . $dmonth3_y . "'))";
                            $sql_oothinv .= "  group by brand,c_code,year(sdate), month(sdate) ";

                            if (trim($row_sql["cus_code"]) == "A102" and $row_sql1['brand'] == "PRESA") {
                                //echo $sql_oothinv; 
                            }


                            $result_inv = mysqli_query($GLOBALS['dbinv'], $sql_oothinv);
                            while ($row_invoth = mysqli_fetch_array($result_inv)) {

                                if ($dmonth1 == $row_invoth["month"] and $dmonth1_y == $row_invoth["year"]) {
                                    $oth1 = ($row_invoth["gtot"]);
                                }
                                if ($dmonth2 == $row_invoth["month"] and $dmonth2_y == $row_invoth["year"]) {
                                    $oth2 = ($row_invoth["gtot"]);
                                }
                                if ($dmonth3 == $row_invoth["month"] and $dmonth3_y == $row_invoth["year"]) {
                                    $oth3 = ($row_invoth["gtot"]);
                                }
                            }


                            $sql_oothgrn = "select sum(amount/(1 +vatrate/100)) as gtot,CUSCODE,brand,month(sdate) as month ,year(sdate) as year from c_bal where  trn_type<>'INC'and trn_type<>'REC' and trn_type<>'PAY' and trn_type<>'ARN'  and flag1 <> '1'";
                            $sql_oothgrn .= " and SAL_EX <> '" . $_GET['cmbrep'] . "'";
                            $sql_oothgrn .= " and CUSCODE ='" . trim($row_sql["cus_code"]) . "'";

                            if (!isset($_GET["chkdef"])) {
                                $sql_oothgrn .= " and trn_type <> 'DGRN'";
                            }

                            $sql_oothgrn .= " and brand= '" . $row_sql1['brand'] . "'";
                            $result_grn = mysqli_query($GLOBALS['dbinv'], $sql_oothgrn);
                            while ($row_grnoth = mysqli_fetch_array($result_grn)) {

                                if ($dmonth1 == $row_grnoth["month"] and $dmonth1_y == $row_grnoth["year"]) {
                                    $oth1 = ($row_grnoth["gtot"]) * -1;
                                }
                                if ($dmonth2 == $row_grnoth["month"] and $dmonth2_y == $row_grnoth["year"]) {
                                    $oth2 = ($row_grnoth["gtot"]) * -1;
                                }
                                if ($dmonth3 == $row_grnoth["month"] and $dmonth3_y == $row_grnoth["year"]) {
                                    $oth3 = ($row_grnoth["gtot"]) * -1;
                                }
                            }
                        }


                        echo "<tr>
				<td  colspan='3'></td>
				 
				<td>" . $row_sql1["brand"] . "</td>
				<td align=\"right\">" . number_format($row_sql1["month1"] + $oth1, 0, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month2"] + $oth2, 0, ".", ",") . "</td>
				<td align=\"right\">" . number_format($row_sql1["month3"] + $oth3, 0, ".", ",") . "</td>
				</tr>";
                        $month1 = $month1 + $row_sql1["month1"] + $oth1;
                        $month2 = $month2 + $row_sql1["month2"] + $oth2;
                        $month3 = $month3 + $row_sql1["month3"] + $oth3;
                        $limit = $limit + $row_sql["limit1"];
                        $month1_tot = $month1_tot + $row_sql1["month1"] + $oth1;
                        $month2_tot = $month2_tot + $row_sql1["month2"] + $oth2;
                        $month3_tot = $month3_tot + $row_sql1["month3"] + $oth3;
                    }

                    echo "<tr>
			<td colspan='4'></td>
			 
			<td align=\"right\"><b>" . number_format($month1, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month2, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month3, 0, ".", ",") . "</b></td>
			</tr>";
                }
            }
            echo "<tr>
			<td  colspan='4' >Total</td>
			 
			<td align=\"right\"><b>" . number_format($month1_tot, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month2_tot, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month3_tot, 0, ".", ",") . "</b></td>
			
			</tr>";

            echo "<tr>
			<td  colspan='4' >% From Credit Limit </td>
			 
			<td align=\"right\"><b>" . number_format($month1_tot / $limit * 100, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month2_tot / $limit * 100, 0, ".", ",") . "</b></td>
			<td align=\"right\"><b>" . number_format($month3_tot / $limit * 100, 0, ".", ",") . "</b></td>
			
			</tr>";
        }

        //custom loop
        //cus list
        //function end
        ?>
    </body>
</html>

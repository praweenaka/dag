<?php
session_start();
if (!isset($_SESSION["UserName"])) {
    echo "Invalid Login";
    exit();
}
date_default_timezone_set('Asia/Colombo');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Current Status</title>
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

        .bg {
            color: red;
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
    <script language="javascript" type="text/javascript">
        <!--
            /****************************************************
             Author: Eric King
             Url: http://redrival.com/eak/index.shtml
             This script is free to use as long as this info is left in
             Featured on Dynamic Drive script library (http://www.dynamicdrive.com)
             ****************************************************/
             var win = null;
             function NewWindow(mypage, myname, w, h, scroll, pos) {
                if (pos == "random") {
                    LeftPosition = (screen.width) ? Math.floor(Math.random() * (screen.width - w)) : 100;
                    TopPosition = (screen.height) ? Math.floor(Math.random() * ((screen.height - h) - 75)) : 100;
                }
                if (pos == "center") {
                    LeftPosition = (screen.width) ? (screen.width - w) / 2 : 100;
                    TopPosition = (screen.height) ? (screen.height - h) / 2 : 100;
                } else if ((pos != "center" && pos != "random") || pos == null) {
                    LeftPosition = 0;
                    TopPosition = 20
                }
                settings = 'width=' + w + ',height=' + h + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=' + scroll + ',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
                win = window.open(mypage, myname, settings);
            }
            // -->
        </script>


    </head>

    <body>
        <!-- Progress bar holder -->


        <?php
        session_start();

        if (isset($_SESSION['CURRENT_USER'])) {

            if ($_GET["radio"] == "optout") {
                htmlview();
            }

            if ($_GET["radio"] == "optpen") {
                printut();
            }
        }

        function htmlview() {

            require_once("connectioni.php");



            $totinv = 0;
            $totret = 0;
            $totpd = 0;


            $TotCrLmt = 0;
            $cat = 0;
            echo "<center>";
            if (($_GET["cmbrep"] == "All") and ( $_GET["cmbbrand1"] == "All")) {
                $crLmt = "select * from br_trn where cus_code='" . trim($_GET["cuscode"]) . "'";
            }

            if (($_GET["cmbrep"] == "All") and ( $_GET["cmbbrand1"] != "All")) {
                $crLmt = "select * from br_trn where brand ='" . $_GET["cmbbrand1"] . "' and  cus_code='" . trim($_GET["cuscode"]) . "'";
            }

            if (($_GET["cmbrep"] != "All") and ( $_GET["cmbbrand1"] == "All")) {
                $crLmt = "select * from br_trn where Rep='" . trim($_GET["cmbrep"]) . "' and  cus_code='" . trim($_GET["cuscode"]) . "'";
            }

            if (($_GET["cmbrep"] != "All") and ( $_GET["cmbbrand1"] != "All")) {
                $crLmt = "select *  from br_trn where  Rep='" . trim($_GET["cmbrep"]) . "' and  brand ='" . $_GET["cmbbrand1"] . "' and  cus_code='" . trim($_GET["cuscode"]) . "'";
            }


            $sql = "select * from vendor where code = '" . trim($_GET["cuscode"]) . "'";
            $result_ven = mysqli_query($GLOBALS['dbinv'], $sql);
            $row_ven = mysqli_fetch_array($result_ven);


            $mcount = 0;
            $result_crLmt = mysqli_query($GLOBALS['dbinv'], $crLmt);
            while ($row_crLmt = mysqli_fetch_array($result_crLmt)) {
                $mcount = $mcount + 1;
                $credit_lim = $row_crLmt["credit_lim"];
                $tmpcat = $row_crLmt["CAT"];

                if (trim($row_crLmt["CAT"]) == "C") {
                    $limit = $limit + $credit_lim;
                }
                if (trim($row_crLmt["CAT"]) == "B") {
                    $limit = $limit + $credit_lim * 2.5;
                }
                if (trim($row_crLmt["CAT"]) == "A") {
                    $limit = $limit + $credit_lim * 2.5;
                }
            }

            if ($mcount == 1) {
                $cat = "C";
                //if (is_null($row_crLmt["CAT"])==false) { $cat = $tmpcat; }
            } else {

                $limit = 0;
                $result_crLmt1 = mysqli_query($GLOBALS['dbinv'], $crLmt);
                while ($row_crLmt1 = mysqli_fetch_array($result_crLmt1)) {

                    if (trim($row_crLmt1["CAT"]) == "C") {
                        $limit = $limit + $row_crLmt1["credit_lim"];
                    }
                    if (trim($row_crLmt1["CAT"]) == "B") {
                        $limit = $limit + $row_crLmt1["credit_lim"] * 2.5;
                    }
                    if (trim($row_crLmt1["CAT"]) == "A") {
                        $limit = $limit + $row_crLmt1["credit_lim"] * 2.5;
                    }

                    $cat = "CC";
                }
            }


            if ($_GET["cmbbrand1"] != "All") {
                $stringhesd = $_GET["cuscode"] . "  " . $_GET["cusname"] . "  Outsanding Statement Rep." . " " . $_GET["cmbrep"] . "   " . $_GET["cmbbrand1"];
            } else {
                $stringhesd = $_GET["cuscode"] . "  " . $_GET["cusname"] . "  Outsanding Statement Rep." . " " . $_GET["cmbrep"];
            }

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $stringhesd . "</center><br>";

            if (($_GET["cmbbrand1"] != "All") and ( $_GET["cmbrep"] != "All")) {
                echo "Credit Limit : " . number_format($limit, 2, ".", ",") . "   Category  : " . $cat . "</br>";
            } else {
                echo "Credit Limit : " . number_format($limit, 2, ".", ",") . "   Category  : " . $cat . "</br>";
            }

            //============================================Invoice==========================================

            $brandSelected = $_GET["brand"];
            $phrase = "";

            if ($brandSelected != "All") {
                $phrase = "Brand = '$brandSelected' and";
            }

            echo "<b>Outstanding Invoice for $brandSelected Brand/s</b>";

            echo "<center><table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td><b>Invoice no</b></td>";
            echo "<td><b>Date</b></td>";
            echo "<td><b>Del.Date</b></td>";
            echo "<td><b>Amount </b></td>";
            echo "<td><b>Paid</b></td>";
            echo "<td><b>Balance</b></td>";
            echo "<td><b>Days</b></td>";
            echo "<td><b>Del.Days</b></td><th>Due Date</th>";

            echo "</tr>";

            if (($_GET["cmbbrand1"] == "All") and ( $_GET["cmbrep"] == "All")) {
                $strsql = "Select * from s_salma where $phrase C_CODE='" . $_GET["cuscode"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 order by SDATE ";
            }

            if (($_GET["cmbbrand1"] == "All") and ( $_GET["cmbrep"] != "All")) {
                $strsql = "Select * from s_salma where $phrase C_CODE='" . $_GET["cuscode"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE ";
            }

            if (($_GET["cmbbrand1"] != "All") and ( $_GET["cmbrep"] == "All")) {
                $strsql = "Select * from view_s_salma where $phrase class='" . trim($_GET["cmbbrand1"]) . "' and  C_CODE='" . $_GET["cuscode"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 order by SDATE ";
            }

            if (($_GET["cmbbrand1"] != "All") and ( $_GET["cmbrep"] != "All")) {
                $strsql = "Select * from view_s_salma where $phrase class='" . trim($_GET["cmbbrand1"]) . "' and  C_CODE='" . $_GET["cuscode"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE ";
            }

            $strsql = "Select * from view_s_salma where  C_CODE='" . $_GET["cuscode"] . "'  and CANCELL='0' and GRAND_TOT-TOTPAY>1 ";

            if ($_GET["brand"] != "All") {
                $strsql .= " and brand = '" . $_GET["brand"] . "'";
            }
            if ($_GET["cmbbrand1"] != "All") {
                $strsql .= " and class='" . trim($_GET["cmbbrand1"]) . "'";
            }
            $date = date('Y-m-d');
            //echo $date;
            $date = strtotime(date("Y-m-d", strtotime($date)) . " -91 days");
            $caldate = date("Y-m-d", $date);
            if ($_GET['cmbrep'] != "All") {
                if ($_SESSION["CURRENT_REP"] != "") {
                    $strsql .= " and (SAL_EX='" . trim($_SESSION["CURRENT_REP"]) . "'  or  sdate <='" . $caldate . "')  ";
                } else {
                    $strsql .= " and (SAL_EX='" . trim($_GET["cmbrep"]) . "')  ";
                }
            }


            //echo $strsql;

            $strsql .= " order by c_code1,sdate";

            $ccode = "";
            $ccode1 = "";

            $result = mysqli_query($GLOBALS['dbinv'], $strsql);
            while ($row = mysqli_fetch_array($result)) {

                if ((strtoupper($row["c_code1"]) != strtoupper($ccode1)) and ( $ccode1 != "") and ( strtoupper($row["C_CODE"]) == strtoupper($ccode))) {

                    echo "<tr>
                    <th></th>
                    <th colspan=8 align=left><b>" . $row["CUS_NAME"] . "</b></th>
                    </tr>";
                }

                $ccode = $row["C_CODE"];
                $ccode1 = $row["c_code1"];


                if ((trim($row["red"]) == "1") or ( is_null($row["REMARK"]) == false)) {
                    if ((is_null($row["deli_date"]) == false) and ( $row["deli_date"] != "1970-01-01") and ( $row["deli_date"] != "0000-00-00")) {
                        echo "<tr>";
                    } else {
                        echo "<tr class='bg'>";
                    }
                    $strsql123 = "Select * from view_s_salma_s_invo_s_mas where  REF_NO='" . $row["REF_NO"] . "'  and (type='TBR' or type='BIAS TYRES')";
                    $result123 = mysqli_query($GLOBALS['dbinv'], $strsql123);
                    if ($row123 = mysqli_fetch_array($result123)) {
                        echo "<td bgcolor=\"yellow\"><a   onfocus=\"this.blur()\" onclick=\"NewWindow('sales_inv_display.php?refno=" . trim($row["REF_NO"]) . "&amp;trn_type=INV','mywin','900','700','yes','center');return false\" class=\"INV\" href=\"\">" . trim($row["REF_NO"]) . "</a></td>";
                    } else {
                        echo "<td  > <a   onfocus=\"this.blur()\" onclick=\"NewWindow('sales_inv_display.php?refno=" . trim($row["REF_NO"]) . "&amp;trn_type=INV','mywin','900','700','yes','center');return false\" class=\"INV\" href=\"\">" . trim($row["REF_NO"]) . "</a></td>";
                    }
//                    echo "<td>";
//
//                    echo "<a onfocus=\"this.blur()\" onclick=\"NewWindow('sales_inv_display.php?refno=" . trim($row["REF_NO"]) . "&amp;trn_type=INV','mywin','900','700','yes','center');return false\" class=\"INV\" href=\"\">" . trim($row["REF_NO"]) . "</a>";
//
//                    echo "</td>";
                    echo "<td>" . $row["SDATE"] . "</td>";

                    if ((is_null($row["deli_date"]) == false) and ( $row["deli_date"] != "1970-01-01") and ( $row["deli_date"] != "0000-00-00")) {
                        echo "<td>" . $row["deli_date"] . "</td>";
                    } else {
                        echo "<td>" . $row["SDATE"] . "</td>";
                    }

                    echo "<td align=right > " . number_format($row["GRAND_TOT"], 2, ".", ",") . "</font></td>";
                    echo "<td align=right >" . number_format($row["TOTPAY"], 2, ".", ",") . "</font></td>";
                    echo "<td align=right >" . number_format(($row["GRAND_TOT"] - $row["TOTPAY"]), 2, ".", ",") . "</font></td>";
                    $diff = abs(strtotime(date("Y-m-d")) - strtotime($row["SDATE"]));
                    $days = floor($diff / (60 * 60 * 24));
                    echo "<td align=right >" . $days . "</td>";

                    if ((is_null($row["deli_date"]) == false) and ( $row["deli_date"] != "1970-01-01") and ( $row["deli_date"] != "0000-00-00")) {
                        $diff = abs(strtotime(date("Y-m-d")) - strtotime($row["deli_date"]));
                        $days = floor($diff / (60 * 60 * 24));
                        $sdate = $row['deli_date'];
                        echo "<td align=right > " . $days . "</td>";
                    } else {
                        $diff = abs(strtotime(date("Y-m-d")) - strtotime($row["SDATE"]));
                        $days = floor($diff / (60 * 60 * 24));
                        $sdate = $row['SDATE'];
                        echo "<td align=right > " . $days . "</td>";
                    }
                    if ($row_ven["incdays"] == 90) {
                        if ($row["cre_pe"] > 90) {
                            $per = $row["cre_pe"];
                        } else {
                            if (is_null($row_ven["incdays"]) == false) {
                                $per = $row_ven["incdays"];
                            }
                        }
                    } else {
                        if ($row["cre_pe"] != 65) {
                            $per = $row["cre_pe"];
                        } else {
                            $per = 75;
                        }
                    }


                    $dtdue = date('Y-m-d', strtotime($sdate . " +" . $per . " days"));
                    echo "<td>" . $dtdue . "</td>";
                    $totinv = $totinv + ($row["GRAND_TOT"] - $row["TOTPAY"]);
                } else {

                    if ((is_null($row["deli_date"]) == false) and ( $row["deli_date"] != "1970-01-01") and ( $row["deli_date"] != "0000-00-00")) {
                        echo "<tr>";
                    } else {
                        echo "<tr class='bg'>";
                    }
                    echo "<td>";

                    echo "<a onfocus=\"this.blur()\" onclick=\"NewWindow('sales_inv_display.php?refno=" . trim($row["REF_NO"]) . "&amp;trn_type=INV','mywin','900','700','yes','center');return false\" class=\"INV\" href=\"\">" . trim($row["REF_NO"]) . "</a>";

                    echo "</td>";


                    echo "<td>" . $row["SDATE"] . "</td>";

                    if (is_null($row["deli_date"]) == false) {
                        echo "<td>" . $row["deli_date"] . "</td>";
                    } else {
                        echo "<td>" . $row["SDATE"] . "</td>";
                    }
                    echo "<td align=right > " . number_format($row["GRAND_TOT"], 2, ".", ",") . "</td>";
                    echo "<td align=right >" . number_format($row["TOTPAY"], 2, ".", ",") . "</td>";
                    echo "<td align=right >" . number_format($row["GRAND_TOT"] - $row["TOTPAY"], 2, ".", ",") . "</td>";



                    if ((is_null($row["deli_date"]) == false) and ( $row["deli_date"] != "1970-01-01") and ( $row["deli_date"] != "0000-00-00")) {
                        $diff = abs(strtotime(date("Y-m-d")) - strtotime($row["deli_date"]));
                        $days = floor($diff / (60 * 60 * 24));
                        echo "<td align=right >" . $days . "</td>";
                        echo "<td align=right >" . $days . "</font></td>";
                        $sdate = $row['deli_date'];
                    } else {
                        $diff = abs(strtotime(date("Y-m-d")) - strtotime($row["SDATE"]));
                        $days = floor($diff / (60 * 60 * 24));
                        $sdate = $row['SDATE'];
                        echo "<td align=right >" . $days . "</font></td>";
                    }

                    if ($row_ven["incdays"] == 90) {
                        if ($row["cre_pe"] > 90) {
                            $per = $row["cre_pe"];
                        } else {
                            if (is_null($row_ven["incdays"]) == false) {
                                $per = $row_ven["incdays"];
                            }
                        }
                    } else {
                        if ($row["cre_pe"] != 65) {
                            $per = $row["cre_pe"];
                        } else {
                            $per = 75;
                        }
                    }

                    $dtdue = date('Y-m-d', strtotime($sdate . " +" . $per . " days"));
                    echo "<td>" . $dtdue . "</td>";

                    $totinv = $totinv + ($row["GRAND_TOT"] - $row["TOTPAY"]);
                }
            }


            echo "</table>";
            echo "<b>Total Outstanding Invoice Balance=" . number_format($totinv, 2, ".", ",") . "</b></br></br>";




            //============================================Return cheqe==========================================
            echo "<b>Outstanding Return Cheque<b>";

            echo "<table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td><b>Cheque no</b></td>";
            echo "<td><b>Date</b></td>";
            echo "<td><b>Amount </b></td>";
            echo "<td><b>Paid</b></td>";
            echo "<td><b>Balance</b></td>";
            echo "<td><b>Days</b></td>";
            echo "<td><b>Rep</b></td>";
            echo "</tr>";



            if ($_GET["cmbrep"] == "All") {
                $strsql = "Select * from s_cheq where CR_C_CODE='" . $_GET["cuscode"] . "'  and CR_CHEVAL-PAID>1 and CR_FLAG='0'  ";
            }

            if ($_GET["cmbrep"] != "All") {
                $strsql = "Select * from s_cheq where CR_C_CODE='" . $_GET["cuscode"] . "'  and CR_CHEVAL-PAID>1 and S_REF='" . trim($_GET["cmbrep"]) . "' and CR_FLAG='0'";
            }


            $result = mysqli_query($GLOBALS['dbinv'], $strsql);
            while ($row = mysqli_fetch_array($result)) {

                echo "<tr><td>" . trim($row["CR_CHNO"]) . "</font></td>";
                echo "<td>" . $row["CR_CHDATE"] . "</font></td>";
                echo "<td align=right>" . number_format($row["CR_CHEVAL"], 2, ".", ",") . "</font></td>";
                echo "<td align=right>" . number_format($row["PAID"], 2, ".", ",") . "</td>";
                echo "<td align=right>" . number_format($row["CR_CHEVAL"] - $row["PAID"], 2, ".", ",") . "</td>";

                $diff = abs(strtotime(date("Y-m-d")) - strtotime($row["CR_CHDATE"]));
                $days = floor($diff / (60 * 60 * 24));

                echo "<td>" . $days . "</font></td>";
                echo "<td>" . trim($row["S_REF"]) . "</font></td>";
                $totret = $totret + ($row["CR_CHEVAL"] - $row["PAID"]);
            }

            echo "</table>";
            echo "Total Outstanding Return Cheque Balance=" . number_format($totret, 2, ".", ",") . "</br></br>";




            //============================================PD cheqe==========================================

            echo "<b>Pending Cheque<b>";

            echo "<table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td><b>Rep</b></td><td><b>Cheque no</b></td>";
            echo "<td><b>Date</b></td>";
            echo "<td><b>Amount </b></td>";
            echo "<td><b>bank</b></td>";
            echo "<td><b>Days</b></td>";
            echo "<td><b>From Dell. Days</b></td>";
            echo "</tr>";

            if ($_GET["cmbbrand1"] != "All") {
                if ($_GET["cmbrep"] == "All") {
                    $sql_rst4 = "SELECT * FROM s_invcheq WHERE che_date>'" . date("Y-m-d") . "' AND CUS_CODE='" . trim($_GET["cuscode"]) . "' and trn_type='REC' order by che_date ";
                }
                if ($_GET["cmbrep"] != "All") {
                    $sql_rst4 = "SELECT * FROM s_invcheq WHERE che_date>'" . date("Y-m-d") . "' AND CUS_CODE='" . trim($_GET["cuscode"]) . "' and trn_type='REC' and sal_ex='" . trim($_GET["cmbrep"]) . "' ";
                }


                $result_rst4 = mysqli_query($GLOBALS['dbinv'], $sql_rst4); 
                while ($row_rst4 = mysqli_fetch_array($result_rst4)) {
                    $OutpDAMT = 0;
                    $sql_st = "select * from s_sttr where ST_REFNO='" . trim($row_rst4["refno"]) . "' and ST_CHNO ='" . trim($row_rst4["cheque_no"]) . "' ";
                    $result_st = mysqli_query($GLOBALS['dbinv'], $sql_st);
                    while ($row_st = mysqli_fetch_array($result_st)) {
                        $sql_tmp = "select class from view_s_salma where REF_NO='" . trim($row_st["ST_INVONO"]) . "'  order by SDATE";
                        $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
                        if ($row_tmp = mysqli_fetch_array($result_tmp)) {
                            if (trim($row_tmp["class"]) == trim($_GET["cmbbrand1"])) {
                                $OutpDAMT = $OutpDAMT + $row_st["ST_PAID"];
                            }
                        }
                    }


                    if ($OutpDAMT > 0) {

                        $mtype = "&nbsp;&nbsp;&nbsp;";
                        if (is_null($row_rst4["trn_type"]) == false) {
                            $mtype = trim($row_rst4["trn_type"]);
                        }
                        if ($mtype == "RET") {
                            echo "<tr><td>" . $row_rst4["sal_ex"] . "</td><td> <font face='Arial' color='Red'> " . trim($row_rst4["cheque_no"]) . " - " . $mtype . "</font></td>";
                            echo "<td> <font face='Arial' color='Red'>" . $row_rst4["che_date"] . "</font></td>";
                            echo "<td align=right> <font face='Arial' color='Red'>" . number_format($OutpDAMT, 2, ".", ",") . "</td>";
                            if (is_null($row_rst4["bank"]) == false) {
                                echo "<td><font face='Arial' color='Red'>" . trim($row_rst4["bank"]) . "</font></td>";
                            } else {
                                echo "<td></td>";
                            }

                            $date1 = date("Y-m-d");
                            $date2 = $row_rst4["che_date"];
                            $diff = abs(strtotime($date2) - strtotime($date1));
                            $days = floor($diff / (60 * 60 * 24));

                            echo "<td><font face='Arial' color='Red'>" . $days . "</font></td>";
                        } else {
                            echo "<tr><td>" . $row_rst4["sal_ex"] . "</td><td><font face='Arial'  > " . trim($row_rst4["cheque_no"]) . " - " . $mtype . "</font></td>";
                            echo "<td><font face='Arial'>" . $row_rst4["che_date"] . "</font></td>";
                            echo "<td align=right>" . number_format($OutpDAMT, 2, ".", ",") . "</td>";
                            if (is_null($row_rst4["bank"]) == false) {
                                echo "<td><font face='Arial'>" . trim($row_rst4["bank"]) . "</font></td>";
                            } else {

                                print "<td></td>";
                            }
                            $date1 = date("Y-m-d");
                            $date2 = $row_rst4["che_date"];
                            $diff = abs(strtotime($date2) - strtotime($date1));
                            $days = floor($diff / (60 * 60 * 24));
                            echo "<td><font face='Arial'>" . $days . "</font></td>";
                        }

                        $totpd = $totpd + $OutpDAMT;
                    }
                }

                echo "</table>";
                echo "Cheque For Pending Cheques=" + number_format($totpd, 2, ".", ",") . "</br></br>";
                //============================================PD cheqe==========================================
                echo "<b>PD For Returns</b>";

                echo "<table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
                echo "<tr align=center bgcolor=#00aaaa>";
                echo "<td><b>Cheque NNo</b></td>";
                echo "<td><b>Date</b></td>";
                echo "<td><b>Amount </b></td>";
                echo "<td><b>bank</b></td>";
                echo "<td><b>Days</b></td>";
                echo "</tr>";


                if ($_GET["cmbrep"] == "All") {
                    $sql_rst4 = "SELECT * FROM s_invcheq WHERE trn_type='RET' and che_date>'" . date("Y-m-d") . "' AND cus_code='" . trim($_GET["cuscode"]) . "' and trn_type='RET'  ";
                }
                if ($_GET["cmbrep"] != "All") {
                    $sql_rst4 = "SELECT * FROM s_invcheq WHERE trn_type='RET' and che_date>'" . date("Y-m-d") . "' AND cus_code='" . trim($_GET["cuscode"]) . "' and trn_type='RET' and sal_ex='" . trim($_GET["cmbrep"]) . "' ";
                }
                $result_rst4 = mysqli_query($GLOBALS['dbinv'], $sql_rst4);
                while ($row_rst4 = mysqli_fetch_array($result_rst4)) {
                    $OutpDAMT = 0;
                    $sql_st = "select * from ch_sttr where cus_code='" . $row_rst4["cus_code"] . "' and ST_REFNO='" . trim($row_rst4["REFNO"]) . "' and ST_CHNO='" . trim($row_rst4["cheque_no"]) . "'";
                    //xx = st.RecordCount
                    $result_st = mysqli_query($GLOBALS['dbinv'], $sql_st);
                    while ($row_st = mysqli_fetch_array($result_st)) {
                        $sql_tmpRet = "select * from ret_chq_history where Ref_no='" . trim($row_st["ST_INVONO"]) . "' ";
                        //xx = tmpRet.RecordCount
                        $result_tmpRet = mysqli_query($GLOBALS['dbinv'], $sql_tmpRet);
                        while ($row_tmpRet = mysqli_fetch_array($result_tmpRet)) {
                            $sql_tmp = "select class from view_s_salma where REF_NO='" . trim($row_tmpRet["Inv_no"]) . "' ";
                            //yy = tmp.RecordCount
                            $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
                            if ($row_tmp = mysqli_fetch_array($result_tmp)) {
                                if (trim($row_tmp["class"]) == trim($_GET["cmbbrand1"])) {
                                    $OutpDAMT = $row_rst4["che_amount"];
                                }
                            }
                        }
                    }


                    if ($OutpDAMT > 0) {
                        $mtype = "&nbsp;&nbsp;&nbsp;";
                        if (is_null($row_rst4["trn_type"]) == false) {
                            $mtype = trim($row_rst4["trn_type"]);
                        }

                        if ($mtype == "RET") {
                            echo "<tr><td><font face='Arial' color='Red'> " + trim($row_rst4["cheque_no"]) . "-" . $mtype . "</td>";

                            echo "<td><font face='Arial' color='Red'> " . $row_rst4["che_date"] . "</td>";
                            echo "<td align=right><font face='Arial' color='Red'>" . number_format($OutpDAMT, 2, ".", ",") . "</td>";
                            if (is_null($row_rst4["bank"]) == false) {
                                echo "<td><font face='Arial' color='Red'>" . trim($row_rst4["bank"]) . "</td>";
                            } else {
                                echo "<td></td><font face='Arial' color='Red'>";
                            }

                            $date1 = date("Y-m-d");
                            $date2 = $row_rst4["che_date"];
                            $diff = abs(strtotime($date2) - strtotime($date1));
                            $days = floor($diff / (60 * 60 * 24));

                            echo "<td><font face='Arial'color='Red'>" . $days . "</td>";
                        } else {
                            echo "<tr><td>  " + trim($row_rst4["cheque_no"]) . "-" . $mtype . "</td>";

                            echo "<td>  " . $row_rst4["che_date"] . "</td>";
                            echo "<td align=right> " . number_format($OutpDAMT, 2, ".", ",") . "</td>";
                            if (is_null($row_rst4["bank"]) == false) {
                                echo "<td> " . trim($row_rst4["bank"]) . "</td>";
                            } else {
                                echo "<td></td> ";
                            }
                            $date1 = date("Y-m-d");
                            $date2 = $row_rst4["che_date"];
                            $diff = abs(strtotime($date2) - strtotime($date1));
                            $days = floor($diff / (60 * 60 * 24));

                            echo "<td> " . $days . "</td>";
                        }

                        $totpd = $totpd + $OutpDAMT;
                    }
                }
            }
            if ($_GET["cmbbrand1"] == "All") {

                if ($_GET["cmbrep"] == "All") {
                    $strsql = "Select * from s_invcheq where cus_code='" . $_GET["cuscode"] . "'  and che_date>'" . date("Y-m-d") . "' order by che_date ";
                    //echo $strsql;
                }
                if ($_GET["cmbrep"] != "All") {
                    $strsql = "Select * from s_invcheq where cus_code='" . $_GET["cuscode"] . "'  and che_date>'" . date("Y-m-d") . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' order by che_date";
                }

                $result_rst2 = mysqli_query($GLOBALS['dbinv'], $strsql);
                while ($row_rst2 = mysqli_fetch_array($result_rst2)) {
                    $mtype = "&nbsp;&nbsp;&nbsp;";
                    if (is_null($row_rst2["trn_type"]) == false) {
                        $mtype = trim($row_rst2["trn_type"]);
                    }

                    if ($mtype == "RET") {
                        echo "<tr><td>" . $row_rst2["sal_ex"] . "</td><td><font face='Arial' color='Red'>" . trim($row_rst2["cheque_no"]) . "-" . $mtype . "</font></td>";
                        echo "<td><font face='Arial' color='Red'>" . $row_rst2["che_date"] . "</font></td>";
                        echo "<td align=right><color='Red' >" . number_format($row_rst2["che_amount"], 2, ".", ",") . "</font></td>";
                        if (is_null($row_rst2["bank"]) == false) {
                            echo "<td> <font face='Arial' color='Red'> " . trim($row_rst2["bank"]) . "</td>";
                        } else {
                            echo "<td></td>";
                        }
                        $date1 = date("Y-m-d");
                        $date2 = $row_rst2["che_date"];
                        $diff = abs(strtotime($date2) - strtotime($date1));
                        $days = floor($diff / (60 * 60 * 24));
                        echo "<td><font face='Arial' color='Red'>" . $days . "</font></td>";

                        $daysin = "";
                        $sett = "select * from ch_sttr where ST_REFNO = '" . $row_rst2["refno"] . "'";
                        $result_PrInv1 = mysqli_query($GLOBALS['dbinv'], $sett);
                        while ($row_PrInv1 = mysqli_fetch_array($result_PrInv1)) {

                            $inv_his = "select Inv_date,Inv_no,inv_Amt,deli_date from view_ret_chq_history where ref_no = '" . $row_PrInv1["ST_INVONO"] . "' group by Inv_date,Inv_no,inv_Amt,deli_date order by Inv_date,deli_date";

                            $result_his = mysqli_query($GLOBALS['dbinv'], $inv_his);
                            if ($row_his = mysqli_fetch_array($result_his)) {

                                $inv_date = $row_his["Inv_date"];
                                if ((!is_null($row_his["deli_date"])) or ( $row_his["deli_date"] != "0000-00-00")) {
                                    $inv_date = $row_his["deli_date"];
                                }

                                if ($row_PrInv1["ST_FLAG"] == "UT") {
                                    $diff = abs(strtotime($inv_date) - strtotime($row_PrInv1["ST_DATE"]));
                                    $daysin = floor($diff / (60 * 60 * 24));
                                } else {
                                    $diff = abs(strtotime($inv_date) - strtotime($row_PrInv1["ST_INDATE"]));
                                    $daysin = floor($diff / (60 * 60 * 24));
                                }
                                // 
                            }
                        }
                        echo "<td align=right><font face='Arial' color='Red'>" . $daysin . "</font></td>";
                    } else {
                        echo "<tr><td>" . $row_rst2["sal_ex"] . "</td><td><font face='Arial'>" . trim($row_rst2["cheque_no"]) . "-" . $mtype . "</font></td>";
                        echo "<td><font face='Arial'>" . $row_rst2["che_date"] . "</font></td>";
                        echo "<td align=right>" . number_format($row_rst2["che_amount"], 2, ".", ",") . "</font></td>";
                        if (is_null($row_rst2["bank"]) == false) {
                            echo "<td>" . trim($row_rst2["bank"]) . "</td>";
                        } else {
                            echo "<td></td>";
                        }
                        $date1 = date("Y-m-d");
                        $date2 = $row_rst2["che_date"];
                        $diff = abs(strtotime($date2) - strtotime($date1));
                        $days = floor($diff / (60 * 60 * 24));

                        echo "<td align=right><font face='Arial'>" . $days . "</font></td>";

                        $sql_st = "SELECT * FROM view_salma_sttr WHERE ST_REFNO ='" . trim($row_rst2["refno"]) . "' and ST_CHNO ='" . trim($row_rst2["cheque_no"]) . "' order by sdate,Deli_date";

                        $result_st = mysqli_query($GLOBALS['dbinv'], $sql_st);
                        if ($row_st = mysqli_fetch_array($result_st)) {
                            if (is_null($row_st['Deli_date'])) {
                                $date2 = $row_st['SDATE'];
                            } else {
                                $date2 = $row_st['Deli_date'];
                            }

                            $date1 = $row_rst2["che_date"];
                            $diff = abs(strtotime($date2) - strtotime($date1));
                            $days = floor($diff / (60 * 60 * 24));

                            echo "<td align=right><font face='Arial'>" . $days . "</font></td>";
                        }
                    }
                    $totpd = $totpd + $row_rst2["che_amount"];
                }
            }

            echo "</table>";

            echo "Total Pending  Cheque Amount=" . number_format($totpd, 2, ".", ",") . "</br></br>";
            echo "Total Outsanding Amount=" . number_format($totinv + $totpd + $totret, 2, ".", ",") . "</br></br>";


            echo "<b>Cheque in Transfer<b>";

            echo "<table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=orange>";
            echo "<td><b>Rep</b></td><td><b>Cheque no</b></td>";
            echo "<td><b>Date</b></td>";
            echo "<td><b>Amount </b></td>";
            echo "<td><b>bank</b></td>";
            echo "<td><b>Days</b></td>";
            echo "<td><b>From Dell. Days</b></td>";
            echo "</tr>";




            $adddate = date('Y-m-d', strtotime("-5 days"));

            if ($_GET["cmbbrand1"] == "All") {

                if ($_GET["cmbrep"] == "All") {
                    $strsql = "Select * from s_invcheq where cus_code='" . $_GET["cuscode"] . "'  and che_date>='" . $adddate . "' and che_date<='" . date("Y-m-d") . "' order by che_date ";
                    //echo $strsql;
                }
                if ($_GET["cmbrep"] != "All") {
                    $strsql = "Select * from s_invcheq where cus_code='" . $_GET["cuscode"] . "' and che_date>='" . $adddate . "' and che_date<='" . date("Y-m-d") . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' order by che_date";
                }

                $result_rst2 = mysqli_query($GLOBALS['dbinv'], $strsql);
                while ($row_rst2 = mysqli_fetch_array($result_rst2)) {
                    $mtype = "&nbsp;&nbsp;&nbsp;";
                    if (is_null($row_rst2["trn_type"]) == false) {
                        $mtype = trim($row_rst2["trn_type"]);
                    }

                    $inv_his = "select * from s_cheq where cr_chno='" . $row_rst2['cheque_no'] . "' and cr_chdate='" . $row_rst2["che_date"] . "'";
                    $result_his1 = mysqli_query($GLOBALS['dbinv'], $inv_his); 
                    if (!$row_his1 = mysqli_fetch_array($result_his1)) {

                        if ($mtype == "RET") {
                            echo "<tr><td>" . $row_rst2["sal_ex"] . "</td><td><font face='Arial' color='Red'>" . trim($row_rst2["cheque_no"]) . "-" . $mtype . "</font></td>";
                            echo "<td><font face='Arial' color='Red'>" . $row_rst2["che_date"] . "</font></td>";
                            echo "<td align=right><color='Red' >" . number_format($row_rst2["che_amount"], 2, ".", ",") . "</font></td>";
                            if (is_null($row_rst2["bank"]) == false) {
                                echo "<td> <font face='Arial' color='Red'> " . trim($row_rst2["bank"]) . "</td>";
                            } else {
                                echo "<td></td>";
                            }
                            $date1 = date("Y-m-d");
                            $date2 = $row_rst2["che_date"];
                            $diff = abs(strtotime($date2) - strtotime($date1));
                            $days = floor($diff / (60 * 60 * 24));
                            echo "<td><font face='Arial' color='Red'>" . $days . "</font></td>";

                            $daysin = "";
                            $sett = "select * from ch_sttr where ST_REFNO = '" . $row_rst2["refno"] . "'";
                            $result_PrInv1 = mysqli_query($GLOBALS['dbinv'], $sett);
                            while ($row_PrInv1 = mysqli_fetch_array($result_PrInv1)) {

                                $inv_his = "select Inv_date,Inv_no,inv_Amt,deli_date from view_ret_chq_history where ref_no = '" . $row_PrInv1["ST_INVONO"] . "' group by Inv_date,Inv_no,inv_Amt,deli_date order by Inv_date,deli_date";

                                $result_his = mysqli_query($GLOBALS['dbinv'], $inv_his);
                                if ($row_his = mysqli_fetch_array($result_his)) {

                                    $inv_date = $row_his["Inv_date"];
                                    if ((!is_null($row_his["deli_date"])) or ( $row_his["deli_date"] != "0000-00-00")) {
                                        $inv_date = $row_his["deli_date"];
                                    }

                                    if ($row_PrInv1["ST_FLAG"] == "UT") {
                                        $diff = abs(strtotime($inv_date) - strtotime($row_PrInv1["ST_DATE"]));
                                        $daysin = floor($diff / (60 * 60 * 24));
                                    } else {
                                        $diff = abs(strtotime($inv_date) - strtotime($row_PrInv1["ST_INDATE"]));
                                        $daysin = floor($diff / (60 * 60 * 24));
                                    }
                                    // 
                                }
                            }
                            echo "<td align=right><font face='Arial' color='Red'>" . $daysin . "</font></td>";
                        } else {
                            echo "<tr><td>" . $row_rst2["sal_ex"] . "</td><td><font face='Arial'>" . trim($row_rst2["cheque_no"]) . "-" . $mtype . "</font></td>";
                            echo "<td><font face='Arial'>" . $row_rst2["che_date"] . "</font></td>";
                            echo "<td align=right>" . number_format($row_rst2["che_amount"], 2, ".", ",") . "</font></td>";
                            if (is_null($row_rst2["bank"]) == false) {
                                echo "<td>" . trim($row_rst2["bank"]) . "</td>";
                            } else {
                                echo "<td></td>";
                            }
                            $date1 = date("Y-m-d");
                            $date2 = $row_rst2["che_date"];
                            $diff = abs(strtotime($date2) - strtotime($date1));
                            $days = floor($diff / (60 * 60 * 24));

                            echo "<td align=right><font face='Arial'>" . $days . "</font></td>";

                            $sql_st = "SELECT * FROM view_salma_sttr WHERE ST_REFNO ='" . trim($row_rst2["refno"]) . "' and ST_CHNO ='" . trim($row_rst2["cheque_no"]) . "' order by sdate,Deli_date";

                            $result_st = mysqli_query($GLOBALS['dbinv'], $sql_st);
                            if ($row_st = mysqli_fetch_array($result_st)) {
                                if (is_null($row_st['Deli_date'])) {
                                    $date2 = $row_st['SDATE'];
                                } else {
                                    $date2 = $row_st['Deli_date'];
                                }

                                $date1 = $row_rst2["che_date"];
                                $diff = abs(strtotime($date2) - strtotime($date1));
                                $days = floor($diff / (60 * 60 * 24));

                                echo "<td align=right><font face='Arial'>" . $days . "</font></td>";
                            }
                        }


                        $totpd1 = $totpd1 + $row_rst2["che_amount"];
                    }
                }
            }

            echo "</table>";
            echo "Total Cheque in Transfer Amount=" . number_format($totpd1, 2, ".", ",") . "</br></br>";



            echo "</body>";
            echo "</html>";
        }

        function view_cash() {

            require_once("connectioni.php");



            $totinv = 0;
            $totret = 0;
            $totpd = 0;


            $TotCrLmt = 0;
            $cat = 0;
            echo "<center>";


            //============================================Invoice==========================================

            if ($_GET["cmbbrand1"] != "All") {
                $stringhesd = $_GET["cuscode"] . "  " . $_GET["cusname"] . "  Outsanding Statement Rep." . " " . $_GET["cmbrep"] . "   " . $_GET["cmbbrand1"];
            } else {
                $stringhesd = $_GET["cuscode"] . "  " . $_GET["cusname"] . "  Outsanding Statement Rep." . " " . $_GET["cmbrep"];
            }

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>" . $stringhesd . "</center><br>";

            echo "<b>Outstanding Invoice For Cash Discount</b><br>";

            echo "<center><table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td><b>Invoice no</b></td>";
            echo "<td><b>Date</b></td>";
            echo "<td><b>Del.Date</b></td>";
            echo "<td><b>Amount</b></td>";
            echo "<td><b>Paid</b></td>";
            echo "<td><b>Balance</b></td>";
            echo "<td><b>Days</b></td>";
            echo "<td><b>Del.Days</b></td>";

            echo "<td><b>Settlement Date</b></td>";
            echo "<td><b>Days from Settlemt</b></td>";

            echo "<td><b>Incen. %</b></td>";
            echo "<td><b>Incen Amt.</b></td>";


            echo "</tr>";

            if (($_GET["cmbbrand1"] == "All") and ( $_GET["cmbrep"] == "All")) {
                $strsql = "Select * from s_salma where   C_CODE='" . $_GET["cuscode"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 and totpay >1 order by SDATE ";
            }

            if (($_GET["cmbbrand1"] == "All") and ( $_GET["cmbrep"] != "All")) {
                $strsql = "Select * from s_salma where   C_CODE='" . $_GET["cuscode"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1  and totpay >1 and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE ";
            }

            if (($_GET["cmbbrand1"] != "All") and ( $_GET["cmbrep"] == "All")) {
                $strsql = "Select * from view_s_salma where  class='" . trim($_GET["cmbbrand1"]) . "'and totpay >1 and  C_CODE='" . $_GET["cuscode"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1  order by SDATE ";
            }

            if (($_GET["cmbbrand1"] != "All") and ( $_GET["cmbrep"] != "All")) {
                $strsql = "Select * from view_s_salma where  class='" . trim($_GET["cmbbrand1"]) . "' and totpay >1  and  C_CODE='" . $_GET["cuscode"] . "' and CANCELL='0' and GRAND_TOT-TOTPAY>1 and SAL_EX='" . trim($_GET["cmbrep"]) . "'  order by SDATE ";
            }

            $incen = 0;
            $result = mysqli_query($GLOBALS['dbinv'], $strsql);
            while ($row = mysqli_fetch_array($result)) {


                if ((is_null($row["deli_date"]) == false) and ( $row["deli_date"] != "1970-01-01") and ( $row["deli_date"] != "0000-00-00")) {
                    echo "<tr>";
                } else {
                    echo "<tr class='bg'>";
                }
                echo "<td>";

                echo "<a onfocus=\"this.blur()\" onclick=\"NewWindow('sales_inv_display.php?refno=" . trim($row["REF_NO"]) . "&amp;trn_type=INV','mywin','900','700','yes','center');return false\" class=\"INV\" href=\"\">" . trim($row["REF_NO"]) . "</a>";

                echo "</td>";
                echo "<td>" . $row["SDATE"] . "</td>";

                if ((is_null($row["deli_date"]) == false) and ( $row["deli_date"] != "1970-01-01") and ( $row["deli_date"] != "0000-00-00")) {
                    echo "<td>" . $row["deli_date"] . "</td>";
                } else {
                    echo "<td>" . $row["SDATE"] . "</td>";
                }

                echo "<td align=right > " . number_format($row["GRAND_TOT"], 2, ".", ",") . "</font></td>";
                echo "<td align=right >" . number_format($row["TOTPAY"], 2, ".", ",") . "</font></td>";
                echo "<td align=right >" . number_format(($row["GRAND_TOT"] - $row["TOTPAY"]), 2, ".", ",") . "</font></td>";
                $diff = abs(strtotime(date("Y-m-d")) - strtotime($row["SDATE"]));
                $days = floor($diff / (60 * 60 * 24));
                echo "<td align=right >" . $days . "</td>";

                if ((is_null($row["deli_date"]) == false) and ( $row["deli_date"] != "1970-01-01") and ( $row["deli_date"] != "0000-00-00")) {
                    $diff = abs(strtotime(date("Y-m-d")) - strtotime($row["deli_date"]));
                    $days = floor($diff / (60 * 60 * 24));
                    $mdate = $row["deli_date"];
                    echo "<td align=right > " . $days . "</td>";
                } else {
                    $diff = abs(strtotime(date("Y-m-d")) - strtotime($row["SDATE"]));
                    $days = floor($diff / (60 * 60 * 24));
                    $mdate = $row["SDATE"];
                    echo "<td align=right > " . $days . "</td>";
                }
                $totinv = $totinv + ($row["GRAND_TOT"] - $row["TOTPAY"]);
                $totgrad = $totgrad + ($row["GRAND_TOT"]);
                $totinvp = $totinvp + ($row["TOTPAY"]);

                $sql = "select * from s_sttr where st_invono = '" . trim($row["REF_NO"]) . "' order by st_paid desc";
                $result_st = mysqli_query($GLOBALS['dbinv'], $sql);
                if ($row_st = mysqli_fetch_array($result_st)) {
                    if ((is_null($row["deli_date"]) == false) and ( $row["deli_date"] != "0000-00-00")) {
                        $Inv_date = $row["deli_date"];
                    } else {
                        $Inv_date = $row["SDATE"];
                    }
                    if ($row_st["ST_FLAG"] == "UT") {
                        $settledate = $row_st["ST_DATE"];
                    } if (($row_st["ST_FLAG"] == "CHK") or ( $row_st["ST_FLAG"] == "Cash TT") or ( $row_st["ST_FLAG"] == "J/Entry") or ( $row_st["ST_FLAG"] == "CAS")) {
                        $settledate = $row_st["st_chdate"];
                    }

                    $date1 = $Inv_date;
                    $date2 = $settledate;
                    $diff = (strtotime($date2) - strtotime($date1));
                    $days = floor($diff / (60 * 60 * 24));
                    echo "<td>" . $settledate . "</td>";
                    echo "<td>" . $days . "</td>";

                    $sql = "select * from s_crnfrmtrn where inv_no = '" . trim($row["REF_NO"]) . "'";
                    $result_st = mysqli_query($GLOBALS['dbinv'], $sql);
                    if ($row_st = mysqli_fetch_array($result_st)) {
                        echo "<td>" . $row_st['Incen_per'] . "</td>";
                        echo "<td  align=right>" . $row_st['Incen_val'] . "</td>";
                        $incen = $incen + $row_st['Incen_val'];
                    } else {
                        echo "<td></td>";
                        echo "<td></td>";
                    }
                }
            }


            echo "<tr>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td  align=right>" . number_format($totgrad, 2, ".", ",") . "</td>";
            echo "<td align=right>" . number_format($totinvp, 2, ".", ",") . "</td>";
            echo "<td align=right>" . number_format($totinv, 2, ".", ",") . "</td>";
            echo "<td></td>";
            echo "<td></td>";

            echo "<td></td>";
            echo "<td></td>";

            echo "<td></td>";
            echo "<td  align=right>" . number_format($incen, 2, ".", ",") . "</td>";


            echo "</tr>";

            echo "</table>";
            echo "<b>Total Outstanding Invoice Balance=" . number_format($totinv, 2, ".", ",") . "</b></br></br>";




            echo "</table>";


            echo "</body>";
            echo "</html>";
        }

        function printut() {

            require_once("connectioni.php");




            if (($_GET["cmbbrand1"] == "All") and ( $_GET["cmbGRNtype"] == "All") and ( trim($_GET["cuscode"]) == "") and ( $_GET["cmbrep"] == "All")) {
                $sql = "select * from view_c_bal_s_deftrn where  BALANCE>0 AND CANCELL = '0' and trn_type<>'ARN'  and sdate>'2016-12-31' ";
            }
            if (($_GET["cmbbrand1"] == "All") and ( $_GET["cmbGRNtype"] == "All") and ( trim($_GET["cuscode"]) != "") and ( $_GET["cmbrep"] == "All")) {
                $sql = "select * from view_c_bal_s_deftrn where CUSCODE='" . trim($_GET["cuscode"]) . "' AND CANCELL = '0' and BALANCE>0 and trn_type<>'ARN'  and sdate>'2016-01-01'";
            }

            if (($_GET["cmbbrand1"] == "All") and ( $_GET["cmbGRNtype"] == "All") and ( $_GET["cmbrep"] != "All") and ( trim($_GET["cuscode"]) == "")) {
                $sql = "select * from view_c_bal_s_deftrn  where  sal_ex='" . trim($_GET["cmbrep"]) . "' AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2016-01-01'";
            }
            if (($_GET["cmbbrand1"] == "All") and ( $_GET["cmbGRNtype"] == "All") and ( $_GET["cmbrep"] != "All") and ( trim($_GET["cuscode"]) != "")) {
                $sql = "select * from view_c_bal_s_deftrn  where CUSCODE='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2016-01-01'";
            }

            if (($_GET["cmbbrand1"] == "All") and ( $_GET["cmbGRNtype"] != "All") and ( trim($_GET["cuscode"]) == "") and ( $_GET["cmbrep"] == "All")) {
                $sql = "select * from view_c_bal_s_deftrn where   trn_type='" . $_GET["cmbGRNtype"] . "'and BALANCE>0 AND CANCELL = '0' and trn_type<>'ARN'  and sdate>'2016-01-01'";
            }
            if (($_GET["cmbbrand1"] == "All") and ( $_GET["cmbGRNtype"] != "All") and ( trim($_GET["cuscode"]) != "") and ( $_GET["cmbrep"] == "All")) {
                $sql = "select * from view_c_bal_s_deftrn where  trn_type='" . $_GET["cmbGRNtype"] . "'and CUSCODE='" . trim($_GET["cuscode"]) . "' AND CANCELL = '0' and BALANCE>0 and trn_type<>'ARN'  and sdate>'2016-01-01'";
            }

            if (($_GET["cmbbrand1"] == "All") and ( $_GET["cmbGRNtype"] != "All") and ( $_GET["cmbrep"] != "All") and ( trim($_GET["cuscode"]) == "")) {
                $sql = "select * from view_c_bal_s_deftrn  where  trn_type='" . $_GET["cmbGRNtype"] . "'and  sal_ex='" . trim($_GET["cmbrep"]) . "' AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2016-01-01'";
            }
            if (($_GET["cmbbrand1"] == "All") and ( $_GET["cmbGRNtype"] != "All") and ( $_GET["cmbrep"] != "All") and ( trim($_GET["cuscode"]) != "")) {
                $sql = "select * from view_c_bal_s_deftrn  where  trn_type='" . $_GET["cmbGRNtype"] . "'and CUSCODE='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2016-01-01'";
            }

            if (($_GET["cmbbrand1"] != "All") and ( $_GET["cmbGRNtype"] == "All") and ( trim($_GET["cuscode"]) == "") and ( $_GET["cmbrep"] == "All")) {
                $sql = "select * from view_c_bal_s_deftrn where  class='" . trim($_GET["cmbbrand1"]) . "' and  BALANCE>0 AND CANCELL = '0' and trn_type<>'ARN'  and sdate>'2016-01-01' ";
            }
            if (($_GET["cmbbrand1"] != "All") and ( $_GET["cmbGRNtype"] == "All") and ( trim($_GET["cuscode"]) != "") and ( $_GET["cmbrep"] == "All")) {
                $sql = "select * from view_c_bal_s_deftrn where   class='" . trim($_GET["cmbbrand1"]) . "' and CUSCODE='" . trim($_GET["cuscode"]) . "' AND CANCELL = '0' and BALANCE>0 and trn_type<>'ARN'  and sdate>'2016-01-01'";
            }

            if (($_GET["cmbbrand1"] != "All") and ( $_GET["cmbGRNtype"] == "All") and ( $_GET["cmbrep"] != "All") and ( trim($_GET["cuscode"]) == "")) {
                $sql = "select * from view_c_bal_s_deftrn  where   class='" . trim($_GET["cmbbrand1"]) . "' and  sal_ex='" . trim($_GET["cmbrep"]) . "' AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2016-01-01'";
            }
            if (($_GET["cmbbrand1"] != "All") and ( $_GET["cmbGRNtype"] == "All") and ( $_GET["cmbrep"] != "All") and ( trim($_GET["cuscode"]) != "")) {
                $sql = "select * from view_c_bal_s_deftrn  where  class='" . trim($_GET["cmbbrand1"]) . "' and  CUSCODE='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "'AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2016-01-01'";
            }

            if (($_GET["cmbbrand1"] != "All") and ( $_GET["cmbGRNtype"] != "All") and ( trim($_GET["cuscode"]) == "") and ( $_GET["cmbrep"] == "All")) {
                $sql = "select * from view_c_bal_s_deftrn where   class='" . trim($_GET["cmbbrand1"]) . "' and   trn_type='" . $_GET["cmbGRNtype"] . "'and BALANCE>0 AND CANCELL = '0' and trn_type<>'ARN'  and sdate>'2016-01-01'";
            }
            if (($_GET["cmbbrand1"] != "All") and ( $_GET["cmbGRNtype"] != "All") and ( trim($_GET["cuscode"]) != "") and ( $_GET["cmbrep"] == "All")) {
                $sql = "select * from view_c_bal_s_deftrn where    class='" . trim($_GET["cmbbrand1"]) . "' and trn_type='" . $_GET["cmbGRNtype"] . "'and CUSCODE='" . trim($_GET["cuscode"]) . "' AND CANCELL = '0' and BALANCE>0 and trn_type<>'ARN'  and sdate>'2016-01-01'";
            }

            if (($_GET["cmbbrand1"] != "All") and ( $_GET["cmbGRNtype"] != "All") and ( $_GET["cmbrep"] != "All") and ( trim($_GET["cuscode"]) == "")) {
                $sql = "select * from view_c_bal_s_deftrn  where   class='" . trim($_GET["cmbbrand1"]) . "' and  trn_type='" . $_GET["cmbGRNtype"] . "'and  sal_ex='" . trim($_GET["cmbrep"]) . "' AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2016-01-01'";
            }
            if (($_GET["cmbbrand1"] != "All") and ( $_GET["cmbGRNtype"] != "All") and ( $_GET["cmbrep"] != "All") and ( trim($_GET["cuscode"]) != "")) {
                $sql = "select * from view_c_bal_s_deftrn  where   class='" . trim($_GET["cmbbrand1"]) . "' and  trn_type='" . $_GET["cmbGRNtype"] . "'and CUSCODE='" . trim($_GET["cuscode"]) . "' and sal_ex='" . trim($_GET["cmbrep"]) . "' AND CANCELL = '0' and   BALANCE>0 and trn_type<>'ARN'  and sdate>'2016-01-01'";
            }
//echo $sql;

            $sql = "select * from view_c_bal_s_deftrn where  BALANCE>0 AND CANCELL = '0' and trn_type<>'ARN'  and sdate>'2016-12-31' ";

            if ($_GET["cmbbrand1"] != "All") {
                $sql .= " and class='" . trim($_GET["cmbbrand1"]) . "'";
            }

            if ($_GET["cmbGRNtype"] != "All") {
                $sql .= " and trn_type='" . trim($_GET["cmbGRNtype"]) . "'";
            }
//echo $sql;
            if ($_SESSION["CURRENT_REP"] != "") {

                if ($_GET["brand"] != "Äll") {
                    $sql_br = "select * from brand_mas where barnd_name ='" . trim($_GET["brand"]) . "'";
                    $result_br = mysqli_query($GLOBALS['dbinv'], $sql_br);
                    $row_br = mysqli_fetch_array($result_br);

                    $sql_b = "select * from s_salrep where REPCODE = '" . trim($_SESSION["CURRENT_REP"]) . "' and rgroup = '" . $row_br['costcenter'] . "'";
                    $result_b = mysqli_query($GLOBALS['dbinv'], $sql_b);

                    if (!$row_b = mysqli_fetch_array($result_b)) {
                        $sql .= " and  sal_ex = '" . $_SESSION["CURRENT_REP"] . "' ";
                    }
                } else {
                    $sql .= " and  sal_ex = '" . $_SESSION["CURRENT_REP"] . "' ";
                }
            } elseif (( $_GET["cmbrep"] != "All")) {
                $sql .= " and  sal_ex = '" . $_GET["cmbrep"] . "'";
            }

            if (trim($_GET["cuscode"]) != "") {
                $sql .= " and  CUSCODE = '" . $_GET["cuscode"] . "'";
            }

            if ($_GET["brand"] != "All") {
                $sql .= " and  brand = '" . $_GET["brand"] . "' ";
            }



            $sql .= " order by sdate,refno,c_code1";
//            echo $sql;
            if ($_GET["cmbbrand1"] != "All") {
                $stringhesd = $_GET["cuscode"] . "  " . $_GET["cusname"] . "  Outsanding Statement Rep." . " " . $_GET["cmbrep"] . "   " . $_GET["cmbbrand1"];
            } else {
                $stringhesd = $_GET["cuscode"] . "  " . $_GET["cusname"] . "  Outsanding Statement Rep." . " " . $_GET["cmbrep"];
            }

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


            echo "<center>Unsettle GRN / Credit Note / Over Payments</center><br>";

            echo "<center>Customer Code : " . $_GET["cuscode"] . "</br>";
            echo "Customer Name : " . $_GET["cusname"] . "</br>";


            echo "<table border=1 color=balck bordercolorlight=#FFCC00 bordercolordark=#FF6633>";
            echo "<tr align=center bgcolor=#00aaaa>";
            echo "<td><b>Ref No</b></td>";
            echo "<td><b>Customer</b></td>";
            echo "<td><b>Dif Ref</b></td>";
            echo "<td><b>Rep</b></td>";
            echo "<td><b>Date</b></td>";
            echo "<td><b>Brand</b></td>";
            echo "<td><b>Amount</b></td>";
            echo "<td><b>Balance</b></td><td><b>Stat</b></td>";
            echo "</tr>";

            $AMOUNT = 0;
            $BALANCE = 0;
            //echo $sql;
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            while ($row = mysqli_fetch_array($result)) {

                $mok = "k";

                if (($_SESSION["CURRENT_DEP"] != "") and ( !is_numeric($_SESSION["CURRENT_DEP"]))) {
                    $mok = "";
                    $sql = "select * from s_salrep  where REPCODE = '" . $row["sal_ex"] . "'";

                    if ($_SESSION["CURRENT_DEP"] == "AREA II") {
                        $sql .= " and ( RGROUP = 'AREA II' or  RGROUP = 'AREA I')";
                    } else {
                        $sql .= " AND RGROUP1 = '" . $_SESSION["CURRENT_DEP"] . "'";
                    }
                    $mok = "k";
                }
                if ($mok == 'k') {

                    $sql_per = "select * from view_userpermission where username='" . $_SESSION["UserName"] . "' and docname='Customer Current Status'";
                    $result_per = mysqli_query($GLOBALS['dbinv'], $sql_per);
                    $row_per = mysqli_fetch_array($result_per);
                    if (($row_per['doc_mod'] == 1)) {
                        if ((strtoupper($row["c_code1"]) != strtoupper($ccode1)) and ( $ccode1 != "") and ( strtoupper($row["CUSCODE"]) == strtoupper($ccode))) {
                            $sql = "select * from vender_sub where c_code = '" . $row["c_code1"] . "'";
                            $result_v = mysqli_query($GLOBALS['dbinv'], $sql);
                            if ($row_v = mysqli_fetch_array($result_v)) {
                                echo "<tr> 
                                <th></th>
                                <th colspan=9 align=left><b>" . $row_v["c_name"] . "</b></th>
                                </tr>";
                            }
                        }
                        $ccode = $row["CUSCODE"];
                        $ccode1 = $row["c_code1"];
                        echo "<tr >";

                        if ($row['trn_type'] == "DGRN") {
                            echo "<td><a onclick=\"NewWindow('defective_item_display.php?txtrefno=" . $row["REFNO"] . "&amp;trn_type=DGRN','mywin','900','700','yes','center');return false\" href=''>" . $row["REFNO"] . "</a></td>";
                        } elseif ($row['trn_type'] == "GRN") {
                            echo "<td><a onclick=\"NewWindow('grn_display.php?grn=" . $row['REFNO'] . "&amp;trn_type=GRN','mywin','900','700','yes','center');return false\" href=''>" . $row["REFNO"] . "</a></td>";
                        } else {
                            echo "<td>" . $row["REFNO"] . "</td>";
                        }
                        echo "<td>" . $row["c_code1"] . "</td>";

                        if (isset($row["DESCRIPT"])) {
                            echo "<td>" . $row["DESCRIPT"] . "</td>";
                        } else {
                            echo "<td></td>";
                        }
                        echo "<td>" . $row["sal_ex"] . "</td>";
                        echo "<td>" . $row["sdate"] . "</td>";
                        echo "<td>" . $row["brand"] . "</td>";
                        echo "<td>" . number_format($row["AMOUNT"], 2, ".", ",") . "</td>";
                        echo "<td>" . number_format($row["BALANCE"], 2, ".", ",") . "</td>";
//                    praweenaka 20.08.12
                        $omk = ""; 
                        if ($row["trn_type"] == "CNT") {
                            if ($row["block"] == "0") {
                                $omk = "Approve";
                            }else if ($row["block"] == "1") {
                                $omk = "Blocked";
                            }else if ($row["block"] == "2") {
                               $omk = "Forward Acc";
                           }
                       }else{

                        if ($row["active"] == "2") {
                            $omk = "Blocked";
                        }
                    }
//

                    echo "<td>" . $omk . "</td>";

                    echo "</tr>";
                    $AMOUNT = $AMOUNT + $row["AMOUNT"];
                    $BALANCE = $BALANCE + $row["BALANCE"];
                } else {
                    if ($row['trn_type'] == "DGRN") {
                        if ($row['hide'] == 0) {
                            if ((strtoupper($row["c_code1"]) != strtoupper($ccode1)) and ( $ccode1 != "") and ( strtoupper($row["CUSCODE"]) == strtoupper($ccode))) {
                                $sql = "select * from vender_sub where c_code = '" . $row["c_code1"] . "'";
                                $result_v = mysqli_query($GLOBALS['dbinv'], $sql);
                                if ($row_v = mysqli_fetch_array($result_v)) {
                                    echo "<tr> 
                                    <th></th>
                                    <th colspan=9 align=left><b>" . $row_v["c_name"] . "</b></th>
                                    </tr>";
                                }
                            }
                            $ccode = $row["CUSCODE"];
                            $ccode1 = $row["c_code1"];
                            echo "<tr >";

                            if ($row['trn_type'] == "DGRN") {
                                echo "<td><a onclick=\"NewWindow('defective_item_display.php?txtrefno=" . $row["REFNO"] . "&amp;trn_type=DGRN','mywin','900','700','yes','center');return false\" href=''>" . $row["REFNO"] . "</a></td>";
                            } elseif ($row['trn_type'] == "GRN") {
                                echo "<td><a onclick=\"NewWindow('grn_display.php?grn=" . $row['REFNO'] . "&amp;trn_type=GRN','mywin','900','700','yes','center');return false\" href=''>" . $row["REFNO"] . "</a></td>";
                            } else {
                                echo "<td>" . $row["REFNO"] . "</td>";
                            }
                            echo "<td>" . $row["c_code1"] . "</td>";

                            if (isset($row["DESCRIPT"])) {
                                echo "<td>" . $row["DESCRIPT"] . "</td>";
                            } else {
                                echo "<td></td>";
                            }
                            echo "<td>" . $row["sal_ex"] . "</td>";
                            echo "<td>" . $row["sdate"] . "</td>";
                            echo "<td>" . $row["brand"] . "</td>";
                            echo "<td>" . number_format($row["AMOUNT"], 2, ".", ",") . "</td>";
                            echo "<td>" . number_format($row["BALANCE"], 2, ".", ",") . "</td>";


                            $omk = "";
                            if ($row["active"] == "2") {
                                $omk = "Blocked";
                            }
                            echo "<td>" . $omk . "</td>";
                            echo "</tr>";
                            $AMOUNT = $AMOUNT + $row["AMOUNT"];
                            $BALANCE = $BALANCE + $row["BALANCE"];
                        }
                    } else {
                        if ((strtoupper($row["c_code1"]) != strtoupper($ccode1)) and ( $ccode1 != "") and ( strtoupper($row["CUSCODE"]) == strtoupper($ccode))) {
                            $sql = "select * from vender_sub where c_code = '" . $row["c_code1"] . "'";
                            $result_v = mysqli_query($GLOBALS['dbinv'], $sql);
                            if ($row_v = mysqli_fetch_array($result_v)) {
                                echo "<tr> 
                                <th></th>
                                <th colspan=9 align=left><b>" . $row_v["c_name"] . "</b></th>
                                </tr>";
                            }
                        }
                        $ccode = $row["CUSCODE"];
                        $ccode1 = $row["c_code1"];
                        echo "<tr >";

                        if ($row['trn_type'] == "DGRN") {
                            echo "<td><a onclick=\"NewWindow('defective_item_display.php?txtrefno=" . $row["REFNO"] . "&amp;trn_type=DGRN','mywin','900','700','yes','center');return false\" href=''>" . $row["REFNO"] . "</a></td>";
                        } elseif ($row['trn_type'] == "GRN") {
                            echo "<td><a onclick=\"NewWindow('grn_display.php?grn=" . $row['REFNO'] . "&amp;trn_type=GRN','mywin','900','700','yes','center');return false\" href=''>" . $row["REFNO"] . "</a></td>";
                        } else {
                            echo "<td>" . $row["REFNO"] . "</td>";
                        }
                        echo "<td>" . $row["c_code1"] . "</td>";

                        if (isset($row["DESCRIPT"])) {
                            echo "<td>" . $row["DESCRIPT"] . "</td>";
                        } else {
                            echo "<td></td>";
                        }
                        echo "<td>" . $row["sal_ex"] . "</td>";
                        echo "<td>" . $row["sdate"] . "</td>";
                        echo "<td>" . $row["brand"] . "</td>";
                        echo "<td>" . number_format($row["AMOUNT"], 2, ".", ",") . "</td>";
                        echo "<td>" . number_format($row["BALANCE"], 2, ".", ",") . "</td>";
//                    praweenaka 20.08.12
                        $omk = ""; 
                        if ($row["trn_type"] == "CNT") {
                            if ($row["block"] == "0") {
                                $omk = "Approve";
                            }else if ($row["block"] == "1") {
                                $omk = "Blocked";
                            }else if ($row["block"] == "2") {
                               $omk = "Forward Acc";
                           }
                       }else{ 
                        if ($row["active"] == "2") {
                            $omk = "Blocked";
                        }
                    }
//

                    echo "<td>" . $omk . "</td>";
                    echo "</tr>";
                    $AMOUNT = $AMOUNT + $row["AMOUNT"];
                    $BALANCE = $BALANCE + $row["BALANCE"];
                }
            }
        }
    }
    echo "<tr >";
    echo "<td colspan=6>&nbsp;</td>";
    echo "<td><b>" . number_format($AMOUNT, 2, ".", ",") . "</b></td>";
    echo "<td><b>" . number_format($BALANCE, 2, ".", ",") . "</b></td>";
    echo "</table>";
}
?>



</body>
</html>

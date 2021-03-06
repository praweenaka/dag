<?php session_start();
?>
<?php date_default_timezone_set('Asia/Colombo'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Print Item Claim</title>
        <style type="text/css">
            <!--
            .companyname {
                color: #0000FF;
                font-weight: bold;
                font-size: 24px;
            }

            .com_address {
                color: #000000;
                font-weight: bold;
                font-size: 18px;
            }

            .heading {
                color: #000000;
                font-weight: bold;
                font-size: 20px;
            }

            body {
                color: #000000;
                font-size: 20px;
            }
            .style2 {
                font-size: 36px;
                font-weight: bold;
            }


            -->
        </style>
    </head>

    <body><center>
            <?php
            require_once("connectioni.php");



            $sql_para = "select * from invpara";
            $result_para = mysqli_query($GLOBALS['dbinv'], $sql_para);
            $row_para = mysqli_fetch_array($result_para);
            ?>

            <table width="1000" border="0">
                <tr>
                    <td colspan="5" align="center"><span class="companyname"><?php echo $row_para["COMPANY"]; ?></span></td>
                </tr>
                <tr>
                    <td colspan="5" align="center"><span class="companyname">UNDER COMPLAINT TYRE/TUBE REPORT</span></td>
                </tr>
                <?php
                //echo $_GET["invno"];

                $sql_rsPrInv = "select * from c_clamas where refno = '" . trim($_GET["txtrefno"]) . "'";
                $result_rsPrInv = mysqli_query($GLOBALS['dbinv'], $sql_rsPrInv);
                $row_rsPrInv = mysqli_fetch_array($result_rsPrInv);

                if (trim($row_rsPrInv["Refund"]) == "Recommended") {
                    $rtxtrefund = trim($row_rsPrInv["Refund"]) . " / " . "Accepted";
                    if (trim($row_rsPrInv["Commercialy"]) == "0") {
                        $rtxcomm = "Not Allowed";
                    } else {
                        $rtxcomm = "Allowed";
                    }
                    //$Text12.Suppress = True
                    //$rtxcomm.Suppress = True
                } else {
                    $rtxtrefund = trim($row_rsPrInv["Refund"]) . " / " . "Rejected";
                    if (trim($row_rsPrInv["Commercialy"]) == "0") {
                        $rtxcomm = "Not Allowed";
                    } else {
                        $rtxcomm = "Allowed";
                    }
                }
                if (trim($_GET["txtCRD_no"]) != "0") {
                    $rtxdefno = $_GET["txtCRD_no"];
                    $rtxdefdate = date("Y-m-d", strtotime($_GET["txtCRE_date"]));
                    $rtxdefamou = number_format($_GET["txtCRE_amount"], 2, ".", ",");
                }
                if (trim($_GET["txtCRD_no2"]) != "0") {
                    $rtxdefno2 = $_GET["txtCRD_no2"];
                    $rtxdefdate2 = date("Y-m-d", strtotime($_GET["txtCRE_date2"]));
                    $rtxdefamou2 = number_format($_GET["txtCRE_amount2"], 2, ".", ",");
                } else {
                    /* $rtxdefno2.Suppress = True
                      $rtxdefdate2.Suppress = True
                      $rtxdefamou2.Suppress = True
                      $Text20.Suppress = True
                      $Text28.Suppress = True */
                }
                if (trim($_GET["txtCRD_no3"]) != "0") {
                    $rtxdefno3 = $_GET["txtCRD_no3"];
                    $rtxdefdate3 = date("Y-m-d", strtotime($_GET["txtCRE_date3"]));
                    $rtxdefamou3 = number_format($_GET["txtCRE_amount3"], 2, ".", ",");
                } else {
                    /* $rtxdefno3.Suppress = True
                      $rtxdefdate3.Suppress = True
                      $rtxdefamou3.Suppress = True
                      $Text34.Suppress = True
                      $Text36.Suppress = True */
                }
                if ($_GET["Prn_md"] == "true") {
                    /* m_Report.Text26.Suppress = False
                      m_Report.Text29.Suppress = False
                      m_Report.Text31.Suppress = False
                      m_Report.Text47.Suppress = False
                      m_Report.Text35.Suppress = False
                      m_Report.Text37.Suppress = False
                      m_Report.Text38.Suppress = False
                      m_Report.Text39.Suppress = False
                      m_Report.Text40.Suppress = False
                      m_Report.Text41.Suppress = False
                      m_Report.Text42.Suppress = False
                      m_Report.Text43.Suppress = False
                      m_Report.Text44.Suppress = False
                      m_Report.Text45.Suppress = False
                      m_Report.Text46.Suppress = False
                      m_Report.Text48.Suppress = False
                      m_Report.Text49.Suppress = False
                      m_Report.Text50.Suppress = False
                      m_Report.Text51.Suppress = False
                      m_Report.Text52.Suppress = False
                      m_Report.Text53.Suppress = False
                      m_Report.Text54.Suppress = False */
                    if (trim(Cmb_refund) == "Not Recommended") { /* m_Report.Text55.Suppress = False */
                    }
                    if (trim(Cmb_refund) == "Recommended") { /* m_Report.Text56.Suppress = False */
                    }
                    /* m_Report.Box5.Suppress = False
                      m_Report.Box6.Suppress = False
                      m_Report.Box7.Suppress = False
                      m_Report.Line35.Suppress = False
                      m_Report.Line27.Suppress = False
                      m_Report.Line36.Suppress = False
                      m_Report.Line37.Suppress = False
                      m_Report.Line38.Suppress = False
                      m_Report.Line39.Suppress = False
                      m_Report.Line40.Suppress = False
                      m_Report.Line41.Suppress = False
                      m_Report.Line42.Suppress = False
                      m_Report.Line43.Suppress = False
                      m_Report.Line44.Suppress = False
                      m_Report.Line45.Suppress = False
                      m_Report.Line46.Suppress = False
                      m_Report.Line48.Suppress = False */


                    $sale = 0;
                    $grn = 0;
                    $dgrn = 0;
                    $i = 1;
                    $m = date("m");
                    $Y = date("Y");
                    $d = date("d");

                    if ($d < 7) {
                        $m = $m - 1;
                    }
                    for ($i = 1; $i <= 6; $i++) {
                        if ($m == 0) {
                            $m = 12;
                            $Y = $Y - 1;
                        }
                        if ($m == 1) {
                            $Mon = "Jan";
                        }
                        if ($m == 2) {
                            $Mon = "Feb";
                        }
                        if ($m == 3) {
                            $Mon = "Mar";
                        }
                        if ($m == 4) {
                            $Mon = "Apr";
                        }
                        if ($m == 5) {
                            $Mon = "May";
                        }
                        if ($m == 6) {
                            $Mon = "Jun";
                        }
                        if ($m == 7) {
                            $Mon = "Jul";
                        }
                        if ($m == 8) {
                            $Mon = "Aug";
                        }
                        if ($m == 9) {
                            $Mon = "Sep";
                        }
                        if ($m == 10) {
                            $Mon = "Oct";
                        }
                        if ($m == 11) {
                            $Mon = "Nov";
                        }
                        if ($m == 12) {
                            $Mon = "Dec";
                        }
                        if ($i == 1) {
                            $sql_rs_sal = "Select sum(GRAND_TOT/1.12) AS S_TOT from s_salma where month(SDATE) = '" . $m . "' and year(SDATE) = '" . $Y . "' and CANCELL = '0' and C_CODE = '" . trim($_GET["txtag_code"]) . "' and Accname != 'NON STOCK'";
                            $result_rs_sal = mysqli_query($GLOBALS['dbinv'], $sql_rs_sal);
                            $row_rs_sal = mysqli_fetch_array($result_rs_sal);

                            $sql_rs_cbal = "Select sum(AMOUNT/1.12) AS G_TOT from c_bal where month(SDATE) = '" . $m . "' and year(SDATE) = '" . $Y . "' and CANCELL = '0' and trn_type <> 'REC' AND trn_type <> 'INC' AND trn_type <> 'ARN' AND trn_type <> 'DGRN' AND CUSCODE = '" . trim($_GET["txtag_code"]) . "'";
                            $result_rs_cbal = mysqli_query($GLOBALS['dbinv'], $sql_rs_cbal);
                            $row_rs_cbal = mysqli_fetch_array($result_rs_cbal);

                            $sql_rs_def = "Select sum(c_amount/1.12) as c_claim from view_cbal_deftrn where month(SDATE) = '" . $m . "' and year(SDATE) = '" . $Y . "' and c_code = '" . trim($_GET["txtag_code"]) . "' and REsult != 'DEFECT' AND CANCELL = '0'";
                            $result_rs_def = mysqli_query($GLOBALS['dbinv'], $sql_rs_def);
                            $row_rs_def = mysqli_fetch_array($result_rs_def);

                            if (is_null($row_rs_sal["S_TOT"]) == false) {
                                $sale = $sale + $row_rs_sal["S_TOT"];
                            }
                            if (is_null($row_rs_cbal["G_TOT"]) == false) {
                                $grn = $grn + $row_rs_cbal["G_TOT"];
                            }
                            $Text48 = $Mon;
                            if (is_null($row_rs_def["c_claim"]) == false) {
                                $Text51 = number_format($row_rs_def["c_claim"], 2, ".", ",");
                                $dgrn = $dgrn + $row_rs_def["c_claim"];
                            }
                        }
                        if ($i == 2) {

                            $sql_rs_sal = "Select sum(GRAND_TOT/1.12) AS S_TOT from s_salma where month(SDATE) = '" . $m . "' and year(SDATE) = '" . $Y . "' and CANCELL = '0' and C_CODE = '" . trim($_GET["txtag_code"]) . "' and Accname != 'NON STOCK'";
                            $result_rs_sal = mysqli_query($GLOBALS['dbinv'], $sql_rs_sal);
                            $row_rs_sal = mysqli_fetch_array($result_rs_sal);

                            $sql_rs_cbal = "Select sum(AMOUNT/1.12) AS G_TOT from c_bal where month(SDATE) = '" . $m . "' and year(SDATE) = '" . $Y . "' and CANCELL = '0' and trn_type <> 'REC' AND trn_type <> 'INC' AND trn_type <> 'ARN' AND trn_type <> 'DGRN' AND CUSCODE = '" . trim($_GET["txtag_code"]) . "'";
                            $result_rs_cbal = mysqli_query($GLOBALS['dbinv'], $sql_rs_cbal);
                            $row_rs_cbal = mysqli_fetch_array($result_rs_cbal);


                            $sql_rs_def = "Select sum(c_amount/1.12) as c_claim from view_cbal_deftrn where month(SDATE) = '" . $m . "' and year(SDATE) = '" . $Y . "' and c_code = '" . trim($_GET["txtag_code"]) . "' and REsult != 'DEFECT' AND CANCELL = '0'";
                            $result_rs_def = mysqli_query($GLOBALS['dbinv'], $sql_rs_def);
                            $row_rs_def = mysqli_fetch_array($result_rs_def);


                            if (is_null($row_rs_sal["S_TOT"]) == false) {
                                $sale = $sale + $row_rs_sal["S_TOT"];
                            }
                            if (is_null($row_rs_cbal["G_TOT"]) == false) {
                                $grn = $grn + $row_rs_cbal["G_TOT"];
                            }
                            $Text49 = $Mon;
                            if (is_null($row_rs_def["c_claim"]) == false) {
                                $Text52 = number_format($row_rs_def["c_claim"], 2, ".", ",");
                                $dgrn = $dgrn + $row_rs_def["c_claim"];
                            }
                        }

                        if ($i == 3) {

                            $sql_rs_sal = "Select sum(GRAND_TOT/1.12) AS S_TOT from s_salma where month(SDATE) = '" . $m . "' and year(SDATE) = '" . $Y . "' and CANCELL = '0' and C_CODE = '" . trim($_GET["txtag_code"]) . "' and Accname != 'NON STOCK'";
                            $result_rs_sal = mysqli_query($GLOBALS['dbinv'], $sql_rs_sal);
                            $row_rs_sal = mysqli_fetch_array($result_rs_sal);


                            $sql_rs_cbal = "Select sum(AMOUNT/1.12) AS G_TOT from c_bal where month(SDATE) = '" . $m . "' and year(SDATE) = '" . $Y . "' and CANCELL = '0' and trn_type != 'REC' AND trn_type != 'INC' AND trn_type != 'ARN' AND trn_type != 'DGRN' AND CUSCODE = '" . trim($_GET["txtag_code"]) . "'";
                            $result_rs_cbal = mysqli_query($GLOBALS['dbinv'], $sql_rs_cbal);
                            $row_rs_cbal = mysqli_fetch_array($result_rs_cbal);



                            $sql_rs_def = "Select sum(c_amount/1.12) as c_claim from view_cbal_deftrn where month(SDATE) = '" . $m . "' and year(SDATE) = '" . $Y . "' and c_code = '" . trim($_GET["txtag_code"]) . "' and REsult != 'DEFECT' AND CANCELL = '0'";
                            $result_rs_def = mysqli_query($GLOBALS['dbinv'], $sql_rs_def);
                            $row_rs_def = mysqli_fetch_array($result_rs_def);



                            if (is_null($row_rs_sal["S_TOT"]) == false) {
                                $sale = $sale + $row_rs_sal["S_TOT"];
                            }
                            if (is_null($row_rs_cbal["G_TOT"]) == false) {
                                $grn = $grn + $row_rs_cbal["G_TOT"];
                            }
                            $Text50 = $Mon;
                            if (is_null($row_rs_def["c_claim"]) == false) {
                                $Text53 = number_format($row_rs_def["c_claim"], 2, ".", ",");
                                $dgrn = $dgrn + $row_rs_def["c_claim"];
                            }
                        }
                        if ($i == 4) {
                            $sql_rs_sal = "Select sum(GRAND_TOT/1.12) AS S_TOT from s_salma where month(SDATE) = '" . $m . "' and year(SDATE) = '" . $Y . "' and CANCELL = '0' and C_CODE = '" . trim($_GET["txtag_code"]) . "' and Accname != 'NON STOCK'";
                            $result_rs_sal = mysqli_query($GLOBALS['dbinv'], $sql_rs_sal);
                            $row_rs_sal = mysqli_fetch_array($result_rs_sal);


                            $sql_rs_cbal = "Select sum(AMOUNT/1.12) AS G_TOT from c_bal where month(SDATE) = '" . $m . "' and year(SDATE) = '" . $Y . "' and CANCELL = '0' and trn_type != 'REC' AND trn_type != 'INC' AND trn_type != 'ARN' AND trn_type != 'DGRN' AND CUSCODE = '" . trim($_GET["txtag_code"]) . "'";
                            $result_rs_cbal = mysqli_query($GLOBALS['dbinv'], $sql_rs_cbal);
                            $row_rs_cbal = mysqli_fetch_array($result_rs_cbal);


                            if (is_null($row_rs_sal["S_TOT"]) == false) {
                                $sale = $sale + $row_rs_sal["S_TOT"];
                            }
                            if (is_null($row_rs_cbal["G_TOT"]) == false) {
                                $grn = $grn + $row_rs_cbal["G_TOT"];
                            }
                        }
                        if ($i == 5) {
                            $sql_rs_sal = "Select sum(GRAND_TOT/1.12) AS S_TOT from s_salma where month(SDATE) = '" . $m . "' and year(SDATE) = '" . $Y . "' and CANCELL = '0' and C_CODE = '" . trim($_GET["txtag_code"]) . "' and Accname != 'NON STOCK'";
                            $result_rs_sal = mysqli_query($GLOBALS['dbinv'], $sql_rs_sal);
                            $row_rs_sal = mysqli_fetch_array($result_rs_sal);

                            $sql_rs_cbal = "Select sum(AMOUNT/1.12) AS G_TOT from c_bal where month(SDATE) = '" . $m . "' and year(SDATE) = '" . $Y . "' and CANCELL = '0' and trn_type != 'REC' AND trn_type != 'INC' AND trn_type != 'ARN' AND trn_type != 'DGRN' AND CUSCODE = '" . trim($_GET["txtag_code"]) . "'";
                            $result_rs_cbal = mysqli_query($GLOBALS['dbinv'], $sql_rs_cbal);
                            $row_rs_cbal = mysqli_fetch_array($result_rs_cbal);


                            if (is_null($row_rs_sal["S_TOT"]) == false) {
                                $sale = $sale + $row_rs_sal["S_TOT"];
                            }
                            if (is_null($row_rs_cbal["G_TOT"]) == false) {
                                $grn = $grn + $row_rs_cbal["G_TOT"];
                            }
                        }

                        if ($i == 6) {
                            $sql_rs_sal = "Select sum(GRAND_TOT/1.12) AS S_TOT from s_salma where month(SDATE) = '" . $m . "' and year(SDATE) = '" . $Y . "' and CANCELL = '0' and C_CODE = '" . trim($_GET["txtag_code"]) . "' and Accname != 'NON STOCK'";
                            $result_rs_sal = mysqli_query($GLOBALS['dbinv'], $sql_rs_sal);
                            $row_rs_sal = mysqli_fetch_array($result_rs_sal);

                            $sql_rs_cbal = "Select sum(AMOUNT/1.12) AS G_TOT from c_bal where month(SDATE) = '" . $m . "' and year(SDATE) = '" . $Y . "' and CANCELL = '0' and trn_type != 'REC' AND trn_type != 'INC' AND trn_type != 'ARN' AND trn_type != 'DGRN' AND CUSCODE = '" . trim($_GET["txtag_code"]) . "'";
                            $result_rs_cbal = mysqli_query($GLOBALS['dbinv'], $sql_rs_cbal);
                            $row_rs_cbal = mysqli_fetch_array($result_rs_cbal);


                            if (is_null($row_rs_sal["S_TOT"]) == false) {
                                $sale = $sale + $row_rs_sal["S_TOT"];
                            }
                            if (is_null($row_rs_cbal["G_TOT"]) == false) {
                                $grn = $grn + $row_rs_cbal["G_TOT"];
                            }
                        }

                        $m = $m - 1;
                    }
                    $Text47 = number_format(($sale + $grn), 2, ".", ",");
                    $Text54 = number_format($dgrn, 2, ".", ",");
                }
                ?>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td width="410" align="center">    </td>
                    <td colspan="2" align="center"></td>
                </tr>
                <tr>
                    <th colspan="4" scope="col" align="center"><table width="800" border="1" cellpadding="0" cellspacing="0">
                            <tr>
                                <th scope="col" width="200">Ref No</th>
                                <th scope="col" width="200">Claim No</th>
                                <th scope="col" width="200">Date of Claim</th>
                                <th scope="col" width="200">Recieved Date</th>
                            </tr>
                            <tr>
                                <td align="center"><?php echo $row_rsPrInv["refno"]; ?></td>
                                <td align="center"><?php echo $row_rsPrInv["cl_no"]; ?></td>
                                <td align="center"><?php if ($row_rsPrInv["entdate"] != "0000-00-00") {
                    echo $row_rsPrInv["entdate"];
                } ?></td>
                                <td align="center"><?php
                if ($row_rsPrInv["recieve_date"] != "0000-00-00") {
                    echo $row_rsPrInv["recieve_date"];
                } else {
                    echo $row_rsPrInv["entdate"];
                }
                ?></td>
                            </tr>
                        </table></th>
                </tr>
                <tr>
                    <td width="326">&nbsp;</td>
                    <td width="269">&nbsp;</td>
                    <td width="410">&nbsp;</td>
                    <td width="233">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4"><table width="1000" border="1" cellspacing="0" cellpadding="0">
                            <tr>
                                <th scope="col" width="500">Dealer</th>
                                <th scope="col" width="500">Customer</th>
                            </tr>
                            <tr>
                                <td><table width="500" border="0">
                                        <tr>
                                            <td width="111" scope="col">Code</th>
                                                <td width="359" scope="col"><?php echo $row_rsPrInv["ag_code"]; ?></th>          </tr>
                                                    <tr>
                                                        <td>Name</td>
                                                        <td><?php echo $row_rsPrInv["ag_name"]; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Address</td>
                                                        <td rowspan="2" valign="top"><?php echo $row_rsPrInv["agadd"]; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    </table></td>
                                                <td><table width="500" border="0">
                                                        <tr>
                                                            <td width="359" scope="col"><?php echo $row_rsPrInv["cus_name"]; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo $row_rsPrInv["cus_add"]; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table></td>
                                        </tr>
                                    </table></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td colspan="4"><table width="1000" border="1" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <th scope="col" width="200">Stk No</th>
                                            <th scope="col" width="400">Description</th>
                                            <th scope="col" width="200">Brand</th>
                                            <th scope="col" width="200">Serial No</th>
                                        </tr>
                                        <tr>
                                            <td align="center"><?php echo $row_rsPrInv["stk_no"]; ?></td>
                                            <td><?php echo $row_rsPrInv["des"]; ?></td>
                                            <td align="center"><?php echo $row_rsPrInv["brand"]; ?></td>
                                            <td align="center"><?php echo $row_rsPrInv["seri_no"]; ?></td>
                                        </tr>
                                    </table></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4"><table width="1000" border="0">
                                        <tr>
                                            <td width="239" scope="col" align="center">Technical Observation :</td>
                                            <td width="751" rowspan="2" scope="col" align="left" valign="top"><?php echo $row_rsPrInv["tc_ob"]; ?></td>
                                        </tr>
                                        <tr>
                                            <td align="center"><span class="style2">
<?php
if ($rtxtrefund == "Recommended / Accepted") {
    echo "ACCEPTED";
}

if ($rtxtrefund == "Not Recommended / Rejected") {
    echo "REJECTED";
}
?>
                                                </span></td>
                                        </tr>

                                    </table></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4"><table width="1000" border="0">
                                        <tr>
                                            <th width="801" rowspan="4" scope="col"><table width="800" border="1" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <th colspan="6" scope="col">N.S.D</th>
                                                        <th scope="col">RTD %</th>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">Remaining</td>
                                                        <td><?php echo $row_rsPrInv["remin1"]; ?></td>
                                                        <td><?php echo $row_rsPrInv["remin2"]; ?></td>
                                                        <td><?php echo $row_rsPrInv["remin3"]; ?></td>
                                                        <td><?php echo $row_rsPrInv["remin4"]; ?></td>
                                                        <td><?php echo $row_rsPrInv["remin5"]; ?></td>
                                                        <td rowspan="2"><?php echo $row_rsPrInv["rem_per"]; ?> %</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">Spec</td>
                                                        <td><?php echo $row_rsPrInv["origin1"]; ?></td>
                                                        <td><?php echo $row_rsPrInv["origin2"]; ?></td>
                                                        <td><?php echo $row_rsPrInv["origin3"]; ?></td>
                                                        <td><?php echo $row_rsPrInv["origin4"]; ?></td>
                                                        <td><?php echo $row_rsPrInv["origin5"]; ?></td>
                                                    </tr>
                                                </table></th>
                                            <th scope="col"><?php if ($_GET["Prn_md"] == "true") {
    echo "Commercially Allowed";
} ?></th>
                                        </tr>
                                        <tr>
                                            <th width="189" scope="col">&nbsp;</th>
                                        </tr>
                                        <tr>
                                            <td><?php if ($_GET["Prn_md"] == "true") {
    echo "___________________________";
} ?></td>
                                        </tr>
                                        <tr>
                                            <td align="center"><?php if ($_GET["Prn_md"] == "true") {
    echo "Managing Director";
} ?></td>
                                        </tr>
                                    </table></td>
                            </tr>
                            <tr>
                                <td>Refund :</td>
                                <td><?php echo $rtxtrefund; ?></td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Commercialy: <?php echo $rtxcomm; ?></td>
                                <td>
<?php
if ($_GET["Prn_md"] == "true") {
    if ($rtxcomm == "Allowed") {
        echo "Approved By " . $row_rsPrInv["approve_md_wd"];
    }
}
?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="left">Management Observation :</td>
                                <td colspan="3" rowspan="3" align="left" valign="top"><?php echo $row_rsPrInv["Mn_ob"]; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td height="44">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Enclosed Credit Note No :</td>
                                <td colspan="3" rowspan="3"><table width="800" border="0">
                                        <tr>
                                            <td scope="col" width="208"><?php echo $rtxdefno; ?></td>
                                            <td scope="col" width="190">Date : <?php echo $rtxdefdate; ?></td>
                                            <td scope="col" width="118">&nbsp;</td>
                                            <td scope="col" width="118">Amount Rs :</td>
                                            <td scope="col" width="144"><?php echo $rtxdefamou; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $rtxdefno2; ?></td>
                                            <td>Date : <?php echo $rtxdefdate2; ?></td>
                                            <td>&nbsp;</td>
                                            <td>Amount Rs :</td>
                                            <td><?php echo $rtxdefamou2; ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $rtxdefno3; ?></td>
                                            <td>Date :  <?php echo $rtxdefdate3; ?></td>
                                            <td>&nbsp;</td>
                                            <td>Amount Rs :</td>
                                            <td><?php echo $rtxdefamou3; ?></td>
                                        </tr>
                                    </table></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>Gate Pass Date:</td>
                                <td><?php if ($row_rsPrInv["gatepass"] != "0000-00-00") {
                                        echo $row_rsPrInv["gatepass"];
                                    } ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>Return Date :</td>
                                <td><?php if ($row_rsPrInv["returndate"] != "0000-00-00") {
                                        echo $row_rsPrInv["returndate"];
                                    } ?></td>
                            </tr>
                            <tr>
                                <td colspan="4">

                                    <?php
                                    if ($_GET["Prn_md"] == "true") {
                                        echo "<table width=\"1000\" border=\"0\">
      <tr>
        <th width=\"669\" align=\"left\" scope=\"col\">* Last 6 Month Total Sales : " . $Text47 . "</th>
        <th width=\"321\" rowspan=\"3\" scope=\"col\"><table width=\"350\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
          <tr>
            <th scope=\"col\" width=\"200\" align=\"left\" >Date sold to Dealer</th>
            <th scope=\"col\">&nbsp;</th>
          </tr>
          <tr>
            <td align=\"left\" >Date sold to Customer</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align=\"left\" >Date returned to Company</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align=\"left\" >Period of use</td>
            <td>&nbsp;</td>
          </tr>
        </table></th>
      </tr>
      <tr>
        <td><table width=\"700\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
          <tr>
            <th width=\"238\" rowspan=\"2\" scope=\"col\">Previous months <br />
              Commercial Claim<br />
              Amount</th>
            <th width=\"120\" scope=\"col\">" . $Text48 . "</th>
            <th width=\"120\" scope=\"col\">" . $Text49 . "</th>
            <th width=\"120\" scope=\"col\">" . $Text50 . "</th>
            <th width=\"120\" scope=\"col\">Total</th>
          </tr>
          <tr>
            <td align=\"center\">" . $Text51 . "</td>
            <td align=\"center\">" . $Text52 . "</td>
            <td align=\"center\">" . $Text53 . "</td>
            <td align=\"center\">" . $Text54 . "</td>
          </tr>
          
          
        </table></td>
        </tr>
      <tr>
        <td><table width=\"700\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
          <tr>
            <th width=\"238\" scope=\"col\">Price</th>
            <th width=\"120\" scope=\"col\">Discount</th>
            <th width=\"120\" scope=\"col\">Net Value</th>
            <th width=\"120\" scope=\"col\">RTD %</th>
            <th width=\"120\" scope=\"col\">Refund Value</th>
          </tr>
          <tr>
            <th width=\"238\" scope=\"col\">&nbsp;</th>
            <td align=\"center\"></td>
            <td align=\"center\"></td>
            <td align=\"center\"></td>
            <td align=\"center\"></td>
          </tr>
          
        </table></td>
      </tr>
    </table>";
                                    }
                                    ?></td>
                            </tr>
                            <tr>
                                <td colspan="4">Note Well : The Company reserve the right to destroy Non Refundable rejected tyres/tubes that are not removed within 30 days from the date here of</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="2">* This is a Computer Genarated report which does not carry a signature</td>
                            </tr>
                            <tr>
                                <td><?php echo date("Y-m-d"); ?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                        </body>
                        </html>

<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Print Advance Commission</title>
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
                font-size: 22px;
            }

            .heading {
                color: #000000;
                font-weight: bold;
                font-size: 20px;
            }

            body {
                color: #000000;
                font-size: 14px;
            }
            .style1 {
                font-size: 18px;
                font-weight: bold;
            }


            -->
        </style>
    </head>

    <body><center>
            <?php
            require_once("connectioni.php");




            $mtyre = 0;
            $mbattery = 0;
            $malloy = 0;
            $mtube = 0;
            $mtyre_com = 0;
            $mbattery_com = 0;
            $malloy_com = 0;
            $mtube_com = 0;
            $i = 1;

            while ($_GET["mgridcount"] > $i) {

                $msgrid1 = "msgrid1_" . $i;
                $msgrid2 = "msgrid2_" . $i;
                $msgrid3 = "msgrid3_" . $i;
                $msgrid4 = "msgrid4_" . $i;
                $msgrid5 = "msgrid5_" . $i;
                $msgrid6 = "msgrid6_" . $i;

                $sql_rsbrand = "Select * from brand_mas where barnd_name = '" . trim($_GET[$msgrid1]) . "' ";
                $result_rsbrand = mysqli_query($GLOBALS['dbinv'], $sql_rsbrand);
                if ($row_rsbrand = mysqli_fetch_array($result_rsbrand)) {

                    $msgrid5_val = str_replace(",", "", $_GET[$msgrid5]);
                    $msgrid6_val = str_replace(",", "", $_GET[$msgrid6]);

                    if ($row_rsbrand["class"] == "TYRE") {
                        $mtyre = $mtyre + $msgrid5_val;
                    }
                    if ($row_rsbrand["class"] == "BATTERY") {
                        $mbattery = $mbattery + $msgrid5_val;
                    }
                    if ($row_rsbrand["class"] == "ALLOY WHEEL") {
                        $malloy = $malloy + $msgrid5_val;
                    }
                    if ($row_rsbrand["class"] == "TUBE") {
                        $mtube = $mtube + $msgrid5_val;
                    }

                    if ($row_rsbrand["class"] == "TYRE") {
                        $mtyre_com = $mtyre_com + $msgrid6_val;
                    }
                    if ($row_rsbrand["class"] == "BATTERY") {
                        $mbattery_com = $mbattery_com + $msgrid6_val;
                    }
                    if ($row_rsbrand["class"] == "ALLOY WHEEL") {
                        $malloy_com = $malloy_com + $msgrid6_val;
                    }
                    if ($row_rsbrand["class"] == "TUBE") {
                        $mtube_com = $mtube_com + $msgrid6_val;
                    }
                }

                $i = $i + 1;
            }


            $year = substr($_GET["dtMonth"], 0, 4);
            $month = substr($_GET["dtMonth"], 5, 2);

            $mrefno = $month . "/" . $year . "-" . substr($_GET["cmbrep"], 0, 2) . "-" . $_GET["cmbdev"];

            $sql_rss_commadva = "select * from s_commadva where FLAG='ADV' AND refno='" . $mrefno . "' ";
            $result_rss_commadva = mysqli_query($GLOBALS['dbinv'], $sql_rss_commadva);
            if ($row_rss_commadva = mysqli_fetch_array($result_rss_commadva)) {


                $sale = $mtyre + $mbattery + $malloy + $mtube;
            } else {

                $sale = $mtyre + $mbattery + $malloy + $mtube;
            }


            $row_rspara = "select * from invpara";
            $result_rspara = mysqli_query($GLOBALS['dbinv'], $row_rspara);
            $row_rspara = mysqli_fetch_array($result_rspara);

            $txtrepono = " " . date("Y-m-d") . "  " . date("H:m:s");


            $sql_rss_salrep = "select * from s_salrep where REPCODE='" . $_GET["cmbrep"] . "'";
            $result_rss_salrep = mysqli_query($GLOBALS['dbinv'], $sql_rss_salrep);
            if ($row_rss_salrep = mysqli_fetch_array($result_rss_salrep)) {
                $TXTREP = $row_rss_salrep["Name"];
            }

            $TXTCOM = $row_rspara["COMPANY"];
            $year = substr($_GET["dtMonth"], 0, 4);
            $month = $year . "-" . substr($_GET["dtMonth"], 5, 2) . "-01";

            $txtmon = $year . "/" . date("M", strtotime($month));
            $txttyre = "Tyre";
            $txtbattery = "Battery";
            $txtalloy = "Alloy Wheel";
            $txttube = "Tube";
            $Text5 = "Tyre";
            $Text6 = "Battery";
            $Text20 = "Alloy Wheel";
            $Text21 = "Tube";


            $txttyresale = $mtyre;
            $txtBatsale = $mbattery;
            $TxtAWsale = $malloy;
            $Txttubesale = $mtube;

            $Text22 = $mtyre * 50 / 100; //' 2;
            $Text23 = $mbattery *50 / 100;
            $Text24 = $malloy * 50 / 100;
            $Text25 = $mtube * 50 / 100;

            $Text26 = $mtyre_com * 50 / 100;
            $Text27 = $mbattery_com * 50 / 100;
            $Text28 = $malloy_com * 50 / 100;
            $Text29 = $mtube_com * 50 / 100;


            $txtretcheq_val = str_replace(",", "", $_GET["txtretcheq"]);
            $txtover60_val = str_replace(",", "", $_GET["txtover60"]);
            $txtretioded_val = str_replace(",", "", $_GET["txtretioded"]);

            $txtout = $txtretcheq_val + $txtover60_val;
            $Text40 = $_GET["TXTADJ"];
            $txtoutper = $_GET["TXTRATO"];
            $txtoutamou = $txtretioded_val * -1;
            $txttotcom = $_GET["txtadvance"];
            $txtroucom = $_GET["txtad"];

            $Text9 = $_GET["txtded1"];
            $Text13 = $_GET["txtded2"];
            $Text14 = $_GET["txtded3"];
            $Text15 = $_GET["txtded4"];
            $Text30 = $_GET["txtded5"];
            $Text42 = $_GET["txtded6"];
            $Text43 = $_GET["txtded7"];
            $Text44 = $_GET["txtded8"];

            $txtdedamou1_val = str_replace(",", "", $_GET["txtdedamou1"]);
            $txtdedamou2_val = str_replace(",", "", $_GET["txtdedamou2"]);
            $txtdedamou3_val = str_replace(",", "", $_GET["txtdedamou3"]);
            $txtdedamou4_val = str_replace(",", "", $_GET["txtdedamou4"]);
            $txtdedamou5_val = str_replace(",", "", $_GET["txtdedamou5"]);
            $txtdedamou6_val = str_replace(",", "", $_GET["txtdedamou6"]);
            $txtdedamou7_val = str_replace(",", "", $_GET["txtdedamou7"]);
            $txtdedamou8_val = str_replace(",", "", $_GET["txtdedamou8"]);


            if (($txtdedamou1_val != "") and ($txtdedamou1_val != 0)) {
                $Text31 = $txtdedamou1_val * -1;
            }
            if (($txtdedamou2_val != "") and ($txtdedamou2_val != 0)) {
                $Text32 = $txtdedamou2_val * -1;
            }
            if (($txtdedamou3_val != "") and ($txtdedamou3_val != 0)) {
                $Text33 = $txtdedamou3_val * -1;
            }
            if (($txtdedamou4_val != "") and ($txtdedamou4_val != 0)) {
                $Text34 = $txtdedamou4_val * -1;
            }
            if (($txtdedamou5_val != "") and ($txtdedamou5_val != 0)) {
                $Text16 = $txtdedamou5_val * -1;
            }
            if (($txtdedamou6_val != "") and ($txtdedamou6_val != 0)) {
                $Text45 = $txtdedamou6_val * -1;
            }
            if (($txtdedamou7_val != "") and ($txtdedamou7_val != 0)) {
                $Text46 = $txtdedamou7_val * -1;
            }
            if (($txtdedamou8_val != "") and ($txtdedamou8_val != 0)) {
                $Text47 = $txtdedamou8_val * -1;
            }

            $txtcommi = $_GET["Txtadva"];
            ?>

            <table width="700" border="0">
                <tr>
                    <td height="70" colspan="5" align="center"><span class="companyname"><?php echo $row_rspara["COMPANY"]; ?></span></td>
                </tr>
                <tr>
                    <td height="37" colspan="5" align="left"><span class="com_address"><?php echo $TXTREP; ?></span></td>
                </tr>
                <?php
//echo $_GET["invno"];

                $sql = "Select * from s_purmas where REFNO='" . $_GET["invno"] . "'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                $row = mysqli_fetch_array($result);

                $sql1 = "Select * from vendor where CODE='" . $row["SUP_CODE"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                $row1 = mysqli_fetch_array($result1);

                $sql2 = "Select * from viewarn where REFNO='" . $_GET["invno"] . "' order by ID";
//echo $sql2;
                $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                ?>
                <tr>
                    <td><span class="style1">Sales Commission Allowance for</span></td>
                    <td colspan="3"><span class="style1"><?php echo $txtmon; ?></span></td>
                </tr>
                <tr>
                    <th colspan="3" scope="col">&nbsp;</th>
                    <th align="center" >Commission</th>
                </tr>
                <tr>
                    <td width="217"><span class="style1">Nett Sales</span></td>
                    <td align="left" width="186"><?php echo $txttyre; ?></td>
                    <td align="right" width="126"><?php echo number_format($txttyresale, 2, ".", ","); ?></td>
                    <td align="right" width="153"><?php echo number_format($Text26, 2, ".", ","); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left"><?php echo $txtbattery; ?></td>
                    <td align="right"><?php echo number_format($txtBatsale, 2, ".", ","); ?></td>
                    <td align="right"><?php echo number_format($Text27, 2, ".", ","); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left"><?php echo $txtalloy; ?></td>
                    <td align="right"><?php echo number_format($TxtAWsale, 2, ".", ","); ?></td>
                    <td align="right"><?php echo number_format($Text28, 2, ".", ","); ?></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td align="left"><?php echo $txttube; ?></td>
                    <td align="right"><?php echo number_format($Txttubesale, 2, ".", ","); ?></td>
                    <td align="right"><?php echo number_format($Text29, 2, ".", ","); ?></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="2"><span class="style1">Return Chqs &amp; Outstanding</span></td>
                    <td align="right"><?php echo $txtout; ?></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2"><span class="style1">Return Chqs & Outstanding - Adjustment</span></td>
                    <td align="right"> <?php echo $Text40; ?></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">Return Chqs &amp; Outstanding - % &amp; Deduct Amount </td>
                    <td align="right"><?php echo $txtoutper . " %"; ?></td>
                    <td align="right"><?php echo $txtoutamou; ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><span class="style1">_________________</span></td>
                </tr>
                <tr>
                    <td colspan="2"><span class="style1">Total for Commission Allowance</span></td>
                    <td>&nbsp;</td>
                    <td align="right"><?php echo $txttotcom; ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>===================</td>
                </tr>
                <tr>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18"><?php echo $txtroucom; ?></td>
                </tr>
                <tr>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left" height="18"><span class="style1">Less</span></td>
                    <td align="left" height="18"><?php echo $Text9; ?></td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18"><?php echo $Text31; ?></td>
                </tr>
                <tr>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="left" height="18"><?php echo $Text13; ?></td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18"><?php echo $Text32; ?></td>
                </tr>
                <tr>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="left" height="18"><?php echo $Text14; ?></td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18"><?php echo $Text33; ?></td>
                </tr>
                <tr>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="left" height="18"><?php echo $Text15; ?></td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18"><?php echo $Text34; ?></td>
                </tr>
                <tr>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="left" height="18"><?php echo $Text30; ?></td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18"><?php echo $Text16; ?></td>
                </tr>
                <tr>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="left" height="18"><?php echo $Text42; ?></td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18"><?php echo $Text45; ?></td>
                </tr>
                <tr>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="left" height="18"><?php echo $Text43; ?></td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18"><?php echo $Text46; ?></td>
                </tr>
                <tr>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="left" height="18"><?php echo $Text44; ?></td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18"><?php echo $Text47; ?></td>
                </tr>
                <tr>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18"><span class="style1">_________________</span></td>
                </tr>
                <tr>
                    <td height="18" colspan="2" align="left"><span class="style1">Total Commission Advance Payable</span></td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18"><span class="style1"><?php echo $txtcommi; ?></span></td>
                </tr>
                <tr>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">===================</td>
                </tr>
                <tr>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">&nbsp;</td>
                    <td align="right" height="18">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right" height="46" colspan="4"><?php echo $Text38; ?></td>
                </tr>
                <tr>
                    <td height="40">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Prepared By:</td>
                    <td>&nbsp;</td>
                    <td>Authorized By:</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Prepared Date: <?php echo $Text36; ?></td>
                    <td>&nbsp;</td>
                    <td>Authorized Date:</td>
                    <td><?php echo $Text37; ?></td>
                </tr>
                <tr>
                    <td><?php echo $txtrepono; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
<!--                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>-->
            </table>
    </body>
</html>

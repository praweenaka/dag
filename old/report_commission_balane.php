<?php
session_start();
date_default_timezone_set('Asia/Colombo');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Print Balance Commission</title>
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
                font-size: 16px;
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

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);


////////////////
            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");


            $txtcom = $row_head["COMPANY"];
            $txtrep = $_GET["cmbrep"];
            $txtmonth = date("M", strtotime($_GET["dtMonth"])) . " / " . date("Y", strtotime($_GET["dtMonth"]));


            $a = str_replace(",", "", $_GET["txtComSale"]);
            $b = str_replace(",", "", $_GET["txtAdd"]);

            $txtComSale = $a + $b;

            $txtComGRN = str_replace(",", "", $_GET["txtComGRN"]);
            $txtcomRetCh = str_replace(",", "", $_GET["txtretch"]);
            $txtBalCom = str_replace(",", "", $_GET["txtComBal"]) + str_replace(",", "", $_GET["txtAdd"]);
            $txtdev = $_GET["cmbdev"];
            $txtAdd = "Sp. Addition";
            $txtaddAmt = str_replace(",", "", $_GET["txtAdd"]);
//==========================================================================================

            $sql_tmp = "delete from tmpcomprint";
            $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);

            /* 	For i = 0 To MSHFlexGrid1.Rows - 1
              DNUSER.CONUSER.Execute "insert into TmpComPrint (type,amt) values ('" & MSHFlexGrid1.TextMatrix(i, 0) & "','" & MSHFlexGrid1.TextMatrix(i, 1) & "') "
              Next i- */

            $sql_tmp = "select * from tmpcomprint";
            $result_tmp = mysqli_query($GLOBALS['dbinv'], $sql_tmp);
            $row_tmp = mysqli_fetch_array($result_tmp);

            $nosale = str_replace(",", "", $_GET["txtnetsale"]) - str_replace(",", "", $_GET["txtcat1sale"]) - str_replace(",", "", $_GET["txtcat1Spsale"]) - str_replace(",", "", $_GET["txtcat2sale"]);

            $txtnetsale = str_replace(",", "", $_GET["txtnetsale"]);
            $txtcat1sale = str_replace(",", "", $_GET["txtcat1sale"]);
            $txtnetsale = str_replace(",", "", $_GET["txtnetsale"]);
            $txtcat1Spsale = str_replace(",", "", $_GET["txtcat1Spsale"]);
            $txtcat2sale = str_replace(",", "", $_GET["txtcat2sale"]);


            if ($txtnetsale > 0) {
                $pr1 = $txtcat1sale / $txtnetsale * 100;
            }
            if ($txtnetsale > 0) {
                $pr2 = $txtcat1Spsale / $txtnetsale * 100;
            }
            if ($txtnetsale > 0) {
                $pr3 = $txtcat2sale / $txtnetsale * 100;
            }
            if ($txtnetsale > 0) {
                $pr4 = $nosale / $txtnetsale * 100;
            }

            $txtsale1 = $txtcat1sale;
            $txtsale2 = $txtcat1Spsale;
            $txtsale3 = $txtcat2sale;
            $txtsale4 = $nosale;

            $txtpr4 = $_GET["txtpre"] . " %";

            $txtcat1Com = str_replace(",", "", $_GET["txtcat1Com"]);
            $txtcat1Spcomm = str_replace(",", "", $_GET["txtcat1Spcomm"]);
            $txtcat2com = str_replace(",", "", $_GET["txtcat2com"]);
            $txtNoCom_COm = str_replace(",", "", $_GET["txtNoCom_COm"]);

            $txtComsale1 = $txtcat1Com;
            $txtComsale2 = $txtcat1Spcomm;
            $txtComsale3 = $txtcat2com;
            $txtNoComCOm = $txtNoCom_COm;

            $txtded1 = str_replace(",", "", $_GET["txtdedamt1"]);
            $txtded2 = str_replace(",", "", $_GET["txtdedamt2"]);
            $txtded3 = str_replace(",", "", $_GET["txtdedamt3"]);
            $txtded4 = str_replace(",", "", $_GET["txtdedamt4"]);
            $txtded5 = str_replace(",", "", $_GET["txtdedamt5"]);

            $txtdes1 = $_GET["txtdes1"] . "  " . $_GET["txtpr"] . " %";
            $txtdes2 = $_GET["txtdes2"];
            $txtdes3 = $_GET["txtdes3"];
            $txtdes4 = $_GET["txtdes4"];
            $txtdes5 = $_GET["txtdes5"];

            if ($_GET["cmbdev"] == "1") {
                $txtrtn = $_GET["txtRetChkAmou_D1"];
            } else {
                $txtrtn = $_GET["txtRetChkAmou_Do"];
            }

            $txtgrn = $_GET["txtret"];

            $txtComBal = str_replace(",", "", $_GET["txtComBal"]);

            $netamt = str_replace(",", "", $_GET["txtComBal"]) + str_replace(",", "", $_GET["txtAdd"]);
            $netamt = $netamt - str_replace(",", "", $_GET["txtdedamt1"]);
            $netamt = $netamt - str_replace(",", "", $_GET["txtdedamt2"]);
            $netamt = $netamt - str_replace(",", "", $_GET["txtdedamt3"]);
            $netamt = $netamt - str_replace(",", "", $_GET["txtdedamt4"]);
            $netamt = $netamt - str_replace(",", "", $_GET["txtdedamt5"]);

            $txtnet = number_format($netamt, 2, ".", ",");

//////////////

            $txtcommi = $_GET["Txtadva"];
            ?>



            <?php echo $txtdev; ?>
            <table width="770" border="0">
                <tr>
                    <td colspan="5" align="center"><span class="companyname"><?php echo $txtcom; ?></span></td>
                </tr>
                <tr><td><span class="com_address">Marketing Rep/Executive </td>
                    <?php
                    $sql_rep = "select * from s_salrep where REPCODE=" . $txtrep;
                    $result_rep = mysqli_query($GLOBALS['dbinv'], $sql_rep);
                    $row_rep = mysqli_fetch_array($result_rep);
                    ?>
                    <td colspan="4" align="left"><span class="com_address"><?php echo $row_rep["Name"]; ?></span></td>
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
                    <td><span class="style1">Month</span></td>
                    <td colspan="3"><span class="style1"><?php echo $txtmonth; ?></span></td>
                </tr>

                <tr>
                    <th colspan="2" scope="col">&nbsp;</th>
                    <th align="center" ></th>
                    <th align="center" ></th>
                </tr>
                <tr>
                    <tr>
                        <th colspan="2" scope="col">&nbsp;</th>
                        <th align="center" >Sales</th>
                        <th align="center" >Commission</th>
                    </tr>
                    <tr>






                        <?php // echo number_format($Text26, 0, ".", ",");  ?>
                        <td width="281">Category 1</td>
                        <td align="center" width="182"></td>
                        <td align="right" width="122"><?php
                            if ($txtsale1 != "") {
                                echo number_format($txtsale1, 2, ".", ",");
                            }
                            ?></td>
                        <td align="right" width="167"><?php
                            if ($txtComsale1 != "") {
                                echo number_format($txtComsale1, 2, ".", ",");
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <td>Category 1 (Over 60)</td>
                        <td align="center"></td>
                        <td align="right"><?php
                            if ($txtsale2 != "") {
                                echo number_format($txtsale2, 2, ".", ",");
                            }
                            ?></td>
                        <td align="right"><?php
                            if ($txtComsale2 != "") {
                                echo number_format($txtComsale2, 2, ".", ",");
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <td>Category 2</td>
                        <td align="center"></td>
                        <td align="right"><?php
                            if ($txtsale3 != "") {
                                echo number_format($txtsale3, 2, ".", ",");
                            }
                            ?></td>
                        <td align="right"><?php
                            if ($txtComsale3 != "") {
                                echo number_format($txtComsale3, 2, ".", ",");
                            }
                            ?></td>
                    </tr>

                    <tr>
                        <td><?php echo $txtAdd; ?></td>
                        <td align="center"></td>
                        <td align="right"></td>
                        <td align="right"><?php echo $txtaddAmt; ?></td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>



                    <tr>
                        <td colspan="2">&nbsp;</td>

                        <td  align="right"></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><span class="style1">No Commission</span></td>
                        <td><?php echo number_format($txtpr4, 2, ".", ","); ?>%</td>
                        <td  align="right"><b>
                                <?php
                                $txtnetsale = str_replace(",", "", $_GET['txtnetsale']);
                                $txtcat1sale = str_replace(",", "", $_GET['txtcat1sale']);
                                $txtcat1Spsale = str_replace(",", "", $_GET['txtcat1Spsale']);
                                $txtcat2sale = str_replace(",", "", $_GET['txtcat2sale']);
                                $nosale = $txtnetsale - $txtcat1sale - $txtcat1Spsale - $txtcat2sale;
                                ?>          
                                <?php
                                if ($txtsale4 != "") {
                                    echo number_format($txtsale4, "2", ".", ",");
                                }
                                ?>                    </b>    </td>
                        <td  align="right"><?php
                            if ($txtNoComCOm != "") {
                                echo number_format($txtNoComCOm, 2, ".", ",");
                            }
                            ?></td>
                    </tr>

                    <tr>
                        <td width="281">&nbsp;</td>
                        <td align="center" width="182"><span class="style1"><?php echo $txttyre; ?></span></td>
                        <td align="right" width="122"><?php
                            if ($txttyresale != "") {
                                echo number_format($txttyresale, 0, ".", ",");
                            }
                            ?></td>
                        <td align="right" width="167"><?php
                            if ($Text26 != "") {
                                echo number_format($Text26, 0, ".", ",");
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td align="center"><span class="style1"><?php echo $txtbattery; ?></span></td>
                        <td align="right"><?php
                            if ($txtBatsale != "") {
                                echo number_format($txtBatsale, 0, ".", ",");
                            }
                            ?></td>
                        <td align="right"><?php
                            if ($Text27 != "") {
                                echo number_format($Text27, 0, ".", ",");
                            }
                            ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td align="center"><span class="style1"><?php echo $txtalloy; ?></span></td>
                        <td align="right"><?php
                            if ($TxtAWsale != "") {
                                echo number_format($TxtAWsale, 0, ".", ",");
                            }
                            ?></td>
                        <td align="right"><?php
                            if ($Text28 != "") {
                                echo number_format($Text28, 0, ".", ",");
                            }
                            ?></td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td align="center"><span class="style1"><?php echo $txttube; ?></span></td>
                        <td align="right"><?php
                            if ($Txttubesale != "") {
                                echo number_format($Txttubesale, 0, ".", ",");
                            }
                            ?></td>
                        <td align="right"><?php
                            if ($Text29 != "") {
                                echo number_format($Text29, 0, ".", ",");
                            }
                            ?></td>
                    </tr>    




                    <tr>
                        <td colspan="2"><span class="style1">Gross Sales Commission</span></td>
                        <td align="right">&nbsp;</td>
                        <td align="right"><span class="style1"><?php
                                if ($txtComSale != "") {
                                    echo number_format($txtComSale, 2, ".", ",");
                                }
                                ?></span></td>
                    </tr>

                    <tr>
                        <td colspan="2"><span class="style1">&nbsp;</span></td>
                        <td align="right">&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>    

                    <tr>
                        <td colspan="2">Less Comm. For GRN</td>
                        <td align="right"> <?php
                            if ($txtgrn != "") {
                                echo $txtgrn;
                            }
                            ?></td>
                        <td align="right">(<?php
                            if ($txtComGRN != "") {
                                echo number_format($txtComGRN, 2, ".", ",");
                            }
                            ?>)</td>
                    </tr>



                    <tr>
                        <td colspan="2">Less Comm. For Return Cheque</td>
                        <td align="right"><?php
                            if ($txtrtn != "") {
                                echo $txtrtn;
                            }
                            ?></td>
                        <td align="right">(<?php
                            if ($txtcomRetCh != "") {
                                echo number_format($txtcomRetCh, 2, ".", ",");
                            }
                            ?>)</td>
                    </tr>

                    <tr>
                        <td colspan="2">Balance Commission</td>
                        <td align="right">&nbsp;</td>
                        <td align="right"><span class="style1"><?php
                                if ($txtBalCom != "") {
                                    echo number_format($txtBalCom, 2, ".", ",");
                                }
                                ?></span></td>
                    </tr>      

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>


                    <tr>
                        <td><span class="style1">Deductions</span></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>    

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>     

                    <tr>
                        <td><?php echo $txtdes1; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td  align="right"><?php
                            if ($txtded1 != "") {
                                echo "(" . number_format($txtded1, 2, ".", ",") . ")";
                            }
                            ?> </td>
                    </tr>

                    <tr>
                        <td><?php echo $txtdes2; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td  align="right"><?php
                            if ($txtded2 != "") {
                                echo "(" . number_format($txtded2, 2, ".", ",") . ")";
                            }
                            ?></td>
                    </tr>    

                    <tr>
                        <td><?php echo $txtdes3; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td  align="right"><?php
                            if ($txtded3 != "") {
                                echo "(" . number_format($txtded3, 2, ".", ",") . ")";
                            }
                            ?></td>
                    </tr>    

                    <tr>
                        <td><?php echo $txtdes4; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td  align="right"><?php
                            if ($txtded4 != "") {
                                echo "(" . number_format($txtded4, 2, ".", ",") . ")";
                            }
                            ?></td>
                    </tr>                     

                    <tr>
                        <td><?php echo $txtdes5; ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td  align="right"><?php
                            if ($txtded5 != "") {
                                echo "(" . number_format($txtded5, 2, ".", ",") . ")";
                            }
                            ?> </td>
                    </tr> 


                    <tr>
                        <td><span class="style1">Balance Commission Payable</span> </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right"><span class="style1"><u><?php echo $txtnet; ?></u></span></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Checked By</td>
                        <td>&nbsp;</td>
                        <td>Authorized By:</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><?php echo $txtrepono; ?></td>
                        <td>&nbsp;</td>
                        <td>Approved By:</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
            </table>
    </body>
</html>

<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Print Invoice</title>
        <style type="text/css">
            <!--
            .style2 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 15px;
            }
            -->
        </style>
    </head>

    <body><center>
            <?php
            require_once("connectioni.php");



            $sql = "SELECT * from view_quomas_quotrn_s_mas where REF_NO= '" . trim($_GET["invno"]) . "'   ";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $row = mysqli_fetch_array($result);

            $sql_para = "Select * from invpara ";
            $result_para = mysqli_query($GLOBALS['dbinv'], $sql_para);
            $row_para = mysqli_fetch_array($result_para);

            if ($_GET["Op_vat"] == "false") {
                $txtvatstatus = "Inclusive Of The VAT";
                $Text14 = "Vat No =" . $row_para["VAT"];
            } else {
                $txtvatstatus = "Exclusive Of The VAT";
            }
            $txtdes = $_GET["TXTREMARK"];
            $txthead = "QUOTATION FOR " . trim($_GET["COM_GROUPS"]);





            $sql = "Select * from s_quomas where REF_NO='" . $_GET["invno"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $row = mysqli_fetch_array($result);

            $sql1 = "Select * from vendor where CODE='" . $row["C_CODE"] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            $row1 = mysqli_fetch_array($result1);

            $sql2 = "Select * from s_quotrn where REF_NO='" . $_GET["invno"] . "'";
            $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
            $row2 = mysqli_fetch_array($result2);









            if ($row["VAT"] == "1") {
                $txtcusvat = "Customer VAT  " . $row1["vatno"];
                $txtcomvat = "VAT Reg. " . $row_para["VAT"];
                $RTXTVAT = "VAT " . $row_para ['vatrate'] . "%" ;
                $RTXVATAMU = $row["BTT"];
                $txttaxinv = "<b>TAX INVOICE</b>";
                $txtsubtot = $row["AMOUNT"];
                $txtsubtotdes = "Sub Total";
            }
            ?>

            <table width="922" height="434" border="0">
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td align="center"></td>
                    <td width="20" align="center"></td>
                    <td align="center"></td>
                    <td colspan="2" align="right"><strong>System Generated Quotation</strong></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td width="155" align="center">    </td>
                    <td align="center">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="right">Ref.No</td>
                    <td width="142"><span class="style2">
                            <?php
                            echo $_GET["invno"];
                            ?>
                        </span></td>
                </tr>

                <tr>

                    <td height="21" colspan="4"><span class="style2"><?php echo date("Y-m-d"); ?></span></td>
                    <td height="21">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>

                    <td colspan="4"><span class="style2"><?php
                            $txtCNAME = str_replace("~", "&", $row['CUS_NAME']);
                            echo $txtCNAME;
                            ?></span></td>
                    <td width="230"><span class="style2">&nbsp;&nbsp;</span></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>

                    <td height="21" colspan="4"><span class="style2"><?php
                            $cus_address = str_replace("~", "&", $_GET['cus_address']);
                            echo $cus_address;
                            ?></span></td>
                    <td height="21">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>

                    <td height="21" colspan="4"><span class="style2"</td>
                    <td height="21">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>


                <tr>

                    <td height="21" colspan="4"><span class="style2">Dear Sir/Madam,</span></td>
                    <td height="21">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>

                    <td height="21" colspan="4"><span class="style2"</td>
                    <td height="21">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>

                <tr>

                    <td height="21" colspan="4"><span class="style2"><b>Quotation For <?php echo $row['GROUPS']; ?></span></td>
                    <td height="21">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>

                <tr>
                    <td height="21">&nbsp;</td>
                    <td height="21" colspan="6"><span class="style2"><?php echo $_GET['TXTREMARK']; ?></span></td>

                </tr>

                <tr>
                    <td height="21">&nbsp;</td>
                    <td height="21" colspan="4"><span class="style2"</td>
                    <td height="21">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>

                <tr>
                    <td height="21" colspan="2">&nbsp;</td>
                    <td colspan="2"></td>
                    <td width="174">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td height="56" colspan="7"><table width="904" height="81" border="1" cellspacing="0">
                            <tr >
                                <td width="100" height="23"><span class="style1">STK No</span></td>
                                <td width="250"><span class="style1">Description</span></td>
                                <td width="180"><span class="style1">Brand Name</span></td>
                                <td width="100"><span class="style1">Rate</span></td>
                                <td width="100"><span class="style1">Quantity</span></td>

                                <td width="152"><span class="style1">Sub Total</span></td>
                            </tr>  
                            <?php
                            $i = 1;
                            $totsuntot = 0;

                            $sql1 = "Select * from s_quotrn where REF_NO='" . $_GET["invno"] . "'";
                            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);

                            while ($row1 = mysqli_fetch_array($result1)) {
                                $sql_part = "Select * from s_mas where STK_NO='" . $row1["STK_NO"] . "'";
                                $result_part = mysqli_query($GLOBALS['dbinv'], $sql_part);
                                $row_part = mysqli_fetch_array($result_part);


                                echo "<tr><td width=50><span class=\"style2\">" . $row1["STK_NO"] . "</span></td>
				<td width=400><span class=\"style2\">&nbsp;" . $row1["DESCRIPT"] . "</span></td>
				<td width=150><span class=\"style2\">" . $row_part["BRAND_NAME"] . "</span></td>";

                                $mprice = $discount1 = $row1["PRICE"] * $row1["DIS_per"] / 100;
                                $mprice = $row1["PRICE"] - $mprice;
                                echo "<td width=80 align=\"right\"><span class=\"style2\">" . number_format($mprice, 2, ".", ",") . "</span></td>
				<td width=50 align=\"right\"><span class=\"style2\">" . number_format($row1["QTY"], 0, ".", ",") . "</span></td>";

                                $discount1 = $row1["PRICE"] * $row1["QTY"] * $row1["DIS_per"] / 100;
                                $subtot = ($row1["PRICE"] * $row1["QTY"]) - $discount1;
                                echo "<td width=100 align=\"right\"><span class=\"style2\">" . number_format($subtot, 2, ".", ",") . "</span></td>
				</tr>";

                                $totsuntot = $totsuntot + $subtot;
                                $i = $i + 1;
                            }

                            if ($row["DIS1"] > 0) {
                                $txtspdis = "Special Discount   " . floatval($row["DIS1"]) . " %";
                            }

                            if ($row["VAT"] == "0") {
                                $txtdis2 = $totsuntot / 100 * $row["DIS1"];
                            } else {
                                $txtdis2 = (($totsuntot / (1 + $row["GST"] / 100)) / 100);
                            }
                            ?>


                        </table>



                    </td>
                </tr>
                <tr><td colspan="7" valign="top">
                        <table width="900" border="0">
						
						<?php 
						if ($RTXVATAMU >0) {
						?>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                <td colspan="3">&nbsp;</td>
                                <td align="right"><b>Sub Total</td>
                                <td align="right"><b><?php echo number_format($totsuntot, 2, ".", ","); ?></td>
                            </tr>
							 <tr>
                                <td colspan="2">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                <td colspan="3">&nbsp;</td>
                                <td align="right"><b>VAT</td>
                                <td align="right"><b><?php echo number_format($RTXVATAMU, 2, ".", ","); ?></td>
                            </tr>
						<?php } ?>	
							 <tr>
                                <td colspan="2">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="2">&nbsp;</td>
                                <td colspan="3">&nbsp;</td>
                                <td align="right"><b>Grand Total</td>
                                <td align="right"><b><?php echo number_format(($totsuntot+$RTXVATAMU), 2, ".", ","); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td height="21" colspan="6"><span class="style2">&nbsp;</span></td>
                </tr>
                <tr>
                    <td height="21" colspan="6"><span class="style2">&nbsp;</span></td>
                </tr>
                <tr>
                    <td height="21" colspan="6"><span class="style2">VAT No = 114195383 7000</span></td>
                </tr>

                <?php
                if ($row['Chk1'] == "1") {
                    ?>
                    <tr>
                        <td height="21" colspan="6"><span class="style2">Warranty = <?php echo $row['warranty']; ?></span></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td height="2" colspan="6"></td>
                </tr>
                <?php
                if ($row['chk2'] == "1") {
                    ?>
                    <tr>
                        <td height="21" colspan="6"><span class="style2">Delivery = Ex-Stock Subject To Prior Sale</span></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td height="2" colspan="6"></td>
                </tr>
                <?php
                if ($row['chk3'] == "1") {
                    ?>
                    <tr>
                        <td height="21" colspan="6"><span class="style2">Delivery = Import and Supply within = <?php echo $row['delivery']; ?></span></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td height="2" colspan="6"></td>
                </tr>
                <?php
                if ($row['chk4'] == "1") {
                    ?>
                    <tr>
                        <td height="21" colspan="6"><span class="style2">Payment Term = <?php echo $row['pay_type']; ?></span></td>
                    </tr>
                    <?php
                }
                ?> 
               <tr>
                    <td height="2" colspan="6"></td>
                </tr>
                <?php
                if ($row['chk5'] == "1") {
                    ?>
                    <tr>
                        <td height="21" colspan="6"><span class="style2">Price Validity = <?php echo $row['validity']; ?></span></td>
                    </tr>
                    <?php
                }
                ?> 
                 <tr>
                    <td height="2" colspan="6"></td>
                </tr>
                <?php
                if ($row['chk6'] == "1") {
                    ?>
                    <tr>
                        <td height="21" colspan="6"><span class="style2">Country of Origin = <?php echo $row['Country']; ?></span></td>
                    </tr>
                    <?php
                }
                ?> 
                 <tr>
                    <td height="2" colspan="6"></td>
                </tr>
                <?php
                if ($row['chk7'] == "1") {
                    ?>
                    <tr>
                        <td height="21" colspan="6"><span class="style2"> Milage Performance= <?php echo $row['Perform']; ?></span></td>
                    </tr>
                    <?php
                }
				//Government of Sri Lanka Taxes: <?php echo $row_para['vatrate']; % VAT shall added to the final amount.
                ?>  
                   <tr>
                    <td height="2" colspan="6"></td>
                </tr>
                   <tr>
                    <td height="2" colspan="6">&nbsp;</td>
                </tr>
                 <tr>
                    <td height="2" colspan="6">&nbsp;</td>
                </tr>
                 <tr>
                    <td height="2" colspan="6">&nbsp;</td>
                </tr>
                
                 <tr>
                    <td height="2" colspan="6">Thank You</td>
                </tr>
                  <tr>
                    <td height="2" colspan="6">&nbsp;</td>
                </tr>
                <tr>
                    <td height="2" colspan="6">Yours Faithfully,</td>
                </tr>
                <tr>
                    <td height="2" colspan="6"><b>TYRE HOUSE TRADING (PVT) LTD</b></td>
                </tr>
                 <tr>
                    <td height="2" colspan="6"><b>221 1/4, SRI SANGARAJA MAWATHA, COLOMBO - 10</b></td>
                </tr>
                <tr>
                    <td height="2" colspan="6"><b>Tel : 011-5445400, Fax - 011-2441693</b></td>
                </tr>
                   <tr>
                    <td height="2" colspan="6">&nbsp;</td>
                </tr>
                   <tr>
                    <td height="2" colspan="6">&nbsp;</td>
                </tr>
                   <tr>
                    <td height="2" colspan="6">&nbsp;</td>
                </tr>
                   <tr>
                    <td height="2" colspan="6">* This is a Computer generated quotation which does not carry signature
</td>
                </tr>
            </table>
    </body>
</html>

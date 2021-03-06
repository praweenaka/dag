<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Print GRN</title>
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
                font-size: 26px;
            }

            body {
                color: #000000;
                font-size: 16px;
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
            require_once ("connectioni.php");
            ?>

            <table width="902" height="428" border="0">

                <?php
                $sql_para = "Select * from invpara ";
                $result_para = mysqli_query($GLOBALS['dbinv'], $sql_para);
                $row_para = mysqli_fetch_array($result_para);

                $sql = "Select * from s_crnma where REF_NO='" . $_GET["invno"] . "'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                $row = mysqli_fetch_array($result);

                $sql1 = "Select * from vendor where CODE='" . $row["C_CODE"] . "'";
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                $row1 = mysqli_fetch_array($result1);

                $sql_bal = "Select * from c_bal where REFNO='" . $_GET["invno"] . "'";
                $result_bal = mysqli_query($GLOBALS['dbinv'], $sql_bal);
                $row_bal = mysqli_fetch_array($result_bal);

                $sql1 = "Select c_main as CODE,c_name as NAME,c_svatno  as svatno ,c_vatno as vatno,c_add as ADD1 from vender_sub where c_code='" . $row_bal["c_code1"] . "'";
                //echo $sql1;
                $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                if ($row1 = mysqli_fetch_array($result1)) {
                    
                } else {

                    $sql1 = "Select * from vendor where CODE='" . $row["C_CODE"] . "'";
                    $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
                    $row1 = mysqli_fetch_array($result1);
                }


                $sql2 = "Select * from s_crntrn where REF_NO='" . $_GET["invno"] . "'";
                $result2 = mysqli_query($GLOBALS['dbinv'], $sql2);
                ?>
                <tr>
                    <td colspan="2" scope="col"><?php
                echo "TYRE HOUSE TRADING (PVT) LTD.";
                ?></td>
                    <td scope="col">&nbsp;</td>
                    <td scope="col">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" scope="col">&nbsp;</td>
                    <td scope="col">&nbsp;</td>
                    <td scope="col">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3" scope="col"><span class="heading">Good Return Note</span></td>
                    <td scope="col">&nbsp;</td>
                    <td scope="col">&nbsp;</td>
                </tr>
                <tr>
                    <td scope="col">GRN No</td>
                    <td scope="col"><?php echo $row["REF_NO"]; ?></td>
                </tr>
                <tr>
                    <td scope="col">GRN Date</td>
                    <td scope="col"><?php echo $row["SDATE"]; ?></td>
                </tr>
                <tr>
                    <td width="187">Sales Reference - </td>
                    <td width="427"><?php echo $row["SAL_EX"]; ?></td>
                    <td width="108">Sto. Ref.</td>
                    <td width="192"><?php echo $row["stoRef"]; ?></td>
                </tr>
                <tr>
                    <td>Return By -</td>
                    <td><?php echo $row["C_CODE"] . " - " . $row1["NAME"]; ?></td>
                    <td>Invoice Date</td>
                    <td><?php echo $row["DDATE"]; ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><?php echo $row1["ADD1"] . ", " . $row1["ADD2"]; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>


                <tr>
                    <td colspan="4">
                        <table width="922" border="1" cellpadding="0" cellspacing="0"><tr><td colspan="3">
                                    <table width="922" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <th width="102" scope="col" align="left">Stk No</th>
                                            <th width="350" scope="col" align="left">Description</th>
                                            <th width="108" scope="col" align="left">Part No</th>
                                            <th width="107" scope="col" align="right">Rate</th>
                                            <th width="79" height="22" align="right">Qty</th>
                                            <th width="94" scope="col" align="right">D%</th>
                                            <th width="127" scope="col" align="right">Amount</th>
                                        </tr>
<?php
while ($row2 = mysqli_fetch_array($result2)) {

    echo "<tr>
        <td align=\"left\">" . $row2["STK_NO"] . "</td>
        <td align=\"left\">" . $row2["DESCRIPT"] . "</td>";

    $sql_stk = "Select * from s_mas where STK_NO='" . $row2["STK_NO"] . "'";
    $result_stk = mysqli_query($GLOBALS['dbinv'], $sql_stk);
    $row_stk = mysqli_fetch_array($result_stk);

    echo "<td  align=\"left\">" . $row_stk["PART_NO"] . "</td>";
    /* 	if ($row2["VAT"]=="1"){
      $rate=$row2["PRICE"]/(1+$row["GST"]/100);
      } else {
      $rate=$row2["PRICE"];
      } */
    echo "<td align=\"right\">" . number_format($row2["PRICE"], 2, ".", ",") . "</td>
        <td align=\"right\">" . number_format($row2["QTY"], 0, ".", ",") . "</td>
        <td align=\"right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $row2["DIS_P"] . "</td>";

    if ($row2["VAT"] == '1') {
        //if (is_null($row2["DIS_P"])==false) {
        $amount = (($row2["QTY"] * $row2["PRICE"]) - (($row2["QTY"] * $row2["PRICE"]) * $row2["DIS_P"]) / 100);
        //} else {
        //	$amount=$row2["QTY"]*$row2["PRICE"]/(1+ $row["GST"]/100);
        //}
    } else {
        if (is_null($row2["DIS_P"]) == false) {
            $amount = $row2["QTY"] * $row2["PRICE"] - $row2["QTY"] * $row2["PRICE"] * $row2["DIS_P"] / 100;
        } else {
            $amount = $row2["QTY"] * $row2["PRICE"];
        }
    }
    echo " <td align=right>" . number_format($amount, 2, ".", ",") . "</td>
     
      </tr>";
}
?>
                                    </table></td></tr></table><br />
                        <table width="922" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td  width="600"><?php echo $row['REMARK']; ?></td>

                                        <?php
                                        $sql_vat = "Select GST,SVAT from s_salma where REF_NO='" . $_GET["invoiceno"] . "'";
                                        $result_vat = mysqli_query($GLOBALS['dbinv'], $sql_vat);
                                        $row_vat = mysqli_fetch_array($result_vat);

                                        $sql_invpara = "SELECT * from invpara";
                                        $result_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
                                        $row_invpara = mysqli_fetch_array($result_invpara);

                                        if ($row_vat["SVAT"] > 0) {
                                            $txtvat = "SVAT " . $row["GST"] . "%: ";
                                        } else {
                                            $txtvat = "VAT " . $row["GST"] . "%: ";
                                        }
                                        ?>   
                                <td><?php echo $txtvat; ?></td>
                                <td align="right"><?php echo number_format($_GET["tax"], 2, ".", ","); ?></td>
                            </tr>

                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td align="right"><?php echo number_format($_GET["invtot"], 2, ".", ","); ?></td>
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
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>_______________________</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;________________________</td>
                    <td>&nbsp;</td>
                    <td>________________________</td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Entered By</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checked by</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Authorized by</td>
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

<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Weekly Order Report</title>

        <style>
            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {
                font-family:Arial, Helvetica, sans-serif;
                font-size:14px;
                padding:5px;
            }
        </style>
    </head>

    <body><center>
            <?php
            require_once("connectioni.php");
            
            



            $mrep = $_GET["salesrep"];
            $mvatrate = "11";

            $sql = "delete from tmpord where tmp_no='" . $_SESSION["CURRENT_USER"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 


            $sql_rs = "select * from  view_wcusordtrn_submas where CANCELL='0' and UNIT='WEO' and  SAL_EX='" . $mrep . "' and SDATE='" . $_GET["dtdate"] . "'";
            //echo $sql_rs;
            $result_rs = mysqli_query($GLOBALS['dbinv'],$sql_rs);
            while ($row_rs = mysqli_fetch_array($result_rs)) {

                if ($row_rs["DIS_per"] > 0) {
                    $cost = (($row_rs["PRICE"] - ($row_rs["PRICE"] * ($row_rs["DIS_per"] / 100))) * $row_rs["QTY"]) / (1 + ($mvatrate / 100));
                } else {
                    $cost = ($row_rs["PRICE"] * $row_rs["QTY"]) / (1 + ($mvatrate / 100));
                }
                $sql = "insert into tmpord (stkno, des, Cuscode, CUSNAME, ordqty, cost, QTYINHAND, stk, tmp_no) values ('" . $row_rs["STK_NO"] . "', '" . $row_rs["DESCRIPT"] . "', '" . $row_rs["c_code"] . "', '" . $row_rs["NAME"] . "', " . $row_rs["QTY"] . ", " . $cost . ", " . $row_rs["QTYINHAND"] . ", '" . $row_rs["stk"] . "', '" . $_SESSION["CURRENT_USER"] . "')";
                $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
            }

            $mdateto = $_GET["DTdateto"];

            $sql_rs = "Select * from view_salma_sinvo where SAL_EX='" . $mrep . "' and SDATE>='" . $_GET["dtdate"] . "' and SDATE <='" . $_GET["DTdateto"] . "' and CANCELL = '0' ";
            //echo $sql_rs;
            $result_rs = mysqli_query($GLOBALS['dbinv'],$sql_rs);
            while ($row_rs = mysqli_fetch_array($result_rs)) {
                $archval = (($row_rs["PRICE"] - ($row_rs["DIS_rs"] / $row_rs["QTY"])) * $row_rs["QTY"]) / (1 + ($mvatrate / 100));

                $sql = "insert into tmpord (stkno, des, Cuscode, CUSNAME, archqty, archval, tmp_no) values ('" . $row_rs["STK_NO"] . "', '" . $row_rs["DESCRIPT"] . "', '" . $row_rs["C_CODE"] . "', '" . $row_rs["CUS_NAME"] . "', " . $row_rs["QTY"] . ", " . $archval . ", '" . $_SESSION["CURRENT_USER"] . "')";
                $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
            }


            $sql_rs = "Select * from view_crnma_crntrn  where  SAL_EX='" . $mrep . "' and SDATE>='" . $_GET["dtdate"] . "' and SDATE <='" . $_GET["DTdateto"] . "' ";
            $result_rs = mysqli_query($GLOBALS['dbinv'],$sql_rs);
            while ($row_rs = mysqli_fetch_array($result_rs)) {

                $qty = $row_rs["QTY"] * -1;
                $mdis = 0;

                if (is_null($row_rs["DIS_P"]) == false) {
                    if ($row_rs["DIS_P"] > 0) {
                        $mdis = $row_rs["DIS_P"];
                    }
                }

                if ($mdis > 0) {
                    $archval = ((($row_rs["PRICE"] - ($row_rs["PRICE"] * ($row_rs["DIS_P"] / 100))) * $row_rs["QTY"]) * -1) / (1 + ($mvatrate / 100));
                } else {
                    $archval = (($row_rs["PRICE"] * $row_rs["QTY"]) * -1) / (1 + ($mvatrate / 100));
                }

                $sql = "insert into tmpord (stkno, des, Cuscode, CUSNAME, archqty, archval, tmp_no) values ('" . $row_rs["STK_NO"] . "', '" . $row_rs["DESCRIPT"] . "', '" . $row_rs["C_CODE"] . "', '" . $row_rs["CUS_NAME"] . "', " . $qty . ", " . $archval . ", '" . $_SESSION["CURRENT_USER"] . "')";
                $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 
            }


            $sql_tmpord = "SELECT * from tmpord where stkno != 'SC01' and stkno != 'A0350' and stkno != 'A0351' and stkno != 'A0352' and stkno != 'A0353' and stkno != 'A0600' and stkno != 'L0531' and tmp_no='" . $_SESSION["CURRENT_USER"] . "' order by stkno , Cuscode , ordqty desc";
            //echo $sql_tmpord;
            $result_tmpord = mysqli_query($GLOBALS['dbinv'],$sql_tmpord);
            while ($row_tmpord = mysqli_fetch_array($result_tmpord)) {
                if ($row_tmpord["ordqty"] != 0) {
                    $totordq = $totordq + $row_tmpord["ordqty"];
                    $val_totordq = $val_totordq + $row_tmpord["cost"];
                }
                if ($row_tmpord["archqty"] != 0) {
                    $totarchq = $totarchq + $row_tmpord["archqty"];
                    $val_totarchq = $val_totarchq + $row_tmpord["archval"];
                }
                if ($row_tmpord["stkno"] == "06365") {
                    $X = 1;
                }

                if ($row_tmpord["stkno"] == $sno) {
                    if ($row_tmpord["ordqty"] > 0) {
                        $ordq = $ordq + $row_tmpord["ordqty"];
                        $val_ordq = $val_ordq + $row_tmpord["cost"];
                        $cusn = $row_tmpord["Cuscode"];
                    }
                    if ($row_tmpord["Cuscode"] == $cusn) {
                        if ($row_tmpord["archqty"] > 0) {
                            $archq = $archq + $row_tmpord["archqty"];
                            $val_archq = $val_archq + $row_tmpord["archval"];
                        }
                        $differ = $ordq - $archq;
                        $val_differ = $val_ordq - $val_archq;
                    }
                } else {
                    $totdif = $totdif + $differ;
                    $val_totdif = $val_totdif + $val_differ;
                    $ordq = 0;
                    $val_ordq = 0;
                    $archq = 0;
                    $val_archq = 0;
                    $differ = 0;
                    $val_differ = 0;

                    if ($row_tmpord["ordqty"] != 0) {
                        $sno = $row_tmpord["stkno"];
                        $cusn = $row_tmpord["Cuscode"];

                        if ($row_tmpord["ordqty"] > 0) {
                            $ordq = $ordq + $row_tmpord["ordqty"];
                            $val_ordq = $val_ordq + $row_tmpord["cost"];
                        }
                        if ($row_tmpord["archqty"] > 0) {
                            $archq = $archq + $row_tmpord["archqty"];
                            $val_archq = $val_archq + $row_tmpord["archval"];
                        }
                        $differ = $ordq - $archq;
                        $val_differ = $val_ordq - $val_archq;
                    }
                }
            }

            $totdif = $totdif + $differ;
            $val_totdif = $val_totdif + $val_differ;

            $mrep = $_GET["salesrep"];


            /* 	
              $sql = "SELECT * from tmpord WHERE stkno != 'SC01' and stkno != 'A0350' and stkno != 'A0351' and stkno != 'A0352' and stkno != 'A0353' and stkno != 'A0600' and stkno != 'L0531' ";
              $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
              while ($row = mysqli_fetch_array($result)) {

              echo "<tr>";
              echo "<td>".$row["stkno"]."</td>";
              echo "<td>".$row["des"]."</td>";
              echo "<td>".$row["Cuscode"]."</td>";
              echo "<td>".$row["CUSNAME"]."</td>";
              echo "<td align=\"right\">".number_format($row["ordqty"], 2, ".", ",")."</td>";
              echo "<td align=\"right\">".number_format($row["cost"], 2, ".", ",")."</td>";
              echo "<td align=\"right\">".number_format($row["archqty"], 2, ".", ",")."</td>";
              echo "<td align=\"right\">".number_format($rows["archval"], 2, ".", ",")."</td>";

              } */

            if ($val_totordq) {
                $Text22 = ($val_totordq - $val_totdif) / ($val_totordq) * 100;
            }
            if ($val_totordq) {
                $Text30 = ($val_totarchq / $val_totordq) * 100;
            }

            if ($totarchq < $totordq) {
                $Text10 = $totarchq - ($totordq - $totdif);
            } else {
                $Text10 = ($totarchq - $totordq) + $totdif;
            }

            if ($totarchq < $totordq) {
                $Text21 = $totarchq - ($totordq - $totdif);
            } else {
                $Text21 = ($totarchq - $totordq) + $totdif;
            }

            if ($totarchq < $totordq) {
                $rtxtqty = ($totordq - $totdif);
            } else {
                $rtxtqty = $totarchq - (($totarchq - $totordq) + $totdif);
            }

            if ($val_totarchq < $val_totordq) {
                $rtxtval = $val_totordq - $val_totdif;
            } else {
                $rtxtval = $val_totarchq - (($val_totarchq - $val_totordq) + $val_totdif);
            }

            if ($val_totarchq < $val_totordq) {
                $Text24 = $val_totarchq - ($val_totordq - $val_totdif);
            } else {
                $Text24 = ($val_totarchq - $val_totordq) + $val_totdif;
            }

            //-------------------------------- All Month Target -----------------------------------

            $sql_target = "select sum(Target) as target  from reptrn where rep_code='" . $_GET["salesrep"] . "'";
            $result_target = mysqli_query($GLOBALS['dbinv'],$sql_target);
            $row_target = mysqli_fetch_array($result_target);

            $sql_salma = "select sum(GRAND_TOT) as tot  from s_salma where Accname != 'NON STOCK' and   SAL_EX='" . $_GET["salesrep"] . "' and month(SDATE)='" . date("m", strtotime($_GET["dtdate"])) . "'   and year(SDATE)='" . date("Y", strtotime($_GET["dtdate"])) . "'  and CANCELL='0'";
            //echo $sql_salma;
            $result_salma = mysqli_query($GLOBALS['dbinv'],$sql_salma);
            $row_salma = mysqli_fetch_array($result_salma);

            $sql_cbal = "select sum(AMOUNT) as tot from c_bal where   SAL_EX='" . $_GET["salesrep"] . "' and  month(SDATE)='" . date("m", strtotime($_GET["dtdate"])) . "'   and year(SDATE)='" . date("Y", strtotime($_GET["dtdate"])) . "'  and trn_type!='ARN' and trn_type!='REC'and trn_type!='DGRN' and trn_type!='INC' and trn_type!='PAY' and flag1 != '1'  ";
            $result_cbal = mysqli_query($GLOBALS['dbinv'],$sql_cbal);
            $row_cbal = mysqli_fetch_array($result_cbal);



            if (is_null($row_target["target"]) == false) {
                $txttot = $row_target["target"];
            } else {
                $txttot = 0;
            }

            if (is_null($row_cbal["tot"]) == false) {
                $txtach = ($row_salma["tot"] - $row_cbal["tot"]) / 1.11;
            } else {
                $txtach = $row_salma["tot"] / 1.11;
            }

            if (is_null($row_cbal["tot"]) == false) {
                $txtbal = ($row_target["target"] - ($row_salma["tot"] - $row_cbal["tot"]) / 1.11);
            } else {
                $txtbal = ($row_target["target"] - ($row_salma["tot"]) / 1.11);
            }

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'],$sql_head);
            $row_head = mysqli_fetch_array($result_head);

            $Text1 = $_GET["department"];
            $txtdes = "Date From : " . $_GET["dtdate"] . " Date To:" . $_GET["DTdateto"];

            echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";



            echo "<center><b>Weekly Order Planning </b>  - From " . $_GET["dtdate"] . " To " . $_GET["DTdateto"] . "</center><br>";

            $sql_rep = "select * from s_salrep where REPCODE='" . $_GET["salesrep"] . "'";
            $result_rep = mysqli_query($GLOBALS['dbinv'],$sql_rep);
            $row_rep = mysqli_fetch_array($result_rep);

            echo "<center>" . $row_rep["REPCODE"] . " - " . $row_rep["Name"] . "</center><br>";
            echo "<center>" . $txtcus . "</center><br>";

$cost=0;

            echo "<center><table border=1 cellpadding=0 ><tr>
		<th colspan=2 align=left>Dealer</th>
		<th align=left>Description</th>
		<th width=70  align=right>Target</th>
		<th width=100 align=right>Value</th>
		<th width=70 align=right><font color ='green'>ARCH.Qty</th>
		<th width=100 align=right><font color ='green'>ARCH.Value</th>
		<th width=70 align=right><font color ='red'>Non Target</th>
		<th width=120 align=right><font color ='red'>Non Target Val</th>
		</tr>";

            $sql = "SELECT Cuscode from tmpord WHERE stkno != 'SC01' and stkno != 'A0350' and stkno != 'A0351' and stkno != 'A0352' and stkno != 'A0353' and stkno != 'A0600' and stkno != 'L0531' and tmp_no='" . $_SESSION["CURRENT_USER"] . "' group by Cuscode order by Cuscode";
            $result = mysqli_query($GLOBALS['dbinv'],$sql) ; 


            while ($row = mysqli_fetch_array($result)) {

                
                $sqlv = "select * from vendor where code = '" . $row["Cuscode"] . "'";
                $resultv = mysqli_query($GLOBALS['dbinv'],$sqlv);
                $rowv = mysqli_fetch_array($resultv);
                
                echo "<tr>
				<td colspan=9><b>" . $row["Cuscode"] . " - " . $rowv["NAME"] . "</b></td></tr>";

                $sql2 = "select sum(ordqty) as ordqty,sum(cost) as cost, sum(archqty) as archqty,sum(archval) as archval,stkno, des from tmpord  where cuscode = '" . $row["Cuscode"] . "' and tmp_no='" . $_SESSION["CURRENT_USER"] . "'  group by stkno ,des";
                
               // echo $sql; 
			   $result1 = mysqli_query($GLOBALS['dbinv'],$sql2) ; 
                while ($row1 = mysqli_fetch_array($result1)) {

                    if (number_format($row1["ordqty"], 0, ".", ",") == "0") {
                        $ordqty_v = "";
                    } else {
                        $ordqty_v = number_format($row1["ordqty"], 0, ".", ",");
                    }

                    if (number_format($row1["cost"], 0, ".", ",") == "0") {
                        $cost_v = "";
                    } else {
                        $cost_v = number_format($row1["cost"], 2, ".", ",");
                    }

                    echo "<tr>
				<td colspan='2'>&nbsp;</td>
				<td>" . $row1["des"] . "</td>
				<td align=right>" . $ordqty_v . "</td>
				<td align=right>" . $cost_v . "</td>";

                    $ordqty = $ordqty + $row1["ordqty"];
                    if ($row1["ordqty"]>0) {
                    $cost = $cost + $row1["cost"];
                    }
                    //if sum ({ado.ordqty}, {ado.stkno}) = 0 and Sum ({ado.Archqty}, {ado.stkno}) > 0 then 0 else Sum ({ado.Archqty}, {ado.stkno})


                    if (($row1["ordqty"] > 0) and ( $row1["archqty"] <> 0)) {
                        echo "<td align=right><font color ='green'>" . number_format($row1["archqty"], 0, ".", ",") . "</td>";
                        echo "<td align=right><font color ='green'>" . number_format($row1["archval"], 2, ".", ",") . "</td>";
                        $archval1 = $archval1 + $row1["archval"];
                        $archqty1 = $archqty1 + $row1["archqty"];
                    } else {
                        echo "<td align=right></td>";
                        echo "<td align=right></td>";
                    }

                       if (($row1["ordqty"] == 0) and ( $row1["archqty"] <> 0)) {
                        echo "<td align=right><font color ='red'>" . number_format($row1["archqty"], 0, ".", ",") . "</td>";
                        echo "<td align=right><font color ='red'>" . number_format($row1["archval"], 2, ".", ",") . "</td>";
                        $archval2 = $archval2 + $row1["archval"];
                        $archqty2 = $archqty2 + $row1["archqty"];
                    } else {
                        echo "<td align=right></td>";
                        echo "<td align=right></td>";
                    }



                    echo "</tr>";
                }
            }



            echo "<tr>
				<td colspan='3'>&nbsp;</td>
				";
            echo "<td align=right><font color ='blue'><b>" . number_format($ordqty, 0, ".", ",") . "</b></td>";
            echo "<td align=right><font color ='blue'><b>" . number_format($cost, 2, ".", ",") . "</b></td>";
            echo "<td align=right><font color ='green'><b>" . number_format($archqty1, 0, ".", ",") . "</b></td>";
            echo "<td align=right><font color ='green'><b>" . number_format($archval1, 2, ".", ",") . "</b></td>";
            echo "<td align=right><font color ='red'><b>" . number_format($archqty2, 0, ".", ",") . "</b></td>";
            echo "<td align=right><font color ='red'><b>" . number_format($archval2, 2, ".", ",") . "</b></td></tr>";
            ?>


            </table></td>
            </tr>
            <tr><td colspan="7">
                    <table width="1000" border="0">
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Weekly Target</strong></td>
                            <td width="127">-</td>
                            <td width="127" align="right"><font color ='blue'><b><?php echo $ordqty; ?></b></td>
                            <td colspan="2" align="right"><font color ='blue'><b> <?php echo number_format($cost, 2, ".", ","); ?></b></td>
                            <td width="79">&nbsp;</td>
                            <td width="163">&nbsp;</td>
                            <td width="191" align="right">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Target Achievement</strong></td>
                            <td>-</td>
                            
                            <td align="right"><font color ='green'><b><?php echo number_format($archqty1, 0, ".", ","); ?></b></td>
                            <td colspan="2" align="right"><font color ='green'><b> <?php echo number_format($archval1, 2, ".", ","); ?></b></td>
                            <td>&nbsp;</td>
                            <?php
								$Text22=$archval1/$cost*100;
							?>
                            <td><b><?php echo number_format($Text22, 1, ".", ","); ?>%</b></td>
                            <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Non Target Sales</strong></td>
                            <td>-</td>
                            
                            <td align="right"><font color ='red'><b><?php echo number_format($archqty2, 0, ".", ","); ?></b></td>
                            <td colspan="2" align="right"><font color ='red'><b> <?php echo number_format($archval2, 2, ".", ","); ?></b></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Total Sales</strong></td>
                            <td>-</td>
                            <td align="right"><font color ='green'><b><?php echo $rtxtqty + $Text21; ?></b></td>
                            <td colspan="2" align="right"><font color ='green'><b> <?php echo number_format($rtxtval + $Text24, 2, ".", ","); ?></b></td>
                            <td>&nbsp;</td>
                            <td><b><?php echo number_format($Text30, 1, ".", ","); ?>%</b></td>
                            <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                            <td colspan="7"><table border="1" cellspacing="0">
                                    <tr>
                                        <th width="117" scope="col">All Month</th>
                                        <th width="131" scope="col">Target</th>
                                        <th width="243" scope="col">Achievement</th>
                                        <th width="202" scope="col">Balance</th>
                                    </tr>
                                    <tr>
                                        <td align="center"><strong>Total</strong></td>
                                        <td align="center"><?php echo number_format($txttot, 2, ".", ","); ?></td>
                                        <td align="center"><?php echo number_format($txtach, 2, ".", ","); ?></td>
                                        <td align="center"><?php echo number_format($txtbal, 2, ".", ","); ?></td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>

            </table>
    </body>
</html>

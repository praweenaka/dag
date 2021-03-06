<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Print Weekly Target</title>
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
                font-size: 16px;
            }

            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {
                border:1px solid black;
                font-family:Arial, Helvetica, sans-serif;
                padding:4px;
            }
            th
            {
                font-weight:bold;
                font-size:14px;

            }
            td
            {
                font-size:14px;
                border-bottom:none;
                border-top:none;
            }
            .style1 {color: #FF0000}
            .style2 {color: #0000FF	}
            -->
        </style>
    </head>

    <body><center>
            <p>
                <?php
                require_once("connectioni.php");



                $sql_para = "select * from invpara";
                $result_para = mysqli_query($GLOBALS['dbinv'], $sql_para);
                $row_para = mysqli_fetch_array($result_para);
                ?>
            </p>



            <?php
            //echo $_GET["invno"];

            $sql = "delete  from tragets where user_id='" . $_SESSION["CURRENT_USER"] . "'";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);

            $sql_week_tragets = "select * from view_tragers_vendor where REFNO='" . $_GET["txtref"] . "'";

            $result_week_tragets = mysqli_query($GLOBALS['dbinv'], $sql_week_tragets);
            while ($row_week_tragets = mysqli_fetch_array($result_week_tragets)) {
                $usr[] = "('" . trim($row_week_tragets["Cus_Code"]) . "', '" . trim($row_week_tragets["NAME"]) . "', " . trim($row_week_tragets["Target"]) . ", '" . trim($row_week_tragets["Remark"]) . "', '" . $_SESSION["CURRENT_USER"] . "')";
            }
            $sql = "insert into tragets(C_CODE, cusNAME, TRAGET, REMARK,  user_id) values " . implode(",", $usr);
            $result = mysqli_query($GLOBALS['dbinv'], $sql);

            $sql_SALMA = "select C_CODE from s_salma where Accname != 'NON STOCK' and sdate1 >= '" . $_GET["dtfrom"] . "' and sdate1 <= '" . $_GET["dtto"] . "'  and CANCELL='0'  and SAL_EX = '" . $_GET["Com_rep"] . "'  group by C_CODE";
            $result_SALMA = mysqli_query($GLOBALS['dbinv'], $sql_SALMA);
            while ($row_SALMA = mysqli_fetch_array($result_SALMA)) {
                $sql_UTRAGETs = "SELECT C_CODE from tragets  WHERE C_CODE= '" . $row_SALMA["C_CODE"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "' ";
                $result_UTRAGETs = mysqli_query($GLOBALS['dbinv'], $sql_UTRAGETs);
                if ($row_UTRAGETs = mysqli_fetch_array($result_UTRAGETs)) {
                    
                } else {
                    $usr1[] = "('" . $row_SALMA["C_CODE"] . "', '" . $_SESSION["CURRENT_USER"] . "')";
                }
            }
            $sql_UTRAGETs = "insert into tragets(C_CODE, user_id) values " . implode(",", $usr1);
            $result_UTRAGETs = mysqli_query($GLOBALS['dbinv'], $sql_UTRAGETs);


            $sql_c_bal = "select CUSCODE from c_bal where sdate1 >= '" . $_GET["dtfrom"] . "' and sdate1 <= '" . $_GET["dtto"] . "'  and CANCELL='0'  and SAL_EX = '" . $_GET["Com_rep"] . "' and trn_type!='REC'and trn_type!='DGRN' and trn_type!='ARN' AND trn_type!='INC' AND  trn_type!='PAY'  group by CUSCODE";
            $result_c_bal = mysqli_query($GLOBALS['dbinv'], $sql_c_bal);
            while ($row_c_bal = mysqli_fetch_array($result_c_bal)) {
                $sql_UTRAGETs = "SELECT C_CODE from tragets  WHERE C_CODE= '" . $row_c_bal["CUSCODE"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'";
                $result_UTRAGETs = mysqli_query($GLOBALS['dbinv'], $sql_UTRAGETs);
                if ($row_UTRAGETs = mysqli_fetch_array($result_UTRAGETs)) {
                    
                } else {
                    $usr2[] = "('" . $row_c_bal["CUSCODE"] . "', '" . $_SESSION["CURRENT_USER"] . "')";
                }
            }
            if (isset($usr2)) {
                $sql_UTRAGETs = "insert into tragets(C_CODE, user_id) values " . implode(",", $usr2);
                $result_UTRAGETs = mysqli_query($GLOBALS['dbinv'], $sql_UTRAGETs);
            }

            $sql_TARGET = "select *  from tragets where user_id='" . $_SESSION["CURRENT_USER"] . "'";
            $result_TARGET = mysqli_query($GLOBALS['dbinv'], $sql_TARGET);
            $usr3 = "";
            while ($row_TARGET = mysqli_fetch_array($result_TARGET)) {

                $m_sales = 0;

                // $sql_sales="select sum(GRAND_TOT-(GRAND_TOT*.11)) as sales from s_salma where Accname != 'NON STOCK' and SAL_EX= '".$_GET["Com_rep"]."' and  sdate1 >= '".$_GET["dtfrom"]."' and sdate1 <= '".$_GET["dtto"]."'  and CANCELL='0' and C_CODE='".$row_TARGET["C_CODE"]."' and DEV='1' ";
                $sql_sales = "select sum(GRAND_TOT/(1 +gst/100)) as sales from s_salma where Accname != 'NON STOCK' and SAL_EX= '" . $_GET["Com_rep"] . "' and  sdate1 >= '" . $_GET["dtfrom"] . "' and sdate1 <= '" . $_GET["dtto"] . "'  and CANCELL='0' and C_CODE='" . $row_TARGET["C_CODE"] . "' and DEV='1' ";
                //echo $sql_sales."</br>";
                $result_sales = mysqli_query($GLOBALS['dbinv'], $sql_sales);
                if ($row_sales = mysqli_fetch_array($result_sales)) {
                    if (is_null($row_sales["sales"]) == false) {
                        $m_sales = $row_sales["sales"];
                    }
                }

                $sql_sales = "select sum(GRAND_TOT/(1 +gst/100)) as sales from s_salma where Accname != 'NON STOCK' and SAL_EX= '" . $_GET["Com_rep"] . "' and  sdate1 >= '" . $_GET["dtfrom"] . "' and sdate1 <= '" . $_GET["dtto"] . "'  and CANCELL='0' and C_CODE='" . $row_TARGET["C_CODE"] . "' and DEV='0' ";

                $result_sales = mysqli_query($GLOBALS['dbinv'], $sql_sales);
                if ($row_sales = mysqli_fetch_array($result_sales)) {
                    if (is_null($row_sales["sales"]) == false) {
                        $m_sales = $m_sales + $row_sales["sales"];
                    }
                }

                $m_rep = $_GET["Com_rep"];
                $sql_sales = "select sum(AMOUNT/(1 +vatrate/100)) as sales from c_bal where SAL_EX= '" . $m_rep . "' and  sdate1 >= '" . $_GET["dtfrom"] . "' and sdate1 <= '" . $_GET["dtto"] . "'  and trn_type!='ARN' and trn_type!='REC'and trn_type!='DGRN' and trn_type!='INC' and trn_type!='PAY' and flag1 != '1' and CANCELL='0' and CUSCODE='" . $row_TARGET["C_CODE"] . "' ";

                $result_sales = mysqli_query($GLOBALS['dbinv'], $sql_sales);
                if ($row_sales = mysqli_fetch_array($result_sales)) {
                    if (is_null($row_sales["sales"]) == false) {
                        $m_sales = $m_sales - $row_sales["sales"];
                    }
                }


                $sql = "update tragets set sale='" . $m_sales . "' where C_CODE='" . $row_TARGET["C_CODE"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
            }


            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");





            $TXTHEAD0 = "<b>Sales Plan From : " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "   To :  " . date("Y-m-d", strtotime($_GET["dtto"])) . "</b>";

            $sql_rep = "sELECT *  from s_salrep where REPCODE='" . $_GET["Com_rep"] . "' ";
            $result_rep = mysqli_query($GLOBALS['dbinv'], $sql_rep);
            $row_rep = mysqli_fetch_array($result_rep);

            $TXTHEAD1 = "<b>Sales Executive  " . $row_rep["Name"] . "</b>";

            echo "</br>" . $TXTHEAD0 . "</br></br>";
            echo $TXTHEAD1;

            $sql_rsPrInv = "sELECT *  from tragets where user_id='" . $_SESSION["CURRENT_USER"] . "' order by TRAGET desc ";
            $result_rsPrInv = mysqli_query($GLOBALS['dbinv'], $sql_rsPrInv);
            while ($row_rsPrInv = mysqli_fetch_array($result_rsPrInv)) {
                if ($row_rsPrInv["C_CODE"] != "") {
                    $sql_rsVENDOR = "Select NAME from vendor where CODE= '" . $row_rsPrInv["C_CODE"] . "'  ";
                    $result_rsVENDOR = mysqli_query($GLOBALS['dbinv'], $sql_rsVENDOR);
                    $row_rsVENDOR = mysqli_fetch_array($result_rsVENDOR);

                    $sql_update = "update tragets set cusNAME='" . $row_rsVENDOR["NAME"] . "' where C_CODE='" . $row_rsPrInv["C_CODE"] . "' and user_id='" . $_SESSION["CURRENT_USER"] . "'  ";
                    $result_update = mysqli_query($GLOBALS['dbinv'], $sql_update);
                }
            }

            //$sql_target = "select sum(target) as tottarget  from rep_target where rep='" . trim($_GET["Com_rep"]) . "'  and TMonth=" . date("m", strtotime($_GET["dtfrom"])) . " and Tyear=" . date("Y", strtotime($_GET["dtfrom"]));
            //$sql_target = "Select sum(Target) as tottarget from rep_target where rep='".trim($_GET["Com_rep"])."' and (tmonth)='" . date("m", strtotime($_GET["dtfrom"])) . "'   and (Tyear)='" . date("Y", strtotime($_GET["dtfrom"])) . "' ";
            $sql_target = "Select target as tottarget from s_salrep where repcode='" . trim($_GET["Com_rep"]) . "' ";
            $result_target = mysqli_query($GLOBALS['dbinv'], $sql_target);
            $row_target = mysqli_fetch_array($result_target);

            $sql_salma = "select sum(grand_tot) as tot  from s_salma where Accname != 'NON STOCK' and   SAL_EX='" . trim($_GET["Com_rep"]) . "' and month(sdate1)='" . date("m", strtotime($_GET["dtfrom"])) . "'   and year(sdate1)='" . date("Y", strtotime($_GET["dtfrom"])) . "'  and CANCELL='0'   ";
            $result_salma = mysqli_query($GLOBALS['dbinv'], $sql_salma);
            $row_salma = mysqli_fetch_array($result_salma);

            $sql_cbal = "select sum(AMOUNT) as tot from c_bal where   SAL_EX='" . trim($_GET["Com_rep"]) . "' and  month(sdate1)='" . date("m", strtotime($_GET["dtfrom"])) . "'   and year(sdate1)='" . date("Y", strtotime($_GET["dtfrom"])) . "'  and trn_type!='ARN' and trn_type!='REC'and trn_type!='DGRN' and trn_type!='INC' and trn_type!='PAY' and flag1 != '1' and CANCELL = '0' ";
            $result_cbal = mysqli_query($GLOBALS['dbinv'], $sql_cbal);
            $row_cbal = mysqli_fetch_array($result_cbal);

            $Text9 = number_format($row_target["tottarget"], 2, ".", ",");
            $Text10 = number_format(($row_salma["tot"] - $row_cbal["tot"]) / ((100+$row_para['vatrate'])/100), 2, ".", ",");
            $Text11 = number_format(($row_target["tottarget"] - (($row_salma["tot"] - $row_cbal["tot"]) / ((100+$row_para['vatrate'])/100))), 2, ".", ",");
            ?>
            <table width="900" border="1" cellpadding="0" cellspacing="0">
                <tr>

                    <th width="450" scope="col">Dealer Name</th>
                    <th width="150" scope="col">Target</th>
                    <th width="150" scope="col">Target Achivement</th>
                    <th width="140" height="22">Non Target Sales</th>
                    <th width="140" height="22">Balance</th>
                </tr>
                <?php
                $target = 0;
                $target_achiv = 0;
                $non_target_achiv = 0;
                $mbalance = 0;
                $sql_rsPrInv = "sELECT *  from tragets where user_id='" . $_SESSION["CURRENT_USER"] . "' order by TRAGET desc ";
//echo $sql_rsPrInv;
                $result_rsPrInv = mysqli_query($GLOBALS['dbinv'], $sql_rsPrInv);
                while ($row_rsPrInv = mysqli_fetch_array($result_rsPrInv)) {

                    $balance = 0;

                    echo "<td align=left>" . $row_rsPrInv["cusNAME"] . "</td>
       	 	<td align=right>" . number_format($row_rsPrInv["TRAGET"], 2, ".", ",") . "</td>";
                    $target = $target + $row_rsPrInv["TRAGET"];

                    if ($row_rsPrInv["TRAGET"] != 0) {

                        if ($row_rsPrInv["sale"] == 0) {
                            echo "<td align=right>&nbsp;</td>";
                        } else {
                            echo "<td align=right>" . number_format($row_rsPrInv["sale"], 2, ".", ",") . "</td>";
                        }
                        $target_achiv = $target_achiv + $row_rsPrInv["sale"];
                        $balance = $row_rsPrInv["TRAGET"] - $row_rsPrInv["sale"];
                    } else {
                        echo "<td align=right>&nbsp;</td>";
                    }

                    if ($row_rsPrInv["TRAGET"] == 0) {
                        if ($row_rsPrInv["sale"] == 0) {
                            echo "<td align=right>&nbsp;</td>";
                        } else {
                            echo "<td align=right>" . number_format($row_rsPrInv["sale"], 2, ".", ",") . "</td>";
                        }
                        $non_target_achiv = $non_target_achiv + $row_rsPrInv["sale"];
                        $balance = $row_rsPrInv["TRAGET"] - $row_rsPrInv["sale"];
                    } else {
                        echo "<td align=right>&nbsp;</td>";
                    }

                    if ($balance != 0) {
                        if ($balance < 0) {
                            echo "<td align=right><span class=\"style2\">" . number_format($balance, 2, ".", ",") . "</style></td>";
                        } else {
                            echo "<td align=right><span class=\"style1\">" . number_format($balance, 2, ".", ",") . "</style></td>";
                        }
                        $mbalance = $mbalance + $balance;
                    } else {
                        echo "<td align=right>&nbsp;</td>";
                    }

                    echo "</tr>";
                }

                echo "<tr><th colspan2>&nbsp;</th>";
                echo "<th align=right><b>" . number_format($target, 2, ".", ",") . "</b></th><th align=right><b>" . number_format($target_achiv, 2, ".", ",") . "</b></th><th align=right><b>" . number_format($non_target_achiv, 2, ".", ",") . "</b></th>";
                if ($mbalance < 0) {
                    echo "<th align=right><span class=\"style2\"><b>" . number_format($mbalance, 2, ".", ",") . "</style></th></tr>";
                } else {
                    echo "<th align=right><span class=\"style1\"><b>" . number_format($mbalance, 2, ".", ",") . "</style></th></tr>";
                }
                ?>


            </table>
            <?php
            $total = $target_achiv + $non_target_achiv;
            //echo $total; 
            ?>
            <br />
            <table  border="1" cellpadding="0" cellspacing="0">
                <tr>
                    <th scope="col" align="left">Weekly Target</th>
                    <th scope="col"><?php echo number_format($target, 2, ".", ","); ?></th>
                    <th scope="col">&nbsp;</th>
                </tr>
                <tr>
                    <th scope="col" align="left"><b>Target Archivement </b></th>
                    <th scope="col"><?php
                        $achive = $target_achiv / $target * 100;
                        echo number_format($target_achiv, 2, ".", ",");
                        ?></th>
                    <th scope="col"><b><?php echo number_format($achive, 2, ".", ",") . "%"; ?></b></th>
                </tr>
                <tr>
                    <th scope="col" align="left"><b>Non Target Sales</b></th>
                    <th scope="col"><b><?php echo number_format($non_target_achiv, 2, ".", ","); ?></b></th>
                    <th scope="col">&nbsp;</th>
                </tr>
                <tr>
                    <th width="214" scope="col" align="left"><b>Total Sale</b></th>
                    <th width="194" scope="col"><?php
                        $tot = $target_achiv + $non_target_achiv;
                        $tot_per = $tot / $target * 100;
                        echo number_format($tot, 2, ".", ",");
                        ?></th>
                    <th width="104" scope="col"><b><?php echo number_format($tot_per, 2, ".", ",") . "%"; ?></b></th>
                </tr>
            </table>

            <p>&nbsp;</p>
            <table  border="1" cellpadding="0" cellspacing="0">
                <tr>
                    <th width="125" scope="col">All Month</th>
                    <th width="117" scope="col">Target</th>
                    <th width="205" scope="col">Achievemant</th>
                    <th width="183" scope="col">Balance</th>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td align="right"><?php echo $Text9; ?></td>
                    <td align="right"><?php echo $Text10; ?></td>
                    <td align="right"><?php echo $Text11; ?></td>
                </tr>
            </table>
    </body>
</html>

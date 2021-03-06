<?php
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60);
session_start();
date_default_timezone_set('Asia/Colombo');
require_once ("connectioni.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Report</title>

        <style>
            table {
                border-collapse: collapse;
            }
            table, th {
                border: 1px solid black;
                font-family: Arial, Helvetica, sans-serif;
                padding: 5px;
            }
            th {
                font-weight: bold;
                font-size: 12x;
            }
            td {
                font-size: 12px;
                border-bottom: dashed;
                border-width: thin;
                font-family: Arial, Helvetica, sans-serif;
                padding: 5px;
            }
        </style>

    </head>

    <body>
        <?php
        $sql_head = "select * from invpara";
        $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
        $row_head = mysqli_fetch_array($result_head);

        echo "<center><span class=\"style1\"><b>" . $row_head["COMPANY"] . "</b></center><br>";
        echo "<center><span class=\"style1\"><b>Sales Register</b></center><br>";
        ?>

        <center> <table><tr>
                    <th width=\"110\"  background=\"images/headingbg.gif\" >Date</th>
                    <th width=\"120\"  background=\"images/headingbg.gif\">Invoice No</th>
                    <th width=\"300\"  background=\"images/headingbg.gif\">Customer</th>
                    <th width=\"100\"  background=\"images/headingbg.gif\">Rep</th>
                    <th width=\"100\"  background=\"images/headingbg.gif\">Amount</th>
                    <th width=\"100\"  background=\"images/headingbg.gif\">Total Pay</th>
                    <th width=\"100\"  background=\"images/headingbg.gif\">Type</th>
                </tr>
                <?php
                $sql_rst = "select * from tempreg where user_nm = '" . $_SESSION["CURRENT_USER"] . "' order by SDATE";
                $result_rst = mysqli_query($GLOBALS['dbinv'], $sql_rst);
                $invtot = 0;
                $paidtot = 0;
                $rettot=0;
                $ResponseXML =""; 
                while ($rstemp = mysqli_fetch_array($result_rst)) {



                    $ResponseXML .= "<tr>                              
                             <td>" . $rstemp['SDATE'] . "</td>
							 <td>" . $rstemp['REFNO'] . "</td>
							 <td>" . $rstemp['cus_name'] . "</td>
							 <td>" . $rstemp['SAL_EX'] . "</td>
							 <td align='right'>" . number_format($rstemp['AMOUNT'], 2, ".", ",") . "</td>
							 <td align='right'>" . number_format($rstemp['BALANCE'], 2, ".", ",") . "</td>
							 <td>" . $rstemp['TRN_TYPE'] . "</td></tr>";

                    if ($rstemp['TRN_TYPE'] == "INV") {
                        $invtot = $invtot + $rstemp['AMOUNT'];
                        $paidtot = $paidtot + ($rstemp['AMOUNT'] - $rstemp['BALANCE']);
                    }
                    if ($rstemp['TRN_TYPE'] != "INV") {
                        $rettot = $rettot + $rstemp["AMOUNT"];
                    }
                }
                $ResponseXML .= "   </table>";


                $ResponseXML .= "<tr>                              
                     <td colspan='2'>Sales Total  =&nbsp;" . number_format($invtot, 2, ".", ",") . "&nbsp;&nbsp;</td>							  
					 <td colspan='2'>&nbsp;&nbsp;Return Total =&nbsp;" . number_format($rettot, 2, ".", ",") . "&nbsp;&nbsp;</td>
					 <td colspan='3'>&nbsp;&nbsp;Paid Total   =&nbsp;" . number_format($paidtot, 2, ".", ",") . "&nbsp;</td>
					 </tr>";


                echo $ResponseXML;
                ?>

















                </body>
                </html>
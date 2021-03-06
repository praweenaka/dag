<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Print Invoice</title>
        <style type="text/css">
            <!--
            .style1 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 14px;
                font-weight: bold;
            }
            .style2 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 15px;
            }

            .style3 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 15px;
                font-weight:bold;
            }
            -->
        </style>
    </head>

    <body><center>
            <?php
            require_once("connectioni.php");





            $sql_rspara = "select * from invpara";
            $result_rspara = mysqli_query($GLOBALS['dbinv'], $sql_rspara);
            $row_rspara = mysqli_fetch_array($result_rspara);

            $txtrepono = $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:m:s");

            $sql = "SELECT * from tmpcommition order by id  ";
            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $row = mysqli_fetch_array($result);

            $sql_sttr1 = "SELECT SUM(commission) AS commission FROM tmpcommition ";
            $result_sttr1 = mysqli_query($GLOBALS['dbinv'], $sql_sttr1);
            $row_sttr1 = mysqli_fetch_array($result_sttr1);


            $mnonocom = 0;
            if (is_null($row_sttr1["commission"]) == false) {
                $mnonocom = $row_sttr1["commission"];
            }



            $rtxtComName = $row_rspara["COMPANY"];
            $rtxtcomadd1 = $row_rspara["ADD1"];
            $rtxtComAdd2 = $row_rspara["ADD2"] . ", " . $row_rspara["ADD3"];

            $rtxtotamount = $totamount;

            $rtxtotdue = $totdue;

            //Call Print_Report(m_Report, 42)
            /*

              '==================================check Permission===========================
              CURRENT_DOC = 42      'document ID
              'VIEW_DOC = True      '  view current document
              FEED_DOC = True      '   save  current document
              'MOD_DOC = True       '   delete   current document
              'PRINT_DOC = True     ' get additional print   of  current document
              'PRICE_EDIT=true      ' edit selling price
              CHECK_USER = True    ' check user permission again
              REFNO = REFNO = Trim(cmbrep) + Format(dtMonth, "MM/YYYY") + " Save"
              frmGetAuth.Show 1
              If Not AUTH_OK Then Exit Sub
              //============================================================================= */

            $sql_rsTMPCOMMITION = "select * from tmpcommition where commission > 0 and  PAY_AMOUNT > 0";
            //echo $sql_rsTMPCOMMITION."</br>";
            $result_rsTMPCOMMITION = mysqli_query($GLOBALS['dbinv'], $sql_rsTMPCOMMITION);
            while ($row_rsTMPCOMMITION = mysqli_fetch_array($result_rsTMPCOMMITION)) {
                $sql_sal = "update s_salma set DUMMY_VAL=0  where REF_NO='" . $row_rsTMPCOMMITION["REFNO"] . "'";
                //echo $sql_sal;
                $result_sal = mysqli_query($GLOBALS['dbinv'], $sql_sal);
            }

            $sql_rsTMPCOMMITION = "select * from tmpcommition where commission > 0 and  PAY_AMOUNT > 0";
            //echo $sql_rsTMPCOMMITION."</br>";
            $result_rsTMPCOMMITION = mysqli_query($GLOBALS['dbinv'], $sql_rsTMPCOMMITION);
            while ($row_rsTMPCOMMITION = mysqli_fetch_array($result_rsTMPCOMMITION)) {
                $sql_sal = "update s_salma set DUMMY_VAL=DUMMY_VAL+" . ($row_rsTMPCOMMITION["commission"] + 1) . " where REF_NO='" . $row_rsTMPCOMMITION["REFNO"] . "'";
                //echo $sql_sal;
                $result_sal = mysqli_query($GLOBALS['dbinv'], $sql_sal);
            }
            ?>		

            <table width="1322" border="1" cellpadding="0" cellspacing="0">
                <tr>
                    <th width="48">Date</th>
                    <th width="150">Ref No</th>
                    <th width="250">Customer</th>
                    <th width="100">Brand</th>
                    <th width="75">Amount</th>
                    <th width="75">Deu</th>
                    <th width="48">Date</th>
                    <th width="75">Amount</th>
                    <th width="51">Days</th>
                    <th width="63">Ap.Da</th>
                    <th width="58">Cat. 1</th>
                    <th width="53">Cat 2</th>
                    <th width="151">No Commission</th>
                    <th width="125">Commission</th>
                </tr>
                <?php
                $sql = "Select * from tmpcommition order by REFNO";
                $result = mysqli_query($GLOBALS['dbinv'], $sql);
                while ($row = mysqli_fetch_array($result)) {

                    if ($row["REFNO"] != $REFNO) {
                        echo "<tr>
                                <td>" . $row["SDATE"] . "</td>
                                <td>" . $row["REFNO"] . "</td>
                                <td>" . $row["cus_name"] . "</td>
                                <td>" . $row["brand"] . "</td>
                                <td align=right>" . $row["AMOUNT"] . "</td>
                                <td align=right>" . $row["DUE"] . "</td>
                                <td colspan=7>&nbsp;</td>
                                        </tr>";

                        $REFNO = $row["REFNO"];
                    }
                    echo "<tr>
                            <td colspan=6>&nbsp;</td>
                            <td align=right>" . $row["PAY_DATE"] . "</td>
                            <td align=right>" . $row["PAY_AMOUNT"] . "</td>
                            <td>" . $row["DATES"] . "</td>
                            <td align=right>" . $row["apdays"] . "</td>
                            <td align=right>" . $row["D_75"] . "</td>
                            <td align=right>" . $row["D_76_90"] . "</td>
                            <td align=right>" . $row["D_91"] . "</td>
                                <td align=right>" . $row["commission"] . "</td>
                                </tr>";
                    $D_75 = $D_75 + $row["D_75"];
                    $D_76_90 = $D_76_90 + $row["D_76_90"];
                    $D_91 = $D_91 + $row["D_91"];
                    $commission = $commission + $row["commission"];
                }

                echo "<tr>
                        <td colspan=6>&nbsp;</td>
                        <td align=right>&nbsp;</td>
                        <td align=right>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align=right>&nbsp;</td>
                        <td align=right><b>" . number_format($D_75, 2, ".", ",") . "</b></td>
                        <td align=right><b>" . number_format($D_76_90, 2, ".", ",") . "</b></td>
                        <td align=right><b>" . number_format($D_91, 2, ".", ",") . "</b></td>
                            <td align=right><b>" . number_format($commission, 2, ".", ",") . "</b></td>
                      </tr>";
                ?>
            </table>
    </body>
</html>

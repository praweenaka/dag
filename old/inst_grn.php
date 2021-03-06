<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>GRN</title>
    </head>
    <body>
        <?php
        // grn
        $hostname = 'localhost';
        $username = 'root';
        $password = '';

        $dbinv1 = mysql_connect($hostname, $username, $password, true);
        $dbinv = mysql_connect($hostname, $username, $password, true);

//mysql_select_db('lotterix_accben', $dbacc);
//mysql_select_db('lotterix_ben', $dbinv);

        mysql_select_db('ben', $dbinv1);
        mysql_select_db('ben_tyre', $dbinv);

        $sql = "select * from s_crnma where sdate >='2014-08-25' and trn_type='GRN' order by ref_no";
        $result = mysql_query($sql, $dbinv1);

        while ($row = mysql_fetch_array($result)) {


            $sql = "insert into s_crnma(REF_NO, SDATE, INVOICENO, DDATE, C_CODE, CUS_NAME, GRAND_TOT, DIS, DEPARTMENT, DEP_CODE, Brand, SAL_EX, DEV, GST, seri_no, vatrate, CANCELL, TRN_TYPE, stoRef) values "
                    . "('" . $row["REF_NO"] . "', '" . $row["SDATE"] . "', '" . $row["INVOICENO"] . "', '" . $row["DDATE"] . "', '" . $row["C_CODE"] . "', '" . $row["CUS_NAME"] . "', " . $row["GRAND_TOT"] . ", " . $row["DIS"] . ", '" . $row["DEPARTMENT"] . "', '" . $row["DEP_CODE"] . "', '" . $row["Brand"] . "', '" . $row["SAL_EX"] . "', '" . $row['DEV'] . "', " . $row["GST"] . ", '" . $row["seri_no"] . "', " . $row['vatrate'] . ", '" . $row['CANCELL'] . "', '" . $row["TRN_TYPE"] . "', '" . $row["stoRef"] . "')";
            echo $sql. "<br>";
            $resultq = mysql_query($sql, $dbinv);


            $sqlc = "select * from c_bal where refno = '" . $row["REF_NO"] . "'";
            echo $sqlc. "<br>";
            $resultc = mysql_query($sqlc, $dbinv1);
            while ($rowc = mysql_fetch_array($resultc)) {
                $sqlcc = "insert into c_bal(REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate, RNO, Cancell) values "
                        . "('" . $rowc["REFNO"] . "', '" . $rowc["SDATE"] . "', '" . $rowc["trn_type"] . "', '" . $rowc["CUSCODE"] . "'," . $rowc["AMOUNT"] . ", " . $rowc["BALANCE"] . ", '" . $rowc["brand"] . "', '" . $rowc["DEP"] . "', '" . $rowc["SAL_EX"] . "', '" . $rowc['DEV'] . "', '" . $rowc['vatrate'] . "', '" . $rowc["RNO"] . "', '" . $rowc['Cancell'] . "')";
                echo $sqlcc. "<br>";
                $resultq = mysql_query($sqlcc, $dbinv);
            }


            $sqlc = "select * from s_crntrn where REF_NO = '" . $row["REF_NO"] . "'";
            $resultr = mysql_query($sqlc, $dbinv1);
            while ($rowt = mysql_fetch_array($resultr)) {
                $sqlr = "insert into s_crntrn(REF_NO, STK_NO, SDATE, DESCRIPT, PRICE, DIS_P, QTY, DEPARTMENT, VAT, Seri_no, vatrate,CANCELL) values "
                        . "('" . $rowt["REF_NO"] . "', '" . $rowt["STK_NO"] . "', '" . $rowt["SDATE"] . "', '" . $rowt["DESCRIPT"] . "', '" . $rowt["PRICE"] . "', '" . $rowt["DIS_P"] . "', " . $rowt["QTY"] . ", '" . $rowt["DEPARTMENT"] . "', '" . $rowt["VAT"] . "', '" . $rowt["Seri_no"] . "', " . $rowt["vatrate"] . ", '" . $rowt['CANCELL'] . "')";
                echo $sqlr. "<br>";
                $resultq = mysql_query($sqlr, $dbinv);

                if ($row['CANCELL'] == "0") {
                    $sql = "update s_invo set ret_qty=ret_qty+" . $rowt["QTY"] . " where REF_NO='" . $row["INVOICENO"] . "' and STK_NO='" . $rowt["STK_NO"] . "'";
                    echo $sql. "<br>";
                    $resultq = mysql_query($sql, $dbinv);


                    $sql = "update s_mas set QTYINHAND=QTYINHAND+" . $rowt["QTY"] . " where STK_NO='" . $rowt["STK_NO"] . "'";
                    echo $sql. "<br>";
                    $resultq = mysql_query($sql, $dbinv);


                    $sql = "update s_submas set QTYINHAND=QTYINHAND+" . $rowt["QTY"] . " where STK_NO='" . $rowt["STK_NO"] . "' and STO_CODE='" . $rowt["DEPARTMENT"] . "'";
                    echo $sql. "<br>";
                    $resultq = mysql_query($sql, $dbinv);


                    $sql = "insert into s_trn(STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, seri_no) values"
                            . " ('" . $rowt["STK_NO"] . "', '" . $rowt["SDATE"] . "', '" . $rowt["REF_NO"] . "', " . $rowt["QTY"] . ", 'GRN', '" . $rowt["DEPARTMENT"] . "', '" . $rowt["Seri_no"] . "')";
                    echo $sql. "<br>";
                    $resultq = mysql_query($sql, $dbinv);
                }
            }

            if ($row['CANCELL'] == "0") {
                $sql = "update s_salma set RET_AMO=RET_AMO+" . $row["GRAND_TOT"] . " where REF_NO='" . $row["REF_NO"] . "' ";
                echo $sql. "<br>";
                $resultq = mysql_query($sql, $dbinv);

                $sql = "insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT, DEV) values "
                        . "('" . $row["REF_NO"] . "', '" . $row["SDATE"] . "', '" . $row["C_CODE"] . "', " . $row["AMOUNT"] . ", 'GRN', '" . $row["DEP_CODE"] . "', '" . $row["DEV"] . "') ";
                echo $sql. "<br>";
                $resultq = mysql_query($sql, $dbinv);


                $sql = "update vendor set CUR_BAL=CUR_BAL-" . $row["AMOUNT"] . " where CODE='" . $row["C_CODE"] . "' ";
                echo $sql. "<br>";
                $resultq = mysql_query($sql, $dbinv);
            }

            $sql = "update invpara set grn=grn+1 ";
            echo $sql. "<br>";
            $resultq = mysql_query($sql, $dbinv);
        }
        ?>
    </body>
</html>

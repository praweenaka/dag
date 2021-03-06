<?php

$hostname = 'localhost';
$username = 'root';
$password = '';

$dbinv1 = mysql_connect($hostname, $username, $password, true);
$dbinv = mysql_connect($hostname, $username, $password, true);

//mysql_select_db('lotterix_accben', $dbacc);
//mysql_select_db('lotterix_ben', $dbinv);

mysql_select_db('ben', $dbinv1);
mysql_select_db('ben_tyre', $dbinv);

$sql = "Select * from cred where C_DATE >='2014-08-25'";
$result = mysql_query($sql, $dbinv1);

while ($row = mysql_fetch_array($result)) {

    $sql = "Insert into cred (C_REFNO, C_DATE, C_INVNO, C_CODE, C_PAYMENT, C_REMARK, C_SALEX, Brand, DEV, CANCELL) values 
('" . $row["C_REFNO"] . "', '" . $row["C_DATE"] . "', '" . $row["C_INVNO"] . "', '" . $row["C_CODE"] . "', '" . $row["C_PAYMENT"] . "', '" . $row["C_REMARK"] . "', '" . $row["C_SALEX"] . "', '" . $row["Brand"] . "', '" . $row['DEV'] . "', '" . $row["CANCELL"] . "') ";
    echo $sql . "<br>";
    $resultq = mysql_query($sql, $dbinv);



    $sql = "Select * from c_bal where REFNO ='" . $row["C_REFNO"] . "'";
    $resultc = mysql_query($sql, $dbinv1);

    while ($rowc = mysql_fetch_array($resultc)) {
        $sql = "Insert into c_bal (REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, vatrate, RNO, flag1, DEV, CANCELL, old, active, totpay) values 
('" . $rowc["REFNO"] . "', '" . $rowc["SDATE"] . "', '" . $rowc["trn_type"] . "', '" . $rowc["CUSCODE"] . "', '" . $rowc["AMOUNT"] . "',"
                . " '" . $rowc["BALANCE"] . "', '" . $rowc["brand"] . "', '" . $rowc["DEP"] . "', '" . $rowc["SAL_EX"] . "', "
                . "'" . $rowc["vatrate"] . "', '" . $rowc["RNO"] . "', '" . $rowc["flag1"] . "', '" . $rowc['DEV'] . "', '" . $rowc['CANCELL'] . "', '" . $rowc['old'] . "', " . $rowc['active'] . ", " . $rowc['totpay'] . ") ";
        echo $sql . "<br>";
        $resultq = mysql_query($sql, $dbinv);
    }

    if ($row['CANCELL'] == 0) {
        $sql = "insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT, DEV) values "
                . "('" . $row["C_REFNO"] . "', '" . $row["C_DATE"] . "', '" . $row["C_CODE"] . "', " . $row["C_PAYMENT"] . ", 'CRN', '" . $row["DEP_CODE"] . "', '" . $row["DEV"] . "') ";
        echo $sql . "<br>";
        $resultq = mysql_query($sql, $dbinv);

        $sql = "update vendor set CUR_BAL = CUR_BAL - " . $row["C_PAYMENT"] . " where CODE='" . $row["C_CODE"] . "'";
        echo $sql. "<br>";
        $resultq = mysql_query($sql, $dbinv);

        $sql = "update br_trn set credit = credit - " . $row["C_PAYMENT"] . " where cus_code='" . $row["C_CODE"] . "' and Rep='" . $row["C_SALEX"] . "'";
        echo $sql . "<br>";
        $resultq = mysql_query($sql, $dbinv);

        $sql = "update s_salma set RET_AMO=RET_AMO+" . $row["C_PAYMENT"] . " where REF_NO='" . $row["C_INVNO"] . "' ";
        echo $sql . "<br>";
        $resultq = mysql_query($sql, $dbinv);
    }

    $sql = "update invpara set CRN = CRN + 1";
    $resultq = mysql_query($sql, $dbinv);
}
?>
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

$sql = "Select * from s_crec where CA_DATE >='2014-08-25'";
$resultm = mysql_query($sql, $dbinv1);

while ($row = mysql_fetch_array($resultm)) {


    $sql = "insert into s_crec(CA_REFNO, CA_DATE, CA_CODE, CA_CASSH, CA_AMOUNT, overpay, FLAG, pay_type, CA_SALESEX, CANCELL, tmp_no, DEPARTMENT, cus_ref, AC_REFNO, TTDATE, DEV) values
	  ('" . $row["CA_REFNO"] . "', '" . $row["CA_DATE"] . "', '" . $row["CA_CODE"] . "', " . $row["CA_CASSH"] . ", " . $row["CA_AMOUNT"] . ", " . $row["overpay"] . ", '" . $row["FLAG"] . "', '" . $row["pay_type"] . "',"
            . " '" . $row["CA_SALESEX"] . "', '" . $row["CANCELL"] . "', '" . $row["tmp_no"] . "', 'O', " . $row["cus_ref"] . ", '" . $row["AC_REFNO"] . "', '" . $row["TTDATE"] . "', '" . $row['DEV'] . "' )";
    echo $sql . "<br>";
    $result = mysql_query($sql, $dbinv);


    $sql = "Select * from s_sttr where st_refno ='" . $row["CA_REFNO"] . "'";
    echo $sql . "<br>";
    $results = mysql_query($sql, $dbinv1);

    while ($rows = mysql_fetch_array($results)) {

        $sql = "insert into s_sttr(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_CHNO, st_chdate, ST_FLAG, st_days, ap_days, st_chbank, cus_code, DEV, del_days, deliin_days, deliin_amo, deliin_lock, department) values
	  ('" . $row["CA_REFNO"] . "', '" . $rows["ST_DATE"] . "', '" . $rows["ST_INVONO"] . "', " . $rows["ST_PAID"] . ", '" . $rows["ST_CHNO"] . "', '" . $rows["st_chdate"] . "', '" . $rows["ST_FLAG"] . "', '" . $rows["st_days"] . "', '" . $rows["ap_days"] . "', '" . $rows["st_chbank"] . "', '" . $rows["cus_code"] . "', '" . $rows['DEV'] . "', '" . $rows["del_days"] . "' , '" . $rows["deliin_days"] . "', '" . $rows["deliin_amo"] . "', '" . $rows["deliin_lock"] . "', '" . $rows["department"] . "')";
        echo $sql . "<br>";
        $result = mysql_query($sql, $dbinv);

        $sql = "update vendor set CUR_BAL=CUR_BAL - " . $rows["ST_PAID"] . " where CODE = '" . $row["CA_CODE"] . "'";
        echo $sql . "<br>";
        $result = mysql_query($sql, $dbinv);

        $sql = "update br_trn set credit=credit - " . $rows["ST_PAID"] . " where cus_code = '" . $row["CA_CODE"] . "' and Rep='" . $row["CA_SALESEX"] . "'";
        echo $sql . "<br>";
        $result = mysql_query($sql, $dbinv);

        $sql = "update s_salma set TOTPAY=TOTPAY + " . $rows["ST_PAID"] . " where REF_NO = '" . $rows["ST_INVONO"] . "'";
        echo $sql . "<br>";
        $result = mysql_query($sql, $dbinv);


        if ($rows["ST_FLAG"] == "CAS") {
            $sql = "update s_salma set CASH=CASH + " . $rows["ST_PAID"] . " where REF_NO = '" . $rows["ST_INVONO"] . "'";
            echo $sql . "<br>";
            $result = mysql_query($sql, $dbinv);
        }


  
    }

      $sql = "Select * from s_invcheq where refno ='" . $row["CA_REFNO"] . "'";
        $resultc = mysql_query($sql, $dbinv1);

        while ($rowc = mysql_fetch_array($resultc)) {
            $sql = "insert into s_invcheq(refno, Sdate, cus_code, CUS_NAME, cheque_no, che_date, bank, che_amount, sal_ex, trn_type, ex_flag, ch_owner, noof, ret_refno, ch_count_ret, department) values
	  ('" . $rowc["refno"] . "', '" . $rowc["Sdate"] . "', '" . $rowc["cus_code"] . "', '" . $rowc["CUS_NAME"] . "', '" . $rowc["cheque_no"] . "', '" . $rowc["che_date"] . "', '" . $rowc["bank"] . "',  " . $rowc["che_amount"] . ", '" . $rowc["sal_ex"] . "', '" . $rowc["trn_type"] . "', '" . $rowc["ex_flag"] . "', '" . $rowc["ch_owner"] . "', '" . $rowc["noof"] . "', '" . $rowc["ret_refno"] . "', '" . $rowc["ch_count_ret"] . "', '" . $rowc["department"] . "')";
            echo $sql . "<br>";
            $result = mysql_query($sql, $dbinv);
        }
		
    $sql = "Select * from c_bal where REFNO ='" . $rowc["CA_REFNO"] . "'";
    $resultc = mysql_query($sql, $dbinv1);

    while ($rowc = mysql_fetch_array($resultc)) {
        $sql = "Insert into c_bal (REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, SAL_EX)) values 
('" . $rowc["REFNO"] . "', '" . $rowc["SDATE"] . "', '" . $rowc["trn_type"] . "', '" . $rowc["CUSCODE"] . "', '" . $rowc["AMOUNT"] . "',"
                . " '" . $rowc["BALANCE"] . "', '" . $rowc["SAL_EX"] . "' )";
        echo $sql . "<br>";
        $resultq = mysql_query($sql, $dbinv);
    }
    
       $sql = "Select * from s_led where REF_NO ='" . $row["CA_REFNO"] . "'";
    $resultc = mysql_query($sql, $dbinv1);

    while ($rowc = mysql_fetch_array($resultc)) {
	$sql="insert into s_led(REF_NO, C_CODE, SDATE, FLAG, AMOUNT) values
	  ('". $rowc["REF_NO"] ."', '".$rowc["C_CODE"]."', '".$rowc["SDATE"]."', '".$rowc["FLAG"]."', ".$rowc["AMOUNT"].")";
        
        echo $sql . "<br>";
        $resultq = mysql_query($sql, $dbinv);
    } 
    
    
    
}
?>
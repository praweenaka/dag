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


$sql = "SELECT * FROM s_utmas WHERE c_date >='2014-08-25'";

$resultm = mysql_query($sql, $dbinv1);

while ($row = mysql_fetch_array($resultm)) {

    $sql = "insert into s_utmas(C_REFNO, C_DATE, C_CODE, C_CRNNo, C_Amount, C_cash, c_chno, c_chdate, ch_val, ch_bank, CANCEL) values "
            . "('" . trim($row["C_REFNO"]) . "', '" . $row["C_DATE"] . "', '" . $row["C_CODE"] . "', '" . $row["C_CRNNo"] . "', '" . $row["C_Amount"] . "', '" . $row["C_cash"] . "', '" . $row["c_chno"] . "', '" . $row["c_chdate"] . "', '" . $row["ch_val"] . "', '" . $row["ch_bank"] . "', '" . $row['CANCEL'] . "')";
    echo $sql . "<br>";
    $result = mysql_query($sql, $dbinv);


    $sql = "SELECT * FROM s_ut WHERE c_refno ='" . trim($row["C_REFNO"]) . "'";
    $result1 = mysql_query($sql, $dbinv1);
    while ($row1 = mysql_fetch_array($result1)) {
        $sql = "insert into s_ut(C_REFNO, C_DATE, C_CODE, C_INVNO, C_PAYMENT, CRE_NO_NO, TYPE) values"
                . " ('" . trim($row["C_REFNO"]) . "', '" . $row["C_DATE"] . "', '" . $row["C_CODE"] . "', '" . $row1["C_INVNO"] . "', '" . $row1["C_PAYMENT"] . "', '" . trim($row1["CRE_NO_NO"]) . "', '" . trim($row1["TYPE"]) . "')";
        echo $sql . "<br>";
        $result = mysql_query($sql, $dbinv);
    }
    
    
    $sql = "Select * from s_sttr where st_refno ='" . $row["C_REFNO"] . "'";
    echo $sql . "<br>";
    $results = mysql_query($sql, $dbinv1);

    while ($rows = mysql_fetch_array($results)) {        
        $sql = "insert into s_sttr(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_FLAG, ST_CHNO, st_days, ap_days, DEV, department) values
	  ('" . $row["C_REFNO"] . "', '" . $rows["ST_DATE"] . "', '" . $rows["ST_INVONO"] . "', " . $rows["ST_PAID"] . ", '" . $rows["ST_FLAG"] . "' , '" . $rows["ST_CHNO"] . "', '" . $rows["st_days"] . "', '" . $rows["ap_days"] . "', '" . $rows['DEV'] . "', '" . $rows["department"] . "')";
        echo $sql . "<br>";
        $result = mysql_query($sql, $dbinv);

        $sql = "update vendor set CUR_BAL=CUR_BAL - " . $rows["ST_PAID"] . " where CODE = '" . $row["C_CODE"] . "'";
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
    
    
    
    
    $sql = "Select * from ch_sttr where st_refno ='" . $row["C_REFNO"] . "'";
    echo $sql . "<br>";
    $results = mysql_query($sql, $dbinv1);

    while ($rows = mysql_fetch_array($results)) {        
        $sql = "insert into ch_sttr(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_FLAG, ST_CHNO, st_days, ap_days, DEV, department) values
	  ('" . $row["C_REFNO"] . "', '" . $rows["ST_DATE"] . "', '" . $rows["ST_INVONO"] . "', " . $rows["ST_PAID"] . ", '" . $rows["ST_FLAG"] . "' , '" . $rows["ST_CHNO"] . "', '" . $rows["st_days"] . "', '" . $rows["ap_days"] . "', '" . $rows['DEV'] . "', '" . $rows["department"] . "')";
        echo $sql . "<br>";
        $result = mysql_query($sql, $dbinv);

        $sql = "update vendor set RET_CHEQ=RET_CHEQ - " . $rows["ST_PAID"] . " where CODE = '" . $row["C_CODE"] . "'";
        echo $sql . "<br>";
        $result = mysql_query($sql, $dbinv);

        $sql = "update s_cheq set paid=paid + " . $rows["ST_PAID"] . " where CR_REFNO = '" . $rows["ST_INVONO"] . "'";
        echo $sql . "<br>";
        $result = mysql_query($sql, $dbinv);
    }
    
    
    $sql="UPDATE c_bal SET BALANCE = BALANCE - ".$row["C_Amount"]." WHERE ((REFNO='".trim($row["C_CRNNo"])."'))";
    echo $sql . "<br>";
    $resultss = mysql_query($sql, $dbinv);

    
    
    
}
?>
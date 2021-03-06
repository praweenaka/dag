<?php

$hostname = 'localhost';
$username = 'root';
$password = '';

$ben = mysql_connect($hostname, $username, $password, true);
$ben_tyre = mysql_connect($hostname, $username, $password, true);

//mysql_select_db('lotterix_accben', $dbacc);
//mysql_select_db('lotterix_ben', $dbinv);

mysql_select_db('ben', $ben);
mysql_select_db('ben_tyre', $ben_tyre);

$sql = "Select * from s_ginmas where SDATE >='2014-08-25'";
$result = mysql_query($sql, $ben);
while ($row = mysql_fetch_array($result)) {

    $sql1 = "insert into s_ginmas(SDATE, REF_NO, DEP_FROM, DEP_F_NAME, DEP_TO, DEP_T_NAME, AR_DATE, AR_NO, tmp_no) values ('".$row["SDATE"]."', '".$row["REF_NO"]."', '".$row["DEP_FROM"]."', '".$row["DEP_F_NAME"]."', '".$row["DEP_TO"]."', '".$row["DEP_T_NAME"]."', '".$row["AR_DATE"]."', '".$row["AR_NO"]."', '".$row["tmp_no"]."')";
    echo $sql1 . "<br>";
    $result1 = mysql_query($sql1, $ben_tyre);

}

$sql = "Select * from s_trn where SDATE >='2014-08-25' and LEDINDI='GINI'";
echo $sql . "<br>";
$result = mysql_query($sql, $ben);
while ($row = mysql_fetch_array($result)) {

    $sql1 = "insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO) values ('".$row["STK_NO"]."', '".$row["SDATE"]."', '".$row["QTY"]."', 'GINI', '".$row["REFNO"]."', '".$row["DEPARTMENT"]."', '".$row['seri_no']."', '".$row["Dev"]."', '".$row["SAL_EX"]."', '".$row["ACTIVE"]."', '".$row["DONO"]."')";
    echo $sql1 . "<br>";
    $result1 = mysql_query($sql1, $ben_tyre);
	
	$sql_mas = "Select * from s_ginmas where SDATE >='2014-08-25' and REF_NO='".$row["REFNO"]."'";
	$result_mas = mysql_query($sql_mas, $ben);
	$row_mas = mysql_fetch_array($result_mas);

	$sql1="update s_submas set QTYINHAND=QTYINHAND-".$row["QTY"]." where STK_NO='".$row["STK_NO"]."' and STO_CODE='".$row_mas["DEP_FROM"]."'";
	echo $sql1 . "<br>";
	$result1 = mysql_query($sql1, $ben_tyre);

}

$sql = "Select * from s_trn where SDATE >='2014-08-25' and LEDINDI='GINR'";
echo $sql . "<br>";
$result = mysql_query($sql, $ben);
while ($row = mysql_fetch_array($result)) {

    $sql1 = "insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO) values ('".$row["STK_NO"]."', '".$row["SDATE"]."', '".$row["QTY"]."', 'GINR', '".$row["REFNO"]."', '".$row["DEPARTMENT"]."', '".$row['seri_no']."', '".$row["Dev"]."', '".$row["SAL_EX"]."', '".$row["ACTIVE"]."', '".$row["DONO"]."')";
    echo $sql1 . "<br>";
    $result1 = mysql_query($sql1, $ben_tyre);
	
	
	$sql_mas = "Select * from s_ginmas where SDATE >='2014-08-25' and REF_NO='".$row["REFNO"]."'";
	$result_mas = mysql_query($sql_mas, $ben);
	$row_mas = mysql_fetch_array($result_mas);
	
	$sqlsub="Select * from s_submas where STK_NO='".$row["STK_NO"]."' and STO_CODE='".$row_mas["DEP_TO"]."'";
	$resultsub = mysql_query($sqlsub, $ben);
	if($rowsub = mysql_fetch_array($resultsub)){
					
		$sql1="update s_submas set QTYINHAND=QTYINHAND+".$row["QTY"]." where STK_NO='".$row["STK_NO"]."' and STO_CODE='".$row_mas["DEP_TO"]."'";
		echo $sql1 . "<br>";
		$result1 = mysql_query($sql1, $ben);
	} else {
		$sql1="insert into s_submas(STO_CODE, STK_NO, DESCRIPt, OPEN_STK, QTYINHAND) values ('".$row_mas["DEP_TO"]."',  '".$row["STK_NO"]."', '".$row_mas["DEP_T_NAME"]."', 0, ".$row["QTY"].")";
		echo $sql1 . "<br>";
		$result1 = mysql_query($sql1, $ben);
	}

}




  
?>
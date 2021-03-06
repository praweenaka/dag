<?php

	require_once("connectioni.php");
	
	
	
	
	$sql = "delete FROM s_salma_c_bal";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	
	$sql = "SELECT * FROM s_salma";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	while($row = mysqli_fetch_array($result)){

	 $sql1 = "insert into s_salma_c_bal(REF_NO, TRN_TYPE, SDATE, C_CODE, CUS_NAME, C_ADD1, TYPE, SAL_EX, DISCOU, AMOUNT, GST, GRAND_TOT, DUMMY_VAL, DIS, DIS1, DIS2, DIS_RUP, CASH, TOTPAY, ORD_NO, ORD_DA, SETTLED, TOTPAY1, DES_CAT, DEPARTMENT, REMARK, CANCELL, BTT, VAT, VAT_VAL, Brand, DEV, Account, Accname, Costcenter, RET_AMO, cre_pe, Comm, red, deli_date, seri_no, points, LOCK1, deliin, SVAT, REQ_DATE, tmp_no, vat_no, s_vat_no) values ('".$row["REF_NO"]."', '".$row["TRN_TYPE"]."', '".$row["SDATE"]."', '".$row["C_CODE"]."', '".$row["CUS_NAME"]."', '".$row["C_ADD1"]."', '".$row["TYPE"]."', '".$row["SAL_EX"]."', ".$row["DISCOU"].", ".$row["AMOUNT"].", ".$row["GST"].", ".$row["GRAND_TOT"].", ".$row["DUMMY_VAL"].", ".$row["DIS"].", ".$row["DIS1"].", ".$row["DIS2"].", ".$row["DIS_RUP"].", ".$row["CASH"].", ".$row["TOTPAY"].", '".$row["ORD_NO"]."', '".$row["ORD_DA"]."', '".$row["SETTLED"]."', '".$row["TOTPAY1"]."', '".$row["DES_CAT"]."', '".$row["DEPARTMENT"]."', '".$row["REMARK"]."', '".$row["CANCELL"]."', '".$row["BTT"]."', '".$row["VAT"]."', ".$row["VAT_VAL"].", '".$row["Brand"]."', '".$row["DEV"]."', '".$row["Account"]."', '".$row["Accname"]."', '".$row["Costcenter"]."', ".$row["RET_AMO"].", ".$row["cre_pe"].", '".$row["Comm"]."', '".$row["red"]."', '".$row["deli_date"]."', '".$row["seri_no"]."', '".$row["points"]."', '".$row["LOCK1"]."', '".$row["deliin"]."', ".$row["SVAT"].", '".$row["REQ_DATE"]."', '".$row["tmp_no"]."', '".$row["vat_no"]."', '".$row["s_vat_no"]."')";
 	
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
	
	}
	
	echo "S_SALMA";
	
	$sql = "SELECT * FROM c_bal";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	while($row = mysqli_fetch_array($result)){
		
		$AMOUNT=(-1*$row["AMOUNT"]);
		$BALANCE=(-1*$row["BALANCE"]);
		
	 $sql1 = "insert into s_salma_c_bal(REF_NO, TRN_TYPE, SDATE, C_CODE, CUS_NAME, C_ADD1, TYPE, SAL_EX, DISCOU, AMOUNT, GST, GRAND_TOT, DUMMY_VAL, DIS, DIS1, DIS2, DIS_RUP, CASH, TOTPAY, ORD_NO, ORD_DA, SETTLED, TOTPAY1, DES_CAT, DEPARTMENT, REMARK, CANCELL, BTT, VAT, VAT_VAL, Brand, DEV, Account, Accname, Costcenter, RET_AMO, cre_pe, Comm, red, deli_date, seri_no, points, LOCK1, deliin, SVAT, REQ_DATE, tmp_no, vat_no, s_vat_no) values ('".$row["REFNO"]."', '".$row["trn_type"]."', '".$row["SDATE"]."', '".$row["CUSCODE"]."', '', '', '', '".$row["SAL_EX"]."', 0, ".$AMOUNT.", 0, ".$AMOUNT.", 0, 0, 0, 0, 0, 0, ".$BALANCE.", '', '', '', '', '', '".$row["DEP"]."', '', '".$row["CANCELL"]."', '', '', 0, '".$row["brand"]."', '".$row["DEV"]."', '', '', '".$row["Costcenter"]."', 0, 0, '', '', '', '', '', '', '', 0, '', '".$row["tmp_no"]."', '', '')";
 	
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
	
	}
	
	echo "c_bal";
?>
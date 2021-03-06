<?php

	
	require_once("connectioni.php");
	
	
	
	
	$sql="select * from s_sttr";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	while($row = mysqli_fetch_array($result)){
		
		$sqlvan="select * from vendor where CODE='".$row["cus_code"]."'";
		$resultvan =mysqli_query($GLOBALS['dbinv'],$sqlvan);
		$rowvan = mysqli_fetch_array($resultvan);
	
		$sql1="insert into s_sttr_all(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, netamount, ST_CHNO, st_chdate, cus_code, cusname, DEV, del_days, deliin_days, deliin_amo, deliin_lock, department, form_type, trn_type) values
	  ('".$row["ST_REFNO"]."', '".$row["ST_DATE"]."', '".$row["ST_INVONO"]."', ".$row["ST_PAID"].", ".(-1*$row["ST_PAID"]).", '".$row["ST_CHNO"]."', '".$row["st_chdate"]."', '".$row["cus_code"]."', '".$rowvan["NAME"]."', '".$row['DEV']."', ".$row['del_days'].", ".$row['deliin_days'].", ".$row['deliin_amo'].", '".$row['deliin_lock']."', '".$row["department"]."', '".$row["ST_FLAG"]."', 'SET')";
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
	}	
	
	
	
	$sql="select * from c_bal where Cancell!='1'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	while($row = mysqli_fetch_array($result)){
		
		$sqlvan="select * from vendor where CODE='".$row["CUSCODE"]."'";
		$resultvan =mysqli_query($GLOBALS['dbinv'],$sqlvan);
		$rowvan = mysqli_fetch_array($resultvan);
		
		$form_type="";
		$trn_type="";
			
		if ($row["trn_type"]=="ARN"){
			$form_type="ARN";
			$trn_type="OVER";
		}
		
		if ($row["trn_type"]=="GRN"){
			$form_type="ARN";
			$trn_type="OVER";
		}	
		
		if ($row["trn_type"]=="CNT"){
			$form_type="CNT";
			$trn_type="OVER";
		}	
		
		if ($row["trn_type"]=="RET"){
			$form_type="RET";
			$trn_type="OVER";
		}	
		
		if ($row["trn_type"]=="DGRN"){
			$form_type="DGRN";
			$trn_type="OVER";
		}	
		
		if ($row["trn_type"]=="UT"){
			$form_type="UT";
			$trn_type="SETOVER";
		}	
		
			$sql1="insert into s_sttr_all(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, balance, netamount, cus_code, cusname, DEV, del_days, deliin_days, deliin_amo, deliin_lock, department, form_type, trn_type) values
	  ('".$row["REFNO"]."', '".$row["SDATE"]."', '".$row["REFNO"]."', ".$row["AMOUNT"].", ".$row["BALANCE"].", ".(-1*$row["BALANCE"]).", '".$row["CUSCODE"]."', '".$rowvan["NAME"]."', '".$row['DEV']."', ".$row['del_days'].", ".$row['deliin_days'].", ".$row['deliin_amo'].", '".$row['deliin_lock']."', '".$row["DEP"]."', '".$form_type."', '".$trn_type."')";
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			
	}
	


	$sql="select * from s_salma where CANCELL!='1'";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	while($row = mysqli_fetch_array($result)){
		
		$sqlvan="select * from vendor where CODE='".$row["CUSCODE"]."'";
		$resultvan =mysqli_query($GLOBALS['dbinv'],$sqlvan);
		$rowvan = mysqli_fetch_array($resultvan);
			
		
			$sql1="insert into s_sttr_all(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, netamount, ST_CHNO, st_chdate, ST_FLAG, st_days, ap_days, st_chbank, cus_code, cusname, sal_ex, DEV, del_days, deliin_days, deliin_amo, deliin_lock, department, form_type, trn_type) values
	  ('".$row["REF_NO"]."', '".$row["SDATE"]."', '".$row["REF_NO"]."', ".$row["GRAND_TOT"].", ".$row["GRAND_TOT"].", '', '', '', '', '', '', '".trim($row["C_CODE"])."', '".$row["CUS_NAME"]."', '".$row["SAL_EX"]."', '".$_SESSION['dev']."', 0, 0, 0, '0', '".$row["department"]."', 'INV', 'OUT')";	
			$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
			
	}
	
	echo "Successfully Completed";	
?>
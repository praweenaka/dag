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

	$sql="Select * from s_salma where SDATE>='2014-08-25'";
	$result=mysql_query($sql, $ben);
	while($row = mysql_fetch_array($result)){
		//$sql1="insert into s_salma(REF_NO, TRN_TYPE, SDATE, C_CODE, Brand, CUS_NAME, VAT, VAT_VAL, TYPE, DISCOU, AMOUNT, GRAND_TOT,  TOTPAY, ORD_NO, ORD_DA,  DEPARTMENT, SAL_EX, BTT, cre_pe, GST, DIS, DIS1, DIS2, SVAT, Account, TOTPAY1, REMARK, REQ_DATE, CANCELL, DEV, tmp_no, DIS_RUP, CASH, SETTLED, DES_CAT, Accname, Costcenter, RET_AMO, Comm, red, seri_no, points, LOCK1, deliin, vat_no, s_vat_no, C_ADD1) values ('".$row["REF_NO"]."', '".$row["TRN_TYPE"]."', '".$row["SDATE"]."', '".trim($row["C_CODE"])."', '".trim($row["Brand"])."', '".trim($row["CUS_NAME"])."','".$row["VAT"]."', ".$row["VAT_VAL"].", '".$row["TYPE"]."',".$row["DISCOU"].", ".$row["AMOUNT"]." , ".$row["GRAND_TOT"].", ".$row["TOTPAY"].", '".trim($row["ORD_NO"])."', '".$row["ORD_DA"]."', '".trim($row["DEPARTMENT"])."', '".trim($row["SAL_EX"])."', ".$row["BTT"].", ".$row["cre_pe"]." , ".$row["GST"].", ".$row["DIS"].", ".$row["DIS1"].", ".$row["DIS2"].", '".$row["SVAT"]."', '".$row["Account"]."', '".$row["TOTPAY1"]."',  '".$row["REMARK"]."', '".$row["REQ_DATE"]."', '".$row["CANCELL"]."', '".$row["DEV"]."', '".$row["tmp_no"]."', ".$row["DIS_RUP"].", ".$row["CASH"].", '".$row["SETTLED"]."', '".$row["DES_CAT"]."', '".$row["Accname"]."', '".$row["Costcenter"]."', ".$row["RET_AMO"].", '".$row["Comm"]."', '".$row["red"]."', '".$row["seri_no"]."', '".$row["points"]."', '".$row["LOCK1"]."', '', '".trim($row["deliin"])."', '".trim($row["vat_no"])."', '".$row["s_vat_no"]."', '".$row["C_ADD1"]."')";
		$sql1="insert into s_salma(REF_NO, TRN_TYPE, SDATE, C_CODE, Brand, CUS_NAME, VAT, VAT_VAL, TYPE, DISCOU, AMOUNT, GRAND_TOT,  TOTPAY, ORD_NO, ORD_DA,  DEPARTMENT, SAL_EX, BTT, cre_pe, GST, DIS, DIS1, DIS2, SVAT, Account, TOTPAY1, REMARK, REQ_DATE, CANCELL, DEV, tmp_no, DIS_RUP, CASH, SETTLED, DES_CAT, Accname, Costcenter, RET_AMO, Comm, red, seri_no, points, LOCK1, deliin, vat_no, s_vat_no, C_ADD1) values ('".$row["REF_NO"]."', '".$row["TRN_TYPE"]."', '".$row["SDATE"]."', '".trim($row["C_CODE"])."', '".trim($row["Brand"])."', '".trim($row["CUS_NAME"])."','".$row["VAT"]."', ".$row["VAT_VAL"].", '".$row["TYPE"]."',".$row["DISCOU"].", ".$row["AMOUNT"]." , ".$row["GRAND_TOT"].", ".$row["TOTPAY"].", '".trim($row["ORD_NO"])."', '".$row["ORD_DA"]."', '".trim($row["DEPARTMENT"])."', '".trim($row["SAL_EX"])."', ".$row["BTT"].", ".$row["cre_pe"]." , ".$row["GST"].", ".$row["DIS"].", ".$row["DIS1"].", ".$row["DIS2"].", '".$row["SVAT"]."', '".$row["Account"]."', '".$row["TOTPAY1"]."',  '".$row["REMARK"]."', '".$row["REQ_DATE"]."', '".$row["CANCELL"]."', '".$row["DEV"]."', '".$row["tmp_no"]."', ".$row["DIS_RUP"].", ".$row["CASH"].", '".$row["SETTLED"]."', '".$row["DES_CAT"]."', '".$row["Accname"]."', '".$row["Costcenter"]."', ".$row["RET_AMO"].", '".$row["Comm"]."', '".$row["red"]."', '".$row["seri_no"]."', '".$row["points"]."', '".$row["LOCK1"]."', '".trim($row["deliin"])."', '".trim($row["vat_no"])."', '".$row["s_vat_no"]."', '".$row["C_ADD1"]."')";
		echo $sql1."</br>";		
		$result1=mysql_query($sql1, $ben_tyre);
	}	
	
	echo "s_salma completed";
	
	$sql="Select * from s_salma where SDATE>='2014-08-25'";
	$result=mysql_query($sql, $ben);
	while($row = mysql_fetch_array($result)){
		$sql1="update vendor set CUR_BAL= CUR_BAL+".$row["GRAND_TOT"]." where CODE='".trim($row["C_CODE"])."'";
		echo $sql1."</br>";		
		$result1=mysql_query($sql1, $ben_tyre);
		
		$sql1="update br_trn set credit= credit+".$row["GRAND_TOT"]." where cus_code='".trim($row["C_CODE"])."'";
		echo $sql1."</br>";		
		$result1=mysql_query($sql1, $ben_tyre);
	}	
	
	echo "vendor completed";
	echo "br_trn completed";
	
	$sql="Select * from s_invo where SDATE>='2014-08-25'";
	$result=mysql_query($sql, $ben);
	while($row = mysql_fetch_array($result)){
		$sql1="insert into s_invo(REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, COST, PRICE, QTY, DEPARTMENT, DIS_per, DIS_rs, REP, TAX_PER, BRAND, vatrate, Print_dis1, Print_dis2, Print_dis3, subtot, ret_qty, DEV, CANCELL, c_code, seri_no, ad) values ('".$row["REF_NO"]."', '".$row["SDATE"]."', '".trim($row["STK_NO"])."', '".trim($row["DESCRIPT"])."', '".$row["PART_NO"]."', ".$row["COST"].", ".$row["PRICE"].", ".$row["QTY"].", '".$row["DEPARTMENT"]."', '".$row["DIS_per"]."', ".$row["DIS_rs"].", '".$row["REP"]."', '".$row["TAX_PER"]."', '".$row["BRAND"]."', ".$row["vatrate"].", ".$row["Print_dis1"].", ".$row["Print_dis2"].", ".$row["Print_dis3"].", ".$row["subtot"].", '".$row["ret_qty"]."', '".$row["DEV"]."', '".$row["CANCELL"]."', '".$row["c_code"]."', '".$row["seri_no"]."', '".$row["ad"]."')";
		echo $sql1."</br>";		
		$result1=mysql_query($sql1, $ben_tyre);
	}	
	
	echo "s_invo completed";
	
  $sql_tr="Select * from s_invo where SDATE>='2014-08-25'";
  echo $sql_tr."</br>";		
  $result_tr=mysql_query($sql_tr, $ben);
  while($row_tr = mysql_fetch_array($result_tr)){	
	$sql="Select * from s_trn where SDATE>='2014-08-25' and REFNO='".$row_tr["REF_NO"]."' and STK_NO='".$row_tr["STK_NO"]."'";
	$result=mysql_query($sql, $ben);
	if($row = mysql_fetch_array($result)){
		$sql1="insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO) values ('".$row["STK_NO"]."', '".$row["SDATE"]."', '".$row["QTY"]."', '".$row["LEDINDI"]."', '".$row["REFNO"]."', '".$row["DEPARTMENT"]."', '".$row["seri_no"]."', '".$row['Dev']."', '".$row["SAL_EX"]."', '".$row["ACTIVE"]."', '".$row["DONO"]."')";
		echo $sql1."</br>";		
		$result1=mysql_query($sql1, $ben_tyre);
	}
  }		
	echo "s_trn completed";
	
  $sql_tr="Select * from s_invo where SDATE>='2014-08-25' and CANCELL='0' ";
  echo $sql_tr."</br>";		
  $result_tr=mysql_query($sql_tr, $ben);
  while($row_tr = mysql_fetch_array($result_tr)){	
	
		$sql1="update s_mas set QTYINHAND= QTYINHAND-".$row_tr["QTY"]." where STK_NO='".trim($row_tr["STK_NO"])."'";
		echo $sql1."</br>";		
		$result1=mysql_query($sql1, $ben_tyre);
		
		$sql_trn="Select * from s_trn where REFNO='".$row_tr["REF_NO"]."' and STK_NO='".$row_tr["STK_NO"]."'";
		echo $sql_trn;
		$result_trn=mysql_query($sql_trn, $ben);
		$row_trn = mysql_fetch_array($result_trn);
	
		$sql1="update s_submas set QTYINHAND=QTYINHAND- ".$row_tr["QTY"]." where STK_NO= '".trim($row_tr["STK_NO"])."' and STO_CODE= '".$row_trn["DEPARTMENT"]."'";
		echo $sql1."</br>";		
		$result1=mysql_query($sql1, $ben_tyre);
  }		
	echo "s_mas completed";
	
  
  	
	$sql_sal="Select * from s_salma where SDATE>='2014-08-25'";
	$result_sal=mysql_query($sql_sal, $ben);
	while($row_sal = mysql_fetch_array($result_sal)){
	
		$sql="Select * from s_led where SDATE>='2014-08-25' and REF_NO='".$row_sal["REF_NO"]."'";
		$result=mysql_query($sql, $ben);
		if($row = mysql_fetch_array($result)){
			$sql1="Insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT) values('".trim($row["REF_NO"])."', '".$row["SDATE"]."', '".trim($row["C_CODE"])."', ".$row["AMOUNT"].", '".$row["FLAG"]."', '".$row["DEPARTMENT"]."')";
			echo $sql1."</br>";		
			$result1=mysql_query($sql1, $ben_tyre);
			
			
		}
		
		$sql1="update vendor set temp_limit= '0'  where CODE='".trim($row_sal["C_CODE"])."'";
		echo $sql1."</br>";		
		$result1=mysql_query($sql1, $ben_tyre);
		
		$sql1="select * from brand_mas where barnd_name='".trim($row_sal["Brand"])."'";
		echo $sql1."</br>";		
		$result1=mysql_query($sql1, $ben);
		if($row1 = mysql_fetch_array($result1)){
			$sqlbr_trn="update br_trn set tmplmt= '0'   where cus_code='".trim($row_sal["C_CODE"])."' and brand='".trim($row1["class"])."' and Rep='".trim($row_sal["SAL_EX"])."'";
			echo $sqlbr_trn."</br>";		
			$resultbr_trn=mysql_query($sqlbr_trn, $ben_tyre);
		}
	}	
	
	echo "s_led completed";	
	
	

?>
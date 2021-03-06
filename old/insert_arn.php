<?php

	include('connectioni.php');
	
	//// Sales Order //////////////////////////////////////////////////////
/*	$sql="Select * from s_ordmas where SDATE>='2014-08-19'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
	while($row = mysqli_fetch_array($result)){
		$sql1="insert into s_ordmas(REFNO, SDATE, SUP_CODE, SUP_NAME, REMARK, DEP_CODE, DEP_NAME, REP_CODE, REP_NAME, cancel, S_date, LC_No, pi_no, Brand, tmp_no) values ('".$row["REFNO"]."', '".$row["SDATE"]."', '".$row["SUP_CODE"]."','".$row["SUP_NAME"]."','".$row["REMARK"]."','".$row["DEP_CODE"]."','".$row["DEP_NAME"]."','".$row["REP_CODE"]."','".$row["REP_NAME"]."', '".$row["cancel"]."', '".$row["S_date"]."','".$row["LC_No"]."', '".$row["pi_no"]."', '".$row["Brand"]."',  '".$row["tmp_no"]."')";
		echo $sql1."</br>";
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
	}	
	
	echo "s_ordmas completed";
	
	$sql="Select * from s_ordtrn where SDATE>='2014-08-19'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
	while($row = mysqli_fetch_array($result)){
		$sql1="insert into s_ordtrn(REFNO, SDATE, STK_NO, DESCRIPT, ORD_QTY, partno, CANCEL, tmp_no) values ('".$row["REFNO"]."', '".$row["SDATE"]."', '".$row["STK_NO"]."','".$row["DESCRIPT"]."','".$row["ORD_QTY"]."','".$row["partno"]."','".$row["CANCEL"]."', '".$row['tmp_no']."')";
		echo $sql1."</br>";		
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
	}	
	
	echo "s_ordtrn completed";*/
	
	
	//// ARN //////////////////////////////////////////////////////

/*  $sql_mas="Select * from s_purmas where SDATE>='2014-08-19'";
  $result_mas=mysqli_query($GLOBALS['dbinv'],$sql_mas, $ben);	
  while($row_mas = mysqli_fetch_array($result_mas)){
	$sql="Select * from c_bal where SDATE>='2014-08-19' and REFNO='".$row_mas["REFNO"]."'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
	if($row = mysqli_fetch_array($result)){
		$sql1="insert into c_bal(REFNO, SDATE, CUSCODE, AMOUNT, BALANCE, DEP, SAL_EX, Cancell, brand, DEV, trn_type, vatrate, old, flag1, active, totpay) values ('".$row["REFNO"]."', '".$row["SDATE"]."', '".$row["CUSCODE"]."', '".$row["AMOUNT"]."', '".$row["BALANCE"]."', '".$row["DEP"]."', '".$row["SAL_EX"]."', '".$row["Cancell"]."', '".$row["brand"]."', '".$row["DEV"]."', '".$row["trn_type"]."', '".$row["vatrate"]."', '".$row["old"]."', '".$row["flag1"]."', '".$row["active"]."', ".$row["totpay"].")";
		echo $sql1."</br>";			
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
	}
  }		
	
	echo "c_bal completed";*/
	
/*	$sql="Select * from s_purmas where SDATE>='2014-08-19'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
	while($row = mysqli_fetch_array($result)){
		$sql1="insert into s_purmas(REFNO, SDATE, ORDNO, LCNO, pi_no, COUNTRY, SUP_CODE, SUP_NAME, REMARK, DEPARTMENT, AMOUNT, PUR_DATE,
TYPE, brand) values ('".$row["REFNO"]."', '".$row["SDATE"]."', '".$row["ORDNO"]."', '".$row["LCNO"]."', '".$row["pi_no"]."', '".$row["COUNTRY"]."', '".$row["SUP_CODE"]."', '".$row["SUP_NAME"]."', '".$row["REMARK"]."', '".$row["DEPARTMENT"]."', '".$row["AMOUNT"]."', '".$row["PUR_DATE"]."', '".$row["TYPE"]."', '".$row["brand"]."')";
		echo $sql1."</br>";			
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
		
		
	}	
	
	echo "s_purmas completed";*/
	
/*	$sql="Select * from s_purmas where SDATE>='2014-08-19'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
	while($row = mysqli_fetch_array($result)){
	
		$sql1="update s_ordmas set cancel='1' where REFNO='".$row["ORDNO"]."'";
		echo $sql1."</br>";		
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
		
		$sql1="update s_ordtrn set CANCEL='1' where REFNO='".$row["ORDNO"]."'";
		echo $sql1."</br>";		
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
	}	
	
	echo "s_ordmas completed";
	echo "s_ordtrn completed";*/
	

/*	$sql="Select * from s_purtrn where SDATE>='2014-08-19'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
	while($row = mysqli_fetch_array($result)){
		$sql1="insert into s_purtrn(REFNO, SDATE, STK_NO, DESCRIPT, COST, MARGIN, SELLING, REC_QTY, FOB, DEPARTMENT, QTYINHAND, O_QTY, 
 Cost_c, acc_cost, acc_cost_c, brand, vatrate, DISCOUNT, ret_qty, cost_seling, cost_margin, CANCEL, soldqty, days) values ('".$row["REFNO"]."', '".$row["SDATE"]."', '".$row["STK_NO"]."', '".$row["DESCRIPT"]."', ".$row["COST"].", ".$row["MARGIN"].", ".$row["SELLING"].", ".$row["REC_QTY"].", ".$row["FOB"].", '".$row["DEPARTMENT"]."', ".$row["QTYINHAND"].", ".$row["O_QTY"].", ".$row["Cost_c"].", '".$row["acc_cost"]."', '".$row["acc_cost_c"]."', '".$row["brand"]."', '".$row["vatrate"]."', ".$row["DISCOUNT"].", ".$row["ret_qty"].", ".$row["cost_seling"].", ".$row["cost_margin"].", '".$row["CANCEL"]."', '".$row["soldqty"]."', ".$row["days"].")";
		echo $sql1."</br>";			
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
	}	
	
	echo "s_purtrn completed";*/
	
	
/*	$sql="Select * from s_purtrn where SDATE>='2014-08-19'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
	while($row = mysqli_fetch_array($result)){
		
		$sql_pmas="Select * from s_purmas where SDATE>='2014-08-19'";
		$result_pmas=mysqli_query($GLOBALS['dbinv'],$sql_pmas, $ben);
		$row_pmas = mysqli_fetch_array($result_pmas);
	
		if ($row_pmas["TYPE"]== "Local"){
    		$cost = $row["acc_cost"];
    	} else {
			$cost=0;
		}
		$acc_cost=$row["acc_cost"];
				
				
		$sql_mas="select * from s_mas where STK_NO='".$row["STK_NO"]."'";
		$result_mas=mysqli_query($GLOBALS['dbinv'],$sql_mas, $ben);
		if ($row_mas = mysqli_fetch_array($result_mas)){
			$QTYINHAND=$row_mas["QTYINHAND"];
			$COST_mas=$row_mas["COST"];
			$acc_cost_c=$row_mas["acc_cost"];
		}
				
		$m_qty=$QTYINHAND+$row["REC_QTY"];
				
		if ($QTYINHAND>0){
			$m_totval=(($QTYINHAND*$acc_cost_c)+($row["REC_QTY"]*$row["acc_cost"]))/$m_qty;
		} else {
			$m_totval=$row["acc_cost"];
		}	
				
				
				//echo $itemcode_name;
				//echo $_GET[$itemcode_name];
				
			
				
				if ($m_totval>0){
					$marg=($row["SELLING"]-$m_totval)/$m_totval*100;
				} else {
					$marg=0;
				}
				if ($_GET["purtype"]== "Local"){
					$sql1="update s_mas set COST=".$m_totval." where  STK_NO='".$row["STK_NO"]."'";
					$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
				}
				
				if (($m_totval>0) and (trim($m_totval)!="")){
					$margin=($row["SELLING"]-$m_totval)/$m_totval*100;
				} else {
					$margin=0;
				}
				
		$sql1="update s_mas set acc_cost=".$m_totval.", SELLING='".$row["SELLING"]."', AR_selling='".$row["SELLING"]."', MARGIN ='".$margin."', QTYINHAND=QTYINHAND+".$row["REC_QTY"]." where  STK_NO='".$row["STK_NO"]."'";
		echo $sql1."</br>";			
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
		
		
		$sql3="select * from s_submas where STK_NO='".$row["STK_NO"]."' and STO_CODE='".$row["DEPARTMENT"]."'";
		echo $sql3."</br>";		
		$result3=mysqli_query($GLOBALS['dbinv'],$sql3, $ben_tyre);
		if ($row3 = mysqli_fetch_array($result3)){
			$sql1="update s_submas set QTYINHAND=QTYINHAND+".$row["REC_QTY"]." where STK_NO='".$row["STK_NO"]."' and STO_CODE='".$row["DEPARTMENT"]."'";
			echo $sql1."</br>";		
			$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
					
					
		} else {	
					
			$sql1="insert into s_submas(STO_CODE, STK_NO, DESCRIPt, OPENT_DATE, QTYINHAND) values ('".$row["DEPARTMENT"]."', '".$row["STK_NO"]."', '".$row["DESCRIPT"]."', '".$row["SDATE"]."', ".$row["REC_QTY"]." )";
			echo $sql1."</br>";		
			$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
		}
	}	
	
	echo "s_mas completed";
	
	*/
/*				
  $sql_tr="Select * from s_purtrn where SDATE>='2014-08-19'";
  echo $sql_tr."</br>";		
  $result_tr=mysqli_query($GLOBALS['dbinv'],$sql_tr, $ben);
  while($row_tr = mysqli_fetch_array($result_tr)){	
	$sql="Select * from s_trn where SDATE>='2014-08-19' and REFNO='".$row_tr["REFNO"]."' and STK_NO='".$row_tr["STK_NO"]."'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
	if($row = mysqli_fetch_array($result)){
		$sql1="insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO) values ('".$row["STK_NO"]."', '".$row["SDATE"]."', '".$row["QTY"]."', '".$row["LEDINDI"]."', '".$row["REFNO"]."', '".$row["DEPARTMENT"]."', '".$row["seri_no"]."', '".$row['Dev']."', '".$row["SAL_EX"]."', '".$row["ACTIVE"]."', '".$row["DONO"]."')";
		echo $sql1."</br>";		
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
	}
  }		
	echo "s_trn completed";
	*/
	//// Sales Order //////////////////////////////////////////////////////
	
/*	$sql="Select * from s_cusordmas where SDATE>='2014-08-19'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
	while($row = mysqli_fetch_array($result)){
		$sql1="insert into s_cusordmas(REF_NO, TRN_TYPE, SDATE, C_CODE, BRAND, CUS_NAME, VAT, TYPE, DISCOU, AMOUNT, GRAND_TOT, DIS, DIS1, DIS2,  DEPARTMENT, SAL_EX, VAT_VAL, CANCELL, DEV, REQ_DATE, INVNO, tmp_no, Limit_need, Forward, GST, DUMMY_VAL, DIS_RUP, CASH, TOTPAY, ORD_NO, ORD_DA, SETTLED, TOTPAY1, DES_CAT, REMARK, BTT, Account, Accname, Costcenter, RET_AMO, comm, approveby, Result, Rejectby) values ('".$row["REF_NO"]."', '".$row["TRN_TYPE"]."', '".$row["SDATE"]."', '".$row["C_CODE"]."', '".$row["BRAND"]."', '".$row["CUS_NAME"]."', 	'".$row["VAT"]."', '".$row["TYPE"]."', ".$row["DISCOU"].", ".$row["AMOUNT"].", ".$row["GRAND_TOT"].", ".$row["DIS"].", ".$row["DIS1"].", ".$row["DIS2"].",  '".$row["DEPARTMENT"]."', '".$row["SAL_EX"]."', ".$row["VAT_VAL"].", '".$row["CANCELL"]."', '".$row["DEV"]."', '".$row["REQ_DATE"]."', '".$row["INVNO"]."', '".$row["tmp_no"]."', ".$row["Limit_need"].", '".$row["Forward"]."', ".$row["GST"].", ".$row["DUMMY_VAL"].", ".$row["DIS_RUP"].", ".$row["CASH"].", ".$row["TOTPAY"].", '".$row["ORD_NO"]."', '".$row["ORD_DA"]."', '', ".$row["SETTLED"].", '".$row["TOTPAY1"]."', '".$row["DES_CAT"]."', ".$row["REMARK"].", '".$row["BTT"]."', '".$row["Account"]."', '".$row["Accname"]."', ".$row["Costcenter"].", ".$row["RET_AMO"].", ".$row["comm"].", '".$row["approveby"]."', '".$row["Result"]."', '".$row["Rejectby"]."')";
		echo $sql1."</br>";		
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
	}	
	
	echo "s_cusordmas completed";
	
	
	$sql="Select * from s_cusordtrn where SDATE>='2014-08-19'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
	while($row = mysqli_fetch_array($result)){
		$sql1="insert into s_cusordtrn(REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, COST, PRICE, QTY, DEPARTMENT, DIS_per, DIS_rs, REP, TAX_PER, BRAND, CANCELL, tmp_no, UNIT, ret_qty, DEV, c_code, stk, inv_qty) values ('" . trim($row["REF_NO"]) . "','" . $row["SDATE"] . "', '" . trim($row["STK_NO"]) . "','" . trim($row["DESCRIPT"]) . "', '" . trim($row["PART_NO"]) . "'," . $row["COST"] . "," . $row["PRICE"] . "," . $row["QTY"] . ",'" . trim($row["DEPARTMENT"]) . "'," . $row["DIS_per"] . "," . $row["DIS_rs"] . ",'" . trim($row["REP"]) . "','".$row["TAX_PER"]."','" . trim($row["BRAND"]) . "', '".$row["CANCELL"]."',  '".$row["tmp_no"]."', '".$row["UNIT"]."', ".$row["ret_qty"].", '".$row["DEV"]."', '".$row["c_code"]."', ".$row["stk"]."," . $row["inv_qty"] . ")";
		echo $sql1."</br>";		
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
	}	
	
	echo "s_cusordtrn completed";*/
	
	
	////// Sales Invoice////////////////////////////////////
	
	
/*	$sql="Select * from s_salma where SDATE>='2014-08-19'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
	while($row = mysqli_fetch_array($result)){
		//$sql1="insert into s_salma(REF_NO, TRN_TYPE, SDATE, C_CODE, Brand, CUS_NAME, VAT, VAT_VAL, TYPE, DISCOU, AMOUNT, GRAND_TOT,  TOTPAY, ORD_NO, ORD_DA,  DEPARTMENT, SAL_EX, BTT, cre_pe, GST, DIS, DIS1, DIS2, SVAT, Account, TOTPAY1, REMARK, REQ_DATE, CANCELL, DEV, tmp_no, DIS_RUP, CASH, SETTLED, DES_CAT, Accname, Costcenter, RET_AMO, Comm, red, seri_no, points, LOCK1, deliin, vat_no, s_vat_no, C_ADD1) values ('".$row["REF_NO"]."', '".$row["TRN_TYPE"]."', '".$row["SDATE"]."', '".trim($row["C_CODE"])."', '".trim($row["Brand"])."', '".trim($row["CUS_NAME"])."','".$row["VAT"]."', ".$row["VAT_VAL"].", '".$row["TYPE"]."',".$row["DISCOU"].", ".$row["AMOUNT"]." , ".$row["GRAND_TOT"].", ".$row["TOTPAY"].", '".trim($row["ORD_NO"])."', '".$row["ORD_DA"]."', '".trim($row["DEPARTMENT"])."', '".trim($row["SAL_EX"])."', ".$row["BTT"].", ".$row["cre_pe"]." , ".$row["GST"].", ".$row["DIS"].", ".$row["DIS1"].", ".$row["DIS2"].", '".$row["SVAT"]."', '".$row["Account"]."', '".$row["TOTPAY1"]."',  '".$row["REMARK"]."', '".$row["REQ_DATE"]."', '".$row["CANCELL"]."', '".$row["DEV"]."', '".$row["tmp_no"]."', ".$row["DIS_RUP"].", ".$row["CASH"].", '".$row["SETTLED"]."', '".$row["DES_CAT"]."', '".$row["Accname"]."', '".$row["Costcenter"]."', ".$row["RET_AMO"].", '".$row["Comm"]."', '".$row["red"]."', '".$row["seri_no"]."', '".$row["points"]."', '".$row["LOCK1"]."', '', '".trim($row["deliin"])."', '".trim($row["vat_no"])."', '".$row["s_vat_no"]."', '".$row["C_ADD1"]."')";
	/*	$sql1="insert into s_salma(REF_NO, TRN_TYPE, SDATE, C_CODE, Brand, CUS_NAME, VAT, VAT_VAL, TYPE, DISCOU, AMOUNT, GRAND_TOT,  TOTPAY, ORD_NO, ORD_DA,  DEPARTMENT, SAL_EX, BTT, cre_pe, GST, DIS, DIS1, DIS2, SVAT, Account, TOTPAY1, REMARK, REQ_DATE, CANCELL, DEV, tmp_no, DIS_RUP, CASH, SETTLED, DES_CAT, Accname, Costcenter, RET_AMO, Comm, red, seri_no, points, LOCK1, deliin, vat_no, s_vat_no, C_ADD1) values ('".$row["REF_NO"]."', '".$row["TRN_TYPE"]."', '".$row["SDATE"]."', '".trim($row["C_CODE"])."', '".trim($row["Brand"])."', '".trim($row["CUS_NAME"])."','".$row["VAT"]."', ".$row["VAT_VAL"].", '".$row["TYPE"]."',".$row["DISCOU"].", ".$row["AMOUNT"]." , ".$row["GRAND_TOT"].", ".$row["TOTPAY"].", '".trim($row["ORD_NO"])."', '".$row["ORD_DA"]."', '".trim($row["DEPARTMENT"])."', '".trim($row["SAL_EX"])."', ".$row["BTT"].", ".$row["cre_pe"]." , ".$row["GST"].", ".$row["DIS"].", ".$row["DIS1"].", ".$row["DIS2"].", '".$row["SVAT"]."', '".$row["Account"]."', '".$row["TOTPAY1"]."',  '".$row["REMARK"]."', '".$row["REQ_DATE"]."', '".$row["CANCELL"]."', '".$row["DEV"]."', '".$row["tmp_no"]."', ".$row["DIS_RUP"].", ".$row["CASH"].", '".$row["SETTLED"]."', '".$row["DES_CAT"]."', '".$row["Accname"]."', '".$row["Costcenter"]."', ".$row["RET_AMO"].", '".$row["Comm"]."', '".$row["red"]."', '".$row["seri_no"]."', '".$row["points"]."', '".$row["LOCK1"]."', '".trim($row["deliin"])."', '".trim($row["vat_no"])."', '".$row["s_vat_no"]."', '".$row["C_ADD1"]."')";
		echo $sql1."</br>";		
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
	}	
	
	echo "s_salma completed";*/
	
/*	$sql="Select * from s_salma where SDATE>='2014-08-19'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
	while($row = mysqli_fetch_array($result)){
		$sql1="update vendor set CUR_BAL= CUR_BAL+".$row["GRAND_TOT"]." where CODE='".trim($row["C_CODE"])."'";
		echo $sql1."</br>";		
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
		
		$sql1="update br_trn set credit= credit+".$row["GRAND_TOT"]." where cus_code='".trim($row["C_CODE"])."'";
		echo $sql1."</br>";		
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
	}	
	
	echo "vendor completed";
	echo "br_trn completed";*/
	
/*	$sql="Select * from s_invo where SDATE>='2014-08-19'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
	while($row = mysqli_fetch_array($result)){
		$sql1="insert into s_invo(REF_NO, SDATE, STK_NO, DESCRIPT, PART_NO, COST, PRICE, QTY, DEPARTMENT, DIS_per, DIS_rs, REP, TAX_PER, BRAND, vatrate, Print_dis1, Print_dis2, Print_dis3, subtot, ret_qty, DEV, CANCELL, c_code, seri_no, ad) values ('".$row["REF_NO"]."', '".$row["SDATE"]."', '".trim($row["STK_NO"])."', '".trim($row["DESCRIPT"])."', '".$row["PART_NO"]."', ".$row["COST"].", ".$row["PRICE"].", ".$row["QTY"].", '".$row["DEPARTMENT"]."', '".$row["DIS_per"]."', ".$row["DIS_rs"].", '".$row["REP"]."', '".$row["TAX_PER"]."', '".$row["BRAND"]."', ".$row["vatrate"].", ".$row["Print_dis1"].", ".$row["Print_dis2"].", ".$row["Print_dis3"].", ".$row["subtot"].", '".$row["ret_qty"]."', '".$row["DEV"]."', '".$row["CANCELL"]."', '".$row["c_code"]."', '".$row["seri_no"]."', '".$row["ad"]."')";
		echo $sql1."</br>";		
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
	}	
	
	echo "s_invo completed";*/
	
/*  $sql_tr="Select * from s_invo where SDATE>='2014-08-19'";
  echo $sql_tr."</br>";		
  $result_tr=mysqli_query($GLOBALS['dbinv'],$sql_tr, $ben);
  while($row_tr = mysqli_fetch_array($result_tr)){	
	$sql="Select * from s_trn where SDATE>='2014-08-19' and REFNO='".$row_tr["REF_NO"]."' and STK_NO='".$row_tr["STK_NO"]."'";
	$result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
	if($row = mysqli_fetch_array($result)){
		$sql1="insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO) values ('".$row["STK_NO"]."', '".$row["SDATE"]."', '".$row["QTY"]."', '".$row["LEDINDI"]."', '".$row["REFNO"]."', '".$row["DEPARTMENT"]."', '".$row["seri_no"]."', '".$row['Dev']."', '".$row["SAL_EX"]."', '".$row["ACTIVE"]."', '".$row["DONO"]."')";
		echo $sql1."</br>";		
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
	}
  }		
	echo "s_trn completed";
	
	$sql_tr="Select * from s_invo where SDATE>='2014-08-19'";
  echo $sql_tr."</br>";		
  $result_tr=mysqli_query($GLOBALS['dbinv'],$sql_tr, $ben);
  while($row_tr = mysqli_fetch_array($result_tr)){	
	
		$sql1="update s_mas set QTYINHAND= QTYINHAND-".$row_tr["QTY"]." where STK_NO='".trim($row_tr["STK_NO"])."'";
		echo $sql1."</br>";		
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
	
  }		
	echo "s_mas completed";
	*/
  
  	
/*	$sql_sal="Select * from s_salma where SDATE>='2014-08-19'";
	$result_sal=mysqli_query($GLOBALS['dbinv'],$sql_sal, $ben);
	while($row_sal = mysqli_fetch_array($result_sal)){
	
		$sql="Select * from s_led where SDATE>='2014-08-19' and REF_NO='".$row_sal["REF_NO"]."'";
		$result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
		if($row = mysqli_fetch_array($result)){
			$sql1="Insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT) values('".trim($row["REF_NO"])."', '".$row["SDATE"]."', '".trim($row["C_CODE"])."', ".$row["AMOUNT"].", '".$row["FLAG"]."', '".$row["DEPARTMENT"]."')";
			echo $sql1."</br>";		
			$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
			
			
		}
		
		$sql1="update vendor set temp_limit= '0'  where CODE='".trim($row_sal["C_CODE"])."'";
		echo $sql1."</br>";		
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
		
		$sql1="select * from brand_mas where barnd_name='".trim($row_sal["Brand"])."'";
		echo $sql1."</br>";		
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben);
		if($row1 = mysqli_fetch_array($result1)){
			$sqlbr_trn="update br_trn set tmplmt= '0'   where cus_code='".trim($row_sal["C_CODE"])."' and brand='".trim($row1["class"])."' and Rep='".trim($row_sal["SAL_EX"])."'";
			echo $sqlbr_trn."</br>";		
			$resultbr_trn=mysqli_query($GLOBALS['dbinv'],$sqlbr_trn, $ben_tyre);
		}
	}	
	
	echo "s_led completed";	*/
	
  $sql="Select * from s_crec where CA_DATE>='2014-08-19'";
  echo $sql."</br>";		
  $result=mysqli_query($GLOBALS['dbinv'],$sql, $ben);
  while($row = mysqli_fetch_array($result)){	
	
		$sql1="insert into s_crec(CA_REFNO, CA_DATE, CA_CODE, CA_CASSH, CA_AMOUNT, overpay, FLAG, pay_type, CA_SALESEX, CANCELL, tmp_no, DEPARTMENT, cus_ref, AC_REFNO, TTDATE, DEV) values
	  ('".$row["CA_REFNO"]."', '".$row["CA_DATE"]."', '".$row["CA_CODE"]."', ".$row["CA_CASSH"].", ".$row["CA_AMOUNT"].", ".$row["overpay"].", '".$row["FLAG"]."', '".$row["pay_type"]."', '".$row["CA_SALESEX"]."', '".$row["CANCELL"]."', '".$row["tmp_no"]."', '".$row["DEPARTMENT"]."', '".$row["cus_ref"]."', '".$row["AC_REFNO"]."', '".$row["TTDATE"]."', '".$row["DEV"]."' )";
		echo $sql1."</br>";		
		$result1=mysqli_query($GLOBALS['dbinv'],$sql1, $ben_tyre);
	
  }		
	echo "s_crec completed";
	
?>
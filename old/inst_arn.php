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



 $sql_mas="Select * from s_purmas where SDATE>='2014-08-25'";
  $result_mas=mysql_query($sql_mas, $ben);	
  while($row_mas = mysql_fetch_array($result_mas)){
	$sql="Select * from c_bal where SDATE>='2014-08-25' and REFNO='".$row_mas["REFNO"]."'";
	$result=mysql_query($sql, $ben);
	if($row = mysql_fetch_array($result)){
		$sql1="insert into c_bal(REFNO, SDATE, CUSCODE, AMOUNT, BALANCE, DEP, SAL_EX, Cancell, brand, DEV, trn_type, vatrate, old, flag1, active, totpay) values ('".$row["REFNO"]."', '".$row["SDATE"]."', '".$row["CUSCODE"]."', '".$row["AMOUNT"]."', '".$row["BALANCE"]."', '".$row["DEP"]."', '".$row["SAL_EX"]."', '".$row["Cancell"]."', '".$row["brand"]."', '".$row["DEV"]."', '".$row["trn_type"]."', '".$row["vatrate"]."', '".$row["old"]."', '".$row["flag1"]."', '".$row["active"]."', ".$row["totpay"].")";
		echo $sql1."</br>";			
		$result1=mysql_query($sql1, $ben_tyre);
	}
  }		
	
	echo "c_bal completed";
	
	$sql="Select * from s_purmas where SDATE>='2014-08-25'";
	$result=mysql_query($sql, $ben);
	while($row = mysql_fetch_array($result)){
		$sql1="insert into s_purmas(REFNO, SDATE, ORDNO, LCNO, pi_no, COUNTRY, SUP_CODE, SUP_NAME, REMARK, DEPARTMENT, AMOUNT, PUR_DATE,
TYPE, brand) values ('".$row["REFNO"]."', '".$row["SDATE"]."', '".$row["ORDNO"]."', '".$row["LCNO"]."', '".$row["pi_no"]."', '".$row["COUNTRY"]."', '".$row["SUP_CODE"]."', '".$row["SUP_NAME"]."', '".$row["REMARK"]."', '".$row["DEPARTMENT"]."', '".$row["AMOUNT"]."', '".$row["PUR_DATE"]."', '".$row["TYPE"]."', '".$row["brand"]."')";
		echo $sql1."</br>";			
		$result1=mysql_query($sql1, $ben_tyre);
		
		
	}	
	
	echo "s_purmas completed";
	
	$sql="Select * from s_purmas where SDATE>='2014-08-25'";
	$result=mysql_query($sql, $ben);
	while($row = mysql_fetch_array($result)){
	
		$sql1="update s_ordmas set cancel='1' where REFNO='".$row["ORDNO"]."'";
		echo $sql1."</br>";		
		$result1=mysql_query($sql1, $ben_tyre);
		
		$sql1="update s_ordtrn set CANCEL='1' where REFNO='".$row["ORDNO"]."'";
		echo $sql1."</br>";		
		$result1=mysql_query($sql1, $ben_tyre);
	}	
	
	echo "s_ordmas completed";
	echo "s_ordtrn completed";
	

	$sql="Select * from s_purtrn where SDATE>='2014-08-25'";
	$result=mysql_query($sql, $ben);
	while($row = mysql_fetch_array($result)){
		$sql1="insert into s_purtrn(REFNO, SDATE, STK_NO, DESCRIPT, COST, MARGIN, SELLING, REC_QTY, FOB, DEPARTMENT, QTYINHAND, O_QTY, 
 Cost_c, acc_cost, acc_cost_c, brand, vatrate, DISCOUNT, ret_qty, cost_seling, cost_margin, CANCEL, soldqty, days) values ('".$row["REFNO"]."', '".$row["SDATE"]."', '".$row["STK_NO"]."', '".$row["DESCRIPT"]."', ".$row["COST"].", ".$row["MARGIN"].", ".$row["SELLING"].", ".$row["REC_QTY"].", ".$row["FOB"].", '".$row["DEPARTMENT"]."', ".$row["QTYINHAND"].", ".$row["O_QTY"].", ".$row["Cost_c"].", '".$row["acc_cost"]."', '".$row["acc_cost_c"]."', '".$row["brand"]."', '".$row["vatrate"]."', ".$row["DISCOUNT"].", ".$row["ret_qty"].", ".$row["cost_seling"].", ".$row["cost_margin"].", '".$row["CANCEL"]."', '".$row["soldqty"]."', ".$row["days"].")";
		echo $sql1."</br>";			
		$result1=mysql_query($sql1, $ben_tyre);
	}	
	
	echo "s_purtrn completed";
	
	
	$sql="Select * from s_purtrn where SDATE>='2014-08-25' and CANCEL='0'";
	$result=mysql_query($sql, $ben);
	while($row = mysql_fetch_array($result)){
		
		$sql_pmas="Select * from s_purmas where REFNO='".$row["REFNO"]."'";
		$result_pmas=mysql_query($sql_pmas, $ben);
		$row_pmas = mysql_fetch_array($result_pmas);
	
		if ($row_pmas["TYPE"]== "Local"){
    		$cost = $row["acc_cost"];
    	} else {
			$cost=0;
		}
		$acc_cost=$row["acc_cost"];
				
				
		$sql_mas="select * from s_mas where STK_NO='".$row["STK_NO"]."'";
		$result_mas=mysql_query($sql_mas, $ben);
		if ($row_mas = mysql_fetch_array($result_mas)){
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
					$result1 =$db->RunQuery($sql1);
				}
				
				if (($m_totval>0) and (trim($m_totval)!="")){
					$margin=($row["SELLING"]-$m_totval)/$m_totval*100;
				} else {
					$margin=0;
				}
				
		$sql1="update s_mas set acc_cost=".$m_totval.", SELLING='".$row["SELLING"]."', AR_selling='".$row["SELLING"]."', MARGIN ='".$margin."', QTYINHAND=QTYINHAND+".$row["REC_QTY"]." where  STK_NO='".$row["STK_NO"]."'";
		echo $sql1."</br>";			
		$result1=mysql_query($sql1, $ben_tyre);
		
		
		$sql3="select * from s_submas where STK_NO='".$row["STK_NO"]."' and STO_CODE='".$row["DEPARTMENT"]."'";
		echo $sql3."</br>";		
		$result3=mysql_query($sql3, $ben_tyre);
		if ($row3 = mysql_fetch_array($result3)){
			$sql1="update s_submas set QTYINHAND=QTYINHAND+".$row["REC_QTY"]." where STK_NO='".$row["STK_NO"]."' and STO_CODE='".$row["DEPARTMENT"]."'";
			echo $sql1."</br>";		
			$result1=mysql_query($sql1, $ben_tyre);
					
					
		} else {	
					
			$sql1="insert into s_submas(STO_CODE, STK_NO, DESCRIPt, OPENT_DATE, QTYINHAND) values ('".$row["DEPARTMENT"]."', '".$row["STK_NO"]."', '".$row["DESCRIPT"]."', '".$row["SDATE"]."', ".$row["REC_QTY"]." )";
			echo $sql1."</br>";		
			$result1=mysql_query($sql1, $ben_tyre);
		}
	}	
	
	echo "s_mas completed";
	
	
	
	
	
				
  $sql_tr="Select * from s_purtrn where SDATE>='2014-08-25'";
  echo $sql_tr."</br>";		
  $result_tr=mysql_query($sql_tr, $ben);
  while($row_tr = mysql_fetch_array($result_tr)){	
	$sql="Select * from s_trn where SDATE>='2014-08-25' and REFNO='".$row_tr["REFNO"]."' and STK_NO='".$row_tr["STK_NO"]."'";
	$result=mysql_query($sql, $ben);
	if($row = mysql_fetch_array($result)){
		$sql1="insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO) values ('".$row["STK_NO"]."', '".$row["SDATE"]."', '".$row["QTY"]."', '".$row["LEDINDI"]."', '".$row["REFNO"]."', '".$row["DEPARTMENT"]."', '".$row["seri_no"]."', '".$row['Dev']."', '".$row["SAL_EX"]."', '".$row["ACTIVE"]."', '".$row["DONO"]."')";
		echo $sql1."</br>";		
		$result1=mysql_query($sql1, $ben_tyre);
	}
  }		
	echo "s_trn completed";

?>

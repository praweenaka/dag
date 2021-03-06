<?php

require_once("connectioni.php");
	
	

	$rs3= "Select AMOUNT, REF_NO, SDATE, C_CODE, CUS_NAME, DISCOU, BTT, GRAND_TOT  from s_salma where SDATE>='2014-08-01' ";
	$result3 =mysqli_query($GLOBALS['dbinv'],$rs3);
	while ($row3 = mysqli_fetch_array($result3)){
		
		$rs2= "Select *  from s_invo where REF_NO='".$row3["REF_NO"]."'";
		//echo $rs2;
		$result2 =mysqli_query($GLOBALS['dbinv'],$rs2);
		if ($row2 = mysqli_fetch_array($result2)){
		} else {
			echo $row3["SDATE"]."--".$row3["REF_NO"]."</br>";
		}
	
	}
	
?>
<?php

require_once("connectioni.php");
	
	

	$rs3= "Select *  from s_crnma where SDATE>='2014-08-01'  and CANCELL!='1'";
	$result3 =mysqli_query($GLOBALS['dbinv'],$rs3);
	while ($row3 = mysqli_fetch_array($result3)){
		
		$rs2= "Select * from c_bal where REFNO='".$row3["REF_NO"]."'";
		//echo $rs2;
		$result2 =mysqli_query($GLOBALS['dbinv'],$rs2);
		if ($row2 = mysqli_fetch_array($result2)){
			if ($row2["AMOUNT"]!=$row3["GRAND_TOT"]){
				echo $row2["REFNO"]."  ".$row2["SDATE"]." - ".$row2["AMOUNT"]." - ".$row3["GRAND_TOT"]."</br>";
			}
		} else {
			echo $row3["REF_NO"]."  ".$row3["SDATE"]." ".$row3["CANCELL"]."</br>";
		}
	
	}
	
?>
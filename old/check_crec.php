<?php

	require_once("connectioni.php");
	
	
//	echo "<table>";
	$sql="select * from s_crec where  CA_DATE>='2014-08-01' and FLAG!='RET'  order by CA_DATE";
	$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	while ($row = mysqli_fetch_array($result)){
		
		$sql1="select * from s_sttr where ST_REFNO='".$row["CA_REFNO"]."'";
		$result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
		if ($row1 = mysqli_fetch_array($result1)){
		} else {
			echo $row["CA_REFNO"]."-".$row["CA_DATE"]."</br>";
		}
			
		//if ($row1["totpay"]!=$row["TOTPAY"]){
		//	$bal=$row["TOTPAY"]-$row1["totpay"];
		//	echo "<tr><td>".$row["REF_NO"]."=".$row["SDATE"]."=</td><td>(".$row["TOTPAY"]."-".$row1["totpay"].")=</td><td>".$bal."</td></tr>";
		//}
		
	}
//echo "</table>";
?>
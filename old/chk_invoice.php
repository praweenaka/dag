<?php

require_once("connectioni.php");
	
	

	//$rs3= "Select AMOUNT, REF_NO, SDATE, C_CODE, CUS_NAME, DISCOU, BTT, GRAND_TOT  from s_salma where SDATE>='2014-08-01' and CANCELL!='1'";
	$rs3= "Select AMOUNT, REF_NO, SDATE, C_CODE, CUS_NAME, DISCOU, BTT, GRAND_TOT, VAT, DIS  from s_salma where SDATE>='2014-11-01' ";
	$result3 =mysqli_query($GLOBALS['dbinv'],$rs3);
	while ($row3 = mysqli_fetch_array($result3)){
		$subtot=0;
		$vat="";
		//$rs2= "Select (sum(PRICE*QTY)*(100-DIS_per)/100) as tot  from s_invo where REF_NO='".$row3["REF_NO"]."'";
		$rs2= "Select *  from s_invo where REF_NO='".$row3["REF_NO"]."'";
		//echo $rs2;
		$result2 =mysqli_query($GLOBALS['dbinv'],$rs2);
		while($row2 = mysqli_fetch_array($result2)){
		
			if ($row3["VAT"]=="0"){
				$price=$row2["PRICE"];
				$vat="0";
			} else {
				$price=$row2["PRICE"]/1.12;
				$vat="1";
			}
			$DIS_per=$row2["DIS_per"];
			$itemwise=(($price*$row2["QTY"])*(100-$row2["DIS_per"])/100);
			//echo $price." ".$itemwise."</br>";
			$subtot=$subtot+$itemwise;
		}
		
		if ($vat=="1"){
			$caltax=$subtot*0.12;
			$calcGrand=$subtot+$caltax;
		} else {
			$calcGrand=$subtot;
		}
		//$cal_grand=($row2["tot"]+$row3["BTT"]);
		if (number_format($calcGrand, 0, ".", "")!=number_format($row3["GRAND_TOT"], 0, ".", "")){
		//if ($calcGrand!=$row3["GRAND_TOT"]){
			echo $row3["SDATE"]."-".$row3["REF_NO"]."-".$row3["C_CODE"]."-".$row3["CUS_NAME"]."---".$row3["GRAND_TOT"]." = ".$calcGrand."</br>"; 
		//if (number_format($cal_grand)!=number_format($row3["GRAND_TOT"])){
			//echo $row3["SDATE"]."--".$row3["REF_NO"]."--".$row3["C_CODE"]."--".$row3["CUS_NAME"]."---".$row3["GRAND_TOT"]."=".$cal_grand."/---( ".$row2["tot"]."+".$row3["DISCOU"]."+".$row3["BTT"]."</br>";
		}
		
		if ($DIS_per!=$row3["DIS"]){
			echo $row3["SDATE"]."-".$row3["REF_NO"]." - ".$DIS_per."/".$row3["DIS"];
		}
		
	}
	
?>
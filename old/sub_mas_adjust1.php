<?php  session_start();

/*
	include_once("connectioni.php");
	include_once("DBConnector.php");
	$letters = $_GET['letters'];
	
	$sql="SELECT * FROM mast_family where name like '".$letters."%'";
		$result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
			
			
			while($row = mysqli_fetch_array($result))
			{
			
			echo $row["name"];
			
			}
			
		*/	
		
		



	include_once("connectioni.php");


//$sql_item = mysqli_query($GLOBALS['dbinv'],"select * from s_mas where BRAND_NAME='CHENG SHING' and STK_NO='06010' order by STK_NO") or die(mysqli_error());				
$sql_item = mysqli_query($GLOBALS['dbinv'],"select * from s_mas order by STK_NO") or die(mysqli_error());				
while($row_item = mysqli_fetch_array($sql_item)){	
  $M_BAL = 0;
  //echo $row_item["STK_NO"]."-";
  	$department=0;
  	//$sql_sto = mysqli_query($GLOBALS['dbinv'],"select * from s_stomas order by CODE") or die(mysqli_error());				
  	//while($row_sto = mysqli_fetch_array($sql_sto)){	
		
		// department wise/////////////////////////////////////
   		$sql = mysqli_query($GLOBALS['dbinv'],"select sum(QTYINHAND) as totqty from s_submas where STK_NO  ='".$row_item["STK_NO"]."' ") or die(mysqli_error());
		//echo "select * from s_trn where  ( SDATE <  '".$_GET["dte_from"]."') and STK_NO='".$_GET["itno"]."' and DEPARTMENT='".$_GET["department"]."' ORDER by SDATE";
	
	
	
	
		$row = mysqli_fetch_array($sql);
   
   		$totqty=$row["totqty"];
   		
	
	
	//$department=$M_BAL;
	
	
		// All/////////////////////////////////////
   		//$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_trn where  ( SDATE <  '2013-04-02') and STK_NO='".$row_item["STK_NO"]."' and DEPARTMENT='".$row_sto["CODE"]."' ORDER by SDATE") or die(mysqli_error());
	$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_trn where  ( SDATE <  '2014-04-02') and STK_NO='".$row_item["STK_NO"]."' and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE") or die(mysqli_error());
	
	
	
	$M_BAL = 0;
	while($row = mysqli_fetch_array($sql)){
   
   	//===stock out
   		if (($row["LEDINDI"] == "INV") or ($row["LEDINDI"] == "ORC") or ($row["LEDINDI"] == "GINI") or ($row["LEDINDI"] == "ARR") or ($row["LEDINDI"] == "IOU")){
      		$M_BAL = $M_BAL - $row["QTY"];
			
   		}
    
	//====stock in
   		if (($row["LEDINDI"] == "ARN") or ($row["LEDINDI"] == "GINR") or ($row["LEDINDI"] == "CRN") or ($row["LEDINDI"] == "GRN") or ($row["LEDINDI"] == "IIN")){
      		$M_BAL = $M_BAL + $row["QTY"];
   		}
   

      	if ($row["LEDINDI"] == "TRN"){
         	$M_BAL = $row["QTY"];
      	}
    	//}
   	}


		
	$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_trn where  (SDATE >=  '2014-04-02') and STK_NO='".$row_item["STK_NO"]."'and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE") or die(mysqli_error());	
	




	$i = 0;
	while($row = mysqli_fetch_array($sql)){



    	$refno=$row["REFNO"];
		$sdate=$row["SDATE"];
		$doc_type="";
		$fcolor="";
	
	
		if ($row["LEDINDI"]=="INV"){
			$doc_type="Sales Invoice";
			$fcolor="#330066";
		}

	
		if ($row["LEDINDI"]=="TRN"){
			$doc_type="Inventory";
			$fcolor="#996600";
			$M_BAL = $row["QTY"];
   		}
	
	
    	//==stock out
		$qty4="";
    	if (($row["LEDINDI"] == "INV") or ($row["LEDINDI"] == "ORC") or ($row["LEDINDI"] == "GINI") or ($row["LEDINDI"] == "ARR") or ($row["LEDINDI"] == "IOU")) {
       		$qty4 = $row["QTY"];
       		$M_BAL = $M_BAL - $row["QTY"];;
    	}
    
    	//===stock in
		$qty3="";
    	if (($row["LEDINDI"] == "ARN") or ($row["LEDINDI"] == "GINR") or ($row["LEDINDI"] == "CRN") or ($row["LEDINDI"] == "GRN") or ($row["LEDINDI"] == "IIN")){
       		$qty3 = $row["QTY"];
       		$M_BAL = $M_BAL + $row["QTY"];
    	}
    	$qty5 = $M_BAL;
 
  
    	$i = $i + 1;
	}
	
	$sql1 = mysqli_query($GLOBALS['dbinv'],"select sum(QTYINHAND) as tot from s_submas where STK_NO='".$row_item["STK_NO"]."' ") or die(mysqli_error());
	$row1 = mysqli_fetch_array($sql1);
	
	if ($row1["tot"]!=$M_BAL){
		
		//$sql2 = mysqli_query($GLOBALS['dbinv'],"select * from s_trn where SDATE='2014-08-29' and STK_NO='".$row_item["STK_NO"]."' ") or die(mysqli_error());
		//if ($row2 = mysqli_fetch_array($sql2)){
			
			echo $row_item["STK_NO"]."-".$row1["tot"]."/".$M_BAL."</br>";
			
			//if ($row_item["QTYINHAND"]!=$M_BAL){
			//	echo $row_item["STK_NO"]."-".$row_item["QTYINHAND"]." / ".$row1["tot"]." / ".$M_BAL."</br>";
			//}
			
		//}	
	}
	//$sql1 = mysqli_query($GLOBALS['dbinv'],"update s_submas set QTYINHAND=".$M_BAL." where STO_CODE='".$row_sto["CODE"]."' and STK_NO='".$row_item["STK_NO"]."'") or die(mysqli_error());
//	$sql1 = mysqli_query($GLOBALS['dbinv'],"update s_mas set QTYINHAND=".$M_BAL." where STK_NO='".$row_item["STK_NO"]."' ") or die(mysqli_error());
//	echo "update s_mas set QTYINHAND=".$M_BAL." where STK_NO='".$row_item["STK_NO"]."'</br>";
	
	//echo $row_sto["CODE"]."-".$row_item["STK_NO"]."-".$M_BAL."</br>";


}
	
?>

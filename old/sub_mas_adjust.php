<?php  session_start();

 


	include_once("connectioni.php");


$sql_item = mysqli_query($GLOBALS['dbinv'],"select * from s_mas where brand_name = 'AGATE' order by STK_NO") or die(mysqli_error());				
while($row_item = mysqli_fetch_array($sql_item)){	
 $totqty=0;
  //echo $row_item["STK_NO"]."-";
  	 
 
		
		 $M_BAL = 0;
		 


   		
		
      	$sql = mysqli_query($GLOBALS['dbinv'],"select * from s_trn_stores where (SDATE >= '2016-04-03') and STK_NO='".$row_item["STK_NO"]."' ORDER BY SDATE") or die(mysqli_error());
		//echo "select * from s_trn where (SDATE >= '2014-04-02') and STK_NO='".$row_item["STK_NO"]."' and DEPARTMENT = '".$row_sto["CODE"]."' ORDER BY SDATE";
			
	

		$i = 0;
		while($row = mysqli_fetch_array($sql)){



    		$refno=$row["REFNO"];
			$sdate=$row["SDATE"];
			$doc_type="";
			$fcolor="";
	
	
	
			if ($row["LEDINDI"]=="TRN"){
				
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
	 	$totqty=$totqty+$M_BAL;
  	
	
	$sql1 = mysqli_query($GLOBALS['dbinv'],"update s_mas set QTYINHAND_STORES=".$totqty." where STK_NO='".$row_item["STK_NO"]."' ") or die(mysqli_error());
	
}
	
?>

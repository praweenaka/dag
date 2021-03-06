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


	$sql1 = "update s_submas set QTYINHAND=0 ";
	$result1=mysqli_query($GLOBALS['dbinv'],$sql1);	
	//$row1 = mysqli_fetch_array($sql1);
	
//$sql_item = mysqli_query($GLOBALS['dbinv'],"select * from s_mas where BRAND_NAME='CHENG SHING' and STK_NO='06010' order by STK_NO") or die(mysqli_error());				
$sql_item ="select * from s_mas order by STK_NO";		
$result_item=mysqli_query($GLOBALS['dbinv'],$sql_item);			
while($row_item = mysqli_fetch_array($result_item)){	
  $M_BAL = 0;
  	$sql1 = "update s_submas set QTYINHAND=".$row_item["QTYINHAND"]." where STK_NO='".$row_item["STK_NO"]."' and STO_CODE='1'";
	$result1=mysqli_query($GLOBALS['dbinv'],$sql1);			
//	$row1 = mysqli_fetch_array($sql1);
	
 
}
	
?>

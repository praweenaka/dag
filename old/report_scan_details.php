<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Barcode Scan Report</title>

<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:16px;
}
table
{
border-collapse:collapse;
}
table, td, th
{

font-family:Arial, Helvetica, sans-serif;
padding:5px;
}
th
{
font-weight:bold;
font-size:13px;

}
td
{
font-size:12px;
border-bottom:none;
border-top:none;
 

}
</style>

</head>

<body>
<center>

<p>
  <?php

    require_once("connectioni.php");
	
	
  
	$sql_head="select * from invpara";
	$result_head =mysqli_query($GLOBALS['dbinv'],$sql_head);
	$row_head = mysqli_fetch_array($result_head);
		
		//////////////////////

	$txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");


 
  $sql = "select * from view_rep_scan ";

$sql .= " order by SDATE";
 
 


?>
</p>

    <?php 
	echo $row_head["COMPANY"]."</br>"; 
	echo $row_head["ADD1"]."</br>"; 
	
	echo $row_head["ADD2"] . ", " . $row_head["ADD3"]."</br></br>"; 
	
	
	
	echo "<b>Scaned Bar Code Report</b></br>"; 
	
	?>
    
    <table width="1000" border="1">
      <tr>
        <th ><b>Ref No</b></th>
		<th ><b>Date</b></th>
        <th ><b>Dealer</b></th>
        <th ><b>Item Code</b></th>
        <th><b>Description</b></th>
		<th><b>AR No</b></th>
        <th><b>Serial No</b></th>
        <th><b>Scan Date</b></th>
		<th><b>Sales Executive</b></th>
      </tr>
     <?php 
	  
		
      $result =mysqli_query($GLOBALS['dbinv'],$sql) ; 
	  while ($row = mysqli_fetch_array($result)){
	   
      			echo "<tr>
        		<td>".$row["refno"]."</td>
        		<td>".$row["SDATE"]."</td>
        		<td>".$row["C_CODE"]."&nbsp;&nbsp;&nbsp;".$row_cus["CUS_NAME"]."</td>
        		<td>".$row["stk_no"]."</td>
        		<td>".$row["DESCRIPT"]."</td>				
				<td>".$row["arno"]."</td>
				<td>".$row["serino"]."</td>
				<td>".$row["scan_date"]."</td>
				<td>".$row["imei"]."</td>				
      			</tr>";	 
	 }
	 
	 ?> 
      
    </table>
<p>&nbsp;</p>
</body>
</html>
